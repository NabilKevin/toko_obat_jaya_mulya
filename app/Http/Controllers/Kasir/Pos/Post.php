<?php

namespace App\Http\Controllers\Kasir\Pos;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use App\Http\Requests\Kasir\Pos\StoreRequest;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Post extends Controller
{
    public function bayar(Request $request)
    {
      // $data = $request->validated();
      $validator = Validator::make($request->all(), [
        'cart' => 'required|array|min:1',
        'cart.*.id' => 'required|integer|exists:obat,id',
        'cart.*.qty' => 'required|integer|min:1',
        'totalTransaction' => 'required|integer|min:1',
        'totalPaid' => 'required|integer|min:1|gt:totalTransaction',
        'totalChange' => 'required|integer|min:0',
      ]);

      if ($validator->fails()) {
        return response()->json([
          'error'=> $validator->errors(),
        ],422);
      }

      $data = $request->all();
      
      $lastId = Transaction::max('id') + 1;
      $kode = 'TRX-' . date('Ymd') . '-' . str_pad($lastId, 5, '0', STR_PAD_LEFT);

      $transaksi = Transaction::create([
        'kode' => $kode,
        'total_transaksi' => $data['totalTransaction'],
        'total_dibayar' => $data['totalPaid'],
        'total_kembalian' => $data['totalChange'],
        'status' => 'SUCCESS',
        'user_id' => /* auth()->user()->id */ 2
      ]);
      foreach($data['cart'] as $value) {
        $obat = Obat::find($value["id"]);
        $obat->stok -= $value["qty"];
        $obat->save();

        TransactionItem::create([
          'obat_id' => $obat->id,
          'transaction_id' => $transaksi->id,
          'harga_modal' => $obat->harga_modal,
          'harga_jual' => $obat->harga_jual,
          'qty' => $value['qty'],
          'subtotal' => $obat->harga_jual * $value['qty']
        ]);
      }

      return response()->json([
        'status' => 'success',
        'message' => 'Berhasil membuat transaksi baru!'
      ]);
    }
}
