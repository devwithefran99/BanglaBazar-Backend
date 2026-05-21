<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="wishlist-url" content="{{ route('wishlist.toggle') }}">
    <title>Checkout | BanglaBazar</title>
     <link rel="icon" type="image/png" href="{{ asset('frontend/image/favIcon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('frontend/css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/pages.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
</head>
<body>

{{-- preloader --}}
<div id="preloader">
  <div class="loader">
    <img src="{{ asset('frontend/image/favIcon.png') }}"  width="80px" alt="logo">
    <p class="mt-5">Loading...</p>
  </div>
</div>


{{-- header --}}
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
                        <a class="nav-link" href="{{ route('about') }}">
                            <i class="bi bi-info-circle me-1"></i> About Us
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">
                            <i class="bi bi-telephone me-1"></i> Contact Us
                        </a>
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

{{-- ── MAIN ── --}}
<main>
<section class="bl-section">
    <div class="container">

        {{-- Success / Error messages --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Empty cart redirect --}}
        @if($items->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-bag-x" style="font-size:3rem;color:#94a3b8;"></i>
                <p class="mt-3 text-muted">No items to checkout.</p>
                <a href="{{ route('shop') }}" class="btn btn-success mt-2">Browse Products</a>
            </div>
        @else

        <div class="bl-page-title bl-anim-1">Checkout</div>
        <div class="bl-page-sub bl-anim-1">Complete your order below</div>

        {{-- ✅ items JSON — form submit এ পাঠানোর জন্য --}}
        @php
            $itemsJson = $items->map(fn($i) => [
                'product_id'   => $i['product']->id,
                'product_type' => $i['product_type'],
                'product_name' => $i['product']->name,
                'quantity'     => $i['quantity'],
                'price'        => $i['price'],
            ])->values()->toJson();
        @endphp

        <form action="{{ route('checkout.place') }}" method="POST" id="checkoutForm">
        @csrf
        <input type="hidden" name="source"  value="{{ $source }}">
        <input type="hidden" name="items"   value="{{ $itemsJson }}">
        <input type="hidden" name="payment" id="paymentInput" value="cod">

        <div class="row g-4">

            {{-- ── LEFT: Billing Form ── --}}
            <div class="col-12 col-lg-7 bill">
                <div class="bl-card bl-anim-2">
                    <div class="bl-card-title">
                        <i class="bi bi-person-lines-fill"></i>
                        Billing Information
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="bl-form-group">
                                <label class="bl-label">First name <span>*</span></label>
                                <input type="text" name="first_name" class="bl-input"
                                       placeholder="Your first name"
                                       value="{{ old('first_name', Auth::user()->name ?? '') }}"
                                       required>
                                @error('first_name')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bl-form-group">
                                <label class="bl-label">Last name <span>*</span></label>
                                <input type="text" name="last_name" class="bl-input"
                                       placeholder="Your last name"
                                       value="{{ old('last_name') }}"
                                       required>
                                @error('last_name')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="bl-form-group">
                                <label class="bl-label">Company Name <span style="color:var(--text-muted);font-weight:500">(optional)</span></label>
                                <input type="text" name="company" class="bl-input" placeholder="Company name">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="bl-form-group">
                                <label class="bl-label">Street Address <span>*</span></label>
                                <input type="text" name="address" class="bl-input"
                                       placeholder="House number and street name"
                                       value="{{ old('address') }}"
                                       required>
                                @error('address')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="bl-form-group">
                                <label class="bl-label">Country / Region <span>*</span></label>
                                <select name="country" class="bl-select" required>
                                    <option value="">Select</option>
                                    <option value="Bangladesh" {{ old('country') == 'Bangladesh' ? 'selected' : '' }}>Bangladesh</option>
                                    <option value="United States">United States</option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="Canada">Canada</option>
                                    <option value="Australia">Australia</option>
                                </select>
                                @error('country')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="bl-form-group">
                                <label class="bl-label">State <span>*</span></label>
                                <select name="state" class="bl-select" required>
                                    <option value="">Select</option>
                                    <option value="Chittagong" {{ old('state') == 'Chittagong' ? 'selected' : '' }}>Chittagong</option>
                                    <option value="Dhaka">Dhaka</option>
                                    <option value="Rajshahi">Rajshahi</option>
                                    <option value="Sylhet">Sylhet</option>
                                    <option value="Khulna">Khulna</option>
                                    <option value="Barisal">Barisal</option>
                                    <option value="Mymensingh">Mymensingh</option>
                                    <option value="Rangpur">Rangpur</option>
                                </select>
                                @error('state')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="bl-form-group">
                                <label class="bl-label">Zip Code <span>*</span></label>
                                <input type="text" name="zip" class="bl-input"
                                       placeholder="Zip Code"
                                       value="{{ old('zip') }}"
                                       required>
                                @error('zip')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="bl-form-group">
                                <label class="bl-label">Email <span>*</span></label>
                                <input type="email" name="email" class="bl-input"
                                       placeholder="Email address"
                                       value="{{ old('email', Auth::user()->email ?? '') }}"
                                       required>
                                @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="bl-form-group">
                                <label class="bl-label">Phone <span>*</span></label>
                                <input type="tel" name="phone" class="bl-input"
                                       placeholder="Phone number"
                                       value="{{ old('phone') }}"
                                       required>
                                @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="bl-check-row">
                                <input type="checkbox" id="blShipDiff">
                                <label for="blShipDiff">Ship to a different address</label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Additional Info --}}
                <div class="bl-card bl-anim-3">
                    <div class="bl-card-title">
                        <i class="bi bi-chat-left-text"></i>
                        Additional Info
                    </div>
                    <div class="bl-form-group">
                        <label class="bl-label">Order Notes <span style="color:var(--text-muted);font-weight:500">(Optional)</span></label>
                        <textarea name="notes" class="bl-textarea"
                                  placeholder="Notes about your order, e.g. special notes for delivery"></textarea>
                    </div>
                </div>
            </div>

            {{-- ── RIGHT: Order Summary ── --}}
            <div class="col-12 col-lg-5">
                <div class="bl-summary-card bl-anim-4">
                    <div class="bl-card-title" style="margin-bottom:1rem;">
                        <i class="bi bi-bag-check"></i>
                        Order Summary
                        <span style="font-size:12px;color:#94a3b8;margin-left:8px;">
                            ({{ $items->count() }} item{{ $items->count() > 1 ? 's' : '' }})
                        </span>
                    </div>

                    {{-- ✅ Dynamic items --}}
                    @foreach($items as $item)
                    <div class="bl-order-item">
                        <div class="bl-item-img">
                            @if($item['product']->image)
                                <img src="{{ asset('storage/' . $item['product']->image) }}"
                                     alt="{{ $item['product']->name }}"
                                     style="width:48px;height:48px;object-fit:cover;border-radius:8px;"
                                     onerror="this.src='{{ asset('frontend/image/Product Image.png') }}'">
                            @else
                                <img src="{{ asset('frontend/image/Product Image.png') }}"
                                     style="width:48px;height:48px;object-fit:cover;border-radius:8px;">
                            @endif
                        </div>
                        <div class="bl-item-info">
                            <div class="bl-item-name">{{ $item['product']->name }}</div>
                            <div class="bl-item-qty">
                                x{{ $item['quantity'] }}
                                @if($item['product_type'] === 'hotdeal')
                                    <span style="font-size:10px;color:#ef4444;margin-left:4px;">🔥 Hot Deal</span>
                                @endif
                            </div>
                        </div>
                        <div class="bl-item-price">
                            ৳{{ number_format($item['subtotal'], 2) }}
                        </div>
                    </div>
                    @endforeach

                    {{-- COUPON BOX --}}
