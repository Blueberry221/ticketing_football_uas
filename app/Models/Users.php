<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Users extends Model
{
    use HasFactory,Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public $timestamps = false; 
    protected $hidden = [
        'password',
    ];
}
