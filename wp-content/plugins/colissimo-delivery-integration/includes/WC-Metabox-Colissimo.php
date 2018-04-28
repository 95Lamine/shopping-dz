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
/* Meta box in order panel for Colissimo tracking                                       */
/****************************************************************************************/
class WC_Metabox_Colissimo {
    public static function init() {
        add_action( 'add_meta_boxes_shop_order',  __CLASS__ . '::cdi_addmetabox' ); 
        add_action( 'save_post',  __CLASS__ . '::cdi_save_metabox_colissimo', 99);
    }
    public static function cdi_addmetabox() {
        add_meta_box( 'cdi-colissimo-tracking-box', 'Colissimo Delivery Integration',   __CLASS__ . '::cdi_create_box_content', 'shop_order', 'side', 'low' );
    }
    public static function cdi_create_box_content() {
      // Ref : wc-meta-box-functions.php
      ?>
        <?php wp_nonce_field( 'cdi_save_metabox_colissimo', 'cdi_save_metabox_colissimo_nonce');  ?> 
        <?php global $woocommerce, $post; ?>
        <?php $order = new WC_Order($post->ID); ?> 
        <?php $order_id = cdiwc3::cdi_order_id($order); ?>

          <div class="cdi-tracking-box">
         
        <?php $cdi_status = get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_status', true); ?>
        <?php $lib_cdi_status = str_replace( array('waiting', 'deposited' , 'intruck'),  array(__('Waiting', 'colissimo-delivery-integration'), __('Deposited', 'colissimo-delivery-integration') , __('Intruck', 'colissimo-delivery-integration')),  $cdi_status );?> 
        <p><a><?php _e('Status : ', 'colissimo-delivery-integration'); ?></a><a style='color:black'><?php echo $lib_cdi_status; ?> </a></p>
        <?php $cdi_urllabel = get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_urllabel', true);
              $cdi_tracking = get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_tracking', true);
              if ($cdi_status == 'intruck' && $cdi_tracking && WC_function_Colissimo::cdi_isconnected()){ 
                eval (WC_function_Colissimo::cdi_eval('7')) ;
                ?> <p><a style="color:black;"><?php echo WC_function_Colissimo::cdi_get_inovert($order_id, $cdi_tracking); ?></a></p><?php
                eval (WC_function_Colissimo::cdi_eval('12')) ;
              }
        ?>
        <?php $shipping_country = get_post_meta($order_id,'_shipping_country',true); ?>
        <p><a><?php _e('To : ', 'colissimo-delivery-integration'); ?></a><a style="color:black;"><?php echo $shipping_country ?> </a></p>

          <p style='width:25%; float:left; margin-top:5px;'><a><?php _e('From : ', 'colissimo-delivery-integration'); ?><?php woocommerce_wp_text_input( array(
                'name' => '_cdi_meta_departure',
                'type' => 'text',
                'style' => 'width:70%; float:left;',
                'id'   => '_cdi_meta_departure',
                'label' => '',
            ) ); ?> </a></p><p style="clear:both"></p>


        <!--  Tracking code zone --> 
        <div style='background-color:#eeeeee; color:#000000; width:100%;'>Tracking zone</div><p style="clear:both"></p>

        <p style='width:35%; float:left;  margin-top:5px;'><a><?php _e('Tracking code : ', 'colissimo-delivery-integration'); ?><?php woocommerce_wp_text_input( array(
                'name' => '_cdi_meta_tracking',
                'type' => 'text',
                'style' => 'width:60%; float:left;',
                'id'   => '_cdi_meta_tracking',
                'label' => '',
            ) ); ?> </a></p><p style="clear:both"></p>

        <?php $cdi_parcelNumberPartner = get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_parcelNumberPartner', true);  ?>  
        <?php if ($cdi_parcelNumberPartner) { ?>  
                <p><a><?php _e('Partner number : ', 'colissimo-delivery-integration'); ?></a><a style='color:black'><?php echo $cdi_parcelNumberPartner ?> </a></p>
        <?php } ?>

        <?php $cdi_urllabel = get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_urllabel', true);  ?>
        <?php if ($cdi_urllabel) { ?> 
                <p><a style="display:inline-block;"><?php _e('To Labels :  ', 'colissimo-delivery-integration'); ?></a><a style="vertical-align: middle; display:inline-block; color:black; width:12em; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;" href="<?php echo $cdi_urllabel ?>" onclick="window.open(this.href); return false;" > <?php echo $cdi_urllabel ?> </a></p>
        <?php } ?>

        <?php if (get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_exist_uploads_label', true) == true OR get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_exist_uploads_cn23', true) == true) {  ?>
          <p style="display:inline-block; margin:0px;">
        <?php } ?>

           <?php if (get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_exist_uploads_label', true) == true) {  ?>
                     <form method="post" id="cdi_local_label_pdf" action="" style="display:inline-block;">
                      <input type="hidden" name="order_id" value="<?php echo $order_id ; ?>">
                      <input type="submit" name="cdi_local_label_pdf" value="Print label"  title="Print label" /> 
                      <?php wp_nonce_field( 'cdi_local_label_pdf', 'cdi_local_label_pdf_nonce');  ?> 
                    </form>
           <?php } ?>

           <?php if (get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_exist_uploads_cn23', true) == true) {  ?>
                     <form method="post" id="cdi_local_cn23_pdf" action="" style="display:inline-block;">
                      <input type="hidden" name="order_id" value="<?php echo $order_id ; ?>">
                      <input type="submit" name="cdi_local_cn23_pdf" value="Print Cn23"  title="Print cn23" /> 
                      <?php wp_nonce_field( 'cdi_local_cn23_pdf', 'cdi_local_cn23_pdf_nonce');  ?> 
                    </form>
           <?php } ?>
        </p>
        <!--  End Tracking code zone --> 



        <div style='background-color:#eeeeee; color:#000000; width:100%;'><?php _e('Parcel parameters', 'colissimo-delivery-integration'); ?></div><p style="clear:both"></p>
        <p style='width:25%; float:left;  margin-top:5px;'><a><?php _e('Parcel : ', 'colissimo-delivery-integration'); ?><?php woocommerce_wp_select( array(
                'name' => '_cdi_meta_typeparcel',
                'type' => 'text',
                'options' => array (
                  'colis-standard'   => __('Standard', 'colissimo-delivery-integration'),
                  'colis-volumineux' => __('Cumbersome', 'colissimo-delivery-integration'),
                  'colis-rouleau   ' => __('Tube', 'colissimo-delivery-integration'),
                  ),
                'style' => 'width:70%; float:left;',
                'id'   => '_cdi_meta_typeparcel',
                'label' => '',
            ) ); ?> </a></p><p style="clear:both"></p>

        <p style='width:25%; float:left;  margin-top:5px;'><a><?php _e('Weight : ', 'colissimo-delivery-integration'); ?><?php woocommerce_wp_text_input( array(
                'name' => '_cdi_meta_parcelweight',
                'type' => 'text',
                'data_type' => 'decimal',
                'style' => 'width:70%; float:left;',
                'id'   => '_cdi_meta_parcelweight',
                'label' => '',
            ) ); ?> </a></p><p style="clear:both"></p>

        <div style='background-color:#eeeeee; color:#000000; width:100%;'><?php _e('Optional services', 'colissimo-delivery-integration'); ?></div><p style="clear:both"></p>

        <?php if (!WC_function_Colissimo::cdi_colissimo_withoutsign_country($shipping_country)) { ?>
           <?php update_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_signature', 'yes') ; ?>
        <?php } ?>

        <p style='width:50%; float:left;  margin-top:0px;'><a><?php _e('Signature : ', 'colissimo-delivery-integration'); ?><?php woocommerce_wp_select( array(
                'name' => '_cdi_meta_signature',
                'type' => 'text',
                'options' => array (
                  'yes' => __('yes', 'colissimo-delivery-integration'),
                  'no' => __('no', 'colissimo-delivery-integration'),
                  ),
                'style' => 'width:20%; float:left;',
                'id'   => '_cdi_meta_signature',
                'label' => '',
            ) ); ?> </a></p><p style="clear:both"></p>

        <?php if (get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_signature', true) == 'yes') { ?> <!--  Additionnal insurance display --> 
        <p style='width:50%; float:left;  margin-top:0px;'><a><?php _e('Compensation + : ', 'colissimo-delivery-integration'); ?><?php woocommerce_wp_select( array(
                'name' => '_cdi_meta_additionalcompensation',
                'type' => 'text',
                'options' => array (
                  'yes' => __('yes', 'colissimo-delivery-integration'),
                  'no' => __('no', 'colissimo-delivery-integration'),
                  ),
                'style' => 'width:20%; float:left;',
                'id'   => '_cdi_meta_additionalcompensation',
                'label' => '',
            ) ); ?> </a></p><p style="clear:both"></p>

        <?php if (get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_additionalcompensation', true) == 'yes') { ?> <!--  Amount compensation display --> 
        <p style='width:30%; float:left; margin-left:20%; margin-top:5px;'><a><?php _e('Amount : ', 'colissimo-delivery-integration'); ?><?php woocommerce_wp_text_input( array(
                'name' => '_cdi_meta_amountcompensation',
                'type' => 'text',
                'data_type' => 'decimal',
                'style' => 'width:45%; float:left;',
                'id'   => '_cdi_meta_amountcompensation',
                'label' => '',
            ) ); ?> </a></p><p style="clear:both"></p>

        <?php } ?> <!--  End Amount compensation display --> 

        <?php } ?> <!--  End Additionnal insurance display display --> 

        <!--Option Avis réception --> 
        <p style='width:50%; float:left;  margin-top:5px;'><a>Avis réception<?php woocommerce_wp_select( array(
                'name' => '_cdi_meta_returnReceipt',
                'type' => 'text',
                'options' => array (
                  'non' => __('sans', 'colissimo-delivery-integration'),
                  'oui' => __('avec', 'colissimo-delivery-integration'),
                  ),
                'style' => 'width:45%; float:left;',
                'id'   => '_cdi_meta_returnReceipt',
                'label' => '',
            ) ); ?> </a></p><p style="clear:both"></p>
        <!--  Fin Option Avis réception --> 

        <?php if (WC_function_Colissimo::cdi_choosereturn_country ($shipping_country) == true) { ?> <!--  Return internationnal display --> 
        <p style='width:50%; float:left;  margin-top:5px;'><a><?php _e('Return : ', 'colissimo-delivery-integration'); ?><?php woocommerce_wp_select( array(
                'name' => '_cdi_meta_typereturn',
                'type' => 'text',
                'options' => array (
                  'no-return'      => __('No return', 'colissimo-delivery-integration'),
                  'pay-for-return' => __('Pay for return', 'colissimo-delivery-integration'),
                  ),
                'style' => 'width:45%; float:left;',
                'id'   => '_cdi_meta_typereturn',
                'label' => '',
            ) ); ?> </a></p><p style="clear:both"></p>
        <?php } ?> <!--  End Return internationnal display --> 

        <?php if (WC_function_Colissimo::cdi_colissimo_outremer_country_ftd ($shipping_country) == true) { ?> <!--Option franc taxes-douanes --> 
        <p style='width:50%; float:left;  margin-top:5px;'><a>ftd OM<?php woocommerce_wp_select( array(
                'name' => '_cdi_meta_ftd',
                'type' => 'text',
                'options' => array (
                  'non' => __('non ftd', 'colissimo-delivery-integration'),
                  'oui' => __('en ftd', 'colissimo-delivery-integration'),
                  ),
                'style' => 'width:45%; float:left;',
                'id'   => '_cdi_meta_ftd',
                'label' => '',
            ) ); ?> </a></p><p style="clear:both"></p>
        <?php } ?> <!--  Fin Option franc de taxes-douanes --> 

        <!--  Pickup location web services - can be filled by meta box or retraitpoint web services --> 
        <div style='background-color:#eeeeee; color:#000000; width:100%;'><?php _e('Customer shipping settings', 'colissimo-delivery-integration'); ?></div><p style="clear:both"></p>
        <p style='width:55%; float:left; margin-top:5px;'><a><?php _e('Forced product code : ', 'colissimo-delivery-integration'); ?><?php woocommerce_wp_text_input( array(
                'name' => '_cdi_meta_productCode',
                'type' => 'text',
                'style' => 'width:40%; float:left;',
                'id'   => '_cdi_meta_productCode',
                'label' => '',
            ) ); ?> </a></p><p style="clear:both"></p>
        <p style='width:50%; float:left; margin-top:5px;'><a><?php _e('Pickup location id : ', 'colissimo-delivery-integration'); ?><?php woocommerce_wp_text_input( array(
                'name' => '_cdi_meta_pickupLocationId',
                'type' => 'text',
                'style' => 'width:45%; float:left;',
                'id'   => '_cdi_meta_pickupLocationId',
                'label' => '',
            ) ); ?> </a></p><p style="clear:both"></p>

        <?php $pickupLocationlabel = get_post_meta( cdiwc3::cdi_order_id($order) , '_cdi_meta_pickupLocationlabel', true );  ?>
        <?php if ($pickupLocationlabel) { ?>
                <?php $pickupLocationlabel = stristr($pickupLocationlabel, "=> Distance: ", true); ?>
                <p><a><?php _e('Location : ', 'colissimo-delivery-integration'); ?></a><a style='color:black'><?php echo $pickupLocationlabel ?> </a></p>
        <?php } ?>
        <!--  End Pickup location web services --> 

