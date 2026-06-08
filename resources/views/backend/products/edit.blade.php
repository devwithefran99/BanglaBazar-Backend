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

<form action="{{ route('backend.products.update', $product) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="row">
  {{-- ── LEFT COLUMN ── --}}
  <div class="col-lg-8">

    {{-- Basic Info --}}
    <div class="card mb-4">
      <div class="card-header"><h5 class="mb-0"><i class="bx bx-box me-2"></i>Product Information</h5></div>
      <div class="card-body">

        <div class="mb-3">
          <label class="form-label fw-semibold">Product Name <span class="text-danger">*</span></label>
          <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                 value="{{ old('name', $product->name) }}">
          @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Category</label>
            <select name="category" class="form-select">
              <option value="">— Category Select করুন —</option>
              @foreach(['sutki'=>'Sutki / শুটকি','fish'=>'Fish / মাছ','meat'=>'Meat / মাংস','rice'=>'Rice / চাল','oil_ghee'=>'Oil & Ghee','spices'=>'Spices / মশলা','beverage'=>'Beverage','general'=>'General'] as $val => $lbl)
                <option value="{{ $val }}" {{ old('category', $product->category)==$val?'selected':'' }}>{{ $lbl }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Supplier</label>
            <select name="supplier_id" class="form-select">
              <option value="">— Supplier Select করুন —</option>
              @foreach($suppliers as $sup)
                <option value="{{ $sup->id }}"
                  {{ old('supplier_id', $product->supplier_id)==$sup->id?'selected':'' }}>
                  {{ $sup->name }}@if($sup->company) — {{ $sup->company }}@endif
                </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Description</label>
          <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
        </div>

      </div>
    </div>

    {{-- ── VARIATION TOGGLE ── --}}
    <div class="card mb-4">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0"><i class="bx bx-slider me-2 text-primary"></i>Pricing & Variations</h5>
        <div class="form-check form-switch mb-0">
          <input class="form-check-input" type="checkbox" name="has_variations" id="hasVariations"
                 value="1" {{ (old('has_variations') || $variations->count() > 0) ? 'checked' : '' }}>
          <label class="form-check-label fw-semibold" for="hasVariations">
            Variation আছে?
          </label>
        </div>
      </div>
      <div class="card-body">

        {{-- Single price --}}
        <div id="singlePriceSection">
          <div class="row">
            <div class="col-md-4 mb-3">
              <label class="form-label fw-semibold">Regular Price (৳)</label>
              <div class="input-group">
                <span class="input-group-text">৳</span>
                <input type="number" name="old_price" step="0.01" min="0"
                       class="form-control" value="{{ old('old_price', $product->old_price) }}">
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label fw-semibold">Sell Price (৳) <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text">৳</span>
                <input type="number" name="price" step="0.01" min="0"
                       class="form-control @error('price') is-invalid @enderror"
                       value="{{ old('price', $product->price) }}">
                @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label fw-semibold">Buy Price (৳)</label>
              <div class="input-group">
                <span class="input-group-text">৳</span>
                <input type="number" name="buy_price" step="0.01" min="0"
                       class="form-control" value="{{ old('buy_price', 0) }}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Stock Quantity <span class="text-danger">*</span></label>
              <input type="number" name="stock" min="0"
                     class="form-control @error('stock') is-invalid @enderror"
                     value="{{ old('stock', $product->stock) }}">
              @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Low Stock Alert</label>
              <input type="number" name="low_stock_threshold" min="0" class="form-control"
                     value="{{ old('low_stock_threshold', $product->low_stock_threshold ?? 5) }}">
            </div>
          </div>
        </div>

        {{-- Variation section --}}
        <div id="variationSection" class="d-none">

          <div class="alert alert-info py-2 small mb-3">
            <i class="bx bx-info-circle me-1"></i>
            Variation edit করলে সব পুরনো variation replace হবে। <strong>Default</strong> টা page এ প্রথমে দেখাবে।
          </div>

          <div id="variationRows">
            {{-- existing variations JS দিয়ে load হবে --}}
          </div>

          <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="addVariationRow()">
            <i class="bx bx-plus me-1"></i> আরেকটা Variation যোগ করুন
          </button>

          <div class="row mt-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Low Stock Alert</label>
              <input type="number" name="low_stock_threshold" min="0" class="form-control"
                     value="{{ old('low_stock_threshold', $product->low_stock_threshold ?? 5) }}">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Buy Price (৳) overall</label>
              <div class="input-group">
                <span class="input-group-text">৳</span>
                <input type="number" name="buy_price" step="0.01" min="0"
                       class="form-control" value="{{ old('buy_price', 0) }}">
              </div>
            </div>
          </div>

        </div>

      </div>
    </div>

  </div>

  {{-- ── RIGHT COLUMN ── --}}
  <div class="col-lg-4">

    <div class="card mb-4">
      <div class="card-header"><h5 class="mb-0">Product Image</h5></div>
      <div class="card-body">
        @if($product->image)
          <div class="mb-2">
            <img src="{{ asset('storage/' . $product->image) }}" alt="Current"
                 style="max-width:100%; border-radius:8px; border:1px solid #ddd;">
            <p class="text-muted small mt-1">Current image — নতুন দিলে replace হবে</p>
          </div>
        @endif
        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
               accept="image/jpg,image/jpeg,image/png,image/webp" onchange="previewImg(this)">
        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
        <div id="imgPreview" class="mt-2 d-none">
          <img id="previewImgEl" src="" alt="Preview"
               style="max-width:100%; border-radius:8px; border:1px solid #ddd;">
        </div>
      </div>
    </div>

    <div class="card mb-4">
      <div class="card-header"><h5 class="mb-0">Settings</h5></div>
      <div class="card-body">
        <div class="form-check form-switch mb-3">
          <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured"
                 {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
          <label class="form-check-label" for="is_featured">
            <i class="bx bx-star text-warning"></i> Featured Product
          </label>
        </div>
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                 {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
          <label class="form-check-label" for="is_active">
            <i class="bx bx-check-circle text-success"></i> Active
          </label>
        </div>
      </div>
    </div>

    <div class="d-grid gap-2">
      <button type="submit" class="btn btn-primary btn-lg">
        <i class="bx bx-save me-1"></i> Product Update করুন
      </button>
      <a href="{{ route('backend.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </div>

  </div>
</div>

</form>
@endsection

@push('scripts')
<script>
let varIndex = 0;

function addVariationRow(label='', price='', oldPrice='', stock='', isDefault=false) {
  const idx = varIndex++;
  const row = `
    <div class="variation-row border rounded p-3 mb-2 bg-light" id="vrow_${idx}">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <span class="fw-semibold text-primary small"><i class="bx bx-purchase-tag me-1"></i> Variation #${idx+1}</span>
        <div class="d-flex align-items-center gap-3">
          <div class="form-check mb-0">
            <input class="form-check-input default-radio" type="radio" name="default_variation"
                   value="${idx}" id="def_${idx}" ${isDefault ? 'checked' : ''}>
            <label class="form-check-label small" for="def_${idx}">Default</label>
          </div>
          <button type="button" class="btn btn-sm btn-outline-danger py-0 px-2"
                  onclick="removeRow('vrow_${idx}')">
            <i class="bx bx-trash"></i>
          </button>
        </div>
      </div>
      <div class="row g-2">
        <div class="col-md-3">
          <label class="form-label small mb-1 fw-semibold">Label <span class="text-danger">*</span></label>
          <input type="text" name="variations[${idx}][label]" class="form-control form-control-sm"
                 placeholder="50gm / 1kg / 1 Piece" value="${label}" required>
        </div>
        <div class="col-md-3">
          <label class="form-label small mb-1 fw-semibold">Regular Price (৳)</label>
          <input type="number" name="variations[${idx}][old_price]" step="0.01" min="0"
                 class="form-control form-control-sm" placeholder="কাটা দাম" value="${oldPrice}">
        </div>
        <div class="col-md-3">
          <label class="form-label small mb-1 fw-semibold">Sell Price (৳) <span class="text-danger">*</span></label>
          <input type="number" name="variations[${idx}][price]" step="0.01" min="0"
                 class="form-control form-control-sm" placeholder="বিক্রয় দাম" value="${price}" required>
        </div>
        <div class="col-md-3">
          <label class="form-label small mb-1 fw-semibold">Stock <span class="text-danger">*</span></label>
          <input type="number" name="variations[${idx}][stock]" min="0"
                 class="form-control form-control-sm" placeholder="0" value="${stock}" required>
        </div>
      </div>
    </div>`;
  document.getElementById('variationRows').insertAdjacentHTML('beforeend', row);
}

function removeRow(id) {
  const rows = document.querySelectorAll('.variation-row');
  if (rows.length <= 1) { alert('কমপক্ষে একটা variation রাখতে হবে!'); return; }
  document.getElementById(id).remove();
}

const toggleEl   = document.getElementById('hasVariations');
const singleSec  = document.getElementById('singlePriceSection');
const varSec     = document.getElementById('variationSection');

// Existing variations from PHP (loaded once)
const existingVariations = @json($variations);

function applyToggle(initial=false) {
  if (toggleEl.checked) {
    singleSec.classList.add('d-none');
    varSec.classList.remove('d-none');
    if (initial && existingVariations.length > 0) {
      existingVariations.forEach((v, i) => {
        addVariationRow(v.label, v.price, v.old_price ?? '', v.stock, v.is_default);
      });
    } else if (document.querySelectorAll('.variation-row').length === 0) {
      addVariationRow('', '', '', '', true);
    }
  } else {
    singleSec.classList.remove('d-none');
    varSec.classList.add('d-none');
  }
}

toggleEl.addEventListener('change', () => applyToggle(false));
applyToggle(true); // on load

function previewImg(input) {
  const box = document.getElementById('imgPreview');
  const img = document.getElementById('previewImgEl');
  if (input.files && input.files[0]) {
    const r = new FileReader();
    r.onload = e => { img.src = e.target.result; box.classList.remove('d-none'); };
    r.readAsDataURL(input.files[0]);
  }
}
</script>
@endpush