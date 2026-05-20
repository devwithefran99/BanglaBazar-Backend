@extends('backend.layouts.app')
@section('title', 'Return Requests')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Return / Refund Requests</h4>
        <small class="text-muted">Manage customer return & refund requests</small>
    </div>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card text-center">
            <div class="card-body py-3">
                <div class="fs-3 fw-bold text-primary">{{ $stats['total'] }}</div>
                <small class="text-muted">Total</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center">
            <div class="card-body py-3">
                <div class="fs-3 fw-bold text-warning">{{ $stats['pending'] }}</div>
                <small class="text-muted">Pending</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center">
            <div class="card-body py-3">
                <div class="fs-3 fw-bold text-success">{{ $stats['approved'] }}</div>
                <small class="text-muted">Approved</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center">
            <div class="card-body py-3">
                <div class="fs-3 fw-bold text-danger">{{ $stats['rejected'] }}</div>
                <small class="text-muted">Rejected</small>
            </div>
        </div>
    </div>
</div>

{{-- Filter --}}
<div class="card mb-4">
    <div class="card-body py-2">
        <form method="GET" class="d-flex gap-2 flex-wrap">
            <select name="status" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                <option value="all"      {{ request('status','all') == 'all'     ? 'selected':'' }}>All</option>
                <option value="pending"  {{ request('status') == 'pending'  ? 'selected':'' }}>⏳ Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected':'' }}>✅ Approved</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected':'' }}>❌ Rejected</option>
            </select>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">All Requests</h5>
        <small class="text-muted">{{ $requests->total() }} total</small>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Order</th>
                    <th>Type</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @forelse($requests as $req)
            <tr>
                <td><strong>{{ $loop->iteration }}</strong></td>
                <td>
                    <div class="fw-semibold">{{ $req->user->name ?? '—' }}</div>
                    <small class="text-muted">{{ $req->user->email ?? '' }}</small>
                </td>
                <td>
                    <a href="{{ route('backend.orders.show', $req->order_id) }}" class="fw-semibold text-primary">
                        #{{ str_pad($req->order_id, 4, '0', STR_PAD_LEFT) }}
                    </a>
                </td>
                <td>
                    @if($req->type === 'return')
                        <span class="badge bg-label-info">🔄 Return</span>
                    @else
                        <span class="badge bg-label-warning">💰 Refund</span>
                    @endif
                </td>
                <td><small>{{ Str::limit($req->reason, 40) }}</small></td>
                <td>
                    @if($req->status === 'pending')
                        <span class="badge bg-warning text-dark">⏳ Pending</span>
                    @elseif($req->status === 'approved')
                        <span class="badge bg-success">✅ Approved</span>
                    @else
                        <span class="badge bg-danger">❌ Rejected</span>
                    @endif
                </td>
                <td><small class="text-muted">{{ $req->created_at->format('d M Y') }}</small></td>
                <td>
                    <a href="{{ route('backend.return.show', $req->id) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bx bx-show"></i> View
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center py-5 text-muted">
                    <i class="bx bx-inbox fs-1 d-block mb-2"></i>
                    No return requests found.
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($requests->hasPages())
    <div class="card-footer">
        {{ $requests->links() }}
    </div>
    @endif
</div>
@endsection