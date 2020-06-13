

/** Slider **/

$(function(){
var mySwiper = new Swiper ('.swiper-container', {
  speed: 800,
  autoplay: 4500,
  autoplayDisableOnInteraction: false,
  loop: true,
  spaceBetween: 10,
  slidesPerView: 'auto',
  centeredSlides : true,
        paginationClickable: true,
  pagination: '.swiper-pagination',
  nextButton: '.swiper-button-next',
  prevButton: '.swiper-button-prev',
  touchRatio: 3
})
});