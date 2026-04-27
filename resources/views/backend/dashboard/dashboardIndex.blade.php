@extends('backend.layouts.app')

@section('title', 'Dashboard')

@section('content')

  <h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Admin /</span> Dashboard
  </h4>

  <div class="row">
    <!-- Total Products Card -->
    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <span class="fw-semibold d-block mb-1">Total Products</span>
              <h3 class="card-title mb-2">{{ $totalProducts ?? 0 }}</h3>
            </div>
            <div class="avatar flex-shrink-0">
              <span class="avatar-initial rounded bg-label-primary">
                <i class="bx bx-package"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Active Products Card -->
    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <span class="fw-semibold d-block mb-1">Active Products</span>
              <h3 class="card-title mb-2">{{ $activeProducts ?? 0 }}</h3>
            </div>
            <div class="avatar flex-shrink-0">
              <span class="avatar-initial rounded bg-label-success">
                <i class="bx bx-check-circle"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Featured Products Card -->
    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <span class="fw-semibold d-block mb-1">Featured</span>
              <h3 class="card-title mb-2">{{ $featuredProducts ?? 0 }}</h3>
            </div>
            <div class="avatar flex-shrink-0">
              <span class="avatar-initial rounded bg-label-warning">
                <i class="bx bx-star"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Out of Stock Card -->
    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <span class="fw-semibold d-block mb-1">Out of Stock</span>
              <h3 class="card-title mb-2">{{ $outOfStock ?? 0 }}</h3>
            </div>
            <div class="avatar flex-shrink-0">
              <span class="avatar-initial rounded bg-label-danger">
                <i class="bx bx-error"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection