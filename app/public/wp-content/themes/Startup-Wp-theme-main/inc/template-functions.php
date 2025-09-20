<?php

/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Wp-ouie
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function wp_ouie_body_classes($classes) {
    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}

add_filter('body_class', 'wp_ouie_body_classes');

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function wp_ouie_pingback_header() {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
    }
}

add_action('wp_head', 'wp_ouie_pingback_header');

if (!function_exists('wp_ouie_setup')) :

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function wp_ouie_setup() {
        load_theme_textdomain('wp-ouie', get_template_directory() . '/languages');
        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(
                array(
                    'menu-1' => esc_html__('Primary', 'wp-ouie'),
                    // 'menu-2' => esc_html__('Footer Navigation 1', 'wp-ouie'),
                    // 'menu-3' => esc_html__('Footer Navigation 2', 'wp-ouie'),
                    // 'menu-4' => esc_html__('Footer Navigation 3', 'wp-ouie'),
                    // 'menu-5' => esc_html__('Copy', 'wp-ouie'),
                   
                    // 'womens_menu' => esc_html__('Womens', 'wp-ouie'),
                    // 'girls_menu' => esc_html__('Girls', 'wp-ouie'),
                    // 'mens_menu' => esc_html__('Mens', 'wp-ouie'),
                    // 'sale&offers_menu' => esc_html__('Sale & Offers', 'wp-ouie'),
                    // 'giftcards_menu' => esc_html__('Gift cards', 'wp-ouie'),
                    
                )
        );

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support(
                'html5',
                array(
                    'search-form',
                    'comment-form',
                    'comment-list',
                    'gallery',
                    'caption',
                    'style',
                    'script',
                )
        );

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        /**
         * Add support for core custom logo.
         * 		
         */
        add_theme_support(
                'custom-logo',
                array(
                    'height' => 250,
                    'width' => 250,
                    'flex-width' => true,
                    'flex-height' => true,
                )
        );
    }

endif;
add_action('after_setup_theme', 'wp_ouie_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 * 
 */
function wp_ouie_content_width() {
    $GLOBALS['content_width'] = apply_filters('wp_ouie_content_width', 640);
}

add_action('after_setup_theme', 'wp_ouie_content_width', 0);

/**
 * Register widget area.
 *
 */
function wp_ouie_widgets_init() {
    register_sidebar(array(
        'name' => esc_html__('Sidebar', 'wp-ouie'),
        'id' => 'sidebar-1',
        'description' => esc_html__('Add widgets here.', 'wp-ouie'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
            )
    );
    register_sidebar(array(
        'name' => 'Header Search',
        'id' => 'header_search',
        'description' => 'This widget area discription',
        'before_widget' => '<div class="woocommerch-search">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => 'Footer area one',
        'id' => 'footer_area_one',
        'description' => 'This widget area discription',
        'before_widget' => '<section class="footer-area footer-area-one">',
        'after_widget' => '</section>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => 'Footer area two',
        'id' => 'footer_area_two',
        'description' => 'This widget area discription',
        'before_widget' => '<section class="footer-area footer-area-two">',
        'after_widget' => '</section>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => 'Footer area three',
        'id' => 'footer_area_three',
        'description' => 'This widget area discription',
        'before_widget' => '<section class="footer-area footer-area-three">',
        'after_widget' => '</section>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => 'Footer area four',
        'id' => 'footer_area_four',
        'description' => 'This widget area discription',
        'before_widget' => '<section class="footer-area footer-area-three">',
        'after_widget' => '</section>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ));
}

add_action('widgets_init', 'wp_ouie_widgets_init');

// Allow SVG
add_filter('wp_check_filetype_and_ext', function ($data, $file, $filename, $mimes) {

    global $wp_version;
    if ($wp_version !== '4.7.1') {
        return $data;
    }
    $filetype = wp_check_filetype($filename, $mimes);
    return [
'ext' => $filetype['ext'],
 'type' => $filetype['type'],
 'proper_filename' => $data['proper_filename']
    ];
}, 10, 4);

function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}

add_filter('upload_mimes', 'cc_mime_types');


/* Custom Post Type */
function cptui_register_my_cpts() {

	/**
	 * Post Type: Testmonial.
	 */

	$labels = [
		"name" => esc_html__( "Testmonial", "wp-ouie" ),
		"singular_name" => esc_html__( "Testmonial", "wp-ouie" ),
	];

	$args = [
		"label" => esc_html__( "Testmonial", "wp-ouie" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"rest_namespace" => "wp/v2",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => false,
		"rewrite" => [ "slug" => "testmonial", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor", "thumbnail" ],
		"show_in_graphql" => false,
	];

	register_post_type( "testmonial", $args );

	/**
	 * Post Type: Jobs.
	 */

//	$labels = [
//		"name" => esc_html__( "Jobs", "twentytwentyone" ),
//		"singular_name" => esc_html__( "Job", "twentytwentyone" ),
//	];
//
//	$args = [
//		"label" => esc_html__( "Jobs", "twentytwentyone" ),
//		"labels" => $labels,
//		"description" => "",
//		"public" => true,
//		"publicly_queryable" => true,
//		"show_ui" => true,
//		"show_in_rest" => true,
//		"rest_base" => "",
//		"rest_controller_class" => "WP_REST_Posts_Controller",
//		"rest_namespace" => "wp/v2",
//		"has_archive" => false,
//		"show_in_menu" => true,
//		"show_in_nav_menus" => true,
//		"delete_with_user" => false,
//		"exclude_from_search" => false,
//		"capability_type" => "post",
//		"map_meta_cap" => true,
//		"hierarchical" => false,
//		"can_export" => false,
//		"rewrite" => [ "slug" => "job", "with_front" => true ],
//		"query_var" => true,
//		"supports" => [ "title", "editor", "thumbnail", "excerpt" ],
//		"show_in_graphql" => false,
//	];
//
//	register_post_type( "job", $args );
}

add_action( 'init', 'cptui_register_my_cpts' );
