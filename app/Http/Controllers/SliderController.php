<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        return view('slider.index', [
            'slider' => Slider::get(),
        ]);
    }

    public function store()
    {
        request()->validate([
            'alt' => 'required|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:1028',
        ]);

        Slider::create([
            'alt' => request('alt'),
            'image' => request()->file('image')->store('img/slider'),
        ]);

        return redirect()->route('slider.index')->with('success', 'Slider berhasil dimasukkan!');
    }

    public function destroy($id)
    {
        $slider = Slider::find($id);
        Storage::delete($slider->image);
        $slider->delete();
        return redirect()->route('slider.index')->with('success', 'Slider berhasil dihapus!');
    }
}
