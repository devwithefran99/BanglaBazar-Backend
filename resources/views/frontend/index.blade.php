@extends('frontend.layouts.app')

@section('title', 'Home')
@section('meta_description', 'BanglaBazar24/7 — Chattogram এর trusted online grocery store। Fresh vegetables, fish, meat, spices সহ সব ধরনের পণ্য সেরা দামে।')
@section('og_title', 'BanglaBazar24/7 — Online Grocery Store')
@section('og_description', 'Fresh groceries delivered to your door. Shop now at BanglaBazar24/7.')

@push('styles')
  <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
@endpush

@section('content')

{{-- HERO BANNER --}}
<section id="heroBanner" class="py-2 mt-3">
  <div class="container-fluid container-md px-2 px-md-3">
    <div class="row g-2">

      <div class="col-12 col-md-8">
        <div class="main-slider position-relative overflow-hidden rounded">
          <div class="slides position-relative w-100 h-100">
            <div class="slide active">
              <a href="{{ route('shop') }}"><img src="{{ asset('frontend/image/sorishaBnr.png') }}" class="w-100" alt="সরিষা তেল ও মশলা — BanglaBazar এ সেরা দামে"></a>
            </div>
            <div class="slide">
              <a href="{{ route('shop') }}"><img src="{{ asset('frontend/image/elishBanner.png') }}" class="w-100" alt="তাজা ইলিশ মাছ — BanglaBazar এ অর্ডার করুন"></a>
            </div>
            <div class="slide">
              <a href="{{ route('shop') }}"><img src="{{ asset('frontend/image/bannerOffer.png') }}" class="w-100" alt="BanglaBazar বিশেষ অফার — সীমিত সময়ের ছাড়"></a>
            </div>
          </div>
          <button class="slider-prev">&#10094;</button>
          <button class="slider-next">&#10095;</button>
        </div>
      </div>

      <div class="col-12 col-md-4">
        <div class="row g-2 h-100">
          <div class="col-6 col-md-12">
            <a href="{{ route('shop') }}"><img src="{{ asset('frontend/image/khasiBnr.png') }}" class="w-100" alt="তাজা খাসির মাংস — BanglaBazar Chattogram"></a>
          </div>
          <div class="col-6 col-md-12">
            <a href="{{ route('shop') }}"><img src="{{ asset('frontend/image/bannerSm2.png') }}" class="w-100 h-100 rounded object-fit-cover" alt="BanglaBazar — তাজা পণ্য দ্রুত ডেলিভারি"></a>
          </div>
        </div>
      </div>

    </div>

    <div class="bg-light border border-secondary-subtle rounded-3 mt-3 p-2">
  <div class="row text-center g-0">
    <div class="col-3 border-end border-secondary-subtle d-flex flex-column align-items-center justify-content-center py-2 px-1">
      <i class="bi bi-wallet2" style="font-size:22px; color:#6f42c1;"></i>
      <p class="mb-0 mt-1" style="font-size:9px; line-height:1.3; color:#555; font-weight:600;">Cash On<br>Delivery</p>
    </div>
    <div class="col-3 border-end border-secondary-subtle d-flex flex-column align-items-center justify-content-center py-2 px-1">
      <i class="bi bi-truck" style="font-size:22px; color:#0d6efd;"></i>
      <p class="mb-0 mt-1" style="font-size:9px; line-height:1.3; color:#555; font-weight:600;">Fast<br>Delivery</p>
    </div>
    <div class="col-3 border-end border-secondary-subtle d-flex flex-column align-items-center justify-content-center py-2 px-1">
      <i class="bi bi-headset" style="font-size:22px; color:#198754;"></i>
      <p class="mb-0 mt-1" style="font-size:9px; line-height:1.3; color:#555; font-weight:600;">Customer<br>Support</p>
    </div>
    <div class="col-3 d-flex flex-column align-items-center justify-content-center py-2 px-1">
      <i class="bi bi-tags" style="font-size:22px; color:#fd7e14;"></i>
      <p class="mb-0 mt-1" style="font-size:9px; line-height:1.3; color:#555; font-weight:600;">Best<br>Deals</p>
    </div>
  </div>
</div>

  </div>
</section>

{{-- CATEGORIES --}}
<section>
  <div class="container">
    <div class="section-wrapper">
      <div class="section-header">
        <h2 class="section-title">Popular <span>Categories</span></h2>
      </div>
      <div class="cat-slider-outer">
        <div class="row g-2 cat-track">
          @foreach($categories as $cat)
          <div class="col-6 col-md-3 col-lg-2 cat-col cat-card">
            <div class="img-box">
              <a href="{{ route('shop') }}?category={{ $cat->slug }}">
                @if($cat->image)
                  <img src="{{ asset('storage/'.$cat->image) }}" alt="{{ $cat->name }}">
                @else
                  <img src="{{ asset('frontend/image/image 1 (1).png') }}" alt="{{ $cat->name }}">
                @endif
              </a>
            </div>
            <span class="cat-name">{{ $cat->name }}</span>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>

{{-- POPULAR PRODUCTS --}}
<section id="populer">
  <div class="container px-3 py-4">
    <div class="section-header">
      <h2 style="font-size:30px;font-weight:700;margin:0;">
        Popular <span style="color:#22c55e;">Products</span>
      </h2>
      <a href="{{ route('shop') }}" class="view-all">View All <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-3">
      @forelse($popularProducts as $product)
      @php
        $inWishlist = Auth::check()
          ? Auth::user()->wishlists->pluck('product_id')->contains($product->id)
          : false;
        $uid = 'product-' . $product->id;
      @endphp
      <div class="col">
        <div class="product-card h-100" style="cursor:pointer;">
          @if($product->hasSale())
            <div class="sale-badge">Sale {{ $product->salePercent() }}%</div>
          @endif
          <div class="product-img-wrap">
            <div class="img-overlay">
              <div class="overlay-icons">
                <button class="wishlist-btn"
                        data-product-id="{{ $product->id }}"
                        data-product-slug="{{ $product->slug }}"
                        data-product-type="product"
                        title="Wishlist">
                  <i class="bi bi-heart{{ $inWishlist ? '-fill' : '' }}"
                     style="{{ $inWishlist ? 'color:#e74c3c;' : '' }}"></i>
                </button>
                <button title="Quick View"
        data-id="{{ $product->id }}"
        data-type="product"
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
            <a href="{{ route('product', $product->slug) }}"
               class="product-name"
               style="text-decoration:none;color:inherit;display:block;">
              {{ $product->name }}
            </a>
            <div class="stars">
              <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              <i class="bi bi-star empty"></i>
            </div>
            @if($product->variations->count() > 0)
            <div class="var-badges">
              @foreach($product->variations->take(3) as $var)
                <span class="var-badge">{{ $var->label }}</span>
              @endforeach
              @if($product->variations->count() > 3)
                <span class="var-badge var-more">+{{ $product->variations->count() - 3 }}</span>
              @endif
            </div>
            @endif
            <div class="price-row">
              <div class="price-block">
                <span class="price-main">৳{{ number_format($product->price, 2) }}</span>
                @if($product->hasSale())
                  <span class="price-old">৳{{ number_format($product->old_price, 2) }}</span>
                @endif
              </div>
              <div class="cart-action-wrap">
                <button class="cart-btn show-qty-btn"
                        data-uid="{{ $uid }}"
                        data-product-id="{{ $product->id }}"
                        data-product-slug="{{ $product->slug }}"
                        data-product-type="product">
                  <i class="bi bi-bag"></i>
                </button>
                <div class="qty-selector"
                     data-uid="{{ $uid }}"
                     data-product-id="{{ $product->id }}"
                     data-product-slug="{{ $product->slug }}"
                     data-product-type="product"
                     style="display:none;">
                  <button class="qty-btn minus"><i class="bi bi-dash"></i></button>
                  <input type="number" class="qty-input" value="1" min="1" max="{{ $product->stock }}">
                  <button class="qty-btn plus"><i class="bi bi-plus"></i></button>
                  <button class="add-to-cart-btn"
                          data-uid="{{ $uid }}"
                          data-product-id="{{ $product->id }}"
                          data-product-slug="{{ $product->slug }}"
                          data-product-type="product">
                    <i class="bi bi-check-lg"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @empty
      <div class="col-12 text-center py-5 text-muted">No products yet.</div>
      @endforelse
    </div>
  </div>
