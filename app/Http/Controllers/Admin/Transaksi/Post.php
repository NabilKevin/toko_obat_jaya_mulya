<?php
namespace App\Http\Controllers\Admin\Transaksi;
use App\Http\Controllers\Controller;
use App\Models\Transaction;

class Post extends Controller
{
  public function cetakStruk($kode)
  {
    // Pastikan relasi model sudah benar di model Transaction
    $transaction = Transaction::with(['items.obat', 'user'])->firstWhere('kode', $kode);

    if (!$transaction) {
      return redirect()->back()->with('error','Transaksi tidak ditemukan!');
    }

    return view('admin.cetak.struk', compact('transaction'));
  }
}
  