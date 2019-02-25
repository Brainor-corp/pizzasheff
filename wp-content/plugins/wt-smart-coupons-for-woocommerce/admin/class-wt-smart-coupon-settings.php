<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


/**
 * The admin-Settings functionality of the plugin.
 *
 * @link       http://www.webtoffee.com
 * @since      1.0.1
 *
 * @package    Wt_Smart_Coupon
 * @subpackage Wt_Smart_Coupon/admin
 * 
 */

if( ! class_exists ( 'WT_smart_Coupon_Settings' ) ) {

    
	class WT_smart_Coupon_Settings {

        public static $option_prefix;

        public function __construct() {
            self::$option_prefix = 'wt_smart_coupon';
        }

        function display_settings_form() {
            ?>
               

            <div id="message-settings"></div>
            <div id="normal-sortables-2" class="meta-box-sortables ui-sortable">
                <div id="wt_smart_coupon_settings" class=" woocommerce">

                <?php
                $updated  = false;
                    if( isset( $_POST[ 'update_wt_smart_coupon_settings'] )) {
                        check_admin_referer('wt_smart_coupons_settings');
                        
                        // echo '<pre>'; var_dump($_POST); die();

                        $smart_coupon_options = Wt_Smart_Coupon_Admin::get_options();

                        if( isset( $_POST['wt_active_coupon_bg_color'] ) && !empty( $_POST['wt_active_coupon_bg_color'] ) ) {
                            $smart_coupon_options['wt_active_coupon_bg_color'] = $_POST['wt_active_coupon_bg_color'];
                        }
                        if( isset( $_POST['wt_active_coupon_border_color'] ) && !empty( $_POST['wt_active_coupon_border_color'] ) ) {
                            $smart_coupon_options['wt_active_coupon_border_color'] = $_POST['wt_active_coupon_border_color'];
                        }

                        if( isset( $_POST['wt_display_used_coupons'] ) && $_POST['wt_display_used_coupons'] == 'on' ) {
                            $smart_coupon_options['wt_display_used_coupons'] = true;
                        } else {
                            $smart_coupon_options['wt_display_used_coupons'] = false;
                        }
                        if( isset( $_POST['wt_used_coupon_bg_color'] ) && !empty( $_POST['wt_used_coupon_bg_color'] ) ) {
                            $smart_coupon_options['wt_used_coupon_bg_color'] = $_POST['wt_used_coupon_bg_color'];
                        }
                        if( isset( $_POST['wt_used_coupon_border_color'] ) && !empty( $_POST['wt_used_coupon_border_color'] ) ) {
                            $smart_coupon_options['wt_used_coupon_border_color'] = $_POST['wt_used_coupon_border_color'];
                        }

                        if( isset( $_POST['wt_display_expired_coupons'] ) && $_POST['wt_display_expired_coupons'] == 'on' ) {
                            $smart_coupon_options['wt_display_expired_coupons'] = true;
                        } else {
                            $smart_coupon_options['wt_display_expired_coupons'] = false;
                        }
                        if( isset( $_POST['wt_expired_coupon_bg_color'] ) && !empty( $_POST['wt_expired_coupon_bg_color'] ) ) {
                            $smart_coupon_options['wt_expired_coupon_bg_color'] = $_POST['wt_expired_coupon_bg_color'];
                        }
                        if( isset( $_POST['wt_expired_coupon_border_color'] ) && !empty( $_POST['wt_expired_coupon_border_color'] ) ) {
                            $smart_coupon_options['wt_expired_coupon_border_color'] = $_POST['wt_expired_coupon_border_color'];
                        }

                        update_option("wt_smart_coupon_options", $smart_coupon_options);
                        $updated = true;
                        do_action('wt_smart_coupon_settings_updated');

                    }

                ?>

                <?php  if( $updated) { ?>
				
                    <div class="notice notice-success is-dismissible">
                        <p><?php _e( 'Done! Updated Smart Coupon settings.', 'wt-smart-coupons-for-woocommerce-pro' ); ?></p>
                    </div>
                <?php } ?>
                
                <div class="wt_smart_coupon_admin_option">
                  
                    <div class="wt_smart_coupon_admin_form">

                        <form method="post" action="<?php echo esc_attr($_SERVER["REQUEST_URI"]); ?>"" name="wt_smart_coupon_settings">
                            
                            <?php
                                $this->render_settings_fields ();
                
                                wp_nonce_field('wt_smart_coupons_settings');

                            ?>
                        </form>
                    </div>


                    <div class="wt_smart_coupon_pro_features">
                        <div class="wt_smart_coupon_premium">

                            <ul id="premium-upgrade-small-box" style="font-weight: bold; color:#666; list-style: none; background:#f8f8f8; padding:20px; margin:20px 15px; font-size: 15px; line-height: 26px;">
                                <li style=""><?php _e( '30 Day Money Back Guarantee','wt-smart-coupons-for-woocommerce-pro' ); ?></li>
                                <li style=""><?php _e( 'Fast and Superior Support','wt-smart-coupons-for-woocommerce-pro'); ?></li>
                                <li style="margin-top: 6px;">
                                    <a href="https://www.webtoffee.com/product/smart-coupons-for-woocommerce/" target="_blank" class="button button-primary button-go-pro"><?php _e( 'Upgrade to Premium','wt-smart-coupons-for-woocommerce-pro'); ?></a>
                                </li>
                            </ul>
                            <span>
                                <ul class="ticked-list">
                                    <li><?php _e( 'Configure the coupons with extensive usage restrictions and checkout options'); ?></li>
                                    <li><?php _e( 'Create and manage bulk coupons with add to store/email/export to CSV options');?></li>
                                    <li><?php _e( 'Giveaway free products with coupons'); ?></li>
                                    <li><?php _e( 'Import coupons'); ?></li>
                                    <li><?php _e( 'Duplicate coupons'); ?></li>
                                </ul>
                            </span>
                            <center> 
                        
                                <a href="https://www.webtoffee.com/category/documentation/smart-coupons-for-woocommerce/" target="_blank" style="margin-bottom: 15px;" class="button button-doc-demo"><?php _e( 'Documentation','wt-smart-coupons-for-woocommerce-pro'); ?></a>
                            </center>

                        

                        </div>

                        <div class="wt-review-widget"><?php
                            echo sprintf(__('<div class=""><p><i>If you like the plugin please leave us a %1$s review!</i><p></div>', 'wt-smart-coupons-for-woocommerce-pro'), '<a href="https://wordpress.org/support/plugin/wt-smart-coupons-for-woocommerce/reviews/?rate=5#new-post" target="_blank" class="wt-rating-link" data-reviewed="' . esc_attr__('Thanks for the review.', 'wf-woocommerce-packing-list') . '">&#9733;&#9733;&#9733;&#9733;&#9733;</a>');
                            ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>

            <?php
        }




        public function render_settings_fields() {

            

            $admin_options = Wt_Smart_Coupon_Admin::get_options();



            ?>
                

                        <div class="form-section">
                            
                            <div class="wt_section_title">
                                <h2><?php _e('Coupon Styling','wt-smart-coupons-for-woocommerce-pro') ?></h2>
                            </div>


                            <div class="coupon_styling_settings available_coupons">
                                <div class="section-sub-title">
                                    <h4><?php _e('Avalable Coupons','wt-smart-coupons-for-woocommerce-pro') ?><h4>
                                </div>
                                
                                <div class="form-item">
                                    <label> <?php _e('Background color','wt-smart-coupons-for-woocommerce-pro') ?> </label>
                                    <div class="form-element">
                                        <input name="wt_active_coupon_bg_color" id="wt_active_coupon_bg_color" type="text" value="<?php echo $admin_options['wt_active_coupon_bg_color']; ?>" class="wt_colorpick" data-default-color="#2890a8"  />
                                    </div>

                                </div>

                                <div class="form-item">
                                    <label> <?php _e('Forground Color','wt-smart-coupons-for-woocommerce-pro') ?> </label>
                                    <div class="form-element">
                                        <input name="wt_active_coupon_border_color" id="wt_active_coupon_border_color" type="text" value="<?php echo $admin_options['wt_active_coupon_border_color']; ?>" class="wt_colorpick" data-default-color="#ffffff"  />
                                    </div>
                                </div>

                                <div class="coupon_preview active_coupon_preview"></div>

                            </div> <!-- Available Coupons -->

                            <div class="coupon_styling_settings used_coupons">
                                <div class="section-sub-title">
                                    <h4><?php _e('Used Coupons','wt-smart-coupons-for-woocommerce-pro') ?><h4>
                                </div>
                                
                                <div class="form-item">
                                    <?php 
                                        $wt_display_used_coupons =  $admin_options['wt_display_used_coupons']; 
                                        $checked = '';
                                        if( $wt_display_used_coupons ) {
                                            $checked = 'checked = checked';
                                        }
                                    
                                    ?>
                                    <input type="checkbox" id="wt_display_used_coupons" name="wt_display_used_coupons" <?php echo $checked; ?>  ><label> <?php _e('Display used Coupons in MyAccount?','wt-smart-coupons-for-woocommerce-pro'); ?></label>
                                </div>

                                <div class="form-item">
                                    <label> <?php _e('Background color','wt-smart-coupons-for-woocommerce-pro') ?> </label>
                                    <div class="form-element">
                                        <input name="wt_used_coupon_bg_color" id="wt_used_coupon_bg_color" type="text" value="<?php echo $admin_options['wt_used_coupon_bg_color']; ?>" class="wt_colorpick" data-default-color="#eeeeee"  />
                                    </div>

                                </div>

                                <div class="form-item">
                                    <label> <?php _e('Forground Color','wt-smart-coupons-for-woocommerce-pro') ?> </label>
                                    <div class="form-element">
                                        <input name="wt_used_coupon_border_color" id="wt_used_coupon_border_color" type="text" value="<?php echo $admin_options['wt_used_coupon_border_color']; ?>" class="wt_colorpick" data-default-color="#000000"  />
                                    </div>
                                </div>

                                <div class="coupon_preview used_coupon_preview"></div>

                            </div> <!-- Used Coupons -->


                            <div class="coupon_styling_settings expired_coupons">
                                <div class="section-sub-title">
                                    <h4><?php _e('Expired Coupons','wt-smart-coupons-for-woocommerce-pro') ?><h4>
                                </div>

                                <div class="form-item">
                                    <?php 
                                        $wt_display_expired_coupons =  $admin_options['wt_display_expired_coupons']; 
                                        $checked = '';
                                        if( $wt_display_expired_coupons ) {
                                            $checked = 'checked = checked';
                                        }
                                    
                                    ?>
                                    <input type="checkbox" id="wt_display_expired_coupons" name="wt_display_expired_coupons" <?php echo $checked; ?> ><label> <?php _e('Display expired Coupons in MyAccount?','wt-smart-coupons-for-woocommerce-pro'); ?></label>
                                </div>
                                
                                <div class="form-item">
                                    <label> <?php _e('Background color','wt-smart-coupons-for-woocommerce-pro') ?> </label>
                                    <div class="form-element">
                                        <input name="wt_expired_coupon_bg_color" id="wt_expired_coupon_bg_color" type="text" value="<?php echo $admin_options['wt_expired_coupon_bg_color']; ?>" class="wt_colorpick" data-default-color="#f3dfdf"  />
                                    </div>

                                </div>

                                <div class="form-item">
                                    <label> <?php _e('Forground Color','wt-smart-coupons-for-woocommerce-pro') ?> </label>
                                    <div class="form-element">
                                        <input name="wt_expired_coupon_border_color" id="wt_expired_coupon_border_color" type="text" value="<?php echo $admin_options['wt_expired_coupon_border_color']; ?>" class="wt_colorpick" data-default-color="#eccaca"  />
                                    </div>
                                </div>

                                <div class="coupon_preview expired_coupon_preview"></div>

                            </div> <!-- Expired Coupons -->

                            <?php do_action('wt_smart_coupon_after_coupon_settings_form'); ?>

                        

                        <div class="wt_form_submit">
                            <div class="form-submit">
                                <button id="update_wt_smart_coupon_settings" name="update_wt_smart_coupon_settings" type="submit" class="button button-primary button-large"><?php _e( 'Save','wt-smart-coupons-for-woocommerce-pro'); ?></button>
                            </div>
                            

                        </div>


                    



                    

                </div>


            <?php
        }

    }
}