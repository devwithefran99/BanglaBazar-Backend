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



{{-- Profit Summary --}}
<div class="row mt-2">
  <div class="col-12 mb-3">
    <h6 class="fw-semibold text-muted">Inventory Financial Summary</h6>
  </div>

  <div class="col-lg-3 col-md-6 mb-4">
    <div class="card border-start border-danger border-3">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <span class="fw-semibold d-block mb-1">Total Investment</span>
            <h4 class="card-title mb-1 text-danger">৳{{ number_format($totalInvestment, 2) }}</h4>
            <small class="text-muted">কত টাকায় কিনেছো</small>
          </div>
          <span class="avatar-initial rounded bg-label-danger p-2">
            <i class="bx bx-trending-down fs-4"></i>
          </span>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 mb-4">
    <div class="card border-start border-primary border-3">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <span class="fw-semibold d-block mb-1">Total Sell Value</span>
            <h4 class="card-title mb-1 text-primary">৳{{ number_format($totalSellValue, 2) }}</h4>
            <small class="text-muted">সব বিক্রি হলে আসবে</small>
          </div>
          <span class="avatar-initial rounded bg-label-primary p-2">
            <i class="bx bx-money fs-4"></i>
          </span>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 mb-4">
    <div class="card border-start border-success border-3">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <span class="fw-semibold d-block mb-1">Potential Profit</span>
            <h4 class="card-title mb-1 text-success">৳{{ number_format($totalPotentialProfit, 2) }}</h4>
            <small class="text-muted">সব বিক্রি হলে লাভ</small>
          </div>
          <span class="avatar-initial rounded bg-label-success p-2">
            <i class="bx bx-trending-up fs-4"></i>
          </span>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 mb-4">
    <div class="card border-start border-warning border-3">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <span class="fw-semibold d-block mb-1">Avg. Profit Margin</span>
            <h4 class="card-title mb-1 text-warning">{{ $avgMargin }}%</h4>
            <small class="text-muted">গড় লাভের হার</small>
          </div>
          <span class="avatar-initial rounded bg-label-warning p-2">
            <i class="bx bx-pie-chart fs-4"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection