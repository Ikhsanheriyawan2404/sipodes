<?php

namespace App\Http\Controllers;

use Laravolt\Indonesia\Models\{Provinsi, City};
use App\Http\Requests\DesaStoreRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Desa;

class DesaController extends Controller
{
    public function index()
    {
        return view('desa.index', [
            'desa' => Desa::first(),
        ]);
    }
    public function create()
    {
        $desa = Desa::first();
        if ($desa) {
            abort(403, 'Data has ready registered!');
        }
        return view('desa.create', [
            'provinsi' => Provinsi::where('code', '32')->first(),
            'kota' => City::where('province_code', '32')->get()
        ]);
    }

    public function store(DesaStoreRequest $request)
    {
        dd(request()->all());
        $desa = Desa::first();
        if ($desa) {
            abort(403, 'Data has ready registered!');
        }
        $request->validated();
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
                $response = $client->post($url, ['form_params' => $params]);
                $response = $response->getBody()->getContents();
            });
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->route('home')->with('success', 'Data desa berhasil dimasukkan!');
    }
}
