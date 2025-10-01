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
        $obats = Obat::whereLike('nama', "%$search%")->paginate(10);
        $from = ($obats->currentPage() - 1) * $obats->perPage() + 1;

        return view('admin.obat.index',
            [
                'obats' => $obats,
                'total' => $obats->total(),
                'from' => $from > $obats->total() ? $from-1 : $from,
                'to' => $from - 1 + $obats->count(),
                'isFirstPage' => $obats->onFirstPage(),
                'isLastPage' => $obats->onLastPage(),
                'currentPage' => $obats->currentPage(),
                'firstPage' => $obats->url(1),
                'lastPage' => $obats->url($obats->lastPage()),
                'nextPage' => $obats->nextPageUrl(),
                'prevPage' => $obats->previousPageUrl(),
                'search' => $search
            ]
        );
    }
    public function create()
    {
        $tipeobat = TipeObat::all();
        return view('admin.obat.create', ['tipeobat' => $tipeobat]);
    }
    public function edit($id)
    {
        $obat = Obat::find($id);
        
        if (!$obat) {
            return redirect()->back()->with("error","Obat tidak ditemukan!");
        }

        $obat->expired_at = Carbon::parse($obat->expired_at)->format("Y-m-d");

        $tipeobat = TipeObat::all();
        
        return view('admin.obat.edit', ['obat'=> $obat, 'tipeobat' => $tipeobat]);
    }
}
