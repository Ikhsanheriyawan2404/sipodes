<?php

namespace App\Http\Controllers;

use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\Village;
use Laravolt\Indonesia\Models\District;

class DropdownController extends Controller
{
    public function kota()
    {
        $provinceId = request('provinceId');
        $kota = [];
        if (request()->has('q')) {
            $search = request('q');
            $kota = City::where('name', 'LIKE', "%$search%")->where('province_code', $provinceId)->get();
        } else {
            $kota = City::where('province_code', $provinceId)->get();
        }
        return response()->json($kota);
    }

    public function kecamatan()
    {
        $kotaId = request('kotaId');
        $kecamatan = [];
        if (request()->has('q')) {
            $search = request('q');
            $kecamatan = District::where('name', 'LIKE', "%$search%")->where('city_code', $kotaId)->get();
        } else {
            $kecamatan = District::where('city_code', $kotaId)->get();
        }
        return response()->json($kecamatan);
    }

    public function desa()
    {
        $kecamatanId = request('kecamatanId');
        $desa = [];
        if (request()->has('q')) {
            $search = request('q');
            $desa = Village::where('name', 'LIKE', "%$search%")->where('district_code', $kecamatanId)->get();
        } else {
            $desa = Village::where('district_code', $kecamatanId)->get();
        }
        return response()->json($desa);
    }
}
