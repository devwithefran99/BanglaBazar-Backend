<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="wishlist-url" content="{{ route('wishlist.toggle') }}">
    <title>{{ $item->name ?? 'Product' }} | BanglaBazar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="{{ asset('frontend/css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/pages.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
</head>
<body>

<!-- preloader -->
<div id="preloader">
    <div class="loader">
        <img src="{{ asset('frontend/image/Logo.png') }}" alt="Logo">
        <p>Loading...</p>
    </div>
</div>
<!-- preloader ends -->

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
                    <a href="{{ route('home') }}" class="logo-slot">
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
                        <a href="#" class="icon-btn cart-btn" id="navCartBtn">
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
<!-- header ends -->

@php
    /* ── helpers ── */
    $hasImage   = !empty($item->image);
    $imageSrc   = $hasImage ? asset('storage/' . $item->image) : asset('frontend/image/Product Image (1).png');
    $hasSale    = $item->hasSale();
    $saleAmt    = $hasSale ? number_format($item->old_price - $item->price, 2) : null;
    $salePct    = $hasSale ? $item->salePercent() : null;
    $inWishlist = Auth::check()
                    ? Auth::user()->wishlists->pluck('product_id')->contains($item->id)
                    : false;
  $checkoutUrl = url('/checkout') . '?type=' . $type . '&id=' . $item->id . '&qty=1';
@endphp

<!-- product detail section -->
<section>
    <div class="container">
        <div class="pd-wrap">

            {{-- ── GALLERY ── --}}
            <div class="pd-gallery">
                <div class="pd-thumbs" id="thumbs">
                    {{-- Main product image as first thumb --}}
                    <div class="pd-thumb active" onclick="switchMain(this, '{{ $imageSrc }}')">
                        <img src="{{ $imageSrc }}" alt="{{ $item->name }}">
                    </div>
                    {{-- Fallback extra thumbs if no additional images
                    <div class="pd-thumb" onclick="switchMain(this, '{{ asset('frontend/image/chechout (1).png') }}')">
                        <img src="{{ asset('frontend/image/chechout (1).png') }}" alt="">
                    </div>
                    <div class="pd-thumb" onclick="switchMain(this, '{{ asset('frontend/image/chechout (2).png') }}')">
                        <img src="{{ asset('frontend/image/chechout (2).png') }}" alt="">
                    </div>
                    <div class="pd-thumb" onclick="switchMain(this, '{{ asset('frontend/image/chechout (3).png') }}')">
                        <img src="{{ asset('frontend/image/chechout (3).png') }}" alt="">
                    </div> --}}
                </div>
                <div class="pd-main-img-wrap">
                    <img id="mainImg" src="{{ $imageSrc }}" alt="{{ $item->name }}">
                </div>
            </div>

            {{-- ── PRODUCT INFO ── --}}
            <div class="pd-info">

                {{-- Stock badge --}}
                @if($item->stock > 0)
                    <span class="pd-badge">In Stock</span>
                @else
                    <span class="pd-badge" style="background:#fee2e2;color:#dc2626;">Out of Stock</span>
                @endif

                {{-- Type badge (Hot Deal) --}}
                @if($type === 'hotdeal')
                    <span class="pd-badge" style="background:#fff7ed;color:#ea580c;margin-left:6px;">🔥 Hot Deal</span>
                @endif

                <h1 class="pd-title">{{ $item->name }}</h1>

                <div class="pd-rating">
                    <div class="pd-stars">
                        @for($s = 1; $s <= 5; $s++)
                        <svg class="pd-star{{ $s == 5 ? ' empty' : '' }}" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        @endfor
                    </div>
                    <span class="pd-reviews">4 Reviews</span>
                    <span class="pd-sku">• SKU: {{ str_pad($item->id, 6, '0', STR_PAD_LEFT) }}</span>
                </div>

                {{-- Price row --}}
                <div class="pd-price-row">
                    @if($hasSale)
                        <span class="pd-price-old">৳{{ number_format($item->old_price, 2) }}</span>
                        <span class="pd-price-now">৳{{ number_format($item->price, 2) }}</span>
                        <span class="pd-discount">{{ $salePct }}% Off</span>
                    @else
                        <span class="pd-price-now">৳{{ number_format($item->price, 2) }}</span>
                    @endif
                </div>

                <div class="pd-divider"></div>

                {{-- Description short --}}
                <p class="pd-desc">
                    @if($item->description)
                        {{ Str::limit($item->description, 200) }}
                    @else
                        Fresh quality product delivered right to your doorstep. Carefully sourced and packed to ensure maximum freshness and satisfaction.
                    @endif
                </p>

                {{-- Quantity selector --}}
                <div class="pd-qty-row">
                    <span class="pd-qty-label">Quantity:</span>
                    <div class="pd-qty">
                        <button class="pd-qty-btn" id="minusBtn" onclick="changeQty(-1)">−</button>
                        <span class="pd-qty-num" id="qtyNum">1</span>
                        <button class="pd-qty-btn" onclick="changeQty(1)">+</button>
                    </div>
                    <span style="font-size:12px;color:#94a3b8;margin-left:8px;">
                        ({{ $item->stock }} available)
                    </span>
                </div>

                {{-- Action buttons --}}
                <div class="pd-btns">
                    {{-- Add to Cart --}}
                    @if($item->stock > 0)
                        <button class="pd-btn-cart"
                                id="pdCartBtn"
                                data-product-id="{{ $item->id }}"
                                data-product-type="{{ $type }}"
                                onclick="pdAddToCart()">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2.2">
                                <circle cx="9" cy="21" r="1"/>
                                <circle cx="20" cy="21" r="1"/>
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                            </svg>
                            Add to Cart
                        </button>

                        {{-- Buy Now → Checkout --}}
                        <a id="pdBuyNowBtn"
                           href="{{ $checkoutUrl }}"
                           class="pd-btn-buy">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2.2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                            Buy Now
                        </a>
                    @else
                        <button class="pd-btn-cart" disabled style="opacity:.5;cursor:not-allowed;">
                            Out of Stock
                        </button>
                    @endif

                    {{-- Wishlist --}}
                    <button class="wishlist-btn"
                            data-product-id="{{ $item->id }}"
                            data-product-type="{{ $type }}"
                            title="Add to Wishlist"
                            style="background:{{ $inWishlist ? '#fee2e2' : '#f1f5f9' }};
                                   border:1.5px solid {{ $inWishlist ? '#fca5a5' : '#e2e8f0' }};
                                   border-radius:10px;padding:10px 14px;cursor:pointer;
                                   font-size:18px;transition:all .2s;">
                        <i class="bi bi-heart{{ $inWishlist ? '-fill' : '' }}"
                           style="color:{{ $inWishlist ? '#e74c3c' : '#64748b' }};"></i>
                    </button>
                </div>

                {{-- Payment badges --}}
                <div class="pd-pay-row">
                    <span class="pd-pay-label">Pay via:</span>
                    <span class="pd-pay-badge">
                        <span class="pd-pay-dot"></span> Cash on Delivery
                    </span>
                    <span class="pd-pay-badge">
                        <span class="pd-pay-dot bkash"></span> bKash
                    </span>
                </div>

                {{-- Category if available --}}
                @if($item->category)
                <div style="margin-top:12px;font-size:13px;color:#64748b;">
                    <strong>Category:</strong>
                    <span style="background:#f0fdf4;color:#16a34a;padding:2px 10px;
                                 border-radius:20px;font-weight:600;margin-left:4px;">
                        {{ ucfirst($item->category) }}
                    </span>
                </div>
                @endif

            </div>{{-- /pd-info --}}
        </div>{{-- /pd-wrap --}}

        <div class="pd-toast" id="toast"></div>
    </div>
