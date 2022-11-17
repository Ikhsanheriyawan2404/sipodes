<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\{ProduksiPangan, Umkm, Wisata, Budaya};

class GeneralController extends Controller
{
    public function count()
    {
        $data = [
            'total_wisata' => Wisata::count(),
            'total_budaya' => Budaya::count(),
            'total_umkm' => Umkm::count(),
            'total_produksi_pangan' => ProduksiPangan::count(),
        ];
        return response()->json(new ApiResource(200, true, 'Jumlah Seluruh Potensi', $data),200);
    }
}
