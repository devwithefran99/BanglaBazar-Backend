/* =====================================================
   common.js – Clean & Optimized Version
   BanglaBazar24/7 E-commerce Project
   ===================================================== */

/* ─────────────────────────────────────────────────────
   1. PRELOADER
───────────────────────────────────────────────────── */
window.addEventListener('load', function () {
  const preloader = document.getElementById('preloader');
  if (!preloader) return;

  setTimeout(() => {
    preloader.classList.add('fade-out');
    setTimeout(() => {
      preloader.style.display = 'none';
      preloader.remove();
    }, 800);
  }, 1200);
});

/* ─────────────────────────────────────────────────────
   2. NAVBAR – Staggered fade-in animation
───────────────────────────────────────────────────── */
document.querySelectorAll('.main-navbar .nav-item').forEach((el, i) => {
  el.style.opacity = '0';
  el.style.transform = 'translateY(-8px)';
  el.style.transition = `opacity .3s ease ${i * 60}ms, transform .3s ease ${i * 60}ms`;
  setTimeout(() => {
    el.style.opacity = '1';
    el.style.transform = 'translateY(0)';
  }, 50);
});

/* ─────────────────────────────────────────────────────
   3. NAVBAR – Active page detector (desktop + mobile)
───────────────────────────────────────────────────── */
(function () {
  const currentPage = window.location.pathname.split('/').pop() || 'index.html';

  document.querySelectorAll('.main-navbar .nav-link').forEach((link) => {
    const linkPage = (link.getAttribute('href') || '').split('/').pop();
    if (linkPage !== currentPage) return;
    link.classList.add('active');
    const parentDropdown = link.closest('.dropdown-custom');
    if (parentDropdown) {
      const parentLink = parentDropdown.querySelector(':scope > .nav-link');
      if (parentLink) parentLink.classList.add('active');
    }
  });

  document.querySelectorAll('.submenu li a').forEach((link) => {
    const linkPage = (link.getAttribute('href') || '').split('/').pop();
    if (linkPage !== currentPage) return;
    link.classList.add('submenu-active');
    const parentDropdown = link.closest('.dropdown-custom');
    if (parentDropdown) {
      const parentLink = parentDropdown.querySelector(':scope > .nav-link');
      if (parentLink) parentLink.classList.add('active');
    }
  });

  document.querySelectorAll('.offcanvas-body .nav-link, .mobile-submenu li a').forEach((link) => {
    const linkPage = (link.getAttribute('href') || '').split('/').pop();
    if (linkPage !== currentPage) return;
    link.classList.add('mobile-active');
    const parentMobileItem = link.closest('.mobile-menu-item');
    if (parentMobileItem) parentMobileItem.classList.add('active');
  });

  document.querySelectorAll('.mobile-toggle').forEach((toggle) => {
    toggle.addEventListener('click', function () {
      this.closest('.mobile-menu-item').classList.toggle('active');
    });
  });
})();

/* ─────────────────────────────────────────────────────
   5. SCROLL-TRIGGERED ANIMATIONS
───────────────────────────────────────────────────── */
(function () {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.style.animationPlayState = 'running';
      }
    });
  }, { threshold: 0.15 });

  document.querySelectorAll('.anim-fade-up, .anim-fade-in').forEach((el) => {
    el.style.animationPlayState = 'paused';
    observer.observe(el);
  });
})();

/* ─────────────────────────────────────────────────────
   6. QUICK VIEW
───────────────────────────────────────────────────── */
(function () {
  const backdrop = document.getElementById('qvBackdrop');
  if (!backdrop) return;

  document.addEventListener('click', function (e) {
    const eyeBtn = e.target.closest('button[title="Quick View"]');
    if (!eyeBtn) return;
    e.stopPropagation();

    const card = eyeBtn.closest('.product-card, .hotProduct-card, .slider-product, .featured-card');
    if (!card) return;

    document.getElementById('qvImg').src           = card.querySelector('.product-img-wrap img')?.src || '';
    document.getElementById('qvTitle').textContent = card.querySelector('.product-name')?.textContent.trim() || '';
    document.getElementById('qvPrice').textContent = card.querySelector('.price-main')?.textContent.trim() || '';
    document.getElementById('qvOld').textContent   = card.querySelector('.price-old')?.textContent.trim() || '';
    document.getElementById('qvCat').textContent   = card.dataset.category || 'Fresh Produce';
    document.getElementById('qvDesc').textContent  = card.dataset.desc || 'Fresh, naturally grown product. Perfect for everyday cooking.';
    document.getElementById('qvQty').value = 1;

    const badge  = card.querySelector('.sale-badge');
    const discEl = document.getElementById('qvDiscount');
    discEl.textContent   = badge ? badge.textContent.trim() : '';
    discEl.style.display = badge ? 'inline-block' : 'none';

    backdrop.classList.add('active');
    document.body.style.overflow = 'hidden';
  });

  function closeQV() {
    backdrop.classList.remove('active');
    document.body.style.overflow = '';
  }

  document.getElementById('qvClose').addEventListener('click', closeQV);
  backdrop.addEventListener('click', (e) => { if (e.target === backdrop) closeQV(); });
  document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeQV(); });

  document.getElementById('qvMinus').addEventListener('click', () => {
    const input = document.getElementById('qvQty');
    if (+input.value > 1) input.value = +input.value - 1;
  });
  document.getElementById('qvPlus').addEventListener('click', () => {
    const input = document.getElementById('qvQty');
    if (+input.value < 99) input.value = +input.value + 1;
  });
})();

