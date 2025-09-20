<?php

/**
 * Wp-Yeasfi functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Wp-ouie
 */
if (!defined('_S_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_S_VERSION', '1.0.0');
}


/**
 * Enqueue scripts and styles.
 */
function wp_ouie_scripts()
{
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), _S_VERSION);
    //wp_enqueue_style('google-font','https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    wp_enqueue_style('wp-ouie-animate', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.1.0/animate.min.css');
    wp_enqueue_style('responsive', get_template_directory_uri() . '/css/responsive.css');
    wp_enqueue_style('Montserrat',  'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');
    wp_enqueue_style('wp-ouie-style', get_stylesheet_uri(), array(), _S_VERSION);


    wp_enqueue_style('splide', get_template_directory_uri() . '/css/splide.min.css');

    wp_enqueue_script('wp-ouie-splide', get_template_directory_uri() . '/js/splide.min.js', array(), _S_VERSION, true);
    //wp_enqueue_script('wp-ouie-splide-video', get_template_directory_uri() . '/js/splide-extension-video.js', array(), _S_VERSION, true);   


    wp_enqueue_script('wp-ouie-jquery', get_template_directory_uri() . '/js/jquery-3.6.1.min.js', array(), _S_VERSION, true);
    wp_enqueue_script('wp-ouie-bootstrap', get_template_directory_uri() . '/js/bootstrap.bundle.min.js', array(), _S_VERSION, true);
    wp_enqueue_script('wp-ouie-wow', 'https://cdnjs.cloudflare.com/ajax/libs/wow/0.1.12/wow.min.js', array(), _S_VERSION, true);
    wp_enqueue_script('wp-ouie-custome', get_template_directory_uri() . '/js/customizer.js', array(), _S_VERSION, true);

    wp_enqueue_script('wp-ouie-fontawsom',  'https://kit.fontawesome.com/81eaa733c5.js', array(), _S_VERSION, true);


   

}

add_action('wp_enqueue_scripts', 'wp_ouie_scripts');

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    require get_template_directory() . 'jetpack.php';
}


/**
 * Register Carbon Field
 */
require get_template_directory() . '/carbonfield.php';


/**
 * Woocommerce
 */
add_action('after_setup_theme', 'woocommerce_support');
function woocommerce_support()
{
    add_theme_support('woocommerce');
}


/*
  Variation radio button
 *  */


