<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\KomponenGajiController;

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
        Route::resource('komponengajis', KomponenGajiController::class);
    });
});
