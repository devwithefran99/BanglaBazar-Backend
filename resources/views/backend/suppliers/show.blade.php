@extends('backend.layouts.app')
@section('title', $supplier->name)

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">
            <span class="text-muted fw-light">
                <a href="{{ route('backend.suppliers.index') }}" class="text-muted">Suppliers</a> /
            </span> {{ $supplier->name }}
        </h4>
        <p class="text-muted mb-0 small">Supplier এর বিস্তারিত তথ্য</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('backend.suppliers.edit', $supplier) }}" class="btn btn-success">
            <i class="bx bx-edit me-1"></i> Edit
        </a>
        <a href="{{ route('backend.suppliers.index') }}" class="btn btn-outline-secondary">
            <i class="bx bx-arrow-back me-1"></i> Back
        </a>
    </div>
</div>

<div class="row">
    {{-- Left --}}
    <div class="col-lg-8">

        {{-- Profile Card --}}
        <div class="card mb-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-start gap-4 pb-4 border-bottom mb-4">
                    <div class="avatar avatar-xl flex-shrink-0">
                        <span class="avatar-initial rounded-circle bg-label-success fw-bold fs-3">
                            {{ $supplier->initials }}
                        </span>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h5 class="mb-0 fw-semibold">{{ $supplier->name }}</h5>
                            @if($supplier->status === 'active')
                                <span class="badge bg-label-success">Active</span>
                            @else
                                <span class="badge bg-label-secondary">Inactive</span>
                            @endif
                        </div>
                        @if($supplier->phone)
                            <div class="text-muted small mb-1">
                                <i class="bx bx-phone me-1"></i>{{ $supplier->phone }}
                            </div>
                        @endif
                        @if($supplier->address)
                            <div class="text-muted small">
                                <i class="bx bx-map-pin me-1"></i>{{ $supplier->address }}
                            </div>
                        @endif
                    </div>
                    <div class="text-end">
                        <div class="text-muted small">Member since</div>
                        <div class="fw-semibold">{{ $supplier->created_at->format('d M Y') }}</div>
                    </div>
                </div>

                {{-- Stats Row --}}
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="p-3 rounded-3 text-center" style="background:#f8fafc;">
                            <div class="text-muted small mb-1">Total Purchase</div>
                            <div class="fs-5 fw-bold">৳{{ number_format($supplier->total_purchase, 2) }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-3 text-center" style="background:#f0fdf4;">
                            <div class="text-muted small mb-1">Total Paid</div>
                            <div class="fs-5 fw-bold text-success">৳{{ number_format($supplier->total_paid, 2) }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-3 text-center"
                             style="background:{{ $supplier->due_amount > 0 ? '#fef2f2' : '#f0fdf4' }};">
                            <div class="text-muted small mb-1">Due Amount</div>
                            <div class="fs-5 fw-bold {{ $supplier->due_amount > 0 ? 'text-danger' : 'text-success' }}">
                                ৳{{ number_format($supplier->due_amount, 2) }}
                            </div>
                        </div>
                    </div>
                </div>

                @if($supplier->notes)
                <div class="mt-4 pt-3 border-top">
                    <div class="text-muted small mb-1">Notes</div>
                    <p class="mb-0">{{ $supplier->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Recent Purchases --}}
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-semibold">
                    Recent Purchases
                    <span class="badge bg-label-success ms-2">{{ $supplier->purchases->count() }}</span>
                </h5>
                <a href="{{ route('backend.purchases.index') }}?supplier_id={{ $supplier->id }}"
                   class="btn btn-sm btn-outline-success">
                    View All
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Product</th>
                            <th class="text-center">Qty</th>
                            <th>Buying Price</th>
                            <th>Total</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($supplier->purchases->take(5) as $purchase)
                        <tr>
                            <td class="ps-4 fw-semibold">{{ $purchase->product_name }}</td>
                            <td class="text-center">
                                <span class="badge bg-label-success">{{ $purchase->quantity }}</span>
                            </td>
                            <td>৳{{ number_format($purchase->buying_price, 2) }}</td>
                            <td class="fw-bold text-success">৳{{ number_format($purchase->total_cost, 2) }}</td>
                            <td class="text-muted small">{{ $purchase->purchase_date->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="bx bx-cart bx-md mb-2 d-block"></i>
                                কোনো purchase record নেই।
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Recent Payments --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-semibold">
                    Recent Payments
                    <span class="badge bg-label-info ms-2">{{ $supplier->payments->count() }}</span>
                </h5>
                <a href="{{ route('backend.supplier-payments.index') }}?supplier_id={{ $supplier->id }}"
                   class="btn btn-sm btn-outline-success">
                    View All
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Paid Amount</th>
                            <th>Method</th>
                            <th>Date</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($supplier->payments->take(5) as $payment)
                        <tr>
                            <td class="ps-4 fw-bold text-success">৳{{ number_format($payment->paid_amount, 2) }}</td>
                            <td>
                                <span class="badge bg-label-secondary text-capitalize">
                                    @if($payment->method === 'bkash') 📱 bKash
                                    @elseif($payment->method === 'nagad') 📱 Nagad
                                    @elseif($payment->method === 'bank') 🏦 Bank
                                    @else 💵 Cash
                                    @endif
                                </span>
                            </td>
                            <td class="text-muted small">{{ $payment->payment_date->format('d M Y') }}</td>
                            <td class="text-muted small">{{ $payment->note ?? '—' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">
                                <i class="bx bx-wallet bx-md mb-2 d-block"></i>
                                কোনো payment record নেই।
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- Right --}}
    <div class="col-lg-4">

        {{-- Quick Actions --}}
        <div class="card mb-4">
            <div class="card-header py-3">
                <h6 class="mb-0 fw-semibold">Quick Actions</h6>
            </div>
            <div class="card-body d-grid gap-2">
                <a href="{{ route('backend.purchases.create') }}?supplier_id={{ $supplier->id }}"
                   class="btn btn-outline-success">
                    <i class="bx bx-cart-add me-2"></i> Add Purchase
                </a>
                <button type="button" class="btn btn-outline-info"
                        data-bs-toggle="modal" data-bs-target="#quickPaymentModal">
                    <i class="bx bx-money me-2"></i> Add Payment
                </button>
                <a href="{{ route('backend.suppliers.edit', $supplier) }}"
                   class="btn btn-outline-primary">
                    <i class="bx bx-edit me-2"></i> Edit Supplier
                </a>
                @if($supplier->phone)
                <a href="tel:{{ $supplier->phone }}" class="btn btn-outline-secondary">
                    <i class="bx bx-phone me-2"></i> Call Supplier
                </a>
                @endif
                <form action="{{ route('backend.suppliers.destroy', $supplier) }}"
                      method="POST"
                      onsubmit="return confirm('Delete {{ $supplier->name }}?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="bx bx-trash me-2"></i> Delete Supplier
                    </button>
                </form>
            </div>
        </div>

        {{-- Payment Status --}}
        <div class="card">
            <div class="card-header py-3">
                <h6 class="mb-0 fw-semibold">Payment Status</h6>
            </div>
            <div class="card-body text-center py-4">
                @php $st = $supplier->payment_status; @endphp
                @if($st === 'paid')
                    <div class="avatar avatar-lg mb-3 mx-auto">
                        <span class="avatar-initial rounded-circle bg-label-success fs-3">
                            <i class="bx bx-check-double"></i>
                        </span>
                    </div>
                    <h5 class="text-success fw-bold mb-1">Fully Paid</h5>
                    <p class="text-muted small mb-0">কোনো due নেই</p>
                @elseif($st === 'partial')
                    <div class="avatar avatar-lg mb-3 mx-auto">
                        <span class="avatar-initial rounded-circle bg-label-warning fs-3">
                            <i class="bx bx-time"></i>
                        </span>
                    </div>
                    <h5 class="text-warning fw-bold mb-1">Partial Payment</h5>
                    <p class="text-muted small mb-0">৳{{ number_format($supplier->due_amount, 2) }} due আছে</p>
                @else
                    <div class="avatar avatar-lg mb-3 mx-auto">
                        <span class="avatar-initial rounded-circle bg-label-danger fs-3">
                            <i class="bx bx-error"></i>
                        </span>
                    </div>
                    <h5 class="text-danger fw-bold mb-1">Payment Due</h5>
                    <p class="text-muted small mb-0">৳{{ number_format($supplier->due_amount, 2) }} due আছে</p>
                @endif
            </div>
        </div>

    </div>
</div>

{{-- Quick Payment Modal --}}
<div class="modal fade" id="quickPaymentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold">
                    <i class="bx bx-money text-success me-2"></i>Add Payment — {{ $supplier->name }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('backend.supplier-payments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="supplier_id" value="{{ $supplier->id }}">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Paid Amount (৳) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">৳</span>
                            <input type="number" name="paid_amount" min="0.01" step="0.01"
                                   class="form-control" placeholder="0.00" required>
                        </div>
                        @if($supplier->due_amount > 0)
                            <div class="form-text text-danger">
                                Current due: ৳{{ number_format($supplier->due_amount, 2) }}
                            </div>
                        @endif
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Payment Date <span class="text-danger">*</span></label>
                            <input type="date" name="payment_date" class="form-control"
                                   value="{{ now()->format('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Method <span class="text-danger">*</span></label>
                            <select name="method" class="form-select" required>
                                <option value="cash">💵 Cash</option>
                                <option value="bkash">📱 bKash</option>
                                <option value="nagad">📱 Nagad</option>
                                <option value="bank">🏦 Bank</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-1">
                        <label class="form-label fw-semibold">Note <small class="text-muted fw-normal">(optional)</small></label>
                        <textarea name="note" class="form-control" rows="2" placeholder="কোনো অতিরিক্ত তথ্য..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bx bx-check me-1"></i> Save Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection