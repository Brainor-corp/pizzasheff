<?php
/**
 * Главная страница (index.php)
 * @package WordPress
 * @subpackage brainor
 */
get_header(); // подключаем header.php ?> 

<!-- Блок с акциями -->
<section>
	<?php get_sidebar('promotions') ?>
</section>

<!-- Блок с товарами -->
<section>
    <h3 class="text-center text-white my-5">Популярные товары</h3>
    <?php get_sidebar('products') ?>
</section>

<!-- Блок с плюсами завидения -->
<section>
    <?php get_sidebar('pluses') ?>
</section>

<?php get_footer(); // подключаем footer.php ?>