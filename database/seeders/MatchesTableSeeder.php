<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Matches;
use App\Models\Teams;

class MatchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $jakarta = Teams::where('name', 'Kumpulan Pria Menawan FC')->first();
        $sleman = Teams::where('name', 'Paingan FC')->first();
        $surabaya = Teams::where('name', 'Sore FC')->first();

        // Pertandingan 1
        Matches::create([
            'home_team_id' => $jakarta->id,
            'away_team_id' => $sleman->id,
            'match_date'   => '2025-06-15 18:00:00',
            'status'       => 'upcoming',
        ]);

        // Pertandingan 2
        Matches::create([
            'home_team_id' => $surabaya->id,
            'away_team_id' => $jakarta->id,
            'match_date'   => '2025-06-18 19:00:00',
            'status'       => 'upcoming',
        ]);

        // Pertandingan 3
        Matches::create([
            'home_team_id' => $sleman->id,
            'away_team_id' => $surabaya->id,
            'match_date'   => '2025-06-20 20:00:00',
            'status'       => 'upcoming',
        ]);
    }
}
