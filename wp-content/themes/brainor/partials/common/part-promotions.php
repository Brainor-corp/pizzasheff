<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 13.02.2019
 * Time: 14:06
 */
?>

<link rel="stylesheet" href="/wp-content/themes/brainor/css/sidebar-promotions.css">

<section class="promotions-block pt-3">
    <div class="container-fluid products-fly">
        <div class="container">
            <img src="/wp-content/themes/brainor/imgs/green-1.png" alt="" class="d-lg-block d-none">
            <img src="/wp-content/themes/brainor/imgs/green-1.png" alt="" class="d-lg-block d-none">
            <img src="/wp-content/themes/brainor/imgs/pepper.png" alt="" class="d-lg-block d-none">
            <img src="/wp-content/themes/brainor/imgs/pepper.png" alt="" class="d-lg-block d-none">
            <img src="/wp-content/themes/brainor/imgs/pepper.png" alt="" class="d-lg-block d-none">
            <img src="/wp-content/themes/brainor/imgs/tomato.png" alt="" class="d-lg-block d-none">
            <img src="/wp-content/themes/brainor/imgs/tomato.png" alt="" class="d-lg-block d-none">
            <img src="/wp-content/themes/brainor/imgs/green-2.png" alt="" class="d-lg-block d-none">
        </div>
    </div>
    <div class="container-fluid curved-container">
        <div class="container">
            <div class="owl-carousel owl-theme owl-carousel-promotions">
                <?php
                global $post;
                    $args = array( 'category_name' => 'promotions' );
                    $posts = get_posts( $args );
                ?>

                <?php foreach( $posts as $post ): setup_postdata($post) ?>
                    <div class="item">
                        <div class="row">
                            <div class="col-md-6 col-12 pb-2">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <img src="/wp-content/themes/brainor/imgs/figure.png" class="figure" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <p class="promotion-label pt-2">Акция</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <p class="promotion-header">
                                            <?php the_title() ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <p class="promotion-description pt-3">
                                            <?php the_excerpt() ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mt-4 text-center">
                                        <a href="<?php the_permalink() ?>" class="btn btn-rounded bg-orange text-white px-3">
                                            Подробнее
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 d-md-block d-none">
                                <a href="<?php the_permalink() ?>">
                                    <img class="img-fluid" src="<?php the_post_thumbnail_url('large') ?>" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="white-curve-bottom"></div>
</section>