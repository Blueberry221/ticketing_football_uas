<?php

namespace Database\Seeders;

use App\Models\Areas;
use App\Models\Seats;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Area;
use App\Models\Seat;

class SeatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $areas = Areas::all();

        foreach ($areas as $area) {
            $totalSeats = $area->status === 'VIP' ? 10 : 20;

            for ($i = 1; $i <= $totalSeats; $i++) {
                Seats::create([
                    'area_id' => $area->id,
                    'number' => strtoupper(substr($area->placement, 0, 1)) . $area->id . '-' . $i,
                    'status' => 'available',
                ]);
            }
        }
    }
}
