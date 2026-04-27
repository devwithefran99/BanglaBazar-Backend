@extends('backend.layouts.app')
@section('title', 'Add Hot Deal')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
  <h4 class="fw-bold py-3 mb-0">
    <span class="text-muted fw-light">Hot Deals /</span> Add New Hot Deal
  </h4>
  <a href="{{ route('backend.hotdeals.index') }}" class="btn btn-outline-secondary">
    <i class="bx bx-arrow-back me-1"></i> Back to List
  </a>
</div>

<div class="row">
  <div class="col-md-8">
    <div class="card mb-4">
      <div class="card-header">
        <h5 class="mb-0"><i class="bx bx-purchase-tag-alt me-2"></i>Hot Deal Information</h5>
      </div>
      <div class="card-body">
        <form action="{{ route('backend.hotdeals.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="mb-3">
            <label class="form-label fw-semibold">Product Name <span class="text-danger">*</span></label>
            <input type="text" name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name') }}" placeholder="যেমন: Fresh Apple Bundle">
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Category</label>
            <select name="category" class="form-select">
              <option value="">— Category Select করুন —</option>
              @foreach(['clothing','electronics','food','accessories','other'] as $cat)
                <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>
                  {{ ucfirst($cat) }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Sale Price (৳) <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text">৳</span>
                <input type="number" name="price" step="0.01" min="0"
                       class="form-control @error('price') is-invalid @enderror"
                       value="{{ old('price') }}" placeholder="0.00">
                @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Original Price (৳) <small class="text-muted">(optional)</small></label>
              <div class="input-group">
                <span class="input-group-text">৳</span>
                <input type="number" name="old_price" step="0.01" min="0"
                       class="form-control" value="{{ old('old_price') }}" placeholder="0.00">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Stock <span class="text-danger">*</span></label>
              <input type="number" name="stock" min="0"
                     class="form-control @error('stock') is-invalid @enderror"
                     value="{{ old('stock', 0) }}">
              @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Low Stock Alert <small class="text-muted">(default: 5)</small></label>
              <input type="number" name="low_stock_threshold" min="0"
                     class="form-control" value="{{ old('low_stock_threshold', 5) }}">
            </div>
          </div>

          {{-- Deal End Date --}}
          <div class="mb-3">
            <label class="form-label fw-semibold">
              <i class="bx bx-timer text-danger"></i> Deal End Date & Time
              <small class="text-muted">(Countdown timer এর জন্য)</small>
            </label>
            <input type="datetime-local" name="deal_ends_at"
                   class="form-control @error('deal_ends_at') is-invalid @enderror"
                   value="{{ old('deal_ends_at') }}">
            @error('deal_ends_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Description</label>
            <textarea name="description" class="form-control" rows="3"
                      placeholder="Product সম্পর্কে বিস্তারিত...">{{ old('description') }}</textarea>
          </div>

          <div class="mb-4">
            <label class="form-label fw-semibold">Product Image</label>
            <input type="file" name="image"
                   class="form-control @error('image') is-invalid @enderror"
                   accept="image/jpg,image/jpeg,image/png,image/webp"
                   onchange="previewImage(this)">
            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
            <div id="imagePreview" class="mt-2 d-none">
              <img id="previewImg" src="" style="max-height:150px; border-radius:8px; border:1px solid #ddd;">
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-md-6">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_best_sale"
                       id="is_best_sale" {{ old('is_best_sale') ? 'checked' : '' }}>
                <label class="form-check-label" for="is_best_sale">
                  <i class="bx bx-trophy text-warning"></i> Best Sale Badge দেখাবে
                </label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_active"
                       id="is_active" checked>
                <label class="form-check-label" for="is_active">
                  <i class="bx bx-check-circle text-success"></i> Active
                </label>
              </div>
            </div>
          </div>

          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
              <i class="bx bx-save me-1"></i> Hot Deal Save করুন
            </button>
            <a href="{{ route('backend.hotdeals.index') }}" class="btn btn-outline-secondary">Cancel</a>
          </div>

        </form>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card border-0 bg-label-danger">
      <div class="card-body">
        <h6 class="fw-bold mb-3"><i class="bx bx-bulb me-1"></i> Hot Deal Tips</h6>
        <ul class="mb-0 ps-3 small">
          <li class="mb-2"><strong>Sale Price</strong> এ discounted দাম দিন।</li>
          <li class="mb-2"><strong>Original Price</strong> এ আসল দাম দিলে % badge দেখাবে।</li>
          <li class="mb-2"><strong>Deal End Date</strong> set করলে countdown timer চলবে।</li>
          <li class="mb-2"><strong>Best Sale</strong> on করলে "Best Sale" badge দেখাবে।</li>
          <li>Image সর্বোচ্চ 2MB, JPG/PNG/WEBP।</li>
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
    reader.onload = e => { img.src = e.target.result; preview.classList.remove('d-none'); };
    reader.readAsDataURL(input.files[0]);
  }
}
</script>
@endpush