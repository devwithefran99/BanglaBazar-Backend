@extends('frontend.layouts.app')

@php
    $hasImage   = !empty($item->image);
    $imageSrc   = $hasImage ? asset('storage/' . $item->image) : asset('frontend/image/Product Image (1).png');
    $hasSale    = $item->hasSale();
    $saleAmt    = $hasSale ? number_format($item->old_price - $item->price, 2) : null;
    $salePct    = $hasSale ? $item->salePercent() : null;
    $inWishlist = Auth::check()
                    ? Auth::user()->wishlists->pluck('product_id')->contains($item->id)
                    : false;

    // Variation support
   $variations = $item->variations()->orderBy('id')->get();
    $hasVariations  = $variations->count() > 0;
    $defaultVar     = $hasVariations ? ($variations->where('is_default', true)->first() ?? $variations->first()) : null;

    // Default price/stock (variation থাকলে default variation এর, না হলে product এর)
    $initPrice      = $hasVariations ? $defaultVar->price    : $item->price;
    $initOldPrice   = $hasVariations ? $defaultVar->old_price : $item->old_price;
    $initStock      = $hasVariations ? $defaultVar->stock    : $item->stock;
    $initVariationId = $hasVariations ? $defaultVar->id      : null;

    $checkoutUrl = url('/checkout') . '?source=buynow&type=' . $type . '&id=' . $item->id . '&qty=1'
                 . ($hasVariations ? '&variation_id=' . $initVariationId : '');
@endphp

@section('title', $item->name ?? 'Product')
@section('meta_description', $item->description ? Str::limit($item->description, 160) : 'Buy ' . ($item->name ?? 'product') . ' at the best price from BanglaBazar — fresh quality delivered to your door.')
@section('og_title', ($item->name ?? 'Product') . ' | BanglaBazar24/7')
@section('og_description', $item->description ? Str::limit($item->description, 160) : 'Shop fresh quality products at BanglaBazar.')
@section('og_image', $imageSrc)

