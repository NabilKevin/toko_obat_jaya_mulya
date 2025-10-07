<?php

namespace App\Http\Controllers\Admin\Obat;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use App\Models\TipeObat;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Get extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search ? $request->search :"";
        $obats = Obat::whereLike('nama', "%$search%")->orWhereLike('kode_barcode', "%$search%")->paginate(10);
        $obats->appends($request->query());
        

        return view('admin.obat.index',compact('obats', 'search'));
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
            return redirect()->back()->with("error","Obat tidak ditemukan!");
        }

        $obat->expired_at = Carbon::parse($obat->expired_at)->format("Y-m-d");

        $tipeobat = TipeObat::all();

        return view('admin.obat.edit', ['obat'=> $obat, 'tipeobat' => $tipeobat]);
    }
}
