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
        $obats = Obat::whereLike('nama', "%$search%")->paginate(10);
        $from = ($obats->currentPage() - 1) * $obats->perPage() + 1;

        return view('kasir.obat.index',
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
}
