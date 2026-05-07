<?php

namespace App\Http\Controllers\Kasir\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Get extends Controller
{
    public function index(Request $request)
    {
        $search    = $request->search;
        $startDate = $request->start_date;
        $endDate   = $request->end_date;
        $status    = $request->status;

        $query = Transaction::with([
            // item transaksi
            'items.obat',

            // return
            'returns',
            'returns.item.obat',
            'returns.user',

            // void
            'voidBy'
        ])
            ->when($search, function ($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%");
            })
            ->when($status, function ($q) use ($status) {
                $q->where('status', $status);
            });
        if (Auth::user() && Auth::user()->role === 'kasir') {
            $query->where('user_id', Auth::user()->id);
        }

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [
                $startDate . ' 00:00:00',
                $endDate . ' 23:59:59'
            ]);
        }

        $transaksis = $query
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('kasir.transaksi.index', compact(
            'transaksis',
            'search',
            'startDate',
            'endDate',
            'status'
        ));
    }


    public function exportExcel(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : null;
        $endDate   = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : null;

        // Query dasar
        $query = Transaction::with(['items.obat', 'user'])->orderBy('created_at', 'desc');

        if (Auth::user() && Auth::user()->role === 'kasir') {
            $query->where('user_id', Auth::user()->id);
        }

        // Jika ada filter tanggal → tambahkan whereBetween
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Ambil semua data (jika tidak ada filter → semua data diexport)
        $transactions = $query->get();

        // Buat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Transaksi');

        // Header kolom
        $headers = ['No', 'Kode Transaksi', 'Tanggal', 'Kasir', 'Nama Obat', 'Qty', 'Modal', 'Total Jual', 'Keuntungan'];
        $sheet->fromArray($headers, null, 'A1');

        // Isi data
        $row = 2;
        $no = 1;
        $totalModal = 0;
        $totalJual = 0;
        $totalUntung = 0;

        foreach ($transactions as $transaction) {

            if ($transaction->status === 'VOID') {
                continue;
            }

            foreach ($transaction->items as $item) {

                $qtyNet = $item->qty - $item->returned_qty;
                if ($qtyNet <= 0) continue;

                $modal = $item->harga_modal * $qtyNet;
                $jual  = $item->harga_jual * $qtyNet;
                $untung = $jual - $modal;

                $sheet->fromArray([
                    $no++,
                    $transaction->kode,
                    optional($transaction->created_at)->format('Y-m-d H:i'),
                    $transaction->user->nama ?? '-',
                    $item->obat->nama ?? '-',
                    $qtyNet,
                    $modal,
                    $jual,
                    $untung
                ], null, 'A' . $row);

                $totalModal += $modal;
                $totalJual += $jual;
                $totalUntung += $untung;
                $row++;
            }
        }

        // Tambahkan total di baris terakhir
        $sheet->setCellValue('F' . $row, 'TOTAL');
        $sheet->setCellValue('G' . $row, $totalModal);
        $sheet->setCellValue('H' . $row, $totalJual);
        $sheet->setCellValue('I' . $row, $totalUntung);

        // Format header dan kolom
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
        foreach (range('A', 'I') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Simpan file sementara
        $fileName = 'Laporan_Transaksi_' . Carbon::now()->format('Ymd_His') . '.xlsx';
        $filePath = storage_path('app/public/' . $fileName);

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        // Download dan hapus setelah terkirim
        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function cetakStruk($kode)
{
    $transaction = Transaction::with([
        'items.obat',
        'user',
        'returns', // ⬅️ cukup ini
    ])->where('kode', $kode)->firstOrFail();

    // 🔁 Mapping return per transaction_item
    $returnedQtyMap = [];
    $totalReturn = 0;

    foreach ($transaction->returns as $ret) {
        $totalReturn += $ret->amount;

        if (!isset($returnedQtyMap[$ret->transaction_item_id])) {
            $returnedQtyMap[$ret->transaction_item_id] = 0;
        }

        $returnedQtyMap[$ret->transaction_item_id] += $ret->qty;
    }

    // 🔢 Hitung ulang qty & subtotal setelah return
    foreach ($transaction->items as $item) {
        $returnedQty = $returnedQtyMap[$item->id] ?? 0;

        $item->qty_return = $returnedQty;
        $item->qty_final  = $item->qty - $returnedQty;
        $item->subtotal_final = $item->qty_final * $item->harga_jual;
        $item->subtotal_return = $returnedQty * $item->harga_jual;
    }

    // 💰 Total akhir setelah return
    $transaction->total_return = $totalReturn;
    $transaction->total_final  = $transaction->total_transaksi - $totalReturn;

    return view('kasir.cetak.struk', compact('transaction'));
}

    public function profit(Request $request)
    {
        $startDate = $request->start_date
            ? Carbon::parse($request->start_date)->startOfDay()
            : null;

        $endDate = $request->end_date
            ? Carbon::parse($request->end_date)->endOfDay()
            : null;

        $query = Transaction::with('items')
            ->whereIn('status', ['SUCCESS', 'RETURN']); // ⬅️ penting
        if (Auth::user() && Auth::user()->role === 'kasir') {
            $query->where('user_id', Auth::user()->id);
        }
        // Filter tanggal
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Filter search kode transaksi
        if ($request->search) {
            $query->where('kode', 'like', "%{$request->search}%");
        }

        $transactions = $query->get();

        $totalModal = 0;
        $totalJual  = 0;

        foreach ($transactions as $transaction) {
            foreach ($transaction->items as $item) {

                // Qty bersih setelah return
                $netQty = $item->qty - ($item->returned_qty ?? 0);

                if ($netQty <= 0) {
                    continue; // item fully returned
                }

                $totalModal += $item->harga_modal * $netQty;
                $totalJual  += $item->harga_jual  * $netQty;
            }
        }

        $keuntungan = $totalJual - $totalModal;
        $margin = $totalJual > 0
            ? round(($keuntungan / $totalJual) * 100, 2)
            : 0;

        return response()->json([
            'total_jual'   => $totalJual,
            'total_modal'  => $totalModal,
            'keuntungan'   => $keuntungan,
            'margin'       => $margin,
        ]);
    }
}
// Filter hanya transaksi milik kasir yang login
        // if (Auth::user() && Auth::user()->role === 'kasir') {
        //     $query->where('user_id', Auth::user()->id);
        // }