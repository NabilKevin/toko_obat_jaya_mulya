<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Kasir;
use App\Http\Controllers\Auth;
use App\Http\Middleware\isAdmin;
use App\Http\Middleware\isKasir;

Route::middleware('guest')->group(function () {
    Route::get("/login", [Auth\Get::class, 'index'])->name('login');
    Route::post("/login", [Auth\Post::class, 'login'])->name('login.store');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post("/logout", [Auth\Post::class, 'logout'])->name('logout');
    Route::middleware([isAdmin::class])->group(function () {
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

            Route::get('/transaksi', [Admin\Transaksi\Get::class, 'index'])->name('admin.transaksi');
        });
    });
    
    Route::middleware([isKasir::class])->group(function () {
        Route::get('/', [Kasir\Dashboard\Get::class, 'index'])->name('kasir.dashboard');
        Route::get('/pos', [Kasir\Pos\Get::class, 'index'])->name('kasir.pos');
        Route::post('/pos', [Kasir\Pos\Post::class, 'bayar'])->name('kasir.pos.store');
        Route::get('/obat', [Kasir\Obat\Get::class, 'index'])->name('kasir.obat');
        Route::get('/obat/search', [Kasir\Obat\Get::class, 'search'])->name('kasir.obat.search');
        Route::get('/transaksi', [Kasir\Transaksi\Get::class, 'index'])->name('kasir.transaksi');
        Route::get('/kasir/struk/{id}', [Kasir\Pos\Post::class, 'cetakStruk'])->name('kasir.cetak.struk');
    });
});
