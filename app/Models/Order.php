<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'total_price',
        'status',
        'payment_method',
    ];

    /**
     * Relasi: Order dimiliki oleh satu User
     */
    public function user()
    {
        return $this->belongsTo(Users::class);
    }

    /**
     * Relasi: Order memiliki banyak Ticket
     */
    public function tickets()
    {
        return $this->hasMany(Tickets::class);
    }
}