        <?php if (WC_function_Colissimo::cdi_cn23_country ($shipping_country)) { ?> <!--  CN23 display --> 
        <div style='background-color:#eeeeee; color:#000000; width:100%;'><?php _e('CN23 parameters', 'colissimo-delivery-integration'); ?></div><p style="clear:both"></p>

        <p style='width:50%; float:left;  margin-top:5px;'><a><?php _e('CN23 transport : ', 'colissimo-delivery-integration'); ?><?php woocommerce_wp_text_input( array(
                'name' => '_cdi_meta_cn23_shipping',
                'type' => 'text',
                'data_type' => 'decimal',
                'style' => 'width:45%; float:left;',
                'id'   => '_cdi_meta_cn23_shipping',
                'label' => '',
            ) ); ?> </a></p><p style="clear:both"></p>

        <p style='width:50%; float:left;  margin-top:5px;'><a><?php _e('CN23 category : ', 'colissimo-delivery-integration'); ?><?php woocommerce_wp_select( array(
                'name' => '_cdi_meta_cn23_category',
                'type' => 'text',
                'options' => array (
                  '1' => __('Gift', 'colissimo-delivery-integration'),
                  '2' => __('Sample', 'colissimo-delivery-integration'),
                  '3' => __('Commercial', 'colissimo-delivery-integration'),
                  '4' => __('Documents', 'colissimo-delivery-integration'),
                  '5' => __('Other', 'colissimo-delivery-integration'),
                  '6' => __('Returned goods', 'colissimo-delivery-integration'),
                  ),
                'style' => 'width:45%; float:left;',
                'id'   => '_cdi_meta_cn23_category',
                'label' => '',
            ) ); ?> </a></p><p style="clear:both"></p>

        <?php $items = $order->get_items(); ?>
        <?php $nbart = 0;  ?>
        <?php foreach( $items as $item ) {  ?>
          <div style='background-color:#eeeeee; color:#000000; width:100%; height:8px; font-size:smaller; line-height:8px;'><?php _e('Article : ', 'colissimo-delivery-integration'); ?><?php echo $nbart ; ?></div><p style="clear:both"></p>

          <p style='width:50%; float:left; margin-top:5px;'><a><?php _e('CN23 Art descript. : ', 'colissimo-delivery-integration'); ?><?php woocommerce_wp_text_input( array(
                  'name' => '_cdi_meta_cn23_article_description_' . $nbart,
                  'type' => 'text',
                  'style' => 'width:45%; float:left;',
                  'id'   => '_cdi_meta_cn23_article_description_' . $nbart,
                  'label' => '',
              ) ); ?> </a></p><p style="clear:both"></p>
          <p style='width:50%; float:left;  margin-top:5px;'><a><?php _e('CN23 Art weight : ', 'colissimo-delivery-integration'); ?><?php woocommerce_wp_text_input( array(
                  'name' => '_cdi_meta_cn23_article_weight_' . $nbart,
                  'type' => 'text',
                  'data_type' => 'decimal',
                  'style' => 'width:45%; float:left;',
                  'id'   => '_cdi_meta_cn23_article_weight_' . $nbart,
                  'label' => '',
              ) ); ?> </a></p><p style="clear:both"></p>

          <p style='width:50%; float:left;  margin-top:5px;'><a><?php _e('CN23 Art quantity : ', 'colissimo-delivery-integration'); ?><?php woocommerce_wp_text_input( array(
                  'name' => '_cdi_meta_cn23_article_quantity_' . $nbart,
                  'type' => 'text',
                  'data_type' => 'decimal',
                  'style' => 'width:45%; float:left;',
                  'id'   => '_cdi_meta_cn23_article_quantity_' . $nbart,
                  'label' => '',
              ) ); ?> </a></p><p style="clear:both"></p>

          <p style='width:50%; float:left;  margin-top:5px;'><a><?php _e('CN23 Art value : ', 'colissimo-delivery-integration'); ?><?php woocommerce_wp_text_input( array(
                  'name' => '_cdi_meta_cn23_article_value_' . $nbart,
                  'type' => 'text',
                  'data_type' => 'decimal',
                  'style' => 'width:45%; float:left;',
                  'id'   => '_cdi_meta_cn23_article_value_' . $nbart,
                  'label' => '',
              ) ); ?> </a></p><p style="clear:both"></p>

          <?php if (get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_cn23_category', true) == '3') { ?> <!--  CN23 HS code display --> 

            <p style='width:50%; float:left; margin-top:5px;'><a> <a href="https://pro.douane.gouv.fr/rita/nomenclatures/index.asp" target="_blank">HS code</a> : <?php woocommerce_wp_text_input( array(
                    'name' => '_cdi_meta_cn23_article_hstariffnumber_' . $nbart,
                    'type' => 'text',
                    'custom_attributes' => array (
                      'pattern' => '[0-9]{4,6}',
                      ),
                    'style' => 'width:45%; float:left;',
                    'id'   => '_cdi_meta_cn23_article_hstariffnumber_' . $nbart,
                    'label' => '',
                ) ); ?> </a></p><p style="clear:both"></p>

          <?php } ?> <!--  End CN23 HS code display --> 

          <p style='width:50%; float:left; margin-top:5px;'><a><?php _e('CN23 Art origine : ', 'colissimo-delivery-integration'); ?><?php woocommerce_wp_text_input( array(
                  'name' => '_cdi_meta_cn23_article_origincountry_' . $nbart,
                  'type' => 'text',
                  'style' => 'width:45%; float:left;',
                  'id'   => '_cdi_meta_cn23_article_origincountry_' . $nbart,
                  'label' => '',
              ) ); ?> </a></p><p style="clear:both"></p>
        <?php   $nbart = $nbart+1; ?>
        <?php } ?>
        <?php } ?> <!--  End CN23 display --> 

