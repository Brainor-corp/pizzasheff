<?php
/**
 * Главная страница (index.php)
 * @package WordPress
 * @subpackage brainor
 */
get_header(); // подключаем header.php ?> 
<section>
	<?php get_sidebar('promotions') ?>
</section>
<?php get_footer(); // подключаем footer.php ?>