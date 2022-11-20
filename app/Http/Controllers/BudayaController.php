<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\{Desa, Budaya, Gambar};
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\{BudayaStoreRequest, BudayaUpdateRequest};

class BudayaController extends Controller
{
    public function index()
{
        return view('budaya.index', [
            'budaya' =>  Budaya::with('images')->get(),
        ]);
    }

    public function create()
    {
        return view('budaya.create');
    }

    public function show($id)
    {
        $budaya = Budaya::with('images')->find($id);
        return response()->json($budaya);
    }

    public function edit($id)
    {
        $budaya = Budaya::find($id);
        return view('budaya.edit', [
            'budaya' => $budaya,
        ]);
    }

    public function store(BudayaStoreRequest $request)
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
            'type_budaya' => request('type_budaya'),
        ];

        $client = new \GuzzleHttp\Client();
        $url = env('PARENT_URL') . '/budaya';
        try {
            DB::transaction(function () use ($params, $url, $client) {
                $params['thumbnail'] = request()->file('thumbnail')->store('img/budaya');
                $budaya = Budaya::create($params);
                $params['code_desa'] = Desa::first()->code;
                $params['budaya_id'] = $budaya->id;
                $client->post($url, ['headers' => ['X-Authorization' => env('API_KEY')], 'form_params' => $params]);
            });
        } catch(\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('budaya.index')->with('success', 'Data budaya berhasil dimasukkan!');
    }

    public function update(BudayaUpdateRequest $request, $id)
    {
        $budaya = Budaya::find($id);
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
            'type_budaya' => request('type_budaya'),
        ];

        if (request('thumbnail')) {
            // Jika ada request maka delete old img
            Storage::delete($budaya->thumbnail);
            $thumbnail = request()->file('thumbnail')->store('img/budaya');
        } else if ($budaya->thumbnail) {
            // jika tidak ada biarkan old thumbnail
            $thumbnail = $budaya->thumbnail;
        }

        $client = new \GuzzleHttp\Client();
        $url = env('PARENT_URL') . '/budaya/' . Desa::first()->code . '/' . $budaya->id;
        try {
            DB::transaction(function () use ($params, $url, $client, $thumbnail, $budaya) {
                $params['thumbnail'] = $thumbnail;
                $budaya->update($params);
                $params['code_desa'] = Desa::first()->code;
                $client->put($url, ['headers' => ['X-Authorization' => env('API_KEY')],'form_params' => $params]);
            });
        } catch(\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('budaya.index')->with('success', 'Data budaya berhasil dimasukkan!');
    }

    public function pageUpload($id)
    {
        $budaya = Budaya::find($id);
        return view('budaya.upload', [
            'budaya' => $budaya,
        ]);
    }

    public function upload($id)
    {
        $budaya = Budaya::find($id);
        request()->validate([
            'image' => 'required'
        ]);
        Gambar::create([
            'budaya_id' => $budaya->id,
            'image' => request()->file('image')->store('img/budaya'),
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
        $budaya = Budaya::find($id);

        $client = new \GuzzleHttp\Client();
        $url = env('PARENT_URL') . '/budaya/' . Desa::first()->code . '/' . $budaya->id;
        try {
            DB::transaction(function () use ($budaya, $url, $client) {
                foreach ($budaya->images as $data) {
                    Storage::delete($data->image);
                }
                $budaya->delete();
                Storage::delete($budaya->thumbnail);
                $client->delete($url, ['headers' => ['X-Authorization' => env('API_KEY')]]);
            });
        } catch(\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->back()->with('success', 'Data budaya berhasil dihapus');
    }
}
