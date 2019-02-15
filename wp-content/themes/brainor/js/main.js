jQuery(document).ready(function($) {
    $(".owl-carousel-promotions").owlCarousel({
        loop:true,
        items:1,
        dots: false,
        autoplay:true,
        autoplayHoverPause:true
    });

    $( ".product-count" ).styler();

    $(document).on('change', "input[name='attribute_pa_size']", function () {
        let input = $(this);
        input.closest('.product-block').find('.product-price').html(input.data('price') + ' р.');
    });

});