/* ─────────────────────────────────────────────────────
   7. CART FUNCTIONALITY (jQuery)
───────────────────────────────────────────────────── */
$(document).ready(function () {

  const csrfToken       = $('meta[name="csrf-token"]').attr('content');
  const isAuthenticated = $('#cartCount').length > 0;

  /* ── Drawer open/close ── */
  function openDrawer() {
    $('#cpDrawer').addClass('active');
    $('#cpOverlay').addClass('active');
    $('body').css('overflow', 'hidden');
    window.loadCartItems();
  }

  function closeDrawer() {
    $('#cpDrawer').removeClass('active');
    $('#cpOverlay').removeClass('active');
    $('body').css('overflow', '');
  }

  $('#navCartBtn').on('click', function (e) {
    e.preventDefault();
    openDrawer();
  });

  $('#cpClose, #cpOverlay').on('click', closeDrawer);

  $(document).on('keydown', function (e) {
    if (e.key === 'Escape') closeDrawer();
  });

  /* ─────────────────────────────────────────────────
     ✅ FIX: data-uid দিয়ে exact card target করো
     product-1, hotdeal-1 — আলাদা uid তাই clash নেই
  ───────────────────────────────────────────────── */
  $(document).on('click', '.show-qty-btn', function (e) {
    e.preventDefault();
    e.stopPropagation();

    if (!isAuthenticated) {
      showToast('error', 'Please login to add items to cart');
      setTimeout(() => { window.location.href = '/signin'; }, 1500);
      return;
    }

    const uid = $(this).data('uid');

    // সব বন্ধ করো
    $('.qty-selector').slideUp(200);
    $('.show-qty-btn').show();

    // শুধু এই uid এর কার্ডটা open করো
    $(this).hide();
    $(`.qty-selector[data-uid="${uid}"]`).slideDown(200);
  });

  /* ── Qty + / - ── */
  $(document).on('click', '.qty-btn.plus', function () {
    const input = $(this).siblings('.qty-input');
    const max   = parseInt(input.attr('max')) || 99;
    const val   = parseInt(input.val());
    if (val < max) input.val(val + 1);
  });

  $(document).on('click', '.qty-btn.minus', function () {
    const input = $(this).siblings('.qty-input');
    const val   = parseInt(input.val());
    if (val > 1) input.val(val - 1);
  });

  /* ── Add to cart (✓ button) ── */
  $(document).on('click', '.add-to-cart-btn', function () {
    const uid         = $(this).data('uid');
    const productId   = $(this).data('product-id');
    const productType = $(this).data('product-type') || 'product';
    const quantity    = $(`.qty-selector[data-uid="${uid}"] .qty-input`).val(); // ✅ uid দিয়ে qty

    $.ajax({
      url: '/cart/add',
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': csrfToken },
      data: {
        product_id:   productId,
        quantity:     quantity,
        product_type: productType
      },
      success: function (response) {
        if (response.success) {
          // ✅ uid দিয়ে exact কার্ড বন্ধ করো
          $(`.qty-selector[data-uid="${uid}"]`).slideUp(200);
          $(`.show-qty-btn[data-uid="${uid}"]`).show();
          $(`.qty-selector[data-uid="${uid}"] .qty-input`).val(1);

          updateCartCount();
          showToast('success', response.message);
          openDrawer();
        }
      },
      error: function (xhr) {
        const res = xhr.responseJSON;
        showToast('error', res?.message || 'Failed to add to cart');
      }
    });
  });

  /* ── Cart drawer: items remove ── */
  $(document).on('click', '.cp-remove', function () {
    const cartId = $(this).data('cart-id');
    $.ajax({
      url: `/cart/remove/${cartId}`,
      method: 'DELETE',
      headers: { 'X-CSRF-TOKEN': csrfToken },
      success: function (response) {
        if (response.success) {
          showToast('success', response.message);
          window.loadCartItems();
          updateCartCount();
        }
      },
      error: function () {
        showToast('error', 'Failed to remove item');
      }
    });
  });

  /* ── Cart count badge update ── */
  function updateCartCount() {
    if (!isAuthenticated) return;
    $.ajax({
      url: '/cart/count',
      method: 'GET',
      success: function (response) {
        if (response.success) $('#cartCount').text(response.data);
      }
    });
  }

  /* ── Load cart items ── */
  window.loadCartItems = function () {
    if (!isAuthenticated) {
      $('#cpEmpty').show();
      $('#cpFooter').hide();
      $('#cpItems').hide();
      return;
    }

    $.ajax({
      url: '/cart',
      method: 'GET',
      success: function (response) {
        if (response.success) renderCartItems(response.data);
      },
      error: function () {
        showToast('error', 'Failed to load cart');
        $('#cpEmpty').show();
        $('#cpFooter').hide();
        $('#cpItems').hide();
      }
    });
  };

  /* ── Render cart items ── */
  function renderCartItems(items) {
    const container = $('#cpItems');
    container.empty();

    if (!items || items.length === 0) {
      $('#cpEmpty').show();
      $('#cpFooter').hide();
      container.hide();
      return;
    }

    $('#cpEmpty').hide();
    $('#cpFooter').show();
    container.show();

    let total = 0;
    let count = 0;

    items.forEach(item => {
      const product = item.product;
      if (!product) return;

      const price    = parseFloat(product.price) || 0;
      const quantity = parseInt(item.quantity)   || 1;
      total += price * quantity;
      count += quantity;

      const imageUrl = product.image
        ? '/storage/' + product.image
        : '/frontend/image/Product Image.png';

      container.append(`
        <div class="cp-item" data-id="${item.id}">
          <div class="cp-item-img">
            <img src="${imageUrl}" alt="${product.name}"
                 onerror="this.src='/frontend/image/Product Image.png'">
          </div>
          <div class="cp-item-info">
            <div class="cp-item-name">${product.name}</div>
            <div class="cp-item-meta">${quantity} × <strong>৳${price.toFixed(2)}</strong></div>
          </div>
          <button class="cp-remove" data-cart-id="${item.id}" aria-label="Remove">
            <i class="bi bi-x"></i>
          </button>
        </div>
      `);
    });

    $('#cpProductCount').text(count);
    $('#cpTotal').text('৳' + total.toFixed(2));
  }

  /* ── Toast ── */
  function showToast(type, message) {
    $('.cart-toast').remove();
    const bg   = type === 'success' ? '#22c55e' : type === 'warning' ? '#f59e0b' : '#ef4444';
    const icon = type === 'success' ? 'check-circle' : 'x-circle';
    $('body').append(`
      <div class="cart-toast" style="
        position:fixed; bottom:24px; right:24px;
        background:${bg}; color:#fff;
        padding:11px 18px; border-radius:8px;
        box-shadow:0 4px 12px rgba(0,0,0,.15);
        z-index:99999; font-size:14px; font-weight:600;
        display:flex; align-items:center; gap:8px;">
        <i class="bi bi-${icon}"></i> ${message}
      </div>`);
    setTimeout(() => $('.cart-toast').fadeOut(300, function () { $(this).remove(); }), 2800);
  }

  /* ── Page load এ count refresh ── */
  if (isAuthenticated) updateCartCount();

});