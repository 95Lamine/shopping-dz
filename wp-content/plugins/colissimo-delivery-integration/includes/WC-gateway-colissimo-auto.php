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
/* Gateway auto                                                                       */
/****************************************************************************************/

class WC_gateway_colissimo_auto {
  public static function init() {
    add_action('admin_init',  __CLASS__ . '::cdi_auto_run');
    require_once dirname(__FILE__) . '/ColissimoAF/ColissimoAFAutoload.php';
  }

  public static function cdi_auto_run() {
    if ( isset($_POST['cdi_gateway_auto']) && isset( $_POST['cdi_auto_run_nonce'] ) && wp_verify_nonce( $_POST['cdi_auto_run_nonce'], 'cdi_auto_run' ) ) {
      global $woocommerce;
      global $wpdb;
      global $order_id;
      global $base64label;
      global $base64cn23;
      if (current_user_can('cdi_gateway')) {
        $results = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "cdi");
        if (count($results)) {
          $cdi_nbrorderstodo = 0 ;
          $cdi_rowcurrentorder = 0 ;
          $cdi_nbrtrkcode = 0 ;
          $cdi_nbrwscorrect = 0;
          foreach ($results as $row) {
            $cdi_tracking = $row->cdi_tracking;
            if (!$cdi_tracking && ($row->cdi_status == 'open' or null == $row->cdi_status)) {
              $cdi_nbrorderstodo = $cdi_nbrorderstodo +1 ;             
            }
          }
          if ( $cdi_nbrorderstodo > 0) {

            foreach ($results as $row) {
              $cdi_tracking = $row->cdi_tracking;
              $errorws = null ;
              if (!$cdi_tracking && ($row->cdi_status == 'open' or null == $row->cdi_status)) {
                $cdi_rowcurrentorder = $cdi_rowcurrentorder+1 ;
                $array_for_carrier = WC_function_Colissimo::cdi_array_for_carrier( $row ) ;
                if ( $cdi_rowcurrentorder == 1) { 
                  // Open sequence
                  require_once dirname(__FILE__) . '/ColissimoAF/ColissimoAFAutoload.php';
                }
                // ********************************* Begin Colissimo Web service *********************************    
                // Ref : https://www.colissimo.entreprise.laposte.fr/fr/system/files/imagescontent/docs/spec_ws_affranchissement.pdf
                // Document Technique - Version Avril 2016 - Spécifications du Web Service d’Affranchissement Colissimo

                // Initiate structure                
                $wsdl = array();
                $wsdl[ColissimoAFWsdlClass::WSDL_URL] = 'http://ws.Colissimo.fr/sls-ws/SlsServiceWS?wsdl';
                $wsdl[ColissimoAFWsdlClass::WSDL_CACHE_WSDL] = WSDL_CACHE_NONE;
                $wsdl[ColissimoAFWsdlClass::WSDL_TRACE] = true;

                $wsdlObject = new ColissimoAFStructGenerateLabelRequest($wsdl);
                $wsdlObject->outputFormat = new ColissimoAFStructOutputFormat();
                $wsdlObject->letter = new ColissimoAFStructLetter();
                $wsdlObject->letter->service = new ColissimoAFStructService();
                $wsdlObject->letter->parcel = new ColissimoAFStructParcel();
                $wsdlObject->letter->customsDeclarations = new ColissimoAFStructCustomsDeclarations();
                $wsdlObject->letter->customsDeclarations->contents = new ColissimoAFStructContents();
                $wsdlObject->letter->customsDeclarations->contents->category = new ColissimoAFStructCategory();
                $wsdlObject->letter->sender = new ColissimoAFStructSender();
                $wsdlObject->letter->sender->address = new ColissimoAFStructAddress();
                $wsdlObject->letter->addressee = new ColissimoAFStructAddressee();
                $wsdlObject->letter->addressee->address = new ColissimoAFStructAddress();

                // Initiate datas
                $order_id = $array_for_carrier['order_id'];

                $wsdlObject->setContractNumber(get_option('wc_settings_tab_colissimo_ws_ContractNumber')); 
                $wsdlObject->setPassword(get_option('wc_settings_tab_colissimo_ws_Password'));

                $wsdlObject->outputFormat->setX(get_option('wc_settings_tab_colissimo_ws_X'));
                $wsdlObject->outputFormat->setY(get_option('wc_settings_tab_colissimo_ws_Y'));
                $wsdlObject->outputFormat->setOutputPrintingType(get_option('wc_settings_tab_colissimo_ws_OutputPrintingType')); 
                //$wsdlObject->outputFormat->setReturnType('SendPDFLinkByMail'); 

                // Compute $productcode
                $productcode = get_post_meta($order_id, '_cdi_meta_productCode', true) ; 
                $pickupLocationId = get_post_meta($order_id, '_cdi_meta_pickupLocationId', true) ;
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
                $wsdlObject->letter->service->setProductCode($productcode);  
                $calc = get_option('wc_settings_tab_colissimo_ws_OffsetDepositDate');
                $wsdlObject->letter->service->setDepositDate(date('Y-m-d',strtotime("+$calc day"))); 
                $wsdlObject->letter->service->setTotalAmount($array_for_carrier['cn23_shipping']*100);  // not clear : as if the data required by cn23 is shipping cost ?
                $wsdlObject->letter->service->setOrderNumber($array_for_carrier['order_id']);  
                $wsdlObject->letter->service->setCommercialName(get_option('wc_settings_tab_colissimo_ws_sa_CompanyName')); 
                $ReturnTypeChoice = str_replace(array('no-return', 'pay-for-return'), array('2', '3'), $array_for_carrier['return_type']);
                if (!$ReturnTypeChoice) $ReturnTypeChoice = '2'; // fallback to be accepted by Colissimo
                $wsdlObject->letter->service->setReturnTypeChoice($ReturnTypeChoice); 
                $wsdlObject->letter->parcel->setInsuranceValue($array_for_carrier['compensation_amount']*100);
                $weight = $array_for_carrier['parcel_weight']/1000;
                $wsdlObject->letter->parcel->setWeight($weight); 
                $NonMachinable = str_replace(array('colis-standard', 'colis-volumineux', 'colis-rouleau'), array('0', '1', '1'), $array_for_carrier['parcel_type']);
                $wsdlObject->letter->parcel->setNonMachinable($NonMachinable); 
                //$wsdlObject->letter->parcel->setInstructions('AN0-70');
                $ReturnReceipt = str_replace(array('non', 'oui'), array('0', '1'), $array_for_carrier['returnReceipt']);
                if (!$ReturnReceipt) $ReturnReceipt = '0'; 
                $wsdlObject->letter->parcel->setreturnReceipt($ReturnReceipt); 
                $wsdlObject->letter->parcel->setpickupLocationId($pickupLocationId); // fieds X00 to do for international shipping
                $Ftd = str_replace(array('non', 'oui'), array('0', '1'), $array_for_carrier['ftd']);
                if (!$Ftd) $Ftd = '0'; 
                $wsdlObject->letter->parcel->setftd($Ftd); 
                $wsdlObject->letter->customsDeclarations->setIncludeCustomsDeclarations(get_option('wc_settings_tab_colissimo_IncludeCustomsDeclarations')); 
                $wsdlObject->letter->customsDeclarations->contents->category->setValue($array_for_carrier['cn23_category']); 
                // Add cn23 article 0
                $art = new ColissimoAFStructArticle();
                $art->setDescription($array_for_carrier['cn23_article_description_0']); 
                $art->setQuantity($array_for_carrier['cn23_article_quantity_0']); 
                $art->setWeight($array_for_carrier['cn23_article_weight_0']/1000); // ??
                $art->setValue($array_for_carrier['cn23_article_value_0']); // ?
                $art->setHsCode($array_for_carrier['cn23_article_hstariffnumber_0']);
                $art->setOriginCountry($array_for_carrier['cn23_article_origincountry_0']); 
                $wsdlObject->letter->customsDeclarations->contents->article[] = $art ;
                // Add cn23 articles 1 to 99 if exist
                for ($nbart = 1; $nbart <= 99; $nbart++) {
                  if (!isset ($array_for_carrier['cn23_article_description_' . $nbart])) break;
                  $art = new ColissimoAFStructArticle();
                  $art->setDescription($array_for_carrier['cn23_article_description_' . $nbart]); 
                  $art->setQuantity($array_for_carrier['cn23_article_quantity_' . $nbart]); 
                  $art->setWeight($array_for_carrier['cn23_article_weight_' . $nbart]/1000); // ??
                  $art->setValue($array_for_carrier['cn23_article_value_' . $nbart]); // ?
                  $art->setHsCode($array_for_carrier['cn23_article_hstariffnumber_' . $nbart]);
                  $art->setOriginCountry($array_for_carrier['cn23_article_origincountry_' . $nbart]); 
                  $wsdlObject->letter->customsDeclarations->contents->article[] = $art ;
                }

                $wsdlObject->letter->sender->setSenderParcelRef($array_for_carrier['order_id']); 
                $wsdlObject->letter->sender->address->setCompanyName(get_option('wc_settings_tab_colissimo_ws_sa_CompanyName')); 
                //$wsdlObject->letter->sender->address->setLastName('AN0-35');
                //$wsdlObject->letter->sender->address->setFirstName('AN0-35');
                //$wsdlObject->letter->sender->address->setLine0('AN0-35');
                $wsdlObject->letter->sender->address->setLine2(get_option('wc_settings_tab_colissimo_ws_sa_Line1')); 
                $wsdlObject->letter->sender->address->setLine1(get_option('wc_settings_tab_colissimo_ws_sa_Line2'));      
                //$wsdlObject->letter->sender->address->setLine3('AN0-35');
                $wsdlObject->letter->sender->address->setCountryCode(get_option('wc_settings_tab_colissimo_ws_sa_CountryCode')); 
                $wsdlObject->letter->sender->address->setCity(get_option('wc_settings_tab_colissimo_ws_sa_City')); 
                $wsdlObject->letter->sender->address->setZipCode(get_option('wc_settings_tab_colissimo_ws_sa_ZipCode')); 
                //$wsdlObject->letter->sender->address->setPhoneNumber('AN15');
                //$wsdlObject->letter->sender->address->setMobileNumber('AN10');
                //$wsdlObject->letter->sender->address->setDoorCode1('AN8');
                //$wsdlObject->letter->sender->address->setDoorCode2('AN8');
                $wsdlObject->letter->sender->address->setEmail(get_option('wc_settings_tab_colissimo_ws_sa_Email')); 
                //$wsdlObject->letter->sender->address->setIntercom('AN30');
                //$wsdlObject->letter->sender->address->setLanguage('FR');

                $comp = apply_filters ('cdi_filterstring_gateway_companyandorderid', $array_for_carrier['shipping_company'] . ' -' . $array_for_carrier['order_id'] . '-', $array_for_carrier) ;
                $wsdlObject->letter->addressee->address->setCompanyName($comp); 
                $wsdlObject->letter->addressee->address->setLastName($array_for_carrier['shipping_last_name']); 
                $wsdlObject->letter->addressee->address->setFirstName($array_for_carrier['shipping_first_name']); 
                $wsdlObject->letter->addressee->address->setLine2($array_for_carrier['shipping_address_1']); 
                $wsdlObject->letter->addressee->address->setLine1($array_for_carrier['shipping_address_2']); 
                if (WC_function_Colissimo::cdi_isconnected()) { 
                  eval (WC_function_Colissimo::cdi_eval('7')) ; 
                  $wsdlObject->letter->addressee->address->setLine0($array_for_carrier['shipping_address_3']);
                  $wsdlObject->letter->addressee->address->setLine3($array_for_carrier['shipping_address_4']);
                  eval (WC_function_Colissimo::cdi_eval('12')) ;
                }
                $wsdlObject->letter->addressee->address->setCountryCode($array_for_carrier['shipping_country']);  
                $wsdlObject->letter->addressee->address->setCity($array_for_carrier['shipping_city_state']); 
                $wsdlObject->letter->addressee->address->setZipCode($array_for_carrier['shipping_postcode']); 

                $PhoneNumber = WC_function_Colissimo::cdi_sanitize_colissimophone($array_for_carrier['billing_phone']);
                $wsdlObject->letter->addressee->address->setPhoneNumber($PhoneNumber);
                $MobileNumber = WC_function_Colissimo::cdi_sanitize_colissimoMobileNumber($array_for_carrier['billing_phone'], $array_for_carrier['shipping_country']);
                $MobileNumber = apply_filters( 'cdi_filterstring_auto_mobilenumber', $MobileNumber, $order_id) ;
                if (isset ($MobileNumber) && $MobileNumber !== '') {
                  $wsdlObject->letter->addressee->address->setMobileNumber($MobileNumber); // Set only if it is a mobile
                }

                //$wsdlObject->letter->addressee->address->setDoorCode1('AN8');
                //$wsdlObject->letter->addressee->address->setDoorCode2('AN8');
                $wsdlObject->letter->addressee->address->setEmail($array_for_carrier['billing_email']); 
                //$wsdlObject->letter->addressee->address->setIntercom('AN30');
                //$wsdlObject->letter->addressee->address->setLanguage('FR');

                // Execute ColissimoAFServiceGenerate
                $ColissimoAFServiceGenerate = new ColissimoAFServiceGenerate();
                if($ColissimoAFServiceGenerate->generateLabel(new ColissimoAFStructGenerateLabel($wsdlObject))) {
                  $ok = $ColissimoAFServiceGenerate->getResult();
                  $retid = $ok->return->messages[0]->id;
                  $retmessageContent = $ok->return->messages[0]->messageContent;
                  if ($retid == 0) {
                    // process the data
                    $retparcelnumber = $ok->return->labelResponse->parcelNumber;
                    $parcelNumberPartner = $ok->return->labelResponse->parcelNumberPartner;
                    $retpdfurl = $ok->return->labelResponse->pdfUrl;
                    WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $retparcelnumber);
                    WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $retpdfurl);
                    $cdi_nbrwscorrect = $cdi_nbrwscorrect+1 ;
                    $x = $wpdb->update($wpdb->prefix . "cdi", array('cdi_tracking' => $retparcelnumber, 'cdi_parcelNumberPartner' => $parcelNumberPartner, 'cdi_hreflabel' => $retpdfurl), array( 'cdi_order_id' => $order_id ) );
                    if ($base64label) {
                      WC_function_Colissimo::cdi_uploads_put_contents ($order_id, 'label', $base64label) ;
                    }
                    if ($base64cn23) {
                      WC_function_Colissimo::cdi_uploads_put_contents ($order_id, 'cn23', $base64cn23) ;
                    }
                  }else{
                    // process the error from soap server
                    WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $retid);
                    WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $retmessageContent);
                    $last = $ColissimoAFServiceGenerate->getLastRequest();
                    WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $last);
                    $ret = $ColissimoAFServiceGenerate->getLastResponse();
                    WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $ret);
                    $errorws = __(' ===> Error stop processing at order #', 'colissimo-delivery-integration') . $array_for_carrier['order_id'] . ' - ' . $retid . ' : ' . $retmessageContent ;
                  }
                }else{
                  // process the error from soap client
                  $nok = $ColissimoAFServiceGenerate->getLastError();
                  $last = $ColissimoAFServiceGenerate->getLastRequest();
                  $ret = $ColissimoAFServiceGenerate->getLastResponse();
                  $retid = $nok['ColissimoAFServiceGenerate::generateLabel']->faultcode;
                  $retmessageContent = $nok['ColissimoAFServiceGenerate::generateLabel']->faultstring;
                  WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $retid);
                  WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $retmessageContent);
                  WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $last);
                  WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $ret);
                  $errorws = __(' ===> Error stop processing at order #', 'colissimo-delivery-integration') . $array_for_carrier['order_id'] . ' - ' . $retid . ' : ' . $retmessageContent ;
                }
                // ********************************* End Colissimo Web service *********************************  
              } // End !$cdi_tracking
              if ($errorws !== null) break ;
            } // End row
            // Close sequence
            $message = number_format_i18n( $cdi_nbrwscorrect ) . __(' parcels processed with Colissimo Web Service.', 'colissimo-delivery-integration') . ' ' . $errorws ;
            update_option( 'cdi_notice_display', $message );
            $sendback = admin_url() . 'admin.php?page=Colissimo-page' ; 
            wp_redirect($sendback); 
            exit () ;
          } // End cdi_nbrorderstodo
        } //End $results
      } // End current_user_can
    } // End cdi_auto_run
  } // cdi_gateway_auto
} // End class

