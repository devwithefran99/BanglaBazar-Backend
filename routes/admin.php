<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\HotDealController;

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
         ->name('backend.dashboard');


    Route::prefix('admin')->name('backend.')->group(function () {
        Route::resource('products', ProductController::class);
          Route::resource('hotdeals', HotDealController::class);
    });

});