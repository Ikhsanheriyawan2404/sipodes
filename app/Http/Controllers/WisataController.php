<?php

namespace App\Http\Controllers;

use App\Models\Gambar;
use App\Models\{Desa, Wisata};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\{WisataStoreRequest, WisataUpdateRequest};

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

        $client = new \GuzzleHttp\Client();
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
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('wisata.index')->with('success', 'Data wisata berhasil dimasukkan!');
    }

    public function show($id)
    {
        $wisata = Wisata::find($id);
        return response()->json($wisata);
    }

    public function edit($id)
    {
        $wisata = Wisata::find($id);
        return view('wisata.edit', [
            'wisata' => $wisata,
        ]);
    }

    public function update(WisataUpdateRequest $request, $id)
    {
        $wisata = Wisata::find($id);
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

        if (request('thumbnail')) {
            // Jika ada request maka delete old img
            Storage::delete($wisata->thumbnail);
            $thumbnail = request()->file('thumbnail')->store('img/thumbnail');
        } else if ($wisata->thumbnail) {
            // jika tidak ada biarkan old thumbnail
            $thumbnail = $wisata->thumbnail;
        }

        $client = new \GuzzleHttp\Client();
        $url = env('PARENT_URL') . '/wisata/' . Desa::first()->code . '/' . $wisata->id;
        try {
            DB::transaction(function () use ($params, $url, $client, $thumbnail, $wisata) {
                $params['thumbnail'] = $thumbnail;
                $wisata->update($params);
                $params['code_desa'] = Desa::first()->code;
                $client->put($url, ['form_params' => $params]);
            });
        } catch(\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('wisata.index')->with('success', 'Data wisata berhasil dimasukkan!');
    }

    public function pageUpload($id)
    {
        $wisata = Wisata::find($id);
        return view('wisata.upload', [
            'wisata' => $wisata,
        ]);
    }

    public function upload($id)
    {
        $wisata = Wisata::find($id);
        request()->validate([
            'image' => 'required'
        ]);
        Gambar::create([
            'wisata_id' => $wisata->id,
            'image' => request()->file('image')->store('img/wisata'),
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
        $wisata = Wisata::find($id);

        $client = new \GuzzleHttp\Client();
        $url = env('PARENT_URL') . '/wisata/' . Desa::first()->code . '/' . $wisata->id;
        try {
            DB::transaction(function () use ($wisata, $url, $client) {
                $wisata->delete();
                Storage::delete($wisata->image);
                $client->delete($url);
            });
        } catch(\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->back()->with('success', 'Data wisata berhasil dihapus');
    }
}
