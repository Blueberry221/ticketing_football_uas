<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Admin routes - hanya bisa diakses oleh admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard.main');
    
    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
    
    // Order Management
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}', [AdminController::class, 'showOrder'])->name('orders.show');
    Route::put('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.update-status');
    
    // Match Management
    Route::get('/matches', [AdminController::class, 'matches'])->name('matches');
    Route::get('/matches/create', [AdminController::class, 'createMatch'])->name('matches.create');
    Route::post('/matches', [AdminController::class, 'storeMatch'])->name('matches.store');
    Route::get('/matches/{match}/edit', [AdminController::class, 'editMatch'])->name('matches.edit');
    Route::put('/matches/{match}', [AdminController::class, 'updateMatch'])->name('matches.update');
    Route::delete('/matches/{match}', [AdminController::class, 'deleteMatch'])->name('matches.delete');
    
    // Team Management
    Route::get('/teams', [AdminController::class, 'teams'])->name('teams');
    Route::get('/teams/create', [AdminController::class, 'createTeam'])->name('teams.create');
    Route::post('/teams', [AdminController::class, 'storeTeam'])->name('teams.store');
    Route::get('/teams/{team}/edit', [AdminController::class, 'editTeam'])->name('teams.edit');
    Route::put('/teams/{team}', [AdminController::class, 'updateTeam'])->name('teams.update');
    Route::delete('/teams/{team}', [AdminController::class, 'deleteTeam'])->name('teams.delete');
    
    // Area Management
    Route::get('/areas', [AdminController::class, 'areas'])->name('areas');
    Route::get('/areas/create', [AdminController::class, 'createArea'])->name('areas.create');
    Route::post('/areas', [AdminController::class, 'storeArea'])->name('areas.store');
    Route::get('/areas/{area}/edit', [AdminController::class, 'editArea'])->name('areas.edit');
    Route::put('/areas/{area}', [AdminController::class, 'updateArea'])->name('areas.update');
    Route::delete('/areas/{area}', [AdminController::class, 'deleteArea'])->name('areas.delete');
    
    // Reports & Analytics
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    
    // Settings
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
});