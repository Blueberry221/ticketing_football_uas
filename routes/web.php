<?php

use App\Http\Controllers\MatchesController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketsController;
use App\Models\Matches;
use App\Models\Seats;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Route::get('/dashboard', function () {
    //     $matches = Matches::with(['homeTeam', 'awayTeam'])->get(); // Pastikan relasinya benar
    //     return view('dashboard', compact('matches'));
    // })->name('dashboard');

    // Route::get('/schedule', function () {
    //     return view('schedule');
    // })->name('schedule');

    Route::get('/schedule', function () {
        $matches = Matches::with(['homeTeam', 'awayTeam'])->get();
        return view('schedule', compact('matches'));
    })->name('schedule');


    Route::get('/tickets', function () {
        $matches = Matches::with(['homeTeam', 'awayTeam'])->get();
        $seats = Seats::with(['area'])->get();
        return view('tickets.index', compact(['matches', 'seats']));
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
