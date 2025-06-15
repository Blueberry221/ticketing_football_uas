<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::post('/midtrans-callback', [OrderController::class, 'callback']);