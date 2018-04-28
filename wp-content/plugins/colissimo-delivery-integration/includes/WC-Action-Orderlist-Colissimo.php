<?PHP

/**
 * This file is part of the Colissimo Delivery Integration plugin.
 * (c) Harasse
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if (!defined('ABSPATH')) exit;
/****************************************************************************************/
/* Add Colissimo actions to the orders listing                                          */
/****************************************************************************************/
class WC_Action_Orderlist_Colissimo {
    public static function init() {
        add_action( 'woocommerce_admin_order_actions_end',  __CLASS__ . '::cdi_add_listing_actions' ); 
        add_action( 'admin_footer',  __CLASS__ . '::cdi_colissimo_ajax' );
        add_action( 'wp_ajax_cdi_colissimo_button',  __CLASS__ . '::cdi_colissimo_button_callback' );
    }
    public static function cdi_add_listing_actions( $order ) { 
      global $woocommerce;
      global $wpdb;
      $status = cdiwc3::cdi_order_status($order) ;
      if ($status == 'processing' OR $status == 'on-hold' ) {
        if( !get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_status', true )) { // create the meta Colissimo
          add_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_status', 'waiting', true);
          add_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_tracking', '', true);
          add_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_parcelNumberPartner', '', true);
          add_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_urllabel', '', true);
          add_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_departure', get_option('wc_settings_tab_colissimo_departure'), true);
          add_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_typeparcel', get_option('wc_settings_tab_colissimo_defaulttypeparcel'), true);
          $total_weight = WC_function_Colissimo::cdi_calc_totalnetweight($order) + get_option('wc_settings_tab_colissimo_parcelweight');
          add_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_parcelweight', $total_weight, true);
          add_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_signature', get_option('wc_settings_tab_colissimo_signature'), true);
          add_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_additionalcompensation', get_option('wc_settings_tab_colissimo_additionalcompensation'), true);
          add_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_amountcompensation', get_option('wc_settings_tab_colissimo_amountcompensation'), true);
          add_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_returnReceipt', 'non', true);
          add_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_typereturn', get_option('wc_settings_tab_colissimo_defaulttypereturn'), true);
          add_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_ftd', 'non', true);
          add_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_nbdayparcelreturn', get_option('wc_settings_tab_colissimo_nbdayparcelreturn'), true);

          // Meta for web services - can already have been created by PointRetrait web service But may not if a no Colissimo method is used
          if (null == get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_productCode', true )) {
            add_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_productCode', '', true);
          }
          if (null == get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_pickupLocationId', true )) {
            add_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_pickupLocationId', '', true);
          }

          // Filter to custom the datas when creating the metabox
          $arrfilter = array ('_cdi_meta_departure' => get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_departure', true ),
                              '_cdi_meta_typeparcel' => get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_typeparcel', true ), 
                              '_cdi_meta_parcelweight' => get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_parcelweight', true ),
                              '_cdi_meta_signature' => get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_signature', true ),
                              '_cdi_meta_additionalcompensation' => get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_additionalcompensation', true ),
                              '_cdi_meta_amountcompensation' => get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_amountcompensation', true ),
                              '_cdi_meta_returnReceipt' => get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_returnReceipt', true ),
                              '_cdi_meta_typereturn' => get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_typereturn', true ),
                              '_cdi_meta_ftd' => get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_ftd', true ),
                              '_cdi_meta_nbdayparcelreturn' => get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_nbdayparcelreturn', true ),
                              '_cdi_meta_productCode' => get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_productCode', true ),
                              '_cdi_meta_pickupLocationId' => get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_pickupLocationId', true )  );
          $return = apply_filters ('cdi_filterarray_orderlist_before_metabox',$arrfilter, $order, get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_refshippingmethod', true)) ;
          update_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_departure', $return['_cdi_meta_departure']);
          update_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_typeparcel', $return['_cdi_meta_typeparcel']);
          update_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_parcelweight', $return['_cdi_meta_parcelweight']);
          update_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_signature', $return['_cdi_meta_signature']);
          update_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_additionalcompensation', $return['_cdi_meta_additionalcompensation']);
          update_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_amountcompensation', $return['_cdi_meta_amountcompensation']);
          update_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_returnReceipt', $return['_cdi_meta_returnReceipt']);
          update_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_typereturn', $return['_cdi_meta_typereturn']);
          update_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_ftd', $return['_cdi_meta_ftd']);
          update_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_nbdayparcelreturn', $return['_cdi_meta_nbdayparcelreturn']);
          update_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_productCode', $return['_cdi_meta_productCode']);
          update_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_pickupLocationId', $return['_cdi_meta_pickupLocationId']);

          // Calculate CN23 article fields
          $cdi_meta_cn23_shipping = WC_function_Colissimo::cdi_cn23_calc_shipping($order);
          $cdi_meta_cn23_category = get_option('wc_settings_tab_colissimo_cn23_category');
          $arrfilter =  array ('_cdi_meta_cn23_shipping' => $cdi_meta_cn23_shipping,
                               '_cdi_meta_cn23_category' => $cdi_meta_cn23_category) ;
          $return = apply_filters ('cdi_filterarray_orderlist_before_metaboxcn23',$arrfilter, $order, get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_refshippingmethod', true)) ;
          add_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_cn23_shipping', $return['_cdi_meta_cn23_shipping'], true);
          add_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_cn23_category', $return['_cdi_meta_cn23_category'], true);

          // Add cn23data according to nbitem
          $order_id = cdiwc3::cdi_order_id($order);
          $ordercurrent = new WC_Order( $order_id );
          $items = $ordercurrent->get_items();
          $nbart = 0;
          foreach( $items as $item ) {
            $cdi_meta_cn23_article_description = get_option('wc_settings_tab_colissimo_cn23_article_description') ;
            if (!$cdi_meta_cn23_article_description or $cdi_meta_cn23_article_description == ' ') {
              $cdi_meta_cn23_article_description = WC_function_Colissimo::cdi_cn23_calc_desc($order, $nbart);
            }
            $cdi_meta_cn23_article_weight = get_option('wc_settings_tab_colissimo_cn23_article_weight') ;
            if (!$cdi_meta_cn23_article_weight or $cdi_meta_cn23_article_weight == 0) {
              $cdi_meta_cn23_article_weight = WC_function_Colissimo::cdi_cn23_calc_artweight($order, $nbart);
            }
            $cdi_meta_cn23_article_quantity = get_option('wc_settings_tab_colissimo_cn23_article_quantity') ;
            if (!$cdi_meta_cn23_article_quantity or $cdi_meta_cn23_article_quantity == 0) {
              $cdi_meta_cn23_article_quantity = WC_function_Colissimo::cdi_cn23_calc_artquantity($order, $nbart);
            }
            $cdi_meta_cn23_article_value = get_option('wc_settings_tab_colissimo_cn23_article_value') ;
            if (!$cdi_meta_cn23_article_value or $cdi_meta_cn23_article_value == 0) {
              $cdi_meta_cn23_article_value = WC_function_Colissimo::cdi_cn23_calc_artvalueht($order, $nbart);
            }
            $cdi_meta_cn23_article_hstariffnumber = get_option('wc_settings_tab_colissimo_cn23_article_hstariffnumber') ;
            if (!$cdi_meta_cn23_article_hstariffnumber or $cdi_meta_cn23_article_hstariffnumber == ' ') {
              $cdi_meta_cn23_article_hstariffnumber = WC_function_Colissimo::cdi_cn23_get_hstariff($order, $nbart);
            }
            $cdi_meta_cn23_article_origincountry = get_option('wc_settings_tab_colissimo_cn23_article_origincountry');
            $arrfilter =  array ('_cdi_meta_cn23_article_description' => $cdi_meta_cn23_article_description,
                                 '_cdi_meta_cn23_article_weight' => $cdi_meta_cn23_article_weight,
                                 '_cdi_meta_cn23_article_quantity' => $cdi_meta_cn23_article_quantity,
                                 '_cdi_meta_cn23_article_value' => $cdi_meta_cn23_article_value,
                                 '_cdi_meta_cn23_article_hstariffnumber' => $cdi_meta_cn23_article_hstariffnumber,
                                 '_cdi_meta_cn23_article_origincountry' => $cdi_meta_cn23_article_origincountry) ;

            $return = apply_filters ('cdi_filterarray_orderlist_before_metaboxcn23art',$arrfilter, $order, get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_refshippingmethod', true), $item) ;
            add_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_cn23_article_description_' . $nbart, $return['_cdi_meta_cn23_article_description'], true);
            add_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_cn23_article_weight_' . $nbart, $return['_cdi_meta_cn23_article_weight'], true);
            add_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_cn23_article_quantity_' . $nbart, $return['_cdi_meta_cn23_article_quantity'], true);
            add_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_cn23_article_value_' . $nbart, $return['_cdi_meta_cn23_article_value'], true);
            add_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_cn23_article_hstariffnumber_' . $nbart, $return['_cdi_meta_cn23_article_hstariffnumber'], true);
            add_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_cn23_article_origincountry_' . $nbart, $return['_cdi_meta_cn23_article_origincountry'], true);

            if ($nbart >= 99) break; // A max limit is needed
            $nbart = $nbart+1;
          }
        }
      }
      // Compute and update the Colissimo status, get the tracking code, and if requested clean gateway order
      if($status == 'processing' OR $status == 'on-hold') {
        $eligible = 'yes' ;
      }else{
        $eligible = apply_filters ('cdi_filterstring_orderlist_eligible', 'no', $order) ;
      }
      if ($eligible == 'yes') {
        if( get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_status', true ) !== 'intruck') {
          $results = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "cdi where cdi_order_id like '" . esc_sql(cdiwc3::cdi_order_id($order)) . "' ");
          if (count($results)) {
            foreach ($results as $row) {
              $tracking_code = $row->cdi_tracking;
              $cdi_parcelNumberPartner = $row->cdi_parcelNumberPartner;
              $url_label = $row->cdi_hreflabel;
              $id_row = $row->id;
            }
            if ($tracking_code && ($row->cdi_status == 'open' or null == $row->cdi_status)) { // For compatibility if parcels are in gateway at change
              $tracking_code = str_replace (' ', '', $tracking_code);
              $cdi_parcelNumberPartner = str_replace (' ', '', $cdi_parcelNumberPartner);
              update_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_status', 'intruck');
              update_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_tracking', $tracking_code);
              update_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_parcelNumberPartner', $cdi_parcelNumberPartner);
              update_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_urllabel', $url_label);
              add_post_meta(cdiwc3::cdi_order_id($order), 'Colissimo', $tracking_code, true); // Compatibility with anterior version of this plugin
              update_post_meta(cdiwc3::cdi_order_id($order), 'Colissimo', $tracking_code);
              if (get_option('wc_settings_tab_colissimo_autoclean_gateway') == 'yes') {
                $wpdb->query("delete from " . $wpdb->prefix . "cdi where id = '" . esc_sql($id_row) . "' limit 1");
              }
              do_action ('cdi_actionorderlist_after_updateorder', $order ) ;
            }else{
              update_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_status', 'deposited');
            }
          }else{
            update_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_status', 'waiting');   
          }
        }
        ?>
        <a id="cdi-<?php echo cdiwc3::cdi_order_id($order) ; ?>" 
        <?php $colissimo_status = get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_status', true); ?>
        <?php if ($colissimo_status == 'waiting') { ?> class="button tips preview-colissimo waiting" alt="<?php _e('Waiting', 'colissimo-delivery-integration'); ?>" data-tip="<?php _e('Waiting - Can be filed in the Colissimo gateway.', 'colissimo-delivery-integration'); ?>" <?php } ?>
        <?php if ($colissimo_status == 'deposited') { ?> class="button tips preview-colissimo deposited" alt="<?php _e('Deposited', 'colissimo-delivery-integration'); ?>" data-tip="<?php _e('Filed in Colissimo gateway - Is pending for processing.', 'colissimo-delivery-integration'); ?>" <?php } ?>   
        <?php if ($colissimo_status == 'intruck') { ?> class="button tips preview-colissimo intruck" alt="<?php _e('In truck', 'colissimo-delivery-integration'); ?>" data-tip="<?php _e('In truck - Parcel is on the road and carrier is in charge.', 'colissimo-delivery-integration'); ?>" <?php } ?>
        >Colissimo shipping</a>
        <?php 
      }
    }
    public static function cdi_colissimo_ajax() { ?>
	<script type="text/javascript" >
	jQuery(document).ready(function($) {
          $('.preview-colissimo').click(function(){
            var data = {'action': 'cdi_colissimo_button', 'orderid': $(this).attr('id')};
            jQuery.post(ajaxurl, data, function(response) {
              window.location="<?php echo admin_url() . 'edit.php?post_type=shop_order' ?>";
	    });
          });
	});
	</script> <?php
    }
    public static function cdi_colissimo_button_callback() {
        $orderid = $_POST['orderid'] ;
        $orderid = str_replace ('cdi-', '', $orderid);
        WC_Gateway_Tab_Colissimo::cdi_colissimo_open () ;
        WC_Gateway_Tab_Colissimo::cdi_colissimo_add($orderid) ;
        WC_Gateway_Tab_Colissimo::cdi_colissimo_close () ;
	wp_die(); 
    }
}
?>
