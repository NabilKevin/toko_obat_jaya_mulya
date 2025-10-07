<?php

namespace App\Http\Controllers\Kasir\Pos;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
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
        'error' => $validator->errors(),
      ], 422);
    }

    DB::beginTransaction();
    try {
      $data = $request->all();

      $lastId = Transaction::max('id') + 1;
      $kode = 'TRX-' . date('Ymd') . '-' . str_pad($lastId, 5, '0', STR_PAD_LEFT);

      $transaksi = Transaction::create([
        'kode' => $kode,
        'total_transaksi' => $data['totalTransaction'],
        'total_dibayar' => $data['totalPaid'],
        'total_kembalian' => $data['totalChange'],
        'status' => 'SUCCESS',
        'user_id' => Auth::id(),
      ]);

      foreach ($data['cart'] as $value) {
        $obat = Obat::findOrFail($value["id"]);

        if ($obat->stok < $value["qty"]) {
          throw new \Exception("Stok {$obat->nama} tidak mencukupi!");
        }

        $obat->stok -= $value["qty"];
        $obat->save();

        TransactionItem::create([
          'obat_id' => $obat->id,
          'transaction_id' => $transaksi->id,
          'harga_modal' => $obat->harga_modal,
          'harga_jual' => $obat->harga_jual,
          'qty' => $value['qty'],
          'subtotal' => $obat->harga_jual * $value['qty'],
        ]);
      }

      DB::commit();

      // Setelah transaksi sukses, redirect ke halaman cetak
      return response()->json([
        'status' => 'success',
        'message' => 'Berhasil membuat transaksi baru!',
        'redirect_url' => route('kasir.cetak.struk', $transaksi->kode),
      ]);
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json([
        'status' => 'error',
        'message' => $e->getMessage(),
      ], 500);
    }
  }

  public function cetakStruk($kode)
  {
    // Pastikan relasi model sudah benar di model Transaction
    $transaction = Transaction::with(['items.obat', 'user'])->where('kode', $kode)->firstOrFail();

    return view('kasir.cetak.struk', compact('transaction'));
  }

}
