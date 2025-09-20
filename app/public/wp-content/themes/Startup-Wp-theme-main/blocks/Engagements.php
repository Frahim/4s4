<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('Nos Engagements'))
        ->add_tab(__('Content Part'), array(
            Field::make('text', 'ne_heading', __('Section Title')),
            Field::make('text', 'ne_sub_heading', __('Section Content')),
            Field::make('complex', 'ne_slider', __('Items'))
            ->set_layout('tabbed-vertical')
            ->add_fields(array(
                Field::make('text', 'ne_item_title', __('Item Title')),
                Field::make('rich_text', 'ne_item_cont', __('Item Content')),
                Field::make('image', 'ne_item_photo', __('Item Photo')),
            ))
        ))
        ->add_tab(__('Style'), array(
            Field::make('color', 'ne_background', 'Background')
            ->set_palette(array('#FF0000', '#00FF00', '#0000FF')),
            Field::make('select', 'ne_content_style', __('Select Style'))
            ->add_options(array(
                'style1' => __('Style 1'),
                'style2' => __('Style 2'),
            ))
        ))
        ->set_render_callback(function ($fields, $attributes) {
            ?>
            <section class="engagements py-120 <?php echo $fields['ne_content_style']; ?> d-none d-lg-block" style="background-color:<?php echo $fields['ne_background']; ?> ">    
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-10 col-12 set-title wow fadeInUp animated"><h2><?php echo $fields['ne_heading']; ?></h2></div>
                        <?php if (!empty($fields['ne_sub_heading'])): ?>
                            <div class="col-lg-8 col-12 set-content wow fadeInDown animated"><p><?php echo $fields['ne_sub_heading']; ?></p></div>
                        <?php endif; ?>
                    </div>
                    <div class="row justify-content-center">
                        <?php
                        $i = 1;
                        foreach ($fields['ne_slider'] as $i => $item) {
                            ?>
                            <div class="col-lg-4 col-12 noe-item-wrap wow fadeInUp animated mt-60" data-wow-delay="0.<?php echo $i; ?>s">
                                <div class="noe-inner-wrwpper">
                                    <img src="<?php echo wp_get_attachment_url($item['ne_item_photo']); ?>" alt="Nos Engagements item Icon "/>
                                    <div class="contentwrap">
                                        <h2><?php echo $item['ne_item_title']; ?> </h2>
                                        <p><?php echo $item['ne_item_cont']; ?></p>
                                    </div>

                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>          
            </section>
            <section class="engagements py-120 <?php echo $fields['ne_content_style']; ?> d-block d-lg-none" style="background-color:<?php echo $fields['ne_background']; ?> ">    
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-10 col-12 set-title wow fadeInUp animated"><h2><?php echo $fields['ne_heading']; ?></h2></div>
                        <?php if (!empty($fields['ne_sub_heading'])): ?>
                            <div class="col-lg-8 col-12 set-content wow fadeInDown animated"><p><?php echo $fields['ne_sub_heading']; ?></p></div>
                        <?php endif; ?>
                    </div>
                    <div class="splide" id="engagements-splide">
                        <div class="splide__track">
                            <ul class="splide__list">
                                <?php
                                $i = 1;
                                foreach ($fields['ne_slider'] as $i => $item) {
                                    ?>
                                    <li class="splide__slide noe-item-wrap wow fadeInUp animated mt-60" data-wow-delay="0.<?php echo $i; ?>s">
                                        <div class="inwrp">
                                            <img src="<?php echo wp_get_attachment_url($item['ne_item_photo']); ?>" alt="Nos Engagements item Icon "/>
                                            <div class="contentwrap">
                                                <h2><?php echo $item['ne_item_title']; ?> </h2>
                                                <p><?php echo $item['ne_item_cont']; ?></p>
                                            </div>

                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>  
                </div>
            </section>
            <style>
            <?php
            $custompaddng = $fields['ne_content_style'];
            switch ($custompaddng) {
                case "style1":
                    ?>
                        .style1 .noe-inner-wrwpper{
                            padding:24px;
                        }
                    <?php
                    break;
                case "style2":
                    ?>
                        .style2 .noe-inner-wrwpper{
                            border: 1px solid var(--Dark-dark_7, #F3F6F6);
                        }
                        .style2 .noe-inner-wrwpper img{
                            padding:10px;
                        }
                        .style2  .noe-inner-wrwpper .contentwrap{
                            padding:24px;
                        }
                        .style2  .noe-inner-wrwpper h2{
                            margin:0 0 12px;
                        }
                    <?php
                    break;
                default:
                    ?>
                        .style1   .noe-inner-wrwpper{
                            padding:14px;
                        }
                <?php
            }
            ?>
            </style>

            <?php
        });
