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
		<div class="container header-container">
            <div class="row header-top">
                <div class="col-md header-first">
                    <div class="row mb-3">
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
                <div class="col-md header-middle pt-5">
                    <div class="row">
                        <div class="col-12">
                            <a href="/">
                                <img src="/wp-content/themes/brainor/imgs/logo.png" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md header-last">
                    <div class="row">
                        <div class="col mb-3">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item mr-0 ml-3"><a href="#">О нас</a></li>
                                <li class="list-inline-item mr-0 ml-3"><a href="#">Акции</a></li>
                                <li class="list-inline-item mr-0 ml-3"><a href="#">Контакты</li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <a href="">Конструктор пиццы</a>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-auto">
                            <a href="<?php echo wc_get_cart_url() ?>">
                                <div class="row align-items-center">
                                    <div class="col">
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
                            <?php for ($i = 0; $i < 4; $i++): ?>
                                <li class="list-inline-item">
                                    <button type="button" class="btn bg-transparent dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item text-dark" href="#">Action</a>
                                        <a class="dropdown-item text-dark" href="#">Another action</a>
                                        <a class="dropdown-item text-dark" href="#">Something else here</a>
                                    </div>
                                </li>
                            <?php endfor ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
	</header>