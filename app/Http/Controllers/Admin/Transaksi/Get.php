<?php

namespace App\Http\Controllers\Admin\Transaksi;
use App\Http\Controllers\Controller;
use App\Models\TransactionItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
class Get extends Controller
{
    public function index(Request $request)
    {
       $search = $request->search ? $request->search :"";
        $transaksis = Transaction::with(['items.obat'])->whereLike('kode', "%$search%")->paginate(10);
        $transaksis->appends($request->query());
        return view('admin.transaksi.index', compact('transaksis', 'search'));
    }
}