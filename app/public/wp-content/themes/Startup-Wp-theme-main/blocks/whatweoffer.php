<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('What We Offer'))
        ->add_tab(__('Section'), array(
            Field::make('text', 'wwo_heading', __('Heading')),
            Field::make('text', 'wwo_content', __('Content')),
            Field::make('text', 'wwo_more', __('More Link')),
            Field::make('complex', 'wwo_items', __('Offer items'))
            ->set_layout('tabbed-vertical')
            ->add_fields(array(
                Field::make('text', 'wwo_item_title', __('Offer Title')),
                Field::make('text', 'wwo_item_cont', __('Offer content')),
                Field::make('text', 'wwo_item_url', __('Offer URL')),
                Field::make('image', 'wwo_item_icon', __('Offer Icon'))
            ))
        ))
        ->add_tab(__('Layouts'), array(
            Field::make('select', 'wwo_layout', __('Select Layouts Type'))
            ->add_options(array(
                'grid' => __('Grid '),
                'carousel' => __('Carousel'),
            ))
        ))
        ->add_tab(__('Style'), array(
            Field::make('image', 'wwo_sec_bg', __('Section BG'))
        ))
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
            ?>

            <?php
            $layout = $fields['wwo_layout'];

            switch ($layout) {
                case "grid":
                    ?>
                    <section class="what-we-offer-area section-padding">
                        <!-- section heading -->
                        <?php if (!empty($fields['wwo_heading'])): ?>
                            <div class="section-heading text-center mb-64">
                                <h2 class="dark-1 fw-bold wow animated fadeInUp">
                                    <?php echo $fields['wwo_heading']; ?>                
                                </h2>
                                <p class="dark-2 wow animated fadeInUp">
                                    <?php echo $fields['wwo_content']; ?>   
                                </p>
                            </div>
                        <?php endif; ?>
                        <!-- section heading -->
                        <div class="container">
                            <div class="row">
                                <?php
                                $i=1;
                                foreach ($fields['wwo_items'] as $item) {
                                    ?>
                                    <div class="col-lg-4 wow fadeInLeft animated" data-wow-delay="0.<?php echo $i;?>s">
                                        <div class="what-we-offer-card bg-white radius-8">
                                            <img src="<?php echo wp_get_attachment_url($item['wwo_item_icon']); ?>" alt="Image" class="img-fluid">
                                                <h4 class="dark-1 fw-bold mt-30">
                                                    <?php echo $item['wwo_item_title']; ?>  
                                                </h4>
                                                <p class="dark-2 fs-18">
                                                    <?php echo $item['wwo_item_cont']; ?> 
                                                </p>
                                                <!-- secondary button -->
                                                <div class="mt-40">
                                                    <a href="<?php echo $item['wwo_item_url']; ?> " class="secondary-border-btn">
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
                            <?php if (!empty($fields['wwo_more'])): ?>
                                <!-- Primary Button -->
                                <div class="text-center mt-64">
                                    <a href="<?php echo $fields['wwo_more']; ?>" class="primary-main-btn text-uppercase fs-16 fw-bold text-decoration-none">
                                        View All
                                    </a>
                                </div>
                                <!-- Primary Button -->
                            <?php endif; ?>
                        </div>
                    </section>
                    <?php
                    break;
                case "carousel":
                    ?>
                    <section class="what-we-offer-area we-offer-carosul section-padding" style="background-image: url( <?php echo wp_get_attachment_url($fields['wwo_sec_bg']) ?>)">                      
                        <!-- section heading -->
                        <div class="container">                           
                                <div class="car-herder-wrwp col-12">
                                    <!-- section heading -->
                                    <?php if (!empty($fields['wwo_heading'])): ?>
                                        <div class="section-heading text-center mb-64">
                                            <h2 class="dark-1 fw-bold">
                                                <?php echo $fields['wwo_heading']; ?>                
                                            </h2>
                                            <p class="dark-2">
                                                <?php echo $fields['wwo_content']; ?>   
                                            </p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div  class="service-caro col-12">
                                    <div class="splide" role="group" id="service-caro" aria-label="Splide Basic HTML Example">
                                        <div class="splide__track">
                                            <ul class="splide__list">
                                                <?php
                                                foreach ($fields['wwo_items'] as $item) {
                                                    ?>
                                                    <li class="caro-item splide__slide">
                                                        <div class="what-we-offer-card bg-white radius-8">
                                                            <img src="<?php echo wp_get_attachment_url($item['wwo_item_icon']); ?>" alt="Image" class="img-fluid">
                                                                <h4 class="dark-1 fw-bold mt-30">
                                                                    <?php echo $item['wwo_item_title']; ?>  
                                                                </h4>
                                                                <p class="dark-2 fs-18">
                                                                    <?php echo $item['wwo_item_cont']; ?> 
                                                                </p>
                                                                <!-- secondary button -->
                                                                <div class="mt-40">
                                                                    <a href="<?php echo $item['wwo_item_url']; ?> " class="secondary-border-btn">
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
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                                   
                        </div>
                    </section>
                    <?php
                    break;
                default:
                    ?>
                    <section class="what-we-offer-area section-padding">
                        <!-- section heading -->
                        <?php if (!empty($fields['wwo_heading'])): ?>
                            <div class="section-heading text-center mb-64">
                                <h2 class="dark-1 fw-bold">
                                    <?php echo $fields['wwo_heading']; ?>                
                                </h2>
                                <p class="dark-2">
                                    <?php echo $fields['wwo_content']; ?>   
                                </p>
                            </div>
                        <?php endif; ?>
                        <!-- section heading -->
                        <div class="container">
                            <div class="row">
                                <?php
                                foreach ($fields['wwo_items'] as $item) {
                                    ?>
                                    <div class="col-lg-4">
                                        <div class="what-we-offer-card bg-white radius-8">
                                            <img src="<?php echo wp_get_attachment_url($item['wwo_item_icon']); ?>" alt="Image" class="img-fluid">
                                                <h4 class="dark-1 fw-bold mt-30">
                                                    <?php echo $item['wwo_item_title']; ?>  
                                                </h4>
                                                <p class="dark-2 fs-18">
                                                    <?php echo $item['wwo_item_cont']; ?> 
                                                </p>
                                                <!-- secondary button -->
                                                <div class="mt-40">
                                                    <a href="<?php echo $item['wwo_item_url']; ?> " class="secondary-border-btn">
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
                                <?php } ?>

                            </div>
                            <?php if (!empty($fields['wwo_more'])): ?>
                                <!-- Primary Button -->
                                <div class="text-center mt-64">
                                    <a href="<?php echo $fields['wwo_more']; ?>" class="primary-main-btn text-uppercase fs-16 fw-bold text-decoration-none">
                                        View All
                                    </a>
                                </div>
                                <!-- Primary Button -->
                            <?php endif; ?>
                        </div>
                    </section>
                <?php
            }
        });
