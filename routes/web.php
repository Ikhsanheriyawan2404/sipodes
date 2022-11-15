<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{HomeController, DropdownController, WisataController, DesaController};
use App\Http\Controllers\Auth\LoginController;

Route::get('city', [DropdownController::class, 'city'])->name('dropdown.city');
Route::get('district', [DropdownController::class, 'district'])->name('dropdown.district');
Route::get('village', [DropdownController::class, 'village'])->name('dropdown.village');

Route::get('login', [LoginController::class, 'showLoginForm']);
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout',  [LoginController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('home', [HomeController::class, 'index'])->name('home');

    Route::get('desa', [DesaController::class, 'index'])->name('desa.index');
    Route::get('desa/create', [DesaController::class, 'create'])->name('desa.create');
    Route::post('desa', [DesaController::class, 'store'])->name('desa.store');

    // Wisata
    Route::resource('wisata', WisataController::class);
    Route::get('wisata/{wisata}/gambar', [WisataController::class, 'pageUpload'])->name('wisata.gambar');
    Route::post('wisata/{wisata}/gambar', [WisataController::class, 'upload'])->name('wisata.upload');
    Route::delete('wisata/{gambar}/gambar', [WisataController::class, 'deleteImage'])->name('wisata.deleteImage');
});


