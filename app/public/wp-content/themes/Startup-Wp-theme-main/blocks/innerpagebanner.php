<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('Inner page Banner'))
        ->add_tab(__('Content Part'), array(
            Field::make('text', 'ipb_heading', __('Heading')),
            Field::make('rich_text', 'ipb_content', __('Content')),
        ))
        ->add_tab(__('Style'), array(
            Field::make('color', 'ne_background', 'Background')
            ->set_palette(array('#FF0000', '#00FF00', '#0000FF')),
            Field::make('image', 'ipb_image_bg', __('Background Image')),
            Field::make('image', 'ipb_image_left', __('Background Image Before')),
            Field::make('image', 'ipb_image_right', __('Background Image Aftere')),
        ))
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
            ?>

            <section class="inner-page_banner section-padding" >
                <div class="container">
                    <div class="row align-items-center text-center justify-content-center">
                        <div class="col-lg-7 col-6 inpb-cont-wrap">
                            <div class="banner-heading">
                                <h2 class="fadeInUp animated">
                                    <?php echo $fields['ipb_heading']; ?>                                
                                </h2>
                            </div>
                            <!-- Dark section heading -->
                            <div class="content-banner fadeInDown animated d-none d-lg-block">
                                <?php echo $fields['ipb_content']; ?>
                            </div>
                        </div>                       
                    </div>
                </div>
            </section>
            <section class="fadeInDown animated d-block d-lg-none inner-page_banner_content_mobile">
                <div class="container">
                    <div class="col-12 border-bottom">
                        <?php echo $fields['ipb_content']; ?>
                    </div>
                </div>
            </section>

            <style>            
                section.inner-page_banner{
                    background-image: url( <?php echo wp_get_attachment_url($fields['ipb_image_bg']) ?>);
                    background-repeat:no-repeat;
                    position:relative;                   
                    overflow:hidden;
                    background-color:<?php echo $fields['ne_background']; ?>
                }
                <?php if (!empty($fields['ipb_image_left'])): ?>
                    section.inner-page_banner:before{
                        content:url(<?php echo wp_get_attachment_url($fields['ipb_image_left']) ?>);
                        position: absolute;
                        bottom: -6px;
                        left:30px;
                        z-index: 1;
                    }
                <?php endif; ?>
                <?php if (!empty($fields['ipb_image_right'])): ?>
                    section.inner-page_banner:after{
                        content:"";
                        background:url(<?php echo wp_get_attachment_url($fields['ipb_image_right']) ?>);
                        width:460px;
                        height:497px;
                        position: absolute;
                        top: 50%;
                        right: 0px;
                        transform: translate(0%, -50%);
                        background-position: right;
                        background-repeat: no-repeat;
                        background-size:contain;
                    }
                <?php endif; ?>
            </style>

            <?php
        });
