<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Backend\ProductController;




Auth::routes();

// Home / Index Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Shop Page
Route::get('/shop', function () {
    return view('frontend.shop');
})->name('shop');

// About Page
Route::get('/about', function () {
    return view('frontend.about');
})->name('about');

// Contact Page
Route::get('/contact', function () {
    return view('frontend.contact');
})->name('contact');

// Sign In Page
Route::get('/signin', function () {
    return view('frontend.signIn');
})->name('signin');

// Sign Up / Create Account Page
Route::get('/register', function () {
    return view('frontend.createAccount');
})->name('register');

// Wishlist Page
Route::get('/wishlist', function () {
    return view('frontend.wishlist');
})->name('wishlist');

// Single Product Page
Route::get('/product/{id?}', function ($id = null) {
    return view('frontend.singleProduct');
})->name('product');

// FAQ Page
Route::get('/faq', function () {
    return view('frontend.faq');
})->name('faq');

// User Dashboard Page
Route::get('/userdashboard', function () {
    return view('frontend.userdashboard');
})->name('userdashboard');



