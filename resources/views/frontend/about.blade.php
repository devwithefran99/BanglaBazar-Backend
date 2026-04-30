<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>about | BanglaBazar</title>
<!-- shop link part starts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <!-- Owl Carousel -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

 <link rel="stylesheet" href="{{ asset ('frontend/css/common.css')}}">
  <link rel="stylesheet" href="{{ asset ('frontend/css/about.css')}}">
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

 <!-- Breadcrumbs Part starts -->
<section id="shopBanner">
    <div class="shopBnr">
        
    </div>
</section>
 <!-- Breadcrumbs part ends -->

<!-- main part starts -->
<main>
<!-- trusted part -->
<section class="about-section">
  <div class="container">
    <div class="about-row-wrapper">
      <div class="row g-0 flex-column-reverse flex-md-row">
 
        <!-- Text (right on desktop, top on mobile) -->
        <div class="col-md-6 about-text-col">
          <p class="about-eyebrow">Our Story</p>
          <h2 class="about-title">100% Trusted<br/><span>Organic</span> Food Store</h2>
          <p class="about-body">
            Morbi porttitor ligula in nunc varius sagittis. Proin dui nisi, laoreet ut tempor ac, cursus vitae eros. Cras quis ultricies elit. Proin ac lectus arcu. Maecenas aliquet vel tellus at accumsan. Donec a eros non massa vulputate ornare. Vivamus ornare commodo ante, at commodo felis congue vitae.
          </p>
          <a href="{{ route('contact') }}" class="about-cta">Learn More</a>
        </div>

         <!-- Image (left on desktop, bottom on mobile) -->
        <div class="col-md-6 about-img-col">
 
          <!-- ✅ Replace these 3 src values with your own images -->
          <img class="slide-img active" src="https://images.unsplash.com/photo-1540420773420-3366772f4999?w=900&q=80" alt="Fresh vegetables from the farm"/>
          <img class="slide-img"        src="{{asset('frontend/image/trusted1.png')}}" alt="Organic farmer in the field"/>
          <img class="slide-img"        src="https://images.unsplash.com/photo-1506484381205-f7945653044d?w=900&q=80" alt="Healthy organic produce"/>
 
          <div class="slide-dots">
            <div class="dot active" onclick="goTo(0)"></div>
            <div class="dot"        onclick="goTo(1)"></div>
            <div class="dot"        onclick="goTo(2)"></div>
          </div>
        </div>
 
      </div>
    </div>
  </div>
</section>
<!-- end of trusted Part -->

 <!-- shop now -->
   <section id="shopNow">
    <div class="container">
      <!-- CTA -->
    <div class="cta-row">
      <div class="cta-text">
        <h3>Ready to Eat Fresher, Live Healthier?</h3>
        <p>Join 25,000+ families who switched to organic. First box ships free.</p>
      </div>
      <div class="cta-btns">
        <a href="{{ route('shop') }}" class="btn-primary-g">
          Shop Now
          <svg viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
        <a href="{{ route('contact') }}" class="btn-outline-g">
         Contact Us
          <svg viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
      </div>
    </div>
    </div>
   </section>
  <!-- end shoop now -->

