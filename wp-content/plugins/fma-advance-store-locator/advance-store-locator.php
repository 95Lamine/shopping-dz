<?php 

/*
 * Plugin Name:       Advance Store Locator(Free)
 * Plugin URI:        http://fmeaddons.com/wordpress/advance-store-locator
 * Description:       Advance store locator extension makes your locations easier to access. This module creates a store finder page on your website where your customers can search for items before actually visiting any store. This saves a lot of time, guides them well and makes them feel valued.
 * Version:           1.0.1
 * Author:            FME Addons
 * Author URI:        http://fmeaddons.com/
 * Text Domain:       advance-store-locator-locale
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * Requires at least: 4.2.0
 * Tested up to: 4.7.5
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {


if ( !class_exists( 'FME_Advance_Store_Locator' ) ) {

	class FME_Advance_Store_Locator {

		public $module_settings = array();
		public $module_default_settings = array();

		function __construct()
		{
			$this->module_tables();
			$this->module_constants();

			if ( is_admin() ) {
                require_once( FMEASL_PLUGIN_DIR . 'admin/class-advance-store-locator-admin.php' );
                load_plugin_textdomain( 'fmeasl', false, basename( dirname( __FILE__ ) ) . '/languages' );
                register_activation_hook( __FILE__, array( $this, 'install_module' ) );
                $this->module_default_settings = $this->get_module_default_settings();
            } else {         
                require_once( FMEASL_PLUGIN_DIR . 'front/class-front.php' );
                
            } 

            
		}

		

		public function module_constants() {
            
            if ( !defined( 'FMEASL_URL' ) )
                define( 'FMEASL_URL', plugin_dir_url( __FILE__ ) );

            if ( !defined( 'FMEASL_BASENAME' ) )
                define( 'FMEASL_BASENAME', plugin_basename( __FILE__ ) );

            if ( ! defined( 'FMEASL_PLUGIN_DIR' ) )
                define( 'FMEASL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
        }

        private function module_tables() {
            
			global $wpdb;
		
			$wpdb->fmeasl_stores = $wpdb->prefix . 'fmeasl_stores';
		}

		public function install_module( $wordpress_network ) {
            
            global $wpdb;
            
            if ( function_exists( 'is_multisite' ) && is_multisite() ) {
                
                if ( $wordpress_network ) {
                    $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );

                    foreach ( $blog_ids as $blog_id ) {
                        switch_to_blog( $blog_id );
                        $this->module_tables();
                        $this->create_module_data();
                    }

                    restore_current_blog();     
                } else {
                    $this->create_module_data();
                }
            } else {
                $this->create_module_data();
            }
        }

        public function create_module_data() {
                        
            $this->create_tables();
            $this->set_module_default_settings();
        }

        public function create_tables() {
            
			global $wpdb;
			
			$charset_collate = '';
		
			if ( !empty( $wpdb->charset ) )
				$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
			if ( !empty( $wpdb->collate ) )
				$charset_collate .= " COLLATE $wpdb->collate";	
				
			

			if ( $wpdb->get_var( "SHOW TABLES LIKE '$wpdb->fmeasl_stores'" ) != $wpdb->fmeasl_stores ) {
				$sql1 = "CREATE TABLE " . $wpdb->fmeasl_stores . " (
									 store_id int(25) NOT NULL auto_increment,
									 store_name varchar(255) NULL,
									 store_meta_title varchar(255) NULL,
									 store_meta_keywords text NULL,
									 store_meta_description text NULL,
									 store_description text NULL,
									 country varchar(255) NULL,
									 city varchar(255) NULL,
									 state varchar(255) NULL,
									 zip_code varchar(255) NULL,
									 address text NULL,
									 latitude varchar(255) NULL,
									 longitude varchar(255) NULL,
									 status varchar(255) NULL,
									 phone varchar(255) NULL,
									 fax varchar(255) NULL,
									 store_image varchar(255) NULL,
									 PRIMARY KEY (store_id)
									 ) $charset_collate;";

				require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
				dbDelta( $sql1 );
			}

            $slug = 'store-locator';
            $args = array(
              'name'        => $slug,
              'post_type'   => 'page',
              'post_status' => 'publish',
              'numberposts' => 1
            );
            $my_posts = get_posts($args);
            if( $my_posts ) {

            } else {
             
                $store_page = array(
                    'post_title' => 'Store Locator',
                    'post_content' => '[fme_advance_store_locator]',
                    'post_status' => 'publish',
                    'post_type' => 'page',
                );
                wp_insert_post( $store_page );
            }

			

			



		}

		public function set_module_default_settings() {
            
			$module_settings = get_option( 'fmeasl_settings' );
			if ( !$module_settings ) {
                update_option( 'fmeasl_settings', $this->module_default_settings );
			}
		}

		public function get_module_default_settings() {
            
            $module_default_settings = array (
                'page_title'         				=> __( 'Page Title', 'fmeasl' ),
                'meta_keywords'         			=> __( 'Meta Keywords', 'fmeasl' ),
                'meta_description'         			=> __( 'Meta Description', 'fmeasl' ),
                'page_heading'         				=> __( 'Page Heading', 'fmeasl' ),
                'page_sub_heading'         			=> __( 'Page Sub Heading', 'fmeasl' ),
                'page_title'         				=> __( 'Page Title', 'fmeasl' ),
                'text_get_direction_button'         => __( 'Get Direction Button Text', 'fmeasl' ),
                'text_header_link'         			=> __( 'Header Link Text', 'fmeasl' ),
                'text_footer_link'         			=> __( 'Footer Link Text', 'fmeasl' ),
                'standard_latitude'         		=> '0',
                'standard_longitude'         		=> '0',
                'api_key'         					=> '0',
                'marker_image'         				=> FMEASL_URL.'images/default_marker.png',
                'enable_marker_numbers'         	=> 'No',
                'enable_sidebar_markers'         	=> 'Yes',
                'map_zoom'         					=> '8',
                'map_distance'         				=> 'Km',
                'enable_search_by_address'         	=> 'Yes',
                'enable_header_link'         		=> 'Yes',
                'enable_footer_link'         		=> 'Yes'
            ); 
            
            return $module_default_settings;
		}

		public function get_module_settings() {
            
            $module_settings = get_option( 'fmeasl_settings' );

            //print_r($module_settings);

            if ( !$module_settings ) {
                update_option( 'fmeasl_settings', $this->module_default_settings );
                $module_settings = $this->module_default_settings;
            }

            return $module_settings;
        }  


        public function get_front_view() {
            
            $views = array (
                array (
                    'name' => __( 'Store Listing', 'fmeasl' ), 
                    'path' => FMEASL_PLUGIN_DIR . 'front/view/store.php'
                ), 
                 
                
            );
            
            return apply_filters( 'fmeasl_views', $views );
        }

        public function get_front_detail_view() {
            
            $views = array (
                
                array (
                    'name' => __( 'Store Details', 'fmeasl' ), 
                    'path' => FMEASL_PLUGIN_DIR . 'front/view/store_details.php'
                ), 
                
            );
            
            return apply_filters( 'fmeasl_views', $views );
        }


	}	

	$fmeasl = new FME_Advance_Store_Locator();
}

}

 


?>
