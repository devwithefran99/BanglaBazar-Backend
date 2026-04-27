@extends('backend.layouts.app')
@section('title', 'All Hot Deals')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
  <h4 class="fw-bold py-3 mb-0">
    <span class="text-muted fw-light">Hot Deals /</span> All Hot Deals
  </h4>
  <a href="{{ route('backend.hotdeals.create') }}" class="btn btn-primary">
    <i class="bx bx-plus me-1"></i> Add Hot Deal
  </a>
</div>

<div class="card">
  <div class="table-responsive text-nowrap">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Image</th>
          <th>Name</th>
          <th>Price</th>
          <th>Deal Ends</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($hotDeals as $deal)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>
            @if($deal->image)
              <img src="{{ asset('storage/' . $deal->image) }}"
                   width="50" height="50" class="rounded" style="object-fit:cover;">
            @else
              <span class="badge bg-label-secondary">No Image</span>
            @endif
          </td>
          <td><strong>{{ $deal->name }}</strong></td>
          <td>
            ৳{{ number_format($deal->price, 2) }}
            @if($deal->hasSale())
              <br><small class="text-muted text-decoration-line-through">
                ৳{{ number_format($deal->old_price, 2) }}
              </small>
              <span class="badge bg-danger ms-1">-{{ $deal->salePercent() }}%</span>
            @endif
          </td>
          <td>
            @if($deal->deal_ends_at)
              @if($deal->isLive())
                <span class="badge bg-label-success">
                  {{ $deal->deal_ends_at->format('d M Y, h:i A') }}
                </span>
              @else
                <span class="badge bg-label-danger">Expired</span>
              @endif
            @else
              <span class="text-muted">No expiry</span>
            @endif
          </td>
          <td>
            @if($deal->is_active)
              <span class="badge bg-label-success">Active</span>
            @else
              <span class="badge bg-label-danger">Inactive</span>
            @endif
          </td>
          <td>
            <a href="{{ route('backend.hotdeals.edit', $deal->id) }}"
               class="btn btn-sm btn-outline-primary me-1">
              <i class="bx bx-edit"></i>
            </a>
            <form action="{{ route('backend.hotdeals.destroy', $deal->id) }}"
                  method="POST" class="d-inline"
                  onsubmit="return confirm('এই Hot Deal টি delete করবেন?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-outline-danger">
                <i class="bx bx-trash"></i>
              </button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" class="text-center py-5">
            <i class="bx bx-purchase-tag-alt fs-1 text-muted d-block mb-2"></i>
            <span class="text-muted">কোনো Hot Deal নেই।</span>
            <br>
            <a href="{{ route('backend.hotdeals.create') }}" class="btn btn-primary btn-sm mt-2">
              প্রথম Hot Deal যোগ করুন
            </a>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($hotDeals->hasPages())
  <div class="card-footer">
    {{ $hotDeals->links() }}
  </div>
  @endif
</div>

@endsection