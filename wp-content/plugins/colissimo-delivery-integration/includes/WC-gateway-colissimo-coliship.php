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
/* Gateway coliship                                                                     */
/****************************************************************************************/
class WC_gateway_colissimo_coliship {
  public static function init() {
    add_action('admin_init',  __CLASS__ . '::cdi_coliship_run');
  }

  public static function CDI_str_to_noaccent($str) {
    $str = preg_replace('#Ç#', 'C', $str);
    $str = preg_replace('#È|É|Ê|Ë#', 'E', $str);
    $str = preg_replace('#@|À|Á|Â|Ã|Ä|Å#', 'A', $str);
    $str = preg_replace('#Ì|Í|Î|Ï#', 'I', $str);
    $str = preg_replace('#Ò|Ó|Ô|Õ|Ö#', 'O', $str);
    $str = preg_replace('#Ù|Ú|Û|Ü#', 'U', $str);
    $str = preg_replace('#Ý#', 'Y', $str);
    return ($str);
  }

  public static function cdi_coliship_run() {
    if ( isset($_POST['cdi_gateway_coliship']) && isset( $_POST['cdi_coliship_run_nonce'] ) && wp_verify_nonce( $_POST['cdi_coliship_run_nonce'], 'cdi_coliship_run' ) ) {
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
            $out = fopen('php://output', 'w');
            $theiimfile = 'Coliship-Orders-' . date('YmdHis') . '.iim' ;
            header('Content-type: text' );
            header('Content-Disposition: inline; filename=' . $theiimfile );
            foreach ($results as $row) {
              $cdi_tracking = $row->cdi_tracking;
              if (!$cdi_tracking && ($row->cdi_status == 'open' or null == $row->cdi_status)) {
                $cdi_rowcurrentorder = $cdi_rowcurrentorder+1 ;
                $array_for_carrier = WC_function_Colissimo::cdi_array_for_carrier( $row ) ;
                WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $array_for_carrier['order_id']);
                if ( $cdi_rowcurrentorder == 1) { // Open sequence
                  fwrite($out, "' *** Head of Coliship iMacros script " . "\r\n") ;
                  fwrite($out, 'TAG POS=1 TYPE=SPAN ATTR=TXT:Expédier<SP>un<SP>colis' . "\r\n") ;
                }
                // Begin imacro script for current order
fwrite($out, "' *** Head of Coliship script for order " . $array_for_carrier['order_id'] . "\r\n") ;

fwrite($out, "' *** Expeditor is supposed already registered in Colissimo " . "\r\n") ;
$x = WC_function_Colissimo::cdi_sanitize_colissimo_enligne($array_for_carrier['shipping_company']);
fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV>DIV>FORM>DIV>DIV:nth-of-type(13)>INPUT" BUTTON=0' . "\r\n") ;
fwrite($out, 'EVENTS TYPE=KEYPRESS SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV>DIV>FORM>DIV>DIV:nth-of-type(13)>INPUT" CHARS="' . $x . ' -' . $array_for_carrier['order_id'] . '-' . '"' . "\r\n") ;

fwrite($out, "' *** Commercial Name " . "\r\n") ;
$CompanyName = get_option('wc_settings_tab_colissimo_ws_sa_CompanyName');
fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV>DIV>FORM>DIV>DIV:nth-of-type(14)>INPUT" BUTTON=0' . "\r\n") ;
fwrite($out, 'EVENTS TYPE=KEYPRESS SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV>DIV>FORM>DIV>DIV:nth-of-type(14)>INPUT" CHARS="' . $CompanyName . '"' . "\r\n") ;

fwrite($out, "' *** Destinataire is a professionnel " . "\r\n") ;
fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV>DIV>FORM>DIV>DIV:nth-of-type(15)>DIV:nth-of-type(2)>BUTTON" BUTTON=0' . "\r\n") ;

fwrite($out, "' *** Company + Order num" . "\r\n") ;
$comp = apply_filters ('cdi_filterstring_gateway_companyandorderid', $array_for_carrier['shipping_company'] . ' -' . $array_for_carrier['order_id'] . '-', $array_for_carrier) ;
fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(2)>DIV>FORM>DIV>LABEL>SPAN" BUTTON=0' . "\r\n") ;
fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(2)>DIV>FORM>DIV:nth-of-type(2)>DIV>INPUT" BUTTON=0' . "\r\n") ;
fwrite($out, 'EVENTS TYPE=KEYPRESS SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(2)>DIV>FORM>DIV:nth-of-type(2)>DIV>INPUT" CHARS="' . $comp . '"' . "\r\n") ;

fwrite($out, "' *** Destination country " . "\r\n") ;
$countryname = mb_strtoupper(WC()->countries->countries[$array_for_carrier['shipping_country']]); 
  $countryname = WC_gateway_colissimo_coliship::CDI_str_to_noaccent($countryname);
  $countryname = str_replace(' (USA)','', $countryname);
fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(2)>DIV>FORM>DIV:nth-of-type(2)>DIV:nth-of-type(9)>INPUT" BUTTON=0' . "\r\n") ;
fwrite($out, 'EVENTS TYPE=KEYPRESS SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(2)>DIV>FORM>DIV:nth-of-type(2)>DIV:nth-of-type(9)>INPUT" KEYS="[8,8,8,8,8,8,8]"' . "\r\n") ;
fwrite($out, 'EVENTS TYPE=KEYPRESS SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(2)>DIV>FORM>DIV:nth-of-type(2)>DIV:nth-of-type(9)>INPUT" CHARS="' . $countryname . '"' . "\r\n") ;
fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(2)>DIV>FORM>DIV:nth-of-type(2)>DIV:nth-of-type(9)>DIV>UL>LI>SPAN" BUTTON=0' . "\r\n") ;

fwrite($out, "' *** Last name " . "\r\n") ;
$x = WC_function_Colissimo::cdi_sanitize_colissimo_enligne($array_for_carrier['shipping_last_name']);
fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(2)>DIV>FORM>DIV:nth-of-type(2)>DIV:nth-of-type(3)>INPUT" BUTTON=0' . "\r\n") ;
fwrite($out, 'EVENTS TYPE=KEYPRESS SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(2)>DIV>FORM>DIV:nth-of-type(2)>DIV:nth-of-type(3)>INPUT" CHARS="' . $x . '"' . "\r\n") ;

fwrite($out, "' *** First name " . "\r\n") ;
$x = WC_function_Colissimo::cdi_sanitize_colissimo_enligne($array_for_carrier['shipping_first_name']);
fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(2)>DIV>FORM>DIV:nth-of-type(2)>DIV:nth-of-type(4)>INPUT" BUTTON=0' . "\r\n") ;
fwrite($out, 'EVENTS TYPE=KEYPRESS SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(2)>DIV>FORM>DIV:nth-of-type(2)>DIV:nth-of-type(4)>INPUT" CHARS="' . $x . '"' . "\r\n") ;

fwrite($out, "' *** Adr line 1 " . "\r\n") ;
$x = WC_function_Colissimo::cdi_sanitize_colissimo_enligne($array_for_carrier['shipping_address_1']);
fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(2)>DIV>FORM>DIV:nth-of-type(2)>DIV:nth-of-type(5)>INPUT" BUTTON=0' . "\r\n") ;
fwrite($out, 'EVENTS TYPE=KEYPRESS SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(2)>DIV>FORM>DIV:nth-of-type(2)>DIV:nth-of-type(5)>INPUT" CHARS="' . $x . '"' . "\r\n") ;

fwrite($out, "' *** Adr line 2 " . "\r\n") ;
$x = WC_function_Colissimo::cdi_sanitize_colissimo_enligne($array_for_carrier['shipping_address_2']);
fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(2)>DIV>FORM>DIV:nth-of-type(2)>DIV:nth-of-type(6)>INPUT" BUTTON=0' . "\r\n") ;
fwrite($out, 'EVENTS TYPE=KEYPRESS SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(2)>DIV>FORM>DIV:nth-of-type(2)>DIV:nth-of-type(6)>INPUT" CHARS="' . $x . '"' . "\r\n") ;

fwrite($out, "' *** Postal code " . "\r\n") ;
fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(2)>DIV>FORM>DIV:nth-of-type(2)>DIV:nth-of-type(10)>DIV>INPUT" BUTTON=0' . "\r\n") ;
fwrite($out, 'EVENTS TYPE=KEYPRESS SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(2)>DIV>FORM>DIV:nth-of-type(2)>DIV:nth-of-type(10)>DIV>INPUT" CHARS="'  . $array_for_carrier['shipping_postcode'] . '"' . "\r\n") ;

fwrite($out, "' *** City and state " . "\r\n") ;
$x = WC_function_Colissimo::cdi_sanitize_colissimo_enligne($array_for_carrier['shipping_city_state']);
fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(2)>DIV>FORM>DIV:nth-of-type(2)>DIV:nth-of-type(10)>DIV:nth-of-type(2)>INPUT" BUTTON=0' . "\r\n") ;
fwrite($out, 'EVENTS TYPE=KEYPRESS SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(2)>DIV>FORM>DIV:nth-of-type(2)>DIV:nth-of-type(10)>DIV:nth-of-type(2)>INPUT" CHARS="' . $x . '"' . "\r\n") ;

fwrite($out, "' *** Phone " . "\r\n") ;
fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(2)>DIV>FORM>DIV:nth-of-type(2)>DIV:nth-of-type(11)>INPUT" BUTTON=0' . "\r\n") ;
fwrite($out, 'EVENTS TYPE=KEYPRESS SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(2)>DIV>FORM>DIV:nth-of-type(2)>DIV:nth-of-type(11)>INPUT" CHARS="' . $array_for_carrier['billing_phone'] . '"' . "\r\n") ;
fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(2)>DIV>FORM>DIV:nth-of-type(2)>DIV:nth-of-type(12)>INPUT" BUTTON=0' . "\r\n") ;
fwrite($out, 'EVENTS TYPE=KEYPRESS SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(2)>DIV>FORM>DIV:nth-of-type(2)>DIV:nth-of-type(12)>INPUT" CHARS="' . $array_for_carrier['billing_phone'] . '"' . "\r\n") ;

fwrite($out, "' *** Email " . "\r\n") ;
fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(2)>DIV>FORM>DIV:nth-of-type(2)>DIV:nth-of-type(13)>INPUT" BUTTON=0' . "\r\n") ;
fwrite($out, 'EVENTS TYPE=KEYPRESS SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(2)>DIV>FORM>DIV:nth-of-type(2)>DIV:nth-of-type(13)>INPUT" CHARS="' . $array_for_carrier['billing_email'] . '"' . "\r\n") ;

fwrite($out, "' *** Customer reference " . "\r\n") ;
fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(2)>DIV>FORM>DIV:nth-of-type(2)>DIV:nth-of-type(16)>INPUT" BUTTON=0' . "\r\n") ;
fwrite($out, 'EVENTS TYPE=KEYPRESS SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(2)>DIV>FORM>DIV:nth-of-type(2)>DIV:nth-of-type(16)>INPUT" CHARS="' . $array_for_carrier['order_id'] . '"' . "\r\n") ;

fwrite($out, "' *** Addressee Validation " . "\r\n") ;
fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(2)>DIV>FORM>DIV:nth-of-type(2)>DIV:nth-of-type(18)>DIV:nth-of-type(2)>BUTTON" BUTTON=0' . "\r\n") ;

fwrite($out, "' *** Parcel weight " . "\r\n") ;
fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(3)>DIV>DIV>DIV>DIV>DIV>DIV>DIV>INPUT" BUTTON=0' . "\r\n") ;
fwrite($out, 'EVENTS TYPE=KEYPRESS SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(3)>DIV>DIV>DIV>DIV>DIV>DIV>DIV>INPUT" CHARS="' . $array_for_carrier['parcel_weight']/1000 . '"' . "\r\n") ;

fwrite($out, "' *** Coliship Reference " . "\r\n") ;
fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(3)>DIV>DIV>DIV>DIV>DIV>DIV>DIV:nth-of-type(2)>INPUT" BUTTON=0' . "\r\n") ;
fwrite($out, 'EVENTS TYPE=KEYPRESS SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(3)>DIV>DIV>DIV>DIV>DIV>DIV>DIV:nth-of-type(2)>INPUT" CHARS="' . $array_for_carrier['order_id'] . "-" . $array_for_carrier['shipping_last_name'] . '"' . "\r\n") ;

fwrite($out, "' *** International option return fields " . "\r\n") ;
if ($array_for_carrier['return_type']) { 
  if ($array_for_carrier['return_type'] == 'no-return') {
    fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(3)>DIV>DIV>DIV>DIV>DIV:nth-of-type(3)>DIV>I" BUTTON=0' . "\r\n") ;
    fwrite($out, 'EVENT TYPE=KEYPRESS SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(3)>DIV>DIV>DIV>DIV>DIV:nth-of-type(3)>DIV>INPUT" CHAR="x"' . "\r\n") ;
    fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(3)>DIV>DIV>DIV>DIV>DIV:nth-of-type(3)>DIV>DIV>UL>LI" BUTTON=0' . "\r\n") ;
  }else{
    fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(3)>DIV>DIV>DIV>DIV>DIV:nth-of-type(3)>DIV>I" BUTTON=0' . "\r\n") ;
    fwrite($out, 'EVENT TYPE=KEYPRESS SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(3)>DIV>DIV>DIV>DIV>DIV:nth-of-type(3)>DIV>INPUT" CHAR="x"' . "\r\n") ;
    fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(3)>DIV>DIV>DIV>DIV>DIV:nth-of-type(3)>DIV>DIV>UL>LI:nth-of-type(2)" BUTTON=0' . "\r\n") ;
  }
}

fwrite($out, "' *** Parcel type " . "\r\n") ;
if ($array_for_carrier['parcel_type'] == 'colis-standard') {
  fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(3)>DIV>DIV>DIV>DIV>DIV:nth-of-type(4)>DIV>DIV>LABEL:nth-of-type(2)>INPUT" BUTTON=0' . "\r\n") ;
}else{
  fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(3)>DIV>DIV>DIV>DIV>DIV:nth-of-type(4)>DIV>DIV:nth-of-type(2)>LABEL:nth-of-type(2)>INPUT" BUTTON=0' . "\r\n") ;
}

fwrite($out, "' *** Signature delivery ? " . "\r\n") ;
if ($array_for_carrier['signature'] == 'yes' && WC_function_Colissimo::cdi_colissimo_withoutsign_country($array_for_carrier['shipping_country']) == true) {
  fwrite($out, 'TAG POS=1 TYPE=SPAN ATTR=CLASS:shape&&DATA-REACTID:.0.2.0.1.$2.0.2.0.0.0.1.$field=1signature.1&&TXT:' . "\r\n") ;
  fwrite($out, 'TAG POS=1 TYPE=INPUT:CHECKBOX ATTR=ID:signature CONTENT=NO' . "\r\n") ;
  fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(3)>DIV>DIV>DIV>DIV>DIV>DIV:nth-of-type(2)>LABEL>SPAN" BUTTON=0' . "\r\n") ;
}

fwrite($out, "' *** Insurance to add ? " . "\r\n") ;
$addcompensationiim = $array_for_carrier['additional_compensation'];
if (!$addcompensationiim) $addcompensationiim = 'no' ;
$amontcompensationiim = $array_for_carrier['compensation_amount'];
if ($addcompensationiim !== 'non' && $amontcompensationiim) {
  $x = floor(($amontcompensationiim)/150)+1 ;
  fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(3)>DIV>DIV>DIV>DIV:nth-of-type(2)>DIV:nth-of-type(2)>DIV>DIV>INPUT" BUTTON=0' . "\r\n") ;
  fwrite($out, 'EVENTS TYPE=KEYPRESS SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(3)>DIV>DIV>DIV>DIV:nth-of-type(2)>DIV:nth-of-type(2)>DIV>DIV>INPUT" CHARS="x"' . "\r\n") ;
  fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(3)>DIV>DIV>DIV>DIV:nth-of-type(2)>DIV:nth-of-type(2)>DIV>DIV>DIV>UL>LI:nth-of-type(' . $x . ')" BUTTON=0' . "\r\n") ;
}

fwrite($out, "' *** Cn23 general fields " . "\r\n") ;
if ($array_for_carrier['cn23_category']) { 

  fwrite($out, "' *** Cn23 Category " . "\r\n") ;
  fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(3)>DIV>DIV>DIV>DIV:nth-of-type(3)>DIV>DIV:nth-of-type(2)>DIV>DIV>INPUT" BUTTON=0' . "\r\n") ;
  fwrite($out, 'EVENTS TYPE=KEYPRESS SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(3)>DIV>DIV>DIV>DIV:nth-of-type(3)>DIV>DIV:nth-of-type(2)>DIV>DIV>INPUT" CHARS="x"' . "\r\n") ;
  fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(3)>DIV>DIV>DIV>DIV:nth-of-type(3)>DIV>DIV:nth-of-type(2)>DIV>DIV>DIV>UL>LI:nth-of-type(' . $array_for_carrier['cn23_category'] . ')" BUTTON=0' . "\r\n") ;

  fwrite($out, "' *** Cn23 article fields 0 to 99 " . "\r\n") ;
  for ($nbart = 0; $nbart <= 99; $nbart++) {
    if (!isset ($array_for_carrier['cn23_article_description_' . $nbart])) break;

    if ($nbart !== 0) {
      fwrite($out, "' *** Go to the next cn23 article" . "\r\n") ;
      fwrite($out, 'TAG POS=1 TYPE=BUTTON ATTR=TXT:Ajouter<SP>un<SP>article' . "\r\n") ;
    }else{
      fwrite($out, "' *** Cn23 Add article" . "\r\n") ;
      fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV>DIV>MAIN>DIV>DIV>DIV:nth-of-type(3)>DIV>DIV>DIV>DIV:nth-of-type(3)>DIV:nth-of-type(2)>DIV:nth-of-type(2)>BUTTON" BUTTON=0' . "\r\n") ;
    }

    fwrite($out, "' *** Cn23 Art description" . "\r\n") ;
    fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV:nth-of-type(5)>DIV>DIV>DIV:nth-of-type(2)>DIV>DIV>DIV>INPUT" BUTTON=0' . "\r\n") ;
    fwrite($out, 'EVENTS TYPE=KEYPRESS SELECTOR="HTML>BODY>DIV:nth-of-type(5)>DIV>DIV>DIV:nth-of-type(2)>DIV>DIV>DIV>INPUT" CHARS="' . $array_for_carrier['cn23_article_description_' . $nbart] . '"' . "\r\n") ;

    fwrite($out, "' *** Cn23 Art weight" . "\r\n") ;
    fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV:nth-of-type(5)>DIV>DIV>DIV:nth-of-type(2)>DIV>DIV>DIV:nth-of-type(2)>DIV>DIV>DIV>INPUT" BUTTON=0' . "\r\n") ;
    fwrite($out, 'EVENTS TYPE=KEYPRESS SELECTOR="HTML>BODY>DIV:nth-of-type(5)>DIV>DIV>DIV:nth-of-type(2)>DIV>DIV>DIV:nth-of-type(2)>DIV>DIV>DIV>INPUT" CHARS="' . $array_for_carrier['cn23_article_weight_' . $nbart]/1000 . '"' . "\r\n") ;

    fwrite($out, "' *** Cn23 Art quantity" . "\r\n") ;
    fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV:nth-of-type(5)>DIV>DIV>DIV:nth-of-type(2)>DIV>DIV>DIV:nth-of-type(2)>DIV>DIV:nth-of-type(2)>DIV>INPUT" BUTTON=0' . "\r\n") ;
    fwrite($out, 'EVENT TYPE=KEYPRESS SELECTOR="HTML>BODY>DIV:nth-of-type(5)>DIV>DIV>DIV:nth-of-type(2)>DIV>DIV>DIV:nth-of-type(2)>DIV>DIV:nth-of-type(2)>DIV>INPUT" CHAR="' . $array_for_carrier['cn23_article_quantity_' . $nbart] . '"' . "\r\n") ;

    fwrite($out, "' *** Cn23 Art price" . "\r\n") ;
    fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV:nth-of-type(5)>DIV>DIV>DIV:nth-of-type(2)>DIV>DIV>DIV:nth-of-type(2)>DIV>DIV:nth-of-type(3)>DIV>INPUT" BUTTON=0' . "\r\n") ;
    fwrite($out, 'EVENTS TYPE=KEYPRESS SELECTOR="HTML>BODY>DIV:nth-of-type(5)>DIV>DIV>DIV:nth-of-type(2)>DIV>DIV>DIV:nth-of-type(2)>DIV>DIV:nth-of-type(3)>DIV>INPUT" CHARS="' . $array_for_carrier['cn23_article_value_' . $nbart] . '"' . "\r\n") ;

    fwrite($out, "' *** Cn23 Art Origine Country" . "\r\n") ;
    fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV:nth-of-type(5)>DIV>DIV>DIV:nth-of-type(2)>DIV>DIV>DIV:nth-of-type(3)>DIV>DIV>INPUT" BUTTON=0' . "\r\n") ;
    $origcountryname = mb_strtoupper(WC()->countries->countries[$array_for_carrier['cn23_article_origincountry_' . $nbart]]); 
    $origcountryname = WC_gateway_colissimo_coliship::CDI_str_to_noaccent($origcountryname);
    $origcountryname = str_replace(' (USA)','', $origcountryname);
    fwrite($out, 'EVENTS TYPE=KEYPRESS SELECTOR="HTML>BODY>DIV:nth-of-type(5)>DIV>DIV>DIV:nth-of-type(2)>DIV>DIV>DIV:nth-of-type(3)>DIV>DIV>INPUT" CHARS="' . $origcountryname . '"' . "\r\n") ;
    fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV:nth-of-type(5)>DIV>DIV>DIV:nth-of-type(2)>DIV>DIV>DIV:nth-of-type(3)>DIV>DIV>DIV>UL>LI>SPAN" BUTTON=0' . "\r\n") ;

    fwrite($out, "' *** Cn23 Art HStariff" . "\r\n") ;
    if ($array_for_carrier['cn23_category'] == '3') {
      fwrite($out, 'EVENT TYPE=CLICK SELECTOR="HTML>BODY>DIV:nth-of-type(5)>DIV>DIV>DIV:nth-of-type(2)>DIV>DIV>DIV:nth-of-type(3)>DIV>DIV:nth-of-type(2)>DIV>INPUT" BUTTON=0' . "\r\n") ;
      fwrite($out, 'EVENTS TYPE=KEYPRESS SELECTOR="HTML>BODY>DIV:nth-of-type(5)>DIV>DIV>DIV:nth-of-type(2)>DIV>DIV>DIV:nth-of-type(3)>DIV>DIV:nth-of-type(2)>DIV>INPUT" CHARS="' . $array_for_carrier['cn23_article_hstariffnumber_' . $nbart] . '"' . "\r\n") ;
    }

    fwrite($out, "' *** Register the cn23 article" . "\r\n") ;
    fwrite($out, 'TAG POS=1 TYPE=BUTTON ATTR=TXT:Ajouter' . "\r\n") ;
  }
}

fwrite($out, "' *** Put in cart " . "\r\n") ;
fwrite($out, 'TAG POS=1 TYPE=SPAN ATTR=CLASS:shape&&DATA-REACTID:.0.2.0.1.$2.0.2.0.3.1.$field=1accepterCGU.1&&TXT:' . "\r\n") ;
fwrite($out, 'TAG POS=1 TYPE=INPUT:CHECKBOX ATTR=ID:accepterCGU CONTENT=YES' . "\r\n") ;
fwrite($out, 'TAG POS=1 TYPE=BUTTON ATTR=TXT:Ajouter<SP>au<SP>panier' . "\r\n") ;

                if ($cdi_rowcurrentorder < $cdi_nbrorderstodo) { // Close sequence
                  fwrite($out, "' *** Game over for next Coliship parcel " . "\r\n") ;
//                  fwrite($out, 'TAG POS=1 TYPE=A ATTR=TXT:Ajouter<SP>un<SP>nouveau<SP>colis' . "\r\n") ;
                }else{
                  fwrite($out, 'WAIT SECONDS=2' . "\r\n") ;
                  fwrite($out, 'PROMPT "' . __('Here we are !', 'colissimo-delivery-integration') . ' \r\n ' . __('No scripting error? So now you can check and / or change your shipments.', 'colissimo-delivery-integration') . ' \r\n ' . __('As soon as everything is ok, you can print your labels.', 'colissimo-delivery-integration') . '"' . "\r\n") ;
                  fwrite($out, "' *** Tail of Coliship iMacros script " . "\r\n") ;
                } 
                // End imacro script

              } // End !$cdi_tracking
            } // End row
            fclose($out);
            $message = number_format_i18n( $cdi_nbrorderstodo ) . __(' parcels inserted in iMacros script file.', 'colissimo-delivery-integration') ;
            update_option( 'cdi_notice_display', $message );
            $sendback = admin_url() . 'admin.php?page=Colissimo-page' ; 
//          wp_redirect($sendback); // Dont work because header - another way to find 
            exit () ;
          } // End cdi_nbrorderstodo
        } //End $results
     } // End current_user_can
    } // End cdi_coliship_run
  } // cdi_gateway_coliship
} // End class
?>
