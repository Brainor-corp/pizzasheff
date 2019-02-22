<?php
/**
 * Шаблон шапки (header.php)
 * @package WordPress
 * @subpackage brainor
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); // вывод атрибутов языка ?>>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="ajax-url" content="<?php echo admin_url('admin-ajax.php'); ?>">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?php /* RSS и всякое */ ?>
	<link rel="alternate" type="application/rdf+xml" title="RDF mapping" href="<?php bloginfo('rdf_url'); ?>">
	<link rel="alternate" type="application/rss+xml" title="RSS" href="<?php bloginfo('rss_url'); ?>">
	<link rel="alternate" type="application/rss+xml" title="Comments RSS" href="<?php bloginfo('comments_rss2_url'); ?>">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php /* Все скрипты и стили теперь подключаются в functions.php */ ?>

	<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<?php wp_head(); // необходимо для работы плагинов и функционала ?>
</head>
<?php
add_filter('body_class','my_classes_names');
function my_classes_names( $classes ) {
    // добавим класс 'class-name' в массив классов $classes
//        $classes[] = 'lazyload';
    return $classes;
}
?>
<body <?php body_class(); // все классы для body ?>>
	<header>

        <!--    Мобильное меню начало   -->
        <nav canvas="mobile" class="offcanvas fixed-top bg-orange canvas-menu">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-8">
                        <a href="/" class="w-100 text-light m-0 pt-2">
                            <strong>ПиццаШеff</strong>
                        </a>
                    </div>
                    <div class="col text-right">
                        <button class="navbar-toggler navbar-toggle-offcanvas-right p-0 text-right">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <div off-canvas="offcanvas-right right reveal h-100" class="container canvas-menu bg-orange">
            <div class="fixed-top text-center p-3">
                <ul class="pl-0 list-unstyled text-white">
                    <?php get_template_part('partials/header/part', 'pages-links') ?>
                </ul>
            </div>
            <div class="fixed-bottom text-center p-3">
                <a href="/">
                    <img src="/wp-content/themes/brainor/imgs/logo.png" alt="" class="img-fluid">
                </a>
            </div>
        </div>
        <!--    Мобильное меню конец    -->

        <!--    Настольное меню начало    -->
        <div class="container header-container">
            <div class="row justify-content-between mt-md-0 mt-3 header-top">
                <div class="col-md col-auto header-first">
                    <div class="row mb-3 d-md-block d-none">
                        <div class="col">
                            <a href="/">
                                <strong>ПиццаШеff - территория вкусной пиццы</strong>
                            </a>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            Ежедневно с <strong>10:00</strong> до <strong>22:00</strong>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-auto pr-md-0">
                            <a href="">
                                <img class="img-fluid" src="/wp-content/themes/brainor/imgs/inst.png" alt="">
                            </a>
                        </div>
                        <div class="col">
                            <a href="tel:+74953694879">+7(495)369-48-79</a>
                        </div>
                    </div>
                </div>
                <div class="col-md header-middle pt-5 d-md-block d-none">
                    <div class="row">
                        <div class="col-12">
                            <a href="/">
                                <img src="/wp-content/themes/brainor/imgs/logo.png" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md col-auto header-last">
                    <div class="row d-md-block d-none">
                        <div class="col mb-3">
                            <ul class="list-inline mb-0">
                                <?php get_template_part('partials/header/part', 'pages-links') ?>
                            </ul>
                        </div>
                    </div>
                    <div class="row d-md-block d-none">
                        <div class="col mb-3">
                            <a href="">Конструктор пиццы</a>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-auto">
                            <a href="<?php echo wc_get_cart_url() ?>">
                                <div class="row align-items-center">
                                    <div class="col d-md-block d-none">
                                        <span class="cart-info">(<?php echo WC()->cart->get_cart_contents_count() . ' на ' . WC()->cart->get_cart_total() ?>)</span>
                                    </div>
                                    <div class="col-auto pl-md-0">
                                        <img class="img-fluid" src="/wp-content/themes/brainor/imgs/cart.png" alt="">
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row header-bottom pt-5">
                <div class="col-12 text-center">
                    <div class="btn-group">
                        <ul class="list-inline mb-0">
                            <?php get_template_part('partials/header/part', 'products-categories') ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!--    Настольное меню конец    -->

	</header>