<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\HotDeal;

class HomeController extends Controller
{
    public function index()
    {
        $popularProducts = Product::where('is_featured', true)
                                  ->where('is_active', true)
                                  ->latest()
                                  ->take(10)
                                  ->get();

        $hotDeals = HotDeal::where('is_active', true)
                           ->where(function($q) {
                               $q->whereNull('deal_ends_at')
                                 ->orWhere('deal_ends_at', '>', now());
                           })
                           ->latest()
                           ->take(10)
                           ->get();

        $featuredDeal = $hotDeals->where('is_best_sale', true)->first()
                     ?? $hotDeals->first();

        return view('frontend.index', compact('popularProducts', 'hotDeals', 'featuredDeal'));
    }
}