<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="wishlist-url" content="{{ route('wishlist.toggle') }}">
  <meta name="cart-add-url" content="{{ route('cart.add') }}">
  <meta name="cart-count-url" content="{{ route('cart.count') }}">
  <title>Shop | BanglaBazar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('frontend/css/common.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/css/shop.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
</head>
<body>

{{-- ── PRELOADER ── --}}
<div id="preloader">
  <div class="loader">
    <img src="{{ asset('frontend/image/Logo.png') }}" alt="Logo">
    <p>Loading...</p>
  </div>
</div>

{{-- ── HEADER ── --}}
<header>
<section id="navigation">

  {{-- TOP BAR --}}
  <div class="topbar d-none d-md-block">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <i class="bi bi-geo-alt-fill text-success me-1"></i>
          Store Location: 5th Floor,Kazi Complex,Beparipara,Agrabad Access Road,Chattogram
        </div>
        <div class="d-flex align-items-center gap-2">
          <span class="sep">|</span>
          <a href="{{ route('signin') }}"><i class="bi bi-person me-1"></i>Sign In /</a>
          <a href="{{ route('register') }}"><i class="bi bi-person me-1"></i>Sign Up</a>
        </div>
      </div>
    </div>
  </div>

  {{-- MIDDLE BAR --}}
  <div class="middlebar d-flex align-items-center justify-content-between">
    <div class="container">
      <div class="d-flex align-items-center justify-content-between gap-3">
        <a href="#" class="logo-slot">
          <img src="{{ asset('frontend/image/Logo.png') }}" height="35" alt="logo">
        </a>
        <div class="d-lg-none ms-auto">
          <button class="navbar-toggler-custom" type="button"
                  data-bs-toggle="offcanvas" data-bs-target="#mobileNav">
            <i class="bi bi-list"></i>
          </button>
        </div>
        <div class="search-wrap flex-grow-1 mx-3">
          <input type="text" placeholder="Search for products..."/>
          <button><i class="bi bi-search me-1"></i>Search</button>
        </div>
        <div class="d-none d-lg-flex align-items-center gap-2">
          <a href="{{ route('wishlist') }}" class="icon-btn">
            <i class="bi bi-heart"></i>
            <span class="badge-dot" id="wishlistCount">
              {{ Auth::check() ? Auth::user()->wishlists()->count() : 0 }}
            </span>
          </a>
          <a href="#" class="icon-btn" id="navCartBtn">
            <i class="bi bi-bag"></i>
            <span class="badge-dot" id="cartCount">
              {{ Auth::check() ? Auth::user()->carts()->count() : 0 }}
            </span>
          </a>
        </div>
      </div>
    </div>
  </div>

  {{-- MAIN NAVBAR --}}
  <nav class="main-navbar">
    <div class="container">
      <div class="d-flex align-items-center justify-content-between">
        <ul class="nav d-none d-lg-flex">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">
              <i class="bi bi-house-door-fill me-1"></i> Home
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('shop') }}">
              <i class="bi bi-shop me-1"></i> Shop
            </a>
          </li>
          <li class="nav-item dropdown-custom">
            <a class="nav-link" href="#">
              <i class="bi bi-file-earmark-text me-1"></i> Pages
            </a>
            <ul class="submenu">
              <li><a href="{{ route('wishlist') }}">Wishlist</a></li>
              <li><a href="{{ route('userdashboard') }}">Order History</a></li>
              <li><a href="{{ route('checkout.show') }}">CheckOut</a></li>
              <li><a href="{{ route('signin') }}">Sign In</a></li>
              <li><a href="{{ route('register') }}">Sign Up</a></li>
              <li><a href="{{ route('faq') }}">FAQS</a></li>
              <li><a href="{{ route('userdashboard') }}">My Account</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('about') }}">
              <i class="bi bi-info-circle me-1"></i> About Us
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('contact') }}">
              <i class="bi bi-telephone me-1"></i> Contact Us
            </a>
          </li>
        </ul>
        <div class="nav-phone d-none d-lg-flex">
          <i class="bi bi-telephone-fill"></i> 01616-239896
        </div>
      </div>
    </div>
  </nav>

  {{-- OFFCANVAS --}}
  <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileNav">
    <div class="offcanvas-header">
      <img src="{{ asset('frontend/image/Logo.png') }}" alt="">
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
      <div class="p-3 border-bottom">
        <div class="d-flex">
          <input type="text" class="form-control" placeholder="Search products..."/>
          <button class="btn ms-2" style="background:var(--green);color:#fff;">
            <i class="bi bi-search"></i>
          </button>
        </div>
      </div>
      <nav class="d-flex flex-column">
        <a class="nav-link" href="{{ route('home') }}">
          <span><i class="bi bi-house-door-fill me-2 text-success"></i>Home</span>
          <i class="bi bi-chevron-down arrow"></i>
        </a>
        <a class="nav-link" href="{{ route('shop') }}">
          <span><i class="bi bi-shop me-2 text-success"></i>Shop</span>
          <i class="bi bi-chevron-down arrow"></i>
        </a>
        <div class="mobile-menu-item">
          <a class="nav-link mobile-toggle" href="javascript:void(0)">
            <span><i class="bi bi-file-earmark-text me-2 text-success"></i>Pages</span>
            <i class="bi bi-chevron-down arrow"></i>
          </a>
          <ul class="mobile-submenu">
            <li><a href="{{ route('wishlist') }}">Wishlist</a></li>
            <li><a href="{{ route('userdashboard') }}">Order History</a></li>
            <li><a href="{{ route('checkout.show') }}">CheckOut</a></li>
            <li><a href="{{ route('signin') }}">Sign In</a></li>
            <li><a href="{{ route('register') }}">Sign Up</a></li>
            <li><a href="{{ route('faq') }}">FAQS</a></li>
            <li><a href="{{ route('userdashboard') }}">My Account</a></li>
          </ul>
        </div>
        <a class="nav-link" href="{{ route('about') }}">
          <span><i class="bi bi-info-circle me-2 text-success"></i>About Us</span>
        </a>
        <a class="nav-link" href="{{ route('contact') }}">
          <span><i class="bi bi-telephone me-2 text-success"></i>Contact Us</span>
        </a>
      </nav>
      <div class="offcanvas-phone">
        <i class="bi bi-telephone-fill"></i> 01616-239896
      </div>
    </div>
  </div>

