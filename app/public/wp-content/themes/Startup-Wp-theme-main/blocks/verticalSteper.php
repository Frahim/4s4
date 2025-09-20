<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('Pourquoi choisir'))
        ->add_tab(__('Choisir Items'), array(
            Field::make('text', 'pc_sec_title', __('Section Title')),
            Field::make('complex', 'pc_items', __('Items'))
            ->set_layout('tabbed-vertical')
            ->add_fields(array(
                Field::make('text', 'pc_item_title', __('Item Title')),
                Field::make('rich_text', 'pc_item_content', __('Item Content')),
                Field::make('image', 'pc_item_photo', __('Item Photo')),
            ))
        ))
        ->add_tab(__('Style'), array(
            Field::make('color', 'pc_background', 'Background')
            ->set_palette(array('#FF0000', '#00FF00', '#0000FF')),
            Field::make('image', 'pc_bg', __('Background Image')),
            Field::make('select', 'pc_steper_select', __('Choose Steper Style'))
            ->set_options(array(
                'number' => __('Number'),
                'icon' => __('Icon'),
            ))
        ))
        ->set_render_callback(function ($fields, $attributes) {
            ?>

            <section class="choisir-sec py-120 <?php echo $fields['pc_steper_select']; ?>">
                <div class="container">
                    <div class="row">
                        <?php if (!empty($fields['pc_sec_title'])): ?>
                            <div class="col-12 mb-60 text-center wow fadeInUp animated"><h2 class="pc_sec_title"><?php echo $fields['pc_sec_title'] ?></h2></div>
                        <?php endif; ?>
                    </div>

                    <?php
                    foreach ($fields['pc_items'] as $i => $item) {
                        if ($i % 2 == 0) {
                            ?>
                            <div class="row align-items-center itemrow">
                                <div class="col-md-5 col-12 order-md-1 order-2 mb-60 pl-30 wow fadeInLeft animated">
                                    <img src="<?php echo wp_get_attachment_url($item['pc_item_photo']); ?>" alt="<?php echo $item['pc_item_title']; ?> Image">
                                </div>
                                <div class="col-md-2 col-12 text-center order-md-2 order-1 stepnumber wow fadeInUp animated">
                                    <?php if ($fields['pc_steper_select'] == 'number') { ?>
                                        <span class="step_number step_number<?php echo $i + 1; ?>"> <?php echo $i + 1; ?></span>
                                    <?php } ?>
                                    <?php if ($fields['pc_steper_select'] == 'icon') { ?>
                                        <span class="step_icon step_icon<?php echo $i + 1; ?>"></span>
                                    <?php } ?>
                                </div>
                                <div class="col-md-5 col-12 order-md-3 order-3 mb-60 pl-30 wow fadeInRight animated">
                                    <h2 class="items-name"> <?php echo $item['pc_item_title']; ?></h2> 
                                    <p class="items-content"><?php echo $item['pc_item_content']; ?></p>
                                </div>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="row align-items-center itemrow">
                                <div class="col-md-5 col-12 text-right order-md-1 order-3 mb-60 pl-30 wow fadeInLeft animated">
                                    <h2 class="items-name"> <?php echo $item['pc_item_title']; ?></h2> 
                                    <p class="items-content"><?php echo $item['pc_item_content']; ?></p>
                                </div>
                                <div class="col-md-2 col-12 text-center order-md-2 order-1 stepnumber wow fadeInUp animated">
                                    <?php if ($fields['pc_steper_select'] == 'number') { ?>
                                        <span class="step_number step_number<?php echo $i + 1; ?>"> <?php echo $i + 1; ?></span>
                                    <?php } ?>
                                    <?php if ($fields['pc_steper_select'] == 'icon') { ?>
                                        <span class="step_icon step_icon<?php echo $i + 1; ?>"></span>
                                    <?php } ?>
                                </div>
                                <div class="col-md-5 col-12 order-md-3 order-2 mb-60 pl-30 wow fadeInRight animated">
                                    <img src="<?php echo wp_get_attachment_url($item['pc_item_photo']); ?>" alt="<?php echo $item['pc_item_title']; ?> Image">
                                </div>
                            </div>
                            <?php
                        }
                        ?>

                    <?php } ?>
                </div>
            </section>
            <style>
                .choisir-sec{
                    background-image:url(<?php echo wp_get_attachment_url($fields['pc_bg']); ?>);
                    background-repeat: no-repeat;
                    background-position: 95% 60px;
                }
                <?php if ($fields['pc_steper_select'] == 'number') { ?>
                    .itemrow {
                        background: url(<?php echo get_template_directory_uri() ?>/img/Line1.png);
                        background-repeat: no-repeat;
                        background-position: top center;
                    }
                    
                    .step_number{
                        box-shadow: 10px 20px 60px 0px rgba(8, 36, 50, 0.12);
                        color: var(--White-white, #FFF);
                        text-align: center;
                        font-family: "Barlow Semi Condensed";
                        font-size: 24px;
                        font-style: normal;
                        font-weight: 600;
                        line-height: 34px;
                        width: 44px;
                        height: 44px;
                        margin: auto;
                        display: inline-flex;
                        align-items: center;
                        justify-content: center;
                        border-radius: 100px;
                        border: solid 6px;
                    }
                    span.step_number1{
                        background: var(--Primary-main, #00A2E1);
                    }
                    span.step_number2{
                        background: var(--Status-danger, #FF000F);
                    }
                    span.step_number3{
                        background: var(--Status-success, #5FCD1B);
                    }
                <?php } ?>
                <?php if ($fields['pc_steper_select'] == 'icon') { ?>
                    .itemrow {
                        background: url(<?php echo get_template_directory_uri() ?>/img/iconrwap-border.png);
                        background-repeat: no-repeat;
                        background-position: top center;
                    }
                    
                    .step_icon{
                        width: 30px;
                        height: 30px;
                        border-radius: 50%;
                        border: 6px solid var(--Primary-main, #00A2E1);
                        box-shadow: 0px 12px 30px 0px rgba(8, 36, 50, 0.12);
                        display: inline-block;
                        background: #fff;
                    }

                <?php } ?>
            </style>
            <?php
        });
