@extends('backend.layouts.app')

@section('title', 'Add Product')

@section('content')

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold py-3 mb-0">
      <span class="text-muted fw-light">Products /</span> Add New Product
    </h4>
    <a href="{{ route('backend.products.index') }}" class="btn btn-outline-secondary">
      <i class="bx bx-arrow-back me-1"></i> Back to List
    </a>
  </div>

  <div class="row">
    <div class="col-md-8">

      <!-- Main Info -->
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="mb-0"><i class="bx bx-info-circle me-2"></i>Product Information</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('backend.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Name -->
            <div class="mb-3">
              <label class="form-label fw-semibold">Product Name <span class="text-danger">*</span></label>
              <input type="text" name="name"
                     class="form-control @error('name') is-invalid @enderror"
                     value="{{ old('name') }}"
                     placeholder="যেমন: Premium Cotton T-Shirt">
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Category -->
            <div class="mb-3">
              <label class="form-label fw-semibold">Category</label>
              <select name="category" class="form-select">
                <option value="">— Category Select করুন —</option>
                <option value="clothing" {{ old('category') == 'clothing' ? 'selected' : '' }}>Clothing</option>
                <option value="electronics" {{ old('category') == 'electronics' ? 'selected' : '' }}>Electronics</option>
                <option value="food" {{ old('category') == 'food' ? 'selected' : '' }}>Food</option>
                <option value="accessories" {{ old('category') == 'accessories' ? 'selected' : '' }}>Accessories</option>
                <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
              </select>
            </div>

            <!-- Price & Discount Price -->
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Price (৳) <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text">৳</span>
                  <input type="number" name="price" step="0.01" min="0"
                         class="form-control @error('price') is-invalid @enderror"
                         value="{{ old('price') }}"
                         placeholder="0.00">
                  @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Discount Price (৳)
                  <small class="text-muted">(optional)</small>
                </label>
                <div class="input-group">
                  <span class="input-group-text">৳</span>
                  <input type="number" name="old_price" step="0.01" min="0"
                         class="form-control"
                         value="{{ old('old_price') }}"
                         placeholder="0.00">
                </div>
                <small class="text-muted">এখানে আসল দাম দিন, price-এ sale দাম</small>
              </div>
            </div>

            <!-- Stock & Threshold -->
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Stock Quantity <span class="text-danger">*</span></label>
                <input type="number" name="stock" min="0"
                       class="form-control @error('stock') is-invalid @enderror"
                       value="{{ old('stock', 0) }}">
                @error('stock')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Low Stock Alert
                  <small class="text-muted">(default: 5)</small>
                </label>
                <input type="number" name="low_stock_threshold" min="0"
                       class="form-control"
                       value="{{ old('low_stock_threshold', 5) }}">
              </div>
            </div>

            <!-- Description -->
            <div class="mb-3">
              <label class="form-label fw-semibold">Description</label>
              <textarea name="description" class="form-control" rows="4"
                        placeholder="Product সম্পর্কে বিস্তারিত লিখুন...">{{ old('description') }}</textarea>
            </div>

            <!-- Image Upload -->
            <div class="mb-4">
              <label class="form-label fw-semibold">Product Image</label>
              <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                     accept="image/jpg,image/jpeg,image/png,image/webp"
                     onchange="previewImage(this)">
              @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <div id="imagePreview" class="mt-2 d-none">
                <img id="previewImg" src="" alt="Preview"
                     style="max-height: 150px; border-radius: 8px; border: 1px solid #ddd;">
              </div>
            </div>

            <!-- Switches -->
            <div class="row mb-4">
              <div class="col-md-6">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" name="is_featured"
                         id="is_featured" {{ old('is_featured') ? 'checked' : '' }}>
                  <label class="form-check-label" for="is_featured">
                    <i class="bx bx-star text-warning"></i> Featured Product
                  </label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" name="is_active"
                         id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                  <label class="form-check-label" for="is_active">
                    <i class="bx bx-check-circle text-success"></i> Active (Website এ দেখাবে)
                  </label>
                </div>
              </div>
            </div>

            <!-- Submit -->
            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary">
                <i class="bx bx-save me-1"></i> Product Save করুন
              </button>
              <a href="{{ route('backend.products.index') }}" class="btn btn-outline-secondary">
                Cancel
              </a>
            </div>

          </form>
        </div>
      </div>

    </div>

    <!-- Right Side Tips -->
    <div class="col-md-4">
      <div class="card border-0 bg-label-info">
        <div class="card-body">
          <h6 class="fw-bold mb-3"><i class="bx bx-bulb me-1"></i> Tips</h6>
          <ul class="mb-0 ps-3 small">
            <li class="mb-2">Product name স্পষ্ট ও সংক্ষিপ্ত রাখুন।</li>
            <li class="mb-2">Discount দিতে চাইলে <strong>Discount Price</strong>-এ আসল দাম, <strong>Price</strong>-এ sale দাম দিন।</li>
            <li class="mb-2">Image সর্বোচ্চ <strong>2MB</strong>, JPG/PNG/WEBP format।</li>
            <li class="mb-2">Featured করলে homepage-এ highlight হবে।</li>
            <li>Active না করলে website-এ দেখাবে না।</li>
          </ul>
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