</section>
</header>

{{-- ── SHOP BANNER ── --}}
<section id="shopBanner">
  <div class="shopBnr"></div>
</section>

{{-- ── MAIN CONTENT ── --}}
<main>
  <section class="content">
    <div class="container p-0">
      <div class="row g-0">

        {{-- FILTER SIDEBAR --}}
        <div class="col-lg-3 filter-sidebar" id="filter-sidebar">
          <div class="d-flex align-items-center justify-content-between mb-4">
            <h5 class="mb-0 fw-bold">All Categories</h5>
            <button onclick="closeSidebar()" class="btn btn-success btn-sm d-lg-none">
              <i class="bi bi-x-lg"></i>
            </button>
          </div>
          <div class="mb-4">
            <button class="category-item active-cat" data-filter="all">
              <span><i class="bi bi-grid me-2"></i>All Products</span>
              <span class="cat-count">{{ $products->count() + $hotDeals->count() }}</span>
            </button>
            @foreach($categories as $cat)
              <button class="category-item" data-filter="{{ $cat }}">
                <span><i class="bi bi-tag me-2"></i>{{ ucfirst($cat) }}</span>
                <span class="cat-count">
                  {{ $products->where('category',$cat)->count() + $hotDeals->where('category',$cat)->count() }}
                </span>
              </button>
            @endforeach
          </div>
          <div class="bg-white text-dark p-4 rounded-4 mb-4 text-center">
            <h4 class="fw-bold text-success mb-1">79% Discount</h4>
            <p class="mb-3 small">on your first order</p>
            <a href="#" class="btn btn-success btn-sm px-4">Shop Now <i class="bi bi-arrow-right"></i></a>
          </div>
          <div class="text-center mt-3 text-muted small" id="results-count">
            {{ $products->count() + $hotDeals->count() }} Results Found
          </div>
        </div>

        {{-- PRODUCT GRID --}}
<div class="col-lg-9">
  <div class="top-bar d-flex align-items-center justify-content-between flex-wrap gap-3">
    <div class="d-flex align-items-center gap-3">
      <button onclick="toggleSidebar()" class="filter-btn btn btn-success d-lg-none">
        <i class="bi bi-list"></i>
      </button>
      <h4 class="mb-0 fw-semibold text-dark">Products</h4>
    </div>
    <div class="d-flex align-items-center gap-3">
      <input type="text" id="searchInput"
             class="form-control d-none d-lg-block"
             placeholder="Search products..."
             style="width: 240px;">
      <select id="sortSelect" class="form-select" style="width: 160px;">
        <option value="latest">Latest</option>
        <option value="name">Name A-Z</option>
      </select>
    </div>
  </div>
 
  <div class="p-4">
    <div class="row g-4" id="product-grid">
 
      {{-- ── Regular Products ── --}}
      @foreach($products as $product)
      @php
        $inWishlist = Auth::check()
          ? Auth::user()->wishlists->pluck('product_id')->contains($product->id)
          : false;
        $uid = 'product-' . $product->id; 
      @endphp
      <div class="col-6 col-lg-4 col-xl-3 product-col"
           data-category="{{ $product->category ?? 'other' }}">
        <div class="hotProduct-card" style="cursor:pointer;"
     onclick="window.location='{{ route('product', $product->id) }}'">
  @if($product->hasSale())
            <div class="sale-badge">-{{ $product->salePercent() }}%</div>
          @endif
          <div class="product-img-wrap">
            <div class="img-overlay">
              <div class="overlay-icons">
                <button class="wishlist-btn"
                        data-product-id="{{ $product->id }}"
                        data-product-type="product"
                        title="Wishlist">
                  <i class="bi bi-heart{{ $inWishlist ? '-fill' : '' }}"
                     style="{{ $inWishlist ? 'color:#e74c3c;' : '' }}"></i>
                </button>
                <button title="Quick View"><i class="bi bi-eye"></i></button>
              </div>
            </div>
            @if($product->image)
              <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
            @else
              <img src="{{ asset('frontend/image/Product Image.png') }}" alt="{{ $product->name }}">
            @endif
          </div>
          <div class="card-body-custom">
          <a href="{{ route('product', ['id' => $product->id]) }}" 
   class="product-name" 
   style="text-decoration:none;color:inherit;display:block;"
   onclick="event.stopPropagation();">
   {{ $product->name }}
</a>
            <div class="stars">
              <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              <i class="bi bi-star empty"></i>
            </div>
            <div class="price-row">
              <div class="price-block">
                <span class="price-main">৳{{ number_format($product->price,2) }}</span>
                @if($product->hasSale())
                  <span class="price-old">৳{{ number_format($product->old_price,2) }}</span>
                @endif
              </div>
              <div class="cart-action-wrap">
                {{-- ✅ data-uid দিয়ে unique করা হয়েছে --}}
                <button class="cart-btn show-qty-btn"
                        data-uid="{{ $uid }}"
                        data-product-id="{{ $product->id }}"
                        data-product-type="product">
                  <i class="bi bi-bag"></i>
                </button>
                <div class="qty-selector"
                     data-uid="{{ $uid }}"
                     data-product-id="{{ $product->id }}"
                     data-product-type="product"
                     style="display:none;">
                  <button class="qty-btn minus"><i class="bi bi-dash"></i></button>
                  <input type="number" class="qty-input"
                         value="1" min="1" max="{{ $product->stock }}">
                  <button class="qty-btn plus"><i class="bi bi-plus"></i></button>
                  <button class="add-to-cart-btn"
                          data-uid="{{ $uid }}"
                          data-product-id="{{ $product->id }}"
                          data-product-type="product">
                    <i class="bi bi-check-lg"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach
 
     {{-- ── Hot Deal Products ── --}}
@foreach($hotDeals as $deal)
@php
  $inWishlistDeal = Auth::check()
    ? Auth::user()->wishlists->pluck('product_id')->contains($deal->id)
    : false;

  $uid = 'hotdeal-' . $deal->id;
@endphp

