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

  /* ── Search Input (shop page internal) ── */
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

  /* ═══════════════════════════════════════════════════════
     NAV SEARCH REDIRECT HANDLER
  ═══════════════════════════════════════════════════════ */
  (function handleNavSearchRedirect() {
    const params       = new URLSearchParams(window.location.search);
    const searchText   = params.get('search');
    const highlightId  = params.get('highlight');
    const highlightCat = params.get('category');

    if (searchText) {
      $('#searchInput').val(searchText);
      if (highlightCat && highlightCat !== 'all') {
        activeCategory = highlightCat;
      }
      applyFilter();
      setTimeout(() => {
        const input = document.getElementById('searchInput');
        if (input) input.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }, 300);
    }

    if (highlightId) {
      if (highlightCat && highlightCat !== 'all') {
        activeCategory = highlightCat;
        $('.category-item').removeClass('active-cat');
        $(`.category-item[data-filter="${highlightCat}"]`).addClass('active-cat');
        applyFilter();
      }
      setTimeout(() => {
        const $targetCol = $(`.product-col[data-product-id="${highlightId}"]`);
        if ($targetCol.length) {
          $targetCol[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
          $targetCol.addClass('search-highlight');
          setTimeout(() => $targetCol.removeClass('search-highlight'), 3000);
        }
      }, 400);
    }
  })();

}); // ← $(function) এর closing — এখানেই শেষ


/* ═══════════════════════════════════
   SIDEBAR TOGGLE (Mobile) — GLOBAL
   onclick="toggleSidebar()" কাজ করার
   জন্য এগুলো $(function) এর বাইরে
═══════════════════════════════════ */

function closeSidebar() {
  const sidebar = document.getElementById('filter-sidebar');
  if (!sidebar) return;
  sidebar.classList.remove('show');
  const backdrop = document.querySelector('.sidebar-backdrop');
  if (backdrop) backdrop.style.display = 'none';
}

function toggleSidebar() {
  const sidebar = document.getElementById('filter-sidebar');
  if (!sidebar) return;
  let backdrop = document.querySelector('.sidebar-backdrop');

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
  const sidebar = document.getElementById('filter-sidebar');
  if (!sidebar) return;
  const filterBtn = e.target.closest('.filter-btn');
  if (!sidebar.contains(e.target) && !filterBtn) {
    if (sidebar.classList.contains('show')) closeSidebar();
  }
});