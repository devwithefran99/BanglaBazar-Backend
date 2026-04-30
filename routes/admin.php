<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\HotDealController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\AdminAuthController;

// ── Admin Login (guest only) ─────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',  [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
});

// ── Admin Logout ─────────────────────────────
Route::post('/admin-logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// ── Admin Protected Routes ───────────────────
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
         ->name('backend.dashboard');

    Route::prefix('admin')->name('backend.')->group(function () {
        Route::resource('products', ProductController::class);
        Route::resource('hotdeals', HotDealController::class);
        Route::get('customers',        [CustomerController::class, 'index'])->name('customers.index');
        Route::get('customers/{user}', [CustomerController::class, 'show'])->name('customers.show');
    });

});