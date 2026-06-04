<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\HotDeal;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderMail;
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
      $oldStatus = $order->status;
$newStatus = $request->status;
$order->update(['status' => $newStatus]);

$mailableStatuses = ['confirmed', 'shipped', 'delivered', 'cancelled'];
if ($oldStatus !== $newStatus && in_array($newStatus, $mailableStatuses)) {
    $order->load(['user', 'items']);
    if ($order->user && $order->user->email) {
        try {
            Mail::to($order->user->email)->send(new OrderMail($order, $newStatus));
        } catch (\Exception $mailEx) {
            \Log::error('Order status mail failed: ' . $mailEx->getMessage());
        }
    }
}

        return back()->with('success', 'Order #' . str_pad($id, 4, '0', STR_PAD_LEFT) . ' status updated to ' . ucfirst($request->status));
    }


    // ✅ Send to Steadfast
public function sendToSteadfast(Request $request, $id)
{
    $order = Order::findOrFail($id);

    // Already sent check
    if ($order->steadfast_consignment_id) {
        return back()->with('error', 'এই order টা already Steadfast এ পাঠানো হয়েছে! Consignment ID: ' . $order->steadfast_consignment_id);
    }

    $apiKey    = env('STEADFAST_API_KEY');
    $apiSecret = env('STEADFAST_API_SECRET');
    $baseUrl   = env('STEADFAST_BASE_URL', 'https://portal.steadfast.com.bd/public/v1');

    $recipientName    = trim(($order->billing_first_name ?? '') . ' ' . ($order->billing_last_name ?? '')) ?: ($order->user->name ?? 'Customer');
    $recipientPhone   = $order->billing_phone ?? $order->phone ?? '';
    $recipientAddress = $order->billing_address ?? $order->address ?? '';
    $codAmount        = $order->total_price ?? 0;
    $note             = 'Order #' . str_pad($order->id, 4, '0', STR_PAD_LEFT) . ' — BanglaBazar';

    try {
        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'Api-Key'    => $apiKey,
            'Secret-Key' => $apiSecret,
            'Content-Type' => 'application/json',
        ])->post($baseUrl . '/create_order', [
            'invoice'            => 'BB-' . str_pad($order->id, 4, '0', STR_PAD_LEFT),
            'recipient_name'     => $recipientName,
            'recipient_phone'    => $recipientPhone,
            'recipient_address'  => $recipientAddress,
            'cod_amount'         => $codAmount,
            'note'               => $note,
        ]);

        $data = $response->json();

        if ($response->successful() && isset($data['consignment']['consignment_id'])) {
            $order->update([
                'steadfast_consignment_id' => $data['consignment']['consignment_id'],
                'steadfast_tracking_code'  => $data['consignment']['tracking_code'] ?? null,
            ]);

            return back()->with('success', '✅ Steadfast এ পাঠানো হয়েছে! Consignment ID: ' . $data['consignment']['consignment_id']);
        } else {
            $errorMsg = $data['message'] ?? $data['errors'] ?? 'Unknown error';
            return back()->with('error', '❌ Steadfast Error: ' . (is_array($errorMsg) ? json_encode($errorMsg) : $errorMsg));
        }

    } catch (\Exception $e) {
        return back()->with('error', '❌ Connection Error: ' . $e->getMessage());
    }
}
}