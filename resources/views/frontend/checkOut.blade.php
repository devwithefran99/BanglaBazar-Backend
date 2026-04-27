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
    <img src="{{ asset('frontend/image/Logo.png')}}" alt="Logo">  
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
        <img src="{{ asset('frontend/image/Logo.png')}}" height="35" alt="logo">
       
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
    <img src="{{ asset('frontend/image/Logo.png')}}" alt="">
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
 <!-- main starts here -->
<main>
<section class="bl-section">
  <div class="container">

 
    <div class="bl-page-title bl-anim-1">Checkout</div>
    <div class="bl-page-sub bl-anim-1">Complete your order below</div>
 
    <div class="row g-4">
 
      <!-- ══ LEFT COL ══ -->
      <div class="col-12 col-lg-7 bill">
 
        <!-- Billing Information -->
        <div class="bl-card bl-anim-2">
          <div class="bl-card-title">
            <i class="bi bi-person-lines-fill"></i>
            Billing Information
          </div>
 
          <div class="row g-3">
            <div class="col-6">
              <div class="bl-form-group">
                <label class="bl-label">First name <span>*</span></label>
                <input type="text" class="bl-input" placeholder="Your first name">
              </div>
            </div>
            <div class="col-6">
              <div class="bl-form-group">
                <label class="bl-label">Last name <span>*</span></label>
                <input type="text" class="bl-input" placeholder="Your last name">
              </div>
            </div>
            <div class="col-12">
              <div class="bl-form-group">
                <label class="bl-label">Company Name <span style="color:var(--text-muted);font-weight:500">(optional)</span></label>
                <input type="text" class="bl-input" placeholder="Company name">
              </div>
            </div>
            <div class="col-12">
              <div class="bl-form-group">
                <label class="bl-label">Street Address <span>*</span></label>
                <input type="text" class="bl-input" placeholder="House number and street name">
              </div>
            </div>
            <div class="col-12 col-sm-4">
              <div class="bl-form-group">
                <label class="bl-label">Country / Region <span>*</span></label>
                <select class="bl-select">
                  <option value="">Select</option>
                  <option>Bangladesh</option>
                  <option>United States</option>
                  <option>United Kingdom</option>
                  <option>Canada</option>
                  <option>Australia</option>
                </select>
              </div>
            </div>
            <div class="col-12 col-sm-4">
              <div class="bl-form-group">
                <label class="bl-label">State <span>*</span></label>
                <select class="bl-select">
                  <option value="">Select</option>
                  <option>Chittagong</option>
                  <option>Dhaka</option>
                  <option>Illinois</option>
                  <option>California</option>
                </select>
              </div>
            </div>
            <div class="col-12 col-sm-4">
              <div class="bl-form-group">
                <label class="bl-label">Zip Code <span>*</span></label>
                <input type="text" class="bl-input" placeholder="Zip Code">
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <div class="bl-form-group">
                <label class="bl-label">Email <span>*</span></label>
                <input type="email" class="bl-input" placeholder="Email address">
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <div class="bl-form-group">
                <label class="bl-label">Phone <span>*</span></label>
                <input type="tel" class="bl-input" placeholder="Phone number">
              </div>
            </div>
            <div class="col-12">
              <div class="bl-check-row">
                <input type="checkbox" id="blShipDiff">
                <label for="blShipDiff">Ship to a different address</label>
              </div>
            </div>
          </div>
        </div>
 
        <!-- Additional Info -->
        <div class="bl-card bl-anim-3">
          <div class="bl-card-title">
            <i class="bi bi-chat-left-text"></i>
            Additional Info
          </div>
          <div class="bl-form-group">
            <label class="bl-label">Order Notes <span style="color:var(--text-muted);font-weight:500">(Optional)</span></label>
            <textarea class="bl-textarea" placeholder="Notes about your order, e.g. special notes for delivery"></textarea>
          </div>
        </div>
 
      </div><!-- /left col -->
 
      <!-- ══ RIGHT COL — Order Summary ══ -->
      <div class="col-12 col-lg-5">
        <div class="bl-summary-card bl-anim-4">
 
          <div class="bl-card-title" style="margin-bottom:1rem;">
            <i class="bi bi-bag-check"></i>
            Order Summary
          </div>
 
          <!-- Items -->
          <div class="bl-order-item">
            <div class="bl-item-img">🫑</div>
            <div class="bl-item-info">
              <div class="bl-item-name">Green Capsicum</div>
              <div class="bl-item-qty">x5</div>
            </div>
            <div class="bl-item-price">$70.00</div>
          </div>
          <div class="bl-order-item">
            <div class="bl-item-img">🍅</div>
            <div class="bl-item-info">
              <div class="bl-item-name">Red Capsicum</div>
              <div class="bl-item-qty">x1</div>
            </div>
            <div class="bl-item-price">$14.00</div>
          </div>
 
          <!-- Totals -->
          <div class="bl-totals">
            <div class="bl-total-row">
              <span class="label">Subtotal</span>
              <span class="val">$84.00</span>
            </div>
            <div class="bl-total-row">
              <span class="label">Shipping</span>
              <span class="val bl-free">Free</span>
            </div>
            <div class="bl-total-row grand">
              <span class="label">Total</span>
              <span class="val">$84.00</span>
            </div>
          </div>
 
          <!-- Payment Method -->
          <div class="bl-payment-title">Payment Method</div>
          <div class="bl-radio-group" id="blPayGroup">
            <label class="bl-radio-option selected">
              <input type="radio" name="payment" value="cod" checked>
              <span class="bl-radio-label">
                <i class="bi bi-truck"></i> Cash on Delivery
              </span>
            </label>
            <label class="bl-radio-option">
              <input type="radio" name="payment" value="paypal">
              <span class="bl-radio-label">
                <i class="bi bi-paypal"></i> PayPal
              </span>
            </label>
            <label class="bl-radio-option">
              <input type="radio" name="payment" value="amazon">
              <span class="bl-radio-label">
                <i class="bi bi-amazon"></i> Amazon Pay
              </span>
            </label>
          </div>
 
          <button class="bl-place-order" onclick="placeOrder()">
            <i class="bi bi-bag-check-fill"></i> Place Order
          </button>
          <div class="bl-secure-note">
            <i class="bi bi-shield-lock-fill"></i>
            100% Secure &amp; Encrypted Checkout
          </div>
 
        </div>
      </div><!-- /right col -->
 
    </div><!-- /row -->
  </div><!-- /container -->
