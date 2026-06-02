<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="wishlist-url" content="{{ route('wishlist.toggle') }}">

  {{-- SEO Meta Tags --}}
  <title>@yield('title', 'BanglaBazar') | BanglaBazar24/7</title>
  <meta name="description" content="@yield('meta_description', 'BanglaBazar - Bangladesh এর trusted online grocery store। Fresh vegetables, fish, meat and more delivered to your door.')">
  <meta name="keywords" content="@yield('meta_keywords', 'online grocery bangladesh, fresh vegetables, bangla bazar, online shop chittagong')">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="{{ url()->current() }}">

  {{-- Open Graph (Facebook / WhatsApp share) --}}
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="BanglaBazar24/7">
  <meta property="og:title" content="@yield('og_title', 'BanglaBazar24/7 — Online Grocery Store')">
  <meta property="og:description" content="@yield('og_description', 'Fresh groceries delivered to your door across Bangladesh.')">
  <meta property="og:image" content="@yield('og_image', asset('frontend/image/ourlogo.png'))">
  <meta property="og:url" content="{{ url()->current() }}">

  <link rel="icon" type="image/png" href="{{ asset('frontend/image/favIcon.png') }}">

  {{-- CSS --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
  <link rel="stylesheet" href="{{ asset('frontend/css/common.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
  @stack('styles')
</head>
<body>

{{-- PRELOADER --}}
<div id="preloader">
  <div class="loader">
    <img src="{{ asset('frontend/image/favIcon.png') }}" width="80px" alt="logo">
    <p class="mt-5">Loading...</p>
  </div>
</div>

{{-- HEADER --}}
<header>
<section id="navigation">

  {{-- TOP BAR --}}
  <div class="topbar d-none d-md-block">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <i class="bi bi-geo-alt-fill text-success me-1"></i>
          Store Location: 4th Floor, Kazi Complex, Beparipara, Agrabad Access Road, Chattogram
        </div>
        <div class="d-flex align-items-center gap-2">
         
          @auth
            <a href="{{ route('userdashboard') }}"><i class="bi bi-person me-1"></i>{{ Auth::user()->name }}</a>

             <span class="sep">|</span>
             
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
              @csrf
              <button type="submit" class="btn btn-sm btn-link p-0 text-decoration-none logoutBtn">
                <i class="bi bi-box-arrow-right me-1"></i>Logout
              </button>
            </form>
          @else
            <a href="{{ route('signin') }}"><i class="bi bi-person me-1"></i>Sign In /</a>
            <a href="{{ route('register') }}"><i class="bi bi-person me-1"></i>Sign Up</a>
          @endauth
        </div>
      </div>
    </div>
  </div>

  {{-- MIDDLE BAR --}}
  <div class="middlebar d-flex align-items-center justify-content-between">
    <div class="container">
      <div class="d-flex align-items-center justify-content-between gap-3">
        <a href="{{ route('home') }}" class="logo-slot">
          <img src="{{ asset('frontend/image/ourlogo.png') }}" width="120px" alt="BanglaBazar Logo">
        </a>
        <div class="d-lg-none ms-auto">
          <button class="navbar-toggler-custom" type="button"
                  data-bs-toggle="offcanvas" data-bs-target="#mobileNav">
            <i class="bi bi-list"></i>
          </button>
        </div>
        <div class="search-wrap flex-grow-1 mx-3" id="searchWrap">
          <input type="text" id="searchInput" placeholder="Search for products..." autocomplete="off"/>
          <button><i class="bi bi-search me-1"></i>Search</button>
          <div id="searchDropdown" class="search-dropdown d-none"></div>
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
            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
              <i class="bi bi-house-door-fill me-1"></i> Home
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('shop') ? 'active' : '' }}" href="{{ route('shop') }}">
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
            <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
              <i class="bi bi-info-circle me-1"></i> About Us
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">
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

  {{-- MOBILE OFFCANVAS --}}
  <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileNav">
    <div class="offcanvas-header">
      <img src="{{ asset('frontend/image/ourlogo.png') }}" width="120px" alt="BanglaBazar">
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
        </a>
        <a class="nav-link" href="{{ route('shop') }}">
          <span><i class="bi bi-shop me-2 text-success"></i>Shop</span>
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

{{-- PAGE CONTENT --}}
@yield('content')

{{-- FOOTER --}}
<footer class="main-footer">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-3 col-md-6 anim-fade-up d1">
        <img src="{{ asset('frontend/image/ourlogo.png') }}" width="140px" alt="BanglaBazar Logo">
        <p class="footer-desc">
          সুস্থ জীবনযাপনের জন্য বিশুদ্ধ ও প্রাকৃতিক পণ্যের কোনো বিকল্প নেই। তাই আমরা প্রতিটি পণ্য যত্নসহকারে নির্বাচন করে আপনার দোরগোড়ায় পৌঁছে দেওয়ার অঙ্গীকার করি।
        </p>
        <div class="footer-contact d-flex align-items-center flex-wrap">
          <a href="tel:01616239896">01616-239896</a>
          <a href="mailto:banglabazar247bd@gmail.com">banglabazar247bd@gmail.com</a>
        </div>
      </div>
      <div class="col-lg-2 col-md-3 col-6 anim-fade-up d2">
        <h6 class="footer-col-title">My Account</h6>
        <ul class="footer-links">
          <li><a href="{{ route('userdashboard') }}">My Account</a></li>
          <li><a href="{{ route('userdashboard') }}">Order History</a></li>
          <li><a href="{{ route('cart.index') }}">Shopping Cart</a></li>
          <li><a href="{{ route('wishlist') }}">Wishlist</a></li>
        </ul>
      </div>
      <div class="col-lg-2 col-md-3 col-6 anim-fade-up d3">
        <h6 class="footer-col-title">Help</h6>
        <ul class="footer-links">
          <li><a href="{{ route('contact') }}">Contact</a></li>
          <li><a href="{{ route('faq') }}">FAQs</a></li>
          <li><a href="{{ route('terms') }}">Terms &amp; Conditions</a></li>
          <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
        </ul>
      </div>
      <div class="col-lg-2 col-md-3 col-6 anim-fade-up d4">
        <h6 class="footer-col-title">Pages</h6>
        <ul class="footer-links">
          <li><a href="{{ route('about') }}">About Us</a></li>
          <li><a href="{{ route('shop') }}">Shop</a></li>
          <li><a href="{{ route('home') }}">Home</a></li>
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
          <p>BanglaBazar24/7 eCommerce &copy; {{ date('Y') }}. All Rights Reserved
            <span>Powered By <a href="https://github.com/devwithefran99">devwithErfan</a></span>
          </p>
        </div>
      </div>
    </div>
  </div>
</footer>

{{-- SCRIPTS --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
{{-- OwlCarousel আগে load করো --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('frontend/js/common.js') }}"></script>
@stack('scripts')

</body>
</html>