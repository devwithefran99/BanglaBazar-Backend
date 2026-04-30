
@extends('backend.layouts.app')
@section('title', 'Customer — ' . ($user->name ?? $user->email))

@section('content')

{{-- Back + Title --}}
<div class="d-flex align-items-center gap-3 mb-4">
  <a href="{{ route('backend.customers.index') }}" class="btn btn-sm btn-outline-secondary">
    <i class="bx bx-arrow-back me-1"></i> Back
  </a>
  <div>
    <h4 class="fw-bold mb-0">Customer Detail</h4>
    <small class="text-muted">{{ $user->email }}</small>s
  </div>
</div>

<div class="row g-4">

  {{-- ─── Left Column: Profile ─────────────────────────── --}}
  <div class="col-xl-4">

    {{-- Profile Card --}}
    <div class="card mb-4">
      <div class="card-body text-center pt-4">
        <div class="avatar avatar-xl mx-auto mb-3">
          @if($user->avatar)
            <img src="{{ asset('storage/'.$user->avatar) }}"
                 class="rounded-circle" style="width:80px;height:80px;object-fit:cover" alt="">
          @else
            <span class="avatar-initial rounded-circle bg-label-primary"
                  style="width:80px;height:80px;font-size:2rem;display:flex;align-items:center;justify-content:center">
              {{ strtoupper(substr($user->name ?? $user->email, 0, 1)) }}
            </span>
          @endif
        </div>
        <h5 class="fw-bold mb-1">{{ $user->name ?? '—' }}</h5>
        <small class="text-muted">{{ $user->email }}</small>
        <div class="mt-2">
          @if($user->email_verified_at)
            <span class="badge bg-label-success">Email Verified</span>
          @else
            <span class="badge bg-label-warning">Unverified</span>
          @endif
        </div>
      </div>
      <div class="card-footer">
        <div class="row text-center g-0">
          <div class="col border-end">
            <h6 class="mb-0 fw-bold">{{ $user->orders ? $user->orders->count() : 0 }}</h6>
            <small class="text-muted">Orders</small>
          </div>
          <div class="col border-end">
            <h6 class="mb-0 fw-bold">{{ $user->wishlists ? $user->wishlists->count() : 0 }}</h6>
            <small class="text-muted">Wishlist</small>
          </div>
          <div class="col">
            <h6 class="mb-0 fw-bold">{{ $user->carts ? $user->carts->count() : 0 }}</h6>
            <small class="text-muted">In Cart</small>
          </div>
        </div>
      </div>
    </div>

    {{-- Info Card --}}
    <div class="card">
      <div class="card-header"><h6 class="mb-0">Account Info</h6></div>
      <div class="card-body" style="font-size:.88rem">
        <div class="d-flex justify-content-between py-2 border-bottom">
          <span class="text-muted">Joined</span>
          <span class="fw-semibold">{{ $user->created_at->format('d M Y') }}</span>
        </div>
        <div class="d-flex justify-content-between py-2 border-bottom">
          <span class="text-muted">Last Update</span>
          <span class="fw-semibold">{{ $user->updated_at->diffForHumans() }}</span>
        </div>
        <div class="d-flex justify-content-between py-2">
          <span class="text-muted">Role</span>
          <span class="badge bg-label-primary">{{ ucfirst($user->role ?? 'customer') }}</span>
        </div>
      </div>
    </div>

  </div>{{-- /.col-xl-4 --}}

  {{-- ─── Right Column: Tabs ─────────────────────────────── --}}
  <div class="col-xl-8">
    <div class="card">
      <div class="card-header p-0">
        <ul class="nav nav-tabs card-header-tabs px-3" id="customerTabs">
          <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#orders-tab">
              <i class="bx bx-receipt me-1"></i> Orders
              <span class="badge bg-primary ms-1">{{ $user->orders ? $user->orders->count() : 0 }}</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#wishlist-tab">
              <i class="bx bx-heart me-1"></i> Wishlist
              <span class="badge bg-danger ms-1">{{ $user->wishlists ? $user->wishlists->count() : 0 }}</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#cart-tab">
              <i class="bx bx-cart me-1"></i> Cart
              <span class="badge bg-warning ms-1">{{ $user->carts ? $user->carts->count() : 0 }}</span>
            </a>
          </li>
        </ul>
      </div>

      <div class="card-body tab-content p-0">

        {{-- ── Orders Tab ── --}}
        <div class="tab-pane fade show active" id="orders-tab">
          @if($user->orders->count())
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead class="table-light">
                  <tr>
                    <th>Order #</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($user->orders as $order)
                    <tr>
                      <td><span class="fw-semibold">#{{ $order->id }}</span></td>
                      <td>
                        <div class="d-flex gap-1 flex-wrap">
                          @foreach($order->items->take(3) as $item)
                            <span class="badge bg-label-secondary">
                              {{ Str::limit($item->product->name ?? '—', 15) }}
                            </span>
                          @endforeach
                          @if($order->items->count() > 3)
                            <span class="badge bg-label-primary">
                              +{{ $order->items->count() - 3 }} more
                            </span>
                          @endif
                        </div>
                      </td>
                      <td class="fw-bold">
                        ৳{{ number_format($order->total_price ?? 0, 2) }}
                      </td>
                      <td>
                        @php
                          $colors = [
                            'pending'   => 'warning',
                            'confirmed' => 'info',
                            'shipped'   => 'primary',
                            'delivered' => 'success',
                            'cancelled' => 'danger',
                          ];
                          $c = $colors[$order->status ?? 'pending'] ?? 'secondary';
                        @endphp
                        <span class="badge bg-label-{{ $c }}">
                          {{ ucfirst($order->status ?? 'pending') }}
                        </span>
                      </td>
                      <td style="font-size:.83rem;color:#888">
                        {{ $order->created_at->format('d M Y') }}
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <div class="text-center py-5 text-muted">
              <i class="bx bx-receipt fs-1 d-block mb-2"></i>
              No orders yet.
            </div>
          @endif
        </div>

        {{-- ── Wishlist Tab ── --}}
        <div class="tab-pane fade" id="wishlist-tab">
          @if{{ $user->wishlists ? $user->wishlists->count() : 0 }}
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead class="table-light">
                  <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Added</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($user->wishlistItems as $item)
                    <tr>
                      <td>
                        <div class="d-flex align-items-center gap-2">
                          @if($item->product?->image)
                            <img src="{{ asset('storage/'.$item->product->image) }}"
                                 style="width:36px;height:36px;border-radius:6px;object-fit:cover" alt="">
                          @else
                            <div style="width:36px;height:36px;border-radius:6px;background:#f0f0f0;
                                        display:flex;align-items:center;justify-content:center">
                              <i class="bx bx-image text-muted"></i>
                            </div>
                          @endif
                          <span class="fw-semibold" style="font-size:.88rem">
                            {{ $item->product->name ?? '—' }}
                          </span>
                        </div>
                      </td>
                      <td class="fw-bold text-success">
                        ৳{{ number_format($item->product->price ?? 0, 2) }}
                      </td>
                      <td style="font-size:.83rem;color:#888">
                        {{ $item->created_at->format('d M Y') }}
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <div class="text-center py-5 text-muted">
              <i class="bx bx-heart fs-1 d-block mb-2"></i>
              Wishlist is empty.
            </div>
          @endif
        </div>

        {{-- ── Cart Tab ── --}}
        <div class="tab-pane fade" id="cart-tab">
          @if($user->cartItems->count())
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead class="table-light">
                  <tr>
                    <th>Product</th>
                    <th class="text-center">Qty</th>
                    <th>Unit Price</th>
                    <th>Subtotal</th>
                  </tr>
                </thead>
                <tbody>
                  @php $cartTotal = 0; @endphp
                  @foreach($user->cartItems as $item)
                    @php
                      $price = $item->product->price ?? 0;
                      $sub   = $price * ($item->quantity ?? 1);
                      $cartTotal += $sub;
                    @endphp
                    <tr>
                      <td>
                        <div class="d-flex align-items-center gap-2">
                          @if($item->product?->image)
                            <img src="{{ asset('storage/'.$item->product->image) }}"
                                 style="width:36px;height:36px;border-radius:6px;object-fit:cover" alt="">
                          @else
                            <div style="width:36px;height:36px;border-radius:6px;background:#f0f0f0;
                                        display:flex;align-items:center;justify-content:center">
                              <i class="bx bx-image text-muted"></i>
                            </div>
                          @endif
                          <span class="fw-semibold" style="font-size:.88rem">
                            {{ $item->product->name ?? '—' }}
                          </span>
                        </div>
                      </td>
                      <td class="text-center">
                        <span class="badge bg-label-primary">{{ $item->quantity ?? 1 }}</span>
                      </td>
                      <td>৳{{ number_format($price, 2) }}</td>
                      <td class="fw-bold">৳{{ number_format($sub, 2) }}</td>
                    </tr>
                  @endforeach
                </tbody>
                <tfoot class="table-light">
                  <tr>
                    <td colspan="3" class="text-end fw-bold">Cart Total:</td>
                    <td class="fw-bold text-primary">৳{{ number_format($cartTotal, 2) }}</td>
                  </tr>
                </tfoot>
              </table>
            </div>
          @else
            <div class="text-center py-5 text-muted">
              <i class="bx bx-cart fs-1 d-block mb-2"></i>
              Cart is empty.
            </div>
          @endif
        </div>

      </div>{{-- /.tab-content --}}
    </div>
  </div>{{-- /.col-xl-8 --}}

</div>{{-- /.row --}}

@endsection