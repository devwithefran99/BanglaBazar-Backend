<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller; // ✅ এই line add করো
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Get user's cart items
    public function index()
{
    try {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        $cartItems = Auth::user()->carts()->with('product')->get();

        // ✅ Debug log (development only)
        \Log::info('Cart Items:', [
            'user_id' => Auth::id(),
            'count' => $cartItems->count(),
            'items' => $cartItems->toArray()
        ]);

        return response()->json([
            'success' => true,
            'data' => $cartItems,
            'message' => 'Cart items retrieved successfully'
        ]);
    } catch (\Exception $e) {
        \Log::error('Cart fetch error: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Failed to retrieve cart items: ' . $e->getMessage()
        ], 500);
    }
}

    // Add product to cart
    public function add(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1'
            ]);

            $product = Product::findOrFail($request->product_id);

            // Stock check
            if ($product->stock < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock available'
                ], 400);
            }

            // Check if already exists
            $existingCart = Cart::where('user_id', Auth::id())
                                ->where('product_id', $request->product_id)
                                ->first();

            if ($existingCart) {
                // Update quantity
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
                    'data' => $existingCart,
                    'message' => 'Cart updated successfully'
                ]);
            }

            // Create new cart item
            $cartItem = Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity
            ]);

            return response()->json([
                'success' => true,
                'data' => $cartItem,
                'message' => 'Product added to cart successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add product to cart'
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
                'data' => $cartItem,
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
                'data' => $count,
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