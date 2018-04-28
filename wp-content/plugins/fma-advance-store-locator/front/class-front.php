<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( !class_exists( 'FMEASL_Front_Class' ) ) {

	class FMEASL_Front_Class extends FME_Advance_Store_Locator { 

		public function __construct() {          
			add_shortcode( 'fme_advance_store_locator', array( $this, 'show_store_locator' ) );
			add_action( 'wp_head', array( $this, 'add_meta_tags' ), 0);
			add_action('wp_head', array( $this, 'add_map_api' ), 7);
			add_action('wp_ajax_my_action', array( $this, 'search_product' ));
			if(isset($_GET['store_id']) && $_GET['store_id']!='') {
			}
            $this->module_settings = $this->get_module_settings();


             
		}

		public function show_store_locator() { 



           
            $store_list = $this->get_front_view();
            $store_details = $this->get_front_detail_view();
            if(isset($_GET['store_id']) && $_GET['store_id']!='') {
                echo "<style>.entry-header { display:none;}</style>";
            	include( $store_details[ absint( 0 ) ]['path'] ); 
            } else {
            	include( $store_list[ absint( 0 ) ]['path'] ); 
        	}
             
		}



		public function add_meta_tags() {
			echo '<title>'.$this->module_settings['page_title'].'</title>';
        	echo '<meta name="description" content="' . $this->module_settings['meta_description'] . '" />' . "\n";
        	echo '<meta name="keywords" content="' . $this->module_settings['meta_keywords'] . '" />' . "\n";
    	}

    	public function add_map_api() {
    		wp_enqueue_script( 'fme_script', 'http://maps.googleapis.com/maps/api/js?libraries=places,geometry&key='.$this->module_settings['api_key']);
			wp_enqueue_script( 'fme_script1', FMEASL_URL . 'front/js/ui/jquery.ui.map.js' );
			wp_enqueue_script( 'my-ajax-handle', 'the_ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
    	
            wp_enqueue_style( 'fme_css', FMEASL_URL . 'front/css/gmapstrlocator.css', false );
            wp_enqueue_script( 'fme_script2', FMEASL_URL . 'front/js/googlemarkerInfobox.js', false );
            wp_enqueue_script( 'fme_script3', FMEASL_URL . 'front/js/markerwithlabel.js', false );
            wp_enqueue_script( 'fme_script4', FMEASL_URL . 'front/js/jquery.tinyscrollbar.min.js', false );
        }

    	

    	public function get_stores() {

    		global $wpdb;

    		$result = $wpdb->get_results($wpdb->prepare( "SELECT * FROM ".$wpdb->fmeasl_stores." WHERE status = %d", '1'));

    		return $result;
			
    	}

    	

    	public function get_allstores() {

    		$data = array();
    		$stores = $this->get_stores();
    		foreach ($stores as $allstore) {
    			

			    $data[] = array(
				'store_id' => $allstore->store_id,
				'store_name' => $allstore->store_name,
				'address' => $allstore->address,
				'state' => $allstore->state,
				'city' => $allstore->city,
				'country' => $allstore->country,
				'zip_code' => $allstore->zip_code,
				'phone' => $allstore->phone,
				'fax' => $allstore->fax,
				'latitude' => $allstore->latitude,
				'longitude' => $allstore->longitude,
				'status' => $allstore->status,
				'store_image' => $allstore->store_image,
				'store_description' => html_entity_decode($allstore->store_description, ENT_QUOTES, 'UTF-8'),
				'href' => $allstore->store_id
			    );
    		}

    		return $data;
    	}

    	
    	

    	public function store_details($id)
    	{
    		global $wpdb;
    		$result = $wpdb->get_row( 
                $wpdb->prepare( "SELECT * FROM ".$wpdb->fmeasl_stores." WHERE store_id = %d", $id));
    		return $result;
    	}

    	

    	

	}

new FMEASL_Front_Class;

}

?>
