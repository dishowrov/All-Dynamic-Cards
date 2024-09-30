jQuery(function ($) {
  $('.dis-course-slider').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2000,
  });

  $('.elementor-tab-title').click(function () {
    setTimeout(function () {
      $('.dis-course-slider').slick('setPosition');
    }, 0); 
  });
});
