<?php

namespace App\Models;

use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gambar extends Model
{
    use HasFactory;

    protected $table = 'gambar';
    protected $fillable = ['wisata_id', 'budaya_id', 'produksi_pangan_id', 'umkm_id', 'image', 'alt'];
    protected $hidden = ['created_at', 'updated_at', 'wisata_id', 'budaya_id', 'produksi_pangan_id', 'umkm_id', 'id'];

    public function getImagePathAttribute()
    {
        return URL::to('/') . '/storage/' . $this->image;
    }
}
