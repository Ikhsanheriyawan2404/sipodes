<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Umkm;
use Illuminate\Support\Str;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\UmkmStoreRequest;

use function PHPSTORM_META\registerArgumentsSet;

class UmkmController extends Controller
{
    public function index()
    {
        $umkm =  Umkm::with('images')->get();
        foreach ($umkm as $data) {
            $data->thumbnail = $data->imagePath;
            foreach($data->images as $item) {
                $item->image = $item->imagePath;
            }
        }
        return new ApiResource(200, true, 'List umkm', $umkm);
    }

    public function show($slug)
    {
        $umkm = Umkm::where('slug', $slug)->first();
        if (!$umkm) {
            return new ApiResource(404, true, 'Data tidak ditemukan');
        }
        $umkm->thumbnail = $umkm->imagePath;
        return new ApiResource(200, true, 'Detail Umkm', $umkm);
    }

    public function store(UmkmStoreRequest $request)
    {
        //validation
        $request->validated();

        //Request Body
        $params = [
            'name'          => request('name'),
            'slug'          => Str::slug(request('name')),
            'location'      =>request('location'),
            'contact'       =>request('contact'),
            'description'   =>request('description'),
            'meta_description' => request('meta_description'),
            'meta_keyword' => request('meta_keyword'),
        ];

        //Set HTTP Client
        $client = new \GuzzleHttp\Client();
        //URL App parent
        $url = env('PARENT_URL') . '/umkm';

        try{
            DB::transaction(function () use ($params, $client, $url) {
                $params['thumbnail'] = request()->file('thumbnail')->store('img/umkm');
                $umkm = Umkm::create($params);
                $params['code_desa'] = Desa::first()->code;
                $params['umkm_id'] = $umkm->id;
                $client->post($url, ['headers' => ['X-Authorization' => env('API_KEY')], 'form_params' => $params]);
            });
        } catch (\Exception $e) {
            return response()->json(new ApiResource(400, false, $e->getMessage()), 400);
        }

        return response()->json(new ApiResource(201, true, 'Data Umkm Berhasil Dibuat'), 201);
    }
}
