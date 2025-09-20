<?php

use Carbon_Fields\Container;
use Carbon_Fields\Block;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', 'crb_attach_theme_options');

function crb_attach_theme_options() {

    Container::make('theme_options', __('Theme Options'))
            ->set_layout('tabbed-vertical')
            ->add_tab(__('Contact Information'), array(
                Field::make('text', 'crb_phone_number', __('Phone')),
                Field::make('textarea', 'crb_phone_svg', __('Icon SVG ')),
                Field::make('icon', 'crb_phone_icon', __('Phone Icon')),
                Field::make('text', 'crb_email', __('Email')),
                Field::make('textarea', 'crb_email_svg', __('Icon SVG ')),
                Field::make('icon', 'crb_email_icon', __('Email Icon')),
                Field::make('text', 'crb_address', __('Address')),
                Field::make('textarea', 'crb_address_svg', __('Icon SVG ')),
                Field::make('icon', 'crb_address_icon', __('Address Icon')),
                Field::make('text', 'crb_post_code', __('Post Code/ZIP')),
                Field::make('text', 'crb_map_link', __('Map Link')),
                
            ))
            ->add_tab(__('Social Media'), array(
                Field::make('complex', 'quicklink', __('Social Icon'))
                ->set_layout('tabbed-vertical')
                ->add_fields(array(
                    Field::make('text', 'btn_title', __('Title')),
                    Field::make('text', 'btn_url', __('Url')),
                    Field::make('text', 'btn_user', __('User Name')),
                    Field::make('separator', 'btn_separator3', __('SVG Code')),
                    Field::make('text', 'btnsvg', __('SVG Code')),
                    Field::make('separator', 'btn_separator2', __('Upload Icon')),
                    Field::make('image', 'image', __('Block Image')),                    
                    Field::make('separator', 'btn_separator1', __('Font Awesome Icon')),
                    Field::make('icon', 'btn_icon', __('Button Icon')),
                ))
            ))
            ->add_tab(__('CTA'), array(
                Field::make('image', 'cta_image_bg', __('Background Image')),
                Field::make('text', 'cta_descreption', __('CTA Title')),
                Field::make('text', 'cta_btn_text', __('BTN Title')),
                Field::make('text', 'cta_url', __('CTA Link')),
            ))
            ->add_tab(__('Blog Page'), array(
                Field::make('image', 'bp_image_bg', __('Background Image')),
                Field::make('text', 'bp_descreption', __('Title')),
                Field::make('text', 'bp_btn_text', __('Content')),
            ))
            ->add_tab(__('Single Post Page'), array(
                Field::make('text', 'spp_title', __('Related Blog section Title')),
                Field::make('text', 'spp_text', __('Related Blog section Content')),
                Field::make('color', 'spp_background', __('Related Blog section Background Color'))
            ))
            ->add_tab(__('Footer'), array(
                Field::make('image', 'footer_image', __('Footer Logo')),
                Field::make('image', 'footer_bg', __('Footer Background Image')),
                Field::make('text', 'footer_descreption', __('Descrerption')),
                Field::make('text', 'footer_signup', __('Sign up Title')),
                Field::make('text', 'footer_signup_desc', __('Sign up Descrerption')),
                Field::make('text', 'footer_signup_form', __('Sign up Form Shortcode')),
                Field::make('text', 'footer_nav', __('Social Section Title')),
                Field::make('text', 'footer_cta1', __('Navigation Title')),
                Field::make('text', 'footer_cta2', __('Navigation Title')),
                Field::make('text', 'footer_cta3', __('Navigation Title')),
                Field::make('text', 'footer_news', __('CTA Title')),

                Field::make('media_gallery', 'footer_payment_image', __('Image')),
                Field::make('text', 'footer_copyright', __('Copyright Title')),
    ));
}

add_action('carbon_fields_register_fields', 'crb_attach_meta_options');

function crb_attach_meta_options() {
    Container::make('post_meta', 'Custome Meta Items ')
            ->where('post_type', '=', 'testmonial')
            ->add_fields(array(
                Field::make('text', 'cst_title', __('Location')),
    ));
}

add_action('carbon_fields_register_fields', 'crb_attach_block_options');

function crb_attach_block_options() {
    require_once( 'blocks/homebanner.php');
    require_once( 'blocks/marquee_text.php');
    require_once( 'blocks/cat-grid.php');
    require_once( 'blocks/container.php');
    require_once( 'blocks/product-carusal.php');


    require_once( 'blocks/Engagements.php');
    require_once( 'blocks/cta.php');
    require_once( 'blocks/verticalSteper.php');
    require_once( 'blocks/innerpagebanner.php');
    require_once( 'blocks/doublegriditem.php');
    require_once( 'blocks/imageContent.php');
    require_once( 'blocks/trusted_partners.php');
    require_once( 'blocks/lequipe.php');
    require_once( 'blocks/affiliationMutuelles.php');
    require_once( 'blocks/contact-page-block.php');
    require_once( 'blocks/map-block.php');
    require_once( 'blocks/custome-content.php');
    require_once( 'blocks/testmonial-page.php');
    require_once( 'blocks/testmonial-cta.php');
    
    
    
    require_once( 'blocks/ourapproach.php');
    require_once( 'blocks/aboutus.php');
    require_once( 'blocks/whatweoffer.php');
    require_once( 'blocks/clientcasestudies.php');
    require_once( 'blocks/testimonialblock.php');
   
    require_once( 'blocks/biography.php');
    require_once( 'blocks/faqblock.php');
    require_once( 'blocks/imagebanner.php');
    require_once( 'blocks/service-content.php');
    require_once( 'blocks/moreservices.php');
    require_once( 'blocks/ourbestclient.php');
    require_once( 'blocks/videoloadmore.php');   
    require_once( 'blocks/ctapage-blog.php');
    require_once( 'blocks/container-block.php');
    require_once( 'blocks/approch-banner.php' );    
    require_once( 'blocks/approch-content.php' );
    
   
    require_once( 'blocks/latestblog.php');
}

//function crb_attach_block2_options() {
//    require_once( 'serviceblock.php' ); 
//}


add_action('after_setup_theme', 'crb_load');

function crb_load() {
    require_once( 'vendor/autoload.php' );
    \Carbon_Fields\Carbon_Fields::boot();
}
