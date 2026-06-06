<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\HotDeal;
use App\Models\Order;
use App\Models\OrderItem;
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
                $qty = min($qty, $product->stock);
                $items->push([
                    'product'      => $product,
                    'product_type' => $type,
                    'quantity'     => $qty,
                    'price'        => $product->price,
                    'subtotal'     => $product->price * $qty,
                ]);
                $total = $product->price * $qty;
            }

        } elseif ($source === 'wishlist') {
            if (Auth::check()) {
                $wishlists = Auth::user()->wishlists()->with('product')->get();
                foreach ($wishlists as $wish) {
                    $product = $wish->product;
                    if (!$product || $product->stock <= 0) continue;
                    $items->push([
                        'product'      => $product,
                        'product_type' => $wish->product_type ?? 'product',
                        'quantity'     => 1,
                        'price'        => $product->price,
                        'subtotal'     => $product->price,
                    ]);
                    $total += $product->price;
                }
            }

        } else {
            if (Auth::check()) {
                $cartItems = Auth::user()->carts()->get();
                foreach ($cartItems as $cartItem) {
                    $product = $cartItem->product_type === 'hotdeal'
                        ? HotDeal::find($cartItem->product_id)
                        : Product::find($cartItem->product_id);
                    if (!$product) continue;
                    $qty = $cartItem->quantity;
                    $items->push([
                        'product'      => $product,
                        'product_type' => $cartItem->product_type,
                        'quantity'     => $qty,
                        'price'        => $product->price,
                        'subtotal'     => $product->price * $qty,
                    ]);
                    $total += $product->price * $qty;
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
            // ── Subtotal calculate ──
           $subtotal = 0;
foreach ($orderData as $item) {
    $product = $item['product_type'] === 'hotdeal'
        ? \App\Models\HotDeal::find($item['product_id'])
        : \App\Models\Product::find($item['product_id']);
    if (!$product) continue;
    $subtotal += $product->price * $item['quantity'];
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
            // ✅ Server এ নিজে calculate করছে — client এর value ignore
            $discount   = $coupon->calculateDiscount($subtotal);
            $couponCode = $coupon->code;
        }
        // invalid হলে discount = 0, silently skip
    }
}

$total = max(0, $subtotal - $discount);

            $order = Order::create([
                'user_id'         => Auth::id(),
                'total_price'     => $total,
                  'discount_amount' => $discount,
                'coupon_code'     => $couponCode,
                'status'          => 'pending',
                'payment_method'  => $request->payment,

                // ✅ Billing info from form (NOT from logged-in user)
                'billing_first_name' => $request->first_name,
                'billing_last_name'  => $request->last_name,
                'billing_email'      => $request->email,
                'billing_phone'      => $request->phone,
                'billing_country'    => $request->country,
                'billing_state'      => $request->state,
                'billing_zip'        => $request->zip,
                'billing_address'    => $request->address,

                // legacy columns — same data, for backward compatibility
                'address' => $request->first_name . ' ' . $request->last_name
                             . ', ' . $request->address
                             . ', ' . $request->state
                             . ', ' . $request->country
                             . ' - ' . $request->zip,
                'phone'   => $request->phone,
            ]);

            foreach ($orderData as $item) {

                // ✅ lockForUpdate() — transaction এর মধ্যে row lock করো
                // এতে দুজন একসাথে order দিলেও একজনকে অপেক্ষা করতে হবে
                if ($item['product_type'] === 'hotdeal') {
                    $product = HotDeal::lockForUpdate()->find($item['product_id']);
                } else {
                    $product = Product::lockForUpdate()->find($item['product_id']);
                }

                // ✅ Product exist করে কিনা check
                if (!$product) {
                    throw new \Exception("'{$item['product_name']}' আর পাওয়া যাচ্ছে না।");
                }

                // ✅ Stock পর্যাপ্ত আছে কিনা check — race condition এর আসল fix এখানে
                if ($product->stock < $item['quantity']) {
                    throw new \Exception(
                        "'{$product->name}' এর পর্যাপ্ত stock নেই। " .
                        "চাহিদা: {$item['quantity']}, বর্তমান stock: {$product->stock}"
                    );
                }

                // ✅ OrderItem তৈরি
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item['product_id'],
                    'product_type' => $item['product_type'],
                    'product_name' => $item['product_name'],
                    'quantity'     => $item['quantity'],
                    'price'        => $item['price'],
                ]);

                // ✅ Main product/hotdeal table stock decrement — check এর পরেই
                $product->decrement('stock', $item['quantity']);

                // ✅ Linked Inventory table stock ও decrement করো
                \App\Models\Inventory::where('product_id', $item['product_id'])
                        ->where('product_type', $item['product_type'])
                        ->lockForUpdate()
                        ->first()
                        ?->decrement('stock', $item['quantity']);
            }

            // ── Coupon use count বাড়াও ──
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
           \Log::error('Checkout error: ' . $e->getMessage());
return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    // ✅ Order Success Page
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

    // Session এ buy now data store করো
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