<?php
/**
 * This file contains plugin basic functions of plugin
 *
 * @package  Custom_Store_Locator
 */
/* Shortcode to display store list */
add_shortcode( 'csl-store-list', 'csl_listing_parameters_shortcode' );
function csl_listing_parameters_shortcode( $atts ) {
    ob_start();
	static $already_run = false;
    if ( $already_run !== true ) {
    extract( shortcode_atts( array (
        'post_type' => 'csl_locations',
        'posts' => -1,
		'post_status' => array('publish'),
		'category' => '',
    ), $atts ) );
	$tax_query = array();
	$csllocationscategories = !empty($_GET['csl-locations-categories']) ? sanitize_text_field($_GET['csl-locations-categories']) : '';
	if(!empty($csllocationscategories) && empty($category))
	{
		$tax_query[] = array(
			'taxonomy' => 'csl_locations_categories',
			'field'    => 'slug',
			'terms'    => $csllocationscategories,
		);
	}
	if(empty($csllocationscategories) && !empty($category))
	{
		$tax_query[] = array(
			'taxonomy' => 'csl_locations_categories',
			'field'    => 'slug',
			'terms'    => $category,
		);
	}
	$csl_location_default_sorting = get_option('csl_location_default_sorting');
	$csl_map_layout = get_option('csl_map_layout');
    $options = array(
		'post_type' => 'csl_locations',
		'post_status' => array('publish'),
		'posts_per_page' => $posts,
		'tax_query' => $tax_query,
	);
	if($csl_location_default_sorting == 'titleasc'){
		$options['orderby'] = 'title'; 
		$options['order'] = 'ASC';
	}elseif($csl_location_default_sorting == 'titledesc'){
		$options['orderby'] = 'title';
		$options['order'] = 'DESC';
	}elseif($csl_location_default_sorting == 'dateasc'){
		$options['orderby'] = 'date';
		$options['order'] = 'ASC';
	}elseif($csl_location_default_sorting == 'datedesc'){
		$options['orderby'] = 'date';
		$options['order'] = 'DESC';
	}elseif($csl_location_default_sorting == 'menuorder'){
		$options['orderby'] = 'menu_order';
		$options['order'] = 'ASC';
	}
	else{
		unset($options['order']); 
		unset($options['orderby']);
	}
	$listing_query = new WP_Query( $options );
    // run the loop based on the query
    if ( $listing_query->have_posts() ) { ?>
	<script>
		var allLocations = [
		<?php while ( $listing_query->have_posts() ) : $listing_query->the_post(); 
			$locid = get_the_ID();
			$thumbnail = get_the_post_thumbnail_url(); 
			$websiteurl = get_post_meta( $locid, 'websiteurl', true );
			$business_phone_number = get_post_meta( $locid, 'business_phone_number', true );
			$business_fax = get_post_meta( $locid, 'business_fax', true );
			$business_contact_email = get_post_meta( $locid, 'business_contact_email', true );
			$business_address = str_replace(array('[\', \']'), '', get_post_meta( $locid, 'business_address', true ));
			$business_zip_code = get_post_meta( $locid, 'business_zip_code', true );
			$business_latitude = get_post_meta( $locid, 'business_latitude', true );
			$business_longitude = get_post_meta( $locid, 'business_longitude', true );
			$business_storehours = str_replace(array('[\', \']'), '', get_post_meta( $locid, 'business_storehours', true ));
			$locations_catlist = get_the_terms( $locid, 'csl_locations_categories' );
			$locaterm_id = $locations_catlist[0]->term_id;
			$category_marker = (!empty($locations_catlist[0])) ? get_term_meta($locaterm_id, 'category_marker', true) : '';
			$csl_hide_phone = (!empty(get_option('csl_hide_phone'))) ? get_option('csl_hide_phone') : '';
			$csl_hide_email = (!empty(get_option('csl_hide_email'))) ? get_option('csl_hide_email') : '';
			$csl_hide_fax = (!empty(get_option('csl_hide_fax'))) ? get_option('csl_hide_fax') : '';
			$csl_hide_website = (!empty(get_option('csl_hide_website'))) ? get_option('csl_hide_website') : '';
			$csl_hide_hours = (!empty(get_option('csl_hide_hours'))) ? get_option('csl_hide_hours') : '';
		?>
		{
		    name: "<?php echo esc_js( get_the_title() ); ?>",
		    <?php if ( $business_latitude ) { ?>
		    lat: <?php echo esc_js( $business_latitude ); ?>,
		    <?php } else { ?>
		    lat: '',            
		    <?php } ?>
		    <?php if ( $business_longitude ) { ?>
		    lng: <?php echo esc_js( $business_longitude ); ?>,
		    <?php } else { ?>
		    lng: '',            
		    <?php } ?>
		    myid: <?php echo esc_js( get_the_ID() ); ?>,
		    <?php if ( $business_contact_email && $csl_hide_email !== 'yes' ) { ?>
		    email: "<?php echo wp_kses_data( '<strong>' . __( "Email", "custom-store-locator" ) . ': </strong> ' ) . esc_js( $business_contact_email ); ?>",
		    <?php } else { ?>
		    email: '',            
		    <?php } ?>
		    <?php if ( $websiteurl && $csl_hide_website !== 'yes' ) { ?>
		    website: "<?php echo wp_kses_data( '<strong>' . __( "Website", "custom-store-locator" ) . ': </strong> <a target=\'_blank\' href=\'' . esc_url( $websiteurl ) . '\'>' . esc_url( $websiteurl ) . '</a>' ); ?>",
		    <?php } else { ?>
		    website: '',            
		    <?php } ?>
		    <?php if ( $websiteurl && $csl_hide_website !== 'yes' ) { ?>
		    websitebtn: "<?php echo '<a target=\'_blank\' href=\'' . esc_url( $websiteurl ) . '\' class=\'site_btn sm white_btn\'>' . esc_attr__( "Website", "custom-store-locator" ) . '</a>'; ?>",
		    <?php } else { ?>
		    websitebtn: '',            
		    <?php } ?>
			caticon: '<?php echo esc_url($category_marker); ?>',
		    <?php if ( $business_zip_code ) { ?>
		    zip: "<?php echo wp_kses_data( '<strong>' . __( "Postal Code", "custom-store-locator" ) . ': </strong>' . esc_html( $business_zip_code ) ); ?>",
		    <?php } else { ?>
		    zip: '',            
		    <?php } ?>
		    <?php if ( $business_phone_number && $csl_hide_phone !== 'yes' ) { ?>
		    phone: "<?php echo wp_kses_data( '<strong>' . __( "Phone", "custom-store-locator" ) . ': </strong> ' . esc_html( $business_phone_number ) ); ?>",
		    <?php } else { ?>
		    phone: '',            
		    <?php } ?>
		    <?php if ( $business_phone_number && $csl_hide_phone !== 'yes' ) { ?>
		    phonebtn: "<?php echo '<a target=\'_blank\' href=\'tel:' . esc_html( $business_phone_number ) . '\' class=\'site_btn sm white_btn\'>' . esc_attr__( "Call", "custom-store-locator" ) . '</a>'; ?>",
		    <?php } else { ?>
		    phonebtn: '',            
		    <?php } ?>
		    <?php if ( $business_fax && $csl_hide_fax !== 'yes' ) { ?>
		    fax: "<?php echo wp_kses_data( '<strong>' . __( "Fax", "custom-store-locator" ) . ': </strong> ' . esc_html( $business_fax ) ); ?>",
		    <?php } else { ?>
		    fax: '',            
		    <?php } ?>
		    <?php if ( $business_storehours && $csl_hide_hours !== 'yes' ) { ?>
		    hours: "<?php echo wp_kses_data( '<strong>' . __( "Store Hours", "custom-store-locator" ) . ': </strong>' . nl2br( esc_html( $business_storehours ) ) ); ?>",
		    <?php } else { ?>
		    hours: '',
		    <?php } ?>
		    <?php if ( ! empty( $locations_catlist ) ) { ?>
		    locationcat: [<?php echo esc_js( join( ', ', wp_list_pluck( $locations_catlist, 'term_id' ) ) ); ?>],
		    <?php } else { ?>
		    locationcat: [],
		    <?php } ?>
		    <?php if ( $business_address ) {
		    $label = '<strong>' . esc_html__( 'Address', 'custom-store-locator' ) . ': </strong> ';
		    $content = nl2br( esc_html( $business_address ) );
		    $final_output = $label . $content;
		    ?>
		    address: <?php echo wp_json_encode( $final_output ); ?>,
			<?php } ?>
			<?php if(has_post_thumbnail()) { ?>
				thumbnail: "<?php echo esc_url($thumbnail); ?>",
			<?php } else { ?>	
				thumbnail: '',
			<?php } ?>
		},
		<?php endwhile;	wp_reset_postdata(); ?>
		];
		var cslAPI = '<?php echo esc_js( get_option( 'csl_map_api_key' ) ); ?>';
		var cslMaptype = '<?php echo esc_js( ! empty( get_option( 'csl_map_type' ) ) ? get_option( 'csl_map_type' ) : 'roadmap' ); ?>';
		var clsIcon = '<?php echo esc_js( get_option( 'csl_custom_map_marker' ) ); ?>';
		var cslcountryrestrict = '<?php echo esc_js( get_option( 'csl_country_restriction' ) ); ?>';
		var cslDistanceunits = '<?php echo esc_js( get_option( 'csl_distance_units' ) ); ?>';
		var cslMapDefaultZoom = <?php echo esc_js( ! empty( get_option( 'csl_map_default_zoom' ) ) ? get_option( 'csl_map_default_zoom' ) : '12' ); ?>;
		var cslDisableClusterMarker = '<?php echo esc_js( get_option( 'csl_disable_clustermarker' ) ); ?>';
	</script>
		<?php $csl_map_default_radius = get_option('csl_map_default_radius');
		$csl_include_cat = get_option('csl_include_cat');
		$csl_include_title = get_option('csl_include_title');
		$csl_autocompletesearchbox = get_option('csl_autocompletesearchbox');
		?>
		<?php 
		if(!empty($csl_map_layout) && $csl_map_layout == "fullwidth")
		{ 
		/* Full Width Layout */
		include CSL_PATH . '/inc/layout/full-width-map.php';
		/* End of Full Width Layout */
		} 
		elseif(!empty($csl_map_layout) && $csl_map_layout == "style1") {
			/* Template 1 Layout */
			include CSL_PATH . '/inc/layout/map-style-1.php';
			/* End of Template 1 Layout */
		}
		/*elseif(!empty($csl_map_layout) && $csl_map_layout == "style2") {
			// Template 2 Layout
			include CSL_PATH . '/inc/layout/map-style-2.php';
			// End of Template 2 Layout
		}
		elseif(!empty($csl_map_layout) && $csl_map_layout == "style3") {
			// Template 3 Layout
			include CSL_PATH . '/inc/layout/map-style-3.php';
			// End of Template 3 Layout
		}*/
		else { 
		/* Default Right Map Layout */
		include CSL_PATH . '/inc/layout/default-right-map.php';
		/* End of Default Right Map Layout */
		} 
		?>
	<?php }
    $already_run = true;
		$myvariable = ob_get_clean();
		return $myvariable;
	}
}
/* End of Shortcode to display store list */
/* Search Form Shortcode */
function csl_search_form($atts) {
    extract( shortcode_atts( array (
        'pageid' => ''
	), $atts ) );
	$csl_default_radius = get_option('csl_map_default_radius'); 
	if(!empty($csl_default_radius)) { $csl_map_default_radius = $csl_default_radius; } else { $csl_map_default_radius = 20; }
	$search_form = '<form class="csl-search-form" action="' . get_permalink($pageid) . '" method="get">
	<label for="userAddress">' . __( "Enter Zipcode", "custom-store-locator" ) . ': <input name="userAddress" id="userAddress" type="text" placeholder="' . __( "Zipcode", "custom-store-locator" ) . '" /></label>
	<input name="maxRadius" id="maxRadius" type="hidden" value="' . sanitize_text_field($csl_map_default_radius)  . '" min="1" />
	<button id="submitLocationSearch">Search</button>
	</form>';
	return $search_form;
}
add_shortcode('csl-search', 'csl_search_form');
/* End of Search Form Shortcode */
/*Adds a metabox to location posts */
add_action( 'add_meta_boxes', 'add_csl_metaboxes' );
function add_csl_metaboxes() {
	add_meta_box(
		'csl_metabox_settings',
		'Store Locator Settings',
		'csl_metabox_settings',
		'csl_locations',
		'normal',
		'high'
	);
}
/**
 * Output the HTML for the metabox.
 */
