<?php

namespace App\Http\Controllers\Kasir\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class Get extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search ? $request->search :"";
        $transaksis = Transaction::with(['items.obat'])->whereLike('kode', "%$search%")->paginate(10);
        $transaksis->appends($request->query());
        return view('kasir.transaksi.index', compact('transaksis', 'search'));
    }
}
