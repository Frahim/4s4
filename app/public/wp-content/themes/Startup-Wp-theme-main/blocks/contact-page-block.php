<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('Contact Page Block'))
        ->add_tab(__('Top 3 Items'), array(
            Field::make('complex', 'tp3_items', __('Items'))
            ->set_layout('tabbed-vertical')
            ->add_fields(array(
                Field::make('text', 'tp3_item_title', __('Item Title')),
                Field::make('rich_text', 'tp3_item_content', __('Item Content')),
                Field::make('image', 'tp3_item_icon', __('Item Icon')),
            ))
        ))
        ->add_tab(__('Social Media Content'), array(
            Field::make('rich_text', 'sm_items', __('Content'))
        ))
        ->add_tab(__('Form Part'), array(
            Field::make('rich_text', 'form_content', __('Content')),
            Field::make('image', 'form_content_image', __('Content Image')),
            Field::make('rich_text', 'form_title', __('Form Title')),
        ))
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
            ?>
            <section class="contact-form section-padding">
                <div class="container top3-item-wrap">
                    <div class="row">
                        <?php
                        $phone = carbon_get_theme_option('crb_phone_number');
                        $email = carbon_get_theme_option('crb_email');
                        $loc = carbon_get_theme_option('crb_address');
                        $socialmedia = carbon_get_theme_option('quicklink');
                        foreach ($fields['tp3_items'] as $i => $item) {
                            ?>
                            <div class="col-lg-4 col-12 mb-3">
                                <div class="item-single-wrap">
                                    <div class="coont-wrwp">
                                        <img src="<?php echo wp_get_attachment_url($item['tp3_item_icon']); ?>">
                                        <div class="right-part">
                                            <?php echo $item['tp3_item_title'] ?>
                                            <div class="cta-item">
                                                <?php
                                                if ($i == '0') {
                                                    echo $phone;
                                                }
                                                ?>
                                                <?php
                                                if ($i == '1') {
                                                    echo $email;
                                                }
                                                ?>
                                                <?php
                                                if ($i == '2') {
                                                    echo $loc;
                                                }
                                                ?>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="content-cpb d-none d-lg-block"> <?php echo $item['tp3_item_content'] ?></div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="col-12 mt-30">
                            <div class="item-sos-wrap item-single-wrap">
                                <div class="sos-cont"> <?php echo $fields['sm_items']; ?></div>
                                <div class="sos-item">
                                    <?php foreach ($socialmedia as $item) { ?>                                   
                                        <a class="social-item" href="<?php echo $item['btn_url']; ?>">
                                            <span><img src="<?php echo wp_get_attachment_url($item['image']); ?>"></span>  
                                            <span class="sos-unpart">
                                                <h3><?php echo $item['btn_title']; ?></h3> 
                                                <h4><?php echo $item['btn_user']; ?></h4> 
                                            </span>                                            
                                        </a>          
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="form-part-wrapper">
                        <div class="row justify-content-between">
                            <div class="col-lg-5 col-12 form_content">
                                <?php echo $fields['form_content']; ?>
                                <img class="form_content_image" src="<?php echo wp_get_attachment_url($fields['form_content_image']); ?>">
                            </div>
                            <div class="col-12 col-lg-7">
                                <div class="formpart">
                                    <div class="form-title"><?php echo $fields['form_title']; ?></div>
                                    <div class="form-wrwp">
                                        <?php echo do_shortcode('[contact-form-7 id="bcd1455" title="Contact form 1"]'); ?>
                                    </div>
                                </div>
                            </div>                       
                        </div>
                    </div>
                </div>
               

            </section>

            <?php
        });
