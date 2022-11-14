<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Support\Facades\DB;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use App\Models\{Desa, Gambar, Wisata};
use App\Http\Requests\WisataStoreRequest;

class WisataController extends Controller
{
    public function index()
    {
        $wisata =  Wisata::with('images')->get();
        foreach ($wisata as $data) {
            $data->thumbnail = $data->imagePath;
        }
        return new ApiResource(200, true, 'List Wisata', $wisata);
    }

    public function store(WisataStoreRequest $request)
    {
        // Validation
        $request->validated();

        // Request Body
        $params = [
            'name' => request('name'),
            'description' => request('description'),
            'location' => request('location'),
            'price' => request('price'),
            'longtitude' => request('longtitude'),
            'latitude' => request('latitude'),
            'meta_description' => request('meta_description'),
            'meta_keyword' => request('meta_keyword'),
        ];

        // Set HTTP Client
        $client = new \GuzzleHttp\Client();
        // Url app parent
        $url = env('PARENT_URL') . '/wisata';

        try {
            DB::transaction(function () use ($params, $url, $client) {
                $params['thumbnail'] = request()->file('thumbnail')->store('img/wisata');
                $wisata = Wisata::create($params);
                $params['code_desa'] = Desa::first()->code;
                $params['wisata_id'] = $wisata->id;
                $client->post($url, ['form_params' => $params]);
            });
        } catch(\Exception $e) {
            return response()->json(new ApiResource(400, false, $e->getMessage()), 400);
        }

        return response()->json(new ApiResource(201, true, 'Data Wisata Berhasil Dimasukkan'), 201);
    }

    public function upload($id)
    {
        $wisata = Wisata::find($id);
        Gambar::create([
            'wisata_id' => $wisata->id,
            'image' => request()->file('image')->store('img/wisata'),
            'alt' => request('alt'),
        ]);
        return response()->json('berhasil memasukan photo', 200);
    }

    public function destroy($id)
    {
        $wisata = Wisata::find($id);
        if (!$wisata) {
            return response()->json(new ApiResource(404, false, 'Data Wisata Tidak Ditemukan'), 404);
        }

        $client = new \GuzzleHttp\Client();
        $url = env('PARENT_URL') . '/wisata/'. Desa::first()->code . '/' . $wisata->id;
        try {
            DB::transaction(function () use ($wisata, $client, $url) {
                $wisata->delete();
                $client->delete($url);
            });
            return response()->json(new ApiResource(200, true, 'Data Wisata Berhasil Dihapus'), 200);
        } catch (\Exception $e) {
            return response()->json(new ApiResource(400, false, $e->getMessage()), 400);
        }
    }
}