function csl_metabox_settings() {
	global $post;
	wp_nonce_field( basename( __FILE__ ), 'event_fields' );
	// Get the location data if it's already been entered
	$websiteurl = get_post_meta( $post->ID, 'websiteurl', true );
	$business_phone_number = get_post_meta( $post->ID, 'business_phone_number', true );
	$business_fax = get_post_meta( $post->ID, 'business_fax', true );
	$business_contact_email = get_post_meta( $post->ID, 'business_contact_email', true );
	$business_address = get_post_meta( $post->ID, 'business_address', true );
	$business_zip_code = get_post_meta( $post->ID, 'business_zip_code', true );
	$business_latitude = get_post_meta( $post->ID, 'business_latitude', true );
	$business_longitude = get_post_meta( $post->ID, 'business_longitude', true );
	$business_storehours = get_post_meta( $post->ID, 'business_storehours', true );
	?>
	<tr>
	<th scope="row"><label>Map</label></th>
	<input id="pac-input" class="controls" type="text" placeholder="<?php esc_html_e( 'Enter Address', 'custom-store-locator' ); ?>" /> 
	<div id="registermap" style="width:500px;height:400px;"></div>	
	</tr>
	<script>
				<?php if (!empty($business_latitude) && !empty($business_longitude)) { ?>
					var myLatlng = { 
						lat: <?php echo esc_js( $business_latitude ); ?>, 
						lng: <?php echo esc_js( $business_longitude ); ?> 
					};
				<?php } else { ?>
					var myLatlng = { 
						lat: 40.3417249, 
						lng: -84.9124694 
					};
				<?php } ?>
				var mymap = new google.maps.Map(document.getElementById("registermap"), {
					zoom: 8,
					center: myLatlng,
				});
				var marker = new google.maps.Marker({
					position: myLatlng,
					map: mymap,
					draggable:true,
					title:"Drag me!"
				});
				var infoWindow = new google.maps.InfoWindow({
					content: "Set your business location",
					position: myLatlng,
				});
				var searchBox = new google.maps.places.SearchBox(document.getElementById('pac-input'));
				mymap.controls[google.maps.ControlPosition.TOP_CENTER].push(document.getElementById('pac-input'));
				mymap.addListener('click', function(mapsMouseEvent) {
				searchBox.set('map', null);
				// Close the current InfoWindow.
				infoWindow.close();
				if (marker && marker.setPosition)
				{
					marker.setPosition(mapsMouseEvent.latLng);
				}	
				else
				{
					marker = new google.maps.Marker({
					position: mapsMouseEvent.latLng,
					map: mymap,
					});
				}
				document.getElementById("business_latitude").value = mapsMouseEvent.latLng.lat();
				document.getElementById("business_longitude").value = mapsMouseEvent.latLng.lng();
				var resultlat = mapsMouseEvent.latLng.lat();
				var resultlng = mapsMouseEvent.latLng.lng();
				var resultlatlng = new google.maps.LatLng(resultlat, resultlng);
				var geocoder = new google.maps.Geocoder();
				geocoder.geocode({'latLng': resultlatlng}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					if (results[1]) {
					document.getElementById("business_zip_code").value =results[0].address_components.find(addr => addr.types[0] === "postal_code").short_name;		
					document.getElementById("business_address").value = results[0].formatted_address;
					}
				}
				else {
				console.log("Geocoder failed due to: " + status);
				}
				});
				});
				google.maps.event.addListener(searchBox, 'places_changed', function() {
					searchBox.set('map', null);
					var places = searchBox.getPlaces();
					var bounds = new google.maps.LatLngBounds();
					var i, place;
					for (i = 0; place = places[i]; i++) {
					(function(place) {
						var marker = new google.maps.Marker({
						position: place.geometry.location
						});
						marker.bindTo('map', searchBox, 'map');
						google.maps.event.addListener(marker, 'map_changed', function() {
						if (!this.getMap()) {
							this.unbindAll();
						}
						});
						bounds.extend(place.geometry.location);
					}(place));
					}
					document.getElementById("business_latitude").value = places[0].geometry.location.lat();
					document.getElementById("business_longitude").value = places[0].geometry.location.lng();
						var searchlat =  places[0].geometry.location.lat();
						var searchlng = places[0].geometry.location.lng();
						var searchlatlng = new google.maps.LatLng(searchlat, searchlng);
						var geocoder = new google.maps.Geocoder();
						geocoder.geocode({'latLng': searchlatlng}, function(results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
						if (results[1]) {
						document.getElementById("business_zip_code").value =results[0].address_components.find(addr => addr.types[0] === "postal_code").short_name;	
						document.getElementById("business_address").value = results[0].formatted_address
						}
						}
						else {
						console.log("Geocoder failed due to: " + status);
						}
					});
					mymap.fitBounds(bounds);
					searchBox.set('map', mymap);
					mymap.setZoom(Math.min(mymap.getZoom(),12));
				});
		</script>
	<?php
    echo '<p><label for="websiteurl">' . esc_html__( "Website URL", "custom-store-locator" ) . '</label>
    <input type="text" id="websiteurl" name="websiteurl" value="' . esc_attr( $websiteurl ) . '" class="widefat" placeholder="Website URL"></p>';
    echo '<p><label for="business_phone_number">' . esc_html__( "Business Phone Number", "custom-store-locator" ) . '</label>
    <input type="text" id="business_phone_number" name="business_phone_number" value="' . esc_attr( $business_phone_number ) . '" class="widefat" placeholder="Business Phone Number"></p>';
    echo '<p><label for="business_fax">' . esc_html__( "Business FAX", "custom-store-locator" ) . '</label>
    <input type="text" id="business_fax" name="business_fax" value="' . esc_attr( $business_fax ) . '" class="widefat" placeholder="Business FAX"></p>';
    echo '<p><label for="business_contact_email">' . esc_html__( "Business Contact Email", "custom-store-locator" ) . '</label>
    <input type="text" id="business_contact_email" name="business_contact_email" value="' . esc_attr( $business_contact_email ) . '" class="widefat" placeholder="Business Contact Email"></p>';
    echo '<p><label for="business_address">' . esc_html__( "Business Address", "custom-store-locator" ) . '</label>
    <textarea id="business_address" name="business_address" class="widefat" placeholder="Business Address">' . esc_textarea( $business_address ) . '</textarea></p>';
    echo '<p><label for="business_zip_code">' . esc_html__( "Business Zip Code", "custom-store-locator" ) . '</label>
    <input type="text" id="business_zip_code" name="business_zip_code" value="' . esc_attr( $business_zip_code ) . '" class="widefat" placeholder="Business Zip Code"></p>';
    echo '<p><label for="business_latitude">' . esc_html__( "Business Latitude", "custom-store-locator" ) . '</label>
    <input type="text" id="business_latitude" name="business_latitude" value="' . esc_attr( $business_latitude ) . '" class="widefat" placeholder="Business Latitude"></p>';
    echo '<p><label for="business_longitude">' . esc_html__( "Business Longitude", "custom-store-locator" ) . '</label>
    <input type="text" id="business_longitude" name="business_longitude" value="' . esc_attr( $business_longitude ) . '" class="widefat" placeholder="Business Longitude"></p>';
    echo '<p><label for="business_storehours">' . esc_html__( "Business Hours (Use Shift+Enter for line break)", "custom-store-locator" ) . '</label></p>';
    $args = array(
        'media_buttons' => false, 
        'textarea_name' => "business_storehours",
        'textarea_rows' => 5,
        'quicktags' => true, 
    );
    wp_editor( $business_storehours, 'business_storehours', $args );
}
/* Save the metabox data */
function save_csl_meta( $post_id, $post ) {
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}
	if ( ! isset( $_POST['business_latitude'] ) || ! wp_verify_nonce( $_POST['event_fields'], basename(__FILE__) ) ) {
		return $post_id;
	}
	$csl_data_meta['websiteurl'] = esc_url( $_POST['websiteurl'] );
	$csl_data_meta['business_phone_number'] = sanitize_text_field( $_POST['business_phone_number'] );
	$csl_data_meta['business_fax'] = sanitize_text_field( $_POST['business_fax'] );
	$csl_data_meta['business_contact_email'] = sanitize_email( $_POST['business_contact_email'] );
	$csl_data_meta['business_address'] = sanitize_textarea_field( $_POST['business_address'] );
	$csl_data_meta['business_zip_code'] = sanitize_text_field( $_POST['business_zip_code'] );
	$csl_data_meta['business_latitude'] = sanitize_text_field( $_POST['business_latitude'] );
	$csl_data_meta['business_longitude'] = sanitize_text_field( $_POST['business_longitude'] );
	$csl_data_meta['business_storehours'] = sanitize_textarea_field( $_POST['business_storehours'] );
	foreach ( $csl_data_meta as $key => $value ) :
		if ( 'revision' === $post->post_type ) {
			return;
		}
		if ( get_post_meta( $post_id, $key, false ) ) {
			update_post_meta( $post_id, $key, $value );
		} else {
			add_post_meta( $post_id, $key, $value);
		}
		if ( ! $value ) {
			delete_post_meta( $post_id, $key );
		}
	endforeach;
}
add_action( 'save_post', 'save_csl_meta', 1, 2 );
/*End of Adds a metabox to location posts */
/* Assets for admin only */
function csl_admin_scripts() {  
	global $parent_file;
	if( 'store_plugin' == $parent_file ) {
		if(function_exists( 'wp_enqueue_media' )){
			wp_enqueue_media();
		}else{
			wp_enqueue_style('thickbox');
			wp_enqueue_script('media-upload');
			wp_enqueue_script('thickbox');
		}
		wp_register_script('my-upload', CSL_URL . '/assets/csl_custom_admin.js', array('jquery','media-upload','thickbox'));
		$csl_primary_color = get_option('csl_primary_color');
		$csl_secondary_color = get_option('csl_secondary_color');
		$csl_map_layout = get_option('csl_map_layout');
		if(in_array($csl_map_layout, ['sidebarlist', 'fullwidth'])) {
			$default_primary = '#ee5253';
			$default_secondary = '#222f3e';
		}elseif($csl_map_layout == 'style1') {
			$default_primary = '#1e272e';
			$default_secondary = '#808e9b';
		}elseif($csl_map_layout == 'style2') {
		}elseif($csl_map_layout == 'style3') {
		}
		wp_localize_script( 'my-upload', 'colors_object',
			array( 
				'primary' => (!empty($csl_primary_color) ? esc_attr($csl_primary_color) : esc_attr($default_primary)),
				'secondary' =>  (!empty($csl_secondary_color) ? esc_attr($csl_secondary_color) : esc_attr($default_secondary)),
				'default_primary' => esc_attr($default_primary),
				'default_secondary' => esc_attr($default_secondary)
			)
		);
		wp_enqueue_script('my-upload');	
	}
	if( 'edit.php?post_type=csl_locations' == $parent_file ) {
		wp_enqueue_style( 'csl-admin-page-css', CSL_URL . '/assets/csl_custom_admin.css' );
	}
	}
	function csl_admin_styles() {
		wp_enqueue_style('thickbox');
	}
	add_action('admin_print_scripts', 'csl_admin_scripts');
	add_action('admin_print_styles', 'csl_admin_styles');
