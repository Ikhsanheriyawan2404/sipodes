<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Wisata extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'meta_description', 'meta_keyword', 'thumbnail', 'location', 'price', 'description', 'latitude', 'longtitude', 'contact', 'schedule'];
    protected $table = 'wisata';
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
        return $this->hasMany(Gambar::class, 'wisata_id');
    }
}
