<?php

namespace App\Models;

use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Budaya extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'meta_description', 'meta_keyword', 'thumbnail', 'location', 'description'];
    protected $table = 'budaya';
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
        return $this->hasMany(Gambar::class, 'budaya_id');
    }
}
