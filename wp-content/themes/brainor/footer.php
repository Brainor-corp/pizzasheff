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
                        <ul class="pl-0 list-unstyled">
                            <?php get_template_part('partials/header/part', 'products-categories') ?>
                        </ul>
                    </div>
                    <div class="col-md-6 col-12 text-md-left text-center">
                        <h5 class="footer-label mb-5">
                            Зона охвата
                        </h5>
                        <div>
                            <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Aa6352315fb5d5419f1dd9e7382f9a2179be82c5c7c2f62356cebc50a82869c70&amp;width=100%&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script>
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
                        <span class="text-orange">© <?php echo date("Y"); ?> - PizzaShef</span>
                    </div>
                    <div class="col-md-auto col-12 my-md-0 my-2 text-md-left text-center">
                        <img src="/wp-content/themes/brainor/imgs/logo-orange.png" class="img-fluid logo-orange" alt="">
                    </div>
                    <div class="col-md-auto col-12 text-md-left text-center">
                        <a href="tel:84953694879" class="text-orange mr-2">8 (495) 369 48 79</a>
                        <a href="">
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