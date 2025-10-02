<?php

namespace App\Http\Controllers\Kasir\Dashboard;

use App\Http\Controllers\Controller;

class Get extends Controller
{
    public function index()
    {
      return view('kasir.dashboard.index');
    }
}
