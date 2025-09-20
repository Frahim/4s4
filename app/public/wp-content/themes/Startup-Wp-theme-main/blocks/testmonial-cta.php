<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('Testmonial CTA Block'))
        ->add_tab(__('Content Part'), array(
            Field::make('text', 'tcta_title', __('Title')),
            Field::make('rich_text', 'tcta_heading', __('Section Content')),
            Field::make('text', 'tcta_btn_url', __('Button URL')),
            Field::make('text', 'tcta_cta_txt', __('Bottom Text')),
        ))
        ->add_tab(__('Style'), array(
            Field::make('color', 'tcta_background', 'Background')
            ->set_palette(array('#FF0000', '#00FF00', '#0000FF')),
            Field::make('image', 'tcta_bg_image', __('Background Image')),
        ))
        ->set_render_callback(function ($fields, $attributes) {
            ?>

            <section class="cta-area py-120 d-none d-lg-block " style="background-image:url(<?php echo wp_get_attachment_url($fields['tcta_bg_image']) ?>);">    
                <div class="container">
                    <div class="row justify-content-end">
                        <div class="col-lg-7 col-12 tcta-content wow fadeInUp animated">
                            <h2> <?php echo $fields['tcta_title']; ?></h2>
                            <div><?php echo $fields['tcta_heading']; ?></div>
                            <a href="<?php echo $fields['tcta_btn_url']; ?>" class="tcontbtn text-decoration-none">
                                <?php echo $fields['tcta_cta_txt']; ?>
                            </a>
                        </div>                        
                    </div>
                </div>          
            </section>

            <?php
        });
