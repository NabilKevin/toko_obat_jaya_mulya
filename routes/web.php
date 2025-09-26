<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\Obat;
use App\Http\Controllers\Admin\User;

Route::prefix('admin')->group(function() {
    Route::get('/', [Dashboard\Get::class, 'index'])->name('dashboard');
    Route::get('/obat', [Obat\Get::class, 'index'])->name('obat.index');
    Route::get('/user', [User\Get::class, 'index'])->name('user.index');
    Route::get('/user/create', [User\Get::class, 'create'])->name('user.create');
    Route::post('/user', [User\Post::class, 'store'])->name('user.store');
});
