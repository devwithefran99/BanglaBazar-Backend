@extends('frontend.layouts.app')

@section('title', 'My Wishlist')
@section('meta_description', 'আপনার saved products দেখুন BanglaBazar Wishlist এ। পছন্দের পণ্য সহজেই আবার কিনুন।')

@push('styles')
  <link rel="stylesheet" href="{{ asset('frontend/css/pages.css') }}">
@endpush

@section('content')

<div class="wl-header text-center">
  <span class="wl-tag">Saved Item's</span>
  <div class="blob blob-1"></div>
  <div class="blob blob-2"></div>
  <h1 class="wl-title">My <span>Wishlist</span></h1>
  <p class="wl-desc">Your curated picks, saved for later. Easily access and manage your favorite products anytime.</p>
  <div class="mt-3">
    <span class="wl-badge">
      <i class="bi bi-collection-fill"></i> {{ $wishlists->count() }} items saved
    </span>
  </div>
</div>

<div class="wl-body">
  <div class="container">
    @php
      $availableTotal = $wishlists->filter(fn($i) => $i->product && ($i->product->stock ?? 1) > 0)
                                  ->sum(fn($i) => $i->product->price ?? 0);
      $inStockCount   = $wishlists->filter(fn($i) => $i->product && ($i->product->stock ?? 1) > 0)->count();
    @endphp

    <div class="summary-strip mt-5">
      <div class="summary-stat">
        <span class="val">{{ $wishlists->count() }}</span>
        <span class="lbl">Total Items</span>
      </div>
      <div class="summary-divider"></div>
      <div class="summary-stat">
        <span class="val">{{ $inStockCount }}</span>
        <span class="lbl">In Stock</span>
      </div>
      <div class="summary-divider"></div>
      <div class="summary-stat">
        <span class="val">৳{{ number_format($availableTotal, 2) }}</span>
        <span class="lbl">Available Total</span>
      </div>
      <div class="ms-auto">
        <button class="btn-buy" style="font-size:0.8rem;padding:9px 18px;">
          <a href="{{ route('checkout.show') }}?source=wishlist" style="text-decoration:none;color:#fff;">
            <i class="bi bi-bag-check-fill"></i> Buy All Available
          </a>
        </button>
      </div>
    </div>

    @forelse($wishlists as $item)
      @if($item->product)
      <div class="product-card" id="card-{{ $item->id }}">
        <div class="img-box">
          <img src="{{ asset('storage/'.$item->product->image) }}"
               onerror="this.src='{{ asset('frontend/image/hotProduct1 (3).png') }}'"
               alt="{{ $item->product->name }}">
        </div>
        <div class="product-info">
          <p class="product-name">{{ $item->product->name }}</p>
          <span class="product-category">{{ $item->product->category ?? 'Product' }}</span>
        </div>
        <div class="price-block">
          <span class="price-now">৳{{ number_format($item->product->price, 2) }}</span>
          @if($item->product->old_price)
            <div class="mt-1">
              <span class="price-old">৳{{ number_format($item->product->old_price, 2) }}</span>
              <span class="price-discount">
                -{{ round((($item->product->old_price - $item->product->price) / $item->product->old_price) * 100) }}%
              </span>
            </div>
          @endif
        </div>
        @if(($item->product->stock ?? 1) > 0)
          <span class="stock-badge in"><i class="bi bi-check-circle-fill me-1"></i>In Stock</span>
          <div class="card-actions">
            <button class="btn-buy">
              <a href="{{ route('product', $item->product->slug) }}" style="text-decoration:none;color:#fff;">
                <i class="bi bi-lightning-charge-fill"></i> Buy Now
              </a>
            </button>
            <form action="{{ route('wishlist.remove', $item->id) }}" method="POST" style="display:inline;">
              @csrf @method('DELETE')
              <button type="submit" class="btn-remove" title="Remove"><i class="bi bi-x-lg"></i></button>
            </form>
          </div>
        @else
          <span class="stock-badge out"><i class="bi bi-x-circle-fill me-1"></i>Out of Stock</span>
          <div class="card-actions">
            <button class="btn-notify"><i class="bi bi-bell-fill"></i> Notify Me</button>
            <form action="{{ route('wishlist.remove', $item->id) }}" method="POST" style="display:inline;">
              @csrf @method('DELETE')
              <button type="submit" class="btn-remove" title="Remove"><i class="bi bi-x-lg"></i></button>
            </form>
          </div>
        @endif
      </div>
      @endif
    @empty
      <div class="text-center py-5">
        <i class="bi bi-heart" style="font-size:4rem;color:#ccc;"></i>
        <h4 class="mt-3 text-muted">Your wishlist is empty!</h4>
        <p class="text-muted">Browse products and add them to your wishlist.</p>
        <a href="{{ route('shop') }}" class="btn btn-success mt-2">Browse Products →</a>
      </div>
    @endforelse

    <div class="toast-wrap" id="toastWrap" style="display:none;">
      <div class="my-toast" id="toastMsg"></div>
    </div>
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
  <script src="{{ asset('frontend/js/wishlist.js') }}" defer></script>
  <script src="{{ asset('frontend/js/pages.js') }}" defer></script>
@endpush