add_action('woocommerce_variable_add_to_cart', function () {
    add_action('wp_print_footer_scripts', function () {
?>
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                console.log('Script loaded');

                // Find the variations form
                var variationsForm = document.querySelector('form.variations_form');
                if (!variationsForm) {
                    console.error('Variations form not found');
                    return;
                }

                console.log('Variations form found');
                var variationsData = variationsForm.getAttribute('data-product_variations');
                if (!variationsData) {
                    console.error('Product variations data not found');
                    return;
                }

                variationsData = JSON.parse(variationsData);
                // Locate the select dropdowns
                document.querySelectorAll('table.variations select').forEach(function(select) {
                    console.log('Processing select element:', select);

                    // Only process if the name is "attribute_pa_color"
                    if (select.getAttribute('name') === 'attribute_pa_color') {
                        console.log('Processing color attribute:', select);

                        // Create a wrapper for all variations related to this select
                        var wrapper = document.createElement('div');
                        var variationType = select.getAttribute('name'); // Get the variation name
                        wrapper.className = 'variation-wrapper-group';
                        wrapper.setAttribute('data-variation-type', variationType);
                        wrapper.id = 'variation-' + variationType.replace('attribute_', '');

                        // Insert the wrapper before the select
                        select.closest('td').appendChild(wrapper);

                        // Create radio buttons with color swatches for each option
                        select.querySelectorAll('option').forEach(function(option) {
                            if (!option.value) return; // Skip empty options

                            var span = document.createElement('span');
                            span.className = 'variation-radio-group';

                            // Create the color swatch
                            var colorSwatch = document.createElement('div');
                            colorSwatch.className = 'color-swatch';
                            colorSwatch.style.width = '100%';
                            colorSwatch.style.height = '100%';
                            colorSwatch.style.borderRadius = '5px';
                            colorSwatch.style.marginRight = '10px';
                            colorSwatch.style.display = 'block';
                            colorSwatch.style.position = 'absolute';
                            colorSwatch.style.top = '0';
                            colorSwatch.style.left = '0';

                            // Set the background color based on the variation name
                            var colorName = option.value.toLowerCase(); // E.g., "Red"
                            colorSwatch.style.backgroundColor = colorName; // Assumes the color name matches a valid CSS color

                            // Create the radio input
                            var radio = document.createElement('input');
                            radio.type = 'radio';
                            radio.name = select.name;
                            radio.value = option.value;
                            radio.id = option.value;

                            // Create the label
                            var label = document.createElement('label');
                            label.className = 'variation-label-wrapper';
                            label.htmlFor = option.value;

                            // Add the color swatch and the variation name to the label
                            label.appendChild(colorSwatch);
                            //label.appendChild(document.createTextNode(option.text)); // Variation name

                            span.appendChild(radio);
                            span.appendChild(label);

                            // Add event listener for radio button selection
                            radio.addEventListener('click', function() {
                                select.value = radio.value;
                                jQuery(select).trigger('change'); // Trigger WooCommerce change event
                            });

                            wrapper.appendChild(span); // Append the variation group to the wrapper
                        });

                        // Hide the original select dropdown
                        select.style.display = 'none';
                    }
                });
            });
        </script>

        <style>
            /* Styling for color swatches */
            .color-swatch {
                border: 1px solid #ccc;
                cursor: pointer;
            }

            .color-swatch:hover {
                border: 2px solid #000;
            }

            .variation-label-wrapper {
                display: flex;
                align-items: center;
                margin-bottom: 10px;
            }
        </style>
    <?php
    });
});

// Remove default sale flash from the image
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);

// Add custom sale flash above the title
add_action('woocommerce_single_product_summary', 'my_custom_sale_flash_above_title', 4);
add_action('woocommerce_before_shop_loop_item_title', 'my_custom_sale_flash_above_title', 10);

function my_custom_sale_flash_above_title()
{
    global $product;

    $regular_price = 0;
    $sale_price = 0;

    // Handle variable products
    if ($product->is_type('variable')) {
        $regular_price = $product->get_variation_regular_price('min', true);
        $sale_price = $product->get_variation_sale_price('min', true);
    } else {
        // Handle single products
        $regular_price = (float) $product->get_regular_price();
        $sale_price = (float) $product->get_sale_price();
    }

    // Display the sale percentage only if sale_price is greater than 0
    if ($regular_price > 0 && $sale_price > 0 && $sale_price < $regular_price) {
        $percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
        echo '<div class="custom-onsale"> -' . $percentage . '%</div>';
    }
}



// Remove the default placement of the excerpt
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);



// Add the size button after the product excerpt
// Add the size button before the quantity button
add_action('woocommerce_after_add_to_cart_form', 'add_sizebutton');
function add_sizebutton()
{
    ?>
    <div class="freeclick">
        <h3><i class="fas fa-hand-pointer"></i> FREE Click & Collect on orders over £25.</h3>
        <div class="gidebutton-wrapper">
            <button type="button" style="margin-bottom: 10px; padding: 5px 10px;" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">Size Guide</button>
            <button type="button" style="margin-bottom: 10px; padding: 5px 10px;" data-bs-toggle="offcanvas" href="#offcanvasExample2" role="button" aria-controls="offcanvasExample">Delivery options</button>
        </div>
    </div>
<?php
}


// Add the excerpt after the product meta
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 41);

// Wrap quantity input and buttons in a common div


add_action('woocommerce_before_quantity_input_field', 'bbloomer_display_quantity_minus');

