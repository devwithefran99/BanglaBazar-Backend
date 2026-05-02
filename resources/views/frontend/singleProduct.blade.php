<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="wishlist-url" content="{{ route('wishlist.toggle') }}">
    <title>about | BanglaBazar</title>
<!-- shop link part starts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <!-- Owl Carousel -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

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
 
 <!-- checkOut content starts -->
<section>
    <div class="container">
        <div class="pd-wrap">
  <div class="pd-gallery">
    <div class="pd-thumbs" id="thumbs">
      <div class="pd-thumb active"><img src="{{ asset('frontend/image/Product Image (1).png')}}" alt=""></div>
      <div class="pd-thumb"><img src="{{ asset('frontend/image/chechout (1).png')}}" alt=""></div>
      <div class="pd-thumb"><img src="{{ asset('frontend/image/chechout (2).png')}}" alt=""></div>
      <div class="pd-thumb"><img src="{{ asset('frontend/image/chechout (3).png')}}" alt=""></div>
    </div>
    <div class="pd-main-img-wrap">
      <img id="mainImg" src="{{ asset('frontend/image/Product Image (1).png')}}" alt="Chinese Cabbage">
    </div>
  </div>

  <div class="pd-info">
    <span class="pd-badge">In Stock</span>
    <h1 class="pd-title">Chinese Cabbage</h1>
    <div class="pd-rating">
      <div class="pd-stars">
        <svg class="pd-star" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
        <svg class="pd-star" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
        <svg class="pd-star" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
        <svg class="pd-star" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
        <svg class="pd-star" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
      </div>
      <span class="pd-reviews">4 Reviews</span>
      <span class="pd-sku">• SKU: 2,51,594</span>
    </div>
    <div class="pd-price-row">
      <span class="pd-price-old">$48.00</span>
      <span class="pd-price-now">$17.28</span>
      <span class="pd-discount">64% Off</span>
    </div>
    <div class="pd-divider"></div>
    <p class="pd-desc">Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nulla nibh diam, blandit vel consequat nec, ultrices et ipsum. Nulla varius magna a consequat pulvinar.</p>

    <div class="pd-qty-row">
      <span class="pd-qty-label">Quantity:</span>
      <div class="pd-qty">
        <button class="pd-qty-btn" id="minusBtn" onclick="changeQty(-1)">−</button>
        <span class="pd-qty-num" id="qtyNum">1</span>
        <button class="pd-qty-btn" onclick="changeQty(1)">+</button>
      </div>
    </div>

    <div class="pd-btns">
      <button class="pd-btn-cart cart-btn" onclick="addToCart()">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
        Add to Cart
      </button>
      <a href="checkOut.html" class="pd-btn-buy" >
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        Buy Now
      </a>
    </div>

    <div class="pd-pay-row">
      <span class="pd-pay-label">Pay via:</span>
      <span class="pd-pay-badge"><span class="pd-pay-dot"></span> Cash on Delivery</span>
      <span class="pd-pay-badge"><span class="pd-pay-dot bkash"></span> bKash</span>
    </div>
  </div>
</div>

<div class="pd-toast" id="toast"></div>

<div class="pd-modal-overlay" id="buyModal">
  <div class="pd-modal">
    <h3>Confirm Order</h3>
    <p id="modalMsg"></p>
    <div style="display:flex;gap:10px;margin-bottom:18px;flex-wrap:wrap">
      <label style="flex:1;min-width:120px;border:1.5px solid var(--border);border-radius:10px;padding:10px 12px;cursor:pointer;font-size:14px;display:flex;align-items:center;gap:8px">
        <input type="radio" name="pay" value="cod" checked style="accent-color:var(--green)">
        <span class="pd-pay-dot"></span> Cash on Delivery
      </label>
      <label style="flex:1;min-width:120px;border:1.5px solid var(--border);border-radius:10px;padding:10px 12px;cursor:pointer;font-size:14px;display:flex;align-items:center;gap:8px">
        <input type="radio" name="pay" value="bkash" style="accent-color:#e2136e">
        <span class="pd-pay-dot bkash"></span> bKash
      </label>
    </div>
    <div class="pd-modal-btns">
      <button class="pd-modal-btn pd-modal-cancel" onclick="closeModal()">Cancel</button>
      <button class="pd-modal-btn pd-modal-confirm" onclick="confirmOrder()">Confirm Order</button>
    </div>
  </div>
</div>

    </div>
</section>
 <!-- checkOut content ends -->
 <!-- product details starts -->