/* End of Assets for admin only */
/* Store Export Functionality */
add_action( 'restrict_manage_posts', 'add_export_button' );
function add_export_button() {
    $screen = get_current_screen();
    if (isset($screen->parent_file) && ('edit.php?post_type=csl_locations' == $screen->parent_file)) {
        ?>
        <input type="submit" name="export_all_posts" id="export_all_posts" class="button button-primary" value="Export Locations CSV">
        <script type="text/javascript">
            jQuery(function($) {
                $('#export_all_posts').insertAfter('#post-query-submit');
            });
        </script>
        <?php
    }
}
add_action( 'admin_init', 'csl_export_all_posts' ); /* By Tarun */
function csl_export_all_posts() {
	if(isset($_GET['export_all_posts'])) {
    $location_args = array(
        'posts_per_page' => -1,
        'post_type'      => 'csl_locations',
        'post_status'    => 'publish'
    );
	global $post;
	$query_locations = get_posts( $location_args );
	$i=1;
	if(!empty($query_locations)) {
		header('Content-type: text/csv');
		header('Content-Disposition: attachment; filename="wp_locations.csv"');
		header('Pragma: no-cache');
		header('Expires: 0');
		$file = fopen('php://output', 'w');
		fputcsv($file, 
		array('title', 
		'website', 
		'business_phone_number', 
		'business_fax', 
		'business_contact_email', 
		'business_address', 
		'business_zip_code', 
		'business_latitude', 
		'business_longitude', 
		'business_storehours',
		'business_category'
		));
		foreach($query_locations as $post) {
			setup_postdata($post);
			$websiteurl = get_post_meta( get_the_ID(), 'websiteurl', true );
			$business_phone_number = get_post_meta( get_the_ID(), 'business_phone_number', true );
			$business_fax = get_post_meta( get_the_ID(), 'business_fax', true );
			$business_contact_email = get_post_meta( get_the_ID(), 'business_contact_email', true );
			$business_address = get_post_meta( get_the_ID(), 'business_address', true );
			$business_zip_code = get_post_meta( get_the_ID(), 'business_zip_code', true );
			$business_latitude = get_post_meta( get_the_ID(), 'business_latitude', true );
			$business_longitude = get_post_meta( get_the_ID(), 'business_longitude', true );
			$business_storehours = get_post_meta( get_the_ID(), 'business_storehours', true );
			$taxonomy = 'csl_locations_categories';
			$business_cats = get_the_terms(get_the_ID(), $taxonomy);
			if(!empty($business_cats)) {
				$csl_business_cats = join(', ', wp_list_pluck($business_cats, 'name'));
			}else{
				$csl_business_cats = '';
			}
			fputcsv($file, 
			array(
				get_the_title(), 
				$websiteurl,
				$business_phone_number,
				$business_fax,
				$business_contact_email,
				$business_address,
				$business_zip_code,
				$business_latitude,
				$business_longitude,
				$business_storehours,
				$csl_business_cats
			)
			);
		}
		exit();
	}
	}
}
/* End of Store Export Functionality */
/* Change Default Sorting */
$csl_location_default_sorting = get_option('csl_location_default_sorting');
if($csl_location_default_sorting == 'menuorder') {
add_action('manage_csl_locations_posts_columns', 'csl_add_new_location_column');
add_action('manage_csl_locations_posts_custom_column','csl_show_order_column');
}
function csl_add_new_location_column($header_text_columns) {
$header_text_columns['menu_order'] = "Order";
return $header_text_columns;
}
function csl_show_order_column($name){
global $post;
switch ($name) {
	case 'menu_order':
	$order = $post->menu_order;
	echo esc_attr($order);
	break;
	default:
	break;
	}
}
/* End of Change Default Sorting */
/* Load plugin textdomain */
add_action( 'init', 'csl_load_textdomain' );
function csl_load_textdomain() {
	load_plugin_textdomain( 'custom-store-locator', false, 'custom-store-locator/languages' ); 
}
/* End of Load plugin textdomain */
/* Add the image field to csl_locations_categories taxonomy */
add_action('csl_locations_categories_add_form_fields', 'csl_add_category_marker_field');
add_action('csl_locations_categories_edit_form_fields', 'csl_edit_category_marker_field');
add_action('edited_csl_locations_categories', 'csl_save_category_marker_field');
add_action('created_csl_locations_categories', 'csl_save_category_marker_field');
// Add field to the 'Add New' category form
function csl_add_category_marker_field($taxonomy) {
    ?>
    <div class="form-field">
        <label for="category_marker"><?php esc_html_e('Category Marker', 'custom-store-locator'); ?></label>
		<input type="text" id="category_marker" name="category_marker" value="" placeholder="Marker URL" style="margin-bottom:5px;">
		<button id="upload_category_marker" class="button"><?php esc_html_e('Upload Marker', 'custom-store-locator'); ?></button>
		<button id="remove_category_marker" class="button" style="display:none;"><?php esc_html_e('Remove Marker', 'custom-store-locator'); ?></button>
		<div id="category_marker_preview" style="margin-top:5px;"></div>
     </div>
    <script>
    jQuery(document).ready(function ($) {
			// Open the media uploader when the "Upload Marker" button is clicked
			$('#upload_category_marker').on('click', function (e) {
				e.preventDefault();
				// Check if the media uploader is already open to prevent duplicates
				var mediaUploader = wp.media({
					title: '<?php echo esc_js(__('Select Marker', 'custom-store-locator')); ?>',
					button: {
						text: '<?php echo esc_js(__('Use This Marker', 'custom-store-locator')); ?>'
					},
					multiple: false // Single selection only
				});
				// When a marker is selected
				mediaUploader.on('select', function () {
					var attachment = mediaUploader.state().get('selection').first().toJSON();
					$('#category_marker').val(attachment.url); // Set the marker URL in the input field
					$('#category_marker_preview').html('<img src="' + attachment.url + '" style="max-width: 100px; max-height: 100px;">'); // Show a preview of the marker
					$('#remove_category_marker').show(); // Show the "Remove Marker" button
				});
				mediaUploader.open();
			});
			// Remove the marker when the "Remove Marker" button is clicked
			$('#remove_category_marker').on('click', function (e) {
				e.preventDefault();
				$('#category_marker').val(''); // Clear the input field
				$('#category_marker_preview').html(''); // Remove the preview image
				$(this).hide(); // Hide the "Remove Marker" button
			});
		});
	</script>
    <?php
}
// Add field to the 'Edit' category form
function csl_edit_category_marker_field($term) {
    $value = get_term_meta($term->term_id, 'category_marker', true);
    ?>
    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="category_marker"><?php esc_html_e('Category Marker', 'custom-store-locator'); ?></label>
        </th>
        <td>
            <input type="text" id="category_marker" name="category_marker" value="<?php echo esc_url($value); ?>" placeholder="Marker URL" style="margin-bottom:5px;">
			<button id="upload_category_marker" class="button"><?php esc_html_e('Upload Marker', 'custom-store-locator'); ?></button>
			<button id="remove_category_marker" class="button" <?php if (!$value): ?>style="display:none;"<?php endif; ?>><?php esc_html_e('Remove Marker', 'custom-store-locator'); ?></button>
			<div id="category_marker_preview" style="margin-top:5px;">
				<?php if ($value): ?>
                    <img src="<?php echo esc_url($value); ?>" style="max-width: 100px; max-height: 100px;">
                <?php endif; ?>
			</div>
         </td>
    </tr>
	<script>
    jQuery(document).ready(function ($) {
        // Open the media uploader when the "Upload Marker" button is clicked
        $('#upload_category_marker').on('click', function (e) {
            e.preventDefault();
            // Check if the media uploader is already open to prevent duplicates
            var mediaUploader = wp.media({
                title: '<?php echo esc_js(__('Select Marker', 'custom-store-locator')); ?>',
                button: {
                    text: '<?php echo esc_js(__('Use This Marker', 'custom-store-locator')); ?>'
                },
                multiple: false // Single selection only
            });
            // When a marker is selected
            mediaUploader.on('select', function () {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                $('#category_marker').val(attachment.url); // Set the marker URL in the input field
                $('#category_marker_preview').html('<img src="' + attachment.url + '" style="max-width: 100px; max-height: 100px;">'); // Show a preview of the marker
                $('#remove_category_marker').show(); // Show the "Remove Marker" button
            });
            mediaUploader.open();
        });
        // Remove the marker when the "Remove Marker" button is clicked
        $('#remove_category_marker').on('click', function (e) {
            e.preventDefault();
            $('#category_marker').val(''); // Clear the input field
            $('#category_marker_preview').html(''); // Remove the preview image
            $(this).hide(); // Hide the "Remove Marker" button
        });
    });
</script>
    <?php
}
// Save the category_marker field
function csl_save_category_marker_field($term_id) {
    if (isset($_POST['category_marker'])) {
        update_term_meta($term_id, 'category_marker', esc_url_raw($_POST['category_marker']));
    }
}
function csl_load_media_files() {
    $screen = get_current_screen();
    if ($screen->taxonomy === 'csl_locations_categories') {
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'csl_load_media_files');
/* End of Add the image field to csl_locations_categories taxonomy */