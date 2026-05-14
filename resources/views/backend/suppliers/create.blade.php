@extends('backend.layouts.app')
@section('title', 'Add Supplier')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">
            <span class="text-muted fw-light">
                <a href="{{ route('backend.suppliers.index') }}" class="text-muted">Suppliers</a> /
            </span> Add Supplier
        </h4>
        <p class="text-muted mb-0 small">নতুন supplier এর তথ্য যোগ করুন</p>
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
                    <i class="bx bx-user-plus text-success me-2"></i>Supplier Information
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('backend.suppliers.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Supplier Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name"
                               class="form-control form-control-lg @error('name') is-invalid @enderror"
                               value="{{ old('name') }}"
                               placeholder="যেমন: Rahim Traders">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Phone Number</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bx bx-phone text-success"></i>
                            </span>
                            <input type="text" name="phone"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   value="{{ old('phone') }}"
                                   placeholder="01X-XXXXXXXX">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                                      rows="2"
                                      placeholder="পূর্ণ ঠিকানা লিখুন...">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Notes
                            <small class="text-muted fw-normal">(optional)</small>
                        </label>
                        <textarea name="notes"
                                  class="form-control @error('notes') is-invalid @enderror"
                                  rows="3"
                                  placeholder="যেকোনো অতিরিক্ত তথ্য...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 pt-2">
                        <button type="submit" class="btn btn-success px-4">
                            <i class="bx bx-check me-1"></i> Save Supplier
                        </button>
                        <a href="{{ route('backend.suppliers.index') }}"
                           class="btn btn-outline-secondary px-4">Cancel</a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0" style="background: linear-gradient(135deg, #f0fdf4, #dcfce7);">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3 text-success">
                    <i class="bx bx-bulb me-2"></i>Tips
                </h6>
                <ul class="mb-0 ps-3 text-muted small">
                    <li class="mb-2">Supplier add করার পর <strong>Purchases</strong> section থেকে purchase record করুন।</li>
                    <li class="mb-2">Payment করলে <strong>Payments</strong> section এ record রাখুন।</li>
                    <li>Due amount automatically calculate হবে।</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection