(function ($) {
  "use strict";

  // Preloader
  $(window).on("load", function () {
    $("#preloader").fadeOut("slow", function () {
      $(this).remove();
    });
  });

  // e-commerce touchspin
  $("input[name='product-quantity']").TouchSpin();

  //Hero Slider
  $(".hero-slider").slick({
    // autoplay: true,
    infinite: true,
    arrows: true,
    prevArrow:
      "<button type='button' class='heroSliderArrow prevArrow tf-ion-chevron-left'></button>",
    nextArrow:
      "<button type='button' class='heroSliderArrow nextArrow tf-ion-chevron-right'></button>",
    dots: true,
    autoplaySpeed: 7000,
    pauseOnFocus: false,
    pauseOnHover: false,
  });
  $(".hero-slider").slickAnimation();
})(jQuery);
