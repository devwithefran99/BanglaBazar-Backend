<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>@yield('title', 'Dashboard') | Admin Panel</title>

  <link rel="icon" type="image/x-icon" href="{{ asset('backend/assets/img/favicon/favicon.ico') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

  <link rel="stylesheet" href="{{ asset('backend/assets/vendor/fonts/boxicons.css') }}" />
  <link rel="stylesheet" href="{{ asset('backend/assets/vendor/css/core.css') }}" />
  <link rel="stylesheet" href="{{ asset('backend/assets/vendor/css/theme-default.css') }}" />
  <link rel="stylesheet" href="{{ asset('backend/assets/css/demo.css') }}" />
  <link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
  <link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/apex-charts/apex-charts.css') }}" />

  <script src="{{ asset('backend/assets/vendor/js/helpers.js') }}"></script>
  <script src="{{ asset('backend/assets/js/config.js') }}"></script>
</head>

<body>
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

      {{-- ===== SIDEBAR ===== --}}
      <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        <div class="app-brand demo">
          <a href="{{ route('backend.dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
              <img src="{{ asset('frontend/image/Logo.png') }}" alt="">
            </span>
          </a>
          <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
          </a>
        </div>

        <div class="menu-inner-shadow"></div>

        <ul class="menu-inner py-1">

          {{-- Dashboard --}}
          <li class="menu-item {{ request()->routeIs('backend.dashboard') ? 'active' : '' }}">
            <a href="{{ route('backend.dashboard') }}" class="menu-link">
              <i class="menu-icon tf-icons bx bx-home-circle"></i>
              <div>Dashboard</div>
            </a>
          </li>
{{-- orders --}}
          <li class="menu-item {{ request()->routeIs('backend.orders.*') ? 'active' : '' }}">
                <a href="{{ route('backend.orders.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-receipt"></i>
                    <div>Orders</div>
                    @php $pending = \App\Models\Order::where('status','pending')->count(); @endphp
                    @if($pending > 0)
                        <div class="badge bg-danger rounded-pill ms-auto">{{ $pending }}</div>
                    @endif
                </a>
          </li>
          {{-- Inventory --}}
            <li class="menu-item {{ request()->routeIs('backend.inventory.*') ? 'active' : '' }}">
              <a href="{{ route('backend.inventory.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-store-alt"></i>
                <div>Inventory</div>
                @php $alertCount = \App\Models\Inventory::lowStock()->count() + \App\Models\Inventory::outOfStock()->count(); @endphp
                @if($alertCount > 0)
                  <div class="badge bg-danger rounded-pill ms-auto">{{ $alertCount }}</div>
                @endif
              </a>
            </li>
          {{-- Categories --}}
              <li class="menu-item {{ request()->routeIs('backend.categories.*') ? 'active' : '' }}">
                <a href="{{ route('backend.categories.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-category"></i>
                  <div>Categories</div>
                </a>
              </li>

          {{-- Products --}}
          <li class="menu-item {{ request()->routeIs('backend.products.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
              <i class="menu-icon tf-icons bx bx-package"></i>
              <div>Populer Products</div>
            </a>
            <ul class="menu-sub">
              <li class="menu-item {{ request()->routeIs('backend.products.create') ? 'active' : '' }}">
                <a href="{{ route('backend.products.create') }}" class="menu-link">
                  <div>Add Product</div>
                </a>
              </li>
              <li class="menu-item {{ request()->routeIs('backend.products.index') ? 'active' : '' }}">
                <a href="{{ route('backend.products.index') }}" class="menu-link">
                  <div>All Products</div>
                </a>
              </li>
            </ul>
          </li>

          {{-- Hot Deals --}}
<li class="menu-item {{ request()->routeIs('backend.hotdeals.*') ? 'active open' : '' }}">
  <a href="javascript:void(0);" class="menu-link menu-toggle">
    <i class="menu-icon tf-icons bx bx-purchase-tag-alt"></i>
    <div>Hot Deals</div>
  </a>
  <ul class="menu-sub">
    <li class="menu-item {{ request()->routeIs('backend.hotdeals.create') ? 'active' : '' }}">
      <a href="{{ route('backend.hotdeals.create') }}" class="menu-link">
        <div>Add Hot Deal</div>
      </a>
    </li>
    <li class="menu-item {{ request()->routeIs('backend.hotdeals.index') ? 'active' : '' }}">
      <a href="{{ route('backend.hotdeals.index') }}" class="menu-link">
        <div>All Hot Deals</div>
      </a>
    </li>
  </ul>
