<?php

namespace App\Models;

use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'meta_description', 'meta_keyword', 'thumbnail', 'location', 'description', 'contact'];
    protected $table = 'umkm';
    protected $hidden = ['updated_at'];
    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
    ];

    public function getImagePathAttribute()
    {
        return URL::to('/') . '/storage/' . $this->thumbnail;
    }

    public function images()
    {
        return $this->hasMany(Gambar::class, 'umkm_id');
    }
}
