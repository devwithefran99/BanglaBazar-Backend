@extends('backend.layouts.app')

@section('title', 'Edit Product')

@section('content')

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold py-3 mb-0">
      <span class="text-muted fw-light">Products /</span> Edit Product
    </h4>
    <a href="{{ route('backend.products.index') }}" class="btn btn-outline-secondary">
      <i class="bx bx-arrow-back me-1"></i> Back to List
    </a>
  </div>

  <div class="row">
    <div class="col-md-8">
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="mb-0"><i class="bx bx-edit me-2"></i>Edit: {{ $product->name }}</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('backend.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="mb-3">
              <label class="form-label fw-semibold">Product Name <span class="text-danger">*</span></label>
              <input type="text" name="name"
                     class="form-control @error('name') is-invalid @enderror"
                     value="{{ old('name', $product->name) }}">
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Category -->
            <div class="mb-3">
              <label class="form-label fw-semibold">Category</label>
              <select name="category" class="form-select">
                <option value="">— Category Select করুন —</option>
                @foreach(['clothing','electronics','food','accessories','other'] as $cat)
                  <option value="{{ $cat }}"
                    {{ old('category', $product->category) == $cat ? 'selected' : '' }}>
                    {{ ucfirst($cat) }}
                  </option>
                @endforeach
              </select>
            </div>

            <!-- Price & Discount -->
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Price (৳) <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text">৳</span>
                  <input type="number" name="price" step="0.01" min="0"
                         class="form-control @error('price') is-invalid @enderror"
                         value="{{ old('price', $product->price) }}">
                  @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Discount Price (৳)</label>
                <div class="input-group">
                  <span class="input-group-text">৳</span>
                  <input type="number" name="old_price" step="0.01" min="0"
                         class="form-control"
                         value="{{ old('old_price', $product->old_price) }}">
                </div>
              </div>
            </div>

            <!-- Stock -->
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Stock Quantity <span class="text-danger">*</span></label>
                <input type="number" name="stock" min="0"
                       class="form-control @error('stock') is-invalid @enderror"
                       value="{{ old('stock', $product->stock) }}">
                @error('stock')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Low Stock Alert</label>
                <input type="number" name="low_stock_threshold" min="0"
                       class="form-control"
                       value="{{ old('low_stock_threshold', $product->low_stock_threshold) }}">
              </div>
            </div>

            <!-- Description -->
            <div class="mb-3">
              <label class="form-label fw-semibold">Description</label>
              <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
            </div>

            <!-- Current Image + New Upload -->
            <div class="mb-4">
              <label class="form-label fw-semibold">Product Image</label>
              @if($product->image)
                <div class="mb-2">
                  <img src="{{ asset('storage/' . $product->image) }}"
                       height="100" style="border-radius: 8px; border: 1px solid #ddd;">
                  <small class="text-muted d-block mt-1">Current image — নতুন upload করলে replace হবে</small>
                </div>
              @endif
              <input type="file" name="image"
                     class="form-control @error('image') is-invalid @enderror"
                     accept="image/jpg,image/jpeg,image/png,image/webp"
                     onchange="previewImage(this)">
              @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <div id="imagePreview" class="mt-2 d-none">
                <img id="previewImg" src="" alt="Preview"
                     style="max-height: 150px; border-radius: 8px;">
              </div>
            </div>

            <!-- Switches -->
            <div class="row mb-4">
              <div class="col-md-6">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" name="is_featured"
                         id="is_featured" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                  <label class="form-check-label" for="is_featured">
                    <i class="bx bx-star text-warning"></i> Featured Product
                  </label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" name="is_active"
                         id="is_active" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                  <label class="form-check-label" for="is_active">
                    <i class="bx bx-check-circle text-success"></i> Active
                  </label>
                </div>
              </div>
            </div>

            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary">
                <i class="bx bx-save me-1"></i> Update করুন
              </button>
              <a href="{{ route('backend.products.index') }}" class="btn btn-outline-secondary">
                Cancel
              </a>
            </div>

          </form>
        </div>
      </div>
    </div>

    <!-- Current Info Summary -->
    <div class="col-md-4">
      <div class="card">
        <div class="card-header">
          <h6 class="mb-0">Product Info</h6>
        </div>
        <div class="card-body">
          <p class="mb-1"><strong>Created:</strong><br>
            <small class="text-muted">{{ $product->created_at->format('d M Y, h:i A') }}</small>
          </p>
          <p class="mb-1"><strong>Last Updated:</strong><br>
            <small class="text-muted">{{ $product->updated_at->format('d M Y, h:i A') }}</small>
          </p>
          @if($product->hasSale())
          <p class="mb-0"><strong>Sale:</strong>
            <span class="badge bg-danger">{{ $product->salePercent() }}% off</span>
          </p>
          @endif
        </div>
      </div>
    </div>
  </div>

@endsection

@push('scripts')
<script>
  function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const img = document.getElementById('previewImg');
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = e => {
        img.src = e.target.result;
        preview.classList.remove('d-none');
      };
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>
@endpush