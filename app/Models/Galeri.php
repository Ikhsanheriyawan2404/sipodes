<?php

namespace App\Models;

use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Galeri extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'title', 'description'];
    protected $table = 'galeri';
    protected $hidden = ['created_at', 'updated_at'];

    public function getImagePathAttribute()
    {
        return URL::to('/') . '/storage/' . $this->image;
    }
}
