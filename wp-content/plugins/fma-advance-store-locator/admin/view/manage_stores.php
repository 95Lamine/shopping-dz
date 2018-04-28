<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
require_once FMEASL_PLUGIN_DIR . 'admin/class-manage-stores.php';

$manage_stores = new FME_List_Stores();
$manage_stores->prepare_items(); 



?>

<div id="fmeasl-store-overview" class="wrap">
    <h2><?php _e('Advance Store Locator'); ?></h2>
    <h3><?php _e('Manage Stores'); ?> 
	    <a class="add-new-h2" href="admin.php?page=fme-add-store">
	    	<?php _e('Add New'); ?>
	    </a>
    </h3>
    <div class="up">
        <form method="post">
            <?php $manage_stores->views() ?>
            <?php $manage_stores->search_box( 'Search Store', 'search_id' ); ?>
        </form>
    </div>
    <div class="errr">
        <?php settings_errors(); ?>
    </div>
    
    <form method="post">
        <?php $manage_stores->display(); ?>
    </form>
    
</div>

