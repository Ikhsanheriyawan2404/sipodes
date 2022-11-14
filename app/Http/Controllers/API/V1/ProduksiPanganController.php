<?php

namespace App\Http\Controllers\API\V1;

use App\Models\ProduksiPangan;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
}
