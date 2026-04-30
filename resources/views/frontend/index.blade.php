<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="wishlist-url" content="{{ route('wishlist.toggle') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="wishlist-url" content="{{ route('wishlist.toggle') }}">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
<!-- Owl Carousel -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<link rel="stylesheet" href="navbar-active.css">
<link rel="stylesheet" href="{{ asset ('frontend/css/common.css')}}">
<link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
<link rel="stylesheet" href="{{ asset ('frontend/css/responsive.css')}}">
<title>BanglaBazar 24/7</title>

</head>
<body>

  <!-- preloader  -->
  <div id="preloader">
  <div class="loader">
    <img src="{{ asset ('frontend/image/Logo.png')}}" alt="logo">  
    <p>Loading...</p>   
  </div>
</div>

<!-- preloader ends -->
    
    <!-- header part starts here -->
 <header>
    <!-- nav bar starts -->
<section id="navigation">
        <!-- ════════════════════════════════════════
     TOP BAR
════════════════════════════════════════ -->
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
 
<!-- ════════════════════════════════════════
     MIDDLE BAR
════════════════════════════════════════ -->
<div class="middlebar d-flex align-items-center justify-content-between">
  <div class="container">
    <div class="d-flex align-items-center justify-content-between gap-3">
 
      <!-- Logo -->
      <a href="#" class="logo-slot">
        <img src="{{ asset ('frontend/image/Logo.png')}}" height="35" alt="logo">
        <!-- Replace above div with <img src="your-logo.png')}}" height="42"> -->
      </a>
      <div class="d-lg-none ms-auto">   <!-- এখানে ms-auto যোগ করো -->
        <button class="navbar-toggler-custom" type="button"
                data-bs-toggle="offcanvas" data-bs-target="#mobileNav">
            <i class="bi bi-list"></i>
        </button>
    </div>
 
      <!-- Search (lg+ only) -->
      <div class="search-wrap flex-grow-1 mx-3">
        <input type="text" placeholder="Search for products..."/>
        <button><i class="bi bi-search me-1"></i>Search</button>
      </div>
 
      <!-- Icons -->
     <div class="d-none d-lg-flex align-items-center gap-2">
        <a href="{{ route('wishlist') }}" class="icon-btn">
          <i class="bi bi-heart"></i>
           <span class="badge-dot" id="wishlistCount">
    {{ Auth::check() ? Auth::user()->wishlists()->count() : 0 }}
  </span>
        </a>
        <a href="#" class="icon-btn cart-btn ">
          <i class="bi bi-bag"></i>
           <span class="badge-dot" id="wishlistCount">
    {{ Auth::check() ? Auth::user()->wishlists()->count() : 0 }}
  </span>
        </a>
      </div>
    </div>
  </div>
</div>
 
<!-- ════════════════════════════════════════
     MAIN NAVBAR (desktop)
════════════════════════════════════════ -->
<nav class="main-navbar ">
  <div class="container">
    <div class="d-flex align-items-center justify-content-between">
 
      <!-- Desktop nav links -->
      <ul class="nav d-none d-lg-flex">
 
        <li class="nav-item">
          <a class="nav-link " href="{{ route('home') }}" >
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

        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('about') }}"><i class="bi bi-info-circle me-1"></i> About Us</a>
        </li>
 
        <li class="nav-item">
          <a class="nav-link" href="{{ route('contact') }}"><i class="bi bi-telephone me-1"></i> Contact Us</a>
        </li>
      </ul>
 
      <!-- Phone (desktop) -->
      <div class="nav-phone d-none d-lg-flex">
        <i class="bi bi-telephone-fill"></i>
        01616-239896
      </div>
 
      <!-- Hamburger (mobile/tablet) -->
      
 
    </div>
  </div>
</nav>
 
<!-- ════════════════════════════════════════
     OFFCANVAS (mobile sidebar)
════════════════════════════════════════ -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileNav">
  <div class="offcanvas-header">
    <img src="{{ asset ('frontend/image/Logo.png')}}" alt="">
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
 
    <!-- Mobile search -->
    <div class="p-3 border-bottom">
      <div class="d-flex">
        <input type="text" class="form-control" placeholder="Search products..."/>
        <button class="btn ms-2" style="background:var(--green);color:#fff;">
          <i class="bi bi-search"></i>
        </button>
      </div>
    </div>
 
    <nav class="d-flex flex-column">
 
      <!-- Home -->
      <a class="nav-link" href="{{ route('home') }}">
        <span><i class="bi bi-house-door-fill me-2 text-success"></i>Home</span>
        <i class="bi bi-chevron-down arrow"></i>
      </a>
 
      <!-- Shop -->
       
      <a class="nav-link"  href="{{ route('shop') }}">
        <span><i class="bi bi-shop me-2 text-success"></i>Shop</span>
        <i class="bi bi-chevron-down arrow"></i>
      </a>

 
      <!-- Pages -->
      <div class="mobile-menu-item">
  <a class="nav-link mobile-toggle" href="javascript:void(0)">
    <span>
      <i class="bi bi-file-earmark-text me-2 text-success"></i>Pages
    </span>
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
 
    <!-- Phone bottom -->
    <div class="offcanvas-phone">
      <i class="bi bi-telephone-fill"></i> 01616-239896
    </div>
 
  </div>
</div>
</section>
    <!-- nav bar ends  -->
 </header>
    <!-- header part ends here -->

    <!-- main part starts -->
     <main>
      <!-- hero section  -->
      <section id="heroBanner" class="py-2 mt-3">
  <div class="container-fluid container-md px-2 px-md-3">
    <div class="row g-2">

      <!-- MAIN SLIDER -->
      <div class="col-12 col-md-8">
        <div class="main-slider position-relative overflow-hidden rounded">
          <div class="slides position-relative w-100 h-100">

            <!-- Slide 1 -->
            <div class="slide active">
              <a href="{{ route('shop') }}"><img src="{{ asset ('frontend/image/Bannar Big.png')}} " class="w-100 " alt=""></a>
            </div>

            <!-- Slide 2 -->
            <div class="slide">
              <a href="{{ route('shop') }}"><img src="{{ asset ('frontend/image/Bannar.png')}} " class="w-100 " alt=""></a>
            </div>

            <!-- Slide 3 -->
            <div class="slide">
              <a href="{{ route('shop') }}"><img src="{{ asset ('frontend/image/Bannar (1).png')}} " class="w-100 " alt=""></a>
            </div>

          </div>

          <!-- Arrows -->
          <button class="slider-prev">&#10094;</button>
          <button class="slider-next">&#10095;</button>

        </div>
      </div>

      <!-- SIDE BANNERS -->
      <div class="col-12 col-md-4">
        <div class="row g-2 h-100">

          <div class="col-6 col-md-12">
           <a href="{{ route('shop') }}"> <img src="{{ asset('frontend/image/Bannar.png')}}" class="w-100 h-100 rounded object-fit-cover" alt=""></a>
          </div>

          <div class="col-6 col-md-12">
           <a href="{{ route('shop') }}"> <img src="{{ asset('frontend/image/Bannar (1).png')}}" class="w-100 h-100 rounded object-fit-cover" alt=""></a>
          </div>

        </div>
      </div>

    </div>

    <!-- FEATURES BAR -->
    <div class="bg-light border border-secondary-subtle rounded-3 mt-3 p-2">
      <div class="row text-center g-0">

        <div class="col-3 border-end border-secondary-subtle d-flex flex-column align-items-center justify-content-center py-2 px-1">
          <img src="{{ asset ('frontend/gif/wallet-security.gif')}}" alt="" class="mb-1" style="width: 36px; height: 36px; object-fit: contain;">
          <p class="mb-0 text-dark" style="font-size: 10px; line-height: 1.3;">Cash On<br>Delivery</p>
        </div>

        <div class="col-3 border-end border-secondary-subtle d-flex flex-column align-items-center justify-content-center py-2 px-1">
          <img src="{{ asset ('frontend/gif/truck.gif')}}" alt="" class="mb-1" style="width: 36px; height: 36px; object-fit: contain;">
          <p class="mb-0 text-dark" style="font-size: 10px; line-height: 1.3;">Fast<br>Delivery</p>
        </div>

        <div class="col-3 border-end border-secondary-subtle d-flex flex-column align-items-center justify-content-center py-2 px-1">
          <img src="{{ asset ('frontend/gif/helpdesk.gif')}}" alt="" class="mb-1" style="width: 36px; height: 36px; object-fit: contain;">
          <p class="mb-0 text-dark" style="font-size: 10px; line-height: 1.3;">Customer<br>Support</p>
        </div>

        <div class="col-3 d-flex flex-column align-items-center justify-content-center py-2 px-1">
          <img src="{{ asset ('frontend/gif/deal.gif')}}" alt="" class="mb-1" style="width: 36px; height: 36px; object-fit: contain;">
          <p class="mb-0 text-dark" style="font-size: 10px; line-height: 1.3;">Best<br>Deals</p>
        </div>

      </div>
    </div>

  </div>
