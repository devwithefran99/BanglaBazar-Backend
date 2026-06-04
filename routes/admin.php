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
use App\Http\Controllers\Backend\InvoiceController;
use App\Http\Controllers\Backend\SupplierController;
use App\Http\Controllers\Backend\PurchaseController;
use App\Http\Controllers\Backend\SupplierPaymentController;
use App\Http\Controllers\Backend\MessagesController;
use App\Http\Controllers\Backend\EmailController;
use App\Http\Controllers\Backend\AdminProfileController;
use App\Http\Controllers\Backend\ReviewController as BackendReviewController;
use App\Http\Controllers\Backend\ReturnRequestController as AdminReturnController;

// ── Admin Login (guest only) ─────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',  [AdminAuthController::class, 'showLogin'])->name('login');
   Route::post('/login', [AdminAuthController::class, 'login'])
     ->name('login.post')
     ->middleware('throttle:5,1');
});

// ── Admin Logout ─────────────────────────────────────────────────────────────
Route::post('/admin-logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// ── Admin Protected Routes (সবাই access পাবে: admin, super_admin, staff) ────
Route::middleware('is_admin')->group(function () {

    // ── Dashboard (সবাই) ──────────────────────────────────────────────────────
    Route::get('/dashboard', [DashboardController::class, 'index'])
         ->name('backend.dashboard');

    // ── Orders (সবাই) ────────────────────────────────────────────────────────
    Route::get('/orders',               [OrderController::class, 'index'])->name('backend.orders.index');
    Route::get('/orders/{id}',          [OrderController::class, 'show'])->name('backend.orders.show');
    Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('backend.orders.updateStatus');
    Route::post('/orders/{orderId}/resend-mail', [EmailController::class, 'resendOrderMail'])->name('backend.orders.resendMail');
    Route::get('/orders/{id}/invoice',  [InvoiceController::class, 'orderInvoice'])->name('backend.orders.invoice');


    Route::post('/orders/{id}/send-to-steadfast', [OrderController::class, 'sendToSteadfast'])->name('backend.orders.sendToSteadfast');

    // Notification polling
Route::get('/notifications/poll', function () {
    return response()->json([
        'new_orders'   => \App\Models\Order::where('status', 'pending')
                            ->where('created_at', '>=', now()->subMinutes(1))
                            ->count(),
        'new_messages' => \App\Models\ContactMessage::where('is_read', false)
                            ->where('created_at', '>=', now()->subMinutes(1))
                            ->count(),
        'new_returns'  => \App\Models\ReturnRequest::where('status', 'pending')
                            ->where('created_at', '>=', now()->subMinutes(1))
                            ->count(),
    ]);
})->name('backend.notifications.poll');

    // ── Messages / Contact (সবাই) ─────────────────────────────────────────────
    Route::get('/messages',              [MessagesController::class, 'index'])->name('backend.messages.index');
    Route::get('/messages/{message}',    [MessagesController::class, 'show'])->name('backend.messages.show');
    Route::delete('/messages/{message}', [MessagesController::class, 'destroy'])->name('backend.messages.destroy');

    // ── Admin Profile ─────────────────────────────────────────────────────────
    Route::prefix('profile')->name('backend.profile.')->group(function () {

        // নিজের profile দেখা ও edit — সবাই
        Route::get('/',           [AdminProfileController::class, 'index'])->name('index');
        Route::put('/update',     [AdminProfileController::class, 'update'])->name('update');
        Route::put('/password',   [AdminProfileController::class, 'updatePassword'])->name('password');

        // অন্য admin add/edit/delete — শুধু super_admin ও admin
        Route::post('/admin',           [AdminProfileController::class, 'store'])
             ->middleware('role:super_admin,admin')->name('admin.store');
        Route::put('/admin/{admin}',    [AdminProfileController::class, 'adminUpdate'])
             ->middleware('role:super_admin,admin')->name('admin.update');
        Route::delete('/admin/{admin}', [AdminProfileController::class, 'destroy'])
             ->middleware('role:super_admin,admin')->name('admin.destroy');
    });

    // ── /admin prefix group ───────────────────────────────────────────────────
    Route::prefix('admin')->name('backend.')->group(function () {

        // ── Customers (সবাই) ─────────────────────────────────────────────────
        Route::get('customers',        [CustomerController::class, 'index'])->name('customers.index');
        Route::get('customers/{user}', [CustomerController::class, 'show'])->name('customers.show');

        // ── Reviews (সবাই) ───────────────────────────────────────────────────
        Route::get('reviews', [BackendReviewController::class, 'index'])->name('reviews.index');
        Route::patch('reviews/{review}/approve',         [BackendReviewController::class, 'approve'])->name('reviews.approve');
        Route::patch('reviews/{review}/reject',          [BackendReviewController::class, 'reject'])->name('reviews.reject');
        Route::delete('reviews/{review}',                [BackendReviewController::class, 'destroy'])->name('reviews.destroy');
        Route::patch('reviews/{review}/toggle-featured', [BackendReviewController::class, 'toggleFeatured'])->name('reviews.toggleFeatured');

        // ── Return Requests (সবাই) ───────────────────────────────────────────
        Route::get('return-requests',              [AdminReturnController::class, 'index'])->name('return.index');
        Route::get('return-requests/{id}',         [AdminReturnController::class, 'show'])->name('return.show');
        Route::post('return-requests/{id}/action', [AdminReturnController::class, 'action'])->name('return.action');

        // ── Inventory (সবাই) ─────────────────────────────────────────────────
        Route::resource('inventory', InventoryController::class);
        Route::post('inventory/{inventory}/adjust-stock', [InventoryController::class, 'adjustStock'])
             ->name('inventory.adjust-stock');

        // 
        // নিচের সব routes — শুধু super_admin ও admin
     
        Route::middleware('role:super_admin,admin')->group(function () {

            // Products, HotDeals, Categories
            Route::resource('products',   ProductController::class);
            Route::resource('hotdeals',   HotDealController::class);
            Route::resource('categories', CategoryController::class);

            // Coupons
            Route::get('coupons',                   [CouponController::class, 'index'])->name('coupons.index');
            Route::post('coupons',                  [CouponController::class, 'store'])->name('coupons.store');
            Route::delete('coupons/{coupon}',       [CouponController::class, 'destroy'])->name('coupons.destroy');
            Route::patch('coupons/{coupon}/toggle', [CouponController::class, 'toggle'])->name('coupons.toggle');

            // Email Center
            Route::get('emails',               [EmailController::class, 'index'])->name('emails.index');
            Route::post('emails/send',         [EmailController::class, 'send'])->name('emails.send');
            Route::delete('emails/{emailLog}', [EmailController::class, 'destroy'])->name('emails.destroy');

            // Suppliers & Purchases
            Route::resource('suppliers',         SupplierController::class);
            Route::resource('purchases',         PurchaseController::class);
            Route::resource('supplier-payments', SupplierPaymentController::class);

            // Invoices (supplier invoices — admin/super_admin only)
            Route::get('invoices', [InvoiceController::class, 'index'])->name('invoices.index');
            Route::get('suppliers/{id}/purchase-invoice', [InvoiceController::class, 'supplierPurchaseInvoice'])
                 ->name('suppliers.purchase-invoice');
            Route::get('suppliers/{id}/payment-invoice',  [InvoiceController::class, 'supplierPaymentInvoice'])
                 ->name('suppliers.payment-invoice');

        }); // end role:super_admin,admin

    }); // end /admin prefix

}); // end is_admin middleware