</section>

{{-- DISCOUNT BANNER --}}
<section id="discountBanner">
  <div class="container">
    <div class="row">
      <div class="discountBnr"></div>
    </div>
  </div>
</section>

{{-- HOT DEALS --}}
<section id="hotDeals">
  <div class="container" style="padding:24px 16px;">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;">
      <h2 style="font-size:30px;font-weight:700;margin-top:30px;">
        Hot <span style="color:#22c55e;">Deals</span>
      </h2>
      <a href="{{ route('shop') }}" style="color:#22c55e;font-size:14px;font-weight:500;text-decoration:none;">
        View All <i class="bi bi-arrow-right"></i>
      </a>
    </div>

    <div class="row g-3">
      @if($hotDeals->isNotEmpty())
        @php $featured = $hotDeals->first(); $featuredUid = 'hotdeal-' . $featured->id; @endphp

        {{-- Featured Big Card --}}
        <div class="col-12 col-md-6 col-lg-4">
          <div class="featured-card">
            @if($featured->hasSale())
              <div class="sale-badge">Sale {{ $featured->salePercent() }}%</div>
            @endif
            <div class="best-badge">Best Sale</div>
            <div class="featured-img-wrap">
              @if($featured->image)
                <img src="{{ asset('storage/'.$featured->image) }}" alt="{{ $featured->name }}">
              @else
                <img src="{{ asset('frontend/image/bigApple.png') }}" alt="{{ $featured->name }}">
              @endif
            </div>
            <div class="featured-action-row">
              <a href="{{ route('wishlist') }}" class="icon-btn"><i class="bi bi-heart"></i></a>
              <button class="cart-btn show-qty-btn hot-btn"
                      data-uid="{{ $featuredUid }}"
                      data-product-id="{{ $featured->id }}"
                      data-product-type="hotdeal"
                      data-product-slug="{{ $featured->slug }}">
                      
                <i class="bi bi-bag">Add to Cart</i>
              </button>
             <button title="Quick View" class="icon-btn"
        data-id="{{ $featured->id }}"
        data-type="hotdeal"
        data-stock="{{ $featured->stock }}">
  <i class="bi bi-eye"></i>
</button>
            </div>
            <div class="qty-selector"
                 data-uid="{{ $featuredUid }}"
                 data-product-id="{{ $featured->id }}"
                 data-product-type="hotdeal"
                 data-product-slug="{{ $featured->slug }}"
                 style="display:none;">
              <button class="qty-btn minus"><i class="bi bi-dash"></i></button>
              <input type="number" class="qty-input" value="1" min="1" max="{{ $featured->stock }}">
              <button class="qty-btn plus"><i class="bi bi-plus"></i></button>
              <button class="add-to-cart-btn"
                      data-uid="{{ $featuredUid }}"
                      data-product-id="{{ $featured->id }}"
                      data-product-type="hotdeal"
                      data-product-slug="{{ $featured->slug }}">
                <i class="bi bi-check-lg"></i>
              </button>
            </div>
            <div class="featured-info">
              <div class="name">{{ $featured->name }}</div>
              <div class="prices">
                ৳{{ number_format($featured->price, 2) }}
                @if($featured->hasSale())
                  <span class="old">৳{{ number_format($featured->old_price, 2) }}</span>
                @endif
              </div>
              <div class="feedback">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                <i class="bi bi-star-half"></i>
              </div>
              @if($featured->deal_ends_at && $featured->isLive())
                <div class="hurry">Hurry up! Offer ends in:</div>
                <div class="countdown" data-ends="{{ $featured->deal_ends_at->timestamp * 1000 }}">
                  <div class="cd-box"><span class="num cd-days">00</span><span class="lbl">Days</span></div>
                  <span class="cd-sep">:</span>
                  <div class="cd-box"><span class="num cd-hours">00</span><span class="lbl">Hours</span></div>
                  <span class="cd-sep">:</span>
                  <div class="cd-box"><span class="num cd-mins">00</span><span class="lbl">Mins</span></div>
                  <span class="cd-sep">:</span>
                  <div class="cd-box"><span class="num cd-secs">00</span><span class="lbl">Secs</span></div>
                </div>
              @endif
            </div>
          </div>
        </div>

        {{-- Right Grid --}}
        <div class="col-12 col-md-6 col-lg-8">
          <div class="row g-3">
            @foreach($hotDeals->skip(1)->take(6) as $deal)
            @php
              $inWishlistDeal = Auth::check()
                ? Auth::user()->wishlists->pluck('product_id')->contains($deal->id)
                : false;
              $uid = 'hotdeal-' . $deal->id;
            @endphp
            <div class="col-6 col-lg-4">
              <div class="hotProduct-card" style="cursor:pointer;">
                @if($deal->hasSale())
                  <div class="sale-badge">Sale {{ $deal->salePercent() }}%</div>
                @endif
                <div class="product-img-wrap">
                  <div class="img-overlay">
                    <div class="overlay-icons">
                      <button class="wishlist-btn"
                              data-product-id="{{ $deal->id }}"
                              data-product-type="hotdeal"
                              data-product-slug="{{ $deal->slug }}"
                              title="Wishlist">
                        <i class="bi bi-heart{{ $inWishlistDeal ? '-fill' : '' }}"
                           style="{{ $inWishlistDeal ? 'color:#e74c3c;' : '' }}"></i>
                      </button>
                     <button title="Quick View"
        data-id="{{ $deal->id }}"
        data-type="hotdeal"
        data-stock="{{ $deal->stock }}">
  <i class="bi bi-eye"></i>
</button>
                    </div>
                  </div>
                  @if($deal->image)
                    <img src="{{ asset('storage/'.$deal->image) }}" alt="{{ $deal->name }}">
                  @else
                    <img src="{{ asset('frontend/image/Product Image (1).png') }}" alt="{{ $deal->name }}">
                  @endif
                </div>
                <div class="card-body-custom">
                  <a href="{{ route('product', ['slug' => $deal->slug]) }}?type=hotdeal"
                    data-product-slug="{{ $deal->slug }}"
                     class="product-name"
                     style="text-decoration:none;color:inherit;">
                    {{ $deal->name }}
                  </a>
                  <div class="stars">
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    <i class="bi bi-star empty"></i>
                  </div>
                  @if($deal->variations->count() > 0)
                  <div class="var-badges">
                    @foreach($deal->variations->take(3) as $var)
                      <span class="var-badge">{{ $var->label }}</span>
                    @endforeach
                    @if($deal->variations->count() > 3)
                      <span class="var-badge var-more">+{{ $deal->variations->count() - 3 }}</span>
                    @endif
                  </div>
                  @endif
                  <div class="price-row">
                    <div class="price-block">
                      <span class="price-main">৳{{ number_format($deal->price, 2) }}</span>
                      @if($deal->hasSale())
                        <span class="price-old">৳{{ number_format($deal->old_price, 2) }}</span>
                      @endif
                    </div>
                    <div class="cart-action-wrap">
                      <button class="cart-btn show-qty-btn"
                              data-uid="{{ $uid }}"
                              data-product-id="{{ $deal->id }}"
                              data-product-type="hotdeal">
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
                  @if($deal->deal_ends_at && $deal->isLive())
                    <div class="countdown mt-1" data-ends="{{ $deal->deal_ends_at->timestamp * 1000 }}">
                      <div class="cd-box"><span class="num cd-days">00</span><span class="lbl">D</span></div>
                      <span class="cd-sep">:</span>
                      <div class="cd-box"><span class="num cd-hours">00</span><span class="lbl">H</span></div>
                      <span class="cd-sep">:</span>
                      <div class="cd-box"><span class="num cd-mins">00</span><span class="lbl">M</span></div>
                      <span class="cd-sep">:</span>
                      <div class="cd-box"><span class="num cd-secs">00</span><span class="lbl">S</span></div>
                    </div>
                  @endif
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>

        {{-- Bottom Row --}}
        @foreach($hotDeals->skip(7)->take(5) as $deal)
        @php
          $inWishlistBottom = Auth::check()
            ? Auth::user()->wishlists->pluck('product_id')->contains($deal->id)
            : false;
          $uid = 'hotdeal-' . $deal->id;
        @endphp
        <div class="bottom-col {{ $loop->last ? 'd-none d-lg-block' : '' }}">
          <div class="hotProduct-card">
            @if($deal->hasSale())
              <div class="sale-badge">Sale {{ $deal->salePercent() }}%</div>
            @endif
            <div class="product-img-wrap">
              <div class="img-overlay">
                <div class="overlay-icons">
                  <button class="wishlist-btn"
                          data-product-id="{{ $deal->id }}"
                          data-product-type="hotdeal"
                          data-product-slug="{{ $deal->slug }}"
                          title="Wishlist">
                    <i class="bi bi-heart{{ $inWishlistBottom ? '-fill' : '' }}"
                       style="{{ $inWishlistBottom ? 'color:#e74c3c;' : '' }}"></i>
                  </button>
                 <button title="Quick View"
        data-id="{{ $deal->id }}"
        data-type="hotdeal"
        data-stock="{{ $deal->stock }}">
  <i class="bi bi-eye"></i>
</button>
                </div>
              </div>
              @if($deal->image)
                <img src="{{ asset('storage/'.$deal->image) }}" alt="{{ $deal->name }}">
              @else
                <img src="{{ asset('frontend/image/hotProduct1 (4).png') }}" alt="{{ $deal->name }}">
              @endif
            </div>
            <div class="card-body-custom">
             <a href="{{ route('product', ['slug' => $deal->slug]) }}?type=hotdeal"
              data-product-slug="{{ $deal->slug }}"
                 class="product-name"
                 style="text-decoration:none;color:inherit;">
                {{ $deal->name }}
              </a>
              <div class="stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star empty"></i><i class="bi bi-star empty"></i>
              </div>
              <div class="price-row">
                <div class="price-block">
                  <span class="price-main">৳{{ number_format($deal->price, 2) }}</span>
                </div>
                <div class="cart-action-wrap">
                  <button class="cart-btn show-qty-btn"
                          data-uid="{{ $uid }}"
                          data-product-id="{{ $deal->id }}"
                          data-product-type="hotdeal">
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

      @else
        <div class="col-12 text-center py-5 text-muted">No hot deals available at the moment.</div>
      @endif
    </div>
  </div>
</section>


{{-- ═══════════════════════════════════════════════
     YouTube Section — home.blade.php এ paste করো
     ════════════════════════════════════════════════
     👉 $ytVideoId    → তোমার YouTube Video ID
     👉 $ytChannelUrl → তোমার Channel URL
═══════════════════════════════════════════════ --}}

@php
    $ytVideoId    = 'Je5AVa_RZaA';
    $ytChannelUrl = 'https://www.youtube.com/@Banglabazar247';
    $ytThumb      = 'https://img.youtube.com/vi/' . $ytVideoId . '/maxresdefault.jpg';
@endphp

<section class="yt-section">
  <div class="container">
    <div class="yt-inner">

      {{-- ── বাম পাশ: Content ── --}}
      <div class="yt-content">

        <div class="yt-badge">
          <span class="yt-badge-dot"></span>
          আমাদের YouTube চ্যানেল
        </div>

        <h2>আমাদের YouTube চ্যানেলে স্বাগতম!</h2>

        <p>
          প্রতিদিনের খাবারের মাধ্যমে অজান্তেই আমরা নানা রোগের দিকে এগিয়ে যাচ্ছি।
          তাই এখনই সচেতন হওয়ার সময়। খাবার কেনার আগে এর উৎস, মান ও নিরাপত্তা
          সম্পর্কে নিশ্চিত হোন। নিজের এবং পরিবারের সুস্বাস্থ্যের জন্য নিরাপদ,
          বিশুদ্ধ ও ভেজালমুক্ত খাদ্য বেছে নিন।
        </p>

        <div class="yt-btns">
          <button class="btn-yt-watch" onclick="ytPlay()">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="white"><path d="M8 5v14l11-7z"/></svg>
            ভিডিও দেখুন
          </button>
          <a class="btn-yt-subscribe" href="{{ $ytChannelUrl }}" target="_blank" rel="noopener">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
              <path d="M23.5 6.2a3 3 0 0 0-2.1-2.1C19.5 3.6 12 3.6 12 3.6s-7.5 0-9.4.5A3 3 0 0 0 .5 6.2C0 8.1 0 12 0 12s0 3.9.5 5.8a3 3 0 0 0 2.1 2.1c1.9.5 9.4.5 9.4.5s7.5 0 9.4-.5a3 3 0 0 0 2.1-2.1C24 15.9 24 12 24 12s0-3.9-.5-5.8zM9.7 15.5V8.5l6.3 3.5-6.3 3.5z"/>
            </svg>
            Subscribe করুন
          </a>
        </div>

      </div>

      {{-- ── ডান পাশ: Video ── --}}
      <div class="yt-video-box" id="ytVideoBox" onclick="ytPlay()">

        {{-- Thumbnail --}}
        <div class="yt-thumbnail" id="ytThumbnail">
          <img
            src="{{ $ytThumb }}"
            alt="YouTube ভিডিও থাম্বনেইল"
            onerror="this.src='https://img.youtube.com/vi/{{ $ytVideoId }}/hqdefault.jpg'"
          >
          <div class="yt-thumb-overlay"></div>
        </div>

        {{-- Play Button (centered) --}}
        <div class="yt-play-center" id="ytPlayCenter">
          <div class="yt-play-btn">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="white"><path d="M8 5v14l11-7z"/></svg>
          </div>
        </div>

        <span class="yt-hover-label" id="ytHoverLabel">▶ ক্লিক করুন দেখতে</span>

        {{-- iframe — click এ load হবে --}}
        <div class="yt-iframe-wrap" id="ytIframeWrap">
          <iframe id="ytIframe" src="" allow="autoplay; encrypted-media" allowfullscreen></iframe>
        </div>

      </div>

    </div>
  </div>
</section>

@push('scripts')
<script>
(function () {
  var VIDEO_ID  = '{{ $ytVideoId }}';
  var playing   = false;

  window.ytPlay = function () {
    if (playing) return;
    playing = true;

    document.getElementById('ytIframe').src =
      'https://www.youtube.com/embed/' + VIDEO_ID + '?autoplay=1&rel=0';

    document.getElementById('ytIframeWrap').classList.add('playing');
    document.getElementById('ytThumbnail').style.opacity  = '0';
    document.getElementById('ytPlayCenter').style.display = 'none';
    document.getElementById('ytHoverLabel').style.display = 'none';
    document.getElementById('ytVideoBox').style.cursor    = 'default';
  };
})();
</script>
@endpush

{{-- FEATURE PRODUCTS --}}
<section id="featureProduct" class="new-trends-section">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center">
      <h2 class="section-title text-dark">
        Feature <span style="color:#22c55e;">Product</span>
      </h2>
      <div class="d-flex gap-2">
        <button class="arrow-btn prev">&#8249;</button>
        <button class="arrow-btn next">&#8250;</button>
      </div>
    </div>

    <div class="slider-wrapper">
      <div class="slider-track">
        @forelse($featureProducts as $product)
        @php
          $inWishlist = Auth::check()
            ? Auth::user()->wishlists->pluck('product_id')->contains($product->id)
            : false;
          $uid = 'product-' . $product->id;
        @endphp
        <div class="slider-product">
          @if($product->hasSale())
            <div class="sale-badge">৳{{ number_format($product->old_price - $product->price, 0) }} OFF</div>
          @endif
          <div class="product-img-wrap">
            <div class="img-overlay">
              <div class="overlay-icons">
                <button class="wishlist-btn"
                        data-product-id="{{ $product->id }}"
                        data-product-slug="{{ $product->slug }}"
                        data-product-type="product"
                        title="Wishlist">
                  <i class="bi bi-heart{{ $inWishlist ? '-fill' : '' }}"
                     style="{{ $inWishlist ? 'color:#e74c3c;' : '' }}"></i>
                </button>
               <button title="Quick View" class="icon-btn"
        data-id="{{ $featured->id }}"
        data-type="hotdeal"
        data-stock="{{ $featured->stock }}">
  <i class="bi bi-eye"></i>
