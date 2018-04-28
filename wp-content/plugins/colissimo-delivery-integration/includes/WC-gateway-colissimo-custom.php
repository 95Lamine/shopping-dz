<?php

/**
 * This file is part of the Colissimo Delivery Integration plugin.
 * (c) Harasse
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if (!defined('ABSPATH')) exit;
/****************************************************************************************/
/* Gateway Custom                                                                       */
/****************************************************************************************/
class WC_gateway_colissimo_custom {
  public static function init() {
    add_action('admin_init',  __CLASS__ . '::cdi_custom_run');
  }
  public static function cdi_custom_run() {
    if ( isset($_POST['cdi_gateway_custom']) && isset( $_POST['cdi_custom_run_nonce'] ) && wp_verify_nonce( $_POST['cdi_custom_run_nonce'], 'cdi_custom_run' ) ) {
      global $woocommerce;
      global $wpdb;
      if (current_user_can('cdi_gateway')) {
        $results = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "cdi");
        if (count($results)) {
          $cdi_nbrorderstodo = 0 ;
          $cdi_rowcurrentorder = 0 ;
          $cdi_nbrtrkcode = 0 ;
          foreach ($results as $row) {
            $cdi_tracking = $row->cdi_tracking;
            if (!$cdi_tracking && ($row->cdi_status == 'open' or null == $row->cdi_status)) {
              $cdi_nbrorderstodo = $cdi_nbrorderstodo +1 ;             
            }
          }
          if ( $cdi_nbrorderstodo > 0) {
            foreach ($results as $row) {
              $cdi_tracking = $row->cdi_tracking;
              if (!$cdi_tracking && ($row->cdi_status == 'open' or null == $row->cdi_status)) {
                $cdi_rowcurrentorder = $cdi_rowcurrentorder+1 ;
                $array_for_carrier = WC_function_Colissimo::cdi_array_for_carrier( $row ) ;
                WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $array_for_carrier['order_id']);
                $cdi_tracking = apply_filters ('cdi_custom_gateway_exec', $cdi_tracking=false , $cdi_nbrorderstodo , $cdi_rowcurrentorder, $array_for_carrier) ;
                WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $cdi_tracking);
                if (is_string($cdi_tracking)) {
                  $cdi_nbrtrkcode = $cdi_nbrtrkcode+1 ;
                  $order_id  = $row->cdi_order_id;
                  $x = $wpdb->update($wpdb->prefix . "cdi", array('cdi_tracking' => $cdi_tracking['tracking']), array( 'cdi_order_id' => $order_id ) );
                }
                if (is_array($cdi_tracking)) {
                  $cdi_nbrtrkcode = $cdi_nbrtrkcode+1 ;
                  $order_id  = $row->cdi_order_id;
                  $cdi_tracking['hreflabel'] = htmlspecialchars_decode($cdi_tracking['hreflabel']) ;
                  $x = $wpdb->update($wpdb->prefix . "cdi", array('cdi_tracking' => $cdi_tracking['tracking'], 'cdi_parcelNumberPartner' => $cdi_tracking['parcelnumberpartner'], 'cdi_hreflabel' => $cdi_tracking['hreflabel']), array( 'cdi_order_id' => $order_id ) );
                }
              } // End !$cdi_tracking
            } // End row
          } // End cdi_nbrorderstodo
          $message = number_format_i18n( $cdi_nbrorderstodo ) . __(' parcels processed ; ', 'colissimo-delivery-integration') . number_format_i18n( $cdi_nbrtrkcode ) . __(' tracking codes updated.', 'colissimo-delivery-integration') ;
          update_option( 'cdi_notice_display', $message );
          $sendback = admin_url() . 'admin.php?page=Colissimo-page' ;
          wp_redirect($sendback);
          exit ;
        } //End $results
      } // End current_user_can 
    } // End cdi_custom_run
  } // cdi_gateway_custom
} // End class
?>
