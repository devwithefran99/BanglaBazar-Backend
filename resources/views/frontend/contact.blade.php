@extends('frontend.layouts.app')

@section('title', 'Contact Us')
@section('meta_description', 'BanglaBazar এর সাথে যোগাযোগ করুন। আমাদের office Chattogram এ। Phone: +8801740604565 | Email: banglabazar247bd@gmail.com')
@section('og_title', 'Contact Us | BanglaBazar24/7')
@section('og_description', 'Get in touch with BanglaBazar. We are here to help you 24/7.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('frontend/css/contact.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
@endpush

@section('content')

{{-- BANNER --}}
<section id="shopBanner">
  <div class="shopBnr"></div>
</section>

{{-- CONTACT FORM --}}
<section class="contact-section">
  <div class="contact-grid">

    {{-- Info Card --}}
    <div class="info-card">
      <div class="info-item">
        <div class="icon-circle"><i class="bi bi-whatsapp"></i></div>
        <div class="info-text">
          +8801740604565
        </div>
      </div>
      <div class="info-divider"></div>
      <div class="info-item">
        <div class="icon-circle"><i class="bi bi-envelope-fill"></i></div>
        <div class="info-text">
          <a href="mailto:banglabazar247bd@gmail.com">banglabazar247bd@gmail.com</a><br>
        </div>
      </div>
      <div class="info-divider"></div>
      <div class="info-item">
        <div class="icon-circle"><i class="bi bi-telephone-fill"></i></div>
        <div class="info-text">
          +8801740604565
        </div>
      </div>
    </div>

    {{-- Form Card --}}
    <div class="form-card">
      <div class="form-title">Just Say <span>Hello!</span></div>
      <div class="form-subtitle">
        Do you fancy saying hi to me or you want to get started with your project and you need my help? Feel free to contact us.
      </div>

      <form action="{{ route('contact.store') }}" method="POST" id="contactForm">
        @csrf
        <div class="form-row">
          <div class="form-group">
            <label>Your Name <span style="color:red">*</span></label>
            <input class="form-input" type="text" name="name" id="fname"
                   placeholder="Your full name" value="{{ old('name') }}">
          </div>
          <div class="form-group">
            <label>Your Email <span style="color:red">*</span></label>
            <input class="form-input" type="email" name="email" id="femail"
                   placeholder="your@email.com" value="{{ old('email') }}">
          </div>
        </div>
        <div class="form-group">
          <label>Subject <span style="color:red">*</span></label>
          <input class="form-input" type="text" name="subject" id="fsubject"
                 placeholder="What's this about?" value="{{ old('subject') }}">
        </div>
        <div class="form-group">
          <label>Message <span style="color:red">*</span></label>
          <textarea class="form-textarea" name="message" id="fmessage"
                    placeholder="Write your message here...">{{ old('message') }}</textarea>
        </div>
        <button class="btn-send" type="submit" id="sendBtn">
          <i class="bi bi-send-fill"></i> Send Message
        </button>
      </form>
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

@endsection

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{ asset('frontend/js/contact.js') }}"></script>
@endpush