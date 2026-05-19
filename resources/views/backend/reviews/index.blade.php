@extends('backend.layouts.app')
@section('title', 'Review Management')

@section('content')

<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Admin /</span> Review Management
</h4>

{{-- ── Stats ── --}}
<div class="row mb-4">
    <div class="col-lg-3 col-sm-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="fw-semibold d-block mb-1">Total Reviews</span>
                        <h3 class="card-title mb-2">{{ $stats['total'] }}</h3>
                    </div>
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-primary">
                            <i class="bx bx-star"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 mb-4">
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
    <div class="col-lg-3 col-sm-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="fw-semibold d-block mb-1">Approved</span>
                        <h3 class="card-title mb-2 text-success">{{ $stats['approved'] }}</h3>
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
    <div class="col-lg-3 col-sm-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="fw-semibold d-block mb-1">Rejected</span>
                        <h3 class="card-title mb-2 text-danger">{{ $stats['rejected'] }}</h3>
                    </div>
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-danger">
                            <i class="bx bx-x-circle"></i>
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
        <form method="GET" action="{{ route('backend.reviews.index') }}"
              class="d-flex align-items-center gap-3 flex-wrap">
            <div class="flex-grow-1">
                <input type="text" name="search" class="form-control"
                       placeholder="Search by customer name..."
                       value="{{ request('search') }}">
            </div>
            <div>
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="all"      {{ request('status','all') == 'all'      ? 'selected' : '' }}>All Status</option>
                    <option value="pending"  {{ request('status') == 'pending'  ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="bx bx-search me-1"></i> Search
            </button>
            @if(request('search') || request('status'))
                <a href="{{ route('backend.reviews.index') }}" class="btn btn-outline-secondary">
                    <i class="bx bx-x me-1"></i> Clear
                </a>
            @endif
        </form>
    </div>
</div>

{{-- ── Reviews Table ── --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">All Reviews</h5>
        <small class="text-muted">Total: {{ $reviews->total() }}</small>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Product</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($reviews as $review)
            <tr>
                <td>{{ $loop->iteration }}</td>

                {{-- Customer --}}
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <div class="avatar avatar-sm flex-shrink-0">
                            <span class="avatar-initial rounded-circle bg-label-success"
                                  style="font-size:11px;">
                                {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                            </span>
                        </div>
                        <div>
                            <div class="fw-semibold" style="font-size:13px;">
                                {{ $review->user->name ?? 'Deleted User' }}
                            </div>
                            <div class="text-muted" style="font-size:11px;">
                                {{ $review->user->email ?? '' }}
                            </div>
                        </div>
                    </div>
                </td>

                {{-- Product --}}
                <td>
                    @php
                        $prod = $review->product_type === 'hotdeal'
                            ? \App\Models\HotDeal::find($review->product_id)
                            : \App\Models\Product::find($review->product_id);
                    @endphp
                    <div style="font-size:13px;">
                        {{ $prod->name ?? 'Deleted Product' }}
                    </div>
                    <span class="badge {{ $review->product_type === 'hotdeal' ? 'bg-label-warning' : 'bg-label-primary' }}"
                          style="font-size:10px;">
                        {{ $review->product_type === 'hotdeal' ? 'Hot Deal' : 'Product' }}
                    </span>
                </td>

                {{-- Rating --}}
                <td>
                    <div class="d-flex align-items-center gap-1">
                        @for($s = 1; $s <= 5; $s++)
                            <i class="bx {{ $s <= $review->rating ? 'bxs-star text-warning' : 'bx-star text-muted' }}"
                               style="font-size:14px;"></i>
                        @endfor
                        <span class="ms-1 fw-semibold" style="font-size:12px;">
                            {{ $review->rating }}/5
                        </span>
                    </div>
                </td>

                {{-- Comment --}}
                <td style="max-width:200px;">
                    @if($review->body)
                        <span style="font-size:13px;color:#475569;">
                            {{ Str::limit($review->body, 60) }}
                        </span>
                    @else
                        <span class="text-muted" style="font-size:12px;">No comment</span>
                    @endif
                </td>

                {{-- Date --}}
                <td style="font-size:13px;">
                    {{ $review->created_at->format('d M Y') }}
                </td>

                {{-- Status --}}
                <td>
                    @if($review->status === 'pending')
                        <span class="badge bg-label-warning">Pending</span>
                    @elseif($review->status === 'approved')
                        <span class="badge bg-label-success">Approved</span>
                    @else
                        <span class="badge bg-label-danger">Rejected</span>
                    @endif
                </td>

                {{-- Actions --}}
                <td>
                    <div class="d-flex gap-2">
                        {{-- Approve --}}
                        @if($review->status !== 'approved')
                        <form action="{{ route('backend.reviews.approve', $review) }}"
                              method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-success"
                                    title="Approve">
                                <i class="bx bx-check"></i>
                            </button>
                        </form>
                        @endif

                        {{-- Reject --}}
                        @if($review->status !== 'rejected')
                        <form action="{{ route('backend.reviews.reject', $review) }}"
                              method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-warning"
                                    title="Reject">
                                <i class="bx bx-x"></i>
                            </button>
                        </form>
                        @endif
                       {{-- Featured Toggle --}}
@if($review->status === 'approved')
<button type="button"
        onclick="toggleFeatured({{ $review->id }}, this)"
        class="btn btn-sm {{ $review->featured ? 'btn-warning' : 'btn-outline-secondary' }}"
        title="{{ $review->featured ? 'Remove from homepage' : 'Show on homepage' }}">
    <i class="bx {{ $review->featured ? 'bxs-star' : 'bx-star' }}"></i>
</button>
@endif

                        {{-- Delete --}}
                        <form action="{{ route('backend.reviews.destroy', $review) }}"
                              method="POST"
                              onsubmit="return confirm('Delete this review?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                    title="Delete">
                                <i class="bx bx-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center py-4 text-muted">
                    No reviews found.
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($reviews->hasPages())
    <div class="card-footer">
        {{ $reviews->withQueryString()->links() }}
    </div>
    @endif
</div>
@push('scripts')
<script>
function toggleFeatured(reviewId, btn) {
    fetch(`/admin/reviews/${reviewId}/toggle-featured`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                         || '{{ csrf_token() }}',
            'X-HTTP-Method-Override': 'PATCH',
        },
        body: JSON.stringify({ _method: 'PATCH' }),
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            // Button toggle
            if (data.featured) {
                btn.classList.remove('btn-outline-secondary');
                btn.classList.add('btn-warning');
                btn.querySelector('i').classList.remove('bx-star');
                btn.querySelector('i').classList.add('bxs-star');
                btn.title = 'Remove from homepage';
            } else {
                btn.classList.remove('btn-warning');
                btn.classList.add('btn-outline-secondary');
                btn.querySelector('i').classList.remove('bxs-star');
                btn.querySelector('i').classList.add('bx-star');
                btn.title = 'Show on homepage';
            }
            // Toast show
            showAdminToast(data.message);
        }
    })
    .catch(err => console.error(err));
}

function showAdminToast(msg) {
    const existing = document.querySelector('.admin-toast');
    if (existing) existing.remove();
    const toast = document.createElement('div');
    toast.className = 'admin-toast alert alert-success';
    toast.style.cssText = 'position:fixed;top:20px;right:20px;z-index:9999;min-width:250px;';
    toast.textContent = msg;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}
</script>
@endpush

@endsection