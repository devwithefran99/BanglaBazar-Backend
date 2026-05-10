@extends('backend.layouts.app')
@section('title', 'Coupons')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h4 class="fw-bold py-3 mb-0">
    <span class="text-muted fw-light">Management /</span> Coupons
  </h4>
</div>

<div class="row">

  {{-- ADD FORM --}}
  <div class="col-md-4">
    <div class="card mb-4">
      <div class="card-header">
        <h5 class="mb-0"><i class="bx bx-plus-circle me-2"></i>New Coupon</h5>
      </div>
      <div class="card-body">
        <form action="{{ route('backend.coupons.store') }}" method="POST">
          @csrf

          <div class="mb-3">
            <label class="form-label fw-semibold">Coupon Code <span class="text-danger">*</span></label>
            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror"
                   value="{{ old('code') }}" placeholder="যেমন: SUMMER20"
                   style="text-transform:uppercase;">
            @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Discount Type <span class="text-danger">*</span></label>
            <select name="type" class="form-select">
              <option value="percent" {{ old('type') == 'percent' ? 'selected' : '' }}>Percent (%)</option>
              <option value="fixed"   {{ old('type') == 'fixed'   ? 'selected' : '' }}>Fixed (৳)</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Discount Value <span class="text-danger">*</span></label>
            <input type="number" name="value" class="form-control @error('value') is-invalid @enderror"
                   value="{{ old('value') }}" placeholder="20 বা 50" min="1" step="0.01">
            @error('value')<div class="invalid-feedback">{{ $message }}</div>@enderror
            <small class="text-muted">Percent হলে 20 = 20%, Fixed হলে 50 = ৳50</small>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Minimum Order (৳)</label>
            <input type="number" name="min_order" class="form-control"
                   value="{{ old('min_order', 0) }}" min="0" step="0.01">
            <small class="text-muted">0 = কোনো minimum নেই</small>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Max Uses</label>
            <input type="number" name="max_uses" class="form-control"
                   value="{{ old('max_uses', 0) }}" min="0">
            <small class="text-muted">0 = unlimited</small>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Expires At</label>
            <input type="date" name="expires_at" class="form-control"
                   value="{{ old('expires_at') }}">
            <small class="text-muted">খালি রাখলে কোনো expiry নেই</small>
          </div>

          <div class="mb-3">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked>
              <label class="form-check-label" for="is_active">Active</label>
            </div>
          </div>

          <button type="submit" class="btn btn-primary w-100">
            <i class="bx bx-save me-1"></i> Save Coupon
          </button>
        </form>
      </div>
    </div>
  </div>

  {{-- COUPON LIST --}}
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0"><i class="bx bx-purchase-tag me-2"></i>All Coupons ({{ $coupons->count() }})</h5>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="table-light">
              <tr>
                <th>Code</th>
                <th>Type</th>
                <th>Value</th>
                <th>Min Order</th>
                <th>Uses</th>
                <th>Expires</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse($coupons as $coupon)
              <tr>
                <td><code class="fw-bold">{{ $coupon->code }}</code></td>
                <td>
                  @if($coupon->type === 'percent')
                    <span class="badge bg-info">Percent</span>
                  @else
                    <span class="badge bg-warning text-dark">Fixed</span>
                  @endif
                </td>
                <td>
                  @if($coupon->type === 'percent')
                    {{ $coupon->value }}%
                  @else
                    ৳{{ number_format($coupon->value, 2) }}
                  @endif
                </td>
                <td>৳{{ number_format($coupon->min_order, 2) }}</td>
                <td>
                  {{ $coupon->used_count }}
                  @if($coupon->max_uses > 0)
                    / {{ $coupon->max_uses }}
                  @else
                    / ∞
                  @endif
                </td>
                <td>
                  @if($coupon->expires_at)
                    <span class="{{ $coupon->expires_at->isPast() ? 'text-danger' : 'text-success' }}">
                      {{ $coupon->expires_at->format('d M Y') }}
                    </span>
                  @else
                    <span class="text-muted">No expiry</span>
                  @endif
                </td>
                <td>
                  <form action="{{ route('backend.coupons.toggle', $coupon->id) }}"
                        method="POST" style="display:inline;">
                    @csrf @method('PATCH')
                    <button type="submit" class="badge border-0 {{ $coupon->is_active ? 'bg-success' : 'bg-secondary' }}"
                            style="cursor:pointer;">
                      {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                    </button>
                  </form>
                </td>
                <td>
                  <form action="{{ route('backend.coupons.destroy', $coupon->id) }}"
                        method="POST" style="display:inline;"
                        onsubmit="return confirm('Delete করবেন?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">
                      <i class="bx bx-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="8" class="text-center py-4 text-muted">
                  কোনো coupon নেই।
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection