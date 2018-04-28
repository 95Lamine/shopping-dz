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
/* Cdi Gateway in a tab panel added in the woocommerce sidebar                          */
/****************************************************************************************/
class WC_Gateway_Tab_Colissimo {
    /**
     * Bootstraps the class and hooks required actions & filters.
     *
     */
    public static function init() {
      add_action('admin_menu', __CLASS__ . '::register_colissimo_submenu_page');
      add_action('admin_init',  __CLASS__ . '::cdi_label_voir');
      add_action('admin_init',  __CLASS__ . '::cdi_cn23_voir');
      add_action('wp_ajax_cdi_ajax_gateway',  __CLASS__ . '::cdi_ajax_gateway');
      add_action('wp_ajax_nopriv_cdi_ajax_gateway',  __CLASS__ . '::cdi_ajax_gateway');
    }

    /**
     * Add a new Gateway tab to the WooCommerce sidebar.
     *
     */
    public static function register_colissimo_submenu_page() {
        add_submenu_page( 'woocommerce', 'Colissimo', 'Colissimo', 'cdi_gateway', 'Colissimo-page', __CLASS__ . '::colissimo_submenu_page_callback' ); 
    }

    /**
     * The Colissimo Gateway page here.
     *
     */
    public static function colissimo_submenu_page_callback() {
      global $wpdb;
      global $woocommerce;
      global $message;
      $returnmsg = WC_function_Colissimo::cdi_cdiplus_credential() ;
      if ($returnmsg) {
         $message = $returnmsg ;
      }
      wp_enqueue_script('jquery-ui-datepicker');
      wp_enqueue_style('jquery-ui-css', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css');

      self::cdi_journal_gateway_csv() ;
      self::cdi_init_date_history() ;
      self::cdi_parcels_history_csv() ;

?>
      <div class="wrap">
        <?php // screen_icon( 'themes' ); // deprecated now so dont use ?>
        <form method="post" id="test">
          <div style="display:inline-block;">
            <h3 style="display:inline-block;"><?php _e('Colissimo Delivery Integration - Shipping Gateway', 'colissimo-delivery-integration'); ?></h3>
            <a style="display:inline-block;"> <?php  WC_function_Colissimo::cdi_button_connected() ; ?></a>
            <a style="display:inline-block;"> <?php $return = WC_function_Colissimo::cdi_button_adhesioncdiplus() ; 
                                                    if ($return !== null) {
                                                      $message = $return ;
                                                    }
                                              ?></a>
            <a style="display:inline-block;"> <?php WC_function_Colissimo::cdi_button_informationcdi() ; ?></a>
          </div>
        </form>
        <h2><?php _e('Manage your Colissimo parcels', 'colissimo-delivery-integration'); ?></h2>
        <?php
          $results = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."cdi");
          echo " " . count($results) . ' ' . __(' parcel(s) in the gateway.', 'colissimo-delivery-integration') ;
        ?>
        <div id="poststuff">
          <div class="metabox-holder columns-2" id="post-body">
            <!-- ************************************************************************************************** -->
            <div id="post-body-content">
              <form method="post" action="?page=<?php echo esc_js(esc_html($_GET['page'])); ?>">

                 <?php self::cdi_parcels_remove() ; ?>

                 <?php self::cdi_parcels_register() ; ?>

                 <?php self::cdi_parcels_block() ; ?>

                 <?php self::cdi_parcels_release() ; ?>

                <?php if (isset($message)) { echo '<div style="padding: 5px;" class="updated"><p>'.$message.'</p></div>'; }?>

                <div id="outer" style="position: relative;">
                  <div id="inner" style="overflow: auto; max-height:50vh;">
                    <table cellspacing="0" class="wp-list-table widefat fixed orderscolissimo">
                      <thead> <?php self::cdi_headfoot_table() ; ?> </thead>
                      <tfoot> <?php self::cdi_headfoot_table() ; ?> </tfoot>
                      <tbody id="the-list"> <?php self::cdi_body_table() ; ?> </tbody>
                    </table>
                  </div>
                </div>
                <br class="clear">
                <p>
                  <em></em>    
                  <input name="cdi_register" type="submit" value="<?php _e('Register your changes', 'colissimo-delivery-integration'); ?>" style="float: left;" title="<?php _e('Save your package tracking code changes.', 'colissimo-delivery-integration'); ?>" />
                  <em></em> 
                  <input name="cdi_block" type="submit" value="<?php _e('Block parcels', 'colissimo-delivery-integration'); ?>" style="margin-left:30%;" title="<?php _e('Block parcels that you temporarily do not want to process in the Colissimo gateway.', 'colissimo-delivery-integration'); ?>" />
                  <input name="cdi_release" type="submit" value="<?php _e('Release parcels', 'colissimo-delivery-integration'); ?>" title="<?php _e('Release parcels that you now want to process in the Colissimo gateway.', 'colissimo-delivery-integration'); ?>" />
                  <input onclick="javascript:return confirm('<?php _e('Are you sure you want to delete ?', 'colissimo-delivery-integration'); ?>');" name="cdi_remove" type="submit" value="<?php _e('Remove parcels', 'colissimo-delivery-integration'); ?>" style="color:red; float: right;" title="<?php _e('Necessary when auto clean of Colissimo parcels has not been set in settings. Your Colissimo parcels can be remove at the end of a gateway session (i.e. after sending parcels to Colissimo, collecting the tracking codes, and copying them in the gateway). Afterward, a new list of Colissimo parcels can be prepared for a new gateway session.', 'colissimo-delivery-integration'); ?>" /> 
                  <em style="color:red; float: right;"></em>
                </p>
                <em></em>
                <p></p>
              </form>

              <?php if (WC_function_Colissimo::cdi_isconnected()) {?>
                <?php eval (WC_function_Colissimo::cdi_eval('7')) ;  ?>
                <br class="clear">
                <div style="margin:1px; padding:10px; background-color:#FFFFFF; width:97%;">
                <h2><?php _e('Bulk gateway process', 'colissimo-delivery-integration'); ?></h2>
                <p><?php _e('Here you can have a bulk process your Colissimo parcels : print labels in your gateway, print cn23 in your gateway, print of gateway shipping log. Blocked parcels will be ignored.', 'colissimo-delivery-integration'); ?></p>
                <div style="display:inline-block; padding:10px; background-color:#FFFFFF; width:97%;">
                    <form method="post" id="cdi_globalprint_label_pdf" action="" style="float:left; margin:1px;">
                      <input type="hidden" name="cdi_globalprint_label_pdf" value="cdi_globalprint_label_pdf">
                      <input type="submit" name="cdi_globalprint_label_pdf" value="<?php _e('Print gateway labels', 'colissimo-delivery-integration'); ?>"  title="Print all local labels" /> 
                      <?php wp_nonce_field( 'cdi_globalprint_label_pdf', 'cdi_globalprint_label_pdf_nonce');  ?> 
                    </form>
                    <form method="post" id="cdi_globalprint_cn23_pdf" action="" style="float:left; margin:1px;">
                      <input type="hidden" name="cdi_globalprint_cn23_pdf" value="cdi_globalprint_cn23_pdf">
                      <input type="submit" name="cdi_globalprint_cn23_pdf" value="<?php _e('Print gateway cn23', 'colissimo-delivery-integration'); ?>"  title="Print all local cn23" /> 
                      <?php wp_nonce_field( 'cdi_globalprint_cn23_pdf', 'cdi_globalprint_cn23_pdf_nonce');  ?> 
                    </form>
                    <form method="post" id="cdi_journal_gateway_csv" action="" style="float:left; margin:1px;">
                      <input type="hidden" name="cdi_journal_gateway_csv" value="cdi_journal_gateway_csv">
                      <input type="submit" name="cdi_journal_gateway_csv" value="<?php _e('Export gateway log', 'colissimo-delivery-integration'); ?>"  title="Print all local gwlog" /> 
                      <?php wp_nonce_field( 'cdi_journal_gateway_csv', 'cdi_journal_gateway_csv_nonce');  ?> 
                    </form>
                </div>
                <br class="clear">
                </div>
                <?php eval (WC_function_Colissimo::cdi_eval('12')) ; ?>
              <?php }?>
              <?php if (WC_function_Colissimo::cdi_isconnected()) {?>
                <?php eval (WC_function_Colissimo::cdi_eval('7')) ; ?>
                <br class="clear">
                <div style="margin:1px; padding:10px; background-color:#FFFFFF; width:97%;">
                <h2><?php _e('Delivery history', 'colissimo-delivery-integration'); ?></h2>
                <p><?php _e('Here you can export the log of your parcels already processed. Parcels in gateway will be ignored.', 'colissimo-delivery-integration'); ?></p>
                <p><?php _e('The date selector will limit the selection to the last 50 parcels of a range of up to 30 days. By default, the parcels of the last 10 days are presented.', 'colissimo-delivery-integration'); ?></p>
                <div style="display:inline-block; padding:10px; background-color:#FFFFFF; width:97%;">
                    <form method="post" id="cdi_parcels_history_csv" action="" style="float:left; margin:1px;">
                      <div id="dates">
                        <label for="fromdate">Colis du </label>
                        <input type="text" class="custom_date" name="fromdate" style="width:25%" value="<?php echo $_SESSION['cdifromdate']; ?>"/>
                        <lablel for="todate">au </label>
                        <input type="text" class="custom_date" name="todate" style="width:25%" value="<?php echo $_SESSION['cditodate']; ?>"/>
                        <lablel for="search"> ==> </label>
                        <input type="submit" name="cdi_parcels_history_csv" value="<?php _e('Export parcels log', 'colissimo-delivery-integration'); ?>"  title="Print parcels log" /> 
                        <?php wp_nonce_field( 'cdi_parcels_history_csv', 'cdi_parcels_history_csv_nonce');  ?> 
                      </div>
                    </form>
                </div>
                <br class="clear">
                </div>
                <?php eval (WC_function_Colissimo::cdi_eval('12')) ; ?>
              <?php }?>


              <!-- ************************************************************************************************** -->
              <div class="meta-box-sortables">
              </div>
            </div>
            <!-- ************************************************************************************************** -->
            <div class="postbox-container" id="postbox-container-1">
              <!-- ************************************************************************************************** -->
              <div class="meta-box-sortables">
                <div class="postbox">
                  <h3><span><?php _e('Submit your parcels at your choice :', 'colissimo-delivery-integration'); ?></span></h3>

                  <div class="inside">
                    <form method="post" id="cdi_gateway_manual" action="">
                      <input type="submit" name="cdi_gateway_manual" value="<?php _e('Manual', 'colissimo-delivery-integration'); ?>" /> 
                      <img class="help_tip" title="<?php _e('A csv file will be exported. It can be printed to manage parcels to send to a La Poste branch. It can be used to activate an browser automation  script for the Colissimo online website (or another carrier). It can be use as input for a carrier software. The parcel tracking codes will then have to be manually entered into the gateway panel.', 'colissimo-delivery-integration'); ?>" src="<?php echo WC()->plugin_url(); ?>/assets/images/help.png" height="16" width="16" />
                      <?php wp_nonce_field( 'cdi_manual_run', 'cdi_manual_run_nonce');  ?> 
                    </form>
                    <p><em><?php _e('Export a csv file.', 'colissimo-delivery-integration'); ?></em></p>
                  </div>

                  <div class="inside">
                    <form method="post" id="cdi_gateway_online" action="">
                      <input type="submit" name="cdi_gateway_online" value="<?php _e('Online', 'colissimo-delivery-integration'); ?>" /> 
                      <img class="help_tip" title="<?php _e('An iMacros script will be exported. It can be run in your browser connected at the Colissimo online website. You must be registered and logged in the Colissimo online service, and you must have registered a defaut expeditor. After printing of Colissimo labels, the parcels tracking codes will then have to be manually entered into the gateway panel. It is recommanded to have no more than 5 parcels in a script.', 'colissimo-delivery-integration'); ?>"  src="<?php echo WC()->plugin_url(); ?>/assets/images/help.png" height="16" width="16" />
                      <a style="color:red"> Mode en obsolescence !</a>
                      <?php wp_nonce_field( 'cdi_online_run', 'cdi_online_run_nonce');  ?> 
                    </form>
                    <p><em><?php _e('Export an iMacros script to be run with "Colissimo en ligne".', 'colissimo-delivery-integration'); ?></em></p>
                  </div>

                  <div class="inside">
                    <form method="post" id="cdi_gateway_coliship" action="">
                      <input type="submit" name="cdi_gateway_coliship" value="<?php _e('Coliship', 'colissimo-delivery-integration'); ?>" /> 
                      <img class="help_tip" title="<?php _e('An iMacros script for Coliship will be exported. It can be run in your browser connected at the Coliship website. You must be registered and logged in Coliship service. After printing of Colissimo labels, the parcels tracking codes will then have to be manually entered into the gateway panel. It is recommanded to have no more than 5 parcels in a script.', 'colissimo-delivery-integration'); ?>"  src="<?php echo WC()->plugin_url(); ?>/assets/images/help.png" height="16" width="16" />
                      <a style="color:red"> Mode en obsolescence !</a>
                      <?php wp_nonce_field( 'cdi_coliship_run', 'cdi_coliship_run_nonce');  ?> 
                    </form>
                    <p><em><?php _e('Run the "Coliship" service.', 'colissimo-delivery-integration'); ?></em></p>
                  </div>

                  <div class="inside">
                    <form method="post" id="cdi_gateway_auto" action="">
                      <input type="submit" name="cdi_gateway_auto" value="<?php _e('Automatic', 'colissimo-delivery-integration'); ?>" /> 
                      <img class="help_tip" title="<?php _e('The service will be executed in line with Colissimo Web service under soap protocol. A business contract with La Poste is needed. After printing of Colissimo labels, the parcel tracking codes will be automatically inserted into the gateway panel.', 'colissimo-delivery-integration'); ?>" src="<?php echo WC()->plugin_url(); ?>/assets/images/help.png" height="16" width="16" />
                      <?php wp_nonce_field( 'cdi_auto_run', 'cdi_auto_run_nonce');  ?> 
                    </form>
                    <p><em><?php _e('Run the "Web Service d’Affranchissement Colissimo".', 'colissimo-delivery-integration'); ?></em></p>
                  </div>

                  <div class="inside">
                    <form method="post" id="cdi_gateway_custom" action="">
                      <input type="submit" name="cdi_gateway_custom" value="<?php _e('Custom', 'colissimo-delivery-integration'); ?>" /> 
                      <img class="help_tip" title="<?php _e('A custom service will be executed. The filter $cdi_tracking = apply_filters (\'cdi_custom_gateway_exec\', $cdi_tracking=false , $cdi_nbrorderstodo , $cdi_rowcurrentorder, $array_for_carrier) is used. $array_for_carrier contains the datas to process with your software carrier. The parcel tracking code is returned in $cdi_tracking and will be automatically updated into the gateway panel. $cdi_nbrorderstodo and $cdi_rowcurrentorder are respectively the number of orders to process and the rank of the current order in process.', 'colissimo-delivery-integration'); ?>"  src="<?php echo WC()->plugin_url(); ?>/assets/images/help.png" height="16" width="16" />
                      <?php wp_nonce_field( 'cdi_custom_run', 'cdi_custom_run_nonce');  ?> 
                    </form>
                    <p><em><?php _e('Run your custom computer program through a filter.', 'colissimo-delivery-integration'); ?></em></p>
                  </div>

                  <div class="inside">
                    <form method="post" id="cdi_gateway_printlabel" target="_blank" action="">
                      <input type="submit" name="cdi_gateway_printlabel" value="<?php _e('Addresses printing', 'colissimo-delivery-integration'); ?>" /> 
                      <img class="help_tip" title="<?php _e('A pdf file with address labels will be exported. It can be printed for parcels or letters to send throught the carrier chosen. The parcel tracking codes will have to be manually entered into the gateway panel.', 'colissimo-delivery-integration'); ?>" src="<?php echo WC()->plugin_url(); ?>/assets/images/help.png" height="16" width="16" />
                      <?php wp_nonce_field( 'cdi_printlabel_run', 'cdi_printlabel_run_nonce');  ?> 
                    </form>
                    <p><em><?php _e('Print address labels.', 'colissimo-delivery-integration'); ?></em></p>
                  </div>

                </div>
              </div>
              <!-- ************************************************************************************************** -->
            </div>
            <!-- ************************************************************************************************** -->
          </div>
          <br class="clear">
        </div>
      </div>
      <?php
    }

