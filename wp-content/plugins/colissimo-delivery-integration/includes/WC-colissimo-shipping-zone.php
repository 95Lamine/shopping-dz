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
/* Colissimo Shipping Method (Shipping zone mode)                                       */
/****************************************************************************************/

class WC_colissimo_shipping {
  public static function init()  {
  }
}

$isitenable = get_option('wc_settings_tab_colissimo_methodshipping') ;
if ($isitenable == 'yes') {
  $wooversion = WC_function_Colissimo::cdi_get_woo_version_number();
  if ($wooversion >= '2.6.0' ) {
    add_action('woocommerce_shipping_init', 'colissimo_shippingzone_method_init');
    add_filter('woocommerce_shipping_methods', 'WC_shipping_method_choice_add');
    $isicon = get_option('wc_settings_tab_colissimo_methodshippingicon') ;
    if ($isicon == 'yes') {
      add_filter('woocommerce_cart_shipping_method_full_label', 'cdi_woocommerce_cart_shipping_method_full_label' , 2, 2) ;
    }
  }
}

  function WC_shipping_method_choice_add($methods){
    $methods['colissimo_shippingzone_method'] = 'Class_Colissimo_Shipping';
    return $methods;
  }

  function colissimo_shippingzone_method_init() {
    class Class_Colissimo_Shipping extends WC_Shipping_Method {
      public $ColissimoInstance;

      public function __construct( $instance_id = 0 ) {
        $this->id = 'colissimo_shippingzone_method';
        $this->instance_id = absint( $instance_id );
        $this->method_title = __('Colissimo', 'colissimo-delivery-integration');
        $this->method_description = __('Colissimo multi purpose shipping method', 'colissimo-delivery-integration');
	$this->supports = array('shipping-zones', 'instance-settings',);
        $array = array(
          'activator' => array(
            'type' => 'checkbox',
            'label' => __('Activate this instance of "Colissimo shipping method"', 'colissimo-delivery-integration') ,
            'desc_tip' => __( 'If no checked, the shipping rates will not be shown to customers.', 'colissimo-delivery-integration' ),
            'default' => 'no'
          ) ,
          'title' => array(
            'title' => __( 'Title','colissimo-delivery-integration'),
            'type' => 'text',
            'desc_tip' => __( 'Mandatory - Title shown in admin shipping options', 'colissimo-delivery-integration' ),
            'default' => __( 'Colissimo','colissimo-delivery-integration'),
          ),
          'prefixshipping' => array(
            'title' => __( 'Prefix ','colissimo-delivery-integration'),
            'type' => 'text',
            'desc_tip' => __( 'Optional - Prefix of shipping title which will be seen by customer.', 'colissimo-delivery-integration' ),
            'default' => __( 'Colissimo','colissimo-delivery-integration'),
          ),
          'shippingdefaulttariffsfile' => array(
            'title' => __( 'Default tariffs file','colissimo-delivery-integration'),
            'type' => 'text',
            'desc_tip' => __( 'Optional - Default tariffs file to overcome the example tariffs at initialisation.', 'colissimo-delivery-integration' ),
            'default' => '',
          ),
          'table_rates' => array(
            'type' => 'shipping_table',
            'default' => '',
          ) ,
          'tax_status' => array(
            'title' => __( 'Others:','colissimo-delivery-integration'),
            'type' => 'select',
            'desc_tip' => __('Tax Status. To apply or not the tax for the shipping fees when in TVA rates you have checked the shipping tick.', 'colissimo-delivery-integration') ,
            'class' => 'wc-enhanced-select',
            'default' => 'taxable',
            'options' => array(
              'taxable' => __('Taxable', 'woocommerce') ,
              'none' => _x('None', 'Tax status', 'woocommerce')
            ) ,
          ) ,
          'shippingclassmode' => array(
            'type' => 'checkbox',
            'label' => __('"Excluding" shipping class mode', 'colissimo-delivery-integration') ,
            'desc_tip' => __( 'Check to have shipping class mode set to "Excluding" mode', 'colissimo-delivery-integration' ),
            'default' => 'no',
          ),
          'shippingpricemode' => array(
            'type' => 'checkbox',
            'label' => __('"Price all tax included" shipping price mode', 'colissimo-delivery-integration') ,
            'desc_tip' => __( 'Check to control cart price with all its tax included.', 'colissimo-delivery-integration' ),
            'default' => 'no',
          ),

        );
        if (WC_function_Colissimo::cdi_isconnected()) {
          eval (WC_function_Colissimo::cdi_eval('7')) ;
          $arrayext = array (
                        'shippingemptypackageweightmode' => array(
                                'type' => 'checkbox',
                                'label' => __('including empty package weight mode', 'colissimo-delivery-integration') ,
                                'desc_tip' => __( 'Check to add empty package weight when considering cart weight.', 'colissimo-delivery-integration' ),
                                'default' => 'no',
                        ),
			'requires' => array(
				'title'   => __( 'Promos :', 'woocommerce' ),
				'type'    => 'select',
				'class'   => 'wc-enhanced-select',
				'default' => '',
				'options' => array(
					''           => __( 'N/A', 'woocommerce' ),
					'coupon'     => __( 'A valid free shipping coupon', 'woocommerce' ),
					'min_amount' => __( 'A minimum order amount', 'woocommerce' ),
					'either'     => __( 'A minimum order amount OR a coupon', 'woocommerce' ),
					'both'       => __( 'A minimum order amount AND a coupon', 'woocommerce' ),
				),
				'description' => __( 'Permet une activation ou non de cette instance Colissimo selon le montant du panier et le code promo actif. ', 'woocommerce' ),
			),
			'min_amount' => array(
				'type'        => 'price',
				'placeholder' => wc_format_localized_price( 0 ),
				'description' => __( 'Les clients devront avoir un montant de dépense supérieur à ce montant pour que cette instance Colissimo soit active (si option choisie ci-dessus).', 'woocommerce' ),
				'default'     => '0',
				'desc_tip'    => true,
			),
                       'promomode' => array(
                                'type' => 'checkbox',
                                'label' => __('"Excluding promo" mode', 'colissimo-delivery-integration') ,
                                'desc_tip' => __( 'Check to have promo mode set to "Excluding" mode', 'colissimo-delivery-integration' ),
                                'default' => 'no',
                        ),
                   );
          eval (WC_function_Colissimo::cdi_eval('3')) ;
          eval (WC_function_Colissimo::cdi_eval('12')) ;
        }
        $this->instance_form_fields = $array ;
        $this->enabled = $this->get_option('enabled');
        $title = $this->get_option( 'title' );
        if (!$title) {
          $title = 'Colissimo'; // Avoid blank 
        }
        $this->title = $title ;
        $this->activator = $this->get_option( 'activator' );
        $this->prefixshipping = $this->get_option( 'prefixshipping' );
        $this->shippingclassmode = $this->get_option( 'shippingclassmode' );
        $this->shippingpricemode = $this->get_option( 'shippingpricemode' );
        $this->shippingemptypackageweightmode = $this->get_option( 'shippingemptypackageweightmode' );
        $this->shippingdefaulttariffsfile = $this->get_option( 'shippingdefaulttariffsfile' );
        $this->tax_status = $this->get_option('tax_status');
        if (WC_function_Colissimo::cdi_isconnected()) {
          $this->min_amount = $this->get_option( 'min_amount', 0 );
          eval (WC_function_Colissimo::cdi_eval('4')) ;
          $this->promomode = $this->get_option( 'promomode' );
        }
        $this->ColissimoInstance = new Class_Colissimo_Shipping_Function(); 
        $this->table_rates = $this->get_option( 'table_rates' );
        $this->init_instance_settings();

 	add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
      }

      public function is_available($package) {
        if (WC_function_Colissimo::cdi_isconnected()) {
          eval (WC_function_Colissimo::cdi_eval('7')) ;
          $has_coupon         = false;
          $has_met_min_amount = false;
          if ( in_array( $this->requires, array( 'coupon', 'either', 'both' ) ) ) {
            if ( $coupons = WC()->cart->get_coupons() ) {
              foreach ( $coupons as $code => $coupon ) {
                if ( $coupon->is_valid() && $coupon->get_free_shipping() ) {
                  $has_coupon = true;
                  break;
                }
              }
            }
          }
          if ( in_array( $this->requires, array( 'min_amount', 'either', 'both' ) ) && isset( WC()->cart->cart_contents_total ) ) {
            eval (WC_function_Colissimo::cdi_eval('5')) ;
            if ( 'incl' === WC()->cart->tax_display_cart ) {
              $total = round( $total - ( WC()->cart->get_cart_discount_total() + WC()->cart->get_cart_discount_tax_total() ), wc_get_price_decimals() );
            } else {
              $total = round( $total - WC()->cart->get_cart_discount_total(), wc_get_price_decimals() );
            }
            if ( $total >= $this->min_amount ) {
              $has_met_min_amount = true;
            }
          }
          switch ( $this->requires ) {
            case 'min_amount' :
              $is_available = $has_met_min_amount;
              break;
            case 'coupon' :
              $is_available = $has_coupon;
              break;
            case 'both' :
              $is_available = $has_met_min_amount && $has_coupon;
              break;
            case 'either' :
              $is_available = $has_met_min_amount || $has_coupon;
              break;
            default :
              $is_available = true;
              break;
          }
          if ($this->promomode == "yes") {
            $is_available = !$is_available;
          }
          eval (WC_function_Colissimo::cdi_eval('12')) ;
          return $is_available;
        }else{
	  return TRUE;
        }
      }

      function calculate_shipping($package = array()) {
        $this->ColissimoInstance->calculate_shipping($package = array() , $this);
      }

      function validate_shipping_table_field($key) { // Only if key is table_rates
        $table_rates = array();
        $currentpackage = $this ;
        if (isset($_POST[$currentpackage->id . '_tablerate'])) {
          $rates = $_POST[$currentpackage->id . '_tablerate'];
        }else{
          $rates = null;
        }
        if (is_array($rates)) {
          foreach($rates as $rate) {
            if (!isset($rate['class'])) {
              $rate['class'] = 'all' ;
            }
            if (is_array($rate['class'])){
              $xlistclass = implode(",", $rate['class']) ;
            }else{
              $xlistclass = $rate['class'] ;
            }
            $table_rates[] = array(
              'class' => (string)$xlistclass,
              'methods' => (string)$rate['methods'],
              'pricemin' => (float)$rate['pricemin'],
              'pricemax' => (float)$rate['pricemax'],
              'weightmin' => (float)$rate['weightmin'],
              'weightmax' => (float)$rate['weightmax'],
              'fare' => (float)$rate['fare'],
              'addfees' => (string)$rate['addfees'],
              'method_name' => (string)$rate['method_name']
            );
          }
        }
        return $table_rates;
      }

      function generate_shipping_table_html() {
        return $this->ColissimoInstance->generate_shipping_table_html($this);
      }

      function process_table_rates() {
        $this->ColissimoInstance->process_table_rates($this);
      }

      function save_default_costs($fields) {
        return $this->ColissimoInstance->save_default_costs($fields);
      }

      function load_table_rates() {
        $this->table_rates = $this->get_table_rates(); 
      }

      function get_table_rates() {
        $return = array_filter((array)get_option($this->table_rates));
        if ($return) {
          return $return;
        }else{
          return $this->get_default_table_rates();
        }
      }

      function get_custom_table_rates($shippingdefaulttariffsfile) {
        $dircdistore =  plugin_dir_path( __FILE__ )  . 'uploads/';
        $dircdistore = str_replace('/includes/', '/', $dircdistore) ;
        $filename = $dircdistore . $shippingdefaulttariffsfile ;
        $url = wp_nonce_url('plugins.php?page=colissimo-delivery-integration');
        $creds = request_filesystem_credentials($url, "", false, false, null) ; 
        if ( ! WP_Filesystem($creds) ) {
	  request_filesystem_credentials($url, '', true, false, null);
        }
        global $wp_filesystem;
        if (!file_exists($filename)) { 
          $code = '';
          echo '<div class="updated notice"><p>';
          echo  __( 'This file does not exist in colissimo-delivery-integration/uploads : ', 'colissimo-delivery-integration' ) . $shippingdefaulttariffsfile;
          echo "</p></div>";
        }else{
          $filecontent = $wp_filesystem->get_contents( $filename) ;
          if ( ! $filecontent ) {
            $code = '';
            echo '<div class="updated notice"><p>';
            echo  __( 'This file in colissimo-delivery-integration/uploads is not valid : ', 'colissimo-delivery-integration' ) . $shippingdefaulttariffsfile;
            echo "</p></div>";
          }else{
            $code =  $filecontent;
          }
        }
        if (isset($code) &&  $code !== '' && strpos($code, 'array(') === 0) {
          $code = str_replace('\\', '', $code); 
          $return = eval('return ' . $code);
        }else{
          $return = '' ;
          echo '<div class="updated notice"><p>';
          echo  __( 'This file in colissimo-delivery-integration/uploads is not valid : ', 'colissimo-delivery-integration' ) . $shippingdefaulttariffsfile;
          echo "</p></div>";
        }
        return $return ;
      }

      function get_default_table_rates() {
        return array(
          array(
            'class' => 'all',
            'methods' => 'home1',
            'pricemin' => '0',
            'pricemax' => '124.99',
            'weightmin' => '0',
            'weightmax' => '30000',
            'fare' => 6.25,
            'addfees' => '',
            'method_name' => 'France',
          ) ,
          array(
            'class' => 'all',
            'methods' => 'home1',
            'pricemin' => '125',
            'pricemax' => '5000',
            'weightmin' => '0',
            'weightmax' => '30000',
            'fare' => 0,
            'addfees' => '',
            'method_name' => 'France Gratuit',
          ) ,
          array(
            'class' => 'all',
            'methods' => 'home1',
            'pricemin' => '0',
            'pricemax' => '5000',
            'weightmin' => '0',
            'weightmax' => '30000',
            'fare' => 15,
            'addfees' => '',
            'method_name' => 'Europe',
          ) ,
          array(
            'class' => 'all',
            'methods' => 'home1',
            'pricemin' => '0',
            'pricemax' => '5000',
            'weightmin' => '0',
            'weightmax' => '30000',
            'fare' => 30,
            'addfees' => '',
            'method_name' => 'International',
          ) ,
          array(
            'class' => 'all',
            'methods' => 'home2',
            'pricemin' => '0',
            'pricemax' => '5000',
            'weightmin' => '0',
            'weightmax' => '30000',
            'fare' => 6.10,
            'addfees' => '',
            'method_name' => 'Domicile sans signature',
          ) ,
          array(
            'class' => 'all',
            'methods' => 'home2',
            'pricemin' => '0',
            'pricemax' => '5000',
            'weightmin' => '0',
            'weightmax' => '30000',
            'fare' => 8.60,
            'addfees' => '',
            'method_name' => 'Domicile avec signature',
          ) ,
          array(
            'class' => 'all',
            'methods' => 'pick1',
            'pricemin' => '0',
            'pricemax' => '5000',
            'weightmin' => '0',
            'weightmax' => '30000',
            'fare' => 6.10,
            'addfees' => '',
            'method_name' => 'Retrait en relais Pickup ou consigne Pickup Station',
          ) ,
          array(
            'class' => 'all',
            'methods' => 'pick2',
            'pricemin' => '0',
            'pricemax' => '5000',
            'weightmin' => '0',
            'weightmax' => '30000',
            'fare' => 6.10,
            'addfees' => '',
            'method_name' => 'Retrait à la Poste',
          ) ,
          array(
            'class' => 'all',
            'methods' => 'home4',
            'pricemin' => '0',
            'pricemax' => '5000',
            'weightmin' => '0',
            'weightmax' => '20000',
            'fare' => 10.00,
            'addfees' => '<?php $level = error_reporting(0); define(fare, fare); error_reporting($level); $price=(float)$woocommerce->cart->cart_contents_total; $weight=(float)$woocommerce->cart->cart_contents_weight; $p=$price*0.01; $w= ($weight/1000)*3; $x=($weight/1000)*$rates[fare]; $return = $p+$w+$x; ?>',
            'method_name' => 'Variable PHP',
          ) ,
          array(
            'class' => 'all',
            'methods' => 'home3',
            'pricemin' => '0',
            'pricemax' => '5000',
            'weightmin' => '0',
            'weightmax' => '20000',
            'fare' => 12.15,
            'addfees' => 'p=+1%, w=+3',
            'method_name' => 'Variable Price-Weight',
          ) ,
          array(
            'class' => 'lourd',
            'methods' => 'shop1',
            'pricemin' => '0',
            'pricemax' => '5000',
            'weightmin' => '12000',
            'weightmax' => '50000',
            'fare' => 0,
            'addfees' => '',
            'method_name' => 'Retrait boutique Article lourd',
          ) ,
        );
      }

      function save_default_table_rates() {
        $table_rates = $this->get_default_table_rates();
        update_option($this->table_rates, $table_rates);
      }

      function get_methods() {
        $shipping_methods = array(
          'home1' => 'home1',
          'home2' => 'home2',
          'home3' => 'home3',
          'home4' => 'home4',
          'home5' => 'home5',
          'pick1' => 'pick1',
          'pick2' => 'pick2',
          'pick3' => 'pick3',
          'pick4' => 'pick4',
          'pick5' => 'pick5',
          'shop1' => 'shop1',
          'shop2' => 'shop2',
          'shop3' => 'shop3',
          'shop4' => 'shop4',
          'shop5' => 'shop5',
        );
        $extends = get_option( 'wc_settings_tab_colissimo_methodshipping_extendtermid' ) ;
        $extends = str_replace ( ' ' , '' , $extends ) ;
        if ($extends && $extends !== '') {
          $extends = explode ( ',' , $extends) ;
          foreach ( $extends as $extend) {
            if ($extend) {
             $shipping_methods[$extend] = $extend ;
            }
          }
        }
        return $shipping_methods;
      }
    }

    class Class_Colissimo_Shipping_Function {

      public function calculate_shipping($package = array() , $currentpackage) {
        global $woocommerce;
        $currentpackage->rate = array();
        $shipping_rates = $currentpackage->get_option('table_rates');
        if (empty($shipping_rates)) $shipping_rates = $currentpackage->table_rates;
        if ($currentpackage->shippingpricemode == 'yes') {
          $price = (float)$woocommerce->cart->subtotal; // Total cart with Tax
        }else{
          $price = (float)$woocommerce->cart->cart_contents_total; // Total cart without Tax
        }
        $weight = (float)$woocommerce->cart->cart_contents_weight;
        if (get_option( 'woocommerce_weight_unit' ) == 'kg') { // Convert kg to g
          $weight = $weight * 1000 ;
        }
        if ($currentpackage->shippingemptypackageweightmode == 'yes') {
          $weight = $weight + get_option( 'wc_settings_tab_colissimo_parcelweight' ) ;
        }
        $classlist = array();
        foreach($woocommerce->cart->get_cart() as $item) {
          if ($item['data']->get_shipping_class()) {
            $classlist[] = $item['data']->get_shipping_class();
          }else{
            $classlist[] = 'no';
          }
        }
        if (!empty($shipping_rates)) {
          $currentshippingrates = array();
          foreach($shipping_rates as $rates) {
            // Buid the array of slug of the shipping classes
            $arrratesclassslug = null ;
            $array = explode(',', $rates['class']);
            foreach ($array as $xclassname) {
              if ($xclassname == 'all') {
                $arrratesclassslug[] = 'all' ;
              }elseif ($xclassname == 'no' ) {
                $arrratesclassslug[] = 'no' ;
              }else{
                if (WC()->shipping->get_shipping_classes()) {
                  foreach(WC()->shipping->get_shipping_classes() as $xshippingclass) {
                    if ($xclassname == $xshippingclass->name) {
                      $arrratesclassslug[] = $xshippingclass->slug ;
                    }
                  }
                }
              }
            }
            // Test if rate is to activate
            $is_eligible = true ;
            if (!((float)$price >= (float)$rates['pricemin'])) {
              $is_eligible = false ;
            }elseif (!((float)$price <= (float)$rates['pricemax'] || (float)$rates['pricemax'] == 0)) {
              $is_eligible = false ;
            }elseif (!((float)$weight >= (float)$rates['weightmin']) ) {
              $is_eligible = false ;
            }elseif (!((float)$weight <= (float)$rates['weightmax'] || (float)$rates['weightmax'] == 0)) {
              $is_eligible = false ;
            }else{
              // Test shipping class condition
              if ($currentpackage->shippingclassmode == 'yes') {
                if ($arrratesclassslug) {
                  foreach ($arrratesclassslug as $slug) {
                    if (!(!isset($slug) || !in_array(sanitize_title($slug) , array_map('strtolower', $classlist)))) {
                      $is_eligible = false ;
                      break ;
                    }else{
                      $is_eligible = true ;
                    }
                  }
                }
              }else{
                $classlist[] = 'all';
                if ($arrratesclassslug) {
                  foreach ($arrratesclassslug as $slug) {
                    if (!(!isset($slug) || in_array(sanitize_title($slug) , array_map('strtolower', $classlist)))) {
                      $is_eligible = false ;
                    }else{
                      $is_eligible = true ;
                      break ;
                    }
                  }
                }
              }
            }
            if ($is_eligible) {
              $currentshippingrates[] = $rates;
            }
          }
          $rgmeth = 0 ;
          foreach($currentshippingrates as $rates) {
            if ($rates['method_name']) {
              $rgmeth = $rgmeth + 1 ;
              // Add fees
              $toadd = (float)0;
              $code = $rates['addfees'] ;
              if (isset($code) &&  $code !== '' && strpos($code, '<?php') === 0) {
                $code = str_replace('<?php', '', $code);
                $code = str_replace('?>', '', $code);  
                $code = str_replace('\\', '', $code); 
                $return =0;
                eval($code);
                $toadd = $toadd + $return ;
              }else{
                $arrayaddfees = explode(',', $rates['addfees']);
                $arrayaddfees = array_map("trim", $arrayaddfees);
                foreach($arrayaddfees as $addfee){
                  if ($addfee){
                    if (strpos($addfee, 'p=+') == 0){
                      $p = str_replace('p=+', '', $addfee);
                      $p = (float)(str_replace('%', '', $p));
                      $x = (($price / 100) * $p)  ;
                      $toadd = $toadd + $x ;
                    }
                    if (strpos($addfee, 'w=+') == 0){
                      $w = str_replace('w=+', '', $addfee);
                      $x = (float)(($weight / 1000) * $w) ;
                      $toadd = $toadd + $x ;
                    }
                  }
                }
              }
              eval (WC_function_Colissimo::cdi_eval('7')) ;
              $fare = $rates['fare'] + $toadd;
              $idinstance = $currentpackage->get_instance_id();
              $rate = array(
                'id' => $currentpackage->id . '_' . $rates['methods'] . ':' . $idinstance . ':' . $rgmeth,
                'label' => __($currentpackage->prefixshipping, 'colissimo-delivery-integration') . ' '. __($rates['method_name'], 'colissimo-delivery-integration'),
                'cost' => $fare,
                'calc_tax' => 'per_order'
              );
              $rate = apply_filters( 'cdi_filterarray_shipping_rate', $rate) ;
              if ($currentpackage->activator !== 'no') { // Only if instance is activated or not registered
                $currentpackage->add_rate($rate);
              }
              eval (WC_function_Colissimo::cdi_eval('12')) ;
              WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $rate);
            }
          }
        }
      }

      function save_default_costs($fields) {
        $default_pricemin = woocommerce_clean($_POST['default_pricemin']);
        $default_pricemax = woocommerce_clean($_POST['default_pricemax']);
        $default_fare = woocommerce_clean($_POST['default_fare']);
        $fields['pricemin'] = $default_pricemin;
        $fields['pricemax'] = $default_pricemax;
        $fields['fare'] = $default_fare;
        return $fields;
      }

      function generate_thead_tfoot() {
        ?>
        <td class="check-column"><input type="checkbox"></td>
	  <th><div style="text-align:center;"><div style="display:inline-block;"><?php _e('Name', 'colissimo-delivery-integration'); ?>
            <span class="woocommerce-help-tip" data-tip=" " title="<?php _e('Name seen by the customer', 'colissimo-delivery-integration'); ?>"></span>
            </div></div></th>
	  <th><div style="text-align:center;"><div style="display:inline-block;"><?php _e('Flat rate', 'colissimo-delivery-integration'); ?>
            <span class="woocommerce-help-tip" data-tip=" " title="<?php _e('Flat rate VAT excluded', 'colissimo-delivery-integration'); ?>"></span>
            </div></div></th>
          <th><div style="text-align:center;"><div style="display:inline-block;"><?php _e('Add fees', 'colissimo-delivery-integration'); ?>
            <span class="woocommerce-help-tip" data-tip=" " title="<?php _e('Comma separated list of additionnal fees, VAT excluded, to add to flat rate. Percentage of price and/or weight(kg) fee. Syntaxe : p=+2.5%, w=+5 . May also be a short php code trigger under create_function', 'colissimo-delivery-integration'); ?>"></span>
            </div></div></th>
          <th><div style="text-align:center;"><div style="display:inline-block;"><?php _e('Shipping class', 'colissimo-delivery-integration'); ?>
            <span class="woocommerce-help-tip" data-tip=" " title="<?php _e('In standard mode,  to activate this rate, an item at least in your cart must have one of the shipping classes. If your have checked the Exclude tick, this rate will activate if none of your items in your cart have none of the shipping classes. Multi select classes allowed.', 'colissimo-delivery-integration'); ?>"></span>
            </div></div></th>
          <th><div style="text-align:center;"><div style="display:inline-block;"><?php _e('Method', 'colissimo-delivery-integration'); ?>
            <span class="woocommerce-help-tip" data-tip=" " title="<?php _e('End of CDI method id', 'colissimo-delivery-integration'); ?>"></span>
            </div></div></th>
	  <th><div style="text-align:center;"><div style="display:inline-block;"><?php _e('Min price', 'colissimo-delivery-integration'); ?>
            <span class="woocommerce-help-tip" data-tip=" " title="<?php _e('minimum price, VAT excluded. All taxes included if the mode is checked.', 'colissimo-delivery-integration'); ?>"></span>
            </div></div></th>
	  <th><div style="text-align:center;"><div style="display:inline-block;"><?php _e('Max price', 'colissimo-delivery-integration'); ?>
            <span class="woocommerce-help-tip" data-tip=" " title="<?php _e('maximum price, VAT excluded. All taxes included if the mode is checked.', 'colissimo-delivery-integration'); ?>"></span>
            </div></div></th>
	  <th><div style="text-align:center;"><div style="display:inline-block;"><?php _e('Min weight', 'colissimo-delivery-integration'); ?>
            <span class="woocommerce-help-tip" data-tip=" " title="<?php _e('minimum weight in g', 'colissimo-delivery-integration'); ?>"></span>
            </div></div></th>
	  <th><div style="text-align:center;"><div style="display:inline-block;"><?php _e('Max weight', 'colissimo-delivery-integration'); ?>
            <span class="woocommerce-help-tip" data-tip=" " title="<?php _e('maximum weight in g', 'colissimo-delivery-integration'); ?>"></span>
            </div></div></th>
        <?php
      }


      function generate_shipping_table_html($currentpackage) {
        global $woocommerce;
        ob_start();
        ?>
	  <tr valign="top">
	    <th scope="row" class="titledesc"><?php
              _e('Rates', 'colissimo-delivery-integration'); ?>:</th>
	      <td class="forminp" id="<?php  echo $currentpackage->id; ?>_table_rates">
	      <table class="shippingrows widefat" cellspacing="0">
		<thead>
		  <tr style="background-color:#E1E1E1">
                    <?php Class_Colissimo_Shipping_Function::generate_thead_tfoot() ; ?>
		  </tr>
		</thead>
		<tfoot>
		  <tr style="background-color:#E1E1E1">
                    <?php Class_Colissimo_Shipping_Function::generate_thead_tfoot() ; ?>
		  </tr>
		  <tr>
		    <th colspan="8">
                      <a href="#" class="add button" style="margin-left: 24px"> <?php _e('Add rate', 'colissimo-delivery-integration'); ?></a> 
                      <a href="#" class="remove button"><?php _e('Delete selected', 'colissimo-delivery-integration'); ?></a></th>
		  </tr>
		</tfoot>
		<tbody class="table_rates" style="background-color:#E1E1E1">
                <p><?php _e('If empty table is saved, examples of methods are shown.', 'colissimo-delivery-integration'); ?></p>
	<?php
        $i = - 1;
        $tablerows = $currentpackage->get_option('table_rates') ;
        if (!$tablerows) {
          $x = new Class_Colissimo_Shipping ;
          $shippingdefaulttariffsfile = $currentpackage->get_option('shippingdefaulttariffsfile') ;
          if ($shippingdefaulttariffsfile !== '') {
            $tablerows = $x->get_custom_table_rates($shippingdefaulttariffsfile) ;
          }else{
            $tablerows = $x->get_default_table_rates() ;
          }
        }
        if ( $tablerows) {
          foreach($tablerows as $class => $rate) {
            $zlistclass = explode(",", $rate['class']);
            $methodsData = array();
            $options = '';
            $i++;
            $methods = new Class_Colissimo_Shipping();
            $methodsData = $methods->get_methods();
            foreach($methodsData as $key => $m) {
              $selected = '';
              if (esc_attr($rate['methods']) == $key) $selected = 'selected="selected"';
              $options.= '<option ' . $selected . ' value="' . $key . '">' . $m . '</option>';
            }
            $shipClass = '';
            $shipclassArr = array();
            if ($currentpackage->shippingclassmode == 'yes') {
              $shipclassArr['no'] = 'No class';
            }else{
              $shipclassArr['all'] = 'All';
              $shipclassArr['no'] = 'No class';
            }
            if (WC()->shipping->get_shipping_classes()) {
              foreach(WC()->shipping->get_shipping_classes() as $shipping_class) {
                $shipclassArr[$shipping_class->name] = $shipping_class->name;
              }
            }
            //WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $shipclassArr);
            foreach($shipclassArr as $key => $m) {
              //WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $m);
              $selected = '';
              if (isset($zlistclass) && in_array($key , $zlistclass) ) {
                $selected = 'selected="selected"';
              }
              $shipClass.= '<option ' . $selected . ' value="' . $key . '">' . $m . '</option>';
            }
            echo '<tr class="table_rate">
	       <th class="check-column"><input type="checkbox" name="select" /></th>
                  <td><input type="text" value="' . esc_attr($rate['method_name']) . '" name="' . esc_attr($currentpackage->id . '_tablerate[' . $i . '][method_name]') . '" style="width: 90%; min-width:100px" class="' . esc_attr($currentpackage->id . 'field[' . $i . ']') . '" placeholder="" size="4" /></td>
		  <td><input type="number" step="any" min="0" value="' . esc_attr($rate['fare']) . '" name="' . esc_attr($currentpackage->id . '_tablerate[' . $i . '][fare]') . '" style="width: 90%; min-width:75px" class="' . esc_attr($currentpackage->id . 'field[' . $i . ']') . '" placeholder="0.00" size="4" /></td>
                  <td><input type="text" value="' . esc_attr($rate['addfees']) . '" name="' . esc_attr($currentpackage->id . '_tablerate[' . $i . '][addfees]') . '" style="width: 90%; min-width:75px" class="' . esc_attr($currentpackage->id . 'field[' . $i . ']') . '" placeholder="" size="4" /></td>
                  <td><select multiple size="2" name="' . esc_attr($currentpackage->id . '_tablerate[' . $i . '][class][]') . '">' . $shipClass . '</select></td>
                  <td><select name="' . esc_attr($currentpackage->id . '_tablerate[' . $i . '][methods]') . '">' . $options . '</select></td>
		  <td><input type="number" step="any" min="0" value="' . esc_attr($rate['pricemin']) . '" name="' . esc_attr($currentpackage->id . '_tablerate[' . $i . '][pricemin]') . '" style="width: 90%; min-width:75px" class="' . esc_attr($currentpackage->id . 'field[' . $i . ']') . '" placeholder="0.00" size="4" /></td>
		  <td><input type="number" step="any" min="0" value="' . esc_attr($rate['pricemax']) . '" name="' . esc_attr($currentpackage->id . '_tablerate[' . $i . '][pricemax]') . '" style="width: 90%; min-width:75px" class="' . esc_attr($currentpackage->id . 'field[' . $i . ']') . '" placeholder="0.00" size="4" /></td>
                  <td><input type="number" step="any" min="0" value="' . esc_attr($rate['weightmin']) . '" name="' . esc_attr($currentpackage->id . '_tablerate[' . $i . '][weightmin]') . '" style="width: 90%; min-width:75px" class="' . esc_attr($currentpackage->id . 'field[' . $i . ']') . '" placeholder="0.00" size="4" /></td>
		  <td><input type="number" step="any" min="0" value="' . esc_attr($rate['weightmax']) . '" name="' . esc_attr($currentpackage->id . '_tablerate[' . $i . '][weightmax]') . '" style="width: 90%; min-width:75px" class="' . esc_attr($currentpackage->id . 'field[' . $i . ']') . '" placeholder="0.00" size="4" /></td>
		</tr>';
          }
        }
        $methods = new Class_Colissimo_Shipping();
        $methodsData = $methods->get_methods();
        $options = '';
        foreach($methodsData as $key => $m) {
          $options.= '<option value="' . $key . '">' . $m . '</option>';
        }
        $shipClass = '';
        $shipclassArr = array();
        $shipclassArr['all'] = 'All';
        if (WC()->shipping->get_shipping_classes()) {
          foreach(WC()->shipping->get_shipping_classes() as $shipping_class) {
            $shipclassArr[$shipping_class->name] = $shipping_class->name;
          }
        }
        $shipClass = '';
        foreach($shipclassArr as $key => $m) {
          $shipClass.= '<option value="' . $key . '">' . $m . '</option>';
        }
?>
						</tbody>
					</table>


					<script type="text/javascript">
						jQuery(function() {
							jQuery('#<?php
        echo $currentpackage->id; ?>_table_rates').on( 'click', 'a.add', function(){
								var size = jQuery('#<?php
        echo $currentpackage->id; ?>_table_rates tbody .table_rate').size();
								var previous = size - 1;
								jQuery('<tr class="table_rate">\
									<th class="check-column"><input type="checkbox" name="select" /></th>\
									<td><input type="text" name="<?php
        echo $currentpackage->id; ?>_tablerate[' + size + '][method_name]" style="width: 90%; min-width:100px" class="<?php
        echo $currentpackage->id; ?>field[' + size + ']" placeholder="" size="4" /></td>\
									<td><input type="number" step="any" min="0" name="<?php
        echo $currentpackage->id; ?>_tablerate[' + size + '][fare]" style="width: 90%; min-width:75px" class="<?php
        echo $currentpackage->id; ?>field[' + size + ']" placeholder="0.00" size="4" /></td>\
									<td><input type="text" name="<?php
        echo $currentpackage->id; ?>_tablerate[' + size + '][addfees]" style="width: 90%" class="<?php
        echo $currentpackage->id; ?>field[' + size + ']" placeholder="" size="4" /></td>\
									<td><select multiple size="2" name="<?php
        echo $currentpackage->id; ?>_tablerate[' + size + '][class]"><?php
        echo $shipClass ?></select></td>\
                                    <td><select name="<?php
        echo $currentpackage->id; ?>_tablerate[' + size + '][methods]"><?php
        echo $options ?></select></td>\n\
                                    <td><input type="number" step="any" min="0" name="<?php
        echo $currentpackage->id; ?>_tablerate[' + size + '][pricemin]" style="width: 90%; min-width:75px" class="<?php
        echo $currentpackage->id; ?>field[' + size + ']" placeholder="0.00" size="4" /></td>\
									<td><input type="number" step="any" min="0" name="<?php
        echo $currentpackage->id; ?>_tablerate[' + size + '][pricemax]" style="width: 90%; min-width:75px" class="<?php
        echo $currentpackage->id; ?>field[' + size + ']" placeholder="0.00" size="4" /></td>\
									<td><input type="number" step="any" min="0" name="<?php
        echo $currentpackage->id; ?>_tablerate[' + size + '][weightmin]" style="width: 90%; min-width:75px" class="<?php
        echo $currentpackage->id; ?>field[' + size + ']" placeholder="0.00" size="4" /></td>\
									<td><input type="number" step="any" min="0" name="<?php
        echo $currentpackage->id; ?>_tablerate[' + size + '][weightmax]" style="width: 90%; min-width:75px" class="<?php
        echo $currentpackage->id; ?>field[' + size + ']" placeholder="0.00" size="4" /></td>\
								</tr>').appendTo('#<?php
        echo $currentpackage->id; ?>_table_rates table tbody');

								return false;
							});

							// Remove row
							jQuery('#<?php
        echo $currentpackage->id; ?>_table_rates').on( 'click', 'a.remove', function(){
								var answer = confirm("<?php
        _e('Delete the selected rates?', 'colissimo-delivery-integration'); ?>")
									if (answer) {
										jQuery('#<?php
        echo $currentpackage->id; ?>_table_rates table tbody tr th.check-column input:checked').each(function(i, el){
										jQuery(el).closest('tr').remove();
									});
								}
								return false;
							});
						});
					</script>
				</td>
			</tr>

		<?php
        return ob_get_clean();
      }
    }
  }

  function cdi_woocommerce_cart_shipping_method_full_label($label, $method){
    if ($method->method_id == 'colissimo_shippingzone_method') {
      $exploded = explode( ':', $method->id) ;
      $termid = str_replace('colissimo_shippingzone_method_', '', $exploded[0]) ;
      $iconid = $termid ;
      $iconmanaged = array ('home1', 'home2', 'home3', 'home4', 'home5', 'pick1', 'pick2', 'pick3', 'pick4', 'pick5', 'shop1', 'shop2', 'shop3', 'shop4', 'shop5') ;
      if (!in_array($iconid , $iconmanaged)) {
        $iconid = 'home1' ; ;
      }
      if ($termid) {
        $urlshippingicon = plugins_url( 'images/' . 'icon' . $iconid . '.png', dirname(__FILE__));
        $urlshippingicon =apply_filters( 'cdi_filterurl_shipping_icon', $urlshippingicon, $termid) ;
        $label = '<img src="' . $urlshippingicon . '"> ' . $label ;
      }
    }

    return $label ;
  }


?>
