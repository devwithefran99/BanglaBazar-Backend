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
<div class="pp-hero">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Privacy Policy</li>
      </ol>
    </nav>
    <h1>Privacy <span>Policy</span></h1>
    <p class="text-muted mb-0" style="font-size:.95rem;">
      How BanglaBazar collects, uses, and protects your personal information.
    </p>
    <div class="pp-updated">
      <i class="bi bi-calendar2-check-fill"></i> Last updated: January 1, 2026
    </div>
  </div>
</div>
 
 
{{-- ════════ MAIN ════════ --}}
<section class="pp-wrap">
  <div class="container">
    <div class="row g-4">
 
      {{-- ── Table of Contents (desktop sticky) ── --}}
      <div class="col-lg-3 d-none d-lg-block">
        <div class="pp-toc">
          <p class="pp-toc-title">On this page</p>
          <a href="#pp-intro">    <i class="bi bi-chevron-right"></i> Overview</a>
          <a href="#pp-collect">  <i class="bi bi-chevron-right"></i> Information We Collect</a>
          <a href="#pp-use">      <i class="bi bi-chevron-right"></i> How We Use Your Data</a>
          <a href="#pp-share">    <i class="bi bi-chevron-right"></i> Sharing Information</a>
          <a href="#pp-cookies">  <i class="bi bi-chevron-right"></i> Cookies</a>
          <a href="#pp-security"> <i class="bi bi-chevron-right"></i> Data Security</a>
          <a href="#pp-rights">   <i class="bi bi-chevron-right"></i> Your Rights</a>
          <a href="#pp-children"> <i class="bi bi-chevron-right"></i> Children's Privacy</a>
          <a href="#pp-changes">  <i class="bi bi-chevron-right"></i> Policy Changes</a>
          <a href="#pp-contact">  <i class="bi bi-chevron-right"></i> Contact Us</a>
        </div>
      </div>
 
      {{-- ── Content ── --}}
      <div class="col-lg-9">
 
        {{-- Intro --}}
        <div class="pp-intro" id="pp-intro">
          <strong>Welcome to BanglaBazar.</strong> We take your privacy seriously. This Privacy Policy explains what personal
          information we collect when you shop on our platform, how we use it, who we may share it with, and the choices
          you have. By using our website and services, you agree to the practices described in this policy.
          If you do not agree, please discontinue use of our platform.
        </div>
 
        {{-- 1. Information We Collect --}}
        <div class="pp-card" id="pp-collect">
          <div class="pp-card-head">
            <div class="pp-icon"><i class="bi bi-person-lines-fill"></i></div>
            <h3>1. Information We Collect</h3>
          </div>
 
          <p><strong>A. Information you give us directly:</strong></p>
          <ul>
            <li><strong>Account details:</strong> Name, email address, and password when you register.</li>
            <li><strong>Order information:</strong> Billing address, delivery address, and phone number when you place an order.</li>
            <li><strong>Payment information:</strong> Card details or mobile banking numbers processed securely via our payment partners. We do <em>not</em> store full card numbers on our servers.</li>
            <li><strong>Communications:</strong> Messages you send us via the contact form, email, or live chat.</li>
            <li><strong>Reviews & ratings:</strong> Product feedback you voluntarily submit on our platform.</li>
          </ul>
 
          <p class="mt-3"><strong>B. Information collected automatically:</strong></p>
          <ul>
            <li><strong>Usage data:</strong> Pages visited, products viewed, search queries, time spent, and click patterns.</li>
            <li><strong>Device & browser data:</strong> IP address, browser type, operating system, and screen resolution.</li>
            <li><strong>Cookies & tracking:</strong> Session cookies, preference cookies, and analytics identifiers (see Cookies section).</li>
            <li><strong>Location data:</strong> Approximate location inferred from IP address for region-based pricing or delivery estimates.</li>
          </ul>
        </div>
 
        {{-- 2. How We Use Your Data --}}
        <div class="pp-card" id="pp-use">
          <div class="pp-card-head">
            <div class="pp-icon"><i class="bi bi-gear-wide-connected"></i></div>
            <h3>2. How We Use Your Information</h3>
          </div>
          <p>We use the information we collect to:</p>
          <ul>
            <li><strong>Process & fulfill orders</strong> — confirm purchases, coordinate delivery, and handle returns or refunds.</li>
            <li><strong>Send transactional emails</strong> — order confirmation, shipping updates, and delivery notifications.</li>
            <li><strong>Manage your account</strong> — maintain your profile, order history, wishlist, and saved addresses.</li>
            <li><strong>Improve our platform</strong> — analyze usage patterns, fix bugs, and enhance the shopping experience.</li>
            <li><strong>Personalize recommendations</strong> — suggest products based on browsing and purchase history.</li>
            <li><strong>Prevent fraud & ensure security</strong> — detect suspicious activity and protect customer accounts.</li>
            <li><strong>Send promotional content</strong> — newsletters and special offers (only with your explicit consent; you may unsubscribe at any time).</li>
            <li><strong>Comply with legal obligations</strong> — respond to lawful requests from authorities where required.</li>
          </ul>
        </div>
 
        {{-- 3. Sharing --}}
        <div class="pp-card" id="pp-share">
          <div class="pp-card-head">
            <div class="pp-icon"><i class="bi bi-people-fill"></i></div>
            <h3>3. Sharing Your Information</h3>
          </div>
          <p>We <strong>never sell</strong> your personal data to third parties. We may share limited information only in these circumstances:</p>
          <ul>
            <li><strong>Delivery partners:</strong> Name, phone number, and delivery address shared with couriers to complete your order.</li>
            <li><strong>Payment processors:</strong> Secure services such as SSLCommerz, bKash, or Nagad to handle transactions.</li>
            <li><strong>Analytics tools:</strong> Anonymized usage data shared with tools like Google Analytics to understand site performance.</li>
            <li><strong>Email service providers:</strong> Platforms used to send order confirmation and marketing emails, under strict data agreements.</li>
            <li><strong>Legal & regulatory bodies:</strong> When required by Bangladeshi law, court order, or to protect our legal rights.</li>
            <li><strong>Business transfers:</strong> In the event of a merger or acquisition, your data may be transferred to the new entity under the same privacy commitments.</li>
          </ul>
          <div class="pp-note">
            <i class="bi bi-info-circle-fill"></i>
            <span>All third-party partners are contractually required to handle your data with the same level of protection we apply.</span>
          </div>
        </div>
 
        {{-- 4. Cookies --}}
        <div class="pp-card" id="pp-cookies">
          <div class="pp-card-head">
            <div class="pp-icon"><i class="bi bi-browser-chrome"></i></div>
            <h3>4. Cookies &amp; Tracking Technologies</h3>
          </div>
          <p>We use cookies and similar technologies to power key features of our site. Here's what we use:</p>
          <ul>
            <li><strong>Essential cookies:</strong> Required for core functionality such as keeping you logged in, maintaining your cart, and processing checkout securely.</li>
            <li><strong>Preference cookies:</strong> Remember your language, region, and display preferences.</li>
            <li><strong>Analytics cookies:</strong> Help us understand how visitors use our site so we can improve it (e.g., Google Analytics). Data is anonymized.</li>
            <li><strong>Marketing cookies:</strong> Used (only with consent) to deliver relevant advertisements on partner platforms.</li>
          </ul>
          <p class="mt-3 mb-0">
            You can manage or disable cookies through your browser settings. Note that disabling essential cookies may affect site functionality, including your ability to add items to your cart or complete checkout.
          </p>
        </div>
 
        {{-- 5. Security --}}
        <div class="pp-card" id="pp-security">
          <div class="pp-card-head">
            <div class="pp-icon"><i class="bi bi-shield-lock-fill"></i></div>
            <h3>5. Data Security</h3>
          </div>
          <p>We implement industry-standard measures to protect your data:</p>
          <ul>
            <li><strong>HTTPS/TLS encryption</strong> on all pages to secure data in transit.</li>
            <li><strong>Hashed &amp; salted passwords</strong> — your password is never stored in plain text.</li>
            <li><strong>Restricted access</strong> — only authorized personnel with a business need can access personal data.</li>
            <li><strong>Secure payment gateways</strong> — we do not handle or store raw card data on our servers.</li>
            <li><strong>Regular audits</strong> — periodic reviews of our systems and third-party integrations.</li>
          </ul>
          <div class="pp-note">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <span>No system is 100% secure. If you suspect unauthorized access to your account, please change your password immediately and contact us.</span>
          </div>
        </div>
 
        {{-- 6. Your Rights --}}
        <div class="pp-card" id="pp-rights">
          <div class="pp-card-head">
            <div class="pp-icon"><i class="bi bi-hand-index-thumb-fill"></i></div>
            <h3>6. Your Rights &amp; Choices</h3>
          </div>
          <p>As a BanglaBazar customer, you have the right to:</p>
          <ul>
            <li><strong>Access:</strong> Request a copy of the personal data we hold about you.</li>
            <li><strong>Correction:</strong> Update or correct inaccurate information via your Account Settings page.</li>
            <li><strong>Deletion:</strong> Request deletion of your account and associated personal data. Some data may be retained for legal or fraud-prevention purposes.</li>
            <li><strong>Opt-out of marketing:</strong> Unsubscribe from promotional emails at any time via the link in the email or through Account Settings.</li>
            <li><strong>Data portability:</strong> Request your data in a structured, machine-readable format.</li>
            <li><strong>Withdraw consent:</strong> Where processing is based on consent, you may withdraw it at any time without affecting prior processing.</li>
          </ul>
          <p class="mt-3 mb-0">
            To exercise any of these rights, email us at
            <a href="mailto:privacy@banglabaazar.com" style="color:var(--green,#4caf50);font-weight:600;">privacy@banglabaazar.com</a>
            or use our <a href="{{ route('contact') }}" style="color:var(--green,#4caf50);font-weight:600;">Contact Page</a>.
            We will respond within <strong>7 business days</strong>.
          </p>
        </div>
 
        {{-- 7. Children --}}
        <div class="pp-card" id="pp-children">
          <div class="pp-card-head">
            <div class="pp-icon"><i class="bi bi-emoji-smile-fill"></i></div>
            <h3>7. Children's Privacy</h3>
          </div>
          <p class="mb-0">
            Our platform is not intended for children under the age of 13. We do not knowingly collect personal information
            from children. If you are a parent or guardian and believe your child has provided us with personal data,
            please contact us immediately at
            <a href="mailto:privacy@banglabaazar.com" style="color:var(--green,#4caf50);font-weight:600;">privacy@banglabaazar.com</a>
            and we will promptly delete the information.
          </p>
        </div>
 
        {{-- 8. Changes --}}
        <div class="pp-card" id="pp-changes">
          <div class="pp-card-head">
            <div class="pp-icon"><i class="bi bi-arrow-repeat"></i></div>
            <h3>8. Changes to This Policy</h3>
          </div>
          <p class="mb-0">
            We may update this Privacy Policy periodically to reflect changes in our practices, legal requirements,
            or new features. When we make material changes, we will:
          </p>
          <ul class="mt-2">
            <li>Update the <strong>"Last updated"</strong> date at the top of this page.</li>
            <li>Send a notification email to registered users for significant changes.</li>
            <li>Display a prominent notice on our website homepage.</li>
          </ul>
          <p class="mt-3 mb-0">
            Continued use of our platform after any changes constitutes your acceptance of the updated policy.
            We encourage you to review this page periodically.
          </p>
        </div>
 
        {{-- 9. Contact CTA --}}
        <div class="pp-cta" id="pp-contact">
          <h4><i class="bi bi-envelope-open-fill me-2"></i> Questions About Your Privacy?</h4>
          <p>
            Our team is here to help. If you have questions, concerns, or requests regarding this Privacy Policy
            or how we handle your personal data, reach out to us — we'll respond within 7 business days.
          </p>
          <a href="{{ route('contact') }}">
            <i class="bi bi-chat-dots-fill"></i> Contact Us
          </a>
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