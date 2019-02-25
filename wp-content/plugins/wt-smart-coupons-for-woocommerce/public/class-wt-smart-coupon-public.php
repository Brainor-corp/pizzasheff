<?php
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.webtoffee.com
 * @since      1.0.0
 *
 * @package    Wt_Smart_Coupon
 * @subpackage Wt_Smart_Coupon/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wt_Smart_Coupon
 * @subpackage Wt_Smart_Coupon/public
 * @author     markhf <info@webtoffee.com>
 */
class Wt_Smart_Coupon_Public {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    

    }
    

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wt-smart-coupon-public.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wt-smart-coupon-public.js', array('jquery'), $this->version, false);
        wp_localize_script($this->plugin_name,'WTSmartCouponOBJ',array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
    }

    /**
     * Filter Function updating woocommcerce coupon validation.
     * @param $valid
     * @param $coupon - Coupon code
     * @since 1.0.0
     */
    public function wt_woocommerce_coupon_is_valid($valid, $coupon) {


        if (!$valid) {
            return false;
        }

        $coupon_id                   = $coupon->get_id();
        $coupon_shipping_method_ids = get_post_meta($coupon_id, '_wt_sc_shipping_methods',true);

        if( ''!=$coupon_shipping_method_ids && ! is_array( $coupon_shipping_method_ids ) ) {
            $coupon_shipping_method_ids = explode(',',$coupon_shipping_method_ids);
        } else {
            $coupon_shipping_method_ids = array();
        }
        
        $coupon_payment_method_ids  = get_post_meta($coupon_id, '_wt_sc_payment_methods',true);
        if( ''!= $coupon_payment_method_ids && ! is_array( $coupon_payment_method_ids ) ) {
            $coupon_payment_method_ids = explode(',',$coupon_payment_method_ids);
        } else {
            $coupon_payment_method_ids = array();
        }
       
        $_wt_sc_user_roles         = get_post_meta($coupon_id, '_wt_sc_user_roles',true);
        if( ''!= $_wt_sc_user_roles && ! is_array( $_wt_sc_user_roles ) ) {
            $_wt_sc_user_roles = explode(',',$_wt_sc_user_roles);
        } else {
            $_wt_sc_user_roles = array();
        }
        
        // shipping method check
        if ( sizeof($coupon_shipping_method_ids ) > 0) {

            $chosen_shipping_methods = WC()->session->get('chosen_shipping_methods');
            $chosen_shipping = $chosen_shipping_methods[0];
            $chosen_shipping = substr($chosen_shipping, 0, strpos($chosen_shipping, ":"));
            if (!in_array($chosen_shipping, $coupon_shipping_method_ids)) {
                $valid = false;
            }

            if ( ! $valid ) {
                throw new Exception( __( 'Sorry, this coupon is not applicable to selected shipping method', 'wt-smart-coupons-for-woocommerce' ), 109 );
            }
        }

        // payment method check
        if (sizeof($coupon_payment_method_ids) > 0) {

            $chosen_payment_method = isset(WC()->session->chosen_payment_method) ? WC()->session->chosen_payment_method : array();
            
            if (!in_array($chosen_payment_method, $coupon_payment_method_ids)) {
                $valid = false;
            }

            if ( ! $valid ) {
                throw new Exception( __( 'Sorry, this coupon is not applicable to selected Payment method', 'wt-smart-coupons-for-woocommerce' ), 109 );
            }
        }

        // user role check
        if (sizeof($_wt_sc_user_roles) > 0) {

            $user = wp_get_current_user();
            $user_roles = (array) $user->roles;

            if (!array_intersect($_wt_sc_user_roles, $user_roles)) {
                $valid = false;
            }

            if ( ! $valid ) {
                throw new Exception( __( 'Sorry, this coupon is not applicable for your Role', 'wt-smart-coupons-for-woocommerce' ), 109 );
            }
        }


        // Usage restriction "AND" for ptoducts
        $wt_product_condition = get_post_meta($coupon_id,'_wt_product_condition',true);
        if( $wt_product_condition == 'and') {
            $valid = true;
            $coupon_products = $coupon->get_product_ids() ;
            if ( count( $coupon_products ) > 0 ) {
                global $woocommerce;
                $items = $woocommerce->cart->get_cart();
                $items_to_check = array();
                foreach( $items as $item ) {
                    array_push($items_to_check,$item['product_id']);
                }
                foreach( $coupon_products as $coupon_product  ) {
                    if ( !in_array( $coupon_product, $items_to_check ) ) {
                        $valid = false;
                        break;
                    }
                }

                if ( ! $valid ) {
                    throw new Exception( __( 'Sorry, this coupon is not applicable to selected products.', 'wt-smart-coupons-for-woocommerce' ), 109 );
                }
            }
        }

        // Usage restriction "AND" for Categories
        $wt_category_condition = get_post_meta($coupon_id,'_wt_category_condition',true);
        if( $wt_category_condition == 'and') {
            $valid = true;
            global $woocommerce;
            $coupon_categores = $coupon->get_product_categories() ;
            $items = $woocommerce->cart->get_cart();
            $items_to_check = array();
            foreach( $items as $item ) {
                $product_cats = wc_get_product_cat_ids( $item['product_id'] );
                $items_to_check = array_merge( $items_to_check,$product_cats );
            }

            foreach( $coupon_categores as $coupon_categry ) {
                if ( !in_array( $coupon_categry, $items_to_check ) ) {
                    $valid = false;
                    break;
                }

            }

            if ( ! $valid ) {
				throw new Exception( __( 'Sorry, this coupon is not applicable to selected products.', 'wt-smart-coupons-for-woocommerce' ), 109 );
			}


        }

        // Quantity of matching Products
        $wt_min_matching_product_qty = get_post_meta($coupon_id,'_wt_min_matching_product_qty',true);
        $wt_max_matching_product_qty = get_post_meta($coupon_id,'_wt_max_matching_product_qty',true);

        if( $wt_min_matching_product_qty > 0 ||  $wt_max_matching_product_qty >0 ) {
            $quantity_of_matching_product = $this->get_quantity_of_matching_product( $coupon );
            if( $wt_min_matching_product_qty > 0 && $quantity_of_matching_product < $wt_min_matching_product_qty ) {
                $valid = false;
                throw new Exception(
                    sprintf( __( 'The minimum quantity of matching products for this coupon is %s.', 'wt-smart-coupons-for-woocommerce' ), $wt_min_matching_product_qty ),110

                );
            }
            if( $wt_max_matching_product_qty >0 && $quantity_of_matching_product > $wt_max_matching_product_qty ) {            
                $valid = false;                
                throw new Exception(
                    sprintf( __( 'The maximum quantity of matching products for this coupon is %s.', 'wt-smart-coupons-for-woocommerce' ), $wt_max_matching_product_qty ),111
                );
            }
        }

        // Subtotal of matching products

        $wt_min_matching_product_subtotal = get_post_meta($coupon_id,'_wt_min_matching_product_subtotal',true);
        $wt_max_matching_product_subtotal = get_post_meta($coupon_id,'_wt_max_matching_product_subtotal',true);
        if( $wt_min_matching_product_subtotal > 0 ||  $wt_min_matching_product_subtotal >0 ) {
            $subtotal_of_matching_product = $this->get_sub_total_of_matching_products($coupon);
            if( $wt_min_matching_product_subtotal >0 && $subtotal_of_matching_product < $wt_min_matching_product_subtotal ) {
                $valid = false;
                throw new Exception(
                    sprintf( __( 'The minimum subtotal of matching products for this coupon is %s.', 'wt-smart-coupons-for-woocommerce' ), $wt_min_matching_product_qty ),112

                );
            }
            if( $wt_max_matching_product_subtotal >0 && $subtotal_of_matching_product > $wt_max_matching_product_subtotal ) {            
                $valid = false;                
                throw new Exception(
                    sprintf( __( 'The maximum subtotal of matching products for this coupon is %s.', 'wt-smart-coupons-for-woocommerce' ), $wt_max_matching_product_qty ),113
                );
            }
        }
        

        return $valid;
    }

    public function get_sub_total_of_matching_products( $coupon ) {
        global $woocommerce;        
        $coupon_products =  $coupon->get_product_ids();

        $coupon_categores = $coupon->get_product_categories() ;
        $items = $woocommerce->cart->get_cart();
        $total = 0;
        if( count( $coupon_products ) > 0 || count($coupon_categores) > 0  ) { // check with matching products by include condition.
            foreach( $items as $item ) {
                $product_cats = wc_get_product_cat_ids( $item['product_id'] );
                if( ( count( $coupon_products ) && in_array( $item['product_id'],$coupon_products ) ) ||  ( count($coupon_categores) && count( array_intersect($coupon_categores,$product_cats) ) > 0 ) ){
                    $total += $item['line_total'];

                }
              
            }
        } else {
            foreach( $items as $item ) {
                $total += $item['line_total'];
            }
        }

        return $total;
    }

    public function get_quantity_of_matching_product( $coupon ) {
        global $woocommerce;        
        $coupon_products =  $coupon->get_product_ids();

        $coupon_categores = $coupon->get_product_categories() ;
        $items = $woocommerce->cart->get_cart();
        $qty = 0;
        if( count( $coupon_products ) > 0 || count($coupon_categores) > 0  ) { // check with matching products by include condition.
            foreach( $items as $item ) {
                $product_cats = wc_get_product_cat_ids( $item['product_id'] );
                if( ( count( $coupon_products ) && in_array( $item['product_id'],$coupon_products ) ) || ( count($coupon_categores) && count( array_intersect($coupon_categores,$product_cats) ) > 0 ) ){
                    $qty += $item['quantity'];

                }
              
            }
        } else {
            foreach( $items as $item ) {
                $qty += $item['quantity'];
            }
        }
        return $qty;
    }

    /**
     * get free product applicable for a coupon
     */

     public function get_free_product_for_a_coupon( $coupon_code ) {
        $coupon = new WC_Coupon($coupon_code);
        $coupon_id      = $coupon->get_id();
        $free_products  = get_post_meta( $coupon_id, '_wt_free_product_ids', true );

        // var_dump($free_products);

        if( ''!= $free_products && ! is_array( $free_products ) ) {
            $free_products = explode(',',$free_products);
        } else {
            $free_products = array();
        }

        return $free_products;
     }

    /**
     * Action function folr dicplaying give-away products on cart.
     * @since 1.0.0
     */
    public function add_free_product_into_cart( $coupon_code ) {
       
        $free_products = $this->get_free_product_for_a_coupon( $coupon_code );
        if( empty( $free_products ) )  return;
        $first_product = wc_get_product( $free_products[0] );
        if( $first_product->is_type( 'simple' ) ) {
            wc_add_notice( 'Congrats you got a free gift!!', 'success' );
            $free_product_id = $free_products[0];
            $found 		= false;
            if ( sizeof( WC()->cart->get_cart() ) > 0 ) {
                // foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {
                //     $_product = $values['data'];
                //     if ( $_product->get_id() == $free_product_id ){
                //         $found = true;
                //     }
                // }
                if( !$found) {
                    $quantity  =1;
                    $variation_id = '';
                    $variation = array();
                    $cart_item_data = array(
                        'free_product' => 'wt_give_away_product'
                    );
                    WC()->cart->add_to_cart( $free_product_id, $quantity, $variation_id, $variation,$cart_item_data  );

                    
                }
            }

        }

    }

    /**
     * Remove Free Prodiuct from cart
     */

    public function remove_free_product_into_cart( $coupon_code ) {
        $free_products = $this->get_free_product_for_a_coupon( $coupon_code );
        if( empty( $free_products ) )  return;

        $free_product_id = $free_products[0];
         foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {

                
                $_product = $values['data'];
                if ( $_product->get_id() == $free_product_id && $values['free_product'] == "wt_give_away_product" ){
                    WC()->cart->remove_cart_item( $cart_item_key );
                }
            }
    }

    /**
     * Check whether cart contains any give away products
     * @since 1.0.0
     */
    public function is_cart_contains_free_products() {
        global $woocommerce;
        $items = $woocommerce->cart->get_cart();
        
        $products_in_cart = array();
        foreach( $items as $item ) {
            if( $this->is_a_free_gift_item( $item ) ) {
                return $item;
            }
        }
        return false;
    }

    // public function is_order_contains_free_products( $order ) {
    //     $order_items = $order->get_items();
    // }

    /**
     * Function for getting give away products based on coupon applied.
     * @since 1.0.0
     */
    public function get_free_products() {
        global $woocommerce;
        $applied_coupons  = $woocommerce->cart->applied_coupons;
        if( empty($applied_coupons)){
            return false;
        }
        
        $free_products =  array();

        foreach( $applied_coupons as $coupon ) {
           $coupon_id =  wc_get_coupon_id_by_code( $coupon) ;
           $products = get_post_meta( $coupon_id, '_wt_free_product_ids', true );
           if( ! is_array( $products ) ) {
                $products = explode(',',$products);
            }
           
           $free_products  = array_merge($free_products, $products );

        }
        return $free_products ;
    }

    /**
     * function for checking a cart item is giveaway.
     * @since 1.0.0
     */
    public function is_a_free_gift_item( $cart_item ) {
        
        if( !empty( $this->get_free_products() ) && isset( $cart_item['free_product']) && $cart_item['free_product']=='wt_give_away_product') {

            return true;
        }
        return false;
    }


    /**
     * filter function for updating cart item price ( Displaying cart item price in cart and checkout page )
     * @param $price Price html.
     * @param $cart_item Cart item object
     * @since 1.0.0
     */
    public function add_custom_cart_item_total( $price,$cart_item ) {
 
        global $woocommerce;
        $free_products = $this->get_free_products();
        
        if ( empty($free_products) || ! in_array( $cart_item['product_id'],$free_products ) || ! ( $this->is_a_free_gift_item( $cart_item ) ) ) {
            return $price;
        }
        $currency = get_woocommerce_currency_symbol();
        $_product = wc_get_product( $cart_item['product_id'] );
        $product_price = $_product->get_price();

        $custom_price = $product_price * ( $cart_item['quantity'] - 1 );

        $return = '<del><span>'.$price.'</span></del> <span>'.$currency.( number_format((float) $custom_price,2,'.','' ) ).'</span>' ;
        return $return;


    }

   
    /**
     * Action function for displaying description for give away product on cart page
     * @Since 1.0.0
     */
    public function display_give_away_product_description( $cart_item ) {
        if( $this->is_a_free_gift_item( $cart_item ) ) {

            $free_gift_text = __('It\'s a free gift for you','wt-smart-coupons-for-woocommerce');
            echo '<p style="color:green;clear:both">'.$free_gift_text.'</p>';
        }
    }

    

    /**
     *  Calculate the Cart Total after reducing the free product price.
     * @since 1.0.0.
    */

     public function discounted_calculated_total( $total, $cart_object ){
         
        $gift_item = $this->is_cart_contains_free_products();

        if( $gift_item ) {
            $_product = wc_get_product( $gift_item['product_id'] );
            
            $discount = $_product->get_price();
            $new_total = $total - $discount;
            return round( $new_total, $cart_object->dp );
        }
        return $total;
        
      
      }

    //   function wt_cart_discounts_before_tax( $discounts_before_tax) {
    //       var_dump($discounts_before_tax);
    //       die();
    //       return $discounts_before_tax+45;
    //   }

    //   function woocommerce_calculate_totals( $cart ) {
    //     return $cart;
    //     $gift_item = $this->is_cart_contains_free_products();
    //     if( $gift_item ) {
    //         $_product = wc_get_product( $gift_item['product_id'] );

    //         // echo '<pre>';var_dump( $gift_item); echo '</pre>';

    //         if( isset( $gift_item['variation_id'] ) && $gift_item['variation_id']  > 0 ) {
    //             $_product = wc_get_product( $gift_item['variation_id'] );

    //         }
    //         $discount = $_product->get_price();
            
    //         $subtotal = $cart->subtotal;

    //         $new_total = $subtotal - $discount;
    //         $cart->subtotal = $new_total;
    //     }
    //     return $cart;
    
    // }

      function woocommerce_calculate_totals( $cart ) {

        $gift_item = $this->is_cart_contains_free_products();

        if( $gift_item ) {
            $_product = wc_get_product( $gift_item['product_id'] );
            
            $discount = $_product->get_price();
            $taxes = $cart->get_tax_totals(); 
            // echo '<pre>';var_dump($taxes); echo '</pre>';

            $rates = WC_Tax::get_rates();
            // echo '<pre>';var_dump($rates); echo '</pre>';
            
            $tax_discount  = WC_Tax::calc_tax( $discount, $rates );

            foreach( $tax_discount as $tax_desc ) $discount+= $tax_desc;
            // echo '<pre>';var_dump($tax_discount); echo '</pre>';



             
            // Add each taxes to $discount
            // foreach($taxes as $tax) $discount += $tax;
            
            // var_dump($discount);
            
        
            $subtotal = $cart->get_totals();
            $discount_total = $cart->get_discount_total( );

            // echo '<pre>'; var_dump($subtotal ); echo '</pre>';
            // echo '<pre>'; var_dump($discount_total ); echo '</pre>';
            // $new_total = $subtotal['subtotal'] - $discount;
            // $cart->subtotal = $new_total;

            $get_discount_tax =  $cart->get_discount_tax( );
            // var_dump($get_discount_tax);

            $cart->set_discount_total( $discount_total+$discount+10 );

            $cart->set_total_tax( $tax_discount );
            // $cart->calculate_totals( );
        }
        
         return $cart;
    
    }

    /**
     * Add Free gift item price details into cart and checkout.
     * @since 1.0.0
     */
    public function add_give_away_product_discount() {
        $gift_item = $this->is_cart_contains_free_products();

        if( $gift_item) {
            $_product = wc_get_product( $gift_item['product_id'] );

            $discount = $_product->get_price();
            $currency = get_woocommerce_currency_symbol();

            ?>
            <tr class="woocommerce-give_away_product wt_give_away_product">
                <th><?php _e( 'Free Gift Item', 'wt-smart-coupons-for-woocommerce' ); ?></th>
                <td>-<?php echo $currency.( number_format((float) $discount,2,'.','' ) ) ?></td>
        
            </tr>
        
           <?php
        }

       
     }

    
    /**
     * Add Free Prodcut details on cart item list.
     * @since 1.0.0
    */
    function add_free_product_details_into_order( $item, $cart_item_key, $values, $order ) {
        if ( empty( $values['free_product'] ) ) {
            return;
        }

        $item->add_meta_data( __( 'free_product', 'wt-smart-coupons-for-woocommerce' ), '<p style="color:green">Its a free Product</p> ' );
    }

    /**
     * Display free product Discount Detail on order details.
     * @since 1.0.0
     */
    function woocommerce_get_order_item_totals( $total_rows, $tax_display  ) {
        $order = $tax_display;
        $order_items = $order->get_items();

        foreach( $order_items as $id => $order_item ) {
            $free_item = wc_get_order_item_meta($id,'free_product',true);
            if( !empty($free_item) ) {
                $product = $order_item['product_id'];
                
                $_product  = wc_get_product( $order_item['product_id'] ) ;
                $product_price = $_product->get_price();
                $quantity = $order_item['quantity'];
                $currency = get_woocommerce_currency_symbol();
                $custom_price = $product_price * ( $quantity - 1 );
                
                $value = '<del><span>'.$currency.( number_format((float) $product_price,2,'.','' ) ).'</span></del> <span>'.$currency.( number_format((float) $custom_price,2,'.','' ) ).'</span>' ;

                $key = 'shipping';
                $offset = array_search($key, array_keys($total_rows));

                $total_rows = array_merge
                        (
                            array_slice($total_rows, 0, $offset),
                            array(
                                'free_product' => array(
                                    'label' => __( 'Free Product:', 'woocommerce' ),
                                    'value' => $value
                                )
                            ),
                            array_slice($total_rows, $offset, null)
                        );
            }

        }
        return $total_rows;
    }

    /**
     * Manage Item Meta on order page
     * @since 1.0.0
     */
    
    function  unset_free_product_order_item_meta_data( $formatted_meta, $item ) {

        foreach( $formatted_meta as $key => $meta ) {
            if( in_array( $meta->key, array('free_product') ) ) {
                unset($formatted_meta[$key]);
            }
                
        }
        return $formatted_meta;
    }

    /**
     * Get formatted Meta values of a coupon.
     * @since 1.0.0
     */
    public static function get_coupon_meta_data( $coupon ) {

        $discount_types = wc_get_coupon_types();
        $coupon_data = array();
        $currency  =  get_woocommerce_currency_symbol() ;
        switch( $coupon->get_discount_type() ) {
            case 'fixed_cart':
                $coupon_data['coupon_type']     = __( 'Cart Discount', 'wt-smart-coupons-for-woocommerce' );
                $coupon_data['coupon_amount']   = $currency.$coupon->get_amount();
                break;

            case 'fixed_product':
                $coupon_data['coupon_type']     = __( 'Product Discount', 'wt-smart-coupons-for-woocommerce' );
                $coupon_data['coupon_amount']   = $currency.$coupon->get_amount();
                break;

            case 'percent_product':
                $coupon_data['coupon_type']     = __( 'Product Discount', 'wt-smart-coupons-for-woocommerce' );
                $coupon_data['coupon_amount']   = $coupon->get_amount() . '%';
                break;

            case 'percent':
                $coupon_data['coupon_type'] = __( 'Cart Discount', 'wt-smart-coupons-for-woocommerce' );
                $coupon_data['coupon_amount'] = $coupon->get_amount() . '%';
                break;

            default:
                $coupon_data['coupon_type'] = $discount_types[ $coupon->discount_type ];
                $coupon_data['coupon_amount'] = $coupon->get_amount();
                break;

        }
        $coupon_data['coupon_expires']   = $coupon->get_date_expires();
        return $coupon_data;
    }
    
    /**
     * Get formattd Expiration date of a coupon.
     * @since 1.0.0
     */
    public static function get_expiration_date_text( $expiry_date ) {
        
        $expiry_days = ( ( $expiry_date - time() )/( 24*60*60 ) );
        if( $expiry_days  > 0 ) {
            $expiry_days = (int) $expiry_days ;
        }

        if( $expiry_days < 0   ) {
            $expires_string = 'expired';
        } elseif( $expiry_days < 1   ) {
            $expires_string = __( 'Expires Today ', 'wt-smart-coupons-for-woocommerce' );
        } elseif ( $expiry_days < 31 ) {
            $expires_string = __( 'Expires in ', 'wt-smart-coupons-for-woocommerce' ) . $expiry_days . __( ' days', 'wt-smart-coupons-for-woocommerce' );
        } else {
            $expires_string = __( 'Expires on ', 'wt-smart-coupons-for-woocommerce' ) . esc_html( date_i18n( get_option( 'date_format', 'F j, Y' ), $expiry_date ) );
        }
        return $expires_string;
    }

    /**
     * Get all coupons used by a customer in previous orders.
     * @since 1.0.0
     */
    public static function get_coupon_used_by_a_customer( $user,$coupon_code = '', $return = 'COUPONS' ) {
        global $current_user,$woocommerce,$wpdb;

        if( !$user ) {
            $user = wp_get_current_user();
        }
        $coupon_used = array();
        $customer_id = $user->ID;
        $args = array(
            'numberposts' => -1,
            'meta_key' => '_customer_user',
            'meta_value'	=> $customer_id,
            'post_type' => 'shop_order',
            'post_status' => 'any'
        );
        $customer_orders = get_posts($args);
        if ($customer_orders) :
            foreach ($customer_orders as $customer_order) :
                $order = wc_get_order( $customer_order->ID );
                $coupons  = $order->get_used_coupons();
                if( $coupons ) {
                    $coupon_used = array_merge( $coupon_used, $coupons );
                }
            endforeach;

            if( $return =='NO_OF_TIMES' && $coupon_code != '' ) {
                $count_of_used = array_count_values($coupon_used);
                
                return isset( $count_of_used[ $coupon_code ] )? $count_of_used[ $coupon_code ] : 0 ;

            }
            return array_unique( $coupon_used );

        else :
            return false;
        endif;
    }

   
    

}