</section>
</main>
 
<!-- main ends here  -->

<!-- add to cart popup -->
<section>
  <!-- Cart Overlay -->
<div class="cp-overlay" id="cpOverlay"></div>
 
<!-- Cart Drawer -->
<div class="cp-drawer" id="cpDrawer">
 
  <!-- Header -->
  <div class="cp-header">
    <div class="cp-title">
      
      <img src="{{ asset('frontend/image/Logo.png')}}" alt="">
     
    </div>
    <button class="cp-close" id="cpClose" aria-label="Close cart">
      <i class="bi bi-x-lg"></i>
    </button>
  </div>
 
  <!-- Items -->
  <div class="cp-items" id="cpItems">
 
    <div class="cp-item" data-id="1">
      <div class="cp-item-img"><img src="{{ asset('frontend/image/hotProduct1 (2).png')}}" alt=""></div>
      <div class="cp-item-info">
        <div class="cp-item-name">Fresh Indian Orange</div>
        <div class="cp-item-meta">1 kg × <strong>$12.00</strong></div>
      </div>
      <button class="cp-remove" onclick="cpRemoveItem(this)" aria-label="Remove">
        <i class="bi bi-x"></i>
      </button>
    </div>
 
    <div class="cp-item" data-id="2">
      <div class="cp-item-img"><img src="{{ asset('frontend/image/hotProduct1 (1).png')}}" alt=""></div>
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
        <img src="{{ asset('frontend/image/logoLight.png')}}" alt="">
 
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
<script src="{{ asset ('frontend/js/pages.js') }}"></script>
</body>
</html>