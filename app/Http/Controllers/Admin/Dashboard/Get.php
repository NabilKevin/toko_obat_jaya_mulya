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
        $totalKenaikanUser = $totalUserBulanIni - $totalUserBulanLalu;

        $totalStokObat = 0;
        $listStokObats = (clone $obats)->map(function ($obat) use (&$totalStokObat) {
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

        $totalobatterjual = (clone $transaksis)->sum('qty');

        $totalModal = (clone $transaksis)->sum(DB::raw('harga_modal * qty'));
        $totalPenjualan = (clone $transaksis)->sum('subtotal');
        $totalKeuntungan = $totalPenjualan - $totalModal;

        $startThisMonth = Carbon::now()->startOfMonth();
        $endThisMonth = Carbon::now()->endOfMonth();
        $startLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endLastMonth = Carbon::now()->subMonth()->endOfMonth();

        $totalModalHariIni = (clone $transaksis)->whereDate('created_at', Carbon::today())->sum(DB::raw('harga_modal * qty'));
        $totalModalBulanIni = (clone $transaksis)->whereBetween('created_at', [$startThisMonth, $endThisMonth])->sum(DB::raw('harga_modal * qty'));
        $totalPenjualanBulanIni = (clone $transaksis)->whereBetween('created_at', [$startThisMonth, $endThisMonth])->sum('subtotal');
        $totalKeuntunganBulanIni = $totalPenjualanBulanIni - $totalModalBulanIni;

        $totalModalBulanLalu = (clone $transaksis)->whereBetween('created_at', [$startLastMonth, $endLastMonth])->sum(DB::raw('harga_modal * qty'));
        $totalPenjualanBulanLalu = (clone $transaksis)->whereBetween('created_at', [$startLastMonth, $endLastMonth])->sum('subtotal');
        $totalKeuntunganBulanLalu = $totalPenjualanBulanLalu - $totalModalBulanLalu;

        $totalmodalperobat = (clone $transaksis)
            ->select(
                'obat_id',
                DB::raw('SUM(harga_modal * qty) as total_modal_per_obat'),
                DB::raw('SUM(subtotal) as total_penjualan_per_obat')
            )
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

        return [
            'transaksi' => $transaksi,
            'penjualanHariIni' => $penjualanHariIni,
            'kenaikanPenjualan' => $totalKenaikanPenjualan,
            'totalobatterjual' => $totalobatterjual,
            'totalModal' => $totalModal,
            'totalPenjualan' => $totalPenjualan,
            'totalKeuntungan' => $totalKeuntungan,
            'totalModalBulanIni' => $totalModalBulanIni,
            'totalPenjualanBulanIni' => $totalPenjualanBulanIni,
            'totalKeuntunganBulanIni' => $totalKeuntunganBulanIni,
            'totalModalBulanLalu' => $totalModalBulanLalu,
            'totalPenjualanBulanLalu' => $totalPenjualanBulanLalu,
            'totalKeuntunganBulanLalu' => $totalKeuntunganBulanLalu,
            'totalmodalperobat' => $totalmodalperobat,
            'totalTransaksi' => $totalTransaksi,
            'days' => $days,
            'totalKenaikanPenjualan' => $totalKenaikanPenjualan,
            'totalKeuntunganHariIni' => $totalKeuntunganHariIni,
            'totalModalHariIni' => $totalModalHariIni,
            'totalPenjualanHariIni' => $penjualanHariIni,
        ];
    }


    public function index()
    {
        $obats = Obat::all();
        $users = User::all();

        $totalObat = $obats->count();
        $totalStokMenipis = (clone $obats)->where('stok', '<', 10)->count();
        $totalUser = $users->count();
        $today = Carbon::today();
$h7 = Carbon::today()->addDays(7);
$h30 = Carbon::today()->addDays(30);

$totalExpired = Obat::whereNotNull('expired_at')
    ->whereDate('expired_at', '<', $today)
    ->count();

$totalExpiredH7 = Obat::whereNotNull('expired_at')
    ->whereBetween('expired_at', [$today, $h7])
    ->count();

$totalExpiredH30 = Obat::whereNotNull('expired_at')
    ->whereBetween('expired_at', [$h7, $h30])
    ->count();

        $dataSummary = $this->getDataSummary($obats, $users);

        $transaksis = TransactionItem::select('transactionitem.*')
            ->join('transaction', 'transactionitem.transaction_id', '=', 'transaction.id')
            ->orderBy('transaction.created_at', 'desc')
            ->with(['obat', 'transaction']);

        $dataTransaksi = $this->getDataTransaksi($transaksis);

        $dataChart = $this->getDataChart($transaksis);

        return view('admin.dashboard.index', [
            'totalObat' => $totalObat,
            'totalStokMenipis' => $totalStokMenipis,
            'totalUser' => $totalUser,

            'totalobatterjual' => $dataTransaksi['totalobatterjual'] ?? 0,
            'totalModal' => $dataTransaksi['totalModal'] ?? 0,
            'totalPenjualan' => $dataTransaksi['totalPenjualan'] ?? 0,
            'totalKeuntungan' => $dataTransaksi['totalKeuntungan'] ?? 0,
            'totalModalBulanIni' => $dataTransaksi['totalModalBulanIni'] ?? 0,
            'totalPenjualanBulanIni' => $dataTransaksi['totalPenjualanBulanIni'] ?? 0,
            'totalKeuntunganBulanIni' => $dataTransaksi['totalKeuntunganBulanIni'] ?? 0,
            'totalModalBulanLalu' => $dataTransaksi['totalModalBulanLalu'] ?? 0,
            'totalPenjualanBulanLalu' => $dataTransaksi['totalPenjualanBulanLalu'] ?? 0,
            'totalKeuntunganBulanLalu' => $dataTransaksi['totalKeuntunganBulanLalu'] ?? 0,
            'totalModalperobat' => $dataTransaksi['totalmodalperobat'] ?? 0,
            'totalTransaksi' => $dataTransaksi['totalTransaksi'] ?? 0,
            'days' => $dataTransaksi['days'] ?? 7,
            'totalKeuntunganHariIni' => $dataTransaksi['totalKeuntunganHariIni'] ?? 0,
            'totalModalHariIni' => $dataTransaksi['totalModalHariIni'] ?? 0,
            'totalPenjualanHariIni' => $dataTransaksi['totalPenjualanHariIni'] ?? 0,

'totalExpired' => $totalExpired,
    'totalExpiredH7' => $totalExpiredH7,
    'totalExpiredH30' => $totalExpiredH30,

            'totalKenaikanObat' => $dataSummary['kenaikanObat'] ?? 0,
            'totalKenaikanUser' => $dataSummary['kenaikanUser'] < 0 ? 0 : $dataSummary['kenaikanUser'],

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
