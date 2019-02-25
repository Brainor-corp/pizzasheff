<?php
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}


global $current_user, $woocommerce, $wpdb;

$smart_coupon_options = Wt_Smart_Coupon_Admin::get_options();

// echo '<pre>';
// var_dump($smart_coupon_options );
// echo '</pre>';
// $wt_active_coupon_bg_color = ( $smart_coupon_options['wt_active_coupon_bg_color'] )?

?>
<style type="text/css">
   .wt-single-coupon{
        background-color: <?php echo $smart_coupon_options['wt_active_coupon_bg_color']; ?> ;
        border: 2px dashed <?php echo $smart_coupon_options['wt_active_coupon_border_color']; ?>;
        color: <?php echo $smart_coupon_options['wt_active_coupon_border_color']; ?>;
        box-shadow: 0 0 0 4px <?php echo $smart_coupon_options['wt_active_coupon_bg_color']; ?>, 2px 1px 6px 4px rgba(10, 10, 0, 0.5);
        text-shadow: -1px -1px <?php echo $smart_coupon_options['wt_active_coupon_bg_color']; ?>;
    }

    .wt-single-coupon.used-coupon {
        background-color: <?php echo $smart_coupon_options['wt_used_coupon_bg_color']; ?> ;
        border: 2px dashed <?php echo $smart_coupon_options['wt_used_coupon_border_color']; ?>;
        color: <?php echo $smart_coupon_options['wt_used_coupon_border_color']; ?>;
        box-shadow: 0 0 0 4px <?php echo $smart_coupon_options['wt_used_coupon_bg_color']; ?>, 2px 1px 6px 4px rgba(10, 10, 0, 0.5);
        text-shadow: -1px -1px <?php echo $smart_coupon_options['wt_used_coupon_bg_color']; ?>;
    }
    .wt-single-coupon.used-coupon.expired {
        background-color: <?php echo $smart_coupon_options['wt_expired_coupon_bg_color']; ?> ;
        border: 2px dashed <?php echo $smart_coupon_options['wt_expired_coupon_border_color']; ?>;
        color: <?php echo $smart_coupon_options['wt_expired_coupon_border_color']; ?>;
        box-shadow: 0 0 0 4px <?php echo $smart_coupon_options['wt_expired_coupon_bg_color']; ?>, 2px 1px 6px 4px rgba(10, 10, 0, 0.5);
        text-shadow: -1px -1px <?php echo $smart_coupon_options['wt_expired_coupon_bg_color']; ?>;
    }

</style>

<?php

$current_user = wp_get_current_user(); 
$user_id = $current_user->ID; 
$email = $current_user->user_email;

$couponlist = $wpdb->get_results("SELECT meta.`post_id` FROM `" . $wpdb->postmeta . "` meta WHERE  ( meta.`meta_key` LIKE 'customer_email' AND meta.`meta_value` LIKE '%" . $email . "%' ) OR  ( meta.`meta_key` LIKE '_wt_make_coupon_available_in_myaccount' AND meta.`meta_value` = 1 )");

