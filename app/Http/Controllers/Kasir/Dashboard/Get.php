<?php

namespace App\Http\Controllers\Kasir\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Carbon\Carbon;

class Get extends Controller
{
    public function index()
    {
      $transaksis = TransactionItem::select('transactionitem.*')
          ->join('transaction', 'transactionitem.transaction_id', '=', 'transaction.id')
          ->orderBy('transaction.created_at', 'desc')
          ->with(['obat', 'transaction']);

      $transaksi = (clone $transaksis)->take(3)->get();

      $penjualanHariIni = (clone $transaksis)->whereDate('created_at', Carbon::today())->sum('subtotal');
      $penjualanKemarin = (clone $transaksis)->whereDate('created_at', Carbon::yesterday())->sum('subtotal');
      $totalKenaikanPenjualan = ceil(($penjualanHariIni - $penjualanKemarin) / ($penjualanKemarin > 0 ? $penjualanKemarin : 1) * 100);

      $totalTransaksiHariIni = Transaction::whereDate('created_at', Carbon::today())->count();
      $totalTransaksiKemarin = Transaction::whereDate('created_at', Carbon::yesterday())->count();
      $totalKenaikanTransaksi = ceil(($totalTransaksiHariIni - $totalTransaksiKemarin) / ($totalTransaksiKemarin > 0 ? $totalTransaksiKemarin : 1) * 100);

      $totalItemTerjualHariIni = (clone $transaksis)->whereDate('created_at', Carbon::today())->count();
      $totalItemTerjualKemarin = (clone $transaksis)->whereDate('created_at', Carbon::yesterday())->count();
      $totalKenaikanItemTerjual = ceil(($totalItemTerjualHariIni - $totalItemTerjualKemarin) / ($totalItemTerjualKemarin > 0 ? $totalItemTerjualKemarin : 1) * 100);

      return view('kasir.dashboard.index', [
        'transaksis' => $transaksi, 
        'penjualanHariIni' => $penjualanHariIni, 
        'totalKenaikanPenjualan' => $totalKenaikanPenjualan,
        'totalTransaksi' => $totalTransaksiHariIni,
        'totalKenaikanTransaksi' => $totalKenaikanTransaksi,
        'totalItemTerjual' => $totalItemTerjualHariIni,
        'totalKenaikanItemTerjual' => $totalKenaikanItemTerjual,
      ]);
    }
}
