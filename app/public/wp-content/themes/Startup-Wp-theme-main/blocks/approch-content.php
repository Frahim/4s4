<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('Our Approach Content'))
        ->add_fields(array(
            Field::make('text', 'oac_heading', __('Section Heading')),
            Field::make('image', 'oac_image_bg', __('Section Image')),
            Field::make('complex', 'oac_items', __('Content Items'))            
            ->set_layout('tabbed-vertical')
            ->add_fields(array(
                Field::make('text', 'oac_item_title', __('Title')),
                Field::make('textarea', 'oac_item_answer', __('Content')),
            ))
        ))
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
            ?>



            <section id="approchcontent" class="section-padding oac-content">
                <div class="container">
                    <div class="row">    
                        <div class="col-lg-6 col-12 order-md-first order-last">
                            <div class="featrueimgwrwp">                            
                                <img src="<?php echo wp_get_attachment_url($fields['oac_image_bg']); ?>" alt="Item Image"/>   
                            </div> 
                        </div>
                        <div class="col-lg-6 col-12 content-wrwpper">    
                            <h2 class="content-header"><?php echo $fields['oac_heading']; ?></h2>
                            <?php                          
                            foreach ($fields['oac_items'] as $i => $item) {
                                ?>
                                <div class="item-wrwpper">
                                    <h2 class="item-title"><?php echo $item['oac_item_title']; ?></h2>
                                    <div class="inner-content-wrwpper">                                        
                                        <p><?php echo $item['oac_item_answer'] ?></p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div> 

                    </div>
                </div>

            </section>
            <?php
        });
