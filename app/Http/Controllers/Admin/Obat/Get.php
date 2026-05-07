<?php

namespace App\Http\Controllers\Admin\Obat;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use App\Models\TipeObat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Get extends Controller
{
    public function index(Request $request)
{
    $search = $request->search ?? "";

    $obats = Obat::query()
        ->when($request->stok === 'habis', function ($q) {
            $q->where('stok', 0);
        })
        ->when($search, function ($q) use ($search) {
            $q->where(function ($sub) use ($search) {
                $sub->where('nama', 'like', "%{$search}%")
                    ->orWhere('kode_barcode', 'like', "%{$search}%");
            });
        })
        ->paginate(10)
        ->appends($request->query());

    return view('admin.obat.index', compact('obats', 'search'));
}

    public function create()
    {
        $tipeobat = TipeObat::all();
        return view('admin.obat.create', ['tipeobat' => $tipeobat]);
    }
    public function edit($id)
    {
        $obat = Obat::with('tipe')->find($id);

        if (!$obat) {
            return redirect()->back()->with("error", "Obat tidak ditemukan!");
        }

        $obat->expired_at = Carbon::parse($obat->expired_at)->format("Y-m-d");

        $tipeobat = TipeObat::all();

        return view('admin.obat.edit', ['obat' => $obat, 'tipeobat' => $tipeobat]);
    }
    public function exportExpired()
    {
        $obats = Obat::whereDate('expired_at', '<=', now())->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->fromArray([
            ['Nama Obat', 'Stok', 'Tanggal Expired', 'Status']
        ], null, 'A1');

        // Data
        $row = 2;
        foreach ($obats as $obat) {
            $sheet->fromArray([
                $obat->nama,
                $obat->stok,
                \Carbon\Carbon::parse($obat->expired_at)->format('d/m/Y'),
                'Expired'
            ], null, "A{$row}");
            $row++;
        }

        $filename = 'barang-expired-' . now()->format('Y-m-d') . '.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename);
    }
}
