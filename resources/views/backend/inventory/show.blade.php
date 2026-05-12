@extends('backend.layouts.app')
@section('title', $inventory->name)
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
  <h4 class="fw-bold py-3 mb-0">
    <span class="text-muted fw-light">
      <a href="{{ route('backend.inventory.index') }}" class="text-muted">Inventory</a> /
    </span> {{ $inventory->name }}
  </h4>
  <div class="d-flex gap-2">
    <a href="{{ route('backend.inventory.edit', $inventory) }}" class="btn btn-outline-primary">
      <i class="bx bx-edit me-1"></i> Edit
    </a>
    <a href="{{ route('backend.inventory.index') }}" class="btn btn-outline-secondary">
      <i class="bx bx-arrow-back me-1"></i> Back
    </a>
  </div>
</div>

<div class="row">
  {{-- Left: Product Info --}}
  <div class="col-lg-8">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-start gap-3 pb-3 border-bottom mb-3">
          @if($inventory->image)
            <img src="{{ asset('storage/' . $inventory->image) }}"
                 class="rounded" width="72" height="72" style="object-fit:cover;" alt="">
          @else
            <div style="width:72px;height:72px;border-radius:8px;background:#f0f0f0;display:flex;align-items:center;justify-content:center;">
              <i class="bx bx-package fs-3 text-muted"></i>
            </div>
          @endif
          <div class="flex-grow-1">
            <div class="d-flex align-items-center gap-2 mb-1">
              <h5 class="mb-0 fw-semibold">{{ $inventory->name }}</h5>
              @if($inventory->status === 'in_stock')
                <span class="badge bg-label-success">In Stock</span>
              @elseif($inventory->status === 'low_stock')
                <span class="badge bg-label-warning">Low Stock</span>
              @else
                <span class="badge bg-label-danger">Out of Stock</span>
              @endif
            </div>
            <div class="text-muted small">
              SKU: <code>{{ $inventory->sku }}</code> &nbsp;·&nbsp;
              {{ ucfirst($inventory->category) }} &nbsp;·&nbsp;
              {{ $inventory->supplier ?? '—' }}
            </div>
            @if($inventory->description)
              <p class="text-muted small mt-2 mb-0">{{ $inventory->description }}</p>
            @endif
          </div>
          <div class="text-end">
            <div class="fs-4 fw-bold text-success">৳{{ number_format($inventory->price, 2) }}</div>
            <div class="text-muted small">per {{ $inventory->unit }}</div>
          </div>
        </div>

        <div class="row g-3">
          <div class="col-6 col-md-3">
            <div class="p-3 rounded bg-light text-center">
              <div class="text-muted small mb-1">Current Stock</div>
              <div class="fs-4 fw-bold {{ $inventory->status === 'in_stock' ? 'text-success' : ($inventory->status === 'low_stock' ? 'text-warning' : 'text-danger') }}">
                {{ $inventory->stock }}
              </div>
              <div class="text-muted small">{{ $inventory->unit }}</div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="p-3 rounded bg-light text-center">
              <div class="text-muted small mb-1">Stock Value</div>
              <div class="fs-5 fw-bold">৳{{ number_format($inventory->stock_value, 0) }}</div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="p-3 rounded bg-light text-center">
              <div class="text-muted small mb-1">Min. Stock</div>
              <div class="fs-5 fw-bold">{{ $inventory->min_stock }}</div>
              <div class="text-muted small">{{ $inventory->unit }}</div>
            </div>
          </div>
          <div class="col-6 col-md-3">
  <div class="p-3 rounded bg-light text-center">
    <div class="text-muted small mb-1">Buy Price</div>
    <div class="fs-5 fw-bold text-danger">৳{{ number_format($inventory->buy_price, 2) }}</div>
    <div class="text-muted small">per {{ $inventory->unit }}</div>
  </div>
</div>
<div class="col-6 col-md-3">
  <div class="p-3 rounded bg-light text-center">
    <div class="text-muted small mb-1">Profit / unit</div>
    <div class="fs-5 fw-bold {{ $inventory->profit_per_unit > 0 ? 'text-success' : 'text-danger' }}">
      ৳{{ number_format($inventory->profit_per_unit, 2) }}
    </div>
    <div class="text-muted small">{{ $inventory->profit_margin }}% margin</div>
  </div>