</section>
      <!-- end of hero section -->

      <!-- categories part starts -->
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
  <div class="col-6 col-md-3 col-lg-2 cat-col">
      <div class="cat-card">
        <div class="img-box">
          <a href="{{ route('shop') }}"><img src="{{ asset ('frontend/image/image 1 (1).png')}}" alt="Fresh Fruit"></a>
        </div>
        <span class="cat-name">Fresh Fruit</span>
      </div>
    </div>

  <div class="col-6 col-md-3 col-lg-2 cat-col">
      <div class="cat-card">
        <div class="img-box">
          <a href="{{ route('shop') }}"><img src="{{ asset ('frontend/image/image 1 (2).png')}}" alt="Fresh Vegetables"></a>
        </div>
        <span class="cat-name">Fresh Vegetables</span>
      </div>
    </div>

  <div class="col-6 col-md-3 col-lg-2 cat-col">
      <div class="cat-card">
        <div class="img-box">
          <a href="{{ route('shop') }}"><img src="{{ asset ('frontend/image/image 1 (3).png')}}" alt="Fresh Vegetables"></a>
        </div>
        <span class="cat-name">Fresh Vegetables</span>
      </div>
    </div>

  <div class="col-6 col-md-3 col-lg-2 cat-col">
      <div class="cat-card">
        <div class="img-box">
          <a href="{{ route('shop') }}"><img src="{{ asset ('frontend/image/image 1 (4).png')}}" alt="Fresh Vegetables"></a>
        </div>
        <span class="cat-name">Fresh Vegetables</span>
      </div>
    </div>

  <div class="col-6 col-md-3 col-lg-2 cat-col">
      <div class="cat-card">
        <div class="img-box">
          <a href="{{ route('shop') }}"><img src="{{ asset ('frontend/image/image 1 (5).png')}}" alt="Fresh Vegetables"></a>
        </div>
        <span class="cat-name">Fresh Vegetables</span>
      </div>
    </div>

  <div class="col-6 col-md-3 col-lg-2 cat-col">
      <div class="cat-card">
        <div class="img-box">
         <a href="{{ route('shop') }}"> <img src="{{ asset ('frontend/image/image 1 (1).png')}}" alt="Fresh Vegetables"></a>
        </div>
        <span class="cat-name">Fresh Vegetables</span>
      </div>
    </div>

  <div class="col-6 col-md-3 col-lg-2 cat-col">
      <div class="cat-card">
        <div class="img-box">
         <a href="{{ route('shop') }}"> <img src="{{ asset ('frontend/image/image 1 (2).png')}}" alt="Fresh Vegetables"></a>
        </div>
        <span class="cat-name">Fresh Vegetables</span>
      </div>
    </div>

  <div class="col-6 col-md-3 col-lg-2 cat-col">
      <div class="cat-card">
        <div class="img-box">
         <a href="{{ route('shop') }}"> <img src="{{ asset ('frontend/image/image 1 (3).png')}}" alt="Fresh Vegetables"></a>
        </div>
        <span class="cat-name">Fresh Vegetables</span>
      </div>
    </div>

  <div class="col-6 col-md-3 col-lg-2 cat-col">
      <div class="cat-card">
        <div class="img-box">
         <a href="{{ route('shop') }}"> <img src="{{ asset ('frontend/image/image 1 (4).png')}}" alt="Fresh Vegetables"></a>
        </div>
        <span class="cat-name">Fresh Vegetables</span>
      </div>
    </div>

  <div class="col-6 col-md-3 col-lg-2 cat-col">
      <div class="cat-card">
        <div class="img-box">
         <a href="{{ route('shop') }}"> <img src="{{ asset ('frontend/image/image 1 (4).png')}}" alt="Fresh Vegetables"></a>
        </div>
        <span class="cat-name">Fresh Vegetables</span>
      </div>
    </div>

  <div class="col-6 col-md-3 col-lg-2 cat-col">
      <div class="cat-card">
        <div class="img-box">
         <a href="{{ route('shop') }}"> <img src="{{ asset ('frontend/image/image 1 (4).png')}}" alt="Fresh Vegetables"></a>
        </div>
        <span class="cat-name">Fresh Vegetables</span>
      </div>
    </div>

  <div class="col-6 col-md-3 col-lg-2 cat-col">
      <div class="cat-card">
        <div class="img-box">
          <a href="{{ route('shop') }}"><img src="{{ asset ('frontend/image/image 1 (2).png')}}" alt="Fresh Vegetables"></a>
        </div>
        <span class="cat-name">Fresh Vegetables</span>
      </div>
    </div>
  </div>
</div>
   </div>
       </section>
      <!-- categories part ends -->

  <!-- populer parts html -->
