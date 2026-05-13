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
          <h5 class="mb-0"><i class="bx bx-fire me-2 text-danger"></i>Hot Deal Information</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('backend.hotdeals.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Name -->
            <div class="mb-3">
              <label class="form-label fw-semibold">Deal Name <span class="text-danger">*</span></label>
              <input type="text" name="name"
                     class="form-control @error('name') is-invalid @enderror"
                     value="{{ old('name') }}"
                     placeholder="যেমন: Eid Special Combo">
              @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- Category -->
            <div class="mb-3">
              <label class="form-label fw-semibold">Category</label>
              <select name="category" class="form-select">
                <option value="">— Category Select করুন —</option>
                <option value="sutki"    {{ old('category') == 'sutki'    ? 'selected' : '' }}>Sutki</option>
                <option value="meat"     {{ old('category') == 'meat'     ? 'selected' : '' }}>Meat</option>
                <option value="fish"     {{ old('category') == 'fish'     ? 'selected' : '' }}>Fish</option>
                <option value="oil_ghee" {{ old('category') == 'oil_ghee' ? 'selected' : '' }}>Oil & Ghee</option>
                <option value="spices"   {{ old('category') == 'spices'   ? 'selected' : '' }}>Spices</option>
                <option value="rice"     {{ old('category') == 'rice'     ? 'selected' : '' }}>Rice</option>
                <option value="beverage" {{ old('category') == 'beverage' ? 'selected' : '' }}>Beverage</option>
              </select>
            </div>

            {{-- ────────── PRICING SECTION ────────── --}}
            <div class="card bg-label-danger border-0 mb-3">
              <div class="card-body p-3">
                <h6 class="fw-bold mb-3 text-danger">
                  <i class="bx bx-money me-1"></i> Pricing Details
                </h6>

                <div class="row">
                  <!-- 1. Regular Price -->
                  <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">
                      Regular Price (৳)
                      <small class="text-muted d-block fw-normal">আসল দাম (কেটে দেখাবে)</small>
                    </label>
                    <div class="input-group">
                      <span class="input-group-text">৳</span>
                      <input type="number" name="old_price" step="0.01" min="0"
                             id="old_price"
                             class="form-control @error('old_price') is-invalid @enderror"
                             value="{{ old('old_price') }}"
                             placeholder="1000.00">
                      @error('old_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                  </div>

                  <!-- 2. Sell / Offer Price -->
                  <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">
                      Sell / Offer Price (৳) <span class="text-danger">*</span>
                      <small class="text-muted d-block fw-normal">customer যে দামে কিনবে</small>
                    </label>
                    <div class="input-group">
                      <span class="input-group-text">৳</span>
                      <input type="number" name="price" step="0.01" min="0"
                             id="price"
                             class="form-control @error('price') is-invalid @enderror"
                             value="{{ old('price') }}"
                             placeholder="700.00">
                      @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                  </div>

                  <!-- 3. Buy Price -->
                  <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">
                      Buy Price (৳)
                      <small class="text-muted d-block fw-normal">supplier price</small>
                    </label>
                    <div class="input-group">
                      <span class="input-group-text">৳</span>
                      <input type="number" name="buy_price" step="0.01" min="0"
                             id="buy_price"
                             class="form-control @error('buy_price') is-invalid @enderror"
                             value="{{ old('buy_price', 0) }}"
                             placeholder="500.00">
                      @error('buy_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                  </div>
                </div>

                <div id="profitPreview" class="alert alert-success py-2 small mb-0 d-none">
                  <i class="bx bx-trending-up me-1"></i>
                  Profit per unit: <strong>৳<span id="profitVal">0.00</span></strong>
                  (<span id="profitMargin">0</span>% margin)
                  &nbsp;|&nbsp;
                  Customer Discount: <strong><span id="discPct">0</span>%</strong>
                </div>
              </div>
            </div>

            <!-- Stock & Threshold -->
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Stock Quantity <span class="text-danger">*</span></label>
                <input type="number" name="stock" min="0"
                       class="form-control @error('stock') is-invalid @enderror"
                       value="{{ old('stock', 0) }}">
                @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
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

            <!-- Deal Ends At (Countdown) -->
            <div class="mb-3">
              <label class="form-label fw-semibold">
                Deal Ends At
                <small class="text-muted">(countdown timer এর জন্য, optional)</small>
              </label>
              <input type="datetime-local" name="deal_ends_at"
                     class="form-control @error('deal_ends_at') is-invalid @enderror"
                     value="{{ old('deal_ends_at') }}">
              @error('deal_ends_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- Description -->
            <div class="mb-3">
              <label class="form-label fw-semibold">Description</label>
              <textarea name="description" class="form-control" rows="4"
                        placeholder="Hot Deal সম্পর্কে বিস্তারিত লিখুন...">{{ old('description') }}</textarea>
            </div>

            <!-- Image -->
            <div class="mb-4">
              <label class="form-label fw-semibold">Deal Image</label>
              <input type="file" name="image"
                     class="form-control @error('image') is-invalid @enderror"
                     accept="image/jpg,image/jpeg,image/png,image/webp"
                     onchange="previewImage(this)">
              @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
              <div id="imagePreview" class="mt-2 d-none">
                <img id="previewImg" src="" alt="Preview"
                     style="max-height: 150px; border-radius: 8px; border: 1px solid #ddd;">
              </div>
            </div>

            <!-- Switches -->
            <div class="row mb-4">
              <div class="col-md-6">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" name="is_best_sale"
                         id="is_best_sale" {{ old('is_best_sale') ? 'checked' : '' }}>
                  <label class="form-check-label" for="is_best_sale">
                    <i class="bx bx-trophy text-warning"></i> Best Sale
                  </label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" name="is_active"
                         id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                  <label class="form-check-label" for="is_active">
                    <i class="bx bx-check-circle text-success"></i> Active
                  </label>
                </div>
              </div>
            </div>

            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-danger">
                <i class="bx bx-fire me-1"></i> Hot Deal Save করুন
              </button>
              <a href="{{ route('backend.hotdeals.index') }}" class="btn btn-outline-secondary">
                Cancel
              </a>
            </div>

          </form>
        </div>
      </div>

    </div>

    <div class="col-md-4">
      <div class="card border-0 bg-label-warning">
        <div class="card-body">
          <h6 class="fw-bold mb-3"><i class="bx bx-bulb me-1"></i> Hot Deal Tips</h6>
          <ul class="mb-0 ps-3 small">
            <li class="mb-2"><strong>Regular Price</strong> = কেটে দেখানোর দাম।</li>
            <li class="mb-2"><strong>Sell Price</strong> = customer এই দামে কিনবে।</li>
            <li class="mb-2"><strong>Buy Price</strong> = supplier থেকে কেনা দাম (private)।</li>
            <li class="mb-2"><strong>Deal Ends At</strong> দিলে countdown timer চলবে।</li>
            <li>Image সর্বোচ্চ <strong>2MB</strong>, JPG/PNG/WEBP।</li>
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

  function calcPricing() {
    const old   = parseFloat(document.getElementById('old_price').value) || 0;
    const sell  = parseFloat(document.getElementById('price').value)     || 0;
    const buy   = parseFloat(document.getElementById('buy_price').value) || 0;
    const box   = document.getElementById('profitPreview');

    if (sell <= 0 && buy <= 0 && old <= 0) {
      box.classList.add('d-none');
      return;
    }

    const profit  = sell - buy;
    const margin  = sell > 0 ? ((profit / sell) * 100).toFixed(1) : 0;
    const discPct = old > sell && old > 0 ? Math.round(((old - sell) / old) * 100) : 0;

    document.getElementById('profitVal').textContent    = profit.toFixed(2);
    document.getElementById('profitMargin').textContent = margin;
    document.getElementById('discPct').textContent      = discPct;
    box.classList.remove('d-none');
  }

  ['old_price', 'price', 'buy_price'].forEach(id => {
    document.getElementById(id).addEventListener('input', calcPricing);
  });
  calcPricing();
</script>
@endpush