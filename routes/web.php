<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreasController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\SeatsController;
use App\Http\Controllers\MatchesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TicketsController;


Route::get('/', function () {
    return view('welcome');
})->name('home');

// Resource Routes - Kompatibel 100% dengan Controller Anda
Route::resource('areas', AreasController::class);
Route::resource('teams', TeamsController::class);
Route::resource('seats', SeatsController::class);
Route::resource('matches', MatchesController::class);
Route::resource('users', UsersController::class);
Route::resource('tickets', TicketsController::class);