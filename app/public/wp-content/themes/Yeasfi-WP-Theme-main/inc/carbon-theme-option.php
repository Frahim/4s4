<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use Carbon_Fields\Block;

add_action( 'carbon_fields_register_fields', 'ywt_attach_theme_options' );
function ywt_attach_theme_options() {
    $basic_options_container = Container::make( 'theme_options', __( 'Theme Options' ) )   
        ->set_icon( 'dashicons-screenoptions' ) 
        ->add_fields( array(
            Field::make( 'html', 'ywt_information_text' )
            ->set_html( '<h2 class="theme-name">Yeasfi Wp Theme Option</h2><p>Developer: MD Yeasir Arafat</p>' ), 

            Field::make( 'header_scripts', 'ywt_header_script', __( 'Header Script' ) ),
            Field::make( 'footer_scripts', 'ywt_footer_script', __( 'Footer Script' ) ),             
        ) );

    // Add second options page under 'Basic Options'
    Container::make( 'theme_options', 'Basic Information' )   
    ->set_page_parent( $basic_options_container ) // reference to a top level container
    ->add_fields( array(
        Field::make( 'html', 'ywt_information_text' )
        ->set_html( '<h2 class="theme-name">Yeasfi Wp Theme Option</h2><p>Developer: MD Yeasir Arafat</p>' ), 
        Field::make( 'image', 'ywt_logo', __( 'Logo' ) ),
        Field::make( 'image', 'ywt_fevicon', __( 'Favicon' ) ),
        Field::make( 'textarea', 'ywt_tagline', __( 'Tagline' ) ),
        Field::make( 'separator', 'ywt_separator', __( 'Contact Information' ) ),
        Field::make( 'complex', 'ywt_contact', __( 'Contact' ) )
        ->add_fields( array(
        Field::make( 'text', 'ywt_email', __( 'Email' ) ),
        Field::make( 'text', 'ywt_phone', __( 'Phone' ) ),  
        ) ),      
        Field::make( 'complex', 'ywt_address', __( 'Address' ) )
        ->add_fields( array(
        Field::make( 'textarea', 'ywt_street_address', __( 'Street Address' ) ),
        Field::make( 'text', 'ywt_city', __( 'City' ) ),
        Field::make( 'text', 'ywt_state', __( 'State' ) ),
        Field::make( 'text', 'ywt_zip', __( 'ZIP Code' ) ),
        ) )

    ) );
// Header
    Container::make( 'theme_options', __( 'Header' ) )      
        ->set_page_parent( $basic_options_container ) // reference to a top level container
        ->add_fields( array(
            Field::make( 'html', 'ywt_information_text' )
            ->set_html( '<h2 class="theme-name">Yeasfi Wp Theme Option</h2><p>Developer: MD Yeasir Arafat</p>' ),   
            Field::make( 'separator', 'ywt_separator_menu', __( 'Primary Menu Style' ) ),
            Field::make( 'color', 'ywt_menu_text_color', __( 'Primary Menu Text Color' ) ),
            Field::make( 'color', 'ywt_menu_hover_text_color', __( 'Primary Menu Text Hover Color' ) )
                
    ) );
// Page Layout  Setup
  $pagesetup = Container::make( 'theme_options', __( 'Page Layout' ) )      
    ->set_page_parent( $basic_options_container ) // reference to a top level container
    ->add_fields( array(
        Field::make( 'html', 'ywt_information_text' )
        ->set_html( '<h2 class="theme-name">Yeasfi Wp Theme Option</h2><p>Developer: MD Yeasir Arafat</p>' ),   
        Field::make( 'separator', 'ywt_separator2', __( 'Defolt Page Layout Option' ) ),
        Field::make( 'checkbox', 'ywt_show_content', 'Cleck Hear to Show Defolt Page Layout Option' ),
        // Field::make( 'sidebar', 'ywt_custom_sidebar', __( 'Select a Sidebar' ) )
        // ->set_conditional_logic( array(
		// 	array('field' => 'ywt_show_content','value' => true,)
        //     ) ),
        Field::make( 'select', 'ywt_container_select', __( 'Select container type' ) )
        ->add_options( array(
                'container' => __( 'Container' ),              
                'container-md' => __( 'Container-md' ),
                'container-lg' => __( 'Container-lg' ),
                'container-xl' => __( 'Container-xl' ),
                'container-xxl' => __( 'Container-xxl' ),
                'container-fluid' => __( 'Container-fluid' ),  
                'container-custome' => __( 'Container Custome' ),                             
        ) )
        ->set_conditional_logic( array(
			array('field' => 'ywt_show_content','value' => true,)
            ) ),
        Field::make( 'text', 'ywt_content', 'Content' )
            ->set_conditional_logic( array(
			array('field' => 'ywt_show_content','value' => true,)
            ) ),
        Field::make( 'text', 'ywt_tes', 'Content' )
            ->set_conditional_logic( array(
			array('field' => 'ywt_show_content','value' => true,)
            ) ),    
        Field::make( 'separator', 'ywt_separator3', __( 'Post Page Layout Option' ) ),
                
    ) );
// Social link
    Container::make( 'theme_options', __( 'Social Links' ) )      
        ->set_page_parent( $basic_options_container ) // reference to a top level container
        ->add_fields( array(
            Field::make( 'html', 'ywt_information_text' )
            ->set_html( '<h2 class="theme-name">Yeasfi Wp Theme Option</h2><p>Developer: MD Yeasir Arafat</p>' ),   
            Field::make( 'complex', 'ywt_social_link', __( 'Social_link' ) )
                ->add_fields( array(
                Field::make( 'icon', 'ywt_social_icon', __( 'Icon' ) ),       
                Field::make( 'text', 'ywt_social_url', __( 'Link' ) ),           
            ) ), 
            Field::make( 'color', 'ywt_social_color', __( 'Icon Color' ) ),
            Field::make( 'color', 'ywt_social_hover_color', __( 'Icon Hover Color' ) )
                     
    ) );

// Add third options page under "Appearance"
    Container::make( 'theme_options', __( 'Customize Background' ) )
        ->set_page_parent( $basic_options_container ) // reference to a top level container
        ->add_fields( array(
            Field::make( 'html', 'ywt_information_text' )
            ->set_html( '<h2 class="theme-name">Yeasfi Wp Theme Option</h2><p>Developer: MD Yeasir Arafat</p>' ),                
            Field::make( 'color', 'ywt_background_color', __( 'Background Color' ) ),
            Field::make( 'image', 'ywt_background_image', __( 'Background Image' ) ),
        ) );
   


//Block

Block::make( __( 'Banner' ) )
	->add_fields( array(
		Field::make( 'text', 'ywt_heading', __( 'Banner Heading' ) ),
		Field::make( 'image', 'ywt_image', __( 'Banner Image' ) ),
		Field::make( 'textarea', 'ywt_content', __( 'Banner Content' ) ),
	) )
	->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
		?>



<div class="p-5 text-center bg-image" style="
      background-image: url('<?php echo wp_get_attachment_image_url( $fields['ywt_image']); ?>');
      height:90vh;
    ">
    <div class="mask">
        <div class="d-flex justify-content-center align-items-center h-60">
            <div class="text-white">
                <h1 class="mb-3"><?php echo esc_html( $fields['ywt_heading'] ); ?></h1>
                <h4 class="mb-3"><?php echo esc_html( $fields['ywt_content'] ); ?></h4>
            </div>
        </div>

        <div class="ctabtnsec">
            <a class="btn btn-outline-light btn-lg m-2" href="https://www.youtube.com" role="button" target="_blank">
                Start tutorial
            </a>
        </div>
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-6 socialmedia-banner">
                    <ul>
                    <?php
                    $social = carbon_get_theme_option( 'ywt_social_link' );
                   
                    foreach ($social as $sitem){                       
                        ?>
<li><a href="<?php echo $sitem['ywt_social_url']; ?>"><i class="fa <?php echo $sitem['ywt_social_icon']['class']; ?>"></i></a></li>
                <?php   
                }
                    ?>
                    </ul>
                </div>
                <div class="col-6 text-right">
                <a href="/contact">Join Our Class <i class="fa-solid fa-caret-right"></i></a>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Background image -->
<?php
	} );
    
    }

add_action( 'after_setup_theme', 'ywt_load' );
function ywt_load() {
    require_once( 'vendor/autoload.php' );
    \Carbon_Fields\Carbon_Fields::boot();
}