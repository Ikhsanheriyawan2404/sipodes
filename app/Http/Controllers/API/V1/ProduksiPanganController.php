<?php

namespace App\Http\Controllers\API\V1;

use App\Models\ProduksiPangan;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;

class ProduksiPanganController extends Controller
{
    public function index()
    {
        $produksiPangan =  ProduksiPangan::with('images')->get();
        foreach ($produksiPangan as $data) {
            $data->thumbnail = $data->imagePath;
        }
        return new ApiResource(200, true, 'List Produksi Pangan', $produksiPangan);
    }

    public function show($slug)
    {
        $produksiPangan = ProduksiPangan::where('slug', $slug)->first();
        if (!$produksiPangan) {
            return new ApiResource(404, true, 'Data tidak ditemukan');
        }
        $produksiPangan->thumbnail = $produksiPangan->imagePath;
        return new ApiResource(200, true, 'Detail Produksi Pangan', $produksiPangan);
    }
}
