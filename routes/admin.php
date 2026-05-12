<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\HotDealController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\AdminAuthController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\InventoryController;

Route::middleware('guest')->group(function () {
    Route::get('/login',  [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
});

Route::post('/admin-logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
         ->name('backend.dashboard');

    Route::get('/orders',               [OrderController::class, 'index'])->name('backend.orders.index');
    Route::get('/orders/{id}',          [OrderController::class, 'show'])->name('backend.orders.show');
    Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('backend.orders.updateStatus');

    Route::prefix('admin')->name('backend.')->group(function () {
        Route::resource('products',   ProductController::class);
        Route::resource('hotdeals',   HotDealController::class);
        Route::resource('categories', CategoryController::class);

        Route::get('customers',        [CustomerController::class, 'index'])->name('customers.index');
        Route::get('customers/{user}', [CustomerController::class, 'show'])->name('customers.show');

        Route::get('coupons',                   [CouponController::class, 'index'])->name('coupons.index');
        Route::post('coupons',                  [CouponController::class, 'store'])->name('coupons.store');
        Route::delete('coupons/{coupon}',       [CouponController::class, 'destroy'])->name('coupons.destroy');
        Route::patch('coupons/{coupon}/toggle', [CouponController::class, 'toggle'])->name('coupons.toggle');

        // ── Inventory ──────────────────────────────────────────────
        Route::resource('inventory', InventoryController::class);
        Route::post('inventory/{inventory}/adjust-stock',
            [InventoryController::class, 'adjustStock']
        )->name('inventory.adjust-stock');
        // ───────────────────────────────────────────────────────────
    });

});