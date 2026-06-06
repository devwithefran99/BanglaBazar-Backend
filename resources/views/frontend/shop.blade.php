@extends('frontend.layouts.app')

@section('title', 'Shop')
@section('meta_description', 'BanglaBazar এ shop করুন — fresh vegetables, fish, meat, spices এবং আরো অনেক কিছু। Best price guaranteed।')
@section('og_title', 'Shop | BanglaBazar24/7')
@section('og_description', 'Fresh groceries at the best price. Shop now at BanglaBazar.')

@push('styles')
  <link rel="stylesheet" href="{{ asset('frontend/css/shop.css') }}">
@endpush

@section('content')

{{-- SHOP BANNER --}}
<section id="shopBanner">
  <div class="shopBnr"></div>
</section>

{{-- MAIN CONTENT --}}
<main>
  <section class="content">
    <div class="container p-0">
      <div class="row g-0">

        {{-- FILTER SIDEBAR --}}
        <div class="col-lg-3 filter-sidebar" id="filter-sidebar">
          <div class="d-flex align-items-center justify-content-between mb-4">
            <h5 class="mb-0 fw-bold">All Categories</h5>
            <button onclick="closeSidebar()" class="btn btn-success btn-sm d-lg-none">
              <i class="bi bi-x-lg"></i>
            </button>
          </div>
          <div class="mb-4">
            <a href="{{ route('shop') }}"
               class="category-item {{ $selectedCategory === 'all' ? 'active-cat' : '' }}"
               style="text-decoration:none;">
              <span><i class="bi bi-grid me-2"></i>All Products</span>
              <span class="cat-count">{{ $allProducts->count() + $allHotDeals->count() }}</span>
            </a>
            @foreach($dbCategories as $cat)
            @php
              $count = $allProducts->where('category', $cat->slug)->count()
                     + $allHotDeals->where('category', $cat->slug)->count();
            @endphp
            <a href="{{ route('shop') }}?category={{ $cat->slug }}"
               class="category-item {{ $selectedCategory === $cat->slug ? 'active-cat' : '' }}"
               style="text-decoration:none;">
              <span><i class="bi bi-tag me-2"></i>{{ $cat->name }}</span>
              <span class="cat-count">{{ $count }}</span>
            </a>
            @endforeach
          </div>
          <div class="bg-white text-dark p-4 rounded-4 mb-4 text-center">
            <h4 class="fw-bold text-success mb-1">79% Discount</h4>
            <p class="mb-3 small">on your first order</p>
            <a href="#" class="btn btn-success btn-sm px-4">Shop Now <i class="bi bi-arrow-right"></i></a>
          </div>
          <div class="text-center mt-3 text-muted small" id="results-count">
           {{ $total }} Results Found
          </div>
        </div>

        {{-- PRODUCT GRID --}}
        <div class="col-lg-9">
          <div class="top-bar d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
              <button onclick="toggleSidebar()" class="filter-btn btn btn-success d-lg-none">
                <i class="bi bi-list"></i>
              </button>
              <h4 class="mb-0 fw-semibold text-dark">Products</h4>
            </div>
            <div class="d-flex align-items-center gap-3">
              <input type="text" id="searchInput"
                     class="form-control d-none d-lg-block"
                     placeholder="Search products..."
                     style="width: 240px;">
              <select id="sortSelect" class="form-select" style="width: 160px;">
                <option value="latest">Latest</option>
                <option value="name">Name A-Z</option>
              </select>
            </div>
          </div>

          <div class="p-4">
            <div class="row g-4" id="product-grid">

              {{-- Regular Products --}}
              @foreach($products as $product)
              @php
                $inWishlist = Auth::check()
                  ? Auth::user()->wishlists->pluck('product_id')->contains($product->id)
                  : false;
                $uid = 'product-' . $product->id;
              @endphp
              <div class="col-6 col-lg-4 col-xl-3 product-col"
                   data-category="{{ $product->category ?? 'other' }}">
                <div class="hotProduct-card" style="cursor:pointer;">
                  @if($product->hasSale())
                    <div class="sale-badge">-{{ $product->salePercent() }}%</div>
                  @endif
                  <div class="product-img-wrap">
                    <div class="img-overlay">
                      <div class="overlay-icons">
                        <button class="wishlist-btn"
                                data-product-id="{{ $product->id }}"
                                data-product-type="product"
                                title="Wishlist">
                          <i class="bi bi-heart{{ $inWishlist ? '-fill' : '' }}"
                             style="{{ $inWishlist ? 'color:#e74c3c;' : '' }}"></i>
                        </button>
                        <button class="quick-view-btn" title="Quick View"
        data-id="{{ $product->id }}"
        data-type="product"
        data-name="{{ $product->name }}"
        data-price="{{ number_format($product->price,2) }}"
        data-old-price="{{ $product->old_price ? number_format($product->old_price,2) : '' }}"
        data-image="{{ $product->image ? asset('storage/'.$product->image) : asset('frontend/image/Product Image.png') }}"
        data-slug="{{ $product->slug }}"
        data-stock="{{ $product->stock }}">
  <i class="bi bi-eye"></i>
