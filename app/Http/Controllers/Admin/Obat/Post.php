<?php

namespace App\Http\Controllers\Admin\Obat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Obat\StoreRequest;
use App\Models\Obat;
use Carbon\Carbon;

class Post extends Controller
{
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        Obat::create($data);

        return redirect()->route('admin.obat')->with('success', 'Obat berhasil ditambahkan!');
    }

       

public function expired()
{
    $today = Carbon::today();
    $h7 = Carbon::today()->addDays(7);

    $obats = Obat::whereNotNull('expired_at')
        ->whereDate('expired_at', '<=', $h7)
        ->orderBy('expired_at', 'asc')
        ->get();

    return view('admin.obat.expired', compact('obats'));
}


}
