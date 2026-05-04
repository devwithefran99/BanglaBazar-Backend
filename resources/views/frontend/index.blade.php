<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="wishlist-url" content="{{ route('wishlist.toggle') }}">
<meta name="cart-add-url" content="{{ route('cart.add') }}">
<meta name="cart-count-url" content="{{ route('cart.count') }}">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<link rel="stylesheet" href="{{ asset('frontend/css/common.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
<title>BanglaBazar 24/7</title>

</head>
<body>

<!-- preloader -->
<div id="preloader">
  <div class="loader">
    <img src="{{ asset('frontend/image/Logo.png') }}" alt="logo">
    <p>Loading...</p>
  </div>
</div>

<!-- header -->
<header>
<section id="navigation">

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
              <li><a href="{{ route('product') }}">CheckOut</a></li>
              <li><a href="{{ route('signin') }}">Sign In</a></li>
              <li><a href="{{ route('register') }}">Sign Up</a></li>
              <li><a href="{{ route('faq') }}">FAQS</a></li>
              <li><a href="{{ route('userdashboard') }}">My Account</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('about') }}"><i class="bi bi-info-circle me-1"></i> About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('contact') }}"><i class="bi bi-telephone me-1"></i> Contact Us</a>
          </li>
        </ul>
        <div class="nav-phone d-none d-lg-flex">
          <i class="bi bi-telephone-fill"></i> 01616-239896
        </div>
      </div>
    </div>
  </nav>

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
            <li><a href="{{ route('product') }}">CheckOut</a></li>
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

