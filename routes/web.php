<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreasController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\SeatsController;
use App\Http\Controllers\MatchesController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TicketsController;
use App\Models\Order;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::resource('areas', AreasController::class);
Route::resource('teams', TeamsController::class);
Route::resource('seats', SeatsController::class);
Route::resource('matches', MatchesController::class);
Route::resource('users', UsersController::class);
Route::resource('tickets', TicketsController::class);

Route::get('/order', [OrderController::class, 'index'])->name('order.index');
Route::post('/order/checkout', [OrderController::class, 'order'])->name('order.checkout');
Route::post('/midtrans-callback', [OrderController::class, 'callback']);