<section id="details" >
 <div class="container">
    <div class="tab-wrap">
  <nav class="tab-nav">
    <button class="tab-btn active" onclick="switchTab('desc',this)">Descriptions</button>
    <button class="tab-btn" onclick="switchTab('info',this)">Additional Information</button>
    <button class="tab-btn" onclick="switchTab('feedback',this)">Customer Feedback</button>
  </nav>

  <!-- DESCRIPTIONS -->
  <div class="tab-panel active" id="tab-desc">
    <div class="desc-grid">
      <div>
        <h2 class="desc-heading">Fresh Chinese Cabbage — Farm Direct</h2>
        <p class="desc-body">Our Chinese Cabbage is harvested fresh from certified organic farms. Crisp, tender leaves packed with essential vitamins and minerals. Ideal for stir-fries, soups, salads, and pickling.</p>
        <p class="desc-body">Each bunch is hand-selected for quality, carefully cleaned and cold-stored to preserve natural freshness from farm to your doorstep.</p>
        <ul class="desc-list">
          <li>100% organically grown, no harmful pesticides</li>
          <li>Rich in Vitamin C, K, and dietary fibre</li>
          <li>Harvested within 24 hours of delivery</li>
          <li>Ideal for Bangladeshi & Asian cuisines</li>
          <li>Supports local farmers & sustainable farming</li>
        </ul>
        <div class="desc-badges">
          <span class="desc-badge green">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            100% Organic
          </span>
          <span class="desc-badge gold">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
            Fresh Delivery
          </span>
          <span class="desc-badge green">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
            64% Discount
          </span>
        </div>
      </div>
      <div class="desc-img-card">
        <img src="https://images.unsplash.com/photo-1506484381205-f7945653044d?w=900&q=80" alt="Healthy organic produce">
      </div>
    </div>
  </div>

  <!-- ADDITIONAL INFORMATION -->
  <div class="tab-panel" id="tab-info">
    <table class="info-table">
      <tr><td>Weight</td><td>03 kg</td></tr>
      <tr><td>Color</td><td>Green</td></tr>
      <tr><td>Type</td><td>Organic</td></tr>
      <tr><td>Category</td><td><span class="info-chip green">Vegetables</span></td></tr>
      <tr>
        <td>Stock Status</td>
        <td><span class="info-stock">Available</span><span class="info-count">(5,413 units)</span></td>
      </tr>
      <tr>
        <td>Tags</td>
        <td>
          <span class="info-chip neutral">Vegetables</span>
          <span class="info-chip neutral">Healthy</span>
          <span class="info-chip green">Chinese</span>
          <span class="info-chip neutral">Cabbage</span>
          <span class="info-chip neutral">Green Cabbage</span>
        </td>
      </tr>
    </table>
  </div>

  <!-- CUSTOMER FEEDBACK -->
  <div class="tab-panel" id="tab-feedback">
    <div class="fb-summary">
      <div style="text-align:center">
        <div class="fb-big-score">4.8</div>
        <div style="display:flex;gap:3px;justify-content:center;margin:6px 0">
          <svg class="fb-star" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
          <svg class="fb-star" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
          <svg class="fb-star" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
          <svg class="fb-star" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
          <svg class="fb-star" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
        </div>
        <div class="fb-score-label">4 reviews</div>
      </div>
      <div class="fb-bars">
        <div class="fb-bar-row"><span class="fb-bar-label">5</span><div class="fb-bar-track"><div class="fb-bar-fill" style="width:75%"></div></div><span class="fb-bar-count">3</span></div>
        <div class="fb-bar-row"><span class="fb-bar-label">4</span><div class="fb-bar-track"><div class="fb-bar-fill" style="width:25%"></div></div><span class="fb-bar-count">1</span></div>
        <div class="fb-bar-row"><span class="fb-bar-label">3</span><div class="fb-bar-track"><div class="fb-bar-fill" style="width:0%"></div></div><span class="fb-bar-count">0</span></div>
        <div class="fb-bar-row"><span class="fb-bar-label">2</span><div class="fb-bar-track"><div class="fb-bar-fill" style="width:0%"></div></div><span class="fb-bar-count">0</span></div>
        <div class="fb-bar-row"><span class="fb-bar-label">1</span><div class="fb-bar-track"><div class="fb-bar-fill" style="width:0%"></div></div><span class="fb-bar-count">0</span></div>
      </div>
    </div>
    <div class="fb-cards">
      <div class="fb-card">
        <div class="fb-card-top">
          <div class="fb-avatar" style="background:#d4ede3;color:#007a3d">RK</div>
          <div><div class="fb-name">Rahim Khan</div><div class="fb-date">12 April 2025</div></div>
          <span class="fb-verified">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Verified
          </span>
        </div>
        <div class="fb-stars-row">
          <svg class="fb-star" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
          <svg class="fb-star" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
          <svg class="fb-star" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
          <svg class="fb-star" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
          <svg class="fb-star" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
        </div>
        <p class="fb-text">খুবই তাজা এবং সুন্দর ছিল। দ্রুত ডেলিভারি পেয়েছি। আবার অর্ডার করবো ইনশাআল্লাহ।</p>
      </div>
      <div class="fb-card">
        <div class="fb-card-top">
          <div class="fb-avatar" style="background:#fdf3e3;color:#c8922a">SA</div>
          <div><div class="fb-name">Sultana Akter</div><div class="fb-date">8 April 2025</div></div>
          <span class="fb-verified">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Verified
          </span>
        </div>
        <div class="fb-stars-row">
          <svg class="fb-star" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
          <svg class="fb-star" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
          <svg class="fb-star" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
          <svg class="fb-star" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
          <svg class="fb-star empty" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
        </div>
        <p class="fb-text">দাম অনুযায়ী মান অনেক ভালো। প্যাকেজিং পরিষ্কার ছিল। সামান্য আরও তাজা হলে পারফেক্ট হতো।</p>
      </div>
      <div class="fb-card">
        <div class="fb-card-top">
          <div class="fb-avatar" style="background:#e6f1fb;color:#185fa5">MH</div>
          <div><div class="fb-name">Mostofa Hasan</div><div class="fb-date">2 April 2025</div></div>
          <span class="fb-verified">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            Verified
          </span>
        </div>
        <div class="fb-stars-row">
          <svg class="fb-star" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
          <svg class="fb-star" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
          <svg class="fb-star" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
          <svg class="fb-star" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
          <svg class="fb-star" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
        </div>
        <p class="fb-text">Excellent product! Delivery was super fast and the cabbage was very fresh. Highly recommended for anyone who wants organic vegetables.</p>
      </div>
    </div>
  </div>
</div>
 </div>
</section>
 <!-- product details ends -->
<main>


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
 
</footer>

    <!-- footer part ends -->

  
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/mixitup@3/dist/mixitup.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset ('frontend/js/common.js') }}"></script>
<script src="{{ asset ('frontend/js/pages.js') }}"></script>
</body>
</html>