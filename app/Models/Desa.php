<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;

class Desa extends Model
{
    use HasFactory;

    protected $table = 'desa';
    protected $fillable = ['code', 'description', 'district_code', 'city_code', 'url', 'logo'];
    protected $hidden = ['created_at', 'updated_at'];

    public function getImagePathAttribute()
    {
        return URL::to('/') . '/storage/' . $this->logo;
    }

    public function getImageStrukutAttribute()
    {
        return URL::to('/') . '/storage/' . $this->struktur;
    }

    public function desa()
    {
        return $this->hasOne(Village::class, 'code', 'code');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_code', 'code');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_code', 'code');
    }
}
