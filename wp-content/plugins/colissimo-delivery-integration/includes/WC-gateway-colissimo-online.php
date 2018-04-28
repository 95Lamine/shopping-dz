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
/* Gateway online                                                                       */
/****************************************************************************************/
class WC_gateway_colissimo_online {
  public static function init() {
    add_action('admin_init',  __CLASS__ . '::cdi_online_run');
  }
  public static function cdi_online_run() {
    if ( isset($_POST['cdi_gateway_online']) && isset( $_POST['cdi_online_run_nonce'] ) && wp_verify_nonce( $_POST['cdi_online_run_nonce'], 'cdi_online_run' ) ) {
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
            $theiimfile = 'Colilign-Orders-' . date('YmdHis') . '.iim' ;
            header('Content-type: text' );
            header('Content-Disposition: inline; filename=' . $theiimfile );
            foreach ($results as $row) {
              $cdi_tracking = $row->cdi_tracking;
              if (!$cdi_tracking && ($row->cdi_status == 'open' or null == $row->cdi_status)) {
                $cdi_rowcurrentorder = $cdi_rowcurrentorder+1 ;
                $array_for_carrier = WC_function_Colissimo::cdi_array_for_carrier( $row ) ;
                WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $array_for_carrier['order_id']);
                if ( $cdi_rowcurrentorder == 1) { // Open sequence
                  fwrite($out, "' *** Head of iMacros script " . "\r\n") ;
                }
                // Begin imacro script for current order
                fwrite($out, "' *** Head of script for order " . $array_for_carrier['order_id'] . "\r\n") ;
                fwrite($out, "' *** Departure " . "\r\n") ;

                fwrite($out, 'TAG POS=1 TYPE=INPUT:HIDDEN FORM=ID:dlbi-colis ATTR=ID:onlyPostalCode CONTENT="' . $array_for_carrier['departure_cp'] . '"' . "\r\n") ;
                fwrite($out, 'TAG POS=1 TYPE=INPUT:HIDDEN FORM=ID:dlbi-colis ATTR=ID:localite CONTENT="' . $array_for_carrier['departure_localite'] . '"' . "\r\n") ;
                fwrite($out, 'TAG POS=1 TYPE=INPUT:TEXT FORM=ID:dlbi-colis ATTR=ID:cp CONTENT="' . $array_for_carrier['departure'] . '"' . "\r\n") ;
                fwrite($out, 'TAG POS=1 TYPE=INPUT:TEXT FORM=ID:dlbi-colis ATTR=ID:cp CONTENT="' . $array_for_carrier['departure'] . '"' . "\r\n") ;
                //Issue to resolve : iMacros and javascript Colissimo are conflicting on zone "Code postal de départ du colis". So this refresh bypass may be a solution
                fwrite($out, 'REFRESH' . "\r\n") ;

                fwrite($out, "' *** Destination country " . "\r\n") ;
                fwrite($out, 'TAG POS=1 TYPE=SELECT FORM=ID:dlbi-colis ATTR=ID:destination CONTENT=%' . $array_for_carrier['shipping_country'] . "\r\n") ;
                fwrite($out, 'TAG POS=1 TYPE=SELECT FORM=ID:dlbi-colis ATTR=ID:destination CONTENT=%' . $array_for_carrier['shipping_country'] . "\r\n") ;

                if (get_option( 'wc_settings_tab_colissimo_fromletterbox') == 'yes') {
                  fwrite($out, "' *** Personnal letter box deposit " . "\r\n") ;
                  fwrite($out, 'TAG POS=1 TYPE=INPUT:RADIO FORM=ID:dlbi-colis ATTR=ID:depot-boite-lettres1' . "\r\n") ;
                  fwrite($out, 'TAG POS=1 TYPE=INPUT:RADIO FORM=ID:dlbi-colis ATTR=ID:depot-boite-lettres1' . "\r\n") ;
                }else{
                  fwrite($out, "' *** Bureau de poste deposit " . "\r\n") ;
                  fwrite($out, 'TAG POS=1 TYPE=INPUT:RADIO FORM=ID:dlbi-colis ATTR=ID:depot-bureau-poste1' . "\r\n") ;
                  fwrite($out, 'TAG POS=1 TYPE=INPUT:RADIO FORM=ID:dlbi-colis ATTR=ID:depot-bureau-poste1' . "\r\n") ;
                }

                fwrite($out, "' *** Parcel type " . "\r\n") ;
                fwrite($out, 'TAG POS=1 TYPE=INPUT:RADIO FORM=ID:dlbi-colis ATTR=ID:' . $array_for_carrier['parcel_type'] . "\r\n") ;

                fwrite($out, "' *** Parcel weight " . "\r\n") ;
                fwrite($out, 'TAG POS=1 TYPE=INPUT:TEXT FORM=ID:dlbi-colis ATTR=ID:poids CONTENT=' . $array_for_carrier['parcel_weight']/1000 . "\r\n") ;

                fwrite($out, "' *** Signature delivery ? " . "\r\n") ;
                $signatureiim = str_replace(array('yes', 'no'), array('reco-signed', 'reco-simple'), $array_for_carrier['signature']);
                fwrite($out, 'TAG POS=1 TYPE=INPUT:RADIO FORM=ID:dlbi-colis ATTR=ID:' . $signatureiim . "\r\n") ;

                fwrite($out, "' *** Insurance to add ? " . "\r\n") ;
                $addcompensationiim = $array_for_carrier['additional_compensation'];
                if (!$addcompensationiim) $addcompensationiim = 'no' ;
                $addcompensationiim = str_replace(array('yes', 'no', ''), array('indemnite-plus-oui', 'indemnite-plus-non', 'indemnite-plus-non'), $addcompensationiim);
                fwrite($out, 'TAG POS=1 TYPE=INPUT:RADIO FORM=ID:dlbi-colis ATTR=ID:' . $addcompensationiim . "\r\n") ;

                fwrite($out, "' *** Insurance amount " . "\r\n") ;
                if ($array_for_carrier['compensation_amount']) {
                  fwrite($out, 'TAG POS=1 TYPE=INPUT:NUMBER FORM=ID:dlbi-colis ATTR=ID:insuredValue CONTENT=' . $array_for_carrier['compensation_amount'] . "\r\n") ;
                  fwrite($out, 'TAG POS=1 TYPE=INPUT:NUMBER FORM=ID:dlbi-colis ATTR=ID:insuredValue CONTENT=' . $array_for_carrier['compensation_amount'] . "\r\n") ;
                  fwrite($out, "' *** Confirm insurance added " . "\r\n") ;
                  fwrite($out, 'TAG POS=1 TYPE=INPUT:CHECKBOX FORM=ID:dlbi-colis ATTR=ID:confirm-indemnite-sup CONTENT=YES' . "\r\n") ;
                  fwrite($out, 'TAG POS=1 TYPE=INPUT:CHECKBOX FORM=ID:dlbi-colis ATTR=ID:confirm-indemnite-sup CONTENT=YES' . "\r\n") ;
                }

                fwrite($out, "' *** Cn23 general fields " . "\r\n") ;
                if ($array_for_carrier['cn23_category']) {   
                  $category = str_replace( array('1', '2', '3', '4', '5', '6'),array('cadeau', 'echantillion', 'envoi-commercial', 'document', 'autre', 'retour-marchandise'), $array_for_carrier['cn23_category']);
                  fwrite($out, 'TAG POS=1 TYPE=SELECT FORM=ID:dlbi-colis ATTR=ID:declaration-nature-colis CONTENT=%' . $category . "\r\n") ;

                  fwrite($out, "' *** Cn23 article fields 0 " . "\r\n") ;
                  fwrite($out, 'TAG POS=1 TYPE=INPUT:TEXT FORM=ID:dlbi-colis ATTR=ID:desc-article-0 CONTENT="' . $array_for_carrier['cn23_article_description_0'] . '"' . "\r\n") ;
                  fwrite($out, 'TAG POS=1 TYPE=INPUT:TEXT FORM=ID:dlbi-colis ATTR=ID:poids-net-unitaire-0 CONTENT=' . $array_for_carrier['cn23_article_weight_0']/1000 . "\r\n") ;
                  fwrite($out, 'TAG POS=1 TYPE=INPUT:TEXT FORM=ID:dlbi-colis ATTR=ID:quantite-0 CONTENT=' . $array_for_carrier['cn23_article_quantity_0'] . "\r\n") ;
                  if ($array_for_carrier['cn23_category'] == '3') {
                    fwrite($out, 'TAG POS=1 TYPE=INPUT:TEXT FORM=ID:dlbi-colis ATTR=ID:numero-tarifaire-0 CONTENT="' . $array_for_carrier['cn23_article_hstariffnumber_0'] . '"' . "\r\n") ;
                  }
                  fwrite($out, 'TAG POS=1 TYPE=INPUT:TEXT FORM=ID:dlbi-colis ATTR=ID:valeur-unitaire-0 CONTENT=' . $array_for_carrier['cn23_article_value_0'] . "\r\n") ;
                  fwrite($out, 'TAG POS=1 TYPE=SELECT FORM=ID:dlbi-colis ATTR=ID:origin-country-0 CONTENT=%' . $array_for_carrier['cn23_article_origincountry_0'] . "\r\n") ;

                  fwrite($out, "' *** Cn23 article fields 1 to 9 " . "\r\n") ;
                  for ($nbart = 1; $nbart <= 9; $nbart++) {
                    if (!isset ($array_for_carrier['cn23_article_description_' . $nbart])) break;
                    fwrite($out, 'TAG POS=1 TYPE=A ATTR=TXT:Ajouter<SP>un<SP>article' . "\r\n") ;
                    fwrite($out, 'TAG POS=1 TYPE=INPUT:TEXT FORM=ID:dlbi-colis ATTR=ID:desc-article-' . $nbart . ' CONTENT="' . $array_for_carrier['cn23_article_description_' . $nbart] . '"' . "\r\n") ;
                    fwrite($out, 'TAG POS=1 TYPE=INPUT:TEXT FORM=ID:dlbi-colis ATTR=ID:poids-net-unitaire-' . $nbart . ' CONTENT=' . $array_for_carrier['cn23_article_weight_' . $nbart]/1000 . "\r\n") ;
                    fwrite($out, 'TAG POS=1 TYPE=INPUT:TEXT FORM=ID:dlbi-colis ATTR=ID:quantite-' . $nbart . ' CONTENT=' . $array_for_carrier['cn23_article_quantity_' . $nbart] . "\r\n") ;
                    if ($array_for_carrier['cn23_category'] == '3') {
                      fwrite($out, 'TAG POS=1 TYPE=INPUT:TEXT FORM=ID:dlbi-colis ATTR=ID:numero-tarifaire-' . $nbart . ' CONTENT="' . $array_for_carrier['cn23_article_hstariffnumber_' . $nbart] . '"' . "\r\n") ;
                    }
                    fwrite($out, 'TAG POS=1 TYPE=INPUT:TEXT FORM=ID:dlbi-colis ATTR=ID:valeur-unitaire-' . $nbart . ' CONTENT=' . $array_for_carrier['cn23_article_value_' . $nbart] . "\r\n") ;
                    fwrite($out, 'TAG POS=1 TYPE=SELECT FORM=ID:dlbi-colis ATTR=ID:origin-country-' . $nbart . ' CONTENT=%' . $array_for_carrier['cn23_article_origincountry_' . $nbart] . "\r\n") ;
                  }
                }

                fwrite($out, "' *** International option return fields " . "\r\n") ;
                if ($array_for_carrier['return_type']) {  
                  $returntypeiim = str_replace(array('no-return', 'pay-for-return'), array('RETOUR_SANS_CHOIX', 'RETOUR_AVEC_CHOIX'), $array_for_carrier['return_type']);
                  fwrite($out, 'TAG POS=1 TYPE=SELECT FORM=ID:dlbi-colis ATTR=NAME:retourColis CONTENT=%' . $returntypeiim . "\r\n") ;
                }

                fwrite($out, "' *** Submit to next page " . "\r\n") ;
                fwrite($out, 'TAG POS=1 TYPE=INPUT:SUBMIT FORM=ID:dlbi-colis ATTR=ID:dlbi-submit' . "\r\n") ;

                fwrite($out, "' *** Expeditor is supposed already registered in Colissimo " . "\r\n") ;
                fwrite($out, "' *** Destinataire Defaut pro and Mr " . "\r\n") ;
                fwrite($out, 'TAG POS=1 TYPE=A ATTR=TXT:Ajouter<SP>le<SP>destinataire' . "\r\n") ;
                fwrite($out, 'TAG POS=2 TYPE=SPAN ATTR=CLASS:icon&&TXT:' . "\r\n") ;
                fwrite($out, 'TAG POS=1 TYPE=INPUT:RADIO FORM=ID:coordonneesProfessionnel ATTR=ID:civiliteMrPro' . "\r\n") ;

                fwrite($out, "' *** Last name " . "\r\n") ;
                $x = WC_function_Colissimo::cdi_sanitize_colissimo_enligne($array_for_carrier['shipping_last_name']);
                fwrite($out, 'TAG POS=1 TYPE=INPUT:TEXT FORM=ID:coordonneesProfessionnel ATTR=ID:lastNamePro CONTENT="' . $x . '"' . "\r\n") ;

                fwrite($out, "' *** First name " . "\r\n") ;
                $x = WC_function_Colissimo::cdi_sanitize_colissimo_enligne($array_for_carrier['shipping_first_name']);
                fwrite($out, 'TAG POS=1 TYPE=INPUT:TEXT FORM=ID:coordonneesProfessionnel ATTR=ID:firstNamePro CONTENT="' . $x . '"' . "\r\n") ;

                fwrite($out, "' *** Company + Order num" . "\r\n") ;
                $comp = apply_filters ('cdi_filterstring_gateway_companyandorderid', $array_for_carrier['shipping_company'] . ' -' . $array_for_carrier['order_id'] . '-', $array_for_carrier) ;
                fwrite($out, 'TAG POS=1 TYPE=INPUT:TEXT FORM=ID:coordonneesProfessionnel ATTR=ID:raisonSocialePro CONTENT="' . $comp . '"' . "\r\n") ;

                fwrite($out, "' *** Adr line 1 " . "\r\n") ;
                $x = WC_function_Colissimo::cdi_sanitize_colissimo_enligne($array_for_carrier['shipping_address_1']);
                fwrite($out, 'TAG POS=1 TYPE=INPUT:TEXT FORM=ID:coordonneesProfessionnel ATTR=ID:numLibellePro CONTENT="' . $x . '"' . "\r\n") ;

                fwrite($out, "' *** Adr line 2 " . "\r\n") ;
                $x = WC_function_Colissimo::cdi_sanitize_colissimo_enligne($array_for_carrier['shipping_address_2']);
                fwrite($out, 'TAG POS=1 TYPE=INPUT:TEXT FORM=ID:coordonneesProfessionnel ATTR=ID:batimentPro CONTENT="' . $x . '"' . "\r\n") ;

                fwrite($out, "' *** Postal code " . "\r\n") ;
                fwrite($out, 'TAG POS=1 TYPE=INPUT:TEXT FORM=ID:coordonneesProfessionnel ATTR=ID:codePostalPro CONTENT="' . $array_for_carrier['shipping_postcode'] . '"' . "\r\n") ;

                fwrite($out, "' *** City and state " . "\r\n") ;
                $x = WC_function_Colissimo::cdi_sanitize_colissimo_enligne($array_for_carrier['shipping_city_state']);
                fwrite($out, 'TAG POS=1 TYPE=INPUT:TEXT FORM=ID:coordonneesProfessionnel ATTR=ID:localitePro CONTENT="' . $x . '"' . "\r\n") ;

                fwrite($out, "' *** Phone " . "\r\n") ;
                fwrite($out, 'TAG POS=1 TYPE=INPUT:TEXT FORM=ID:coordonneesProfessionnel ATTR=ID:phonee CONTENT="' . $array_for_carrier['billing_phone'] . '"' . "\r\n") ;

                fwrite($out, "' *** Email " . "\r\n") ;
                fwrite($out, 'TAG POS=1 TYPE=INPUT:TEXT FORM=ID:coordonneesProfessionnel ATTR=ID:email CONTENT="' . $array_for_carrier['billing_email'] . '"' . "\r\n") ;

                fwrite($out, "' *** Add Dest " . "\r\n") ;
                fwrite($out, 'TAG POS=1 TYPE=INPUT:SUBMIT FORM=ID:coordonneesProfessionnel ATTR=ID:AjouterDestinataireInsererAdressePro' . "\r\n") ;

                fwrite($out, "' *** Submit to next page " . "\r\n") ;
                fwrite($out, 'WAIT SECONDS=1' . "\r\n") ; 
                fwrite($out, 'TAG POS=1 TYPE=INPUT:SUBMIT FORM=ID:dlbi-colis-envoi ATTR=*' . "\r\n") ; 
                if ($cdi_rowcurrentorder < $cdi_nbrorderstodo) { // Close sequence
                  fwrite($out, "' *** Game over for next parcel " . "\r\n") ;
                  fwrite($out, 'WAIT SECONDS=1' . "\r\n") ; 
                  fwrite($out, 'TAG POS=1 TYPE=A ATTR=TXT:Ajouter<SP>un<SP>nouveau<SP>colis' . "\r\n") ;
                }else{
                  fwrite($out, 'WAIT SECONDS=2' . "\r\n") ;
                  fwrite($out, 'PROMPT "' . __('Here we are !', 'colissimo-delivery-integration') . ' \r\n ' . __('No scripting error? So now you can check and / or change your shipments.', 'colissimo-delivery-integration') . ' \r\n ' . __('As soon as everything is ok, then go to the Colissimo checkout.', 'colissimo-delivery-integration') . '"' . "\r\n") ;
                  fwrite($out, "' *** Tail of iMacros script " . "\r\n") ;
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
    } // End cdi_online_run
  } // cdi_gateway_online
} // End class
?>
