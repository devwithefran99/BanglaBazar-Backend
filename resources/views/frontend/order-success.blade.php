<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="wishlist-url" content="{{ route('wishlist.toggle') }}">
<meta name="cart-add-url" content="{{ route('cart.add') }}">
<meta name="cart-count-url" content="{{ route('cart.count') }}">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<link rel="stylesheet" href="{{ asset('frontend/css/common.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
<title>BanglaBazar 24/7</title>

</head>
<body>

<!-- preloader -->
<div id="preloader">
  <div class="loader">
    <img src="{{ asset('frontend/image/Logo.png') }}" alt="logo">
    <p>Loading...</p>
  </div>
</div>

<!-- header -->
<header>
<section id="navigation">

  <div class="topbar d-none d-md-block">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <i class="bi bi-geo-alt-fill text-success me-1"></i>
          Store Location: 5th Floor,Kazi Complex,Beparipara,Agrabad Access Road,Chattogram
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
          <img src="{{ asset('frontend/image/Logo.png') }}" height="40" alt="logo">
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
            <a class="nav-link" href="{{ route('about') }}"><i class="bi bi-info-circle me-1"></i> About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('contact') }}"><i class="bi bi-telephone me-1"></i> Contact Us</a>
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


{{-- ── SUCCESS POPUP ── --}}
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

{{-- ── ORDER DETAIL (popup বন্ধ হলে দেখাবে) ── --}}
<div class="os-detail-section" id="osDetail" style="display:none;">
 
    {{-- Step indicator --}}
    <div class="text-center mb-4">
        <div style="display:inline-flex;align-items:center;gap:8px;background:#f0fdf4;
                    padding:10px 20px;border-radius:30px;">
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
 
   {{-- ✅ Order Items — actual product image সহ --}}
<div class="os-detail-card">
    <h5><i class="bi bi-bag text-success"></i> Ordered Items</h5>
    @foreach($order->items as $item)
    @php
        // product_type অনুযায়ী সঠিক model থেকে image আনো
        if ($item->product_type === 'hotdeal') {
            $product = \App\Models\HotDeal::find($item->product_id);
        } else {
            $product = \App\Models\Product::find($item->product_id);
        }
        $imgSrc = ($product && $product->image)
            ? asset('storage/' . $product->image)
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
 
    {{-- Total --}}
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
 
    {{-- Action buttons --}}
    <div class="d-flex gap-3 justify-content-center flex-wrap">
        <a href="{{ route('userdashboard') }}" class="os-btn-primary">
            <i class="bi bi-person-circle me-1"></i> Go to My Account
        </a>
        <a href="{{ route('shop') }}" class="os-btn-outline">
            <i class="bi bi-shop me-1"></i> Continue Shopping
        </a>
    </div>
 
</div>
 
<!-- Cart Drawer -->
<div class="cp-drawer" id="cpDrawer">
 
  <!-- Header -->
  <div class="cp-header">
    <div class="cp-title">
      
      <img src="{{asset('frontend/image/Logo.png')}}" alt="">
     
    </div>
    <button class="cp-close" id="cpClose" aria-label="Close cart">
      <i class="bi bi-x-lg"></i>
    </button>
  </div>
 
  <!-- Items -->
  <div class="cp-items" id="cpItems">
 
    <div class="cp-item" data-id="1">
      <div class="cp-item-img"><img src="{{asset('frontend/image/hotProduct1 (2).png')}}" alt=""></div>
      <div class="cp-item-info">
        <div class="cp-item-name">Fresh Indian Orange</div>
        <div class="cp-item-meta">1 kg × <strong>$12.00</strong></div>
      </div>
      <button class="cp-remove" onclick="cpRemoveItem(this)" aria-label="Remove">
        <i class="bi bi-x"></i>
      </button>
    </div>
 
    <div class="cp-item" data-id="2">
      <div class="cp-item-img"><img src="{{asset('frontend/image/hotProduct1 (1).png')}}" alt=""></div>
      <div class="cp-item-info">
        <div class="cp-item-name">Green Apple</div>
        <div class="cp-item-meta">1 kg × <strong>$14.00</strong></div>
      </div>
      <button class="cp-remove" onclick="cpRemoveItem(this)" aria-label="Remove">
        <i class="bi bi-x"></i>
      </button>
    </div>
 
  </div>
 
  <!-- Empty state (hidden by default) -->
  <div class="cp-empty" id="cpEmpty">
    <i class="bi bi-bag-x"></i>
    <p>Your cart is empty</p>
    <a href="{{ route('shop') }}" class="cp-shop-link">Browse Products →</a>
  </div>
 
  <!-- Footer -->
  <div class="cp-footer" id="cpFooter">
    <div class="cp-subtotal">
      <span class="cp-sub-label"><span id="cpProductCount">2</span> Product</span>
      <span class="cp-sub-price" id="cpTotal">$26.00</span>
    </div>
    <a href="{{ route('checkout.show') }}?source=cart" class="cp-checkout-btn">
      <i class="bi bi-bag-check-fill me-1"></i> Checkout
    </a>
    <a href="#" class="cp-cart-link">Go To Cart</a>
  </div>
 