</button>
                      </div>
                    </div>
                    @if($product->image)
                      <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
                    @else
                      <img src="{{ asset('frontend/image/Product Image.png') }}" alt="{{ $product->name }}">
                    @endif
                  </div>
                  <div class="card-body-custom">
                    <a href="{{ route('product', ['slug' => $product->slug]) }}"
                       class="product-name"
                       style="text-decoration:none;color:inherit;display:block;">
                      {{ $product->name }}
                    </a>
                    <div class="stars">
                      <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                      <i class="bi bi-star empty"></i>
                    </div>
                    <div class="price-row">
                      <div class="price-block">
                        <span class="price-main">৳{{ number_format($product->price,2) }}</span>
                        @if($product->hasSale())
                          <span class="price-old">৳{{ number_format($product->old_price,2) }}</span>
                        @endif
                      </div>
                      <div class="cart-action-wrap">
                        <button class="cart-btn show-qty-btn"
                                data-uid="{{ $uid }}"
                                data-product-id="{{ $product->id }}"
                                data-product-type="product"
                                   data-product-slug="{{ $product->slug }}">
                          <i class="bi bi-bag"></i>
                        </button>
                        <div class="qty-selector"
                             data-uid="{{ $uid }}"
                             data-product-id="{{ $product->id }}"
                             data-product-type="product"
                             style="display:none;">
                          <button class="qty-btn minus"><i class="bi bi-dash"></i></button>
                          <input type="number" class="qty-input" value="1" min="1" max="{{ $product->stock }}">
                          <button class="qty-btn plus"><i class="bi bi-plus"></i></button>
                          <button class="add-to-cart-btn"
                                  data-uid="{{ $uid }}"
                                  data-product-id="{{ $product->id }}"
                                  data-product-type="product">
                            <i class="bi bi-check-lg"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach

              {{-- Hot Deal Products --}}
              @foreach($hotDeals as $deal)
              @php
                $inWishlistDeal = Auth::check()
                  ? Auth::user()->wishlists->pluck('product_id')->contains($deal->id)
                  : false;
                $uid = 'hotdeal-' . $deal->id;
              @endphp
              <div class="col-6 col-lg-4 col-xl-3 product-col"
                   data-category="{{ $deal->category ?? 'other' }}">
                <div class="hotProduct-card" style="cursor:pointer;">
                  <div class="hot-deal-badge">🔥 Hot Deal</div>
                  @if($deal->hasSale())
                    <div class="sale-badge">-{{ $deal->salePercent() }}%</div>
                  @endif
                  <div class="product-img-wrap">
                    <div class="img-overlay">
                      <div class="overlay-icons">
                        <button class="wishlist-btn"
                                data-product-id="{{ $deal->id }}"
                                data-product-type="hotdeal"
                                title="Wishlist">
                          <i class="bi bi-heart{{ $inWishlistDeal ? '-fill' : '' }}"
                             style="{{ $inWishlistDeal ? 'color:#e74c3c;' : '' }}"></i>
                        </button>
                      <button class="quick-view-btn" title="Quick View"
        data-id="{{ $deal->id }}"
        data-type="hotdeal"
        data-name="{{ $deal->name }}"
        data-price="{{ number_format($deal->price,2) }}"
        data-old-price="{{ $deal->old_price ? number_format($deal->old_price,2) : '' }}"
        data-image="{{ $deal->image ? asset('storage/'.$deal->image) : asset('frontend/image/Product Image.png') }}"
        data-slug="{{ $deal->slug }}"
        data-stock="{{ $deal->stock }}">
  <i class="bi bi-eye"></i>
