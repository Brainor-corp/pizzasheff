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
            <img src="/wp-content/themes/brainor/imgs/green-1.png" alt="">
            <img src="/wp-content/themes/brainor/imgs/green-1.png" alt="">
            <img src="/wp-content/themes/brainor/imgs/pepper.png" alt="">
            <img src="/wp-content/themes/brainor/imgs/pepper.png" alt="">
            <img src="/wp-content/themes/brainor/imgs/pepper.png" alt="">
            <img src="/wp-content/themes/brainor/imgs/tomato.png" alt="">
            <img src="/wp-content/themes/brainor/imgs/tomato.png" alt="">
            <img src="/wp-content/themes/brainor/imgs/green-2.png" alt="">
        </div>
    </div>
    <div class="container-fluid curved-container">
        <div class="container">
            <div class="owl-carousel owl-theme owl-carousel-promotions">
                <?php for($i = 0; $i < 5; $i++): ?>
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
                                            Третья пицца в подарок
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <p class="promotion-description pt-3">
                                            При покупке 2х пицц 40 см, колоа или сок
                                            третья пица мясная или маргарита - в подарок
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mt-4 text-center">
                                        <a href="#" class="btn btn-rounded bg-orange text-white px-3">
                                            Подробнее
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <img class="img-fluid" src="https://via.placeholder.com/450x300" alt="">
                            </div>
                        </div>
                    </div>
                <?php endfor ?>
            </div>
        </div>
    </div>
    <div class="white-curve-bottom"></div>
</section>