@extends('frontend.layouts.app')

@section('title', 'Privacy Policy')
@section('meta_description', 'BanglaBazar Privacy Policy — আমরা কীভাবে আপনার data সংগ্রহ, ব্যবহার এবং সুরক্ষা করি তা জানুন।')

@push('styles')
  <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('frontend/css/pages.css') }}">
@endpush

@section('content')

{{-- QUICK VIEW MODAL --}}
<div class="qv-backdrop" id="qvBackdrop">
  <div class="qv-modal" role="dialog" aria-modal="true">
    <button class="qv-close" id="qvClose"><i class="bi bi-x"></i></button>
    <div class="qv-img-side"><img id="qvImg" src="" alt=""></div>
    <div class="qv-info-side">
      <span class="qv-category" id="qvCat">Vegetables</span>
      <h2 class="qv-title" id="qvTitle"></h2>
      <div class="qv-stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star empty"></i></div>
      <div class="qv-price-row">
        <span class="qv-price-current" id="qvPrice"></span>
        <span class="qv-price-old" id="qvOld"></span>
        <span class="qv-discount" id="qvDiscount" style="display:none"></span>
      </div>
      <p class="qv-desc" id="qvDesc">Fresh, naturally grown product.</p>
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

{{-- PRIVACY CONTENT --}}

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

