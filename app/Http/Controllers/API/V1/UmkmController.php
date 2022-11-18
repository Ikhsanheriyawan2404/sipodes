<?php

namespace App\Http\Controllers\API\V1;

use App\Models\{Desa, Gambar, Umkm};
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\{UmkmUpdateRequest, UmkmStoreRequest};

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
            'type_umkm'     =>request('type_umkm'),
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

    public function upload($id)
    {
        request()->validate([
            'image'=> 'required'
        ]);

        $umkm = Umkm::find($id);
        if(!$umkm){
            return new ApiResource(404, true, 'Data tidak ditemukan');
        }
        Gambar::create([
            'umkm_id' => $umkm->id,
            'image' => request()->file('image')->store('img/umkm'),
            'alt' => request('alt')
        ]);
        return response()->json(new ApiResource(200, true, 'Data Gambar Umkm Berhasil Ditambahkan'), 200);
    }

    public function deleteImage(Gambar $gambar)
    {
        $gambar->delete();
        Storage::delete($gambar->image);
        return response()->json(new ApiResource(200, true,'Data Gambar Umkm Berhasil Dihapus'), 200);
    }

    public function update(UmkmUpdateRequest $request, $id)
    {
        $request->validated();
        $umkm = Umkm::find($id);
        if(!$umkm){
            return new ApiResource(404, true, 'Data tidak ditemukan');
        }
        $params = [
            'name' => request('name'),
            'location'=> request('location'),
            'contact'=> request('contact'),
            'description' => request('description'),
            'type_umkm'     =>request('type_umkm'),
            'meta_description' => request('meta_description'),
            'meta_keyword' => request('meta_keyword'),
        ];

        if(request('thumbnail'))
        {
            Storage::delete($umkm->thumbnail);
            $thumbnail = request()->file('thumbnail')->store('img/umkm');
        } else if ($umkm->thumbnail) {
            $thumbnail = $umkm->thumbnail;
        }

        $client = new \GuzzleHttp\Client();
        $url = env ('PARENT_URL') . '/umkm/' . Desa::first()->code . '/' . $umkm->id;

        try {
            DB::transaction(function () use ($params, $client, $url, $thumbnail, $umkm) {
                $params['thumbnail'] = $thumbnail;
                $umkm->update($params);
                $params['code_desa'] = Desa::first()->code;
                $params['umkm_id'] = $umkm->id;
                $client->put($url, ['headers' => ['X-Authorization' => env('API_KEY')],'form_params' => $params]);
            });
        } catch (\Exception $e) {
            return response()->json(new ApiResource(400, false, $e->getMessage()), 400);
        }
        return response()->json(new ApiResource(200,true, 'Data Umkm Berhasil Diupdate'), 200);
    }

    public function destroy($id)
    {
        $umkm = Umkm::find($id);
        if(!$umkm) {
            return response()->json(new ApiResource(404, false, 'Data Umkm Tidak Ditemukan'), 404);
        }

        $client = new \GuzzleHttp\Client();
        $url = env('PARENT_URL') . '/umkm/' . Desa::first()->code . '/' . $umkm->id;

        try{
            DB::transaction(function () use ($umkm, $client, $url) {
                foreach ($umkm->images as $data){
                    Storage::delete($data->image);
                }

                $umkm->delete();
                $client->delete($url, ['headers' => ['X-Authorization' => env('API_KEY')]]);
                Storage::delete($umkm->thumbnail);
            });
        } catch (\Exception $e) {
            return response()->json(new ApiResource(400, false, $e->getMessage()), 400);
        }
        return response()->json(new ApiResource(200, true, 'Data Umkm Berhasil Dihapus'), 200);
    }
}
