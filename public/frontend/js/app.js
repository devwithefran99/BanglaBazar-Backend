

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
 let total = 60*86400 + 23*3600 + 34*60 + 57;
  setInterval(() => {
    if(total <= 0) return;
    total--;
    const d = Math.floor(total/86400);
    const h = Math.floor((total%86400)/3600);
    const m = Math.floor((total%3600)/60);
    const s = total%60;
    document.getElementById('cd-days').textContent  = String(d).padStart(2,'0');
    document.getElementById('cd-hours').textContent = String(h).padStart(2,'0');
    document.getElementById('cd-mins').textContent  = String(m).padStart(2,'0');
    document.getElementById('cd-secs').textContent  = String(s).padStart(2,'0');
  }, 1000);

// hot deals ends

  // tranding slide js
$(function(){

const track = $('.slider-track')
let card = $('.slider-product')

/* clone cards for infinite */
track.append(card.clone())

card = $('.slider-product')

let index = 0
let slideInterval

function cardWidth(){
return card.outerWidth(true)
}

function visible(){
let w = $(window).width()

if(w < 768) return 2
if(w < 1024) return 3
return 5
}

function move(){
track.css('transform','translateX(-'+ index * cardWidth() +'px)')
}

function nextSlide(){

index++
move()

if(index >= card.length/2){

setTimeout(function(){

track.css('transition','none')
index = 0
move()

setTimeout(function(){
track.css('transition','transform .6s ease')
},50)

},600)

}

}

function prevSlide(){

if(index <= 0){
index = card.length/2
track.css('transition','none')
move()

setTimeout(function(){
track.css('transition','transform .6s ease')
},50)
}

index--
move()

}

/* BUTTON CONTROL */

$('.next').click(function(){
nextSlide()
})

$('.prev').click(function(){
prevSlide()
})

/* AUTO SLIDE */

slideInterval = setInterval(nextSlide,2500)

/* RESIZE */

$(window).resize(function(){
move()
})

})


  // end of tranding slider js

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