@push('styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
  <link rel="stylesheet" href="{{ asset('frontend/css/pages.css') }}">
@endpush

@section('content')

{{-- PRODUCT DETAIL --}}
<section id="productDetail">
    <div class="container">
        <div class="pd-wrap">

            {{-- GALLERY --}}
            <div class="pd-gallery">
                <div class="pd-thumbs" id="thumbs">
                    <div class="pd-thumb active" onclick="switchMain(this, '{{ $imageSrc }}')">
                        <img src="{{ $imageSrc }}" alt="{{ $item->name }}">
                    </div>
                </div>
                <div class="pd-main-img-wrap">
                    <img id="mainImg" src="{{ $imageSrc }}" alt="{{ $item->name }}">
                </div>
            </div>

            {{-- PRODUCT INFO --}}
            <div class="pd-info">
                {{-- Stock badge --}}
                @if($initStock > 0)
                    <span class="pd-badge" id="pdStockBadge">In Stock</span>
                @else
                    <span class="pd-badge" id="pdStockBadge" style="background:#fee2e2;color:#dc2626;">Out of Stock</span>
                @endif
                @if($type === 'hotdeal')
                    <span class="pd-badge" style="background:#fff7ed;color:#ea580c;margin-left:6px;">🔥 Hot Deal</span>
                @endif

                <h1 class="pd-title">{{ $item->name }}</h1>

                <div class="pd-rating">
                    <div class="pd-stars">
                        @php $avg = $item->avg_rating ?? 0; @endphp
                        @for($s = 1; $s <= 5; $s++)
                        <svg class="pd-star{{ $s <= round($avg) ? '' : ' empty' }}" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        @endfor
                    </div>
                    <span class="pd-reviews">
                        {{ $item->review_count > 0 ? $item->review_count . ' Reviews' : 'No reviews yet' }}
                    </span>
                    <span class="pd-sku">• SKU: {{ str_pad($item->id, 6, '0', STR_PAD_LEFT) }}</span>
                </div>

                {{-- PRICE ROW --}}
                <div class="pd-price-row">
                    @if($initOldPrice && $initOldPrice > $initPrice)
                        <span class="pd-price-old" id="pdPriceOld">৳{{ number_format($initOldPrice, 2) }}</span>
                        <span class="pd-price-now" id="pdPriceNow">৳{{ number_format($initPrice, 2) }}</span>
                        <span class="pd-discount" id="pdDiscount">
                            {{ round((($initOldPrice - $initPrice) / $initOldPrice) * 100) }}% Off
                        </span>
                    @else
                        <span class="pd-price-old" id="pdPriceOld" style="display:none"></span>
                        <span class="pd-price-now" id="pdPriceNow">৳{{ number_format($initPrice, 2) }}</span>
                        <span class="pd-discount" id="pdDiscount" style="display:none"></span>
                    @endif
                </div>

                <div class="pd-divider"></div>

                {{-- ══ VARIATION SELECTOR ══ --}}
                @if($hasVariations)
                <div class="pd-variations" style="margin-bottom:16px;">
                    <div style="font-size:13px;font-weight:600;color:#374151;margin-bottom:8px;">
                        পরিমাণ / Size বেছে নিন:
                    </div>
                    <div style="display:flex;flex-wrap:wrap;gap:8px;" id="variationBtns">
                        @foreach($variations as $var)
                        <button type="button"
                                class="pd-var-btn {{ $var->is_default ? 'pd-var-active' : '' }}"
                                data-id="{{ $var->id }}"
                                data-price="{{ $var->price }}"
                                data-old-price="{{ $var->old_price ?? '' }}"
                                data-stock="{{ $var->stock }}"
                                data-label="{{ $var->label }}"
                                onclick="selectVariation(this)"
                                style="
                                    padding:7px 16px;
                                    border-radius:8px;
                                    border:2px solid {{ $var->is_default ? '#16a34a' : '#e2e8f0' }};
                                    background:{{ $var->is_default ? '#f0fdf4' : '#fff' }};
                                    color:{{ $var->is_default ? '#16a34a' : '#374151' }};
                                    font-size:13px;
                                    font-weight:600;
                                    cursor:pointer;
                                    transition:all .2s;
                                    line-height:1.3;
                                    text-align:center;
                                ">
                            {{ $var->label }}
                            <br>
                            <span style="font-size:12px;font-weight:700;">৳{{ number_format($var->price, 0) }}</span>
                        </button>
                        @endforeach
                    </div>
                    <input type="hidden" id="selectedVariationId" value="{{ $initVariationId }}">
                </div>
                @endif
                {{-- ══ END VARIATION ══ --}}

                <p class="pd-desc">
                    @if($item->description)
                        {{ Str::limit($item->description, 200) }}
                    @else
                        Fresh quality product delivered right to your doorstep. Carefully sourced and packed to ensure maximum freshness and satisfaction.
                    @endif
                </p>

                <div class="pd-qty-row">
                    <span class="pd-qty-label">Quantity:</span>
                    <div class="pd-qty">
                        <button class="pd-qty-btn" id="minusBtn" onclick="changeQty(-1)">−</button>
                        <span class="pd-qty-num" id="qtyNum">1</span>
                        <button class="pd-qty-btn" onclick="changeQty(1)">+</button>
                    </div>
                    <span style="font-size:12px;color:#94a3b8;margin-left:8px;" id="pdStockCount">({{ $initStock }} available)</span>
                </div>

                <div class="pd-btns">
                    @if($initStock > 0)
                        <button class="pd-btn-cart" id="pdCartBtn"
                                data-product-id="{{ $item->id }}"
                                data-product-type="{{ $type }}"
                                onclick="pdAddToCart()">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                            </svg>
                            Add to Cart
                        </button>
                        <a id="pdBuyNowBtn" href="{{ $checkoutUrl }}" class="pd-btn-buy">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                            Buy Now
                        </a>
                    @else
                        <button class="pd-btn-cart" id="pdCartBtn" disabled style="opacity:.5;cursor:not-allowed;">Out of Stock</button>
                        <button class="pd-btn-buy" id="pdBuyNowBtn" disabled style="opacity:.5;cursor:not-allowed;">Buy Now</button>
                    @endif

                    <button class="wishlist-btn"
                            data-product-id="{{ $item->id }}"
                            data-product-type="{{ $type }}"
                            title="Add to Wishlist"
                            style="background:{{ $inWishlist ? '#fee2e2' : '#f1f5f9' }};
                                   border:1.5px solid {{ $inWishlist ? '#fca5a5' : '#e2e8f0' }};
                                   border-radius:10px;padding:10px 14px;cursor:pointer;
                                   font-size:18px;transition:all .2s;">
                        <i class="bi bi-heart{{ $inWishlist ? '-fill' : '' }}"
                           style="color:{{ $inWishlist ? '#e74c3c' : '#64748b' }};"></i>
                    </button>
                </div>

                <div class="pd-pay-row">
                    <span class="pd-pay-label">Pay via:</span>
                    <span class="pd-pay-badge"><span class="pd-pay-dot"></span> Cash on Delivery</span>
                    <span class="pd-pay-badge"><span class="pd-pay-dot bkash"></span> bKash</span>
                </div>

                @if($item->category)
                <div style="margin-top:12px;font-size:13px;color:#64748b;">
                    <strong>Category:</strong>
                    <span style="background:#f0fdf4;color:#16a34a;padding:2px 10px;
                                 border-radius:20px;font-weight:600;margin-left:4px;">
                        {{ ucfirst($item->category) }}
                    </span>
                </div>
                @endif
            </div>
        </div>

        <div class="pd-toast" id="toast"></div>
    </div>
</section>

{{-- TABS --}}
<section id="details">
    <div class="container">
        <div class="tab-wrap">
            <nav class="tab-nav">
                <button class="tab-btn active" onclick="switchTab('desc', this)">Description</button>
                <button class="tab-btn" onclick="switchTab('info', this)">Additional Information</button>
                <button class="tab-btn" onclick="switchTab('feedback', this)">Customer Feedback</button>
            </nav>

            {{-- DESCRIPTION --}}
            <div class="tab-panel active" id="tab-desc">
                <div class="desc-grid">
                    <div>
                        <h2 class="desc-heading">{{ $item->name }} — Fresh &amp; Quality</h2>
                        <p class="desc-body">
                            @if($item->description)
                                {{ $item->description }}
                            @else
                                Our product is carefully sourced and quality-checked before delivery. We ensure maximum freshness and satisfaction for every order placed through BanglaBazar.
                            @endif
                        </p>
                        <p class="desc-body">Each item is hand-selected for quality, carefully packaged and stored to preserve natural freshness from source to your doorstep.</p>
                        <ul class="desc-list">
                            <li>Premium quality — carefully selected</li>
                            <li>Fast and safe delivery</li>
                            @if($hasVariations)
                                <li>{{ $variations->count() }}টি size/weight option available</li>
                            @else
                                <li>{{ $item->stock }} units currently available</li>
                            @endif
                            @if($hasSale)
                            <li>Save ৳{{ $saleAmt }} — {{ $salePct }}% discount applied</li>
                            @endif
                            <li>Secure payment: Cash on Delivery &amp; bKash</li>
                        </ul>
                        <div class="desc-badges">
                            <span class="desc-badge green">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                </svg>
                                Premium Quality
                            </span>
                            <span class="desc-badge gold">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/>
                                </svg>
                                Fast Delivery
                            </span>
                            @if($hasSale)
                            <span class="desc-badge green">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                                {{ $salePct }}% Discount
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="desc-img-card">
                        <img src="{{ $imageSrc }}" alt="{{ $item->name }}">
                    </div>
                </div>
            </div>

            {{-- ADDITIONAL INFO --}}
            <div class="tab-panel" id="tab-info">
                <table class="info-table">
                    <tr><td>Product Name</td><td>{{ $item->name }}</td></tr>
                    @if($item->category)
                    <tr><td>Category</td><td><span class="info-chip green">{{ ucfirst($item->category) }}</span></td></tr>
                    @endif
                    @if($hasVariations)
                    <tr>
                        <td>Available Sizes</td>
                        <td>
                            @foreach($variations as $var)
                                <span style="background:#f0fdf4;color:#16a34a;padding:2px 8px;border-radius:20px;
                                             font-size:12px;font-weight:600;margin-right:4px;">
                                    {{ $var->label }} — ৳{{ number_format($var->price, 0) }}
                                </span>
                            @endforeach
                        </td>
                    </tr>
                    @else
                    <tr><td>Sale Price</td><td style="color:#22c55e;font-weight:700;">৳{{ number_format($item->price, 2) }}</td></tr>
                    @if($hasSale)
                    <tr><td>Original Price</td><td style="text-decoration:line-through;color:#94a3b8;">৳{{ number_format($item->old_price, 2) }}</td></tr>
                    <tr><td>You Save</td><td style="color:#ef4444;font-weight:700;">৳{{ $saleAmt }} ({{ $salePct }}% OFF)</td></tr>
                    @endif
                    @endif
                    <tr>
                        <td>Stock Status</td>
                        <td>
                            @if($initStock > 0)
                                <span class="info-stock">Available</span>
                                <span class="info-count">({{ $initStock }} units)</span>
                            @else
                                <span style="color:#ef4444;font-weight:600;">Out of Stock</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Product Type</td>
                        <td><span class="info-chip {{ $type === 'hotdeal' ? 'neutral' : 'green' }}">{{ $type === 'hotdeal' ? '🔥 Hot Deal' : '⭐ Regular Product' }}</span></td>
                    </tr>
                    <tr><td>SKU</td><td>{{ str_pad($item->id, 6, '0', STR_PAD_LEFT) }}</td></tr>
                    @if($type === 'hotdeal' && isset($item->deal_ends_at) && $item->deal_ends_at)
                    <tr><td>Deal Ends</td><td style="color:#ef4444;font-weight:600;">{{ $item->deal_ends_at->format('d M Y, h:i A') }}</td></tr>
                    @endif
                </table>
            </div>

            {{-- CUSTOMER FEEDBACK --}}
            <div class="tab-panel" id="tab-feedback">
                @php
                    $approvedReviews = $item->approvedReviews()->with('user')->latest()->get();
                    $avgRating       = $item->avg_rating;
                    $reviewCount     = $item->review_count;
                    $dist = [];
                    for ($i = 5; $i >= 1; $i--) {
                        $dist[$i] = $approvedReviews->where('rating', $i)->count();
                    }
                    $userReview = Auth::check()
                        ? $item->reviews()->where('user_id', Auth::id())->first()
                        : null;
                @endphp

                <div class="fb-summary">
                    <div style="text-align:center">
                        @if($avgRating)
                            <div class="fb-big-score">{{ $avgRating }}</div>
                            <div style="display:flex;gap:3px;justify-content:center;margin:6px 0">
                                @for($i = 1; $i <= 5; $i++)
                                <svg class="fb-star{{ $i <= round($avgRating) ? '' : ' empty' }}" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                @endfor
                            </div>
                            <div class="fb-score-label">{{ $reviewCount }} {{ Str::plural('review', $reviewCount) }}</div>
                        @else
                            <div style="font-size:32px;color:#cbd5e1;">☆☆☆☆☆</div>
                            <div class="fb-score-label" style="margin-top:6px;">No reviews yet</div>
                            <div style="font-size:13px;color:#94a3b8;margin-top:4px;">Be the first to review!</div>
                        @endif
                    </div>

                    @if($reviewCount > 0)
                    <div class="fb-bars">
                        @for($i = 5; $i >= 1; $i--)
                        @php $pct = $reviewCount > 0 ? round(($dist[$i] / $reviewCount) * 100) : 0; @endphp
                        <div class="fb-bar-row">
                            <span class="fb-bar-label">{{ $i }}</span>
                            <div class="fb-bar-track"><div class="fb-bar-fill" style="width:{{ $pct }}%"></div></div>
                            <span class="fb-bar-count">{{ $dist[$i] }}</span>
                        </div>
                        @endfor
                    </div>
                    @endif
                </div>

                <div class="fb-write" id="writeReviewBox">
                    @auth
                        @if($userReview)
                            <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:14px 18px;font-size:14px;color:#16a34a;">
                                ✓ You have already reviewed this product.
                                @if($userReview->status === 'pending')
                                    <span style="color:#f59e0b;"> (Awaiting Verification)</span>
                                @endif
                            </div>
                        @else
                            <div style="margin-bottom:12px;">
                                <div style="font-size:14px;color:#64748b;margin-bottom:8px;font-weight:500;">Rate this product:</div>
                                <div class="review-stars" id="reviewStars">
                                    @for($i = 1; $i <= 5; $i++)
                                    <svg class="rv-star" data-value="{{ $i }}" viewBox="0 0 24 24"
                                         style="width:32px;height:32px;cursor:pointer;fill:#e2e8f0;transition:fill .15s;stroke:none;">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                    @endfor
                                    <span id="ratingLabel" style="font-size:13px;color:#94a3b8;margin-left:10px;font-weight:500;">Click to rate</span>
                                </div>
                            </div>
                            <div id="reviewCommentBox" style="max-height:0;overflow:hidden;transition:max-height .35s ease;">
                                <textarea id="reviewBody" placeholder="Optional: Share your experience..."
                                          style="width:100%;padding:10px 12px;border-radius:8px;border:1px solid #e2e8f0;
                                                 font-size:14px;resize:none;outline:none;margin-bottom:10px;
                                                 font-family:inherit;color:#374151;" rows="3"></textarea>
                                <div style="display:flex;gap:8px;">
                                    <button type="button" onclick="submitReview()"
                                            style="padding:8px 20px;background:#16a34a;color:#fff;border:none;
                                                   border-radius:8px;font-size:14px;cursor:pointer;font-weight:500;">
                                        Submit Review
                                    </button>
                                    <button type="button" onclick="cancelReview()"
                                            style="padding:8px 16px;background:transparent;border:1px solid #e2e8f0;
                                                   border-radius:8px;font-size:14px;cursor:pointer;color:#64748b;">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                            <div id="reviewSuccess"
                                 style="display:none;background:#f0fdf4;border:1px solid #bbf7d0;
                                        border-radius:8px;padding:12px 16px;font-size:14px;color:#16a34a;">
                                ✓ Review submitted! Thank you for sharing your experience.
                            </div>
                        @endif
                    @else
                        <div style="font-size:14px;color:#64748b;padding:12px 0;">
                            <a href="{{ route('signin') }}" style="color:#16a34a;font-weight:600;">Sign in</a> to leave a review.
                        </div>
                    @endauth
                </div>

                @if($approvedReviews->count() > 0)
                <div class="fb-list" style="margin-top:24px;">
                    @foreach($approvedReviews as $review)
                    <div class="fb-item" style="padding:16px 0;border-top:1px solid #f1f5f9;">
                        <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;">
                            <div style="width:36px;height:36px;border-radius:50%;background:#dcfce7;
                                        display:flex;align-items:center;justify-content:center;
                                        font-size:14px;font-weight:600;color:#16a34a;flex-shrink:0;">
                                {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-size:14px;font-weight:600;color:#1e293b;">{{ $review->user->name ?? 'User' }}</div>
                                <div style="font-size:12px;color:#94a3b8;">{{ $review->created_at->format('d M Y') }}</div>
                            </div>
                            <div style="margin-left:auto;display:flex;gap:2px;">
                                @for($s = 1; $s <= 5; $s++)
                                <svg viewBox="0 0 24 24"
                                     style="width:14px;height:14px;fill:{{ $s <= $review->rating ? '#f59e0b' : '#e2e8f0' }};stroke:none;">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                @endfor
                                <span style="font-size:12px;color:#f59e0b;margin-left:4px;font-weight:600;">{{ $review->rating_label }}</span>
                            </div>
                        </div>
                        @if($review->body)
                        <p style="font-size:14px;color:#475569;margin:0;line-height:1.6;padding-left:46px;">
                            {{ $review->body }}
                        </p>
                        @endif
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

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
    <div class="cp-empty" id="cpEmpty">
        <i class="bi bi-bag-x"></i>
        <p>Your cart is empty</p>
        <a href="{{ route('shop') }}" class="cp-shop-link">Browse Products →</a>
    </div>
    <div class="cp-footer" id="cpFooter">
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <script src="{{ asset('frontend/js/pages.js') }}"></script>
  <script>
  // ── Base data ──
  const PD_PRODUCT_ID = {{ $item->id ?? 0 }};
  const PD_TYPE       = '{{ $type }}';
  const HAS_VARIATIONS = {{ $hasVariations ? 'true' : 'false' }};

  // Mutable state — variation select করলে এগুলো update হবে
  let PD_MAX_STOCK  = {{ $initStock }};
  let PD_BASE_PRICE = {{ $initPrice }};
  let PD_VARIATION_ID = {{ $initVariationId ?? 'null' }};

  // ── Toast ──
  function showPdToast(msg, type = 'success') {
      const toast = document.getElementById('toast');
      if (!toast) return;
      toast.textContent = msg;
      toast.style.background = type === 'error' ? '#ef4444' : '#22c55e';
      toast.classList.add('show');
      clearTimeout(toast._t);
      toast._t = setTimeout(() => toast.classList.remove('show'), 2800);
  }

  // ── Qty ──
 function changeQty(delta) {
    const el  = document.getElementById('qtyNum');
    let qty   = parseInt(el.textContent) + delta;
    if (qty > PD_MAX_STOCK) {
        showPdToast('⚠️ স্টকে মাত্র ' + PD_MAX_STOCK + 'টি পণ্য আছে!', 'error');
        qty = PD_MAX_STOCK;
    }
    qty = Math.max(1, qty);
    el.textContent = qty;
    // ✅ এই line টা add করো
    const priceEl = document.getElementById('pdPriceNow');
    if (priceEl) priceEl.textContent = '৳' + (PD_BASE_PRICE * qty).toLocaleString('en-IN');
    updateBuyNow(qty);
}

  function updateBuyNow(qty) {
      const buyBtn = document.getElementById('pdBuyNowBtn');
      if (!buyBtn) return;
      let url = '/checkout?source=buynow&type=' + PD_TYPE + '&id=' + PD_PRODUCT_ID + '&qty=' + qty;
      if (PD_VARIATION_ID) url += '&variation_id=' + PD_VARIATION_ID;
      buyBtn.href = url;
  }

  // ── Variation select ──
  function selectVariation(btn) {
      // সব buttons reset
      document.querySelectorAll('.pd-var-btn').forEach(b => {
          b.style.borderColor  = '#e2e8f0';
          b.style.background   = '#fff';
          b.style.color        = '#374151';
      });
      // selected highlight
      btn.style.borderColor = '#16a34a';
      btn.style.background  = '#f0fdf4';
      btn.style.color       = '#16a34a';

      const price    = parseFloat(btn.dataset.price);
      const oldPrice = btn.dataset.oldPrice ? parseFloat(btn.dataset.oldPrice) : null;
      const stock    = parseInt(btn.dataset.stock);
      const varId    = parseInt(btn.dataset.id);

      // State update
      PD_BASE_PRICE   = price;
      PD_MAX_STOCK    = stock;
      PD_VARIATION_ID = varId;
      document.getElementById('selectedVariationId').value = varId;

      // Price update
      const priceEl    = document.getElementById('pdPriceNow');
      const oldPriceEl = document.getElementById('pdPriceOld');
      const discEl     = document.getElementById('pdDiscount');

      priceEl.textContent = '৳' + price.toLocaleString('en-IN');

      if (oldPrice && oldPrice > price) {
          const pct = Math.round(((oldPrice - price) / oldPrice) * 100);
          oldPriceEl.textContent = '৳' + oldPrice.toLocaleString('en-IN');
          oldPriceEl.style.display = '';
          discEl.textContent = pct + '% Off';
          discEl.style.display = '';
      } else {
          oldPriceEl.style.display = 'none';
          discEl.style.display = 'none';
      }

      // Stock badge + count
      const stockBadge = document.getElementById('pdStockBadge');
      const stockCount = document.getElementById('pdStockCount');
      const cartBtn    = document.getElementById('pdCartBtn');
      const buyBtn     = document.getElementById('pdBuyNowBtn');

      if (stock > 0) {
          stockBadge.textContent   = 'In Stock';
          stockBadge.style.background = '';
          stockBadge.style.color      = '';
          if (stockCount) stockCount.textContent = '(' + stock + ' available)';
          if (cartBtn) { cartBtn.disabled = false; cartBtn.style.opacity = '1'; cartBtn.style.cursor = 'pointer'; }
          if (buyBtn)  { buyBtn.style.opacity = '1'; buyBtn.style.pointerEvents = ''; }
      } else {
          stockBadge.textContent      = 'Out of Stock';
          stockBadge.style.background = '#fee2e2';
          stockBadge.style.color      = '#dc2626';
          if (stockCount) stockCount.textContent = '(0 available)';
          if (cartBtn) { cartBtn.disabled = true; cartBtn.style.opacity = '.5'; cartBtn.style.cursor = 'not-allowed'; }
          if (buyBtn)  { buyBtn.style.opacity = '.5'; buyBtn.style.pointerEvents = 'none'; }
      }

      // qty reset to 1
      document.getElementById('qtyNum').textContent = 1;
      updateBuyNow(1);
  }

  // ── Add to Cart ──
  function pdAddToCart() {
      const qty = parseInt(document.getElementById('qtyNum').textContent) || 1;
      if (PD_MAX_STOCK <= 0) { showPdToast('❌ পণ্যটি স্টকে নেই!', 'error'); return; }

      const payload = {
          product_id:   PD_PRODUCT_ID,
          product_type: PD_TYPE,
          quantity:     qty,
      };
      if (PD_VARIATION_ID) payload.variation_id = PD_VARIATION_ID;

      fetch('{{ route("cart.add") }}', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          },
          body: JSON.stringify(payload),
      })
      .then(r => r.json())
      .then(data => {
          if (data.success) {
              const badge = document.getElementById('cartCount');
              if (badge) badge.textContent = data.cart_count ?? (parseInt(badge.textContent || '0') + 1);
              showPdToast('✅ Cart এ যোগ হয়েছে!');
          } else {
              showPdToast('❌ ' + (data.message || 'Failed to add'), 'error');
          }
      })
      .catch(() => showPdToast('⚠️ Please login first.', 'error'));
  }

  // ── Image switch ──
  function switchMain(thumb, src) {
      document.getElementById('mainImg').src = src;
      document.querySelectorAll('.pd-thumb').forEach(t => t.classList.remove('active'));
      thumb.classList.add('active');
  }

  // ── Tab switch ──
  function switchTab(id, btn) {
      document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
      document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
      document.getElementById('tab-' + id).classList.add('active');
      btn.classList.add('active');
  }

  // ── Reviews ──
  (function () {
      const PRODUCT_ID   = {{ $item->id }};
      const PRODUCT_TYPE = '{{ $type }}';
      const SUBMIT_URL   = '{{ route("review.store") }}';
      const CSRF         = '{{ csrf_token() }}';
      const labels       = { 1:'Poor', 2:'Fair', 3:'Good', 4:'Very Good', 5:'Excellent' };
      let selectedRating = 0;

      const stars      = document.querySelectorAll('.rv-star');
      const labelEl    = document.getElementById('ratingLabel');
      const commentBox = document.getElementById('reviewCommentBox');
      const successBox = document.getElementById('reviewSuccess');
      const writeBox   = document.getElementById('writeReviewBox');
      const bodyInput  = document.getElementById('reviewBody');

      if (!stars.length) return;

      stars.forEach(star => {
          star.addEventListener('mouseenter', () => {
              const val = +star.dataset.value;
              highlightStars(val);
              if (labelEl) { labelEl.textContent = labels[val]; labelEl.style.color = '#f59e0b'; }
          });
      });

      document.getElementById('reviewStars')?.addEventListener('mouseleave', () => {
          highlightStars(selectedRating);
          if (labelEl) {
              labelEl.textContent = selectedRating ? labels[selectedRating] : 'Click to rate';
              labelEl.style.color = selectedRating ? '#f59e0b' : '#94a3b8';
          }
      });

      stars.forEach(star => {
          star.addEventListener('click', () => {
              selectedRating = +star.dataset.value;
              highlightStars(selectedRating);
              if (labelEl) { labelEl.textContent = labels[selectedRating]; labelEl.style.color = '#f59e0b'; }
              if (commentBox) commentBox.style.maxHeight = '200px';
          });
      });

      function highlightStars(upTo) {
          stars.forEach(s => { s.style.fill = +s.dataset.value <= upTo ? '#f59e0b' : '#e2e8f0'; });
      }

      window.submitReview = async function () {
          if (!selectedRating) { showPdToast('Please select a star rating first.', 'error'); return; }
          const body = bodyInput ? bodyInput.value.trim() : '';
          const btn  = writeBox?.querySelector('button');
          if (btn) { btn.disabled = true; btn.textContent = 'Submitting...'; }
          try {
              const res  = await fetch(SUBMIT_URL, {
                  method: 'POST',
                  headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                  body: JSON.stringify({ product_id: PRODUCT_ID, product_type: PRODUCT_TYPE, rating: selectedRating, body: body || null }),
              });
              const data = await res.json();
              if (data.success) {
                  if (commentBox) commentBox.style.maxHeight = '0';
                  if (successBox) successBox.style.display = 'block';
                  highlightStars(0);
                  showPdToast('✓ Review submitted!', 'success');
              } else {
                  showPdToast(data.message || 'Something went wrong.', 'error');
                  if (btn) { btn.disabled = false; btn.textContent = 'Submit Review'; }
              }
          } catch (err) {
              showPdToast('Network error. Please try again.', 'error');
              if (btn) { btn.disabled = false; btn.textContent = 'Submit Review'; }
          }
      };

      window.cancelReview = function () {
          selectedRating = 0;
          highlightStars(0);
          if (commentBox) commentBox.style.maxHeight = '0';
          if (labelEl)    { labelEl.textContent = 'Click to rate'; labelEl.style.color = '#94a3b8'; }
          if (bodyInput)  bodyInput.value = '';
      };
  })();
  </script>
@endpush