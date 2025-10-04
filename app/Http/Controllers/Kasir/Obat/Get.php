<?php

namespace App\Http\Controllers\Kasir\Obat;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request;

class Get extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search ? $request->search :"";
        $obats = Obat::whereLike('nama', "%$search%")->orWhereLike('kode_barcode', "%$search%")->paginate(10);
        $obats->appends($request->query());

        return view('kasir.obat.index',compact('search','obats'));
    }
    public function search(Request $request) {
        $q = $request->get('q');
        $obat = Obat::whereLike('nama', "%$q%")
                ->orWhereLike('kode_barcode', "%$q%")
                ->get(['id', 'kode_barcode', 'nama', 'harga_jual as harga', 'stok']);
        return response()->json($obat);
    }
}