<div class="col-6 col-lg-4 col-xl-3 product-col"
     data-category="{{ $deal->category ?? 'other' }}">

  <div class="hotProduct-card"
       style="cursor:pointer;"
       onclick="window.location='{{ route('product', ['id' => $deal->id]) }}?type=hotdeal'">

    {{-- 🔥 Hot Deal badge --}}
    <div class="hot-deal-badge">🔥 Hot Deal</div>

    @if($deal->hasSale())
      <div class="sale-badge">-{{ $deal->salePercent() }}%</div>
    @endif

    <div class="product-img-wrap">
      <div class="img-overlay">
        <div class="overlay-icons">

          <button class="wishlist-btn"
                  data-product-id="{{ $deal->id }}"
                  data-product-type="hotdeal"
                  title="Wishlist"
                  onclick="event.stopPropagation();">
            <i class="bi bi-heart{{ $inWishlistDeal ? '-fill' : '' }}"
               style="{{ $inWishlistDeal ? 'color:#e74c3c;' : '' }}"></i>
          </button>

          <button title="Quick View" onclick="event.stopPropagation();">
            <i class="bi bi-eye"></i>
          </button>

        </div>
      </div>

      @if($deal->image)
        <img src="{{ asset('storage/'.$deal->image) }}" alt="{{ $deal->name }}">
      @else
        <img src="{{ asset('frontend/image/Product Image.png') }}" alt="{{ $deal->name }}">
      @endif
    </div>

    <div class="card-body-custom">

      <a href="{{ route('product', ['id' => $deal->id]) }}?type=hotdeal"
         class="product-name"
         style="text-decoration:none;color:inherit;display:block;"
         onclick="event.stopPropagation();">
        {{ $deal->name }}
      </a>

      <div class="stars">
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i>
        <i class="bi bi-star empty"></i>
      </div>

      <div class="price-row">
        <div class="price-block">
          <span class="price-main">৳{{ number_format($deal->price, 2) }}</span>

          @if($deal->hasSale())
            <span class="price-old">৳{{ number_format($deal->old_price, 2) }}</span>
          @endif
        </div>

        <div class="cart-action-wrap" onclick="event.stopPropagation();">

          <button class="cart-btn show-qty-btn"
                  data-uid="{{ $uid }}"
                  data-product-id="{{ $deal->id }}"
                  data-product-type="hotdeal">
            <i class="bi bi-bag"></i>
          </button>

          <div class="qty-selector"
               data-uid="{{ $uid }}"
               data-product-id="{{ $deal->id }}"
               data-product-type="hotdeal"
               style="display:none;">

            <button class="qty-btn minus">
              <i class="bi bi-dash"></i>
            </button>

            <input type="number"
                   class="qty-input"
                   value="1"
                   min="1"
                   max="{{ $deal->stock }}">

            <button class="qty-btn plus">
              <i class="bi bi-plus"></i>
            </button>

            <button class="add-to-cart-btn"
                    data-uid="{{ $uid }}"
                    data-product-id="{{ $deal->id }}"
                    data-product-type="hotdeal">
              <i class="bi bi-check-lg"></i>
            </button>

          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endforeach
      {{-- Empty state --}}
      @if($products->isEmpty() && $hotDeals->isEmpty())
      <div class="col-12 text-center py-5">
        <img src="{{ asset('frontend/image/nodata.png') }}" alt=""
             style="max-width:200px;opacity:0.5;">
        <p class="text-muted mt-3">কোনো product পাওয়া যায়নি।</p>
      </div>
      @endif
 
    </div>
  </div>
</div>
      </div>
    </div>
  </section>
</main>

{{-- ── CART DRAWER ── --}}
<div class="cp-overlay" id="cpOverlay"></div>
<div class="cp-drawer" id="cpDrawer">
  <div class="cp-header">
    <div class="cp-title">
      <img src="{{ asset('frontend/image/Logo.png') }}" alt="">
    </div>
    <button class="cp-close" id="cpClose" aria-label="Close cart">
      <i class="bi bi-x-lg"></i>
    </button>
  </div>
  <div class="cp-items" id="cpItems"></div>
  <div class="cp-empty" id="cpEmpty" style="display:flex;">
    <i class="bi bi-bag-x"></i>
    <p>Your cart is empty</p>
    <a href="{{ route('shop') }}" class="cp-shop-link">Browse Products →</a>
  </div>
  <div class="cp-footer" id="cpFooter" style="display:none;">
    <div class="cp-subtotal">
      <span class="cp-sub-label"><span id="cpProductCount">0</span> Product</span>
      <span class="cp-sub-price" id="cpTotal">৳0.00</span>
    </div>
    <a href="{{ route('shop') }}" class="cp-checkout-btn">
      <i class="bi bi-bag-check-fill me-1"></i> Checkout
    </a>
  </div>
</div>