<div class="mb-3">
  <div class="d-flex gap-2">
    <input type="text" id="couponInput"
           class="form-control"
           placeholder="Coupon code লিখুন..."
           style="text-transform:uppercase;">
    <button type="button" onclick="applyCoupon()"
            class="btn btn-outline-success"
            style="white-space:nowrap;">
      Apply
    </button>
  </div>
  <div id="couponMsg" class="mt-2 small"></div>
</div>

{{-- Hidden inputs --}}
<input type="hidden" name="coupon_code"     id="couponCode" value="">
<input type="hidden" name="coupon_discount" id="couponDiscount" value="0">

{{-- Totals --}}
<div class="bl-totals">
  <div class="bl-total-row">
    <span class="label">Subtotal</span>
    <span class="val">৳{{ number_format($total, 2) }}</span>
  </div>
  {{-- Discount row (hidden by default) --}}
  <div class="bl-total-row" id="discountRow" style="display:none;">
    <span class="label text-success">Discount</span>
    <span class="val text-success" id="discountVal">-৳0.00</span>
  </div>
  <div class="bl-total-row">
    <span class="label">Shipping</span>
    <span class="val bl-free">Free</span>
  </div>
  <div class="bl-total-row grand">
    <span class="label">Total</span>
    <span class="val" id="grandTotal">৳{{ number_format($total, 2) }}</span>
  </div>