// Adapt format of Soap request (for ns1) and format of Soap response (for Mtom/xop)
class ColissimoAFSoapClient extends SoapClient {
  function __doRequest($request, $location, $action, $version, $one_way = NULL) {
    if ($location !== 'https://ws.colissimo.fr/sls-ws/SlsServiceWS') {
      return $response = parent::__doRequest($request, $location, $action, $version, $one_way);
    }else{
      if (strpos($request, "<generateLabelRequest>") == false) { 
        // It seems it is not a <generateLabelRequest>
        return $response = parent::__doRequest($request, $location, $action, $version, $one_way);
      }else{
        // It seems this is a <generateLabelRequest> so we can clean the request
        // suppress ns1 generated by soap
        $request = str_replace( ' xsi:type="ns1:outputFormat"', '', $request );
        $request = str_replace( ' xsi:type="ns1:letter"', '', $request );
        $request = str_replace( ' xsi:type="ns1:address"', '', $request );
        $request = str_replace( '<original xsi:nil="true"/>', '', $request );
        $response = parent::__doRequest($request, $location, $action, $version, $one_way);
        WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $response);
        $this->__last_request = $request;
//$response = '--uuid:67ef9219-5356-4a6b-9372-fdcf781f5344 Content-Type: application/xop+xml; charset=UTF-8; type="text/xml"; Content-Transfer-Encoding: binary Content-ID: <root.message@cxf.apache.org> <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"> <soap:Body> <ns2:generateLabelResponse xmlns:ns2="http://sls.ws.coliposte.fr"> <return> <messages> <id>0</id> <messageContent>La requête a été traitée avec succès</messageContent> <type>INFOS</type> </messages> <labelResponse> <label> <xop:Include href="cid:5592d0a6-7526-41a0-a186-45404fb52b6c- 59@cxf.apache.org" xmlns:xop="http://www.w3.org/2004/08/xop/include"/> </label> <cn23> <xop:Include href="cid:5592d0a6-7526-41a0-a186-45404fb52b6c- 60@cxf.apache.org" xmlns:xop="http://www.w3.org/2004/08/xop/include"/> </cn23> <parcelNumber>7Q05592274242</parcelNumber> <parcelNumberPartner>internat92274242</parcelNumberPartner>   <pdfUrl>https://pfi.telintrans.fr/sls- ws/GetLabel?parcelNumber=7Q05592274242&amp;signature=d0fe8cc2e3d35febd858b2f73b6a26cc4 edb8674820a7c4033982c08ad668374&amp;includeCustomsDeclarations=true</pdfUrl> </labelResponse> </return> </ns2:generateLabelResponse> </soap:Body> </soap:Envelope> --uuid:67ef9219-5356-4a6b-9372-fdcf781f5344--' ;
//$response = WC_function_Colissimo::cdi_uploads_get_contents ('9999', 'label');
//$response = '' ; // file includes/CDI-label-9999.txt to include for testing
//$response = WC_function_Colissimo::cdi_uploads_get_contents ('9995', 'label') ; // Pdf retour-colis store in base64
//$response = WC_function_Colissimo::cdi_uploads_get_contents ('9997', 'label') ; // idem 9998
//$response = WC_function_Colissimo::cdi_uploads_get_contents ('9996', 'label') ; // Pdf directly store in binary (stream transmitting) without heading
//$response = WC_function_Colissimo::cdi_uploads_get_contents ('9998', 'label') ; // 9998 directly store in binary (stream transmitting)

        WC_gateway_colissimo_auto_fonct::store_attach_label_and_cn23($response);
        $response = WC_gateway_colissimo_auto_fonct::Keep_only_xml($response);
        return $response;
      }
    }
  }
}

