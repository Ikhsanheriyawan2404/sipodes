<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\Gambar;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProduksiPangan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PanganStoreRequest;
use App\Http\Requests\PanganUpdateRequest;

class ProduksiPanganController extends Controller
{
    public function index()
    {
        return view('produksi-pangan.index', [
            'produksi-pangan' =>  ProduksiPangan::with('images')->get(),
        ]);
    }

    public function create()
    {
        return view('produksi-pangan.create');
    }

    public function show($id)
    {
        $produksiPangan = ProduksiPangan::with('images')->find($id);
        return response()->json($produksiPangan);
    }

    public function edit($id)
    {
        $produksiPangan = ProduksiPangan::find($id);
        return view('produksi-pangan.edit', [
            'produksiPangan' => $produksiPangan,
        ]);
    }

    public function store(PanganStoreRequest $request)
    {
        $request->validated();

        $params = [
            'name' => request('name'),
            'slug' => Str::slug(request('name')),
            'location' => request('location'),
            'contact' => request('contact'),
            'description' => request('description'),
            'meta_description' => request('meta_description'),
            'meta_keyword' => request('meta_keyword'),
        ];

        $client = new \GuzzleHttp\Client();
        $url = env('PARENT_URL') . '/produksi-pangan';
        try {
            DB::transaction(function () use ($params, $url, $client) {
                $params['thumbnail'] = request()->file('thumbnail')->store('img/produksi-pangan');
                $produksiPangan = ProduksiPangan::create($params);
                $params['code_desa'] = Desa::first()->code;
                $params['produksi_pangan_id'] = $produksiPangan->id;
                $client->post($url, ['headers' => ['X-Authorization' => env('API_KEY')], 'form_params' => $params]);
            });
        } catch(\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('produksi-pangan.index')->with('success', 'Data produksi pangan berhasil dimasukkan!');
    }

    public function update(PanganUpdateRequest $request, $id)
    {
        $produksiPangan = ProduksiPangan::find($id);
        $request->validated();

        $params = [
            'name' => request('name'),
            'location' => request('location'),
            'contact' => request('contact'),
            'description' => request('description'),
            'meta_description' => request('meta_description'),
            'meta_keyword' => request('meta_keyword'),
        ];

        if (request('thumbnail')) {
            // Jika ada request maka delete old img
            Storage::delete($produksiPangan->thumbnail);
            $thumbnail = request()->file('thumbnail')->store('img/produksi-pangan');
        } else if ($produksiPangan->thumbnail) {
            // jika tidak ada biarkan old thumbnail
            $thumbnail = $produksiPangan->thumbnail;
        }

        $client = new \GuzzleHttp\Client();
        $url = env('PARENT_URL') . '/produksi-pangan/' . Desa::first()->code . '/' . $produksiPangan->id;
        try {
            DB::transaction(function () use ($params, $url, $client, $thumbnail, $produksiPangan) {
                $params['thumbnail'] = $thumbnail;
                $produksiPangan->update($params);
                $params['code_desa'] = Desa::first()->code;
                $client->put($url, ['headers' => ['X-Authorization' => env('API_KEY')],'form_params' => $params]);
            });
        } catch(\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('produksi-pangan.index')->with('success', 'Data produksi pangan berhasil dimasukkan!');
    }

    public function pageUpload($id)
    {
        $produksiPangan = ProduksiPangan::find($id);
        return view('produksi-pangan.upload', [
            'produksi-pangan' => $produksiPangan,
        ]);
    }

    public function upload($id)
    {
        $produksiPangan = ProduksiPangan::find($id);
        request()->validate([
            'image' => 'required'
        ]);
        Gambar::create([
            'produksi_pangan_id' => $produksiPangan->id,
            'image' => request()->file('image')->store('img/produksi-pangan'),
            'alt' => request('alt'),
        ]);
        return redirect()->back()->with('success', 'Gambar baru berhasil ditambahkan');
    }

    public function deleteImage(Gambar $gambar)
    {
        $gambar->delete();
        Storage::delete($gambar->image);
        return redirect()->back()->with('success', 'Gambar berhasil dihapus');
    }

    public function destroy($id)
    {
        $produksiPangan = ProduksiPangan::find($id);

        $client = new \GuzzleHttp\Client();
        $url = env('PARENT_URL') . '/produksi-pangan/' . Desa::first()->code . '/' . $produksiPangan->id;
        try {
            DB::transaction(function () use ($produksiPangan, $url, $client) {
                foreach ($produksiPangan->images as $data) {
                    Storage::delete($data->image);
                }
                $produksiPangan->delete();
                Storage::delete($produksiPangan->thumbnail);
                $client->delete($url, ['headers' => ['X-Authorization' => env('API_KEY')]]);
            });
        } catch(\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->back()->with('success', 'Data produksi pangan berhasil dihapus');
    }
}
