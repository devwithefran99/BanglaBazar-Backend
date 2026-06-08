@extends('backend.layouts.app')
@section('title', 'Edit Hot Deal')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
  <h4 class="fw-bold py-3 mb-0">
    <span class="text-muted fw-light">Hot Deals /</span> Edit: {{ $hotdeal->name }}
  </h4>
  <a href="{{ route('backend.hotdeals.index') }}" class="btn btn-outline-secondary">
    <i class="bx bx-arrow-back me-1"></i> Back to List
  </a>
</div>

<form action="{{ route('backend.hotdeals.update', $hotdeal->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="row">
  {{-- ── LEFT ── --}}
  <div class="col-lg-8">

    <div class="card mb-4">
      <div class="card-header"><h5 class="mb-0"><i class="bx bx-edit me-2"></i>Edit Hot Deal</h5></div>
      <div class="card-body">

        <div class="mb-3">
          <label class="form-label fw-semibold">Deal Name <span class="text-danger">*</span></label>
          <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                 value="{{ old('name', $hotdeal->name) }}">
          @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Category</label>
            <select name="category" class="form-select">
              <option value="">— Category Select করুন —</option>
              @foreach(['sutki'=>'Sutki','meat'=>'Meat','fish'=>'Fish','oil_ghee'=>'Oil & Ghee','spices'=>'Spices','rice'=>'Rice','beverage'=>'Beverage'] as $val => $lbl)
                <option value="{{ $val }}" {{ old('category', $hotdeal->category)==$val?'selected':'' }}>{{ $lbl }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Supplier</label>
            <select name="supplier_id" class="form-select">
              <option value="">— Supplier Select করুন —</option>
              @foreach($suppliers as $sup)
                <option value="{{ $sup->id }}" {{ old('supplier_id',$hotdeal->supplier_id)==$sup->id?'selected':'' }}>
                  {{ $sup->name }}@if($sup->company) — {{ $sup->company }}@endif
                </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Description</label>
          <textarea name="description" class="form-control" rows="3">{{ old('description', $hotdeal->description) }}</textarea>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">
            Deal Ends At <small class="text-muted">(optional)</small>
          </label>
          <input type="datetime-local" name="deal_ends_at" class="form-control"
                 value="{{ old('deal_ends_at', $hotdeal->deal_ends_at?->format('Y-m-d\TH:i')) }}">
        </div>

      </div>
    </div>

    {{-- ── VARIATION TOGGLE ── --}}
    <div class="card mb-4">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0"><i class="bx bx-slider me-2 text-danger"></i>Pricing & Variations</h5>
        <div class="form-check form-switch mb-0">
          <input class="form-check-input" type="checkbox" name="has_variations" id="hasVariations"
                 value="1" {{ (old('has_variations') || $variations->count() > 0) ? 'checked' : '' }}>
          <label class="form-check-label fw-semibold" for="hasVariations">Variation আছে?</label>
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
                       class="form-control" value="{{ old('old_price', $hotdeal->old_price) }}">
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label fw-semibold">Sell Price (৳) <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text">৳</span>
                <input type="number" name="price" step="0.01" min="0"
                       class="form-control @error('price') is-invalid @enderror"
                       value="{{ old('price', $hotdeal->price) }}">
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
              <label class="form-label fw-semibold">Stock <span class="text-danger">*</span></label>
              <input type="number" name="stock" min="0"
                     class="form-control @error('stock') is-invalid @enderror"
                     value="{{ old('stock', $hotdeal->stock) }}">
              @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Low Stock Alert</label>
              <input type="number" name="low_stock_threshold" min="0" class="form-control"
                     value="{{ old('low_stock_threshold', $hotdeal->low_stock_threshold ?? 5) }}">
            </div>
          </div>
        </div>

        {{-- Variation section --}}
        <div id="variationSection" class="d-none">
          <div class="alert alert-warning py-2 small mb-3">
            <i class="bx bx-info-circle me-1"></i>
            Variation edit করলে সব পুরনো variation replace হবে।
          </div>
          <div id="variationRows"></div>
          <button type="button" class="btn btn-outline-danger btn-sm mt-2" onclick="addVariationRow()">
            <i class="bx bx-plus me-1"></i> আরেকটা Variation যোগ করুন
          </button>
          <div class="row mt-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Low Stock Alert</label>
              <input type="number" name="low_stock_threshold" min="0" class="form-control"
                     value="{{ old('low_stock_threshold', $hotdeal->low_stock_threshold ?? 5) }}">
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

  {{-- ── RIGHT ── --}}
  <div class="col-lg-4">

    <div class="card mb-4">
      <div class="card-header"><h5 class="mb-0">Deal Image</h5></div>
      <div class="card-body">
        @if($hotdeal->image)
          <div class="mb-2">
            <img src="{{ asset('storage/' . $hotdeal->image) }}"
                 style="max-width:100%;border-radius:8px;border:1px solid #ddd;">
            <p class="text-muted small mt-1">Current image — নতুন দিলে replace হবে</p>
          </div>
        @endif
        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
               accept="image/jpg,image/jpeg,image/png,image/webp" onchange="previewImg(this)">
        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
        <div id="imgPreview" class="mt-2 d-none">
          <img id="previewImgEl" src="" style="max-width:100%;border-radius:8px;border:1px solid #ddd;">
        </div>
      </div>
    </div>

    <div class="card mb-4">
      <div class="card-header"><h5 class="mb-0">Settings</h5></div>
      <div class="card-body">
        <div class="form-check form-switch mb-3">
          <input class="form-check-input" type="checkbox" name="is_best_sale" id="is_best_sale"
                 {{ old('is_best_sale', $hotdeal->is_best_sale) ? 'checked' : '' }}>
          <label class="form-check-label" for="is_best_sale">
            <i class="bx bx-trophy text-warning"></i> Best Sale
          </label>
        </div>
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                 {{ old('is_active', $hotdeal->is_active) ? 'checked' : '' }}>
          <label class="form-check-label" for="is_active">
            <i class="bx bx-check-circle text-success"></i> Active
          </label>
        </div>
      </div>
    </div>

    <div class="d-grid gap-2">
      <button type="submit" class="btn btn-danger btn-lg">
        <i class="bx bx-save me-1"></i> Hot Deal Update করুন
      </button>
      <a href="{{ route('backend.hotdeals.index') }}" class="btn btn-outline-secondary">Cancel</a>
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
        <span class="fw-semibold text-danger small"><i class="bx bx-purchase-tag me-1"></i> Variation #${idx+1}</span>
        <div class="d-flex align-items-center gap-3">
          <div class="form-check mb-0">
            <input class="form-check-input" type="radio" name="default_variation"
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
  if (document.querySelectorAll('.variation-row').length <= 1) {
    alert('কমপক্ষে একটা variation রাখতে হবে!'); return;
  }
  document.getElementById(id).remove();
}

const toggleEl      = document.getElementById('hasVariations');
const singleSec     = document.getElementById('singlePriceSection');
const varSec        = document.getElementById('variationSection');
const existingVars  = @json($variations);

function applyToggle(initial=false) {
  if (toggleEl.checked) {
    singleSec.classList.add('d-none');
    varSec.classList.remove('d-none');
    if (initial && existingVars.length > 0) {
      existingVars.forEach((v, i) => {
        addVariationRow(v.label, v.price, v.old_price ?? '', v.stock, v.is_default);
      });
    } else if (document.querySelectorAll('.variation-row').length === 0) {
      addVariationRow('','','','',true);
    }
  } else {
    singleSec.classList.remove('d-none');
    varSec.classList.add('d-none');
  }
}
toggleEl.addEventListener('change', () => applyToggle(false));
applyToggle(true);

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