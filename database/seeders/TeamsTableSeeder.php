<?php

namespace Database\Seeders;

use App\Models\Teams;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Teams::create([
            'name' => 'Kumpulan Pria Menawan FC',
            'logo' => 'KPM_FC.png',
            'city' => 'Jakarta',
        ]);

        Teams::create([
            'name' => 'Paingan FC',
            'logo' => 'Paingan_FC.png',
            'city' => 'Sleman',
        ]);

        Teams::create([
            'name' => 'Sore FC',
            'logo' => 'Sore_FC.png',
            'city' => 'Surabaya',
        ]);
    }
}
