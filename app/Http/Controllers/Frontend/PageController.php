<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function about()   { return view('frontend.about'); }
    public function faq()     { return view('frontend.faq'); }
    public function privacy() { return view('frontend.privacy'); }
    public function terms()   { return view('frontend.terms'); }
    public function wishlist(){ return view('frontend.wishlist'); }
}