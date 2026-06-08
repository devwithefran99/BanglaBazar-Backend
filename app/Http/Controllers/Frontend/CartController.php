<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\HotDeal;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        try {
            if (!Auth::check()) {
                return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
            }

            $cartItems = Auth::user()->carts()->with('variation')->get();

            $cartItems->each(function ($item) {
                if ($item->product_type === 'hotdeal') {
                    $item->setRelation('product', HotDeal::find($item->product_id));
                } else {
                    $item->setRelation('product', Product::find($item->product_id));
                }
            });

            return response()->json(['success' => true, 'data' => $cartItems]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function add(Request $request)
    {
        try {
            if (!Auth::check()) {
                return response()->json(['success' => false, 'message' => 'Login করুন'], 401);
            }

            $productType = $request->input('product_type', 'product');
            $tableMap    = ['product' => 'products', 'hotdeal' => 'hot_deals'];
            $table       = $tableMap[$productType] ?? 'products';

            $request->validate([
                'product_id'   => "required|exists:{$table},id",
                'quantity'     => 'required|integer|min:1',
                'variation_id' => 'nullable|exists:product_variations,id',
            ]);

            // Stock check — variation থাকলে variation এর stock, না হলে product এর stock
            $variationId = $request->input('variation_id');
            if ($variationId && $productType === 'product') {
                $variation   = ProductVariation::findOrFail($variationId);
                $stockLimit  = $variation->stock;
            } else {
                $product    = $productType === 'hotdeal'
                              ? HotDeal::findOrFail($request->product_id)
                              : Product::findOrFail($request->product_id);
                $stockLimit = $product->stock;
            }

            if ($stockLimit < $request->quantity) {
                return response()->json(['success' => false, 'message' => 'স্টক পর্যাপ্ত নেই'], 400);
            }

            // Existing cart check — same product + same variation
            $existing = Cart::where('user_id', Auth::id())
                            ->where('product_id', $request->product_id)
                            ->where('product_type', $productType)
                            ->where('variation_id', $variationId)
                            ->first();

            if ($existing) {
                $newQty = $existing->quantity + $request->quantity;
                if ($stockLimit < $newQty) {
                    return response()->json(['success' => false, 'message' => 'Stock limit reached'], 400);
                }
                $existing->update(['quantity' => $newQty]);
                $cartCount = Auth::user()->carts()->count();
                return response()->json(['success' => true, 'data' => $existing, 'cart_count' => $cartCount, 'message' => 'Cart updated']);
            }

            $cartItem = Cart::create([
                'user_id'      => Auth::id(),
                'product_id'   => $request->product_id,
                'product_type' => $productType,
                'variation_id' => $variationId,
                'quantity'     => $request->quantity,
            ]);

            $cartCount = Auth::user()->carts()->count();
            return response()->json(['success' => true, 'data' => $cartItem, 'cart_count' => $cartCount, 'message' => 'Cart এ যোগ হয়েছে']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function updateQuantity(Request $request, $id)
    {
        try {
            $request->validate(['quantity' => 'required|integer|min:1']);

            $cartItem = Cart::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

            // Stock check with variation
            if ($cartItem->variation_id) {
                $stock = ProductVariation::find($cartItem->variation_id)?->stock ?? 0;
            } else {
                $product = $cartItem->product_type === 'hotdeal'
                           ? HotDeal::find($cartItem->product_id)
                           : Product::find($cartItem->product_id);
                $stock   = $product?->stock ?? 0;
            }

            if ($stock < $request->quantity) {
                return response()->json(['success' => false, 'message' => 'Insufficient stock'], 400);
            }

            $cartItem->update(['quantity' => $request->quantity]);
            return response()->json(['success' => true, 'data' => $cartItem, 'message' => 'Updated']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function remove($id)
    {
        try {
            Cart::where('user_id', Auth::id())->where('id', $id)->firstOrFail()->delete();
            return response()->json(['success' => true, 'message' => 'Removed from cart']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function clear()
    {
        try {
            Auth::user()->carts()->delete();
            return response()->json(['success' => true, 'message' => 'Cart cleared']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function count()
    {
        try {
            $count = Auth::user()->carts()->count();
            return response()->json(['success' => true, 'data' => $count]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}