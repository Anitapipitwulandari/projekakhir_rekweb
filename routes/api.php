<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MakulController;

Route::prefix('mahasiswa')->group(function () {
    Route::post('/create', [MahasiswaController::class, 'store']);
    Route::get('/read', [MahasiswaController::class, 'index']);
    Route::put('/update/{id}', [MahasiswaController::class, 'update']);
    Route::delete('/delete/{id}', [MahasiswaController::class, 'destroy']);
});

Route::prefix('dosen')->group(function () {
    Route::post('/create', [DosenController::class, 'store']);
    Route::get('/read', [DosenController::class, 'index']);
    Route::put('/update/{id}', [DosenController::class, 'update']);
    Route::delete('/delete/{id}', [DosenController::class, 'destroy']);
});

Route::prefix('makul')->group(function () {
    Route::post('/create', [MakulController::class, 'store']);
    Route::get('/read', [MakulController::class, 'index']);
    Route::put('/update/{id}', [MakulController::class, 'update']);
    Route::delete('/delete/{id}', [MakulController::class, 'destroy']);
});



