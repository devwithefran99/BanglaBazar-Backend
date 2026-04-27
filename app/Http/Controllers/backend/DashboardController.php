<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        return view('backend.dashboard.dashboardIndex', [
            'totalProducts'    => Product::count(),
            'activeProducts'   => Product::where('is_active', true)->count(),
            'featuredProducts' => Product::where('is_featured', true)->count(),
            'outOfStock'       => Product::where('stock', 0)->count(),
        ]);
    }
}