class WC_gateway_colissimo_auto_fonct {
  public static function store_attach_label_and_cn23 ($response) {
    // If exist, parse $response to extract and store label and cn23 (in base64 format). Not use when Retour service 
    global $order_id;
    global $base64label;
    global $base64cn23;
    $response = str_replace ('href="cid:', 'href="', $response) ; // To avoid too many combinations
    $response = str_replace ('Content-ID: <cid:', 'Content-ID: <', $response) ;
    $uuid = '--uuid' . WC_function_Colissimo::sup_line(WC_function_Colissimo::get_string_between($response, '--uuid', 'Content-Type:')) ;
    $uuid = sanitize_text_field($uuid) ;
    $xoplabel = WC_function_Colissimo::sup_line(WC_function_Colissimo::get_string_between($response, '<label>', '</label>')) ;
    $hreflabel = WC_function_Colissimo::sup_line(WC_function_Colissimo::get_string_between($xoplabel, 'href="', '"')) ;
    if ($hreflabel) {
      $base64labelA = WC_function_Colissimo::get_string_between($response, 'Content-ID: <' . $hreflabel . '>', $uuid);
      $base64label = 'JVBER' . WC_function_Colissimo::get_string_between($base64labelA, 'JVBER', null);
      if ($base64label == 'JVBER') { // Empty, so seem being not in base64 but in direct stream 
        $base64label = '%PDF' . WC_function_Colissimo::get_string_between($base64labelA, '%PDF', '%%EOF') . '%%EOF';
        $base64label = base64_encode ($base64label);
      }
    }
    $xopcn23 = WC_function_Colissimo::sup_line(WC_function_Colissimo::get_string_between($response, '<cn23>', '</cn23>')) ;
    $hrefcn23 = WC_function_Colissimo::sup_line(WC_function_Colissimo::get_string_between($xopcn23, 'href="', '"')) ;
    if ($hrefcn23) {
      $base64cn23A = WC_function_Colissimo::get_string_between($response, 'Content-ID: <' . $hrefcn23 . '>', $uuid);
      $base64cn23 = 'JVBER' . WC_function_Colissimo::get_string_between($base64cn23A, 'JVBER', null);
      if ($base64cn23 == 'JVBER') { // Empty, so seem being not in base64 but in direct stream 
        $base64cn23 = '%PDF' . WC_function_Colissimo::get_string_between($base64cn23A, '%PDF', '%%EOF') . '%%EOF';
        $base64cn23 = base64_encode ($base64cn23);
      }
    }
  }

  public static function Keep_only_xml ($response) {
    // if response content type is Mtom, strip away everything but the xml
    if (strpos($response, "Content-Type: application/xop+xml") !== false) {
      // Keep only soap Envelope
      $tempstr = stristr($response, "<soap:Envelope");
      $response = substr($tempstr, 0, strpos($tempstr, "/soap:Envelope>")) . "/soap:Envelope>";
      // If exist remove xop part inside <label> 
      $tempstr = stristr($response, "<label>");
      $suppress = substr($tempstr, 0, strpos($tempstr, "</label>")) . "</label>";
      $response = str_replace ($suppress, '' , $response);
      // If exist remove xop part inside <cn23>
      $tempstr = stristr($response, "<cn23>");
      $suppress = substr($tempstr, 0, strpos($tempstr, "</cn23>")) . "</cn23>";
      $response = str_replace ($suppress, '' , $response);
    }
    $response = str_replace(array("\r\n","\r","\n"),"",$response);
    $response = str_replace("  "," ",$response);
    return $response;
  }
}


?>
