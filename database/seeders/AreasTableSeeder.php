<?php

namespace Database\Seeders;

use App\Models\Areas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Areas::create([
            'placement' => 'timur',
            'status' => 'VIP',
            'price' => 200_000.00,
        ]);

        Areas::create([
            'placement' => 'timur',
            'status' => 'Regular',
            'price' => 100_000.00,
        ]);

        Areas::create([
            'placement' => 'selatan',
            'status' => 'VIP',
            'price' => 140_000.00,
        ]);

        Areas::create([
            'placement' => 'selatan',
            'status' => 'Regular',
            'price' => 70_000.00,
        ]);

        Areas::create([
            'placement' => 'barat',
            'status' => 'VIP',
            'price' => 160_000.00,
        ]);

        Areas::create([
            'placement' => 'barat',
            'status' => 'Regular',
            'price' => 80_000.00,
        ]);

        Areas::create([
            'placement' => 'utara',
            'status' => 'VIP',
            'price' => 155_000.00,
        ]);

        Areas::create([
            'placement' => 'utara',
            'status' => 'Regular',
            'price' => 77_000.00,
        ]);
    }
}
