<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('Double Grid Items'))
        ->add_tab(__('Content Part'), array(
            Field::make('text', 'dgi_heading', __('Section Title')),
            Field::make('text', 'dgi_sub_heading', __('Section Content')),
            Field::make('complex', 'dgi_slider', __('Items'))
            ->set_layout('tabbed-vertical')
            ->add_fields(array(
                Field::make('text', 'dgi_item_title', __('Item Title')),
                Field::make('rich_text', 'dgi_item_cont', __('Item Content')),
                Field::make('image', 'dgi_item_photo', __('Item Photo')),
            ))
        ))
        ->add_tab(__('Style'), array(
            Field::make('color', 'dgi_background', 'Background')
            ->set_palette(array('#FF0000', '#00FF00', '#0000FF')),
        ))
        ->set_render_callback(function ($fields, $attributes) {
            ?>

<section class="doublefrid py-120" style="background-color:<?php echo $fields['dgi_background']; ?> ">    
                <div class="container">
                    <div class="row">
                        <div class="col-12 set-title wow fadeInUp animated"><h2><?php echo $fields['dgi_heading']; ?></h2></div>
                        <?php if(!empty($fields['dgi_sub_heading'])):?>
                        <div class="col-12 set-content wow fadeInDown animated"><p><?php echo $fields['dgi_sub_heading']; ?></p></div>
                        <?php endif; ?>
                    </div>
                    <div class="row justify-content-center">
                        
                        <?php
                        $i = 1;
                        foreach ($fields['dgi_slider'] as $i => $item) {
                            ?>
                            <div class="col-lg-5 col-12 noe-item-wrap wow fadeInUp animated mt-60" data-wow-delay="0.<?php echo $i; ?>s">
                                <div class="inner-wrwpper">
                                    <div class="img-grid">
                                        <img src="<?php echo wp_get_attachment_url($item['dgi_item_photo']); ?>" alt="Nos Engagements item Icon "/>
                                    </div>
                                     <div class="content-grid">
                                    <h2><?php echo $item['dgi_item_title']; ?> </h2>
                                    <p><?php echo $item['dgi_item_cont']; ?></p>
                                     </div>
                                </div>
                            </div>
                        <?php } ?>
                       
                    </div>
                </div>          
            </section>

            <?php
        });
