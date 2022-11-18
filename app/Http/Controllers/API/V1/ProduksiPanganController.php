<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Desa;
use App\Models\Gambar;
use Illuminate\Support\Str;
use App\Models\ProduksiPangan;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PanganStoreRequest;
use App\Http\Requests\PanganUpdateRequest;

class ProduksiPanganController extends Controller
{
    public function index()
    {
        $produksiPangan =  ProduksiPangan::with('images')->get();
        foreach ($produksiPangan as $data) {
            $data->thumbnail = $data->imagePath;
            foreach($data->images as $item) {
                $item->image = $item->imagePath;
            }
        }
        return new ApiResource(200, true, 'List Produksi Pangan', $produksiPangan);
    }

    public function show($slug)
    {
        $produksiPangan = ProduksiPangan::where('slug', $slug)->first();
        if (!$produksiPangan) {
            return new ApiResource(404, true, 'Data tidak ditemukan');
        }
        $produksiPangan->thumbnail = $produksiPangan->imagePath;
        return new ApiResource(200, true, 'Detail Produksi Pangan', $produksiPangan);
    }

    public function store(PanganStoreRequest $request)
    {
        // Validation
        $request->validated();

        // Request Body
        $params = [
            'name' => request('name'),
            'slug' => Str::slug(request('name')),
            'location' => request('location'),
            'contact' => request('contact'),
            'type_produksi_pangan'  => request('type_produksi_pangan'),
            'description' => request('description'),
            'meta_description' => request('meta_description'),
            'meta_keyword' => request('meta_keyword'),
        ];

        // Set HTTP Client
        $client = new \GuzzleHttp\Client();
        // Url app parent
        $url = env('PARENT_URL') . '/produksi-pangan';

        try {
            DB::transaction(function () use ($params, $url, $client) {
                $params['thumbnail'] = request()->file('thumbnail')->store('img/produksi-pangan');
                $produksiPangan = ProduksiPangan::create($params);
                $params['code_desa'] = Desa::first()->code;
                $params['produksi_pangan_id'] = $produksiPangan->id;
                $client->post($url, ['headers' => ['X-Authorization' => env('API_KEY')],'form_params' => $params]);
            });
        } catch(\Exception $e) {
            return response()->json(new ApiResource(400, false, $e->getMessage()), 400);
        }

        return response()->json(new ApiResource(201, true, 'Data Produksi Pangan Berhasil Dibuat'), 201);
    }

    public function upload($id)
    {
        request()->validate([
            'image' => 'required',
        ]);
        $produksiPangan = ProduksiPangan::find($id);
        if (!$produksiPangan) {
            return new ApiResource(404, true, 'Data tidak ditemukan');
        }
        Gambar::create([
            'produksi_pangan_id' => $produksiPangan->id,
            'image' => request()->file('image')->store('img/produksi-pangan'),
            'alt' => request('alt'),
        ]);
        return response()->json(new ApiResource(200, true, 'Data Gambar Produksi Pangan Berhasil Ditambahkan'), 200);
    }

    public function deleteImage(Gambar $gambar)
    {
        $gambar->delete();
        Storage::delete($gambar->image);
        return response()->json(new ApiResource(200, true, 'Data Gambar Produksi Pangan Berhasil Dihapus'), 200);
    }

    public function update(PanganUpdateRequest $request, $id)
    {
        $request->validated();
        $produksiPangan = ProduksiPangan::find($id);
        if (!$produksiPangan) {
            return new ApiResource(404, true, 'Data tidak ditemukan');
        }
        $params = [

            'name' => request('name'),
            'slug' => Str::slug(request('name')),
            'location' => request('location'),
            'contact' => request('contact'),
            'type_produksi_pangan'  => request('type_produksi_pangan'),
            'description' => request('description'),
            'meta_description' => request('meta_description'),
            'meta_keyword' => request('meta_keyword'),
        ];

        if (request('thumbnail')) {
            Storage::delete($produksiPangan->thumbnail);
            $thumbnail = request()->file('thumbnail')->store('img/produksi-pangan');
        } else if ($produksiPangan->thumbnail) {
            $thumbnail = $produksiPangan->thumbnail;
        }

        $client = new \GuzzleHttp\Client();
        $url = env('PARENT_URL') . '/produksi-pangan/' . Desa::first()->code . '/' . $produksiPangan->id;

        try {
            DB::transaction(function () use ($params, $url, $client, $thumbnail, $produksiPangan) {
                $params['thumbnail'] = $thumbnail;
                $produksiPangan->update($params);
                $params['code_desa'] = Desa::first()->code;
                $params['produksi_pangan_id'] = $produksiPangan->id;
                $client->put($url, ['headers' => ['X-Authorization' => env('API_KEY')],'form_params' => $params]);
            });
        } catch(\Exception $e) {
            return response()->json(new ApiResource(400, false, $e->getMessage()), 400);
        }

        return response()->json(new ApiResource(200, true, 'Data Produksi Pangan Berhasil Diupdate'), 200);
    }

    public function destroy($id)
    {
        $produksiPangan = ProduksiPangan::find($id);
        if (!$produksiPangan) {
            return response()->json(new ApiResource(404, false, 'Data Produksi Pangan Tidak Ditemukan'), 404);
        }

        $client = new \GuzzleHttp\Client();
        $url = env('PARENT_URL') . '/produksi-pangan/'. Desa::first()->code . '/' . $produksiPangan->id;
        try {
            DB::transaction(function () use ($produksiPangan, $client, $url) {
                foreach ($produksiPangan->images as $data) {
                    Storage::delete($data->image);
                }
                $produksiPangan->delete();
                $client->delete($url, ['headers' => ['X-Authorization' => env('API_KEY')]]);
                Storage::delete($produksiPangan->thumbnail);
            });
        } catch (\Exception $e) {
            return response()->json(new ApiResource(400, false, $e->getMessage()), 400);
        }
        return response()->json(new ApiResource(200, true, 'Data Produksi Pangan Berhasil Dihapus'), 200);
    }

}