<section id="populer">
<div class="container px-3 py-4">
  <div class="section-header">
    <h2 style="font-size:30px; font-weight:700; margin:0;">
      Popular <span style="color: #22c55e;">Products</span>
    </h2>
    <a href="{{ route('shop') }}" class="view-all">View All <i class="bi bi-arrow-right"></i></a>
  </div>

  <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-3">

    @forelse($popularProducts as $product)
    <div class="col">
      <div class="product-card h-100">

        {{-- Sale badge --}}
        @if($product->hasSale())
          <div class="sale-badge">Sale {{ $product->salePercent() }}%</div>
        @endif

        <div class="product-img-wrap">
          <div class="img-overlay">
            <div class="overlay-icons">
             @php
  $inWishlist = Auth::check() 
    ? Auth::user()->wishlists->pluck('product_id')->contains($product->id)
    : false;
@endphp
<button 
  class="wishlist-btn"
  data-product-id="{{ $product->id }}"
  data-product-type="product"
  title="Wishlist">
  <i class="bi bi-heart{{ $inWishlist ? '-fill' : '' }}"
     style="{{ $inWishlist ? 'color:#e74c3c;' : '' }}"></i>
</button>
              <button title="Quick View"><i class="bi bi-eye"></i></button>
            </div>
          </div>
          {{-- Image --}}
          @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
          @else
            <img src="{{ asset('frontend/image/Product Image.png') }}" alt="{{ $product->name }}">
          @endif
        </div>

        <div class="card-body-custom">
          <div class="product-name">{{ $product->name }}</div>
          <div class="stars">
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star empty"></i>
          </div>
          <div class="price-row">
            <div>
              <span class="price-main">৳{{ number_format($product->price, 2) }}</span>
              @if($product->hasSale())
                <span class="price-old">৳{{ number_format($product->old_price, 2) }}</span>
              @endif
            </div>
            <a href="{{ route('product', $product->id) }}" class="cart-btn">
              <i class="bi bi-bag"></i>
            </a>
          </div>
        </div>

      </div>
    </div>
    @empty
      <div class="col-12 text-center py-5 text-muted">
        No featured products yet.
      </div>
    @endforelse

  </div>
</div>
</section>

  <!-- populer part ends -->

  <!-- discount banner starts -->
<section id="discountBanner">
  <div class="container">
    <div class="row">
      <div class="discountBnr">
  
      </div>  
    </div>
  </div>

</section>
  <!-- discount banner ends -->

  <!-- hot deals starts -->
