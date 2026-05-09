<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="wishlist-url" content="{{ route('wishlist.toggle') }}">
    <title>Shop | BanglaBazar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('frontend/css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/userDashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">

    <style>
        /* ── Responsive patches ── */

        /* Stats row: wrap on small screens */
        .udb-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .udb-stat {
            flex: 1 1 100px;
            min-width: 90px;
        }

        /* Profile + Billing row: stack on mobile */
        .udb-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .udb-row .udb-card {
            flex: 1 1 280px;
            min-width: 0;
        }

        /* Greeting text */
        .udb-greeting h2 {
            font-size: clamp(1.1rem, 4vw, 1.6rem);
        }

        /* Table: hide less-important columns on xs */
        @media (max-width: 575.98px) {
            .udb-hide-xs { display: none !important; }

            .udb-table td,
            .udb-table th {
                padding: 0.45rem 0.35rem;
                font-size: 11px;
            }

            /* Profile card: stack vertically */
            .udb-profile-inner {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
            .udb-profile-inner img {
                margin-bottom: .75rem;
            }

            /* Stat values smaller */
            .udb-stat-val {
                font-size: 1.3rem !important;
            }
        }

        /* Medium: two stats per row */
        @media (min-width: 576px) and (max-width: 767.98px) {
            .udb-stat {
                flex: 1 1 calc(50% - .5rem);
            }
        }

        /* Topbar hidden on xs — Bootstrap already handles this via d-none d-md-block */

        /* Cart drawer: full-width on mobile */
        @media (max-width: 575.98px) {
            .cp-drawer {
                width: 100% !important;
                max-width: 100% !important;
            }
        }

        /* Footer columns: already using Bootstrap grid, but ensure text wraps */
        .footer-desc {
            word-break: break-word;
        }

        /* Order product image: smaller on xs */
        @media (max-width: 400px) {
            .order-thumb {
                width: 34px !important;
                height: 34px !important;
            }
        }

        /* Offcanvas mobile search fix */
        .offcanvas-body .form-control:focus {
            box-shadow: none;
            border-color: var(--green, #22c55e);
        }
    </style>
</head>
<body>

<!-- ── Preloader ── -->
<div id="preloader">
    <div class="loader">
        <img src="{{ asset('frontend/image/Logo.png') }}" alt="Logo">
        <p>Loading...</p>
    </div>
</div>

<!-- ════════════════════════════════════════
     HEADER
════════════════════════════════════════ -->
<header>
    <section id="navigation">

        <!-- TOP BAR -->
        <div class="topbar d-none d-md-block">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <i class="bi bi-geo-alt-fill text-success me-1"></i>
                        Store Location: 5th Floor, Kazi Complex, Beparipara, Agrabad Access Road, Chattogram
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="sep">|</span>
                        <a href="{{ route('signin') }}"><i class="bi bi-person me-1"></i>Sign In /</a>
                        <a href="{{ route('register') }}"><i class="bi bi-person me-1"></i>Sign Up</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- MIDDLE BAR -->
        <div class="middlebar d-flex align-items-center justify-content-between">
            <div class="container">
                <div class="d-flex align-items-center justify-content-between gap-3">

                    <!-- Logo -->
                    <a href="#" class="logo-slot">
                        <img src="{{ asset('frontend/image/Logo.png') }}" height="35" alt="logo">
                    </a>

                    <!-- Hamburger (mobile/tablet) -->
                    <div class="d-lg-none ms-auto">
                        <button class="navbar-toggler-custom" type="button"
                                data-bs-toggle="offcanvas" data-bs-target="#mobileNav">
                            <i class="bi bi-list"></i>
                        </button>
                    </div>

                    <!-- Search (lg+ only) -->
                    <div class="search-wrap flex-grow-1 mx-3 d-none d-lg-flex">
                        <input type="text" placeholder="Search for products..."/>
                        <button><i class="bi bi-search me-1"></i>Search</button>
                    </div>

                    <!-- Icons (lg+) -->
                    <div class="d-none d-lg-flex align-items-center gap-2">
                        <a href="{{ route('wishlist') }}" class="icon-btn">
                            <i class="bi bi-heart"></i>
                            <span class="badge-dot" id="wishlistCount">
                                {{ Auth::check() ? Auth::user()->wishlists()->count() : 0 }}
                            </span>
                        </a>
                        <a href="#" class="icon-btn cart-btn" id="navCartBtn">
                            <i class="bi bi-bag"></i>
                            <span class="badge-dot" id="cartCount">
                                {{ Auth::check() ? Auth::user()->carts()->count() : 0 }}
                            </span>
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <!-- MAIN NAVBAR (desktop) -->
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
                        <i class="bi bi-telephone-fill"></i>
                        01616-239896
                    </div>

                </div>
            </div>
        </nav>

        <!-- OFFCANVAS (mobile sidebar) -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileNav">
            <div class="offcanvas-header">
                <img src="{{ asset('frontend/image/Logo.png') }}" alt="">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">

                <!-- Mobile search -->
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

<!-- ════════════════════════════════════════
     MAIN CONTENT
════════════════════════════════════════ -->
<main>
    <section id="userDash" class="udb-wrap">
        <div class="container">

            <!-- Greeting -->
            <div class="udb-greeting">
                <h2 id="udbGreeting">Good evening, {{ Auth::user()->name }} ✦</h2>
                <p>Here's a summary of your account activity</p>
            </div>

            <!-- Stats -->
            <div class="udb-stats">
                <div class="udb-stat">
                    <div class="udb-stat-label">Orders</div>
                    <div class="udb-stat-val">{{ Auth::user()->orders->count() }}</div>
                </div>
                <div class="udb-stat">
                    <div class="udb-stat-label">Spent</div>
                    <div class="udb-stat-val green">
                        ৳{{ number_format(Auth::user()->orders->sum('total_price'), 0) }}
                    </div>
                </div>
                <div class="udb-stat">
                    <div class="udb-stat-label">Tier</div>
                    <div class="udb-stat-val gold">VIP</div>
                </div>
            </div>

            <!-- Profile + Billing -->
            <div class="udb-row">

                <!-- Profile -->
                <div class="udb-card udb-profile-card">
                    <div class="udb-profile-inner">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/'.Auth::user()->avatar) }}" alt="">
                        @else
                            <img src="https://i.pravatar.cc/300?img=68" alt="">
                        @endif
                        <div class="udb-profile-info">
                            <h4>{{ Auth::user()->name }}</h4>
                            <div>
                                <span class="udb-vip">
                                    <i class="bi bi-star-fill"></i> VIP Member
                                </span>
                            </div>
                            <button class="udb-btn-green" onclick="editProfile()">
                                <i class="bi bi-person-pen me-1"></i> Edit Profile
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Billing -->
                <div class="udb-card">
                    <div class="udb-card-label">Billing Address</div>
                    <div class="udb-billing-name">{{ Auth::user()->name }}</div>
                    <div class="udb-billing-addr">4540 Parker Rd<br>Allentown, NM 3834</div>
                    <button class="udb-btn-outline" onclick="editAddress()">
                        <i class="bi bi-pencil me-1"></i> Edit Address
                    </button>
                </div>

            </div>

            <!-- Recent Orders -->
            <div class="udb-card udb-orders-card">
                <div class="udb-orders-head">
                    <h5>Recent Orders</h5>
                    <a href="#" class="udb-view-all" onclick="viewAllOrders()">View all →</a>
                </div>
                <div class="table-responsive">
                    <table class="udb-table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product</th>
                                <th class="udb-hide-mobile d-none d-md-table-cell">Date</th>
                                <th>Total</th>
                                <th class="d-none d-sm-table-cell">Qty</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse(Auth::user()->orders->take(5) as $order)
                            @php
                                $firstItem = $order->items->first();
                                $imgSrc = asset('frontend/image/Product Image.png');
                                if ($firstItem) {
                                    if ($firstItem->product_type === 'hotdeal') {
                                        $p = \App\Models\HotDeal::find($firstItem->product_id);
                                    } else {
                                        $p = \App\Models\Product::find($firstItem->product_id);
                                    }
                                    if ($p && $p->image) {
                                        $imgSrc = asset('storage/' . $p->image);
                                    }
                                }
                                $itemCount  = $order->items->count();
                                $firstName  = $firstItem ? $firstItem->product_name : 'N/A';
                                $extraCount = $itemCount - 1;
                            @endphp
                            <tr>
                                <!-- Image -->
                                <td>
                                    <img src="{{ $imgSrc }}"
                                         alt="{{ $firstName }}"
                                         onerror="this.src='{{ asset('frontend/image/Product Image.png') }}'"
                                         class="order-thumb"
                                         style="width:44px;height:44px;border-radius:8px;object-fit:cover;
                                                border:1.5px solid #f1f5f9;">
                                </td>
                                <!-- Product Name -->
                                <td class="td-n">
                                    <div style="font-weight:700;font-size:13px;color:#0f172a;">
                                        {{ Str::limit($firstName, 20) }}
                                    </div>
                                    @if($extraCount > 0)
                                        <div style="font-size:11px;color:#94a3b8;">+{{ $extraCount }} more</div>
                                    @endif
                                    <div style="font-size:11px;color:#94a3b8;">
                                        Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                                    </div>
                                </td>
                                <!-- Date (hidden on mobile) -->
                                <td class="td-d udb-hide-mobile d-none d-md-table-cell">
                                    {{ $order->created_at->format('d M Y') }}
                                </td>
                                <!-- Total -->
                                <td class="td-p" style="font-weight:700;color:#22c55e;">
                                    ৳{{ number_format($order->total_price, 0) }}
                                </td>
                                <!-- Qty (hidden on xs) -->
                                <td class="d-none d-sm-table-cell">
                                    <span class="udb-qty">{{ $order->items->sum('quantity') }}</span>
                                </td>
                                <!-- Status -->
                                <td>
                                    @if($order->status == 'pending')
                                        <span class="udb-status udb-s-proc">Processing</span>
                                    @elseif($order->status == 'confirmed')
                                        <span class="udb-status udb-s-proc">Confirmed</span>
                                    @elseif($order->status == 'shipped')
                                        <span class="udb-status udb-s-way">On Way</span>
                                    @elseif($order->status == 'delivered')
                                        <span class="udb-status udb-s-done">Done</span>
                                    @elseif($order->status == 'cancelled')
                                        <span class="udb-status" style="background:#fee2e2;color:#dc2626;">Cancelled</span>
                                    @else
                                        <span class="udb-status udb-s-proc">{{ ucfirst($order->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-3 text-muted">No orders yet.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
</main>

<!-- ════════════════════════════════════════
     CART POPUP
════════════════════════════════════════ -->
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

    <div class="cp-items" id="cpItems">
        <div class="cp-item" data-id="1">
            <div class="cp-item-img"><img src="{{ asset('frontend/image/hotProduct1 (2).png') }}" alt=""></div>
            <div class="cp-item-info">
                <div class="cp-item-name">Fresh Indian Orange</div>
                <div class="cp-item-meta">1 kg × <strong>$12.00</strong></div>
            </div>
            <button class="cp-remove" onclick="cpRemoveItem(this)" aria-label="Remove">
                <i class="bi bi-x"></i>
            </button>
        </div>
        <div class="cp-item" data-id="2">
            <div class="cp-item-img"><img src="{{ asset('frontend/image/hotProduct1 (1).png') }}" alt=""></div>
            <div class="cp-item-info">
                <div class="cp-item-name">Green Apple</div>
                <div class="cp-item-meta">1 kg × <strong>$14.00</strong></div>
            </div>
            <button class="cp-remove" onclick="cpRemoveItem(this)" aria-label="Remove">
                <i class="bi bi-x"></i>
            </button>
        </div>
    </div>

    <div class="cp-empty" id="cpEmpty">
        <i class="bi bi-bag-x"></i>
        <p>Your cart is empty</p>
        <a href="{{ route('shop') }}" class="cp-shop-link">Browse Products →</a>
    </div>

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

<!-- ════════════════════════════════════════
     FOOTER  (fixed: removed nested <footer>)
════════════════════════════════════════ -->
<footer class="main-footer">
    <div class="container">
        <div class="row g-4">

            <!-- Brand -->
            <div class="col-lg-3 col-md-6 anim-fade-up d1">
                <img src="{{ asset('frontend/image/logoLight.png') }}" alt="">
                <p class="footer-desc">
                    Morbi cursus porttitor enim lobortis molestie. Duis gravida turpis dui,
                    eget bibendum magna congue nec.
                </p>
                <div class="footer-contact d-flex align-items-center flex-wrap">
                    <a href="tel:01616239896">01616-239896</a>
                    <span class="separator">or</span>
                    <a href="mailto:Proxy@gmail.com">Proxy@gmail.com</a>
                </div>
            </div>

            <!-- My Account -->
            <div class="col-lg-2 col-md-3 col-6 anim-fade-up d2">
                <h6 class="footer-col-title">My Account</h6>
                <ul class="footer-links">
                    <li><a href="{{ route('userdashboard') }}">My Account</a></li>
                    <li><a href="{{ route('userdashboard') }}">Order History</a></li>
                    <li><a href="#" class="active">Shopping Cart</a></li>
                    <li><a href="{{ route('wishlist') }}">Wishlist</a></li>
                </ul>
            </div>

            <!-- Helps -->
            <div class="col-lg-2 col-md-3 col-6 anim-fade-up d3">
                <h6 class="footer-col-title">Helps</h6>
                <ul class="footer-links">
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                    <li><a href="{{ route('faq') }}">FAQS</a></li>
                    <li><a href="#">Terms &amp; Condition</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>

            <!-- Proxy -->
            <div class="col-lg-2 col-md-3 col-6 anim-fade-up d4">
                <h6 class="footer-col-title">Proxy</h6>
                <ul class="footer-links">
                    <li><a href="{{ route('about') }}">About</a></li>
                    <li><a href="{{ route('shop') }}">Shop</a></li>
                    <li><a href="#">Product</a></li>
                </ul>
            </div>

            <!-- Categories -->
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

    <!-- Bottom Bar -->
    <div class="footer-bottom mt-4">
        <div class="container">
            <div class="row align-items-center anim-fade-in d6">
                <div class="col-md-6 mySign">
                    <p>BanglaBazar24/7 eCommerce © 2026. All Rights Reserved
                        <span>Powered By <a href="https://github.com/devwithefran99">devwithErfan</a></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/mixitup@3/dist/mixitup.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('frontend/js/common.js') }}"></script>
<script src="{{ asset('frontend/js/userDashboard.js') }}"></script>
</body>
</html>