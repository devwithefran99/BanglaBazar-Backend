<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\HotDeal;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Inventory;
use App\Models\InventoryMovement;

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
        $total = collect($orderData)->sum(fn($i) => $i['price'] * $i['quantity']);

        // ── Coupon discount apply ── 👈 নতুন
        $discount = (float) $request->input('coupon_discount', 0);
        $total    = max(0, $total - $discount);

        $order = Order::create([
            'user_id'     => Auth::id(),
            'total_price' => $total, // 👈 discount বাদে total
            'status'      => 'pending',
            'address'     => $request->first_name . ' ' . $request->last_name
                             . ', ' . $request->address
                             . ', ' . $request->state
                             . ', ' . $request->country
                             . ' - ' . $request->zip,
            'phone'       => $request->phone,
        ]);

      foreach ($orderData as $item) {
            OrderItem::create([
                'order_id'     => $order->id,
                'product_id'   => $item['product_id'],
                'product_type' => $item['product_type'],
                'product_name' => $item['product_name'],
                'quantity'     => $item['quantity'],
                'price'        => $item['price'],
            ]);

            // Product / HotDeal stock কমাও
            if ($item['product_type'] === 'hotdeal') {
                HotDeal::where('id', $item['product_id'])->decrement('stock', $item['quantity']);
            } else {
                Product::where('id', $item['product_id'])->decrement('stock', $item['quantity']);
            }

            // Inventory stock কমাও (product_id + product_type দিয়ে exact match)
            $inventory = \App\Models\Inventory::where('product_id', $item['product_id'])
                ->where('product_type', $item['product_type'])
                ->first();

            if ($inventory && $inventory->stock >= $item['quantity']) {
                $stockBefore = $inventory->stock;
                $inventory->decrement('stock', $item['quantity']);

                \App\Models\InventoryMovement::create([
                    'inventory_id' => $inventory->id,
                    'type'         => 'out',
                    'quantity'     => $item['quantity'],
                    'stock_before' => $stockBefore,
                    'stock_after'  => $stockBefore - $item['quantity'],
                    'note'         => 'Order #' . str_pad($order->id, 6, '0', STR_PAD_LEFT),
                    'created_by'   => null,
                ]);
            }
        }

        // ── Coupon use count বাড়াও ── 👈 নতুন
        if ($request->filled('coupon_code')) {
            \App\Models\Coupon::where('code', strtoupper($request->coupon_code))
                              ->increment('used_count');
        }

        if ($source === 'cart' && Auth::check()) {
            Auth::user()->carts()->delete();
        }

        DB::commit();

        return redirect()->route('order.success', ['id' => $order->id]);

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Order failed: ' . $e->getMessage());
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
}