<?php
/*
 * Plugin Name: Colissimo Delivery Integration 
 * Description: Easy Colissimo Services with WooCommerce.
 * Version: 3.2.4
 * Author: Harasse
 *
 * Text Domain: colissimo-delivery-integration
 * Domain Path: /languages/
 *
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * 
 * Copyright: (c) 2016  Harasse 
 
 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License, version 3, as 
 published by the Free Software Foundation.
 
 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.
 
 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
__( 'Colissimo Delivery Integration', 'colissimo-delivery-integration' ) ;
__( 'Easy Colissimo Services with WooCommerce.', 'colissimo-delivery-integration' ) ;

/**
 * This file is part of the Colissimo Delivery Integration plugin.
 * (c) Harasse
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if (!defined('ABSPATH')) exit;

/**
 * Add the styles
 */
function cdi_add_styles_css() {
  wp_enqueue_style( 'colissimo-delivery-integration-admin', plugin_dir_url( __FILE__ ) . 'css/admincdi.css' );
}
add_action( 'admin_enqueue_scripts', 'cdi_add_styles_css' );


/**
 * Plugin Activation
 */
function cdi_install($networkwide) {
  global $wpdb;
  if (function_exists('is_multisite') && is_multisite()) {
    // check if it is a network activation - if so, run the activation function for each blog id
    if ($networkwide) {
      $old_blog = $wpdb->blogid;
      // Get all blog ids
      $blogids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
      foreach ($blogids as $blog_id) {
        switch_to_blog($blog_id);
        cdi_install_db();
      }
      switch_to_blog($old_blog);
      return;
    }   
  } 
  cdi_install_db();      
}
register_activation_hook(__FILE__, 'cdi_install');


/**
 * Activation New blog
 */      
function new_blog($blog_id, $user_id, $domain, $path, $site_id, $meta ) {
  global $wpdb;
  $old_blog = $wpdb->blogid;
  switch_to_blog($blog_id);
  cdi_install_db();
  switch_to_blog($old_blog);
}
add_action( 'wpmu_new_blog', 'new_blog', 10, 6);  


/**
 * Plugin Deactivation
 */
function cdi_uninstall() {
  // Nothing done here - See uninstall.php file
  global $wpdb;
  // Remove capability cdi_gateway
  $roles = get_editable_roles();
  foreach ($GLOBALS['wp_roles']->role_objects as $key => $role) {
    if (isset($roles[$key]) && $role->has_cap('cdi_gateway')) {
      $role->remove_cap('cdi_gateway');
    }
  }
}
register_deactivation_hook(__FILE__, 'cdi_uninstall');


/**
 * DB install
 */
function cdi_install_db() {
  global $wpdb;
  $table     = $wpdb->prefix . "cdi";
  $structure = "CREATE TABLE IF NOT EXISTS $table (
        id INT(9) NOT NULL AUTO_INCREMENT,
        cdi_order_id VARCHAR(9) NOT NULL,
        cdi_tracking VARCHAR(200) NOT NULL,
        cdi_parcelNumberPartner VARCHAR(200) NOT NULL,
        cdi_hreflabel VARCHAR(200) NOT NULL,
        cdi_status VARCHAR(200) NOT NULL, 
        cdi_reserve VARCHAR(200) NOT NULL,
	UNIQUE KEY id (id),
        UNIQUE KEY cdi_order_id (cdi_order_id)
     );";
  $wpdb->query($structure);
}


/**
 * Update version and db
 */
function cdi_update_version() {
  global $wpdb;
  global $noticestodisplay ;
  $plugin_data = get_plugin_data( __FILE__ );
  $plugin_version = $plugin_data['Version'];
  $options_version = get_option('cdi_options_version');
  $x = strnatcasecmp ( $plugin_version , $options_version );
  if (!$options_version or $x > 0) {
    $table = $wpdb->prefix . "cdi";
    if (strnatcasecmp ( '2.0.2' , $options_version ) > 0) { // Update (again) for 2.0.2
          // Nothing to do
    }
    if (strnatcasecmp ( '3.0.0' , $options_version ) > 0) { // Update (again) for 3.0.0
          // Nothing to do
    }
    if (strnatcasecmp ( '3.2.4' , $options_version ) > 0) { // Update (again) for 3.2.4
      $noticestodisplay[] = '<div class="notice notice-info is-dismissible"><p>Le nouveau service CDI+ (Colissimo Delivery Integration plus) est opérationnel. Allez dans les règlages de CDI pour plus d\'informations et pour y adhérer.</p></div>' ;
    }


    // Update version in options table
    delete_option('cdi_options_version' );
    add_option('cdi_options_version', $plugin_version);

  }
  $result = get_option('WC_settings_tab_colissimo_domain') ;
  if (!$result){
    update_option('WC_settings_tab_colissimo_domain', 'https://colissimodeliveryintegration.com');
  }
}
add_action( 'admin_init', 'cdi_update_version' );

/**
 * Display admin notices
 */
function cdi_general_admin_notice(){
    global $noticestodisplay ;
      if ($noticestodisplay) {
        foreach ($noticestodisplay as $noticetodisplay){
          echo $noticetodisplay ;
        }
        $noticestodisplay = null ;
      }
}
add_action('admin_notices', 'cdi_general_admin_notice');

/**
 * Set sub link in  plugins extension admin panel
 */
