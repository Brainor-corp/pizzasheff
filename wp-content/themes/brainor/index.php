<?php
/**
 * Главная страница (index.php)
 * @package WordPress
 * @subpackage brainor
 */
get_header(); // подключаем header.php ?> 

<!-- Блок с акциями -->
<section>
    <?php get_template_part('partials/common/part', 'promotions') ?>
</section>

<!-- Блок с товарами -->
<section>
    <h3 class="text-center text-white font-weight-light my-5">Популярные товары</h3>
    <?php
    $args = array(
        'limit' => 9,
        'orderby' => 'date',
        'order' => 'DESC',
    );
        $products = wc_get_products( $args );
        hm_get_template_part( 'partials/common/part-products', [ 'products' => $products ] );
    ?>

</section>

<!-- Блок с плюсами завидения -->
<section>
    <?php get_template_part('partials/common/part', 'pluses') ?>
</section>

<!-- Блок с формой подписки -->
<section>
    <?php get_template_part('partials/common/part', 'subscribe') ?>
</section>

<?php get_footer(); // подключаем footer.php ?>