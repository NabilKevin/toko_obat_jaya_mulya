<?php

namespace App\Http\Controllers\Kasir\Pos;

use App\Http\Controllers\Controller;
use App\Models\Obat;

class Get extends Controller
{
    public function index()
    {
        $obats = Obat::get(['id', 'kode_barcode', 'nama', 'harga_jual as harga', 'stok']);
        return view('kasir.pos.index', ['obats' => $obats]);
    }
}
