<?PHP

/**
 * This file is part of the Colissimo Delivery Integration plugin.
 * (c) Harasse
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if (!defined('ABSPATH')) exit;
/******************************************************************************************************/
/* Functions and Controls : the shipment tracking code is present when status become completed        */
/******************************************************************************************************/
class WC_function_Colissimo {
   // ***************************************************************************************************
    public static function init() {
        add_action( 'woocommerce_order_status_changed',  __CLASS__ . '::cdi_change_status_tocomplete', 10, 3 );
        add_action( 'admin_notices',  __CLASS__ . '::cdi_admin_notice');
        add_action( 'before_delete_post',  __CLASS__ . '::cdi_delete_order');
    }
   // ***************************************************************************************************
    public static function cdi_change_status_tocomplete($order_id,  $old_status, $new_status) {
        if ($old_status == 'processing' && $new_status == 'completed') {
          if( !get_post_meta( !$order_id, 'cdi_colis_status', true ) && !get_post_meta( $order_id, 'Colissimo', true )) {
            $message = __('Your last order(s) completed has no Colissimo tracking code. You can add a tracking code and send again order completed mail.', 'colissimo-delivery-integration') ;
            update_option( 'cdi_notice_display', $message );
          }
        }
    }
   // ***************************************************************************************************
    public static function cdi_admin_notice() {
      $cdi_notice_display = get_option( 'cdi_notice_display') ;
      if ($cdi_notice_display !== 'nothing'){
        echo '<div class="updated notice"><p>';
        echo $cdi_notice_display ;
        echo "</p></div>";
        update_option( 'cdi_notice_display', 'nothing' );
      }else{
        add_option('cdi_notice_display', 'nothing');
      }
    }
   // ***************************************************************************************************
    public static function cdi_delete_order($idorder) {
      // Automatic clean of cdistore when an order is suppress
      if (get_post_type($idorder) !== 'shop_order') {
	return false;
      }
      $upload_dir = wp_upload_dir();
      $dircdistore = trailingslashit($upload_dir['basedir']).'cdistore';
      $url = wp_nonce_url('plugins.php?page=colissimo-delivery-integration');
      if (false === ($creds = request_filesystem_credentials($url, "", false, false, null) ) ) {
        WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , 'error - request creds');
	return false;
      }
      if ( !WP_Filesystem($creds) ) {
        WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , 'error - creds not valid');
        return false;
      }
      global $wp_filesystem;
      if (!file_exists($dircdistore)) { 
        return false;
      }
      $filename = trailingslashit($dircdistore). 'CDI-' . 'label' . '-' . $idorder .'.txt';
      $result = $wp_filesystem->delete( $filename) ;
      $filename = trailingslashit($dircdistore). 'CDI-' . 'cn23' . '-' . $idorder .'.txt';
      $result = $wp_filesystem->delete( $filename) ;
      return true;
    }
   // ***************************************************************************************************
    public static function cdi_uploads_put_contents ($idorder, $type, $filecontent) {
      if ($type !== 'label' and $type !== 'cn23') {
	return false;
      }
      $upload_dir = wp_upload_dir();
      $dircdistore = trailingslashit($upload_dir['basedir']).'cdistore';
      $url = wp_nonce_url('plugins.php?page=colissimo-delivery-integration');
      if (false === ($creds = request_filesystem_credentials($url, "", false, false, null) ) ) {
        WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , 'error - request creds');
	return false;
      }
      if ( !WP_Filesystem($creds) ) {
        WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , 'error - creds not valid');
        return false;
      }
      global $wp_filesystem;
      if (!file_exists($dircdistore)) { // create cdistore dir if not exist
        if ( ! $wp_filesystem->mkdir($dircdistore) ) {
          WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , 'error - create dir');
          return false;
        }
      }
      $filename = trailingslashit($dircdistore). 'CDI-' . $type . '-' . $idorder .'.txt';
      $result = $wp_filesystem->delete( $filename) ; // if exist suppress before replace
      if ( ! $wp_filesystem->put_contents( $filename, $filecontent, FS_CHMOD_FILE) ) {
        WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , 'error - create file');
        return false;
      }
      add_post_meta($idorder, '_cdi_meta_exist_uploads_' . $type, true, true); // Indicate that file exists in cdistore
      return true;
    }
   // ***************************************************************************************************
    public static function cdi_uploads_get_contents ($idorder, $type) {
      if ($type !== 'label' and $type !== 'cn23') {
	return false;
      }
      $upload_dir = wp_upload_dir();
      $dircdistore = trailingslashit($upload_dir['basedir']).'cdistore';
      $url = wp_nonce_url('plugins.php?page=colissimo-delivery-integration');
      if (false === ($creds = request_filesystem_credentials($url, "", false, false, null) ) ) {
        WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , 'error - request creds');
	return false;
      }
      if ( !WP_Filesystem($creds) ) {
        WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , 'error - creds not valid');
        return false;
      }
      global $wp_filesystem;
      if (!file_exists($dircdistore)) { 
        WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , 'error - dir not exist');
        return false;
      }
      $filename = trailingslashit($dircdistore). 'CDI-' . $type . '-' . $idorder .'.txt';
      $filecontent = $wp_filesystem->get_contents( $filename) ;
      if ( ! $filecontent ) {
        WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , 'error - file get');
        return false;
      }
      return $filecontent;
    }
   // ***************************************************************************************************
    public static function cdi_cn23_country($country) {
      if ( !in_array ($country, array('DE', 'AT', 'BE', 'BG', 'CY', 'DK', 'ES', 'EE', 'FI', 'FR', 'GR', 'HU', 'IE', 'IT', 'LV', 'LT', 'LU', 'MT', 'NL', 'PL', 'PT', 'CZ', 'RO', 'GB', 'IE', 'SK', 'SI', 'SE'))) { 
        return true ;
      }else{
        return false ;
      }
    }
   // ***************************************************************************************************
    public static function cdi_choosereturn_country($country) {
      if ( !in_array ($country, array('US', 'AU', 'JP', 'DE', 'AT', 'BE', 'BG', 'CY', 'DK', 'ES', 'EE', 'FI', 'FR', 'GR', 'HU', 'IE', 'IT', 'LV', 'LT', 'LU', 'MT', 'NL', 'PL', 'PT', 'CZ', 'RO', 'GB', 'IE', 'SK', 'SI', 'SE'))) { 
        return true ;
      }else{
        return false ;
      }
    }
   // ***************************************************************************************************
    public static function cdi_colissimo_withoutsign_country($country) {
      if ( in_array ($country, array('FR', 'AD', 'MC', 'MQ', 'GP', 'RE', 'GF', 'YT', 'PM', 'MF', 'BL'))) { 
        return true ;
      }else{
        return false ;
      }
    }
   // ***************************************************************************************************
    public static function cdi_colissimo_outremer_country($country) {
      if ( in_array ($country, array('MQ', 'GP', 'RE', 'GF', 'YT', 'PM', 'MF', 'BL', 'NC', 'PF', 'TF', 'WF'))) { 
        return true ;
      }else{
        return false ;
      }
    }
   // ***************************************************************************************************
    public static function cdi_colissimo_outremer_country_ftd($country) {
      if ( in_array ($country, array('MQ', 'GP', 'RE', 'GF'))) { 
        return true ;
      }else{
        return false ;
      }
    }
   // ***************************************************************************************************
    public static function cdi_calc_totalnetweight($order) {
	  $order_id = cdiwc3::cdi_order_id($order);
	  $order = new WC_Order( $order_id );
	  $items = $order->get_items();
	  $total_weight = 0;
	  foreach( $items as $item ) {
                $item_metas = get_post_meta( $item['variation_id'] );
                if (!$item_metas) {$item_metas = get_post_meta( $item['product_id'] );}
		$weight = $item_metas['_weight']['0'];
		$quantity = $item['qty'];
                if (is_numeric($weight) && is_numeric($quantity)) {
		  $item_weight = ( $weight * $quantity );
                }else{
		  $item_weight = 0 ;
                }
		$total_weight += $item_weight;
	  }
          if (get_option( 'woocommerce_weight_unit' ) == 'kg') { // Convert kg to g
            $total_weight = $total_weight * 1000 ;
          }
          return $total_weight ;
    }
   // ***************************************************************************************************
    public static function cdi_cn23_calc_desc($order, $artnum=0) { 
	  $order_id = cdiwc3::cdi_order_id($order);
	  $order = new WC_Order( $order_id );
	  $items = $order->get_items();
          $rank = key($items) + $artnum;
          $item = $items[$rank];
          $artdesc = get_the_title($item['product_id']);
          return $artdesc ;
    }
   // ***************************************************************************************************
    public static function cdi_cn23_calc_artweight($order, $artnum=0) { 
	  $order_id = cdiwc3::cdi_order_id($order);
	  $order = new WC_Order( $order_id );
	  $items = $order->get_items();
          $rank = key($items) + $artnum;
          $item = $items[$rank];
          $item_metas = get_post_meta( $item['variation_id'] );
          if (!$item_metas) {$item_metas = get_post_meta( $item['product_id'] );}
          $artweight = $item_metas['_weight']['0'];
          if (get_option( 'woocommerce_weight_unit' ) == 'kg') { // Convert kg to g
            if (is_numeric($artweight)) {
              $artweight = $artweight * 1000 ;
            }else{
              $artweight = 0 ;
            }
          }
          return $artweight ;
    }
   // ***************************************************************************************************
    public static function cdi_cn23_get_hstariff($order, $artnum=0) { 
	  $order_id = cdiwc3::cdi_order_id($order);
	  $order = new WC_Order( $order_id );
	  $items = $order->get_items();
          $rank = key($items) + $artnum;
          $item = $items[$rank];
          $item_metas = get_post_meta( $item['variation_id'] );
          if (!$item_metas) {$item_metas = get_post_meta( $item['product_id'] );}
          if (!array_key_exists("hstariff",$item_metas)) {
            $hstariff = '' ;
          }else{
            $hstariff = $item_metas['hstariff']['0'];
          }
          return $hstariff ;
    }
   // ***************************************************************************************************
    public static function cdi_cn23_calc_artquantity($order, $artnum=0) {  
	  $order_id = cdiwc3::cdi_order_id($order);
	  $order = new WC_Order( $order_id );
	  $items = $order->get_items();
          $rank = key($items) + $artnum;
          $item = $items[$rank];
	  $artquantity = $item['qty'];
          return $artquantity ;
    }

   // ***************************************************************************************************
    public static function cdi_cn23_calc_artvalueht($order, $artnum=0) { 
          // Warning : exVAT price for product variation is not considered. Only exVAT parent product.
	  $order_id = cdiwc3::cdi_order_id($order); 
	  $order = new WC_Order( $order_id );
	  $items = $order->get_items();
          $rank = key($items) + $artnum;
          $item = $items[$rank];
	  $artquantity = $item['qty'];
	  $valueht = $item['line_subtotal'];
          $artvalueht = $valueht / $artquantity ;
          if ($artvalueht == 0 ) { // Case when value is 0
            $artvalueht = 0.01;
          }
          return $artvalueht ;
    }
   // ***************************************************************************************************
    public static function cdi_cn23_calc_shipping($order) { 
	  $order_id = cdiwc3::cdi_order_id($order);
	  $order = new WC_Order( $order_id );
	  $items = $order->get_items( 'shipping' );
	  $item = current($items);
	  $costshipping = $item['cost']; 
          return $costshipping ; // exVAT shipping cost returned
    }
   // ***************************************************************************************************
    public static function cdi_sanitize_laposte_voie($string) {
      $string =  sanitize_text_field( $string) ;
      $excludespecial = array('’', '(', '_', ')', '=', ';', ':', '!', '#', '{', '[', '|', '^', '@', ']', '}', 'µ', '?', '§', '*', '"', "'", ',' );
      $string = str_replace ($excludespecial, ' ', $string) ;
      return $string ;
    }
   // ***************************************************************************************************
    public static function cdi_sanitize_laposte_name($string) {
      $string =  sanitize_text_field( $string) ;
      $excludespecial = array('’', '(', '_', ')', '=', ';', ':', '!', '#', '{', '[', '|', '^', '@', ']', '}', 'µ', '?', '§', '*', '"', ',' );
      $string = str_replace ($excludespecial, '', $string) ;
      $excludespecial = array('.', '%', '/', '&' );
      $string = str_replace ($excludespecial, ' ', $string) ;
      return $string ;
    }
   // ***************************************************************************************************
    public static function cdi_sanitize_colissimo_enligne($string) {
      $excludespecial = array("'",'%', '/', '-', '&', '.');
      $string = str_replace ($excludespecial, ' ', $string) ;
      $string = strtoupper($string);
      return $string ;
    }
   // ***************************************************************************************************
    public static function cdi_array_for_carrier($row) {
      global $woocommerce;
      global $wpdb;
      if (is_numeric($row)) {
        $cdi_order_id  = $row;
      }else{
        $cdi_order_id  = $row->cdi_order_id;
      }
      $order = new WC_Order($cdi_order_id); 
      $order_date = cdiwc3::cdi_order_date_created($order);
      $shipping_first_name = get_post_meta($cdi_order_id,'_shipping_first_name',true); $shipping_first_name = remove_accents ($shipping_first_name) ; 
             $shipping_first_name = WC_function_Colissimo::cdi_sanitize_laposte_name( $shipping_first_name ) ;
      $shipping_last_name = get_post_meta($cdi_order_id,'_shipping_last_name',true); $shipping_last_name = remove_accents ($shipping_last_name) ; 
             $shipping_last_name = WC_function_Colissimo::cdi_sanitize_laposte_name( $shipping_last_name ) ;
      $shipping_company = get_post_meta($cdi_order_id,'_shipping_company',true); $shipping_company = remove_accents ($shipping_company) ; 
             $shipping_company = WC_function_Colissimo::cdi_sanitize_laposte_name( $shipping_company ) ;
             if (!$shipping_company) { $shipping_company = $shipping_last_name ; }
      $shipping_address_1 = get_post_meta($cdi_order_id,'_shipping_address_1',true); $shipping_address_1 = remove_accents ($shipping_address_1) ; 
             $shipping_address_1 = WC_function_Colissimo::cdi_sanitize_laposte_voie( $shipping_address_1 ) ;
      $shipping_address_2 = get_post_meta($cdi_order_id,'_shipping_address_2',true); $shipping_address_2 = remove_accents ($shipping_address_2) ; 
             $shipping_address_2 = WC_function_Colissimo::cdi_sanitize_laposte_voie( $shipping_address_2 ) ;
      $shipping_address_3 = get_post_meta($cdi_order_id,'_shipping_address_3',true); $shipping_address_3 = remove_accents ($shipping_address_3) ; 
             $shipping_address_3 = WC_function_Colissimo::cdi_sanitize_laposte_voie( $shipping_address_3 ) ;
      $shipping_address_4 = get_post_meta($cdi_order_id,'_shipping_address_4',true); $shipping_address_4 = remove_accents ($shipping_address_4) ; 
             $shipping_address_4 = WC_function_Colissimo::cdi_sanitize_laposte_voie( $shipping_address_4 ) ;
      $shipping_city = get_post_meta($cdi_order_id,'_shipping_city',true); $shipping_city = remove_accents ($shipping_city) ; 
             $shipping_city = WC_function_Colissimo::cdi_sanitize_laposte_voie( $shipping_city ) ;
      $shipping_postcode = get_post_meta($cdi_order_id,'_shipping_postcode',true); $shipping_postcode = remove_accents ($shipping_postcode) ; 
             $shipping_postcode = WC_function_Colissimo::cdi_sanitize_laposte_voie( $shipping_postcode ) ;
      $shipping_country = get_post_meta($cdi_order_id,'_shipping_country',true); $shipping_country = remove_accents ($shipping_country) ;
             $shipping_country = WC_function_Colissimo::cdi_sanitize_laposte_voie( $shipping_country ) ;
      $shipping_state = get_post_meta($cdi_order_id,'_shipping_state',true); $shipping_state = remove_accents ($shipping_state) ; 
             $shipping_state = WC_function_Colissimo::cdi_sanitize_laposte_voie( $shipping_state ) ;
      if ($shipping_state) {
        $shipping_city_state = $shipping_city . " " . $shipping_state ; 
      }else{
        $shipping_city_state = $shipping_city ; 
      }
      $billing_phone = get_post_meta($cdi_order_id,'_billing_phone',true); $billing_phone = remove_accents ($billing_phone) ; 
      $billing_email = get_post_meta($cdi_order_id,'_billing_email',true); $billing_email = remove_accents ($billing_email) ; 
      $customer_message = get_post_field( 'post_excerpt', $cdi_order_id );
      $cdi_meta_departure = get_post_meta($cdi_order_id,'_cdi_meta_departure',true);
      $cdi_meta_departure = WC_function_Colissimo::cdi_sanitize_laposte_voie( $cdi_meta_departure ) ;
            $cdi_departure_cp = substr ( $cdi_meta_departure , 0 ,5 );
            $cdi_departure_localite = substr ( $cdi_meta_departure , 6 );
      $cdi_meta_typeparcel = get_post_meta($cdi_order_id,'_cdi_meta_typeparcel',true);
      $cdi_meta_parcelweight = get_post_meta($cdi_order_id,'_cdi_meta_parcelweight',true);

      if (!WC_function_Colissimo::cdi_colissimo_withoutsign_country($shipping_country)) { update_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_signature', 'yes') ; }
         $cdi_meta_signature = get_post_meta($cdi_order_id,'_cdi_meta_signature',true);
      if ($cdi_meta_signature == 'yes') { //  Additionnal insurance display 
        $cdi_meta_additionalcompensation = get_post_meta($cdi_order_id,'_cdi_meta_additionalcompensation',true);
        if (get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_additionalcompensation', true) == 'yes') { // Amount compensation display 
          $cdi_meta_amountcompensation = get_post_meta($cdi_order_id,'_cdi_meta_amountcompensation',true);
        }else{
          $cdi_meta_amountcompensation = '';
        } //  End Amount compensation display  
      }else{
        $cdi_meta_additionalcompensation = '';
        $cdi_meta_amountcompensation = '';
      } //  End Additionnal insurance display display

      $cdi_meta_returnReceipt = get_post_meta($cdi_order_id,'_cdi_meta_returnReceipt',true); //  Return avis réception
      //  End return avis réception
      if (WC_function_Colissimo::cdi_choosereturn_country ($shipping_country)) { //  Return internationnal display  
        $cdi_meta_typereturn = get_post_meta($cdi_order_id,'_cdi_meta_typereturn',true);
      }else{
        $cdi_meta_typereturn = '';          
      } //  End Return internationnal display  
      if (WC_function_Colissimo::cdi_colissimo_outremer_country_ftd ($shipping_country)) { //  OM ftd  
        $cdi_meta_ftd = get_post_meta($cdi_order_id,'_cdi_meta_ftd',true);
      }else{
        $cdi_meta_ftd = '';          
      } //  End OM ftd 

      $cdi_meta_productCode = get_post_meta($cdi_order_id,'_cdi_meta_productCode',true);
      $cdi_meta_pickupLocationId = get_post_meta($cdi_order_id,'_cdi_meta_pickupLocationId',true);

      if (WC_function_Colissimo::cdi_cn23_country ($shipping_country)) { //  CN23 display 
        $cdi_meta_cn23_shipping = get_post_meta($cdi_order_id,'_cdi_meta_cn23_shipping',true);
        $cdi_meta_cn23_category = get_post_meta($cdi_order_id,'_cdi_meta_cn23_category',true);
      }else{
        $cdi_meta_cn23_shipping = '';
        $cdi_meta_cn23_category = '';
      } //  End CN23 display

      $array_for_carrier = array  ('order_id' => $cdi_order_id);
      $array_for_carrier['order_date']  = $order_date ;
      $array_for_carrier['shipping_first_name']  = $shipping_first_name ;
      $array_for_carrier['shipping_last_name']  = $shipping_last_name ;
      $array_for_carrier['shipping_company']  = $shipping_company ;
      $array_for_carrier['shipping_address_1']  = $shipping_address_1 ;
      $array_for_carrier['shipping_address_2']  = $shipping_address_2 ;
      $array_for_carrier['shipping_address_3']  = $shipping_address_3 ;
      $array_for_carrier['shipping_address_4']  = $shipping_address_4 ;
      $array_for_carrier['shipping_city']  = $shipping_city ;
      $array_for_carrier['shipping_postcode']  = $shipping_postcode ;
      $array_for_carrier['shipping_country']  = $shipping_country ;
      $array_for_carrier['shipping_state']  = $shipping_state ;
      $array_for_carrier['shipping_city_state']  = $shipping_city_state ;
      $array_for_carrier['billing_phone']  = $billing_phone ;
      $array_for_carrier['billing_email']  = $billing_email ;
      $array_for_carrier['customer_message']  = $customer_message ;
      $array_for_carrier['departure']  = $cdi_meta_departure ;
      $array_for_carrier['departure_cp']  = $cdi_departure_cp ;
      $array_for_carrier['departure_localite']  = $cdi_departure_localite ;
      $array_for_carrier['parcel_type']  = $cdi_meta_typeparcel ;
      $array_for_carrier['parcel_weight']  = $cdi_meta_parcelweight ;
      $array_for_carrier['signature']  = $cdi_meta_signature ;
      $array_for_carrier['additional_compensation']  = $cdi_meta_additionalcompensation ;
      $array_for_carrier['compensation_amount']  = $cdi_meta_amountcompensation ;

      $array_for_carrier['returnReceipt']  = $cdi_meta_returnReceipt ;
      $array_for_carrier['return_type']  = $cdi_meta_typereturn ;
      $array_for_carrier['ftd']  = $cdi_meta_ftd ;

      $array_for_carrier['product_code']  = $cdi_meta_productCode ;
      $array_for_carrier['pickup_Location_id']  = $cdi_meta_pickupLocationId ;
      $array_for_carrier['cn23_shipping']  = $cdi_meta_cn23_shipping ;
      $array_for_carrier['cn23_category']  = $cdi_meta_cn23_category ;
      $items = $order->get_items();
      $nbart = 0; 
      foreach( $items as $item ) { 
        if (WC_function_Colissimo::cdi_cn23_country ($shipping_country)) {
          $cdi_meta_cn23_article_description = get_post_meta($cdi_order_id,'_cdi_meta_cn23_article_description_' . $nbart,true);
          $cdi_meta_cn23_article_weight = get_post_meta($cdi_order_id,'_cdi_meta_cn23_article_weight_' . $nbart,true);
          $cdi_meta_cn23_article_quantity = get_post_meta($cdi_order_id,'_cdi_meta_cn23_article_quantity_' . $nbart,true);
          $cdi_meta_cn23_article_value = get_post_meta($cdi_order_id,'_cdi_meta_cn23_article_value_' . $nbart,true);
          if (get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_cn23_category', true) == '3') { //  CN23 HS code display  
            $cdi_meta_cn23_article_hstariffnumber = get_post_meta($cdi_order_id,'_cdi_meta_cn23_article_hstariffnumber_' . $nbart,true);
          }else{
            $cdi_meta_cn23_article_hstariffnumber = '';
          } //  End CN23 HS code display  
          $cdi_meta_cn23_article_origincountry = get_post_meta($cdi_order_id,'_cdi_meta_cn23_article_origincountry_' . $nbart,true);
        }else{
          $cdi_meta_cn23_article_description = '';
          $cdi_meta_cn23_article_weight = '';
          $cdi_meta_cn23_article_quantity = '';
          $cdi_meta_cn23_article_value = '';
          $cdi_meta_cn23_article_hstariffnumber = '';
          $cdi_meta_cn23_article_origincountry = '';
        } 
        $array_for_carrier['cn23_article_description_' . $nbart]  = $cdi_meta_cn23_article_description ;
        $array_for_carrier['cn23_article_weight_' . $nbart]  = $cdi_meta_cn23_article_weight ;
        $array_for_carrier['cn23_article_quantity_' . $nbart]  = $cdi_meta_cn23_article_quantity ;
        $array_for_carrier['cn23_article_value_' . $nbart]  = $cdi_meta_cn23_article_value ;
        $array_for_carrier['cn23_article_hstariffnumber_' . $nbart]  = $cdi_meta_cn23_article_hstariffnumber ;
        $array_for_carrier['cn23_article_origincountry_' . $nbart]  = $cdi_meta_cn23_article_origincountry ;
        $nbart = $nbart+1; 
      }
      return $array_for_carrier ;
    } 
   // ***************************************************************************************************
    public static function cdi_debug ($line, $file, $var) {
      if (get_option('wc_settings_tab_colissimo_log') == 'yes') {
        $x = plugin_dir_path( __FILE__ ) ; // magic trick to shorten the path
        $x = str_replace('/includes/', '', $x) ;
        $file = str_replace($x, '', $file) ;
        if (in_array ($file, get_option('wc_settings_tab_colissimo_moduletolog'))) {
          error_log('*** LOG CDI - LINE:' . $line . ' FILE:' . $file . ' ***: ' . print_R($var, TRUE));
        }
      }
    }
   // ***************************************************************************************************
    public static function cdi_get_woo_version_number() {
	if ( ! function_exists( 'get_plugins' ) ) require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	$plugin_folder = get_plugins( '/' . 'woocommerce' );
	$plugin_file = 'woocommerce.php';
	if ( isset( $plugin_folder[$plugin_file]['Version'] ) ) {
		return $plugin_folder[$plugin_file]['Version'];
	}else{
		return NULL;
	}
    }
   // ***************************************************************************************************
    public static function cdi_get_radiosite() {
      $return = '' ;
      $return .= ' | Site Url' . ' : ' . get_option('siteurl') ;
      $return .= ' | CDI Version' . ' : ' . get_option('cdi_options_version') ;
      $return .= ' | WC Version' . ' : ' . WC_function_Colissimo::cdi_get_woo_version_number() ;
      $return .= ' | WP Version' . ' : ' . get_bloginfo($show = 'version' ) ;
      $return .= ' | PHP Version' . ' : ' . phpversion() ;

      $return .= ' | WC_settings_tab_colissimo_autoclean_gateway' . ' : ' . get_option('WC_settings_tab_colissimo_autoclean_gateway') ; 
      $return .= ' | WC_settings_tab_colissimo_defaulttypeparcel' . ' : ' . get_option('WC_settings_tab_colissimo_defaulttypeparcel') ; 
      $return .= ' | WC_settings_tab_colissimo_parcelweight' . ' : ' . get_option('WC_settings_tab_colissimo_parcelweight') ; 
      $return .= ' | WC_settings_tab_colissimo_signature' . ' : ' . get_option('WC_settings_tab_colissimo_signature') ; 
      $return .= ' | WC_settings_tab_colissimo_additionalcompensation' . ' : ' . get_option('WC_settings_tab_colissimo_additionalcompensation') ; 
      $return .= ' | WC_settings_tab_colissimo_amountcompensation' . ' : ' . get_option('WC_settings_tab_colissimo_amountcompensation') ; 
      $return .= ' | WC_settings_tab_colissimo_defaulttypereturn' . ' : ' . get_option('WC_settings_tab_colissimo_defaulttypereturn') ; 
      $return .= ' | WC_settings_tab_colissimo_departure' . ' : ' . get_option('WC_settings_tab_colissimo_departure') ; 
      $return .= ' | WC_settings_tab_colissimo_fromletterbox' . ' : ' . get_option('wc_settings_tab_colissimo_fromletterbox') ;
      $return .= ' | WC_settings_tab_colissimo_log' . ' : ' . get_option('WC_settings_tab_colissimo_log') ; 
      $return .= ' | WC_settings_tab_colissimo_moduletolog' . ' : ' . implode ( ' ; ', get_option('wc_settings_tab_colissimo_moduletolog')) ; 
      $return .= ' | WC_settings_tab_colissimo_cleanonsuppress' . ' : ' . get_option('WC_settings_tab_colissimo_cleanonsuppress') ; 
      $return .= ' | WC_settings_tab_colissimo_rolename_gateway' . ' : ' . implode ( ' ; ', get_option('wc_settings_tab_colissimo_rolename_gateway')) ; 

      $return .= ' | WC_settings_tab_colissimo_cn23_category' . ' : ' . get_option('WC_settings_tab_colissimo_cn23_category') ; 
      $return .= ' | WC_settings_tab_colissimo_cn23_article_description' . ' : ' . get_option('WC_settings_tab_colissimo_cn23_article_description') ; 
      $return .= ' | WC_settings_tab_colissimo_cn23_article_weight' . ' : ' . get_option('WC_settings_tab_colissimo_cn23_article_weight') ; 
      $return .= ' | WC_settings_tab_colissimo_cn23_article_quantity' . ' : ' . get_option('WC_settings_tab_colissimo_cn23_article_quantity') ; 
      $return .= ' | WC_settings_tab_colissimo_cn23_article_value' . ' : ' . get_option('WC_settings_tab_colissimo_cn23_article_value') ; 
      $return .= ' | WC_settings_tab_colissimo_cn23_article_hstariffnumber' . ' : ' . get_option('WC_settings_tab_colissimo_cn23_article_hstariffnumber') ; 
      $return .= ' | WC_settings_tab_colissimo_cn23_article_origincountry' . ' : ' . get_option('WC_settings_tab_colissimo_cn23_article_origincountry') ; 

      $return .= ' | WC_settings_tab_colissimo_inserttrackingcode' . ' : ' . get_option('WC_settings_tab_colissimo_inserttrackingcode') ; 
//    $return .= ' | WC_settings_tab_colissimo_text_preceding_trackingcode' . ' : ' . get_option('WC_settings_tab_colissimo_text_preceding_trackingcode') ; 
      $return .= ' | WC_settings_tab_colissimo_url_trackingcode' . ' : ' . get_option('WC_settings_tab_colissimo_url_trackingcode') ; 

      $return .= ' | WC_settings_tab_colissimo_ws_ContractNumber' . ' : ' . get_option('WC_settings_tab_colissimo_ws_ContractNumber') ; 
//    $return .= ' | WC_settings_tab_colissimo_ws_Password' . ' : ' . get_option('WC_settings_tab_colissimo_ws_Password') ; 
//    $return .= ' | WC_settings_tab_colissimo_ws_X' . ' : ' . get_option('WC_settings_tab_colissimo_ws_X') ; 
//    $return .= ' | WC_settings_tab_colissimo_ws_Y' . ' : ' . get_option('WC_settings_tab_colissimo_ws_Y') ; 
//    $return .= ' | WC_settings_tab_colissimo_ws_OutputPrintingType' . ' : ' . get_option('WC_settings_tab_colissimo_ws_OutputPrintingType') ; 
      $return .= ' | WC_settings_tab_colissimo_ws_OffsetDepositDate' . ' : ' . get_option('WC_settings_tab_colissimo_ws_OffsetDepositDate') ; 
      $return .= ' | WC_settings_tab_colissimo_IncludeCustomsDeclarations' . ' : ' . get_option('WC_settings_tab_colissimo_IncludeCustomsDeclarations') ; 
//    $return .= ' | WC_settings_tab_colissimo_ws_sa_CompanyName' . ' : ' . get_option('WC_settings_tab_colissimo_ws_sa_CompanyName') ; 
//    $return .= ' | WC_settings_tab_colissimo_ws_sa_Line1' . ' : ' . get_option('WC_settings_tab_colissimo_ws_sa_Line1') ; 
//    $return .= ' | WC_settings_tab_colissimo_ws_sa_Line2' . ' : ' . get_option('WC_settings_tab_colissimo_ws_sa_Line2') ; 
//    $return .= ' | WC_settings_tab_colissimo_ws_sa_ZipCode' . ' : ' . get_option('WC_settings_tab_colissimo_ws_sa_ZipCode') ; 
//    $return .= ' | WC_settings_tab_colissimo_ws_sa_City' . ' : ' . get_option('WC_settings_tab_colissimo_ws_sa_City') ; 
//    $return .= ' | WC_settings_tab_colissimo_ws_sa_CountryCode' . ' : ' . get_option('WC_settings_tab_colissimo_ws_sa_CountryCode') ; 
//    $return .= ' | WC_settings_tab_colissimo_ws_sa_Email' . ' : ' . get_option('WC_settings_tab_colissimo_ws_sa_Email') ; 
      $return .= ' | WC_settings_tab_colissimo_ws_FranceCountryCodes' . ' : ' . get_option('wc_settings_tab_colissimo_ws_FranceCountryCodes') ; 
      $return .= ' | WC_settings_tab_colissimo_ws_FranceProductCodes' . ' : ' . get_option('wc_settings_tab_colissimo_ws_FranceProductCodes') ; 
      $return .= ' | WC_settings_tab_colissimo_ws_OutreMerCountryCodes' . ' : ' . get_option('wc_settings_tab_colissimo_ws_OutreMerCountryCodes') ; 
      $return .= ' | WC_settings_tab_colissimo_ws_OutreMerProductCodes' . ' : ' . get_option('wc_settings_tab_colissimo_ws_OutreMerProductCodes') ; 
      $return .= ' | WC_settings_tab_colissimo_ws_EuropeCountryCodes' . ' : ' . get_option('wc_settings_tab_colissimo_ws_EuropeCountryCodes') ; 
      $return .= ' | WC_settings_tab_colissimo_ws_EuropeProductCodes' . ' : ' . get_option('wc_settings_tab_colissimo_ws_EuropeProductCodes') ; 
      $return .= ' | WC_settings_tab_colissimo_ws_InternationalCountryCodes' . ' : ' . get_option('wc_settings_tab_colissimo_ws_InternationalCountryCodes') ; 
      $return .= ' | WC_settings_tab_colissimo_ws_InternationalProductCodes' . ' : ' . get_option('wc_settings_tab_colissimo_ws_InternationalProductCodes') ; 
      $return .= ' | WC_settings_tab_colissimo_ws_ExceptionProductCodes' . ' : ' . get_option('WC_settings_tab_colissimo_ws_ExceptionProductCodes') ; 

      $return .= ' | WC_settings_tab_colissimo_methodreferal' . ' : ' . get_option('WC_settings_tab_colissimo_methodreferal') ; 
      $return .= ' | WC_settings_tab_colissimo_pickupmethodnames' . ' : ' . get_option('WC_settings_tab_colissimo_pickupmethodnames') ;
      $return .= ' | WC_settings_tab_colissimo_ws_InternationalPickupLocationContryCodes' . ' : ' . get_option('WC_settings_tab_colissimo_ws_InternationalPickupLocationContryCodes') ; 
      $return .= ' | WC_settings_tab_colissimo_mapopen' . ' : ' . get_option('WC_settings_tab_colissimo_mapopen') ; 
      $return .= ' | WC_settings_tab_colissimo_maprefresh' . ' : ' . get_option('WC_settings_tab_colissimo_maprefresh') ; 
//    $return .= ' | WC_settings_tab_colissimo_googlemapsapikey' . ' : ' . get_option('wc_settings_tab_colissimo_googlemapsapikey') ; 
      $return .= ' | WC_settings_tab_colissimo_forcedproductcodes' . ' : ' . get_option('WC_settings_tab_colissimo_forcedproductcodes') ; 
      $return .= ' | WC_settings_tab_colissimo_exclusiveshippingmethod' . ' : ' . get_option('wc_settings_tab_colissimo_exclusiveshippingmethod') ;

      $return .= ' | WC_settings_tab_colissimo_methodshipping' . ' : ' . get_option('WC_settings_tab_colissimo_methodshipping') ; 
      $return .= ' | WC_settings_tab_colissimo_methodshippingicon' . ' : ' . get_option('WC_settings_tab_colissimo_methodshippingicon') ; 

      $return .= ' | WC_settings_tab_colissimo_parcelreturn' . ' : ' . get_option('WC_settings_tab_colissimo_parcelreturn') ; 
//    $return .= ' | WC_settings_tab_colissimo_text_preceding_parcelreturn' . ' : ' . get_option('WC_settings_tab_colissimo_text_preceding_parcelreturn') ; 
//    $return .= ' | WC_settings_tab_colissimo_text_preceding_printreturn' . ' : ' . get_option('WC_settings_tab_colissimo_text_preceding_printreturn') ; 
      $return .= ' | WC_settings_tab_colissimo_trackingheaders_parcelreturn' . ' : ' . get_option('WC_settings_tab_colissimo_trackingheaders_parcelreturn') ; 
      $return .= ' | WC_settings_tab_colissimo_nbdayparcelreturn' . ' : ' . get_option('WC_settings_tab_colissimo_nbdayparcelreturn') ; 
//    $return .= ' | WC_settings_tab_colissimo_returnparcelservice' . ' : ' . get_option('WC_settings_tab_colissimo_returnparcelservice') ; 

      $return .= ' | wc_settings_tab_colissimo_pagesize' . ' : ' . get_option('wc_settings_tab_colissimo_pagesize') ; 
      $return .= ' | wc_settings_tab_colissimo_labellayout' . ' : ' . get_option('wc_settings_tab_colissimo_labellayout') ; 
      $return .= ' | wc_settings_tab_colissimo_addresswidth' . ' : ' . get_option('wc_settings_tab_colissimo_addresswidth') ; 
      $return .= ' | wc_settings_tab_colissimo_fontsize' . ' : ' . get_option('wc_settings_tab_colissimo_fontsize') ; 
      $return .= ' | wc_settings_tab_colissimo_startrank' . ' : ' . get_option('wc_settings_tab_colissimo_startrank') ; 
      $return .= ' | wc_settings_tab_colissimo_managerank' . ' : ' . get_option('wc_settings_tab_colissimo_managerank') ; 
      $return .= ' | wc_settings_tab_colissimo_testgrid' . ' : ' . get_option('wc_settings_tab_colissimo_testgrid') ; 
//    $return .= ' | wc_settings_tab_colissimo_miseenpage' . ' : ' . get_option('wc_settings_tab_colissimo_miseenpage') ; 
//    $return .= ' | wc_settings_tab_colissimo_customcss' . ' : ' . get_option('wc_settings_tab_colissimo_customcss') ; 

      $return .= ' | ' ;
      return $return ;
    }
   // ***************************************************************************************************
    public static function cdi_sanitize_colissimophone($string) { // Keep only number and the heading + 
      $string = preg_replace('/^\+/', '00000000', $string); // Suppress international + and replace by a 00000000 patttern
      $string = preg_replace('/[^0-9]+/', '', $string); // Clean with only numbers
      $string = preg_replace('/^00000000/', '+', $string); // Reset international + if exist in input
      return $string ;
    }
   // ***************************************************************************************************
    public static function cdi_sanitize_colissimoMobileNumber($MobileNumber, $country) {
      $MobileNumber = WC_function_Colissimo::cdi_sanitize_colissimophone($MobileNumber);
      switch ($country) {
        case 'FR':
          // Si le numéro commence par +33X, 0033X, +330X ou 00330X il est nécessaire d'avoir converti le début en 0X (où X = 6 ou 7)
          $MobileNumber = preg_replace('/^003306/', '06', $MobileNumber);
          $MobileNumber = preg_replace('/^003307/', '07', $MobileNumber);
          $MobileNumber = preg_replace('/^\+3306/', '06', $MobileNumber);
          $MobileNumber = preg_replace('/^\+3307/', '07', $MobileNumber);
          $MobileNumber = preg_replace('/^00336/', '06', $MobileNumber);
          $MobileNumber = preg_replace('/^00337/', '07', $MobileNumber);
          $MobileNumber = preg_replace('/^\+336/', '06', $MobileNumber);
          $MobileNumber = preg_replace('/^\+337/', '07', $MobileNumber);
          switch ($MobileNumber) {
            case (preg_match('/^06/', $MobileNumber) ? true : false) :
              break;
            case (preg_match('/^07/', $MobileNumber) ? true : false) :
              break;   
            default:
              $MobileNumber = ''; // Erase mobile number if invalid
          }
          break ;
      }
      return $MobileNumber ;
    }
   // ***************************************************************************************************
    /**
     *
     * The most advanced method of serialization.
     *
     * @param mixed $obj => can be an objectm, an array or string. may contain unlimited number of subobjects and subarrays
     * @param string $wrapper => main wrapper for the xml
     * @param array (key=>value) $replacements => an array with variable and object name replacements
     * @param boolean $add_header => whether to add header to the xml string
     * @param array (key=>value) $header_params => array with additional xml tag params
     * @param string $node_name => tag name in case of numeric array key
     */
    public static function generateValidXmlFromMixiedObj($obj, $wrapper = null, $replacements = array(
) , $add_header = true, $header_params = array() , $node_name = 'node') {
      $xml = '';
      if ($add_header) $xml.= self::generateHeader($header_params);
      if ($wrapper != null) $xml.= '<' . $wrapper . '>';
      if (is_object($obj)) {
        $node_block = strtolower(get_class($obj));
        if (isset($replacements[$node_block])) $node_block = $replacements[$node_block];
        $xml.= '<' . $node_block . '>';
        $vars = get_object_vars($obj);
        if (!empty($vars)) {
          foreach($vars as $var_id => $var) {
            if (isset($replacements[$var_id])) $var_id = $replacements[$var_id];
            $xml.= '<' . $var_id . '>';
            $xml.= self::generateValidXmlFromMixiedObj($var, null, $replacements, false, null, $node_name);
            $xml.= '</' . $var_id . '>';
          }
        }
        $xml.= '</' . $node_block . '>';
      } else if (is_array($obj)) {
        foreach($obj as $var_id => $var) {
          if (!is_object($var)) {
            if (is_numeric($var_id)) $var_id = $node_name;
            if (isset($replacements[$var_id])) $var_id = $replacements[$var_id];
            $xml.= '<' . $var_id . '>';
          }
          $xml.= self::generateValidXmlFromMixiedObj($var, null, $replacements, false, null, $node_name);
          if (!is_object($var)) $xml.= '</' . $var_id . '>';
        }
      } else {
        $xml.= htmlspecialchars($obj, ENT_QUOTES);
      }
      if ($wrapper != null) $xml.= '</' . $wrapper . '>';
      return $xml;
    }
    /**
     *
     * xml header generator
     * @param array $params
     */
    public static function generateHeader($params = array()) {
      $basic_params = array(
        'version' => '1.0',
        'encoding' => 'UTF-8'
      );
      if (!empty($params)) $basic_params = array_merge($basic_params, $params);
      $header = '<?xml';
      foreach($basic_params as $k => $v) {
        $header.= ' ' . $k . '=' . $v;
      }
      $header.= ' ?>';
      return $header;
    }
   // ***************************************************************************************************
    public static function strToHex($string) {
      $hex = '';
      for ($i = 0; $i < strlen($string); $i++) {
        $ord = ord($string[$i]);
        $hexCode = dechex($ord);
        $hex.= substr('0' . $hexCode, -2);
      }
      return strToUpper($hex);
    }
    public static function hexToStr($hex) {
      $string = '';
      for ($i = 0; $i < strlen($hex) - 1; $i+= 2) {
        $string.= chr(hexdec($hex[$i] . $hex[$i + 1]));
      }
      return $string;
    }
   // ***************************************************************************************************
    public static function get_string_between($string, $start, $end){
      $string = ' ' . $string;
      $ini = strpos($string, $start);
      if ($ini == 0) return '';
      $ini += strlen($start);
      if ($end !== null) {
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
      }else{
        return substr($string, $ini);
      }
    }
    public static function sup_line($string){
      $string = str_replace(array("\r\n","\r","\n"),"",$string);
      return $string;
    }
   // ***************************************************************************************************
    public static function get_openssl_version_number($patch_as_number=false,$openssl_version_number=null) {
      // OPENSSL_VERSION_NUMBER parser, works from OpenSSL v.0.9.5b+ (e.g. for use with version_compare())
      // OPENSSL_VERSION_NUMBER is a numeric release version identifier for OpenSSL
      // Syntax: MNNFFPPS: major minor fix patch status (HEX)
      // The status nibble meaning: 0 => development, 1 to e => betas, f => release
      // Examples:
      // - 0x000906023 => 0.9.6b beta 3
      // - 0x00090605f => 0.9.6e release
      // - 0x1000103f  => 1.0.1c
      /**
      * @param Return Patch-Part as decimal number for use with version_compare
      * @param OpenSSL version identifier as hex value $openssl_version_number
      */
      if (is_null($openssl_version_number)) $openssl_version_number = OPENSSL_VERSION_NUMBER;
      $openssl_numeric_identifier = str_pad((string)dechex($openssl_version_number),8,'0',STR_PAD_LEFT);
      $openssl_version_parsed = array();
      $preg = '/(?<major>[[:xdigit:]])(?<minor>[[:xdigit:]][[:xdigit:]])(?<fix>[[:xdigit:]][[:xdigit:]])';
      $preg.= '(?<patch>[[:xdigit:]][[:xdigit:]])(?<type>[[:xdigit:]])/';
      preg_match_all($preg, $openssl_numeric_identifier, $openssl_version_parsed);
      $openssl_version = false;
      if (!empty($openssl_version_parsed)) {
        $alphabet = array(1=>'a',2=>'b',3=>'c',4=>'d',5=>'e',6=>'f',7=>'g',8=>'h',9=>'i',10=>'j',11=>'k',
                                       12=>'l',13=>'m',14=>'n',15=>'o',16=>'p',17=>'q',18=>'r',19=>'s',20=>'t',21=>'u',
                                       22=>'v',23=>'w',24=>'x',25=>'y',26=>'z');
        $openssl_version = intval($openssl_version_parsed['major'][0]).'.';
        $openssl_version.= intval($openssl_version_parsed['minor'][0]).'.';
        $openssl_version.= intval($openssl_version_parsed['fix'][0]);
        $patchlevel_dec = hexdec($openssl_version_parsed['patch'][0]);
        if (!$patch_as_number && array_key_exists($patchlevel_dec, $alphabet)) {
            $openssl_version.= $alphabet[$patchlevel_dec]; // ideal for text comparison
        }else{
            $openssl_version.= '.'.$patchlevel_dec; // ideal for version_compare
        }
      }
      return $openssl_version;
    }
   // ***************************************************************************************************
    public static function cdi_cdiplus_anonyme($action,$xml='') {  
      $xml = base64_encode('<xmldata>' . $xml . '</xmldata>');
      try {
        $errorfilegetcontents = false ;
        $postdata = http_build_query( array(
                'api' => 'cdi',
                'version' => get_option('cdi_options_version'),
                'contractnumber' => '0',
                'password' => '0',
                'carrier' => '000',
                'action' => $action,
                'siteurl' => rawurlencode(get_site_url()),
                'xml' => $xml ) );
        $opts = array('http' => array(
                'method'  => 'POST',
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n" ,
                'request_fulluri' => true ,
                'content' => $postdata ) );
        $context  = stream_context_create($opts);
        $result = file_get_contents( get_option('WC_settings_tab_colissimo_domain') , false, $context);
        if ($result === false) {
          WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $result);
          $errorfilegetcontents = true ;
        }
      } catch (Exception $e) {
        // Handle exception
        WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $e);
        $errorfilegetcontents = true ;
      }
      $result = base64_decode($result);
      WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $result);
      if ($errorfilegetcontents == false) { // no error for client and server sides
        //on traite result
        return $result ;
      }else{
        //on traite error
        WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , 'Error : ' . $result);
        return '' ;
      }
    }

    public static function ssl_private_decrypt($source,$key){
      $maxlength=128;
      $output='';
      while($source){
        $input= substr($source,0,$maxlength);
        $source=substr($source,$maxlength);
        $ok= openssl_private_decrypt($input,$out,$key);    
        $output.=$out;
      }
      return $output;
    } 

    public static function cdi_eval($action) {
      $cdi_eval_crypted = get_option('cdi_eval') ;
      $data = hex2bin($cdi_eval_crypted[$action]) ; 
      $privKeyhex =  get_option('cdi_privkey');
      $privKey = hex2bin($privKeyhex) ;
      $return = self::ssl_private_decrypt($data,$privKey) ;
      return $return ;
    }

    public static function cdi_isconnected() {
      $cdi_eval_crypted = get_option('cdi_eval') ; 
      if (!$cdi_eval_crypted) {
        $return = false ;
      }else{
        eval(WC_function_Colissimo::cdi_eval('99')) ;
      }
      return $return ;
    }

    public static function cdi_cdiplus_credential() { 
      $tokenlastnews = time() ;
      $oldtokenlastnews = get_option('cdi_tokenlastnews') ;
      if ($oldtokenlastnews > ($tokenlastnews + 172800)) {  // Older than 2 days, so something may be wrong : incoherent data to reinitiate
        $oldtokenlastnews = 100 ;
      } 
      if (!$oldtokenlastnews OR (($oldtokenlastnews + 43200) < $tokenlastnews)) { // timer pour demande forcée à 43200s (12h)
        $forcedrequest = true ;
        update_option('cdi_tokenlastnews', $tokenlastnews) ;
      }else{
        $forcedrequest = false ;
      }
      if ((get_option('wc_settings_tab_colissimo_cdiplus_ContractNumber') && get_option('wc_settings_tab_colissimo_cdiplus_Password')) OR $forcedrequest == true) {
        $tokentimercredential = time() ;
        $oldtokentimercredential = get_option('cdi_tokentimercredential') ;
        if ($oldtokentimercredential && (($oldtokentimercredential + 600) > $tokentimercredential)) { // timer pour maj à 600s (10mn)
          return ;
        }
        update_option('cdi_tokentimercredential', $tokentimercredential) ;
        $xml = '<xmldata></xmldata>' ;
        $xml = base64_encode($xml);
        try {
          $errorfilegetcontents = false ;
          $postdata = http_build_query( array(
                  'api' => 'cdi',
                  'version' => get_option('cdi_options_version'),
                  'contractnumber' => get_option('wc_settings_tab_colissimo_cdiplus_ContractNumber'),
                  'password' => get_option('wc_settings_tab_colissimo_cdiplus_Password'),
                  'carrier' => 'col',
                  'action' => 'ab',
                  'siteurl' => rawurlencode(get_site_url()),
                  'xml' => $xml ) );
          $opts = array('http' => array(
                  'method'  => 'POST',
                  'header'  => "Content-type: application/x-www-form-urlencoded\r\n" ,
                  'request_fulluri' => true ,
                  'content' => $postdata ) );
          $context  = stream_context_create($opts);
          $result = file_get_contents( get_option('WC_settings_tab_colissimo_domain') , false, $context);
          if ($result === false) {
            WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $result);
            $errorfilegetcontents = true ;
          }
        } catch (Exception $e) {
          // Handle exception
          WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $e);
          $errorfilegetcontents = true ;
        }
        $result = base64_decode($result);
        if ($errorfilegetcontents == false) { // no error for client and server sides
          $errorCode = WC_function_Colissimo::get_string_between($result, '<id>', '</id>') ;
          $cdi_date_lastnews = WC_function_Colissimo::get_string_between($result, '<lastnews>', '</lastnews>') ;
          update_option ('cdi_date_lastnews', $cdi_date_lastnews) ;
          if ($errorCode == '0') {
            $privKeyhex = WC_function_Colissimo::get_string_between($result, '<privkey>', '</privkey>') ;
            update_option('cdi_privkey', $privKeyhex);
            $string = WC_function_Colissimo::get_string_between($result, '<content>', '</content>') ;
            $cdi_eval_crypted = array () ;
            $arrx = explode (';', $string) ;
            foreach ($arrx as $x) {
              $arry = explode (':', $x) ;
              if ($arry[0] && $arry[1]) {
                $cdi_eval_crypted[$arry[0]] = $arry[1] ;
              }
            }
            $returnmsg = null ;
            update_option('cdi_eval', $cdi_eval_crypted) ;
            $errorCode = '99999' ;
            update_option('cdi_lasterror_isabonnecdi', '0') ;
          }else{
            if (WC_function_Colissimo::get_string_between($result, '<id>', '</id>') !== '90000' ) {
              $returnmsg = 'Erreur authentificaton Abonné CDI+ : ' . WC_function_Colissimo::get_string_between($result, '<id>', '</id>') . ' ' . WC_function_Colissimo::get_string_between($result, '<messageContent>', '</messageContent>') ;
            }else{
              $returnmsg = null ;
            }
            delete_option('cdi_eval') ;
            $errorCode = '99990' ;
            update_option('cdi_lasterror_isabonnecdi', WC_function_Colissimo::get_string_between($result, '<id>', '</id>')) ;
          }
        }else{
          $returnmsg = null ;
          delete_option('cdi_eval') ;
          $errorCode = '99990' ;
        }
      }else{
        $returnmsg = null ;
        delete_option('cdi_eval') ;
        $errorCode = '99990' ;
      }
      eval(WC_function_Colissimo::cdi_eval('98')) ;
      return $returnmsg ;
    }

    public static function cdi_get_inovert($order_id, $trackingcode) {  
      if (WC_function_Colissimo::cdi_isconnected()) { 
        $arrayinovert = get_post_meta($order_id, 'cdi_colis_inovert', true ) ;
        if ($arrayinovert && strpos('x,RENAVI,', $arrayinovert['eventCode'])) {
          $msgsuivicolis = ' ' . $arrayinovert['eventCode'] . ' ' . $arrayinovert['eventDate'] . ' | ' . $arrayinovert['eventLibelle'] . ' | ' . $arrayinovert['eventSite'] . ' ' . $arrayinovert['recipientCity'] . ' ' . $arrayinovert['recipientCountryCode'] . ' ' . $arrayinovert['recipientZipCode'] ;
          return $msgsuivicolis ;
        }else{
          $order = wc_get_order( $order_id );
          $order_date_obj = $order->get_date_created() ;
          $order_date = $order_date_obj->format('Y-m-d');
          $limitdate = str_replace('-', '', date('Y-m-d', strtotime("-30 days"))) ;
          $checkeddate = str_replace('-', '', substr($order_date,0,10)) ;
          $datetime1 = new DateTime($limitdate);
          $datetime2 = new DateTime($checkeddate);
          $difference = $datetime1->diff($datetime2);
          if ($difference->invert > 0) {
            return ' *** Plus de suivi Colissimo pour les colis de plus de 30 jours.' ;
          }else{
            // Initiate structure    
            $cdicolcontractnumber = get_option('wc_settings_tab_colissimo_ws_ContractNumber') ;
            $cdicolpassword = get_option('wc_settings_tab_colissimo_ws_Password') ;
            //$cdicolcontractnumber = '123456' ; // for Colissimo account test
            //$cdicolpassword = 'ABC123' ;  // for Colissimo account test
            $result = file_get_contents('https://www.coliposte.fr/tracking-chargeur-cxf/TrackingServiceWS/track?accountNumber=' . $cdicolcontractnumber . '&password=' . $cdicolpassword . '&skybillNumber=' . $trackingcode) ;
            $errorCode = WC_function_Colissimo::get_string_between($result, '<errorCode>', '</errorCode>') ;
            if ($errorCode !== '0') {
              return 'Erreur suivi colis: ' . $errorCode ;
            }else{
              $arrayinovert = array() ;
              $arrayinovert['eventCode'] = WC_function_Colissimo::get_string_between($result, '<eventCode>', '</eventCode>') ;
              $arrayinovert['eventDate'] = WC_function_Colissimo::get_string_between($result, '<eventDate>', '</eventDate>') ;
              $arrayinovert['eventLibelle'] = WC_function_Colissimo::get_string_between($result, '<eventLibelle>', '</eventLibelle>') ;
              $arrayinovert['eventSite'] = WC_function_Colissimo::get_string_between($result, '<eventSite>', '</eventSite>') ;
              $arrayinovert['recipientCity'] = WC_function_Colissimo::get_string_between($result, '<recipientCity>', '</recipientCity>') ;
              $arrayinovert['recipientCountryCode'] = WC_function_Colissimo::get_string_between($result, '<recipientCountryCode>', '</recipientCountryCode>') ;
              $arrayinovert['recipientZipCode'] = WC_function_Colissimo::get_string_between($result, '<recipientZipCode>', '</recipientZipCode>') ;
              update_post_meta($order_id, 'cdi_colis_inovert', $arrayinovert ) ;
              $msgsuivicolis = ' ' . $arrayinovert['eventCode'] . ' ' . $arrayinovert['eventDate'] . ' | ' . $arrayinovert['eventLibelle'] . ' | ' . $arrayinovert['eventSite'] . ' ' . $arrayinovert['recipientCity'] . ' ' . $arrayinovert['recipientCountryCode'] . ' ' . $arrayinovert['recipientZipCode'] ;
              return $msgsuivicolis ;
            }
          }
        }
      }
    }

    public static function cdi_button_connected() {
      if (WC_function_Colissimo::cdi_isconnected()) {
        eval (WC_function_Colissimo::cdi_eval('7')) ;
        eval (WC_function_Colissimo::cdi_eval('97')) ; 
        $datetime1 = new DateTime('20' . substr($cdi_datefinabonnement,0,6));
        $datetime2 = new DateTime();
        $difference = $datetime1->diff($datetime2);
        if ( ($difference->invert == 1) && ($difference->days > 30)) { $color = 'green';
          }elseif ( ($difference->invert == 1) && ($difference->days > 15) ) { $color = '#ff00be';
          }else{ $color = 'red';
        }
        $datefin = '20' . substr($cdi_datefinabonnement,0,2) . '/' . substr($cdi_datefinabonnement,2,2) . '/' . substr($cdi_datefinabonnement,4,2) ;
        ?><em></em><input name="cdi_green_del" type="submit" value="CDI+ connecté -> <?php echo $datefin ; ?>" style="float: left; background-color:<?php echo $color ; ?>; color:white;"/><em></em><?php
        eval (WC_function_Colissimo::cdi_eval('12')) ;
      }else{
        ?><em></em><input name="cdi_green_del" type="submit" value="CDI+ non connecté" style="float: left; background-color:gray; color:black;" title="Abonnement périmé ? : Allez sur votre console colissimodeliveryintégration.com pour mettre à jour votre abonnement.
Adhérer à CDI+ ? : Cliquez sur le bouton vert d'adhésion en haut de page."/><em></em><?php
      }
    }

    public static function cdi_button_informationcdi() {
        $cdi_date_lastnews = get_option ('cdi_date_lastnews') ;
        $cdi_date_newsread = get_option('cdi_date_newsread') ;
        if ($cdi_date_lastnews !== $cdi_date_newsread) {
          ?><em></em><input id="blink" name="cdi_annonce_cdiplus" type="submit" value="Information CDI" style="float: left; background-color:blue; color:white; font-weight: bold;" title="Vous n'avez pas encore lu cette information, cliquez !" /><em></em><?php
        }else{
          ?><em></em><input id="noblink" name="cdi_annonce_cdiplus" type="submit" value="Information CDI" style="float: left; background-color:gray; color:white; font-weight: bold;" title="Cliquez pour lire cette information." /><em></em><?php
        }
        if ($_SERVER['REQUEST_METHOD'] == "POST" and ISSET($_POST['cdi_annonce_cdiplus'])) {
          echo '</p><br class="clear">' ;
          $result = WC_function_Colissimo::cdi_cdiplus_anonyme('if') ;
          $return = WC_function_Colissimo::get_string_between($result, '<return>', '</return>') ;
          $messages = WC_function_Colissimo::get_string_between($return, '<messages>', '</messages>') ;
          $retid = WC_function_Colissimo::get_string_between($messages, '<id>', '</id>') ;
          $retmessageContent = WC_function_Colissimo::get_string_between($messages, '<messageContent>', '</messageContent>') ;
          if ($retid != 0) {
            ?><p> Erreur <?php echo $retid ; ?> : <?php echo $retmessageContent ; ?></p><?php
          }else{
            if (isset($retmessageContent) && $retmessageContent !== null && $retmessageContent !== '') {
              ?><div> <?php echo $retmessageContent ; ?> </div><?php
            }
          }
          update_option('cdi_date_newsread', get_option ('cdi_date_lastnews')) ;
        }
        ?><script type="text/javascript">
          var blacktime = 1000;
          var whitetime = 1000;
          setTimeout(whiteFunc,blacktime);
          function whiteFunc(){
            document.getElementById("blink").style.color = "white";
            setTimeout(blackFunc,whitetime);
          }
          function blackFunc(){
            document.getElementById("blink").style.color = "black";
            setTimeout(whiteFunc,blacktime);
          }
        </script><?php
    }

    public static function cdi_button_adhesioncdiplus() {
      global $woocommerce;
      $return = null ;
      $contractnumber = get_option('wc_settings_tab_colissimo_cdiplus_ContractNumber') ;
      if (!$contractnumber) {
        ?><em></em><input name="cdi_adhesion_cdiplus" type="submit" value="S'abonner à CDI+" style="float: left; background-color:green; color:white;" title="CDI+ est entré en fonction. Pour s'abonner cliquez !" /><em></em><?php

        if ($_SERVER['REQUEST_METHOD'] == "POST" and ISSET($_POST['cdi_adhesion_cdiplus'])) {
          $prenom  = '' ;
          $nom  = '' ;
          $entreprise  = get_option('wc_settings_tab_colissimo_ws_sa_CompanyName') ;
          $adresseligne1  = get_option('wc_settings_tab_colissimo_ws_sa_Line1') ;
          $adresseligne2  = get_option('wc_settings_tab_colissimo_ws_sa_Line2') ;
          $codepostal  = get_option('wc_settings_tab_colissimo_ws_sa_ZipCode') ;
          $ville  = get_option('wc_settings_tab_colissimo_ws_sa_City') ;
          $payscode  = get_option('wc_settings_tab_colissimo_ws_sa_CountryCode') ;
          $paysname = WC()->countries->countries[$payscode];
          $urlsite  = get_site_url() ;
          $email  = get_option('wc_settings_tab_colissimo_ws_sa_Email') ;
          $telephone  = '' ;

          $html  =  '</p><br class="clear">' ;
          $html .= '<div style="border: 5px solid blue; margin-left:18%;"><div style="background-color:white; color:black; padding:15px;">' ;
          $html .= '<p><strong>Les données qui vont être communiquées à CDI+ pour initier votre abonnement : </strong></p>' ;
          $html .= '<p><p>Prénom : <input name="cdi_prenom" placeholder="Prénom ..." type="text" value="'. $prenom . '"/></p>' ;
          $html .= '<p><p>Nom : <input name="cdi_nom" placeholder="Nom ..." type="text" value="'. $nom . '"/></p>' ;
          $html .= '<p><p>Entreprise : <input name="cdi_entreprise" placeholder="Entreprise ..." type="text" value="'. $entreprise . '"/></p>' ;
          $html .= '<p><p>Adresse ligne 1 : <input name="cdi_adresseligne1" placeholder="Adresse ligne 1 ..." type="text" value="'. $adresseligne1 . '"/></p>' ;
          $html .= '<p><p>Adresse ligne 2 : <input name="cdi_adresseligne2" placeholder="Adresse ligne 2 ..." type="text" value="'. $adresseligne2 . '"/></p>' ;
          $html .= '<p><p>Code postal : <input name="cdi_codepostal" placeholder="Code postal ..." type="text" value="'. $codepostal . '"/></p>' ;
          $html .= '<p><p>Ville : <input name="cdi_ville" placeholder="Ville ..." type="text" value="'. $ville . '"/></p>' ;
          $html .= '<p><p>Pays : <input name="cdi_pays" placeholder="Pays ..." type="text" value="'. $paysname . '"/></p>' ;
          $html .= '<p><p>Téléphone : <input name="cdi_telephone" placeholder="Téléphone ..." type="text" value="'. $telephone . '"/></p>' ;
          $html .= '<p><p>Email : <input name="cdi_email" placeholder="Email ..." type="text" value="'. $email . '"/></p>' ;
          $html .= '<p>Url site : ' . $urlsite . '</p>' ;

          $html .= '<p><strong>Les vérifications que vous devez faire :</strong></p>' ;
          $html .= '<p>Vous pourrez compléter ou modifier la plupart de ces données depuis votre console de gestion CDI (colissimodeliveryintegration.com). Vous devez cependant être très vigilant sur deux données :</p>' ;
          $html .= "<p> - Votre adresse email. Elle ne sera pas modifiable sur la console CDI, et c'est le seul moyen pour vous communiquer votre identifiant et votre clè d'authentification. Par ailleurs, cet email doit être unique et il ne peut pas exister 2 abonnements CDI avec le même email.</p>" ;
          $html .= "<p> - Votre url de site. Il faut que l'url déclarée dans votre abonnement CDI+ soit la même que celle du site effectuant les requêtes au serveur CDI. Vous pourrez néanmoins modifier cette url depuis votre console CDI.</p>" ;

          $html .= '<p><strong>Que va-t-il se passer à la validation ?</strong></p>' ;
          $html .= "<p>Vous allez recevoir un mail sur votre adresse email " . $email . " pour vous communiquer votre identifiant CDI et une clé initiale d'authentification.</p>" ;
          $html .= "<p>Vous irez alors sur votre console CDI (colissimodeliveryintegration.com) et dès votre connection, vous aurez à valider les Conditions Générales et à vous générer une nouvelle clé d'authentification.</p>" ;
          $html .= "<p>Pour que votre site soit connecté à CDI+, vous devrez alors renseigner sur votre site, dans les 'Réglages généraux' de CDI (en bas de page, zone 'Réservé aux abonné CDI+') votre numéro de contrat et votre clé d'authentification définitive. Le numéro de contrat et la clé d'authentification vous servent à la fois à connecté votre site à CDI+ et à accéder à votre console de gestion.</p>" ;
          $html .= "<p><em>CDI vous souhaite la bienvenue et vous acceuille avec un abonnement gratuit de 1 mois.</em></p>" ;
          $html .= "<p>---------------------------------------</p>" ;
          $html .= "<p>Merci pour votre confiance.</p>" ;

          $html .= '<input name="cdi_annulation" type="submit" value="Annuler" style="float:left; margin-bottom:15px;" title="Annuler votre procédure d\'abonnement à CDI+." />' ;
          $html .= '<input name="cdi_sabonner_cdiplus" type="submit" value="S\'abonner à CDI+" style="float:right; margin-bottom:15px;" title="S\'abonner à CDI+" />' ; 
          $html .= '<p style="color:white;">-</p>' ;

          $html .= '</div></div>' ;
          echo $html ;
        }
      }
      if ($_SERVER['REQUEST_METHOD'] == "POST" and ISSET($_POST['cdi_sabonner_cdiplus'])) {
        $xml = '<xmldata>' .
               '<prenom>' . $_POST['cdi_prenom'] . '</prenom>' .
               '<nom>' . $_POST['cdi_nom'] . '</nom>' .
               '<entreprise>' . $_POST['cdi_entreprise'] . '</entreprise>' .
               '<adresseligne1>' . $_POST['cdi_adresseligne1'] . '</adresseligne1>' .
               '<adresseligne2>' . $_POST['cdi_adresseligne2'] . '</adresseligne2>' .
               '<codeppostal>' . $_POST['cdi_codepostal'] . '</codeppostal>' .
               '<ville>' . $_POST['cdi_ville'] . '</ville>' .
               '<pays>' . $_POST['cdi_pays'] . '</pays>' .
               '<telephone>' . $_POST['cdi_telephone'] . '</telephone>' .
               '<email>' . $_POST['cdi_email'] . '</email>' .
               '<urlsite>' . get_site_url() . '</urlsite>' .
               '</xmldata>' ;
        $xml = base64_encode($xml);
        try {
          $errorfilegetcontents = false ;
          $postdata = http_build_query( array(
                  'api' => 'cdi',
                  'version' => get_option('cdi_options_version'),
                  'contractnumber' => '0',
                  'password' => '0',
                  'carrier' => '000',
                  'action' => 'ad',
                  'siteurl' => rawurlencode(get_site_url()),
                  'xml' => $xml ) );
          $opts = array('http' => array(
                  'method'  => 'POST',
                  'header'  => "Content-type: application/x-www-form-urlencoded\r\n" ,
                  'request_fulluri' => true ,
                  'content' => $postdata ) );
          $context  = stream_context_create($opts);
          $result = file_get_contents( get_option('WC_settings_tab_colissimo_domain') , false, $context);
          if ($result === false) {
            WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $result);
            $errorfilegetcontents = true ;
          }
        } catch (Exception $e) {
          // Handle exception
          WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $e);
          $errorfilegetcontents = true ;
        }
        $result = base64_decode($result);
        if ($errorfilegetcontents == false) { // no error for client and server sides
          if (WC_function_Colissimo::get_string_between($result, '<id>', '</id>') == '0') {
            $return = "Demande adhésion CDI+ : Prise en compte. Un mail vous est envoyé pour vous communiquer vos données d'accès. " ;
          }else{
            $return = 'Demande adhésion CDI+ : ' . WC_function_Colissimo::get_string_between($result, '<id>', '</id>') . ' ' . WC_function_Colissimo::get_string_between($result, '<messageContent>', '</messageContent>') ;
          }
        }else{
          $return = 'Demande adhésion CDI+ : Erreur technique' . $result ;
        }
      }
      return $return ;
    }

    public static function cdi_hex_dump($data, $newline="\n") {
      static $return = '';
      static $from = '';
      static $to = '';
      static $width = 16; # number of bytes per line
      static $pad = '.'; # padding for non-visible characters
      if ($from==='') {
        for ($i=0; $i<=0xFF; $i++) {
          $from .= chr($i);
          $to .= ($i >= 0x20 && $i <= 0x7E) ? chr($i) : $pad;
        }
      }
      $hex = str_split(bin2hex($data), $width*2);
      $chars = str_split(strtr($data, $from, $to), $width);
      $offset = 0;
      foreach ($hex as $i => $line) {
        //echo sprintf('%6X',$offset).' : '.implode(' ', str_split($line,2)) . ' [' . $chars[$i] . ']' . $newline;
        $return .= sprintf('%6X',$offset).' : '.implode(' ', str_split($line,2))  . ' [' . $chars[$i] . ']' . $newline ;
        $offset += $width;
      }
      return $return ;
    }

}



?>
