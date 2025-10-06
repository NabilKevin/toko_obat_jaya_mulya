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
    private function getDataChart($transaksis)
    {
        $totalPenjualan = (clone $transaksis)
            ->select(
                DB::raw("DATE_FORMAT(transaction.created_at, '%Y-%m') as bulan"),
                DB::raw('SUM(transactionitem.subtotal) as total')
            )
            ->where('transaction.created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('bulan')
            ->orderBy('bulan', 'asc')
            ->get();

        $totalPenjualanLabels = $totalPenjualan->pluck('bulan');
        $totalPenjualanTotals = $totalPenjualan->pluck('total');

        // --- Total Modal ---
        $totalModal = (clone $transaksis)
            ->select(
                DB::raw("DATE_FORMAT(transaction.created_at, '%Y-%m') as bulan"),
                DB::raw('SUM(transactionitem.harga_modal * transactionitem.qty) AS total')
            )
            ->where('transaction.created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('bulan')
            ->orderBy('bulan', 'asc')
            ->get();

        $totalModalLabels = $totalModal->pluck('bulan');
        $totalModalTotals = $totalModal->pluck('total');

        // --- Total Keuntungan ---
        $totalKeuntungan = (clone $transaksis)
            ->select(
                DB::raw("DATE_FORMAT(transaction.created_at, '%Y-%m') as bulan"),
                DB::raw('SUM((transactionitem.harga_jual - transactionitem.harga_modal) * transactionitem.qty) AS total')
            )
            ->where('transaction.created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('bulan')
            ->orderBy('bulan', 'asc')
            ->get();

        $totalKeuntunganLabels = $totalKeuntungan->pluck('bulan');
        $totalKeuntunganTotals = $totalKeuntungan->pluck('total');

        return [
            'penjualanLabels' => $totalPenjualanLabels,
            'penjualanTotals' => $totalPenjualanTotals,
            'modalLabels' => $totalModalLabels,
            'modalTotals' => $totalModalTotals,
            'keuntunganLabels' => $totalKeuntunganLabels,
            'keuntunganTotals' => $totalKeuntunganTotals,
        ];
    }
    private function getDataSummary($obats, $users)
    {
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

        return [
            'kenaikanObat' => $totalKenaikanObat,
            'kenaikanUser' => $totalKenaikanUser,
            'listStokObat' => $listStokObats,
            'totalStokObat' => $totalStokObat
        ];
    }
    private function getDataTransaksi($transaksis) 
    {
        $transaksi = (clone $transaksis)->take(3)->get();

        $penjualanHariIni = (clone $transaksis)->whereDate('created_at', Carbon::today())->sum('subtotal');
        $penjualanKemarin = (clone $transaksis)->whereDate('created_at', Carbon::yesterday())->sum('subtotal');

        $totalKenaikanPenjualan = ceil(($penjualanHariIni - $penjualanKemarin) / ($penjualanKemarin > 0 ? $penjualanKemarin : 1) * 100);

        return [
            'transaksi' => $transaksi,
            'penjualanHariIni' => $penjualanHariIni,
            'kenaikanPenjualan' => $totalKenaikanPenjualan
        ];
    }
    public function index()
    {
        $obats = Obat::all();
        $users = User::all();
        
        $totalObat = $obats->count();
        $totalStokMenipis = (clone $obats)->where('stok', '<', 10)->count();
        $totalUser = $users->count();

        $dataSummary = $this->getDataSummary($obats, $users);

        $transaksis = TransactionItem::select('transactionitem.*')
            ->join('transaction', 'transactionitem.transaction_id', '=', 'transaction.id')
            ->orderBy('transaction.created_at', 'desc')
            ->with(['obat', 'transaction']);

        $dataTransaksi = $this->getDataTransaksi($transaksis);

        $dataChart = $this->getDataChart($transaksis);

        return view('admin.dashboard.index', [
            'totalObat' => $totalObat,
            'totalStokMenipis'=> $totalStokMenipis,
            'totalUser'=> $totalUser,

            'totalKenaikanObat' => $dataSummary['kenaikanObat'],
            'totalKenaikanUser' => $dataSummary['kenaikanUser'] < 0 ? 0: $dataSummary['kenaikanUser'],

            'overviewObats' => $dataSummary['listStokObat'],
            'totalStokObat' => $dataSummary['totalStokObat'],

            'transaksis' => $dataTransaksi['transaksi'],

            'penjualanHariIni' => $dataTransaksi['penjualanHariIni'],
            'totalKenaikanPenjualan' => $dataTransaksi['kenaikanPenjualan'],

            'totalPenjualanLabels' => $dataChart['penjualanLabels'],
            'totalPenjualanTotals' => $dataChart['penjualanTotals'],

            'totalModalLabels' => $dataChart['modalLabels'],
            'totalModalTotals' => $dataChart['modalTotals'],

            'totalKeuntunganLabels' => $dataChart['keuntunganLabels'],
            'totalKeuntunganTotals' => $dataChart['keuntunganTotals'],
        ]);
    }
}
