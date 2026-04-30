
@extends('backend.layouts.app')
@section('title', 'Customers')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
  <div>
    <h4 class="fw-bold mb-1"><i class="bx bx-group me-2 text-primary"></i>Customers</h4>
    <p class="text-muted mb-0" style="font-size:.88rem">All registered users of BanglaBazar</p>
  </div>
  <span class="badge bg-label-primary fs-6 px-3 py-2">
    {{ $customers->total() }} Total
  </span>
</div>

{{-- Stats Cards --}}
<div class="row g-3 mb-4">
  <div class="col-sm-6 col-xl-3">
    <div class="card h-100">
      <div class="card-body d-flex align-items-center gap-3">
        <div class="avatar flex-shrink-0">
          <span class="avatar-initial rounded bg-label-primary">
            <i class="bx bx-user fs-4"></i>
          </span>
        </div>
        <div>
          <small class="text-muted d-block">Total Customers</small>
          <h5 class="mb-0 fw-bold">{{ $customers->total() }}</h5>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card h-100">
      <div class="card-body d-flex align-items-center gap-3">
        <div class="avatar flex-shrink-0">
          <span class="avatar-initial rounded bg-label-success">
            <i class="bx bx-check-circle fs-4"></i>
          </span>
        </div>
        <div>
          <small class="text-muted d-block">Verified Emails</small>
          <h5 class="mb-0 fw-bold">
            {{ $customers->getCollection()->whereNotNull('email_verified_at')->count() }}
          </h5>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card h-100">
      <div class="card-body d-flex align-items-center gap-3">
        <div class="avatar flex-shrink-0">
          <span class="avatar-initial rounded bg-label-warning">
            <i class="bx bx-cart fs-4"></i>
          </span>
        </div>
        <div>
          <small class="text-muted d-block">With Orders</small>
          <h5 class="mb-0 fw-bold">
            {{ $customers->getCollection()->where('orders_count', '>', 0)->count() }}
          </h5>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card h-100">
      <div class="card-body d-flex align-items-center gap-3">
        <div class="avatar flex-shrink-0">
          <span class="avatar-initial rounded bg-label-info">
            <i class="bx bx-calendar fs-4"></i>
          </span>
        </div>
        <div>
          <small class="text-muted d-block">New This Month</small>
          <h5 class="mb-0 fw-bold">
            {{ \App\Models\User::whereMonth('created_at', now()->month)->count() }}
          </h5>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Search Bar --}}
<div class="card mb-3">
  <div class="card-body py-3">
    <div class="row g-2 align-items-center">
      <div class="col-md-6">
        <div class="input-group">
          <span class="input-group-text"><i class="bx bx-search"></i></span>
          <input type="text" id="customerSearch" class="form-control"
                 placeholder="Search by name or email..." />
        </div>
      </div>
      <div class="col-md-3">
        <select id="filterOrder" class="form-select">
          <option value="">All Customers</option>
          <option value="has_orders">With Orders</option>
          <option value="no_orders">No Orders Yet</option>
        </select>
      </div>
    </div>
  </div>
</div>

{{-- Table --}}
<div class="card">
  <div class="table-responsive">
    <table class="table table-hover align-middle" id="customersTable">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Customer</th>
          <th>Email</th>
          <th class="text-center">Orders</th>
          <th class="text-center">Wishlist</th>
          <th>Joined</th>
          <th class="text-center">Status</th>
          <th class="text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($customers as $i => $customer)
          <tr>
            <td class="text-muted" style="font-size:.85rem">
              {{ $customers->firstItem() + $i }}
            </td>

            {{-- Avatar + Name --}}
            <td>
              <div class="d-flex align-items-center gap-2">
                <div class="avatar avatar-sm flex-shrink-0">
                  @if($customer->avatar)
                    <img src="{{ asset('storage/'.$customer->avatar) }}"
                         class="rounded-circle" alt="">
                  @else
                    <span class="avatar-initial rounded-circle bg-label-primary"
                          style="font-size:.85rem">
                      {{ strtoupper(substr($customer->name ?? $customer->email, 0, 1)) }}
                    </span>
                  @endif
                </div>
                <div>
                  <span class="fw-semibold d-block" style="font-size:.9rem">
                    {{ $customer->name ?? '—' }}
                  </span>
                </div>
              </div>
            </td>

            <td style="font-size:.88rem">{{ $customer->email }}</td>

            {{-- Orders count --}}
            <td class="text-center">
              <span class="badge bg-label-{{ $customer->orders_count > 0 ? 'success' : 'secondary' }}">
                {{ $customer->orders_count }}
              </span>
            </td>

            {{-- Wishlist count --}}
            <td class="text-center">
              <span class="badge bg-label-danger">
                {{ $customer->wishlist_items_count ?? 0 }}
              </span>
            </td>

            {{-- Joined --}}
            <td style="font-size:.85rem; color:#888">
              {{ $customer->created_at->format('d M Y') }}
            </td>

            {{-- Verified status --}}
            <td class="text-center">
              @if($customer->email_verified_at)
                <span class="badge bg-label-success">Verified</span>
              @else
                <span class="badge bg-label-warning">Unverified</span>
              @endif
            </td>

            {{-- Actions --}}
            <td class="text-center">
              <a href="{{ route('backend.customers.show', $customer->id) }}"
                 class="btn btn-sm btn-primary px-3">
                <i class="bx bx-show me-1"></i> View
              </a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="8" class="text-center py-5 text-muted">
              <i class="bx bx-user-x fs-1 d-block mb-2"></i>
              No customers found.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Pagination --}}
  @if($customers->hasPages())
    <div class="card-footer d-flex justify-content-between align-items-center">
      <small class="text-muted">
        Showing {{ $customers->firstItem() }}–{{ $customers->lastItem() }}
        of {{ $customers->total() }}
      </small>
      {{ $customers->links() }}
    </div>
  @endif
</div>

@endsection

@push('scripts')
<script>
// Live search
document.getElementById('customerSearch').addEventListener('input', function () {
    const query = this.value.toLowerCase();
    document.querySelectorAll('#customersTable tbody tr').forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(query) ? '' : 'none';
    });
});
</script>
@endpush