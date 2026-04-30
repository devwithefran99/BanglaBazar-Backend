<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\HotDeal;

class ShopController extends Controller
{
    public function index()
    {
        // সব active products
        $products = Product::where('is_active', true)
                           ->latest()
                           ->get();

        // সব active hot deals
        $hotDeals = HotDeal::where('is_active', true)
                           ->latest()
                           ->get();

        // সব category — Product + HotDeal মিলিয়ে
        $productCats = Product::where('is_active', true)
                              ->whereNotNull('category')
                              ->distinct()
                              ->pluck('category');

        $dealCats = HotDeal::where('is_active', true)
                           ->whereNotNull('category')
                           ->distinct()
                           ->pluck('category');

        $categories = $productCats->merge($dealCats)->unique()->values();

        return view('frontend.shop', compact('products', 'hotDeals', 'categories'));
    }
}