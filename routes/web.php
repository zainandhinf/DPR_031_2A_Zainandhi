<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\KomponenGajiController;
use App\Http\Controllers\PenggajianController;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::resource('anggotas', AnggotaController::class);

    Route::middleware('role:admin')->group(function () {
        Route::resource('penggunas', PenggunaController::class);
        Route::resource('komponen_gajis', KomponenGajiController::class);
        Route::get('/penggajians/create', [PenggajianController::class, 'create'])->name('penggajians.create');
        Route::post('penggajians', [PenggajianController::class, 'store'])->name('penggajians.store');
        Route::get('/penggajians/{id_anggota}/{id_komponen_gaji}/edit', [PenggajianController::class, 'edit'])->name('penggajians.edit');
        Route::put('/penggajians/{id_anggota}/{id_komponen_gaji}', [PenggajianController::class, 'update'])->name('penggajians.update');
        Route::delete('/penggajians/{id_anggota}/{id_komponen_gaji}', [PenggajianController::class, 'destroy'])->name('penggajians.destroy');
    });

    Route::get('penggajians', [PenggajianController::class, 'index'])->name('penggajians.index');
    Route::get('/penggajians/get-komponen/{id_anggota}', [PenggajianController::class, 'getKomponen']);
    Route::get('/penggajians/{id_anggota}', [PenggajianController::class, 'show'])->name('penggajians.show');
});