function bbloomer_display_quantity_minus()
{
    if (! is_product()) return;
    echo '<button type="button" class="minus" >-</button>';
}

add_action('woocommerce_after_quantity_input_field', 'bbloomer_display_quantity_plus');

function bbloomer_display_quantity_plus()
{
    if (! is_product()) return;
    echo '<button type="button" class="plus" >+</button>';
}

add_action('woocommerce_before_single_product', 'bbloomer_add_cart_quantity_plus_minus');

function bbloomer_add_cart_quantity_plus_minus()
{
    wc_enqueue_js("
      $('form.cart').on( 'click', 'button.plus, button.minus', function() {
            var qty = $( this ).closest( 'form.cart' ).find( '.qty' );
            var val   = parseFloat(qty.val());
            var max = parseFloat(qty.attr( 'max' ));
            var min = parseFloat(qty.attr( 'min' ));
            var step = parseFloat(qty.attr( 'step' ));
            if ( $( this ).is( '.plus' ) ) {
               if ( max && ( max <= val ) ) {
                  qty.val( max );
               } else {
                  qty.val( val + step );
               }
            } else {
               if ( min && ( min >= val ) ) {
                  qty.val( min );
               } else if ( val > 1 ) {
                  qty.val( val - step );
               }
            }
         });
   ");
}



/** Size Gide */
function register_size_guide_post_type()
{
    register_post_type(
        'size_guide',
        array(
            'labels' => array(
                'name' => 'Size Guides',
                'singular_name' => 'Size Guide',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Size Guide',
                'edit_item' => 'Edit Size Guide',
                'new_item' => 'New Size Guide',
                'view_item' => 'View Size Guide',
                'search_items' => 'Search Size Guides',
                'not_found' => 'No size guides found',
                'not_found_in_trash' => 'No size guides found in Trash',
                'parent_item_colon' => '',
                'all_items' => 'All Size Guides',
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail'),
            'menu_icon' => 'dashicons-welcome-widgets-menus',
            'show_in_rest' => true, // Optional: Enable block editor support
        )
    );
}
add_action('init', 'register_size_guide_post_type');



/**  */

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', 'add_size_guide_select_to_products');

function add_size_guide_select_to_products()
{
    // Create a container for custom fields on products
    Container::make('post_meta', 'Size Guide')
        ->where('post_type', '=', 'product') // Apply to WooCommerce products
        ->add_fields(array(
            Field::make('select', 'size_guide_select', 'Size Guide')
                ->set_options(get_size_guides_for_select()) // Dynamically load size guides from the post type
                ->set_help_text('Select a size guide for this product.')
        ));
}

// Function to dynamically fetch size guides from the 'size_guide' custom post type
function get_size_guides_for_select()
{
    $size_guides = get_posts(array(
        'post_type' => 'size_guide', // Use the custom post type
        'posts_per_page' => -1, // Get all size guides
        'post_status' => 'publish', // Only get published size guides
    ));

    $options = array();

    if (! empty($size_guides)) {
        foreach ($size_guides as $guide) {
            $options[$guide->ID] = $guide->post_title; // Use the post ID as the value and the title as the label
        }
    }

    return $options;
}


function register_shop_sidebar()
{
    register_sidebar([
        'name'          => __('Shop Sidebar', 'your-theme'),
        'id'            => 'shop-sidebar',
        'description'   => __('Widgets added here will appear on the WooCommerce shop page.', 'your-theme'),
        'before_widget' => '<div class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ]);
}
add_action('widgets_init', 'register_shop_sidebar');




// function custom_disable_add_to_cart_for_guests() {
//     if ( ! is_user_logged_in() ) {
//         remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
//         remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
//     }
// }
// add_action( 'init', 'custom_disable_add_to_cart_for_guests' );




/**
 * 
 * custom_disable_add_to_cart_for_guests
 */
/**
 * Main function to control catalog mode for guest users.
 */
function custom_catalog_mode_for_guests() {
    if ( ! is_user_logged_in() ) {
        // Always hide the "Add to Cart" button for guests.
        // It's safe to add this on the `init` hook as it will apply everywhere.
        add_action( 'woocommerce_after_shop_loop_item', 'custom_hide_add_to_cart_loop', 9 );
        add_action( 'woocommerce_single_product_summary', 'custom_hide_add_to_cart_single', 29 );
        
        // Always hide the price for guests.
        add_filter( 'woocommerce_get_price_html', 'custom_hide_price_for_guests', 99, 2 );
    }
}
add_action( 'init', 'custom_catalog_mode_for_guests' );

/**
 * Replaces the "Add to Cart" button on shop archives.
 * We'll hide this on shop page and add the custom text on single product page.
 */
function custom_hide_add_to_cart_loop() {
    // This function doesn't add anything, it just provides a hook to remove the default button.
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
}

/**
 * Replaces the "Add to Cart" button on single product page.
 */
function custom_hide_add_to_cart_single() {
    // Hide the default button first
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
    
    // Check if we are on a single product page before adding the custom content
    if ( is_product() ) {
        custom_display_price_access_message();
    }
}

/**
 * Hides the price for guest users.
 */
function custom_hide_price_for_guests( $price, $product ) {
    if ( ! is_user_logged_in() ) {
        return ''; // Return an empty string to hide the price.
    }
    return $price;
}

/**
 * Outputs the custom message, SVG, and buttons.
 */
function custom_display_price_access_message() {
    $login_url = get_permalink( wc_get_page_id( 'myaccount' ) );
    
    echo '<div class="accessprice-div">
              <span class="svgicon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                      <path d="M6 22.3901C5.45 22.3901 4.97917 22.1943 4.5875 21.8026C4.19583 21.411 4 20.9401 4 20.3901V10.3901C4 9.84014 4.19583 9.3693 4.5875 8.97764C4.97917 8.58597 5.45 8.39014 6 8.39014H7V6.39014C7 5.0068 7.4875 3.82764 8.4625 2.85264C9.4375 1.87764 10.6167 1.39014 12 1.39014C13.3833 1.39014 14.5625 1.87764 15.5375 2.85264C16.5125 3.82764 17 5.0068 17 6.39014V8.39014H18C18.55 8.39014 19.0208 8.58597 19.4125 8.97764C19.8042 9.3693 20 9.84014 20 10.3901V20.3901C20 20.9401 19.8042 21.411 19.4125 21.8026C19.0208 22.1943 18.55 22.3901 18 22.3901H6ZM6 20.3901H18V10.3901H6V20.3901ZM12 17.3901C12.55 17.3901 13.0208 17.1943 13.4125 16.8026C13.8042 16.411 14 15.9401 14 15.3901C14 14.8401 13.8042 14.3693 13.4125 13.9776C13.0208 13.586 12.55 13.3901 12 13.3901C11.45 13.3901 10.9792 13.586 10.5875 13.9776C10.1958 14.3693 10 14.8401 10 15.3901C10 15.9401 10.1958 16.411 10.5875 16.8026C10.9792 17.1943 11.45 17.3901 12 17.3901ZM9 8.39014H15V6.39014C15 5.5568 14.7083 4.84847 14.125 4.26514C13.5417 3.6818 12.8333 3.39014 12 3.39014C11.1667 3.39014 10.4583 3.6818 9.875 4.26514C9.29167 4.84847 9 5.5568 9 6.39014V8.39014Z" fill="black"/>
                  </svg>
              </span>
              <h3>Access professional prices</h3>
              Create an account to access our exclusive prices and professional offers.
          </div>';
    echo '<a href="' . esc_url( $login_url ) . '" class="button">Sign In</a> ';
    echo '<a href="' . esc_url( $login_url ) . '" class="button">Sign Up</a>'; // Login and registration are often on the same page.
}