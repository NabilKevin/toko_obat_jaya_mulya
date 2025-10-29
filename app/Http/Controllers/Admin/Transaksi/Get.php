<?php

namespace App\Http\Controllers\Admin\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\TransactionItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Carbon\Carbon;


class Get extends Controller
{
  public function index(Request $request)
  {
    $search = $request->search ?? '';
    $filter = $request->filter ?? '';
    $startDate = $request->start_date;
    $endDate = $request->end_date;

    $query = Transaction::with(['items.obat'])
      ->when($search, function ($q) use ($search) {
        $q->where('kode', 'like', "%{$search}%");
      });

    // Filter rentang tanggal manual
    if ($startDate && $endDate) {
      $query->whereBetween('created_at', [
        $startDate . ' 00:00:00',
        $endDate . ' 23:59:59'
      ]);
    }

    // // Filter cepat (harian, mingguan, bulanan)
    // if ($filter === 'harian') {
    //   $query->whereDate('created_at', now());
    // } elseif ($filter === 'mingguan') {
    //   $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    // } elseif ($filter === 'bulanan') {
    //   $query->whereMonth('created_at', now()->month)
    //     ->whereYear('created_at', now()->year);
    // }

    // Urutkan dari transaksi terbaru
    $transaksis = $query->orderBy('id', 'desc')->paginate(10);
    $transaksis->appends($request->query());

    return view('admin.transaksi.index', compact('transaksis', 'search'));
  }

  public function exportExcel(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : null;
        $endDate   = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : null;

        // Query dasar
        $query = Transaction::with(['items.obat', 'user'])->orderBy('created_at', 'desc');


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
            foreach ($transaction->items as $item) {
                $modal = $item->harga_modal * $item->qty;
                $jual = $item->harga_jual * $item->qty;
                $untung = $jual - $modal;

                $sheet->fromArray([
                    $no++,
                    $transaction->kode,
                    $transaction->created_at ? $transaction->created_at->format('Y-m-d H:i') : '-',
                    $transaction->user->nama ?? '-',
                    $item->obat->nama ?? '-',
                    $item->qty,
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
    // Pastikan relasi model sudah benar di model Transaction
    $transaction = Transaction::with(['items.obat', 'user'])->where('kode', $kode)->firstOrFail();

    return view('admin.cetak.struk', compact('transaction'));
  }
}
