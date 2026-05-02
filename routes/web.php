<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\UserDashboardController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\CartController;

// ── Public Pages ──────────────────────────────
Route::get('/',        [HomeController::class, 'index'])->name('home');
Route::get('/shop',    [ShopController::class, 'index'])->name('shop');
Route::get('/about',   fn() => view('frontend.about'))->name('about');
Route::get('/contact', fn() => view('frontend.contact'))->name('contact');
Route::get('/wishlist',fn() => view('frontend.wishlist'))->name('wishlist');
Route::get('/faq',     fn() => view('frontend.faq'))->name('faq');

Route::get('/product/{id?}', function ($id = null) {
    return view('frontend.singleProduct');
})->name('product');

// ── Auth (Guest only) ─────────────────────────
Route::get('/signin',    [AuthController::class, 'showSignIn'])->name('signin');
Route::post('/signin',   [AuthController::class, 'signIn'])->name('signin.post');
Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

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
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::put('/update/{id}', [CartController::class, 'updateQuantity'])->name('update');
        Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
        Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
        Route::get('/count', [CartController::class, 'count'])->name('count');
    });
});