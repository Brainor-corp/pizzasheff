<?php
/**
 * Шаблон подвала (footer.php)
 * @package WordPress
 * @subpackage brainor
 */
?>
	<footer>
		<div class="container-fluid bg-white py-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-12 text-md-left text-center">
                        <h5 class="footer-label mb-5">
                            Информация
                        </h5>
                        <ul class="pl-0 list-unstyled">
                            <?php query_posts('tag=show_in_footer'); ?>
                            <?php if (have_posts()) : while (have_posts()) : the_post(); // если посты есть - запускаем цикл wp ?>
                                <li class="mb-2">
                                    <a href="<?php echo get_the_permalink() ?>" class="text-orange"><?php echo get_the_title() ?></a>
                                </li>
                            <?php endwhile; endif; ?>
                            <li class="mb-2">
                                <a href="#" class="text-orange" data-toggle="modal" data-target="#contactModal">Обратная связь</a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="text-orange" data-toggle="modal" data-target="#deliveryModal">Доставка</a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="text-orange" data-toggle="modal" data-target="#liveModal">Live</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-3 col-12 text-md-left text-center">
                        <h5 class="footer-label mb-5">
                            Продукты
                        </h5>
                        <?php $args = array( // опции для вывода верхнего меню, чтобы они работали, меню должно быть создано в админке
                            'theme_location' => 'bottom', // идентификатор меню, определен в register_nav_menus() в functions.php
                            'container' => false, // обертка списка, тут не нужна
                            'menu_id' => 'bottom-nav-ul', // id для ul
                            'items_wrap' => '<ul id="%1$s" class="menu %2$s">%3$s</ul>',
                            'menu_class' => 'nav_bottom', // класс для ul, первые 2 обязательны
                            'walker'          => '',
                        );
                        wp_nav_menu($args); // выводим верхнее меню
                        ?>
                    </div>
                    <div class="col-md-6 col-12 text-md-left text-center">
                        <h5 class="footer-label mb-5">
                            Зона охвата
                        </h5>
                        <div>
                            <?php //echo get_option('map'); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 py-3">
                        <hr class="my-1">
                        <hr class="my-0">
                    </div>
                </div>
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-auto col-12 text-md-left text-center">
                        <span class="text-orange">© <?php echo date("Y"); ?> - ПиццаШефф</span>
                    </div>
                    <div class="col-md-auto col-12 my-md-0 my-2 text-md-left text-center">
                        <img src="/wp-content/themes/brainor/imgs/logo-orange.png" class="img-fluid logo-orange" alt="">
                    </div>
                    <div class="col-md-auto col-12 text-md-left text-center">
                        <a href="tel:<?php echo get_option('phone'); ?>" class="text-orange mr-2"><?php echo get_option('phone'); ?></a>
                        <a href="<?php echo get_option('instagram'); ?>">
                            <img src="/wp-content/themes/brainor/imgs/ins-orange.png" alt="" class="img-fluid">
                        </a>
                    </div>
                </div>
            </div>
        </div>
	</footer>
    <?php get_template_part('partials/modals/part', 'contact-form') ?>
    <?php get_template_part('partials/modals/part', 'delivery') ?>
    <?php get_template_part('partials/modals/part', 'live') ?>
    <div class="preload"></div>
<?php wp_footer(); // необходимо для работы плагинов и функционала  ?>
</body>
</html>