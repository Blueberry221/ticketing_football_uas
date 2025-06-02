<?php

namespace Database\Seeders;

use App\Models\Areas;
use App\Models\Seats;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Ambil semua area dulu
        $areas = Areas::all();


    }
}
