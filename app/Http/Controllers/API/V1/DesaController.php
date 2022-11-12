<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Desa;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Laravolt\Indonesia\Models\Provinsi;

class DesaController extends Controller
{
    public function index()
    {
        return response()->json(Desa::with('desa', 'district', 'city')->get(), 200);
    }

    public function create()
    {
        return view('desa.create', [
            'provinsi' => Provinsi::get(),
        ]);
    }

    public function store()
    {
        try {
            DB::transaction(function () {

                $client = new \GuzzleHttp\Client();
                $url = env('PARENT_URL') . '/desa';

                $params = [
                   'code' => request('desa'),
                    'district_code' => request('kecamatan'),
                    'city_code' => request('kota'),
                ];
                Desa::create($params);

                $response = $client->post($url, ['form_params' => $params]);
                $response = $response->getBody()->getContents();
                return response()->json('yeafmaudk', 200);
            });

        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 400);
        }
    }
}
