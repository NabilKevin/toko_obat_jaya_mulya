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
        $startDate = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : Carbon::now()->startOfDay();
        $endDate   = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : Carbon::now()->endOfDay();

        $transactions = Transaction::with(['items.obat', 'user'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();

        // Buat spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Transaksi');

        // Header kolom
        $headers = ['No', 'Kode Transaksi', 'Tanggal', 'Kasir', 'Nama Obat', 'Qty', 'Modal', 'Total Jual', 'Keuntungan'];
        $sheet->fromArray($headers, null, 'A1');

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
                    $transaction->created_at->format('Y-m-d H:i'),
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

        // Tambahkan total di bawah
        $sheet->setCellValue('F' . $row, 'TOTAL');
        $sheet->setCellValue('G' . $row, $totalModal);
        $sheet->setCellValue('H' . $row, $totalJual);
        $sheet->setCellValue('I' . $row, $totalUntung);

        // Formatting
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(30);

        // Simpan file
        $fileName = 'Laporan_Transaksi_' . Carbon::now()->format('Ymd_His') . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $filePath = storage_path('app/public/' . $fileName);
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }

  public function cetakStruk($kode)
  {
    // Pastikan relasi model sudah benar di model Transaction
    $transaction = Transaction::with(['items.obat', 'user'])->where('kode', $kode)->firstOrFail();

    return view('admin.cetak.struk', compact('transaction'));
  }
}
