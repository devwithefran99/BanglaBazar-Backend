@extends('backend.layouts.app')
@section('title', 'Inventory')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
  <h4 class="fw-bold py-3 mb-0">
    <span class="text-muted fw-light">Admin /</span> Inventory
  </h4>
  <a href="{{ route('backend.inventory.create') }}" class="btn btn-primary">
    <i class="bx bx-plus me-1"></i> Add Item
  </a>
</div>

{{-- Summary Cards --}}
<div class="row mb-4">
  <div class="col-lg-3 col-md-6 mb-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <span class="fw-semibold d-block mb-1">Total Items</span>
            <h3 class="card-title mb-1">{{ $stats['total'] }}</h3>
            <small class="text-muted">All SKUs</small>
          </div>
          <span class="avatar-initial rounded bg-label-primary p-2">
            <i class="bx bx-package fs-4"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 mb-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <span class="fw-semibold d-block mb-1">In Stock</span>
            <h3 class="card-title mb-1">{{ $stats['in_stock'] }}</h3>
            <small class="text-success">Healthy level</small>
          </div>
          <span class="avatar-initial rounded bg-label-success p-2">
            <i class="bx bx-check-circle fs-4"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 mb-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <span class="fw-semibold d-block mb-1">Low Stock</span>
            <h3 class="card-title mb-1">{{ $stats['low_stock'] }}</h3>
            <small class="text-warning">Reorder needed</small>
          </div>
          <span class="avatar-initial rounded bg-label-warning p-2">
            <i class="bx bx-error-alt fs-4"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 mb-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <span class="fw-semibold d-block mb-1">Out of Stock</span>
            <h3 class="card-title mb-1">{{ $stats['out_of_stock'] }}</h3>
            <small class="text-danger">Urgent restock</small>
          </div>
          <span class="avatar-initial rounded bg-label-danger p-2">
            <i class="bx bx-x-circle fs-4"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="alert alert-primary d-flex align-items-center mb-4">
  <i class="bx bx-money me-2 fs-5"></i>
  Total Inventory Value: <strong class="ms-1">৳{{ number_format($stats['total_value'], 2) }}</strong>
</div>

{{-- Filters --}}
<div class="card mb-4">
  <div class="card-body py-3">
    <form method="GET" action="{{ route('backend.inventory.index') }}" class="row g-2 align-items-end">
      <div class="col-md-4">
        <input type="text" name="search" class="form-control"
               placeholder="Search name, SKU, supplier..."
               value="{{ request('search') }}">
      </div>
      <div class="col-md-3">
        <select name="category" class="form-select">
          <option value="">All Categories</option>
          @foreach($categories as $cat)
            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
              {{ ucfirst($cat) }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-3">
        <select name="status" class="form-select">
          <option value="">All Status</option>
          <option value="in_stock"     {{ request('status') == 'in_stock'     ? 'selected' : '' }}>In Stock</option>
          <option value="low_stock"    {{ request('status') == 'low_stock'    ? 'selected' : '' }}>Low Stock</option>
          <option value="out_of_stock" {{ request('status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
        </select>
      </div>
      <div class="col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-primary w-100">Filter</button>
        <a href="{{ route('backend.inventory.index') }}" class="btn btn-outline-secondary">Reset</a>
      </div>
    </form>
  </div>
</div>

{{-- Table --}}
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Inventory Items
      <span class="badge bg-label-secondary ms-1">{{ $inventories->total() }}</span>
    </h5>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Product</th>
          <th>SKU</th>
          <th>Category</th>
          <th>Stock</th>
          <th>Price</th>
          <th>Stock Value</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse($inventories as $item)
        <tr>
          <td>
            <div class="d-flex align-items-center gap-2">
             @php
  $imgSrc = null;
  if ($item->product_type === 'hotdeal') {
      $linked = \App\Models\HotDeal::find($item->product_id);
  } else {
      $linked = \App\Models\Product::find($item->product_id);
  }
  if (!empty($linked->image)) {
      $imgSrc = asset('storage/' . $linked->image);
  }
@endphp

@if($imgSrc)
  <img src="{{ $imgSrc }}"
       class="rounded" width="36" height="36" style="object-fit:cover;" alt="">
@else
  <span class="avatar-initial rounded bg-label-secondary"
        style="width:36px;height:36px;display:inline-flex;align-items:center;justify-content:center;">
    <i class="bx bx-package"></i>
  </span>
@endif
              <span class="fw-semibold">{{ $item->name }}</span>
            </div>
          </td>
          <td><code>{{ $item->sku }}</code></td>
          <td><span class="badge bg-label-info">{{ ucfirst($item->category) }}</span></td>
          <td>
            @php $pct = $item->min_stock > 0 ? min(100, round(($item->stock / ($item->min_stock * 3)) * 100)) : 100; @endphp
            <strong class="{{ $item->status === 'in_stock' ? 'text-success' : ($item->status === 'low_stock' ? 'text-warning' : 'text-danger') }}">
              {{ $item->stock }}
            </strong>
            <span class="text-muted small"> {{ $item->unit }}</span>
            <div class="progress mt-1" style="height:4px;width:80px;">
              <div class="progress-bar {{ $item->status === 'in_stock' ? 'bg-success' : ($item->status === 'low_stock' ? 'bg-warning' : 'bg-danger') }}"
                   style="width:{{ $pct }}%"></div>
            </div>
          </td>
          <td>৳{{ number_format($item->price, 2) }}</td>
          <td>৳{{ number_format($item->stock_value, 2) }}</td>
          <td>
            @if($item->status === 'in_stock')
              <span class="badge bg-label-success">In Stock</span>
            @elseif($item->status === 'low_stock')
              <span class="badge bg-label-warning">Low Stock</span>
            @else
              <span class="badge bg-label-danger">Out of Stock</span>
            @endif
          </td>
          <td>
            <div class="dropdown">
              <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                Actions
              </button>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="{{ route('backend.inventory.show', $item) }}">
                    <i class="bx bx-show me-2"></i> View Details
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="{{ route('backend.inventory.edit', $item) }}">
                    <i class="bx bx-edit me-2"></i> Edit
                  </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <form action="{{ route('backend.inventory.destroy', $item) }}" method="POST"
                        onsubmit="return confirm('Delete {{ $item->name }}?')">
                    @csrf @method('DELETE')
                    <button class="dropdown-item text-danger" type="submit">
                      <i class="bx bx-trash me-2"></i> Delete
                    </button>
                  </form>
                </li>
              </ul>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="8" class="text-center py-5 text-muted">
            <i class="bx bx-package fs-1 d-block mb-2"></i>
            No inventory items found.
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($inventories->hasPages())
  <div class="card-footer d-flex justify-content-end">
    {{ $inventories->links() }}
  </div>
  @endif
</div>

@endsection