</button>
              </div>
            </div>
            @if($product->image)
              <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
            @else
              <img src="{{ asset('frontend/image/Product Image (1).png') }}" alt="{{ $product->name }}">
            @endif
          </div>
          <div class="card-body-custom">
           <a href="{{ route('product', $product->slug) }}"
            data-product-slug="{{ $product->slug }}"
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
                <span class="price-main">৳{{ number_format($product->price, 2) }}</span>
                @if($product->hasSale())
                  <span class="price-old">৳{{ number_format($product->old_price, 2) }}</span>
                @endif
              </div>
              <div class="cart-action-wrap">
                <button class="cart-btn show-qty-btn"
                        data-uid="{{ $uid }}"
                        data-product-id="{{ $product->id }}"
                        data-product-slug="{{ $product->slug }}"
                        data-product-type="product">
                  <i class="bi bi-bag"></i>
                </button>
                <div class="qty-selector"
                     data-uid="{{ $uid }}"
                     data-product-id="{{ $product->id }}"
                     data-product-slug="{{ $product->slug }}"
                     data-product-type="product"
                     style="display:none;">
                  <button class="qty-btn minus"><i class="bi bi-dash"></i></button>
                  <input type="number" class="qty-input" value="1" min="1" max="{{ $product->stock }}">
                  <button class="qty-btn plus"><i class="bi bi-plus"></i></button>
                  <button class="add-to-cart-btn"
                          data-uid="{{ $uid }}"
                          data-product-id="{{ $product->id }}"
                          data-product-slug="{{ $product->slug }}"
                          data-product-type="product">
                    <i class="bi bi-check-lg"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 text-muted">No featured products yet.</div>
        @endforelse
      </div>
    </div>
    <div class="slider-dots"></div>
  </div>
</section>

{{-- TESTIMONIALS --}}
@if(isset($testimonials) && $testimonials->count() > 0)
<section id="feedback" class="py-5">
  <div class="container">
    <h2 class="section-title text-start">
      Client <span style="color:#22c55e;">Testimonials</span>
    </h2>
    <div class="owl-carousel testimonial-slider">
      @foreach($testimonials as $review)
      <div class="testimonial-card">
        <div class="quote">"</div>
        <p class="testimonial-text">{{ $review->body ?? 'Great product! Highly recommended.' }}</p>
        <div class="client-info">
          <div class="client-left">
            <div class="client-img"
                 style="width:48px;height:48px;border-radius:50%;background:#dcfce7;
                        display:flex;align-items:center;justify-content:center;
                        font-size:18px;font-weight:700;color:#16a34a;flex-shrink:0;">
              {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
            </div>
            <div>
              <p class="client-name">{{ $review->user->name ?? 'Customer' }}</p>
              <p class="client-role">Verified Customer</p>
            </div>
          </div>
          <div class="stars">
            @for($s = 1; $s <= 5; $s++)
              <span style="color:{{ $s <= $review->rating ? '#f59e0b' : '#cbd5e1' }};font-size:16px;">★</span>
            @endfor
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif

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

{{-- CART DRAWER --}}
<div class="cp-overlay" id="cpOverlay"></div>
<div class="cp-drawer" id="cpDrawer">
  <div class="cp-header">
    <div class="cp-title"><img src=" {{ asset('frontend/image/ourlogo.png') }}" alt="Logo"></div>
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
  <script src="{{ asset('frontend/js/wishlist.js') }}"></script>
  <script src="{{ asset('frontend/js/app.js') }}"></script>
@endpush