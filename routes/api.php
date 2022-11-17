<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\{AuthController, DesaController, WisataController, BudayaController, GeneralController, ProduksiPanganController, UmkmController, GaleriController, SliderController};

Route::prefix('v1')->group(function () {

    // Authentication
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    // Count All Potensi
    Route::get('potensi/count', [GeneralController::class, 'count']);
    // Get List Potensi
    Route::get('wisata', [WisataController::class, 'index']);
    Route::get('wisata/{id}', [WisataController::class, 'show']);

    Route::get('budaya', [BudayaController::class, 'index']);
    Route::get('budaya/{id}', [BudayaController::class, 'show']);

    Route::get('umkm', [UmkmController::class, 'index']);
    Route::get('umkm/{id}', [UmkmController::class, 'show']);

    Route::get('produksi-pangan', [ProduksiPanganController::class, 'index']);
    Route::get('produksi-pangan/{id}', [ProduksiPanganController::class, 'show']);

    // Galeri & Slider
    Route::get('galeri', [GaleriController::class, 'index']);
    Route::post('galeri', [GaleriController::class, 'store']);
    Route::delete('galeri/{galeri}', [GaleriController::class, 'destroy']);
    Route::get('slider', [SliderController::class, 'index']);
    Route::post('slider', [SliderController::class, 'store']);
    Route::delete('slider/{slider}', [SliderController::class, 'destroy']);

    // Get Profile Desa
    Route::get('desa', [DesaController::class, 'index']);

    Route::middleware('auth:sanctum')->group(function () {

        // Store Desa
        Route::post('desa', [DesaController::class, 'store']);

        // Admin Crud Potensi
        Route::apiResource('wisata', WisataController::class)->except('index', 'show');
        Route::apiResource('budaya', BudayaController::class)->except('index', 'show');
        Route::apiResource('umkm', UmkmController::class)->except('index', 'show');
        Route::apiResource('produksi-pangan', ProduksiPanganController::class)->except('index', 'show');

        // Store Multi Image
        Route::post('wisata/{id}/image', [WisataController::class, 'upload']);
        Route::delete('wisata/{gambar}/image', [WisataController::class, 'deleteImage']);

        Route::post('umkm/{id}/image', [UmkmController::class, 'upload']);
        Route::delete('umkm/{gambar}/image', [UmkmController::class, 'deleteImage']);

        Route::post('budaya/{id}/image', [BudayaController::class, 'upload']);
        Route::delete('budaya/{gambar}/image', [BudayaController::class, 'deleteImage']);

        Route::post('produksi-pangan/{id}/image', [ProduksiPanganController::class, 'upload']);
        Route::delete('produksi-pangan/{gambar}/image', [ProduksiPanganController::class, 'deleteImage']);

        // Logout
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

