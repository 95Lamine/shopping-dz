<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div id="fmeasl-wrap" class="wrap fmeasl-settings">
    <h2><?php _e( 'Advance Store Locator Settings', 'fmeasl' ); ?></h2>
    <?php 
        global $wpdb;
        settings_errors();

        //print_r($this->module_settings);
    ?>

    <form id="fmeasl-settings-form" method="post" action="options.php" accept-charset="utf-8">
        <h2></h2>
        <ul id="info-nav">
            <li><a href="#general"><span><?php _e('General', 'fmeasl') ?></span></a></li>
            <li><a href="#data"><span><?php _e('Data', 'fmeasl'); ?></span></a></li>
        </ul>
        <div id="info">
            <div id="general" class="hide">
                <br /><br />
                <h3><?php _e('General', 'fmeasl'); ?></h3>
                <?php _e('Enter your settings below:', 'fmeasl'); ?>

                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row">
                                <?php _e('Page Title:','fmeasl'); ?>
                            </th>
                            <td>
                                <input type="text" value="<?php if($this->module_settings['page_title']!='') echo esc_attr( $this->module_settings['page_title'] ); ?>" name="fmeasl_module[page_title]" placeholder="<?php _e( 'Page Title', 'fmeasl' ); ?>" class="textinput" id="fmeasl-page-title" />
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <?php _e('Meta Keywords:','fmeasl'); ?>
                            </th>
                            <td>
                                <textarea name="fmeasl_module[meta_keywords]" class="textinput" rows="7" placeholder="<?php _e( 'Meta Keywords', 'fmeasl' ); ?>"><?php if($this->module_settings['meta_keywords']!='') echo esc_attr( $this->module_settings['meta_keywords'] ); ?></textarea> 
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <?php _e('Meta Description:','fmeasl'); ?>
                            </th>
                            <td>
                                <textarea name="fmeasl_module[meta_description]" class="textinput" rows="7" placeholder="<?php _e( 'Meta Description', 'fmeasl' ); ?>"><?php if($this->module_settings['meta_description']!='') echo esc_attr( $this->module_settings['meta_description'] ); ?></textarea> 
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <?php _e('Page Heading:','fmeasl'); ?>
                                <p class="description">(<?php _e('Main heading of the advance store locator page', 'fmeasl'); ?>)</p>
                            </th>
                            <td>
                                <input type="text" value="<?php if($this->module_settings['page_heading']!='') echo esc_attr( $this->module_settings['page_heading'] ); ?>" name="fmeasl_module[page_heading]" placeholder="<?php _e( 'Page Heading', 'fmeasl' ); ?>" class="textinput" id="fmeasl-page-heading" />
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <?php _e('Page Sub Heading:','fmeasl'); ?>
                                <p class="description">(<?php _e('Sub heading of the advance store locator page', 'fmeasl'); ?>)</p>
                            </th>
                            <td>
                                <input type="text" value="<?php if($this->module_settings['page_sub_heading']!='') echo esc_attr( $this->module_settings['page_sub_heading'] ); ?>" name="fmeasl_module[page_sub_heading]" placeholder="<?php _e( 'Page Sub Heading', 'fmeasl' ); ?>" class="textinput" id="fmeasl-page-sub-heading" />
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <?php _e('Get Direction Button Text:','fmeasl'); ?>
                                <p class="description">(<?php _e('Text for get direction button', 'fmeasl'); ?>)</p>
                            </th>
                            <td>
                                <input type="text" value="<?php if($this->module_settings['text_get_direction_button']!='') echo esc_attr( $this->module_settings['text_get_direction_button'] ); ?>" name="fmeasl_module[text_get_direction_button]" placeholder="<?php _e( 'Get Direction Button Text', 'fmeasl' ); ?>" class="textinput" id="fmeasl-button-get-direction" />
                            </td>
                        </tr>

                        

                    </tbody>
                </table>
            </div>
            <div id="data" class="hide">
                <br /><br />
                <h3><?php _e('Data', 'fmeasl'); ?></h3>
                <?php _e('Enter your settings below:', 'fmeasl'); ?>

                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row">
                                <?php _e('Standard Latitude:','fmeasl'); ?>
                            </th>
                            <td>
                                <input type="text" value="<?php if($this->module_settings['standard_latitude']!='') echo esc_attr( $this->module_settings['standard_latitude'] ); ?>" name="fmeasl_module[standard_latitude]" placeholder="<?php _e( 'Standard Latitude', 'fmeasl' ); ?>" class="textinput" id="fmeasl-standard-latitude" />
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <?php _e('Standard Longitude:','fmeasl'); ?>
                            </th>
                            <td>
                                <input type="text" value="<?php if($this->module_settings['standard_longitude']!='') echo esc_attr( $this->module_settings['standard_longitude'] ); ?>" name="fmeasl_module[standard_longitude]" placeholder="<?php _e( 'Standard Longitude', 'fmeasl' ); ?>" class="textinput" id="fmeasl-standard-longitude" />
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <?php _e('API Key:','fmeasl'); ?>
                                <p class="description">(<?php _e('Google Map API Key(v3)', 'fmeasl'); ?>)</p>
                            </th>
                            <td>
                                <input type="text" value="<?php if($this->module_settings['api_key']!='') echo esc_attr( $this->module_settings['api_key'] ); ?>" name="fmeasl_module[api_key]" placeholder="<?php _e( 'API Key', 'fmeasl' ); ?>" class="textinput" id="fmeasl-api-key" />
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <?php _e('Map Marker Image:','fmeasl'); ?>
                            </th>
                            <td>
                                <input type="text" name="fmeasl_module[marker_image]" id="new_img" value="<?php if($this->module_settings['marker_image']!='') echo esc_attr( $this->module_settings['marker_image'] ); ?>">
                                <a class="button" onclick="upload_image('new_img');">Upload Image</a>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <?php _e('Current Marker Image:','fmeasl'); ?>
                            </th>
                            <td>
                                <img src="<?php echo esc_attr( $this->module_settings['marker_image'] ); ?>" width="50" height="50" />
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <?php _e('Enable Marker Numbers:','fmeasl'); ?>
                            </th>
                            <td>
                                <select name="fmeasl_module[enable_marker_numbers]" class="textinput" id="fmeasl-enable-marker-numbers">
                                    <option value="Yes" <?php selected( $this->module_settings['enable_marker_numbers'] , 'Yes'); ?>>Yes</option>
                                    <option value="No" <?php selected( $this->module_settings['enable_marker_numbers'] , 'No'); ?>>No</option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <?php _e('Enable Sidebar Markers:','fmeasl'); ?>
                            </th>
                            <td>
                                <select name="fmeasl_module[enable_sidebar_markers]" class="textinput" id="fmeasl-enable-sidebar-markers">
                                    <option value="Yes" <?php selected( $this->module_settings['enable_sidebar_markers'] , 'Yes'); ?>>Yes</option>
                                    <option value="No" <?php selected( $this->module_settings['enable_sidebar_markers'] , 'No'); ?>>No</option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <?php _e('Map Zoom:','fmeasl'); ?>
                                <p class="description">(<?php _e('Enter digit for map zoom. i.e(6, 8, 11) etc', 'fmeasl'); ?>)</p>
                            </th>
                            <td>
                                <input type="text" value="<?php echo esc_attr( $this->module_settings['map_zoom'] ); ?>" name="fmeasl_module[map_zoom]" placeholder="<?php _e( 'Map Zoom', 'fmeasl' ); ?>" class="textinput" id="fmeasl-map-zoom" />
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <?php _e('Map Distance:','fmeasl'); ?>
                            </th>
                            <td>
                                <select name="fmeasl_module[map_distance]" class="textinput" id="fmeasl-map-distance">
                                    <option value="km" <?php selected( $this->module_settings['map_distance'] , 'Km'); ?>>Km</option>
                                    <option value="Mile" <?php selected( $this->module_settings['map_distance'] , 'Mile'); ?>>Mile</option>
                                </select>
                            </td>
                        </tr>

                        
                        <tr>
                            <th scope="row">
                                <?php _e('Enable Search By Address, Zip Code, State:','fmeasl'); ?>
                            </th>
                            <td>
                                <select name="fmeasl_module[enable_search_by_address]" class="textinput" id="fmeasl-enable-search-by-address">
                                    <option value="Yes" <?php selected( $this->module_settings['enable_search_by_address'] , 'Yes'); ?>>Yes</option>
                                    <option value="No" <?php selected( $this->module_settings['enable_search_by_address'] , 'No'); ?>>No</option>
                                </select>
                            </td>
                        </tr>

                        


                    </tbody>
                 </table>

            </div>
            <p class="submit">
                <input type="submit" value="<?php _e( 'Save Changes', 'fmeasl' ); ?>" class="button-primary" name="fmeasl-save-settings" id="fmeasl-save-settings">
            <?php settings_fields( 'fmeasl_settings' ); ?>
            </p>
        </div>
    </form>


</div>

<script type="text/javascript">
    jQuery(document).ready(function($){
      $( '#info #data' ).hide();
      
      $('#info-nav li').click(function(e) {
        $('#info .hide').hide();
        $('#info-nav .current').removeClass("current");
        $(this).addClass('current');
        
        var clicked = $(this).find('a:first').attr('href');
        $('#info ' + clicked).fadeIn('fast');
        e.preventDefault();
      }).eq(0).addClass('current');
    });

</script>
