@extends('backend.layouts.app')
@section('title', 'Invoices')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Invoices</h4>
        <p class="text-muted mb-0 small">Order, Purchase এবং Payment এর সকল invoices</p>
    </div>
</div>

{{-- ── Stats ── --}}
<div class="row mb-4">
    <div class="col-lg-4 col-sm-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted fw-semibold mb-1 small text-uppercase" style="font-size:11px;letter-spacing:.5px;">Order Invoices</p>
                        <h3 class="fw-bold mb-0">{{ $totalOrders }}</h3>
                        <small class="text-muted">Confirmed / Shipped / Delivered</small>
                    </div>
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-primary">
                            <i class="bx bx-receipt fs-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-sm-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted fw-semibold mb-1 small text-uppercase" style="font-size:11px;letter-spacing:.5px;">Purchase Invoices</p>
                        <h3 class="fw-bold mb-0">{{ $totalPurchases }}</h3>
                        <small class="text-muted">Supplier থেকে কেনা পণ্য</small>
                    </div>
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-success">
                            <i class="bx bx-cart fs-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-sm-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted fw-semibold mb-1 small text-uppercase" style="font-size:11px;letter-spacing:.5px;">Payment Invoices</p>
                        <h3 class="fw-bold mb-0">{{ $totalPayments }}</h3>
                        <small class="text-muted">Supplier কে করা payment</small>
                    </div>
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-warning">
                            <i class="bx bx-money fs-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">

    {{-- ── Order Invoices ── --}}
    <div class="col-12 col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-semibold">Order Invoices</h5>
                <a href="{{ route('backend.orders.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Order</th>
                            <th>Customer</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td class="ps-3">
                                <div class="fw-semibold small">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</div>
                                <div class="text-muted" style="font-size:11px;">{{ $order->created_at->format('d M Y') }}</div>
                            </td>
                            <td>
                                <div class="small fw-semibold">{{ $order->user->name ?? 'Guest' }}</div>
                                <div class="text-muted" style="font-size:11px;">৳{{ number_format($order->total_price, 0) }}</div>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('backend.orders.invoice', $order->id) }}"
                                   target="_blank"
                                   class="btn btn-sm btn-icon btn-text-primary"
                                   title="Print Invoice">
                                    <i class="bx bx-printer fs-5"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-muted small">কোনো order নেই।</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ── Purchase Invoices ── --}}
    <div class="col-12 col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-semibold">Purchase Invoices</h5>
                <a href="{{ route('backend.purchases.index') }}" class="btn btn-sm btn-outline-success">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Supplier</th>
                            <th>Product</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPurchases as $purchase)
                        <tr>
                            <td class="ps-3">
                                <div class="fw-semibold small">{{ $purchase->supplier->name ?? '—' }}</div>
                                <div class="text-muted" style="font-size:11px;">{{ $purchase->purchase_date->format('d M Y') }}</div>
                            </td>
                            <td>
                                <div class="small fw-semibold">{{ Str::limit($purchase->product_name, 18) }}</div>
                                <div class="text-muted" style="font-size:11px;">Qty: {{ $purchase->quantity }}</div>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('backend.suppliers.purchase-invoice', $purchase->supplier_id) }}"
                                   target="_blank"
                                   class="btn btn-sm btn-icon btn-text-success"
                                   title="Print Invoice">
                                    <i class="bx bx-printer fs-5"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-muted small">কোনো purchase নেই।</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ── Payment Invoices ── --}}
    <div class="col-12 col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-semibold">Payment Invoices</h5>
                <a href="{{ route('backend.supplier-payments.index') }}" class="btn btn-sm btn-outline-warning">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Supplier</th>
                            <th>Amount</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPayments as $payment)
                        <tr>
                            <td class="ps-3">
                                <div class="fw-semibold small">{{ $payment->supplier->name ?? '—' }}</div>
                                <div class="text-muted" style="font-size:11px;">{{ $payment->payment_date->format('d M Y') }}</div>
                            </td>
                            <td>
                                <div class="small fw-semibold text-success">৳{{ number_format($payment->paid_amount, 0) }}</div>
                                <div class="text-muted" style="font-size:11px;">{{ ucfirst($payment->method ?? 'cash') }}</div>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('backend.suppliers.payment-invoice', $payment->supplier_id) }}"
                                   target="_blank"
                                   class="btn btn-sm btn-icon btn-text-warning"
                                   title="Print Invoice">
                                    <i class="bx bx-printer fs-5"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-muted small">কোনো payment নেই।</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection