@extends('frontend.layouts.app')

@section('title', 'Sign In')
@section('meta_description', 'BanglaBazar এ sign in করুন। আপনার orders, wishlist এবং account manage করুন।')

@push('styles')
  <link rel="stylesheet" href="{{ asset('frontend/css/pages.css') }}">
@endpush

@section('content')

<section>
  <div class="container">
    <div class="row justify-content-center">
      <div class="card">

        <div class="brand">
          <img src="{{ asset('frontend/image/Logo.png') }}" alt="BanglaBazar">
        </div>

        <div class="heading">
          <h1>Sign In</h1>
          <p>Welcome back! Please enter your details.</p>
        </div>

        @if(session('error'))
          <div class="alert alert-danger mb-3">{{ session('error') }}</div>
        @endif

        <div class="field" id="field-email">
          <label for="email">Email address</label>
          <div class="input-wrap">
            <svg class="icon" viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><polyline points="2,4 12,13 22,4"/></svg>
            <input type="email" id="email" placeholder="you@example.com" autocomplete="email">
          </div>
          <div class="error-msg" id="email-err">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            Please enter a valid email address.
          </div>
        </div>

        <div class="field" id="field-pw">
          <label for="password">Password</label>
          <div class="input-wrap">
            <svg class="icon" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            <input type="password" id="password" placeholder="Enter your password" autocomplete="current-password">
            <button class="eye-btn" id="toggle-pw" type="button" aria-label="Toggle password visibility">
              <svg id="eye-icon" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
          </div>
          <div class="error-msg" id="pw-err">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            Password must be at least 6 characters.
          </div>
        </div>

        <div class="options-row">
          <label class="checkbox-label">
            <input type="checkbox" id="remember">
            <span>Remember me</span>
          </label>
          <a href="{{ route('password.request') }}" class="forgot-link">Forget Password</a>
        </div>

        <button class="btn-login" id="login-btn">Login</button>

        <div class="divider"><hr><span>or continue with</span><hr></div>

        <div class="social-row">
          <button class="social-btn" id="google-btn">
            <svg viewBox="0 0 24 24" fill="none">
              <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
              <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
              <path d="M5.84 14.1c-.22-.66-.35-1.36-.35-2.1s.13-1.44.35-2.1V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.83z" fill="#FBBC05"/>
              <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.83C6.71 7.31 9.14 5.38 12 5.38z" fill="#EA4335"/>
            </svg>
            <span class="label">Google</span>
          </button>
          <button class="social-btn" id="fb-btn">
            <svg viewBox="0 0 24 24"><path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047V9.413c0-3.025 1.791-4.697 4.533-4.697 1.312 0 2.686.235 2.686.235v2.97h-1.513c-1.491 0-1.956.93-1.956 1.886v2.267h3.328l-.532 3.49h-2.796V24C19.612 23.094 24 18.1 24 12.073z" fill="#1877F2"/></svg>
            <span class="label">Facebook</span>
          </button>
          <button class="social-btn" id="apple-btn">
            <svg viewBox="0 0 24 24" fill="#1c1c1c"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/></svg>
            <span class="label">Apple</span>
          </button>
        </div>

        <p class="register-row">Don't have an account? <a href="{{ route('register') }}">Register</a></p>

      </div>
      <div class="toast" id="toast"></div>
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
  <script>
    const SIGNIN_URL = "{{ route('signin.post') }}";
    const CSRF_TOKEN = "{{ csrf_token() }}";
  </script>
  <script src="{{ asset('frontend/js/signPages.js') }}" ></script>
@endpush