<!-- about content starts -->
<section class="about-section">
  <div class="container">
    <div class="row align-items-center g-5">
     <!-- Image Column -->
      <div class="col-lg-6">
        <div class="about-img-wrap">
          <!--  👇 Replace src with your actual image path  -->
          <img src="{{asset('frontend/image/about1.png')}}" alt="Farmer with fresh organic vegetables" />
          <span class="img-badge">100% Organic &amp; Natural</span>
        </div>
      </div>
 
     
      <!-- Content Column -->
      <div class="col-lg-6">
        <div class="about-content">
 
          <span class="section-tag">about</span>
 
          <h2 class="about-title">
            We Delivered, You <br>
            <span>Enjoy Your Order.</span>
          </h2>
 
          <p class="about-desc">
            Pellentesque a ante vulputate leo porttitor luctus sed eget eros. Nulla et rhoncus neque. Duis non diam eget est luctus tincidunt a a mi. Nulla eu eros consequat tortor tincidunt feugiat.
          </p>
 
          <!-- Features grid -->
          <div class="features-grid">
 
            <!-- 1 -->
            <div class="feature-card">
              <div class="feature-icon">
                <img src="{{asset('frontend/gif/organic.gif')}}" alt="">
              </div>
              <div class="feature-text">
                <h6>100% Organic Food</h6>
                <p>100% healthy &amp; fresh food.</p>
              </div>
            </div>
 
            <!-- 2 -->
            <div class="feature-card">
              <div class="feature-icon">
                <img src="{{asset('frontend/gif/support.gif')}}" alt="">
              </div>
              <div class="feature-text">
                <h6>Great Support 24/7</h6>
                <p>Instant access to contact.</p>
              </div>
            </div>
 
            <!-- 3 -->
            <div class="feature-card">
              <div class="feature-icon">
                <img src="{{asset('frontend/gif/rating.gif')}}" alt="">
              </div>
              <div class="feature-text">
                <h6>Customer Feedback</h6>
                <p>Our happy customers.</p>
              </div>
            </div>
 
            <!-- 4 -->
            <div class="feature-card">
              <div class="feature-icon">
                <img src="{{asset('frontend/gif/credit-card.gif')}}" alt="">
              </div>
              <div class="feature-text">
                <h6>100% Secure Payment</h6>
                <p>We ensure your money is safe.</p>
              </div>
            </div>
 
            <!-- 5 -->
            <div class="feature-card">
              <div class="feature-icon">
               <img src="{{asset('frontend/gif/transport.gif')}}" alt="">
              </div>
              <div class="feature-text">
                <h6>Free Shipping</h6>
                <p>Free shipping with discount.</p>
              </div>
            </div>
 
            <!-- 6 -->
            <div class="feature-card">
              <div class="feature-icon">
               <img src="{{asset('frontend/gif/best-price.gif')}}" alt="">
              </div>
              <div class="feature-text">
                <h6>Best Deal</h6>
                <p>100% healthy &amp; fresh food.</p>
              </div>
            </div>
 
          </div><!-- /features-grid -->
 
          <a href="{{ route('contact') }}" class="btn-about">
            Discover More
            <svg viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
 
        </div>
      </div>

    </div>
  </div>
</section>
<!-- about contant ends -->

