<?php
/**
 * The plugin file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.devxcel.com/
 * @since             1.0.0
 * @package           Custom_Store_Locator
 *
 * @wordpress-plugin
 * Plugin Name:       Custom WP Store Locator
 * Plugin URI:        https://www.devxcel.com/
 * Description:       This is store locator plugin which provide search stores and other functionality.
 * Version:           1.5.1.1
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            Metatagg Inc
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       custom-store-locator
 * Domain Path:       /languages
 */
/*
Custom WP Store Locator is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
Custom WP Store Locator is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with Custom WP Store Locator. If not, see {License URI}
*/
defined( 'ABSPATH' ) or die( 'Hey, what are you doing here? You silly human!' );
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}
/* Global Constants */
define( 'CSL_URL', plugins_url('custom-store-locator', dirname(__FILE__) ) );
define( 'CSL_BASE_FILE', __FILE__ );
define( 'CSL_PATH', dirname( CSL_BASE_FILE ) );
/* End of Global Constants */
use CSLInc\Activate;
use CSLInc\Deactivate;
if ( !class_exists( 'CustomStoreLocatorPlugin' ) ) {
	class CustomStoreLocatorPlugin
	{
		public $plugin;
		function __construct() {
			$this->plugin = plugin_basename( __FILE__ );
			/* Functions */
			require plugin_dir_path( __FILE__ ) . 'inc/Csl-functions.php'; 
			/* End of Functions */ 
		}
		function csl_register() {
			add_action( 'wp_enqueue_scripts', array( $this, 'csl_enqueue' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'csl_admin_enqueue' ) );
			add_action( 'admin_menu', array( $this, 'csl_add_admin_pages' ) );
            add_filter( "plugin_action_links_$this->plugin", array( $this, 'csl_settings_link' ) );
			add_action( 'init', array( $this, 'csl_custom_post_type' ) );
			add_action( 'admin_init', array( $this, 'csl_register_settings' ) );
			add_action( 'admin_notices', array( $this, 'csl_error_notice' ));
			add_filter( 'manage_csl_locations_posts_columns', array( $this, 'csl_manage_csl_locations_posts_columns' ));
		}
		function csl_register_settings() {
			add_option( 'csl_map_api_key', '');
			register_setting( 'csl_options_group', 'csl_map_api_key', 'csl_callback' );
			add_option( 'csl_map_default_radius', '');
			register_setting( 'csl_options_group', 'csl_map_default_radius', 'csl_callback' );
			add_option( 'csl_include_cat', '');
			register_setting( 'csl_options_group', 'csl_include_cat', 'csl_callback' );
			add_option( 'csl_include_title', '');
			register_setting( 'csl_options_group', 'csl_include_title', 'csl_callback' );
			add_option( 'csl_map_type', '');
			register_setting( 'csl_options_group', 'csl_map_type', 'csl_callback' );
			add_option( 'csl_custom_map_marker', '');
			register_setting( 'csl_options_group', 'csl_custom_map_marker', 'csl_callback' );
			add_option( 'csl_location_default_sorting', '');
			register_setting( 'csl_options_group', 'csl_location_default_sorting', 'csl_callback' );
			add_option( 'csl_map_layout', '');
			register_setting( 'csl_options_group', 'csl_map_layout', 'csl_callback' );
			add_option( 'csl_primary_color', '');
			register_setting( 'csl_options_group', 'csl_primary_color', 'csl_callback' );
			add_option( 'csl_primary_color_dark', '');
			register_setting( 'csl_options_group', 'csl_secondary_color', 'csl_callback' );
			add_option( 'csl_secondary_color_light', '');
			register_setting( 'csl_options_group', 'csl_fullwidth_include_loc', 'csl_callback' );
			add_option( 'csl_autocompletesearchbox', '');
			register_setting( 'csl_options_group', 'csl_autocompletesearchbox', 'csl_callback' );
			add_option( 'csl_country_restriction', '');
			register_setting( 'csl_options_group', 'csl_country_restriction', 'csl_callback' );
			add_option( 'csl_distance_units', '');
			register_setting( 'csl_options_group', 'csl_distance_units', 'csl_callback' );
			add_option( 'csl_map_default_zoom', '');
			register_setting( 'csl_options_group', 'csl_map_default_zoom', 'csl_callback' );
			add_option( 'csl_disable_clustermarker', '');
			register_setting( 'csl_options_group', 'csl_disable_clustermarker', 'csl_callback' );
			add_option( 'csl_hide_phone', '');
			register_setting( 'csl_options_group', 'csl_hide_phone', 'csl_callback' );
			add_option( 'csl_hide_email', '');
			register_setting( 'csl_options_group', 'csl_hide_email', 'csl_callback' );
			add_option( 'csl_hide_fax', '');
			register_setting( 'csl_options_group', 'csl_hide_fax', 'csl_callback' );
			add_option( 'csl_hide_website', '');
			register_setting( 'csl_options_group', 'csl_hide_website', 'csl_callback' );
			add_option( 'csl_hide_hours', '');
			register_setting( 'csl_options_group', 'csl_hide_hours', 'csl_callback' );
		 }
		function csl_error_notice() {
			if(empty(get_option('csl_map_api_key'))) {
			?>
			<div class="error notice">
			<p><?php esc_html_e( 'Please add google map api key on setting for map to work.', 'custom-store-locator' ); ?></p>
			</div>
			<?php
			}
		}
		public function csl_settings_link( $links ) {
			$settings_link = '<a href="admin.php?page=store_plugin">Settings</a>';
			array_push( $links, $settings_link );
			return $links;
		}
		public function csl_add_admin_pages() {
			add_menu_page( __( "Store Locator", "custom-store-locator" ), __( "Store Locator", "custom-store-locator" ), 'manage_options', 'store_plugin', array( $this, 'csl_admin_index' ), 'dashicons-store', 110 );
			add_submenu_page( 'store_plugin', __( "About", "custom-store-locator" ), __( "About", "custom-store-locator" ), 'manage_options', 'store_plugin');
			add_submenu_page( 'store_plugin', __( "Settings", "custom-store-locator" ), __( "Settings", "custom-store-locator" ), 'manage_options', 'store_plugin_settings', array( $this, 'csl_admin_settings' ));
		}
		public function csl_admin_index() {
			require_once plugin_dir_path( __FILE__ ) . 'templates/admin.php';
		}
		public function csl_admin_settings() {
			require_once plugin_dir_path( __FILE__ ) . 'templates/adminsettings.php';
		}
		function csl_custom_post_type() {
			register_post_type( 
				'csl_locations', 
				['public' => true, 
				'menu_icon' => 'dashicons-location-alt', 
				'label' => __( "Locations", "custom-store-locator" ),
				'supports' => array( 'title', 'author', 'page-attributes', 'thumbnail'),
				] 
			);
			register_taxonomy(
				'csl_locations_categories',
				'csl_locations',
				array(
					'hierarchical' => true,
					'label' => __( "Location Categories", "custom-store-locator" ),
					'query_var' => true,
					'show_in_quick_edit' => true,
					'show_admin_column' => true,
					'rewrite' => array(
						'slug' => 'csl-locations-categories',
						'with_front' => false
					)
				)
			);			
		}

		function csl_manage_csl_locations_posts_columns( $columns ) {
			$columns = array(
		      	'cb' => $columns['cb'],
		      	'title' => __( "Title", "custom-store-locator" ),
		      	'taxonomy-csl_locations_categories' => 'Location Categories',
		      	'author' => 'Author',
		      	'date' => 'Date',
		    );		  	
		  	return $columns;
		}
		function csl_enqueue() {
			$csl_map_layout = get_option('csl_map_layout');
			
			// enqueue all our scripts
			if ( ! wp_script_is( 'jquery', 'enqueued' )) {
				wp_enqueue_script( 'jquery' );
			}
			
			wp_enqueue_script( 'csl-pluginscript', plugins_url( '/assets/csl-custom-script.js', __FILE__ ), array(), null  );
			$api_key = get_option('csl_map_api_key');
			if ($api_key) {
				wp_register_script('csl-gmapscript', '//maps.googleapis.com/maps/api/js?&key=' . esc_attr($api_key) . '&libraries=geometry,places', array(), '', true);
				wp_script_add_data('csl-gmapscript', 'async defer', true);
			}
			wp_enqueue_script( 'csl-markerclusterer', plugins_url( '/assets/markerclusterer.js', __FILE__ ), array( 'jquery', 'csl-gmapscript' ), false, true );
			if(!empty($csl_map_layout) && $csl_map_layout == "fullwidth")
			{
				wp_enqueue_style( 'csl-pluginstyle', plugins_url( '/assets/csl-custom-style.css', __FILE__ ), array(), null  );
				$default_primary = '#ee5253';
				$default_secondary = '#222f3e';
				$default_root = '--secondary-light: #f1f1f1;--text-color: #231f20;--white: #ffffff;--black: #000000;--scrollbar-track: #cccccc;';
				wp_enqueue_script( 'csl-mapscript', plugins_url( '/assets/csl-full-map-functions.js', __FILE__ ), array( 'jquery', 'csl-gmapscript' ), false, true);				
			}
			elseif(!empty($csl_map_layout) && $csl_map_layout == "style1") {
				global $post;
				$has_shortcode = false;
				if ($post) {
		            if (has_shortcode($post->post_content, 'csl-store-list')) {
		                $has_shortcode = true;
		            }
		        }
		        if($has_shortcode) {
		        	wp_enqueue_style( 'csl-pluginbootstrap', plugins_url( '/assets/style/css/bootstrap.min.css', __FILE__ ), array(), null  );	
		        }
				wp_enqueue_style( 'csl-pluginstyle', plugins_url( '/assets/style/css/style1.css', __FILE__ ), array(), null  );	
				$default_primary = '#1e272e';
				$default_secondary = '#808e9b';
				$default_root = "--lightgray: #f6f6f6;--gray: #eaeaea;--white: #ffffff;--darkgray: #6f6f6f;--black: #000000;";
				wp_enqueue_script( 'csl-mapscript', plugins_url( '/assets/style/csl-map-style-1.js', __FILE__ ), array( 'jquery', 'csl-gmapscript' ), false, true);
			}
			/*elseif(!empty($csl_map_layout) && $csl_map_layout == "style2") {
				wp_enqueue_style( 'csl-pluginstyle', plugins_url( '/assets/style/css/style2.css', __FILE__ ), array(), null  );
				$default_primary = '#1e272e';
				$default_secondary = '#808e9b';
				$default_root = "--lightgray: #f6f6f6;--gray: #eaeaea;--white: #ffffff;";
				wp_enqueue_script( 'csl-mapscript', plugins_url( '/assets/style/csl-map-style-2.js', __FILE__ ), array( 'jquery', 'csl-gmapscript' ), false, true);
			}
			elseif(!empty($csl_map_layout) && $csl_map_layout == "style3") {
				wp_enqueue_style( 'csl-pluginstyle', plugins_url( '/assets/style/css/style3.css', __FILE__ ), array(), null  );
				$default_primary = '#1e272e';
				$default_secondary = '#808e9b';
				$default_root = "--lightgray: #f6f6f6;--gray: #eaeaea;--white: #ffffff;";
				wp_enqueue_script( 'csl-mapscript', plugins_url( '/assets/style/csl-map-style-3.js', __FILE__ ), array( 'jquery', 'csl-gmapscript' ), false, true);
			}*/
			else
			{
				wp_enqueue_style( 'csl-pluginstyle', plugins_url( '/assets/csl-custom-style.css', __FILE__ ), array(), null  );
				$default_primary = '#ee5253';
				$default_secondary = '#222f3e';
				$default_root = '--secondary-light: #f1f1f1;--text-color: #231f20;--white: #ffffff;--black: #000000;--scrollbar-track: #cccccc;';
				wp_enqueue_script( 'csl-mapscript', plugins_url( '/assets/csl-map-functions.js', __FILE__ ), array( 'jquery', 'csl-gmapscript' ), null, true );				
			}

			$csl_primary_color = esc_attr(get_option('csl_primary_color'));
			$csl_secondary_color = esc_attr(get_option('csl_secondary_color'));		    
			$color_vars = '';
			if(!empty($csl_primary_color)) {
				$color_vars .= "--primary-color: {$csl_primary_color};";
			}else{
				$color_vars .= "--primary-color: {$default_primary};";
			}
			if(!empty($csl_secondary_color)) {
				$color_vars .= "--secondary-color: {$csl_secondary_color};";
			}else{
				$color_vars .= "--secondary-color: {$default_secondary};";
			}
			$custom_css = "
	        	:root {
				    {$color_vars}
				    {$default_root}				    
				}
	    	";
	    	wp_add_inline_style('csl-pluginstyle', $custom_css);

	    	$csl_autocompletesearchbox = get_option('csl_autocompletesearchbox');
			if ($csl_autocompletesearchbox === "yes") {
				$usrAddPlaceholder = __('Address or Zipcode', 'custom-store-locator');
			}else{
				$usrAddPlaceholder = __('Zipcode', 'custom-store-locator');
			}
			wp_localize_script( 'csl-mapscript', 'mapscript_object',
				array( 
					'get_direction' => __( "Get Direction", "custom-store-locator" ),
					'no_loc_in_area' =>  __( "No locations found. Please search again", "custom-store-locator" ),
					'loc_near_me' =>  __( "Locations near Me", "custom-store-locator" ),
					'loc_near_in' =>  __( "Locations near", "custom-store-locator" ),
					'view_on_map' =>  __( "View on Map", "custom-store-locator" ),
					'no_locations_in' =>  __( "Sorry, no locations were found near", "custom-store-locator" ),
					'street_view' =>  __( "Street View", "custom-store-locator" ),
					'miles_away' =>  __( "Miles Away", "custom-store-locator" ),
					'kms_away' =>  __( "KM Away", "custom-store-locator" ),
					'csl_url' =>  CSL_URL,
					'store_name' => __( "Store Name", "custom-store-locator" ),
					'usrAddPlaceholder' => $usrAddPlaceholder,
				)
			);
		}
		function csl_admin_enqueue() {
			$args_map = array(
				'key' => get_option('csl_map_api_key'),
				'libraries' => 'geometry,places'
			);
			wp_enqueue_style( 'csl-pickr', plugins_url( '/assets/csl-pickr.css', __FILE__ ), array(), null  );
			wp_enqueue_script( 'csl-pickr', plugins_url( '/assets/csl-pickr.js', __FILE__ ), array( 'jquery' ), false, true );
			wp_enqueue_script( 'csl-gmapscript', add_query_arg( $args_map, '//maps.googleapis.com/maps/api/js'),  array('jquery'), false, false );
			wp_enqueue_script( 'csl-mapscript', plugins_url( '/assets/csl-map-functions.js', __FILE__ ), array( 'jquery', 'csl-gmapscript' ), false, true );
		}
		function activate() {
			Activate::activate();
		}
		function deactivate() {
			Deactivate::deactivate();
		}
	}
	$storeLocatorPlugin = new CustomStoreLocatorPlugin();
    $storeLocatorPlugin->csl_register();
	// trigger when plugin activate
	register_activation_hook( __FILE__, array( $storeLocatorPlugin, 'activate' ) );
	// trigger when plugin deactivate
	register_deactivation_hook( __FILE__, array( $storeLocatorPlugin, 'deactivate' ) );
}