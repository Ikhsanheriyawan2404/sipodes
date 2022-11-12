<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gambar extends Model
{
    use HasFactory;

    protected $table = 'gambar';
    protected $fillable = ['wisata_id', 'budaya_id', 'produksi_pangan_id', 'umkm_id', 'image'];
}
