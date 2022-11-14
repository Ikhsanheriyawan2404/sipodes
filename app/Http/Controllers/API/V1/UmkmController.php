<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Umkm;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UmkmController extends Controller
{
    public function index()
    {
        $umkm =  Umkm::with('images')->get();
        foreach ($umkm as $data) {
            $data->thumbnail = $data->imagePath;
        }
        return new ApiResource(200, true, 'List umkm', $umkm);
    }
}
