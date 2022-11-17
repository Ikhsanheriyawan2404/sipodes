<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Slider;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $slider = Slider::latest()->get();
        foreach ($slider as $data) {
            $data->image = $data->imagePath;
        }
        return new ApiResource(200, true, 'Data Slider', $slider);
    }

    public function store()
    {
        request()->validate([
            'alt' => 'required|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:1028',
        ]);

        $data = Slider::create([
            'alt' => request('alt'),
            'image' => request()->file('image')->store('img/slider'),
        ]);

        return new ApiResource(200, true, 'Berhasil menambahkan slider', $data);
    }

    public function destroy(Slider $slider)
    {
        if (!$slider) {
            return new ApiResource(404, false, 'Data tidak ditemukan');
        }
        Storage::delete($slider->image);
        $slider->delete();
        return new ApiResource(200, true, 'Berhasil menghapus slider');
    }
}
