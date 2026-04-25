/* =====================================================
   main.js  –  Clean & Bug-fixed Version
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
      preloader.remove(); // DOM থেকে পুরোপুরি সরিয়ে দেওয়া হচ্ছে
    }, 800);
  }, 1200);
});


/* ─────────────────────────────────────────────────────
   2. NAVBAR – Staggered fade-in animation
───────────────────────────────────────────────────── */
document.querySelectorAll('.main-navbar .nav-item').forEach((el, i) => {
  el.style.opacity    = '0';
  el.style.transform  = 'translateY(-8px)';
  el.style.transition = `opacity .3s ease ${i * 60}ms, transform .3s ease ${i * 60}ms`;
  // BUG FIX: template literal এ missing backtick ও braces ছিল

  setTimeout(() => {
    el.style.opacity   = '1';
    el.style.transform = 'translateY(0)';
  }, 50);
});


/* ─────────────────────────────────────────────────────
   3. NAVBAR – Active page detector (desktop + mobile)
───────────────────────────────────────────────────── */
(function () {
  const currentPage = window.location.pathname.split('/').pop() || 'index.html';

  /* ── Desktop nav links ── */
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

  /* ── Desktop submenu links ── */
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

  /* ── Mobile offcanvas links ── */
  document.querySelectorAll('.offcanvas-body .nav-link, .mobile-submenu li a').forEach((link) => {
    const linkPage = (link.getAttribute('href') || '').split('/').pop();
    if (linkPage !== currentPage) return;

    link.classList.add('mobile-active');

    const parentMobileItem = link.closest('.mobile-menu-item');
    if (parentMobileItem) parentMobileItem.classList.add('active');
  });

  /* ── Mobile dropdown toggle ── */
  // NOTE: নিচে duplicate ছিল – একটাই রাখা হয়েছে
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
  const drawer  = document.getElementById('cpDrawer');
  const overlay = document.getElementById('cpOverlay');
  const closeBtn = document.getElementById('cpClose');
  if (!drawer || !overlay || !closeBtn) return;

  function cpOpen() {
    drawer.classList.add('active');
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function cpClose() {
    drawer.classList.remove('active');
    overlay.classList.remove('active');
    document.body.style.overflow = '';
  }

  /* Cart trigger elements bind করা */
  function bindTriggers() {
    document.querySelectorAll('#cartTrigger, .cart-btn').forEach((el) => {
      el.addEventListener('click', (e) => { e.preventDefault(); cpOpen(); });
    });

    document.querySelectorAll('.icon-btn').forEach((el) => {
      if (!el.querySelector('.bi-bag, .bi-bag-fill')) return;
      el.addEventListener('click', (e) => { e.preventDefault(); cpOpen(); });
    });
  }

  overlay.addEventListener('click', cpClose);
  closeBtn.addEventListener('click', cpClose);
  document.addEventListener('keydown', (e) => { if (e.key === 'Escape') cpClose(); });

  /* Item remove */
  window.cpRemoveItem = function (btn) {
    const item = btn.closest('.cp-item');
    if (!item) return;
    item.classList.add('removing');
    setTimeout(() => { item.remove(); cpUpdateState(); }, 220);
  };

  /* Cart state update (count + total + empty view) */
  function cpUpdateState() {
    const items = document.querySelectorAll('#cpItems .cp-item');
    const count = items.length;

    document.getElementById('cpCount').textContent        = count;
    document.getElementById('cpProductCount').textContent = count + ' Product';

    let total = 0;
    items.forEach((item) => {
      const meta = item.querySelector('.cp-item-meta strong');
      if (meta) {
        const val = parseFloat(meta.textContent.replace('৳', '').trim());
        if (!isNaN(val)) total += val;
      }
    });
    document.getElementById('cpTotal').textContent = '৳' + total.toFixed(2);

    const empty   = document.getElementById('cpEmpty');
    const footer  = document.getElementById('cpFooter');
    const itemsEl = document.getElementById('cpItems');

    if (count === 0) {
      itemsEl.style.display = 'none';
      empty.style.display   = 'flex';
      footer.style.display  = 'none';
    } else {
      itemsEl.style.display = '';
      empty.style.display   = 'none';
      footer.style.display  = '';
    }
  }

  document.addEventListener('DOMContentLoaded', bindTriggers);
  bindTriggers(); // DOMContentLoaded আগেই fired হলেও কাজ করবে
})();


/* ─────────────────────────────────────────────────────
   5. SCROLL-TRIGGERED ANIMATIONS (Footer / Sections)
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
   6. QUICK VIEW (Eye / Product popup)
───────────────────────────────────────────────────── */
(function () {
  const backdrop = document.getElementById('qvBackdrop');
  if (!backdrop) return;

  /* Quick view open – delegate to document */
  document.addEventListener('click', function (e) {
    const eyeBtn = e.target.closest('button[title="Quick View"]');
    if (!eyeBtn) return;

    e.stopPropagation();

    const card = eyeBtn.closest('.product-card, .hotProduct-card, .slider-product, .featured-card');
    if (!card) return;

    document.getElementById('qvImg').src                  = card.querySelector('.product-img-wrap img')?.src || '';
    document.getElementById('qvTitle').textContent        = card.querySelector('.product-name')?.textContent.trim() || '';
    document.getElementById('qvPrice').textContent        = card.querySelector('.price-main')?.textContent.trim() || '';
    document.getElementById('qvOld').textContent          = card.querySelector('.price-old')?.textContent.trim() || '';
    document.getElementById('qvCat').textContent          = card.dataset.category || 'Fresh Produce';
    document.getElementById('qvDesc').textContent         = card.dataset.desc     || 'Fresh, naturally grown product. Perfect for everyday cooking.';
    document.getElementById('qvQty').value                = 1;

    const badge   = card.querySelector('.sale-badge');
    const discEl  = document.getElementById('qvDiscount');
    discEl.textContent    = badge ? badge.textContent.trim() : '';
    discEl.style.display  = badge ? 'inline-block' : 'none';

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
    const i = document.getElementById('qvQty');
    if (+i.value > 1) i.value = +i.value - 1;
  });

  document.getElementById('qvPlus').addEventListener('click', () => {
    const i = document.getElementById('qvQty');
    if (+i.value < 99) i.value = +i.value + 1;
  });
})();