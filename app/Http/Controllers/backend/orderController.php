<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\HotDeal;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // সব orders list
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items'])->latest();

        // Status filter
        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Search by order id or phone
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('id', $request->search)
                  ->orWhere('phone', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($q2) use ($request) {
                      $q2->where('name', 'like', '%' . $request->search . '%')
                         ->orWhere('email', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $orders = $query->paginate(15);

        $stats = [
            'total'     => Order::count(),
            'pending'   => Order::where('status', 'pending')->count(),
            'shipped'   => Order::where('status', 'shipped')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
        ];

        return view('backend.orders.orders-index', compact('orders', 'stats'));
    }

    // Single order details
    public function show($id)
    {
        $order = Order::with(['user', 'items'])->findOrFail($id);

        // প্রতিটা item এর product image লোড করো
        foreach ($order->items as $item) {
            if ($item->product_type === 'hotdeal') {
                $item->productModel = HotDeal::find($item->product_id);
            } else {
                $item->productModel = Product::find($item->product_id);
            }
        }

        return view('backend.orders.orders-show', compact('order'));
    }

    // Status update
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,shipped,delivered,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Order #' . str_pad($id, 4, '0', STR_PAD_LEFT) . ' status updated to ' . ucfirst($request->status));
    }
}