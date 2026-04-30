/* ═══════════════════════════════════
   SHOP PAGE — MAIN JS
═══════════════════════════════════ */

$(function () {

  let activeCategory = 'all';

  /* ── Category Filter ── */
  $(document).on('click', '.category-item', function () {
    $('.category-item').removeClass('active-cat');
    $(this).addClass('active-cat');
    activeCategory = $(this).data('filter');
    applyFilter();

    // Mobile এ sidebar বন্ধ করো
    if (window.innerWidth < 992) {
      closeSidebar();
    }
  });

  /* ── Search ── */
  $('#searchInput').on('keyup', function () {
    applyFilter();
  });

  /* ── Sort ── */
  $('#sortSelect').on('change', function () {
    let val   = $(this).val();
    let items = $('#product-grid .product-col').toArray();

    if (val === 'name') {
      items.sort(function (a, b) {
        let nameA = $(a).find('.product-name').text().trim().toLowerCase();
        let nameB = $(b).find('.product-name').text().trim().toLowerCase();
        return nameA.localeCompare(nameB);
      });
      $('#product-grid').append(items);
    }
    applyFilter();
  });

  /* ── Main Filter ── */
  function applyFilter() {
    let search = $('#searchInput').val().toLowerCase().trim();
    let count  = 0;

    $('#product-grid .product-col').each(function () {
      let cat      = String($(this).data('category') || '').toLowerCase();
      let name     = $(this).find('.product-name').text().toLowerCase();
      let catMatch = (activeCategory === 'all') || (cat === activeCategory.toLowerCase());
      let srcMatch = (search === '') || name.includes(search);

      if (catMatch && srcMatch) {
        $(this).show();
        count++;
      } else {
        $(this).hide();
      }
    });

    $('#results-count').text(count + ' Results Found');
  }

  /* ── Countdown Timer ── */
  document.querySelectorAll('.countdown[data-ends]').forEach(function (el) {
    const endTime = parseInt(el.dataset.ends);
    function tick() {
      const diff = endTime - Date.now();
      if (diff <= 0) {
        el.innerHTML = '<span style="color:#ef4444;font-size:11px;">Ended</span>';
        return;
      }
      const days  = Math.floor(diff / 86400000);
      const hours = Math.floor((diff % 86400000) / 3600000);
      const mins  = Math.floor((diff % 3600000) / 60000);
      const secs  = Math.floor((diff % 60000) / 1000);
      el.querySelector('.cd-days').textContent  = String(days).padStart(2,'0');
      el.querySelector('.cd-hours').textContent = String(hours).padStart(2,'0');
      el.querySelector('.cd-mins').textContent  = String(mins).padStart(2,'0');
      el.querySelector('.cd-secs').textContent  = String(secs).padStart(2,'0');
    }
    tick();
    setInterval(tick, 1000);
  });

});

/* ═══════════════════════════════════
   SIDEBAR TOGGLE (Mobile)
═══════════════════════════════════ */
function closeSidebar() {
  document.getElementById('filter-sidebar').classList.remove('show');
  const backdrop = document.querySelector('.sidebar-backdrop');
  if (backdrop) backdrop.style.display = 'none';
}

function toggleSidebar() {
  const sidebar = document.getElementById('filter-sidebar');
  let backdrop  = document.querySelector('.sidebar-backdrop');

  if (!backdrop) {
    backdrop = document.createElement('div');
    backdrop.className = 'sidebar-backdrop';
    document.body.appendChild(backdrop);
    backdrop.addEventListener('click', closeSidebar);
  }

  if (sidebar.classList.contains('show')) {
    closeSidebar();
  } else {
    sidebar.classList.add('show');
    backdrop.style.display = 'block';
  }
}

document.addEventListener('click', function (e) {
  if (window.innerWidth >= 992) return;
  const sidebar   = document.getElementById('filter-sidebar');
  const filterBtn = e.target.closest('.filter-btn');
  if (!sidebar.contains(e.target) && !filterBtn) {
    if (sidebar.classList.contains('show')) closeSidebar();
  }
});