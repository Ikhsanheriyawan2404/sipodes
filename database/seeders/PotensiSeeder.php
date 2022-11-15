<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Umkm;
use App\Models\Budaya;
use App\Models\Wisata;
use Illuminate\Support\Str;
use App\Models\ProduksiPangan;
use Illuminate\Database\Seeder;

class PotensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id-ID');
        $name = 'Wisata Curug Ciguntur';
        Wisata::create([
            'name' => $name,
            'slug' => Str::slug($name),
            'location' => 'jl merak no 25',
            'meta_description' => $faker->sentence,
            'meta_keyword' => $faker->name,
            'longtitude' => '-6.6897378',
            'latitude' => '108.4127686',
            'price' => 14000,
            'description' => $faker->paragraph(),
            'thumbnail' => 'img/default',
        ]);

        $name = 'Tari Jaipong';
        Budaya::create([
            'name' => $name,
            'location' => 'lsfdsaf',
            'slug' => Str::slug($name),
            'meta_description' => $faker->sentence,
            'meta_keyword' => $faker->name,
            'contact' => 'Pak sutisno',
            'description' => $faker->paragraph(),
            'thumbnail' => 'img/default',
        ]);

        $name = 'Produksi Rumahan HandiCraft';
        Umkm::create([
            'name' => $name,
            'slug' => Str::slug($name),
            'location' => 'jl merak no 25',
            'contact' => '082121212',
            'meta_description' => $faker->sentence,
            'meta_keyword' => $faker->name,
            'description' => $faker->paragraph(),
            'thumbnail' => 'img/default',
        ]);

        $name = 'Tanaman Jagung Pak Kudis';
        ProduksiPangan::create([
            'name' => $name,
            'slug' => Str::slug($name),
            'location' => 'jl bifsdaof fisdaifsd',
            'contact' => '082121212',
            'meta_description' => $faker->sentence,
            'meta_keyword' => $faker->name,
            'description' => $faker->paragraph(),
            'thumbnail' => 'img/default',
        ]);
    }
}
