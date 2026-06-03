@extends('frontend.layouts.app')

@section('title', 'About Us')
@section('meta_description', 'BanglaBazar সম্পর্কে জানুন — আমরা Chattogram এর একটি trusted organic grocery store। Fresh vegetables, fish, meat সরাসরি আপনার দরজায়।')
@section('og_title', 'About Us | BanglaBazar24/7')
@section('og_description', '100% trusted organic food store based in Chattogram, Bangladesh.')

@push('styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
  <link rel="stylesheet" href="{{ asset('frontend/css/about.css') }}">
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
            <p class="about-eyebrow">Our Story</p>
            <h2 class="about-title">100% Trusted<br/><span>Organic</span> Food Store</h2>
            <p class="about-body">
              Morbi porttitor ligula in nunc varius sagittis. Proin dui nisi, laoreet ut tempor ac, cursus vitae eros. Cras quis ultricies elit. Proin ac lectus arcu. Maecenas aliquet vel tellus at accumsan. Donec a eros non massa vulputate ornare. Vivamus ornare commodo ante, at commodo felis congue vitae.
            </p>
            <a href="{{ route('contact') }}" class="about-cta">Learn More</a>
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
            <h2 class="about-title">We Delivered, You <br><span>Enjoy Your Order.</span></h2>
            <p class="about-desc">
              Pellentesque a ante vulputate leo porttitor luctus sed eget eros. Nulla et rhoncus neque. Duis non diam eget est luctus tincidunt a a mi. Nulla eu eros consequat tortor tincidunt feugiat.
            </p>
            <div class="features-grid">
              <div class="feature-card">
                <div class="feature-icon"><img src="{{ asset('frontend/gif/organic.gif') }}" alt=""></div>
                <div class="feature-text"><h6>100% Organic Food</h6><p>100% healthy &amp; fresh food.</p></div>
              </div>
              <div class="feature-card">
                <div class="feature-icon"><img src="{{ asset('frontend/gif/support.gif') }}" alt=""></div>
                <div class="feature-text"><h6>Great Support 24/7</h6><p>Instant access to contact.</p></div>
              </div>
              <div class="feature-card">
                <div class="feature-icon"><img src="{{ asset('frontend/gif/rating.gif') }}" alt=""></div>
                <div class="feature-text"><h6>Customer Feedback</h6><p>Our happy customers.</p></div>
              </div>
              <div class="feature-card">
                <div class="feature-icon"><img src="{{ asset('frontend/gif/credit-card.gif') }}" alt=""></div>
                <div class="feature-text"><h6>100% Secure Payment</h6><p>We ensure your money is safe.</p></div>
              </div>
              <div class="feature-card">
                <div class="feature-icon"><img src="{{ asset('frontend/gif/transport.gif') }}" alt=""></div>
                <div class="feature-text"><h6>Free Shipping</h6><p>Free shipping with discount.</p></div>
              </div>
              <div class="feature-card">
                <div class="feature-icon"><img src="{{ asset('frontend/gif/best-price.gif') }}" alt=""></div>
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
        <span class="wcu-tag">Why Choose Us</span>
        <h2 class="wcu-title mx-auto" style="max-width:620px">
          Nature's Best, Delivered<br><span>Fresh To Your Door</span>
        </h2>
        <p class="wcu-sub mx-auto">
          We source directly from certified organic farms — no middlemen, no chemicals, just pure goodness picked at peak freshness and delivered within 24 hours.
        </p>
      </div>
      <div class="stats-row">
        <div class="stat-card">
          <div class="stat-icon"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg></div>
          <div class="stat-num"><span class="counter" data-target="25000">0</span><span class="plus">+</span></div>
          <div class="stat-label">Happy Customers</div>
        </div>
        <div class="stat-card">
          <div class="stat-icon"><svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></div>
          <div class="stat-num"><span class="counter" data-target="150">0</span><span class="plus">+</span></div>
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

  {{-- OUR TEAM --}}
  <section class="team-section">
    <div class="container">
      <div class="text-center mb-2">
        <span class="team-tag">Meet The People</span>
        <h2 class="team-title">Our Awesome <span>Team</span></h2>
        <p class="team-desc">Pellentesque a ante vulputate leo porttitor luctus sed eget eros.</p>
      </div>
      <div class="team-carousel-wrap">
        <div class="owl-carousel owl-theme" id="teamCarousel">
          @php
          $team = [
            ['name'=>'Marcus Holloway','role'=>'CEO Founder','img'=>'https://images.unsplash.com/photo-1607990281513-2c110a25bd8c?w=500&q=80'],
            ['name'=>'Priya Nair','role'=>'Head of Operations','img'=>'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=500&q=80'],
            ['name'=>'Daniel Osei','role'=>'Senior Manager','img'=>'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=500&q=80'],
            ['name'=>'Layla Benali','role'=>'Quality Lead','img'=>'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=500&q=80'],
            ['name'=>'Ethan Caldwell','role'=>'Logistics Head','img'=>'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=500&q=80'],
            ['name'=>'Sofia Marchetti','role'=>'Marketing Director','img'=>'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=500&q=80'],
          ];
          @endphp
          @foreach($team as $member)
          <div class="team-card">
            <div class="team-img-box">
              <img src="{{ $member['img'] }}" alt="{{ $member['name'] }}"/>
              <div class="team-social">
                <a href="#" aria-label="Facebook"><svg viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg></a>
                <a href="#" aria-label="Instagram"><svg viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg></a>
                <a href="#" aria-label="LinkedIn"><svg viewBox="0 0 24 24"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg></a>
              </div>
            </div>
            <div class="team-info">
              <div class="team-name">{{ $member['name'] }}</div>
              <div class="team-role">{{ $member['role'] }}</div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </section>

  {{-- CLIENT TESTIMONIALS --}}
  <section id="feedback" class="py-2">
    <div class="container">
      <h2 class="section-title text-start">Client Testimonials</h2>
      <div class="owl-carousel testimonial-slider">
        @php
        $testimonials = [
          ['name'=>'Robert Fox','role'=>'Customer','img'=>'clients (1).png','text'=>'Pellentesque eu nibh eget mauris congue mattis mattis nec tellus. Phasellus imperdiet elit eu magna dictum.'],
          ['name'=>'Dianne Russell','role'=>'Customer','img'=>'clients (2).png','text'=>'Pellentesque eu nibh eget mauris congue mattis mattis nec tellus. Phasellus imperdiet elit eu magna dictum.'],
          ['name'=>'Eleanor Pena','role'=>'Customer','img'=>'clients (3).png','text'=>'Pellentesque eu nibh eget mauris congue mattis mattis nec tellus. Phasellus imperdiet elit eu magna dictum.'],
          ['name'=>'Jenny Wilson','role'=>'Customer','img'=>'bigApple.png','text'=>'Pellentesque eu nibh eget mauris congue mattis mattis nec tellus. Phasellus imperdiet elit eu magna dictum.'],
        ];
        @endphp
        @foreach($testimonials as $t)
        <div class="testimonial-card">
          <div class="quote">"</div>
          <p class="testimonial-text">{{ $t['text'] }}</p>
          <div class="client-info">
            <div class="client-left">
              <img src="{{ asset('frontend/image/'.$t['img']) }}" class="client-img">
              <div>
                <p class="client-name">{{ $t['name'] }}</p>
                <p class="client-role">{{ $t['role'] }}</p>
              </div>
            </div>
            <div class="stars">★★★★★</div>
          </div>
        </div>
        @endforeach
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" defer></script>
  <script src="{{ asset('frontend/js/about.js') }} " defer></script>
@endpush