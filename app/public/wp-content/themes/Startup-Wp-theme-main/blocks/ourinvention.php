<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('Our Invention'))
        ->add_fields(array(
            Field::make('text', 'oi_heading', __('Block Heading')),
            Field::make('image', 'oi_image', __('Block Image')),
            Field::make('complex', 'oi_items', __('Invention item'))
            ->set_layout('tabbed-vertical')
            ->add_fields(array(
                Field::make('media_gallery', 'oi_media_gallery', __('Invention Media Gallery'))
            ))
        ))
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
            ?>

            <section class="inventions-area section-padding-140">
                <div class="container">
                    <div class="section-heading">
                        <h2 class="spl-title text-center ff-sg-thin-25">
                            Our inventi<span class="position-relative">o<img src="<?php echo wp_get_attachment_url($fields['oi_image']); ?>" alt="icon"
                                                                             class="star-icon position-absolute end-0 img-fluid" /></span>ns
                        </h2>
                    </div>
                </div>

                <!-- Inner slider -/Start -->
                <div class="invention-inner-slide-section">

                    <div class="invention-inner-slider-wrap">

                        <div class="splide" id="invention_inner_slider" role="group"
                             aria-label="Splide Basic HTML Example">
                            <div class="splide__track">
                                <ul class="splide__list">
                                    <?php
                                    foreach ($fields['oi_items'] as $item) {
                                        ?>
                                        <li class="splide__slide">
                                            <div class="invention-inner-slide-item invention-main-slide-bg-1" data-tilt
                                                 data-tilt-max="0.25" data-tilt-speed="400" data-tilt-perspective="50">
                                                <div class="invention-in-slider-container scroller">
                                                    <div class="invention-in-slider-wrap scroller__inner">
                                                        <?php foreach ($item['oi_media_gallery'] as $image) {
                                                            ?>
                                                            <div class="invention-in-slider-item">
                                                                <img src="<?php echo wp_get_attachment_url($image) ?>" alt="">
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>

                                                    </div>
                                                </div>
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
                <!-- Inner slider -/End -->
            </section>

            <?php
        });
