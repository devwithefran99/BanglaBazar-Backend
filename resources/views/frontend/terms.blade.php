@extends('frontend.layouts.app')

@section('title', 'Terms & Conditions')
@section('meta_description', 'BanglaBazar Terms & Conditions — আমাদের platform ব্যবহারের নিয়মাবলী, payment, delivery এবং return policy সম্পর্কে জানুন।')

@push('styles')
  <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('frontend/css/pages.css') }}">
@endpush

@section('content')

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

<section class="tc-wrap">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-3 d-none d-lg-block">
        <div class="tc-toc">
          <p class="tc-toc-title">On this page</p>
          <a href="#tc-intro"><i class="bi bi-chevron-right"></i> Overview</a>
          <a href="#tc-acceptance"><i class="bi bi-chevron-right"></i> Acceptance of Terms</a>
          <a href="#tc-account"><i class="bi bi-chevron-right"></i> User Accounts</a>
          <a href="#tc-orders"><i class="bi bi-chevron-right"></i> Orders &amp; Payments</a>
          <a href="#tc-pricing"><i class="bi bi-chevron-right"></i> Pricing &amp; Promotions</a>
          <a href="#tc-shipping"><i class="bi bi-chevron-right"></i> Shipping &amp; Delivery</a>
          <a href="#tc-returns"><i class="bi bi-chevron-right"></i> Returns &amp; Refunds</a>
          <a href="#tc-prohibited"><i class="bi bi-chevron-right"></i> Prohibited Activities</a>
          <a href="#tc-ip"><i class="bi bi-chevron-right"></i> Intellectual Property</a>
          <a href="#tc-liability"><i class="bi bi-chevron-right"></i> Limitation of Liability</a>
          <a href="#tc-governing"><i class="bi bi-chevron-right"></i> Governing Law</a>
          <a href="#tc-contact"><i class="bi bi-chevron-right"></i> Contact Us</a>
        </div>
      </div>
      <div class="col-lg-9">
        <div class="tc-intro" id="tc-intro">
          Welcome to <strong>BanglaBazar</strong>. These Terms &amp; Conditions ("Terms") govern your access to and use of our website, mobile app, and all related services. By creating an account, browsing our site, or placing an order, you confirm that you have read, understood, and agree to be bound by these Terms along with our <a href="{{ route('privacy') }}" style="color:var(--green,#4caf50);font-weight:600;">Privacy Policy</a>. If you do not agree, please stop using our platform.
          <div class="tc-note warning mt-3"><i class="bi bi-exclamation-triangle-fill"></i><span>These Terms form a legally binding agreement between you and BanglaBazar. Please read them carefully.</span></div>
        </div>

        <div class="tc-card" id="tc-acceptance">
          <div class="tc-card-head"><div class="tc-icon"><i class="bi bi-check2-circle"></i></div><h3>1. Acceptance of Terms</h3></div>
          <ul>
            <li>Are at least <strong>18 years of age</strong>, or are using the platform under the supervision of a parent or legal guardian.</li>
            <li>Are a resident of Bangladesh or are accessing our services from a jurisdiction where such use is lawful.</li>
            <li>Have the legal capacity to enter into a binding agreement.</li>
            <li>Will use our platform only for lawful purposes and in compliance with these Terms.</li>
          </ul>
        </div>

        <div class="tc-card" id="tc-account">
          <div class="tc-card-head"><div class="tc-icon"><i class="bi bi-person-circle"></i></div><h3>2. User Accounts</h3></div>
          <ul>
            <li>You must provide <strong>accurate, current, and complete</strong> information during registration.</li>
            <li>You are solely responsible for maintaining the <strong>confidentiality of your password</strong>.</li>
            <li>You must <strong>not share</strong> your account credentials with any third party.</li>
            <li>Each person may register <strong>only one account</strong>. Multiple accounts to abuse promotions is prohibited.</li>
            <li>We reserve the right to <strong>suspend or permanently terminate</strong> accounts that violate these Terms.</li>
          </ul>
        </div>

        <div class="tc-card" id="tc-orders">
          <div class="tc-card-head"><div class="tc-icon"><i class="bi bi-bag-check-fill"></i></div><h3>3. Orders &amp; Payments</h3></div>
          <p><strong>Placing an order:</strong></p>
          <ul>
            <li>All orders are subject to <strong>product availability and acceptance</strong>.</li>
            <li>Once your order is confirmed, you will receive an email confirmation.</li>
            <li>We may cancel an order if stock is unavailable, if a pricing error is detected, or if we suspect fraudulent activity.</li>
          </ul>
          <p class="mt-3"><strong>Payments:</strong></p>
          <ul>
            <li>All prices are in <strong>Bangladeshi Taka (৳)</strong> and inclusive of applicable taxes unless stated otherwise.</li>
            <li>We accept <strong>bKash, Nagad, credit/debit cards, and Cash on Delivery</strong>.</li>
          </ul>
          <div class="tc-note info"><i class="bi bi-info-circle-fill"></i><span>Payment information is processed by PCI-compliant third-party gateways. BanglaBazar does not store your full card or mobile banking credentials.</span></div>
        </div>

        <div class="tc-card" id="tc-pricing">
          <div class="tc-card-head"><div class="tc-icon"><i class="bi bi-tag-fill"></i></div><h3>4. Pricing &amp; Promotions</h3></div>
          <ul>
            <li>BanglaBazar reserves the right to <strong>change prices at any time</strong> without prior notice.</li>
            <li><strong>Coupon codes &amp; discount offers</strong> are subject to their individual terms.</li>
            <li>Coupon codes cannot be <strong>combined</strong> with other offers unless explicitly stated.</li>
            <li>Hot Deals and limited-time offers are available only while <strong>stocks last</strong>.</li>
          </ul>
        </div>

        <div class="tc-card" id="tc-shipping">
          <div class="tc-card-head"><div class="tc-icon"><i class="bi bi-truck"></i></div><h3>5. Shipping &amp; Delivery</h3></div>
          <ul>
            <li>We deliver within <strong>Chattogram city</strong> and selected areas of Bangladesh.</li>
            <li>Estimated delivery times are provided at checkout and may vary due to demand or logistics issues.</li>
            <li><strong>Risk of loss</strong> and title for products transfer to you upon successful delivery.</li>
          </ul>
        </div>

        <div class="tc-card" id="tc-returns">
          <div class="tc-card-head"><div class="tc-icon"><i class="bi bi-arrow-return-left"></i></div><h3>6. Returns &amp; Refunds</h3></div>
          <p><strong>Return eligibility:</strong></p>
          <ul>
            <li>Return requests must be submitted within <strong>24 hours</strong> of delivery.</li>
            <li>Items must be <strong>unused, in original condition</strong>, and in their original packaging.</li>
            <li><strong>Perishable goods</strong> are not eligible for return unless they arrived damaged or incorrect.</li>
          </ul>
          <p class="mt-3"><strong>Refund process:</strong></p>
          <ul>
            <li>Refunds are processed within <strong>5–7 business days</strong> after inspection.</li>
            <li>Refunds are issued to the <strong>original payment method</strong> or as store credit.</li>
          </ul>
          <div class="tc-note warning"><i class="bi bi-exclamation-triangle-fill"></i><span>Items returned without prior authorization or outside the return window will not be accepted.</span></div>
        </div>

        <div class="tc-card" id="tc-prohibited">
          <div class="tc-card-head"><div class="tc-icon"><i class="bi bi-slash-circle-fill"></i></div><h3>7. Prohibited Activities</h3></div>
          <ul>
            <li>Using our platform for any <strong>unlawful purpose</strong>.</li>
            <li>Submitting <strong>false, misleading, or fraudulent</strong> orders, reviews, or personal information.</li>
            <li>Using <strong>automated bots, scrapers, or crawlers</strong> without written permission.</li>
            <li>Posting <strong>abusive, defamatory, hateful, or obscene</strong> content.</li>
            <li>Exploiting pricing errors, system bugs, or promotional loopholes in bad faith.</li>
          </ul>
        </div>

        <div class="tc-card" id="tc-ip">
          <div class="tc-card-head"><div class="tc-icon"><i class="bi bi-award-fill"></i></div><h3>8. Intellectual Property</h3></div>
          <p class="mb-0">All content on the BanglaBazar platform — including logos, brand name, product images, descriptions, graphics, layout, software, and source code — is the exclusive property of BanglaBazar and is protected under applicable intellectual property laws.</p>
        </div>

        <div class="tc-card" id="tc-liability">
          <div class="tc-card-head"><div class="tc-icon"><i class="bi bi-shield-exclamation"></i></div><h3>9. Limitation of Liability</h3></div>
          <p>To the maximum extent permitted under applicable law, BanglaBazar shall <strong>not be liable</strong> for any indirect, incidental, special, or consequential damages arising from your use of our platform.</p>
        </div>

        <div class="tc-card" id="tc-governing">
          <div class="tc-card-head"><div class="tc-icon"><i class="bi bi-bank2"></i></div><h3>10. Governing Law &amp; Disputes</h3></div>
          <p class="mb-0">These Terms shall be governed by the laws of the <strong>People's Republic of Bangladesh</strong>. Any dispute shall be subject to the exclusive jurisdiction of the courts located in <strong>Chattogram, Bangladesh</strong>.</p>
        </div>

        <div class="tc-cta" id="tc-contact">
          <h4><i class="bi bi-chat-text-fill me-2"></i> Questions About These Terms?</h4>
          <p>If you have any questions or need clarification, our support team is ready to help.</p>
          <div class="tc-cta-btns">
            <a href="{{ route('contact') }}" class="btn-white"><i class="bi bi-chat-dots-fill"></i> Contact Us</a>
            <a href="{{ route('privacy') }}" class="btn-outline"><i class="bi bi-shield-check"></i> Privacy Policy</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- CART DRAWER --}}
