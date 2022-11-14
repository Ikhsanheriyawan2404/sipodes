<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Budaya;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BudayaController extends Controller
{
    public function index()
    {
        $budaya =  Budaya::with('images')->get();
        foreach ($budaya as $data) {
            $data->thumbnail = $data->imagePath;
        }
        return new ApiResource(200, true, 'List Budaya', $budaya);
    }
}