<!-- why choose us part -->
<section class="wcu-section">
  <div class="blob blob-1"></div>
  <div class="blob blob-2"></div>
 
  <div class="container position-relative">
 
    <!-- Header -->
    <div class="text-center mb-2">
      <span class="wcu-tag">Why Choose Us</span>
      <h2 class="wcu-title mx-auto" style="max-width:620px">
        Nature's Best, Delivered<br>
        <span>Fresh To Your Door</span>
      </h2>
      <p class="wcu-sub mx-auto">
        We source directly from certified organic farms — no middlemen, no chemicals, just pure goodness picked at peak freshness and delivered within 24 hours.
      </p>
    </div>
 
    <!-- Stats -->
    <div class="stats-row">
 
      <div class="stat-card">
        <div class="stat-icon">
          <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
        </div>
        <div class="stat-num"><span class="counter" data-target="25000">0</span><span class="plus">+</span></div>
        <div class="stat-label">Happy Customers</div>
      </div>
 
      <div class="stat-card">
        <div class="stat-icon">
          <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        </div>
        <div class="stat-num"><span class="counter" data-target="150">0</span><span class="plus">+</span></div>
        <div class="stat-label">Partner Farms</div>
      </div>
 
      <div class="stat-card">
        <div class="stat-icon">
          <svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
        </div>
        <div class="stat-num"><span class="counter" data-target="98">0</span><span class="plus">%</span></div>
        <div class="stat-label">On-Time Delivery</div>
      </div>
 
      <div class="stat-card">
        <div class="stat-icon">
          <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        </div>
        <div class="stat-num"><span class="counter" data-target="100">0</span><span class="plus">%</span></div>
        <div class="stat-label">Certified Organic</div>
      </div>
 
    </div>
 
    <!-- Feature Cards -->
    <div class="features-row">
 
      <div class="feat-card">
        <div class="feat-num">01</div>
        <div class="feat-icon-wrap">
          <svg viewBox="0 0 24 24"><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 5.477 10 10-4.477 10-10 10z"/><path d="M8 12l3 3 5-5"/></svg>
        </div>
        <div class="feat-title">Farm-to-Table Freshness</div>
        <div class="feat-desc">Directly sourced from our certified organic partner farms. Every product arrives within 24 hours of harvest — no cold storage, no preservatives.</div>
      </div>
 
      <div class="feat-card">
        <div class="feat-num">02</div>
        <div class="feat-icon-wrap">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
        </div>
        <div class="feat-title">Same-Day Delivery</div>
        <div class="feat-desc">Order before 12PM and get your fresh organic produce delivered same day. Real-time tracking lets you know exactly when to expect your order.</div>
      </div>
 
      <div class="feat-card">
        <div class="feat-num">03</div>
        <div class="feat-icon-wrap">
          <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
        </div>
        <div class="feat-title">Eco Packaging</div>
        <div class="feat-desc">100% biodegradable packaging made from recycled materials. Our carbon-neutral delivery network means your order helps, not harms, the planet.</div>
      </div>
 
    </div>
  </div>
</section>
<!-- end of why choose us -->

