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
/* Bulk print pdf file when requested from admin                                             */
/****************************************************************************************/

/****************************************************************************************/
// For storage of label_pdf and cn23_pdf (used on each order and accesible by admin) the choice was made to store them in an upload/cdistore file
// and not in meta_post to avoid clutter of the data base. 
/****************************************************************************************/

class WC_Gateway_Tab_Printbulkpdf {
  public static function init() {
    add_action('admin_init',  __CLASS__ . '::cdi_globalprint_label_pdf');
    add_action('admin_init',  __CLASS__ . '::cdi_globalprint_cn23_pdf');
    add_action('admin_init',  __CLASS__ . '::cdi_general_send_csv');
    if (!class_exists('FPDF')) {
      require_once dirname(__FILE__) . '/../includes/FPDF/fpdf.php';
    }
    if (!class_exists('FPDI')) {
      require_once dirname(__FILE__) . '/../includes/FPDI/fpdi.php';
    }
  }

  public static function cdi_globalprint_storeworking($lbfilename, $filecontent) {
    //
    // Store current pdf in cdistore/working file to get it back after
    //
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
    global $wp_filesystem;
    $return = null ;
    while(true){
      $upload_dir = wp_upload_dir();
      $dircdistore = trailingslashit($upload_dir['basedir']).'cdistore';
      $url = wp_nonce_url('plugins.php?page=colissimo-delivery-integration');
      if (false === ($creds = request_filesystem_credentials($url, "", false, false, null) ) ) {
        error_log('*** LOG CDI - LINE:' . __LINE__ . ' FILE:' . __FILE__ . ' ***: ' . print_R($url, TRUE));
        break;
      }
      if ( !WP_Filesystem($creds) ) {
        error_log('*** LOG CDI - LINE:' . __LINE__ . ' FILE:' . __FILE__ . ' ***: ' . print_R($creds, TRUE));
        break;
      }
      if (!file_exists($dircdistore)) { // create cdistore dir if not exist
        if ( ! $wp_filesystem->mkdir($dircdistore) ) {
          error_log('*** LOG CDI - LINE:' . __LINE__ . ' FILE:' . __FILE__ . ' ***: ' . print_R($dircdistore, TRUE));
          break;
        }
      }
      $lbfilename = trailingslashit($dircdistore). $lbfilename ;
      $result = $wp_filesystem->delete( $lbfilename) ; // if exist suppress before replace
      if ( ! $wp_filesystem->put_contents( $lbfilename, $filecontent, FS_CHMOD_FILE) ) {
        error_log('*** LOG CDI - LINE:' . __LINE__ . ' FILE:' . __FILE__ . ' ***: ' . print_R($lbfilename, TRUE));
        break;
      }
      $return = $lbfilename ;
      break;
    }
    return $return ;
    // End of store in cdistore/file
  }

  public static function AddPdfFile($pdf,$file) {
    $nbPage = $pdf->setSourceFile($file);
    for ($i = 1; $i <= $nbPage; $i++) {
      $tplidx = $pdf->ImportPage($i);
      $size = $pdf->getTemplatesize($tplidx);
      $pdf->AddPage('P', array($size['w'], $size['h']));
      $pdf->useTemplate($tplidx);
    }
  }

  public static function AddPdfFile_format_pdfA4($pdf,$file) { // Add sur format A4 portrait après rotation de 270 degrès
    $nbPage = $pdf->setSourceFile($file);
    for ($i = 1; $i <= $nbPage; $i++) {
      $tplidx = $pdf->ImportPage($i);
      $size = $pdf->getTemplatesize($tplidx);
      $pdf->AddPage('L', array($size['h'], $size['w']),-90);
      $pdf->useTemplate($tplidx);
    }
  }

  public static function AddPdfFile_format_10x15($pdf,$file) { // Add sur format 10x15 portrait
    $nbPage = $pdf->setSourceFile($file);
    for ($i = 1; $i <= $nbPage; $i++) {
      $tplidx = $pdf->ImportPage($i);
      $size = $pdf->getTemplatesize($tplidx);
      $pdf->AddPage('P', array($size['w'], $size['h']));
      $pdf->useTemplate($tplidx);
    }
  }

