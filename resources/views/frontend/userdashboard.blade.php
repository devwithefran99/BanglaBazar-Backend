@extends('frontend.layouts.app')

@section('title', 'My Account')
@section('meta_description', 'BanglaBazar আপনার account — order history, billing address এবং profile manage করুন।')

@push('styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('frontend/css/userDashboard.css') }}">
  <style>
    .udb-stats { display:flex; flex-wrap:wrap; gap:1rem; }
    .udb-stat  { flex:1 1 100px; min-width:90px; }

    /* Profile avatar fix */
    .udb-profile-inner img {
      width: 72px !important;
      height: 72px !important;
      border-radius: 50% !important;
      object-fit: cover !important;
      flex-shrink: 0;
    }
  </style>
@endpush

@section('content')

<main>
  <section id="userDash" class="udb-wrap">
    <div class="container">

     {{-- Greeting --}}
<div class="udb-greeting">
  <h2 id="udbGreeting">Hello, {{ Auth::user()->name }} ✦</h2>
  <p>Here's a summary of your account activity</p>
</div>

{{-- Hidden: pass user name to JS --}}
<span id="udbUserName" style="display:none">{{ Auth::user()->name }}</span>

      {{-- Stats --}}
      <div class="udb-stats">
        <div class="udb-stat">
          <div class="udb-stat-label">Orders</div>
          <div class="udb-stat-val">{{ Auth::user()->orders->count() }}</div>
        </div>
        <div class="udb-stat">
          <div class="udb-stat-label">Spent</div>
          <div class="udb-stat-val green">৳{{ number_format(Auth::user()->orders->sum('total_price'), 0) }}</div>
        </div>
        <div class="udb-stat">
          <div class="udb-stat-label">Tier</div>
          <div class="udb-stat-val gold">VIP</div>
        </div>
      </div>

      {{-- Profile + Billing --}}
      <div class="udb-row">

        <div class="udb-card udb-profile-card">
          <div class="udb-profile-inner">
            @if(Auth::user()->avatar)
              <img src="{{ asset('storage/'.Auth::user()->avatar) }}" alt="">
            @else
              <div style="width:72px;height:72px;border-radius:50%;
                          background:linear-gradient(135deg,#22c55e,#16a34a);
                          display:flex;align-items:center;justify-content:center;
                          font-size:28px;font-weight:700;color:#fff;flex-shrink:0;">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
              </div>
            @endif
            <div class="udb-profile-info">
              <h4>{{ Auth::user()->name }}</h4>
              <div>
                <span class="udb-vip"><i class="bi bi-star-fill"></i> VIP Member</span>
              </div>
              <button class="udb-btn-green" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                <i class="bi bi-person-pen me-1"></i> Edit Profile
              </button>
            </div>
          </div>
        </div>

        <div class="udb-card">
          <div class="udb-card-label">Billing Address</div>
          <div class="udb-billing-name">{{ Auth::user()->name }}</div>
          <div class="udb-billing-addr">
            @if(Auth::user()->address)
              {{ Auth::user()->address }}
            @else
              <span class="text-muted" style="font-size:13px;font-style:italic;">No address saved yet.</span>
            @endif
          </div>
          <button class="udb-btn-outline" data-bs-toggle="modal" data-bs-target="#editAddressModal">
            <i class="bi bi-pencil me-1"></i> Edit Address
          </button>
        </div>

      </div>

      {{-- Recent Orders --}}
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
                $firstItem  = $order->items->first();
                $imgSrc     = asset('frontend/image/Product Image.png');
                if ($firstItem) {
                  $p = $firstItem->product_type === 'hotdeal'
                    ? \App\Models\HotDeal::find($firstItem->product_id)
                    : \App\Models\Product::find($firstItem->product_id);
                  if ($p && $p->image) $imgSrc = asset('storage/'.$p->image);
                }
                $itemCount  = $order->items->count();
                $firstName  = $firstItem ? $firstItem->product_name : 'N/A';
                $extraCount = $itemCount - 1;
              @endphp
              <tr>
                <td>
                  <img src="{{ $imgSrc }}" alt="{{ $firstName }}"
                       onerror="this.src='{{ asset('frontend/image/Product Image.png') }}'"
                       class="order-thumb"
                       style="width:44px;height:44px;border-radius:8px;object-fit:cover;border:1.5px solid #f1f5f9;">
                </td>
                <td class="td-n">
                  <div style="font-weight:700;font-size:13px;color:#0f172a;">{{ Str::limit($firstName, 20) }}</div>
                  @if($extraCount > 0)
                    <div style="font-size:11px;color:#94a3b8;">+{{ $extraCount }} more</div>
                  @endif
                  <div style="font-size:11px;color:#94a3b8;">Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</div>
                </td>
                <td class="td-d udb-hide-mobile d-none d-md-table-cell">{{ $order->created_at->format('d M Y') }}</td>
                <td class="td-p" style="font-weight:700;color:#22c55e;">৳{{ number_format($order->total_price, 0) }}</td>
                <td class="d-none d-sm-table-cell">
                  <span class="udb-qty">{{ $order->items->sum('quantity') }}</span>
                </td>
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

  {{-- Return/Refund --}}
  <section>
    <div class="container">
      @if(isset($deliveredOrders) && $deliveredOrders->count() > 0)
      <hr class="my-4">
      <div class="mb-3 d-flex align-items-center gap-2">
        <div style="width:36px;height:36px;background:#f0fdf4;border-radius:10px;display:flex;align-items:center;justify-content:center;">
          <i class="bi bi-plus-circle" style="color:#22c55e;font-size:1.1rem;"></i>
        </div>
        <div>
          <div class="fw-semibold" style="font-size:14px;">Submit New Request</div>
          <div class="text-muted" style="font-size:11px;">Only delivered orders are eligible</div>
        </div>
      </div>

      <form action="{{ route('return.store') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label class="form-label" style="font-size:12px;font-weight:600;color:#475569;letter-spacing:.3px;">
            <i class="bi bi-receipt me-1"></i> SELECT ORDER
          </label>
          <select name="order_id" class="form-select form-select-sm" required
                  style="border-radius:10px;border:1.5px solid #e2e8f0;font-size:13px;padding:9px 12px;height:auto;">
            <option value="">Choose a delivered order...</option>
            @foreach($deliveredOrders as $order)
              @php
                $hasActive = $returnRequests
                  ->where('order_id', $order->id)
                  ->whereIn('status', ['pending','approved'])
                  ->count();
              @endphp
              @if(!$hasActive)
              <option value="{{ $order->id }}">
                Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                — ৳{{ number_format($order->total_price, 0) }}
                ({{ $order->created_at->format('d M Y') }})
              </option>
              @endif
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label" style="font-size:12px;font-weight:600;color:#475569;letter-spacing:.3px;">
            <i class="bi bi-arrow-left-right me-1"></i> REQUEST TYPE
          </label>
          <div class="d-flex gap-3">
            <label style="flex:1;cursor:pointer;">
              <input type="radio" name="type" value="return" checked class="d-none" id="typeReturn">
              <div class="type-option" id="typeReturnBox"
                   style="border:1.5px solid #22c55e;background:#f0fdf4;border-radius:12px;padding:12px;text-align:center;transition:all .2s;">
                <i class="bi bi-arrow-return-left d-block mb-1" style="font-size:1.2rem;color:#16a34a;"></i>
                <div style="font-size:12px;font-weight:600;color:#15803d;">Return Item</div>
                <div style="font-size:10px;color:#86efac;">Send item back</div>
              </div>
            </label>
            <label style="flex:1;cursor:pointer;">
              <input type="radio" name="type" value="refund" class="d-none" id="typeRefund">
              <div class="type-option" id="typeRefundBox"
                   style="border:1.5px solid #e2e8f0;background:#f8fafc;border-radius:12px;padding:12px;text-align:center;transition:all .2s;">
                <i class="bi bi-currency-exchange d-block mb-1" style="font-size:1.2rem;color:#64748b;"></i>
                <div style="font-size:12px;font-weight:600;color:#475569;">Refund</div>
                <div style="font-size:10px;color:#94a3b8;">Get money back</div>
              </div>
            </label>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label" style="font-size:12px;font-weight:600;color:#475569;letter-spacing:.3px;">
            <i class="bi bi-chat-square-text me-1"></i> REASON
          </label>
          <select name="reason" class="form-select form-select-sm" required
                  style="border-radius:10px;border:1.5px solid #e2e8f0;font-size:13px;padding:9px 12px;height:auto;">
            <option value="">Select a reason...</option>
            <option value="Wrong item received">Wrong item received</option>
            <option value="Damaged product">Damaged product</option>
            <option value="Product not as described">Product not as described</option>
            <option value="Missing items in order">Missing items in order</option>
            <option value="Changed my mind">Changed my mind</option>
            <option value="Other">Other</option>
          </select>
        </div>

        <div class="mb-4">
          <label class="form-label" style="font-size:12px;font-weight:600;color:#475569;letter-spacing:.3px;">
            <i class="bi bi-card-text me-1"></i> ADDITIONAL DETAILS
            <span style="color:#94a3b8;font-weight:400;">(optional)</span>
          </label>
          <textarea name="description" rows="3"
                    style="border-radius:10px;border:1.5px solid #e2e8f0;font-size:13px;padding:10px 12px;width:100%;outline:none;resize:none;font-family:inherit;"
                    placeholder="Describe the issue in detail..."></textarea>
        </div>

        <button type="submit" class="udb-btn w-100 mb-4"
                style="border-radius:12px;padding:12px;font-size:14px;font-weight:600;display:flex;align-items:center;justify-content:center;gap:8px;background-color:#15803d;color:#f0fdf4;border:none">
          <i class="bi bi-send"></i> Submit Request
        </button>
      </form>

      @else
      <hr class="my-3">
      <div class="text-center py-3" style="color:#94a3b8;font-size:12px;">
        <i class="bi bi-bag-check d-block mb-1" style="font-size:1.5rem;"></i>
        Only <strong>delivered</strong> orders are eligible for return/refund.
      </div>
      @endif
    </div>
  </section>
</main>

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

{{-- Edit Profile Modal --}}
<div class="modal fade" id="editProfileModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:18px;border:none;">
      <div class="modal-header border-0 pb-0">
        <h6 class="modal-title fw-bold" style="font-size:15px;">Edit Profile</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body pt-2">
        <div class="text-center mb-3">
          <div id="avatarPreview" style="width:72px;height:72px;border-radius:50%;
               background:linear-gradient(135deg,#22c55e,#16a34a);
               display:flex;align-items:center;justify-content:center;
               font-size:28px;font-weight:700;color:#fff;margin:0 auto 8px;overflow:hidden;">
            @if(Auth::user()->avatar)
              <img src="{{ asset('storage/'.Auth::user()->avatar) }}" style="width:100%;height:100%;object-fit:cover;">
            @else
              {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            @endif
          </div>
          <label for="avatarInput" style="font-size:12px;color:#22c55e;cursor:pointer;font-weight:600;">Change Photo</label>
          <input type="file" id="avatarInput" accept="image/*" class="d-none">
        </div>
        <div class="mb-3">
          <label style="font-size:12px;font-weight:600;color:#475569;letter-spacing:.3px;">FULL NAME</label>
          <input type="text" id="profileName" class="form-control form-control-sm mt-1"
                 style="border-radius:10px;border:1.5px solid #e2e8f0;font-size:13px;padding:9px 12px;height:auto;"
                 value="{{ Auth::user()->name }}" placeholder="Your full name">
        </div>
        <div class="mb-3">
          <label style="font-size:12px;font-weight:600;color:#475569;letter-spacing:.3px;">PHONE</label>
          <input type="text" id="profilePhone" class="form-control form-control-sm mt-1"
                 style="border-radius:10px;border:1.5px solid #e2e8f0;font-size:13px;padding:9px 12px;height:auto;"
                 value="{{ Auth::user()->phone ?? '' }}" placeholder="01XXXXXXXXX">
        </div>
        <div id="profileAlert" class="d-none" style="border-radius:10px;font-size:13px;padding:9px 12px;"></div>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn btn-sm" data-bs-dismiss="modal"
                style="border-radius:10px;font-size:13px;border:1.5px solid #e2e8f0;padding:7px 18px;">Cancel</button>
        <button type="button" id="saveProfileBtn"
                style="border-radius:10px;font-size:13px;padding:7px 20px;background:#22c55e;color:#fff;border:none;font-weight:600;">
          Save Changes
        </button>
      </div>
    </div>
  </div>
</div>

{{-- Edit Address Modal --}}
<div class="modal fade" id="editAddressModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:18px;border:none;">
      <div class="modal-header border-0 pb-0">
        <h6 class="modal-title fw-bold" style="font-size:15px;">Edit Address</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body pt-2">
        <div class="mb-3">
          <label style="font-size:12px;font-weight:600;color:#475569;letter-spacing:.3px;">FULL ADDRESS</label>
          <textarea id="addressInput" class="form-control form-control-sm mt-1" rows="3"
                    style="border-radius:10px;border:1.5px solid #e2e8f0;font-size:13px;padding:9px 12px;resize:none;"
                    placeholder="House, Road, Area, City">{{ Auth::user()->address ?? '' }}</textarea>
        </div>
        <div id="addressAlert" class="d-none" style="border-radius:10px;font-size:13px;padding:9px 12px;"></div>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn btn-sm" data-bs-dismiss="modal"
                style="border-radius:10px;font-size:13px;border:1.5px solid #e2e8f0;padding:7px 18px;">Cancel</button>
        <button type="button" id="saveAddressBtn"
                style="border-radius:10px;font-size:13px;padding:7px 20px;background:#22c55e;color:#fff;border:none;font-weight:600;">
          Save Address
        </button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
  <script src="{{ asset('frontend/js/userDashboard.js') }}" ></script>
  <script>
  const PROFILE_UPDATE_URL = "{{ route('profile.update') }}";
  const ADDRESS_UPDATE_URL = "{{ route('address.update') }}";
  const CSRF = "{{ csrf_token() }}";

  // Type card toggle
  document.querySelectorAll('input[name="type"]').forEach(function(radio) {
    radio.addEventListener('change', function() {
      document.getElementById('typeReturnBox').style.border     = '1.5px solid #e2e8f0';
      document.getElementById('typeReturnBox').style.background = '#f8fafc';
      document.getElementById('typeRefundBox').style.border     = '1.5px solid #e2e8f0';
      document.getElementById('typeRefundBox').style.background = '#f8fafc';
      document.querySelector('#typeReturnBox i').style.color    = '#64748b';
      document.querySelector('#typeRefundBox i').style.color    = '#64748b';
      if (this.value === 'return') {
        document.getElementById('typeReturnBox').style.border     = '1.5px solid #22c55e';
        document.getElementById('typeReturnBox').style.background = '#f0fdf4';
        document.querySelector('#typeReturnBox i').style.color    = '#16a34a';
      } else {
        document.getElementById('typeRefundBox').style.border     = '1.5px solid #22c55e';
        document.getElementById('typeRefundBox').style.background = '#f0fdf4';
        document.querySelector('#typeRefundBox i').style.color    = '#16a34a';
      }
    });
  });

  // Avatar preview
  document.getElementById('avatarInput').addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
      document.getElementById('avatarPreview').innerHTML =
        `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;">`;
    };
    reader.readAsDataURL(file);
  });

  // Save Profile
  document.getElementById('saveProfileBtn').addEventListener('click', function () {
    const btn   = this;
    const alert = document.getElementById('profileAlert');
    const name  = document.getElementById('profileName').value.trim();
    const phone = document.getElementById('profilePhone').value.trim();
    const avatarFile = document.getElementById('avatarInput').files[0];

    if (!name) {
      alert.className   = 'alert alert-danger';
      alert.textContent = 'Name is required.';
      return;
    }

    const formData = new FormData();
    formData.append('_token', CSRF);
    formData.append('name', name);
    formData.append('phone', phone);
    if (avatarFile) formData.append('avatar', avatarFile);

    btn.disabled = true; btn.textContent = 'Saving...';

    fetch(PROFILE_UPDATE_URL, { method: 'POST', body: formData })
      .then(r => r.json())
      .then(data => {
        if (data.success) {
          alert.className = 'alert alert-success';
          alert.textContent = data.message;
          setTimeout(() => location.reload(), 1000);
        } else {
          alert.className = 'alert alert-danger';
          alert.textContent = 'Something went wrong.';
        }
      })
      .catch(() => { alert.className = 'alert alert-danger'; alert.textContent = 'Network error.'; })
      .finally(() => { btn.disabled = false; btn.textContent = 'Save Changes'; });
  });

  // Save Address
  document.getElementById('saveAddressBtn').addEventListener('click', function () {
    const btn     = this;
    const alert   = document.getElementById('addressAlert');
    const address = document.getElementById('addressInput').value.trim();

    if (!address) {
      alert.className = 'alert alert-danger';
      alert.textContent = 'Address cannot be empty.';
      return;
    }

    btn.disabled = true; btn.textContent = 'Saving...';

    fetch(ADDRESS_UPDATE_URL, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
      body: JSON.stringify({ address })
    })
    .then(r => r.json())
    .then(data => {
      if (data.success) {
        alert.className = 'alert alert-success';
        alert.textContent = data.message;
        setTimeout(() => location.reload(), 1000);
      } else {
        alert.className = 'alert alert-danger';
        alert.textContent = 'Something went wrong.';
      }
    })
    .catch(() => { alert.className = 'alert alert-danger'; alert.textContent = 'Network error.'; })
    .finally(() => { btn.disabled = false; btn.textContent = 'Save Address'; });
  });
  </script>
@endpush