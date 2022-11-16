<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index()
    {
        return view('galeri.index', [
            'galeri' => Galeri::get(),
        ]);
    }

    public function store()
    {
        request()->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:1028',
        ]);

        Galeri::create([
            'title' => request('title'),
            'description' => request('description'),
            'image' => request()->file('image')->store('img/galeri'),
        ]);
        return redirect()->route('galeri.index')->with('success', 'Galeri berhasil dimasukkan!');
    }

    public function destroy($id)
    {
        $galeri = Galeri::find($id);
        Storage::delete($galeri->image);
        $galeri->delete();
        return redirect()->route('galeri.index')->with('success', 'Galeri berhasil dihapus!');
    }
}
