@extends('backend.layouts.app')
@section('title', 'Add Purchase')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">
            <span class="text-muted fw-light">
                <a href="{{ route('backend.purchases.index') }}" class="text-muted">Purchases</a> /
            </span> Add Purchase
        </h4>
        <p class="text-muted mb-0 small">নতুন purchase record যোগ করুন</p>
    </div>
    <a href="{{ route('backend.purchases.index') }}" class="btn btn-outline-secondary">
        <i class="bx bx-arrow-back me-1"></i> Back
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bx bx-cart-add text-success me-2"></i>Purchase Details
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('backend.purchases.store') }}" method="POST">
                    @csrf

                    {{-- Supplier --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Supplier <span class="text-danger">*</span>
                        </label>
                        <select name="supplier_id"
                                class="form-select form-select-lg @error('supplier_id') is-invalid @enderror"
                                id="supplierSelect">
                            <option value="">— Supplier বেছে নিন —</option>
                            @foreach($suppliers as $sup)
                                <option value="{{ $sup->id }}"
                                    {{ old('supplier_id') == $sup->id ? 'selected' : '' }}>
                                    {{ $sup->name }}
                                    @if($sup->phone) ({{ $sup->phone }}) @endif
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if($suppliers->isEmpty())
                            <div class="form-text text-warning">
                                <i class="bx bx-info-circle"></i> কোনো active supplier নেই।
                                <a href="{{ route('backend.suppliers.create') }}" target="_blank">এখানে add করুন</a>
                            </div>
                        @endif
                    </div>

                    {{-- Product Name --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Product Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="product_name"
                               class="form-control @error('product_name') is-invalid @enderror"
                               value="{{ old('product_name') }}"
                               placeholder="যেমন: Basmati Rice 5kg">
                        @error('product_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Quantity & Price --}}
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Quantity <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="quantity" min="1"
                                   class="form-control @error('quantity') is-invalid @enderror"
                                   value="{{ old('quantity') }}"
                                   placeholder="0"
                                   id="qtyInput">
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Buying Price (৳) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">৳</span>
                                <input type="number" name="buying_price" min="0" step="0.01"
                                       class="form-control @error('buying_price') is-invalid @enderror"
                                       value="{{ old('buying_price') }}"
                                       placeholder="0.00"
                                       id="priceInput">
                                @error('buying_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Total Cost Preview --}}
                    <div class="mb-4 p-3 rounded-3" style="background:#f0fdf4; border:1px solid #bbf7d0;">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-semibold text-success">Total Cost</span>
                            <span class="fs-4 fw-bold text-success" id="totalCost">৳0.00</span>
                        </div>
                    </div>

                    {{-- Purchase Date --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Purchase Date <span class="text-danger">*</span>
                        </label>
                        <input type="date" name="purchase_date"
                               class="form-control @error('purchase_date') is-invalid @enderror"
                               value="{{ old('purchase_date', now()->format('Y-m-d')) }}">
                        @error('purchase_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Notes --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Notes <small class="text-muted fw-normal">(optional)</small></label>
                        <textarea name="notes" class="form-control" rows="2"
                                  placeholder="যেকোনো অতিরিক্ত তথ্য...">{{ old('notes') }}</textarea>
                    </div>

                    <div class="d-flex gap-2 pt-2">
                        <button type="submit" class="btn btn-success px-4">
                            <i class="bx bx-check me-1"></i> Save Purchase
                        </button>
                        <a href="{{ route('backend.purchases.index') }}"
                           class="btn btn-outline-secondary px-4">Cancel</a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- Info --}}
    <div class="col-lg-4">
        <div class="card border-0" style="background: linear-gradient(135deg, #f0fdf4, #dcfce7);">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3 text-success">
                    <i class="bx bx-info-circle me-2"></i>মনে রাখুন
                </h6>
                <ul class="mb-0 ps-3 text-muted small">
                    <li class="mb-2">Purchase save করলে supplier এর <strong>Total Purchase</strong> automatically বাড়বে।</li>
                    <li class="mb-2">Due amount = Total Purchase − Total Paid.</li>
                    <li>Payment করলে <strong>Payments</strong> section এ আলাদা record রাখুন।</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const qty   = document.getElementById('qtyInput');
    const price = document.getElementById('priceInput');
    const total = document.getElementById('totalCost');

    function updateTotal() {
        const q = parseFloat(qty.value)   || 0;
        const p = parseFloat(price.value) || 0;
        total.textContent = '৳' + (q * p).toLocaleString('en-BD', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    qty.addEventListener('input',   updateTotal);
    price.addEventListener('input', updateTotal);
</script>
@endpush