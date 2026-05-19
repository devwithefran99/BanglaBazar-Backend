@extends('backend.layouts.app')

@section('title', 'Order #' . str_pad($order->id, 4, '0', STR_PAD_LEFT))

@section('content')

<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Admin / <a href="{{ route('backend.orders.index') }}" class="text-muted">Orders</a> /</span>
    Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
</h4>

<div class="row">

    {{-- ── LEFT: Order Items + Billing ── --}}
    <div class="col-12 col-lg-8">

        {{-- Order Items --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="bx bx-package me-2"></i>Ordered Items</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Type</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($order->items as $item)
                        @php
                            $imgSrc = asset('backend/assets/img/avatars/1.png');
                            if ($item->productModel && $item->productModel->image) {
                                $imgSrc = asset('storage/' . $item->productModel->image);
                            }
                        @endphp
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ $imgSrc }}"
                                         style="width:50px;height:50px;border-radius:10px;object-fit:cover;border:1px solid #eee;"
                                         onerror="this.src='{{ asset('backend/assets/img/avatars/1.png') }}'">
                                    <div>
                                        <div class="fw-semibold">{{ $item->product_name }}</div>
                                        <small class="text-muted">ID: #{{ $item->product_id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($item->product_type === 'hotdeal')
                                    <span class="badge bg-label-danger">🔥 Hot Deal</span>
                                @else
                                    <span class="badge bg-label-primary">Product</span>
                                @endif
                            </td>
                            <td>৳{{ number_format($item->price, 2) }}</td>
                            <td><span class="badge bg-label-secondary">{{ $item->quantity }}</span></td>
                            <td class="fw-bold text-success">৳{{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end fw-bold">Subtotal:</td>
                                <td class="fw-bold">৳{{ number_format($order->total_price, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-end fw-bold">Shipping:</td>
                                <td class="text-success fw-bold">Free</td>
                            </tr>
                            <tr class="table-success">
                                <td colspan="4" class="text-end fw-bold fs-6">Total:</td>
                                <td class="fw-bold fs-6 text-success">৳{{ number_format($order->total_price, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{-- Billing / Delivery Info --}}
      
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bx bx-map me-2"></i>Billing & Delivery Info</h5>
        <small class="text-muted">checkout form থেকে</small>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-sm-6">
                <label class="form-label text-muted small">Billing Name</label>
                <div class="fw-semibold">
                    {{ trim(($order->billing_first_name ?? '') . ' ' . ($order->billing_last_name ?? '')) ?: 'N/A' }}
                </div>
            </div>
            <div class="col-sm-6">
                <label class="form-label text-muted small">Billing Email</label>
                <div class="fw-semibold">{{ $order->billing_email ?? 'N/A' }}</div>
            </div>
            <div class="col-sm-6">
                <label class="form-label text-muted small">Billing Phone</label>
                <div class="fw-semibold">{{ $order->billing_phone ?? $order->phone ?? 'N/A' }}</div>
            </div>
            <div class="col-sm-6">
                <label class="form-label text-muted
                 small">Order Date</label>
                <div class="fw-semibold">{{ $order->created_at->format('d M Y, h:i A') }}</div>
            </div>
            <div class="col-12">
                <label class="form-label text-muted small">Delivery Address</label>
                <div class="fw-semibold">
                    <i class="bx bx-map-pin text-danger me-1"></i>
                    @if($order->billing_address)
                        {{ $order->billing_address }},
                        {{ $order->billing_state }},
                        {{ $order->billing_country }}
                        @if($order->billing_zip) - {{ $order->billing_zip }} @endif
                    @else
                        {{ $order->address ?? 'N/A' }}
                    @endif
                </div>
            </div>
            @if($order->payment_method)
            <div class="col-sm-6">
                <label class="form-label text-muted small">Payment Method</label>
                <div class="fw-semibold">
                    <span class="badge bg-label-info">{{ strtoupper($order->payment_method) }}</span>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

    </div>

    {{-- ── RIGHT: Status + Customer ── --}}
    <div class="col-12 col-lg-4">

        {{-- ✅ Status Update Card --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="bx bx-edit me-2"></i>Update Order Status</h5>
            </div>
            <div class="card-body">

                {{-- Current Status --}}
                <div class="mb-3">
                    <label class="form-label text-muted small">Current Status</label>
                    @php
                        $badges = [
                            'pending'   => 'warning',
                            'confirmed' => 'info',
                            'shipped'   => 'primary',
                            'delivered' => 'success',
                            'cancelled' => 'danger',
                        ];
                        $badge = $badges[$order->status] ?? 'secondary';
                    @endphp
                    <div>
                        <span class="badge bg-{{ $badge }} fs-6 px-3 py-2">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>

                {{-- ✅ Status Progress Bar --}}
                <div class="mb-4">
                    @php
                        $steps = ['pending', 'confirmed', 'shipped', 'delivered'];
                        $currentIndex = array_search($order->status, $steps);
                    @endphp
                    <div class="d-flex justify-content-between align-items-center position-relative mb-2">
                        <div style="position:absolute;top:14px;left:0;right:0;height:3px;background:#e9ecef;z-index:0;"></div>
                        @foreach($steps as $i => $step)
                        @php
                            $done    = $currentIndex !== false && $i <= $currentIndex;
                            $current = $currentIndex !== false && $i === $currentIndex;
                        @endphp
                        <div class="text-center" style="z-index:1;flex:1;">
                            <div class="mx-auto rounded-circle d-flex align-items-center justify-content-center"
                                 style="width:28px;height:28px;
                                        background:{{ $done ? '#696cff' : '#e9ecef' }};
                                        color:{{ $done ? '#fff' : '#adb5bd' }};
                                        font-size:12px;font-weight:700;
                                        border:3px solid {{ $current ? '#696cff' : ($done ? '#696cff' : '#e9ecef') }};">
                                @if($done && !$current)
                                    <i class="bx bx-check" style="font-size:14px;"></i>
                                @else
                                    {{ $i + 1 }}
                                @endif
                            </div>
                            <div style="font-size:10px;margin-top:4px;color:{{ $done ? '#696cff' : '#adb5bd' }};font-weight:{{ $current ? '700' : '400' }};">
                                {{ ucfirst($step) }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Status Update Form --}}
                <form action="{{ route('backend.orders.updateStatus', $order->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Change Status</label>
                        <select name="status" class="form-select">
                            <option value="pending"   {{ $order->status == 'pending'   ? 'selected' : '' }}>⏳ Pending</option>
                            <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>✅ Confirmed</option>
                            <option value="shipped"   {{ $order->status == 'shipped'   ? 'selected' : '' }}>🚚 Shipped</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>📦 Delivered</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bx bx-save me-1"></i> Update Status
                    </button>
                </form>
            </div>
        </div>

        {{-- Customer Info --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="bx bx-user me-2"></i>Customer Info</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="avatar">
                        <span class="avatar-initial rounded-circle bg-label-primary fs-5">
                            {{ strtoupper(substr($order->user->name ?? 'U', 0, 2)) }}
                        </span>
                    </div>
                    <div>
                        <div class="fw-bold">{{ $order->user->name ?? 'Unknown' }}</div>
                        <small class="text-muted">{{ $order->user->email ?? '' }}</small>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <a href="tel:{{ $order->phone }}" class="btn btn-sm btn-outline-success w-100">
                        <i class="bx bx-phone me-1"></i> Call
                    </a>
                    <a href="mailto:{{ $order->user->email ?? '' }}" class="btn btn-sm btn-outline-primary w-100">
                        <i class="bx bx-envelope me-1"></i> Email
                    </a>
                </div>
            </div>
        </div>

        {{-- invoice --}}
          <a href="{{ route('backend.orders.invoice', $order->id) }}"
              target="_blank"
              class="btn btn-success w-100 mb-2">
               <i class="bx bx-printer me-1"></i> Print Invoice
         </a>

        {{-- Back button --}}
        <a href="{{ route('backend.orders.index') }}" class="btn btn-outline-secondary w-100">
            <i class="bx bx-arrow-back me-1"></i> Back to Orders
        </a>

    </div>
</div>

@endsection