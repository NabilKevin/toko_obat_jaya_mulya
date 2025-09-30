<?php

namespace App\Http\Controllers\Admin\Obat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Obat\UpdateRequest;
use App\Models\Obat;

class Put extends Controller
{
    public function update(UpdateRequest $request, $id)
    {
        $data = $request->validated();
        $obat = Obat::find($id);
        if (!$obat) {
            return redirect()->back()->with("error","Obat tidak ditemukan!");
        }
        $filtered = array_filter($data, function ($value) {
            return !is_null($value) && $value !== '';
        });

        $obat->update($filtered);

        return redirect()->route('obat.index')->with('success', 'Obat berhasil diedit!');
    }       
}
