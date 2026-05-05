
// hero js down
$(document).ready(function(){

  let current = 0;
  let slides = $(".slide");
  let total = slides.length;

  function showSlide(index){
    slides.removeClass("active");
    slides.eq(index).addClass("active");
  }

  $(".slider-next").click(function(){
    current = (current + 1) % total;
    showSlide(current);
  });

  $(".slider-prev").click(function(){
    current = (current - 1 + total) % total;
    showSlide(current);
  });
  
  function showSlide(index){
  $(".slide").removeClass("active");
  $(".slide").eq(index).addClass("active");
}

  // auto slide
  setInterval(function(){
    current = (current + 1) % total;
    showSlide(current);
  }, 3000);

});
// hero part js ends

// hotDeals starts


// hot deals ends

// trending slider js with infinite loop
$(function(){

  const track = $('.slider-track');
  const card = $('.slider-product');
  const totalCards = card.length;
  
  let index = 0;
  let slideInterval;
  let isTransitioning = false;

  // Clone ALL cards for seamless infinite loop
  for(let i = 0; i < totalCards; i++) {
    track.append(card.eq(i).clone());
  }

  function getCardWidth() {
    return card.outerWidth(true);
  }

  function getVisibleItems() {
    let w = $(window).width();
    if(w < 768) return 2;
    if(w < 1024) return 3;
    return 5;
  }

  function move(animate = true) {
    if(!animate) {
      track.css('transition', 'none');
    } else {
      track.css('transition', 'transform 0.6s ease');
    }
    
    track.css('transform', 'translateX(-' + (index * getCardWidth()) + 'px)');
  }

  function nextSlide() {
    if(isTransitioning) return;
    isTransitioning = true;
    
    index++;
    move();

    // If we reach the cloned set, reset to original position
    if(index >= totalCards) {
      setTimeout(function() {
        index = 0;
        move(false);
        
        // Re-enable transition after reset
        setTimeout(function() {
          move(true);
          isTransitioning = false;
        }, 50);
      }, 600); // Match this with CSS transition duration
    } else {
      setTimeout(function() {
        isTransitioning = false;
      }, 600);
    }
  }

  function prevSlide() {
    if(isTransitioning) return;
    isTransitioning = true;
    
    if(index <= 0) {
      index = totalCards;
      move(false);
      
      setTimeout(function() {
        index--;
        move();
      }, 50);
    } else {
      index--;
      move();
    }

    setTimeout(function() {
      isTransitioning = false;
    }, 600);
  }

  function goToSlide(slideIndex) {
    if(isTransitioning) return;
    index = slideIndex;
    move();
  }

  // Button controls
  $('.next').click(function(e) {
    e.preventDefault();
    nextSlide();
    resetAutoSlide();
  });

  $('.prev').click(function(e) {
    e.preventDefault();
    prevSlide();
    resetAutoSlide();
  });

  // Dots navigation (optional - add if you have dots)
  $('.slider-dot').click(function() {
    const dotIndex = $(this).index();
    goToSlide(dotIndex);
    resetAutoSlide();
  });

  // Auto slide
  function startAutoSlide() {
    slideInterval = setInterval(nextSlide, 2500);
  }

  function resetAutoSlide() {
    clearInterval(slideInterval);
    startAutoSlide();
  }

  // Start auto slide
  startAutoSlide();

  // Pause on hover
  $('.slider-parent').hover(
    function() {
      clearInterval(slideInterval);
    },
    function() {
      startAutoSlide();
    }
  );

  // Touch/Swipe support
  let touchStartX = 0;
  let touchEndX = 0;

  track.on('touchstart', function(e) {
    touchStartX = e.originalEvent.touches[0].clientX;
  });

  track.on('touchend', function(e) {
    touchEndX = e.originalEvent.changedTouches[0].clientX;
    handleSwipe();
  });

  function handleSwipe() {
    const swipeThreshold = 50;
    const diff = touchStartX - touchEndX;
    
    if(Math.abs(diff) > swipeThreshold) {
      if(diff > 0) {
        nextSlide();
      } else {
        prevSlide();
      }
      resetAutoSlide();
    }
  }

  // Resize handler
  let resizeTimer;
  $(window).resize(function() {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function() {
      move(false);
      setTimeout(function() {
        move(true);
      }, 50);
    }, 250);
  });

});

  // feedback starts
  $('.testimonial-slider').owlCarousel({
loop:true,
margin:20,
autoplay:true,
autoplayTimeout:2000,
autoplayHoverPause:false,
dots:false,
nav:false,

smartSpeed:800,        
autoplaySpeed:800, 

responsive:{
0:{items:1},
768:{items:2},
992:{items:3}
}
});
// feedback ends

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



