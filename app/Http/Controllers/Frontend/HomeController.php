<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\HotDeal;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $popularProducts = Product::where('is_active', true)
                                  ->with('variations')
                                  ->latest()
                                  ->take(10)
                                  ->get();

        $featureProducts = Product::where('is_featured', true)
                                  ->where('is_active', true)
                                  ->with('variations')
                                  ->latest()
                                  ->take(12)
                                  ->get();

        $hotDeals = HotDeal::where('is_active', true)
                           ->with('variations')
                           ->where(function($q) {
                               $q->whereNull('deal_ends_at')
                                 ->orWhere('deal_ends_at', '>', now());
                           })
                           ->latest()
                           ->take(10)
                           ->get();

        $categories = Category::where('is_active', true)
                              ->orderBy('sort_order')
                              ->get();

        $testimonials = Review::where('status', 'approved')
                              ->where('featured', true)
                              ->with('user')
                              ->latest()
                              ->take(8)
                              ->get();

        if (Auth::check()) {
            Auth::user()->load('wishlists');
        }

        return view('frontend.index', compact(
            'popularProducts',
            'hotDeals',
            'featureProducts',
            'categories',
            'testimonials'
        ));
    }
}