</button>
                      </div>
                    </div>
                    @if($deal->image)
                      <img src="{{ asset('storage/'.$deal->image) }}" alt="{{ $deal->name }}">
                    @else
                      <img src="{{ asset('frontend/image/Product Image.png') }}" alt="{{ $deal->name }}">
                    @endif
                  </div>
                  <div class="card-body-custom">
                    <a href="{{ route('product', ['slug' => $deal->slug]) }}?type=hotdeal"
                       class="product-name"
                       style="text-decoration:none;color:inherit;display:block;">
                      {{ $deal->name }}
                    </a>
                    <div class="stars">
                      <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                      <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                      <i class="bi bi-star empty"></i>
                    </div>
                    <div class="price-row">
                      <div class="price-block">
                        <span class="price-main">৳{{ number_format($deal->price,2) }}</span>
                        @if($deal->hasSale())
                          <span class="price-old">৳{{ number_format($deal->old_price,2) }}</span>
                        @endif
                      </div>
                      <div class="cart-action-wrap">
                        <button class="cart-btn show-qty-btn"
                                data-uid="{{ $uid }}"
                                data-product-id="{{ $deal->id }}"
                                data-product-type="hotdeal"
                                data-product-slug="{{ $deal->slug }}">
                          <i class="bi bi-bag"></i>
                        </button>
                        <div class="qty-selector"
                             data-uid="{{ $uid }}"
                             data-product-id="{{ $deal->id }}"
                             data-product-type="hotdeal"
                             style="display:none;">
                          <button class="qty-btn minus"><i class="bi bi-dash"></i></button>
                          <input type="number" class="qty-input" value="1" min="1" max="{{ $deal->stock }}">
                          <button class="qty-btn plus"><i class="bi bi-plus"></i></button>
                          <button class="add-to-cart-btn"
                                  data-uid="{{ $uid }}"
                                  data-product-id="{{ $deal->id }}"
                                  data-product-type="hotdeal">
                            <i class="bi bi-check-lg"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach

              {{-- Empty State --}}
              @if($products->isEmpty() && $hotDeals->isEmpty())
              <div class="col-12 text-center py-5">
                @if($selectedCategory !== 'all')
                  <div style="padding: 60px 20px;">
                    <i class="bi bi-hourglass-split text-success" style="font-size:3.5rem;"></i>
                    <h4 class="mt-3 fw-bold">Coming Soon!</h4>
                    <p class="text-muted mt-2">
                      <strong>{{ ucfirst($selectedCategory) }}</strong> category-তে শীঘ্রই products আসছে 🚀
                    </p>
                    <a href="{{ route('shop') }}" class="btn btn-success mt-2 px-4">
                      <i class="bi bi-arrow-left me-1"></i> সব Products দেখুন
                    </a>
                  </div>
                @else
                  <img src="{{ asset('frontend/image/nodata.png') }}" alt="" style="max-width:200px;opacity:0.5;">
                  <p class="text-muted mt-3">কোনো product পাওয়া যায়নি।</p>
                @endif
              </div>
              @endif

            </div>
          </div>
        </div>
        {{-- PAGINATION --}}
            @if($paginatedItems->hasPages())
            <div class="d-flex flex-column align-items-center gap-2 pb-4">
              <p class="text-muted small mb-1">
                Showing {{ $paginatedItems->firstItem() }}–{{ $paginatedItems->lastItem() }}
                of {{ $total }} products
              </p>
              <nav>
                <ul class="pagination pagination-shop mb-0">

                  {{-- Prev --}}
                  <li class="page-item {{ $paginatedItems->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link"
                       href="{{ $paginatedItems->previousPageUrl() }}"
                       aria-label="Previous">
                      <i class="bi bi-chevron-left"></i>
                    </a>
                  </li>

                  {{-- Page Numbers --}}
                  @foreach($paginatedItems->getUrlRange(1, $paginatedItems->lastPage()) as $pg => $url)
                    <li class="page-item {{ $pg == $paginatedItems->currentPage() ? 'active' : '' }}">
                      <a class="page-link" href="{{ $url }}">{{ $pg }}</a>
                    </li>
                  @endforeach

                  {{-- Next --}}
                  <li class="page-item {{ !$paginatedItems->hasMorePages() ? 'disabled' : '' }}">
                    <a class="page-link"
                       href="{{ $paginatedItems->nextPageUrl() }}"
                       aria-label="Next">
                      <i class="bi bi-chevron-right"></i>
                    </a>
                  </li>

                </ul>
              </nav>
            </div>
            @endif

      </div>
    </div>
  </section>
</main>

{{-- CART DRAWER --}}
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
    <a href="{{ route('shop') }}" class="cp-checkout-btn">
      <i class="bi bi-bag-check-fill me-1"></i> Checkout
    </a>
  </div>
</div>

{{-- QUICK VIEW MODAL --}}
<div class="qv-backdrop" id="qvBackdrop">
  <div class="qv-modal" role="dialog" aria-modal="true">
    <button class="qv-close" id="qvClose"><i class="bi bi-x"></i></button>
    <div class="qv-img-side"><img id="qvImg" src="" alt="quick-view"></div>
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
      <p class="qv-desc" id="qvDesc">Fresh, naturally grown product. Packed with nutrients and flavour.</p>
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
<script>
  window.checkoutUrl = "{{ route('checkout.show') }}";
</script>

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/mixitup@3/dist/mixitup.min.js" defer></script>
  <script src="{{ asset('frontend/js/wishlist.js') }}" defer></script>
  <script src="{{ asset('frontend/js/shop.js') }}" defer></script>
@endpush