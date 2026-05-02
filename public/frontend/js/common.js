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
   4. ADD-TO-CART DRAWER
───────────────────────────────────────────────────── */
(function () {
  const drawer = document.getElementById('cpDrawer');
  const overlay = document.getElementById('cpOverlay');
  const closeBtn = document.getElementById('cpClose');
  if (!drawer || !overlay || !closeBtn) return;

  function cpOpen() {
    console.log('🛒 Opening cart drawer...');
    drawer.classList.add('active');
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
    
    if (typeof window.loadCartItems === 'function') {
      console.log('📞 Calling loadCartItems()...');
      window.loadCartItems();
    } else {
      console.error('❌ loadCartItems function not found!');
    }
  }

  function cpClose() {
    drawer.classList.remove('active');
    overlay.classList.remove('active');
    document.body.style.overflow = '';
  }

  const navCartBtn = document.getElementById('navCartBtn');
  if (navCartBtn) {
    navCartBtn.addEventListener('click', function (e) {
      e.preventDefault();
      cpOpen();
    });
  }

  overlay.addEventListener('click', cpClose);
  closeBtn.addEventListener('click', cpClose);
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') cpClose();
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
    document.getElementById('qvImg').src = card.querySelector('.product-img-wrap img')?.src || '';
    document.getElementById('qvTitle').textContent = card.querySelector('.product-name')?.textContent.trim() || '';
    document.getElementById('qvPrice').textContent = card.querySelector('.price-main')?.textContent.trim() || '';
    document.getElementById('qvOld').textContent = card.querySelector('.price-old')?.textContent.trim() || '';
    document.getElementById('qvCat').textContent = card.dataset.category || 'Fresh Produce';
    document.getElementById('qvDesc').textContent = card.dataset.desc || 'Fresh, naturally grown product. Perfect for everyday cooking.';
    document.getElementById('qvQty').value = 1;

    const badge = card.querySelector('.sale-badge');
    const discEl = document.getElementById('qvDiscount');
    discEl.textContent = badge ? badge.textContent.trim() : '';
    discEl.style.display = badge ? 'inline-block' : 'none';

    backdrop.classList.add('active');
    document.body.style.overflow = 'hidden';
  });

  function closeQV() {
    backdrop.classList.remove('active');
    document.body.style.overflow = '';
  }

  document.getElementById('qvClose').addEventListener('click', closeQV);
  backdrop.addEventListener('click', (e) => {
    if (e.target === backdrop) closeQV();
  });
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeQV();
  });

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
  console.log('🚀 Cart functionality initialized');
  
  const csrfToken = $('meta[name="csrf-token"]').attr('content');
  console.log('🔑 CSRF Token:', csrfToken ? 'Found' : 'Missing');

  const isAuthenticated = $('#cartCount').length > 0;
  console.log('👤 User authenticated:', isAuthenticated);

  // Show quantity selector
  $(document).on('click', '.show-qty-btn', function (e) {
    e.preventDefault();
    e.stopPropagation();

    if (!isAuthenticated) {
      showToast('error', 'Please login to add items to cart');
      setTimeout(() => {
        window.location.href = '/signin';
      }, 1500);
      return;
    }

    const productId = $(this).data('product-id');
    console.log('🛍️ Show quantity selector for product:', productId);

    $('.qty-selector').slideUp(200);
    $('.show-qty-btn').show();

    $(this).hide();
    $(`.qty-selector[data-product-id="${productId}"]`).slideDown(200);
  });

  // Quantity increase
  $(document).on('click', '.qty-btn.plus', function () {
    const input = $(this).siblings('.qty-input');
    const max = parseInt(input.attr('max'));
    let val = parseInt(input.val());

    if (val < max) {
      input.val(val + 1);
    }
  });

  // Quantity decrease
  $(document).on('click', '.qty-btn.minus', function () {
    const input = $(this).siblings('.qty-input');
    let val = parseInt(input.val());

    if (val > 1) {
      input.val(val - 1);
    }
  });

  // Add to cart
  $(document).on('click', '.add-to-cart-btn', function () {
    const productId = $(this).data('product-id');
    const quantity = $(`.qty-selector[data-product-id="${productId}"] .qty-input`).val();

    console.log('➕ Adding to cart:', { productId, quantity });

    $.ajax({
      url: '/cart/add',
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': csrfToken
      },
      data: {
        product_id: productId,
        quantity: quantity
      },
      success: function (response) {
        console.log('✅ Add to cart success:', response);
        
        if (response.success) {
          updateCartCount();
          showToast('success', response.message);

          $(`.qty-selector[data-product-id="${productId}"]`).slideUp(200);
          $(`.show-qty-btn[data-product-id="${productId}"]`).show();
          $(`.qty-selector[data-product-id="${productId}"] .qty-input`).val(1);
        }
      },
      error: function (xhr) {
        console.error('❌ Add to cart error:', xhr);
        const response = xhr.responseJSON;
        showToast('error', response?.message || 'Failed to add to cart');
      }
    });
  });

  // Update cart count
  function updateCartCount() {
    if (!isAuthenticated) return;

    $.ajax({
      url: '/cart/count',
      method: 'GET',
      success: function (response) {
        console.log('🔢 Cart count:', response);
        if (response.success) {
          $('#cartCount').text(response.data);
        }
      },
      error: function(xhr) {
        console.error('❌ Failed to update cart count:', xhr);
      }
    });
  }

  // Load cart items
  window.loadCartItems = function () {
    console.log('📦 Loading cart items...');
    console.log('Auth status:', isAuthenticated);

    if (!isAuthenticated) {
      console.log('⚠️ User not authenticated, showing empty cart');
      $('#cpEmpty').show();
      $('#cpFooter').hide();
      $('#cpItems').hide();
      return;
    }

    $.ajax({
      url: '/cart',
      method: 'GET',
      success: function (response) {
        console.log('✅ Cart API Response:', response);
        
        if (response.success) {
          console.log('📦 Cart items count:', response.data.length);
          renderCartItems(response.data);
        } else {
          console.error('⚠️ API returned success:false');
        }
      },
      error: function (xhr) {
        console.error('❌ Cart load error:', xhr);
        console.error('Status:', xhr.status);
        console.error('Response:', xhr.responseJSON);
        
        showToast('error', 'Failed to load cart items');
        $('#cpEmpty').show();
        $('#cpFooter').hide();
        $('#cpItems').hide();
      }
    });
  };

