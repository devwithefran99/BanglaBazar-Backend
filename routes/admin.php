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
use App\Http\Controllers\Backend\ReviewController as BackendReviewController;

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

    // Orders
    Route::get('/orders',               [OrderController::class, 'index'])->name('backend.orders.index');
    Route::get('/orders/{id}',          [OrderController::class, 'show'])->name('backend.orders.show');
    Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('backend.orders.updateStatus');

    Route::post('/orders/{orderId}/resend-mail', [EmailController::class, 'resendOrderMail'])->name('backend.orders.resendMail');

    // ✅ Order Invoice
    Route::get('/orders/{id}/invoice', [InvoiceController::class, 'orderInvoice'])
         ->name('backend.orders.invoice');

    // সব admin routes একসাথে
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

     //    mails
        Route::get('emails',               [EmailController::class, 'index'])->name('emails.index');
        Route::post('emails/send',         [EmailController::class, 'send'])->name('emails.send');
        Route::delete('emails/{emailLog}', [EmailController::class, 'destroy'])->name('emails.destroy');

        // inventory
         Route::resource('inventory', InventoryController::class);
         Route::post('inventory/{inventory}/adjust-stock', [InventoryController::class, 'adjustStock'])
        ->name('inventory.adjust-stock');
      // Suppliers & Purchases
            Route::resource('suppliers', SupplierController::class);
            Route::resource('purchases', PurchaseController::class);
            Route::resource('supplier-payments', SupplierPaymentController::class);

         // ── Invoice Section ──────────────────
        Route::get('invoices', [InvoiceController::class, 'index'])->name('invoices.index');
 
        Route::get('suppliers/{id}/purchase-invoice', [InvoiceController::class, 'supplierPurchaseInvoice'])
             ->name('suppliers.purchase-invoice');
 
        Route::get('suppliers/{id}/payment-invoice', [InvoiceController::class, 'supplierPaymentInvoice'])
             ->name('suppliers.payment-invoice');

          //    reviews
          // Reviews
          Route::get('reviews', [BackendReviewController::class, 'index'])->name('reviews.index');
          Route::patch('reviews/{review}/approve', [BackendReviewController::class, 'approve'])->name('reviews.approve');
          Route::patch('reviews/{review}/reject',  [BackendReviewController::class, 'reject'])->name('reviews.reject');
          Route::delete('reviews/{review}',        [BackendReviewController::class, 'destroy'])->name('reviews.destroy');
          Route::patch('reviews/{review}/toggle-featured', [BackendReviewController::class, 'toggleFeatured'])
           ->name('reviews.toggleFeatured');

        
    });
      //    contact todo form
          Route::get('/messages',          [MessagesController::class, 'index'])->name('backend.messages.index');
          Route::get('/messages/{message}', [MessagesController::class, 'show'])->name('backend.messages.show');
          Route::delete('/messages/{message}', [MessagesController::class, 'destroy'])->name('backend.messages.destroy');

});