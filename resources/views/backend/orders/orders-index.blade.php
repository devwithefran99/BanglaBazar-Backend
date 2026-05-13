@extends('backend.layouts.app')

@section('title', 'Orders Management')

@section('content')

<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Admin /</span> Orders Management
</h4>

{{-- ── Stats Cards ── --}}
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="fw-semibold d-block mb-1">Total Orders</span>
                        <h3 class="card-title mb-2">{{ $stats['total'] }}</h3>
                    </div>
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-primary">
                            <i class="bx bx-receipt"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="fw-semibold d-block mb-1">Pending</span>
                        <h3 class="card-title mb-2 text-warning">{{ $stats['pending'] }}</h3>
                    </div>
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-warning">
                            <i class="bx bx-time"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="fw-semibold d-block mb-1">Shipped</span>
                        <h3 class="card-title mb-2 text-info">{{ $stats['shipped'] }}</h3>
                    </div>
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-info">
                            <i class="bx bx-truck"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="fw-semibold d-block mb-1">Delivered</span>
                        <h3 class="card-title mb-2 text-success">{{ $stats['delivered'] }}</h3>
                    </div>
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-success">
                            <i class="bx bx-check-circle"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── Filter & Search ── --}}
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('backend.orders.index') }}"
              class="d-flex align-items-center gap-3 flex-wrap">
            <div class="flex-grow-1">
                <input type="text" name="search" class="form-control"
                       placeholder="Search by Order ID, phone, or customer name..."
                       value="{{ request('search') }}">
            </div>
            <div>
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                    <option value="pending"   {{ request('status') == 'pending'   ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="shipped"   {{ request('status') == 'shipped'   ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="bx bx-search me-1"></i> Search
            </button>
            @if(request('search') || request('status'))
                <a href="{{ route('backend.orders.index') }}" class="btn btn-outline-secondary">
                    <i class="bx bx-x me-1"></i> Clear
                </a>
            @endif
        </form>
    </div>
</div>

{{-- ── Orders Table ── --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">All Orders</h5>
        <small class="text-muted">Total: {{ $orders->total() }} orders</small>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Phone</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
            @forelse($orders as $order)
            @php
                $firstItem = $order->items->first();
                $imgSrc = asset('backend/assets/img/avatars/1.png');
                if ($firstItem) {
                    $p = $firstItem->product_type === 'hotdeal'
                        ? \App\Models\HotDeal::find($firstItem->product_id)
                        : \App\Models\Product::find($firstItem->product_id);
                    if ($p && $p->image) $imgSrc = asset('storage/' . $p->image);
                }
            @endphp
            <tr>
                {{-- Order ID --}}
                <td>
                    <strong>#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</strong>
                </td>

                {{-- Customer --}}
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <div class="avatar avatar-sm flex-shrink-0">
                            <span class="avatar-initial rounded-circle bg-label-primary" style="font-size:11px;">
                               {{ strtoupper(substr($order->billing_first_name ?? $order->user->name ?? 'U', 0, 2)) }}
                            </span>
                        </div>
                        <div>
                          <div class="fw-semibold" style="font-size:13px;">
    {{ trim(($order->billing_first_name ?? '') . ' ' . ($order->billing_last_name ?? '')) ?: ($order->user->name ?? 'Unknown') }}
</div>
<small class="text-muted">{{ $order->billing_email ?? $order->user->email ?? '' }}</small>
                        </div>
                    </div>
                </td>

                {{-- Items --}}
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <img src="{{ $imgSrc }}"
                             style="width:36px;height:36px;border-radius:8px;object-fit:cover;"
                             onerror="this.src='{{ asset('backend/assets/img/avatars/1.png') }}'">
                        <div>
                            <div style="font-size:12px;font-weight:600;">
                                {{ \Str::limit($firstItem->product_name ?? 'N/A', 18) }}
                            </div>
                            @if($order->items->count() > 1)
                                <small class="text-muted">+{{ $order->items->count() - 1 }} more</small>
                            @endif
                        </div>
                    </div>
                </td>

                {{-- Total --}}
                <td>
                    <span class="fw-bold text-success">৳{{ number_format($order->total_price, 0) }}</span>
                </td>

                {{-- Phone --}}
                <td>{{ $order->phone }}</td>

                {{-- Date --}}
                <td>
                    <div style="font-size:12px;">{{ $order->created_at->format('d M Y') }}</div>
                    <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                </td>

                {{-- Status Badge --}}
                <td>
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
                    <span class="badge bg-label-{{ $badge }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </td>

                {{-- Action --}}
                <td>
                    <a href="{{ route('backend.orders.show', $order->id) }}"
                       class="btn btn-sm btn-outline-primary">
                        <i class="bx bx-show me-1"></i> View
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center py-4 text-muted">
                    <i class="bx bx-receipt fs-3 d-block mb-2"></i>
                    No orders found.
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>

   {{-- Pagination --}}
@if($orders->hasPages())
<div class="card-footer d-flex justify-content-between align-items-center">
    <small class="text-muted">
        Showing {{ $orders->firstItem() }}–{{ $orders->lastItem() }}
        of {{ $orders->total() }} orders
    </small>
    {{ $orders->withQueryString()->links() }}
</div>
@endif
</div>

@endsection