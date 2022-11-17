<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Galeri;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index()
    {
        $galeri = Galeri::latest()->get();
        foreach ($galeri as $data) {
            $data->image = $data->imagePath;
        }
        return new ApiResource(200, true, 'Data Galeri', $galeri);
    }

    public function store()
    {
        request()->validate([
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:1028',
        ]);

        $data = Galeri::create([
            'title' => request('title'),
            'description' => request('description'),
            'image' => request()->file('image')->store('img/galeri'),
        ]);

        return new ApiResource(200, true, 'Berhasil menambahkan slider', $data);
    }

    public function destroy(Galeri $galeri)
    {
        if (!$galeri) {
            return new ApiResource(404, false, 'Data tidak ditemukan');
        }
        Storage::delete($galeri->image);
        $galeri->delete();
        return new ApiResource(200, true, 'Berhasil menghapus galeri');
    }
}
