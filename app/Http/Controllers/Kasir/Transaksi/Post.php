<?php
namespace App\Http\Controllers\Kasir\Transaksi;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Post extends Controller
{
  public function cetakStruk($kode)
{
    $transaction = Transaction::with([
        'items.obat',
        'user',
        'returns', // ⬅️ cukup ini
    ])->where('kode', $kode)->firstOrFail();

    // 🔁 Mapping return per transaction_item
    $returnedQtyMap = [];
    $totalReturn = 0;

    foreach ($transaction->returns as $ret) {
        $totalReturn += $ret->amount;

        if (!isset($returnedQtyMap[$ret->transaction_item_id])) {
            $returnedQtyMap[$ret->transaction_item_id] = 0;
        }

        $returnedQtyMap[$ret->transaction_item_id] += $ret->qty;
    }

    // 🔢 Hitung ulang qty & subtotal setelah return
    foreach ($transaction->items as $item) {
        $returnedQty = $returnedQtyMap[$item->id] ?? 0;

        $item->qty_return = $returnedQty;
        $item->qty_final  = $item->qty - $returnedQty;
        $item->subtotal_final = $item->qty_final * $item->harga_jual;
        $item->subtotal_return = $returnedQty * $item->harga_jual;
    }

    // 💰 Total akhir setelah return
    $transaction->total_return = $totalReturn;
    $transaction->total_final  = $transaction->total_transaksi - $totalReturn;

    return view('kasir.cetak.struk', compact('transaction'));
}

  public function store(Request $request, $transactionId)
{
    $request->validate([
        'items' => 'required|array',
        'items.*' => 'nullable|integer|min:0',
        'reason' => 'required|string|max:255',
    ]);

    DB::beginTransaction();

    try {
        // 🔒 Ambil transaksi
        $transaction = DB::table('transaction')
            ->where('id', $transactionId)
            ->lockForUpdate()
            ->first();

        if (!$transaction || $transaction->status === 'VOID') {
            return back()->with('error', 'Transaksi tidak valid atau sudah dibatalkan');
        }

        $totalReturn = 0;

        foreach ($request->items as $itemId => $qty) {
            if ($qty <= 0) continue;

            // 🔒 Ambil item transaksi
            $item = DB::table('transactionitem')
                ->where('id', $itemId)
                ->where('transaction_id', $transactionId)
                ->lockForUpdate()
                ->first();

            if (!$item) continue;

            // Validasi qty tersedia
            $availableQty = $item->qty - $item->returned_qty;
            if ($qty > $availableQty) {
                throw new \Exception('Qty return melebihi jumlah tersedia');
            }

            $returnAmount = $item->harga_jual * $qty;
            $totalReturn += $returnAmount;

            // 1️⃣ Simpan return
            DB::table('transaction_returns')->insert([
                'transaction_id' => $transactionId,
                'transaction_item_id' => $item->id,
                'user_id' => Auth::id(),
                'qty' => $qty,
                'amount' => $returnAmount,
                'reason' => $request->reason,
                'created_at' => now()->timezone('Asia/Jakarta'),
                'updated_at' => now()->timezone('Asia/Jakarta'),
            ]);

            // 2️⃣ Update returned_qty
            DB::table('transactionitem')
                ->where('id', $item->id)
                ->update([
                    'returned_qty' => $item->returned_qty + $qty
                ]);

            // 3️⃣ Kembalikan stok obat
            DB::table('obat')
                ->where('id', $item->obat_id)
                ->increment('stok', $qty);
        }

        if ($totalReturn <= 0) {
            return back()->with('error', 'Tidak ada item yang direturn');
        }

        // 4️⃣ Update transaksi
        DB::table('transaction')
            ->where('id', $transactionId)
            ->update([
                'total_return' => $transaction->total_return + $totalReturn,
                'status' => 'RETURN',
                'updated_at' => now()->timezone('Asia/Jakarta'),
            ]);

        DB::commit();
        return back()->with('success', 'Return multi item berhasil diproses');

    } catch (\Throwable $e) {
        DB::rollBack();
        report($e);
        return back()->with('error', $e->getMessage() ?: 'Terjadi kesalahan saat proses return');
    }
}


  public function void(Request $request, $id)
{
    $request->validate([
        'void_reason' => 'required|string|min:5'
    ]);

    DB::transaction(function () use ($request, $id) {

        $trx = Transaction::with('items')->findOrFail($id);

        // ❌ tidak boleh void jika sudah void
        if ($trx->status === 'VOID') {
            abort(400, 'Transaksi sudah di-VOID');
        }

        // 1️⃣ update status transaksi
        $trx->update([
            'status' => 'VOID',
            'void_reason' => $request->void_reason,
            'void_by' => Auth::user()->id,
            'void_at' => Carbon::now()->timezone('Asia/Jakarta'),
        ]);

        // 2️⃣ kembalikan stok
        foreach ($trx->items as $item) {
            Obat::where('id', $item->obat_id)
                ->increment('stok', $item->qty);
        }

    });

    return redirect()->back()->with('success', 'Transaksi berhasil di-VOID');
}
}
  