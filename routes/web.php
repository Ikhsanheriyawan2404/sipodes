<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WisataController;
use App\Http\Controllers\DropdownController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\API\V1\DesaController;

Route::get('kota', [DropdownController::class, 'kota'])->name('dropdown.kota');
Route::get('kecamatan', [DropdownController::class, 'kecamatan'])->name('dropdown.kecamatan');
Route::get('desa', [DropdownController::class, 'desa'])->name('dropdown.desa');

Route::get('login', [LoginController::class, 'showLoginForm']);
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout',  [LoginController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('home', [HomeController::class, 'index'])->name('home');

    Route::get('villages', [DesaController::class, 'index'])->name('desa.index');
    Route::get('villages/create', [DesaController::class, 'create'])->name('desa.create');
    Route::post('villages', [DesaController::class, 'store'])->name('desa.store');

    // Wisata
    Route::resource('wisata', WisataController::class);
    Route::get('wisata/{wisata}/gambar', [WisataController::class, 'pageUpload'])->name('wisata.gambar');
    Route::post('wisata/{wisata}/gambar', [WisataController::class, 'upload'])->name('wisata.upload');
    Route::delete('wisata/{gambar}/gambar', [WisataController::class, 'deleteImage'])->name('wisata.deleteImage');
});


