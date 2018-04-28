<?php

/**
 * This file is part of the Colissimo Delivery Integration plugin.
 * (c) Harasse
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if (!defined('ABSPATH')) exit;

//
// *** Example to have a  pickup location select from the google maps (need 3 hooks)
//


//****** Display of the selected location data with a select button
add_filter( 'cdi_filterhtml_retrait_descpickup',  'example_cdi_filterhtml_retrait_descpickup', 10, 2) ;
function example_cdi_filterhtml_retrait_descpickup ($description, $PointRetrait) {
  $return = '<div id="selretrait" data-value="' . $PointRetrait->identifiant . '">' ;
  $return .= '<p style="color:red; width:100%; display:inline-block;">(' . $PointRetrait->identifiant . ') <a class="selretrait button" style="float: right;" id="selretraitshown" >Sélectionner</a></p>' ;
  $return .= '<div id="selretraithidden" style="display:none;"><p style="text-align:center;"><a class="button">Point Retrait sélectionné</a></p></div>' ;
  $return .= '<p style="color:green; margin-bottom:0px;">' . $PointRetrait->nom . '</p>' ;
  $return .= '<p style="color:green; margin-bottom:0px;">' .  $PointRetrait->adresse1 . ' ' . $PointRetrait->adresse2 . '</p>' ;
  $return .= '<p style="color:green;">' . $PointRetrait->codePostal . ' ' . $PointRetrait->localite .  '</p>' ;
  $return .= '<p style="color:black;">Distance: ' . $PointRetrait->distanceEnMetre . 'm</p>' ;
  $return .= '<p style="color:black; margin-bottom:0px;"> Lundi ' . $PointRetrait->horairesOuvertureLundi . '</p>' ;
  $return .= '<p style="color:black; margin-bottom:0px;"> Mardi ' . $PointRetrait->horairesOuvertureMardi . '</p>' ;
  $return .= '<p style="color:black; margin-bottom:0px;"> Mercredi ' . $PointRetrait->horairesOuvertureMercredi . '</p>' ;
  $return .= '<p style="color:black; margin-bottom:0px;"> Jeudi ' . $PointRetrait->horairesOuvertureJeudi . '</p>' ;
  $return .= '<p style="color:black; margin-bottom:0px;"> Vendredi ' . $PointRetrait->horairesOuvertureVendredi . '</p>' ;
  $return .= '<p style="color:black; margin-bottom:0px;"> Samedi ' . $PointRetrait->horairesOuvertureSamedi . '</p>' ;
  $return .= '<p style="color:black;"> Dimanche ' . $PointRetrait->horairesOuvertureDimanche . '</p>' ;
  $return .= '<p style="color:black;">GPS: ' . $PointRetrait->coordGeolocalisationLatitude . ' ' . $PointRetrait->coordGeolocalisationLongitude .  '</p>' ;
  if ($PointRetrait->parking) $return .= '<p style="color:black ; margin-bottom:0px;">Parking: ' . $PointRetrait->parking . '</p>' ;
  if ($PointRetrait->accesPersonneMobiliteReduite) $return .= '<p style="color:black ; margin-bottom:0px;">Mobilité réduite: ' . $PointRetrait->accesPersonneMobiliteReduite . '</p>' ;
  if ($PointRetrait->langue) $return .= '<p style="color:black ; margin-bottom:0px;">Langue: ' . $PointRetrait->langue . '</p>' ;
  if ($PointRetrait->poidsMaxi) $return .= '<p style="color:black ; margin-bottom:0px;">Poids maxi: ' . $PointRetrait->poidsMaxi . '</p>' ;
  if ($PointRetrait->loanOfHandlingTool) $return .= '<p style="color:black ; margin-bottom:0px;">Equipements de manipulation: ' . $PointRetrait->loanOfHandlingTool . '</p>' ;
  $return .= '</div>' ;
  return $return ;
}
//****** Process the choice when the select button is pressed, and some html tweaks 
add_action('wp_footer','example_cdi_filterhtml_retrait_descpickup_js');
function example_cdi_filterhtml_retrait_descpickup_js() {
  if (is_checkout()) {
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
              fireEvent(sel,'change'); // Force a change event to resume the CDI process
              break;
            }
          }
          function fireEvent(element,event){
            if (document.createEventObject){ // dispatch for IE
              var evt = document.createEventObject();
              return element.fireEvent('on'+event,evt)
            }else{ // dispatch for firefox + others
              var evt = document.createEvent("HTMLEvents");
              evt.initEvent(event, true, true ); // event type,bubbling,cancelable
              return !element.dispatchEvent(evt);
            }
          }
        }); 
    </script><?php
    // Optional - Suppress of the no used display 
    ?> <style>  
      #zoneiconmap {display: none;} 
      /*   #pickupselect {display: none;}  */
    </style><?php
  }
}
//****** >Suppress the return data displayed which is no use in that case
add_filter( 'cdi_filterhtml_retrait_displayselected',  'example_cdi_filterhtml_retrait_displayselected', 10, 2) ;
function example_cdi_filterhtml_retrait_displayselected ($pickupdetail, $PointRetrait) {
  return '' ;
}

?>
