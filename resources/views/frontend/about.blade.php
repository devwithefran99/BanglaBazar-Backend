@extends('frontend.layouts.app')

@section('title', 'About Us')
@section('meta_description', 'BanglaBazar সম্পর্কে জানুন — আমরা Chattogram এর একটি trusted organic grocery store। Fresh vegetables, fish, meat সরাসরি আপনার দরজায়।')
@section('og_title', 'About Us | BanglaBazar24/7')
@section('og_description', '100% trusted organic food store based in Chattogram, Bangladesh.')

@push('styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
  <link rel="stylesheet" href="{{ asset('frontend/css/about.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
@endpush

@section('content')

{{-- BANNER --}}
<section id="shopBanner">
  <div class="shopBnr"></div>
</section>

<main>

  {{-- TRUSTED SECTION --}}
  <section class="about-section">
    <div class="container">
      <div class="about-row-wrapper">
        <div class="row g-0 flex-column-reverse flex-md-row">
         <div class="col-md-6 about-text-col">
    <p class="about-eyebrow">আমাদের গল্প</p>

    <h4 class="about-title">
        ১০০% বিশ্বস্ত<br/>
        <span>প্রাকৃতিক ও নিরাপদ</span> খাদ্যের বিশ্বস্ত ঠিকানা
    </h4>

    <p class="about-body">
        বাংলাবাজার ২৪/৭-এ আমরা বিশ্বাস করি বিশুদ্ধ ও নিরাপদ খাদ্যই সুস্থ জীবনের ভিত্তি।
        বাংলাদেশের বিভিন্ন অঞ্চল থেকে বাছাইকৃত মানসম্মত পণ্য সংগ্রহ করে আমরা
        সরাসরি আপনার কাছে পৌঁছে দিই। সততা, গুণগত মান এবং গ্রাহক সন্তুষ্টিকে
        সর্বোচ্চ গুরুত্ব দিয়ে আমরা প্রতিদিন কাজ করে যাচ্ছি, যাতে আপনার পরিবার
        পায় নিরাপদ ও নির্ভরযোগ্য খাদ্যসামগ্রী।
    </p>

    <a href="{{ route('contact') }}" class="about-cta">আরও জানুন</a>
</div>
          <div class="col-md-6 about-img-col">
            <img class="slide-img active" src="https://images.unsplash.com/photo-1540420773420-3366772f4999?w=900&q=80" alt="Fresh vegetables from the farm"/>
            <img class="slide-img" src="{{ asset('frontend/image/trusted1.png') }}" alt="Organic farmer in the field"/>
            <img class="slide-img" src="https://images.unsplash.com/photo-1506484381205-f7945653044d?w=900&q=80" alt="Healthy organic produce"/>
            <div class="slide-dots">
              <div class="dot active" onclick="goTo(0)"></div>
              <div class="dot" onclick="goTo(1)"></div>
              <div class="dot" onclick="goTo(2)"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- SHOP NOW CTA --}}
  <section id="shopNow">
    <div class="container">
      <div class="cta-row">
        <div class="cta-text">
    <h3>আজই বেছে নিন নিরাপদ ও বিশুদ্ধ খাবার</h3>
    <p>৭১২+ সন্তুষ্ট পরিবারের বিশ্বস্ত পছন্দ বাংলাবাজার ২৪/৭।</p>
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

  {{-- ABOUT CONTENT --}}
  <section class="about-section">
    <div class="container">
      <div class="row align-items-center g-5">
        <div class="col-lg-6">
          <div class="about-img-wrap">
            <img src="{{ asset('frontend/image/about1.png') }}" alt="Farmer with fresh organic vegetables"/>
            <span class="img-badge">100% Organic &amp; Natural</span>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="about-content">
            <span class="section-tag">about</span>
            <h2 class="about-title">
    আমরা পৌঁছে দিই,<br>
    আপনি উপভোগ করুন <span><br>বিশুদ্ধ খাদ্য</span>। 
</h2>

<p class="about-desc">
    বাংলাবাজার ২৪/৭ আপনার জন্য দেশের বিভিন্ন অঞ্চল থেকে সংগ্রহ করা
    নিরাপদ, মানসম্মত ও তাজা খাদ্যপণ্য সরাসরি ঘরে পৌঁছে দেয়।
    আমাদের লক্ষ্য হলো বিশ্বস্ত সেবা, সঠিক মান এবং আপনার পরিবারের
    সুস্থ জীবন নিশ্চিত করা।
