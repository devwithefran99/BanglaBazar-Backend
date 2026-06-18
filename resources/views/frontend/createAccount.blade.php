@extends('frontend.layouts.app')

@section('title', 'Create Account')
@section('meta_description', 'BanglaBazar এ নতুন account তৈরি করুন। Fresh groceries order করুন সেরা দামে।')

@push('styles')
  <link rel="stylesheet" href="{{ asset('frontend/css/pages.css') }}">
@endpush

@section('content')

<section>
  <div class="container">
    <div class="row justify-content-center">
      <div id="register-card">

        <div id="register-brand">
           <img src="{{ asset('frontend/image/ourlogo.png') }}" width="120px" alt="BanglaBazar Logo">
        </div>

        <div id="register-heading">
          <h1>Create Account</h1>
          <p>Join us today! Fill in the details below.</p>
        </div>

        <div class="field" id="field-reg-email">
          <label for="reg-email">Email address</label>
          <div class="input-wrap">
            <svg class="icon" viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><polyline points="2,4 12,13 22,4"/></svg>
            <input type="email" id="reg-email" placeholder="you@example.com" autocomplete="email">
          </div>
          <div class="error-msg" id="reg-email-err">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            Please enter a valid email address.
          </div>
        </div>

        <div class="field" id="field-reg-pw">
          <label for="reg-password">Password</label>
          <div class="input-wrap">
            <svg class="icon" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            <input type="password" id="reg-password" placeholder="Create a password" autocomplete="new-password">
            <button id="toggle-reg-pw" type="button" aria-label="Toggle password visibility">
              <svg id="eye-icon-pw" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
          </div>
          <div class="error-msg" id="reg-pw-err">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            Password must be at least 6 characters.
          </div>
        </div>

        <div class="field" id="field-reg-cpw">
          <label for="reg-confirm-password">Confirm Password</label>
          <div class="input-wrap">
            <svg class="icon" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            <input type="password" id="reg-confirm-password" placeholder="Re-enter your password" autocomplete="new-password">
            <button id="toggle-reg-cpw" type="button" aria-label="Toggle confirm password visibility">
              <svg id="eye-icon-cpw" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
          </div>
          <div class="error-msg" id="reg-cpw-err">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            Passwords do not match.
          </div>
        </div>

        <label id="register-terms-row">
          <input type="checkbox" id="reg-terms">
          <span>Accept all <a href="{{ route('terms') }}">terms &amp; Conditions</a></span>
        </label>
        <div class="error-msg" id="register-terms-err">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          Please accept the terms &amp; conditions.
        </div>

        <button id="register-btn">Create Account</button>

        <p id="register-login-row">Already have account? <a href="{{ route('signin') }}">Login</a></p>

      </div>
      <div id="register-toast"></div>
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
  <script>
    const REGISTER_URL = "{{ route('register.post') }}";
    const CSRF_TOKEN   = "{{ csrf_token() }}";
  </script>
  <script src="{{ asset('frontend/js/signPages.js') }}" ></script>
@endpush