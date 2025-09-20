<?php
if ( ! current_user_can( 'manage_options' ) ) {
  return;
}
//Get the active tab from the $_GET param
$default_tab = null;
$tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;
?>
<?php
/* Process import file */
if (isset($_POST['import'])) {
    $csv_file = ($_FILES['csv_file']) ? $_FILES['csv_file'] : '';
    if(!empty($csv_file['tmp_name']))
    {
        $csv_to_array = array_map('str_getcsv', file($csv_file['tmp_name']));
        if (is_array($csv_file)) {
          foreach ($csv_to_array as $key => $value) {
            if ($key == 0) {
              $filetmp = $csv_file['tmp_name'];
              if (($handle = fopen($filetmp, "r")) !== FALSE) {
                $flag = true;
                $totallocations = explode("\n",file_get_contents($filetmp));
                $count = count( $totallocations );
              // unset($songs);
                echo esc_html__( "Total item count: ", "custom-store-locator" ) . ' ' . esc_attr($count) . '<BR />';
                // typical entry: If You Have To Ask,Red Hot Chili Peppers,0:03:37, Rock & Alternative,1991,on
                // using a generous 1000 length - will lowering this actually impact performance in terms of memory allocation?
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                  // Skip the first entry in the csv containing colmn info
                  if($flag) {
                    $flag = false; 
                    echo "<BR />"; 
                    $count--; 
                    continue; 
                  }
                  // insert the current post and relevant info into the database
                  $currently_processed = process_custom_post($data, $count);
                  $count--;
                }
                echo  esc_html__( "Done! ", "custom-store-locator" );
                fclose($handle);
              }
              unlink($filetmp); // delete the temp csv file
            }
          }
      }
  }
} 
/* End of Process import file */
/* Add location from imported csv file */
function process_custom_post($locations, $count) {
  global $wpdb;
  // Prepare and insert the custom post
  $location_title = (array_key_exists(0, $locations) && $locations[0] != "" ? $locations[0] : 'N/A');
  $custom_post = array();
  $custom_post['post_type'] = 'csl_locations';
  $custom_post['post_status'] = 'publish';
  $custom_post['post_title'] = $location_title;
  printf(
      /* translators: 1: Name of a city 2: ZIP code */
      esc_html__('Importing %1$s, <i> ( %2$s locations remaining)...</i><BR />', 'custom-store-locator'),
      esc_attr($location_title),
      esc_attr($count)
  );
  // Check if post exists
  $post_id = post_exists($location_title);
  if (!$post_id) {
      $post_id = wp_insert_post($custom_post);
  }
  // Prepare and insert the custom post meta using WordPress functions (add_post_meta/update_post_meta)
  $meta_keys = array(
      'websiteurl' => (array_key_exists(1, $locations) && $locations[1] != "" ? $locations[1] : 'N/A'),
      'business_phone_number' => (array_key_exists(2, $locations) && $locations[2] != "" ? $locations[2] : 'N/A'),
      'business_fax' => (array_key_exists(3, $locations) && $locations[3] != "" ? $locations[3] : 'N/A'),
      'business_contact_email' => (array_key_exists(4, $locations) && $locations[4] != "" ? $locations[4] : 'N/A'),
      'business_address' => (array_key_exists(5, $locations) && $locations[5] != "" ? $locations[5] : 'N/A'),
      'business_zip_code' => (array_key_exists(6, $locations) && $locations[6] != "" ? $locations[6] : ''),
      'business_latitude' => (array_key_exists(7, $locations) && $locations[7] != "" ? $locations[7] : ''),
      'business_longitude' => (array_key_exists(8, $locations) && $locations[8] != "" ? $locations[8] : ''),
      'business_storehours' => (array_key_exists(9, $locations) && $locations[9] != "" ? $locations[9] : ''),
      'business_category' => (array_key_exists(10, $locations) && $locations[10] != "" ? $locations[10] : '')
  );
  // Add or update post meta
  foreach ($meta_keys as $key => $value) {
      update_post_meta($post_id, $key, $value);
  }
  // Handling the taxonomy (business categories)
  $business_categories = explode(', ', $meta_keys['business_category']);
  $taxonomy = 'csl_locations_categories';
  if (!empty($business_categories)) {
      $csl_business_cats = array();
      foreach ($business_categories as $business_cat) {
          $csl_term = term_exists($business_cat, $taxonomy);
          if (!$csl_term) {
              $csl_term = wp_insert_term($business_cat, $taxonomy);
          }
          if (is_array($csl_term)) {
              $csl_business_cats[] = $csl_term['term_id'];
          }
      }
      if (!empty($csl_business_cats)) {
          wp_set_post_terms($post_id, $csl_business_cats, $taxonomy);
      }
  }
  return true;
}
/* End of Add location from imported csv file */
?>
<div class="wrap">
<h1><?php esc_html_e( 'Custom Store Locator Settings', 'custom-store-locator' ); ?></h1> 
<!-- Here are our tabs -->
<nav class="nav-tab-wrapper">
    <a href="?page=store_plugin_settings" class="nav-tab <?php if($tab===null):?>nav-tab-active<?php endif; ?>"><?php esc_html_e( 'General', 'custom-store-locator' ); ?></a>
    <a href="?page=store_plugin_settings&tab=fields" class="nav-tab <?php if($tab==='fields'):?>nav-tab-active<?php endif; ?>"><?php esc_html_e( 'Field Settings', 'custom-store-locator' ); ?></a>
    <a href="?page=store_plugin_settings&tab=import" class="nav-tab <?php if($tab==='import'):?>nav-tab-active<?php endif; ?>"><?php esc_html_e( 'Import', 'custom-store-locator' ); ?></a>
    <a href="?page=store_plugin_settings&tab=appearance" class="nav-tab <?php if($tab==='appearance'):?>nav-tab-active<?php endif; ?>"><?php esc_html_e( 'Appearance', 'custom-store-locator' ); ?></a>
</nav>
<div class="tab-content">
  <?php switch($tab) :
    case 'import':
    ?>
    <h2><?php esc_html_e( 'Import Locations', 'custom-store-locator' ); ?> </h2>
    <?php
    $samplecsvfile = '' . CSL_URL . '/templates/sample-locations.csv';
    ?>
    <p>
    <?php
    if (!empty($samplecsvfile)) {
        printf(
            /* translators: %s: Link to the sample CSV file */
            esc_html__('You can import location using a CSV file. You can download the sample CSV file from %s.', 'custom-store-locator'),
            '<a href="' . esc_url($samplecsvfile) . '" target="_blank">' . esc_html__('here', 'custom-store-locator') . '</a>'
        );
    }
    ?>
    </p>
    <?php
    echo '<form action="" method="post" enctype="multipart/form-data">';
    echo '<input type="file" name="csv_file">';
    echo '<input type="submit" class="button-primary" name="import" value="Import">';
    echo '</form>';
    break;
    case 'fields':
    ?>
      <h2><?php esc_html_e( 'Field Settings', 'custom-store-locator' ); ?>  </h2>
      <form method="post" action="options.php" enctype="multipart/form-data">
      <?php settings_fields( 'csl_options_group' );  
      $csl_hide_phone = esc_js(get_option('csl_hide_phone'));
      $csl_hide_email = esc_js(get_option('csl_hide_email'));
      $csl_hide_fax = esc_js(get_option('csl_hide_fax'));
      $csl_hide_website = esc_js(get_option('csl_hide_website'));
      $csl_hide_hours = esc_js(get_option('csl_hide_hours'));
      ?>
      <table class="form-table" role="presentation">
      <tr>
      <th scope="row"><label for="csl_hide_phone"><?php esc_html_e( 'Hide Phone Number', 'custom-store-locator' ); ?></label></th>
      <td><input type="checkbox" id="csl_hide_phone" name="csl_hide_phone" value="yes" <?php if($csl_hide_phone == 'yes' ) { echo 'checked'; } ?> /></td>
      </tr>
      <tr>
      <th scope="row"><label for="csl_hide_email"><?php esc_html_e( 'Hide Email', 'custom-store-locator' ); ?></label></th>
      <td><input type="checkbox" id="csl_hide_email" name="csl_hide_email" value="yes" <?php if($csl_hide_email == 'yes' ) { echo 'checked'; } ?> /></td>
      </tr>
      <tr>
      <th scope="row"><label for="csl_hide_fax"><?php esc_html_e( 'Hide Fax Number', 'custom-store-locator' ); ?></label></th>
      <td><input type="checkbox" id="csl_hide_fax" name="csl_hide_fax" value="yes" <?php if($csl_hide_fax == 'yes' ) { echo 'checked'; } ?> /></td>
      </tr>
      <tr>
      <th scope="row"><label for="csl_hide_website"><?php esc_html_e( 'Hide Website', 'custom-store-locator' ); ?></label></th>
      <td><input type="checkbox" id="csl_hide_website" name="csl_hide_website" value="yes" <?php if($csl_hide_website == 'yes' ) { echo 'checked'; } ?> /></td>
      </tr>
      <tr>
      <th scope="row"><label for="csl_hide_hours"><?php esc_html_e( 'Hide Store Hours', 'custom-store-locator' ); ?></label></th>
      <td><input type="checkbox" id="csl_hide_hours" name="csl_hide_hours" value="yes" <?php if($csl_hide_hours == 'yes' ) { echo 'checked'; } ?> /></td>
      </tr>
      </table>
      <input type="hidden" name="csl_primary_color" value="<?php echo esc_js(get_option('csl_primary_color')); ?>" />
      <input type="hidden" name="csl_secondary_color" value="<?php echo esc_js(get_option('csl_secondary_color')); ?>" />
      <input type="hidden" name="csl_map_default_radius" value="<?php echo esc_js(get_option('csl_map_default_radius')); ?>" />
      <input type="hidden" name="csl_map_type" value="<?php echo esc_js(get_option('csl_map_type')); ?>" />
      <input type="hidden" name="csl_custom_map_marker" value="<?php echo esc_js(get_option('csl_custom_map_marker')); ?>" />
      <input type="hidden" name="csl_location_default_sorting" value="<?php echo esc_js(get_option('csl_location_default_sorting')); ?>" />
      <input type="hidden" name="csl_map_layout" value="<?php echo esc_js(get_option('csl_map_layout')); ?>" />
      <input type="hidden" name="csl_fullwidth_include_loc" value="<?php echo esc_js(get_option('csl_fullwidth_include_loc')); ?>" />
      <input type="hidden" name="csl_autocompletesearchbox" value="<?php echo esc_js(get_option('csl_autocompletesearchbox')); ?>" />
      <input type="hidden" name="csl_country_restriction" value="<?php echo esc_js(get_option('csl_country_restriction')); ?>" />
      <input type="hidden" name="csl_map_api_key" value="<?php echo esc_js(get_option('csl_map_api_key')); ?>" />
      <input type="hidden" name="csl_distance_units" value="<?php echo esc_js(get_option('csl_distance_units')); ?>" />
      <input type="hidden" name="csl_include_cat" value="<?php echo esc_js(get_option('csl_include_cat')); ?>" />
	  <input type="hidden" name="csl_include_title" value="<?php echo esc_js(get_option('csl_include_title')); ?>" />
      <input type="hidden" name="csl_disable_clustermarker" value="<?php echo esc_js(get_option('csl_disable_clustermarker')); ?>" />
      <input type="hidden" name="csl_map_default_zoom" value="<?php echo esc_js(get_option('csl_map_default_zoom')); ?>" />
      <?php submit_button(); ?>
    </form>
    <?php
    break;
    case 'appearance':
    ?>
      <h2><?php esc_html_e( 'Appearance Settings', 'custom-store-locator' ); ?>  </h2>
      <form method="post" action="options.php" enctype="multipart/form-data">
      <?php settings_fields( 'csl_options_group' );  
      $csl_primary_color = esc_js(get_option('csl_primary_color'));
      $csl_secondary_color = esc_js(get_option('csl_secondary_color'));
      ?>
      <table class="form-table" role="presentation">      
      <tr>
      <th scope="row"><label for="csl_primary_color"><?php esc_html_e( 'Primary Color', 'custom-store-locator' ); ?></label></th>
      <td><input type="hidden" id="csl_primary_color" name="csl_primary_color" value="<?php if($csl_primary_color) { echo esc_attr($csl_primary_color); } else { echo ""; } ?>" /><div class="csl_primary_color_picker"></div></td>
      </tr>
      <tr>
      <th scope="row"><label for="csl_secondary_color"><?php esc_html_e( 'Secondary Color', 'custom-store-locator' ); ?></label></th>
      <td><input type="hidden" id="csl_secondary_color" name="csl_secondary_color" value="<?php if($csl_secondary_color) { echo esc_attr($csl_secondary_color); } else { echo ''; } ?>" /><div class="csl_secondary_color_picker"></div></td>
      </tr>
      </table>

      <input type="hidden" name="csl_hide_phone" value="<?php echo esc_js(get_option('csl_hide_phone')); ?>" />
      <input type="hidden" name="csl_hide_email" value="<?php echo esc_js(get_option('csl_hide_email')); ?>" />
      <input type="hidden" name="csl_hide_fax" value="<?php echo esc_js(get_option('csl_hide_fax')); ?>" />
      <input type="hidden" name="csl_hide_website" value="<?php echo esc_js(get_option('csl_hide_website')); ?>" />
      <input type="hidden" name="csl_hide_hours" value="<?php echo esc_js(get_option('csl_hide_hours')); ?>" />
      <input type="hidden" name="csl_map_default_radius" value="<?php echo esc_js(get_option('csl_map_default_radius')); ?>" />
      <input type="hidden" name="csl_map_type" value="<?php echo esc_js(get_option('csl_map_type')); ?>" />
      <input type="hidden" name="csl_custom_map_marker" value="<?php echo esc_js(get_option('csl_custom_map_marker')); ?>" />
      <input type="hidden" name="csl_location_default_sorting" value="<?php echo esc_js(get_option('csl_location_default_sorting')); ?>" />
      <input type="hidden" name="csl_map_layout" value="<?php echo esc_js(get_option('csl_map_layout')); ?>" />
      <input type="hidden" name="csl_fullwidth_include_loc" value="<?php echo esc_js(get_option('csl_fullwidth_include_loc')); ?>" />
      <input type="hidden" name="csl_autocompletesearchbox" value="<?php echo esc_js(get_option('csl_autocompletesearchbox')); ?>" />
      <input type="hidden" name="csl_country_restriction" value="<?php echo esc_js(get_option('csl_country_restriction')); ?>" />
      <input type="hidden" name="csl_map_api_key" value="<?php echo esc_js(get_option('csl_map_api_key')); ?>" />
      <input type="hidden" name="csl_distance_units" value="<?php echo esc_js(get_option('csl_distance_units')); ?>" />
      <input type="hidden" name="csl_include_cat" value="<?php echo esc_js(get_option('csl_include_cat')); ?>" />
	  <input type="hidden" name="csl_include_title" value="<?php echo esc_js(get_option('csl_include_title')); ?>" />
      <input type="hidden" name="csl_disable_clustermarker" value="<?php echo esc_js(get_option('csl_disable_clustermarker')); ?>" />
      <input type="hidden" name="csl_map_default_zoom" value="<?php echo esc_js(get_option('csl_map_default_zoom')); ?>" />
      <?php submit_button(); ?>
    </form>
    <?php
    break;
    default:
    ?>
    <h2><?php esc_html_e( 'General', 'custom-store-locator' ); ?>  </h2>
    <form method="post" action="options.php" enctype="multipart/form-data">
      <?php settings_fields( 'csl_options_group' ); 
      $csl_map_default_radius = get_option('csl_map_default_radius');
      $csl_map_type = get_option('csl_map_type');
      $csl_custom_map_marker = get_option('csl_custom_map_marker');
      $csl_include_cat = get_option('csl_include_cat');
	  $csl_include_title = get_option('csl_include_title');
      $csl_location_default_sorting = get_option('csl_location_default_sorting');
      $csl_map_layout = get_option('csl_map_layout');
      $csl_fullwidth_include_loc = get_option('csl_fullwidth_include_loc');
      $csl_autocompletesearchbox = get_option('csl_autocompletesearchbox');
      $csl_country_restriction = get_option('csl_country_restriction');
      $csl_map_api_key = get_option('csl_map_api_key');
      $csl_distance_units = get_option('csl_distance_units');
      $csl_disable_clustermarker = get_option('csl_disable_clustermarker');
      $csl_map_default_zoom = get_option('csl_map_default_zoom');
      ?>
      <input type="hidden" name="csl_hide_phone" value="<?php echo esc_js(get_option('csl_hide_phone')); ?>" />
      <input type="hidden" name="csl_hide_email" value="<?php echo esc_js(get_option('csl_hide_email')); ?>" />
      <input type="hidden" name="csl_hide_fax" value="<?php echo esc_js(get_option('csl_hide_fax')); ?>" />
      <input type="hidden" name="csl_hide_website" value="<?php echo esc_js(get_option('csl_hide_website')); ?>" />
      <input type="hidden" name="csl_hide_hours" value="<?php echo esc_js(get_option('csl_hide_hours')); ?>" />
      <input type="hidden" name="csl_primary_color" value="<?php echo esc_js(get_option('csl_primary_color')); ?>" />
      <input type="hidden" name="csl_secondary_color" value="<?php echo esc_js(get_option('csl_secondary_color')); ?>" />
      <table class="form-table" role="presentation">
      <tr>
      <th scope="row"><label for="csl_map_api_key"><?php esc_html_e( 'Google Map API Key', 'custom-store-locator' ); ?></label></th>
      <td><input type="text" id="csl_map_api_key" name="csl_map_api_key" value="<?php echo esc_attr($csl_map_api_key); ?>" /></td>
      </tr>
      <tr>
      <th scope="row"><label for="csl_distance_units"><?php esc_html_e( 'Distance Units', 'custom-store-locator' ); ?></label></th>
      <td><select id="csl_distance_units" name="csl_distance_units">
      <option value="">Select Option</option>
      <option value="" <?php if($csl_distance_units == '') { echo 'selected="selected"'; } ?>><?php esc_html_e( 'Miles', 'custom-store-locator' ); ?></option>
      <option value="km" <?php if($csl_distance_units == 'km') { echo 'selected="selected"'; } ?>><?php esc_html_e( 'Kilometers', 'custom-store-locator' ); ?></option>
      </select>
      </td>
      </tr>
      <tr>
      <th scope="row"><label for="csl_map_default_radius"><?php esc_html_e( 'Google Map Default Radius', 'custom-store-locator' ); ?></label></th>
      <td>
      <input type="text" id="csl_map_default_radius" name="csl_map_default_radius" value="<?php if($csl_map_default_radius) { echo esc_attr($csl_map_default_radius); } else { echo '20'; } ?>" />
      <p class="description"><?php esc_html_e( 'Radius units are based on above Distance Units field selected option', 'custom-store-locator' ); ?></p>
      </td>
      </tr>
      <tr>
      <th scope="row"><label for="csl_include_cat"><?php esc_html_e( 'Include Category in Searchbox', 'custom-store-locator' ); ?></label></th>
      <td><input type="checkbox" id="csl_include_cat" name="csl_include_cat" value="yes" <?php if($csl_include_cat == 'yes' ) { echo 'checked'; } ?> /></td>
      </tr>
	  <tr>
      <th scope="row"><label for="csl_include_title"><?php esc_html_e( 'Include Name in Searchbox', 'custom-store-locator' ); ?></label></th>
      <td><input type="checkbox" id="csl_include_title" name="csl_include_title" value="yes" <?php if($csl_include_title == 'yes' ) { echo 'checked'; } ?> /></td>
      </tr>
      <tr>
      <th scope="row"><label for="csl_custom_map_marker"><?php esc_html_e( 'Upload Custom Google Map Marker', 'custom-store-locator' ); ?></label></th>
      <td>
      <input type="text" class="csl_custom_map_marker" name="csl_custom_map_marker" id="csl_custom_map_marker" value="<?php echo esc_textarea($csl_custom_map_marker) ?>" />
      <input type="button" class="button upload_button" value="Upload" id="upload_image_button" />
      <?php if(!empty($csl_custom_map_marker)) { ?>
      <img src="<?php echo esc_attr($csl_custom_map_marker); ?>" width="20" height="20" />
      <?php } ?>
      </td>
      </tr>
      <tr>
      <th scope="row"><label for="csl_map_type"><?php esc_html_e( 'Google Map Type', 'custom-store-locator' ); ?></label></th>
      <td><select id="csl_map_type" name="csl_map_type">
      <option value=""><?php esc_html_e( 'Select Option', 'custom-store-locator' ); ?></option>
      <option value="roadmap" <?php if($csl_map_type == 'roadmap') { echo 'selected="selected"'; } ?>><?php esc_html_e( 'Roadmap', 'custom-store-locator' ); ?></option>
      <option value="satellite" <?php if($csl_map_type == 'satellite') { echo 'selected="selected"'; } ?>><?php esc_html_e( 'Satellite', 'custom-store-locator' ); ?></option>
      <option value="hybrid" <?php if($csl_map_type == 'hybrid') { echo 'selected="selected"'; } ?>><?php esc_html_e( 'Hybrid', 'custom-store-locator' ); ?></option>
      <option value="terrain" <?php if($csl_map_type == 'terrain') { echo 'selected="selected"'; } ?>><?php esc_html_e( 'Terrain', 'custom-store-locator' ); ?></option>
      </select></td>
      </tr>
      <tr>
      <th scope="row"><label for="csl_location_default_sorting"><?php esc_html_e( 'Locations Default Sorting', 'custom-store-locator' ); ?></label></th>
      <td><select id="csl_location_default_sorting" name="csl_location_default_sorting">
      <option value="">Select Option</option>
      <option value="" <?php if($csl_location_default_sorting == '') { echo 'selected="selected"'; } ?>><?php esc_html_e( 'Default', 'custom-store-locator' ); ?></option>
      <option value="menuorder" <?php if($csl_location_default_sorting == 'menuorder') { echo 'selected="selected"'; } ?>><?php esc_html_e( 'Custom Menu Order', 'custom-store-locator' ); ?></option>
      <option value="titleasc" <?php if($csl_location_default_sorting == 'titleasc') { echo 'selected="selected"'; } ?>><?php esc_html_e( 'Title Ascending', 'custom-store-locator' ); ?></option>
      <option value="titledesc" <?php if($csl_location_default_sorting == 'titledesc') { echo 'selected="selected"'; } ?>><?php esc_html_e( 'Title Descending', 'custom-store-locator' ); ?></option>
      <option value="dateasc" <?php if($csl_location_default_sorting == 'dateasc') { echo 'selected="selected"'; } ?>><?php esc_html_e( 'Date Ascending', 'custom-store-locator' ); ?></option>
      <option value="datedesc" <?php if($csl_location_default_sorting == 'datedesc') { echo 'selected="selected"'; } ?>><?php esc_html_e( 'Date Descending', 'custom-store-locator' ); ?></option>
      </select></td>
      </tr>
      <tr>
      <th scope="row"><label for="csl_map_layout"><?php esc_html_e( 'Layout', 'custom-store-locator' ); ?></label></th>
      <td><select id="csl_map_layout" name="csl_map_layout">
      <option value=""><?php esc_html_e( 'Select Layout', 'custom-store-locator' ); ?></option>
      <option value="sidebarlist" <?php if($csl_map_layout == 'sidebarlist') { echo 'selected="selected"'; } ?>><?php esc_html_e( 'Map With Sidebar List', 'custom-store-locator' ); ?></option>
      <option value="fullwidth" <?php if($csl_map_layout == 'fullwidth') { echo 'selected="selected"'; } ?>><?php esc_html_e( 'Fullwidth Map', 'custom-store-locator' ); ?></option>
	  <option value="style1" <?php if($csl_map_layout == 'style1') { echo 'selected="selected"'; } ?>><?php esc_html_e( 'Modern Style 1', 'custom-store-locator' ); ?></option>
     <?php /* <option value="style2" <?php if($csl_map_layout == 'style2') { echo 'selected="selected"'; } ?>><?php esc_html_e( 'Template 2', 'custom-store-locator' ); ?></option>
      <option value="style3" <?php if($csl_map_layout == 'style3') { echo 'selected="selected"'; } ?>><?php esc_html_e( 'Template 3', 'custom-store-locator' ); ?></option> */ ?>
      </select></td>
      </tr>
      <?php if($csl_map_layout == 'fullwidth') { ?>
      <tr>
      <th scope="row"><label for="csl_fullwidth_include_loc"><?php esc_html_e( 'Include Locations Dropdown in Searchbox', 'custom-store-locator' ); ?></label></th>
      <td><input type="checkbox" id="csl_fullwidth_include_loc" name="csl_fullwidth_include_loc" value="yes" <?php if($csl_fullwidth_include_loc == 'yes' ) { echo 'checked'; } ?> /></td>
      </tr>
      <?php }  ?>
      <tr>
      <th scope="row"><label for="csl_autocompletesearchbox"><?php esc_html_e( 'Enable Autocomplete in Searchbox', 'custom-store-locator' ); ?></label></th>
      <td><input type="checkbox" id="csl_autocompletesearchbox" name="csl_autocompletesearchbox" value="yes" <?php if($csl_autocompletesearchbox == 'yes' ) { echo 'checked'; } ?> /></td>
      </tr>
      <tr>
      <th scope="row"><label for="csl_disable_clustermarker"><?php esc_html_e( 'Disable Marker Cluster in Map', 'custom-store-locator' ); ?></label></th>
      <td><input type="checkbox" id="csl_disable_clustermarker" name="csl_disable_clustermarker" value="yes" <?php if($csl_disable_clustermarker == 'yes' ) { echo 'checked'; } ?> /></td>
      </tr>
      <tr>
      <th scope="row"><label for="csl_map_default_zoom"><?php esc_html_e( 'Google Map Default Zoom', 'custom-store-locator' ); ?></label></th>
      <td>
      <input type="text" id="csl_map_default_zoom" name="csl_map_default_zoom" value="<?php if($csl_map_default_zoom) { echo esc_attr($csl_map_default_zoom); } else { echo '20'; } ?>" />
      <p class="description"><?php esc_html_e( 'Map Default Zoom', 'custom-store-locator' ); ?></p>
      </td>
      </tr>
      <?php
      $allcountriesList = array(
        "AF" => "Afghanistan",
        "AL" => "Albania",
        "DZ" => "Algeria",
        "AS" => "American Samoa",
        "AD" => "Andorra",
        "AO" => "Angola",
        "AI" => "Anguilla",
        "AQ" => "Antarctica",
        "AG" => "Antigua and Barbuda",
        "AR" => "Argentina",
        "AM" => "Armenia",
        "AW" => "Aruba",
        "AU" => "Australia",
        "AT" => "Austria",
        "AX" => "Åland Islands",
        "AZ" => "Azerbaijan",
        "BS" => "Bahamas",
        "BH" => "Bahrain",
        "BD" => "Bangladesh",
        "BB" => "Barbados",
        "BY" => "Belarus",
        "BE" => "Belgium",
        "BZ" => "Belize",
        "BJ" => "Benin",
        "BM" => "Bermuda",
        "BT" => "Bhutan",
        "BO" => "Bolivia",
        "BA" => "Bosnia and Herzegovina",
        "BW" => "Botswana",
        "BV" => "Bouvet Island",
        "BR" => "Brazil",
        "BQ" => "British Antarctic Territory",
        "IO" => "British Indian Ocean Territory",
        "VG" => "British Virgin Islands",
        "BN" => "Brunei",
        "BG" => "Bulgaria",
        "BF" => "Burkina Faso",
        "BI" => "Burundi",
        "KH" => "Cambodia",
        "CM" => "Cameroon",
        "CA" => "Canada",
        "CT" => "Canton and Enderbury Islands",
        "CV" => "Cape Verde",
        "KY" => "Cayman Islands",
        "CF" => "Central African Republic",
        "TD" => "Chad",
        "CL" => "Chile",
        "CN" => "China",
        "CX" => "Christmas Island",
        "CC" => "Cocos [Keeling] Islands",
        "CO" => "Colombia",
        "KM" => "Comoros",
        "CG" => "Congo - Brazzaville",
        "CD" => "Congo - Kinshasa",
        "CK" => "Cook Islands",
        "CR" => "Costa Rica",
        "HR" => "Croatia",
        "CU" => "Cuba",
        "CY" => "Cyprus",
        "CZ" => "Czech Republic",
        "CI" => "Côte d’Ivoire",
        "DK" => "Denmark",
        "DJ" => "Djibouti",
        "DM" => "Dominica",
        "DO" => "Dominican Republic",
        "NQ" => "Dronning Maud Land",
        "DD" => "East Germany",
        "EC" => "Ecuador",
        "EG" => "Egypt",
        "SV" => "El Salvador",
        "GQ" => "Equatorial Guinea",
        "ER" => "Eritrea",
        "EE" => "Estonia",
        "ET" => "Ethiopia",
        "FK" => "Falkland Islands",
        "FO" => "Faroe Islands",
        "FJ" => "Fiji",
        "FI" => "Finland",
        "FR" => "France",
        "GF" => "French Guiana",
        "PF" => "French Polynesia",
        "TF" => "French Southern Territories",
        "FQ" => "French Southern and Antarctic Territories",
        "GA" => "Gabon",
        "GM" => "Gambia",
        "GE" => "Georgia",
        "DE" => "Germany",
        "GH" => "Ghana",
        "GI" => "Gibraltar",
        "GR" => "Greece",
        "GL" => "Greenland",
        "GD" => "Grenada",
        "GP" => "Guadeloupe",
        "GU" => "Guam",
        "GT" => "Guatemala",
        "GG" => "Guernsey",
        "GN" => "Guinea",
        "GW" => "Guinea-Bissau",
        "GY" => "Guyana",
        "HT" => "Haiti",
        "HM" => "Heard Island and McDonald Islands",
        "HN" => "Honduras",
        "HK" => "Hong Kong SAR China",
        "HU" => "Hungary",
        "IS" => "Iceland",
        "IN" => "India",
        "ID" => "Indonesia",
        "IR" => "Iran",
        "IQ" => "Iraq",
        "IE" => "Ireland",
        "IM" => "Isle of Man",
        "IL" => "Israel",
        "IT" => "Italy",
        "JM" => "Jamaica",
        "JP" => "Japan",
        "JE" => "Jersey",
        "JT" => "Johnston Island",
        "JO" => "Jordan",
        "KZ" => "Kazakhstan",
        "KE" => "Kenya",
        "KI" => "Kiribati",
        "KW" => "Kuwait",
        "KG" => "Kyrgyzstan",
        "LA" => "Laos",
        "LV" => "Latvia",
        "LB" => "Lebanon",
        "LS" => "Lesotho",
        "LR" => "Liberia",
        "LY" => "Libya",
        "LI" => "Liechtenstein",
        "LT" => "Lithuania",
        "LU" => "Luxembourg",
        "MO" => "Macau SAR China",
        "MK" => "Macedonia",
        "MG" => "Madagascar",
        "MW" => "Malawi",
        "MY" => "Malaysia",
        "MV" => "Maldives",
        "ML" => "Mali",
        "MT" => "Malta",
        "MH" => "Marshall Islands",
        "MQ" => "Martinique",
        "MR" => "Mauritania",
        "MU" => "Mauritius",
        "YT" => "Mayotte",
        "FX" => "Metropolitan France",
        "MX" => "Mexico",
        "FM" => "Micronesia",
        "MI" => "Midway Islands",
        "MD" => "Moldova",
        "MC" => "Monaco",
        "MN" => "Mongolia",
        "ME" => "Montenegro",
        "MS" => "Montserrat",
        "MA" => "Morocco",
        "MZ" => "Mozambique",
        "MM" => "Myanmar [Burma]",
        "NA" => "Namibia",
        "NR" => "Nauru",
        "NP" => "Nepal",
        "NL" => "Netherlands",
        "AN" => "Netherlands Antilles",
        "NT" => "Neutral Zone",
        "NC" => "New Caledonia",
        "NZ" => "New Zealand",
        "NI" => "Nicaragua",
        "NE" => "Niger",
        "NG" => "Nigeria",
        "NU" => "Niue",
        "NF" => "Norfolk Island",
        "KP" => "North Korea",
        "VD" => "North Vietnam",
        "MP" => "Northern Mariana Islands",
        "NO" => "Norway",
        "OM" => "Oman",
        "PC" => "Pacific Islands Trust Territory",
        "PK" => "Pakistan",
        "PW" => "Palau",
        "PS" => "Palestinian Territories",
        "PA" => "Panama",
        "PZ" => "Panama Canal Zone",
        "PG" => "Papua New Guinea",
        "PY" => "Paraguay",
        "YD" => "People's Democratic Republic of Yemen",
        "PE" => "Peru",
        "PH" => "Philippines",
        "PN" => "Pitcairn Islands",
        "PL" => "Poland",
        "PT" => "Portugal",
        "PR" => "Puerto Rico",
        "QA" => "Qatar",
        "RO" => "Romania",
        "RU" => "Russia",
        "RW" => "Rwanda",
        "RE" => "Réunion",
        "BL" => "Saint Barthélemy",
        "SH" => "Saint Helena",
        "KN" => "Saint Kitts and Nevis",
        "LC" => "Saint Lucia",
        "MF" => "Saint Martin",
        "PM" => "Saint Pierre and Miquelon",
        "VC" => "Saint Vincent and the Grenadines",
        "WS" => "Samoa",
        "SM" => "San Marino",
        "SA" => "Saudi Arabia",
        "SN" => "Senegal",
        "RS" => "Serbia",
        "CS" => "Serbia and Montenegro",
        "SC" => "Seychelles",
        "SL" => "Sierra Leone",
        "SG" => "Singapore",
        "SK" => "Slovakia",
        "SI" => "Slovenia",
        "SB" => "Solomon Islands",
        "SO" => "Somalia",
        "ZA" => "South Africa",
        "GS" => "South Georgia and the South Sandwich Islands",
        "KR" => "South Korea",
        "ES" => "Spain",
        "LK" => "Sri Lanka",
        "SD" => "Sudan",
        "SR" => "Suriname",
        "SJ" => "Svalbard and Jan Mayen",
        "SZ" => "Swaziland",
        "SE" => "Sweden",
        "CH" => "Switzerland",
        "SY" => "Syria",
        "ST" => "São Tomé and Príncipe",
        "TW" => "Taiwan",
        "TJ" => "Tajikistan",
        "TZ" => "Tanzania",
        "TH" => "Thailand",
        "TL" => "Timor-Leste",
        "TG" => "Togo",
        "TK" => "Tokelau",
        "TO" => "Tonga",
        "TT" => "Trinidad and Tobago",
        "TN" => "Tunisia",
        "TR" => "Turkey",
        "TM" => "Turkmenistan",
        "TC" => "Turks and Caicos Islands",
        "TV" => "Tuvalu",
        "UM" => "U.S. Minor Outlying Islands",
        "PU" => "U.S. Miscellaneous Pacific Islands",
        "VI" => "U.S. Virgin Islands",
        "UG" => "Uganda",
        "UA" => "Ukraine",
        "SU" => "Union of Soviet Socialist Republics",
        "AE" => "United Arab Emirates",
        "GB" => "United Kingdom",
        "US" => "United States",
        "ZZ" => "Unknown or Invalid Region",
        "UY" => "Uruguay",
        "UZ" => "Uzbekistan",
        "VU" => "Vanuatu",
        "VA" => "Vatican City",
        "VE" => "Venezuela",
        "VN" => "Vietnam",
        "WK" => "Wake Island",
        "WF" => "Wallis and Futuna",
        "EH" => "Western Sahara",
        "YE" => "Yemen",
        "ZM" => "Zambia",
        "ZW" => "Zimbabwe"
        );
      ?>
      <tr>
      <th scope="row"><label for="csl_country_restriction"><?php esc_html_e( 'Country Search Restriction', 'custom-store-locator' ); ?></label></th>
      <td><select id="csl_country_restriction" name="csl_country_restriction">
      <option value=""><?php esc_html_e( 'All Countries', 'custom-store-locator' ); ?></option>
      <?php
      foreach($allcountriesList as $key => $value)
      {
        $selectedcountry = (!empty($csl_country_restriction) &&  $csl_country_restriction == $key) ? 'selected="selected"' : ''; 
        echo '<option value="' . esc_attr($key) . '" ' . esc_attr($selectedcountry) . '>' . esc_attr($value) . '</option>';
      }
      ?>
      </select>
      <p class="description"><?php esc_html_e( 'This is helpful when all of your stores are located in single country and you are facing incorrect search result problems. Just select country from above list.', 'custom-store-locator' ); ?></p>
      </td>
      </tr>
      </table>
      <?php  submit_button(); ?>
    </form>
  <?php
  break;
endswitch; 
?>
</div>