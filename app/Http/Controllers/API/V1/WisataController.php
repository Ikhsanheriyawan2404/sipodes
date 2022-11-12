<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Desa;
use App\Models\Wisata;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class WisataController extends Controller
{
    public function create()
    {
        return view('wisata.create');
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
        // $response = Http::post($url, [
        //     'name' => request('name'),
        //     'description' => request('description'),
        //     'location' => request('location'),
        //     'price' => request('price'),
        //     'contact' => request('contact'),
        // ]);

        return response()->json($response, 200);
    }

    public function storeWisata()
    {
        request()->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        Wisata::create([
            'title' => request('title'),
            'description' => request('description'),
        ]);

        return redirect()->route('wisata.create');
    }
}
