<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\HotDeal;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    // Category list একজায়গায় রাখো
    const CATEGORIES = [
        'sutki'    => 'Sutki',
        'meat'     => 'Meat',
        'fish'     => 'Fish',
        'oil_ghee' => 'Oil & Ghee',
        'spices'   => 'Spices',
        'rice'     => 'Rice',
        'beverage' => 'Beverage',
    ];

    public function index(Request $request)
    {
        $selectedCategory = $request->query('category', 'all');

        $productsQuery = Product::where('is_active', true)->latest();
        $hotDealsQuery = HotDeal::where('is_active', true)->latest();

        // Category filter
        if ($selectedCategory !== 'all') {
            $productsQuery->where('category', $selectedCategory);
            $hotDealsQuery->where('category', $selectedCategory);
        }

        $products = $productsQuery->get();
        $hotDeals = $hotDealsQuery->get();

        // Sidebar এর count এর জন্য সব data
        $allProducts = Product::where('is_active', true)->get();
        $allHotDeals = HotDeal::where('is_active', true)->get();

         $dbCategories = Category::where('is_active', true)
                            ->orderBy('sort_order')
                            ->get();

        if (Auth::check()) {
            Auth::user()->load('wishlists');
        }

        return view('frontend.shop', compact(
            'products',
            'hotDeals',
            'allProducts',
            'allHotDeals',
            'selectedCategory',
            'selectedCategory', 
            'dbCategories'
        ));
    }
}