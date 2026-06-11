<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\UserDashboardController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\CouponController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\ReturnRequestController;





// ── Public Pages ──────────────────────────────
Route::get('/',        [HomeController::class, 'index'])->name('home');
Route::get('/shop',    [ShopController::class, 'index'])->name('shop');
Route::get('/about',            [PageController::class, 'about'])->name('about');
Route::get('/contact',  [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store')->middleware('throttle:3,1');
Route::get('/wishlist',         [PageController::class, 'wishlist'])->name('wishlist');
Route::get('/faq',              [PageController::class, 'faq'])->name('faq');
Route::get('/privacy-policy',   [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms-conditions', [PageController::class, 'terms'])->name('terms');

Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product');

Route::get('/search/suggestions', [ShopController::class, 'searchSuggestions'])->name('search.suggestions');

// ── Auth (Guest only) ─────────────────────────
Route::get('/signin',    [AuthController::class, 'showSignIn'])->name('signin');
Route::post('/signin',   [AuthController::class, 'signIn'])->name('signin.post')->middleware('throttle:5,1');
Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post')->middleware('throttle:5,1');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── User Dashboard (Login লাগবে) ──────────────
Route::get('/my-account', function () {
    // Login নেই → signin এ
    if (!Auth::check()) {
        return redirect()->route('signin');
    }
    // Admin হলে → এই page এর access নেই
    if (Auth::user()->role === 'admin') {
        return redirect()->route('signin');
    }
    // Customer → userdashboard
    return app(\App\Http\Controllers\Frontend\UserDashboardController::class)->index();
})->name('userdashboard');


// wishlist Route
Route::get('/wishlist',              [WishlistController::class, 'index'])->name('wishlist');
Route::post('/wishlist/toggle',      [WishlistController::class, 'toggle'])->name('wishlist.toggle');
Route::delete('/wishlist/{id}',      [WishlistController::class, 'remove'])->name('wishlist.remove');

// cart Route



// Cart Routes (Protected by auth middleware)
Route::middleware(['auth'])->group(function () {
    // return request
         Route::post('/return-request', [ReturnRequestController::class, 'store'])
         ->name('return.store');

        //  buy now 
        Route::post('/buy-now', [CheckoutController::class, 'buyNow'])->name('buy.now')->middleware('auth');

    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::put('/update/{id}', [CartController::class, 'updateQuantity'])->name('update');
        Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
        Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
       

    });

//    profile & address
      Route::post('/profile/update',  [UserDashboardController::class, 'updateProfile'])->name('profile.update');
    Route::post('/address/update',  [UserDashboardController::class, 'updateAddress'])->name('address.update');
});

Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

// checkout 
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.show')->middleware('auth');
Route::post('/checkout/place', [CheckoutController::class, 'place'])->name('checkout.place')->middleware('auth');

// Order Success
Route::get('/order/success/{id}', [CheckoutController::class, 'success'])
    ->name('order.success')
    ->middleware('auth');


Route::post('/coupon/apply', [CouponController::class, 'apply'])
     ->name('coupon.apply')
     ->middleware('auth');
     
    //  reviews
   // reviews
Route::post('/review', [ReviewController::class, 'store'])
     ->name('review.store')
     ->middleware('auth');