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

<form action="{{ route('backend.products.store') }}" method="POST" enctype="multipart/form-data">
@csrf

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
                 value="{{ old('name') }}" placeholder="যেমন: চিংড়ি শুটকি">
          @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Category</label>
            <select name="category" class="form-select">
              <option value="">— Category Select করুন —</option>
              <option value="sutki"    {{ old('category')=='sutki'    ?'selected':'' }}>Sutki / শুটকি</option>
              <option value="fish"     {{ old('category')=='fish'     ?'selected':'' }}>Fish / মাছ</option>
              <option value="meat"     {{ old('category')=='meat'     ?'selected':'' }}>Meat / মাংস</option>
              <option value="rice"     {{ old('category')=='rice'     ?'selected':'' }}>Rice / চাল</option>
              <option value="oil_ghee" {{ old('category')=='oil_ghee' ?'selected':'' }}>Oil & Ghee</option>
              <option value="spices"   {{ old('category')=='spices'   ?'selected':'' }}>Spices / মশলা</option>
              <option value="beverage" {{ old('category')=='beverage' ?'selected':'' }}>Beverage</option>
              <option value="general"  {{ old('category')=='general'  ?'selected':'' }}>General</option>
            </select>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Supplier</label>
            <select name="supplier_id" class="form-select">
              <option value="">— Supplier Select করুন —</option>
              @foreach($suppliers as $sup)
                <option value="{{ $sup->id }}" {{ old('supplier_id')==$sup->id?'selected':'' }}>
                  {{ $sup->name }}@if($sup->company) — {{ $sup->company }}@endif
                </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Description</label>
          <textarea name="description" class="form-control" rows="3"
                    placeholder="Product সম্পর্কে বিস্তারিত লিখুন...">{{ old('description') }}</textarea>
        </div>

      </div>
    </div>

    {{-- ── VARIATION TOGGLE ── --}}
    <div class="card mb-4">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0"><i class="bx bx-slider me-2 text-primary"></i>Pricing & Variations</h5>
        <div class="form-check form-switch mb-0">
          <input class="form-check-input" type="checkbox" name="has_variations" id="hasVariations"
                 value="1" {{ old('has_variations') ? 'checked' : '' }}>
          <label class="form-check-label fw-semibold" for="hasVariations">
            Variation আছে? (size/weight/piece)
          </label>
        </div>
      </div>
      <div class="card-body">

        {{-- NO VARIATION: single price/stock --}}
        <div id="singlePriceSection">
          <div class="row">
            <div class="col-md-4 mb-3">
              <label class="form-label fw-semibold">Regular Price (৳)</label>
              <div class="input-group">
                <span class="input-group-text">৳</span>
                <input type="number" name="old_price" step="0.01" min="0" id="s_old_price"
                       class="form-control" value="{{ old('old_price') }}" placeholder="কেটে দেখাবে">
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label fw-semibold">Sell Price (৳) <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text">৳</span>
                <input type="number" name="price" step="0.01" min="0" id="s_price"
                       class="form-control @error('price') is-invalid @enderror"
                       value="{{ old('price') }}" placeholder="customer দাম">
                @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label fw-semibold">Buy Price (৳)</label>
              <div class="input-group">
                <span class="input-group-text">৳</span>
                <input type="number" name="buy_price" step="0.01" min="0" id="s_buy_price"
                       class="form-control" value="{{ old('buy_price', 0) }}" placeholder="supplier দাম">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Stock Quantity <span class="text-danger">*</span></label>
              <input type="number" name="stock" min="0"
                     class="form-control @error('stock') is-invalid @enderror"
                     value="{{ old('stock', 0) }}">
              @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Low Stock Alert <small class="text-muted">(default: 5)</small></label>
              <input type="number" name="low_stock_threshold" min="0" class="form-control"
                     value="{{ old('low_stock_threshold', 5) }}">
            </div>
          </div>
        </div>

        {{-- WITH VARIATION --}}
        <div id="variationSection" class="d-none">

          <div class="alert alert-info py-2 small mb-3">
            <i class="bx bx-info-circle me-1"></i>
            প্রতিটা variation এর label, দাম ও stock আলাদা দাও। <strong>Default</strong> চিহ্নিত টা page এ প্রথমে select থাকবে।
          </div>

          <div id="variationRows">
            {{-- JS দিয়ে rows add হবে --}}
          </div>

          <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="addVariationRow()">
            <i class="bx bx-plus me-1"></i> আরেকটা Variation যোগ করুন
          </button>

          <div class="row mt-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Low Stock Alert <small class="text-muted">(default: 5)</small></label>
              <input type="number" name="low_stock_threshold" min="0" class="form-control"
                     value="{{ old('low_stock_threshold', 5) }}">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Buy Price (৳) <small class="text-muted">overall supplier দাম</small></label>
              <div class="input-group">
                <span class="input-group-text">৳</span>
                <input type="number" name="buy_price" step="0.01" min="0" class="form-control"
                       value="{{ old('buy_price', 0) }}">
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
                 {{ old('is_featured') ? 'checked' : '' }}>
          <label class="form-check-label" for="is_featured">
            <i class="bx bx-star text-warning"></i> Featured Product
          </label>
        </div>
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                 {{ old('is_active', true) ? 'checked' : '' }}>
          <label class="form-check-label" for="is_active">
            <i class="bx bx-check-circle text-success"></i> Active
          </label>
        </div>
      </div>
    </div>

    <div class="card border-0 bg-label-info mb-4">
      <div class="card-body">
        <h6 class="fw-bold mb-2"><i class="bx bx-bulb me-1"></i> Variation Tips</h6>
        <ul class="mb-0 ps-3 small">
          <li class="mb-1">Label যেকোনো কিছু দেওয়া যাবে: <strong>50gm, 1kg, 1 Piece, 1 Packet</strong></li>
          <li class="mb-1">প্রতিটা size এর আলাদা price ও stock দাও</li>
          <li class="mb-1"><strong>Default</strong> টা customer প্রথমে দেখবে</li>
          <li>Variation না থাকলে toggle off রাখো</li>
        </ul>
      </div>
    </div>

    <div class="d-grid gap-2">
      <button type="submit" class="btn btn-primary btn-lg">
        <i class="bx bx-save me-1"></i> Product Save করুন
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
  // প্রথম row সবসময় default
  if (varIndex === 1) {
    document.querySelector(`#def_${idx}`).checked = true;
  }
}

function removeRow(id) {
  const rows = document.querySelectorAll('.variation-row');
  if (rows.length <= 1) { alert('কমপক্ষে একটা variation রাখতে হবে!'); return; }
  document.getElementById(id).remove();
}

// Toggle logic
const toggleEl = document.getElementById('hasVariations');
const singleSec = document.getElementById('singlePriceSection');
const varSec = document.getElementById('variationSection');

function applyToggle() {
  if (toggleEl.checked) {
    singleSec.classList.add('d-none');
    varSec.classList.remove('d-none');
    if (document.querySelectorAll('.variation-row').length === 0) {
      addVariationRow('', '', '', '', true);
    }
  } else {
    singleSec.classList.remove('d-none');
    varSec.classList.add('d-none');
  }
}

toggleEl.addEventListener('change', applyToggle);
applyToggle(); // on page load

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