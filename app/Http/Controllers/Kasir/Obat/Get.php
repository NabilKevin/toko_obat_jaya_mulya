<?php

namespace App\Http\Controllers\Kasir\Obat;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request;

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

    return view('kasir.obat.index', compact('obats', 'search'));
}
    public function search(Request $request) {
        $q = $request->get('q');
        $obat = Obat::whereLike('nama', "%$q%")
                ->orWhereLike('kode_barcode', "%$q%")
                ->get(['id', 'kode_barcode', 'nama', 'harga_jual as harga', 'stok']);
        return response()->json($obat);
    }
}