<!-- hot deals starts -->
<section id="hotDeals">
  <div class="container" style="padding:24px 16px;">
    <!-- Header -->
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:18px;">
      <h2 style="font-size:30px; font-weight:700; margin-top:30px;">
        Hot <span style="color: #22c55e;">Deals</span>
      </h2>
      <a href="{{ route('shop') }}" style="color:#22c55e; font-size:14px; font-weight:500; text-decoration:none;">
        View All <i class="bi bi-arrow-right"></i>
      </a>
    </div>

    <div class="row g-3">

      {{-- ===== FEATURED BIG CARD (প্রথম deal) ===== --}}
      @if($hotDeals->isNotEmpty())
        @php $featured = $hotDeals->first(); @endphp
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
              <button class="add-to cart-btn">
                <i class="bi bi-bag"></i> Add to Cart
              </button>
              <button title="Quick View" class="icon-btn"><i class="bi bi-eye"></i></button>
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

        {{-- ===== RIGHT GRID: 2 থেকে 7 নম্বর deal (6টা small card) ===== --}}
        <div class="col-12 col-md-6 col-lg-8">
          <div class="row g-3">
            @foreach($hotDeals->skip(1)->take(6) as $deal)
            <div class="col-6 col-lg-4">
              <div class="hotProduct-card">
                @if($deal->hasSale())
                  <div class="sale-badge">Sale {{ $deal->salePercent() }}%</div>
                @endif
                <div class="product-img-wrap">
                  <div class="img-overlay">
                    <div class="overlay-icons">
                    <button 
  class="wishlist-btn"
  data-product-id="{{ $product->id }}"
  data-product-type="product"
  title="Wishlist">
  <i class="bi bi-heart{{ $inWishlist ? '-fill' : '' }}"
     style="{{ $inWishlist ? 'color:#e74c3c;' : '' }}"></i>
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
                    <div>
                      <span class="price-main">৳{{ number_format($deal->price, 2) }}</span>
                      @if($deal->hasSale())
                        <span class="price-old">৳{{ number_format($deal->old_price, 2) }}</span>
                      @endif
                    </div>
                    <button class="cart-btn"><i class="bi bi-bag"></i></button>
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

        {{-- ===== BOTTOM ROW: 8 থেকে 12 নম্বর deal (5টা) ===== --}}
        @foreach($hotDeals->skip(7)->take(5) as $index => $deal)
          <div class="bottom-col {{ $loop->last ? 'd-none d-lg-block' : '' }}">
            <div class="hotProduct-card">
              @if($deal->hasSale())
                <div class="sale-badge">Sale {{ $deal->salePercent() }}%</div>
              @endif
              <div class="product-img-wrap">
                <div class="img-overlay">
                  <div class="overlay-icons">
                   <button 
  class="wishlist-btn"
  data-product-id="{{ $product->id }}"
  data-product-type="product"
  title="Wishlist">
  <i class="bi bi-heart{{ $inWishlist ? '-fill' : '' }}"
     style="{{ $inWishlist ? 'color:#e74c3c;' : '' }}"></i>
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
                  <span class="price-main">৳{{ number_format($deal->price, 2) }}</span>
                  <button class="cart-btn"><i class="bi bi-bag"></i></button>
                </div>
              </div>
            </div>
          </div>
        @endforeach

      @else
        {{-- ===== কোনো deal না থাকলে static fallback ===== --}}
        <div class="col-12 col-md-6 col-lg-4">
          <div class="featured-card">
            <div class="sale-badge">Sale 50%</div>
            <div class="best-badge">Best Sale</div>
            <div class="featured-img-wrap">
              <img src="{{ asset('frontend/image/bigApple.png') }}" alt="Featured Product">
            </div>
            <div class="featured-action-row">
              <a href="{{ route('wishlist') }}" class="icon-btn"><i class="bi bi-heart"></i></a>
              <button class="add-to cart-btn"><i class="bi bi-bag"></i> Add to Cart</button>
              <button title="Quick View" class="icon-btn"><i class="bi bi-eye"></i></button>
            </div>
            <div class="featured-info">
              <div class="name">Chinese cabbage</div>
              <div class="prices">$12.00 <span class="old">$24.00</span></div>
              <div class="feedback">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                <i class="bi bi-star-half"></i>
                <span>(524 Feedback)</span>
              </div>
              <div class="hurry">Hurry up! Offer ends in:</div>
              <div class="countdown" data-ends="{{ (now()->addDays(1)->timestamp) * 1000 }}">
                <div class="cd-box"><span class="num cd-days">01</span><span class="lbl">Days</span></div>
                <span class="cd-sep">:</span>
                <div class="cd-box"><span class="num cd-hours">23</span><span class="lbl">Hours</span></div>
                <span class="cd-sep">:</span>
                <div class="cd-box"><span class="num cd-mins">34</span><span class="lbl">Mins</span></div>
                <span class="cd-sep">:</span>
                <div class="cd-box"><span class="num cd-secs">57</span><span class="lbl">Secs</span></div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-12 col-md-6 col-lg-8">
          <div class="row g-3">
            @foreach([
              'Product Image (1).png','Product Image (2).png','Product Image (4).png',
              'hotProduct1 (1).png','Product Image (3).png','hotProduct1 (3).png'
            ] as $img)
            <div class="col-6 col-lg-4">
              <div class="hotProduct-card">
                <div class="product-img-wrap">
                  <div class="img-overlay">
                    <div class="overlay-icons">
                     <button 
  class="wishlist-btn"
  data-product-id="{{ $product->id }}"
  data-product-type="product"
  title="Wishlist">
  <i class="bi bi-heart{{ $inWishlist ? '-fill' : '' }}"
     style="{{ $inWishlist ? 'color:#e74c3c;' : '' }}"></i>
</button>
                      <button title="Quick View"><i class="bi bi-eye"></i></button>
                    </div>
                  </div>
                  <img src="{{ asset('frontend/image/' . $img) }}" alt="Product">
                </div>
                <div class="card-body-custom">
                  <div class="product-name">Product Name</div>
                  <div class="stars">
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    <i class="bi bi-star empty"></i>
                  </div>
                  <div class="price-row">
                    <span class="price-main">$12.00</span>
                    <button class="cart-btn"><i class="bi bi-bag"></i></button>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>

        @foreach(['hotProduct1 (4).png','hotProduct1 (4).png','hotProduct1 (4).png','hotProduct1 (4).png'] as $i => $img)
        <div class="bottom-col">
          <div class="hotProduct-card">
            <div class="product-img-wrap">
              <div class="img-overlay">
                <div class="overlay-icons">
                 <button 
  class="wishlist-btn"
  data-product-id="{{ $product->id }}"
  data-product-type="product"
  title="Wishlist">
  <i class="bi bi-heart{{ $inWishlist ? '-fill' : '' }}"
     style="{{ $inWishlist ? 'color:#e74c3c;' : '' }}"></i>
