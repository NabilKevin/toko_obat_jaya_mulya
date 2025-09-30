<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\Obat;
use App\Http\Controllers\Admin\User;
use App\Http\Controllers\Auth\Login;

Route::middleware('guest')->group(function () {
    Route::get("/login", [Login\Get::class, 'index'])->name('login');
    Route::post("/login", [Login\Post::class, 'login'])->name('login.store');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post("/logout", [Login\Post::class, 'logout'])->name('logout');
    Route::prefix('admin')->group(function() {
        Route::get('/', [Dashboard\Get::class, 'index'])->name('dashboard');
        Route::get('/obat', [Obat\Get::class, 'index'])->name('obat.index');
        Route::get('/obat/create', [Obat\Get::class, 'create'])->name('obat.create');
        Route::post('/obat', [Obat\Post::class, 'store'])->name('obat.store');
        Route::get('/obat/{id}/edit', [Obat\Get::class, 'edit'])->name('obat.edit');
        Route::put('/obat/{id}', [Obat\Put::class, 'update'])->name('obat.update');
        Route::delete('/obat/{id}', [Obat\Delete::class, 'destroy'])->name('obat.delete');

        Route::get('/user', [User\Get::class, 'index'])->name('user.index');
        Route::get('/user/create', [User\Get::class, 'create'])->name('user.create');
        Route::post('/user', [User\Post::class, 'store'])->name('user.store');
        Route::get('/user/{id}/edit', [User\Get::class, 'edit'])->name('user.edit');
        Route::put('/user/{id}', [User\Put::class, 'update'])->name('user.update');
        Route::delete('/user/{id}', [User\Delete::class, 'destroy'])->name('user.delete');
    });
});
