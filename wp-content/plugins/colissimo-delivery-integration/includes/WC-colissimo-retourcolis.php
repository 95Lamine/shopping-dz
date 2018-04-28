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
/* Colissimo Retour Colis                                                               */
/****************************************************************************************/

class WC_colissimo_retourcolis {
  public static function init()  {
    add_action('woocommerce_view_order',  __CLASS__ . '::cdi_display_colissimo_retourcolis' ); 
    add_action('init',  __CLASS__ . '::cdi_print_returnlabel_pdf');
  }

  public static function cdi_print_returnlabel_pdf() {
    if ( isset($_POST['cdi_print_returnlabel_pdf']) && isset( $_POST['cdi_print_returnlabel_pdf_nonce'] ) && wp_verify_nonce( $_POST['cdi_print_returnlabel_pdf_nonce'], 'cdi_print_returnlabel_pdf' ) ) {
      global $woocommerce;
      $id_order = $_POST['idreturnlabel'] ;
      WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $id_order);
      $base64return = get_post_meta($id_order, '_cdi_meta_base64_return', true);  
      if ($base64return) {
        $cdi_loclabel_pdf = base64_decode ($base64return);
        $out = fopen('php://output', 'w');
        $thepdffile = 'Return-' . $id_order . '-' . date('YmdHis') . '.pdf' ;
        header('Content-Type: application/pdf' );
        header('Content-Disposition: attachment; filename=' . $thepdffile );
        fwrite($out, $cdi_loclabel_pdf) ;
        fclose($out);
        die ();
      }
    } // End $_POST['cdi_print_returnlabel_pdf'
  } // End function cdi_print_returnlabel_pdf


  public static function cdi_display_colissimo_retourcolis ($id_order) {
    global $woocommerce;

    // If posted, get and store the return label
    if ( isset($_POST['cdi_getparcelreturn']) ) {
      $productcode = $_POST['productcode'] ;
      WC_colissimo_retourcolis::cdi_getparcelreturn_ws ($id_order, $productcode) ;
    }

    // Normal processing of order view
    $statusparcelreturn = get_option('wc_settings_tab_colissimo_parcelreturn');
    if ($statusparcelreturn == 'yes') {
      $order = new WC_Order($id_order); 
      //$statusorder = $order->post->post_status ;  // Deprecated WC3
      $statusorder = cdiwc3::cdi_order_status($order) ; 
      if( get_post_meta($id_order, '_cdi_meta_status', true ) == 'intruck') {
        $retoureligible = apply_filters ( 'cdi_filterstring_retourcolis_eligible', 'yes', $order) ;
      }else{
        $retoureligible = 'no' ;
      }
      WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $id_order . ' - ' . $statusorder . ' - ' . $retoureligible);
      if ($retoureligible == 'yes') {
        $cdi_tracking = get_post_meta($id_order, '_cdi_meta_tracking', true);
        $cdi_tracking_heading =  substr ($cdi_tracking, 0, 2) ;
        $trackingheaders_parcelreturn = get_option('wc_settings_tab_colissimo_trackingheaders_parcelreturn');
        if (!(strpos ($trackingheaders_parcelreturn , $cdi_tracking_heading ) === false)) {
          $cdi_urllabel = get_post_meta($id_order, '_cdi_meta_urllabel', true);
          if ($cdi_urllabel) {
            // Here we can process the parcel return function 
            //$completeddate = $order->post->post_date ; // Deprecated WC3
            $completeddate = cdiwc3::cdi_order_date_created($order) ; 
            $nbdaytoreturn = get_post_meta($id_order, '_cdi_meta_nbdayparcelreturn', true);
            $daynoreturn = ($nbdaytoreturn*60*60*24) + strtotime($completeddate) ;
            $today = strtotime("now") ;
            if ($today < $daynoreturn) {
              $base64return = get_post_meta($id_order, '_cdi_meta_base64_return', true);
              if ($base64return) {
                // Display the existing parcel return label
                $txt = get_option('wc_settings_tab_colissimo_text_preceding_printreturn'); 
                $val = __( 'Print your Colissimo return label', 'colissimo-delivery-integration') ; 
                $url = get_option('wc_settings_tab_colissimo_url_following_printreturn'); 
                echo '<div id="divcdiprintparcelreturn"><form method="post" id="cdi_print_returnlabel_pdf" action="">' . '<input type="hidden" name="idreturnlabel" value="' . $id_order . '" />' . 
' <input type="submit" name="cdi_print_returnlabel_pdf" value="'  .  $val . '"  title="Print your Colissimo return label" />  ' .  $txt ;
                echo '<a href="' . $url . '" onclick="window.open(this.href); return false;" > ' . $url . ' </a>' ;
                wp_nonce_field( 'cdi_print_returnlabel_pdf', 'cdi_print_returnlabel_pdf_nonce');
                echo '</form></div>' ;
              }else{
                // Create the parcel return label and display it
                $array_for_carrier = WC_function_Colissimo::cdi_array_for_carrier( $id_order ) ;
                $shippingcountry =  $array_for_carrier['shipping_country'];
                // Test if Product code exist in tables
                $productcode = '' ;
                $arrcoderelationlist = explode(';', get_option('wc_settings_tab_colissimo_returnproduct_code')) ;
                foreach ($arrcoderelationlist as $coderelationlist) {
                  $arrcodereturn = explode('=', $coderelationlist) ;
                  if (!(strpos($arrcodereturn[1], $shippingcountry) === false)) {
                    $productcode = $arrcodereturn[0] ;
                    break ;
                  }
                }
                if ($productcode && $productcode !== '') {
                  $txt = get_option('wc_settings_tab_colissimo_text_preceding_parcelreturn');
                  $val = __('Request for a Colissimo return label', 'colissimo-delivery-integration') ; 
                  echo '<div id="divcdigetparcelreturn"><form method="post" id="cdi_getparcelreturn" action="">' .  $txt . ' <input type="submit" name="cdi_getparcelreturn" value="'  .  $val . '"  title="Request for a Colissimo return label"/>' . '<input type="hidden" name="productcode" value="' . $productcode . '"/>' ;
                  //wp_nonce_field( 'cdi_getparcelreturn_run', 'cdi_getparcelreturn_run_nonce');
                  echo '</form></div>   ' ;
                }
              }
            }
          }
        }
      }
    }
  }

  public static function cdi_getparcelreturn_ws ($order_id, $productcode) {
    global $woocommerce;
    global $base64label;
    // Open sequence
    require_once dirname(__FILE__) . '/ColissimoAF/ColissimoAFAutoload.php';
    $errorws = null ;

    // ********************************* Begin Colissimo Web service *********************************    
    // Ref : https://www.colissimo.entreprise.laposte.fr/fr/system/files/imagescontent/docs/spec_ws_affranchissement.pdf
    // Document Technique - Version Avril 2016 - Spécifications du Web Service d’Affranchissement Colissimo
    // The "class ColissimoAFSoapClient extends SoapClient" is in the WC-gateway-colissimo-auto.php file and is commun with this file

    $array_for_carrier = WC_function_Colissimo::cdi_array_for_carrier( $order_id ) ;

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
                
    $wsdlObject->setContractNumber(get_option('wc_settings_tab_colissimo_ws_ContractNumber')); 
    $wsdlObject->setPassword(get_option('wc_settings_tab_colissimo_ws_Password'));

    $wsdlObject->outputFormat->setX(get_option('wc_settings_tab_colissimo_ws_X'));
    $wsdlObject->outputFormat->setY(get_option('wc_settings_tab_colissimo_ws_Y'));
    //$wsdlObject->outputFormat->setOutputPrintingType(get_option('wc_settings_tab_colissimo_ws_OutputPrintingType')); 
    $wsdlObject->outputFormat->setOutputPrintingType('PDF_A4_300dpi'); // Forced to A4 pdf because generally consumer has this printer
    //$wsdlObject->outputFormat->setReturnType('SendPDFLinkByMail'); 

    $wsdlObject->letter->service->setProductCode($productcode);  // Only France zone may be in scope. Waiting for Colissimo explanations
    $calc = get_option('wc_settings_tab_colissimo_ws_OffsetDepositDate');
    $wsdlObject->letter->service->setDepositDate(date('Y-m-d',strtotime("+$calc day"))); 
    //$wsdlObject->letter->service->setMailBoxPicking('true'); 
    //$wsdlObject->letter->service->setMailBoxPickingDate(date('Y-m-d',strtotime("+$calc day"))); 
    $wsdlObject->letter->service->setOrderNumber($order_id);  
    $wsdlObject->letter->service->setCommercialName(get_option('wc_settings_tab_colissimo_ws_sa_CompanyName')); 

    $wsdlObject->letter->parcel->setInsuranceValue('0');
    $weight = $array_for_carrier['parcel_weight']/1000;
    $wsdlObject->letter->parcel->setWeight($weight); 
    $NonMachinable = str_replace(array('colis-standard', 'colis-volumineux', 'colis-rouleau'), array('0', '1', '1'), $array_for_carrier['parcel_type']);
    $wsdlObject->letter->parcel->setNonMachinable($NonMachinable); 
    $wsdlObject->letter->parcel->setReturnReceipt('0'); 

    $wsdlObject->letter->customsDeclarations->setIncludeCustomsDeclarations('false'); 
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

    $wsdlObject->letter->sender->setSenderParcelRef($order_id); 
    $companyandorderid = $array_for_carrier['shipping_company'] . ' -' . $array_for_carrier['order_id'] . '-' ;
    $wsdlObject->letter->sender->address->setCompanyName($companyandorderid); 
    $wsdlObject->letter->sender->address->setLastName($array_for_carrier['shipping_last_name']);
    $wsdlObject->letter->sender->address->setFirstName($array_for_carrier['shipping_first_name']);
    //$wsdlObject->letter->sender->address->setLine0('AN0-35');
    $wsdlObject->letter->sender->address->setLine2($array_for_carrier['shipping_address_1']); 
    $wsdlObject->letter->sender->address->setLine1($array_for_carrier['shipping_address_2']);
    //$wsdlObject->letter->sender->address->setLine3('AN0-35');
    $wsdlObject->letter->sender->address->setCountryCode($array_for_carrier['shipping_country']); 
    $wsdlObject->letter->sender->address->setCity($array_for_carrier['shipping_city_state']); 
    $wsdlObject->letter->sender->address->setZipCode($array_for_carrier['shipping_postcode']); 
    $wsdlObject->letter->sender->address->setPhoneNumber($array_for_carrier['billing_phone']);
    //$wsdlObject->letter->sender->address->setMobileNumber('AN10');
    //$wsdlObject->letter->sender->address->setDoorCode1('AN8');
    //$wsdlObject->letter->sender->address->setDoorCode2('AN8');
    $wsdlObject->letter->sender->address->setEmail($array_for_carrier['billing_email']); 
    //$wsdlObject->letter->sender->address->setIntercom('AN30');
    //$wsdlObject->letter->sender->address->setLanguage('FR');

    $wsdlObject->letter->addressee->setAddresseeParcelRef($order_id);
    $wsdlObject->letter->addressee->setCodeBarForReference('true');
    $wsdlObject->letter->addressee->setServiceInfo(get_option('wc_settings_tab_colissimo_returnparcelservice')); 
    $wsdlObject->letter->addressee->address->setCompanyName(get_option('wc_settings_tab_colissimo_ws_sa_CompanyName'));  
    $wsdlObject->letter->addressee->address->setLastName(get_option('wc_settings_tab_colissimo_ws_sa_CompanyName')); 
    //$wsdlObject->letter->addressee->address->setFirstName('AN0-29'); 
    //$wsdlObject->letter->addressee->address->setLine0('AN0-35');
    $wsdlObject->letter->addressee->address->setLine2(get_option('wc_settings_tab_colissimo_ws_sa_Line1')); 
    $wsdlObject->letter->addressee->address->setLine1(get_option('wc_settings_tab_colissimo_ws_sa_Line2')); 
    //$wsdlObject->letter->addressee->address->setLine3('AN0-35');
    $wsdlObject->letter->addressee->address->setCountryCode(get_option('wc_settings_tab_colissimo_ws_sa_CountryCode'));  
    $wsdlObject->letter->addressee->address->setCity(get_option('wc_settings_tab_colissimo_ws_sa_City')); 
    $wsdlObject->letter->addressee->address->setZipCode(get_option('wc_settings_tab_colissimo_ws_sa_ZipCode')); 
    //$wsdlObject->letter->addressee->address->setPhoneNumber('AN15'); 
    //$wsdlObject->letter->addressee->address->setMobileNumber('AN10');
    //$wsdlObject->letter->addressee->address->setDoorCode1('AN8');
    //$wsdlObject->letter->addressee->address->setDoorCode2('AN8');
    $wsdlObject->letter->addressee->address->setEmail(get_option('wc_settings_tab_colissimo_ws_sa_Email')); 
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
        delete_post_meta($order_id, '_cdi_meta_parcelnumber_return');
        add_post_meta($order_id, '_cdi_meta_parcelnumber_return', $retparcelnumber, true);
        $retpdfurl = $ok->return->labelResponse->pdfUrl;
        delete_post_meta($order_id, '_cdi_meta_pdfurl_return');
        add_post_meta($order_id, '_cdi_meta_pdfurl_return', $retpdfurl, true);
        WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $retparcelnumber);
        WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $retpdfurl);
        if ($base64label) {
          delete_post_meta($order_id, '_cdi_meta_base64_return');
          add_post_meta($order_id, '_cdi_meta_base64_return', $base64label, true);
        }
      }else{
        // process the error from soap server
        WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $retid);
        WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $retmessageContent);
        $last = $ColissimoAFServiceGenerate->getLastRequest();
        WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $last);
        $ret = $ColissimoAFServiceGenerate->getLastResponse();
        WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $ret);
        $errorws = __(' ===> Return label not available - #', 'colissimo-delivery-integration') . $order_id . ' - ' . $retid . ' : ' . $retmessageContent ;
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
      $errorws = __(' ===> Return label not available - #', 'colissimo-delivery-integration') . $order_id . ' - ' . $retid . ' : ' . $retmessageContent ;
    }
    // ********************************* End Colissimo Web service ********************************* 

    // Close sequence
    if (null !== $errorws) {
      WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $errorws);
      echo $errorws ;
    }
  }
}



?>
