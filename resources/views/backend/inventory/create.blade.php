@extends('backend.layouts.app')
@section('title', 'Add Inventory Item')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
  <h4 class="fw-bold py-3 mb-0">
    <span class="text-muted fw-light">
      <a href="{{ route('backend.inventory.index') }}" class="text-muted">Inventory</a> /
    </span> Add Item
  </h4>
  <a href="{{ route('backend.inventory.index') }}" class="btn btn-outline-secondary">
    <i class="bx bx-arrow-back me-1"></i> Back
  </a>
</div>

<form action="{{ route('backend.inventory.store') }}" method="POST" enctype="multipart/form-data">
  @csrf
  <div class="row">
    <div class="col-lg-8">
      <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">Product Information</h5></div>
        <div class="card-body">

          <div class="mb-3">
            <label class="form-label fw-semibold">Product Name <span class="text-danger">*</span></label>
            <input type="text" name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name') }}" placeholder="e.g. Wireless Headphones">
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">SKU <span class="text-danger">*</span></label>
              <input type="text" name="sku"
                     class="form-control @error('sku') is-invalid @enderror"
                     value="{{ old('sku') }}" placeholder="e.g. WH-001">
              @error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
              <input type="text" name="category"
                     class="form-control @error('category') is-invalid @enderror"
                     value="{{ old('category') }}" list="cat-list" placeholder="e.g. Electronics">
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
                   value="{{ old('supplier') }}" placeholder="e.g. TechGlobal BD">
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Description</label>
            <textarea name="description" class="form-control" rows="3"
                      placeholder="Optional...">{{ old('description') }}</textarea>
          </div>

        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">Stock & Pricing</h5></div>
        <div class="card-body">

          <div class="mb-3">
            <label class="form-label fw-semibold">Initial Stock <span class="text-danger">*</span></label>
            <input type="number" name="stock" min="0"
                   class="form-control @error('stock') is-invalid @enderror"
                   value="{{ old('stock', 0) }}">
            @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Min. Stock Level <span class="text-danger">*</span></label>
            <input type="number" name="min_stock" min="0"
                   class="form-control @error('min_stock') is-invalid @enderror"
                   value="{{ old('min_stock', 5) }}">
            <div class="form-text">Low stock alert threshold</div>
            @error('min_stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Price (৳) <span class="text-danger">*</span></label>
            <input type="number" name="price" min="0" step="0.01"
                   class="form-control @error('price') is-invalid @enderror"
                   value="{{ old('price') }}" placeholder="0.00">
            @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Unit <span class="text-danger">*</span></label>
            <select name="unit" class="form-select">
              @foreach(['pcs','kg','g','ltr','ml','box','set','pack','ream','dozen'] as $u)
                <option value="{{ $u }}" {{ old('unit') == $u ? 'selected' : '' }}>{{ $u }}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Image</label>
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="form-check form-switch mb-4">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked>
            <label class="form-check-label" for="is_active">Active</label>
          </div>

          <button type="submit" class="btn btn-primary w-100">
            <i class="bx bx-save me-1"></i> Save Item
          </button>

        </div>
      </div>
    </div>
  </div>
</form>

@endsection