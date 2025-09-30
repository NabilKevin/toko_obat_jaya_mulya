<?php

namespace App\Http\Controllers\Auth\Login;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Login\StoreRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Post extends Controller
{
  public function login(StoreRequest $request)
  {
    $credential = $request->validated();
    
    if(!Auth::attempt($credential)) {
      return redirect()->back()->with("error","Username atau password salah!");
    }

    $request->session()->regenerate();
    return redirect('/admin');
  }
  public function logout(Request $request)
  {
    Auth::guard('web')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
    return redirect('/login');
  }
}
