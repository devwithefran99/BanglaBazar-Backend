@extends('backend.layouts.app')
@section('title', 'Return Request Detail')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Request Detail</h4>
        <small class="text-muted">Review and take action</small>
    </div>
    <a href="{{ route('backend.return.index') }}" class="btn btn-outline-secondary">
        <i class="bx bx-arrow-back me-1"></i> Back
    </a>
</div>

<div class="row g-4">

    {{-- LEFT: Request Info --}}
    <div class="col-12 col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="bx bx-rotate-left me-2"></i>Request Info</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label class="text-muted small">Type</label>
                        <div>
                            @if($returnRequest->type === 'return')
                                <span class="badge bg-label-info fs-6">🔄 Return</span>
                            @else
                                <span class="badge bg-label-warning fs-6">💰 Refund</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label class="text-muted small">Status</label>
                        <div>
                            @if($returnRequest->status === 'pending')
                                <span class="badge bg-warning text-dark fs-6">⏳ Pending</span>
                            @elseif($returnRequest->status === 'approved')
                                <span class="badge bg-success fs-6">✅ Approved</span>
                            @else
                                <span class="badge bg-danger fs-6">❌ Rejected</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="text-muted small">Reason</label>
                        <div class="fw-semibold">{{ $returnRequest->reason }}</div>
                    </div>
                    @if($returnRequest->description)
                    <div class="col-12">
                        <label class="text-muted small">Description</label>
                        <div class="p-3 bg-light rounded">{{ $returnRequest->description }}</div>
                    </div>
                    @endif
                    @if($returnRequest->admin_note)
                    <div class="col-12">
                        <label class="text-muted small">Admin Note</label>
                        <div class="p-3 bg-light rounded text-muted">{{ $returnRequest->admin_note }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Order Items --}}
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bx bx-receipt me-2"></i>
                    Order #{{ str_pad($returnRequest->order_id, 4, '0', STR_PAD_LEFT) }}
                </h5>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($returnRequest->order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>৳{{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-end fw-bold">Total</td>
                            <td class="fw-bold text-primary">৳{{ number_format($returnRequest->order->total_price, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- RIGHT: Customer + Action --}}
    <div class="col-12 col-lg-4">

        {{-- Customer Info --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="bx bx-user me-2"></i>Customer</h5>
            </div>
            <div class="card-body">
                <div class="fw-bold">{{ $returnRequest->user->name ?? '—' }}</div>
                <div class="text-muted small mb-3">{{ $returnRequest->user->email ?? '' }}</div>
                <div class="text-muted small mb-1">
                    <i class="bx bx-calendar me-1"></i>
                    Submitted: {{ $returnRequest->created_at->format('d M Y, h:i A') }}
                </div>
            </div>
        </div>

        {{-- Action (শুধু pending হলে দেখাবে) --}}
        @if($returnRequest->status === 'pending')
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bx bx-check-shield me-2"></i>Take Action</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('backend.return.action', $returnRequest->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small">Admin Note <span class="text-muted">(optional)</span></label>
                        <textarea name="admin_note" class="form-control" rows="3"
                                  placeholder="Write a note for the customer..."></textarea>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" name="status" value="approved"
                                class="btn btn-success"
                                onclick="return confirm('Approve this request?')">
                            <i class="bx bx-check me-1"></i> Approve
                        </button>
                        <button type="submit" name="status" value="rejected"
                                class="btn btn-danger"
                                onclick="return confirm('Reject this request?')">
                            <i class="bx bx-x me-1"></i> Reject
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @else
        <div class="alert alert-{{ $returnRequest->status === 'approved' ? 'success' : 'danger' }}">
            <i class="bx bx-info-circle me-1"></i>
            This request has been <strong>{{ $returnRequest->status }}</strong>.
        </div>
        @endif

    </div>
</div>
@endsection