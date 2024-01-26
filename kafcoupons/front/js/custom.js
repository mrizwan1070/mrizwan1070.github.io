jQuery(document).ready(function () {
 // brand slider
 $('.brand-slider').slick({
    slidesToShow: 10,
    slidesToScroll: 1,
    autoplay: true,
    infinite: true,
    autoplaySpeed: 0,
    speed: 1000,
    pauseOnFocus: false, 
    pauseOnHover: true,
    cssEase: 'linear',
    responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 5,
            infinite: true,
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 3,
            infinite: true,
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 2,
            infinite: true,
          }
        }
    ]
});
$('.category-cards').slick({
    slidesToShow: 2,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 0,
    speed: 13000,
    pauseOnFocus: false, 
    pauseOnHover: true,
    cssEase: 'linear',
    arrows: false,
    responsive: [
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 1,
            infinite: true,
          }
        },
        // {
        //   breakpoint: 480,
        //   settings: {
        //     slidesToShow: 2,
        //     infinite: true,
        //   }
        // }
    ]
});
});
