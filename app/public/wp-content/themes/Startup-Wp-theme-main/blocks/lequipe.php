<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('L’Équipe'))
        ->add_tab(__('Content Part'), array(
            Field::make('text', 'leq_heading', __('Section Title')),
            Field::make('text', 'leq_sub_heading', __('Section Content')),
            Field::make('complex', 'leq_slider', __('Items'))
            ->set_layout('tabbed-vertical')
            ->add_fields(array(
                Field::make('text', 'leq_item_title', __('Item Title')),
                Field::make('rich_text', 'leq_item_cont', __('Item Content')),
                Field::make('image', 'leq_item_photo', __('Item Photo')),
            ))
        ))
        ->add_tab(__('Style'), array(
            Field::make('color', 'leq_background', 'Background')
            ->set_palette(array('#FF0000', '#00FF00', '#0000FF')),
            Field::make('image', 'leq_item_photo', __('Background Photo')),
        ))
        ->set_render_callback(function ($fields, $attributes) {
            ?>

            <section class="lequipe-section py-120" style="background-image:url(<?php echo wp_get_attachment_url($fields['leq_item_photo']); ?>);">    
                <div class="container">                  
                    <div class="row justify-content-between align-items-center">
                        <div class="col-lg-5 col-12 leq_contentwrap">
                            <h2><?php echo $fields['leq_heading'] ?></h2>
                            <p><?php echo $fields['leq_sub_heading'] ?></p>
                        </div>
                        <div class="col-lg-6 col-12">
                             <div class="row">
                            <?php
                            $i = 1;
                            foreach ($fields['leq_slider'] as $i => $item) {
                                ?>
                                <div class="col-lg-6 col-6 single-item-wrap wow fadeInUp animated mt-60" data-wow-delay="0.<?php echo $i; ?>s">
                                    <div class="inner-wrwpper">
                                        <div class="img-grid">
                                            <img src="<?php echo wp_get_attachment_url($item['leq_item_photo']); ?>" alt="Nos Engagements item Icon "/>
                                        </div>
                                        <div class="content-grid">
                                            <h2 class="item-name"><?php echo $item['leq_item_title']; ?> </h2>
                                            <p class="item-content"><?php echo $item['leq_item_cont']; ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                             </div>
                        </div>
                    </div> 
                </div>
            </section>

            <?php
        });
