<?php

namespace App\Http\Controllers\Admin\Laporan;
use App\Http\Controllers\Controller;
use App\Models\Obat;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\TransactionItem;
use App\Models\User;

class Get extends Controller
{
    private function getDataTransaksi($transaksis)
    {
        $transaksi = (clone $transaksis)->take(3)->get();

        $penjualanHariIni = (clone $transaksis)->whereDate('created_at', Carbon::today())->sum('subtotal');
        $penjualanKemarin = (clone $transaksis)->whereDate('created_at', Carbon::yesterday())->sum('subtotal');

        $totalobatterjual = (clone $transaksis)->count();

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

        // $dataSummary = $this->getDataSummary($obats, $users);

        $transaksis = TransactionItem::select('transactionitem.*')
            ->join('transaction', 'transactionitem.transaction_id', '=', 'transaction.id')
            ->orderBy('transaction.created_at', 'desc')
            ->with(['obat', 'transaction']);

        $dataTransaksi = $this->getDataTransaksi($transaksis);

        // $dataChart = $this->getDataChart($transaksis);

        return view('admin.laporan.index', [
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

            'transaksis' => $dataTransaksi['transaksi'],

            'penjualanHariIni' => $dataTransaksi['penjualanHariIni'],
            'totalKenaikanPenjualan' => $dataTransaksi['kenaikanPenjualan'],

        ]);
    }
}