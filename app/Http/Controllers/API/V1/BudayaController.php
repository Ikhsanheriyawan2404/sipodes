<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Budaya;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;

class BudayaController extends Controller
{
    public function index()
    {
        $budaya =  Budaya::with('images')->get();
        foreach ($budaya as $data) {
            $data->thumbnail = $data->imagePath;
            foreach($data->images as $item) {
                $item->image = $item->imagePath;
            }
        }
        return new ApiResource(200, true, 'List Budaya', $budaya);
    }

    public function show($slug)
    {
        $budaya = Budaya::where('slug', $slug)->first();
        if (!$budaya) {
            return new ApiResource(404, true, 'Data tidak ditemukan');
        }
        $budaya->thumbnail = $budaya->imagePath;
        return new ApiResource(200, true, 'Detail Budaya', $budaya);
    }
}
