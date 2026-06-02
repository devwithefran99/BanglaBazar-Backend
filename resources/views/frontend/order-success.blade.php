@extends('frontend.layouts.app')

@section('title', 'Order Confirmed')
@section('meta_description', 'আপনার order সফলভাবে placed হয়েছে। BanglaBazar এ order করার জন্য ধন্যবাদ।')

@section('content')

{{-- SUCCESS POPUP --}}
<div class="os-overlay" id="osOverlay">
  <div class="os-popup">
    <div class="os-check">
      <i class="bi bi-check-lg"></i>
    </div>
    <div class="os-title">Order Confirmed! 🎉</div>
    <div class="os-sub">
      আপনার অর্ডারটি সফলভাবে submit হয়েছে।<br>
      আমরা শীঘ্রই আপনার সাথে যোগাযোগ করব।
    </div>
    <div class="os-order-id">
      Order ID: #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
    </div>
    <div class="os-btns">
      <button class="os-btn-primary" onclick="closePopup()">
        <i class="bi bi-receipt me-1"></i> View Details
      </button>
      <a href="{{ route('shop') }}" class="os-btn-outline">
        <i class="bi bi-shop me-1"></i> Continue Shopping
      </a>
    </div>
  </div>
</div>

{{-- ORDER DETAIL --}}
<div class="os-detail-section" id="osDetail" style="display:none;">

  {{-- Step indicator --}}
  <div class="text-center mb-4">
    <div style="display:inline-flex;align-items:center;gap:8px;background:#f0fdf4;padding:10px 20px;border-radius:30px;">
      <span style="background:#22c55e;color:#fff;width:24px;height:24px;border-radius:50%;
                   display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:800;">✓</span>
      <span style="font-size:13px;font-weight:700;color:#166534;">Order Placed</span>
      <span style="color:#94a3b8;">→</span>
      <span style="font-size:13px;color:#94a3b8;">Processing</span>
      <span style="color:#94a3b8;">→</span>
      <span style="font-size:13px;color:#94a3b8;">Shipped</span>
      <span style="color:#94a3b8;">→</span>
      <span style="font-size:13px;color:#94a3b8;">Delivered</span>
    </div>
  </div>

  {{-- Order Info --}}
  <div class="os-detail-card">
    <h5><i class="bi bi-receipt text-success"></i> Order Information</h5>
    <div class="row g-2" style="font-size:14px;">
      <div class="col-6">
        <div style="color:#94a3b8;font-size:12px;">Order ID</div>
        <div style="font-weight:700;">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
      </div>
      <div class="col-6">
        <div style="color:#94a3b8;font-size:12px;">Date</div>
        <div style="font-weight:700;">{{ $order->created_at->format('d M Y, h:i A') }}</div>
      </div>
      <div class="col-6 mt-2">
        <div style="color:#94a3b8;font-size:12px;">Status</div>
        <div><span class="os-status-badge"><i class="bi bi-clock-fill"></i> Pending</span></div>
      </div>
      <div class="col-6 mt-2">
        <div style="color:#94a3b8;font-size:12px;">Phone</div>
        <div style="font-weight:700;">{{ $order->phone }}</div>
      </div>
      <div class="col-12 mt-2">
        <div style="color:#94a3b8;font-size:12px;">Delivery Address</div>
        <div style="font-weight:700;">{{ $order->address }}</div>
      </div>
    </div>
  </div>

  {{-- Ordered Items --}}
  <div class="os-detail-card">
    <h5><i class="bi bi-bag text-success"></i> Ordered Items</h5>
    @foreach($order->items as $item)
    @php
      $product = $item->product_type === 'hotdeal'
        ? \App\Models\HotDeal::find($item->product_id)
        : \App\Models\Product::find($item->product_id);
      $imgSrc = ($product && $product->image)
        ? asset('storage/'.$product->image)
        : asset('frontend/image/Product Image.png');
    @endphp
    <div class="os-item-row">
      <img class="os-item-img"
           src="{{ $imgSrc }}"
           alt="{{ $item->product_name }}"
           onerror="this.src='{{ asset('frontend/image/Product Image.png') }}'">
      <div>
        <div class="os-item-name">{{ $item->product_name }}</div>
        <div class="os-item-meta">
          Qty: {{ $item->quantity }}
          @if($item->product_type === 'hotdeal')
            · <span style="color:#ef4444;">🔥 Hot Deal</span>
          @endif
        </div>
      </div>
      <div class="os-item-price">৳{{ number_format($item->price * $item->quantity, 2) }}</div>
    </div>
    @endforeach
  </div>

  {{-- Price Summary --}}
  <div class="os-detail-card">
    <h5><i class="bi bi-calculator text-success"></i> Price Summary</h5>
    <div class="os-total-row">
      <span>Subtotal</span>
      <span>৳{{ number_format($order->total_price, 2) }}</span>
    </div>
    <div class="os-total-row">
      <span>Shipping</span>
      <span style="color:#22c55e;font-weight:700;">Free</span>
    </div>
    <div class="os-total-row grand">
      <span>Total</span>
      <span style="color:#22c55e;">৳{{ number_format($order->total_price, 2) }}</span>
    </div>
  </div>

  {{-- Action Buttons --}}
  <div class="d-flex gap-3 justify-content-center flex-wrap">
    <a href="{{ route('userdashboard') }}" class="os-btn-primary">
      <i class="bi bi-person-circle me-1"></i> Go to My Account
    </a>
    <a href="{{ route('shop') }}" class="os-btn-outline">
      <i class="bi bi-shop me-1"></i> Continue Shopping
    </a>
  </div>

</div>

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

{{-- QUICK VIEW MODAL --}}
<div class="qv-backdrop" id="qvBackdrop">
  <div class="qv-modal" role="dialog" aria-modal="true">
    <button class="qv-close" id="qvClose"><i class="bi bi-x"></i></button>
    <div class="qv-img-side"><img id="qvImg" src="" alt=""></div>
    <div class="qv-info-side">
      <span class="qv-category" id="qvCat">Vegetables</span>
      <h2 class="qv-title" id="qvTitle"></h2>
      <div class="qv-stars">
        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
        <i class="bi bi-star empty"></i>
      </div>
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

@endsection

@push('scripts')
  <script src="{{ asset('frontend/js/wishlist.js') }}"></script>
  <script>
  function closePopup() {
    document.getElementById('osOverlay').style.animation = 'fadeOut .3s ease forwards';
    setTimeout(() => {
      document.getElementById('osOverlay').style.display = 'none';
      document.getElementById('osDetail').style.display  = 'block';
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }, 300);
  }

  setTimeout(() => {
    if (document.getElementById('osOverlay') &&
        document.getElementById('osOverlay').style.display !== 'none') {
      closePopup();
    }
  }, 5000);

  const style = document.createElement('style');
  style.textContent = '@keyframes fadeOut { to { opacity: 0; } }';
  document.head.appendChild(style);
  </script>
@endpush