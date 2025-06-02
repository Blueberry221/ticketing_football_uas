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
            'name' => 'Jakarta Tigers',
            'logo' => 'jakarta_tigers.png',
            'city' => 'Jakarta',
        ]);

        Teams::create([
            'name' => 'Bandung Wolves',
            'logo' => 'bandung_wolves.png',
            'city' => 'Bandung',
        ]);

        Teams::create([
            'name' => 'Surabaya Sharks',
            'logo' => 'surabaya_sharks.png',
            'city' => 'Surabaya',
        ]);
    }
}
