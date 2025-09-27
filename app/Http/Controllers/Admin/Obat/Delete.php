<?php

namespace App\Http\Controllers\Admin\Obat;

use App\Http\Controllers\Controller;
use App\Models\Obat;

class Delete extends Controller
{
    public function destroy($id)
    {
        $obat = Obat::find($id);
        if (!$obat) {
            return redirect()->back()->with("error","Obat tidak ditemukan!");
        }
        $obat->delete();
        return redirect()->back()->with("success","Berhasil hapus obat!");
    }       
}
