<?php

namespace App\Http\Controllers\Admin\Obat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Get extends Controller
{
    public function index()
    {
        return view('admin.obat.index');
    }
}
