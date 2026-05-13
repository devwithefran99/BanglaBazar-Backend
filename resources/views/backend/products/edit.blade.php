@extends('backend.layouts.app')

@section('title', 'Edit Hot Deal')

@section('content')

  @php
    $linkedInventory = \App\Models\Inventory::where('product_id', $hotdeal->id)
                                            ->where('product_type', 'hotdeal')
                                            ->first();
    $currentBuyPrice = $linkedInventory->buy_price ?? 0;
  @endphp

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold py-3 mb-0">
      <span class="text-muted fw-light">Hot Deals /</span> Edit Hot Deal
    </h4>
    <a href="{{ route('backend.hotdeals.index') }}" class="btn btn-outline-secondary">
      <i class="bx bx-arrow-back me-1"></i> Back to List
    </a>
  </div>

  <div class="row">
    <div class="col-md-8">
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="mb-0"><i class="bx bx-edit me-2"></i>Edit: {{ $hotdeal->name }}</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('backend.hotdeals.update', $hotdeal->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="mb-3">
              <label class="form-label fw-semibold">Deal Name <span class="text-danger">*</span></label>
              <input type="text" name="name"
                     class="form-control @error('name') is-invalid @enderror"
                     value="{{ old('name', $hotdeal->name) }}">
              @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- Category -->
            <div class="mb-3">
              <label class="form-label fw-semibold">Category</label>
              <select name="category" class="form-select">
                <option value="">— Category Select করুন —</option>
                @foreach(['sutki','meat','fish','oil_ghee','spices','rice','beverage'] as $cat)
                  <option value="{{ $cat }}"
                    {{ old('category', $hotdeal->category) == $cat ? 'selected' : '' }}>
                    {{ ucfirst(str_replace('_',' ',$cat)) }}
                  </option>
                @endforeach
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
                      <small class="text-muted d-block fw-normal">আসল দাম</small>
                    </label>
                    <div class="input-group">
                      <span class="input-group-text">৳</span>
                      <input type="number" name="old_price" step="0.01" min="0"
                             id="old_price"
                             class="form-control"
                             value="{{ old('old_price', $hotdeal->old_price) }}">
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
                             value="{{ old('price', $hotdeal->price) }}">
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
                             class="form-control"
                             value="{{ old('buy_price', $currentBuyPrice) }}">
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

            <!-- Stock -->
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Stock Quantity <span class="text-danger">*</span></label>
                <input type="number" name="stock" min="0"
                       class="form-control @error('stock') is-invalid @enderror"
                       value="{{ old('stock', $hotdeal->stock) }}">
                @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Low Stock Alert</label>
                <input type="number" name="low_stock_threshold" min="0"
                       class="form-control"
                       value="{{ old('low_stock_threshold', $hotdeal->low_stock_threshold) }}">
              </div>
            </div>

            <!-- Deal Ends At -->
            <div class="mb-3">
              <label class="form-label fw-semibold">Deal Ends At <small class="text-muted">(optional)</small></label>
              <input type="datetime-local" name="deal_ends_at"
                     class="form-control @error('deal_ends_at') is-invalid @enderror"
                     value="{{ old('deal_ends_at', $hotdeal->deal_ends_at ? $hotdeal->deal_ends_at->format('Y-m-d\TH:i') : '') }}">
              @error('deal_ends_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- Description -->
            <div class="mb-3">
              <label class="form-label fw-semibold">Description</label>
              <textarea name="description" class="form-control" rows="4">{{ old('description', $hotdeal->description) }}</textarea>
            </div>

            <!-- Current Image + New Upload -->
            <div class="mb-4">
              <label class="form-label fw-semibold">Deal Image</label>
              @if($hotdeal->image)
                <div class="mb-2">
                  <img src="{{ asset('storage/' . $hotdeal->image) }}"
                       height="100" style="border-radius: 8px; border: 1px solid #ddd;">
                  <small class="text-muted d-block mt-1">Current image — নতুন upload করলে replace হবে</small>
                </div>
              @endif
              <input type="file" name="image"
                     class="form-control @error('image') is-invalid @enderror"
                     accept="image/jpg,image/jpeg,image/png,image/webp"
                     onchange="previewImage(this)">
              @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
              <div id="imagePreview" class="mt-2 d-none">
                <img id="previewImg" src="" alt="Preview"
                     style="max-height: 150px; border-radius: 8px;">
              </div>
            </div>

            <!-- Switches -->
            <div class="row mb-4">
              <div class="col-md-6">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" name="is_best_sale"
                         id="is_best_sale" {{ old('is_best_sale', $hotdeal->is_best_sale) ? 'checked' : '' }}>
                  <label class="form-check-label" for="is_best_sale">
                    <i class="bx bx-trophy text-warning"></i> Best Sale
                  </label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" name="is_active"
                         id="is_active" {{ old('is_active', $hotdeal->is_active) ? 'checked' : '' }}>
                  <label class="form-check-label" for="is_active">
                    <i class="bx bx-check-circle text-success"></i> Active
                  </label>
                </div>
              </div>
            </div>

            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-danger">
                <i class="bx bx-save me-1"></i> Update করুন
              </button>
              <a href="{{ route('backend.hotdeals.index') }}" class="btn btn-outline-secondary">
                Cancel
              </a>
            </div>

          </form>
        </div>
      </div>
    </div>

    <!-- Info Summary -->
    <div class="col-md-4">
      <div class="card">
        <div class="card-header">
          <h6 class="mb-0">Hot Deal Info</h6>
        </div>
        <div class="card-body">
          <p class="mb-1"><strong>Created:</strong><br>
            <small class="text-muted">{{ $hotdeal->created_at->format('d M Y, h:i A') }}</small>
          </p>
          <p class="mb-1"><strong>Last Updated:</strong><br>
            <small class="text-muted">{{ $hotdeal->updated_at->format('d M Y, h:i A') }}</small>
          </p>
          @if($hotdeal->hasSale())
          <p class="mb-2"><strong>Discount:</strong>
            <span class="badge bg-danger">{{ $hotdeal->salePercent() }}% off</span>
          </p>
          @endif
          @if($hotdeal->deal_ends_at)
            <p class="mb-2"><strong>Status:</strong>
              @if($hotdeal->isExpired())
                <span class="badge bg-secondary">Expired</span>
              @else
                <span class="badge bg-success">Live</span>
              @endif
            </p>
          @endif

          @if($linkedInventory)
            <hr>
            <p class="mb-1 small text-muted"><strong>Linked Inventory:</strong></p>
            <p class="mb-0 small">
              SKU: <code>{{ $linkedInventory->sku }}</code><br>
              Buy: ৳{{ number_format($linkedInventory->buy_price, 2) }}<br>
              Stock Value: ৳{{ number_format($linkedInventory->stock * $linkedInventory->price, 2) }}
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