</div>

                    {{-- Totals --}}
                    <div class="bl-totals">
                        <div class="bl-total-row">
                            <span class="label">Subtotal</span>
                            <span class="val">৳{{ number_format($total, 2) }}</span>
                        </div>
                        <div class="bl-total-row">
                            <span class="label">Shipping</span>
                            <span class="val bl-free">Free</span>
                        </div>
                        <div class="bl-total-row grand">
                            <span class="label">Total</span>
                            <span class="val">৳{{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    {{-- Payment Method --}}
                    <div class="bl-payment-title">Payment Method</div>
                    <div class="bl-radio-group" id="blPayGroup">
                        <label class="bl-radio-option selected" onclick="selectPayment(this, 'cod')">
                            <input type="radio" name="payment_display" value="cod" checked>
                            <span class="bl-radio-label">
                                <i class="bi bi-truck"></i> Cash on Delivery
                            </span>
                        </label>
                        <label class="bl-radio-option" onclick="selectPayment(this, 'bkash')">
                            <input type="radio" name="payment_display" value="bkash">
                            <span class="bl-radio-label">
                                <i class="bi bi-phone"></i> bKash
                            </span>
                        </label>
                        <label class="bl-radio-option" onclick="selectPayment(this, 'nagad')">
                            <input type="radio" name="payment_display" value="nagad">
                            <span class="bl-radio-label">
                                <i class="bi bi-wallet2"></i> Nagad
                            </span>
                        </label>
                    </div>

                    <button type="submit" class="bl-place-order">
                        <i class="bi bi-bag-check-fill"></i> Place Order
                    </button>
                    <div class="bl-secure-note">
                        <i class="bi bi-shield-lock-fill"></i>
                        100% Secure &amp; Encrypted Checkout
                    </div>

                </div>
            </div>

        </div>
        </form>

        @endif

    </div>
</section>
</main>

{{-- Cart Drawer --}}
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
        <a href="{{ route('checkout.show') }}" class="cp-checkout-btn">
            <i class="bi bi-bag-check-fill me-1"></i> Checkout
        </a>
    </div>
</div>

{{-- Footer --}}
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
                    <li><a href="#">Shopping Cart</a></li>
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
                <div class="col-12 mySign">
                    <p>BanglaBazar24/7 eCommerce © 2026. All Rights Reserved
                        <span>Powered By <a href="https://github.com/devwithefran99">devwithErfan</a></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('frontend/js/common.js') }}"></script>
<script src="{{ asset('frontend/js/wishlist.js') }}"></script>
<script src="{{ asset('frontend/js/pages.js') }}"></script>

<script>
/* ── Payment method select ── */
function selectPayment(label, value) {
    document.querySelectorAll('.bl-radio-option').forEach(l => l.classList.remove('selected'));
    label.classList.add('selected');
    document.getElementById('paymentInput').value = value;
}

// Coupon Apply
const originalTotal = {{ $total }};

function applyCoupon() {
  const code = document.getElementById('couponInput').value.trim();
  const msgEl = document.getElementById('couponMsg');

  if (!code) {
    msgEl.innerHTML = '<span class="text-danger">Coupon code দিন।</span>';
    return;
  }

  fetch('{{ route('coupon.apply') }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
    },
    body: JSON.stringify({ code: code, total: originalTotal }),
  })
  .then(r => r.json())
  .then(data => {
    if (data.valid) {
      msgEl.innerHTML = '<span class="text-success">' + data.message + '</span>';

      // Discount row দেখাও
      document.getElementById('discountRow').style.display = 'flex';
      document.getElementById('discountVal').textContent = '-৳' + data.discount.toFixed(2);
      document.getElementById('grandTotal').textContent  = '৳' + data.newTotal.toFixed(2);

      // Hidden inputs set করো
      document.getElementById('couponCode').value     = code;
      document.getElementById('couponDiscount').value = data.discount;

    } else {
      msgEl.innerHTML = '<span class="text-danger">' + data.message + '</span>';
      resetCoupon();
    }
  })
  .catch(() => {
    msgEl.innerHTML = '<span class="text-danger">Something went wrong!</span>';
  });
}

function resetCoupon() {
  document.getElementById('discountRow').style.display = 'none';
  document.getElementById('grandTotal').textContent = '৳' + originalTotal.toFixed(2);
  document.getElementById('couponCode').value     = '';
  document.getElementById('couponDiscount').value = '0';
}
</script>

</body>
</html>