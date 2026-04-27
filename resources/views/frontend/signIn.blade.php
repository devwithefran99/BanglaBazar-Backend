<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop | BanglaBazar</title>
<!-- shop link part starts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset ('frontend/css/common.css')}}">
   <link rel="stylesheet" href="{{ asset ('frontend/css/pages.css')}}">
  <link rel="stylesheet" href="{{ asset ('frontend/css/responsive.css')}}">
<!-- shop link ends -->

</head>
<body>
<!-- preloader  -->

  <div id="preloader">
  <div class="loader">
    <img src="{{asset('frontend/image/Logo.png')}}" alt="Logo">  
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
        <img src="{{asset('frontend/image/Logo.png')}}" height="35" alt="logo">
       
      </a>
      <div class="d-lg-none ms-auto">   
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
          <span class="badge-dot">3</span>
        </a>
        <a href="#" class="icon-btn cart-btn ">
          <i class="bi bi-bag"></i>
          <span class="badge-dot">3</span>
        </a>
      </div>
 
    </div>
  </div>
</div>
 
<!-- ════════════════════════════════════════
     MAIN NAVBAR (desktop)
════════════════════════════════════════ -->
<nav class="main-navbar">
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
    <img src="{{asset('frontend/image/Logo.png')}}" alt="">
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
<!-- main content starts here -->
 <main>

 
<!-- main content end here -->
 <section>
    <div class="container">
        <div class="row justify-content-center ">
            <div class="card">
 
  <!-- Brand -->
  <div class="brand">
    <img src="{{asset('frontend/image/Logo.png')}}" alt="">
  </div>
 
  <!-- Heading -->
  <div class="heading">
    <h1>Sign In</h1>
    <p>Welcome back! Please enter your details.</p>
  </div>
 
  <!-- Email -->
  <div class="field" id="field-email">
    <label for="email">Email address</label>
    <div class="input-wrap">
      <svg class="icon" viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><polyline points="2,4 12,13 22,4"/></svg>
      <input type="email" id="email" placeholder="you@example.com" autocomplete="email">
    </div>
    <div class="error-msg" id="email-err">
      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      Please enter a valid email address.
    </div>
  </div>
 
  <!-- Password -->
  <div class="field" id="field-pw">
    <label for="password">Password</label>
    <div class="input-wrap">
      <svg class="icon" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
      <input type="password" id="password" placeholder="Enter your password" autocomplete="current-password">
      <button class="eye-btn" id="toggle-pw" type="button" aria-label="Toggle password visibility">
        <svg id="eye-icon" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
      </button>
    </div>
    <div class="error-msg" id="pw-err">
      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      Password must be at least 6 characters.
    </div>
  </div>
 
  <!-- Options Row -->
  <div class="options-row">
    <label class="checkbox-label">
      <input type="checkbox" id="remember">
      <span>Remember me</span>
    </label>
    <a href="#" class="forgot-link">Forget Password</a>
  </div>
 
  <!-- Login Button -->
  <button class="btn-login" id="login-btn">Login</button>
 
  <!-- Divider -->
  <div class="divider">
    <hr><span>or continue with</span><hr>
  </div>
 
  <!-- Social Buttons -->
  <div class="social-row">
    <button class="social-btn" id="google-btn">
      <svg viewBox="0 0 24 24" fill="none">
        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
        <path d="M5.84 14.1c-.22-.66-.35-1.36-.35-2.1s.13-1.44.35-2.1V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.83z" fill="#FBBC05"/>
        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.83C6.71 7.31 9.14 5.38 12 5.38z" fill="#EA4335"/>
      </svg>
      <span class="label">Google</span>
    </button>
    <button class="social-btn" id="fb-btn">
      <svg viewBox="0 0 24 24"><path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047V9.413c0-3.025 1.791-4.697 4.533-4.697 1.312 0 2.686.235 2.686.235v2.97h-1.513c-1.491 0-1.956.93-1.956 1.886v2.267h3.328l-.532 3.49h-2.796V24C19.612 23.094 24 18.1 24 12.073z" fill="#1877F2"/></svg>
      <span class="label">Facebook</span>
    </button>
    <button class="social-btn" id="apple-btn">
      <svg viewBox="0 0 24 24" fill="#1c1c1c"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/></svg>
      <span class="label">Apple</span>
    </button>
  </div>
 
  <!-- Register -->
  <p class="register-row">Don't have an account? <a href="#">Register</a></p>
 
</div>
 
<!-- Toast -->
<div class="toast" id="toast"></div>
        </div>
    </div>
 </section>

 </main>


 <!-- add to cart popup -->
<section>
  <!-- Cart Overlay -->
<div class="cp-overlay" id="cpOverlay"></div>
 
<!-- Cart Drawer -->
<div class="cp-drawer" id="cpDrawer">
 
  <!-- Header -->
  <div class="cp-header">
    <div class="cp-title">
      
      <img src="{{asset('frontend/image/Logo.png')}}" alt="">
     
    </div>
    <button class="cp-close" id="cpClose" aria-label="Close cart">
      <i class="bi bi-x-lg"></i>
    </button>
  </div>
 
  <!-- Items -->
  <div class="cp-items" id="cpItems">
 
    <div class="cp-item" data-id="1">
      <div class="cp-item-img"><img src="{{asset('frontend/image/hotProduct1 (2).png')}}" alt=""></div>
      <div class="cp-item-info">
        <div class="cp-item-name">Fresh Indian Orange</div>
        <div class="cp-item-meta">1 kg × <strong>$12.00</strong></div>
      </div>
      <button class="cp-remove" onclick="cpRemoveItem(this)" aria-label="Remove">
        <i class="bi bi-x"></i>
      </button>
    </div>
 
    <div class="cp-item" data-id="2">
      <div class="cp-item-img"><img src="{{asset('frontend/image/hotProduct1 (1).png')}}" alt=""></div>
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
 <!-- footrer part starts -->
<footer>
<!-- ═══════════════════════════════════════
     MAIN FOOTER
════════════════════════════════════════ -->
<footer class="main-footer">
  <div class="container">
    <div class="row g-4">
 
      <!-- Brand Column -->
      <div class="col-lg-3 col-md-6 anim-fade-up d1">
        <img src="{{asset('frontend/image/logoLight.png')}}" alt="">
 
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
          <li><a href="#">Product</a></li>
          
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
 
        <div class="col-md-6 mySign">
          <p>BanglaBazar24/7 eCommerce © 2026. All Rights Reserved <span>Powered By <a href="https://github.com/devwithefran99">devwithErfan</a></span></p>
        </div>
 
        
 
      </div>
    </div>
  </div>
 
  </section>
</footer>

    <!-- footer part ends -->

  
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/mixitup@3/dist/mixitup.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset ('frontend/js/common.js') }}"></script>
<script src="{{asset('frontend/js/signPages.js"></script>
</body>
</html>