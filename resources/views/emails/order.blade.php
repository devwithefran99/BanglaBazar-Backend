<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<style>
  * { margin:0; padding:0; box-sizing:border-box; }
  body { font-family:'Segoe UI', Arial, sans-serif; background:#f4f6fb; color:#333; }
  .wrapper { max-width:600px; margin:30px auto; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,.08); }
  .header { padding:32px 40px; text-align:center; }
  .header-placed    { background:linear-gradient(135deg,#696cff,#9155fd); }
  .header-confirmed { background:linear-gradient(135deg,#0dcaf0,#0d6efd); }
  .header-shipped   { background:linear-gradient(135deg,#fd7e14,#ffc107); }
  .header-delivered { background:linear-gradient(135deg,#20c997,#198754); }
  .header-cancelled { background:linear-gradient(135deg,#dc3545,#c00); }
  .header h1 { color:#fff; font-size:26px; font-weight:700; margin-bottom:6px; }
  .header p  { color:rgba(255,255,255,.85); font-size:14px; }
  .header .icon { font-size:48px; margin-bottom:12px; display:block; }
  .body { padding:32px 40px; }
  .greeting { font-size:17px; margin-bottom:20px; }
  .greeting strong { color:#696cff; }
  .status-badge { display:inline-block; padding:6px 18px; border-radius:50px; font-size:13px; font-weight:600; margin-bottom:24px; }
  .badge-placed    { background:#ede7ff; color:#7c3aed; }
  .badge-confirmed { background:#dbeafe; color:#1d4ed8; }
  .badge-shipped   { background:#fff3cd; color:#b45309; }
  .badge-delivered { background:#d1fae5; color:#065f46; }
  .badge-cancelled { background:#fee2e2; color:#991b1b; }
  .order-box { background:#f8f9ff; border:1px solid #e8eaf6; border-radius:10px; padding:20px 24px; margin-bottom:24px; }
  .order-box h3 { font-size:13px; text-transform:uppercase; letter-spacing:.8px; color:#888; margin-bottom:14px; }
  .order-meta { display:flex; justify-content:space-between; flex-wrap:wrap; gap:12px; }
  .order-meta-item { font-size:14px; }
  .order-meta-item span { color:#888; display:block; font-size:12px; margin-bottom:2px; }
  .items-table { width:100%; border-collapse:collapse; margin-bottom:20px; }
  .items-table th { background:#f1f3ff; text-align:left; padding:10px 12px; font-size:12px; text-transform:uppercase; color:#666; }
  .items-table td { padding:12px; font-size:14px; border-bottom:1px solid #f0f0f0; }
  .total-row { display:flex; justify-content:space-between; padding:14px 16px; background:#696cff; border-radius:8px; }
  .total-row span { color:#fff; font-size:15px; font-weight:700; }
  .address-box { background:#f8f9ff; border-left:4px solid #696cff; padding:14px 18px; border-radius:0 8px 8px 0; margin-bottom:24px; font-size:14px; color:#555; }
  .address-box strong { color:#333; display:block; margin-bottom:4px; font-size:13px; }
  .message-box { background:#fffbeb; border:1px solid #fde68a; border-radius:8px; padding:16px 20px; font-size:14px; color:#78350f; margin-bottom:24px; line-height:1.6; }
  .cta-btn { display:block; width:fit-content; margin:0 auto 24px; padding:14px 36px; background:#696cff; color:#fff; text-decoration:none; border-radius:8px; font-size:15px; font-weight:600; }
  .footer { background:#f8f9ff; padding:24px 40px; text-align:center; border-top:1px solid #eee; }
  .footer p { font-size:12px; color:#aaa; line-height:1.8; }
  .footer strong { color:#696cff; }
</style>
</head>
<body>

@php
$icons = [
    'placed'    => '🛍️',
    'confirmed' => '✅',
    'shipped'   => '🚚',
    'delivered' => '📦',
    'cancelled' => '❌',
];
$messages = [
    'placed'    => 'আপনার অর্ডার সফলভাবে প্লেস হয়েছে। আমরা শীঘ্রই প্রসেস করব।',
    'confirmed' => 'আমরা আপনার অর্ডার কনফার্ম করেছি। প্যাকেজিং শুরু হয়েছে।',
    'shipped'   => 'আপনার অর্ডার পাঠানো হয়েছে এবং রাস্তায় আছে।',
    'delivered' => 'আপনার অর্ডার ডেলিভারি হয়েছে। ধন্যবাদ! 😊',
    'cancelled' => 'আপনার অর্ডারটি বাতিল করা হয়েছে।',
];
$orderId = str_pad($order->id, 4, '0', STR_PAD_LEFT);
@endphp

<div class="wrapper">
  <div class="header header-{{ $mailType }}">
    <span class="icon">{{ $icons[$mailType] ?? '📬' }}</span>
    <h1>
      @if($mailType === 'placed') Order Received!
      @elseif($mailType === 'confirmed') Order Confirmed!
      @elseif($mailType === 'shipped') Order Shipped!
      @elseif($mailType === 'delivered') Delivered!
      @elseif($mailType === 'cancelled') Order Cancelled
      @endif
    </h1>
    <p>Order #{{ $orderId }}</p>
  </div>

  <div class="body">
    <p class="greeting">Hi <strong>{{ $order->user->name ?? 'Customer' }}</strong>,</p>

    <span class="status-badge badge-{{ $mailType }}">
      Status: {{ ucfirst($mailType === 'placed' ? 'Order Placed' : $mailType) }}
    </span>

    <div class="message-box">
      <strong>📋 What's happening?</strong>
      {{ $messages[$mailType] ?? '' }}
    </div>

    <div class="order-box">
      <h3>Order Summary</h3>
      <div class="order-meta">
        <div class="order-meta-item">
          <span>Order ID</span>
          <strong>#{{ $orderId }}</strong>
        </div>
        <div class="order-meta-item">
          <span>Date</span>
          <strong>{{ $order->created_at->format('d M Y') }}</strong>
        </div>
        <div class="order-meta-item">
          <span>Phone</span>
          <strong>{{ $order->phone }}</strong>
        </div>
      </div>
    </div>

    <table class="items-table">
      <thead>
        <tr>
          <th>Product</th>
          <th>Qty</th>
          <th>Price</th>
        </tr>
      </thead>
      <tbody>
        @foreach($order->items as $item)
        <tr>
          <td>{{ $item->product_name }}</td>
          <td>{{ $item->quantity }}</td>
          <td>৳{{ number_format($item->price * $item->quantity, 2) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="total-row">
      <span>Total Amount</span>
      <span>৳{{ number_format($order->total_price, 2) }}</span>
    </div>

    <br>

    <div class="address-box">
      <strong>📍 Delivery Address</strong>
      {{ $order->address }}
    </div>

    <a href="{{ url('/my-account') }}" class="cta-btn">View My Orders</a>
  </div>

  <div class="footer">
    <p>
      Thank you for shopping with <strong>{{ config('app.name') }}</strong>.<br>
      <small>You received this email because you placed an order on our website.</small>
    </p>
  </div>
</div>

</body>
</html>