<main>

  {{-- ── HERO BANNER ── --}}
  <section id="heroBanner" class="py-2 mt-3">
    <div class="container-fluid container-md px-2 px-md-3">
      <div class="row g-2">
        <div class="col-12 col-md-8">
          <div class="main-slider position-relative overflow-hidden rounded">
            <div class="slides position-relative w-100 h-100">
              <div class="slide active">
                <a href="{{ route('shop') }}"><img src="{{ asset('frontend/image/Bannar Big.png') }}" class="w-100" alt=""></a>
              </div>
              <div class="slide">
                <a href="{{ route('shop') }}"><img src="{{ asset('frontend/image/Bannar.png') }}" class="w-100" alt=""></a>
              </div>
              <div class="slide">
                <a href="{{ route('shop') }}"><img src="{{ asset('frontend/image/Bannar (1).png') }}" class="w-100" alt=""></a>
              </div>
            </div>
            <button class="slider-prev">&#10094;</button>
            <button class="slider-next">&#10095;</button>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="row g-2 h-100">
            <div class="col-6 col-md-12">
              <a href="{{ route('shop') }}"><img src="{{ asset('frontend/image/Bannar.png') }}" class="w-100 h-100 rounded object-fit-cover" alt=""></a>
            </div>
            <div class="col-6 col-md-12">
              <a href="{{ route('shop') }}"><img src="{{ asset('frontend/image/Bannar (1).png') }}" class="w-100 h-100 rounded object-fit-cover" alt=""></a>
            </div>
          </div>
        </div>
      </div>

      <div class="bg-light border border-secondary-subtle rounded-3 mt-3 p-2">
        <div class="row text-center g-0">
          <div class="col-3 border-end border-secondary-subtle d-flex flex-column align-items-center justify-content-center py-2 px-1">
            <img src="{{ asset('frontend/gif/wallet-security.gif') }}" alt="" class="mb-1" style="width:36px;height:36px;object-fit:contain;">
            <p class="mb-0 text-dark" style="font-size:10px;line-height:1.3;">Cash On<br>Delivery</p>
          </div>
          <div class="col-3 border-end border-secondary-subtle d-flex flex-column align-items-center justify-content-center py-2 px-1">
            <img src="{{ asset('frontend/gif/truck.gif') }}" alt="" class="mb-1" style="width:36px;height:36px;object-fit:contain;">
            <p class="mb-0 text-dark" style="font-size:10px;line-height:1.3;">Fast<br>Delivery</p>
          </div>
          <div class="col-3 border-end border-secondary-subtle d-flex flex-column align-items-center justify-content-center py-2 px-1">
            <img src="{{ asset('frontend/gif/helpdesk.gif') }}" alt="" class="mb-1" style="width:36px;height:36px;object-fit:contain;">
            <p class="mb-0 text-dark" style="font-size:10px;line-height:1.3;">Customer<br>Support</p>
          </div>
          <div class="col-3 d-flex flex-column align-items-center justify-content-center py-2 px-1">
            <img src="{{ asset('frontend/gif/deal.gif') }}" alt="" class="mb-1" style="width:36px;height:36px;object-fit:contain;">
            <p class="mb-0 text-dark" style="font-size:10px;line-height:1.3;">Best<br>Deals</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ── CATEGORIES ── --}}
  <section>
    <div class="container">
      <div class="section-wrapper">
        <div class="section-header">
          <h2 class="section-title">Popular <span>Categories</span></h2>
          <a href="{{ route('shop') }}" class="view-all">
            View All
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
              <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </a>
        </div>
        <div class="row g-2">
          @foreach([
            ['frontend/image/image 1 (1).png','Fresh Fruit'],
            ['frontend/image/image 1 (2).png','Fresh Vegetables'],
            ['frontend/image/image 1 (3).png','Fresh Vegetables'],
            ['frontend/image/image 1 (4).png','Fresh Vegetables'],
            ['frontend/image/image 1 (5).png','Fresh Vegetables'],
            ['frontend/image/image 1 (1).png','Fresh Vegetables'],
            ['frontend/image/image 1 (2).png','Fresh Vegetables'],
            ['frontend/image/image 1 (3).png','Fresh Vegetables'],
            ['frontend/image/image 1 (4).png','Fresh Vegetables'],
            ['frontend/image/image 1 (4).png','Fresh Vegetables'],
            ['frontend/image/image 1 (4).png','Fresh Vegetables'],
            ['frontend/image/image 1 (2).png','Fresh Vegetables'],
          ] as [$img, $name])
          <div class="col-6 col-md-3 col-lg-2 cat-col">
            <div class="cat-card">
              <div class="img-box">
                <a href="{{ route('shop') }}"><img src="{{ asset($img) }}" alt="{{ $name }}"></a>
              </div>
              <span class="cat-name">{{ $name }}</span>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </section>

  {{-- ── POPULAR PRODUCTS ── --}}
  <section id="populer">
    <div class="container px-3 py-4">
      <div class="section-header">
        <h2 style="font-size:30px;font-weight:700;margin:0;">
          Popular <span style="color:#22c55e;">Products</span>
        </h2>
        <a href="{{ route('shop') }}" class="view-all">View All <i class="bi bi-arrow-right"></i></a>
      </div>

      <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-3">
        @forelse($popularProducts as $product)
        @php
          $inWishlist = Auth::check()
            ? Auth::user()->wishlists->pluck('product_id')->contains($product->id)
            : false;
          $uid = 'product-' . $product->id;
        @endphp
        <div class="col">
          <div class="product-card h-100">
            @if($product->hasSale())
              <div class="sale-badge">Sale {{ $product->salePercent() }}%</div>
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
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
              @else
                <img src="{{ asset('frontend/image/Product Image.png') }}" alt="{{ $product->name }}">
              @endif
            </div>
            <div class="card-body-custom">
              <div class="product-name">{{ $product->name }}</div>
              <div class="stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                <i class="bi bi-star empty"></i>
              </div>
              <div class="price-row">
                <div class="price-block">
                  <span class="price-main">৳{{ number_format($product->price, 2) }}</span>
                  @if($product->hasSale())
                    <span class="price-old">৳{{ number_format($product->old_price, 2) }}</span>
                  @endif
                </div>
                <div class="cart-action-wrap">
                  {{-- ✅ data-uid যোগ করা হয়েছে --}}
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
                    <input type="number" class="qty-input" value="1" min="1" max="{{ $product->stock }}">
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
        @empty
        <div class="col-12 text-center py-5 text-muted">No featured products yet.</div>
        @endforelse
      </div>
    </div>
  </section>

  {{-- ── DISCOUNT BANNER ── --}}
  <section id="discountBanner">
    <div class="container">
      <div class="row">
        <div class="discountBnr"></div>
      </div>
    </div>
  </section>

  {{-- ── HOT DEALS ── --}}
  <section id="hotDeals">
    <div class="container" style="padding:24px 16px;">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;">
        <h2 style="font-size:30px;font-weight:700;margin-top:30px;">
          Hot <span style="color:#22c55e;">Deals</span>
        </h2>
        <a href="{{ route('shop') }}" style="color:#22c55e;font-size:14px;font-weight:500;text-decoration:none;">
          View All <i class="bi bi-arrow-right"></i>
        </a>
      </div>

      <div class="row g-3">

        @if($hotDeals->isNotEmpty())
          @php $featured = $hotDeals->first(); $featuredUid = 'hotdeal-' . $featured->id; @endphp

          {{-- Featured Big Card --}}
          <div class="col-12 col-md-6 col-lg-4">
            <div class="featured-card">
              @if($featured->hasSale())
                <div class="sale-badge">Sale {{ $featured->salePercent() }}%</div>
              @endif
              <div class="best-badge">Best Sale</div>
              <div class="featured-img-wrap">
                @if($featured->image)
                  <img src="{{ asset('storage/' . $featured->image) }}" alt="{{ $featured->name }}">
                @else
                  <img src="{{ asset('frontend/image/bigApple.png') }}" alt="{{ $featured->name }}">
                @endif
              </div>
              <div class="featured-action-row">
                <a href="{{ route('wishlist') }}" class="icon-btn"><i class="bi bi-heart"></i></a>
                {{-- ✅ Featured card এও uid যোগ করা হয়েছে --}}
                <button class="cart-btn show-qty-btn"
                        data-uid="{{ $featuredUid }}"
                        data-product-id="{{ $featured->id }}"
                        data-product-type="hotdeal">
                  <i class="bi bi-bag"></i> Add to Cart
                </button>
                <button title="Quick View" class="icon-btn"><i class="bi bi-eye"></i></button>
              </div>
              {{-- Featured qty selector --}}
              <div class="qty-selector"
                   data-uid="{{ $featuredUid }}"
                   data-product-id="{{ $featured->id }}"
                   data-product-type="hotdeal"
                   style="display:none;">
                <button class="qty-btn minus"><i class="bi bi-dash"></i></button>
                <input type="number" class="qty-input" value="1" min="1" max="{{ $featured->stock }}">
                <button class="qty-btn plus"><i class="bi bi-plus"></i></button>
                <button class="add-to-cart-btn"
                        data-uid="{{ $featuredUid }}"
                        data-product-id="{{ $featured->id }}"
                        data-product-type="hotdeal">
                  <i class="bi bi-check-lg"></i>
                </button>
              </div>
              <div class="featured-info">
                <div class="name">{{ $featured->name }}</div>
                <div class="prices">
                  ৳{{ number_format($featured->price, 2) }}
                  @if($featured->hasSale())
                    <span class="old">৳{{ number_format($featured->old_price, 2) }}</span>
                  @endif
                </div>
                <div class="feedback">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-half"></i>
                </div>
                @if($featured->deal_ends_at && $featured->isLive())
                  <div class="hurry">Hurry up! Offer ends in:</div>
                  <div class="countdown" data-ends="{{ $featured->deal_ends_at->timestamp * 1000 }}">
                    <div class="cd-box"><span class="num cd-days">00</span><span class="lbl">Days</span></div>
                    <span class="cd-sep">:</span>
                    <div class="cd-box"><span class="num cd-hours">00</span><span class="lbl">Hours</span></div>
                    <span class="cd-sep">:</span>
                    <div class="cd-box"><span class="num cd-mins">00</span><span class="lbl">Mins</span></div>
                    <span class="cd-sep">:</span>
                    <div class="cd-box"><span class="num cd-secs">00</span><span class="lbl">Secs</span></div>
                  </div>
                @endif
              </div>
            </div>
          </div>

          {{-- Right Grid: 2 থেকে 7 নম্বর deal --}}
          <div class="col-12 col-md-6 col-lg-8">
            <div class="row g-3">
              @foreach($hotDeals->skip(1)->take(6) as $deal)
              @php
                $inWishlistDeal = Auth::check()
                  ? Auth::user()->wishlists->pluck('product_id')->contains($deal->id)
                  : false;
                $uid = 'hotdeal-' . $deal->id;
              @endphp
              <div class="col-6 col-lg-4">
                <div class="hotProduct-card">
                  @if($deal->hasSale())
                    <div class="sale-badge">Sale {{ $deal->salePercent() }}%</div>
                  @endif
                  <div class="product-img-wrap">
                    <div class="img-overlay">
                      <div class="overlay-icons">
                        <button class="wishlist-btn"
                                data-product-id="{{ $deal->id }}"
                                data-product-type="hotdeal"
                                title="Wishlist">
                          <i class="bi bi-heart{{ $inWishlistDeal ? '-fill' : '' }}"
                             style="{{ $inWishlistDeal ? 'color:#e74c3c;' : '' }}"></i>
                        </button>
                        <button title="Quick View"><i class="bi bi-eye"></i></button>
                      </div>
                    </div>
                    @if($deal->image)
                      <img src="{{ asset('storage/' . $deal->image) }}" alt="{{ $deal->name }}">
                    @else
                      <img src="{{ asset('frontend/image/Product Image (1).png') }}" alt="{{ $deal->name }}">
                    @endif
                  </div>
                  <div class="card-body-custom">
                    <div class="product-name">{{ $deal->name }}</div>
                    <div class="stars">
                      <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                      <i class="bi bi-star empty"></i>
                    </div>
                    <div class="price-row">
                      <div class="price-block">
                        <span class="price-main">৳{{ number_format($deal->price, 2) }}</span>
                        @if($deal->hasSale())
                          <span class="price-old">৳{{ number_format($deal->old_price, 2) }}</span>
                        @endif
                      </div>
                      <div class="cart-action-wrap">
                        {{-- ✅ data-uid যোগ করা হয়েছে --}}
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
                          <button class="qty-btn minus"><i class="bi bi-dash"></i></button>
                          <input type="number" class="qty-input" value="1" min="1" max="{{ $deal->stock }}">
                          <button class="qty-btn plus"><i class="bi bi-plus"></i></button>
                          <button class="add-to-cart-btn"
                                  data-uid="{{ $uid }}"
                                  data-product-id="{{ $deal->id }}"
                                  data-product-type="hotdeal">
                            <i class="bi bi-check-lg"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                    @if($deal->deal_ends_at && $deal->isLive())
                      <div class="countdown mt-1" data-ends="{{ $deal->deal_ends_at->timestamp * 1000 }}">
                        <div class="cd-box"><span class="num cd-days">00</span><span class="lbl">D</span></div>
                        <span class="cd-sep">:</span>
                        <div class="cd-box"><span class="num cd-hours">00</span><span class="lbl">H</span></div>
                        <span class="cd-sep">:</span>
                        <div class="cd-box"><span class="num cd-mins">00</span><span class="lbl">M</span></div>
                        <span class="cd-sep">:</span>
                        <div class="cd-box"><span class="num cd-secs">00</span><span class="lbl">S</span></div>
                      </div>
                    @endif
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>

          {{-- Bottom Row: 8 থেকে 12 নম্বর deal --}}
          @foreach($hotDeals->skip(7)->take(5) as $deal)
          @php
            $inWishlistBottom = Auth::check()
              ? Auth::user()->wishlists->pluck('product_id')->contains($deal->id)
              : false;
            $uid = 'hotdeal-' . $deal->id;
          @endphp
          <div class="bottom-col {{ $loop->last ? 'd-none d-lg-block' : '' }}">
            <div class="hotProduct-card">
              @if($deal->hasSale())
                <div class="sale-badge">Sale {{ $deal->salePercent() }}%</div>
              @endif
              <div class="product-img-wrap">
                <div class="img-overlay">
                  <div class="overlay-icons">
                    <button class="wishlist-btn"
                            data-product-id="{{ $deal->id }}"
                            data-product-type="hotdeal"
                            title="Wishlist">
                      <i class="bi bi-heart{{ $inWishlistBottom ? '-fill' : '' }}"
                         style="{{ $inWishlistBottom ? 'color:#e74c3c;' : '' }}"></i>
                    </button>
                    <button title="Quick View"><i class="bi bi-eye"></i></button>
                  </div>
                </div>
                @if($deal->image)
                  <img src="{{ asset('storage/' . $deal->image) }}" alt="{{ $deal->name }}">
                @else
                  <img src="{{ asset('frontend/image/hotProduct1 (4).png') }}" alt="{{ $deal->name }}">
                @endif
              </div>
              <div class="card-body-custom">
                <div class="product-name">{{ $deal->name }}</div>
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star empty"></i><i class="bi bi-star empty"></i>
                </div>
                <div class="price-row">
                  <div class="price-block">
                    <span class="price-main">৳{{ number_format($deal->price, 2) }}</span>
                  </div>
                  <div class="cart-action-wrap">
                    {{-- ✅ data-uid যোগ করা হয়েছে --}}
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
                      <button class="qty-btn minus"><i class="bi bi-dash"></i></button>
                      <input type="number" class="qty-input" value="1" min="1" max="{{ $deal->stock }}">
                      <button class="qty-btn plus"><i class="bi bi-plus"></i></button>
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

        @else
          <div class="col-12 text-center py-5 text-muted">No hot deals available at the moment.</div>
        @endif

      </div>
    </div>
  </section>

  {{-- ── FEATURE PRODUCTS ── --}}
  <section id="featureProduct" class="new-trends-section">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center">
        <h2 class="section-title text-dark">
          Feature <span style="color:#22c55e;">Product</span>
        </h2>
        <div class="d-flex gap-2">
          <button class="arrow-btn prev">&#8249;</button>
          <button class="arrow-btn next">&#8250;</button>
        </div>
      </div>

      <div class="slider-wrapper">
        <div class="slider-track">
          @forelse($featureProducts as $product)
          @php
            $inWishlist = Auth::check()
              ? Auth::user()->wishlists->pluck('product_id')->contains($product->id)
              : false;
            $uid = 'product-' . $product->id;
          @endphp
          <div class="slider-product">
            @if($product->hasSale())
              <div class="sale-badge">৳{{ number_format($product->old_price - $product->price, 0) }} OFF</div>
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
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
              @else
                <img src="{{ asset('frontend/image/Product Image (1).png') }}" alt="{{ $product->name }}">
              @endif
            </div>
            <div class="card-body-custom">
              <div class="product-name">{{ $product->name }}</div>
              <div class="stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                <i class="bi bi-star empty"></i>
              </div>
              <div class="price-row">
                <div class="price-block">
                  <span class="price-main">৳{{ number_format($product->price, 2) }}</span>
                  @if($product->hasSale())
                    <span class="price-old">৳{{ number_format($product->old_price, 2) }}</span>
                  @endif
                </div>
                <div class="cart-action-wrap">
                  {{-- ✅ data-uid যোগ করা হয়েছে --}}
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
                    <input type="number" class="qty-input" value="1" min="1" max="{{ $product->stock }}">
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
          @empty
          {{-- Static fallback --}}
          @foreach(range(1,7) as $i)
          <div class="slider-product">
            <div class="sale-badge">৳40 OFF</div>
            <div class="product-img-wrap">
              <div class="img-overlay">
                <div class="overlay-icons">
                  <button class="wishlist-btn" title="Wishlist">
                    <i class="bi bi-heart"></i>
                  </button>
                  <button title="Quick View"><i class="bi bi-eye"></i></button>
                </div>
              </div>
              <img src="{{ asset('frontend/image/Product Image (1).png') }}">
            </div>
            <div class="card-body-custom">
              <div class="product-name">Product Name</div>
              <div class="stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                <i class="bi bi-star empty"></i>
              </div>
              <div class="price-row">
                <div class="price-block">
                  <span class="price-main">৳80</span>
                  <span class="price-old">৳120</span>
                </div>
                <button class="cart-btn"><i class="bi bi-bag"></i></button>
              </div>
            </div>
          </div>
          @endforeach
          @endforelse
        </div>
      </div>

      <div class="slider-dots"></div>
    </div>
  </section>

  {{-- ── TESTIMONIALS ── --}}
  <section id="feedback" class="py-5">
    <div class="container">
      <h2 class="section-title text-start">Client <span style="color:#22c55e;">Testimonials</span></h2>
      <div class="owl-carousel testimonial-slider">
        @foreach([
          ['clients (1).png','Robert Fox'],
          ['clients (2).png','Dianne Russell'],
          ['clients (3).png','Eleanor Pena'],
          ['bigApple.png','Jenny Wilson'],
        ] as [$img, $name])
        <div class="testimonial-card">
          <div class="quote">"</div>
          <p class="testimonial-text">
            Pellentesque eu nibh eget mauris congue mattis mattis nec tellus.
            Phasellus imperdiet elit eu magna dictum.
          </p>
          <div class="client-info">
            <div class="client-left">
              <img src="{{ asset('frontend/image/' . $img) }}" class="client-img">
              <div>
                <p class="client-name">{{ $name }}</p>
                <p class="client-role">Customer</p>
              </div>
            </div>
            <div class="stars">★★★★★</div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>

</main>

{{-- ── CART DRAWER ── --}}
<div class="cp-overlay" id="cpOverlay"></div>
<div class="cp-drawer" id="cpDrawer">
  <div class="cp-header">
    <div class="cp-title">
      <img src="{{ asset('frontend/image/Logo.png') }}" alt="Logo">
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
      <i class="bi bi-bag-check-fill me-1"></i> Continue Shopping
    </a>
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
          <li><a href="{{ route('shop') }}">Product</a></li>
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
        <div class="col-12 mySign">
          <p>BanglaBazar24/7 eCommerce © 2026. All Rights Reserved
            <span>Powered By <a href="https://github.com/devwithefran99">devwithErfan</a></span>
          </p>
        </div>
      </div>
    </div>
  </div>
</footer>

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

{{-- ── SCRIPTS ── --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('frontend/js/common.js') }}"></script>
<script src="{{ asset('frontend/js/wishlist.js') }}"></script>
<script src="{{ asset('frontend/js/app.js') }}"></script>
@stack('scripts')

</body>
</html>