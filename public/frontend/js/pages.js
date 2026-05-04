/* ─────────────────────────────────────────────────────
   1. CUSTOM CURSOR
───────────────────────────────────────────────────── */
const cursor = document.getElementById('customCursor');

if (cursor) {
  let timeout;

  document.addEventListener('mousemove', (e) => {
    cursor.style.left = e.clientX + 'px';
    cursor.style.top  = e.clientY + 'px';
    clearTimeout(timeout);
    cursor.classList.remove('active');
    timeout = setTimeout(() => {
      cursor.classList.add('active');
    }, 800);
  });

  document.querySelectorAll('a, button, .btn, .card, input, textarea, [role="button"]')
    .forEach(el => {
      el.addEventListener('mouseenter', () => cursor.classList.add('hover'));
      el.addEventListener('mouseleave', () => cursor.classList.remove('hover'));
    });

  document.addEventListener('mousedown', () => cursor.classList.add('active'));
  document.addEventListener('mouseup',   () => cursor.classList.remove('active'));
}

/* ─────────────────────────────────────────────────────
   2. PRELOADER
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
   3. NAVBAR ANIMATION
───────────────────────────────────────────────────── */
document.querySelectorAll('.main-navbar .nav-item').forEach((el, i) => {
  el.style.opacity    = '0';
  el.style.transform  = 'translateY(-8px)';
  el.style.transition = `opacity .3s ease ${i * 60}ms, transform .3s ease ${i * 60}ms`;
  setTimeout(() => {
    el.style.opacity   = '1';
    el.style.transform = 'translateY(0)';
  }, 50);
});

/* ─────────────────────────────────────────────────────
   4. MOBILE DROPDOWN SUBMENU
───────────────────────────────────────────────────── */
document.querySelectorAll('.mobile-toggle').forEach(item => {
  item.addEventListener('click', function () {
    this.parentElement.classList.toggle('active');
  });
});

/* ─────────────────────────────────────────────────────
   5. WISHLIST PAGE
───────────────────────────────────────────────────── */
let toastTimer;

function removeCard(id) {
  const card = document.getElementById(id);
  if (!card) return;
  card.style.transition = 'opacity 0.3s, transform 0.3s';
  card.style.opacity    = '0';
  card.style.transform  = 'translateX(20px)';
  setTimeout(() => card.remove(), 300);

  const wrap = document.getElementById('toastWrap');
  const el   = document.getElementById('toastMsg');
  if (wrap && el) {
    el.textContent    = '🗑 Item removed from wishlist';
    wrap.style.display = 'block';
    el.style.animation = 'none';
    void el.offsetWidth;
    el.style.animation = 'slideUp 0.3s ease';
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => { wrap.style.display = 'none'; }, 2800);
  }
}

/* ─────────────────────────────────────────────────────
   6. SINGLE PRODUCT (checkout) PAGE
───────────────────────────────────────────────────── */
const toastEl = document.getElementById('toast');

function showToast(msg) {
  if (!toastEl) return;
  toastEl.textContent = msg;
  toastEl.classList.add('show');
  clearTimeout(toastEl._t);
  toastEl._t = setTimeout(() => toastEl.classList.remove('show'), 2500);
}

let qty = 1;

function changeQty(d) {
  const next = qty + d;
  if (next < 1) { showToast('Minimum quantity is 1'); return; }
  qty = next;
  const qtyNum = document.getElementById('qtyNum');
  if (qtyNum) qtyNum.textContent = qty;
}

function addToCart() {
  showToast('✓ Added ' + qty + ' item(s) to cart');
}

function buyNow() {
  const modalMsg = document.getElementById('modalMsg');
  const buyModal = document.getElementById('buyModal');
  if (modalMsg) {
    modalMsg.innerHTML = 'You\'re ordering <strong>' + qty + ' × Chinese Cabbage</strong>. Choose your payment method:';
  }
  if (buyModal) buyModal.classList.add('open');
}

function closeModal() {
  const buyModal = document.getElementById('buyModal');
  if (buyModal) buyModal.classList.remove('open');
}

function confirmOrder() {
  const pay = document.querySelector('input[name="pay"]:checked');
  if (!pay) return;
  closeModal();
  showToast('🎉 Order placed via ' + (pay.value === 'cod' ? 'Cash on Delivery' : 'bKash') + '!');
}

// Product image thumbs
const thumbsEl = document.getElementById('thumbs');
if (thumbsEl) {
  thumbsEl.querySelectorAll('.pd-thumb').forEach((th) => {
    th.addEventListener('click', () => {
      document.querySelectorAll('.pd-thumb').forEach(t => t.classList.remove('active'));
      th.classList.add('active');
      const mainImg = document.getElementById('mainImg');
      if (mainImg) mainImg.src = th.querySelector('img').src;
    });
  });
}

