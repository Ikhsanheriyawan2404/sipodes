<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{HomeController, UserController, DropdownController, WisataController, DesaController, GaleriController, SliderController};
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

    Route::resource('users', UserController::class);

    Route::get('desa', [DesaController::class, 'index'])->name('desa.index');
    Route::get('desa/create', [DesaController::class, 'create'])->name('desa.create');
    Route::post('desa', [DesaController::class, 'store'])->name('desa.store');
    Route::get('desa/edit', [DesaController::class, 'edit'])->name('desa.edit');
    Route::put('desa/edit', [DesaController::class, 'update'])->name('desa.update');

    // Galeri
    Route::get('galeri', [GaleriController::class, 'index'])->name('galeri.index');
    Route::post('galeri', [GaleriController::class, 'store'])->name('galeri.store');
    Route::delete('galeri/{id}', [GaleriController::class, 'destroy'])->name('galeri.destroy');
    // Slider
    Route::get('slider', [SliderController::class, 'index'])->name('slider.index');
    Route::post('slider', [SliderController::class, 'store'])->name('slider.store');
    Route::delete('slider/{id}', [SliderController::class, 'destroy'])->name('slider.destroy');

    // Wisata
    Route::resource('wisata', WisataController::class);
    Route::get('wisata/{wisata}/gambar', [WisataController::class, 'pageUpload'])->name('wisata.gambar');
    Route::post('wisata/{wisata}/gambar', [WisataController::class, 'upload'])->name('wisata.upload');
    Route::delete('wisata/{gambar}/gambar', [WisataController::class, 'deleteImage'])->name('wisata.deleteImage');
});


