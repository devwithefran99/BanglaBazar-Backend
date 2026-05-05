<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\HotDeal;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Request $request, $id)
    {
        $type = $request->query('type', 'product');

        if ($type === 'hotdeal') {
            $item = HotDeal::find($id);
        } else {
            $item = Product::find($id);
        }

        if (!$item) {
            return redirect()->route('shop')
                ->with('error', 'Product not found! Please buy something else.');
        }

        return view('frontend.singleProduct', compact('item', 'type'));
    }
}