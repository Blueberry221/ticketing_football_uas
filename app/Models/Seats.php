<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seats extends Model
{
    use HasFactory;

    protected $primaryKey = 'id'; 

    protected $fillable = [
        'area_id', 
        'number',
        'status'
    ];

    public function area()
    {
        return $this->belongsTo(Areas::class);
    }

    public function ticket()
    {
        return $this->hasOne(Tickets::class);
    }
}
