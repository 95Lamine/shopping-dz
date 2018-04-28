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
/* Cdi settings in a tab panel added in the woocommerce settings                        */
/****************************************************************************************/

// Colissimo official constants
define('wc_settings_tab_colissimo_ws_FranceCountryCodes', 'FR,MC,AD');
define('wc_settings_tab_colissimo_ws_FranceProductCodes', 'DOM,DOS,A2P') ;
define('wc_settings_tab_colissimo_ws_OutreMerCountryCodes', 'MQ,GP,RE,GF,YT,PM,MF,BL,PF,NC,WF,TF') ;
define('wc_settings_tab_colissimo_ws_OutreMerProductCodes', 'COM,CDS,') ;
define('wc_settings_tab_colissimo_ws_EuropeCountryCodes', 'BE,DE,NL,ES,GB,LU,PT,AT,CZ,HU,SK,SI,LT,LV,EE,BG,CY,HR,DK,FI,GR,IE,IS,IT,MT,NO,PL,RO,SE,CH') ; // Change in 3.0.0
define('wc_settings_tab_colissimo_ws_EuropeProductCodes', 'DOM,DOS,CMT') ;
define('wc_settings_tab_colissimo_ws_InternationalCountryCodes', '*') ;
define('wc_settings_tab_colissimo_ws_InternationalProductCodes', 'COLI,COLI,') ;
define('wc_settings_tab_colissimo_ws_ExceptionProductCodes', 'ACP=BPR,CDI=BPR') ;
define('wc_settings_tab_colissimo_ws_InternationalPickupLocationContryCodes', 'FR,MC,AD,BE,DE,NL,ES,GB,LU,AT,EE,LV,LT,PL,PT,SE') ; // Change in 3.0.0
define('wc_settings_tab_colissimo_trackingheaders_parcelreturn', '6A,9L,6C,9V,6H,6M,8R,7R,8Q,7Q,9W,5R,CP,EY,EN,CM,CA,CB,CI') ; // Change in 3.0.0
define('wc_settings_tab_colissimo_returnproduct_code', 'CORE=FR,MC,AD;CORI=DE,AT,BE,ES,FI,IE,IT,LU,NL,PL,CZ,GB,SK,SI,CH,PT,EE,HU,LT,HR,GR,MT,RO,AU') ; // Change in 3.0.0

