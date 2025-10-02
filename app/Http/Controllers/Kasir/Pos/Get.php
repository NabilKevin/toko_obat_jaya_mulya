<?php

namespace App\Http\Controllers\Kasir\Pos;

use App\Http\Controllers\Controller;
use App\Models\Obat;

class Get extends Controller
{
    public function index()
    {
        $obats = Obat::all()->map(function($obat) {
            return [
                'id' => $obat->id,
                'nama' => $obat->nama,
                'harga' => $obat->harga_jual,
                'stok' => $obat->stok,
            ];
        });
        return view('kasir.pos.index', ['obats' => $obats]);
    }
}
