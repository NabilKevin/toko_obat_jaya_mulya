<?php

namespace App\Http\Controllers\Kasir\Pos;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Post extends Controller
{
    public function bayar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cart' => 'required|array|min:1',
            'cart.*.id' => 'required|integer|exists:obat,id',
            'cart.*.qty' => 'required|integer|min:1',
            'totalTransaction' => 'required|integer|min:1',
            'totalPaid' => 'required|integer|min:1|gte:totalTransaction',
            'totalChange' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();

        try {
            $data = $request->all();

            // 🔒 LOCK BARANG UNTUK HINDARI RACE CONDITION
            foreach ($data['cart'] as $item) {
                $obat = Obat::where('id', $item['id'])->lockForUpdate()->first();

                if (!$obat) {
                    throw new \Exception('Obat tidak ditemukan');
                }
                if ($obat->expired_at && Carbon::parse($obat->expired_at)->isPast()) {
                    throw new \Exception("Obat {$obat->nama} sudah kadaluarsa");
                }

                if ($obat->stok <= 0) {
                    throw new \Exception("Stok {$obat->nama} habis");
                }

                if ($obat->stok < $item['qty']) {
                    throw new \Exception("Stok {$obat->nama} tidak mencukupi");
                }
            }

            // Generate kode transaksi
            $lastId = Transaction::max('id') + 1;
            $kode = 'TRX-' . date('Ymd') . '-' . str_pad($lastId, 5, '0', STR_PAD_LEFT);

            $transaksi = Transaction::create([
                'kode' => $kode,
                'total_transaksi' => $data['totalTransaction'],
                'total_dibayar' => $data['totalPaid'],
                'total_kembalian' => $data['totalChange'],
                'status' => 'SUCCESS',
                'user_id' => Auth::user()->id,
                'created_at' => now()->timezone('Asia/Jakarta'),
                'updated_at' => now()->timezone('Asia/Jakarta'),
                'paid_at' => now()->timezone('Asia/Jakarta'),
            ]);

            // Simpan item & kurangi stok
            foreach ($data['cart'] as $item) {
                $obat = Obat::where('id', $item['id'])->lockForUpdate()->first();

                $obat->stok -= $item['qty'];
                $obat->save();

                TransactionItem::create([
                    'obat_id' => $obat->id,
                    'transaction_id' => $transaksi->id,
                    'harga_modal' => $obat->harga_modal,
                    'harga_jual' => $obat->harga_jual,
                    'qty' => $item['qty'],
                    'subtotal' => $obat->harga_jual * $item['qty'],
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Transaksi berhasil',
                'redirect_url' => route('kasir.cetak.struk', $transaksi->kode),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 422); // ⬅️ bukan 500
        }
    }


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
    $transaction->paid_final   = $transaction->total_dibayar;
    $transaction->total_kembalian = $transaction->paid_final - $transaction->total_final;

    return view('kasir.cetak.struk', compact('transaction'));
}

}
