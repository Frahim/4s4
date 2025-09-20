<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('Suit of services'))
        ->add_fields(array(
            Field::make('text', 'sos_heading', __('Services Heading')),
            Field::make('text', 'sos_link', __('Services Link')),
            Field::make('complex', 'sos_items', __('Services item'))
            ->set_layout('tabbed-vertical')
            ->add_fields(array(
                Field::make('text', 'sos_srv_title', __('Services Title')),
                Field::make('image', 'sos_srv_icon', __('Services Icon'))
            ))
        ))
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
            ?>

            <section class="services-area bg-clr-neviBlue overflow-hidden">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-4">
                            <div class="services-heading">
                                <h2 class="text-white ff-sg-semibold-25 "><?php echo $fields['sos_heading']; ?></h2>
                                <div class="d-flex services-area-btn">
                                    <a href="<?php echo $fields['sos_link']; ?>"
                                       class="common-btn bg-clr-primary rounded-pill fs-6 fw-semi-bold text-decoration-none d-flex align-items-center justify-content-center gap-2 text-white text-uppercase">Let’s
                                        talk
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M9.24269 9.24264H7.74009V3.32062L1.28774 9.77297L0.227081 8.71231L6.67943 2.25996H0.757411V0.757359H9.24269V9.24264Z"
                                                fill="#ffffff" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="d-flex align-items-center services-item-two-column-wrap overflow-hidden">
                                <div class="services-item-left-column w-100">
                                    <div class="first-slider-wrapper">
                                        <div class="splide" id="slider1" role="group"
                                             aria-label="Splide Basic HTML Example">
                                            <div class="splide__track">
                                                <ul class="splide__list">
                                                    <?php
                                                    foreach ($fields['sos_items'] as $item) {
                                                        ?>
                                                        <li class="splide__slide">
                                                            <div class="services-item">
                                                                <div class="">
                                                                    <img src="<?php echo wp_get_attachment_url($item['sos_srv_icon']); ?>"
                                                                         alt="Ui ux design" class="img-fluid" />
                                                                </div>
                                                                <p class="ff-sg-light-25 text-white">
                                                                   <?php echo $item['sos_srv_title']; ?>
                                                                </p>
                                                            </div>
                                                        </li>
                                                        <?php
                                                    }
                                                    ?>          
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="services-item-right-column w-100 marquee-reverse">
                                    <div class="first-slider-wrapper">
                                        <div class="splide" id="slider2" role="group"
                                             aria-label="Splide Basic HTML Example">
                                            <div class="splide__track">
                                                <ul class="splide__list">
                                                    <?php
                                                    foreach ($fields['sos_items'] as $item) {
                                                        ?>
                                                        <li class="splide__slide">
                                                            <div class="services-item">
                                                                <div class="">
                                                                    <img src="<?php echo wp_get_attachment_url($item['sos_srv_icon']); ?>"
                                                                         alt="Ui ux design" class="img-fluid" />
                                                                </div>
                                                                <p class="ff-sg-light-25 text-white">
                                                                   <?php echo $item['sos_srv_title']; ?>
                                                                </p>
                                                            </div>
                                                        </li>
                                                        <?php
                                                    }
                                                    ?>     
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <?php
        });
