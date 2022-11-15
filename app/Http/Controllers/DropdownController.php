<?php

namespace App\Http\Controllers;

use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\Village;
use Laravolt\Indonesia\Models\District;

class DropdownController extends Controller
{
    // public function city()
    // {
    //     $provinceId = request('provinceId');
    //     $kota = [];
    //     if (request()->has('q')) {
    //         $search = request('q');
    //         $kota = City::where('name', 'LIKE', "%$search%")->where('province_code', $provinceId)->get();
    //     } else {
    //         $kota = City::where('province_code', $provinceId)->get();
    //     }
    //     return response()->json($kota);
    // }

    public function district()
    {
        $city_code = request('city_codeId');
        $kecamatan = [];
        if (request()->has('q')) {
            $search = request('q');
            $kecamatan = District::where('name', 'LIKE', "%$search%")->where('city_code', $city_code)->get();
        } else {
            $kecamatan = District::where('city_code', $city_code)->get();
        }
        return response()->json($kecamatan);
    }

    public function village()
    {
        $district_code = request('district_codeId');
        $desa = [];
        if (request()->has('q')) {
            $search = request('q');
            $desa = Village::where('name', 'LIKE', "%$search%")->where('district_code', $district_code)->get();
        } else {
            $desa = Village::where('district_code', $district_code)->get();
        }
        return response()->json($desa);
    }
}