</div>
          <div class="col-6 col-md-3">
            <div class="p-3 rounded bg-light text-center">
              <div class="text-muted small mb-1">Last Updated</div>
              <div class="fw-semibold small">{{ $inventory->updated_at->format('d M Y') }}</div>
            </div>
          </div>
        </div>

        @php
          $pct = $inventory->min_stock > 0
            ? min(100, round(($inventory->stock / ($inventory->min_stock * 3)) * 100))
            : 100;
        @endphp
        <div class="mt-4">
          <div class="d-flex justify-content-between small text-muted mb-1">
            <span>Stock level</span>
            <span>Min: {{ $inventory->min_stock }} {{ $inventory->unit }}</span>
          </div>
          <div class="progress" style="height:8px;">
            <div class="progress-bar {{ $inventory->status === 'in_stock' ? 'bg-success' : ($inventory->status === 'low_stock' ? 'bg-warning' : 'bg-danger') }}"
                 style="width:{{ $pct }}%"></div>
          </div>
        </div>
      </div>
    </div>

    {{-- Movement History --}}
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0"><i class="bx bx-transfer me-2"></i>Stock Movement History</h5>
      </div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Type</th><th>Qty</th><th>Before</th><th>After</th>
              <th>Note</th><th>By</th><th>Date</th>
            </tr>
          </thead>
          <tbody>
            @forelse($inventory->movements as $m)
            <tr>
              <td>
                @if($m->type === 'in')
                  <span class="badge bg-label-success"><i class="bx bx-plus me-1"></i>Stock In</span>
                @elseif($m->type === 'out')
                  <span class="badge bg-label-danger"><i class="bx bx-minus me-1"></i>Stock Out</span>
                @else
                  <span class="badge bg-label-warning"><i class="bx bx-slider me-1"></i>Adjustment</span>
                @endif
              </td>
              <td>
                <strong class="{{ $m->type === 'in' ? 'text-success' : ($m->type === 'out' ? 'text-danger' : 'text-warning') }}">
                  {{ $m->type === 'in' ? '+' : ($m->type === 'out' ? '-' : '±') }}{{ $m->quantity }}
                </strong>
              </td>
              <td class="text-muted">{{ $m->stock_before }}</td>
              <td><strong>{{ $m->stock_after }}</strong></td>
              <td class="text-muted">{{ $m->note ?? '—' }}</td>
              <td class="text-muted small">{{ $m->creator?->name ?? 'System' }}</td>
              <td class="text-muted small">{{ $m->created_at->format('d M Y, h:i A') }}</td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="text-center py-4 text-muted">No movement history yet.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- Right: Adjust Stock --}}
  <div class="col-lg-4">
    <div class="card mb-4">
      <div class="card-header">
        <h5 class="mb-0"><i class="bx bx-transfer-alt me-2"></i>Adjust Stock</h5>
      </div>
      <div class="card-body">
        <form action="{{ route('backend.inventory.adjust-stock', $inventory) }}" method="POST">
          @csrf

          <div class="mb-3">
            <label class="form-label fw-semibold">Movement Type</label>
            <div class="d-flex gap-3">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="type" value="in" id="type_in" checked>
                <label class="form-check-label text-success" for="type_in">Stock In</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="type" value="out" id="type_out">
                <label class="form-check-label text-danger" for="type_out">Stock Out</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="type" value="adjustment" id="type_adj">
                <label class="form-check-label text-warning" for="type_adj">Adjust</label>
              </div>
            </div>
            @error('type') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Quantity</label>
            <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror"
                   min="1" value="{{ old('quantity', 1) }}">
            @error('quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-4">
            <label class="form-label fw-semibold">Note <span class="text-muted fw-normal">(optional)</span></label>
            <input type="text" name="note" class="form-control"
                   placeholder="e.g. Sales order #1042..." value="{{ old('note') }}">
          </div>

          <div class="alert alert-secondary py-2 small mb-3">
            Current stock: <strong>{{ $inventory->stock }} {{ $inventory->unit }}</strong>
          </div>

          <button type="submit" class="btn btn-primary w-100">
            <i class="bx bx-save me-1"></i> Update Stock
          </button>
        </form>
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        <h6 class="fw-semibold mb-3">Item Details</h6>
        <table class="table table-sm table-borderless mb-0">
          <tr>
            <td class="text-muted ps-0">Supplier</td>
            <td class="fw-semibold">{{ $inventory->supplier ?? '—' }}</td>
          </tr>
          <tr>
            <td class="text-muted ps-0">Unit</td>
            <td>{{ $inventory->unit }}</td>
          </tr>
          <tr>
            <td class="text-muted ps-0">Active</td>
            <td>
              @if($inventory->is_active)
                <span class="badge bg-label-success">Yes</span>
              @else
                <span class="badge bg-label-secondary">No</span>
              @endif
            </td>
          </tr>
          <tr>
            <td class="text-muted ps-0">Added</td>
            <td class="small">{{ $inventory->created_at->format('d M Y') }}</td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
document.querySelectorAll('input[name="type"]').forEach(radio => {
    radio.addEventListener('change', () => {
        const label = document.querySelector('label[for="type_adj"]').closest('.form-check').previousElementSibling;
    });
});
</script>
@endpush