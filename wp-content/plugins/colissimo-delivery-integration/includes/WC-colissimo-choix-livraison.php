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
/* Colissimo Choix de Livraison (Pickup Location / Point de Retrait)                    */
/****************************************************************************************/

class WC_colissimo_choix_livraison {
  public static function init()  {
    if (get_option('wc_settings_tab_colissimo_methodreferal') == 'yes') {
      add_action('woocommerce_cart_calculate_fees', __CLASS__ . '::cdi_colissimo_get_pickupandproductcode' ); 
      add_action('woocommerce_checkout_order_processed', __CLASS__ . '::cdi_woocommerce_checkout_order_processed', 10, 2 ); 
      add_filter('woocommerce_review_order_after_cart_contents' ,  __CLASS__ . '::cdi_woocommerce_review_order_after_cart_contents');
      add_action('woocommerce_checkout_process',  __CLASS__ . '::cdi_woocommerce_checkout_process');
      add_action('wp_ajax_set_pickuplocation',  __CLASS__ . '::cdi_set_pickuplocation');
      add_action('wp_ajax_nopriv_set_pickuplocation',  __CLASS__ . '::cdi_set_pickuplocation');
      add_action('wp_ajax_set_pickupgooglemaps',  __CLASS__ . '::cdi_set_pickupgooglemaps');
      add_action('wp_ajax_nopriv_set_pickupgooglemaps',  __CLASS__ . '::cdi_set_pickupgooglemaps');
      add_action('wp_head',   __CLASS__ . '::cdi_googlemaps_header');
      add_action('wp_footer',   __CLASS__ . '::cdi_googlemaps_refreshiddentheme',100);
      add_filter('woocommerce_package_rates',  __CLASS__ . '::cdi_woocommerce_package_rates', 100 );
      require_once dirname(__FILE__) . '/ColissimoPR/ColissimoPRAutoload.php';
    }
  }

