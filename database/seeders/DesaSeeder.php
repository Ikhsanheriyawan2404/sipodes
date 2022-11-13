<?php

namespace Database\Seeders;

use App\Models\Desa;
use Faker\Factory;
use Illuminate\Database\Seeder;

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
        ]);
    }
}
