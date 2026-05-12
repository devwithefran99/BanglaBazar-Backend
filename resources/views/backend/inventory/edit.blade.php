@extends('backend.layouts.app')
@section('title', 'Edit — ' . $inventory->name)
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
  <h4 class="fw-bold py-3 mb-0">
    <span class="text-muted fw-light">
      <a href="{{ route('backend.inventory.index') }}" class="text-muted">Inventory</a> /
      <a href="{{ route('backend.inventory.show', $inventory) }}" class="text-muted">{{ $inventory->name }}</a> /
    </span> Edit
  </h4>
  <a href="{{ route('backend.inventory.show', $inventory) }}" class="btn btn-outline-secondary">
    <i class="bx bx-arrow-back me-1"></i> Cancel
  </a>
</div>

<form action="{{ route('backend.inventory.update', $inventory) }}" method="POST" enctype="multipart/form-data">
  @csrf @method('PUT')
  <div class="row">
    <div class="col-lg-8">
      <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">Product Information</h5></div>
        <div class="card-body">

          <div class="mb-3">
            <label class="form-label fw-semibold">Product Name <span class="text-danger">*</span></label>
            <input type="text" name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $inventory->name) }}">
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">SKU <span class="text-danger">*</span></label>
              <input type="text" name="sku"
                     class="form-control @error('sku') is-invalid @enderror"
                     value="{{ old('sku', $inventory->sku) }}">
              @error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
              <input type="text" name="category"
                     class="form-control @error('category') is-invalid @enderror"
                     value="{{ old('category', $inventory->category) }}" list="cat-list">
              <datalist id="cat-list">
                @foreach($categories as $cat)
                  <option value="{{ $cat }}">
                @endforeach
              </datalist>
              @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Supplier</label>
            <input type="text" name="supplier" class="form-control"
                   value="{{ old('supplier', $inventory->supplier) }}">
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Description</label>
            <textarea name="description" class="form-control"
                      rows="3">{{ old('description', $inventory->description) }}</textarea>
          </div>

        </div>
      </div>
    </div>

   <div class="col-lg-4">
  <div class="card mb-4">
    <div class="card-header"><h5 class="mb-0">Stock & Pricing</h5></div>
    <div class="card-body">

      <div class="alert alert-info py-2 small mb-3">
        <i class="bx bx-info-circle me-1"></i>
        Current stock: <strong>{{ $inventory->stock }} {{ $inventory->unit }}</strong>.
        Stock পরিবর্তন করতে
        <a href="{{ route('backend.inventory.show', $inventory) }}">details page</a> থেকে Adjust করো।
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">
          Buy Price (৳) <span class="text-danger">*</span>
          <small class="text-muted fw-normal">— supplier থেকে কত টাকায় কিনেছো</small>
        </label>
        <div class="input-group">
          <span class="input-group-text">৳</span>
          <input type="number" name="buy_price" min="0" step="0.01"
                 class="form-control @error('buy_price') is-invalid @enderror"
                 value="{{ old('buy_price', $inventory->buy_price) }}"
                 placeholder="0.00">
        </div>
        @if($inventory->buy_price > 0)
          <div class="form-text text-success">
            Profit per unit: ৳{{ number_format($inventory->price - $inventory->buy_price, 2) }}
            ({{ $inventory->profit_margin }}% margin)
          </div>
        @endif
        @error('buy_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Min. Stock Level <span class="text-danger">*</span></label>
        <input type="number" name="min_stock" min="0"
               class="form-control @error('min_stock') is-invalid @enderror"
               value="{{ old('min_stock', $inventory->min_stock) }}">
        @error('min_stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Unit <span class="text-danger">*</span></label>
        <select name="unit" class="form-select">
          @foreach(['pcs','kg','g','ltr','ml','box','set','pack','ream','dozen'] as $u)
            <option value="{{ $u }}" {{ old('unit', $inventory->unit) == $u ? 'selected' : '' }}>{{ $u }}</option>
          @endforeach
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Supplier</label>
        <input type="text" name="supplier" class="form-control"
               value="{{ old('supplier', $inventory->supplier) }}"
               placeholder="e.g. TechGlobal BD">
      </div>

      <div class="mb-4">
        <label class="form-label fw-semibold">Note</label>
        <textarea name="description" class="form-control" rows="2"
                  placeholder="Optional note...">{{ old('description', $inventory->description) }}</textarea>
      </div>

      <button type="submit" class="btn btn-primary w-100">
        <i class="bx bx-save me-1"></i> Save Changes
      </button>

    </div>
  </div>
</div>
  </div>
</form>

@endsection