<?php
/**
 * Single variation cart button
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;
?>
<div class="woocommerce-variation-add-to-cart variations_button">
	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

	<?php
//	do_action( 'woocommerce_before_add_to_cart_quantity' );

//	woocommerce_quantity_input( array(
//		'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
//		'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
//		'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
//        'class' => 'form-control'
//	) );
//
//	do_action( 'woocommerce_after_add_to_cart_quantity' );
//	?>

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

	<button type="submit" class="single_add_to_cart_button button btn bg-orange alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>

	<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="variation_id" class="variation_id" value="0" />
</div>
