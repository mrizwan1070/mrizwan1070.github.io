jQuery(document).ready(function () {
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
});
