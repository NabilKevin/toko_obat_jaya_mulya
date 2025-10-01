<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\Obat;
use App\Http\Controllers\Admin\User;
use App\Http\Controllers\Auth\Login;

Route::get('/', function() {
    return view('kasir.dashboard.index');
})->name('kasir.dashboard');
Route::get('/pos', function() {
    return view('kasir.pos.index');
})->name('kasir.pos');

Route::middleware('guest')->group(function () {
    Route::get("/login", [Login\Get::class, 'index'])->name('login');
    Route::post("/login", [Login\Post::class, 'login'])->name('login.store');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post("/logout", [Login\Post::class, 'logout'])->name('logout');
    Route::prefix('admin')->group(function() {
        Route::get('/', [Dashboard\Get::class, 'index'])->name('admin.dashboard');
        Route::get('/obat', [Obat\Get::class, 'index'])->name('admin.obat.index');
        Route::get('/obat/create', [Obat\Get::class, 'create'])->name('admin.obat.create');
        Route::post('/obat', [Obat\Post::class, 'store'])->name('admin.obat.store');
        Route::get('/obat/{id}/edit', [Obat\Get::class, 'edit'])->name('admin.obat.edit');
        Route::put('/obat/{id}', [Obat\Put::class, 'update'])->name('admin.obat.update');
        Route::delete('/obat/{id}', [Obat\Delete::class, 'destroy'])->name('admin.obat.delete');

        Route::get('/user', [User\Get::class, 'index'])->name('admin.user.index');
        Route::get('/user/create', [User\Get::class, 'create'])->name('admin.user.create');
        Route::post('/user', [User\Post::class, 'store'])->name('admin.user.store');
        Route::get('/user/{id}/edit', [User\Get::class, 'edit'])->name('admin.user.edit');
        Route::put('/user/{id}', [User\Put::class, 'update'])->name('admin.user.update');
        Route::delete('/user/{id}', [User\Delete::class, 'destroy'])->name('admin.user.delete');
    });
});
