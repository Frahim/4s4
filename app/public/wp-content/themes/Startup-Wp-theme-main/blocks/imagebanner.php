<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('Image Banner'))
        ->add_tab(__('Content'), array(
            Field::make('text', 'ib_heading', __('Heading')),
            Field::make('textarea', 'ib_content', __('Content')),
        ))
        ->add_tab(__('Image'), array(
            Field::make('image', 'ib_image_bg', __('Image BG')),
            Field::make('image', 'ib_banner_image', __('Banner Image')),
        ))
        ->add_tab(__('CTA'), array(
            Field::make('text', 'ib_cta_text', __('CTA Text')),
            Field::make('text', 'ib_cta_url', __('CTA URL')),
        ))
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
            ?>

            <section class="image_banner section-padding" style="background-image: url( <?php echo wp_get_attachment_url($fields['ib_image_bg']) ?>)">
                <div class="container">
                    <div class="row align-items-start ">
                        <div class="col-lg-5  col-12 cont-wrap">
                            <div class="banner-heading">
                                <h2 class="mb-3 fadeInUp animated">
                                    <?php echo $fields['ib_heading']; ?>                                
                                </h2>
                            </div>
                            <!-- Dark section heading -->
                            <div class="content-banner fadeInDown animated">
                                <?php echo $fields['ib_content']; ?>
                            </div>

                            <!-- Primary Button -->
                            <div class="mt-40 fadeInDown animated">
                                <a href="<?php echo $fields['ib_cta_url']; ?>" class="primary-main-btn text-uppercase fs-16 fw-bold text-decoration-none">
                                    <?php echo $fields['ib_cta_text']; ?>
                                </a>
                            </div>
                            <!-- Primary Button -->
                        </div>
                        <div class="col-lg-6 offset-lg-1 col-12 banner-img-wrap fadeInRight animated">
                            <img class="banner-img" src="<?php echo wp_get_attachment_url($fields['ib_banner_image']); ?>" alt="Image" class="img-fluid"> 
                        </div>
                    </div>

                </div>

            </section>
            <?php
        });