</section>
<!-- product detail section ends -->

<!-- tabs: description / additional info / reviews -->
<section id="details">
    <div class="container">
        <div class="tab-wrap">
            <nav class="tab-nav">
                <button class="tab-btn active" onclick="switchTab('desc', this)">Description</button>
                <button class="tab-btn" onclick="switchTab('info', this)">Additional Information</button>
                <button class="tab-btn" onclick="switchTab('feedback', this)">Customer Feedback</button>
            </nav>

            {{-- ── DESCRIPTION ── --}}
            <div class="tab-panel active" id="tab-desc">
                <div class="desc-grid">
                    <div>
                        <h2 class="desc-heading">{{ $item->name }} — Fresh &amp; Quality</h2>
                        <p class="desc-body">
                            @if($item->description)
                                {{ $item->description }}
                            @else
                                Our product is carefully sourced and quality-checked before delivery.
                                We ensure maximum freshness and satisfaction for every order placed
                                through BanglaBazar.
                            @endif
                        </p>
                        <p class="desc-body">
                            Each item is hand-selected for quality, carefully packaged and stored
                            to preserve natural freshness from source to your doorstep.
                        </p>
                        <ul class="desc-list">
                            <li>Premium quality — carefully selected</li>
                            <li>Fast and safe delivery</li>
                            <li>{{ $item->stock }} units currently available</li>
                            @if($hasSale)
                            <li>Save ৳{{ $saleAmt }} — {{ $salePct }}% discount applied</li>
                            @endif
                            <li>Secure payment: Cash on Delivery &amp; bKash</li>
                        </ul>
                        <div class="desc-badges">
                            <span class="desc-badge green">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                </svg>
                                Premium Quality
                            </span>
                            <span class="desc-badge gold">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                    <path d="M12 8v4l3 3"/>
                                </svg>
                                Fast Delivery
                            </span>
                            @if($hasSale)
                            <span class="desc-badge green">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                                {{ $salePct }}% Discount
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="desc-img-card">
                        <img src="{{ $imageSrc }}" alt="{{ $item->name }}">
                    </div>
                </div>
            </div>

            {{-- ── ADDITIONAL INFORMATION ── --}}
            <div class="tab-panel" id="tab-info">
                <table class="info-table">
                    <tr>
                        <td>Product Name</td>
                        <td>{{ $item->name }}</td>
                    </tr>
                    @if($item->category)
                    <tr>
                        <td>Category</td>
                        <td>
                            <span class="info-chip green">{{ ucfirst($item->category) }}</span>
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td>Sale Price</td>
                        <td style="color:#22c55e;font-weight:700;">
                            ৳{{ number_format($item->price, 2) }}
                        </td>
                    </tr>
                    @if($hasSale)
                    <tr>
                        <td>Original Price</td>
                        <td style="text-decoration:line-through;color:#94a3b8;">
                            ৳{{ number_format($item->old_price, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <td>You Save</td>
                        <td style="color:#ef4444;font-weight:700;">
                            ৳{{ $saleAmt }} ({{ $salePct }}% OFF)
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td>Stock Status</td>
                        <td>
                            @if($item->stock > 0)
                                <span class="info-stock">Available</span>
                                <span class="info-count">({{ $item->stock }} units)</span>
                            @else
                                <span style="color:#ef4444;font-weight:600;">Out of Stock</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Product Type</td>
                        <td>
                            <span class="info-chip {{ $type === 'hotdeal' ? 'neutral' : 'green' }}">
                                {{ $type === 'hotdeal' ? '🔥 Hot Deal' : '⭐ Regular Product' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>SKU</td>
                        <td>{{ str_pad($item->id, 6, '0', STR_PAD_LEFT) }}</td>
                    </tr>
                    @if($type === 'hotdeal' && isset($item->deal_ends_at) && $item->deal_ends_at)
                    <tr>
                        <td>Deal Ends</td>
                        <td style="color:#ef4444;font-weight:600;">
                            {{ $item->deal_ends_at->format('d M Y, h:i A') }}
                        </td>
                    </tr>
                    @endif
                </table>
            </div>

            {{-- ── CUSTOMER FEEDBACK (static UI — connect to reviews model later) ── --}}
            <div class="tab-panel" id="tab-feedback">
                <div class="fb-summary">
                    <div style="text-align:center">
                        <div class="fb-big-score">4.8</div>
                        <div style="display:flex;gap:3px;justify-content:center;margin:6px 0">
                            @for($i = 0; $i < 5; $i++)
                            <svg class="fb-star" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            @endfor
                        </div>
                        <div class="fb-score-label">4 reviews</div>
                    </div>
                    <div class="fb-bars">
                        <div class="fb-bar-row">
                            <span class="fb-bar-label">5</span>
                            <div class="fb-bar-track"><div class="fb-bar-fill" style="width:75%"></div></div>
                            <span class="fb-bar-count">3</span>
                        </div>
                        <div class="fb-bar-row">
                            <span class="fb-bar-label">4</span>
                            <div class="fb-bar-track"><div class="fb-bar-fill" style="width:25%"></div></div>
                            <span class="fb-bar-count">1</span>
                        </div>
                        <div class="fb-bar-row">
                            <span class="fb-bar-label">3</span>
                            <div class="fb-bar-track"><div class="fb-bar-fill" style="width:0%"></div></div>
                            <span class="fb-bar-count">0</span>
                        </div>
                        <div class="fb-bar-row">
                            <span class="fb-bar-label">2</span>
                            <div class="fb-bar-track"><div class="fb-bar-fill" style="width:0%"></div></div>
                            <span class="fb-bar-count">0</span>
                        </div>
                        <div class="fb-bar-row">
                            <span class="fb-bar-label">1</span>
                            <div class="fb-bar-track"><div class="fb-bar-fill" style="width:0%"></div></div>
                            <span class="fb-bar-count">0</span>
                        </div>
                    </div>
                </div>
                <div class="fb-cards">
                    <div class="fb-card">
                        <div class="fb-card-top">
                            <div class="fb-avatar" style="background:#d4ede3;color:#007a3d">RK</div>
                            <div>
                                <div class="fb-name">Rahim Khan</div>
                                <div class="fb-date">12 April 2025</div>
                            </div>
                            <span class="fb-verified">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2.5">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                                Verified
                            </span>
                        </div>
                        <div class="fb-stars-row">
                            @for($i = 0; $i < 5; $i++)
                            <svg class="fb-star" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            @endfor
                        </div>
                        <p class="fb-text">খুবই তাজা এবং সুন্দর ছিল। দ্রুত ডেলিভারি পেয়েছি। আবার অর্ডার করবো ইনশাআল্লাহ।</p>
                    </div>
                    <div class="fb-card">
                        <div class="fb-card-top">
                            <div class="fb-avatar" style="background:#fdf3e3;color:#c8922a">SA</div>
                            <div>
                                <div class="fb-name">Sultana Akter</div>
                                <div class="fb-date">8 April 2025</div>
                            </div>
                            <span class="fb-verified">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2.5">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                                Verified
                            </span>
                        </div>
                        <div class="fb-stars-row">
                            @for($i = 0; $i < 4; $i++)
                            <svg class="fb-star" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            @endfor
                            <svg class="fb-star empty" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </div>
                        <p class="fb-text">দাম অনুযায়ী মান অনেক ভালো। প্যাকেজিং পরিষ্কার ছিল।</p>
                    </div>
                    <div class="fb-card">
                        <div class="fb-card-top">
                            <div class="fb-avatar" style="background:#e6f1fb;color:#185fa5">MH</div>
                            <div>
                                <div class="fb-name">Mostofa Hasan</div>
                                <div class="fb-date">2 April 2025</div>
                            </div>
                            <span class="fb-verified">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2.5">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                                Verified
                            </span>
                        </div>
                        <div class="fb-stars-row">
                            @for($i = 0; $i < 5; $i++)
                            <svg class="fb-star" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            @endfor
                        </div>
                        <p class="fb-text">Excellent product! Delivery was super fast. Highly recommended for everyone.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- tabs end -->

<main></main>

<!-- cart popup -->
<section>
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
        <div class="cp-empty" id="cpEmpty">
            <i class="bi bi-bag-x"></i>
            <p>Your cart is empty</p>
            <a href="{{ route('shop') }}" class="cp-shop-link">Browse Products →</a>
        </div>
        <div class="cp-footer" id="cpFooter">
            <div class="cp-subtotal">
                <span class="cp-sub-label"><span id="cpProductCount">0</span> Product</span>
                <span class="cp-sub-price" id="cpTotal">৳0.00</span>
            </div>
          <a href="{{ route('checkout.show') }}" class="cp-checkout-btn">
                <i class="bi bi-bag-check-fill me-1"></i> Checkout
            </a>
            <a href="#" class="cp-cart-link">Go To Cart</a>
        </div>
    </div>
</section>
<!-- cart popup ends -->

<!-- footer -->
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
                    <li><a href="#">Shopping Cart</a></li>
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
<!-- footer ends -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('frontend/js/common.js') }}"></script>
<script src="{{ asset('frontend/js/pages.js') }}"></script>

<script>
/* ═══════════════════════════════════════
   SINGLE PRODUCT PAGE JS
═══════════════════════════════════════ */
const PD_MAX_STOCK  = {{ $item->stock ?? 1 }};
const PD_PRODUCT_ID = {{ $item->id ?? 0 }};
const PD_TYPE       = '{{ $type }}';

function changeQty(delta) {
    const el  = document.getElementById('qtyNum');
    let qty   = parseInt(el.textContent) + delta;
    qty       = Math.max(1, Math.min(PD_MAX_STOCK, qty));
    el.textContent = qty;

    const buyBtn = document.getElementById('pdBuyNowBtn');
    if (buyBtn) {
        buyBtn.href = '/checkout?type=' + PD_TYPE + '&id=' + PD_PRODUCT_ID + '&qty=' + qty;
    }
}

// ── Add to Cart (uses existing common.js cart logic via AJAX) ──
function pdAddToCart() {
    const qty = parseInt(document.getElementById('qtyNum').textContent) || 1;

    fetch('{{ route("cart.add") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({
            product_id:   PD_PRODUCT_ID,
            product_type: PD_TYPE,
            qty:          qty,
        }),
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            // Update cart badge
            const badge = document.getElementById('cartCount');
            if (badge && data.cart_count !== undefined) {
                badge.textContent = data.cart_count;
            }
            // Show toast
            const toast = document.getElementById('toast');
            if (toast) {
                toast.textContent = '✅ Added to cart!';
                toast.classList.add('show');
                setTimeout(() => toast.classList.remove('show'), 2500);
            }
        }
    })
    .catch(() => {
        const toast = document.getElementById('toast');
        if (toast) {
            toast.textContent = '⚠️ Please login first.';
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 2500);
        }
    });
}

// ── Thumbnail switcher ──
function switchMain(thumb, src) {
    document.getElementById('mainImg').src = src;
    document.querySelectorAll('.pd-thumb').forEach(t => t.classList.remove('active'));
    thumb.classList.add('active');
}

// ── Tab switcher ──
function switchTab(id, btn) {
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + id).classList.add('active');
    btn.classList.add('active');
}
</script>

</body>
</html>