  public static function cdi_woocommerce_package_rates( $rates ) { // To select in package rates only the first exclusive method found
    $arrayexclusivemethodoption = explode(',', get_option('wc_settings_tab_colissimo_exclusiveshippingmethod')) ;
    $arrayexclusivemethod = array_map("trim", $arrayexclusivemethodoption);
    $newrates = array();
    foreach ((array) $rates as $rate_id => $rate ) {
      $startofid = explode(':', $rate->id) ;
      WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $startofid[0] . ' - ' . get_option('wc_settings_tab_colissimo_exclusiveshippingmethod')) ;
      if (in_array($startofid[0], $arrayexclusivemethod)) { // Is it a racine-name ?
        $newrates[ $rate_id ] = $rate;
        break;
      }
      if (isset($startofid[1]) && is_numeric($startofid[1]) ) { // Is it a shipping zone method 2.6 ?
        if (in_array($startofid[0] . ':' . $startofid[1], $arrayexclusivemethod)) { // So now test if it is racine-name:instance ?
          $newrates[ $rate_id ] = $rate;
          break;
        }
      }
    }
    return ! empty( $newrates ) ? $newrates : $rates;
  }

  public static function cdi_googlemaps_header() {
    if (is_checkout()) { // No useful to do this if not the checkout page
      $key = get_option('wc_settings_tab_colissimo_googlemapsapikey') ;
      if ($key == null or $key == '') { // Google maps API depending if key exists
        ?><script type="text/javascript" src="https://maps.google.com/maps/api/js"></script><?php 
      }else{
        /*
        Optionnal : to delete all Google API scripts before loading
        global $wp_scripts;
        foreach ($wp_scripts->registered as $key => $script) {
          if (preg_match('#maps\.google(?:\w+)?\.com/maps/api/js#', $script->src)) {
            unset($wp_scripts->registered[$key]);
          }
        }
        */
        ?><script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo $key; ?>" async defer ></script><?php
      }
    }else{
      WC()->session->set( 'cdi_refshippingmethod' , '' );
    }
  }

  public static function cdi_colissimo_get_pickupandproductcode() { // Activate when calculate_fees
    global $woocommerce;
    global $msgtofrontend;
    // From CDI 1.16.1 WC()->session->get('customer')['shipping_city'] is change by $woocommerce->customer->get_shipping_city()
    // From CDI 1.16.1 cdi_colissimo_get_pickupandproductcode and cdi_woocommerce_review_order_after_cart_contents use only Ajax triggers and time limit for google maps is suppressed
    // From CDI 2.0.4 $lastunikkeydisplpickup + token time is used to avoid multiple triggers
    if (is_checkout() && is_ajax()) { // No useful to do this if not the checkout page AND only if Ajax
      $needs_shipping = WC()->cart->needs_shipping();
      if ($needs_shipping) {
        $chosen_methods = WC()->session->get( 'chosen_shipping_methods' );
        $chosen_shipping = $chosen_methods[0]; // $chosen_shipping = method : instance : suffixe
      }else{
        $chosen_methods = null ;
        $chosen_shipping = null ;
      }

      // Verify if nothing has been done from 300s
      $tokentimereplay = time() ;
      $oldtokentimereplay = WC()->session->get('cdi_tokentimereplay') ;
      if (!$oldtokentimereplay OR (($oldtokentimereplay + 300) < $tokentimereplay)) { 
        $tokentimereplaypass = 1;
      }else{
        $tokentimereplaypass = 0;
      }
      WC()->session->set('cdi_tokentimereplay', $tokentimereplay) ;

      // Verify if a change in shipping method or shipping data or if nothing has been done from a long time
      $unikkeydisplpickup = $chosen_shipping . '-' . $woocommerce->customer->get_shipping_country() . '-' . $woocommerce->customer->get_shipping_city() . '-' . $woocommerce->customer->get_shipping_postcode() . '-' . $woocommerce->customer->get_shipping_address() ;
      $lastunikkeydisplpickup = WC()->session->get( 'cdi_unikkeydisplpickup' );
      if (!isset($lastunikkeydisplpickup) or $lastunikkeydisplpickup == '' or $lastunikkeydisplpickup !== $unikkeydisplpickup or $tokentimereplaypass == 1) {
        WC()->session->set( 'cdi_forcedproductcode' , '' );
        WC()->session->set( 'cdi_pickuplocationid' , '');
        WC()->session->set( 'cdi_pickuplocationlabel' , '');
        WC()->session->set( 'cdi_displayzone' , '' );
        WC()->session->set( 'cdi_refshippingmethod' , '' );
        WC()->session->set( 'cdi_unikkeydisplpickup' , $unikkeydisplpickup );
      }else{
        return;
      }

      WC()->session->set( 'cdi_refshippingmethod' , $chosen_shipping);
      WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $chosen_shipping);
      $pickuplist = get_option('wc_settings_tab_colissimo_pickupmethodnames') ;
      WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $pickuplist);
      $arraypickuplist = explode(',', $pickuplist) ;
      $arraypickuplist = array_map("trim", $arraypickuplist);
      $arraychosen = explode(':', $chosen_shipping); // explode = method : instance : suffixe

      if ($woocommerce->customer->get_shipping_address() && $woocommerce->customer->get_shipping_postcode() && $woocommerce->customer->get_shipping_city() && $woocommerce->customer->get_shipping_country()  // An address seems exist
      && $chosen_shipping // and a method exists
      && isset($arraychosen[1]) && is_numeric($arraychosen[1]) ) { // and is a shipping zone method 2.6    
        $filterrelay = null ;
        // Test if in the pickup list and extract filterrelay
        if (in_array($woocommerce->customer->get_shipping_country(), explode(',', get_option('wc_settings_tab_colissimo_ws_InternationalPickupLocationContryCodes')))) { // and is in the pickup country list
          foreach ($arraypickuplist as $x ) {
            $arrx = explode('=', $x) ;
            $arry = explode(':', $arrx[0]) ;
            if (!isset($arry[1]) or !is_numeric($arry[1])) {
              if ($arry[0] == $arraychosen[0]){ // Default without instance num
                if (isset($arrx[1])) {
                  $filterrelay = $arrx[1] ;
                }else{
                  $filterrelay = '1' ; // Default without the "=0 or 1"
                }
                break ;
              }
            }else{
              if ($arry[0] . ':' . $arry[1] == $arraychosen[0] . ':' . $arraychosen[1]){ // Ok with instance num
                if (isset($arrx[1])) {
                  $filterrelay = $arrx[1] ;
                }else{
                  $filterrelay = '1' ; // Default without the "=0 or 1"
                }
                break ;
              }
            }
          }
        }
        if ($filterrelay !== null) {
          // We are in the pickup list
          $listPR = WC_colissimo_choix_livraison::get_wsdlPR($filterrelay);
          if ($listPR == false) {
            // it seems as if an error as Web service. The address seems invalid
            wc_add_notice( __('Colissimo does not recognize this address. Please try again.', 'colissimo-delivery-integration' ) . $msgtofrontend, $notice_type = 'error' ) ;
          }else{
            WC()->session->set( 'cdi_displayzone' , $listPR );
          }
        }else{
          // Not in the pickup list, so test if in the forced product code list
          $forcedproductcode = get_option('wc_settings_tab_colissimo_forcedproductcodes') ;
          $arrayforcedproductcode = explode(',', $forcedproductcode) ;
          $arrayforcedproductcode = array_map("trim", $arrayforcedproductcode);
          $codeproductfound = '';
          foreach ($arrayforcedproductcode as $relation) {
            $arrayrelation = explode('=', $relation) ;
            if ($arrayrelation[0] && (($arrayrelation[0] == $arraychosen[0]) OR ($arrayrelation[0] == $arraychosen[0] . ':' . $arraychosen[1]))) {
              $codeproductfound = $arrayrelation[1] ;
            }
          }
          WC()->session->set( 'cdi_forcedproductcode' , $codeproductfound );
        }
      }
    } //End if checkout
  }

  public static function get_wsdlPR($filterrelay) {
    global $woocommerce;
    global $msgtofrontend;
    // Ref : https://www.colissimo.entreprise.laposte.fr/fr/system/files/imagescontent/docs/spec_ws_livraison.pdf
    // Document Technique - Version Avril 2016 - Spécifications du web service choix de livraison

    // Test if server ssl and Colissimo Website are ok  
    $urlpointretrait = 'https://ws.colissimo.fr/pointretrait-ws-cxf/PointRetraitServiceWS/2.0?wsdl' ;
    $file_headers = @get_headers($urlpointretrait);
    if (!strpos($file_headers[0], "200 OK") > 0) {
      $msgtofrontend = ' CDI : Colissimo website access denied - ' . $file_headers[0] ;
      return false;
    }

    $wsdl = array();
    $wsdl[ColissimoPRWsdlClass::WSDL_URL] = 'https://ws.colissimo.fr/pointretrait-ws-cxf/PointRetraitServiceWS/2.0?wsdl';
    $wsdl[ColissimoPRWsdlClass::WSDL_CACHE_WSDL] = WSDL_CACHE_NONE;
    $wsdl[ColissimoPRWsdlClass::WSDL_TRACE] = true;

    $wsdlObject = new ColissimoPRStructFindRDVPointRetraitAcheminement($wsdl);

    $wsdlObject->setAccountNumber(get_option('wc_settings_tab_colissimo_ws_ContractNumber')); 
    $wsdlObject->setPassword(get_option('wc_settings_tab_colissimo_ws_Password'));
    $calc = WC_function_Colissimo::cdi_sanitize_laposte_voie( $woocommerce->customer->get_shipping_address() . ' ' . $woocommerce->customer->get_shipping_address_2() ) ;
    $wsdlObject->setAddress($calc);
    $wsdlObject->setZipCode($woocommerce->customer->get_shipping_postcode());
    $wsdlObject->setCity(WC_function_Colissimo::cdi_sanitize_laposte_voie($woocommerce->customer->get_shipping_city()));
    $wsdlObject->setCountryCode($woocommerce->customer->get_shipping_country());
    $weightrelay = (float)$woocommerce->cart->cart_contents_weight;
    if (get_option( 'woocommerce_weight_unit' ) == 'kg') { // Convert kg to g
      $weightrelay = $weightrelay * 1000 ;
    }
    $weightrelay = $weightrelay + get_option('wc_settings_tab_colissimo_parcelweight') ; 
    if (!$weightrelay or $weightrelay == 0) {
      $weightrelay = 100; // 0g is not good but 1g would be enought to not break the Colissimo WS
    }
    $wsdlObject->setWeight($weightrelay); 
    $calc = get_option('wc_settings_tab_colissimo_ws_OffsetDepositDate');
    $wsdlObject->setShippingDate(date('d/m/Y',strtotime("+$calc day")));
    $wsdlObject->setFilterRelay($filterrelay); 
    $wsdlObject->setRequestId('CDI-' . date('YmdHis'));
    //$wsdlObject->setLang($woocommerce->customer->get_shipping_country()); 
    $wsdlObject->setOptionInter('1');

    $colissimoPRServiceFind = new ColissimoPRServiceFind();
    if($colissimoPRServiceFind->findInternalRDVPointRetraitAcheminement(new ColissimoPRStructFindInternalRDVPointRetraitAcheminement($wsdlObject))) {
      $ok = $colissimoPRServiceFind->getResult();
      $retid = $ok->return->errorCode;
      $retmessageContent = $ok->return->errorMessage;
      if ($retid == 0) {
        return $ok ;
      }else{
        // process the error from soap server
        WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $retid);
        WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $retmessageContent);
        $last = $colissimoPRServiceFind->getLastRequest();
        WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $last);
        $ret = $colissimoPRServiceFind->getLastResponse();
        WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $ret);
        $msgtofrontend = ' (' . WC_colissimo_choix_livraison::get_string_between($ret, '<errorCode>', '</errorCode>') . ' - ' . WC_colissimo_choix_livraison::get_string_between($ret, '<errorMessage>', '</errorMessage>')  .  ')' ;
        return false ;
      }
    }else{
      // process the error from soap client
      $nok = $colissimoPRServiceFind->getLastError();
      $last = $colissimoPRServiceFind->getLastRequest();
      $ret = $colissimoPRServiceFind->getLastResponse();
      WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $last);
      WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $ret);
      return false ;
    }
  }

  public static function cdi_woocommerce_review_order_after_cart_contents() { // When choice shipping done, display the pickup box
    global $woocommerce;
    if (is_ajax()) {
      $token = time() ; // To view only the newest token div in js
      $listPR = WC()->session->get('cdi_displayzone') ;
      $urlglobeopen = plugins_url( 'images/globeopen.png', dirname(__FILE__)) ;
      $urlglobeclose = plugins_url( 'images/globeclose.png', dirname(__FILE__)) ;
      if($listPR) {
        $listePointRetraitAcheminement = $listPR->return->listePointRetraitAcheminement;
        $arrayabstract = array() ;
        $nbpointretrait = 0;
        foreach ($listePointRetraitAcheminement as $PointRetrait) {
          if ($PointRetrait->reseau !== 'X00' && $nbpointretrait < 30) { // Exclude X00 networks
            $nbpointretrait = $nbpointretrait +1;
            $arrayabstract[] = $PointRetrait->nom . ' =&gt; ' .
                               $PointRetrait->adresse1 . ' ' .
                               $PointRetrait->adresse2 . ' ' .
                               $PointRetrait->codePostal . ' ' .
                               $PointRetrait->localite . ' =&gt; Distance: ' .
                               $PointRetrait->distanceEnMetre . 'm =&gt; Id: ' .
                               $PointRetrait->identifiant ;
          }
        }
        if (get_option('wc_settings_tab_colissimo_mapopen') == 'yes') {
          $htmlmap = WC_colissimo_choix_livraison::cdi_calc_js_googlemaps() ;
          $htmlurlglobe = $urlglobeclose ;
        }else{
          $htmlmap = '' ;
          $htmlurlglobe = $urlglobeopen ;
        }
        $insertmsg = '' ;
        $insertmsg .= '<div id="popupmap">' . $htmlmap . '</div>' ; // Place reserved for the popup google maps
        $insertmsg = $insertmsg . '<div id="zoneiconmap"><span>' . __('Select your pickup locations :', 'colissimo-delivery-integration') . '</span>' ;
        $insertmsg = $insertmsg . '<span id="iconpopupmap">' ; 
        $insertmsg = $insertmsg . '<a title="Pickup locations map" style="float:right;"> ' ;
        $insertmsg = $insertmsg . '<input type="image" id="pickupgooglemaps" name="pickupgooglemaps" value="pickupgooglemaps" src="' . $htmlurlglobe . '"> ' ; 
        $insertmsg = $insertmsg . '</a></span></div>' ;
        $insertselect = '<div style="width:100%; overflow:hidden"><select id="pickupselect" name="pickupselect" style="width:100%; overflow:hidden;">' . '<option value="">' . __('Choose a location', 'colissimo-delivery-integration') . '</option>' ;
        foreach ($arrayabstract as $abstract) {
          $idpt = stristr($abstract, " Id: ") ;
          $idpt = str_replace(" Id: ", '', $idpt);
          $insertselect = $insertselect . '<option style="overflow:hidden;" value=' . $idpt . '>' . $abstract . '</option>' ;
        }
        $insertselect = $insertselect . '</select></div>' ;
        $insertmsg = $insertmsg . apply_filters( 'cdi_filterhtml_retrait_selectoptions', $insertselect, $listePointRetraitAcheminement) ;
      }else{
        $insertmsg = '' ;
      }
      ?><script>
        jQuery("#order_review").bind('DOMNodeInserted', function(cleancdiselectlocation){
          var higher = undefined ;
          jQuery( ".cdiselectlocation" ).each(function( index ) { 
            if (typeof(higher) == "undefined") {
              higher = 0 ;
            }
            var currentID = this.id ;
	    if (higher < currentID) { 
              higher = this.id ;
  	    }
	  });
          jQuery( ".cdiselectlocation" ).each(function( index ) { 
            var currentID = this.id ;
	    if (higher > currentID) { 
             jQuery(this).remove();
  	    }
	  });
          cleancdiselectlocation.preventDefault(); // to prevent woocommerce to trigger checkout
        });
      </script><?php
      ?>
        <div id='<?php echo $token ; ?>' class="cdiselectlocation"><p>
          <?php echo $insertmsg ; ?>
        </p></div>
      <?php 
      $ajaxurl = admin_url('admin-ajax.php');
      ?><script>
        jQuery(document).ready(function(){ // call ajax for pickup google maps
          jQuery("#pickupgooglemaps").click(function(googlemapevent){ 
            if (jQuery('#googlemapsopen').length){
              var urlglobeopen = '<?php echo $urlglobeopen; ?>';
              jQuery("#popupmap").html(' ') ;
              jQuery("#pickupgooglemaps" ).attr('src', urlglobeopen) ; 
            }else{
              var data = { 'action': 'set_pickupgooglemaps', 'pickupgooglemaps': 'pickupgooglemaps' };
              var ajaxurl = '<?php echo $ajaxurl; ?>';
              jQuery.post(ajaxurl, data, function(response) {
                var urlglobeclose = '<?php echo $urlglobeclose; ?>';
                jQuery("#popupmap").html(response) ;
                jQuery("#pickupgooglemaps" ).attr('src', urlglobeclose) ; 
              });
            }
            googlemapevent.preventDefault(); // to prevent woocommerce to trigger checkout
            jQuery('html, body').animate({ scrollTop: jQuery("#popupmap").offset().top }, 2000);
          });
        });
      </script><?php
      // call ajax for storage of pickupselect
      $jsselectorpickup = 'var pickupselect = document.getElementById("pickupselect").options[document.getElementById("pickupselect").selectedIndex].value;' ;
      $jsselectorpickup = apply_filters ('cdi_filterjava_retrait_selectorpickup', $jsselectorpickup) ;
      ?><script>  
        jQuery(document).ready(function(){
          jQuery("#pickupselect").change(function(){
            <?php echo $jsselectorpickup; ?> // insert here the var pickupselect
            var data = { "action": "set_pickuplocation", "postpickupselect": pickupselect };
            var ajaxurl = "<?php echo $ajaxurl; ?>";
            jQuery.post(ajaxurl, data, function(response) {
              var arrresponse = jQuery.parseJSON(response);
              if (arrresponse[0].length){ // No display if no return
                var html = arrresponse[0].includes("<", 0);
                if (arrresponse[0].includes("</", 0)) { // Is return a html code ?
                  var para = document.createElement("DIV"); 
                  para.setAttribute("id", "customselect");
                  para.style.position = "fixed"; 
                  para.style.width = "80vw";
                  para.style.height = "80vh";
                  para.style.right = "10vw";
                  para.style.top = "10vh";
                  document.body.appendChild(para);    
                  jQuery("#customselect").html(arrresponse[0]) ;
                }else{ // Not html, so display with alert
                  alert(arrresponse[0]);
                }
              }
              if (jQuery("#googlemapsopen").length){ // Refresh google maps if open
                var urlglobeclose = "<?php echo $urlglobeclose; ?>";
                jQuery("#popupmap").html(arrresponse[1]) ;
                jQuery("#pickupgooglemaps" ).attr("src", urlglobeclose) ; 
                jQuery('html, body').animate({ scrollTop: jQuery("#popupmap").offset().top }, 2000);
              }
            });
          });
        });
      </script><?php
      $wheremap =  get_option('wc_settings_tab_colissimo_wheremustbeemap') ;
      if (!$wheremap or $wheremap == '') {
        $wheremap =  'insertBefore( jQuery( ".shop_table" ) )' ;
      }
      $whereselectorpickup = apply_filters ('cdi_filterjava_retrait_whereselectorpickup', $wheremap) ;
      ?><script>
        jQuery(document).ready(function(){
          jQuery( ".cdiselectlocation" ).<?php echo $whereselectorpickup; ?>; // insert where the pickupselect will be
        });
      </script><?php
     }
   }

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

   public static function cdi_html_retrait_descpickup ($PointRetrait) { 
     $return = '<div id="selretrait" data-value="' . $PointRetrait->identifiant . '">' ;
     $return .= '<p style="width:100%; display:inline-block;"><em>(' . $PointRetrait->identifiant . ')</em><a class="selretrait button" style="float: right;" id="selretraitshown" >Sélectionner</a></p>' ;
     $return .= '<div id="selretraithidden" style="display:none;"><p style="text-align:center;"><a class="button">Point Retrait sélectionné</a></p></div>' ;
     $return .= '<p style="margin-bottom:0px;"><mark>' . $PointRetrait->nom . '</mark></p>' ;
     $return .= '<p style="margin-bottom:0px;"><mark>' .  $PointRetrait->adresse1 . ' ' . $PointRetrait->adresse2 . '</mark></p>' ;
     $return .= '<p style=""><mark>' . $PointRetrait->codePostal . ' ' . $PointRetrait->localite .  '</mark></p>' ;
     $return .= '<p style=""><em>Distance: ' . $PointRetrait->distanceEnMetre . 'm</em></p>' ;
     $return .= '<p style="margin-bottom:0px;"> Lundi ' . $PointRetrait->horairesOuvertureLundi . '</p>' ;
     $return .= '<p style="margin-bottom:0px;"> Mardi ' . $PointRetrait->horairesOuvertureMardi . '</p>' ;
     $return .= '<p style="margin-bottom:0px;"> Mercredi ' . $PointRetrait->horairesOuvertureMercredi . '</p>' ;
     $return .= '<p style="margin-bottom:0px;"> Jeudi ' . $PointRetrait->horairesOuvertureJeudi . '</p>' ;
     $return .= '<p style="margin-bottom:0px;"> Vendredi ' . $PointRetrait->horairesOuvertureVendredi . '</p>' ;
     $return .= '<p style="margin-bottom:0px;"> Samedi ' . $PointRetrait->horairesOuvertureSamedi . '</p>' ;
     $return .= '<p style=""> Dimanche ' . $PointRetrait->horairesOuvertureDimanche . '</p>' ;
     $return .= '<p style="">GPS: ' . $PointRetrait->coordGeolocalisationLatitude . ' ' . $PointRetrait->coordGeolocalisationLongitude .  '</p>' ;
     if ($PointRetrait->parking) $return .= '<p style="margin-bottom:0px;">Parking: ' . $PointRetrait->parking . '</p>' ;
     if ($PointRetrait->accesPersonneMobiliteReduite) $return .= '<p style="margin-bottom:0px;">Mobilité réduite: ' . $PointRetrait->accesPersonneMobiliteReduite . '</p>' ;
     if ($PointRetrait->langue) $return .= '<p style="margin-bottom:0px;">Langue: ' . $PointRetrait->langue . '</p>' ;
     if ($PointRetrait->poidsMaxi) $return .= '<p style="margin-bottom:0px;">Poids maxi: ' . $PointRetrait->poidsMaxi . '</p>' ;
     if ($PointRetrait->loanOfHandlingTool) $return .= '<p style="margin-bottom:0px;">Equipements de manipulation: ' . $PointRetrait->loanOfHandlingTool . '</p>' ;
     $return .= '</div>' ;
     return $return ;
   }

   public static function cdi_calc_js_googlemaps() { 
     global $woocommerce;
     $urliconmarker = apply_filters( 'cdi_filterurl_retrait_iconmarker', plugins_url( 'images/iconmarker.png', dirname(__FILE__))) ;
     $urliconmarkerselect = apply_filters( 'cdi_filterurl_retrait_iconmarkerselect',plugins_url( 'images/iconmarkerselect.png', dirname(__FILE__))) ;
     $urliconcustomer = apply_filters( 'cdi_filterurl_retrait_iconcustomer',plugins_url( 'images/iconcustomer.png', dirname(__FILE__))) ;
     $listPR = WC()->session->get('cdi_displayzone') ;
     $listePointRetraitAcheminement = $listPR->return->listePointRetraitAcheminement;
     $listmarks = array ();
     $nbpointretrait = 0;
     foreach ($listePointRetraitAcheminement as $PointRetrait) {
       if ($PointRetrait->reseau !== 'X00' && $nbpointretrait < 30) { // Exclude X00 networks
         $nbpointretrait = $nbpointretrait + 1;
         $urlicon = $urliconmarker ;
         $pickuplocationid = WC()->session->get( 'cdi_pickuplocationid') ;
         if ($pickuplocationid !== null and $pickuplocationid !== '' and $pickuplocationid == $PointRetrait->identifiant) {
           $urlicon = $urliconmarkerselect ;
         }
         $viewselected = WC_function_Colissimo::cdi_sanitize_laposte_voie($PointRetrait->nom) . ' =&gt; ' .
                         WC_function_Colissimo::cdi_sanitize_laposte_voie($PointRetrait->adresse1) . ' ' .
                         WC_function_Colissimo::cdi_sanitize_laposte_voie($PointRetrait->adresse2) . ' ' .
                         $PointRetrait->codePostal . ' ' .
                         WC_function_Colissimo::cdi_sanitize_laposte_voie($PointRetrait->localite) . ' =&gt; Distance: ' .
                         $PointRetrait->distanceEnMetre . 'm =&gt; Id: ' .
                         $PointRetrait->identifiant ;
         if ('yes' == get_option('wc_settings_tab_colissimo_selectclickonmap') && WC_function_Colissimo::cdi_isconnected()) {
           eval (WC_function_Colissimo::cdi_eval('18')) ;
         }
         $listmarks[] = array (
               'lati' => $PointRetrait->coordGeolocalisationLatitude ,
               'long' => $PointRetrait->coordGeolocalisationLongitude ,
               'desc' => apply_filters( 'cdi_filterhtml_retrait_descpickup', $viewselected, $PointRetrait  )  ,
               'icon' => $urlicon
               ) ;    
       }
     }
     // Calc geolocate of customer
     $addresscustomer = WC_function_Colissimo::cdi_sanitize_laposte_voie( $woocommerce->customer->get_shipping_address()) . ', '
              . $woocommerce->customer->get_shipping_postcode() . ' '
              . WC_function_Colissimo::cdi_sanitize_laposte_voie($woocommerce->customer->get_shipping_city()) . ', '
              . $woocommerce->customer->get_shipping_country() ;
     $address = str_replace ('  ', ' ', $addresscustomer) ;
     $address = str_replace ('  ', ' ', $address) ;
     $address = str_replace (' ', '+', $address) ;
     $key = get_option('wc_settings_tab_colissimo_googlemapsapikey') ;
     if ($key == null or $key == '') { // Google maps API depending if key exists
       $result = file_get_contents('https://maps.googleapis.com/maps/api/geocode/xml?address=' .  $address) ;
     }else{
       $result = file_get_contents('https://maps.googleapis.com/maps/api/geocode/xml?address=' .  $address . '&key=' . $key) ;
     }
     $status = WC_colissimo_choix_livraison::get_string_between($result, '<status>', '</status>') ;
     if ($status !== 'OK') {
       wc_add_notice( __( 'Google Maps can not geolocate this address. Please try again.', 'colissimo-delivery-integration' ) . ' (' . $status . ')', $notice_type = 'error' );
       return '' ;
     }
     // Extract lat and lon
     $latlng = WC_colissimo_choix_livraison::get_string_between($result, '<location>', '</location>') ;
     $lat = WC_colissimo_choix_livraison::get_string_between($latlng, '<lat>', '</lat>') ;
     $lon = WC_colissimo_choix_livraison::get_string_between($latlng, '<lng>', '</lng>') ;
     // Add marker for customer location
     $listmarks[] = array (
               'lati' => $lat ,
               'long' => $lon ,
               'desc' => apply_filters( 'cdi_filterhtml_retrait_desccustomer', $addresscustomer, $woocommerce->customer) ,  // Last argument customer is now an objet
               'icon' => $urliconcustomer
               ) ; 
     $paramgooglemapcss = apply_filters( 'cdi_filterarray_retrait_mapparam', array('z'=>"12", 'w'=>"100%", 'h'=>"400px", 'maptype' => 'ROADMAP', 'styles' => '[]', 'style' => 'border:1px solid gray; margin: 0 auto;') );
     $paramgooglemap = array_merge( array( 'id'=>"googlemapsopen", 'lat'=> $lat, 'lon'=>$lon ), $paramgooglemapcss );
     if (is_numeric($paramgooglemap['w'])) {
       $paramgooglemap['w'] = $paramgooglemap['w'] . 'px' ;
     }
     if (is_numeric($paramgooglemap['h'])) {
       $paramgooglemap['h'] = $paramgooglemap['h'] . 'px' ;
     }
     $jsgm = '';
     $jsgm .= ' <div id="' . $paramgooglemap['id'] . '" style="width:' . $paramgooglemap['w'] . ';height:' . $paramgooglemap['h'] . ';' . $paramgooglemap['style'] . ' "></div><br /> ' ;
     $jsgm .= ' <script type="text/javascript"> ' ;
     $jsgm .= ' var infowindow = null; var latlng = new google.maps.LatLng(' . $paramgooglemap['lat'] . ', ' . $paramgooglemap['lon'] . '); var myOptions = {zoom: ' . $paramgooglemap['z'] . ', center: latlng, mapTypeId: google.maps.MapTypeId.' . $paramgooglemap['maptype'] . ', styles: ' . $paramgooglemap['styles'] . ' }; var ' . $paramgooglemap['id'] . ' = new google.maps.Map(document.getElementById("' . $paramgooglemap['id'] . '"), myOptions); ';
     $jsgm .= ' var sites = [';
     foreach ($listmarks as $mark) {
       $jsgm .= '[' . $mark['lati'] . ',' . $mark['long'] . ',\'' . $mark['desc'] . '\',\'' . $mark['icon'] .  '\'],';
     }
     $jsgm = substr($jsgm, 0, strlen($jsgm) - 1);
     $jsgm.= '];';
     $jsgm.= ' ';
     $jsgm.= ' for (var i = 0; i < sites.length; i++) {';
     $jsgm.= ' var site = sites[i]; ';
     $jsgm.= ' var siteLatLng = new google.maps.LatLng(site[0], site[1]); ';
     $jsgm.= ' if(site[3]!=null) { ';
     $jsgm.= ' var markerimage  = site[3]; ';
     $jsgm.= ' var marker = new google.maps.Marker({ ';
     $jsgm.= ' position: siteLatLng, ';
     $jsgm.= ' map: ' . $paramgooglemap['id'] . ', ';
     $jsgm.= ' icon: markerimage, ';
     $jsgm.= ' html: site[2] }); ';
     $jsgm.= ' } else { ';
     $jsgm.= ' var marker = new google.maps.Marker({ ';
     $jsgm.= ' position: siteLatLng, ';
     $jsgm.= ' map: ' . $paramgooglemap['id'] . ', ';
     $jsgm.= ' html: site[2] }); ';
     $jsgm.= ' } ';
     $jsgm.= ' var contentString = "Some content";';
     $jsgm.= 'google.maps.event.addListener(marker, "click", function () { ';
     $jsgm.= 'infowindow.setContent(this.html); ';
     $jsgm.= ' infowindow.open(' . $paramgooglemap['id'] . ', this); ';
     $jsgm.= '}); ';
     $jsgm.= '} ';
     $jsgm.= ' infowindow = new google.maps.InfoWindow({ content: "loading..." }); ';
     $jsgm.= '</script>';
     return $jsgm ;
   }

   public static function cdi_set_pickupgooglemaps() { // callback for show the pickup locations on google map
     global $woocommerce;
     if ($_SERVER['REQUEST_METHOD'] == "POST" and ISSET($_POST['pickupgooglemaps'])) {
       echo (WC_colissimo_choix_livraison::cdi_calc_js_googlemaps()) ;
       wp_die();
     }
   }

   public static function cdi_set_pickuplocation() { // callback for storage of pickupselect and display of full info
     global $woocommerce;
     if ($_SERVER['REQUEST_METHOD'] == "POST" and ISSET($_POST['postpickupselect'])) {
       $pickupchosen = $_POST['postpickupselect'];
       WC()->session->set( 'cdi_pickuplocationid' , $pickupchosen);
       // *********
       $listPR = WC()->session->get('cdi_displayzone') ;
       $pickupdetail = '' ;
       $eol = "\x0a" ;
       if($listPR) {
         $listePointRetraitAcheminement = $listPR->return->listePointRetraitAcheminement;
         $nbpointretrait = 0;
         foreach ($listePointRetraitAcheminement as $PointRetrait) {
           if ($PointRetrait->reseau !== 'X00' && $nbpointretrait < 30 && $PointRetrait->identifiant == $pickupchosen) { 
             $nbpointretrait = $nbpointretrait + 1;
             WC()->session->set( 'cdi_pickuplocationlabel' , 
                               $PointRetrait->nom . ' => ' .
                               $PointRetrait->adresse1 . ' ' .
                               $PointRetrait->adresse2 . ' ' .
                               $PointRetrait->codePostal . ' ' .
                               $PointRetrait->localite . ' => Distance: ' .
                               $PointRetrait->distanceEnMetre . 'm => Id: ' .
                               $PointRetrait->identifiant) ;

             $pickupdetail .= 'Id: ' . $PointRetrait->identifiant . $eol ;
             $pickupdetail .= 'Distance: ' . $PointRetrait->distanceEnMetre . 'm' . $eol ;
             $pickupdetail .= $eol ;
             $pickupdetail .= $PointRetrait->nom . $eol ;
             $pickupdetail .= $PointRetrait->adresse1 . $eol ;
             if ($PointRetrait->adresse2) $pickupdetail .= $PointRetrait->adresse2 . $eol ;
             if ($PointRetrait->adresse3) $pickupdetail .= $PointRetrait->adresse3 . $eol ;
             $pickupdetail .= $PointRetrait->codePostal . ' ' . $PointRetrait->localite .  $eol ;
             $pickupdetail .= $PointRetrait->libellePays . $eol ;
             $pickupdetail .= $eol ;

             $pickupdetail .= '    Lundi    ' . $PointRetrait->horairesOuvertureLundi . $eol ;
             $pickupdetail .= '    Mardi    ' . $PointRetrait->horairesOuvertureMardi . $eol ;
             $pickupdetail .= '    Mercredi ' . $PointRetrait->horairesOuvertureMercredi . $eol ;
             $pickupdetail .= '    Jeudi    ' . $PointRetrait->horairesOuvertureJeudi . $eol ;
             $pickupdetail .= '    Vendredi ' . $PointRetrait->horairesOuvertureVendredi . $eol ;
             $pickupdetail .= '    Samedi   ' . $PointRetrait->horairesOuvertureSamedi . $eol ;
             $pickupdetail .= '    Dimanche ' . $PointRetrait->horairesOuvertureDimanche . $eol ;
             $pickupdetail .= $eol ;

             $pickupdetail .= 'GPS: ' . $PointRetrait->coordGeolocalisationLatitude . ' ' . $PointRetrait->coordGeolocalisationLongitude .  $eol ;
             if ($PointRetrait->parking) $pickupdetail .= 'Parking: ' . $PointRetrait->parking . $eol ;
             if ($PointRetrait->accesPersonneMobiliteReduite) $pickupdetail .= 'Mobilité réduite: ' . $PointRetrait->accesPersonneMobiliteReduite . $eol ;
             if ($PointRetrait->langue) $pickupdetail .= 'Langue: ' . $PointRetrait->langue . $eol ;
             if ($PointRetrait->poidsMaxi) $pickupdetail .= 'Poids maxi: ' . $PointRetrait->poidsMaxi . $eol ;
             if ($PointRetrait->loanOfHandlingTool) $pickupdetail .= 'Equipements de manipulation: ' . $PointRetrait->loanOfHandlingTool . $eol ;
             if ('yes' == get_option('wc_settings_tab_colissimo_selectclickonmap') && WC_function_Colissimo::cdi_isconnected()) {
               $pickupdetail = '' ;
             }
             $pickupdetail = apply_filters( 'cdi_filterhtml_retrait_displayselected', $pickupdetail, $PointRetrait) ;
             break ;
           }
         }
       }
       // *********
       $response = array() ;
       $response[] = $pickupdetail ; // Pickup details in array 0
       $response[] = WC_colissimo_choix_livraison::cdi_calc_js_googlemaps() ; // Refresh js google maps scrip in array 1
       echo json_encode($response); 
       wp_die();
     }
   }

   public static function cdi_woocommerce_checkout_process() { // Action when checkout button is pressed
     global $woocommerce;
     // Check if location is set
     $cdipickuplocationid = WC()->session->get( 'cdi_pickuplocationid') ;
     $cdipickuplocationlabel = WC()->session->get( 'cdi_pickuplocationlabel') ;
     $codeproductfound = WC()->session->get( 'cdi_forcedproductcode') ;
     $refshippingmethod = WC()->session->get( 'cdi_refshippingmethod') ;
     $cdidisplayzone = WC()->session->get( 'cdi_displayzone') ;
     if ($cdidisplayzone) {
       if (!$cdipickuplocationid) {
         throw new Exception( __( 'You must select a pickup location. Please try again.', 'colissimo-delivery-integration' ) );
       }else{
         $listePointRetraitAcheminement = $cdidisplayzone->return->listePointRetraitAcheminement;
         WC()->session->set( 'cdi_forcedproductcode' , '' );
         foreach ($listePointRetraitAcheminement as $PointRetrait) {
           if ($cdipickuplocationid ==  $PointRetrait->identifiant &&  $PointRetrait->typeDePoint ) {
             $codeproductfound =  $PointRetrait->typeDePoint ;
             WC()->session->set( 'cdi_forcedproductcode', $codeproductfound) ;  
             break;
           }
         }
       }
     }
     // Change name of custom session data because "woocommerce_cart_calculate_fees" may be trigger and alter data
     $x = WC()->session->get( 'cdi_forcedproductcode') ; WC()->session->set( 'cdi_xforcedproductcode', $x) ;
     $x = WC()->session->get( 'cdi_pickuplocationid') ; WC()->session->set( 'cdi_xpickuplocationid', $x) ;
     $x = WC()->session->get( 'cdi_pickuplocationlabel') ; WC()->session->set( 'cdi_xpickuplocationlabel', $x) ;
     $x = WC()->session->get( 'cdi_refshippingmethod') ; WC()->session->set( 'cdi_xrefshippingmethod', $x) ;  
     //throw new Exception( __( 'ONE MORE TIME TO TEST !', 'woocommerce' ) );
     // Debug zone
     $debug = '*** Just before ckeckout, data passed as woocommerce order post meta : ' . 'Product: ' . $codeproductfound . ' Location: ' . $cdipickuplocationid . ' label: ' . $cdipickuplocationlabel . 'Method: ' . $refshippingmethod . ' ***' ;
     WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $debug);
     //throw new Exception( $debug );
   }

  public static function cdi_woocommerce_checkout_order_processed($order_id, $posted ) { 
    // Here the order exist. So we can store cdi_forcedproductcode cdi_pickuplocationid cdi_pickuplocationlabel and method used in meta
    global $woocommerce;
    add_post_meta($order_id, '_cdi_meta_productCode', WC()->session->get( 'cdi_xforcedproductcode'), true);
    add_post_meta($order_id, '_cdi_meta_pickupLocationId', WC()->session->get( 'cdi_xpickuplocationid'), true);
    add_post_meta($order_id, '_cdi_meta_pickupLocationlabel', WC()->session->get( 'cdi_xpickuplocationlabel'), true);
    add_post_meta($order_id, '_cdi_refshippingmethod', WC()->session->get( 'cdi_xrefshippingmethod'), true); 
  }

  public static function cdi_googlemaps_refreshiddentheme() {
    if (is_checkout()) { // No useful to do this if not the checkout page
      if (get_option('wc_settings_tab_colissimo_maprefresh') == 'yes') {
        $ajaxurl = admin_url('admin-ajax.php');
        ?><script>
          Element.prototype.isVisible=function(){"use strict";function e(f,i,n,r,d,l,s){var u=f.parentNode;return!!o(f)&&(9===u.nodeType||"0"!==t(f,"opacity")&&"none"!==t(f,"display")&&"hidden"!==t(f,"visibility")&&(void 0!==i&&void 0!==n&&void 0!==r&&void 0!==d&&void 0!==l&&void 0!==s||(i=f.offsetTop,d=f.offsetLeft,r=i+f.offsetHeight,n=d+f.offsetWidth,l=f.offsetWidth,s=f.offsetHeight),!u||("hidden"!==t(u,"overflow")&&"scroll"!==t(u,"overflow")||!(d+2>u.offsetWidth+u.scrollLeft||d+l-2<u.scrollLeft||i+2>u.offsetHeight+u.scrollTop||i+s-2<u.scrollTop))&&(f.offsetParent===u&&(d+=u.offsetLeft,i+=u.offsetTop),e(u,i,n,r,d,l,s))))}function t(e,t){return window.getComputedStyle?document.defaultView.getComputedStyle(e,null)[t]:e.currentStyle?e.currentStyle[t]:void 0}function o(e){for(;e=e.parentNode;)if(e==document)return!0;return!1}return e(this)};
          var refreshdone = 0 ;
          jQuery(document).ready(function(){ // call ajax for pickup google maps
            jQuery(".woocommerce-checkout").click(function(refreshmapifdivhidden){ 
              setTimeout(function() {
                var elmtotest = document.getElementById('googlemapsopen');
                if (!refreshdone && elmtotest.isVisible(elmtotest)) {
                  refreshdone = 1 ;
                  var data = { 'action': 'set_pickupgooglemaps', 'pickupgooglemaps': 'pickupgooglemaps' };
                  var ajaxurl = '<?php echo $ajaxurl; ?>';
                  jQuery.post(ajaxurl, data, function(response) {
                    jQuery("#popupmap").html(response) ;
                  });
                }
              }, 1500);
            });
          });
        </script><?php
      }
      if ('yes' == get_option('wc_settings_tab_colissimo_selectclickonmap') && WC_function_Colissimo::cdi_isconnected()) {
        ?><script type="text/javascript"> 
        jQuery("#order_review").on("click", "a.selretrait.button", function(detailselret){
          document.getElementById("selretraithidden").style.display = "inline";
          document.getElementById("selretraitshown").style.display = "none";
          var idret = document.getElementById("selretrait").getAttribute('data-value') ;
          var options = document.querySelector("#pickupselect").options; 
          for (var i = 0; i < options.length; i++) { 
            if (options[i].value == idret) {
              var pickupselectvalue =  options[i].value;
              var pickupselecttext =  options[i].text;
              options[i].selected = true;
              var sel = document.getElementById('pickupselect');
              fireEvent(sel,'change'); 
              break;
            }
          }
          function fireEvent(element,event){
            if (document.createEventObject){ 
              var evt = document.createEventObject();
              return element.fireEvent('on'+event,evt)
            }else{ 
              var evt = document.createEvent("HTMLEvents");
              evt.initEvent(event, true, true ); 
              return !element.dispatchEvent(evt);
            }
          }
        }); 
        </script><?php
        ?> <style>  
          /* #zoneiconmap {display: none;} */
          /* #pickupselect {display: none;} */
        </style><?php
      }
    }
  }
}

// Adapt format of Soap request (for ns1) and format of Soap response (for Mtom/xop)
class ColissimoPRSoapClient extends SoapClient {
  function __doRequest($request, $location, $action, $version, $one_way = NULL) {
    if ($location !== 'https://ws.colissimo.fr/pointretrait-ws-cxf/PointRetraitServiceWS/2.0') {
      return $response = parent::__doRequest($request, $location, $action, $version, $one_way);
    }else{
      // correct text generated by soap
      $request = str_replace( '<ns1:findInternalRDVPointRetraitAcheminement><accountNumber xsi:type="ns1:findRDVPointRetraitAcheminement">', '<ns1:findInternalRDVPointRetraitAcheminement>', $request );
      $request = str_replace( '</accountNumber></ns1:findInternalRDVPointRetraitAcheminement>', '</ns1:findInternalRDVPointRetraitAcheminement>', $request );
      $response = parent::__doRequest($request, $location, $action, $version, $one_way);
      $this->__last_request = $request;
      // if response content type is Mtom, strip away everything but the xml
      if (strpos($response, "Content-Type: application/xop+xml") !== false) {
        // Keep only soap Envelope
        $tempstr = stristr($response, "<soap:Envelope");
        $response = substr($tempstr, 0, strpos($tempstr, "/soap:Envelope>")) . "/soap:Envelope>";
      }
      $response = str_replace(array("\r\n","\r","\n"),"",$response);
      $response = str_replace("  "," ",$response);
      return $response;
    }
  }
}


?>
