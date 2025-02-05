jQuery(document).ready(function () {
    $(".sortBtn").on("click", function () {
        $(".sortBtn").removeClass("active");
        $(this).addClass("active");
    });
});
