<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use App\Models\TipeObat;
use App\Models\TransactionItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Get extends Controller
{
    public function index()
    {
        $obats = Obat::all();
        $users = User::all();
        
        $totalObat = $obats->count();
        $totalStokMenipis = (clone $obats)->where('stok', '<', 10)->count();
        $totalUser = $users->count();

        $startLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endLastMonth = Carbon::now()->subMonth()->endOfMonth();

        $startThisMonth = Carbon::now()->startOfMonth();
        $endThisMonth = Carbon::now()->endOfMonth();

        $totalObatBulanLalu = (clone $obats)->whereBetween('created_at', [$startLastMonth, $endLastMonth])->count();
        $totalObatBulanIni = (clone $obats)->whereBetween('created_at', [$startThisMonth, $endThisMonth])->count();
        $totalKenaikanObat = ceil(($totalObatBulanIni - $totalObatBulanLalu) / ($totalObatBulanLalu > 0 ? $totalObatBulanLalu : 1) * 100);
        
        $totalUserBulanLalu = (clone $users)->whereBetween('created_at', [$startLastMonth, $endLastMonth])->count();
        $totalUserBulanIni = (clone $users)->whereBetween('created_at', [$startThisMonth, $endThisMonth])->count();
        $totalKenaikanUser = $totalUserBulanIni-$totalUserBulanLalu;

        $totalStokObat = 0;
        $listStokObats = (clone $obats)->map(function($obat) use(&$totalStokObat) {
            $totalStokObat += $obat->stok;
            return ['nama' => $obat->nama, 'stok' => $obat->stok];
        })->sortBy('stok', SORT_NATURAL, true)->take(4);

        $transaksis = TransactionItem::select('transactionitem.*')
            ->join('transaction', 'transactionitem.transaction_id', '=', 'transaction.id')
            ->orderBy('transaction.created_at', 'desc')
            ->with(['obat', 'transaction']);

        $transaksi = (clone $transaksis)->take(3)->get();

        $penjualanHariIni = (clone $transaksis)->whereDate('created_at', Carbon::today())->sum('subtotal');
        $penjualanKemarin = (clone $transaksis)->whereDate('created_at', Carbon::yesterday())->sum('subtotal');

        $totalobatterjual = (clone $transaksis)->count();

        $totalModal = (clone $transaksis)->sum(DB::raw('harga_modal * qty'));
        $totalPenjualan = (clone $transaksis)->sum('subtotal');
        $totalKeuntungan = $totalPenjualan - $totalModal;

        $totalModalHariIni = (clone $transaksis)->whereDate('created_at', Carbon::today())->sum(DB::raw('harga_modal * qty'));
        $totalModalbulanIni = (clone $transaksis)->whereBetween('created_at', [$startThisMonth, $endThisMonth])->sum(DB::raw('harga_modal * qty'));
        $totalPenjualanBulanIni = (clone $transaksis)->whereBetween('created_at', [$startThisMonth, $endThisMonth])->sum('subtotal');
        $totalKeuntunganBulanIni = $totalPenjualanBulanIni - $totalModalbulanIni;

        $totalModalBulanLalu = (clone $transaksis)->whereBetween('created_at', [$startLastMonth, $endLastMonth])->sum(DB::raw('harga_modal * qty'));
        $totalPenjualanBulanLalu = (clone $transaksis)->whereBetween('created_at', [$startLastMonth, $endLastMonth])->sum('subtotal');
        $totalKeuntunganBulanLalu = $totalPenjualanBulanLalu - $totalModalBulanLalu;
        
       //Total modal per obat dan penjualan per obat
        $totalmodalperobat = (clone $transaksis)
            ->select('obat_id', DB::raw('SUM(harga_modal * qty) as total_modal_per_obat'), DB::raw('SUM(subtotal) as total_penjualan_per_obat'))
            ->groupBy('obat_id')
            ->with('obat')
            ->get();
        // $totalKeuntunganBulanIni = $totalPenjualanBulanIni - $totalModalBulanIni
        $totalKeuntunganHariIni = $penjualanHariIni - $totalModalHariIni;
        // hitung persentase kenaikan penjualan
        $totalKenaikanPenjualan = 0;
        if ($penjualanKemarin == 0 && $penjualanHariIni > 0) {
            $totalKenaikanPenjualan = 100;
        } elseif ($penjualanKemarin == 0 && $penjualanHariIni == 0) {
            $totalKenaikanPenjualan = 0;
        } else {
            $totalKenaikanPenjualan = ceil(($penjualanHariIni - $penjualanKemarin) / ($penjualanKemarin > 0 ? $penjualanKemarin : 1) * 100);
        }
        // data untuk chart penjualan 7 hari terakhir
        $totalTransaksi = (clone $transaksis)->count();
        if ($totalTransaksi < 7) {
            $days = $totalTransaksi;
        } else {
            $days = 7;
        }
        // ambil data penjualan per hari selama 7 hari terakhir

        $chartPenjualan = (clone $transaksis)->select(
            DB::raw('DATE(created_at) as tanggal'),
            DB::raw('SUM(subtotal) as total')
        )
        ->where('created_at', '>=', Carbon::now()->subDays(6))
        ->groupBy('tanggal')
        ->orderBy('tanggal', 'asc')
        ->get();

        // siapkan array label dan data untuk chart
        $chartLabels = $chartPenjualan->pluck('tanggal');
        $chartTotals = $chartPenjualan->pluck('total');

        return view('admin.dashboard.index', [
            'totalObat' => $totalObat,
            'totalStokMenipis'=> $totalStokMenipis,
            'totalUser'=> $totalUser,
            'totalModalBulanIni' => $totalModalbulanIni,
            'totalPenjualanBulanIni' => $totalPenjualanBulanIni,
            'totalKeuntunganBulanIni' => $totalKeuntunganBulanIni,
            'totalModalBulanLalu' => $totalModalBulanLalu,
            'totalPenjualanBulanLalu' => $totalPenjualanBulanLalu,
            'totalKeuntunganBulanLalu' => $totalKeuntunganBulanLalu,
            'totalModalperobat' => $totalmodalperobat,
            'totalPenjualanHariIni' => $penjualanHariIni,
            'totalModalHariIni' => $totalModalHariIni,
            'totalKeuntunganHariIni' => $totalKeuntunganHariIni,
            'totalKenaikanPenjualan' => $totalKenaikanPenjualan,

            'totalTransaksi' => $totalTransaksi,

            'totalModal' => $totalModal,
            'totalPenjualan' => $totalPenjualan,
            'totalKeuntungan' => $totalKeuntungan,

            'totalobatterjual' => $totalobatterjual,

            'totalKenaikanObat' => $totalKenaikanObat,
            'totalKenaikanUser' => $totalKenaikanUser < 0 ? 0: $totalKenaikanUser,

            'overviewObats' => $listStokObats,
            'totalStokObat' => $totalStokObat,

            'transaksis' => $transaksi,

            'penjualanHariIni' => $penjualanHariIni,
            'totalKenaikanPenjualan' => $totalKenaikanPenjualan,

            'chartLabels' => $chartLabels,
            'chartTotals' => $chartTotals
        ]);
    }
}
