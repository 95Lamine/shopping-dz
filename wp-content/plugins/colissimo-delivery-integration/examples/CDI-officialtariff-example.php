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
// *** Example of filter in order to apply to customers the official Colissimo tariffs
//
// The table used here is the "Tarifs 2017 Contrat Privilège - Offre France" from Colissimo.
// You must therefore adapt the table according to your Colissimo tariffs and/or the tariffs you wish to apply to your customers.
//
add_filter( 'cdi_filterarray_shipping_rate','cdi_tarifs_officiels_colissimo_2017') ;
function cdi_tarifs_officiels_colissimo_2017 ($rate) {
  global $woocommerce;
  $newrate = $rate ;
  $shippingcountry = WC()->customer->get_shipping_country();
  if (!(strpos('FR,MC,AD', $shippingcountry) === false)) { // Only FR,MC,AD are accepted
    $method = explode(':', $rate['id'])[0] ;
    $method = str_replace('colissimo_shippingzone_method_','',$method) ;
    if ($method == 'home1'  or $method == 'home2' or $method == 'pick1') { // Only some mehods are accepted
      $tarifcolissimo = array (
        // Tarifs HT France selon le poids 
        // Poids mini, Poids maxi, Tarif sans signature, Tarif avec signature, Tarif relais pickup consigne ou station
        array ("wmax" => 0.25, "dom" => 5.41, "dos" => 6.22, "ret" => 4.21),
        array ("wmax" => 0.50, "dom" => 6.10, "dos" => 7.04, "ret" => 4.90),
        array ("wmax" => 0.75, "dom" => 6.83, "dos" => 7.77, "ret" => 5.63),
        array ("wmax" => 1.00, "dom" => 7.41, "dos" => 8.35, "ret" => 6.21),
        array ("wmax" => 2.00, "dom" => 8.21, "dos" => 9.15, "ret" => 7.01),
        array ("wmax" => 3.00, "dom" => 9.01, "dos" => 9.95, "ret" => 7.81),
        array ("wmax" => 4.00, "dom" => 9.83, "dos" => 10.77, "ret" => 8.63),
        array ("wmax" => 5.00, "dom" => 10.63, "dos" => 11.57, "ret" => 9.43),
        array ("wmax" => 6.00, "dom" => 11.45, "dos" => 12.39, "ret" => 10.2),
        array ("wmax" => 7.00, "dom" => 12.25, "dos" => 13.19, "ret" => 11.05),
        array ("wmax" => 8.00, "dom" => 13.05, "dos" => 13.99, "ret" => 11.85),
        array ("wmax" => 9.00, "dom" => 13.87, "dos" => 14.81, "ret" => 12.67),
        array ("wmax" => 10.00, "dom" => 14.67, "dos" => 15.61, "ret" => 13.47),
        array ("wmax" => 11.00, "dom" => 15.49, "dos" => 16.43, "ret" => 14.29),
        array ("wmax" => 12.00, "dom" => 16.29, "dos" => 17.23, "ret" => 15.09),
        array ("wmax" => 13.00, "dom" => 17.10, "dos" => 18.04, "ret" => 15.90),
        array ("wmax" => 14.00, "dom" => 17.91, "dos" => 18.85, "ret" => 16.71),
        array ("wmax" => 15.00, "dom" => 18.71, "dos" => 19.65, "ret" => 17.51),
        array ("wmax" => 16.00, "dom" => 19.53, "dos" => 20.47, "ret" => 18.33),
        array ("wmax" => 17.00, "dom" => 20.33, "dos" => 21.27, "ret" => 19.13),
        array ("wmax" => 18.00, "dom" => 21.14, "dos" => 22.08, "ret" => 19.94),
        array ("wmax" => 19.00, "dom" => 21.95, "dos" => 22.89, "ret" => 20.75),
        array ("wmax" => 20.00, "dom" => 22.75, "dos" => 23.69, "ret" => 21.55),
        array ("wmax" => 21.00, "dom" => 23.57, "dos" => 24.51, "ret" => 22.37),
        array ("wmax" => 22.00, "dom" => 24.37, "dos" => 25.31, "ret" => 23.17),
        array ("wmax" => 23.00, "dom" => 25.18, "dos" => 26.12, "ret" => 23.98),
        array ("wmax" => 24.00, "dom" => 25.99, "dos" => 26.93, "ret" => 24.79),
        array ("wmax" => 25.00, "dom" => 26.79, "dos" => 27.73, "ret" => 25.59),
        array ("wmax" => 26.00, "dom" => 27.61, "dos" => 28.55, "ret" => 26.41),
        array ("wmax" => 27.00, "dom" => 28.41, "dos" => 29.35, "ret" => 27.21),
        array ("wmax" => 28.00, "dom" => 29.22, "dos" => 30.16, "ret" => 28.02),
        array ("wmax" => 29.00, "dom" => 30.03, "dos" => 30.97, "ret" => 28.83),
        array ("wmax" => 30.00, "dom" => 30.83, "dos" => 31.77, "ret" => 29.63)
      ) ;
      $weightcart = (float)$woocommerce->cart->cart_contents_weight;
      if (get_option( 'woocommerce_weight_unit' ) == 'g') { // Convert g to kg
        $weightcart = $weightcart/1000 ;
      }
      foreach ($tarifcolissimo as $tar) {
        if ($weightcart <= $tar['wmax']) {
          if ($method == 'home1') {
            $newrate['cost'] =  $tar['dom'] ;
            break ;
          }elseif ($method == 'home2') {
            $newrate['cost'] =  $tar['dos'] ;
            break ;
          }elseif ($method == 'pick1') {
            $newrate['cost'] =  $tar['ret'] ;
            break ;
          } 
        }
      }
    }
  }
  return $newrate;
}

?>