<section class="pp-wrap">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-3 d-none d-lg-block">
        <div class="pp-toc">
          <p class="pp-toc-title">On this page</p>
          <a href="#pp-intro"><i class="bi bi-chevron-right"></i> Overview</a>
          <a href="#pp-collect"><i class="bi bi-chevron-right"></i> Information We Collect</a>
          <a href="#pp-use"><i class="bi bi-chevron-right"></i> How We Use Your Data</a>
          <a href="#pp-share"><i class="bi bi-chevron-right"></i> Sharing Information</a>
          <a href="#pp-cookies"><i class="bi bi-chevron-right"></i> Cookies</a>
          <a href="#pp-security"><i class="bi bi-chevron-right"></i> Data Security</a>
          <a href="#pp-rights"><i class="bi bi-chevron-right"></i> Your Rights</a>
          <a href="#pp-children"><i class="bi bi-chevron-right"></i> Children's Privacy</a>
          <a href="#pp-changes"><i class="bi bi-chevron-right"></i> Policy Changes</a>
          <a href="#pp-contact"><i class="bi bi-chevron-right"></i> Contact Us</a>
        </div>
      </div>
      <div class="col-lg-9">
        <div class="pp-intro" id="pp-intro">
          <strong>Welcome to BanglaBazar.</strong> We take your privacy seriously. This Privacy Policy explains what personal information we collect when you shop on our platform, how we use it, who we may share it with, and the choices you have. By using our website and services, you agree to the practices described in this policy. If you do not agree, please discontinue use of our platform.
        </div>
        <div class="pp-card" id="pp-collect">
          <div class="pp-card-head"><div class="pp-icon"><i class="bi bi-person-lines-fill"></i></div><h3>1. Information We Collect</h3></div>
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
            <li><strong>Cookies & tracking:</strong> Session cookies, preference cookies, and analytics identifiers.</li>
            <li><strong>Location data:</strong> Approximate location inferred from IP address for region-based pricing or delivery estimates.</li>
          </ul>
        </div>
        <div class="pp-card" id="pp-use">
          <div class="pp-card-head"><div class="pp-icon"><i class="bi bi-gear-wide-connected"></i></div><h3>2. How We Use Your Information</h3></div>
          <ul>
            <li><strong>Process & fulfill orders</strong> — confirm purchases, coordinate delivery, and handle returns or refunds.</li>
            <li><strong>Send transactional emails</strong> — order confirmation, shipping updates, and delivery notifications.</li>
            <li><strong>Manage your account</strong> — maintain your profile, order history, wishlist, and saved addresses.</li>
            <li><strong>Improve our platform</strong> — analyze usage patterns, fix bugs, and enhance the shopping experience.</li>
            <li><strong>Personalize recommendations</strong> — suggest products based on browsing and purchase history.</li>
            <li><strong>Prevent fraud & ensure security</strong> — detect suspicious activity and protect customer accounts.</li>
            <li><strong>Send promotional content</strong> — newsletters and special offers (only with your explicit consent).</li>
            <li><strong>Comply with legal obligations</strong> — respond to lawful requests from authorities where required.</li>
          </ul>
        </div>
        <div class="pp-card" id="pp-share">
          <div class="pp-card-head"><div class="pp-icon"><i class="bi bi-people-fill"></i></div><h3>3. Sharing Your Information</h3></div>
          <p>We <strong>never sell</strong> your personal data to third parties. We may share limited information only in these circumstances:</p>
          <ul>
            <li><strong>Delivery partners:</strong> Name, phone number, and delivery address shared with couriers to complete your order.</li>
            <li><strong>Payment processors:</strong> Secure services such as SSLCommerz, bKash, or Nagad to handle transactions.</li>
            <li><strong>Analytics tools:</strong> Anonymized usage data shared with tools like Google Analytics.</li>
            <li><strong>Email service providers:</strong> Platforms used to send order confirmation and marketing emails.</li>
            <li><strong>Legal & regulatory bodies:</strong> When required by Bangladeshi law or court order.</li>
          </ul>
          <div class="pp-note"><i class="bi bi-info-circle-fill"></i><span>All third-party partners are contractually required to handle your data with the same level of protection we apply.</span></div>
        </div>
        <div class="pp-card" id="pp-cookies">
          <div class="pp-card-head"><div class="pp-icon"><i class="bi bi-browser-chrome"></i></div><h3>4. Cookies &amp; Tracking Technologies</h3></div>
          <ul>
            <li><strong>Essential cookies:</strong> Required for core functionality such as keeping you logged in and maintaining your cart.</li>
            <li><strong>Preference cookies:</strong> Remember your language, region, and display preferences.</li>
            <li><strong>Analytics cookies:</strong> Help us understand how visitors use our site (e.g., Google Analytics). Data is anonymized.</li>
            <li><strong>Marketing cookies:</strong> Used (only with consent) to deliver relevant advertisements on partner platforms.</li>
          </ul>
        </div>
        <div class="pp-card" id="pp-security">
          <div class="pp-card-head"><div class="pp-icon"><i class="bi bi-shield-lock-fill"></i></div><h3>5. Data Security</h3></div>
          <ul>
            <li><strong>HTTPS/TLS encryption</strong> on all pages to secure data in transit.</li>
            <li><strong>Hashed &amp; salted passwords</strong> — your password is never stored in plain text.</li>
            <li><strong>Restricted access</strong> — only authorized personnel can access personal data.</li>
            <li><strong>Secure payment gateways</strong> — we do not handle or store raw card data on our servers.</li>
          </ul>
          <div class="pp-note"><i class="bi bi-exclamation-triangle-fill"></i><span>No system is 100% secure. If you suspect unauthorized access, please change your password immediately and contact us.</span></div>
        </div>
        <div class="pp-card" id="pp-rights">
          <div class="pp-card-head"><div class="pp-icon"><i class="bi bi-hand-index-thumb-fill"></i></div><h3>6. Your Rights &amp; Choices</h3></div>
          <ul>
            <li><strong>Access:</strong> Request a copy of the personal data we hold about you.</li>
            <li><strong>Correction:</strong> Update or correct inaccurate information via your Account Settings page.</li>
            <li><strong>Deletion:</strong> Request deletion of your account and associated personal data.</li>
            <li><strong>Opt-out of marketing:</strong> Unsubscribe from promotional emails at any time.</li>
            <li><strong>Data portability:</strong> Request your data in a structured, machine-readable format.</li>
          </ul>
          <p class="mt-3 mb-0">To exercise any of these rights, email us at <a href="mailto:privacy@banglabaazar.com" style="color:var(--green,#4caf50);font-weight:600;">privacy@banglabaazar.com</a> or use our <a href="{{ route('contact') }}" style="color:var(--green,#4caf50);font-weight:600;">Contact Page</a>. We will respond within <strong>7 business days</strong>.</p>
        </div>
        <div class="pp-card" id="pp-children">
          <div class="pp-card-head"><div class="pp-icon"><i class="bi bi-emoji-smile-fill"></i></div><h3>7. Children's Privacy</h3></div>
          <p class="mb-0">Our platform is not intended for children under the age of 13. If you are a parent or guardian and believe your child has provided us with personal data, please contact us at <a href="mailto:privacy@banglabaazar.com" style="color:var(--green,#4caf50);font-weight:600;">privacy@banglabaazar.com</a>.</p>
        </div>
        <div class="pp-card" id="pp-changes">
          <div class="pp-card-head"><div class="pp-icon"><i class="bi bi-arrow-repeat"></i></div><h3>8. Changes to This Policy</h3></div>
          <p class="mb-0">We may update this Privacy Policy periodically. When we make material changes, we will update the "Last updated" date and notify registered users via email.</p>
        </div>
        <div class="pp-cta" id="pp-contact">
          <h4><i class="bi bi-envelope-open-fill me-2"></i> Questions About Your Privacy?</h4>
          <p>Our team is here to help. If you have questions about this Privacy Policy, reach out to us — we'll respond within 7 business days.</p>
          <a href="{{ route('contact') }}"><i class="bi bi-chat-dots-fill"></i> Contact Us</a>
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
  <script src="{{ asset('frontend/js/wishlist.js') }}" defer></script>
  <script src="{{ asset('frontend/js/pages.js') }}" defer></script>
@endpush