// Buy modal backdrop click
const buyModalEl = document.getElementById('buyModal');
if (buyModalEl) {
  buyModalEl.addEventListener('click', function (e) {
    if (e.target === this) closeModal();
  });
}

// Product detail tabs
function switchTab(id, btn) {
  document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  const panel = document.getElementById('tab-' + id);
  if (panel) panel.classList.add('active');
  if (btn)   btn.classList.add('active');
}

/* ─────────────────────────────────────────────────────
   7. USER DASHBOARD PAGE
───────────────────────────────────────────────────── */
const orderList = document.getElementById('order-list');

if (orderList) {
  const orders = [
    { name: 'Running Shoes',      date: '8 Sep, 2020',  qty: 5,  total: 135, status: 'processing' },
    { name: 'Wireless Headphones',date: '24 May, 2020', qty: 1,  total: 25,  status: 'onway'      },
    { name: 'Smart Watch Set',    date: '22 Oct, 2020', qty: 4,  total: 250, status: 'done'       },
    { name: 'Gym Water Bottle',   date: '1 Feb, 2020',  qty: 1,  total: 35,  status: 'done'       },
    { name: 'Leather Backpack',   date: '21 Sep, 2020', qty: 13, total: 578, status: 'done'       },
    { name: 'Desk Organizer',     date: '22 Oct, 2020', qty: 7,  total: 345, status: 'done'       },
  ];

  const statusLabels = { processing: 'Processing', onway: 'On the Way', done: 'Completed' };

  orders.forEach(o => {
    const row = document.createElement('div');
    row.className = 'order-row';
    row.innerHTML = `
      <div>
        <div class="order-name">${o.name}</div>
        <div class="order-date">${o.date}</div>
      </div>
      <div class="qty-cell">${o.qty} pcs</div>
      <div class="total-cell">$${o.total.toFixed(2)}</div>
      <div><span class="badge ${o.status}">${statusLabels[o.status]}</span></div>`;
    orderList.appendChild(row);
  });

  // Dashboard sidebar
  function openSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    if (sidebar) sidebar.classList.add('open');
    if (overlay) overlay.classList.add('open');
  }

  function closeSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    if (sidebar) sidebar.classList.remove('open');
    if (overlay) overlay.classList.remove('open');
  }

  // AI assistant
  const CONTEXT = `You are a friendly ecommerce assistant. Answer in 1-3 short sentences, be friendly and concise.`;

  async function sendQ(preset) {
    const input = document.getElementById('ai-q');
    const msgs  = document.getElementById('ai-messages');
    const btn   = document.getElementById('ai-btn');
    if (!input || !msgs || !btn) return;

    const q = preset || input.value.trim();
    if (!q) return;
    input.value = '';

    msgs.innerHTML += `<div class="user-bubble">${q}</div>`;

    const typing = document.createElement('div');
    typing.className = 'typing';
    typing.innerHTML = `<div class="dot"></div><div class="dot"></div><div class="dot"></div>`;
    msgs.appendChild(typing);
    msgs.scrollTop = msgs.scrollHeight;
    btn.disabled = true;

    try {
      const r = await fetch('https://api.anthropic.com/v1/messages', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          model: 'claude-sonnet-4-20250514',
          max_tokens: 1000,
          system: CONTEXT,
          messages: [{ role: 'user', content: q }]
        })
      });
      const d   = await r.json();
      const txt = d.content?.find(c => c.type === 'text')?.text || "Sorry, I couldn't get a response.";
      typing.remove();
      msgs.innerHTML += `<div class="ai-bubble">${txt}</div>`;
    } catch (e) {
      typing.remove();
      msgs.innerHTML += `<div class="ai-bubble">Connection error. Please try again.</div>`;
    }

    btn.disabled = false;
    msgs.scrollTop = msgs.scrollHeight;
  }

  // sendQ global এ রাখো যাতে HTML onclick থেকে call করা যায়
  window.sendQ        = sendQ;
  window.openSidebar  = openSidebar;
  window.closeSidebar = closeSidebar;
}

/* ─────────────────────────────────────────────────────
   8. BILLING PAGE
───────────────────────────────────────────────────── */
const blPayGroup = document.getElementById('blPayGroup');
if (blPayGroup) {
  blPayGroup.querySelectorAll('input[type="radio"]').forEach(radio => {
    radio.addEventListener('change', () => {
      blPayGroup.querySelectorAll('.bl-radio-option').forEach(opt => opt.classList.remove('selected'));
      radio.closest('.bl-radio-option')?.classList.add('selected');
    });
  });
}

const blShipDiff = document.getElementById('blShipDiff');
if (blShipDiff) {
  blShipDiff.addEventListener('change', function () {
    // extend: show a secondary address form here
  });
}

function placeOrder() {
  alert('Order Placed! 🎉');
}