  public static function cdi_globalprint_label_pdf() {
    if ( isset($_POST['cdi_globalprint_label_pdf']) && isset( $_POST['cdi_globalprint_label_pdf_nonce'] ) && wp_verify_nonce( $_POST['cdi_globalprint_label_pdf_nonce'], 'cdi_globalprint_label_pdf' ) && WC_function_Colissimo::cdi_isconnected()) {
      global $woocommerce;
      global $wpdb;
      global $message;
      if (current_user_can('cdi_gateway')) {
        $results = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "cdi");
        if (count($results)) {
          $cdi_nbrorderstodo = 0 ;
          $cdi_rowcurrentorder = 0 ;
          foreach ($results as $row) {
            if ($row->cdi_status == 'open' or null == $row->cdi_status) {
              $cdi_nbrorderstodo = $cdi_nbrorderstodo +1 ; 
            }
          }
          if ( $cdi_nbrorderstodo > 0) {
            $out = fopen('php://output', 'w');
            $thepdffile = 'Bulk-label-' . date('YmdHis') . '.pdf' ;
            header('Content-Type: application/pdf' );
            eval (WC_function_Colissimo::cdi_eval('9')) ;
            $cdi_nbrorderstoprocess = 0 ;
            $pdf = new FPDI();
            foreach ($results as $row) {
              if ($row->cdi_status == 'open' or null == $row->cdi_status) {
                $cdi_nbrorderstoprocess = $cdi_nbrorderstoprocess + 1 ;
                $cdi_loclabel = WC_function_Colissimo::cdi_uploads_get_contents ($row->cdi_order_id, 'label'); 
                if ($cdi_loclabel) {
                  $cdi_loclabel_pdf = base64_decode ($cdi_loclabel);
                  $lbfilename = 'Bulk-label-working-' . $cdi_nbrorderstoprocess . '.pdf';
                  $realfilename = self::cdi_globalprint_storeworking($lbfilename, $cdi_loclabel_pdf) ;
                  WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $realfilename);
                  if (null !== $realfilename) {
                    $format = get_option('wc_settings_tab_colissimo_ws_OutputPrintingType') ;
                    if ($format == 'PDF_A4_300dpi') {
                      self::AddPdfFile_format_pdfA4($pdf, $realfilename) ;
                    }elseif ($format == 'PDF_10x15_300dpi') {
                      self::AddPdfFile_format_10x15($pdf, $realfilename) ;
                    }else{
                      $message = 'Error output format : ' . $format ; // Notice admin to rework
                      error_log('*** LOG CDI - LINE:' . __LINE__ . ' FILE:' . __FILE__ . ' ***: ' . print_R('Error output format : ' . $format, TRUE));
                    }
                  }
                }
              }
            }
            $resultpdf = $pdf->Output('S');
            $lbfilename = 'Bulk-label-working-' . '0' . '.pdf';
            $realfilename = self::cdi_globalprint_storeworking($lbfilename, $resultpdf) ;
            fwrite($out, $resultpdf) ;
            fclose($out);
            die ();
          }
        } // End $results
      } // End current_user_can
    } // End $_POST['cdi_globalprint_label_pdf'
  } // End function cdi_globalprint_label_pdf

  public static function cdi_globalprint_cn23_pdf() {
    if ( isset($_POST['cdi_globalprint_cn23_pdf']) && isset( $_POST['cdi_globalprint_cn23_pdf_nonce'] ) && wp_verify_nonce( $_POST['cdi_globalprint_cn23_pdf_nonce'], 'cdi_globalprint_cn23_pdf' ) && WC_function_Colissimo::cdi_isconnected()) {
      global $woocommerce;
      global $wpdb;
      if (current_user_can('cdi_gateway')) {
        $results = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "cdi");
        if (count($results)) {
          $cdi_nbrorderstodo = 0 ;
          $cdi_rowcurrentorder = 0 ;
          foreach ($results as $row) {
            if ($row->cdi_status == 'open' or null == $row->cdi_status) {
              $cdi_nbrorderstodo = $cdi_nbrorderstodo +1 ; 
            }
          }
          if ( $cdi_nbrorderstodo > 0) {
            $out = fopen('php://output', 'w');
            $thepdffile = 'Bulk-cn23-' . date('YmdHis') . '.pdf' ;
            header('Content-Type: application/pdf' );
            eval (WC_function_Colissimo::cdi_eval('9')) ;
            $cdi_nbrorderstoprocess = 0 ;
            $pdf = new FPDI();
            foreach ($results as $row) {
              if ($row->cdi_status == 'open' or null == $row->cdi_status) {
                $cdi_nbrorderstoprocess = $cdi_nbrorderstoprocess + 1 ;
                $cdi_loccn23 = WC_function_Colissimo::cdi_uploads_get_contents ($row->cdi_order_id, 'cn23'); 
                if ($cdi_loccn23) {
                  $cdi_loccn23_pdf = base64_decode ($cdi_loccn23);
                  $lbfilename = 'Bulk-cn23-working-' . $cdi_nbrorderstoprocess . '.pdf';
                  $realfilename = self::cdi_globalprint_storeworking($lbfilename, $cdi_loccn23_pdf) ;
                  WC_function_Colissimo::cdi_debug(__LINE__ ,__FILE__ , $realfilename);
                  if (null !== $realfilename) {
                    self::AddPdfFile($pdf, $realfilename) ;
                  }
                }
              }
            }
            $resultpdf = $pdf->Output('S');
            $lbfilename = 'Bulk-cn23-working-' . '0' . '.pdf';
            $realfilename = self::cdi_globalprint_storeworking($lbfilename, $resultpdf) ;
            fwrite($out, $resultpdf) ;
            fclose($out);
            die ();
          }
        } // End $results
      } // End current_user_can
    } // End $_POST['cdi_globalprint_cn23_pdf'
  } // End function cdi_globalprint_cn23_pdf

  public static function cdi_general_send_csv() {
    if (get_option('wc_settings_tab_colissimo_generalsendcsv') && WC_function_Colissimo::cdi_isconnected()) {
      if (current_user_can('cdi_gateway')) {
            $thecsvfile = get_option('wc_settings_tab_colissimo_generalsendcsv')['filename'] ;
            $thecontent = get_option('wc_settings_tab_colissimo_generalsendcsv')['content'] ;
            $out = fopen('php://output', 'w');
            header('Content-type: text/csv' );
            eval (WC_function_Colissimo::cdi_eval('10')) ;
            fwrite($out, $thecontent);
            fclose($out);
            delete_option('wc_settings_tab_colissimo_generalsendcsv') ;
            die ();
      } // End current_user_can
    } // End $_POST['cdi_general_send_csv'
  } // End function cdi_general_send_csv

} // End class
?>
