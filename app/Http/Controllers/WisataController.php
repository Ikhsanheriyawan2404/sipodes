<?php

namespace App\Http\Controllers;

use App\Http\Requests\WisataStoreRequest;
use App\Models\Wisata;
use Illuminate\Http\Request;

class WisataController extends Controller
{
    public function index()
    {
        return view('wisata.index', [
            'wisata' =>  Wisata::with('images')->get(),
        ]);
    }

    public function create()
    {
        return view('wisata.create');
    }

    public function store(WisataStoreRequest $request)
    {
        $request->validated();

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

        $params['thumbnail'] = request()->file('thumbnail')->store('img/wisata');
        Wisata::create($params);

        $client = new \GuzzleHttp\Client();
        $url = env('PARENT_URL') . '/wisata';

        $response = $client->post($url, ['headers' => ['Accept', 'application/json']], ['form_params' => $params]);
        $response = $response->getBody()->getContents();

        return redirect()->route('wisata.index');
    }
}
