<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    protected $table = 'teams';

    protected $fillable = [
        'nama_tim',
        'kota',
    ];

    // Relasi ke pertandingan sebagai tim tuan rumah
    public function homeMatches(): HasMany
    {
        return $this->hasMany(MatchModel::class, 'home_team_id');
    }

    // Relasi ke pertandingan sebagai tim tamu
    public function awayMatches(): HasMany
    {
        return $this->hasMany(MatchModel::class, 'away_team_id');
    }
}
