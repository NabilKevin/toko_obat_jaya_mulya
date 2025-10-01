<?php

namespace App\Http\Controllers\Admin\Obat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Obat\StoreRequest;
use App\Models\Obat;

class Post extends Controller
{
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        
        Obat::create($data);
        
        return redirect()->route('admin.obat.index')->with('success', 'Obat berhasil ditambahkan!');
    }

}
