@extends('backend.layouts.app')
@section('title', 'Purchases')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">
            <span class="text-muted fw-light">Suppliers /</span> Purchases
        </h4>
        <p class="text-muted mb-0 small">Supplier থেকে কেনা পণ্যের সম্পূর্ণ রেকর্ড</p>
    </div>
    <a href="{{ route('backend.purchases.create') }}" class="btn btn-success">
        <i class="bx bx-plus me-1"></i> Add Purchase
    </a>
</div>

{{-- ── Stats ── --}}
<div class="row mb-4">
    <div class="col-lg-4 col-sm-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted fw-semibold mb-1 small">Total Purchases</p>
                        <h3 class="fw-bold mb-0">{{ $stats['total_purchases'] }}</h3>
                    </div>
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-success">
                            <i class="bx bx-cart-add fs-4"></i>
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
                        <p class="text-muted fw-semibold mb-1 small">Total Cost</p>
                        <h3 class="fw-bold mb-0">৳{{ number_format($stats['total_cost'], 0) }}</h3>
                    </div>
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-info">
                            <i class="bx bx-money fs-4"></i>
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
                        <p class="text-muted fw-semibold mb-1 small">This Month</p>
                        <h3 class="fw-bold mb-0">৳{{ number_format($stats['this_month'], 0) }}</h3>
                    </div>
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-warning">
                            <i class="bx bx-calendar fs-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── Filters ── --}}
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('backend.purchases.index') }}">
            <div class="row g-2 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bx bx-search text-muted"></i>
                        </span>
                        <input type="text" name="search"
                               class="form-control border-start-0 ps-0"
                               placeholder="Product name দিয়ে খুঁজুন..."
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="supplier_id" class="form-select">
                        <option value="">All Suppliers</option>
                        @foreach($suppliers as $sup)
                            <option value="{{ $sup->id }}"
                                {{ request('supplier_id') == $sup->id ? 'selected' : '' }}>
                                {{ $sup->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-success flex-grow-1">
                        <i class="bx bx-filter-alt me-1"></i> Filter
                    </button>
                    @if(request()->hasAny(['search', 'supplier_id']))
                        <a href="{{ route('backend.purchases.index') }}" class="btn btn-outline-secondary">
                            <i class="bx bx-x"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

{{-- ── Table ── --}}
<div class="card">
    <div class="card-header py-3">
        <h5 class="mb-0 fw-semibold">Purchase Records</h5>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">#</th>
                    <th>Supplier</th>
                    <th>Product Name</th>
                    <th class="text-center">Quantity</th>
                    <th>Buying Price</th>
                    <th>Total Cost</th>
                    <th>Date</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($purchases as $purchase)
                <tr>
                    <td class="ps-4 text-muted small">{{ $purchases->firstItem() + $loop->index }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar avatar-sm flex-shrink-0">
                                <span class="avatar-initial rounded-circle bg-label-success" style="font-size:11px;">
                                    {{ $purchase->supplier->initials ?? '??' }}
                                </span>
                            </div>
                            <span class="fw-semibold small">{{ $purchase->supplier->name ?? '—' }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="fw-semibold">{{ $purchase->product_name }}</span>
                        @if($purchase->notes)
                            <div class="text-muted small">{{ Str::limit($purchase->notes, 30) }}</div>
                        @endif
                    </td>
                    <td class="text-center">
                        <span class="badge bg-label-success px-3">{{ $purchase->quantity }}</span>
                    </td>
                    <td>৳{{ number_format($purchase->buying_price, 2) }}</td>
                    <td>
                        <span class="fw-bold text-success">
                            ৳{{ number_format($purchase->total_cost, 2) }}
                        </span>
                    </td>
                    <td>
                        <span class="small text-muted">
                            <i class="bx bx-calendar me-1"></i>
                            {{ $purchase->purchase_date->format('d M Y') }}
                        </span>
                    </td>
                    <td class="text-center">
                        <form action="{{ route('backend.purchases.destroy', $purchase) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('এই purchase record মুছে ফেলবেন?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-icon btn-text-danger" title="Delete">
                                <i class="bx bx-trash fs-5"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <i class="bx bx-cart bx-lg text-muted mb-3 d-block"></i>
                        <p class="text-muted mb-3">কোনো purchase record নেই।</p>
                        <a href="{{ route('backend.purchases.create') }}" class="btn btn-success btn-sm">
                            <i class="bx bx-plus me-1"></i> প্রথম Purchase যোগ করুন
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($purchases->hasPages())
    <div class="card-footer d-flex justify-content-between align-items-center py-3">
        <small class="text-muted">
            Showing {{ $purchases->firstItem() }}–{{ $purchases->lastItem() }} of {{ $purchases->total() }}
        </small>
        {{ $purchases->links() }}
    </div>
    @endif
</div>

@endsection