<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use App\Models\{Desa, Gambar, Wisata};
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\{WisataStoreRequest, WisataUpdateRequest};

class WisataController extends Controller
{
    public function index()
    {
        $query = request('name');
        $limit = request('limit');
        $wisata =  Wisata::limit($limit)->with('images')->where("name", "like", "%$query%")->latest()->get();
        foreach ($wisata as $data) {
            $data->thumbnail = $data->imagePath;
            foreach($data->images as $item) {
                $item->image = $item->imagePath;
            }
        }
        return new ApiResource(200, true, 'List Wisata', $wisata);
    }

    public function show($slug)
    {
        $wisata = Wisata::with('images')->where('slug', $slug)->first();
        if (!$wisata) {
            return new ApiResource(404, true, 'Data tidak ditemukan');
        }
        $wisata->thumbnail = $wisata->imagePath;
        return new ApiResource(200, true, 'Detail Wisata', $wisata);
    }

    public function store(WisataStoreRequest $request)
    {
        // Validation
        $request->validated();

        // Request Body
        $params = [
            'name' => request('name'),
            'slug' => Str::slug(request('name')),
            'description' => request('description'),
            'location' => request('location'),
            'price' => request('price'),
            'contact' => request('contact'),
            'schedule' => request('schedule'),
            'longtitude' => request('longtitude'),
            'latitude' => request('latitude'),
            'meta_description' => request('meta_description'),
            'meta_keyword' => request('meta_keyword'),
        ];

        // Set HTTP Client
        $client = new \GuzzleHttp\Client();
        // Endpoint app parent
        $url = env('PARENT_URL') . '/wisata';

        try {
            DB::transaction(function () use ($params, $url, $client) {
                $params['thumbnail'] = request()->file('thumbnail')->store('img/wisata');
                $wisata = Wisata::create($params);
                $params['code_desa'] = Desa::first()->code;
                $params['wisata_id'] = $wisata->id;
                $client->post($url, ['headers' => ['X-Authorization' => env('API_KEY')],'form_params' => $params]);
            });
        } catch(\Exception $e) {
            return response()->json(new ApiResource(400, false, $e->getMessage()), 400);
        }

        return response()->json(new ApiResource(201, true, 'Data Wisata Berhasil Dibuat'), 201);
    }

    public function upload($id)
    {
        request()->validate([
            'image' => 'required',
        ]);
        $wisata = Wisata::find($id);
        if (!$wisata) {
            return new ApiResource(404, true, 'Data tidak ditemukan');
        }
        Gambar::create([
            'wisata_id' => $wisata->id,
            'image' => request()->file('image')->store('img/wisata'),
            'alt' => request('alt'),
        ]);
        return response()->json(new ApiResource(200, true, 'Data Gambar Wisata Berhasil Ditambahkan'), 200);
    }

    public function deleteImage(Gambar $gambar)
    {
        $gambar->delete();
        Storage::delete($gambar->image);
        return response()->json(new ApiResource(200, true, 'Data Gambar Wisata Berhasil Dihapus'), 200);
    }

    public function update(WisataUpdateRequest $request, $id)
    {
        $request->validated();
        $wisata = Wisata::find($id);
        if (!$wisata) {
            return new ApiResource(404, true, 'Data tidak ditemukan');
        }
        $params = [
            'name' => request('name'),
            'description' => request('description'),
            'location' => request('location'),
            'price' => request('price'),
            'contact' => request('contact'),
            'schedule' => request('schedule'),
            'longtitude' => request('longtitude'),
            'latitude' => request('latitude'),
            'meta_description' => request('meta_description'),
            'meta_keyword' => request('meta_keyword'),
        ];

        if (request('thumbnail')) {
            Storage::delete($wisata->thumbnail);
            $thumbnail = request()->file('thumbnail')->store('img/wisata');
        } else if ($wisata->thumbnail) {
            $thumbnail = $wisata->thumbnail;
        }

        $client = new \GuzzleHttp\Client();
        $url = env('PARENT_URL') . '/wisata/' . Desa::first()->code . '/' . $wisata->id;

        try {
            DB::transaction(function () use ($params, $url, $client, $thumbnail, $wisata) {
                $params['thumbnail'] = $thumbnail;
                $wisata->update($params);
                $params['code_desa'] = Desa::first()->code;
                $params['wisata_id'] = $wisata->id;
                $client->put($url, ['headers' => ['X-Authorization' => env('API_KEY')],'form_params' => $params]);
            });
        } catch(\Exception $e) {
            return response()->json(new ApiResource(400, false, $e->getMessage()), 400);
        }

        return response()->json(new ApiResource(200, true, 'Data Wisata Berhasil Diupdate'), 200);
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
                foreach ($wisata->images as $data) {
                    Storage::delete($data->image);
                }
                $wisata->delete();
                $client->delete($url, ['headers' => ['X-Authorization' => env('API_KEY')]]);
                Storage::delete($wisata->thumbnail);
            });
        } catch (\Exception $e) {
            return response()->json(new ApiResource(400, false, $e->getMessage()), 400);
        }
        return response()->json(new ApiResource(200, true, 'Data Wisata Berhasil Dihapus'), 200);
    }
}
