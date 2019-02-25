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

    $( document.body ).on( 'updated_cart_totals', function(){
        updateCart();
        $( ".product-count" ).styler();
    });

    $( ".product-count" ).styler();

    $(document).on('change', "input[name='attribute_pa_size']", function () {
        let input = $(this);
        input.closest('.product-block').find('.product-price').html(input.data('price') + ' р.');
    });


    function updateCart() {
        console.log($('meta[name="ajax-url"]').attr('content'));
        $.ajax({
            type: 'POST',
            url: $('meta[name="ajax-url"]').attr('content'),
            data: {
                action: 'get_cart_update',
            },
            dataType: 'html',
            success: function(data){
                $('span.cart-info').html(data);
                $('.preload').hide();
            },
            error: function (data) {
                console.log('error');
                console.log(data);
                $('.preload').hide();
            }
        });
    }

    $(document).on('submit', '.to-cart-form', function (e) {
        e.preventDefault();
        let form = $(this);

        console.log('/?'+form.serialize());

        $.ajax({
            type: 'GET',
            url: '/?'+form.serialize(),
            beforeSend: function () {
                $('.preload').fadeIn();
            },
            success: function(response, textStatus, jqXHR){
                updateCart();
            },
            error: function (error) {
                console.log(error);
                $('.preload').fadeOut();
            }
        });
    })
});