</p>
           <div class="features-grid">
  <div class="feature-card">
    <div class="feature-icon"><i class="bi bi-flower1" style="font-size:28px; color:#198754;"></i></div>
    <div class="feature-text"><h6>100% Organic Food</h6><p>100% healthy &amp; fresh food.</p></div>
  </div>
  <div class="feature-card">
    <div class="feature-icon"><i class="bi bi-headset" style="font-size:28px; color:#0d6efd;"></i></div>
    <div class="feature-text"><h6>Great Support 24/7</h6><p>Instant access to contact.</p></div>
  </div>
  <div class="feature-card">
    <div class="feature-icon"><i class="bi bi-star-fill" style="font-size:28px; color:#ffc107;"></i></div>
    <div class="feature-text"><h6>Customer Feedback</h6><p>Our happy customers.</p></div>
  </div>
  <div class="feature-card">
    <div class="feature-icon"><i class="bi bi-shield-lock-fill" style="font-size:28px; color:#6f42c1;"></i></div>
    <div class="feature-text"><h6>100% Secure Payment</h6><p>We ensure your money is safe.</p></div>
  </div>
  <div class="feature-card">
    <div class="feature-icon"><i class="bi bi-truck" style="font-size:28px; color:#fd7e14;"></i></div>
    <div class="feature-text"><h6>Free Shipping</h6><p>Free shipping with discount.</p></div>
  </div>
  <div class="feature-card">
    <div class="feature-icon"><i class="bi bi-tags-fill" style="font-size:28px; color:#dc3545;"></i></div>
    <div class="feature-text"><h6>Best Deal</h6><p>100% healthy &amp; fresh food.</p></div>
  </div>
</div>
            <a href="{{ route('contact') }}" class="btn-about">
              Discover More
              <svg viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- WHY CHOOSE US --}}
  <section class="wcu-section">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="container position-relative">
      <div class="text-center mb-2">
    <span class="wcu-tag">কেন বাংলাবাজার ২৪/৭</span>

    <h4 class="wcu-title mx-auto" style="max-width:620px">
        বাংলার ঐতিহ্যবাহী খাদ্য,<br>
        <span>বিশ্বাসের সাথে আপনার ঘরে</span>
    </h4>

    <p class="wcu-sub mx-auto">
        দেশের বিভিন্ন প্রান্তের খাঁটি ও নিরাপদ খাদ্যপণ্য এক প্ল্যাটফর্মে এনে
        আমরা সহজে আপনার কাছে পৌঁছে দিই। গুণগত মান, সততা এবং গ্রাহক সন্তুষ্টিই
        আমাদের প্রধান অঙ্গীকার।
    </p>
</div>
      <div class="stats-row">
        <div class="stat-card">
          <div class="stat-icon"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg></div>
          <div class="stat-num"><span class="counter" data-target="1367">0</span><span class="plus">+</span></div>
          <div class="stat-label">Happy Customers</div>
        </div>
        <div class="stat-card">
          <div class="stat-icon"><svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></div>
          <div class="stat-num"><span class="counter" data-target="23">0</span><span class="plus">+</span></div>
          <div class="stat-label">Partner Farms</div>
        </div>
        <div class="stat-card">
          <div class="stat-icon"><svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg></div>
          <div class="stat-num"><span class="counter" data-target="98">0</span><span class="plus">%</span></div>
          <div class="stat-label">On-Time Delivery</div>
        </div>
        <div class="stat-card">
          <div class="stat-icon"><svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
          <div class="stat-num"><span class="counter" data-target="100">0</span><span class="plus">%</span></div>
          <div class="stat-label">Certified Organic</div>
        </div>
      </div>
      <div class="features-row">
        <div class="feat-card">
          <div class="feat-num">01</div>
          <div class="feat-icon-wrap"><svg viewBox="0 0 24 24"><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 5.477 10 10-4.477 10-10 10z"/><path d="M8 12l3 3 5-5"/></svg></div>
          <div class="feat-title">Farm-to-Table Freshness</div>
          <div class="feat-desc">Directly sourced from our certified organic partner farms. Every product arrives within 24 hours of harvest.</div>
        </div>
        <div class="feat-card">
          <div class="feat-num">02</div>
          <div class="feat-icon-wrap"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg></div>
          <div class="feat-title">Same-Day Delivery</div>
          <div class="feat-desc">Order before 12PM and get your fresh organic produce delivered same day with real-time tracking.</div>
        </div>
        <div class="feat-card">
          <div class="feat-num">03</div>
          <div class="feat-icon-wrap"><svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg></div>
          <div class="feat-title">Eco Packaging</div>
          <div class="feat-desc">100% biodegradable packaging made from recycled materials with carbon-neutral delivery.</div>
        </div>
      </div>
    </div>
  </section>

  
 

  {{-- CART DRAWER --}}
  <div class="cp-overlay" id="cpOverlay"></div>
  <div class="cp-drawer" id="cpDrawer">
    <div class="cp-header">
      <div class="cp-title"><img src=" {{ asset('frontend/image/ourlogo.png') }}" alt=""></div>
      <button class="cp-close" id="cpClose"><i class="bi bi-x-lg"></i></button>
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
      <a href="{{ route('checkout.show') }}" class="cp-checkout-btn">
        <i class="bi bi-bag-check-fill me-1"></i> Checkout
      </a>
    </div>
  </div>

</main>

@endsection

@push('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <script src="{{ asset('frontend/js/about.js') }} "></script>
@endpush