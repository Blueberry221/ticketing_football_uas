<?php

use App\Http\Controllers\MatchesController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/schedule', function () {
        return view('schedule');
    })->name('schedule');

    Route::get('/tickets', function () {
        return view('tickets');
    })->name('tickets');
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets');
    Route::get('/ticket', [TicketController::class, 'index'])->name('ticket');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/order', [OrderController::class, 'index'])->name('order.index');
Route::post('/order/checkout', [OrderController::class, 'order'])->name('order.checkout');
Route::post('/midtrans-callback', [OrderController::class, 'callback']);

require __DIR__ . '/auth.php';
