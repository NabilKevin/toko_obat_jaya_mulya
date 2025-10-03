<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Kasir;
use App\Http\Controllers\Auth;

Route::get('/', [Kasir\Dashboard\Get::class, 'index'])->name('kasir.dashboard');
Route::get('/pos', [Kasir\Pos\Get::class, 'index'])->name('kasir.pos');
Route::get('/obat', [Kasir\Obat\Get::class, 'index'])->name('kasir.obat');

Route::middleware('guest')->group(function () {
    Route::get("/login", [Auth\Get::class, 'index'])->name('login');
    Route::post("/login", [Auth\Post::class, 'login'])->name('login.store');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post("/logout", [Auth\Post::class, 'logout'])->name('logout');
    Route::prefix('admin')->group(function() {
        Route::get('/', [Admin\Dashboard\Get::class, 'index'])->name('admin.dashboard');
        Route::get('/obat', [Admin\Obat\Get::class, 'index'])->name('admin.obat');
        Route::get('/obat/create', [Admin\Obat\Get::class, 'create'])->name('admin.obat.create');
        Route::post('/obat', [Admin\Obat\Post::class, 'store'])->name('admin.obat.store');
        Route::get('/obat/{id}/edit', [Admin\Obat\Get::class, 'edit'])->name('admin.obat.edit');
        Route::put('/obat/{id}', [Admin\Obat\Put::class, 'update'])->name('admin.obat.update');
        Route::delete('/obat/{id}', [Admin\Obat\Delete::class, 'destroy'])->name('admin.obat.delete');

        Route::get('/user', [Admin\User\Get::class, 'index'])->name('admin.user');
        Route::get('/user/create', [Admin\User\Get::class, 'create'])->name('admin.user.create');
        Route::post('/user', [Admin\User\Post::class, 'store'])->name('admin.user.store');
        Route::get('/user/{id}/edit', [Admin\User\Get::class, 'edit'])->name('admin.user.edit');
        Route::put('/user/{id}', [Admin\User\Put::class, 'update'])->name('admin.user.update');
        Route::delete('/user/{id}', [Admin\User\Delete::class, 'destroy'])->name('admin.user.delete');
    });
});