</li>
{{-- cusmoter managment --}}
<li class="menu-item {{ request()->routeIs('backend.customers.*') ? 'active' : '' }}">
  <a href="{{ route('backend.customers.index') }}" class="menu-link">
    <i class="menu-icon tf-icons bx bx-group"></i>
    <div>User Info</div>
  </a>
</li>
{{-- Coupons --}}
<li class="menu-item {{ request()->routeIs('backend.coupons.*') ? 'active' : '' }}">
  <a href="{{ route('backend.coupons.index') }}" class="menu-link">
    <i class="menu-icon tf-icons bx bx-purchase-tag"></i>
    <div>Coupons</div>
  </a>
</li>
        </ul>
      </aside>
      {{-- ===== / SIDEBAR ===== --}}

      {{-- ===== LAYOUT PAGE ===== --}}
      <div class="layout-page">

        {{-- NAVBAR --}}
        <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
          <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
              <i class="bx bx-menu bx-sm"></i>
            </a>
          </div>
          <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <div class="navbar-nav align-items-center">
              <div class="nav-item d-flex align-items-center">
                <i class="bx bx-search fs-4 lh-0"></i>
                <input type="text" class="form-control border-0 shadow-none" placeholder="Search..." />
              </div>
            </div>
            <ul class="navbar-nav flex-row align-items-center ms-auto">
              <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                  <div class="avatar avatar-online">
                    <img src="{{ asset('backend/assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle" />
                  </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li>
                    <a class="dropdown-item" href="#">
                      <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                          <div class="avatar avatar-online">
                            <img src="{{ asset('backend/assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle" />
                          </div>
                        </div>
                        <div class="flex-grow-1">
                          <span class="fw-semibold d-block">{{ auth()->user()->name ?? 'Admin' }}</span>
                          <small class="text-muted">Admin</small>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li><div class="dropdown-divider"></div></li>
                  <li>
                   <form action="{{ route('admin.logout') }}" method="POST">
                      @csrf
                      <button type="submit" class="dropdown-item">
                        <i class="bx bx-power-off me-2"></i> Log Out
                      </button>
                    </form>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
        {{-- / NAVBAR --}}

        {{-- ===== MAIN CONTENT ===== --}}
        <div class="content-wrapper">
          <div class="container-xxl flex-grow-1 container-p-y">

            {{-- Flash Messages --}}
            @if(session('success'))
              <div class="alert alert-success alert-dismissible mb-4" role="alert">
                <i class="bx bx-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            @endif
            @if(session('error'))
              <div class="alert alert-danger alert-dismissible mb-4" role="alert">
                <i class="bx bx-error-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            @endif

            @yield('content') {{-- ← এইখানে প্রতিটা page এর content আসবে --}}

          </div>
          <div class="content-backdrop fade"></div>
        </div>
        {{-- ===== / MAIN CONTENT ===== --}}

      </div>
      {{-- ===== / LAYOUT PAGE ===== --}}

    </div>
  </div>
  {{-- / layout-wrapper --}}

  {{-- Scripts --}}
  <script src="{{ asset('backend/assets/vendor/libs/jquery/jquery.js') }}"></script>
  <script src="{{ asset('backend/assets/vendor/libs/popper/popper.js') }}"></script>
  <script src="{{ asset('backend/assets/vendor/js/bootstrap.js') }}"></script>
  <script src="{{ asset('backend/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
  <script src="{{ asset('backend/assets/vendor/js/menu.js') }}"></script>
  <script src="{{ asset('backend/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
  <script src="{{ asset('backend/assets/js/main.js') }}"></script>
  <script src="{{ asset('backend/assets/js/dashboards-analytics.js') }}"></script>

  @stack('scripts')
</body>
</html>