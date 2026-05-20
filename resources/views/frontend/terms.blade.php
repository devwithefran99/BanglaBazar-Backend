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


{{-- ════════ HERO ════════ --}}
<div class="tc-hero">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Terms &amp; Conditions</li>
      </ol>
    </nav>
    <h1>Terms &amp; <span>Conditions</span></h1>
    <p class="text-muted mb-0" style="font-size:.95rem;">
      Please read these terms carefully before using BanglaBazar's services.
    </p>
    <div class="tc-updated">
      <i class="bi bi-calendar2-check-fill"></i> Last updated: January 1, 2026
    </div>
  </div>
</div>
 
 
{{-- ════════ MAIN ════════ --}}
<section class="tc-wrap">
  <div class="container">
    <div class="row g-4">
 
      {{-- ── Table of Contents ── --}}
      <div class="col-lg-3 d-none d-lg-block">
        <div class="tc-toc">
          <p class="tc-toc-title">On this page</p>
          <a href="#tc-intro">       <i class="bi bi-chevron-right"></i> Overview</a>
          <a href="#tc-acceptance">  <i class="bi bi-chevron-right"></i> Acceptance of Terms</a>
          <a href="#tc-account">     <i class="bi bi-chevron-right"></i> User Accounts</a>
          <a href="#tc-orders">      <i class="bi bi-chevron-right"></i> Orders &amp; Payments</a>
          <a href="#tc-pricing">     <i class="bi bi-chevron-right"></i> Pricing &amp; Promotions</a>
          <a href="#tc-shipping">    <i class="bi bi-chevron-right"></i> Shipping &amp; Delivery</a>
          <a href="#tc-returns">     <i class="bi bi-chevron-right"></i> Returns &amp; Refunds</a>
          <a href="#tc-prohibited">  <i class="bi bi-chevron-right"></i> Prohibited Activities</a>
          <a href="#tc-ip">          <i class="bi bi-chevron-right"></i> Intellectual Property</a>
          <a href="#tc-liability">   <i class="bi bi-chevron-right"></i> Limitation of Liability</a>
          <a href="#tc-governing">   <i class="bi bi-chevron-right"></i> Governing Law</a>
          <a href="#tc-contact">     <i class="bi bi-chevron-right"></i> Contact Us</a>
        </div>
      </div>
 
      {{-- ── Content ── --}}
      <div class="col-lg-9">
 
        {{-- Intro --}}
        <div class="tc-intro" id="tc-intro">
          Welcome to <strong>BanglaBazar</strong>. These Terms &amp; Conditions ("Terms") govern your access to and use of
          our website, mobile app, and all related services. By creating an account, browsing our site, or placing an order,
          you confirm that you have read, understood, and agree to be bound by these Terms along with our
          <a href="{{ route('privacy') }}" style="color:var(--green,#4caf50);font-weight:600;">Privacy Policy</a>.
          If you do not agree, please stop using our platform.
 
          <div class="tc-note warning mt-3">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <span>These Terms form a legally binding agreement between you and BanglaBazar. Please read them carefully.</span>
          </div>
        </div>
 
        {{-- 1. Acceptance --}}
        <div class="tc-card" id="tc-acceptance">
          <div class="tc-card-head">
            <div class="tc-icon"><i class="bi bi-check2-circle"></i></div>
            <h3>1. Acceptance of Terms</h3>
          </div>
          <p>By using our platform, you confirm that you:</p>
          <ul>
            <li>Are at least <strong>18 years of age</strong>, or are using the platform under the supervision of a parent or legal guardian.</li>
            <li>Are a resident of Bangladesh or are accessing our services from a jurisdiction where such use is lawful.</li>
            <li>Have the legal capacity to enter into a binding agreement.</li>
            <li>Will use our platform only for lawful purposes and in compliance with these Terms.</li>
            <li>Agree to receive service-related communications from BanglaBazar (e.g., order confirmations, delivery updates).</li>
          </ul>
        </div>
 
        {{-- 2. Accounts --}}
        <div class="tc-card" id="tc-account">
          <div class="tc-card-head">
            <div class="tc-icon"><i class="bi bi-person-circle"></i></div>
            <h3>2. User Accounts</h3>
          </div>
          <p>To shop on BanglaBazar, you may be required to create an account. When you do:</p>
          <ul>
            <li>You must provide <strong>accurate, current, and complete</strong> information during registration and keep it updated.</li>
            <li>You are solely responsible for maintaining the <strong>confidentiality of your password</strong> and all activity that occurs under your account.</li>
            <li>You must <strong>not share</strong> your account credentials with any third party.</li>
            <li>Notify us immediately at <a href="mailto:support@banglabaazar.com" style="color:var(--green,#4caf50);">support@banglabaazar.com</a> if you suspect unauthorized access to your account.</li>
            <li>Each person may register <strong>only one account</strong>. Creating multiple accounts to abuse promotions or coupons is prohibited.</li>
            <li>We reserve the right to <strong>suspend or permanently terminate</strong> accounts that violate these Terms, without prior notice.</li>
          </ul>
        </div>
 
        {{-- 3. Orders & Payments --}}
        <div class="tc-card" id="tc-orders">
          <div class="tc-card-head">
            <div class="tc-icon"><i class="bi bi-bag-check-fill"></i></div>
            <h3>3. Orders &amp; Payments</h3>
          </div>
          <p><strong>Placing an order:</strong></p>
          <ul>
            <li>All orders are subject to <strong>product availability and acceptance</strong>. We reserve the right to decline or cancel any order at our discretion.</li>
            <li>Once your order is confirmed, you will receive an email confirmation. This constitutes acceptance of your order.</li>
            <li>We may cancel an order if stock is unavailable, if a pricing error is detected, or if we suspect fraudulent activity. A full refund will be issued in such cases.</li>
          </ul>
          <p class="mt-3"><strong>Payments:</strong></p>
          <ul>
            <li>All prices are in <strong>Bangladeshi Taka (৳)</strong> and inclusive of applicable taxes unless stated otherwise.</li>
            <li>Payment must be completed before your order is processed and dispatched.</li>
            <li>We accept <strong>bKash, Nagad, credit/debit cards, and Cash on Delivery</strong> (COD available for eligible areas).</li>
            <li>For COD orders, full payment must be made to the delivery agent upon receipt. Refusal to pay may result in account suspension.</li>
          </ul>
          <div class="tc-note info">
            <i class="bi bi-info-circle-fill"></i>
            <span>Payment information is processed by PCI-compliant third-party gateways. BanglaBazar does not store your full card or mobile banking credentials.</span>
          </div>
        </div>
 
        {{-- 4. Pricing & Promotions --}}
        <div class="tc-card" id="tc-pricing">
          <div class="tc-card-head">
            <div class="tc-icon"><i class="bi bi-tag-fill"></i></div>
            <h3>4. Pricing &amp; Promotions</h3>
          </div>
          <ul>
            <li>BanglaBazar reserves the right to <strong>change prices at any time</strong> without prior notice. The price shown at the time of checkout is the final price.</li>
            <li>In case of a <strong>pricing error</strong> (e.g., product listed at ৳0 or an unusually low price due to a system error), we reserve the right to cancel affected orders and issue a full refund.</li>
            <li><strong>Coupon codes &amp; discount offers</strong> are subject to their individual terms — including expiry dates, minimum order values, and eligible product categories.</li>
            <li>Coupon codes cannot be <strong>combined</strong> with other offers unless explicitly stated.</li>
            <li>Hot Deals and limited-time offers are available only while <strong>stocks last</strong>. We do not offer rain checks.</li>
            <li>Promotional prices apply only to the specified period and cannot be retroactively applied to previous orders.</li>
          </ul>
        </div>
 
        {{-- 5. Shipping --}}
        <div class="tc-card" id="tc-shipping">
          <div class="tc-card-head">
            <div class="tc-icon"><i class="bi bi-truck"></i></div>
            <h3>5. Shipping &amp; Delivery</h3>
          </div>
          <ul>
            <li>We deliver across <strong>Bangladesh</strong>. Delivery availability and timelines vary by location.</li>
            <li>Delivery charges, if any, will be clearly displayed at checkout before you confirm your order.</li>
            <li>Estimated delivery times are provided as a guide only and are <strong>not guaranteed</strong>. Delays may occur due to high order volume, weather, public holidays, or events beyond our control.</li>
            <li>You are responsible for providing a <strong>correct and accessible delivery address</strong>. BanglaBazar is not liable for delays or failed deliveries caused by incorrect addresses.</li>
            <li>If a delivery attempt fails and the order is returned to us, <strong>re-delivery charges</strong> may apply. We will contact you to arrange re-delivery.</li>
            <li><strong>Risk of loss</strong> and title for products transfer to you upon successful delivery.</li>
            <li>For fresh or perishable products, please ensure someone is available to receive the order to maintain product quality.</li>
          </ul>
        </div>
 
        {{-- 6. Returns & Refunds --}}
        <div class="tc-card" id="tc-returns">
          <div class="tc-card-head">
            <div class="tc-icon"><i class="bi bi-arrow-return-left"></i></div>
            <h3>6. Returns &amp; Refunds</h3>
          </div>
          <p><strong>Return eligibility:</strong></p>
          <ul>
            <li>Return requests must be submitted within <strong>7 days</strong> of delivery via your account's order history page.</li>
            <li>Items must be <strong>unused, in original condition</strong>, and in their original packaging.</li>
            <li><strong>Perishable goods</strong> (fresh produce, dairy, meat, bakery) are not eligible for return unless they arrived damaged, spoiled, or incorrect.</li>
            <li>Items marked as <strong>"Non-Returnable"</strong> on the product page are not eligible for returns.</li>
          </ul>
          <p class="mt-3"><strong>Refund process:</strong></p>
          <ul>
            <li>Once we receive and inspect the returned item, refunds are processed within <strong>5–7 business days</strong>.</li>
            <li>Refunds are issued to the <strong>original payment method</strong> or as BanglaBazar store credit, at our discretion.</li>
            <li>Return shipping costs are borne by the <strong>customer</strong>, unless the return is due to a defective or incorrect item sent by us.</li>
          </ul>
          <div class="tc-note warning">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <span>Items returned without prior authorization or outside the return window will not be accepted and will be sent back to the customer.</span>
          </div>
        </div>
 
        {{-- 7. Prohibited Activities --}}
        <div class="tc-card" id="tc-prohibited">
          <div class="tc-card-head">
            <div class="tc-icon"><i class="bi bi-slash-circle-fill"></i></div>
            <h3>7. Prohibited Activities</h3>
          </div>
          <p>You agree <strong>not to</strong> engage in any of the following while using our platform:</p>
          <ul>
            <li>Using our platform for any <strong>unlawful purpose</strong> or in violation of any applicable laws or regulations.</li>
            <li>Attempting to gain unauthorized access to any part of our platform, servers, or databases.</li>
            <li>Submitting <strong>false, misleading, or fraudulent</strong> orders, reviews, or personal information.</li>
            <li>Using <strong>automated bots, scrapers, or crawlers</strong> to collect data from our site without written permission.</li>
            <li>Posting <strong>abusive, defamatory, hateful, or obscene</strong> content in reviews, comments, or messages.</li>
            <li><strong>Reselling</strong> products purchased from BanglaBazar for commercial gain without our prior written consent.</li>
            <li>Exploiting pricing errors, system bugs, or promotional loopholes in bad faith.</li>
            <li>Impersonating any person or entity, or misrepresenting your affiliation with any person or entity.</li>
          </ul>
          <p class="mt-3 mb-0">Violations may result in immediate account suspension, order cancellation, and legal action where appropriate.</p>
        </div>
 
        {{-- 8. Intellectual Property --}}
        <div class="tc-card" id="tc-ip">
          <div class="tc-card-head">
            <div class="tc-icon"><i class="bi bi-award-fill"></i></div>
            <h3>8. Intellectual Property</h3>
          </div>
          <p class="mb-0">
            All content on the BanglaBazar platform — including but not limited to logos, brand name, product images,
            descriptions, graphics, layout, software, and source code — is the exclusive property of BanglaBazar or its
            licensed content providers and is protected under applicable intellectual property laws.
          </p>
          <ul class="mt-2">
            <li>You may <strong>not reproduce, copy, distribute, modify</strong>, or create derivative works from any content without our express written permission.</li>
            <li>You may not use our brand name, logo, or trademarks in any manner that suggests endorsement or affiliation without prior consent.</li>
            <li>User-submitted content (e.g., product reviews) grants BanglaBazar a <strong>non-exclusive, royalty-free license</strong> to use, display, and republish that content across our platform and marketing channels.</li>
          </ul>
        </div>
 
        {{-- 9. Limitation of Liability --}}
        <div class="tc-card" id="tc-liability">
          <div class="tc-card-head">
            <div class="tc-icon"><i class="bi bi-shield-exclamation"></i></div>
            <h3>9. Limitation of Liability</h3>
          </div>
          <p>To the maximum extent permitted under applicable law, BanglaBazar shall <strong>not be liable</strong> for:</p>
          <ul>
            <li>Any <strong>indirect, incidental, special, or consequential damages</strong> arising from your use of our platform or services.</li>
            <li>Loss of profits, data, business opportunities, or goodwill.</li>
            <li>Service interruptions, errors, or outages caused by factors beyond our reasonable control (e.g., internet failure, natural disasters, third-party platform outages).</li>
            <li>Damage caused by <strong>unauthorized access</strong> to your account where such access resulted from your failure to maintain account security.</li>
          </ul>
          <p class="mt-3 mb-0">
            Our total liability to you for any single claim arising out of or related to these Terms shall not exceed
            <strong>the total amount you paid for the specific order</strong> in question.
          </p>
        </div>
 
        {{-- 10. Governing Law --}}
        <div class="tc-card" id="tc-governing">
          <div class="tc-card-head">
            <div class="tc-icon"><i class="bi bi-bank2"></i></div>
            <h3>10. Governing Law &amp; Disputes</h3>
          </div>
          <p class="mb-0">
            These Terms shall be governed by and construed in accordance with the laws of the
            <strong>People's Republic of Bangladesh</strong>. Any dispute, claim, or controversy arising
            out of or relating to these Terms or your use of our platform shall be subject to the
            exclusive jurisdiction of the courts located in <strong>Chattogram, Bangladesh</strong>.
          </p>
          <ul class="mt-2">
            <li>We strongly encourage resolving disputes <strong>amicably first</strong> — please contact our support team before initiating legal proceedings.</li>
            <li>For minor disputes, we offer mediation through our customer support channel as a first step.</li>
            <li>BanglaBazar reserves the right to modify these Terms at any time. Continued use of the platform after changes constitutes acceptance of the updated Terms.</li>
          </ul>
        </div>
 
        {{-- CTA --}}
        <div class="tc-cta" id="tc-contact">
          <h4><i class="bi bi-chat-text-fill me-2"></i> Questions About These Terms?</h4>
          <p>
            If you have any questions, concerns, or need clarification about our Terms &amp; Conditions,
            our support team is ready to help — we respond within 7 business days.
          </p>
          <div class="tc-cta-btns">
            <a href="{{ route('contact') }}" class="btn-white">
              <i class="bi bi-chat-dots-fill"></i> Contact Us
            </a>
            <a href="{{ route('privacy') }}" class="btn-outline">
              <i class="bi bi-shield-check"></i> Privacy Policy
            </a>
          </div>
        </div>
 
      </div>{{-- /col --}}
    </div>{{-- /row --}}
  </div>{{-- /container --}}
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