        <?php if (get_option('wc_settings_tab_colissimo_parcelreturn') == 'yes') { ?> <!--  Parcel return display --> 
          <div style='background-color:#eeeeee; color:#000000; width:100%;'><?php _e('Parcel return', 'colissimo-delivery-integration'); ?></div><p style="clear:both"></p>
          <p style='width:50%; float:left; margin-top:5px;'><a><?php _e('Return days : ', 'colissimo-delivery-integration'); ?><?php woocommerce_wp_text_input( array(
                'name' => '_cdi_meta_nbdayparcelreturn',
                'type' => 'text',
                'data_type' => 'decimal',
                'style' => 'width:45%; float:left;',
                'id'   => '_cdi_meta_nbdayparcelreturn',
                'label' => '',
              ) ); ?> </a></p><p style="clear:both"></p>

          <?php if (get_post_meta($order_id, '_cdi_meta_base64_return', true)) {  ?>
            <p style="display:inline-block; margin:0px;">
               <form method="post" id="cdi_admin_return_pdf" action="" style="display:inline-block;">
                 <input type="hidden" name="order_id" value="<?php echo $order_id ; ?>">
                 <input type="submit" name="cdi_admin_return_pdf" value="Print return label"  title="Print return label" /> 
                 <?php wp_nonce_field( 'cdi_admin_return_pdf', 'cdi_admin_return_pdf_nonce');  ?> 
               </form>
 
            <?php $cdi_urllabel_return = get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_pdfurl_return', true);  ?>
              <p><a style="display:inline-block;"><?php _e('To return label : ', 'colissimo-delivery-integration'); ?></a><a style="vertical-align: middle; display:inline-block; color:black; width:12em; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;" href="<?php echo $cdi_urllabel_return ?>" onclick="window.open(this.href); return false;" > <?php echo $cdi_urllabel_return ?> </a></p>

            <?php $cdi_tracking_return = get_post_meta(cdiwc3::cdi_order_id($order), '_cdi_meta_parcelnumber_return', true);  ?>  
              <p><a><?php _e('Return tracking code : ', 'colissimo-delivery-integration'); ?></a><a style='color:black'><?php echo $cdi_tracking_return ?> </a></p>

          </p>
          <?php } ?>
        <?php } ?> <!--  End Parcel return display --> 

