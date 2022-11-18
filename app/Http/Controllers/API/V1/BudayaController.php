<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Desa;
use App\Models\Budaya;
use App\Models\Gambar;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\BudayaStoreRequest;
use App\Http\Requests\BudayaUpdateRequest;

class BudayaController extends Controller
{
    public function index()
    {
        $budaya =  Budaya::with('images')->get();
        foreach ($budaya as $data) {
            $data->thumbnail = $data->imagePath;
            foreach($data->images as $item) {
                $item->image = $item->imagePath;
            }
        }
        return new ApiResource(200, true, 'List Budaya', $budaya);
    }

    public function show($slug)
    {
        $budaya = Budaya::where('slug', $slug)->first();
        if (!$budaya) {
            return new ApiResource(404, true, 'Data tidak ditemukan');
        }
        $budaya->thumbnail = $budaya->imagePath;
        return new ApiResource(200, true, 'Detail Budaya', $budaya);
    }

    public function store(BudayaStoreRequest $request)
    {
        //validation
        $request->validated();

        //Request Body
        $params = [
            'name'          => request('name'),
            'slug'          => Str::slug(request('name')),
            'location'      =>request('location'),
            'figure'        => request('figure'),
            'contact'       =>request('contact'),
            'description'   =>request('description'),
            'meta_description' => request('meta_description'),
            'meta_keyword' => request('meta_keyword'),
            'type_budaya' => request('type_budaya'),
        ];

        //Set HTTP Client
        $client = new \GuzzleHttp\Client();
        //URL App parent
        $url = env('PARENT_URL') . '/budaya';

        try{
            DB::transaction(function () use ($params, $client, $url) {
                $params['thumbnail'] = request()->file('thumbnail')->store('img/budaya');
                $budaya = Budaya::create($params);
                $params['code_desa'] = Desa::first()->code;
                $params['budaya_id'] = $budaya->id;
                $client->post($url, ['headers' => ['X-Authorization' => env('API_KEY')], 'form_params' => $params]);
            });
        } catch (\Exception $e) {
            return response()->json(new ApiResource(400, false, $e->getMessage()), 400);
        }

        return response()->json(new ApiResource(201, true, 'Data Budaya Berhasil Dibuat'), 201);
    }

    public function upload($id)
    {
        request()->validate([
            'image'=> 'required'
        ]);

        $budaya = Budaya::find($id);
        if(!$budaya){
            return new ApiResource(404, true, 'Data tidak ditemukan');
        }
        Gambar::create([
            'budaya_id' => $budaya->id,
            'image' => request()->file('image')->store('img/budaya'),
            'alt' => request('alt')
        ]);
        return response()->json(new ApiResource(200, true, 'Data Gambar Budaya Berhasil Ditambahkan'), 200);
    }

    public function deleteImage(Gambar $gambar)
    {
        $gambar->delete();
        Storage::delete($gambar->image);
        return response()->json(new ApiResource(200, true,'Data Gambar Budaya Berhasil Dihapus'), 200);
    }

    public function update(BudayaUpdateRequest $request, $id)
    {
        $request->validated();
        $budaya = Budaya::find($id);
        if(!$budaya){
            return new ApiResource(404, true, 'Data tidak ditemukan');
        }
        $params = [
            'name' => request('name'),
            'location'=> request('location'),
            'figure' => request('figure'),
            'contact'=> request('contact'),
            'description' => request('description'),
            'meta_description' => request('meta_description'),
            'meta_keyword' => request('meta_keyword'),
            'type_budaya' => request('type_budaya'),
        ];

        if(request('thumbnail'))
        {
            Storage::delete($budaya->thumbnail);
            $thumbnail = request()->file('thumbnail')->store('img/budaya');
        } else if ($budaya->thumbnail) {
            $thumbnail = $budaya->thumbnail;
        }

        $client = new \GuzzleHttp\Client();
        $url = env ('PARENT_URL') . '/budaya/' . Desa::first()->code . '/' . $thumbnail->id;

        try {
            DB::transaction(function () use ($params, $client, $url, $thumbnail, $budaya) {
                $params['thumbnail'] = $thumbnail;
                $budaya->update($params);
                $params['code_desa'] = Desa::first()->code;
                $params['budaya_id'] = $budaya->id;
                $client->put($url, ['headers' => ['X-Authorization' => env('API_KEY')],'form_params' => $params]);
            });
        } catch (\Exception $e) {
            return response()->json(new ApiResource(400, false, $e->getMessage()), 400);
        }
        return response()->json(new ApiResource(200,true, 'Data Budaya Berhasil Diupdate'), 200);
    }

    public function destroy($id)
    {
        $budaya = Budaya::find($id);
        if(!$budaya) {
            return response()->json(new ApiResource(404, false, 'Data Budaya Tidak Ditemukan'), 404);
        }

        $client = new \GuzzleHttp\Client();
        $url = env('PARENT_URL') . '/budaya/' . Desa::first()->code . '/' . $budaya->id;

        try{
            DB::transaction(function () use ($budaya, $client, $url) {
                foreach ($budaya->images as $data){
                    Storage::delete($data->image);
                }

                $budaya->delete();
                $client->delete($url, ['headers' => ['X-Authorization' => env('API_KEY')]]);
                Storage::delete($budaya->thumbnail);
            });
        } catch (\Exception $e) {
            return response()->json(new ApiResource(400, false, $e->getMessage()), 400);
        }
        return response()->json(new ApiResource(200, true, 'Data Budaya Berhasil Dihapus'), 200);
    }
}
