jQuery(document).ready(function () {
  const returnDateContainer = $('#returnDateContainer');

  function toggleReturnDate() {
      if ($('#oneway').is(':checked')) {
          console.log("I am here");
          returnDateContainer.hide();
      } else {
          returnDateContainer.show();
      }
  }
  $('.search-flight-btn').on('click', function() {
    window.location.href = 'flight.html'; // Change this to your desired URL
});
  // Attach event listener to radio buttons
  $('#round, #oneway').on('change', toggleReturnDate);

  // Call function on page load to set the initial state
  toggleReturnDate();

  $(".pessangerSelect").click(function (event) {
      event.stopPropagation();
  });
  $(".pessanger").click(function () {
      $(".pessangerSelect").css("display", "block");
      console.log("clicked");
  });
  $("#pessangerClose").click(function () {
      $(".pessangerSelect").css("display", "none");
  });
  $('#setPessanger').click(function () {
      var adult = $('#adult').val();
      var child = $('#child').val();
      var infant = $('#infant').val();

      var totalPessanger = '';

      if (adult > 0) {
          totalPessanger += adult + (adult > 1 ? ' Adults, ' : ' Adult, ');
      }
      if (child > 0) {
          totalPessanger += child + (child > 1 ? ' Children, ' : ' Child, ');
      }
      if (infant > 0) {
          totalPessanger += infant + (infant > 1 ? ' Infants' : ' Infant');
      }

      $('#totalPessanger').val(totalPessanger);
      $(".pessangerSelect").css("display", "none");
  });
  $(".sortBtn").on("click", function () {
    $(".sortBtn").removeClass("active");
    $(this).addClass("active");
  });
  var tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });
  $('.airline-slider').owlCarousel({
    items:10,
    loop:true,
    margin:1,
    autoplay:true,
    autoplayTimeout:2000,
    autoplaySpeed: 2000,
    slideTransition: '',
    autoplayHoverPause:true,
    responsive:{
        1200 : {
            items: 7 
        },
        800 : {
            items: 6 
        },
        768 : {
            items: 5 
        },
        576 : {
            items: 4 
        },
        480 : {
            items: 3 
        },
        0 : {
            items: 2
        }
    }
});
$('.testimonial-slider').owlCarousel({
    items:10,
    loop:true,
    margin:1,
    autoplay:true,
    autoplayTimeout:7000,
    autoplaySpeed: 5000,
    autoHeight: true,
    dots: true,
    nav: true,
    slideTransition: '',
    autoplayHoverPause:true,
    responsive:{
        1200 : {
            items: 3 
        },
        576 : {
            items: 2 
        },
        0 : {
            items: 1
        }
    }
});
});
