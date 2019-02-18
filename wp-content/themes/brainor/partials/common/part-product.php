<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 14.02.2019
 * Time: 11:15
 */
?>

<?php
    $product = $template_args['product'];
?>

<div class="col-lg-4 col-sm-6 col-12 mb-4 product-block">
    <form action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', '/' ) ); ?>" class="h-100">
        <div class="product-wrapper h-100 bg-white p-2">
            <div class="row h-100">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="product-img" style="background-image: url('<?php echo get_the_post_thumbnail_url($product->get_id(), 'large'); ?>')"></div>
                        </div>
                        <div class="col-12">
                            <div class="px-2">
                                <input type="hidden" name="add-to-cart" value="<?php echo $product->get_id() ?>">
                                <div class="row mb-3">
                                    <div class="col-12 pt-3">
                                        <h4 class="text-orange">
                                            <?php echo $product->get_name() ?>
                                        </h4>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <strong class="product-field-label-label">Состав:</strong>
                                        <span class="product-field-label-value">
                                                        <?php echo $product->get_short_description() ?>
                                                    </span>
                                    </div>
                                </div>
                                <?php
                                $available_variations = [];
                                if($product->is_type('variable')) {
                                    $available_variations = $product->get_available_variations();
                                }
                                ?>
                                <?php if(count($available_variations)): ?>
                                    <div class="row mb-3 product-count-row">
                                        <div class="col-12">
                                            <div class="row align-items-center">
                                                <div class="col-4 pr-0">
                                                    <strong class="product-field-label">Размер (см):</strong>
                                                </div>
                                                <div class="col">
                                                    <?php foreach ($available_variations as $key => $available_variation): ?>
                                                        <?php
                                                        $variation = new WC_Product_Variation($available_variation['variation_id']);
                                                        ?>
                                                        <div class="product-size-block d-inline-block">
                                                            <input
                                                                    type="radio"
                                                                    name="attribute_pa_size"
                                                                    data-price="<?php echo $variation->regular_price ?>"
                                                                    id="product-<?php echo $product->get_id() ?>-size-<?php echo $variation->get_id() ?>"
                                                                    value="<?php echo $variation->get_attribute('size') ?>"
                                                                <?php if($product->get_variation_default_attribute('pa_size') == $variation->get_attribute('size')): ?>
                                                                    checked
                                                                <? endif; ?>
                                                            >
                                                            <label for="product-<?php echo $product->get_id() ?>-size-<?php echo $variation->get_id() ?>">
                                                                <?php echo $variation->get_attribute('size') ?>
                                                            </label>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>
                                <div class="row mb-3 product-count-row">
                                    <div class="col-12">
                                        <div class="row align-items-center">
                                            <div class="col-4 pr-0">
                                                <strong class="product-field-label">Кол-во:</strong>
                                            </div>
                                            <div class="col">
                                                <div class="input-group product-counter-group">
                                                    <input type="number" name="quantity" class="product-count" value="1" min="1" step="1">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center mb-3">
                                    <div class="col-4 pr-0">
                                        <strong class="product-field-label">Цена:</strong>
                                    </div>
                                    <div class="col">
                                                    <span class="product-field-value product-price">
                                                        <?php echo $product->get_price() ?>
                                                        р.
                                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 align-self-end">
                    <div class="px-2">
                        <div class="row mb-3">
                            <div class="col-12">
                                <button class="btn bg-orange text-uppercase w-100" type="submit">
                                    заказать
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
