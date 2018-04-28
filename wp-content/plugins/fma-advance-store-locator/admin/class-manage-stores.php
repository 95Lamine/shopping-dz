<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ( !class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
if ( !class_exists( 'Advance_Store_Locator_Admin' ) ) {
    require_once FMEASL_PLUGIN_DIR . 'admin/class-advance-store-locator-admin.php';
}

class FME_List_Stores extends WP_List_Table {
    private $_per_page;
    function __construct(){
        global $status, $page;
                
        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'store',     //singular name of the listed records
            'plural'    => 'stores',    //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ) );
        
        $this->_per_page = $this->get_per_page();

            
    }




    function get_per_page() {
        
        $user     = get_current_user_id();
        $screen   = get_current_screen();
        $option   = $screen->get_option( 'per_page', 'option' );
        $per_page = get_user_meta( $user, $option, true );
        
        if ( empty( $per_page ) || $per_page < 1 ) {
            $per_page = $screen->get_option( 'per_page', 'default' );
        }
        
        return $per_page;
    }

    function no_items() {
        _e( 'No store found', 'fmeasl' );
    }

    function column_default($item, $column_name){ 
        switch($column_name){
            case 'thumb':
            return "<a href='?page=".$_REQUEST['page']."&action=edit&store_id=".$item->store_id."'><img src='".$item->store_image."' width='100'>";
            case 'store_name':
            return $item->store_name;
            case 'country':
            return $item->country;
            case 'city':
            return $item->city;
            case 'address':
            return $item->address;
            case 'status':
                return ( $item->status ) ? __( 'Active', 'fmeasl' ) : __( 'Inactive', 'fmeasl' );
            default:
                return $item->store_id;
        }

    }

    function ed($id)
    {
        $data = $this->getStore($id);
        if(isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'excerpt')
        {
            return substr($data->store_description,0,100);
        } 
        elseif(isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'list')
        {
            return '';
        }
        else
        {
            return '';
        }
    }

    function column_store_name($item){
        
        //Build row actions
        $actions = array(
            'edit'      => sprintf('<a href="?page=%s&action=%s&store_id=%s">Edit</a>',$_REQUEST['page'],'edit',$item->store_id),
            'quick_edit'    => sprintf('<a href="#" class="fmeasl_qedit">Quick Edit</a>
                <input name="store_id" type="hidden" value="' . $item->store_id . '" />
                <input name="qedit_nonce" type="hidden" value="' . wp_create_nonce( 'qedit_nonce_'.$item->store_id ) . '" />
            ',$_REQUEST['page'],'quick_edit',$item->store_id),
            'delete'    => sprintf('<a href="?page=%s&action=%s&store_id=%s&delete_nonce" class="fmeasl_del">Delete</a>
                <input name="store_id" type="hidden" value="' . $item->store_id . '" />
                <input name="delete_nonce" type="hidden" value="' . wp_create_nonce( 'delete_nonce_'.$item->store_id ) . '" />
            ',$_REQUEST['page'],'delete',$item->store_id),
            'view'    => sprintf('<a href="'.get_site_url().'/index.php/g-map-store-locator/?store_id=%s">View</a>',$item->store_id),
        );


        
        //Return the title contents
        return sprintf('<strong><a href="?page='.$_REQUEST['page'].'&action=edit&store_id='.$item->store_id.'">%1$s</a></strong><br />
            <span style="color:silver"></span>%3$s
            <span style="color:silver"></span>%4$s',
            /*$1%s*/ $item->store_name,
            /*$2%s*/ $item->store_id,
            $this->ed($item->store_id),
            /*$3%s*/ $this->row_actions($actions)
        );
    }

    function column_cb($item){
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            /*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("movie")
            /*$2%s*/ $item->store_id                //The value of the checkbox should be the record's id
        );
    }

    function get_sortable_columns() {
        
        $sortable_columns = array(
            'store_name'   => array( 'store_name', false ),
            'country'   => array( 'country', false ),
            'city'   => array( 'city', false ),
            'address'   => array( 'address', false )
            
        );

        return $sortable_columns;
    }

    function get_columns() {
        
        $columns = array(
            'cb'      => '<input type="checkbox" />',
            'thumb'   => "<span class='wc-image tips'></span>",
            'store_name'   => __( 'Store Name', 'fmeasl' ),
            'country'   => __( 'Country', 'fmeasl' ),
            'city'   => __( 'City', 'fmeasl' ),
            'address'   => __( 'Address', 'fmeasl' ),
            'status'  => __( 'Status', 'fmeasl' )
        );

        return $columns;
    }


    function get_bulk_actions() {
        
        $actions = array(
            'delete'     => __( 'Delete', 'wpsl' ),
            'activate'   => __( 'Activate', 'wpsl' ),
            'deactivate' => __( 'Deactivate', 'wpsl' )
        );

        return $actions;
    }
    protected function getAllStores() {
         global $wpdb;

         $result = $wpdb->get_var( "SELECT COUNT(*) AS count FROM $wpdb->fmeasl_stores" );      

         return $result;
    }

    protected function getAllPublished() {
         global $wpdb;

         $result = $wpdb->get_var( "SELECT COUNT(*) AS count, status FROM $wpdb->fmeasl_stores WHERE status = 1" );      

         return $result;
    }

    protected function getAllTrash() {
         global $wpdb;

         $result = $wpdb->get_var( "SELECT COUNT(*) AS count, status FROM $wpdb->fmeasl_stores WHERE status = 0" );      

         return $result;
    }


    function get_views(){
       $views = array();
       $current = ( !empty($_REQUEST['status']) ? $_REQUEST['status'] : 'all');

       //All link
       $class = ($current == 'all' ? ' class="current"' :'');
       $all_url = remove_query_arg('status');
       $views['all'] = "<a href='{$all_url }' {$class} >All <span class='count'>(".$this->getAllStores().")</span></a>";

       //Foo link
       $foo_url = add_query_arg('status','active');
       $class = ($current == 'active' ? ' class="current"' :'');
       $views['active'] = "<a href='{$foo_url}' {$class} >Active <span class='count'>(".$this->getAllPublished().")</span></a>";

       //Bar link
       $bar_url = add_query_arg('status','inactive');
       $class = ($current == 'inactive' ? ' class="current"' :'');
       $views['inactive'] = "<a href='{$bar_url}' {$class} >Inactive <span class='count'>(".$this->getAllTrash().")</span></a>";

       return $views;
    }



    protected function view_switcher( $current_mode ) {
?>
        <input type="hidden" name="mode" value="<?php echo esc_attr( $current_mode ); ?>" />
        <div class="view-switch">
<?php
            foreach ( $this->modes as $mode => $title ) {
                $classes = array( 'view-' . $mode );
                if ( $current_mode == $mode )
                    $classes[] = 'current';
                printf(
                    "<a href='%s' class='%s' id='view-switch-$mode'><span class='screen-reader-text'>%s</span></a>\n",
                    esc_url( add_query_arg( 'mode', $mode ) ),
                    implode( ' ', $classes ),
                    $title
                );
            }
        ?>
        </div>
<?php

    }



    function update_store_status( $store_ids, $status ) { 
        
        global $wpdb;

        if ( $status === 'deactivate' ) {
            $active_status       = 0;
            $success_action_desc = __( 'deactivated', 'fmeasl' );
            $fail_action_desc    = __( 'deactivating', 'fmeasl' );
        } else {
            $active_status       = 1;
            $success_action_desc = __( 'activated', 'fmeasl' );
            $fail_action_desc    = __( 'activating', 'fmeasl' );
        }
        
        $result = $wpdb->query( $wpdb->prepare( "UPDATE $wpdb->fmeasl_stores SET status = %d WHERE store_id IN ( $store_ids )", $active_status ) );    
        
        if ( $result === false ) {
            $state = 'error';
            $msg = sprintf( __( 'There was a problem %s the Store(s), please try again.', 'fmeasl' ), $fail_action_desc );

        } else {
            $state = 'updated';
            $msg = sprintf( __( 'Store(s) successfully %s.', 'fmeasl' ), $success_action_desc );
        } 
        
        add_settings_error ( 'bulk-state', esc_attr( 'bulk-state' ), $msg, $state );
    }
    

    function remove_stores( $store_ids ) {

        global $wpdb;

        $result = $wpdb->query( "DELETE FROM $wpdb->fmeasl_stores WHERE store_id IN ( $store_ids )" );
        
        if ( $result === false ) {
            $state = 'error';
            $msg   = __( 'There was a problem removing the Store(s), please try again.', 'fmeasl' );
        } else {
            $state = 'updated';
            $msg   = __( 'Store(s) successfully removed.' , 'fmeasl' );
        } 
        
        add_settings_error ( 'bulk-remove', esc_attr( 'bulk-remove' ), $msg, $state );
    }
    

    function process_bulk_action() {
        
        if ( !current_user_can( apply_filters( 'fmeasl_capability', 'manage_options' ) ) )
            die( '-1' );
        
        if ( isset( $_POST['_wpnonce'] ) && ! empty( $_POST['_wpnonce'] ) ) {
            $nonce  = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );
            $action = 'bulk-' . $this->_args['plural'];

            if ( !wp_verify_nonce( $nonce, $action ) )
                wp_die( 'Nope! Security check failed!' );
            
            $action = $this->current_action();

            /* If an action is set continue, otherwise reload the page */
            if ( !empty( $action ) ) {
                $id_list = array();

                foreach ( $_POST['store'] as $store_id ) {
                    $id_list[] = $store_id;
                }

                /* Before checking which type of bulk action to run, we make sure we actually have some ids to process */
                if ( !empty( $id_list ) ) {
                    $store_ids = esc_sql( implode( ',', wp_parse_id_list( $id_list ) ) );

                    switch ( $action ) {
                        case 'activate':
                            $this->update_store_status( $store_ids, 'activate' );
                            break;
                        case 'deactivate':
                            $this->update_store_status( $store_ids, 'deactivate' );
                            break;                 
                         case 'delete':
                            $this->remove_stores( $store_ids );
                            break;                
                    }   
                }
            }
        }
    }
    


    function get_store_list() { 
        
        global $wpdb;
        
        $total_items = 0;
        if(isset($_REQUEST['status']) && $_REQUEST['status']=='active')
        {
            $status = 1;
        }
        if(isset($_REQUEST['status']) && $_REQUEST['status']=='inactive')
        {
            $status = 0;
        } else {
            $status = 1;
        } 
        //$this->_per_page = 20;
                
        if ( isset( $_POST['s'] ) && ( !empty( $_POST['s'] ) ) ) {
            $search = trim( $_POST['s'] );
            $result = $wpdb->get_results( 
                            $wpdb->prepare( "SELECT store_id, store_name, store_image, country, city, address, status
                                             FROM $wpdb->fmeasl_stores
                                             WHERE status = $status AND store_name LIKE %s", 
                                             '%' . like_escape( $search ). '%', '%' . like_escape( $search ). '%', '%' . like_escape( $search ). '%', '%' . like_escape( $search ). '%', '%' . like_escape( $search ). '%'
                                          ) 
                            );
        } else {
            $orderby   = !empty ( $_GET["orderby"] ) ? esc_sql( $_GET["orderby"] ) : 'store_name';
            $order     = !empty ( $_GET["order"] ) ? esc_sql( $_GET["order"] ) : 'ASC';
            $order_sql = $orderby.' '.$order; 

            $total_items = $wpdb->get_var( "SELECT COUNT(*) AS count, status FROM $wpdb->fmeasl_stores WHERE status = $status" );
            $paged       = !empty ( $_GET["paged"] ) ? esc_sql( $_GET["paged"] ) : '';
            
            if ( empty( $paged ) || !is_numeric( $paged ) || $paged <= 0 ) { 
                $paged = 1; 
            }

            $totalpages = ceil( $total_items / $this->_per_page );
            
            if ( !empty( $paged ) && !empty( $this->_per_page ) ){
                $offset    = ( $paged - 1 ) * $this->_per_page;
                $limit_sql = (int)$offset.',' . (int)$this->_per_page;
            }
            
            $result = $wpdb->get_results( "SELECT store_id, store_name, store_image, country, city, address, status FROM ".$wpdb->fmeasl_stores." WHERE status = $status ORDER BY $order_sql LIMIT $limit_sql" );
        }

        
        $i = 0;
        foreach ( $result as $k => $store_details ) {
            
            
            $i++;
        }
        
        $response = array(
            "data"  => stripslashes_deep( $result ),
            "count" => $total_items
        );
        
        return $response;
    }   

    function prepare_items() {
        
        $columns  = $this->get_columns();
        $hidden   = array();
        $sortable = $this->get_sortable_columns();
        
        $this->process_bulk_action();        
        $response = $this->get_store_list();

        //echo "<pre>"; print_r($response); echo "</pre>";

        $current_page = $this->get_pagenum();
        $total_items  = $response['count'];
        //Retrieve $customvar for use in query to get items.
        $view = ( isset($_REQUEST['status']) ? $_REQUEST['status'] : 'all');
        
        
        $this->set_pagination_args( array(
            'total_items' => $total_items,
            'per_page'    => $this->_per_page,
            'total_pages' => ceil( $total_items / $this->_per_page ) 
        ) );

        $this->items = $response['data'];
        $this->_column_headers = array( $columns, $hidden, $sortable );       
    }



    public function display_rows_or_placeholder() {
        if ( $this->has_items() ) {
            $this->display_rows();

        } else {
            echo '<tr class="no-items"><td class="colspanchange" colspan="' . $this->get_column_count() . '">';
            $this->no_items();
            echo '</td></tr>';
        }
    }

    protected function getStore($id)
        {
            global $wpdb;
            $result = $wpdb->get_row( 
                            $wpdb->prepare( "SELECT * FROM $wpdb->fmeasl_stores 
                                WHERE store_id = %d", $id
                                          )
                            );

            return $result; 
        }

    public function single_row( $item ) { 
        echo '<tr class="qes2" id=fmeasl-wrrap'.$item->store_id.'>';
            $this->single_row_columns( $item );
        echo '</tr>';
            $store = $this->getStore($item->store_id);
            $cc = new Advance_Store_Locator_Admin();
            $countries = $cc->my_add_country_select();
        echo '<tr class="qes inline-edit-row inline-edit-row-page inline-edit-store quick-edit-row quick-edit-row-page inline-edit-store inline-editor" id="fmeasl-wrap'.$item->store_id.'" style="display:none;">
            <td class="colspanchange" style="width:987px; float:left;">
                <div id="" class="qe">
                    <fieldset class="inline-edit-col-left">
                      <div class="inline-edit-col">
                        <h4>QUICK EDIT</h4>
                        <label>
                            <span class="title">Name</span>
                            <span class="input-text-wrap s_name'.$store->store_id.'">
                                <input type="text" value="'.$store->store_name.'" class="ptitle" name="store_name">
                            </span>
                        </label>

                        <label>
                            <span class="title">Country</span>
                            <span class="input-text-wrap s_country'.$store->store_id.'">
                                <select name="country">
                                    <option value="">Select Country</option>'; ?>
                                    <?php foreach ($countries as $country) { ?>
                                       <option value="<?php echo $country; ?>" <?php selected($store->country, $country); ?>><?php echo $country; ?></option>
                                    <?php } ?>
                                <?php echo '</select>
                            </span>
                        </label>

                        <label>
                            <span class="title">City</span>
                            <span class="input-text-wrap s_city'.$store->store_id.'">
                                <input type="text" value="'.$store->city.'" class="ptitle" name="city">
                            </span>
                        </label>

                        <label>
                            <span class="title">State</span>
                            <span class="input-text-wrap s_state'.$store->store_id.'">
                                <input type="text" value="'.$store->state.'" class="ptitle" name="state">
                            </span>
                        </label>

                      </div>  
                    </fieldset>


                    <fieldset class="inline-edit-col-right">
                        <div class="inline-edit-col">
                            <label>
                                <span class="title">Zip Code</span>
                                <span class="input-text-wrap s_zip_code'.$store->store_id.'">
                                    <input type="text" value="'.$store->zip_code.'" class="ptitle" name="zip_code">
                                </span>
                            </label>

                            <label>
                                <span class="title">Address</span>
                                <span class="input-text-wrap s_address'.$store->store_id.'">
                                    <input type="text" value="'.$store->address.'" class="ptitle" name="address">
                                </span>
                            </label>

                            <label>
                                <span class="title">Latitude</span>
                                <span class="input-text-wrap s_latitude'.$store->store_id.'">
                                    <input type="text" value="'.$store->latitude.'" class="ptitle" name="latitude">
                                </span>
                            </label>

                            <label>
                                <span class="title">Longitude</span>
                                <span class="input-text-wrap s_longitude'.$store->store_id.'">
                                    <input type="text" value="'.$store->longitude.'" class="ptitle" name="longitude">
                                </span>
                            </label>

                        </div>
                    </fieldset>


                    <p class="submit inline-edit-save">
                        <a class="button-secondary cancel alignleft" href="#inline-edit">Cancel</a>
                        <input type="hidden" value="'.$store->store_id.'" class="ptitle" name="store_id">
                        <a class="button-primary save alignright" href="#inline-edit">Update</a>
                            <span class="spinner"></span>
                        <br class="clear">
                    </p>

                </div>
            </td>
        </tr>';
    }

    protected function extra_tablenav( $which ) {
        $mode = ( isset($_REQUEST['mode']) ? $_REQUEST['mode'] : 'list');
        $this->view_switcher($mode);
    }

   function display() {
        $singular = $this->_args['singular'];

        $this->display_tablenav( 'top' );
        
	?>
        <table class="wp-list-table <?php echo implode( ' ', $this->get_table_classes() ); ?>" cellspacing="0">
                <thead>
                <tr>
                        <?php $this->print_column_headers(); ?>
                </tr>
                </thead>

                <tfoot>
                <tr>
                        <?php $this->print_column_headers( false ); ?>
                </tr>
                </tfoot>

                <tbody id="the-list"<?php if ( $singular ) echo " data-wp-lists='list:$singular'"; ?>>
                        <?php $this->display_rows_or_placeholder(); ?>
                        
                </tbody>

        </table>
        <div id="fmeasl-delete-confirmation">
            <p><?php _e( 'Are you sure you want to delete this store?', 'fmeasl' ); ?></p>
            <p>
                <input class="button-primary" type="submit" name="delete" value="<?php _e( 'Delete', 'fmeasl' ); ?>" />
                <input class="button-secondary dialog-cancel" type="reset" value="<?php _e( 'Cancel', 'fmeasl' ); ?>" />
            </p>
		</div>
        <?php
            $this->display_tablenav( 'bottom' );
    }

    /**
     * Send required variables to JavaScript land
     */
    function _js_vars() {

        $args = array(
            'url'    => fMEASL_URL
        );

        printf( "<script type='text/javascript'>var fmeasl_data = %s;</script>\n", json_encode( $args ) );
    }
    
}
