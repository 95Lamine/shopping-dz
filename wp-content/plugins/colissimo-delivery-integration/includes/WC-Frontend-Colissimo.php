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
class WC_Frontend_Colissimo {
    public static function init() {
        add_action( 'woocommerce_view_order',  __CLASS__ . '::cdi_display_tracking_view' ); 
        add_action( 'woocommerce_email_after_order_table',  __CLASS__ . '::cdi_woocommerce_email_after_order_table', 101, 4);
        add_filter( 'woocommerce_checkout_fields' ,   __CLASS__ . '::cdi_override_checkout_fields' );
        add_filter( 'woocommerce_default_address_fields' ,   __CLASS__ . '::cdi_override_default_address_fields' );
        add_action( 'wp_footer',   __CLASS__ . '::cdi_limit_lenght_address',100);
        add_filter( 'woocommerce_my_account_my_address_formatted_address',   __CLASS__ . '::cdi_woocommerce_my_account_my_address_formatted_address', 2, 3);
        add_filter( 'woocommerce_formatted_address_replacements',   __CLASS__ . '::cdi_woocommerce_formatted_address_replacements', 10, 2);
        add_filter( 'woocommerce_localisation_address_formats',   __CLASS__ . '::cdi_woocommerce_localisation_address_formats');
        add_filter( 'woocommerce_order_formatted_billing_address',   __CLASS__ . '::cdi_woocommerce_order_formatted_billing_address', 10, 2);
        add_filter( 'woocommerce_order_formatted_shipping_address',   __CLASS__ . '::cdi_woocommerce_order_formatted_shipping_address', 10, 2);
        add_filter( 'woocommerce_admin_billing_fields',   __CLASS__ . '::cdi_woocommerce_admin_billing_fields');
        add_filter( 'woocommerce_admin_shipping_fields',   __CLASS__ . '::cdi_woocommerce_admin_shipping_fields');
        add_filter( 'woocommerce_get_order_address',   __CLASS__ . '::cdi_woocommerce_get_order_address', 10, 3);
    }

