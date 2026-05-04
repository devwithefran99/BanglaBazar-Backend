<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\HotDeal;  // ✅ যোগ করা হয়েছে
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Get user's cart items
   public function index()
{
    try {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
        }

        $cartItems = Auth::user()->carts()->get();

        // ✅ product_type অনুযায়ী manually product load করো
        $cartItems->each(function ($item) {
            if ($item->product_type === 'hotdeal') {
                $item->setRelation('product', \App\Models\HotDeal::find($item->product_id));
            } else {
                $item->setRelation('product', \App\Models\Product::find($item->product_id));
            }
        });

        return response()->json([
            'success' => true,
            'data'    => $cartItems,
            'message' => 'Cart items retrieved successfully'
        ]);

    } catch (\Exception $e) {
        \Log::error('Cart fetch error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}

    // Add product to cart
    public function add(Request $request)
    {
        try {
            // ✅ FIX: product_type নাও, default 'product'
            $productType = $request->input('product_type', 'product');

            // ✅ FIX: product_type অনুযায়ী সঠিক model ও table validate করো
            $tableMap = [
                'product' => 'products',
                'hotdeal' => 'hot_deals',
            ];

            $table = $tableMap[$productType] ?? 'products';

            $request->validate([
                'product_id' => "required|exists:{$table},id",
                'quantity'   => 'required|integer|min:1'
            ]);

            // ✅ FIX: product_type অনুযায়ী সঠিক model থেকে product আনো
            if ($productType === 'hotdeal') {
                $product = HotDeal::findOrFail($request->product_id);
            } else {
                $product = Product::findOrFail($request->product_id);
            }

            // Stock check
            if ($product->stock < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock available'
                ], 400);
            }

            // ✅ FIX: product_type দিয়ে existing cart check করো
            $existingCart = Cart::where('user_id', Auth::id())
                                ->where('product_id', $request->product_id)
                                ->where('product_type', $productType)
                                ->first();

            if ($existingCart) {
                $newQuantity = $existingCart->quantity + $request->quantity;

                if ($product->stock < $newQuantity) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Cannot add more. Stock limit reached'
                    ], 400);
                }

                $existingCart->update(['quantity' => $newQuantity]);

                return response()->json([
                    'success' => true,
                    'data'    => $existingCart,
                    'message' => 'Cart updated successfully'
                ]);
            }

            // ✅ FIX: product_type সহ নতুন cart item তৈরি করো
            $cartItem = Cart::create([
                'user_id'      => Auth::id(),
                'product_id'   => $request->product_id,
                'product_type' => $productType,
                'quantity'     => $request->quantity
            ]);

            return response()->json([
                'success' => true,
                'data'    => $cartItem,
                'message' => 'Product added to cart successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add product to cart: ' . $e->getMessage()
            ], 500);
        }
    }

    // Update cart item quantity
    public function updateQuantity(Request $request, $id)
    {
        try {
            $request->validate([
                'quantity' => 'required|integer|min:1'
            ]);

            $cartItem = Cart::where('user_id', Auth::id())
                            ->where('id', $id)
                            ->firstOrFail();

            $product = $cartItem->product;

            // Stock check
            if ($product->stock < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock available'
                ], 400);
            }

            $cartItem->update(['quantity' => $request->quantity]);

            return response()->json([
                'success' => true,
                'data'    => $cartItem,
                'message' => 'Cart quantity updated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update cart quantity'
            ], 500);
        }
    }

    // Remove item from cart
    public function remove($id)
    {
        try {
            $cartItem = Cart::where('user_id', Auth::id())
                            ->where('id', $id)
                            ->firstOrFail();

            $cartItem->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product removed from cart successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove product from cart'
            ], 500);
        }
    }

    // Clear entire cart
    public function clear()
    {
        try {
            Auth::user()->carts()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Cart cleared successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear cart'
            ], 500);
        }
    }

    // Get cart count
    public function count()
    {
        try {
            $count = Auth::user()->carts()->count();

            return response()->json([
                'success' => true,
                'data'    => $count,
                'message' => 'Cart count retrieved successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get cart count'
            ], 500);
        }
    }
}