{{-- ── QUICK VIEW MODAL ── --}}
<div class="qv-backdrop" id="qvBackdrop">
  <div class="qv-modal" role="dialog" aria-modal="true">
    <button class="qv-close" id="qvClose" aria-label="Close"><i class="bi bi-x"></i></button>
    <div class="qv-img-side">
      <img id="qvImg" src="" alt="">
    </div>
    <div class="qv-info-side">
      <span class="qv-category" id="qvCat">Vegetables</span>
      <h2 class="qv-title" id="qvTitle"></h2>
      <div class="qv-stars">
        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
        <i class="bi bi-star empty"></i>
      </div>
      <div class="qv-price-row">
        <span class="qv-price-current" id="qvPrice"></span>
        <span class="qv-price-old" id="qvOld"></span>
        <span class="qv-discount" id="qvDiscount" style="display:none"></span>
      </div>
      <p class="qv-desc" id="qvDesc">Fresh, naturally grown product. Packed with nutrients and flavour — perfect for everyday cooking.</p>
      <div class="qv-qty-row">
        <span class="qv-qty-label">Qty</span>
        <div class="qv-qty-ctrl">
          <button class="qv-qty-btn" id="qvMinus"><i class="bi bi-dash"></i></button>
          <input class="qv-qty-val" id="qvQty" type="number" value="1" min="1" max="99">
          <button class="qv-qty-btn" id="qvPlus"><i class="bi bi-plus"></i></button>
        </div>
      </div>
      <div class="qv-btn-row">
        <button class="qv-btn-cart"><i class="bi bi-cart3"></i> Add to Cart</button>
        <button class="qv-btn-buy"><i class="bi bi-lightning-charge-fill"></i> Buy Now</button>
      </div>
    </div>
  </div>
</div>

{{-- ── FOOTER ── --}}
<footer class="main-footer">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-3 col-md-6 anim-fade-up d1">
        <img src="{{ asset('frontend/image/logoLight.png') }}" alt="">
        <p class="footer-desc">
          Morbi cursus porttitor enim lobortis molestie. Duis gravida turpis dui, eget bibendum magna congue nec.
        </p>
        <div class="footer-contact d-flex align-items-center flex-wrap">
          <a href="tel:01616239896">01616-239896</a>
          <span class="separator">or</span>
          <a href="mailto:Proxy@gmail.com">Proxy@gmail.com</a>
        </div>
      </div>
      <div class="col-lg-2 col-md-3 col-6 anim-fade-up d2">
        <h6 class="footer-col-title">My Account</h6>
        <ul class="footer-links">
          <li><a href="{{ route('userdashboard') }}">My Account</a></li>
          <li><a href="{{ route('userdashboard') }}">Order History</a></li>
          <li><a href="#" class="active">Shopping Cart</a></li>
          <li><a href="{{ route('wishlist') }}">Wishlist</a></li>
        </ul>
      </div>
      <div class="col-lg-2 col-md-3 col-6 anim-fade-up d3">
        <h6 class="footer-col-title">Helps</h6>
        <ul class="footer-links">
          <li><a href="{{ route('contact') }}">Contact</a></li>
          <li><a href="{{ route('faq') }}">FAQS</a></li>
          <li><a href="#">Terms &amp; Condition</a></li>
          <li><a href="#">Privacy Policy</a></li>
        </ul>
      </div>
      <div class="col-lg-2 col-md-3 col-6 anim-fade-up d4">
        <h6 class="footer-col-title">Proxy</h6>
        <ul class="footer-links">
          <li><a href="{{ route('about') }}">About</a></li>
          <li><a href="{{ route('shop') }}">Shop</a></li>
          <li><a href="#">Product</a></li>
        </ul>
      </div>
      <div class="col-lg-3 col-md-3 col-6 anim-fade-up d5">
        <h6 class="footer-col-title">Categories</h6>
        <ul class="footer-links">
          <li><a href="{{ route('shop') }}">Fruit &amp; Vegetables</a></li>
          <li><a href="{{ route('shop') }}">Meat &amp; Fish</a></li>
          <li><a href="{{ route('shop') }}">Bread &amp; Bakery</a></li>
          <li><a href="{{ route('shop') }}">Beauty &amp; Health</a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="footer-bottom mt-4">
    <div class="container">
      <div class="row align-items-center anim-fade-in d6">
        <div class="col-md-6 mySign">
          <p>BanglaBazar24/7 eCommerce © 2026. All Rights Reserved
            <span>Powered By <a href="https://github.com/devwithefran99">devwithErfan</a></span>
          </p>
        </div>
      </div>
    </div>
  </div>
</footer>

{{-- ── SCRIPTS ── --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/mixitup@3/dist/mixitup.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('frontend/js/common.js') }}"></script>
<script src="{{ asset('frontend/js/wishlist.js') }}"></script>
<script src="{{ asset('frontend/js/shop.js') }}"></script>

</body>
</html>