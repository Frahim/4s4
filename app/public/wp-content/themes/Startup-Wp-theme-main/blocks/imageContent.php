<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('Image and Comntent Grid'))
        ->add_tab(__('Content Part'), array(
            Field::make('text', 'iacg_heading', __('Heading')),
            Field::make('rich_text', 'iacg_content', __('Content')),
            Field::make('image', 'iacg_image', __('Image')),
        ))
        ->add_tab(__('Style'), array(
            Field::make('color', 'iacg_background', 'Background')
            ->set_palette(array('#FF0000', '#00FF00', '#0000FF')),
            Field::make('image', 'iacg_image_bg', __('Background Image')),
            Field::make('select', 'iacg_content_align', __('Image Position'))
            ->add_options(array(
                'left' => __('Left'),
                'right' => __('Right'),
            )),
             Field::make('select', 'iacg_title_fontwidth', __('Title Font Width'))
            ->add_options(array(
                '400' => __('400'),
                '500' => __('500'),
                '600' => __('600'),
                '700' => __('700'),                
            ))
        ))
        ->set_render_callback(function ($fields, $attributes) {
            ?>
            <section class="image-content-section section-padding" >
                <div class="container">
                    <div class="row align-items-center justify-content-between">
                        <?php
                        $favcolor = $fields['iacg_content_align'];
                        switch ($favcolor) {
                            case "left":
                                ?>
                                <div class="col-lg-6 col-12 img-part-left img-part wow fadeInRight  animated">
                                    <img src="<?php echo wp_get_attachment_url($fields['iacg_image']); ?>" alt=" Section Image" />
                                </div>
                                <div class="col-lg-6 col-12 content-part-left content-part wow fadeInLeft  animated">
                                    <h2 class="iacg_heading"><?php echo $fields['iacg_heading']; ?></h2>
                                    <p><?php echo $fields['iacg_content']; ?></p>
                                </div>
                                <?php
                                break;
                            case "right":
                                ?>
                                <div class="col-lg-6 col-12 content-part-right content-part wow fadeInRight  animated">
                                    <h2 class="iacg_heading"><?php echo $fields['iacg_heading']; ?></h2>
                                    <p><?php echo $fields['iacg_content']; ?></p>
                                </div>
                                <div class="col-lg-6 col-12 img-part-right img-part wow fadeInLeft  animated">
                                    <img src="<?php echo wp_get_attachment_url($fields['iacg_image']); ?>" alt=" Section Image" />
                                </div>
                                <?php
                                break;
                            default:
                                ?> 
                                <div class="col-lg-6 col-12 img-part-left img-part wow fadeInRight  animated">
                                    <img src="<?php echo wp_get_attachment_url($fields['iacg_image']); ?>" alt=" Section Image" />
                                </div>
                                <div class="col-lg-6 col-12 content-part-left content-part wow fadeInLeft  animated">
                                    <h2 class="iacg_heading"><?php echo $fields['iacg_heading']; ?></h2>
                                    <p><?php echo $fields['iacg_content']; ?></p>
                                </div>
                            <?php
                        }
                        ?>     
                    </div>
                </div>
            </section>
            <style>
                .image-content-section{
                    background-color:<?php echo $fields['iacg_background']; ?>;
                    background-image:<?php echo wp_get_attachment_url($fields['iacg_image_bg']); ?>
                        
                }
                .content-part h2 {
                    color: var(--Dark-dark_1, #0F1517);
                    font-family: "Barlow Semi Condensed";
                    font-size: 52px;
                    font-style: normal;                  
                    line-height: 62px;
                    margin-bottom: 20px;
                }
                .content-part p {
                    color: var(--Dark-dark_2, #2B3335);
                    font-family: Barlow;
                    font-size: 20px;
                    font-style: normal;
                    font-weight: 400;
                    line-height: 30px;
                }
                .content-part-right{
                }
                .img-part-right{
                }
                .content-part-left{
                    padding-left:60px
                }
                .img-part-left{
                    padding-right:60px
                }
                .iacg_heading{
                   font-weight:<?php echo $fields['iacg_title_fontwidth']; ?>; 
                }
            </style>
            <?php
        });

