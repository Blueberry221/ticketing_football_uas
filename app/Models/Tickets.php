<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'match_id',
        'seat_id',
        'status',
        'user_id',
        'booked_at',
        'payment_method',
    ];

    public function match()
    {
        return $this->belongsTo(Matches::class);
    }

    public function seat()
    {
        return $this->belongsTo(Seats::class);
    }

    public function user()
    {
        return $this->belongsTo(Users::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }
}
