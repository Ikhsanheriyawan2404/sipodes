<?php

namespace App\Http\Controllers\API\V1;

use App\Models\{Desa, Gambar, Wisata};
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;

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

    public function store()
    {
        request()->validate([
            'name' => 'required',
            'description' => 'required',
            'location' => 'required',
            'price' => 'required',
            'contact' => 'required',
            'thumbnail' => 'required',
        ]);

        $params = [
            'name' => request('name'),
            'description' => request('description'),
            'location' => request('location'),
            'price' => request('price'),
            'contact' => request('contact'),
            'thumbnail' => request()->file('thumbnail')->store('img/wisata'),
        ];

        $data = Wisata::create($params);

        $client = new \GuzzleHttp\Client();
        $url = env('PARENT_URL') . '/wisata';

        $form_params = [
            'name' => $data->name,
            'description' => $data->description,
            'location' => $data->location,
            'price' => $data->price,
            'contact' => $data->contact,
            // 'thumbnail' => $data->thumbnail,
            'code_desa' => Desa::find(1)->code,
        ];
        $response = $client->post($url, ['form_params' => $form_params]);
        $response = $response->getBody()->getContents();

        return response()->json($response, 200);
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
}
