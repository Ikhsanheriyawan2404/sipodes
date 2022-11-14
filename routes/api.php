<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\API\V1\{AuthController, DesaController, WisataController, BudayaController, ProduksiPanganController, UmkmController};

Route::prefix('v1')->group(function () {

    // Get List Potensi
    Route::get('wisata', [WisataController::class, 'index']);
    Route::get('wisata/{id}', [WisataController::class, 'show']);

    Route::get('budaya', [BudayaController::class, 'index']);
    Route::get('budaya/{id}', [BudayaController::class, 'show']);

    Route::get('umkm', [UmkmController::class, 'index']);
    Route::get('umkm/{id}', [UmkmController::class, 'show']);

    Route::get('produksi-pangan', [ProduksiPanganController::class, 'index']);
    Route::get('produksi-pangan/{id}', [ProduksiPanganController::class, 'show']);

    // Authentication
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    
    Route::middleware('auth:sanctum')->group(function () {
        
        // Store Desa
        Route::get('desa', [DesaController::class, 'index']);
        Route::post('desa', [DesaController::class, 'store']);

        // Admin Crud Potensi
        Route::apiResource('wisata', WisataController::class)->except('index', 'show');
        Route::apiResource('budaya', WisataController::class)->except('index', 'show');
        Route::apiResource('umkm', WisataController::class)->except('index', 'show');
        Route::apiResource('produksi-pangan', WisataController::class)->except('index', 'show');

        // Store Multi Image
        Route::post('wisata/{id}/image', [WisataController::class, 'upload']);
        Route::post('budaya/{id}/image', [BudayaController::class, 'upload']);
        Route::post('umkm/{id}/image', [UmkmController::class, 'upload']);
        Route::post('produksi-pangan/wisata/{id}/image', [ProduksiPanganController::class, 'upload']);

        // Logout
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