    // Insert tracking code in customer order views
    public static function cdi_display_tracking_view ($id_order) {
      $statusinsert = get_option('wc_settings_tab_colissimo_inserttrackingcode');
      if ($statusinsert == 'order-views' or $statusinsert == 'emails and order-views'  ) {
        $trackingcode = get_post_meta( $id_order , '_cdi_meta_tracking', true );
        WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $id_order . ' - ' . $trackingcode);
        if ( !empty($trackingcode) ) {
          $txt =  __(get_option('wc_settings_tab_colissimo_text_preceding_trackingcode'), 'colissimo-delivery-integration') ; 
          $url = get_option('wc_settings_tab_colissimo_url_trackingcode');
          $url = str_replace( 'href="', '', $url); // Because backward compatibility 
          echo '<div id="cditrackingcodeorderview"><p>' . $txt . ' ' . '<a ' . 'href="' . $url . $trackingcode . '" onclick="window.open(this.href); return false;" > ' . $trackingcode .'</a> </p></div>';
        }
        $pickupLocationlabel = get_post_meta( $id_order , '_cdi_meta_pickupLocationlabel', true );
        if ($pickupLocationlabel) {
          $pickupLocationlabel = stristr($pickupLocationlabel, "=> Distance: ", true);
          echo '<div id="cdipickupLocationlabel"><p>' . __('Pickup location : ', 'colissimo-delivery-integration') . $pickupLocationlabel .'</p></div>';
        }
      }
    }
    // Insert tracking code in emails
    public static function cdi_woocommerce_email_after_order_table ($order, $sent_to_admin, $plain_text, $email) {
      $statusinsert = get_option('wc_settings_tab_colissimo_inserttrackingcode');
      if ($statusinsert == 'emails' or $statusinsert == 'emails and order-views'  ) {
        if (function_exists('wc_sequential_order_numbers')) {
          $id_order = wc_sequential_order_numbers()->find_order_by_order_number( $order->get_order_number() );
        }elseif (function_exists('wc_seq_order_number_pro')){
          $id_order = wc_seq_order_number_pro()->find_order_by_order_number( $order->get_order_number() );
        }else{
           $id_order = $order->get_order_number() ;
        }
        $id_order = str_replace( 'n°', '', $id_order);
        $id_order = str_replace( '#', '', $id_order );
        $trackingcode = get_post_meta( $id_order , '_cdi_meta_tracking', true );
        WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $id_order . ' - ' . $trackingcode);
        if ( !empty($trackingcode) ) {
          $txt =  __(get_option('wc_settings_tab_colissimo_text_preceding_trackingcode'), 'colissimo-delivery-integration') ; 
          $url = get_option('wc_settings_tab_colissimo_url_trackingcode'); 
          $url = str_replace( 'href="', '', $url); // Because backward compatibility
          $html = '<div id="cditrackingcodeemail"><p>' . $txt . ' ' . '<a ' . 'href="' . $url . $trackingcode . '" onclick="window.open(this.href); return false;" > ' . $trackingcode .'</a> </p></div>';
          echo $html ;
        }
        $pickupLocationlabel = get_post_meta( $id_order , '_cdi_meta_pickupLocationlabel', true );
        if ($pickupLocationlabel) {
          $pickupLocationlabel = stristr($pickupLocationlabel, "=> Distance: ", true);
          $html = '<div id="cdipickupLocationlabel"><p>' . __('Pickup location : ', 'colissimo-delivery-integration') . $pickupLocationlabel .'</p></div>';
          echo $html ;
        }
      }
    }
    // checkout control
    public static function cdi_override_checkout_fields ($fields) {
      if ('yes' == get_option('wc_settings_tab_colissimo_extentedaddress') && WC_function_Colissimo::cdi_isconnected()) {
        eval (WC_function_Colissimo::cdi_eval('7')) ;
        $fields['order']['order_comments']['placeholder'] = __('Notes on your order, eg special notes for color, size, ...', 'colissimo-delivery-integration');
        eval (WC_function_Colissimo::cdi_eval('12')) ;
      }
      return $fields;
    }
    public static function cdi_limit_lenght_address() {
      if ('yes' == get_option('wc_settings_tab_colissimo_extentedaddress') && WC_function_Colissimo::cdi_isconnected()) {
        eval (WC_function_Colissimo::cdi_eval('7')) ;
        ?><script>
          jQuery(document).ready(function($){
            $("#billing_address_1").attr('maxlength','35');
            $("#billing_address_2").attr('maxlength','35');
            $("#billing_address_3").attr('maxlength','35');
            $("#billing_address_4").attr('maxlength','35');
            $("#shipping_address_1").attr('maxlength','35');
            $("#shipping_address_2").attr('maxlength','35');
            $("#shipping_address_3").attr('maxlength','35');
            $("#shipping_address_4").attr('maxlength','35');
          });
        </script><?php
        eval (WC_function_Colissimo::cdi_eval('12')) ;
      }
    }
    public static function cdi_override_default_address_fields ($fields) {
      if ('yes' == get_option('wc_settings_tab_colissimo_extentedaddress') && WC_function_Colissimo::cdi_isconnected()) {
        eval (WC_function_Colissimo::cdi_eval('7')) ;
        $fields['address_1']['placeholder'] = __('(*) House number + Name of the way (street, avenue, ...)', 'colissimo-delivery-integration');
        $fields['address_2']['placeholder'] = __('Entrance - Block - Building - Residence', 'colissimo-delivery-integration');
        $fields['address_3']['placeholder'] = __('Apartment or letter box number - Floor - Corridor - Staircase', 'colissimo-delivery-integration');
          $fields['address_3']['class'] = array ('form-row-wide', 'address-field');
          $fields['address_3']['required'] = null;
          $fields['address_3']['autocomplete'] = 'address-line3';
          $fields['address_3']['priority'] = 61;
        $fields['address_4']['placeholder'] = __('Postal box - Place called', 'colissimo-delivery-integration');
          $fields['address_4']['class'] = array ('form-row-wide', 'address-field');
          $fields['address_4']['required'] = null;
          $fields['address_4']['autocomplete'] = 'address-line4';
          $fields['address_4']['priority'] = 62;
        eval (WC_function_Colissimo::cdi_eval('12')) ;
      }
      return $fields;
    }
    public static function cdi_woocommerce_my_account_my_address_formatted_address ($address, $customer_id, $name) {
      if ('yes' == get_option('wc_settings_tab_colissimo_extentedaddress') && WC_function_Colissimo::cdi_isconnected()) {
        $address['address_3'] = get_user_meta( $customer_id,  $name . '_address_3', true ) ;
        $address['address_4'] = get_user_meta( $customer_id,  $name . '_address_4', true ) ;
      }
      return $address;
    }
    public static function cdi_woocommerce_formatted_address_replacements ($items, $args) {
      if ('yes' == get_option('wc_settings_tab_colissimo_extentedaddress') && WC_function_Colissimo::cdi_isconnected()) {
        eval (WC_function_Colissimo::cdi_eval('7')) ;
        if (isset($args['address_3']) ) {
          $items['{address_3}'] = $args['address_3'] ;
          $items['{address_3_upper}'] = $args['address_3'] ;
        }
        if (isset($args['address_4']) ) {
          $items['{address_4}'] = $args['address_4'] ;
          $items['{address_4_upper}'] = $args['address_4'] ;
        }
        eval (WC_function_Colissimo::cdi_eval('12')) ;
      }
      return $items ;
    }
    public static function cdi_woocommerce_localisation_address_formats ($formats) {
      if ('yes' == get_option('wc_settings_tab_colissimo_extentedaddress') && WC_function_Colissimo::cdi_isconnected()) {
        eval (WC_function_Colissimo::cdi_eval('7')) ;
        $return = array() ;
        foreach ($formats as $key => $format) {
          $return[$key] = str_replace("{address_2}", "{address_2}\n{address_3}\n{address_4}", $format) ; 
        }
        eval (WC_function_Colissimo::cdi_eval('12')) ;
        return $return ;
      }
      return $formats ;
    }
    public static function cdi_woocommerce_order_formatted_billing_address($address, $order) {
      if ('yes' == get_option('wc_settings_tab_colissimo_extentedaddress') && WC_function_Colissimo::cdi_isconnected()) {
        eval (WC_function_Colissimo::cdi_eval('14')) ;
        $address['address_3'] = get_post_meta($id,'_billing_address_3',true);
        $address['address_4'] = get_post_meta($id,'_billing_address_4',true);
      }
      return $address;
    }
    public static function cdi_woocommerce_order_formatted_shipping_address($address, $order) {
      if ('yes' == get_option('wc_settings_tab_colissimo_extentedaddress') && WC_function_Colissimo::cdi_isconnected()) {
        eval (WC_function_Colissimo::cdi_eval('14')) ;
        $address['address_3'] = get_post_meta($id,'_shipping_address_3',true);
        $address['address_4'] = get_post_meta($id,'_shipping_address_4',true);
      }
      return $address;
    }
    public static function cdi_woocommerce_get_order_address($items, $type, $third ) {
      if ('yes' == get_option('wc_settings_tab_colissimo_extentedaddress') && WC_function_Colissimo::cdi_isconnected()) {
        if ($type == 'shipping') {
          $return = array_merge( array(
			'first_name' => '',
			'last_name'  => '',
			'company'    => '',
			'address_1'  => '',
			'address_2'  => '',
			'address_3'  => '',
			'address_4'  => '',
			'city'       => '',
			'state'      => '',
			'postcode'   => '',
			'country'    => ''),
                    $items) ;
        }else{
          $return = array_merge( array(
			'first_name' => '',
			'last_name'  => '',
			'company'    => '',
			'address_1'  => '',
			'address_2'  => '',
			'address_3'  => '',
			'address_4'  => '',
			'city'       => '',
			'state'      => '',
			'postcode'   => '',
			'country'    => '',
			'email'      => '',
			'phone'      => '',),
                    $items) ;
        }
        return $return;
      }
      return $items;
    }
    public static function cdi_woocommerce_admin_billing_fields($billing_fields) {
      if ('yes' == get_option('wc_settings_tab_colissimo_extentedaddress') && WC_function_Colissimo::cdi_isconnected()) {
        $return = array() ;
        foreach ($billing_fields as $key => $field) {
          $return[$key] = $field ; 
          if ($key == 'address_2') {
            $return['address_3'] = array( 'label' => __( 'Address line 3', 'woocommerce' ), 'show'  => false, ) ; 
            $return['address_4'] = array( 'label' => __( 'Address line 4', 'woocommerce' ), 'show'  => false, ) ; 
          }
        }
        return $return;
      }
      return $billing_fields;
    }
    public static function cdi_woocommerce_admin_shipping_fields($shipping_fields) {
      if ('yes' == get_option('wc_settings_tab_colissimo_extentedaddress') && WC_function_Colissimo::cdi_isconnected()) {
        $return = array() ;
        foreach ($shipping_fields as $key => $field) {
          $return[$key] = $field ; 
          if ($key == 'address_2') {
            $return['address_3'] = array( 'label' => __( 'Address line 3', 'woocommerce' ), 'show'  => false, ) ; 
            $return['address_4'] = array( 'label' => __( 'Address line 4', 'woocommerce' ), 'show'  => false, ) ; 
          }
        }
        return $return;
      }
      return $shipping_fields;
    }


}
?>
