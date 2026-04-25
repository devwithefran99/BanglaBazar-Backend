<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController; // ← Backend হবে

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
         ->name('dashboard');
});