<!-- our team part -->
<section class="team-section">
  <div class="container">
 
    <!-- Header -->
    <div class="text-center mb-2">
      <span class="team-tag">Meet The People</span>
      <h2 class="team-title">Our Awesome <span>Team</span></h2>
      <p class="team-desc">
        Pellentesque a ante vulputate leo porttitor luctus sed eget eros. Nulla et rhoncus neque. Duis non diam eget est luctus tincidunt a a mi.
      </p>
    </div>
 
    <!-- Carousel -->
    <div class="team-carousel-wrap">
      <div class="owl-carousel owl-theme" id="teamCarousel">
 
        <!-- Card 1 -->
        <div class="team-card">
          <div class="team-img-box">
            <img src="https://images.unsplash.com/photo-1607990281513-2c110a25bd8c?w=500&q=80" alt="Marcus Holloway"/>
            <div class="team-social">
              <a href="#" aria-label="Facebook">
                <svg viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
              </a>
              <a href="#" aria-label="Twitter/X">
                <svg viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53A4.48 4.48 0 0012 8v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg>
              </a>
              <a href="#" aria-label="Instagram">
                <svg viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
              </a>
              <a href="#" aria-label="LinkedIn">
                <svg viewBox="0 0 24 24"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
              </a>
            </div>
          </div>
          <div class="team-info">
            <div class="team-name">Marcus Holloway</div>
            <div class="team-role">CEO Founder</div>
          </div>
        </div>
 
        <!-- Card 2 -->
        <div class="team-card">
          <div class="team-img-box">
            <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=500&q=80" alt="Priya Nair"/>
            <div class="team-social">
              <a href="#" aria-label="Facebook">
                <svg viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
              </a>
              <a href="#" aria-label="Twitter/X">
                <svg viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53A4.48 4.48 0 0012 8v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg>
              </a>
              <a href="#" aria-label="Instagram">
                <svg viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
              </a>
              <a href="#" aria-label="LinkedIn">
                <svg viewBox="0 0 24 24"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
              </a>
            </div>
          </div>
          <div class="team-info">
            <div class="team-name">Priya Nair</div>
            <div class="team-role">Head of Operations</div>
          </div>
        </div>
 
        <!-- Card 3 -->
        <div class="team-card">
          <div class="team-img-box">
            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=500&q=80" alt="Daniel Osei"/>
            <div class="team-social">
              <a href="#" aria-label="Facebook">
                <svg viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
              </a>
              <a href="#" aria-label="Twitter/X">
                <svg viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53A4.48 4.48 0 0012 8v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg>
              </a>
              <a href="#" aria-label="Instagram">
                <svg viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
              </a>
              <a href="#" aria-label="LinkedIn">
                <svg viewBox="0 0 24 24"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
              </a>
            </div>
          </div>
          <div class="team-info">
            <div class="team-name">Daniel Osei</div>
            <div class="team-role">Senior  Manager</div>
          </div>
        </div>
 
        <!-- Card 4 -->
        <div class="team-card">
          <div class="team-img-box">
            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=500&q=80" alt="Layla Benali"/>
            <div class="team-social">
              <a href="#" aria-label="Facebook">
                <svg viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
              </a>
              <a href="#" aria-label="Twitter/X">
                <svg viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53A4.48 4.48 0 0012 8v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg>
              </a>
              <a href="#" aria-label="Instagram">
                <svg viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
              </a>
              <a href="#" aria-label="LinkedIn">
                <svg viewBox="0 0 24 24"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
              </a>
            </div>
          </div>
          <div class="team-info">
            <div class="team-name">Layla Benali</div>
            <div class="team-role">Quality  Lead</div>
          </div>
        </div>
 
        <!-- Card 5 -->
        <div class="team-card">
          <div class="team-img-box">
            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=500&q=80" alt="Ethan Caldwell"/>
            <div class="team-social">
              <a href="#" aria-label="Facebook">
                <svg viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
              </a>
              <a href="#" aria-label="Twitter/X">
                <svg viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53A4.48 4.48 0 0012 8v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg>
              </a>
              <a href="#" aria-label="Instagram">
                <svg viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
              </a>
              <a href="#" aria-label="LinkedIn">
                <svg viewBox="0 0 24 24"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
              </a>
            </div>
          </div>
          <div class="team-info">
            <div class="team-name">Ethan Caldwell</div>
            <div class="team-role">Logistics Head</div>
          </div>
        </div>
 
        <!-- Card 6 -->
        <div class="team-card">
          <div class="team-img-box">
            <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?w=500&q=80" alt="Sofia Marchetti"/>
            <div class="team-social">
              <a href="#" aria-label="Facebook">
                <svg viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
              </a>
              <a href="#" aria-label="Twitter/X">
                <svg viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53A4.48 4.48 0 0012 8v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg>
              </a>
              <a href="#" aria-label="Instagram">
                <svg viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
              </a>
              <a href="#" aria-label="LinkedIn">
                <svg viewBox="0 0 24 24"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
              </a>
            </div>
          </div>
          <div class="team-info">
            <div class="team-name">Sofia Marchetti</div>
            <div class="team-role">Marketing Director</div>
          </div>
        </div>
 
      </div>
    </div>
 
  </div>
</section>
<!-- our team ends -->
<!-- client feedback starts -->
<section id="feedback" class="py-2">
<div class="container">

<h2 class="section-title text-start">Client Testimonials</h2>

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
<img src="{{asset('frontend/image/clients (1).png')}}" class="client-img">

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

<img src="{{asset('frontend/image/clients (2).png')}}" class="client-img">

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

<img src="{{asset('frontend/image/clients (3).png')}}" class="client-img">

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

<img src="{{asset('frontend/image/bigApple.png')}}" class="client-img">

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
 
</footer>

    <!-- footer part ends -->

  
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/mixitup@3/dist/mixitup.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset ('frontend/js/common.js') }}"></script>
<script src="{{ asset ('frontend/js/about.js') }}"></script>
</body>
</html>