if( $couponlist ) {
    $couponarrayfinal = array(); 
foreach ($couponlist as $key => $row) {

    $value = $row->post_id;
    $couponarrayfinal[] = $value;
}

$couponargs = array(
    'post_type' => 'shop_coupon',
    'post__in' => $couponarrayfinal,
    'orderby' => 'title',
    'order' => 'ASC',
    'posts_per_page' => '-1');
$coupons = get_posts($couponargs);
?>
<div class="wt-mycoupons">
        <?php
        $expired_coupon = array();
        foreach ($coupons as $coupon ) {

            $coupon_obj = new WC_Coupon( $coupon->post_title );

            $email_restriction = $coupon_obj->get_email_restrictions();
            
            // Check is coupon restricted for other Email.
            if( !empty( $email_restriction ) && !in_array($email,$email_restriction)  ) {
                continue;
            }

            // Check is Coupon Expired.
            $coupon_data  = Wt_Smart_Coupon_Public::get_coupon_meta_data( $coupon_obj );
            if( $coupon_data['coupon_expires'] ) {

                $exp_date =  $coupon_data['coupon_expires']->getTimestamp();
                $expire_text = Wt_Smart_Coupon_Public::get_expiration_date_text( $exp_date );
                if( $expire_text == 'expired') {
                    array_push($expired_coupon,$coupon_obj->get_code() );
                    continue;
                }
            } else{
                $expire_text = '';
            }

            // Check is usage limit per user is exeeded.
            $number_of_times_used = Wt_Smart_Coupon_Public::get_coupon_used_by_a_customer( $current_user,$coupon->post_title, 'NO_OF_TIMES' );
            $get_usage_limit_per_user = $coupon_obj->get_usage_limit_per_user();

            if( $get_usage_limit_per_user && ( $get_usage_limit_per_user <= $number_of_times_used ) ) {
                continue;
            }

            ?>
                <div class="wt-single-coupon">
                    <div class="wt-coupon-content">
                        <div class="wt-coupon-amount">
                            <span class="amount"> <?php echo $coupon_data['coupon_amount'].'</span><span> '.$coupon_data['coupon_type'] ; ?></span>
                        </div>  
                        <div class="wt-coupon-code"> <code> <?php echo $coupon->post_name; ?></code></div>
                        <?php if(  '' != $expire_text ) { ?>
                            <div class="wt-coupon-expiry"><?php echo $expire_text; ?></div>
                        <?php  } ?>
                        <?php $coupon_desc = $coupon_obj->get_description(); 
                            if( '' != $coupon_desc ) {
                        ?>
                            <div class="coupon-desc-wrapper">
                                <i class="info"> i </i>
                                <div class="coupon-desc"> <?php echo $coupon_desc; ?> </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

            <?php
        }
        ?>
</div>
<?php
    
} else {
    ?>
    <div class="wt-mycoupons">
        <?php  _e('Sorry you don\'t have any available coupons' ,'wt-smart-coupons-for-woocommerce'); ?>
    </div>
    <?php
}

//  Display used Coupons.

$coupon_used  = Wt_Smart_Coupon_Public::get_coupon_used_by_a_customer( $current_user  );

?>

    <div class="wt-used-coupons">
        <?php 
        $coupon_displayed = 0;
        if(  ( ! empty( $coupon_used ) && $smart_coupon_options['wt_display_used_coupons'] ) || ( !empty( $expired_coupon ) && $smart_coupon_options['wt_display_expired_coupons'] ) ) { ?>
            <h4>  <?php _e("Used / Expired Coupons","wt-smart-coupons-for-woocommerce"); ?></h4>
            <?php
                if( ! empty( $coupon_used ) && $smart_coupon_options['wt_display_used_coupons'] ) {
                foreach ($coupon_used as $coupon ) {
                    $coupon_post    = get_page_by_title( $coupon,'OBJECT','shop_coupon' );
                    if( !$coupon_post || $coupon_post->post_status != 'publish') {
                        continue;
                    }

                    $coupon_obj = new WC_Coupon( $coupon );
                    
                    $coupon_data  = Wt_Smart_Coupon_Public::get_coupon_meta_data( $coupon_obj );
                    $coupon_displayed++;
                    ?>
                        <div class="wt-single-coupon used-coupon">
                            <div class="wt-coupon-content">
                                <div class="wt-coupon-amount">
                                    <span class="amount"> <?php echo $coupon_data['coupon_amount'].'</span><span> '.$coupon_data['coupon_type'] ; ?></span>
                                </div>  
                                <div class="wt-coupon-code"> <code> <?php echo $coupon ?></code></div>
                            </div>
                        </div>
                    <?php
                }
            }
            if( ! empty( $expired_coupon ) && $smart_coupon_options['wt_display_expired_coupons']  ) {
                $expired_coupon  = array_diff($expired_coupon , $coupon_used);
                foreach ($expired_coupon as $coupon ) {
                    $coupon_post    = get_page_by_title( $coupon,'OBJECT','shop_coupon' );
                    if( !$coupon_post || $coupon_post->post_status != 'publish') {
                        continue;
                    }

                    $coupon_obj = new WC_Coupon( $coupon );
                    
                    $coupon_data  = Wt_Smart_Coupon_Public::get_coupon_meta_data( $coupon_obj );
                    $coupon_displayed++;
                    ?>
                        <div class="wt-single-coupon used-coupon expired">
                            <div class="wt-coupon-content">
                                <div class="wt-coupon-amount">
                                    <span class="amount"> <?php echo $coupon_data['coupon_amount'].'</span><span> '.$coupon_data['coupon_type'] ; ?></span>
                                </div>  
                                <div class="wt-coupon-code"> <code> <?php echo $coupon ?></code></div>
                                <div class="wt-coupon-expiry"><?php _e('Expired','wt-smart-coupons-for-woocommerce'); ?></div>
                            </div>
                        </div>
                    <?php
                }
            }

            if( !$coupon_displayed ) {
                _e('Sorry no coupon to display' ,'wt-smart-coupons-for-woocommerce');
            }
        }
        ?>
    </div>
<?php
