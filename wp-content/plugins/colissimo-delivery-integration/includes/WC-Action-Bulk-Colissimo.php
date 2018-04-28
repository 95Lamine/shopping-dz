<?PHP

/**
 * This file is part of the Colissimo Delivery Integration plugin.
 * (c) Harasse
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if (!defined('ABSPATH')) exit;
/****************************************************************************************/
/* Add bulk Colissimo actions in the orders listing                                     */
/****************************************************************************************/
class WC_Action_Bulk_Colissimo {
    public static function init() {
      add_action('admin_footer-edit.php',  __CLASS__ . '::cdi_custom_bulk_colissimo_action');
      add_action('load-edit.php', __CLASS__ . '::cdi_custom_bulk_action');
    }
    public static function cdi_custom_bulk_colissimo_action() {
        global $post_type;
        if($post_type == 'shop_order') {
          ?>
          <script type="text/javascript">
            jQuery(document).ready(function() {
              jQuery('<option>').val('colissimo').text('<?php _e('Colissimo')?>').appendTo("select[name='action']");
              jQuery('<option>').val('colissimo').text('<?php _e('Colissimo')?>').appendTo("select[name='action2']");
            });
          </script>
          <?php
        }
    }
    public static function cdi_custom_bulk_action() {
        global $typenow;
        $post_type = $typenow;
        if($post_type == 'shop_order') {
          $wp_list_table = _get_list_table('WP_Posts_List_Table');  
          $action = $wp_list_table->current_action();
          $allowed_actions = array("colissimo");
          if(!in_array($action, $allowed_actions)) return;
          check_admin_referer('bulk-posts'); // security check
          if(isset($_REQUEST['post'])) {
            $post_ids = array_map('intval', $_REQUEST['post']);
          }
          if(empty($post_ids)) return;
          $nbcolis = 0;
          WC_Gateway_Tab_Colissimo::cdi_colissimo_open () ;
          foreach( $post_ids as $post_id ) {
            WC_Gateway_Tab_Colissimo::cdi_colissimo_add($post_id) ;
            $nbcolis++;
          }
          WC_Gateway_Tab_Colissimo::cdi_colissimo_close () ;
          if ($nbcolis > 0) {
            $message = number_format_i18n( $nbcolis ) . ' Colissimo orders added in Gateway.' ;
            update_option( 'cdi_notice_display', $message );
            $sendback = admin_url() . 'edit.php?post_type=shop_order' ;
            wp_redirect($sendback);
            exit ;
          }
        }
    }
}
?>
