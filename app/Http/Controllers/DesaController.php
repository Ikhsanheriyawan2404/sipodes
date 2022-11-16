<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\DesaStoreRequest;
use Illuminate\Support\Facades\Storage;
use Laravolt\Indonesia\Models\{Provinsi, City};

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
        $ikshan;
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
                $response = $client->post($url, ['headers' => ['X-Authorization' => env('API_KEY')],'form_params' => $params]);
                $response = $response->getBody()->getContents();
            });

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->route('desa.index')->with('success', 'Data desa berhasil dimasukkan!');
    }

    public function edit()
    {
        return view('desa.edit', [
            'desa' => Desa::first(),
        ]);
    }

    public function update()
    {
        request()->validate([
            'url' => 'required|max:255',
            'logo' => 'image|mimes:jpeg,jpg,png|max:1028',
        ]);

        $desa = Desa::first();
        if (request('logo')) {
            // Jika ada request maka delete old img
            Storage::delete($desa->logo);
            $logo = request()->file('logo')->store('img/desa');
        } else if ($desa->logo) {
            // jika tidak ada biarkan old logo
            $logo = $desa->logo;
        }
        try {
            DB::transaction(function () use ($desa, $logo) {
                $client = new \GuzzleHttp\Client();
                $url = env('PARENT_URL') . '/desa/' . $desa->code;
                $params = [
                    'url' => request('url'),
                    'description' => request('description'),
                    'logo' => $logo,
                ];
                $desa->update($params);
                $response = $client->put($url, ['headers' => ['X-Authorization' => env('API_KEY')],'form_params' => $params]);
                $response = $response->getBody()->getContents();
            });

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->route('home')->with('success', 'Data desa berhasil dimasukkan!');
    }
}
