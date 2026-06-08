<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\HotDeal;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $source = $request->query('source', 'cart');
        $items  = collect();
        $total  = 0;

        if ($source === 'buynow') {
            $type    = $request->query('type', 'product');
            $id      = $request->query('id');
            $qty     = max(1, (int) $request->query('qty', 1));
            $product = $type === 'hotdeal' ? HotDeal::find($id) : Product::find($id);

            if ($product) {
                $variationId = $request->query('variation_id');
                $variation   = $variationId ? ProductVariation::find($variationId) : null;
                $price       = $variation ? $variation->price : $product->price;
                $stockLimit  = $variation ? $variation->stock : $product->stock;
                $qty         = min($qty, $stockLimit);

                $items->push([
                    'product'         => $product,
                    'product_type'    => $type,
                    'variation_id'    => $variation?->id,
                    'variation_label' => $variation?->label,
                    'quantity'        => $qty,
                    'price'           => $price,
                    'subtotal'        => $price * $qty,
                ]);
                $total = $price * $qty;
            }

        } elseif ($source === 'wishlist') {
            if (Auth::check()) {
                $wishlists = Auth::user()->wishlists()->with('product')->get();
                foreach ($wishlists as $wish) {
                    $product = $wish->product;
                    if (!$product || $product->stock <= 0) continue;
                    $items->push([
                        'product'         => $product,
                        'product_type'    => $wish->product_type ?? 'product',
                        'variation_id'    => null,
                        'variation_label' => null,
                        'quantity'        => 1,
                        'price'           => $product->price,
                        'subtotal'        => $product->price,
                    ]);
                    $total += $product->price;
                }
            }

        } else {
            if (Auth::check()) {
                $cartItems = Auth::user()->carts()->with('variation')->get();
                foreach ($cartItems as $cartItem) {
                    $product = $cartItem->product_type === 'hotdeal'
                        ? HotDeal::find($cartItem->product_id)
                        : Product::find($cartItem->product_id);
                    if (!$product) continue;
                    $qty   = $cartItem->quantity;
                    $price = $cartItem->variation ? $cartItem->variation->price : $product->price;
                    $items->push([
                        'product'         => $product,
                        'product_type'    => $cartItem->product_type,
                        'variation_id'    => $cartItem->variation_id,
                        'variation_label' => $cartItem->variation?->label,
                        'quantity'        => $qty,
                        'price'           => $price,
                        'subtotal'        => $price * $qty,
                    ]);
                    $total += $price * $qty;
                }
            }
        }

        $user = Auth::user();
        return view('frontend.checkOut', compact('items', 'total', 'source', 'user'));
    }

    public function place(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'address'    => 'required|string|max:255',
            'country'    => 'required|string',
            'state'      => 'required|string',
            'zip'        => 'required|string|max:20',
            'email'      => 'required|email',
            'phone'      => 'required|string|max:20',
            'payment'    => 'required|string',
            'source'     => 'required|string',
            'items'      => 'required|string',
        ]);

        $source    = $request->source;
        $orderData = json_decode($request->items, true);

        if (!$orderData || count($orderData) === 0) {
            return back()->with('error', 'No items to order!');
        }

        DB::beginTransaction();
        try {
            // ── Subtotal calculate — item price ব্যবহার করো (variation price সহ সঠিক) ──
            $subtotal = 0;
            foreach ($orderData as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            // ── Coupon discount apply ──
            $discount   = 0;
            $couponCode = null;

            if ($request->filled('coupon_code')) {
                $coupon = \App\Models\Coupon::where('code', strtoupper($request->coupon_code))
                                            ->first();
                if ($coupon) {
                    $result = $coupon->isValid($subtotal);
                    if ($result['valid']) {
                        $discount   = $coupon->calculateDiscount($subtotal);
                        $couponCode = $coupon->code;
                    }
                }
            }

            $total = max(0, $subtotal - $discount);

            $order = Order::create([
                'user_id'            => Auth::id(),
                'total_price'        => $total,
                'discount_amount'    => $discount,
                'coupon_code'        => $couponCode,
                'status'             => 'pending',
                'payment_method'     => $request->payment,
                'billing_first_name' => $request->first_name,
                'billing_last_name'  => $request->last_name,
                'billing_email'      => $request->email,
                'billing_phone'      => $request->phone,
                'billing_country'    => $request->country,
                'billing_state'      => $request->state,
                'billing_zip'        => $request->zip,
                'billing_address'    => $request->address,
                'address'            => $request->first_name . ' ' . $request->last_name
                                       . ', ' . $request->address
                                       . ', ' . $request->state
                                       . ', ' . $request->country
                                       . ' - ' . $request->zip,
                'phone'              => $request->phone,
            ]);

            foreach ($orderData as $item) {

                // lockForUpdate() — race condition prevent
                if ($item['product_type'] === 'hotdeal') {
                    $product = HotDeal::lockForUpdate()->find($item['product_id']);
                } else {
                    $product = Product::lockForUpdate()->find($item['product_id']);
                }

                if (!$product) {
                    throw new \Exception("'{$item['product_name']}' আর পাওয়া যাচ্ছে না।");
                }

                // Stock check — variation থাকলে variation stock, না হলে product stock
                if (!empty($item['variation_id'])) {
                    $variation = ProductVariation::lockForUpdate()->find($item['variation_id']);
                    if (!$variation || $variation->stock < $item['quantity']) {
                        throw new \Exception(
                            "'{$product->name} ({$item['variation_label']})' এর পর্যাপ্ত stock নেই।"
                        );
                    }
                } else {
                    if ($product->stock < $item['quantity']) {
                        throw new \Exception(
                            "'{$product->name}' এর পর্যাপ্ত stock নেই। " .
                            "চাহিদা: {$item['quantity']}, বর্তমান stock: {$product->stock}"
                        );
                    }
                }

                // OrderItem তৈরি
                OrderItem::create([
                    'order_id'        => $order->id,
                    'product_id'      => $item['product_id'],
                    'product_type'    => $item['product_type'],
                    'product_name'    => $item['product_name'],
                    'variation_id'    => $item['variation_id'] ?? null,
                    'variation_label' => $item['variation_label'] ?? null,
                    'quantity'        => $item['quantity'],
                    'price'           => $item['price'],
                ]);

                // Variation stock decrement (variation থাকলে)
                if (!empty($item['variation_id'])) {
                    ProductVariation::where('id', $item['variation_id'])
                        ->decrement('stock', $item['quantity']);
                }

                // Main product stock decrement (একবারই)
                $product->decrement('stock', $item['quantity']);

                // Linked Inventory stock sync
                \App\Models\Inventory::where('product_id', $item['product_id'])
                    ->where('product_type', $item['product_type'])
                    ->lockForUpdate()
                    ->first()
                    ?->decrement('stock', $item['quantity']);
            }

            // Coupon use count বাড়াও
            if ($couponCode) {
                \App\Models\Coupon::where('code', $couponCode)->increment('used_count');
            }

            if ($source === 'cart' && Auth::check()) {
                Auth::user()->carts()->delete();
            }

            DB::commit();

            $order->load(['user', 'items']);

            try {
                Mail::to($request->email)->send(new OrderMail($order, 'placed'));
            } catch (\Exception $mailEx) {
                \Log::error('Order placed mail failed: ' . $mailEx->getMessage());
            }

            return redirect()->route('order.success', ['id' => $order->id]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Checkout error: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    // Order Success Page
    public function success($id)
    {
        $order = Order::with('items')->findOrFail($id);

        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('frontend.order-success', compact('order'));
    }

    public function buyNow(Request $request)
    {
        $request->validate([
            'product_id'   => 'required|integer',
            'product_type' => 'required|string',
            'quantity'     => 'required|integer|min:1',
        ]);

        session([
            'buy_now' => [
                'product_id'   => $request->product_id,
                'product_type' => $request->product_type,
                'quantity'     => $request->quantity,
            ]
        ]);

        return response()->json(['success' => true]);
    }
}