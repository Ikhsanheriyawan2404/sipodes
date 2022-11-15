<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Umkm;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;

class UmkmController extends Controller
{
    public function index()
    {
        $umkm =  Umkm::with('images')->get();
        foreach ($umkm as $data) {
            $data->thumbnail = $data->imagePath;
            foreach($data->images as $item) {
                $item->image = $item->imagePath;
            }
        }
        return new ApiResource(200, true, 'List umkm', $umkm);
    }

    public function show($slug)
    {
        $umkm = Umkm::where('slug', $slug)->first();
        if (!$umkm) {
            return new ApiResource(404, true, 'Data tidak ditemukan');
        }
        $umkm->thumbnail = $umkm->imagePath;
        return new ApiResource(200, true, 'Detail Umkm', $umkm);
    }
}