// Render cart items in sidebar
function renderCartItems(items) {
  const container = $('#cpItems');
  container.empty();

  if (items.length === 0) {
    $('#cpEmpty').show();
    $('#cpFooter').hide();
    $('#cpItems').hide();
    return;
  }

  $('#cpEmpty').hide();
  $('#cpFooter').show();
  $('#cpItems').show();

  let total = 0;
  let count = 0;

  items.forEach(item => {
    const product = item.product;
    
    if (!product) {
      console.error('⚠️ Product data missing for cart item:', item);
      return;
    }
    
    // ✅ Type conversion
    const price = parseFloat(product.price) || 0;
    const quantity = parseInt(item.quantity) || 1;
    
    const itemTotal = price * quantity;
    total += itemTotal;
    count += quantity;

    const imageUrl = product.image 
? '/storage/' + product.image: '/frontend/image/Product Image.png';

    const html = `
      <div class="cp-item" data-id="${item.id}">
        <div class="cp-item-img">
          <img src="${imageUrl}" alt="${product.name}" onerror="this.src='/frontend/image/Product Image.png'">
        </div>
        <div class="cp-item-info">
          <div class="cp-item-name">${product.name}</div>
          <div class="cp-item-meta">${quantity} × <strong>৳${price.toFixed(2)}</strong></div>
        </div>
        <button class="cp-remove" data-cart-id="${item.id}" aria-label="Remove">
          <i class="bi bi-x"></i>
        </button>
      </div>
    `;
    
    container.append(html);
  });

  $('#cpProductCount').text(count);
  $('#cpTotal').text('৳' + total.toFixed(2));
}

  // Remove from cart
  $(document).on('click', '.cp-remove', function () {
    const cartId = $(this).data('cart-id');
    console.log('🗑️ Removing cart item:', cartId);

    $.ajax({
      url: `/cart/remove/${cartId}`,
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': csrfToken
      },
      success: function (response) {
        console.log('✅ Remove success:', response);
        
        if (response.success) {
          showToast('success', response.message);
          loadCartItems();
          updateCartCount();
        }
      },
      error: function (xhr) {
        console.error('❌ Remove error:', xhr);
        showToast('error', 'Failed to remove item');
      }
    });
  });

  // Toast notification
  function showToast(type, message) {
    const toast = $(`
      <div class="custom-toast ${type}" style="
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#22c55e' : '#ef4444'};
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 9999;
        animation: slideInRight 0.3s ease;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
      ">
        <i class="bi bi-${type === 'success' ? 'check-circle' : 'x-circle'} me-2"></i>
        ${message}
      </div>
    `);

    $('body').append(toast);

    setTimeout(() => {
      toast.fadeOut(300, function () {
        $(this).remove();
      });
    }, 3000);
  }

  // Page load
  if (isAuthenticated) {
    updateCartCount();
  }
});