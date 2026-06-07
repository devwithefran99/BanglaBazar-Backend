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
 <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<link rel="stylesheet" href="{{ asset('frontend/css/common.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/pages.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
<title>BanglaBazar 24/7</title>
<link rel="icon" type="image/png" href="{{ asset('frontend/image/favIcon.png') }}">
</head>
<body>

<!-- preloader -->
<div id="preloader">
  <div class="loader">
    <img src="{{ asset('frontend/image/favIcon.png') }}"  width="80px" alt="logo">
    <p class="mt-5">Loading...</p>
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
          Store Location: 4th Floor,Kazi Complex,Beparipara,Agrabad Access Road,Chattogram
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
          <img src="{{ asset('frontend/image/ourlogo.png') }}"  width="120px" alt="logo">
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
              <li><a href="{{ route('checkout.show') }}">CheckOut</a></li>
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
          <i class="bi bi-telephone-fill"></i> +8801740604565
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
        <i class="bi bi-telephone-fill"></i> +8801740604565
      </div>
    </div>
  </div>

</section>
</header>

{{-- ════════════ 404 CONTENT ════════════ --}}
<section class="err-section">
  <div class="err-inner">
 
    {{-- Illustration --}}
    <div class="err-img-wrap">
      {{-- floating leaves --}}
      <div class="leaf leaf-1"></div>
      <div class="leaf leaf-2"></div>
      <div class="leaf leaf-3"></div>
      <div class="leaf leaf-4"></div>
      <div class="leaf leaf-5"></div>
      {{-- question bubble --}}
      <div class="q-bubble">?</div>
      {{-- main image --}}
      <img src="{{ asset('frontend/image/Info.png') }}" alt="404 Not Found">
    </div>
 
    {{-- Text --}}
    <h1 class="err-title">Oops! Page not found</h1>
    <p class="err-desc">
      The page you're looking for doesn't exist or has been moved.<br class="d-none d-sm-block">
      Let's get you back on track.
    </p>
 
    {{-- Main CTA --}}
    <a href="{{ route('home') }}" class="err-btn">
      <i class="bi bi-house-door-fill"></i> Back to Home
    </a>
 
    {{-- Quick Links --}}
    <div class="err-links">
      <a href="{{ route('shop') }}"        class="err-link-pill"><i class="bi bi-shop"></i> Shop</a>
      <a href="{{ route('contact') }}"     class="err-link-pill"><i class="bi bi-telephone"></i> Contact</a>
      <a href="{{ route('faq') }}"         class="err-link-pill"><i class="bi bi-question-circle"></i> FAQs</a>
      <a href="{{ route('wishlist') }}"    class="err-link-pill"><i class="bi bi-heart"></i> Wishlist</a>
      <a href="{{ route('userdashboard') }}" class="err-link-pill"><i class="bi bi-person"></i> My Account</a>
    </div>
 
  </div>
</section>



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
         <img src="{{ asset('frontend/image/ourlogo.png') }}"  width="140px" alt="logo">
        <p class="footer-desc">
          সুস্থ জীবনযাপনের জন্য বিশুদ্ধ ও প্রাকৃতিক পণ্যের কোনো বিকল্প নেই। তাই আমরা প্রতিটি পণ্য যত্নসহকারে নির্বাচন করে আপনার দোরগোড়ায় পৌঁছে দেওয়ার অঙ্গীকার করি।
        </p>
        <div class="footer-contact d-flex align-items-center flex-wrap">
          <a href="tel:01616239896">+8801740604565</a>
          
          <a href="mailto:banglabazar247bd@gmail.com">banglabazar247bd@gmail.com</a>
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
          <li><a href="{{ route('terms') }}">Terms &amp; Condition</a></li>
        <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
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
<script src="{{ asset('frontend/js/pages.js') }}"></script>

</body>
</html>
