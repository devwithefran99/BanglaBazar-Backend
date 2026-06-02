@extends('frontend.layouts.app')

@section('title', 'FAQ')
@section('meta_description', 'BanglaBazar সম্পর্কে সাধারণ প্রশ্নের উত্তর। Delivery, payment, return সম্পর্কে জানুন।')

@push('styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('frontend/css/pages.css') }}">
@endpush

@section('content')

<main>
  <section class="faq-section">
    <div class="container">
      <div class="row align-items-center g-5">

        <div class="col-lg-6">
          <h2 class="section-title">
            Welcome, Let's Talk <br>About Our <span style="color:var(--green);">BanglaBazar</span>
          </h2>
          <div class="accordion" id="ecobazarFAQ">
            <div class="faq-card">
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="true">
                    In elementum est a ante sodales iaculis.
                  </button>
                </h2>
                <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#ecobazarFAQ">
                  <div class="faq-answer">Morbi porttitor ligula in nunc varius sagittis. Proin dui nisl, laoreet ut tempor ac, cursus vitae eros. Cras quis ultrices elit. Praesent lectus arcu. Maecenas aliquet vel tellus at accumsan.</div>
                </div>
              </div>
            </div>
            <div class="faq-card">
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                    Etiam lobortis massa eu nibh tempor elementum.
                  </button>
                </h2>
                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#ecobazarFAQ">
                  <div class="faq-answer">Vivamus ornare commodo ante, at commodo felis congue vitae. Integer tincidunt eros id tempor accumsan. Sed vel lectus ut odio tincidunt ultricies.</div>
                </div>
              </div>
            </div>
            <div class="faq-card">
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                    In elementum est a ante sodales iaculis.
                  </button>
                </h2>
                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#ecobazarFAQ">
                  <div class="faq-answer">Nulla tincidunt eros id tempor accumsan. Phasellus efficitur, augue in ultricies feugiat, lorem metus volutpat metus, eget aliquet lacus lacus at nisi.</div>
                </div>
              </div>
            </div>
            <div class="faq-card">
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                    Aenean quis quam nec lacus semper dignissim.
                  </button>
                </h2>
                <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#ecobazarFAQ">
                  <div class="faq-answer">Suspendisse potenti. Sed in arcu ut augue tincidunt fermentum. Donec euismod, nisl eget feugiat consectetur, purus nunc tincidunt metus.</div>
                </div>
              </div>
            </div>
            <div class="faq-card">
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                    Nulla tincidunt eros id tempor accumsan.
                  </button>
                </h2>
                <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#ecobazarFAQ">
                  <div class="faq-answer">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <img src="{{ asset('frontend/image/faqs.png') }}" alt="FAQ illustration">
        </div>

      </div>
    </div>
  </section>
</main>

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
  <script src="{{ asset('frontend/js/pages.js') }}"></script>
@endpush