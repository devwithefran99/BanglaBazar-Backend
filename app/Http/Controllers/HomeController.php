<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
     public function index()
    {
        // is_featured = true যেগুলো সেগুলো popular section এ যাবে
        $popularProducts = Product::where('is_featured', true)
                                  ->where('is_active', true)
                                  ->latest()
                                  ->take(10)
                                  ->get();

        return view('frontend.index', compact('popularProducts'));
    }
}
