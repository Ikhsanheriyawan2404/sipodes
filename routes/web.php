<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DropdownController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\API\V1\DesaController;
use App\Http\Controllers\API\V1\WisataController;

Route::get('kota', [DropdownController::class, 'kota'])->name('dropdown.kota');
Route::get('kecamatan', [DropdownController::class, 'kecamatan'])->name('dropdown.kecamatan');
Route::get('desa', [DropdownController::class, 'desa'])->name('dropdown.desa');

Route::get('login', [LoginController::class, 'showLoginForm']);
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout',  [LoginController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return view('welcome');
});

Route::get('home', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('villages', [DesaController::class, 'index'])->name('desa.index');
    Route::get('villages/create', [DesaController::class, 'create'])->name('desa.create');
    Route::post('villages', [DesaController::class, 'store'])->name('desa.store');

    Route::get('wisata/create', [WisataController::class, 'create'])->name('wisata.create');
    Route::post('wisata', [WisataController::class, 'storeWisata'])->name('wisata.store');
});


