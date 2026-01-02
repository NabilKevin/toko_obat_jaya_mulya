<?php

namespace App\Http\Controllers\Admin\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\TransactionItem;
use App\Models\Transaction;
use App\Models\User;

class Get extends Controller
{
    private function getDataTransaksi($transaksis)
{
    $items = (clone $transaksis)->get();

    $penjualanHariIni = 0;
    $penjualanKemarin = 0;
    $totalModal = 0;
    $totalPenjualan = 0;
    $totalobatterjual = 0;

    $today = Carbon::today();
    $yesterday = Carbon::yesterday();

    foreach ($items as $item) {

        // safety check status
        if (!in_array($item->transaction->status, ['SUCCESS', 'RETURN'])) {
            continue;
        }

        $netQty = max($item->qty - ($item->returned_qty ?? 0), 0);
        if ($netQty <= 0) continue;

        $penjualan = $item->harga_jual * $netQty;
        $modal = $item->harga_modal * $netQty;

        $totalPenjualan += $penjualan;
        $totalModal += $modal;
        $totalobatterjual += $netQty;

        if ($item->transaction->created_at->isSameDay($today)) {
            $penjualanHariIni += $penjualan;
        }

        if ($item->transaction->created_at->isSameDay($yesterday)) {
            $penjualanKemarin += $penjualan;
        }
    }

    $totalKeuntungan = $totalPenjualan - $totalModal;

    /** ================= BULANAN ================= */
    $startThisMonth = Carbon::now()->startOfMonth();
    $endThisMonth = Carbon::now()->endOfMonth();
    $startLastMonth = Carbon::now()->subMonth()->startOfMonth();
    $endLastMonth = Carbon::now()->subMonth()->endOfMonth();

    $totalPenjualanBulanIni = 0;
    $totalModalBulanIni = 0;
    $totalPenjualanBulanLalu = 0;
    $totalModalBulanLalu = 0;

    foreach ($items as $item) {

        if (!in_array($item->transaction->status, ['SUCCESS', 'RETURN'])) {
            continue;
        }

        $netQty = max($item->qty - ($item->returned_qty ?? 0), 0);
        if ($netQty <= 0) continue;

        $jual = $item->harga_jual * $netQty;
        $modal = $item->harga_modal * $netQty;
        $created = $item->transaction->created_at;

        if ($created->between($startThisMonth, $endThisMonth)) {
            $totalPenjualanBulanIni += $jual;
            $totalModalBulanIni += $modal;
        }

        if ($created->between($startLastMonth, $endLastMonth)) {
            $totalPenjualanBulanLalu += $jual;
            $totalModalBulanLalu += $modal;
        }
    }

    $totalKeuntunganBulanIni = $totalPenjualanBulanIni - $totalModalBulanIni;
    $totalKeuntunganBulanLalu = $totalPenjualanBulanLalu - $totalModalBulanLalu;

    /** ================= KENAIKAN ================= */
    if ($penjualanKemarin == 0 && $penjualanHariIni > 0) {
        $totalKenaikanPenjualan = 100;
    } elseif ($penjualanKemarin == 0) {
        $totalKenaikanPenjualan = 0;
    } else {
        $totalKenaikanPenjualan = round(
            (($penjualanHariIni - $penjualanKemarin) / $penjualanKemarin) * 100,
            2
        );
    }

    return [
        'penjualanHariIni' => $penjualanHariIni,
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

        'totalKenaikanPenjualan' => $totalKenaikanPenjualan,
        'totalTransaksi' => $items->groupBy('transaction_id')->count(),
    ];
}


    private function hitungPenjualanByTanggal($query, $date)
    {
        $items = (clone $query)
            ->whereDate('transaction.created_at', $date)
            ->get();

        $total = 0;

        foreach ($items as $item) {
            $netQty = max($item->qty - ($item->returned_qty ?? 0), 0);
            $total += $item->harga_jual * $netQty;
        }

        return $total;
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
            ->whereIn('transaction.status', ['SUCCESS', 'RETURN'])
            ->orderBy('transaction.created_at', 'desc')
            ->with(['obat', 'transaction']);

        $dataTransaksi = $this->getDataTransaksi($transaksis);

        // $dataChart = $this->getDataChart($transaksis);

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

            'transaksis' => $dataTransaksi['transaksi'],

            'penjualanHariIni' => $dataTransaksi['penjualanHariIni'],
            'totalKenaikanPenjualan' => $dataTransaksi['kenaikanPenjualan'],

        ]);
    }

    public function laporan(Request $request)
    {
        $startDate = $request->filled('start_date')
            ? Carbon::parse($request->start_date)->startOfDay()
            : null;

        $endDate = $request->filled('end_date')
            ? Carbon::parse($request->end_date)->endOfDay()
            : null;

        $transactionQuery = Transaction::query();

        if ($startDate && $endDate) {
            $transactionQuery->whereBetween('created_at', [$startDate, $endDate]);
        }

        if ($request->status) {
            $transactionQuery->where('status', $request->status);
        }

        /** =========================
         *  RINGKASAN STATUS
         *  ========================= */
        $totalTransaksi = (clone $transactionQuery)->count();
        $totalSuccess   = (clone $transactionQuery)->where('status', 'SUCCESS')->count();
        $totalVoid      = (clone $transactionQuery)->where('status', 'VOID')->count();
        $totalReturn    = (clone $transactionQuery)->where('status', 'RETURN')->count();

        /** =========================
         *  KEUANGAN (SUCCESS + RETURN)
         *  ========================= */
        $transactions = (clone $transactionQuery)
            ->whereIn('status', ['SUCCESS', 'RETURN'])
            ->with('items')
            ->get();

        $totalJual = 0;
        $totalModal = 0;

        foreach ($transactions as $trx) {
            foreach ($trx->items as $item) {
                $netQty = max($item->qty - ($item->returned_qty ?? 0), 0);
                if ($netQty === 0) continue;

                $totalJual  += $item->harga_jual * $netQty;
                $totalModal += $item->harga_modal * $netQty;
            }
        }

        $keuntungan = $totalJual - $totalModal;
        $margin = $totalJual > 0 ? round(($keuntungan / $totalJual) * 100, 2) : 0;

        /** =========================
         *  TABEL TRANSAKSI
         *  ========================= */
        $transaksis = (clone $transactionQuery)
            ->with(['user', 'items'])
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.laporan.index', compact(
            'totalTransaksi',
            'totalSuccess',
            'totalVoid',
            'totalReturn',
            'totalJual',
            'totalModal',
            'keuntungan',
            'margin',
            'transaksis'
        ));
    }
}
