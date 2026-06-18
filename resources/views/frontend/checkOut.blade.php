@extends('frontend.layouts.app')

@section('title', 'Checkout')
@section('meta_description', 'BanglaBazar checkout — আপনার order complete করুন। Secure payment with Cash on Delivery, bKash and Nagad.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('frontend/css/pages.css') }}">
@endpush

@section('content')

<main>
<section>
  <div class="container">

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($items->isEmpty())
      <div class="text-center py-5">
        <i class="bi bi-bag-x" style="font-size:3rem;color:#94a3b8;"></i>
        <p class="mt-3 text-muted">No items to checkout.</p>
        <a href="{{ route('shop') }}" class="btn btn-success mt-2">Browse Products</a>
      </div>
    @else

    <div class="bl-page-title bl-anim-1">Checkout</div>
    <div class="bl-page-sub bl-anim-1">Complete your order below</div>

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

      {{-- LEFT: Billing Form --}}
      <div class="col-12 col-lg-7 bill">
        <div class="bl-card bl-anim-2">
          <div class="bl-card-title">
            <i class="bi bi-person-lines-fill"></i> Billing Information
          </div>
          <div class="row g-3">
            <div class="col-6">
              <div class="bl-form-group">
                <label class="bl-label">First name <span>*</span></label>
                <input type="text" name="first_name" class="bl-input"
                       placeholder="Your first name"
                       value="{{ old('first_name', Auth::user()->name ?? '') }}" required>
                @error('first_name')<small class="text-danger">{{ $message }}</small>@enderror
              </div>
            </div>
            <div class="col-6">
              <div class="bl-form-group">
                <label class="bl-label">Last name <span>*</span></label>
                <input type="text" name="last_name" class="bl-input"
                       placeholder="Your last name"
                       value="{{ old('last_name') }}" required>
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
                       value="{{ old('address') }}" required>
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
                       value="{{ old('zip') }}" required>
                @error('zip')<small class="text-danger">{{ $message }}</small>@enderror
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <div class="bl-form-group">
                <label class="bl-label">Email <span>*</span></label>
                <input type="email" name="email" class="bl-input"
                       placeholder="Email address"
                       value="{{ old('email', Auth::user()->email ?? '') }}" required>
                @error('email')<small class="text-danger">{{ $message }}</small>@enderror
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <div class="bl-form-group">
                <label class="bl-label">Phone <span>*</span></label>
                <input type="tel" name="phone" class="bl-input"
                       placeholder="Phone number"
                       value="{{ old('phone') }}" required>
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

        <div class="bl-card bl-anim-3">
          <div class="bl-card-title">
            <i class="bi bi-chat-left-text"></i> Additional Info
          </div>
          <div class="bl-form-group">
            <label class="bl-label">Order Notes <span style="color:var(--text-muted);font-weight:500">(Optional)</span></label>
            <textarea name="notes" class="bl-textarea"
                      placeholder="Notes about your order, e.g. special notes for delivery"></textarea>
          </div>
        </div>
      </div>

      {{-- RIGHT: Order Summary --}}
      <div class="col-12 col-lg-5">
        <div class="bl-summary-card bl-anim-4">
          <div class="bl-card-title" style="margin-bottom:1rem;">
            <i class="bi bi-bag-check"></i> Order Summary
            <span style="font-size:12px;color:#94a3b8;margin-left:8px;">
              ({{ $items->count() }} item{{ $items->count() > 1 ? 's' : '' }})
            </span>
          </div>

          @foreach($items as $item)
          <div class="bl-order-item">
            <div class="bl-item-img">
              @if($item['product']->image)
                <img src="{{ asset('storage/'.$item['product']->image) }}"
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
            <div class="bl-item-price">৳{{ number_format($item['subtotal'], 2) }}</div>
          </div>
          @endforeach

          {{-- COUPON --}}
          <div class="mb-3">
            <div class="d-flex gap-2">
              <input type="text" id="couponInput" class="form-control"
                     placeholder="Coupon code লিখুন..."
                     style="text-transform:uppercase;">
              <button type="button" onclick="applyCoupon()"
                      class="btn btn-outline-success"
                      style="white-space:nowrap;">Apply</button>
            </div>
            <div id="couponMsg" class="mt-2 small"></div>
          </div>

          <input type="hidden" name="coupon_code" id="couponCode" value="">

          {{-- TOTALS --}}
          <div class="bl-totals">
            <div class="bl-total-row">
              <span class="label">Subtotal</span>
              <span class="val">৳{{ number_format($total, 2) }}</span>
            </div>
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

          {{-- PAYMENT --}}
          <div class="bl-payment-title">Payment Method</div>
          <div class="bl-radio-group" id="blPayGroup">
            <label class="bl-radio-option selected" onclick="selectPayment(this, 'cod')">
              <input type="radio" name="payment_display" value="cod" checked>
              <span class="bl-radio-label"><i class="bi bi-truck"></i> Cash on Delivery</span>
            </label>
            <label class="bl-radio-option" onclick="selectPayment(this, 'bkash')">
              <input type="radio" name="payment_display" value="bkash">
              <span class="bl-radio-label"><i class="bi bi-phone"></i> bKash</span>
            </label>
            <label class="bl-radio-option" onclick="selectPayment(this, 'nagad')">
              <input type="radio" name="payment_display" value="nagad">
              <span class="bl-radio-label"><i class="bi bi-wallet2"></i> Nagad</span>
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
  <script src="{{ asset('frontend/js/wishlist.js') }}"></script>
  <script src="{{ asset('frontend/js/pages.js') }}"></script>
  <script>
  function selectPayment(label, value) {
    document.querySelectorAll('.bl-radio-option').forEach(l => l.classList.remove('selected'));
    label.classList.add('selected');
    document.getElementById('paymentInput').value = value;
  }

  const originalTotal = {{ $total }};

  function applyCoupon() {
    const code  = document.getElementById('couponInput').value.trim();
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
        document.getElementById('discountRow').style.display = 'flex';
        document.getElementById('discountVal').textContent   = '-৳' + data.discount.toFixed(2);
        document.getElementById('grandTotal').textContent    = '৳' + data.newTotal.toFixed(2);
        document.getElementById('couponCode').value          = code;
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
    document.getElementById('grandTotal').textContent    = '৳' + originalTotal.toFixed(2);
    document.getElementById('couponCode').value          = '';
  }
  </script>
@endpush