</div>
 
</section>
{{-- ── FOOTER ── --}}
<footer class="main-footer">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-3 col-md-6 anim-fade-up d1">
        <img src="{{ asset('frontend/image/logoLight.png') }}" alt="">
        <p class="footer-desc">
          Morbi cursus porttitor enim lobortis molestie. Duis gravida turpis dui, eget bibendum magna congue nec.
        </p>
        <div class="footer-contact d-flex align-items-center flex-wrap">
          <a href="tel:01616239896">01616-239896</a>
          <span class="separator">or</span>
          <a href="mailto:Proxy@gmail.com">Proxy@gmail.com</a>
        </div>
      </div>
      <div class="col-lg-2 col-md-3 col-6 anim-fade-up d2">
        <h6 class="footer-col-title">My Account</h6>
        <ul class="footer-links">
          <li><a href="{{ route('userdashboard') }}">My Account</a></li>
          <li><a href="{{ route('userdashboard') }}">Order History</a></li>
          <li><a href="#" class="active">Shopping Cart</a></li>
          <li><a href="{{ route('wishlist') }}">Wishlist</a></li>
        </ul>
      </div>
      <div class="col-lg-2 col-md-3 col-6 anim-fade-up d3">
        <h6 class="footer-col-title">Helps</h6>
        <ul class="footer-links">
          <li><a href="{{ route('contact') }}">Contact</a></li>
          <li><a href="{{ route('faq') }}">FAQS</a></li>
          <li><a href="#">Terms &amp; Condition</a></li>
          <li><a href="#">Privacy Policy</a></li>
        </ul>
      </div>
      <div class="col-lg-2 col-md-3 col-6 anim-fade-up d4">
        <h6 class="footer-col-title">Proxy</h6>
        <ul class="footer-links">
          <li><a href="{{ route('about') }}">About</a></li>
          <li><a href="{{ route('shop') }}">Shop</a></li>
          <li><a href="{{ route('shop') }}">Product</a></li>
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

{{-- ── QUICK VIEW MODAL ── --}}
<div class="qv-backdrop" id="qvBackdrop">
  <div class="qv-modal" role="dialog" aria-modal="true">
    <button class="qv-close" id="qvClose" aria-label="Close"><i class="bi bi-x"></i></button>
    <div class="qv-img-side">
      <img id="qvImg" src="" alt="">
    </div>
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
      <p class="qv-desc" id="qvDesc">Fresh, naturally grown product. Packed with nutrients and flavour — perfect for everyday cooking.</p>
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

<script>
function closePopup() {
    document.getElementById('osOverlay').style.animation = 'fadeOut .3s ease forwards';
    setTimeout(() => {
        document.getElementById('osOverlay').style.display = 'none';
        document.getElementById('osDetail').style.display = 'block';
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

{{-- ── SCRIPTS ── --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('frontend/js/common.js') }}"></script>
<script src="{{ asset('frontend/js/wishlist.js') }}"></script>
@stack('scripts')

</body>
</html>