    /**
     * Parcels blocking
     *
     */
    public static function cdi_parcels_block() {
      global $wpdb;
      global $woocommerce;
      global $message;
      if ($_SERVER['REQUEST_METHOD'] == "POST" and ISSET($_POST['cdi_block'])) {
        if (ISSET($_GET['rem'])) $_POST['rem'][] = $_GET['rem'];
        $count = 0;
        if (isset($_POST['rem']) && is_array($_POST['rem'])) {
          foreach ($_POST['rem'] as $id ) {
            $results = $wpdb->update($wpdb->prefix . "cdi", array('cdi_status' => 'close'), array( 'ID' => $id ) );
            $count++;
          }
        }
        $message = $count . __(' parcel(s) have been freezed.', 'colissimo-delivery-integration') ;
      }
    }
    /**
     * Parcels release
     *
     */
    public static function cdi_parcels_release() {
      global $wpdb;
      global $woocommerce;
      global $message;
      if ($_SERVER['REQUEST_METHOD'] == "POST" and ISSET($_POST['cdi_release'])) {
        if (ISSET($_GET['rem'])) $_POST['rem'][] = $_GET['rem'];
        $count = 0;
        if (isset($_POST['rem']) && is_array($_POST['rem'])) {
          foreach ($_POST['rem'] as $id ) {
            $results = $wpdb->update($wpdb->prefix . "cdi", array('cdi_status' => 'open'), array( 'ID' => $id ) );
            $count++;
          }
        }
        $message = $count . __(' parcel(s) have been unfreezed.', 'colissimo-delivery-integration') ;
      }
    }
    /**
     * Parcels register
     *
     */
    public static function cdi_parcels_register() {
      global $wpdb;
      global $woocommerce;
      global $message;
      if ($_SERVER['REQUEST_METHOD'] == "POST" and ISSET($_POST['cdi_register'])) {
        if (ISSET($_GET['parcelrow'])) $_POST['parcelrow'][] = $_GET['parcelrow'];
        $count = 0;
        if (isset($_POST['parcelrow']) && is_array($_POST['parcelrow'])) {
          foreach ($_POST['parcelrow'] as $id =>$track) {
            $results = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "cdi where id like '" . esc_sql($id) . "' ");
            if (count($results)) {
              if ($results[0]->cdi_tracking !== $track){
                $x = $wpdb->update($wpdb->prefix . "cdi", array('cdi_tracking' => $track), array( 'ID' => $id ) );
                $count++;
              }
            }
          }
          $message = $count . __(' tracking code(s) have been changed.', 'colissimo-delivery-integration') ;
        }
      }
    }
    /**
     * Parcels remove
     *
     */
    public static function cdi_parcels_remove() {
      global $wpdb;
      global $woocommerce;
      global $message;
      if ($_SERVER['REQUEST_METHOD'] == "POST" and ISSET($_POST['cdi_remove'])) {
        if (ISSET($_GET['rem'])) $_POST['rem'][] = $_GET['rem'];
        $count = 0;
        if (isset($_POST['rem']) && is_array($_POST['rem'])) {
          foreach ($_POST['rem'] as $id) {
            $wpdb->query("delete from " . $wpdb->prefix . "cdi where id = '" . esc_sql($id) . "' limit 1");
            $count++;
          }
          $message = $count . __(' parcels have been removed successfully.', 'colissimo-delivery-integration') ;
        }
      }
    }
    /**
     * Parcels history
     *
     */
    public static function cdi_parcels_history_csv() {
      global $wpdb;
      global $woocommerce;
      global $message;
      if (isset ($_POST['cdi_parcels_history_csv'])){
        if (isset ($_POST['fromdate']) or isset ($_POST['todate'])) {
          $fromdatex = $_POST['fromdate'];
          $fromdatex = str_replace('-', '', $fromdatex) ;
          $todatex = $_POST['todate'];
          $todatex = str_replace('-', '', $todatex) ;
          $datetime1 = new DateTime($fromdatex);
          $datetime2 = new DateTime($todatex);
          $difference = $datetime1->diff($datetime2);
          if ( ($difference->invert == 0) && ($difference->days < 30)) {
            $_SESSION['cdifromdate'] = $_POST['fromdate'];
            $_SESSION['cditodate'] = $_POST['todate'];
            $customer_orders = get_posts( array(
              'numberposts' => 50,
              'orderby'     => 'date',
              'order'       => 'DESC',
              'post_type'   => wc_get_order_types(),
              'post_status' => array_keys( wc_get_order_statuses() ),
              'meta_key'    => '_cdi_meta_status',
            	'meta_value'  => 'intruck',
              'date_query' => array(
                  'after' => $_SESSION['cdifromdate'],
                  'before' => $_SESSION['cditodate'] 
                  )
              ) );
            $listeorderid = array();
            foreach ( $customer_orders as $customer_order ) {
              $order = wc_get_order( $customer_order );
              $listeorderid[] = $order->get_id();
            }
            $cdi_nbrorderstodo = count($listeorderid) ;
            if ($cdi_nbrorderstodo) {
              $csv = array() ;
              $csv['filename'] = 'Cdi-histo-parcels-' . date('YmdHis') . '.csv' ;
              $stringtitle = '||' . ',' .
                       'Colis id' . ',' .
                       'Date commande' . ',' .
                       'Entreprise' . ',' .
                       'Prénom' . ',' .
                       'Nom' . ',' .
                       'Ville' . ',' .
                       'Pays dest.' . ',' .
                       'Etat' . ',' .
                       'Email' . ',' .
                       'Téléphone' . ',' .
                       '||' . ',' .
                       'Code produit' . ',' .
                       'Poids (g)' . ',' .
                       'Assurance' . ',' .
                       'Avis récept.' . ',' .
                       'FTD' . ',' .
                       'Type colis' . ',' .
                       '||' . ',' .
                       'Type retour' . ',' .
                       'Point retrait' . ',' .
                       '||' . ',' .
                       'Code suivi' . ',' .
                       'Suivi internat.' . ',' .
                       'Etiquette' . ',' .
                       'Cn23' . ',' .
                       '||' . ',' .
                       'Situation suivi colis' . ',' .
                       '||' . ',' .

                       "\r\n";
              $content = $stringtitle ;
              foreach ($listeorderid as $orderid) {
                  $cdi_tracking = get_post_meta($orderid, '_cdi_meta_tracking', true);
                  $cdi_parcelNumberPartner =  get_post_meta($orderid, '_cdi_meta_parcelNumberPartner', true); 
                  $array_for_carrier = WC_function_Colissimo::cdi_array_for_carrier( $orderid ) ;
                  WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $orderid);
                  $situationcolis = WC_function_Colissimo::cdi_get_inovert($orderid, $cdi_tracking) ;
                  $stringrow = '||' . ',' .
                         $orderid . ',' .
                         substr($array_for_carrier['order_date'],0,10) . ',' .
                         $array_for_carrier['shipping_company'] . ',' .
                         $array_for_carrier['shipping_first_name'] . ',' .
                         $array_for_carrier['shipping_last_name'] . ',' .
                         $array_for_carrier['shipping_city'] . ',' .
                         $array_for_carrier['shipping_country'] . ',' .
                         $array_for_carrier['shipping_state'] . ',' .
                         $array_for_carrier['billing_email'] . ',' .
                         $array_for_carrier['billing_phone'] . ',' .
                         '||' . ',' .
                         $array_for_carrier['product_code'] . ',' .
                         $array_for_carrier['parcel_weight'] . ',' .
                         $array_for_carrier['compensation_amount'] . ',' .
                         get_post_meta($orderid, '_cdi_meta_returnReceipt', true) . ',' .
                         get_post_meta($orderid, '_cdi_meta_ftd', true) . ',' .
                         $array_for_carrier['parcel_type'] . ',' .
                         '||' . ',' .
                         $array_for_carrier['return_type'] . ',' .
                         get_post_meta($orderid, '_cdi_meta_pickupLocationId', true) . ',' .
                         '||' . ',' .
                         $cdi_tracking . ',' .
                         $cdi_parcelNumberPartner . ',' .
                         get_post_meta($orderid, '_cdi_meta_exist_uploads_label', true) . ',' .
                         get_post_meta($orderid, '_cdi_meta_exist_uploads_cn23', true) . ',' .
                         '||' . ',' .
                         $situationcolis . ',' .
                         '||' . ',' .
                         "\r\n";
                  $content = $content . $stringrow ;
              } // End row array
              $csv['content'] = $content ;
              update_option( 'wc_settings_tab_colissimo_generalsendcsv', $csv);
              $sendback = admin_url() . 'admin.php?page=Colissimo-page' ; 
              wp_redirect($sendback); 
            } // End count
          }else{
            $message = 'CDI - erreur de dates pour la sélection de vos commandes (historique colis maximum de 30 jours).' ; 
          }
        }
      }
      ?><script type="text/javascript">
          jQuery(document).ready(function($) {
            $('.custom_date').datepicker({
              dateFormat : 'yy-mm-dd'
            });
          });
      </script><?php
    }
    /**
     * Init date history
     *
     */
    public static function cdi_init_date_history() {
      if (!isset($_SESSION['cdifromdate']) or !isset($_SESSION['cditodate'])) {
        $_SESSION['cditodate'] = date("Y-m-d") ;
        $_SESSION['cdifromdate'] = date('Y-m-d', strtotime("-10 days")) ;
      }
    }
    /**
     * Journal Gateway.
     *
     */
    public static function cdi_journal_gateway_csv() {
      global $wpdb;
      global $woocommerce;
      if ( isset($_POST['cdi_journal_gateway_csv']) && isset( $_POST['cdi_journal_gateway_csv_nonce'] ) && wp_verify_nonce( $_POST['cdi_journal_gateway_csv_nonce'], 'cdi_journal_gateway_csv' ) && WC_function_Colissimo::cdi_isconnected()) {
        if (current_user_can('cdi_gateway')) {
          eval (WC_function_Colissimo::cdi_eval('8')) ;
          if (count($results)) {
            $cdi_nbrorderstodo = 0 ;
            $cdi_rowcurrentorder = 0 ;
            foreach ($results as $row) {
              if ($row->cdi_status == 'open' or null == $row->cdi_status) {
                $cdi_nbrorderstodo = $cdi_nbrorderstodo +1 ; 
              }
            }
            if ( $cdi_nbrorderstodo > 0) {
              $csv = array() ;
              $csv['filename'] = 'Cdi-journal-gateway-' . date('YmdHis') . '.csv' ;
              $stringtitle = '||' . ',' .
                       'Colis id' . ',' .
                       'Date commande' . ',' .
                       'Entreprise' . ',' .
                       'Prénom' . ',' .
                       'Nom' . ',' .
                       'Ville' . ',' .
                       'Pays dest.' . ',' .
                       'Etat' . ',' .
                       'Email' . ',' .
                       'Téléphone' . ',' .
                       '||' . ',' .
                       'Code produit' . ',' .
                       'Poids (g)' . ',' .
                       'Assurance' . ',' .
                       'Avis récept.' . ',' .
                       'FTD' . ',' .
                       'Type colis' . ',' .
                       '||' . ',' .
                       'Type retour' . ',' .
                       'Point retrait' . ',' .
                       '||' . ',' .
                       'Code suivi' . ',' .
                       'Suivi internat.' . ',' .
                       'Etiquette' . ',' .
                       'Cn23' . ',' .
                       '||' . ',' .
                       "\r\n";
              $content = $stringtitle ;
              foreach ($results as $row) {
                $cdi_tracking = $row->cdi_tracking;
                if ($row->cdi_status == 'open' or null == $row->cdi_status) {
                  $cdi_rowcurrentorder = $cdi_rowcurrentorder+1 ;
                  $array_for_carrier = WC_function_Colissimo::cdi_array_for_carrier( $row ) ;
                  WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $array_for_carrier['order_id']);
                  $stringrow = '||' . ',' .
                         $array_for_carrier['order_id'] . ',' .
                         substr($array_for_carrier['order_date'],0,10) . ',' .
                         $array_for_carrier['shipping_company'] . ',' .
                         $array_for_carrier['shipping_first_name'] . ',' .
                         $array_for_carrier['shipping_last_name'] . ',' .
                         $array_for_carrier['shipping_city'] . ',' .
                         $array_for_carrier['shipping_country'] . ',' .
                         $array_for_carrier['shipping_state'] . ',' .
                         $array_for_carrier['billing_email'] . ',' .
                         $array_for_carrier['billing_phone'] . ',' .
                         '||' . ',' .
                         $array_for_carrier['product_code'] . ',' .
                         $array_for_carrier['parcel_weight'] . ',' .
                         $array_for_carrier['compensation_amount'] . ',' .
                         get_post_meta($array_for_carrier['order_id'], '_cdi_meta_returnReceipt', true) . ',' .
                         get_post_meta($array_for_carrier['order_id'], '_cdi_meta_ftd', true) . ',' .
                         $array_for_carrier['parcel_type'] . ',' .
                         '||' . ',' .
                         $array_for_carrier['return_type'] . ',' .
                         get_post_meta($array_for_carrier['order_id'], '_cdi_meta_pickupLocationId', true) . ',' .
                         '||' . ',' .
                         $row->cdi_tracking . ',' .
                         $row->cdi_parcelNumberPartner . ',' .
                         get_post_meta($array_for_carrier['order_id'], '_cdi_meta_exist_uploads_label', true) . ',' .
                         get_post_meta($array_for_carrier['order_id'], '_cdi_meta_exist_uploads_cn23', true) . ',' .
                         '||' . ',' .
                         "\r\n";
                  $content = $content . $stringrow ;
                } // End !$cdi_tracking
              } // End row
              $csv['content'] = $content ;
              update_option( 'wc_settings_tab_colissimo_generalsendcsv', $csv);
              $sendback = admin_url() . 'admin.php?page=Colissimo-page' ; 
              wp_redirect($sendback); 
            }
          } // End $results
        } // End current_user_can
      } // End $_POST['cdi_journal_gateway_csv'
    }
    /**
     * Head and Foot.
     *
     */
    public static function cdi_headfoot_table() {
      if (WC_function_Colissimo::cdi_isconnected()) {
        eval (WC_function_Colissimo::cdi_eval('7')) ;
        ?>
          <tr>
            <th class="manage-column column-cb check-column" id="cb" scope="col" style=""><input type="checkbox"></th>
            <th class="manage-column column-orderid" id="cdi-order-id" scope="col" style="width:8%;"><?php _e('Parcel', 'colissimo-delivery-integration'); ?><span class="sorting-indicator"></span></th>
            <th class="manage-column column-preview" id="cdi-order-order" scope="col" style="width:8%;"><?php _e('Order', 'colissimo-delivery-integration'); ?><span class="sorting-indicator"></span></th>
            <th class="manage-column column-name" id="cdi-name" scope="col" style="width:20%;"><span><?php _e('Destination', 'colissimo-delivery-integration'); ?></span><span class="sorting-indicator"></span></th>
            <th class="manage-column column-address" id="cdi-address" scope="col" style="width:8%;"><span><?php _e('Address', 'colissimo-delivery-integration'); ?></span><span class="sorting-indicator"></span></th>
            <th class="manage-column column-trackingcode" id="cdi-tracking" scope="col" style=""><span><?php _e('Tracking code', 'colissimo-delivery-integration'); ?></span><span class="sorting-indicator"></span></th>
            <th class="manage-column column-label" id="cdi-label" scope="col" style="width:8%;"><span>Etiquette</span><span class="sorting-indicator"></span></th>
            <th class="manage-column column-cn23" id="cdi-cn23" scope="col" style="width:8%;"><span>Cn23</span><span class="sorting-indicator"></span></th>
          </tr>
        <?php
        eval (WC_function_Colissimo::cdi_eval('12')) ;
      }else{
        ?>
          <tr>
            <th class="manage-column column-cb check-column" id="cb" scope="col" style=""><input type="checkbox"></th>
            <th class="manage-column column-orderid" id="cdi-order-id" scope="col" style="width:8%;"><?php _e('Parcel', 'colissimo-delivery-integration'); ?><span class="sorting-indicator"></span></th>
            <th class="manage-column column-name" id="cdi-name" scope="col" style="width:40%;"><span><?php _e('Destination', 'colissimo-delivery-integration'); ?></span><span class="sorting-indicator"></span></th>
            <th class="manage-column column-trackingcode" id="cdi-tracking" scope="col" style=""><span><?php _e('Tracking code', 'colissimo-delivery-integration'); ?></span><span class="sorting-indicator"></span></th>
            <th class="manage-column column-hreflabel" id="cdi-hreflabel" scope="col" style=""><span><?php _e('Url Labels', 'colissimo-delivery-integration'); ?></span><span class="sorting-indicator"></span></th>
          </tr>
        <?php
       }
    }
    /**
     * Body of table
     *
     */
    public static function cdi_body_table() {
      global $wpdb;
      global $woocommerce;
      global $message;
      $results = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "cdi");
      function cmp($a, $b) { return strcmp($b->cdi_order_id, $a->cdi_order_id); }
      usort($results, "cmp");
      if (count($results) < 1)
        echo '<tr class="no-items"><td colspan="3" class="colspanchange">' . __('No parcel have been registered in the gateway.', 'colissimo-delivery-integration') . '</td></tr>';
      else {
        $results = apply_filters( 'cdi_filterarray_gateway_sortresults', $results) ;
        $arrhtmljs = array() ;
        $arrhtmlshipadjs = array() ;
        $ajaxurl = admin_url('admin-ajax.php');
        foreach ($results as $row) {
          if ($row->cdi_status == 'close') {
            $color = '#aaaaaa' ;
          }else{
            $color = '#ffffff' ;
          }
          if (wc_get_order($row->cdi_order_id) != false) { // check if order exist
            $array_for_carrier = WC_function_Colissimo::cdi_array_for_carrier($row->cdi_order_id) ;
            $display =  $array_for_carrier['shipping_last_name'] . ' ' . $array_for_carrier['shipping_first_name'] . ' (' . $array_for_carrier['shipping_country'] . ') | ' .
                   "Weight: " . $array_for_carrier['parcel_weight'] . 'g | ' .
                   ' ' . 'shipping_company: ' . $array_for_carrier['shipping_company'] . ' | ' .
                   ' ' . 'shipping_address_1: ' . $array_for_carrier['shipping_address_1'] . ' | ' .
                   ' ' . 'shipping_address_2: ' . $array_for_carrier['shipping_address_2'] . ' | ' .
                   ' ' . 'shipping_postcode: ' . $array_for_carrier['shipping_postcode'] . ' | ' .
                   ' ' . 'shipping_city_state: ' . $array_for_carrier['shipping_city_state'] . ' | ' .
                   ' ' . 'billing_phone: ' . $array_for_carrier['billing_phone'] . ' | ' .
                   ' ' . 'billing_email: ' . $array_for_carrier['billing_email'] . ' | ' .
                   ' ' . 'cdi_meta_typeparcel: ' . $array_for_carrier['parcel_type'] . ' | ' .
                   ' ' . 'cdi_meta_signature: ' . $array_for_carrier['signature'] . ' | ' .
                   ' ' . 'cdi_meta_additionalcompensation: ' . $array_for_carrier['additional_compensation'] . ' | ' .
                   ' ' . 'cdi_meta_amountcompensation: ' . $array_for_carrier['compensation_amount'] . ' | ' .
                   ' ' . 'cdi_meta_typereturn: ' . $array_for_carrier['return_type'] . ' | ' .
                   ' ' . 'cdi_meta_productCode: ' . $array_for_carrier['product_code'] . ' | ' .
                   ' ' . 'cdi_meta_pickupLocationId: ' . $array_for_carrier['pickup_Location_id'] . ' | ' .
                   ' ' ;
            $displayorder = $array_for_carrier['shipping_last_name'] . ' ' . $array_for_carrier['shipping_first_name'] . ' (' . $array_for_carrier['shipping_country'] . ') '. $array_for_carrier['parcel_weight'] . 'g '  . substr($array_for_carrier['order_date'],0,10) ;
            $displayorder = apply_filters( 'cdi_filterstring_gateway_displayorder', $displayorder, $array_for_carrier) ;
            if (WC_function_Colissimo::cdi_isconnected()) {
              eval (WC_function_Colissimo::cdi_eval('7')) ;
              if ($row->cdi_order_id && get_post_meta($row->cdi_order_id, '_cdi_meta_exist_uploads_label', true) == true) {
                $tdlabel = '<td style="overflow:hidden; white-space:nowrap; text-overflow: ellipsis;"><form method="post" id="cdi_label_voir" action="" style="display:inline-block;"><input type="hidden" name="cdi_label_voir_post" value="' . $row->cdi_order_id . '"><input type="submit" name="cdi_label_voir" value="Voir"  title="Print label" /></form></td>' ;
              }else{
                $tdlabel = '<td></td>' ;
              }
              if ($row->cdi_order_id && get_post_meta($row->cdi_order_id, '_cdi_meta_exist_uploads_cn23', true) == true) {
                $tdcn23 = '<td style="overflow:hidden; white-space:nowrap; text-overflow: ellipsis;"><form method="post" id="cdi_cn23_voir" action="" style="display:inline-block;"><input type="hidden" name="cdi_cn23_voir_post" value="' . $row->cdi_order_id . '"><input type="submit" name="cdi_cn23_voir" value="Voir"  title="Print cn23" /></form></td>' ;
              }else{
                $tdcn23 = '<td></td>' ;
              }

              eval (WC_function_Colissimo::cdi_eval('17')) ;
              $imgmetabox = '<img src="' . plugins_url( 'images/iconmetabox.png', dirname(__FILE__)) . '">' ;
              $imgorder = '<img src="' . plugins_url( 'images/iconorder.png', dirname(__FILE__)) . '">' ;
              $imgcheck = '<img src="' . plugins_url( 'images/iconcheckad.png', dirname(__FILE__)) . '">' ;
              echo '<tr style="background-color:' . $color . ';"> 
                <th class="check-column" style="padding:5px 0 2px 0"><input type="checkbox" name="rem[]" value="' . esc_js(esc_html($row->id)) . '"></th>
                <td><a class="cdi-preview-metabox" name="cdi_preview_metabox' .  $row->cdi_order_id . '" title="Preview the CDI Metabox" > ' . $imgmetabox . esc_js(esc_html($row->cdi_order_id)) . ' </a></td>
                <td><a class="cdi-preview-order" name="cdi_preview_' .  $row->cdi_order_id . '" title="Preview this order" > ' . $imgorder . ' </a></td>
                <td>' . $displayorder . ' </td>
                <td><a class="cdi-checkad" name="cdi_checkad_' .  $row->cdi_order_id . '" title="Check the shipping address of this order" > ' . $imgcheck . ' </a></td>
                <td><input name="parcelrow[' . esc_js(esc_html($row->id)) . ']" style="width:95%" value="' . esc_js(esc_html($row->cdi_tracking)) . '"/> </td>
               ' .  $tdlabel . '
               ' .  $tdcn23 . '
                </tr>';
              eval (WC_function_Colissimo::cdi_eval('12')) ; 
            }else{
              echo '<tr style="background-color:' . $color . ';"> 
                <th class="check-column" style="padding:5px 0 2px 0"><input type="checkbox" name="rem[]" value="' . esc_js(esc_html($row->id)) . '"></th>
                <td><a title="' . $display . '" />' . esc_js(esc_html($row->cdi_order_id)) . '</a></td>
                <td>' . $displayorder . ' </td>
                <td><input name="parcelrow[' . esc_js(esc_html($row->id)) . ']" style="width:95%" value="' . esc_js(esc_html($row->cdi_tracking)) . '"/> </td>
                <td><a style="vertical-align: middle; display:inline-block; color:black; width:12em; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;" onmouseover="this.style.color=\'red\';" onmouseout="this.style.color=\'\';" href="' . esc_js(esc_html($row->cdi_hreflabel)) .'" onclick="window.open(this.href); return false;">' . esc_js(esc_html($row->cdi_hreflabel)) . '</a></td>
                </tr>';
            }
          }else{ // order does not exist so clean the gateway
            $wpdb->query("delete from " . $wpdb->prefix . "cdi where cdi_order_id = '" . $row->cdi_order_id . "' limit 1");
          } // end test order exist
        } // end foreach
        if (WC_function_Colissimo::cdi_isconnected()) {
          eval (WC_function_Colissimo::cdi_eval('16')) ;
        }
      }
    }

    /**
     * Process of Ajax requests from Gateway.
     *
     */
    public static function cdi_ajax_gateway() { 
      global $woocommerce;
      $endpoint = 'https://api.laposte.fr/controladresse/v1/adresses';
      if ($_SERVER['REQUEST_METHOD'] == "POST" and ISSET($_POST['case'])) {
        $case = $_POST['case'] ;
        switch($case) {
          case '1' : 
            $reponse = '<br><br>' ;
            if ($_POST['address']['pa'] !== 'France') {
              $reponse .= "<strong>Erreur : </strong>Vérification non disponible pour cette destination.<br>" ;      
            }
            if (null == get_option('wc_settings_tab_colissimo_apikeylaposte')) {
              $reponse .= "<strong>Erreur : </strong>Service nécessitant une clé API de La Poste.<br>" ;      
            }
            if (strlen($reponse) > 8) {
              $response = json_encode(array('0' => 'nok', '1' => $reponse )) ;
              echo ($response) ;
              wp_die();
            }
            $rawaddress = $_POST['address']['l1'] . ' ' .
                          $_POST['address']['l2'] . ' ' .
                          $_POST['address']['l3'] . ' ' .
                          $_POST['address']['l4'] . ' ' . 
                          $_POST['address']['cp'] . ' ' . 
                          $_POST['address']['vi']  ;
            $request  = "q=" . $rawaddress ;
            $headers  = array('X-Okapi-Key' => get_option('wc_settings_tab_colissimo_apikeylaposte') , 'Content-Type' => 'application/json', 'Accept' => 'application/json');
            $responseapi = wp_remote_get( $endpoint . '?' . $request, array( 'timeout' => 70, 'headers' => $headers, ) );
            $responseapi_code = $responseapi['response']['code'];
            $responseapi_message = $responseapi['response']['message'];
            if ($responseapi_message !== 'OK') {
              $response = json_encode(array('0' => 'nok', '1' => "<strong>Erreur API : </strong>" . $responseapi['response']['message'] . '<br>' )) ;
              echo ($response) ;
              wp_die();
            }
            $response = json_encode(array('0' => 'ok', '1' => $responseapi['body'] )) ;
            echo ($response) ;
            wp_die();
            break;
          case '2' : 
            $request  = $_POST['code'] ;
            $headers  = array('X-Okapi-Key' => get_option('wc_settings_tab_colissimo_apikeylaposte') , 'Content-Type' => 'application/json', 'Accept' => 'application/json');
            $responseapi = wp_remote_get( $endpoint . '/' . $request, array( 'timeout' => 70, 'headers' => $headers, ) );
            $responseapi_code = $responseapi['response']['code'];
            $responseapi_message = $responseapi['response']['message'];
            if ($responseapi_message !== 'OK') {
              $response = json_encode(array('0' => 'nok', '1' => "<strong>Erreur API : </strong>" . $responseapi['response']['message'] . '<br>' )) ;
              echo ($response) ;
              wp_die();
            }
            $objaddress = json_decode( $responseapi['body'] );

            $newadrstructure = array() ;
            $newadrstructure['l1'] = $objaddress->numeroVoie . ' ' . $objaddress->libelleVoie ;
            $newadrstructure['l2'] = $objaddress->pointRemise ;
            $newadrstructure['l3'] = $objaddress->destinataire ;
            $newadrstructure['l4'] = $objaddress->lieuDit ;
            $newadrstructure['cp'] = $objaddress->codePostal ;
            if ($objaddress->codeCedex) {
              $newadrstructure['cp'] = $objaddress->codeCedex ;
            }
            $newadrstructure['vi'] = $objaddress->commune ;
            $newadrstructure['cpvi'] = $newadrstructure['cp'] . ' ' . $newadrstructure['vi'] ;

            $newadrhtml = '<br>' ;
            foreach ($newadrstructure as $key => $label) {
              if ($label && $key !== 'cp' &&  $key !== 'vi' ) {
                $newadrhtml .= '<br>' . $label ;
              }
            }
            $newadrhtml .= '<br>FRANCE' ;
            $response = json_encode(array('0' => 'ok', '1' => $newadrstructure, '2' => $newadrhtml)) ;
            echo ($response) ;
            wp_die();
            break;
          case '3' : 
            update_post_meta($_POST['order'],'_shipping_address_1' ,$_POST['newadr']['l1']) ;
            update_post_meta($_POST['order'],'_shipping_address_2' ,$_POST['newadr']['l2']) ;
            update_post_meta($_POST['order'],'_shipping_address_3' ,$_POST['newadr']['l3']) ;
            update_post_meta($_POST['order'],'_shipping_address_4' ,$_POST['newadr']['l4']) ;
            update_post_meta($_POST['order'],'_shipping_postcode' ,$_POST['newadr']['cp']) ;
            update_post_meta($_POST['order'],'_shipping_city' ,$_POST['newadr']['vi']) ;
            break;
          case '4' : 
            $cdi_status = get_post_meta($_POST['code'],'_cdi_meta_status',true) ;
            $lib_cdi_status = str_replace( array('waiting', 'deposited' , 'intruck'),  array(__('Waiting', 'colissimo-delivery-integration'), __('Deposited', 'colissimo-delivery-integration') , __('Intruck', 'colissimo-delivery-integration')),  $cdi_status ) ;

            $html = '' ;
            $order = new WC_Order($_POST['code']);  
            $order_id = cdiwc3::cdi_order_id($order); 

            $html .= '<p>(' . __("More details in CDI Metabox", "colissimo-delivery-integration") . ')</p><p style="clear:both"></p>'; 
            $html .= '<div class="cdi-tracking-box">'; 
            $cdi_status = get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_status', true); 
       
            $cdi_meta_departure = get_post_meta($order_id,'_cdi_meta_departure',true); 
            $html .= '<p><a>' .  __("From : ", "colissimo-delivery-integration") .   $cdi_meta_departure  . '</a><br>' ;
            $shipping_country = get_post_meta($order_id,'_shipping_country',true); 
            $html .= '<a>' . __('To : ', 'colissimo-delivery-integration') . $shipping_country .  '</a>'; 
            $html .= '</p><p style="clear:both"></p>' ;

            $html .= '<div style="background-color:#eeeeee; color:#000000; width:100%;">Tracking zone</div><p style="clear:both"></p><p>'; 
            $cdi_meta_tracking = get_post_meta($order_id,'_cdi_meta_tracking',true); 
            $html .= '<a>' . __('Tracking code : ', 'colissimo-delivery-integration') . $cdi_meta_tracking . '</a><br>';
            if ($cdi_status == 'intruck' && $cdi_meta_tracking){ 
              $html .= '<a style="color:black;">' . WC_function_Colissimo::cdi_get_inovert($order_id, $cdi_meta_tracking) . '</a><br>'; 
            }
            $cdi_parcelNumberPartner = get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_parcelNumberPartner', true);    
            if ($cdi_parcelNumberPartner) {   
              $html .= '<a>' . __('Partner number : ', 'colissimo-delivery-integration') . $cdi_parcelNumberPartner . '</a><br';
            } 
            $html .= '</p><p style="clear:both"></p>' ;

            $html .= '<div style="background-color:#eeeeee; color:#000000; width:100%;">' .  __('Parcel parameters', 'colissimo-delivery-integration') . '</div><p style="clear:both"></p><p>';
            $cdi_meta_typeparcel = get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_typeparcel', true) ;
            $html .= '<a>' .  __('Parcel : ', 'colissimo-delivery-integration') . $cdi_meta_typeparcel  . '</a><br>' ;
            $cdi_meta_parcelweight = get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_parcelweight', true) ;
            $html .= '<a>' . __('Weight : ', 'colissimo-delivery-integration') . $cdi_meta_parcelweight  .  '</a><br>';
            $html .= '</p><p style="clear:both"></p>' ;

            $html .= '<div style="background-color:#eeeeee; color:#000000; width:100%;">' . __('Optional services', 'colissimo-delivery-integration') . '</div><p style="clear:both"></p><p>';
            $cdi_meta_signature = get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_signature', true) ;
            $html .= '<a>' .  __('Signature : ', 'colissimo-delivery-integration') . $cdi_meta_signature  .'</a><br>' ;
            $cdi_meta_additionalcompensation = get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_additionalcompensation', true) ;
            $html .= '<a>' . __('Compensation + : ', 'colissimo-delivery-integration') .  $cdi_meta_additionalcompensation . '</a><br>' ;
            $cdi_meta_amountcompensation = get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_amountcompensation', true) ;
            $html .= '<a>' . __('Amount : ', 'colissimo-delivery-integration') . $cdi_meta_amountcompensation . '</a><br>' ;
            $cdi_meta_returnReceipt = get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_returnReceipt', true) ;
            $html .= '<a>' . __('Avis réception : ', 'colissimo-delivery-integration') . $cdi_meta_returnReceipt . '</a><br>' ;
            $cdi_meta_typereturn = get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_typereturn', true) ;
            $html .= '<a>' . __('Return : ', 'colissimo-delivery-integration') . $cdi_meta_typereturn . '</a><br>' ;
            $cdi_meta_ftd = get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_ftd', true) ;
            $html .= '<a>' . __('ftd OM : ', 'colissimo-delivery-integration') . $cdi_meta_ftd . '</a><br>' ;
            $html .= '</p><p style="clear:both"></p>' ;

            $html .= '<div style="background-color:#eeeeee; color:#000000; width:100%;">' . __('Customer shipping settings', 'colissimo-delivery-integration') . '</div></p><p>';
            $cdi_meta_productCode = get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_productCode', true) ;
            $html .= '<a>' . __('Forced product code : ', 'colissimo-delivery-integration') . $cdi_meta_productCode . '</a><br>' ;
            $cdi_meta_pickupLocationId = get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_pickupLocationId', true) ;
            $html .= '<a>' . __('Pickup location id : ', 'colissimo-delivery-integration') . $cdi_meta_pickupLocationId . '</a><br>' ;
            $cdi_meta_pickupLocationlabel = get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_pickupLocationlabel', true) ;
            $html .= '<a>' . __('Location : ', 'colissimo-delivery-integration') . $cdi_meta_pickupLocationlabel . '</a><br>' ;
            $html .= '</p><p style="clear:both"></p>' ;
 
            $html .= '<div style="background-color:#eeeeee; color:#000000; width:100%;">' . __('CN23 parameters', 'colissimo-delivery-integration') . '</div><p style="clear:both"></p><p>';
            $cdi_meta_cn23_shipping = get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_cn23_shipping', true) ;
            $html .= '<a>' . __('CN23 transport : ', 'colissimo-delivery-integration') . $cdi_meta_cn23_shipping . '</a><br>' ;
            $cdi_meta_cn23_category = get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_cn23_category', true) ;
            $html .= '<a>' . __('CN23 category : ', 'colissimo-delivery-integration') . $cdi_meta_cn23_category . '</a><br>' ;
            $html .= '</p><p style="clear:both"></p>' ;

            $html .= '<div style="background-color:#eeeeee; color:#000000; width:100%;">' . __('Parcel return', 'colissimo-delivery-integration') . '</div><p style="clear:both"></p><p>';
            $cdi_meta_nbdayparcelreturn = get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_nbdayparcelreturn', true) ;
            $html .= '<a>' . __('Return days : ', 'colissimo-delivery-integration') . $cdi_meta_nbdayparcelreturn . '</a><br>' ;
            $cdi_meta_parcelnumber_return = get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_parcelnumber_return', true) ;
            $html .= '<a>' . __('Return tracking code : ', 'colissimo-delivery-integration') . $cdi_meta_parcelnumber_return . '</a><br>' ;
            $html .= '</p><p style="clear:both"></p>' ;

            $html .= '</div>'; 

            $response = json_encode(array('0' => 'ok', '1' => $html, '2' => $lib_cdi_status)) ;
            echo ($response) ;
            wp_die();
            break;
          default:
            error_log('*** LOG CDI - LINE:' . __LINE__ . ' FILE:' . __FILE__ . ' ***: ' . print_R($_POST['case'], TRUE));
            break;
        }
      }
    }

    /**
     * View and print label.
     *
     */
    public static function cdi_label_voir() {
      if ( isset($_POST['cdi_label_voir']) ) {
        global $woocommerce;
        global $wpdb;
        $order_id = $_POST['cdi_label_voir_post'] ;
        if (current_user_can('cdi_gateway')) {
          $cdi_loclabel = WC_function_Colissimo::cdi_uploads_get_contents ($order_id, 'label'); 
          if ($cdi_loclabel) {
            $cdi_loclabel_pdf = base64_decode ($cdi_loclabel);
            $out = fopen('php://output', 'w');
            $thepdffile = 'Label-' . $order_id . '-' . date('YmdHis') . '.pdf' ;
            header('Content-Type: application/pdf' );
            header('Content-Disposition: attachment; filename=' . $thepdffile );
            fwrite($out, $cdi_loclabel_pdf) ;
            fclose($out);
            die ();
          }
        } // End current_user_can
      }
    } 

    /**
     * View and print cn23.
     *
     */
    public static function cdi_cn23_voir() {
      if ( isset($_POST['cdi_cn23_voir']) ) {
        global $woocommerce;
        global $wpdb;
        $order_id = $_POST['cdi_cn23_voir_post'] ;
        if (current_user_can('cdi_gateway')) {
          $cdi_loccn23 = WC_function_Colissimo::cdi_uploads_get_contents ($order_id, 'cn23'); 
          if ($cdi_loccn23) {
            $cdi_loccn23_pdf = base64_decode ($cdi_loccn23);
            $out = fopen('php://output', 'w');
            $thepdffile = 'cn23-' . $order_id . '-' . date('YmdHis') . '.pdf' ;
            header('Content-Type: application/pdf' );
            header('Content-Disposition: attachment; filename=' . $thepdffile );
            fwrite($out, $cdi_loccn23_pdf) ;
            fclose($out);
            die ();
          }
        } // End current_user_can
      }
    } 
    /**
     * Preview the order.
     *
     */
    public static function cdi_preview($order_id) {
      $html = '' ;
      global $woocommerce;
      global $wpdb;
      eval (WC_function_Colissimo::cdi_eval('15')) ;
      if ( $order ) {
        include_once( WP_PLUGIN_DIR . '/woocommerce/includes/admin/list-tables/class-wc-admin-list-table-orders.php' );
        $result = WC_Admin_List_Table_Orders::order_preview_get_order_details( $order) ;
        $html = '<header style="display:inline-block;">	<h1 style="display:inline-block;">' . 'Aperçu Client/Commande : ' . $result["order_number"] . '</h1> <mark style="display:inline-block;"><span>' . $result["status_name"]  . '</span></mark> </header>' ;
        $html .= '<div><h2>' . __( "Billing details", "woocommerce" ) . '</h2>' . $result["formatted_billing_address"] . '<p><strong>' . __( "Email", "woocommerce" ) . '</strong><a>' .  $result["data"]["billing"]["email"] . '</a></p><p><strong>' . __( "Phone", "woocommerce" ) . '</strong><a>' . $result["data"]["billing"]["phone"] . '</a></p><p><strong>' . __( "Payment via", "colissimo-delivery-integration" ) . ' </strong>' . $result["payment_via"] . '</p></div>' ;
        $html .= '<div><h2>' . __( "Shipping details", "woocommerce" ) . '</h2>' . $result["formatted_billing_address"] . '<p><strong>' . __( "Shipping method", "woocommerce" ) . ' </strong>' . $result["shipping_via"] . '</p></div>' ;
        $html .= '<div><p><strong>' . __( "Customer note", "colissimo-delivery-integration" ) . ' </strong>' . $result["data"]["customer_note"] . '</p></div>' ;
        $html .= $result["item_html"] ;

      }
      return $html ;
    } 

    public static function cdi_checkad($order_id) {
      global $woocommerce;
      $cdi_status = get_post_meta($order_id,'_cdi_meta_status',true) ;
      $lib_cdi_status = str_replace( array('waiting', 'deposited' , 'intruck'),  array(__('Waiting', 'colissimo-delivery-integration'), __('Deposited', 'colissimo-delivery-integration') , __('Intruck', 'colissimo-delivery-integration')),  $cdi_status ) ;
      $return = array(
                   "st" => $lib_cdi_status,
                   "l1" => get_post_meta($order_id,'_shipping_address_1',true),
                   "l2" => get_post_meta($order_id,'_shipping_address_2',true),
                   "l3" => get_post_meta($order_id,'_shipping_address_3',true),
                   "l4" => get_post_meta($order_id,'_shipping_address_4',true),
                   "cp" => get_post_meta($order_id,'_shipping_postcode',true),
                   "vi" => get_post_meta($order_id,'_shipping_city',true),
                   "pa" => WC()->countries->countries[get_post_meta($order_id,'_shipping_country',true)]
                ) ;
      return $return ;
    } 


    public static function cdi_colissimo_open() {
    }

    public static function cdi_colissimo_add($orderid) {
      global $wpdb;
      $results = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "cdi where cdi_order_id like '" . esc_sql($orderid) . "' ");
      if (!count($results)) {
        $wpdb->query("insert into " . $wpdb->prefix . "cdi (cdi_order_id, cdi_tracking) values ('" . esc_sql($orderid) . "', '" . "" . "')");
        $id = $wpdb->insert_id ; 
        $results = $wpdb->update($wpdb->prefix . "cdi", array('cdi_status' => 'open'), array( 'ID' => $id ) );

      }
    }

    public static function cdi_colissimo_close() {
    }

}
?>
