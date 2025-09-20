<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('Testimonial Block'))
        ->add_fields(array(
            Field::make('text', 'tm_heading', __('Testimonial Section Heading')),
            Field::make('text', 'tm_para', __('BTN Text')),
            Field::make('text', 'tm_para_url', __('BTN URL')),
            Field::make('image', 'tm_imagebg', __('BG Picture')),
            Field::make('complex', 'tm_items', __('Testimonial items'))
            ->set_layout('tabbed-vertical')
            ->add_fields(array(
                Field::make('text', 'tm_name', __('Name')),
                Field::make('image', 'tm_image', __('Picture')),
                Field::make('text', 'tm_title', __('Title')),
                Field::make('text', 'tm_location', __('Location')),
                Field::make('textarea', 'tm_content', __('Content')),
                Field::make('text', 'tm_short', __('TM Tag'))
            ))
        ))
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
            ?>

            <section class="clients-review-area section-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5 wow animated fadeInUp">
                            <!-- section heading -->
                            <div class="section-heading">
                                <h2 class="dark-1 fw-bold">
                                    <?php echo $fields['tm_heading']; ?>
                                </h2>

                            </div>
                            <!-- section heading -->

                            <!-- Primary Button -->
                            <div class=" mt-40">
                                <a href="<?php echo $fields['tm_para_url']; ?>" class="primary-main-btn text-uppercase fs-16 fw-bold text-decoration-none">
                                    <?php echo $fields['tm_para']; ?>
                                </a>
                            </div>
                            <!-- Primary Button -->
                        </div>
                        <div class="col-lg-7 wow animated fadeInUp">
                            <!-- clients review -->
                            <div class="clients-review-wrapper">
                                <div class="single-clients-review">

                                    <div id="clients-review-splide" class="clients-review-slider" role="group" aria-label="Splide Basic HTML Example">
                                        <div class="splide__track">
                                            <ul class="splide__list">
                                                <li class="splide__slide">Slide 01</li>
                                                <li class="splide__slide">Slide 02</li>
                                                <li class="splide__slide">Slide 03</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- clients review -->
                        </div>
                    </div>
                </div>
            </section>
            <?php
        });
