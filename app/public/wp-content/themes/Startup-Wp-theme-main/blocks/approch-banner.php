<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('Our Approach Banner'))
        ->add_tab(__('Content'), array(
            Field::make('image', 'oab_header_icon', __('Header Icon')),
            Field::make('text', 'oab_heading', __('Heading')),
            Field::make('textarea', 'oab_content', __('Content')),
            Field::make('image', 'oab_image_bg', __('Banner Image')),
        ))
        ->add_tab(__('Style'), array(
            Field::make('color', 'oab_banner_color', __('Banner Background')),
        ))
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
            ?>

            <section class="approach_banner" style="background-color: <?php
                     if (!empty($fields['oab_banner_color'])) {
                         echo $fields['oab_banner_color'];
                     } else {
                         echo "#05283F";
                     }
                     ?>">
                <div class="container">
                    <div class="row align-items-start ">
                        <div class="col-lg-5  col-12 cont-wrap">
                            <div class="banner-heading">
                                <img class="approch-banner-img" src="<?php echo wp_get_attachment_url($fields['oab_header_icon']); ?>" alt="Image" class="img-fluid"> 
                                <h2 class="mb-3">
                                    <?php echo $fields['oab_heading']; ?>                                
                                </h2>
                            </div>
                            <!-- Dark section heading -->
                            <div class="content-banner">
                                <?php echo $fields['oab_content']; ?>
                            </div>                          
                        </div>
                        <div class="col-lg-6 offset-lg-1 col-12 approch-banner-img-wrap">
                            <img class="approch-banner-img" src="<?php echo wp_get_attachment_url($fields['oab_image_bg']); ?>" alt="Image" class="img-fluid">
                            <a href="#approchcontent">  
                                <img class="approch-banner-img" src="<?php echo get_template_directory_uri(); ?>/img/learnmore.png" alt="Image" class="img-fluid">
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            <?php
        });
