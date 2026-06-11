/* ============================================================
   HERO BANNER SLIDER — #heroBanner scope
   ============================================================ */
$(document).ready(function () {


  $('.testimonial-slider').owlCarousel({
  loop: true,
  margin: 20,
  autoplay: true,
  autoplayTimeout: 2000,
  autoplayHoverPause: true,
  dots: false,
  nav: false,
  smartSpeed: 800,
  autoplaySpeed: 800,
  responsive: {
    0:   { items: 1 },
    768: { items: 2 },
    992: { items: 3 }
  }
});

  // ✅ শুধু #heroBanner এর ভেতরের .slide নেওয়া হচ্ছে
  const $hero  = $('#heroBanner');
  const slides = $hero.find('.slide');
  const total  = slides.length;
  let current  = 0;
  let heroTimer;

  function showSlide(index) {
    slides.removeClass('active');
    slides.eq(index).addClass('active');
  }

  function resetHeroTimer() {
    clearInterval(heroTimer);
    heroTimer = setInterval(function () {
      current = (current + 1) % total;
      showSlide(current);
    }, 3000);
  }

  // ✅ #heroBanner scoped — conflict নেই
  $hero.find('.slider-next').click(function () {
    current = (current + 1) % total;
    showSlide(current);
    resetHeroTimer();
  });

  $hero.find('.slider-prev').click(function () {
    current = (current - 1 + total) % total;
    showSlide(current);
    resetHeroTimer();
  });

  resetHeroTimer();
});
// hero ends


/* ============================================================
   GENERIC PRODUCT SLIDER FACTORY
   — একই function দিয়ে যেকোনো section চালানো যাবে
   ============================================================ */
function initProductSlider(sectionSelector) {

  const $section   = $(sectionSelector);
  if (!$section.length) return;

  const $track     = $section.find('.slider-track');
  const $cards     = $section.find('.slider-product');
  const totalCards = $cards.length;
  if (!totalCards) return;

  let index           = 0;
  let slideInterval;
  let isTransitioning = false;

  // Clone for infinite loop
  for (let i = 0; i < totalCards; i++) {
    $track.append($cards.eq(i).clone());
  }

  function getCardWidth() {
    return $section.find('.slider-product').first().outerWidth(true);
  }

  function getVisibleItems() {
    const w = $(window).width();
    if (w < 768)  return 2;
    if (w < 1024) return 3;
    return 5;
  }

  function move(animate) {
    if (animate === undefined) animate = true;
    $track.css('transition', animate ? 'transform 0.6s ease' : 'none');
    $track.css('transform', 'translateX(-' + (index * getCardWidth()) + 'px)');
  }

  function nextSlide() {
    if (isTransitioning) return;
    isTransitioning = true;
    index++;
    move();

    if (index >= totalCards) {
      setTimeout(function () {
        index = 0;
        move(false);
        setTimeout(function () { isTransitioning = false; }, 50);
      }, 600);
    } else {
      setTimeout(function () { isTransitioning = false; }, 600);
    }
  }

  function prevSlide() {
    if (isTransitioning) return;
    isTransitioning = true;

    if (index <= 0) {
      index = totalCards;
      move(false);
      setTimeout(function () {
        index--;
        move();
        setTimeout(function () { isTransitioning = false; }, 600);
      }, 50);
    } else {
      index--;
      move();
      setTimeout(function () { isTransitioning = false; }, 600);
    }
  }

  function startAutoSlide() {
    slideInterval = setInterval(nextSlide, 2500);
  }

  function resetAutoSlide() {
    clearInterval(slideInterval);
    startAutoSlide();
  }

  // ✅ Section-scoped buttons — কোনো conflict নেই
  $section.find('.next').click(function (e) {
    e.preventDefault();
    nextSlide();
    resetAutoSlide();
  });

  $section.find('.prev').click(function (e) {
    e.preventDefault();
    prevSlide();
    resetAutoSlide();
  });

  $section.find('.slider-dot').click(function () {
    if (isTransitioning) return;
    index = $(this).index();
    move();
    resetAutoSlide();
  });

  // Pause on hover
  $section.find('.slider-wrapper, .slider-parent').hover(
    function () { clearInterval(slideInterval); },
    function () { startAutoSlide(); }
  );

  // Touch / Swipe
  let touchStartX = 0;
  $track.on('touchstart', function (e) {
    touchStartX = e.originalEvent.touches[0].clientX;
  });
  $track.on('touchend', function (e) {
    const diff = touchStartX - e.originalEvent.changedTouches[0].clientX;
    if (Math.abs(diff) > 50) {
      diff > 0 ? nextSlide() : prevSlide();
      resetAutoSlide();
    }
  });

  // Resize
  let resizeTimer;
  $(window).resize(function () {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function () {
      move(false);
      setTimeout(function () { move(true); }, 150);
    }, 250);
  });

  startAutoSlide();
}

// ✅ প্রতিটা section আলাদাভাবে init
$(function () {
  initProductSlider('#featureProduct');
});




/* ============================================================
   COUNTDOWN TIMER
   ============================================================ */
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
    const mins  = Math.floor((diff % 3600000)  / 60000);
    const secs  = Math.floor((diff % 60000)    / 1000);

    el.querySelector('.cd-days').textContent  = String(days).padStart(2, '0');
    el.querySelector('.cd-hours').textContent = String(hours).padStart(2, '0');
    el.querySelector('.cd-mins').textContent  = String(mins).padStart(2, '0');
    el.querySelector('.cd-secs').textContent  = String(secs).padStart(2, '0');
  }

  tick();
  setInterval(tick, 1000);
});