function plugin_row_meta( $links, $file ) {
  if ( $file ==  plugin_basename( __FILE__ ) ) {
    $row_meta = array(
      'support' => '<a href="https://wordpress.org/plugins/colissimo-delivery-integration/faq/" title="Do you need some help?" onclick="window.open(this.href); return false;" target="_self">' . __( 'Do you need some help?', 'colissimo-delivery-integration' ) . '</a>');
    if (WC_function_Colissimo::cdi_isconnected()) {
      $siteurl = get_option('siteurl') ;
      $abonne = get_option('wc_settings_tab_colissimo_cdiplus_ContractNumber') ;
      $radiosite = WC_function_Colissimo::cdi_get_radiosite() ;
      $radiosite = str_replace('WC_settings_tab_colissimo', 'X', $radiosite) ; // to shorten the display and avoid truncated mail
      $row_meta_early = array(
      'early' => '<a style="background-color:#cccccc;" href="mailto:colissimodeliveryintegration@gmail.com?Subject=CDI ASSISTANCE : ' . $siteurl . ' ' . $abonne . '&body=' . ' => YOUR CDI PARAMETERS :%0D%0A' . $radiosite . ' ************%0D%0A=> YOUR ISSUE DESCRIPTION TO INCLUDE HERE :%0D%0A' . '" title="This premium support is exclusively for CDI+ registered users. When you click, an email is suggest to you. This proposed email, that you can modify, contains your non-confidential settings that will clarify the context of your problem." >' . __( 'Your CDI+ premium support !', 'colissimo-delivery-integration' ) . '</a>');
      eval (WC_function_Colissimo::cdi_eval('11')) ;
    }
    return array_merge( $links, $row_meta );
  }
  return (array) $links;
}
add_filter( 'plugin_row_meta', 'plugin_row_meta', 10, 2 );

/**
 * Set locale and load plugin textdomain
 */
function cdi_load_plugin_textdomain() {
$locale = apply_filters( 'plugin_locale', get_locale(), 'colissimo-delivery-integration' );
load_textdomain( 'colissimo-delivery-integration', WP_LANG_DIR . '/colissimo-delivery-integration/colissimo-delivery-integration-' . $locale . '.mo' );
load_plugin_textdomain( 'colissimo-delivery-integration', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'cdi_load_plugin_textdomain' ) ;


/**
 * Define "cdi_gateway" capability for admin roles (which can manage_options) and for role names chosen in settings.
 */
function cdi_add_caps_gateway() {
  $arrrolename = get_option('wc_settings_tab_colissimo_rolename_gateway') ;
  if ($arrrolename && $arrrolename !== '') {
    $roles = get_editable_roles();
    foreach ($GLOBALS['wp_roles']->role_objects as $key => $role) {
      if (isset($roles[$key])) {
        if ($role->has_cap('manage_options') OR in_array($role->name, $arrrolename)) {
          $role->add_cap('cdi_gateway');
        }else{
          $role->remove_cap('cdi_gateway');
        }
      }
    }
  }
}
add_action( 'admin_init','cdi_add_caps_gateway');


/**
 * Define link to settings.
 */
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'cdi_plugin_action_links' );
function cdi_plugin_action_links( $links ) {
  $setting_link = 'admin.php?page=wc-settings&tab=settings_tab_colissimo' ;
  $plugin_links = array(
                    '<a href="' . $setting_link . '">' . __( 'Settings', 'colissimo-delivery-integration' ) . '</a>',
		  );
  return array_merge( $plugin_links, $links );
}


/**
 * Including Classes
 */

include_once ('includes/WC-cdi-class-wc3.php'); 

include_once ('includes/WC-function-Colissimo.php'); 
WC_function_Colissimo::init();

include_once ('includes/WC-Metabox-Colissimo.php');
WC_Metabox_Colissimo::init();

include_once ('includes/WC-Settings-Tab-Colissimo.php'); 
WC_Settings_Tab_Colissimo::init();

include_once ('includes/WC-Action-Orderlist-Colissimo.php'); 
WC_Action_Orderlist_Colissimo::init();
		
include_once ('includes/WC-Action-Bulk-Colissimo.php'); 
WC_Action_Bulk_Colissimo::init();

include_once ('includes/WC-Gateway-Tab-Colissimo.php'); 
WC_Gateway_Tab_Colissimo::init();

include_once ('includes/WC-gateway-colissimo-manual.php');
WC_gateway_colissimo_manual::init();

include_once ('includes/WC-gateway-colissimo-printlabel.php');
WC_gateway_colissimo_printlabel::init();

include_once ('includes/WC-gateway-colissimo-online.php');
WC_gateway_colissimo_online::init();

include_once ('includes/WC-gateway-colissimo-auto.php');
WC_gateway_colissimo_auto::init();

include_once ('includes/WC-gateway-colissimo-custom.php');
WC_gateway_colissimo_custom::init();

include_once ('includes/WC-Frontend-Colissimo.php');
WC_Frontend_Colissimo::init();

include_once ('includes/WC-print-localpdf-labelandcn23.php');
WC_print_localpdf_labelandcn23::init();

include_once ('includes/WC-colissimo-shipping-zone.php');
WC_colissimo_shipping::init();

include_once ('includes/WC-colissimo-choix-livraison.php');
WC_colissimo_choix_livraison::init();

include_once ('includes/WC-colissimo-retourcolis.php');
WC_colissimo_retourcolis::init();

include_once ('includes/WC-gateway-colissimo-coliship.php');
WC_gateway_colissimo_coliship::init();

include_once ('includes/WC-Gateway-Tab-Printbulkpdf.php');
WC_Gateway_Tab_Printbulkpdf::init();


?>
