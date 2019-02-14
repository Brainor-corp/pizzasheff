jQuery(document).ready(function($) {
    $(".owl-carousel-promotions").owlCarousel({
        loop:true,
        items:1,
        dots: false
    });

    function inputChangeCount(direct) {
        let button = $(this);
        let input = button.closest('.product-counter-group').find('input');
        console.log(direct);

        if(direct === 'down') {
            input.val(parseInt(input.val()) > 1 ? parseInt(input.val()) - 1 : 1);
        } else {
            input.val(parseInt(input.val()) + 1);
        }
    }

    var timeoutId = 0;

    $(document).on('mousedown', '.product-count-down', function() {
        timeoutId = setTimeout(inputChangeCount('down'), 700);
    }).on('mouseup mouseleave', function() {
        clearTimeout(timeoutId);
    });

    $(document).on('mousedown', '.product-count-up', function() {
        timeoutId = setTimeout(inputChangeCount('up'), 700);
    }).on('mouseup mouseleave', function() {
        clearTimeout(timeoutId);
    });

    $(document).on('click', '.product-count-down', function () {
        inputChangeCount('down');

        // let button = $(this);

        // let input = button.closest('.product-counter-group').find('input');
        // input.val(parseInt(input.val()) > 1 ? parseInt(input.val()) - 1 : 1);
    });

    $(document).on('click', '.product-count-up', function () {
        inputChangeCount('up');
        //
        // let button = $(this);
        // let input = button.closest('.product-counter-group').find('input');
        //
        // input.val(parseInt(input.val()) + 1);
    });
});