</button>
                  <button title="Quick View"><i class="bi bi-eye"></i></button>
                </div>
              </div>
              <img src="{{ asset('frontend/image/' . $img) }}" alt="Product">
            </div>
            <div class="card-body-custom">
              <div class="product-name">Product Name</div>
              <div class="stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star empty"></i><i class="bi bi-star empty"></i>
              </div>
              <div class="price-row">
                <span class="price-main">$12.00</span>
                <button class="cart-btn"><i class="bi bi-bag"></i></button>
              </div>
            </div>
          </div>
        </div>
        @endforeach
        <div class="bottom-col d-none d-lg-block">
          <div class="hotProduct-card">
            <div class="product-img-wrap">
              <div class="img-overlay">
                <div class="overlay-icons">
                 <button 
  class="wishlist-btn"
  data-product-id="{{ $product->id }}"
  data-product-type="product"
  title="Wishlist">
  <i class="bi bi-heart{{ $inWishlist ? '-fill' : '' }}"
     style="{{ $inWishlist ? 'color:#e74c3c;' : '' }}"></i>
</button>
                  <button title="Quick View"><i class="bi bi-eye"></i></button>
                </div>
              </div>
              <img src="{{ asset('frontend/image/hotProduct1 (4).png') }}" alt="Product">
            </div>
            <div class="card-body-custom">
              <div class="product-name">Product Name</div>
              <div class="stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star empty"></i><i class="bi bi-star empty"></i>
              </div>
              <div class="price-row">
                <span class="price-main">$12.00</span>
                <button class="cart-btn"><i class="bi bi-bag"></i></button>
              </div>
            </div>
          </div>
        </div>
      @endif

    </div>
  </div>
</section>
<!-- hot deals ends -->

{{-- Countdown Timer Script --}}
@push('scripts')
<script>
document.querySelectorAll('.countdown[data-ends]').forEach(function(el) {
  const endTime = parseInt(el.dataset.ends);
  function tick() {
    const diff = endTime - Date.now();
    if (diff <= 0) {
      el.innerHTML = '<span style="color:#ef4444;font-size:12px;">Deal Ended</span>';
      return;
    }
    const days  = Math.floor(diff / 86400000);
    const hours = Math.floor((diff % 86400000) / 3600000);
    const mins  = Math.floor((diff % 3600000) / 60000);
    const secs  = Math.floor((diff % 60000) / 1000);
    el.querySelector('.cd-days').textContent  = String(days).padStart(2,'0');
    el.querySelector('.cd-hours').textContent = String(hours).padStart(2,'0');
    el.querySelector('.cd-mins').textContent  = String(mins).padStart(2,'0');
    el.querySelector('.cd-secs').textContent  = String(secs).padStart(2,'0');
  }
  tick();
  setInterval(tick, 1000);
});
</script>
@endpush
  <!-- hot deals ends -->

  <!-- feature product starts -->
<section id="featureProduct" class="new-trends-section">
  <div class="container">

    <div class="d-flex justify-content-between align-items-center">
      <h2 class="section-title text-dark">
        Feature <span style="color: #22c55e;">Product</span>
      </h2>
      <div class="d-flex gap-2">
        <button class="arrow-btn prev">&#8249;</button>
        <button class="arrow-btn next">&#8250;</button>
      </div>
    </div>

    <div class="slider-wrapper">
      <div class="slider-track">

        @forelse($featureProducts as $product)
        <div class="slider-product">

          {{-- Sale badge --}}
          @if($product->hasSale())
            <div class="sale-badge">
              ৳{{ number_format($product->old_price - $product->price, 0) }} OFF
            </div>
          @endif

          <div class="product-img-wrap">
            <div class="img-overlay">
              <div class="overlay-icons">
               <button 
  class="wishlist-btn"
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
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star empty"></i>
            </div>

            <div class="price-row">
              <div>
                <span class="price-main">৳{{ number_format($product->price, 2) }}</span>
                @if($product->hasSale())
                  <span class="price-old">৳{{ number_format($product->old_price, 2) }}</span>
                @endif
              </div>
              <a href="{{ route('product', $product->id) }}" class="cart-btn">
                <i class="bi bi-bag"></i>
              </a>
            </div>
          </div>

        </div>
        @empty
        {{-- Database এ product না থাকলে static fallback --}}
        @foreach(range(1,7) as $i)
        <div class="slider-product">
          <div class="sale-badge">৳40 OFF</div>
          <div class="product-img-wrap">
            <div class="img-overlay">
              <div class="overlay-icons">
               <button 
  class="wishlist-btn"
  data-product-id="{{ $product->id }}"
  data-product-type="product"
  title="Wishlist">
  <i class="bi bi-heart{{ $inWishlist ? '-fill' : '' }}"
     style="{{ $inWishlist ? 'color:#e74c3c;' : '' }}"></i>
