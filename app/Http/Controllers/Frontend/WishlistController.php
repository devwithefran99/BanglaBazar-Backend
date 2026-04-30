<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Wishlist page দেখাবে
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('signin');
        }

        $wishlists = Wishlist::where('user_id', Auth::id())
            ->with('product')
            ->latest()
            ->get();

        return view('frontend.wishlist', compact('wishlists'));
    }

    // Wishlist এ add/remove করবে (toggle)
    public function toggle(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please sign in first.',
                'redirect' => route('signin'),
            ], 401);
        }
        $request->validate([
        'product_id' => 'required|integer',
    ]);

        $productId   = $request->product_id;
        $productType = $request->product_type ?? 'product';

        // Already আছে কিনা check করো
        $existing = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->where('product_type', $productType)
            ->first();

        if ($existing) {
            // থাকলে remove করো
            $existing->delete();
            $added = false;
        } else {
            // না থাকলে add করো
            Wishlist::create([
                'user_id'      => Auth::id(),
                'product_id'   => $productId,
                'product_type' => $productType,
            ]);
            $added = true;
        }

        // এই user এর মোট wishlist count
        $count = Wishlist::where('user_id', Auth::id())->count();

        return response()->json([
            'success' => true,
            'added'   => $added,
            'count'   => $count,
            'message' => $added ? 'Added to wishlist!' : 'Removed from wishlist!',
        ]);
    }

    // Wishlist থেকে remove করবে
    public function remove($id)
    {
        Wishlist::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return redirect()->route('wishlist')
            ->with('success', 'Removed from wishlist.');
    }
}