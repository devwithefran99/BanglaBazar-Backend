@extends('backend.layouts.app')
@section('title', 'Supplier Payments')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">
            <span class="text-muted fw-light">Suppliers /</span> Payments
        </h4>
        <p class="text-muted mb-0 small">Supplier দের payment এর সম্পূর্ণ ইতিহাস</p>
    </div>
    {{-- Add Payment Modal Trigger --}}
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPaymentModal">
        <i class="bx bx-plus me-1"></i> Add Payment
    </button>
</div>

{{-- ── Stats ── --}}
<div class="row mb-4">
    <div class="col-lg-4 col-sm-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted fw-semibold mb-1 small">Total Paid</p>
                        <h3 class="fw-bold mb-0 text-success">৳{{ number_format($stats['total_paid'], 0) }}</h3>
                    </div>
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-success">
                            <i class="bx bx-check-double fs-4"></i>
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
                        <p class="text-muted fw-semibold mb-1 small">This Month Paid</p>
                        <h3 class="fw-bold mb-0">৳{{ number_format($stats['this_month'], 0) }}</h3>
                    </div>
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-info">
                            <i class="bx bx-calendar-check fs-4"></i>
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
                        <p class="text-muted fw-semibold mb-1 small">Total Due</p>
                        <h3 class="fw-bold mb-0 text-danger">৳{{ number_format($stats['total_due'], 0) }}</h3>
                    </div>
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-danger">
                            <i class="bx bx-wallet fs-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── Filter ── --}}
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('backend.supplier-payments.index') }}">
            <div class="row g-2 align-items-center">
                <div class="col-md-6">
                    <select name="supplier_id" class="form-select">
                        <option value="">All Suppliers</option>
                        @foreach($suppliers as $sup)
                            <option value="{{ $sup->id }}"
                                {{ request('supplier_id') == $sup->id ? 'selected' : '' }}>
                                {{ $sup->name }} — Due: ৳{{ number_format($sup->due_amount, 2) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-success flex-grow-1">
                        <i class="bx bx-filter-alt me-1"></i> Filter
                    </button>
                    @if(request('supplier_id'))
                        <a href="{{ route('backend.supplier-payments.index') }}" class="btn btn-outline-secondary">
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
        <h5 class="mb-0 fw-semibold">Payment History</h5>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">#</th>
                    <th>Supplier Name</th>
                    <th>Paid Amount</th>
                    <th>Due Amount</th>
                    <th>Method</th>
                    <th>Payment Date</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr>
                    <td class="ps-4 text-muted small">{{ $payments->firstItem() + $loop->index }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar avatar-sm flex-shrink-0">
                                <span class="avatar-initial rounded-circle bg-label-success" style="font-size:11px;">
                                    {{ $payment->supplier->initials ?? '??' }}
                                </span>
                            </div>
                            <span class="fw-semibold small">{{ $payment->supplier->name ?? '—' }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="fw-bold text-success">৳{{ number_format($payment->paid_amount, 2) }}</span>
                    </td>
                    <td>
                        @php $due = $payment->supplier->due_amount ?? 0; @endphp
                        @if($due > 0)
                            <span class="text-danger fw-semibold">৳{{ number_format($due, 2) }}</span>
                        @else
                            <span class="text-success small"><i class="bx bx-check-circle me-1"></i>Clear</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-label-secondary text-capitalize">
                            @if($payment->method === 'bkash') 📱 bKash
                            @elseif($payment->method === 'nagad') 📱 Nagad
                            @elseif($payment->method === 'bank') 🏦 Bank
                            @else 💵 Cash
                            @endif
                        </span>
                    </td>
                    <td>
                        <span class="small text-muted">
                            <i class="bx bx-calendar me-1"></i>
                            {{ $payment->payment_date->format('d M Y') }}
                        </span>
                    </td>
                    <td class="text-center">
                        @php $st = $payment->supplier->payment_status ?? 'due'; @endphp
                        @if($st === 'paid')
                            <span class="badge bg-label-success px-3 py-2">Paid</span>
                        @elseif($st === 'partial')
                            <span class="badge bg-label-warning px-3 py-2">Partial</span>
                        @else
                            <span class="badge bg-label-danger px-3 py-2">Due</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <form action="{{ route('backend.supplier-payments.destroy', $payment) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('এই payment record মুছে ফেলবেন?')">
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
                        <i class="bx bx-wallet bx-lg text-muted mb-3 d-block"></i>
                        <p class="text-muted mb-3">কোনো payment record নেই।</p>
                        <button type="button" class="btn btn-success btn-sm"
                                data-bs-toggle="modal" data-bs-target="#addPaymentModal">
                            <i class="bx bx-plus me-1"></i> প্রথম Payment যোগ করুন
                        </button>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($payments->hasPages())
    <div class="card-footer d-flex justify-content-between align-items-center py-3">
        <small class="text-muted">
            Showing {{ $payments->firstItem() }}–{{ $payments->lastItem() }} of {{ $payments->total() }}
        </small>
        {{ $payments->links() }}
    </div>
    @endif
</div>

{{-- ── Add Payment Modal ── --}}
<div class="modal fade" id="addPaymentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold">
                    <i class="bx bx-money text-success me-2"></i>Add Payment
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('backend.supplier-payments.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Supplier <span class="text-danger">*</span></label>
                        <select name="supplier_id" class="form-select" required>
                            <option value="">— Supplier বেছে নিন —</option>
                            @foreach($suppliers as $sup)
                                <option value="{{ $sup->id }}"
                                    {{ request('supplier_id') == $sup->id ? 'selected' : '' }}>
                                    {{ $sup->name }}
                                    @if($sup->due_amount > 0)
                                        — Due: ৳{{ number_format($sup->due_amount, 2) }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Paid Amount (৳) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">৳</span>
                            <input type="number" name="paid_amount" min="0.01" step="0.01"
                                   class="form-control" placeholder="0.00" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Payment Date <span class="text-danger">*</span></label>
                            <input type="date" name="payment_date"
                                   class="form-control"
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
                        <textarea name="note" class="form-control" rows="2"
                                  placeholder="কোনো অতিরিক্ত তথ্য..."></textarea>
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