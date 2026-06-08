@extends('frontend.layouts.app')

@section('title', 'FAQ')
@section('meta_description', 'BanglaBazar সম্পর্কে সাধারণ প্রশ্নের উত্তর। Delivery, payment, return সম্পর্কে জানুন।')

@push('styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('frontend/css/pages.css') }}">
   <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
@endpush

@section('content')

<main>
 <section class="faq-section">
    <div class="container">
      <div class="row align-items-center g-5">

        <div class="col-lg-6">
          <h2 class="section-title">
  আপনার কথা, আমাদের সেবা <br><span style="color:var(--green);">BanglaBazar</span> এর সাথে
</h2>
          <div class="accordion" id="ecobazarFAQ">
            <div class="faq-card">
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="true">
                    অর্ডার করার পর কতদিনের মধ্যে ডেলিভারি পাবো?
                  </button>
                </h2>
                <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#ecobazarFAQ">
                  <div class="faq-answer">সাধারণত চট্টগ্রাম শহরের মধ্যে ১-২ কার্যদিবসের মধ্যে ডেলিভারি দেওয়া হয়। শহরের বাইরে ২-৪ কার্যদিবস লাগতে পারে। অর্ডার কনফার্ম হওয়ার পর আপনাকে SMS বা কলের মাধ্যমে জানানো হবে।</div>
                </div>
              </div>
            </div>
            <div class="faq-card">
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                    পেমেন্ট কীভাবে করতে পারবো?
                  </button>
                </h2>
                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#ecobazarFAQ">
                  <div class="faq-answer">আমরা ক্যাশ অন ডেলিভারি (COD) সাপোর্ট করি। পণ্য হাতে পাওয়ার পর ডেলিভারি ম্যানকে সরাসরি টাকা দিতে পারবেন। ভবিষ্যতে অনলাইন পেমেন্ট অপশনও যুক্ত করা হবে।</div>
                </div>
              </div>
            </div>
            <div class="faq-card">
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                    পণ্য ফেরত দিতে চাইলে কী করবো?
                  </button>
                </h2>
                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#ecobazarFAQ">
                  <div class="faq-answer">পণ্য পাওয়ার ২৪ ঘণ্টার মধ্যে যদি কোনো সমস্যা থাকে, তাহলে আমাদের সাথে যোগাযোগ করুন। পণ্য নষ্ট বা ভুল হলে বিনামূল্যে রিটার্ন ও রিপ্লেসমেন্ট করা হবে। রিটার্নের জন্য আপনার ড্যাশবোর্ড থেকে রিকোয়েস্ট পাঠাতে পারবেন।</div>
                </div>
              </div>
            </div>
            <div class="faq-card">
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                    ডেলিভারি চার্জ কত?
                  </button>
                </h2>
                <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#ecobazarFAQ">
                  <div class="faq-answer">চট্টগ্রাম শহরের মধ্যে ডেলিভারি চার্জ মাত্র ৬০ টাকা। নির্দিষ্ট পরিমাণের উপরে অর্ডার করলে ফ্রি ডেলিভারিও পাওয়া যায়। শহরের বাইরে Steadfast Courier-এর মাধ্যমে ডেলিভারি দেওয়া হয়।</div>
                </div>
              </div>
            </div>
            <div class="faq-card">
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                    কোনো সমস্যা হলে কোথায় যোগাযোগ করবো?
                  </button>
                </h2>
                <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#ecobazarFAQ">
                  <div class="faq-answer">যেকোনো সমস্যায় আমাদের Contact পেজ থেকে মেসেজ পাঠাতে পারেন অথবা সরাসরি ফোন করতে পারেন। আমাদের সাপোর্ট টিম সপ্তাহের ৭ দিন সকাল ৯টা থেকে রাত ৯টা পর্যন্ত সেবা দিতে প্রস্তুত।</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <img src="{{ asset('frontend/image/delivary.png') }}" alt="FAQ illustration">
        </div>

      </div>
    </div>
  </section>

  {{-- About Section --}}
<section class="ab-section">
  <div class="container">
    <div class="ab-header">
      <span class="ab-tag">আমাদের সম্পর্কে</span>
      <h2 class="ab-title">BanglaBazar  — বাংলাদেশের বিশ্বস্ত অনলাইন শপ</h2>
      <p class="ab-sub">তাজা পণ্য, দ্রুত ডেলিভারি এবং সহজ অর্ডার প্রক্রিয়া নিয়ে আমরা আপনার দোরগোড়ায়।</p>
    </div>

    <div class="ab-story">
      <p>BanglaBazar শুরু হয়েছিল একটি সহজ লক্ষ্য নিয়ে — বাংলাদেশের মানুষদের কাছে তাজা ও মানসম্পন্ন পণ্য সহজে পৌঁছে দেওয়া। আমরা বিশ্বাস করি, প্রতিটি পরিবার সেরা মানের পণ্য পাওয়ার যোগ্য।</p>
    </div>

   <div class="row g-3 mb-4">
  <div class="col-12 col-lg-4">
    <div class="ab-card">
      <div class="ab-icon" style="background:#EAF3DE;">
        <i class="ti ti-truck-delivery" style="font-size:20px; color:#3B6D11;"></i>
      </div>
      <p class="ab-card-title">দ্রুত ডেলিভারি</p>
      <p class="ab-card-text">সারাদেশে দ্রুত ও নিরাপদ ডেলিভারি নিশ্চিত</p>
    </div>
  </div>
  <div class="col-12 col-lg-4">
    <div class="ab-card">
      <div class="ab-icon" style="background:#E6F1FB;">
        <i class="ti ti-shield-check" style="font-size:20px; color:#185FA5;"></i>
      </div>
      <p class="ab-card-title">মানের নিশ্চয়তা</p>
      <p class="ab-card-text">প্রতিটি পণ্য যাচাই করে পাঠানো হয়</p>
    </div>
  </div>
  <div class="col-12 col-lg-4">
    <div class="ab-card">
      <div class="ab-icon" style="background:#FAEEDA;">
        <i class="ti ti-headset" style="font-size:20px; color:#854F0B;"></i>
      </div>
      <p class="ab-card-title">সার্বক্ষণিক সাপোর্ট</p>
      <p class="ab-card-text">সকাল ৯টা – রাত ৯টা কাস্টমার সেবা</p>
    </div>
  </div>
</div>

    <div class="ab-stats">
      <div class="ab-stat">
        <span class="ab-stat-num">১৩৬৭+</span>
        <p class="ab-stat-lbl">সন্তুষ্ট গ্রাহক</p>
      </div>
      <div class="ab-stat">
        <span class="ab-stat-num">১৭৪৩+</span>
        <p class="ab-stat-lbl">সফল অর্ডার</p>
      </div>
      <div class="ab-stat">
        <span class="ab-stat-num">৯৮%</span>
        <p class="ab-stat-lbl">সন্তুষ্টির হার</p>
      </div>
    </div>
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

@endsection

@push('scripts')
  <script src="{{ asset('frontend/js/pages.js') }}"></script>
@endpush