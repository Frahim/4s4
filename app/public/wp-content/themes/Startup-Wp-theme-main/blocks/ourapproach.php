<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('Our Approach'))
        ->add_fields(array(
            Field::make('text', 'op_heading', __('Heading')),
            Field::make('text', 'op_desc', __('Description')),
            Field::make('complex', 'op_items', __('Approach item'))
            ->set_layout('tabbed-vertical')
            ->add_fields(array(
                Field::make('text', 'op_srv_title', __('Approach Title')),
                Field::make('image', 'op_srv_icon', __('Approach Icon')),
                Field::make('text', 'op_srv_cont', __('Approach content')),
                Field::make('text', 'op_srv_url', __('Approach URL')),
            ))
        ))
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
            ?>

            <section class="our-approach-area section-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 wow fadeInUp animated">
                            <div class="section-heading">
                                <h2 class="dark-1 fw-bold">
                                    <?php echo $fields['op_heading']; ?>                                   
                                </h2>
                                <p class="dark-2">
                                    <?php echo $fields['op_desc']; ?>                                    
                                </p>
                            </div>
                        </div>
                        <?php
                        $i=1;
                        foreach ($fields['op_items'] as $item) {
                            ?>
                            <div class="col-lg-4 wow fadeInUp animated"  data-wow-delay="0.<?php echo $i;?>s">
                                <div class="our-approach-item radius-4">
                                    <div class="">
                                        <img src="<?php echo wp_get_attachment_url($item['op_srv_icon']); ?>" alt="Icon" class="img-fluid">
                                            <h4 class="dark-1 fw-bold">
                                               <?php echo $item['op_srv_title']; ?> 
                                            </h4>
                                            <p class="dark-2">
                                               <?php echo $item['op_srv_cont']; ?> 
                                            </p>
                                    </div>
                                    <!-- secondary button -->
                                    <div class="">
                                        <a href="<?php echo $item['op_srv_url']; ?>" class="secondary-border-btn">
                                            More Details

                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M8.1083 14.0302L7.05005 12.9697L11.0168 8.99998L7.05005 5.03023L8.1113 3.96973L12.075 7.93948C12.3562 8.22077 12.5142 8.60223 12.5142 8.99998C12.5142 9.39772 12.3562 9.77918 12.075 10.0605L8.1083 14.0302Z"
                                                    fill="#141414" />
                                            </svg>

                                        </a>
                                    </div>
                                    <!-- secondary button -->
                                </div>
                            </div>
                        <?php
                        
                         $i++;
                        } ?>

                    </div>
                </div>
            </section>

            <?php
        });
