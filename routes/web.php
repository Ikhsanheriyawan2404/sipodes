<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\{HomeController,BudayaController, UserController, DropdownController, WisataController, DesaController, GaleriController, SliderController, UmkmController, ProduksiPanganController};

Route::get('city', [DropdownController::class, 'city'])->name('dropdown.city');
Route::get('district', [DropdownController::class, 'district'])->name('dropdown.district');
Route::get('village', [DropdownController::class, 'village'])->name('dropdown.village');

Route::get('login', [LoginController::class, 'showLoginForm']);
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout',  [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::resource('users', UserController::class);

    Route::get('desa', [DesaController::class, 'index'])->name('desa.index');
    Route::get('desa/create', [DesaController::class, 'create'])->name('desa.create');
    Route::post('desa', [DesaController::class, 'store'])->name('desa.store');
    Route::get('desa/edit', [DesaController::class, 'edit'])->name('desa.edit');
    Route::put('desa/edit', [DesaController::class, 'update'])->name('desa.update');
    Route::get('desa/{id}', [DesaController::class, 'show'])->name('desa.show');

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

    // Budaya
    Route::resource('budaya', BudayaController::class);
    Route::get('budaya/{budaya}/gambar', [BudayaController::class, 'pageUpload'])->name('budaya.gambar');
    Route::post('budaya/{budaya}/gambar', [BudayaController::class, 'upload'])->name('budaya.upload');
    Route::delete('budaya/{gambar}/gambar', [BudayaController::class, 'deleteImage'])->name('budaya.deleteImage');

    // Umkm
    Route::resource('umkm', UmkmController::class);
    Route::get('umkm/{umkm}/gambar', [UmkmController::class, 'pageUpload'])->name('umkm.gambar');
    Route::post('umkm/{umkm}/gambar', [UmkmController::class, 'upload'])->name('umkm.upload');
    Route::delete('umkm/{gambar}/gambar', [UmkmController::class, 'deleteImage'])->name('umkm.deleteImage');

    // Produksi Pangan
    Route::resource('produksi-pangan', ProduksiPanganController::class);
    Route::get('produksi-pangan/{produksi_pangan}/gambar', [ProduksiPanganController::class, 'pageUpload'])->name('produksi-pangan.gambar');
    Route::post('produksi-pangan/{produksi_pangan}/gambar', [ProduksiPanganController::class, 'upload'])->name('produksi-pangan.upload');
    Route::delete('produksi-pangan/{gambar}/gambar', [ProduksiPanganController::class, 'deleteImage'])->name('produksi-pangan.deleteImage');
});