        </div>
      <?php 
    }
    public static function cdi_save_metabox_colissimo ($post_id) {
      global $woocommerce, $post, $post_type;
      if ( !isset( $_POST['cdi_save_metabox_colissimo_nonce'] ) ) { return $post_id; }
      if ( !wp_verify_nonce( $_POST['cdi_save_metabox_colissimo_nonce'], 'cdi_save_metabox_colissimo' ) ) { return $post_id; }
//      if ( !current_user_can( 'edit_post' ) ) {	return $post_id; }
      if($post_type !== 'shop_order') { return $post_id; }

      if (ISSET($_POST['_cdi_meta_destcountrycode'])) { update_post_meta( $post_id, '_cdi_meta_destcountrycode', sanitize_text_field( $_POST['_cdi_meta_destcountrycode'] ) ); }
      if (isset($_POST['_cdi_meta_departure'])) { update_post_meta( $post_id, '_cdi_meta_departure', sanitize_text_field( $_POST['_cdi_meta_departure'] ) ); }
      if (isset($_POST['_cdi_meta_tracking'])) { update_post_meta( $post_id, '_cdi_meta_tracking', sanitize_text_field( $_POST['_cdi_meta_tracking'] ) ); }
      if (isset($_POST['_cdi_meta_typeparcel'])) { update_post_meta( $post_id, '_cdi_meta_typeparcel', sanitize_text_field( $_POST['_cdi_meta_typeparcel'] ) ); }
      if (isset($_POST['_cdi_meta_parcelweight'])) { update_post_meta( $post_id, '_cdi_meta_parcelweight', sanitize_text_field( $_POST['_cdi_meta_parcelweight'] ) ); }
      if (isset($_POST['_cdi_meta_signature'])) { update_post_meta( $post_id, '_cdi_meta_signature', sanitize_text_field( $_POST['_cdi_meta_signature'] ) ); }
      if (isset($_POST['_cdi_meta_additionalcompensation'])) { update_post_meta( $post_id, '_cdi_meta_additionalcompensation', sanitize_text_field( $_POST['_cdi_meta_additionalcompensation'] ) ); }
      if (isset($_POST['_cdi_meta_amountcompensation'])) { update_post_meta( $post_id, '_cdi_meta_amountcompensation', sanitize_text_field( $_POST['_cdi_meta_amountcompensation'] ) ); }
      if (isset($_POST['_cdi_meta_returnReceipt'])) { update_post_meta( $post_id, '_cdi_meta_returnReceipt', sanitize_text_field( $_POST['_cdi_meta_returnReceipt'] ) ); }
      if (isset($_POST['_cdi_meta_typereturn'])) { update_post_meta( $post_id, '_cdi_meta_typereturn', sanitize_text_field( $_POST['_cdi_meta_typereturn'] ) ); }
      if (isset($_POST['_cdi_meta_ftd'])) { update_post_meta( $post_id, '_cdi_meta_ftd', sanitize_text_field( $_POST['_cdi_meta_ftd'] ) ); }
      if (isset($_POST['_cdi_meta_productCode'])) { update_post_meta( $post_id, '_cdi_meta_productCode', sanitize_text_field( $_POST['_cdi_meta_productCode'] ) ); }
      if (isset($_POST['_cdi_meta_pickupLocationId'])) { update_post_meta( $post_id, '_cdi_meta_pickupLocationId', sanitize_text_field( $_POST['_cdi_meta_pickupLocationId'] ) ); }
      if (isset($_POST['_cdi_meta_cn23_shipping'])) { update_post_meta( $post_id, '_cdi_meta_cn23_shipping', sanitize_text_field( $_POST['_cdi_meta_cn23_shipping'] ) ); }      
      if (isset($_POST['_cdi_meta_cn23_category'])) { update_post_meta( $post_id, '_cdi_meta_cn23_category', sanitize_text_field( $_POST['_cdi_meta_cn23_category'] ) ); }
      if (isset($_POST['_cdi_meta_nbdayparcelreturn'])) { update_post_meta( $post_id, '_cdi_meta_nbdayparcelreturn', sanitize_text_field( $_POST['_cdi_meta_nbdayparcelreturn'] ) ); }

      // $order = new WC_Order($post->ID); $items = $order->get_items(); => give a crash with woocommerce-pdf-invoices-packingslips, so a resiliant way to found to find nb of cn23 articles
      
      $nbart = 0 ;
      while( $nbart <= 10 ) { // Check post limited to 10 products to limit server overhead
        if (isset($_POST['_cdi_meta_cn23_article_description_' . $nbart])) { update_post_meta( $post_id, '_cdi_meta_cn23_article_description_' . $nbart, sanitize_text_field( $_POST['_cdi_meta_cn23_article_description_' . $nbart] ) ); }
        if (isset($_POST['_cdi_meta_cn23_article_weight_' . $nbart])) { update_post_meta( $post_id, '_cdi_meta_cn23_article_weight_' . $nbart, sanitize_text_field( $_POST['_cdi_meta_cn23_article_weight_' . $nbart] ) ); }
        if (isset($_POST['_cdi_meta_cn23_article_quantity_' . $nbart])) { update_post_meta( $post_id, '_cdi_meta_cn23_article_quantity_' . $nbart, sanitize_text_field( $_POST['_cdi_meta_cn23_article_quantity_' . $nbart] ) ); }
        if (isset($_POST['_cdi_meta_cn23_article_value_' . $nbart])) { update_post_meta( $post_id, '_cdi_meta_cn23_article_value_' . $nbart, sanitize_text_field( $_POST['_cdi_meta_cn23_article_value_' . $nbart] ) ); }
        if (isset($_POST['_cdi_meta_cn23_article_hstariffnumber_' . $nbart])) { update_post_meta( $post_id, '_cdi_meta_cn23_article_hstariffnumber_' . $nbart, sanitize_text_field( $_POST['_cdi_meta_cn23_article_hstariffnumber_' . $nbart] ) ); }
        if (isset($_POST['_cdi_meta_cn23_article_origincountry_' . $nbart])) { update_post_meta( $post_id, '_cdi_meta_cn23_article_origincountry_' . $nbart, sanitize_text_field( $_POST['_cdi_meta_cn23_article_origincountry_' . $nbart] ) ); }
        $nbart = $nbart+1; 
      }
    }
}


?>
