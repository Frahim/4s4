<?php

use Carbon_Fields\Container;
use Carbon_Fields\Block;
use Carbon_Fields\Field;



function crb_load()
{
    require_once('vendor/autoload.php');
    \Carbon_Fields\Carbon_Fields::boot();

    // Default options page
    $basic_options_container = Container::make('theme_options', __('Basic Options'))
        ->add_fields(array(
            Field::make('header_scripts', 'crb_header_script', __('Header Script')),
            Field::make('footer_scripts', 'crb_footer_script', __('Footer Script')),
        ));

    // Add second options page under 'Basic Options'
    Container::make('theme_options', __('Contact Information'))
        ->set_page_parent($basic_options_container) // reference to a top level container
        ->add_fields(array(
            Field::make('text', 'crb_phone_number', __('Phone')),
            Field::make('icon', 'crb_phone_icon', __('Phone Icon')),
            Field::make('text', 'crb_email', __('Email')),
            Field::make('icon', 'crb_email_icon', __('Email Icon')),
            Field::make('text', 'crb_address', __('Address')),
            Field::make('icon', 'crb_address_icon', __('Address Icon')),
            Field::make('text', 'crb_post_code', __('Post Code/ZIP')),
            Field::make('text', 'crb_map_link', __('Map Link')),
        ));

    // Add second options page under 'Basic Options'
    Container::make('theme_options', __('Social Links'))
        ->set_page_parent($basic_options_container) // reference to a top level container
        ->add_fields(array(
            Field::make('complex', 'crb_socialmedia', 'Social Media')
                ->set_layout('tabbed-horizontal')
                ->add_fields(array(
                    Field::make('text', 'title', 'Title'),
                    Field::make('text', 'url', 'Your Social Url'),
                    Field::make('icon', 'smicon', 'Icon'),
                )),
        ));

    // Add third options page under "Appearance"
    Container::make('theme_options', __('Customize Background'))
        ->set_page_parent('themes.php') // identificator of the "Appearance" admin section
        ->add_fields(array(
            Field::make('color', 'crb_background_color', __('Background Color')),
            Field::make('image', 'crb_background_image', __('Background Image')),
        ));


    Block::make(__('My Shiny Gutenberg Block'))
        ->add_fields(array(
            Field::make('text', 'heading', __('Block Heading')),
            Field::make('image', 'image', __('Block Image')),
            Field::make('rich_text', 'content', __('Block Content')),
        ))
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
?>

        <div class="block">
            <div class="block__heading">
                <h1><?php echo esc_html($fields['heading']); ?></h1>
            </div><!-- /.block__heading -->

            <div class="block__image">
                <?php echo wp_get_attachment_image($fields['image'], 'full'); ?>
            </div><!-- /.block__image -->

            <div class="block__content">
                <?php echo apply_filters('the_content', $fields['content']); ?>
            </div><!-- /.block__content -->
        </div><!-- /.block -->

<?php
        });
}

add_action('after_setup_theme', 'crb_load');
