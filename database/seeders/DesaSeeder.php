<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Desa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\URL;

class DesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker=Factory::create();
        Desa::create([
            'code' => '3209372007',
            'district_code' => '320937',
            'city_code' => '3209',
            'logo' => $faker->imageUrl(640, 480, 'gmabar', true, 'dsafsadf', true),
            'url' => URL::to('/'),
        ]);
    }
}
