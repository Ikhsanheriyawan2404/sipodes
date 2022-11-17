<?php

namespace App\Http\Controllers;

use App\Models\{Umkm, Gambar, Desa};
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\{UmkmStoreRequest, UmkmUpdateRequest};

class UmkmController extends Controller
{
    public function index()
    {
        return view('umkm.index', [
            'umkm' =>  Umkm::with('images')->get(),
        ]);
    }

    public function create()
    {
        return view('umkm.create');
    }

    public function show($id)
    {
        $umkm = Umkm::with('images')->find($id);
        return response()->json($umkm);
    }

    public function edit($id)
    {
        $umkm = Umkm::find($id);
        return view('umkm.edit', [
            'umkm' => $umkm,
        ]);
    }

    public function store(UmkmStoreRequest $request)
    {
        $request->validated();

        $params = [
            'name' => request('name'),
            'slug' => Str::slug(request('name')),
            'description' => request('description'),
            'location' => request('location'),
            'figure' => request('figure'),
            'contact' => request('contact'),
            'meta_description' => request('meta_description'),
            'meta_keyword' => request('meta_keyword'),
        ];

        $client = new \GuzzleHttp\Client();
        $url = env('PARENT_URL') . '/umkm';
        try {
            DB::transaction(function () use ($params, $url, $client) {
                $params['thumbnail'] = request()->file('thumbnail')->store('img/umkm');
                $umkm = umkm::create($params);
                $params['code_desa'] = Desa::first()->code;
                $params['umkm_id'] = $umkm->id;
                $client->post($url, ['headers' => ['X-Authorization' => env('API_KEY')], 'form_params' => $params]);
            });
        } catch(\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('umkm.index')->with('success', 'Data umkm berhasil dimasukkan!');
    }

    public function update(UmkmUpdateRequest $request, $id)
    {
        $umkm = umkm::find($id);
        $request->validated();

        $params = [
            'name' => request('name'),
            'description' => request('description'),
            'location' => request('location'),
            'price' => request('price'),
            'figure' => request('figure'),
            'contact' => request('contact'),
            'meta_description' => request('meta_description'),
            'meta_keyword' => request('meta_keyword'),
        ];

        if (request('thumbnail')) {
            // Jika ada request maka delete old img
            Storage::delete($umkm->thumbnail);
            $thumbnail = request()->file('thumbnail')->store('img/umkm');
        } else if ($umkm->thumbnail) {
            // jika tidak ada biarkan old thumbnail
            $thumbnail = $umkm->thumbnail;
        }

        $client = new \GuzzleHttp\Client();
        $url = env('PARENT_URL') . '/umkm/' . Desa::first()->code . '/' . $umkm->id;
        try {
            DB::transaction(function () use ($params, $url, $client, $thumbnail, $umkm) {
                $params['thumbnail'] = $thumbnail;
                $umkm->update($params);
                $params['code_desa'] = Desa::first()->code;
                $client->put($url, ['headers' => ['X-Authorization' => env('API_KEY')],'form_params' => $params]);
            });
        } catch(\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('umkm.index')->with('success', 'Data umkm berhasil dimasukkan!');
    }

    public function pageUpload($id)
    {
        $umkm = umkm::find($id);
        return view('umkm.upload', [
            'umkm' => $umkm,
        ]);
    }

    public function upload($id)
    {
        $umkm = umkm::find($id);
        request()->validate([
            'image' => 'required'
        ]);
        Gambar::create([
            'umkm_id' => $umkm->id,
            'image' => request()->file('image')->store('img/umkm'),
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
        $umkm = Umkm::find($id);

        $client = new \GuzzleHttp\Client();
        $url = env('PARENT_URL') . '/umkm/' . Desa::first()->code . '/' . $umkm->id;
        try {
            DB::transaction(function () use ($umkm, $url, $client) {
                foreach ($umkm->images as $data) {
                    Storage::delete($data->image);
                }
                $umkm->delete();
                Storage::delete($umkm->thumbnail);
                $client->delete($url, ['headers' => ['X-Authorization' => env('API_KEY')]]);
            });
        } catch(\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->back()->with('success', 'Data umkm berhasil dihapus');
    }
}
