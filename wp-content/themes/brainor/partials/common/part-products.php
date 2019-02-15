<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 14.02.2019
 * Time: 11:15
 */
?>

<link rel="stylesheet" href="/wp-content/themes/brainor/css/sidebar-products.css">

<div class="container products-container">
    <div class="row">
        <?php for($i = 0; $i < 9; $i++): ?>
            <div class="col-md-4 col-sm-6 col-12 mb-4 product-block">
                <div class="product-wrapper bg-white p-2">
                    <div class="row">
                        <div class="col-12">
                            <div class="product-img" style="background-image: url('https://via.placeholder.com/450x300')"></div>
                        </div>
                    </div>
                    <div class="px-2">
                        <form action="">
                            <div class="row mb-3">
                                <div class="col-12 pt-3">
                                    <h4 class="text-orange">Комбо 5 "ХИТ" 40 см</h4>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <span class="product-field-label-label">Состав:</span>
                                    <span class="product-field-label-value">
                                    бекон | грудинка свиная | грибы шампиньоны | помидор | лук красный | маслины | моцарелла | соус томатный
                                </span>
                                </div>
                            </div>
                            <div class="row mb-3 product-count-row">
                                <div class="col-12">
                                    <div class="row align-items-center">
                                        <div class="col-4 pr-0">
                                            <span class="product-field-label">Размер (см):</span>
                                        </div>
                                        <div class="col">
                                            <div class="product-size-block d-inline-block">
                                                <input type="radio" name="size" id="product-<?php echo $i ?>-size-1" checked>
                                                <label for="product-<?php echo $i ?>-size-1">
                                                    30
                                                </label>
                                            </div>
                                            <div class="product-size-block d-inline-block">
                                                <input type="radio" name="size" id="product-<?php echo $i ?>-size-2">
                                                <label for="product-<?php echo $i ?>-size-2">
                                                    40
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3 product-count-row">
                                <div class="col-12">
                                    <div class="row align-items-center">
                                        <div class="col-4 pr-0">
                                            <span class="product-field-label">Кол-во:</span>
                                        </div>
                                        <div class="col">
                                            <div class="input-group product-counter-group">
                                                <input type="number" class="form-control border-orange" value="1" min="1" step="1">
                                                <div class="d-inline-block pl-1">
                                                    <button class="btn bg-orange px-1 py-0 text-white d-block product-count-up" type="button">
                                                        <i class="fas fa-caret-up"></i>
                                                    </button>
                                                    <button class="btn bg-orange px-1 py-0 text-white d-block mt-1 product-count-down" type="button">
                                                        <i class="fas fa-caret-down"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4 pr-0">
                                    <span class="product-field-label">Цена:</span>
                                </div>
                                <div class="col">
                                    <span class="product-field-value product-price">2500 р.</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <button class="btn bg-orange text-uppercase w-100" type="submit">
                                        заказать
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endfor ?>
    </div>
</div>

