<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Areas extends Model
{
    use HasFactory;

    protected $fillable = [
        'placement',
        'status',
        'price'
    ];

    public function seats()
    {
        return $this->hasMany(Seats::class);
    }
}