</button>
                <button title="Quick View"><i class="bi bi-eye"></i></button>
              </div>
            </div>
            <img src="{{ asset('frontend/image/Product Image (1).png') }}">
          </div>
          <div class="card-body-custom">
            <div class="product-name">Product Name</div>
            <div class="stars">
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star empty"></i>
            </div>
            <div class="price-row">
              <div>
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
<!-- feature product ends -->

  <!-- client feedback starts -->
<section id="feedback" class="py-5">
<div class="container">

<h2 class="section-title text-start">Client <span style="color: #22c55e;">Testimonials</span></h2>

<div class="owl-carousel testimonial-slider">

<!-- CARD -->
<div class="testimonial-card">

<div class="quote">“</div>

<p class="testimonial-text">
Pellentesque eu nibh eget mauris congue mattis mattis nec tellus.
Phasellus imperdiet elit eu magna dictum.
</p>

<div class="client-info">

<div class="client-left">

<!-- CLIENT IMAGE -->
<img src="{{ asset ('frontend/image/clients (1).png')}}" class="client-img">

<div>
<p class="client-name">Robert Fox</p>
<p class="client-role">Customer</p>
</div>

</div>

<div class="stars">★★★★★</div>

</div>
</div>


<!-- CARD -->
<div class="testimonial-card">

<div class="quote">“</div>

<p class="testimonial-text">
Pellentesque eu nibh eget mauris congue mattis mattis nec tellus.
Phasellus imperdiet elit eu magna dictum.
</p>

<div class="client-info">

<div class="client-left">

<img src="{{ asset ('frontend/image/clients (2).png')}}" class="client-img">

<div>
<p class="client-name">Dianne Russell</p>
<p class="client-role">Customer</p>
</div>

</div>

<div class="stars">★★★★★</div>

</div>
</div>


<!-- CARD -->
<div class="testimonial-card">

<div class="quote">“</div>

<p class="testimonial-text">
Pellentesque eu nibh eget mauris congue mattis mattis nec tellus.
Phasellus imperdiet elit eu magna dictum.
</p>

<div class="client-info">

<div class="client-left">

<img src="{{ asset ('frontend/image/clients (3).png')}}" class="client-img">

<div>
<p class="client-name">Eleanor Pena</p>
<p class="client-role">Customer</p>
</div>

</div>

<div class="stars">★★★★★</div>

</div>
</div>


<!-- CARD -->
<div class="testimonial-card">

<div class="quote">“</div>

<p class="testimonial-text">
Pellentesque eu nibh eget mauris congue mattis mattis nec tellus.
Phasellus imperdiet elit eu magna dictum.
</p>

<div class="client-info">

<div class="client-left">

<img src="{{ asset ('frontend/image/bigApple.png')}}" class="client-img">

<div>
<p class="client-name">Jenny Wilson</p>
<p class="client-role">Customer</p>
</div>

</div>

<div class="stars">★★★★★</div>

</div>
</div>

</div>

</div>
</section>
  <!-- clients feedback ends -->
     </main>
    <!-- main part ends -->

    <!-- footrer part starts -->

<!-- add to cart popup -->
<section>
  <!-- Cart Overlay -->
<div class="cp-overlay" id="cpOverlay"></div>
 
<!-- Cart Drawer -->
<div class="cp-drawer" id="cpDrawer">
 
  <!-- Header -->
  <div class="cp-header">
    <div class="cp-title">
      
      <img src="{{ asset ('frontend/image/Logo.png')}}" alt="">
     
    </div>
    <button class="cp-close" id="cpClose" aria-label="Close cart">
      <i class="bi bi-x-lg"></i>
    </button>
  </div>
 
  <!-- Items -->
  <div class="cp-items" id="cpItems">
 
    <div class="cp-item" data-id="1">
      <div class="cp-item-img"><img src="{{ asset ('frontend/image/hotProduct1 (2).png')}}" alt=""></div>
      <div class="cp-item-info">
        <div class="cp-item-name">Fresh Indian Orange</div>
        <div class="cp-item-meta">1 kg × <strong>$12.00</strong></div>
      </div>
      <button class="cp-remove" onclick="cpRemoveItem(this)" aria-label="Remove">
        <i class="bi bi-x"></i>
      </button>
    </div>
 
    <div class="cp-item" data-id="2">
      <div class="cp-item-img"><img src="{{ asset ('frontend/image/hotProduct1 (1).png')}}" alt=""></div>
      <div class="cp-item-info">
        <div class="cp-item-name">Green Apple</div>
        <div class="cp-item-meta">1 kg × <strong>$14.00</strong></div>
      </div>
      <button class="cp-remove" onclick="cpRemoveItem(this)" aria-label="Remove">
        <i class="bi bi-x"></i>
      </button>
    </div>
 
  </div>
 
  <!-- Empty state (hidden by default) -->
  <div class="cp-empty" id="cpEmpty">
    <i class="bi bi-bag-x"></i>
    <p>Your cart is empty</p>
    <a href="{{ route('shop') }}" class="cp-shop-link">Browse Products →</a>
  </div>
 
  <!-- Footer -->
  <div class="cp-footer" id="cpFooter">
    <div class="cp-subtotal">
      <span class="cp-sub-label"><span id="cpProductCount">2</span> Product</span>
      <span class="cp-sub-price" id="cpTotal">$26.00</span>
    </div>
    <a href="checkout.html" class="cp-checkout-btn">
      <i class="bi bi-bag-check-fill me-1"></i> Checkout
    </a>
    <a href="#" class="cp-cart-link">Go To Cart</a>
  </div>
 
