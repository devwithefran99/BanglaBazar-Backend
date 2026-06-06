<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\HotDeal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function show(Request $request, string $slug)
    {
        $type = $request->query('type', 'product');

        if ($type === 'hotdeal') {
            $item = HotDeal::where('slug', $slug)->firstOrFail();
        } else {
            $item = Product::where('slug', $slug)->firstOrFail();
        }

        if (Auth::check()) {
            Auth::user()->load('wishlists');
        }

        return view('frontend.singleProduct', compact('item', 'type'));
    }
}