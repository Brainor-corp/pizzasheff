<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.webtoffee.com
 * @since      1.0.0
 *
 * @package    Wt_Smart_Coupon
 * @subpackage Wt_Smart_Coupon/admin/partials
 */
?>
<?php

if( !function_exists('wt_smart_coupon_admin_tabs') ) {
    function wt_smart_coupon_admin_tabs() {

        $active_tab = ( isset( $_GET['tab'] ) )? $_GET['tab'] : '';
            if( $active_tab == 'settings' ) {
                $tab1 = 'nav-tab-active';
                $tab6 = '';
            } else {
                $tab1 = '';
                $tab2 = 'nav-tab-active';
            }
            $actual_link = get_admin_url().'admin.php?page=wt-smart-coupon';
            $coupon_page = get_admin_url().'edit.php?post_type=shop_coupon';
           ?>
            <nav class="nav-tab-wrapper smart-coupon-tabs">
                <a class="nav-tab <?php echo $tab2; ?>" href="<?php echo $coupon_page; ?>"><?php _e('Coupon','wt-smart-coupons-for-woocommerce'); ?></a>                
                <a class="nav-tab <?php echo $tab1; ?>" href="<?php echo $actual_link ?>&tab=settings"><?php _e('Settings','wt-smart-coupons-for-woocommerce'); ?></a>                
                <a  class="nav-tab premium_promo nav-tab-premium" href="https://www.webtoffee.com/product/smart-coupons-for-woocommerce/"  target="_blank"><?php _e('Upgrade to Premium for More Features','wt-smart-coupons-for-woocommerce'); ?></a>
            </nav>
        <?php
    }
}
        