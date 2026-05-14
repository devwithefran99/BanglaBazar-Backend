@extends('backend.layouts.app')
@section('title', 'Edit Supplier')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">
            <span class="text-muted fw-light">
                <a href="{{ route('backend.suppliers.index') }}" class="text-muted">Suppliers</a> /
            </span> Edit Supplier
        </h4>
        <p class="text-muted mb-0 small">{{ $supplier->name }} এর তথ্য আপডেট করুন</p>
    </div>
    <a href="{{ route('backend.suppliers.index') }}" class="btn btn-outline-secondary">
        <i class="bx bx-arrow-back me-1"></i> Back
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bx bx-edit text-success me-2"></i>Update Information
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('backend.suppliers.update', $supplier) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Supplier Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name"
                               class="form-control form-control-lg @error('name') is-invalid @enderror"
                               value="{{ old('name', $supplier->name) }}">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Phone Number</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bx bx-phone text-success"></i>
                            </span>
                            <input type="text" name="phone"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   value="{{ old('phone', $supplier->phone) }}">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Address</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bx bx-map-pin text-success"></i>
                            </span>
                            <textarea name="address"
                                      class="form-control @error('address') is-invalid @enderror"
                                      rows="2">{{ old('address', $supplier->address) }}</textarea>
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Notes <small class="text-muted fw-normal">(optional)</small>
                        </label>
                        <textarea name="notes"
                                  class="form-control @error('notes') is-invalid @enderror"
                                  rows="3">{{ old('notes', $supplier->notes) }}</textarea>
                        @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select">
                            <option value="active"
                                {{ old('status', $supplier->status) === 'active' ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="inactive"
                                {{ old('status', $supplier->status) === 'inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>
                        </select>
                    </div>

                    <div class="d-flex gap-2 pt-2">
                        <button type="submit" class="btn btn-success px-4">
                            <i class="bx bx-check me-1"></i> Update Supplier
                        </button>
                        <a href="{{ route('backend.suppliers.index') }}"
                           class="btn btn-outline-secondary px-4">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Summary --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header py-3">
                <h6 class="mb-0 fw-semibold">
                    <i class="bx bx-bar-chart-alt-2 text-success me-2"></i>Summary
                </h6>
            </div>
            <div class="card-body px-4">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Total Purchase</span>
                        <span class="fw-semibold">৳{{ number_format($supplier->total_purchase, 2) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Total Paid</span>
                        <span class="fw-semibold text-success">৳{{ number_format($supplier->total_paid, 2) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Due Amount</span>
                        <span class="fw-bold {{ $supplier->due_amount > 0 ? 'text-danger' : 'text-success' }}">
                            ৳{{ number_format($supplier->due_amount, 2) }}
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Added On</span>
                        <span class="small text-muted">{{ $supplier->created_at->format('d M Y') }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card mt-3 border-0" style="background: linear-gradient(135deg, #f0fdf4, #dcfce7);">
            <div class="card-body p-3 d-flex gap-3 align-items-center">
                <a href="{{ route('backend.purchases.index') }}?supplier_id={{ $supplier->id }}"
                   class="btn btn-sm btn-outline-success flex-grow-1">
                    <i class="bx bx-cart me-1"></i> Purchases
                </a>
                <a href="{{ route('backend.supplier-payments.index') }}?supplier_id={{ $supplier->id }}"
                   class="btn btn-sm btn-outline-success flex-grow-1">
                    <i class="bx bx-money me-1"></i> Payments
                </a>
            </div>
        </div>
    </div>
</div>

@endsection