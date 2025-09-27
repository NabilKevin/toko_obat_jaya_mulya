<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;

class Delete extends Controller
{
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with("error","User tidak ditemukan!");
        }
        $user->delete();
        return redirect()->back()->with("success","Berhasil hapus user!");
    }       
}