class WC_Settings_Tab_Colissimo {
    /**
     * Bootstraps the class and hooks required actions & filters.
     *
     */
    public static function init() {
        add_filter( 'woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50 );
        add_action( 'woocommerce_settings_tabs_settings_tab_colissimo', __CLASS__ . '::settings_tab' );
        add_action( 'woocommerce_sections_settings_tab_colissimo',  __CLASS__ . '::output_sections' );
        add_action( 'woocommerce_update_options_settings_tab_colissimo', __CLASS__ . '::update_settings' );
    }


// 'settings_tab_colissimo' is the name of new Tab and its Sections


//  Add a new settings tab to the WooCommerce settings tabs array.
    public static function add_settings_tab( $settings_tabs ) {
        $settings_tabs['settings_tab_colissimo'] = __( 'Colissimo', 'colissimo-delivery-integration' );
        return $settings_tabs;
    }


//   Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
    public static function settings_tab() {
        woocommerce_admin_fields( self::get_settings() );
    }


//  Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
    public static function update_settings() {
        woocommerce_update_options( self::get_settings() );
    }


//  Declare of Sections to include in the Tab
    public static function get_sections() {
        $sections = array(
            'section-general'      => __( 'General settings', 'colissimo-delivery-integration' ),
            'section-cn23'         => __( 'CN23 parameters', 'colissimo-delivery-integration' ),
            'section-tracking'     => __( 'Tracking settings', 'colissimo-delivery-integration' ),
            'section-automatic'    => __( 'Automatic Mode', 'colissimo-delivery-integration' ),
            'section-referrals'    => __( 'Method referrals', 'colissimo-delivery-integration' ),
            'section-shipping'     => __( 'Colissimo method', 'colissimo-delivery-integration' ),
            'section-parcelreturn' => __( 'Parcel return', 'colissimo-delivery-integration' ),
            'section-printlabel'   => __( 'Printing labels', 'colissimo-delivery-integration' ),
        );
        return $sections ;
    }


//  Display the html Sections in the Tab
    public static function output_sections() {
        global $current_section;
        $sections = WC_Settings_Tab_Colissimo::get_sections();
        if ( empty( $sections ) || 1 === sizeof( $sections ) ) {
            return;
        }
        echo '<ul class="subsubsub">';
        $array_keys = array_keys( $sections );
        foreach ( $sections as $id => $label ) {
            echo '<li><a href="' . admin_url( 'admin.php?page=wc-settings&tab=' . 'settings_tab_colissimo' . '&section=' . sanitize_title( $id ) ) . '" class="' . ( $current_section == $id ? 'current' : '' ) . '">' . $label . '</a> ' . ( end( $array_keys ) == $id ? '' : '|' ) . ' </li>';
        }
        $returnmsg = WC_function_Colissimo::cdi_cdiplus_credential() ;
        if ($returnmsg) {
          WC_Admin_Settings::add_message($returnmsg);
        }
        echo '</ul><br class="clear" />';
        echo '<p>' ;
        // To reinstall the official Colissimo settings
        echo '<em></em><input name="cdi_reset_settings_colissimo" type="submit" value="' . __( 'Reset the official Colissimo settings', 'colissimo-delivery-integration' ) . '" style="float: left; color:red;" title="' . __( 'Warning : To reset your Colissimo settings (shown with red font)  to official settings if you have inadvertently changed them. Your own website settings (font not in red) will not be modified.', 'colissimo-delivery-integration' ) . '" /><em></em>' ;
        if ($_SERVER['REQUEST_METHOD'] == "POST" and ISSET($_POST['cdi_reset_settings_colissimo'])) {
          update_option('wc_settings_tab_colissimo_ws_FranceCountryCodes', wc_settings_tab_colissimo_ws_FranceCountryCodes) ;
          update_option('wc_settings_tab_colissimo_ws_FranceProductCodes', wc_settings_tab_colissimo_ws_FranceProductCodes) ;
          update_option('wc_settings_tab_colissimo_ws_OutreMerCountryCodes', wc_settings_tab_colissimo_ws_OutreMerCountryCodes) ;
          update_option('wc_settings_tab_colissimo_ws_OutreMerProductCodes', wc_settings_tab_colissimo_ws_OutreMerProductCodes) ;
          update_option('wc_settings_tab_colissimo_ws_EuropeCountryCodes', wc_settings_tab_colissimo_ws_EuropeCountryCodes) ;
          update_option('wc_settings_tab_colissimo_ws_EuropeProductCodes', wc_settings_tab_colissimo_ws_EuropeProductCodes) ;
          update_option('wc_settings_tab_colissimo_ws_InternationalCountryCodes', wc_settings_tab_colissimo_ws_InternationalCountryCodes) ;
          update_option('wc_settings_tab_colissimo_ws_InternationalProductCodes', wc_settings_tab_colissimo_ws_InternationalProductCodes) ;
          update_option('wc_settings_tab_colissimo_ws_ExceptionProductCodes', wc_settings_tab_colissimo_ws_ExceptionProductCodes) ;
          update_option('wc_settings_tab_colissimo_ws_InternationalPickupLocationContryCodes', wc_settings_tab_colissimo_ws_InternationalPickupLocationContryCodes) ;
          update_option('wc_settings_tab_colissimo_trackingheaders_parcelreturn', wc_settings_tab_colissimo_trackingheaders_parcelreturn) ;
          update_option('wc_settings_tab_colissimo_returnproduct_code', wc_settings_tab_colissimo_returnproduct_code) ;
        }
        if (WC_function_Colissimo::cdi_isconnected()) {
          echo '<em></em><input name="cdi_reinstall_cdidb_colissimo" type="submit" value="' . __( 'Reinstall the CDI Gateway', 'colissimo-delivery-integration' ) . '" style="float: left; color:red;" title="' . __( 'Warning : To reinstall the CDI gateway when something is wrong in CDI process or in an order. The gateway will be recreate empty of parcels. Existing pending parcels in gateway will be deleted, but corresponding orders will be inchanged. All others CDI settings will stay.', 'colissimo-delivery-integration' ) . '" /><em></em>' ;
          if ($_SERVER['REQUEST_METHOD'] == "POST" and ISSET($_POST['cdi_reinstall_cdidb_colissimo'])) {
            global $wpdb;
            eval (WC_function_Colissimo::cdi_eval('6')) ;
            $results = $wpdb->query("DROP TABLE $table") ;
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
        }

        WC_function_Colissimo::cdi_button_connected() ;
        $return = WC_function_Colissimo::cdi_button_adhesioncdiplus() ;
        if ($return !== null) {
          WC_Admin_Settings::add_message($return);
        }
        WC_function_Colissimo::cdi_button_informationcdi() ;

        echo '</p><br class="clear">' ;

        // Warning if settings has not been saved
        $warning = '' ;
        if (null == get_option('wc_settings_tab_colissimo_autoclean_gateway')) {
          $warning .= __( 'General settings', 'colissimo-delivery-integration' ) . ' | ' ;
        }
        if (null == get_option('wc_settings_tab_colissimo_cn23_category')) {
          $warning .= __( 'CN23 parameters', 'colissimo-delivery-integration' ) . ' | ' ;
        }
        if (null == get_option('wc_settings_tab_colissimo_inserttrackingcode')) {
          $warning .= __( 'Tracking settings', 'colissimo-delivery-integration' ) . ' | ' ;
        }
        if (null == get_option('wc_settings_tab_colissimo_ws_OffsetDepositDate')) {
          $warning .= __( 'Automatic Mode', 'colissimo-delivery-integration' ) . ' | ' ;
        }
        if (null == get_option('wc_settings_tab_colissimo_methodreferal')) {
          $warning .= __( 'Method referrals', 'colissimo-delivery-integration' ) . ' | ' ;
        }
        if (null == get_option('wc_settings_tab_colissimo_methodshipping')) {
          $warning .= __( 'Colissimo method', 'colissimo-delivery-integration' ) . ' | ' ;
        }
        if (null == get_option('wc_settings_tab_colissimo_parcelreturn')) {
          $warning .= __( 'Parcel return', 'colissimo-delivery-integration' ) . ' | ' ;
        }
        if (null == get_option('wc_settings_tab_colissimo_pagesize')) {
          $warning .= __( 'Printing labels', 'colissimo-delivery-integration' ) . ' | ' ;
        }
        if ($warning !== '') {
          WC_Admin_Settings::add_message( __( 'It seems yours CDI panels | ', 'colissimo-delivery-integration' ) . $warning . __( ' have not been registered. So your plugin will not work correctly. Please click on "Register changes" for each of theses panels to have your settings correctly registered.', 'colissimo-delivery-integration' ));
        }

        // Warnings if use of old packages
        $wcversion = get_bloginfo('version');
        if (version_compare($wcversion, '4.4.0') < 0) {
          WC_Admin_Settings::add_message( __( 'The Wordpress version is less than 4.4.0. You should upgrade it to fully use Colissimo Delivery Integration', 'colissimo-delivery-integration' ));
        }
        $wooversion = WC_function_Colissimo::cdi_get_woo_version_number();
        if (version_compare($wooversion, '2.6.0') < 0) {
          WC_Admin_Settings::add_message( __( 'The Woocommerce version is less than 2.6.0. You should upgrade it to fully use Colissimo Delivery Integration', 'colissimo-delivery-integration' ));
        }
        if (version_compare(phpversion(), '5.4.0') < 0) {
          WC_Admin_Settings::add_message( __( 'The PHP version is less than 5.4.0. You should upgrade it to fully use Colissimo Delivery Integration', 'colissimo-delivery-integration' ));
        }
        if (!extension_loaded('openssl')) {
          WC_Admin_Settings::add_message( __( 'The OpenSSL extension is not installed. You should install it to fully use Colissimo Delivery Integration', 'colissimo-delivery-integration' ));
        }else{
          $opensslcurrent = WC_function_Colissimo::get_openssl_version_number($patch_as_number=true) ;
          if (version_compare($opensslcurrent, '1.0.1') < 0) {
            WC_Admin_Settings::add_message( __( 'The Openssl version is less than 1.0.1. You should upgrade it to fully use Colissimo Delivery Integration', 'colissimo-delivery-integration' ));
          }
        }

    }


//  Declare of Settings according to the Section called
    public static function get_settings() {
        global $settings ;
        if (isset($_GET["section"])) {
          $section = $_GET["section"];
        }else{
          $section = 'section-general'; // default section
        }
        switch( $section ){
            case 'section-general' :
                $settings = WC_Settings_Tab_Colissimo::get_settings_section_general() ;
            break;
            case 'section-cn23' :
                $settings = WC_Settings_Tab_Colissimo::get_settings_section_cn23() ;
            break;
            case 'section-tracking' :
                $settings = WC_Settings_Tab_Colissimo::get_settings_section_tracking() ;
            break;
            case 'section-automatic' :
                $settings = WC_Settings_Tab_Colissimo::get_settings_section_automatic() ;
            break;
            case 'section-referrals' :
                $settings = WC_Settings_Tab_Colissimo::get_settings_section_referrals() ;
            break;
            case 'section-shipping' :
                $settings = WC_Settings_Tab_Colissimo::get_settings_section_shipping() ;
            break;
            case 'section-parcelreturn' :
                $settings = WC_Settings_Tab_Colissimo::get_settings_section_parcelreturn() ;
            break;
            case 'section-printlabel' :
                $settings = WC_Settings_Tab_Colissimo::get_settings_section_printlabel() ;
            break;
        }
        return $settings ;
    }


//  ref : https://github.com/woothemes/woocommerce/blob/5dcd19f5fa133a25c7e025d7c73e04516bcf90da/includes/admin/class-wc-admin-settings.php#L195
//  Get the settings of Section general
    public static function get_settings_section_general() {
        $selectroles = array() ;
        $roles = get_editable_roles();
        foreach ($GLOBALS['wp_roles']->role_objects as $key => $role) {
          if (isset($roles[$key])) {
            $selectroles[$role->name] =  $role->name ;
          }
        }

        return array(
            'section_title' => array(
                'name'     => __( 'Colissimo Delivery Integration - General settings', 'colissimo-delivery-integration' ),
                'type'     => 'title',
                'desc'     => '',
                'id'       => 'wc_settings_tab_colissimo_section_general'
            ),
            'General settings' => array(
                'name' => __( 'Parcel default settings', 'colissimo-delivery-integration' ),
                'type' => 'checkbox',
                'default' => 'yes',
                'desc' => __( 'Auto clean of Colissimo parcels in gateway when "In truck" status', 'colissimo-delivery-integration' ),
                'id'   => 'wc_settings_tab_colissimo_autoclean_gateway'
            ),
            'Type Parcel' => array(
                'type' => 'select',
                'options' => array (
                  'colis-standard'   => __('Standard', 'colissimo-delivery-integration'),
                  'colis-volumineux' => __('Cumbersome', 'colissimo-delivery-integration'),
                  'colis-rouleau   ' => __('Tube', 'colissimo-delivery-integration'),
                  ),
                'default' => 'Standard',
                'desc' => __( 'Default Type Parcel', 'colissimo-delivery-integration' ),
                'id'   => 'wc_settings_tab_colissimo_defaulttypeparcel'
            ),
            'Parcel empty weight' => array(
                'type' => 'number',
                'default' => '250',
                'desc' => __( 'Default weight (in grams) of empty Colissimo package (net weight of products will be added)', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "If products have not weight, this tare weight will be the default weight of the parcel. Anyway, the total computed weight of the parcel can be change manually in the order meta box before processing the parcel.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_parcelweight'
            ),
            'Contre signature' => array(
                'type' => 'checkbox',
                'default' => 'no',
                'desc' => __( 'Default Delivery "contre-signature avec option recommandation"', 'colissimo-delivery-integration' ),
                'id'   => 'wc_settings_tab_colissimo_signature'
            ),
            'Additional Compensation' => array(
                'type' => 'checkbox',
                'default' => 'no',
                'desc' => __( 'Default Additional Compensation ? :', 'colissimo-delivery-integration' ),
                'id'   => 'wc_settings_tab_colissimo_additionalcompensation'
            ),
            'Amount Compensation' => array(
                'type' => 'number',
                'default' => '50',
                'desc' => __( 'Default Total Amount Compensation in euros', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Is significant only if additional compensation is checked. It is the default insurance amount in €.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_amountcompensation'
            ),
            'Type Return' => array(
                'type' => 'select',
                'options' => array (
                  'no-return'      => __('No return', 'colissimo-delivery-integration'),
                  'pay-for-return' => __('Pay for return', 'colissimo-delivery-integration'),
                  ),
                'default' => 'No return',
                'desc' => __( 'Default Type Return', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Mandatory for some abroad shipments. Consult Colissimo help to known which countries need that data.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_defaulttypereturn'
            ),
            'French departure city' => array(
                'name' => __( 'Colissimo Online Mode (iMacros script)', 'colissimo-delivery-integration' ),
                'type' => 'text',
                'default' => '75001 PARIS',
                'desc' => __( 'French departure city - ZIP code & City.', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Mandatory for Colissimo online services. The syntax zipcode espace city is strict.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_departure'
            ),
            'Départ Boite aux lettres' => array(
                'type' => 'checkbox',
                'default' => 'no',
                'desc' => __( 'Departure from your own letter box', 'colissimo-delivery-integration' ),
                'id'   => 'wc_settings_tab_colissimo_fromletterbox'
            ),
            'Module to log' => array(
                'name' => __( 'Plugin features', 'colissimo-delivery-integration' ),
                'type' => 'multiselect',
                'options' => array (
                  '/includes/WC-Action-Bulk-Colissimo.php' => '/includes/WC-Action-Bulk-Colissimo.php' ,
                  '/includes/WC-Action-Orderlist-Colissimo.php' => '/includes/WC-Action-Orderlist-Colissimo.php' ,
                  '/includes/WC-colissimo-choix-livraison.php' => '/includes/WC-colissimo-choix-livraison.php' ,
                  '/includes/WC-colissimo-retourcolis.php' => '/includes/WC-colissimo-retourcolis.php' ,
                  '/includes/WC-colissimo-shipping-zone.php' => '/includes/WC-colissimo-shipping-zone.php' ,
                  '/includes/WC-filter-examples.php' => '/includes/WC-filter-examples.php' ,
                  '/includes/WC-Frontend-Colissimo.php' => '/includes/WC-Frontend-Colissimo.php' ,
                  '/includes/WC-function-Colissimo.php' => '/includes/WC-function-Colissimo.php' ,
                  '/includes/WC-gateway-colissimo-auto.php' => '/includes/WC-gateway-colissimo-auto.php' ,
                  '/includes/WC-gateway-colissimo-custom.php' => '/includes/WC-gateway-colissimo-custom.php' ,
                  '/includes/WC-gateway-colissimo-manual.php' => '/includes/WC-gateway-colissimo-manual.php' ,
                  '/includes/WC-gateway-colissimo-printlabel.php' => '/includes/WC-gateway-colissimo-printlabel.php' ,
                  '/includes/WC-gateway-colissimo-online.php' => '/includes/WC-gateway-colissimo-online.php' ,
                  '/includes/WC-Gateway-Tab-Colissimo.php' => '/includes/WC-Gateway-Tab-Colissimo.php' ,
                  '/includes/WC-Metabox-Colissimo.php' => '/includes/WC-Metabox-Colissimo.php' ,
                  '/includes/WC-print-localpdf-labelandcn23.php' => '/includes/WC-print-localpdf-labelandcn23.php' ,
                  '/includes/WC-Settings-Tab-Colissimo.php' => '/includes/WC-Settings-Tab-Colissimo.php' ,
                  '/includes/WC-gateway-colissimo-coliship.php' => '/includes/WC-gateway-colissimo-coliship.php' ,
                  '/includes/WC-Gateway-Tab-Printbulkpdf.php' => '/includes/WC-Gateway-Tab-Printbulkpdf.php' ,
                  '/colissimo-delivery-integration.php' => '/colissimo-delivery-integration.php' ,
                  '/uninstall.php' => '/uninstall.php' ,
                  ),
                'default' => array (
                   '/includes/WC-gateway-colissimo-auto.php',
                   '/includes/WC-colissimo-retourcolis.php',
                 ),
                'desc' => __( 'Multi select the modules for which you need a debugging log.', 'colissimo-delivery-integration' ),
                'desc_tip' => __( 'A selection of only some modules will give you a smaller log file easier to be analysed. To analyse the log, you can directly edit the wp-content/debug.log file, or use ad-hoc plugin to view and manage the file as for instance "WP Log Viewer Plugin".', "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_moduletolog'
            ),
            'Mode log' => array(
                'type' => 'checkbox',
                'default' => 'no',
                'desc' => __( 'Enable log for debugging purpose', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Traces apply to all CDI modules. They are stored in the wp-content/debug.log file when the config.php setting authorize the debug mode with : define( 'WP_DEBUG', true ); define( 'WP_DEBUG_LOG', true ); define( 'WP_DEBUG_DISPLAY', false );", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_log'
            ),
            'Role using Gateway' => array(
                'type' => 'multiselect',
                'options' => $selectroles , 
                'default' => array ('shop_manager'),
                'desc' => __( 'Choose the WP role you want to have access to CDI-Gateway.', 'colissimo-delivery-integration' ),
                'desc_tip' => __( 'Administrator have already an access to CDI-Gateway. But you can choose to give also access to CDI-Gateway to another role which is not administrator .', "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_rolename_gateway'
            ),
            'Clean on suppress' => array(
                'type' => 'checkbox',
                'default' => 'no',
                'desc' => __( 'Clean CDI datas when plugin is uninstalled', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "CDI parameters are normally keep saved in the database when the plugin is uninstalled. Thus, these parameters are operational when the plugin is reinstalled. By cons, when the ckeck is checked, all CDI datas will be cleaned when the plugin is uninstall.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_cleanonsuppress'
            ),
            'Contract Number' => array(
                'name' => __( 'Réservé aux abonné CDI+', 'colissimo-delivery-integration' ),
                'type' => 'text',
                'default' => '',
                'desc' => __( 'CDI+ contract number', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Si vous êtes abonné à CDI+, indiquez ici votre numéro de contrat.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_cdiplus_ContractNumber'
            ),
            'Authentification' => array(
                'type' => 'password',
                'default' => '',
                'desc' => __( 'CDI+ authentification', 'colissimo-delivery-integration' ), 
                'desc_tip' => __( "Si vous êtes abonné à CDI+, indiquez ici votre clé authentification CDI+", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_cdiplus_Password'
            ),
            'section_end' => array(
                 'type' => 'sectionend',
                 'id' => 'wc_settings_tab_colissimo_section_general_end'
            )
        );
    }


//  Get the settings of Section cn23
    public static function get_settings_section_cn23() {
        return array(
            'section_title' => array(
                'name'     => __( 'Colissimo Delivery Integration - CN23 default settings', 'colissimo-delivery-integration' ),
                'type'     => 'title',
                'desc'     => '',
                'id'       => 'wc_settings_tab_colissimo_section_cn23'
            ),
            'CN23 default' => array(
                'type' => 'select',
                'options' => array (
                  '1' => __('Gift', 'colissimo-delivery-integration'),
                  '2' => __('Sample', 'colissimo-delivery-integration'),
                  '3' => __('Commercial', 'colissimo-delivery-integration'),
                  '4' => __('Documents', 'colissimo-delivery-integration'),
                  '5' => __('Other', 'colissimo-delivery-integration'),
                  '6' => __('Returned goods', 'colissimo-delivery-integration'),
                  ),
                'default' => '3',
                'desc' => __( 'Default CN23 Category', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Give the nature of the contents of the package in CN23 codification. CN23 is an internationally recognized standard, to codify customs declarations. In France, a CN23 is required for all shipments abroad and the TOM-DOM except: DE, AT, BE, BG, CY, DK ES  EE, FI, E, GR, HU, IE, IT, LV, LT, LU, MT, NL,  PL , PT , CZ , RO , GB , IE , SK , SI , SE.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_cn23_category'
            ),
            'CN23 Article Description' => array(
                'type' => 'text',
                'desc' => __( 'Default CN23 Description of article (blank = copied from product order)', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Give the the default description of articles in the parcel. Up to 10 items/products can be included in a CDI CN23.
If null or 0,  product title, product weight, product quantity, and product price in the order will be considered. ", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_cn23_article_description'
            ),
            'CN23 Article Weight' => array(
                'type' => 'number',
                'default' => '0',
                'desc' => __( 'Default CN23 Net weight in grams of one article (0 = copied from product order)', 'colissimo-delivery-integration' ),
                'id'   => 'wc_settings_tab_colissimo_cn23_article_weight'
            ),
            'CN23 Article Quantity' => array(
                'type' => 'number',
                'default' => '0',
                'desc' => __( 'Default CN23 Number of articles in the parcel (0 = copied from product order)', 'colissimo-delivery-integration' ),
                'id'   => 'wc_settings_tab_colissimo_cn23_article_quantity'
            ),
            'CN23 Article Value' => array(
                'type' => 'number',
                'default' => '0',
                'desc' => __( 'Default CN23 ex VAT Value in € of one article (0 = copied from product order)', 'colissimo-delivery-integration' ),
                'id'   => 'wc_settings_tab_colissimo_cn23_article_value'
            ),
            'CN23 Article HStariffnumber' => array(
                'type' => 'text',
                'default' => '620630',
                'custom_attributes' => array (
                  'pattern' => '[0-9]{4,6}',
                  ),
                'desc' => __( 'Default CN23 HS tariff code- 4 to 6 digits (only if "Commercial" category)', 'colissimo-delivery-integration' ) . ' - <a href="https://pro.douane.gouv.fr/" target="_blank">HS Tariff code</a>',
                'desc_tip' => __( "HS Tariff is an internationally recognized standard, to codify customs declarations. This code is required only for commercial shipment", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_cn23_article_hstariffnumber'
            ),
            'CN23 Article OriginCountry' => array(
                'type' => 'single_select_country',
                'default' => 'FR',
                'desc' => __( 'Default CN23 ISO code of origine country (for Customs)', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Required by some customs : the 2 letters ISO code of origine country of the item", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_cn23_article_origincountry'
            ),
            'section_end' => array(
                 'type' => 'sectionend',
                 'id' => 'wc_settings_tab_colissimo_section_cn23_end'
            )
        );
    }

//  Get the settings of Section tracking
    public static function get_settings_section_tracking() {
        $return = array(
            'section_title' => array(
                'name'     => __( 'Colissimo Delivery Integration - Tracking settings', 'colissimo-delivery-integration' ),
                'type'     => 'title',
                'desc'     => '',
                'id'       => 'wc_settings_tab_colissimo_section_tracking'
            ),
            'Tracking code to customer' => array(
                'name' => __( 'Tracking code to customer', 'colissimo-delivery-integration' ),
                'type' => 'select',
                'options' => array (
                  'no'                     => __( 'nothing', 'colissimo-delivery-integration' ),
                  'emails'                 => __( 'emails', 'colissimo-delivery-integration' ),
                  'order-views'            => __( 'order-views', 'colissimo-delivery-integration' ),
                  'emails and order-views' => __( 'emails and order-views', 'colissimo-delivery-integration' ),
                  ),
                'default' => 'emails and order-views',
                'desc' => __( 'Insert tracking code and pickup location in Customer emails and/or Customer order views', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "You can choose to insert customer informations in the customer  mails and / or the customer order views. Information shown are the tracking code and the pickup location the customer has choosen.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_inserttrackingcode'
            ),
            'Text preceding tracking code' => array(
                'type' => 'text',
                'css'  => 'width:70%;',
                'default' => __( 'Order shipped. Your tracking code is : ', 'colissimo-delivery-integration' ),
                'desc' => __( 'Text preceding tracking code', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Here, the text you want the customer to see just before the tracking code", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_text_preceding_trackingcode'
            ),
            'Url tracking code' => array(
                'type' => 'text',
                'css'  => 'width:70%;',
                'default' => 'http://www.colissimo.fr/portail_colissimo/suivre.do?colispart=',
                'desc' => __( 'Url for tracking code', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Here, the standard url of your carrier. Don't change it if you don't known its url.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_url_trackingcode'
            )
        );
        if (WC_function_Colissimo::cdi_isconnected()) {
          eval (WC_function_Colissimo::cdi_eval('7')) ;
          $returnext =  array(
            'Extented WC address' => array(
                'name' => __( 'Extend WC addresses to postal standarts', 'colissimo-delivery-integration' ),
                'type' => 'checkbox',
                'default' => 'no',
                'desc' => __( 'Extend the Woocommerce addresses to 4 lines as the standarts used by LaPoste-Colissimo', 'colissimo-delivery-integration' ),
                'id'   => 'wc_settings_tab_colissimo_extentedaddress'
              ), 

            'La Poste ControlAdresse API key' => array(
                'type' => 'text',
                'css'  => 'width:70%;',
                'default' => '',
                'desc' => __( 'La Poste ControlAdresse API key. Key to get at https://developer.laposte.fr/', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Here, the La Poste ControlAdresse API key to be authorize to ask address control.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_apikeylaposte'
              ), 
          ) ;
          eval (WC_function_Colissimo::cdi_eval('13')) ;
          eval (WC_function_Colissimo::cdi_eval('12')) ;
        }
        return array_merge ($return , array(
            'section_end' => array(
                 'type' => 'sectionend',
                 'id' => 'wc_settings_tab_colissimo_section_tracking_end'
              )
         ) ) ;
    }


//  Get the settings of Section automatic
    public static function get_settings_section_automatic() {
        return array(
            'section_title' => array(
                'name'     => __( 'Colissimo Delivery Integration - Automatic Mode (Web Service) settings', 'colissimo-delivery-integration' ),
                'type'     => 'title',
                'desc'     => '',
                'id'       => 'wc_settings_tab_colissimo_section_automatic'
            ),
            'Contract Number' => array(
                'name' => __( 'General', 'colissimo-delivery-integration' ),
                'type' => 'text',
                'default' => '123456',
                'desc' => __( 'Web Service - Contract Number', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Your Colissimo contrat number including the option 'Web Service (Flexibilité) pour livraison et étiquetage'.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_ws_ContractNumber'
            ),
            'Password' => array(
                'type' => 'password',
                'default' => 'PWD123',
                'desc' => __( 'Web Service - Password', 'colissimo-delivery-integration' ), 
                'desc_tip' => __( "Your password at your Colissimo contrat", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_ws_Password'
            ),
            'Output Format - Offset X' => array(
                'type' => 'number',
                'default' => '0',
                'desc' => __( 'Web Service - Output Format - Offset X in pixels', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "The 3 following datas are Colissimo settings for the printing.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_ws_X'
            ),
            'Output Format - Offset Y' => array(
                'type' => 'number',
                'default' => '0',
                'desc' => __( 'Web Service - Output Format - Offset Y in pixels', 'colissimo-delivery-integration' ),
                'id'   => 'wc_settings_tab_colissimo_ws_Y'
            ),
            'Output Format - Printing Type' => array(
                'type' => 'select',
                'options' => array (
                  'PDF_10x15_300dpi' => 'PDF_10x15_300dpi',
                  'PDF_A4_300dpi' => 'PDF_A4_300dpi',
                  ),
                'default' => 'PDF_A4_300dpi',
                'desc' => __( 'Web Service - Output Format - Printing Type (DPL & ZPL not supported)', 'colissimo-delivery-integration' ),
                'id'   => 'wc_settings_tab_colissimo_ws_OutputPrintingType'
            ),
            'Offset Deposit Date' => array(
                'type' => 'number',
                'default' => '+2',
                'desc' => __( 'Web Service - Offset Deposit Date (estimate in days after running the web service)', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Estimate period in days to deposit yours parcels. Useful for La Poste.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_ws_OffsetDepositDate'
            ),
            'return CN23 labels' => array(
                'type' => 'checkbox',
                'default' => 'yes',
                'desc' => __( 'Include CN23 customs declarations in returned labels', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "When checked, a CN23 will be added at the end of the label you access with the url. Anyway, an enclose CN23 is always store in your meta box order.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_IncludeCustomsDeclarations'
            ),
            'Sender Address - Company Name' => array(
                'name' => __( 'Sender address', 'colissimo-delivery-integration' ),
                'type' => 'text',
                'default' => 'The CDI Company',
                'desc' => __( 'Web Service - Sender Address - Company Name (May be same as website name)', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "The 6 following datas define your address as sender. This address will be on the parcels.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_ws_sa_CompanyName'
            ),
            'Sender Address - Line 1' => array(
                'type' => 'text',
                'default' => 'Mandatory - num and street',
                'desc' => __( 'Web Service - Sender Address - Mandatory num and street', 'colissimo-delivery-integration' ),
                'id'   => 'wc_settings_tab_colissimo_ws_sa_Line1'
            ),
            'Sender Address - Line 2' => array(
                'type' => 'text',
                'default' => 'Optionnal - other infos',
                'desc' => __( 'Web Service - Sender Address - Optionnal other infos', 'colissimo-delivery-integration' ),
                'id'   => 'wc_settings_tab_colissimo_ws_sa_Line2'
            ),
            'Sender Address - ZipCode' => array(
                'type' => 'text',
                'custom_attributes' => array (
                  'pattern' => '[0-9]{5,5}',
                  ),
                'default' => '75001',
                'desc' => __( 'Web Service - Sender Address - ZipCode', 'colissimo-delivery-integration' ),
                'id'   => 'wc_settings_tab_colissimo_ws_sa_ZipCode'
            ),
            'Sender Address - City' => array(
                'type' => 'text',
                'default' => 'PARIS',
                'desc' => __( 'Web Service - Sender Address - City', 'colissimo-delivery-integration' ),
                'id'   => 'wc_settings_tab_colissimo_ws_sa_City'
            ),
            'Sender Address - Country Code' => array(
                'type' => 'single_select_country',
                'default' => 'FR',
                'desc' => __( 'Web Service - Sender Address - Country Code', 'colissimo-delivery-integration' ),
                'id'   => 'wc_settings_tab_colissimo_ws_sa_CountryCode'
            ),
            'Sender Address - Email' => array(
                'type' => 'email',
                'default' => 'a@b.fr',
                'desc' => __( 'Web Service - Sender Address - Email', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Your email address as sender of the parcel.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_ws_sa_Email'
            ),
            'France Country Codes' => array(
                'name' => __( 'France Zone', 'colissimo-delivery-integration' ),
                'type' => 'text',
                'css'  => 'width:50%; color:red;',
                'default' => wc_settings_tab_colissimo_ws_FranceCountryCodes,
                'desc' => __( 'ISO country codes for Colissimo France zone', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "This defines 1- the list of ISO country codes for Colissimo France zone, and 2- the Colissimo product codes with France as destination, for the services : without signature, with signature, pickup location. Theses codes are used only if no product code is set in the order meta box.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_ws_FranceCountryCodes'
            ),
            'France Product Codes' => array(
                'type' => 'text',
                'css'  => 'width:20%; margin-left:30%; color:red;',
                'default' => wc_settings_tab_colissimo_ws_FranceProductCodes,
                'desc' => __( 'Product Codes for France zone', 'colissimo-delivery-integration' ),
                'id'   => 'wc_settings_tab_colissimo_ws_FranceProductCodes'
            ),
            'Outre-mer Country Codes' => array(
                'name' => __( 'Outre-mer Zone', 'colissimo-delivery-integration' ),
                'type' => 'text',
                'css'  => 'width:50%; color:red;',
                'default' => wc_settings_tab_colissimo_ws_OutreMerCountryCodes,
                'desc' => __( 'ISO country codes for Colissimo Outre-mer zone', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "This defines 1- the list of ISO country codes for Colissimo Outre-mer zone, and 2- the Colissimo product codes with Outre Mer as destination, for the services : without signature, with signature, pickup location. Theses codes are used only if no product code is set in the order meta box.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_ws_OutreMerCountryCodes'
            ),
            'Outre Mer Product Codes' => array(
                'type' => 'text',
                'css'  => 'width:20%; margin-left:30%; color:red;',
                'default' => wc_settings_tab_colissimo_ws_OutreMerProductCodes,
                'desc' => __( 'Product Codes for Outre-mer zone', 'colissimo-delivery-integration' ),
                'id'   => 'wc_settings_tab_colissimo_ws_OutreMerProductCodes'
            ),
            'Europe Country Codes' => array(
                'name' => __( 'Europe Zone', 'colissimo-delivery-integration' ),
                'type' => 'text',
                'css'  => 'width:50%; color:red;',
                'default' => wc_settings_tab_colissimo_ws_EuropeCountryCodes,
                'desc' => __( 'ISO country codes for Colissimo Europe zone', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "This defines 1- the list of ISO country codes for Colissimo Europe zone, and 2- the Colissimo product codes with Europe as destination, for the services : without signature, with signature, pickup location. Theses codes are used only if no product code is set in the order meta box.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_ws_EuropeCountryCodes'
            ),
            'Europe Product Codes' => array(
                'type' => 'text',
                'css'  => 'width:20%; margin-left:30%; color:red;',
                'default' => wc_settings_tab_colissimo_ws_EuropeProductCodes,
                'desc' => __( 'Product Codes for Europe zone', 'colissimo-delivery-integration' ),
                'id'   => 'wc_settings_tab_colissimo_ws_EuropeProductCodes'
            ),
            'International Country Codes' => array(
                'name' => __( 'International Zone', 'colissimo-delivery-integration' ),
                'type' => 'text',
                'css'  => 'width:50%; color:red;',
                'default' => wc_settings_tab_colissimo_ws_InternationalCountryCodes,
                'desc' => __( 'ISO country codes for Colissimo International zone', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "This defines 1- the list of ISO country codes for Colissimo International zone, and 2- the Colissimo product codes with International as destination, for the services : without signature, with signature, pickup location. Theses codes are used only if no product code is set in the order meta box.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_ws_InternationalCountryCodes'
            ),
            'International Product Codes' => array(
                'type' => 'text',
                'css'  => 'width:20%; margin-left:30%; color:red;',
                'default' => wc_settings_tab_colissimo_ws_InternationalProductCodes,
                'desc' => __( 'Product Codes for International zone', 'colissimo-delivery-integration' ),
                'id'   => 'wc_settings_tab_colissimo_ws_InternationalProductCodes'
            ),
            'Exception Product Codes' => array(
                'name' => __( 'Exception product codes', 'colissimo-delivery-integration' ),
                'type' => 'text',
                'css'  => 'color:red;',
                'default' => wc_settings_tab_colissimo_ws_ExceptionProductCodes,
                'desc' => __( 'Web Service - Comma separated list of "code_to_replace=new_code_to_use" just before the call of Colissimo WS (ex DOM=COLD,DOS=COL)', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "This defines Colissimo product codes in exception which have to be replace just before the call of Colissimo Web Service. Generally speaking, the choice of a product code is done in this order : 1) the code for a shipping method as defined in referal, 2) the code given by Colissimo for a pickup location, 3) the code manually forced in meta box order, 4) optionnally if still null in meta box, the code defines in settings for France, Outre mer, International, 5) and finally the exception code rule which has the greatest priority. ", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_ws_ExceptionProductCodes'
            ),
            'section_end' => array(
                 'type' => 'sectionend',
                 'id' => 'wc_settings_tab_colissimo_section_automatic_end'
            )
        );
    }

//  Get the settings of Section referrals
    public static function get_settings_section_referrals() {
        $return = array(
            'section_title' => array(
                'name'     => __( 'Colissimo Delivery Integration - Referrals to shipping methods', 'colissimo-delivery-integration' ),
                'type'     => 'title',
                'desc'     => '',
                'id'       => 'wc_settings_tab_colissimo_section_referrals'
            ),
            'Method Referal' => array(
                'type' => 'checkbox',
                'default' => 'yes',
                'desc' => __( 'Global enable of referrals to shipping method.', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Shipping method referrals enables to set 3 qualifications to shipping methods presented to customer : - shipping methods for which the Pickup locations function must be activate, - the Colissimo product codes to associate to shipping methods, - shipping methods which are exclusive.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_methodreferal'
            ) ,
            'pickup_method_name' => array(
                'name' => __( 'Pickup locations', 'colissimo-delivery-integration' ),
                'type' => 'text',
                'css'  => 'width:70%;',
                'default' => 'colissimo_shippingzone_method_pick1=1, colissimo_shippingzone_method_pick2=0,',
                'desc' => __( 'Optional - Comma separated list of "Shipping-Method-names = filter-relay" which activate the Colissimo pickup location choice process. Filter-relay = 0 or 1 to define type of Colissimo list. May be methods of Colissimo shipping or external methods. Selection may focus on a specific instance as "flat_rate:25=1" ', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Here, define the shipping methods for which the Pickup locations function must be activate. They must be shipping zone methods (WC >=2.6)", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_pickupmethodnames'
            ) ,
            'International pickup location - Country Codes' => array(
                'type' => 'text',
                'css'  => 'color:red;',
                'default' => wc_settings_tab_colissimo_ws_InternationalPickupLocationContryCodes,
                'desc' => __( 'Pickup location country codes (excluding X00 network)', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "This defines the list of destination countries for which Colissimo runs its pickup location service.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_ws_InternationalPickupLocationContryCodes'
            ),
            'Pickup location map open' => array(
                'type' => 'checkbox',
                'default' => 'yes',
                'desc' => __( 'Pickup location map shown open at entry of selected method.', 'colissimo-delivery-integration' ),
                'id'   => 'wc_settings_tab_colissimo_mapopen'
            ) ,
            'Pickup location map refresh' => array(
                'type' => 'checkbox',
                'default' => 'no',
                'desc' => __( 'Map periodic refresh for themes with multi views in woocommerce checkout page (to use only when necessary).', 'colissimo-delivery-integration' ),
                'id'   => 'wc_settings_tab_colissimo_maprefresh'
            ) ,
        );
        if (WC_function_Colissimo::cdi_isconnected()) {
          eval (WC_function_Colissimo::cdi_eval('7')) ;
          $returnext =  array(
            'Pickup location mode selectclickonmap' => array(
                'type' => 'checkbox',
                'default' => 'no',
                'desc' => __( 'Pickup location mode to select location by click on map. Warning, this option may not work with some themes and plugins.', 'colissimo-delivery-integration' ),
                'id'   => 'wc_settings_tab_colissimo_selectclickonmap'
            ) ,
            'Pickup location mode wheremustbeemap' => array(
                'type' => 'select',
                'options' => array (
                  'insertBefore( jQuery( ".shop_table" ) )' => __('Before shop box', 'colissimo-delivery-integration'),
                  'insertAfter( jQuery( ".shop_table" ) )'  => __('After shop box', 'colissimo-delivery-integration'),
                  'insertBefore( jQuery( "#payment" ) )' => __('Before payment', 'colissimo-delivery-integration'),
                  'insertAfter( jQuery( "#payment" ) )'  => __('After payment', 'colissimo-delivery-integration'),
                  'insertBefore( jQuery( "#order_review" ) )' => __('Before order review', 'colissimo-delivery-integration'),
                  'insertAfter( jQuery( "#order_review" ) )'  => __('After order review', 'colissimo-delivery-integration'),

                  ),
                'default' => 'Before shop box',
                'desc' => __( 'Pickup location to choose where must be map in checkout page. Warning, this option may not work with some themes and plugins.', 'colissimo-delivery-integration' ),
                'id'   => 'wc_settings_tab_colissimo_wheremustbeemap'
            ) ,
          ) ;
          eval (WC_function_Colissimo::cdi_eval('13')) ;
          eval (WC_function_Colissimo::cdi_eval('12')) ;
        }
        return array_merge ($return , array(
            'googlemap api key' => array(
                'type' => 'text',
                'css'  => 'width:70%;',
                'default' => '',
                'desc' => __( 'Optional - Google maps API key', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Here, set your Google maps API key. Without a key, you will have a restricted use of Google maps.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_googlemapsapikey'
            ) ,
           'forced_product_code' => array(
                'name' => __( 'Associated product codes', 'colissimo-delivery-integration' ),
                'type' => 'text',
                'css'  => 'width:70%;',
                'default' => '',
                'desc' => __( 'Optional - Comma separated list of relations "Method-name = Colissimo-product-code" to be use for Colissimo. May be methods of Colissimo shipping or external methods.', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Here, define the Colissimo product codes to associate to shipping methods.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_forcedproductcodes'
            ) ,
           'Exclusive Shipping Method' => array(
                'name' => __( 'Exclusive shipping methods', 'colissimo-delivery-integration' ),
                'type' => 'text',
                'css'  => 'width:70%;',
                'desc' => __( 'Optional - Comma separated list of shipping method names which are exclusive of others. The priority is given to the first method matching in the original woocommerce package list. May be methods of Colissimo shipping or external methods. Ex: "colissimo_shippingzone_method_home5, free_shipping"', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Here, define the shipping methods which are exclusive (i.e. which will be alone when presented to customer).", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_exclusiveshippingmethod'
            ) ,
            'section_end' => array(
                 'type' => 'sectionend',
                 'id' => 'wc_settings_tab_colissimo_section_referrals_end'
            )
        ) ) ;
    }


//  Get the settings of Section shipping
    public static function get_settings_section_shipping() {
        $return = array(
            'section_title' => array(
                'name'     => __( 'Colissimo Delivery Integration - Colissimo method global settings', 'colissimo-delivery-integration' ),
                'type'     => 'title',
                'desc'     => '',
                'id'       => 'wc_settings_tab_colissimo_section_shipping'
            ),
            'Shipping Method' => array(
                'type' => 'checkbox',
                'default' => 'yes',
                'desc' => __( 'Global enabling of Colissimo shipping method (Shipping zone mode)', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "You must have installed WooCommerce 2.6 or further to run this shipping method.  Details of settings must be done in each methods [WooCommerce -> Settings -> Shipping].", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_methodshipping'
            ) ,
            'Icon Shipping Method' => array(
                'type' => 'checkbox',
                'default' => 'yes',
                'desc' => __( 'Set shipping method icons in front end.', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Customization of icons are to do in plugin images directory (refer to examples for size and type) or trought a filter to keep the images in your own directory.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_methodshippingicon'
            )
        );
        if (WC_function_Colissimo::cdi_isconnected()) {
          eval (WC_function_Colissimo::cdi_eval('7')) ;
          $returnext =  array(
              'Extend Termid Shipping Method' => array(
                'name' => __( 'Extend Termid list', 'colissimo-delivery-integration' ),
                'type' => 'text',
                'css'  => 'width:70%;',
                'desc' => __( 'Optional - Comma separated list of shipping method Termid which will be added to the standard list. Ex: "home6, home7, shop6, autre1, autre2"', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Here, extend the shipping methods Termid for your special customization.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_methodshipping_extendtermid'
              ) 
          ) ;
          eval (WC_function_Colissimo::cdi_eval('13')) ;
          eval (WC_function_Colissimo::cdi_eval('12')) ;
        }
        return array_merge ($return , array(
              'section_end' => array(
                 'type' => 'sectionend',
                 'id' => 'wc_settings_tab_colissimo_section_shipping_end'
              )
         ) ) ;
    }

//  Get the settings of Parcels Return
    public static function get_settings_section_parcelreturn() {
        return array(
            'section_title' => array(
                'name'     => __( 'Colissimo Delivery Integration - Parcel return settings', 'colissimo-delivery-integration' ),
                'type'     => 'title',
                'desc'     => '',
                'id'       => 'wc_settings_tab_colissimo_section_parcelreturn'
            ),
            'Parcels return' => array(
                'type' => 'checkbox',
                'default' => 'no',
                'desc' => __( 'Global enabling of Colissimo parcel return function.', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Logged customers will have the capacity, from their order view, to create and print a Colissimo return label. This feature requires a Bussiness contract with Colissimo to access the Web Service Affranchissement.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_parcelreturn'
            ) ,
            'Text preceding parcel return request' => array(
                'type' => 'text',
                'css'  => 'width:70%;',
                'default' => __( 'In case you need to return your parcel, request for a  printable Colissimo return label : ', 'colissimo-delivery-integration' ),
                'desc' => __( 'Text preceding customer parcel return label request in their order view', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Here, the text your customer will see in its order view to invite him to post a request to get a parcel return label. These information will be seen by the customer only if it is inside the authorized period defined below.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_text_preceding_parcelreturn'
            ),
            'Text preceding parcel return print' => array(
                'type' => 'text',
                'css'  => 'width:70%;',
                'default' => __( 'Your Colissimo return label is available. Paste it on your parcel. After printing, you can choose the type of postal deposit you want at :', 'colissimo-delivery-integration' ),
                'desc' => __( 'Text accompanying the parcel return label print button', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Here, the text your customer will see to invite him to print its parcel return label.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_text_preceding_printreturn'
            ),
            'Url following text parcel return print' => array(
                'type' => 'text',
                'css'  => 'width:70%;',
                'default' => 'https://www.colissimo.fr/retourbal/index.htm', 'colissimo-delivery-integration',
                'desc' => __( 'Url following the text parcel return print (when necessary)', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Here, when necessary, the url your need to follow the parcel return print text. When blank, no url will be shown", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_url_following_printreturn'
            ),
            'Tracking code headers' => array(
                'type' => 'text',
                'css'  => 'width:70%; color:red;',
                'default' => wc_settings_tab_colissimo_trackingheaders_parcelreturn,
                'desc' => __( 'Comma separated list of 2 digits headers of Colissimo tracking codes allowed for a customer parcel return label request.', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Here, the list of Colissimo tracking codes headers (2 digits) which are allowed for a customer parcel return label request. The  standard list can be updated for future new Colissimo products.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_trackingheaders_parcelreturn'
            ),
           'Return_product_code' => array(
                'type' => 'text',
                'css'  => 'width:70%; color:red;',
                'default' => wc_settings_tab_colissimo_returnproduct_code,
                'desc' => __( 'Semicolon separated list of relations "Return-product-code=ISO-countrycode list" to be use for parcel returns.', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Here, define the Colissimo return product codes and associated countries.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_returnproduct_code'
            ) ,
            'Nb day parcel return' => array(
                'type' => 'number',
                'default' => '+14',
                'desc' => __( 'Number of day after the order creation date+time during whitch a customer parcel return label request is permitted. Setting this number to 0 will allowed customers to use this function only on a case by case basis after the admin has changed this value for the order in the Colissimo metabox.', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Here, the number of days you allow to your customer to retrieve and print a return parcel label. This number must not be confused which the validity period Colissimo give for a label to be deposit. The default 14 days correspond to the European regulation e-commerce for returns if you offer this facility to your customers.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_nbdayparcelreturn'
            ),
            'Return Parcel Service' => array(
                'type' => 'text',
                'default' => 'Service des retours',
                'desc' => __( 'Name of the Company service to whitch the parcels must be returned', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Here, the name of the service in your company that must receice the returned parcel. The rest of the return address is the sender address you set in Web Service Affranchissement settings.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_returnparcelservice'
            ),
            'section_end' => array(
                 'type' => 'sectionend',
                 'id' => 'wc_settings_tab_colissimo_section_parcelreturn_end'
            )
        );
    }

//  Get the settings of Section printlabel
    public static function get_settings_section_printlabel() {
        return array(
            'section_title' => array(
                'name'     => __( 'Colissimo Delivery Integration - Printing of address labels', 'colissimo-delivery-integration' ),
                'type'     => 'title',
                'desc'     => '',
                'id'       => 'wc_settings_tab_colissimo_section_printlabel'
            ),
            'Page size' => array(
                'type' => 'text',
                'default' => '210x297',
                'desc' => __( 'Page size width x height in mm', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Here the size of the page in your printer. Syntax = width x height in mm (ex 210x297 for a portrait A4 format).", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_pagesize'
            ),
            'Labels layout' => array(
                'type' => 'text',
                'default' => '3x5',
                'desc' => __( 'Layout of labels in the page: width  x height', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Here, the layout of the labels in the page: nb-in-width x nb-in-height (ex 3x5 which will give a total of 15 labels in the page).", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_labellayout'
            ),
            'Address show size' => array(
                'type' => 'text',
                'default' => '80%',
                'desc' => __( 'Width of the viewing area of the address: in %', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Here, the width of the display area of the address on the label, expressed in % of the width of the label (ex 80%).", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_addresswidth'
            ),
            'Font size' => array(
                'type' => 'text',
                'default' => '12px',
                'desc' => __( 'Address font size : in css unit', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Here, the address font size in css unit (ex 12px).", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_fontsize'
            ),
            'Start rank' => array(
                'type' => 'number',
                'default' => '+1',
                'desc' => __( 'Position of the first label to be printed.', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Here, the position of the first label to be printed. This number must be between 1 and the total number of labels in the page.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_startrank'
            ),
            'Start rank manage' => array(
                'type' => 'select',
                'default' => 'fix',
                'options' => array (
                  'fix'     => 'fix',
                  'forward' => 'forward',
                  ),
                'desc' => __( 'Mode for managing the position of the first label', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Here, the mode of management of the position of the 1st label. fix to always start at the same location in the pages; forward to automatically advance the position and thus allow to use all the labels of the pages.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_managerank'
            ),
            'Test grid' => array(
                'type' => 'checkbox',
                'default' => 'yes',
                'desc' => __( 'Test grid mode to help the setting of the printer', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Here, the test grid mode is used to assist in the setting of the printer. In this mode, the positions of the labels are delimited by a grid.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_testgrid'
            ) ,
            'Css page layout' => array(
                'type' => 'textarea',
                'css'  => 'width:70%; height:4em;',
                'default' => 'padding: 0 !important; margin-top: 5mm !important; height:96% !important; margin-left: 12mm !important; width:99% !important;',
                'desc' => __( 'Area specifying the layout in the sheet, in css code', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Here, the zone specifying the layout in the sheet, in css code (Ex: padding: 0 !important; margin-top: 5mm !important; height:96% !important; margin-left: 12mm !important; width:99% !important;).", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_miseenpage'
            ),
            'Custom css' => array(
                'type' => 'textarea',
                'css'  => 'width:70%; height:10em;',
                'default' => '',
                'desc' => __( 'Zone specifying formatting of addresses, in css  code', 'colissimo-delivery-integration' ),
                'desc_tip' => __( "Here, the area specifying the formatting of the addresses, in css code.", "colissimo-delivery-integration" ),
                'id'   => 'wc_settings_tab_colissimo_customcss'
            ),
            'section_end' => array(
                 'type' => 'sectionend',
                 'id' => 'wc_settings_tab_colissimo_section_printlabel_end'
            )
        );
    }

}
?>