</div>
 
</section>
<!-- end add to cart popup -->
 
 
<!-- ═══════════════════════════════════════
     MAIN FOOTER
════════════════════════════════════════ -->
<footer class="main-footer">
  <div class="container">
    <div class="row g-4">
 
      <!-- Brand Column -->
      <div class="col-lg-3 col-md-6 anim-fade-up d1">
        <img src="{{ asset ('frontend/image/logoLight.png')}}" alt="">
 
        <p class="footer-desc">
          Morbi cursus porttitor enim lobortis molestie. Duis gravida turpis dui, eget bibendum magna congue nec.
        </p>
 
        <div class="footer-contact d-flex align-items-center flex-wrap">
          <a href="tel:2195550114">01616-239896</a>
          <span class="separator">or</span>
          <a href="mailto:Proxy@gmail.com">Proxy@gmail.com</a>
        </div>
      </div>
 
      <!-- My Account -->
      <div class="col-lg-2 col-md-3 col-6 anim-fade-up d2">
        <h6 class="footer-col-title">My Account</h6>
        <ul class="footer-links">
           <li><a href="{{ route('userdashboard') }}">My Account</a></li>
          <li><a href="{{ route('userdashboard') }}">Order History</a></li>
          <li><a href="#" class="active">Shoping Cart</a></li>
          <li><a href="{{ route('wishlist') }}">Wishlist</a></li>
        </ul>
      </div>
 
      <!-- Helps -->
      <div class="col-lg-2 col-md-3 col-6 anim-fade-up d3">
        <h6 class="footer-col-title">Helps</h6>
        <ul class="footer-links">
          <li><a href="{{ route('contact') }}">Contact</a></li>
           <li><a href="{{ route('faq') }}">FAQS</a></li>
          <li><a href="#">Terms &amp; Condition</a></li>
          <li><a href="#">Privacy Policy</a></li>
        </ul>
      </div>
 
      <!-- Proxy -->
      <div class="col-lg-2 col-md-3 col-6 anim-fade-up d4">
        <h6 class="footer-col-title">Proxy</h6>
        <ul class="footer-links">
          <li><a href="{{ route('about') }}">About</a></li>
          <li><a href="{{ route('shop') }}">Shop</a></li>
          <li><a href="{{ route('shop') }}">Product</a></li>
        </ul>
      </div>
 
      <!-- Categories -->
      <div class="col-lg-3 col-md-3 col-6 anim-fade-up d5">
        <h6 class="footer-col-title">Categories</h6>
        <ul class="footer-links">
          <li><a href="{{ route('shop') }}">Fruit &amp; Vegetables</a></li>
          <li><a href="{{ route('shop') }}">Meat &amp; Fish</a></li>
          <li><a href="{{ route('shop') }}">Bread &amp; Bakery</a></li>
          <li><a href="{{ route('shop') }}">Beauty &amp; Health</a></li>
        </ul>
      </div>
 
    </div><!-- /row -->
  </div><!-- /container -->
 
  <!-- ── Bottom Bar ── -->
  <div class="footer-bottom mt-4">
    <div class="container">
      <div class="row align-items-center anim-fade-in d6">
 
        <div class="col-12 mySign">
          <p>BanglaBazar24/7 eCommerce © 2026. All Rights Reserved <span>Powered By <a href="https://github.com/devwithefran99">devwithErfan</a></span></p>
        </div>
      </div>
    </div>
  </div>
 
  </section>
</footer>

    <!-- footer part ends -->

    <!-- eye pop up starts -->
<!-- Quick View Modal — body এর শেষে একবারই রাখো -->
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
    <!-- eye pop up ends -->


<!-- javascript link  -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="navbar-active.js"></script>
<script src="{{ asset ('frontend/js/common.js') }}"></script>
<script src="{{ asset ('frontend/js/wishlist.js') }}"></script>
<script src="{{ asset ('frontend/js/app.js') }}"></script >
  @stack('scripts')
    <!-- javascripts link ends -->
</body>
</html>