<div class="cp-overlay" id="cpOverlay"></div>
<div class="cp-drawer" id="cpDrawer">
  <div class="cp-header">
    <div class="cp-title"><img src="{{ asset('frontend/image/Logo.png') }}" alt=""></div>
    <button class="cp-close" id="cpClose"><i class="bi bi-x-lg"></i></button>
  </div>
  <div class="cp-items" id="cpItems"></div>
  <div class="cp-empty" id="cpEmpty" style="display:flex;">
    <i class="bi bi-bag-x"></i><p>Your cart is empty</p>
    <a href="{{ route('shop') }}" class="cp-shop-link">Browse Products →</a>
  </div>
  <div class="cp-footer" id="cpFooter" style="display:none;">
    <div class="cp-subtotal">
      <span class="cp-sub-label"><span id="cpProductCount">0</span> Product</span>
      <span class="cp-sub-price" id="cpTotal">৳0.00</span>
    </div>
    <a href="{{ route('checkout.show') }}" class="cp-checkout-btn">
      <i class="bi bi-bag-check-fill me-1"></i> Checkout
    </a>
  </div>
</div>

@endsection

@push('scripts')
  <script src="{{ asset('frontend/js/wishlist.js') }}" ></script>
  <script src="{{ asset('frontend/js/pages.js') }}" ></script>
@endpush