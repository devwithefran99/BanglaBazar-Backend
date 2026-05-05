<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\HotDeal;

class CheckoutController extends Controller
{
    /**
     * Show checkout page with the selected product/hotdeal details.
     *
     * URL: /checkout?type=product&id=5&qty=2
     *      /checkout?type=hotdeal&id=3&qty=1
     */
    public function index(Request $request)
    {
        $type = $request->query('type', 'product'); // 'product' or 'hotdeal'
        $id   = $request->query('id');
        $qty  = max(1, (int) $request->query('qty', 1));

        $item = null;

        if ($id) {
            if ($type === 'hotdeal') {
                $item = HotDeal::find($id);
            } else {
                $item = Product::find($id);
            }
        }

        // Clamp qty to available stock
        if ($item && $qty > $item->stock) {
            $qty = $item->stock;
        }

      return view('frontend.checkout', compact('item', 'type', 'qty'));
    }

    /**
     * Handle Place Order form submission.
     */
    public function place(Request $request)
    {
        $request->validate([
            'first_name'   => 'required|string|max:100',
            'address'      => 'required|string|max:255',
            'country'      => 'required|string',
            'state'        => 'required|string',
            'zip'          => 'required|string|max:20',
            'email'        => 'required|email',
            'phone'        => 'required|string|max:20',
            'product_id'   => 'required|integer',
            'product_type' => 'required|in:product,hotdeal',
            'qty'          => 'required|integer|min:1',
        ]);

        // ── Fetch the ordered item ──
        $type = $request->product_type;
        $item = $type === 'hotdeal'
            ? HotDeal::findOrFail($request->product_id)
            : Product::findOrFail($request->product_id);

        $qty   = (int) $request->qty;
        $total = $item->price * $qty;

        // ── (Optional) Create an Order record here ──
        // Order::create([...]);

        // ── Reduce stock ──
        // $item->decrement('stock', $qty);

        // ── Redirect to success / thank-you page ──
        return redirect()->route('home')
            ->with('success', "✅ Order placed successfully! Total: ৳" . number_format($total, 2));
    }
}