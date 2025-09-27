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

        $transaksi = TransactionItem::with(['obat'])->get()->sortBy('created_at', SORT_NATURAL, true)->take(3);

        $penjualanHariIni = TransactionItem::whereDate('created_at', Carbon::today())->sum('subtotal');
        $penjualanKemarin = TransactionItem::whereDate('created_at', Carbon::yesterday())->sum('subtotal');

        $totalKenaikanPenjualan = ceil(($penjualanHariIni - $penjualanKemarin) / ($penjualanKemarin > 0 ? $penjualanKemarin : 1) * 100);

        $chartPenjualan = TransactionItem::select(
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
