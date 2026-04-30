<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\HotDeal;

class HomeController extends Controller
{
   public function index()
{
    // Popular = সব active product (featured ছাড়াও)
    $popularProducts = Product::where('is_active', true)
                              ->latest()
                              ->take(10)
                              ->get();

    // Feature = শুধু featured + active product (slider এ দেখাবে)
    $featureProducts = Product::where('is_featured', true)
                              ->where('is_active', true)
                              ->latest()
                              ->take(12)
                              ->get();

    $hotDeals = HotDeal::where('is_active', true)
                       ->where(function($q) {
                           $q->whereNull('deal_ends_at')
                             ->orWhere('deal_ends_at', '>', now());
                       })
                       ->latest()
                       ->take(10)
                       ->get();

    return view('frontend.index', compact('popularProducts', 'hotDeals', 'featureProducts'));
}
}