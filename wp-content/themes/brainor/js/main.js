jQuery(document).ready(function($) {
    $(".owl-carousel-promotions").owlCarousel({
        loop:true,
        items:1,
        dots: false,
        autoplay:true,
        autoplayHoverPause:true,
        nav:true,
        navText : ['<i class="fas fa-arrow-left"></i>','<i class="fas fa-arrow-right"></i>']
    });

    $( ".product-count" ).styler();

    $(document).on('change', "input[name='attribute_pa_size']", function () {
        let input = $(this);
        input.closest('.product-block').find('.product-price').html(input.data('price') + ' р.');
    });

});