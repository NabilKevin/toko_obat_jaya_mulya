<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class Get extends Controller
{
    public function index()
    {
      return view('auth.login');
    }
}
