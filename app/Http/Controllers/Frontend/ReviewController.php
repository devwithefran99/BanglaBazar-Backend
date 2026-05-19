<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use App\Models\HotDeal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        // Login check
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to submit a review.',
            ], 401);
        }

        $request->validate([
            'product_id'   => 'required|integer',
            'product_type' => 'required|in:product,hotdeal',
            'rating'       => 'required|integer|min:1|max:5',
            'body'         => 'nullable|string|max:500',
        ]);

        // Product exist করে কিনা check
        if ($request->product_type === 'hotdeal') {
            $product = HotDeal::find($request->product_id);
        } else {
            $product = Product::find($request->product_id);
        }

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.',
            ], 404);
        }

        // Already review দিয়েছে কিনা check
        $existing = Review::where('user_id', Auth::id())
                          ->where('product_id', $request->product_id)
                          ->where('product_type', $request->product_type)
                          ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'You have already reviewed this product.',
            ], 422);
        }

        // Review save
        Review::create([
            'user_id'      => Auth::id(),
            'product_id'   => $request->product_id,
            'product_type' => $request->product_type,
            'rating'       => $request->rating,
            'body'         => $request->body,
            'status'       => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review submitted! It will appear after approval.',
        ]);
    }
}