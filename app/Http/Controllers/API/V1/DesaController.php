<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Desa;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Laravolt\Indonesia\Models\{Provinsi, City};
use App\Http\Resources\ApiResource;
use App\Http\Requests\DesaStoreRequest;

class DesaController extends Controller
{
    public function index()
    {
        $desa = Desa::with('desa', 'district', 'city')->first();
        $desa->logo = $desa->imagePath;
        return response()->json(new ApiResource(200, true, 'Data Desa', $desa), 200);
    }

    public function store(DesaStoreRequest $request)
    {
        $request->validated();
        $desa = Desa::first();
        if ($desa) {
            return response()->json(new ApiResource(400, true, 'Duplicate Entry'), 400);
        }
        try {
            DB::transaction(function () {
                $client = new \GuzzleHttp\Client();
                $url = env('PARENT_URL') . '/desa';
                $params = [
                    'code' => request('village_code'),
                    'district_code' => request('district_code'),
                    'city_code' => request('city_code'),
                    'url' => request('url'),
                    'description' => request('description'),
                    'logo' => request()->file('logo')->store('img/desa'),
                ];
                $data = Desa::create($params);
                $response = $client->post($url, ['headers' => ['X-Authorization' => '4eUUTcAPMbAlgsLSvRovpFBe4u7UAm8HNl69RJ8oiLNuGCRCiOg2DIJqEwMrn2NX'], 'form_params' => $params]);
                $response = $response->getBody()->getContents();
            });

        } catch (\Exception $e) {
            return response()->json(new ApiResource(400, true, $e->getMessage()), 400);
        }
        return response()->json(new ApiResource(201, true, 'Desa berhasil dimasukkan!'), 201);
    }
}
