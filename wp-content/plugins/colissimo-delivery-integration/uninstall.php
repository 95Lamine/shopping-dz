<?php
/**
 * This file is part of the Colissimo Delivery Integration plugin.
 * (c) Harasse
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/****************************************************************************************/
/* Colissimo Delivery Integration uninstall proc                                        */
/****************************************************************************************/

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) { exit;}
class PLL_Uninstall {

 function __construct() {
   global $wpdb;
   // check if it is a multisite uninstall - if so, run the uninstall function for each blog id
   if ( is_multisite() ) {
     foreach ( $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" ) as $blog_id ) {
       switch_to_blog( $blog_id );
       $this->uninstall();
     }
     restore_current_blog();
   }else{
     $this->uninstall();
   }
 }

 function uninstall() {
   global $wpdb ;
   if (get_option('wc_settings_tab_colissimo_cleanonsuppress') == 'yes') {
     delete_option('cdi_notice_display'); 
     delete_option('cdi_options_version'); 
     $wpdb->query("delete from $wpdb->options where option_name LIKE 'wc\_settings\_tab\_colissimo\_%';");
     $wpdb->query("delete from $wpdb->options where option_name LIKE 'woocommerce\_colissimo\_shippingzone\_method\_%';");
     $wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}cdi" );
   }
 }
}

new PLL_Uninstall();
