<?php

namespace App\Models;

use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'alt'];

    public function getImagePathAttribute()
    {
        return URL::to('/') . '/storage/' . $this->image;
    }
}
