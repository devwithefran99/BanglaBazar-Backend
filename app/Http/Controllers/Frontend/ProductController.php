<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\HotDeal;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function show($slug)
    {
        // Product হলে variations সহ load করো
        $product = Product::where('slug', $slug)
                          ->where('is_active', true)
                          ->with('variations')
                          ->first();

        if ($product) {
            return view('frontend.singleProduct', [
                'item' => $product,
                'type' => 'product',
            ]);
        }

       // HotDeal check
$hotDeal = HotDeal::where('slug', $slug)
                  ->where('is_active', true)
                  ->with('variations')  
                  ->first();

        if ($hotDeal) {
            return view('frontend.singleProduct', [
                'item' => $hotDeal,
                'type' => 'hotdeal',
            ]);
        }

        abort(404);
    }
}