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
            $thecsvfile = 'Coliship-Import-' . date('YmdHis') . '.csv' ;
            header('Content-type: text/csv' );
            header('Content-Disposition: inline; filename=' . $thecsvfile );
            foreach ($results as $row) {
              $cdi_tracking = $row->cdi_tracking;
              if (!$cdi_tracking && ($row->cdi_status == 'open' or null == $row->cdi_status)) {
                $cdi_rowcurrentorder = $cdi_rowcurrentorder+1 ;
                $array_for_carrier = WC_function_Colissimo::cdi_array_for_carrier( $row ) ;
                WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $array_for_carrier['order_id']);
                // Open sequence
                if ( $cdi_rowcurrentorder == 1) {
                  // Nothing to do
                }



                $clsgabarit = array( "B" => "",  "C" => "",  "D" => "",  "E" => "",  "F" => "",  "G" => "",  "H" => "",  "I" => "",  "J" => "",  "K" => "",  "L" => "",  "M" => "",  "N" => "",  "O" => "",  "P" => "",  "Q" => "",  "R" => "",  "S" => "",  "T" => "",  "U" => "",  "V" => "",  "W" => "",  "X" => "",  "Y" => "",  "Z" => "",  "AA" => "",  "AB" => "",  "AC" => "",  "AD" => "",  "AE" => "",  "AF" => "",  "AG" => "",  "AH" => "",  "AI" => "",  "AJ" => "",  "AK" => "",  "AL" => "",  "AM" => "",  "AN" => "",  "AO" => "",  "AP" => "",  "AQ" => "",  "AR" => "",  "AS" => "",  "AT" => "",  "AU" => "",  "AV" => "",  "AW" => "",  "AX" => "",  "AY" => "",  "AZ" => "",  "BA" => "",  "BB" => "",  "BC" => "",  "BD" => "",  "BE" => "",  "BF" => "",  "BG" => "",  "BH" => "",  "BI" => "",  "BJ" => "",  "BK" => "",  "BL" => "",  "BM" => "",  "BN" => "",  "BO" => "",  "BP" => "",  "BQ" => "",  "BR" => "",  "BS" => "",  "BT" => "",  "BU" => "",  "BV" => "",  "BW" => "",  "BX" => "",  "BY" => "",  "BZ" => "",  "CA" => "",  "CB" => "",  "CC" => "",  "CD" => "",  "CE" => "",  "CF" => "",  "CG" => "",  "CH" => "",  "CI" => "",  "CJ" => "",  "CK" => "",  "CL" => "",  "CM" => "",  "CN" => "",  "CO" => "",  "CP" => "",  "CQ" => "",  "CR" => "",  "CS" => "",  "CT" => "",  "CU" => "",  "CV" => "",  "CW" => "",  "CX" => "",  "CY" => "",  "CZ" => "",  "DA" => "",  "DB" => "",  "DC" => "",  "DD" => "",  "DE" => "",  "DF" => "",  "DG" => "",  "DH" => "",  "DI" => "",  "DJ" => "") ;


                $clsgabarit['B'] = get_option('wc_settings_tab_colissimo_ws_ContractNumber') ; 

                // Compute $productcode
                $productcode = get_post_meta($row->cdi_order_id, '_cdi_meta_productCode', true) ; 
                $pickupLocationId = get_post_meta($row->cdi_order_id, '_cdi_meta_pickupLocationId', true) ;
                $shippingcountry = $array_for_carrier['shipping_country'] ;
                if (null == $productcode OR $productcode == '') {
                  if (!(strpos(get_option('wc_settings_tab_colissimo_ws_FranceCountryCodes'), $shippingcountry) === false)) { 
                    $switch = 'france' ;
                  }elseif (!(strpos(get_option('wc_settings_tab_colissimo_ws_OutreMerCountryCodes'), $shippingcountry) === false)) { 
                    $switch = 'outremer' ;
                  }elseif (!(strpos(get_option('wc_settings_tab_colissimo_ws_EuropeCountryCodes'), $shippingcountry) === false)) { 
                    $switch = 'europe' ;
                  }else{
                    $switch = 'international' ;
                  }
                  switch( $switch ) {
                    case 'france':
                      $arrayproductcode = explode (',', get_option('wc_settings_tab_colissimo_ws_FranceProductCodes')) ;
                      if ($pickupLocationId) {
                        $productcode = $arrayproductcode[2] ;
                      }else{
                        if ($array_for_carrier['signature'] == 'yes') {
                          $productcode = $arrayproductcode[1] ;
                        }else{
                          $productcode = $arrayproductcode[0] ;
                        }
                      }
                      break;
                    case 'outremer':
                      $arrayproductcode = explode (',', get_option('wc_settings_tab_colissimo_ws_OutreMerProductCodes')) ;
                      if ($pickupLocationId) {
                        $productcode = $arrayproductcode[2] ;
                      }else{
                        if ($array_for_carrier['signature'] == 'yes') {
                          $productcode = $arrayproductcode[1] ;
                        }else{
                          $productcode = $arrayproductcode[0] ;
                        }
                      }
                      break;
                    case 'europe':
                      $arrayproductcode = explode (',', get_option('wc_settings_tab_colissimo_ws_EuropeProductCodes')) ;
                      if ($pickupLocationId) {
                        $productcode = $arrayproductcode[2] ;
                      }else{
                        if ($array_for_carrier['signature'] == 'yes') {
                          $productcode = $arrayproductcode[1] ;
                        }else{
                          $productcode = $arrayproductcode[0] ;
                        }
                      }
                      break;
                    case 'international':
                      $arrayproductcode = explode (',', get_option('wc_settings_tab_colissimo_ws_InternationalProductCodes')) ;
                      if ($pickupLocationId) {
                        $productcode = $arrayproductcode[2] ;
                      }else{
                        if ($array_for_carrier['signature'] == 'yes') {
                          $productcode = $arrayproductcode[1] ;
                        }else{
                          $productcode = $arrayproductcode[0] ;
                        }
                      }
                      break;
                  } // End switch
                }

                // process of exception product codes
                $arrayexceptionproductcode = explode(',', get_option('wc_settings_tab_colissimo_ws_ExceptionProductCodes')) ;
                foreach ($arrayexceptionproductcode as $exceptionproductcode) {
                  $arraytoreplace = explode('=', $exceptionproductcode) ;
                  $arraytoreplace = array_map("trim", $arraytoreplace);
                  if ($productcode == $arraytoreplace[0]) {
                    $productcode = $arraytoreplace[1] ;
                    break;
                  } 
                }
                // End Compute $productcode
                $clsgabarit['D'] = $productcode;  
                $calc = get_option('wc_settings_tab_colissimo_ws_OffsetDepositDate');
                $clsgabarit['E'] = date('Y-m-d',strtotime("+$calc day")); 
                $clsgabarit['BE'] = $array_for_carrier['cn23_shipping']*100;  // not clear : as if the data required by cn23 is shipping cost ?
                $clsgabarit['C'] = $array_for_carrier['order_id'];  
                $clsgabarit['F'] = get_option('wc_settings_tab_colissimo_ws_sa_CompanyName'); 
                $ReturnTypeChoice = str_replace(array('no-return', 'pay-for-return'), array('2', '3'), $array_for_carrier['return_type']);
                if (!$ReturnTypeChoice) $ReturnTypeChoice = '2'; // fallback to be accepted by Colissimo
                $clsgabarit['N'] = $ReturnTypeChoice; 
                $clsgabarit['I'] = $array_for_carrier['compensation_amount']*100;
                $weight = $array_for_carrier['parcel_weight']/1000;
                $clsgabarit['G'] = $weight; 
                $NonMachinable = str_replace(array('colis-standard', 'colis-volumineux', 'colis-rouleau'), array('0', '1', '1'), $array_for_carrier['parcel_type']);
                $clsgabarit['J'] = $NonMachinable; 
                $clsgabarit['L'] = '0'; 

//              $clsgabarit['pickupLocationId'] = $pickupLocationId; // pickupLocationId not found in Coliship table ????

                $clsgabarit['BC'] = str_replace(array('no', 'yes'), array('0', '1'), get_option('wc_settings_tab_colissimo_IncludeCustomsDeclarations')); 
                $clsgabarit['BN'] = $array_for_carrier['cn23_category']; 

                $clsgabarit['P'] = get_option('wc_settings_tab_colissimo_ws_sa_CompanyName'); 

                $clsgabarit['S'] = get_option('wc_settings_tab_colissimo_ws_sa_Line1'); 
                $clsgabarit['U'] = get_option('wc_settings_tab_colissimo_ws_sa_Line2');      

                $clsgabarit['W'] = get_option('wc_settings_tab_colissimo_ws_sa_CountryCode'); 
                $clsgabarit['X'] = get_option('wc_settings_tab_colissimo_ws_sa_City'); 
                $clsgabarit['Y'] = get_option('wc_settings_tab_colissimo_ws_sa_ZipCode'); 

                $clsgabarit['AD'] = get_option('wc_settings_tab_colissimo_ws_sa_Email'); 

                $comp = apply_filters ('cdi_filterstring_gateway_companyandorderid', $array_for_carrier['shipping_company'] . ' -' . $array_for_carrier['order_id'] . '-', $array_for_carrier) ;
                $clsgabarit['AJ'] = $comp; 
                $clsgabarit['AL'] = $array_for_carrier['shipping_last_name']; 
                $clsgabarit['AM'] = $array_for_carrier['shipping_first_name']; 

                $clsgabarit['AN'] = $array_for_carrier['shipping_address_1']; 
                $clsgabarit['AP'] = $array_for_carrier['shipping_address_2']; 

                $clsgabarit['AR'] = $array_for_carrier['shipping_country'];  
                $clsgabarit['AS'] = $array_for_carrier['shipping_city_state']; 
                $clsgabarit['AT'] = $array_for_carrier['shipping_postcode']; 

                $PhoneNumber = WC_function_Colissimo::cdi_sanitize_colissimophone($array_for_carrier['billing_phone']);
                $clsgabarit['AU'] = $PhoneNumber;
                $MobileNumber = WC_function_Colissimo::cdi_sanitize_colissimoMobileNumber($array_for_carrier['billing_phone'], $array_for_carrier['shipping_country']);
                $MobileNumber = apply_filters( 'cdi_filterstring_auto_mobilenumber', $MobileNumber, $row->cdi_order_id) ;
                if (isset ($MobileNumber) && $MobileNumber !== '') {
                  $clsgabarit['AV'] = $MobileNumber; // Set only if it is a mobile
                }

                $clsgabarit['BA'] = $array_for_carrier['billing_email']; 

                // Build the CLS line
                $clsline = "";
                foreach ($clsgabarit as $cell) {
                  $clsline .= ',' . $cell ;
                }
                $clsline = 'CLS' . $clsline . "\r\n";
                fwrite($out, $clsline);

                // Add cn23 articles 0 to 99 if exist
                for ($nbart = 0; $nbart <= 99; $nbart++) {
                  if (!isset ($array_for_carrier['cn23_article_description_' . $nbart]) or $array_for_carrier['cn23_article_description_' . $nbart] == "" ) break;
                  $cn2gabarit = array( "B" => "",  "C" => "",  "D" => "",  "E" => "",  "F" => "",  "G" => "",  "H" => "",  "I" => "",  "J" => "",  "K" => "") ;
                  $cn2gabarit['B'] = $array_for_carrier['cn23_article_description_' . $nbart]; 
                  $cn2gabarit['C'] = $array_for_carrier['cn23_article_quantity_' . $nbart]; 
                  $cn2gabarit['D'] = $array_for_carrier['cn23_article_weight_' . $nbart]/1000; // ??
                  $cn2gabarit['E'] = $array_for_carrier['cn23_article_value_' . $nbart]; // ?
                  $cn2gabarit['F'] = $array_for_carrier['cn23_article_hstariffnumber_' . $nbart];
                  $cn2gabarit['G'] = $array_for_carrier['cn23_article_origincountry_' . $nbart]; 
                  // Build the CN2 line
                  $cn2line = "";
                  foreach ($cn2gabarit as $cell) {
                    $cn2line .= ',' . $cell ;
                  }
                  $cn2line = 'CN2' . $cn2line . "\r\n";
                  fwrite($out, $cn2line);
                }
              } // End !$cdi_tracking
            } // End row
            fclose($out);
            $message = number_format_i18n( $cdi_nbrorderstodo ) . __(' parcels inserted in Coliship Import file.', 'colissimo-delivery-integration') ;
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
