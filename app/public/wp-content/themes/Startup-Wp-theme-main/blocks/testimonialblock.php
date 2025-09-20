<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('Testimonial'))
        ->add_tab(__('Section'), array(
            Field::make('text', 'tmd_heading', __('Section Heading')),
            Field::make('text', 'tmd_content', __('Section Content')),
            Field::make('text', 'tmd_para', __('BTN Text')),
            Field::make('text', 'tmd_para_url', __('BTN URL')),
        ))
        ->add_tab(__('Testimonial Item'), array(
            Field::make('complex', 'tm_items', __('Testimonial Items'))
            ->set_layout('tabbed-vertical')
            ->add_fields(array(
                Field::make('text', 'tm_name', __('Name')),
                Field::make('textarea', 'tm_content', __('Content')),
                Field::make('text', 'tm_location', __('Location')),
                Field::make('image', 'tm_image', __('Picture'))
            ))
        ))
        ->add_tab(__('Style'), array(
            Field::make('color', 'tm_background', 'Background')
            ->set_palette(array('#FF0000', '#00FF00', '#0000FF')),
            Field::make('image', 'tm_bg', __('Background Image')),
        ))
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
            ?>

            <section class="clients-review-area py-120">
                <div class="container">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-lg-5 hed-wrwp">
                            <!-- section heading -->
                            <div class="section-heading">
                                <h2 class="tm-sec-title wow animated fadeInLeft">
                                    <?php echo $fields['tmd_heading']; ?>
                                </h2>
                                <p class="tm-sec-content wow animated fadeInLeft">
                                    <?php echo $fields['tmd_content']; ?>
                                </p>
                            </div>
                            <!-- section heading -->

                            <!-- Primary Button -->
                            <div class=" mt-40 wow animated fadeInLeft">
                                <a href="<?php echo $fields['tmd_para_url']; ?>" class="primary-main-btn text-uppercase fs-16 fw-bold text-decoration-none">
                                    <?php echo $fields['tmd_para']; ?>
                                </a>
                            </div>
                            <!-- Primary Button -->
                        </div>

                        <div class="col-lg-6 tm-wrap-item wow animated fadeInRight">
                            <!-- clients review -->
                            <div class="clients-review-wrapper">
                                <div class="single-clients-review">
                                    <div id="clients-review-splide" class="splide" role="group" aria-label="Splide Basic HTML Example">
                                        <div class="splide__arrows">
                                            <button class="splide__arrow splide__arrow--prev">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M6.17667 20L5 18.8233L13.2342 10.5892C13.3904 10.4329 13.4782 10.221 13.4782 9.99999C13.4782 9.77902 13.3904 9.5671 13.2342 9.41083L5.01417 1.19249L6.1925 0.0141602L14.4108 8.23249C14.8795 8.70131 15.1428 9.33708 15.1428 9.99999C15.1428 10.6629 14.8795 11.2987 14.4108 11.7675L6.17667 20Z" fill="white"/>
                                                </svg>

                                            </button>
                                            <button class="splide__arrow splide__arrow--next">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M6.17667 20L5 18.8233L13.2342 10.5892C13.3904 10.4329 13.4782 10.221 13.4782 9.99999C13.4782 9.77902 13.3904 9.5671 13.2342 9.41083L5.01417 1.19249L6.1925 0.0141602L14.4108 8.23249C14.8795 8.70131 15.1428 9.33708 15.1428 9.99999C15.1428 10.6629 14.8795 11.2987 14.4108 11.7675L6.17667 20Z" fill="white"/>
                                                </svg>

                                            </button>
                                        </div>
                                        <div class="splide__track">
                                            <ul class="splide__list">
                                                <?php
                                                foreach ($fields['tm_items'] as $tmitem) {
                                                    ?>
                                                    <li class="splide__slide tmitem_wrap">
                                                        <span class="coment-icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path d="M14.6455 2.82349V21.1764L22.5867 13.4117V2.82349H14.6455Z" fill="#00A2E1"/>
                                                                <path d="M1.41113 2.82349V21.1764L9.35231 13.4117V2.82349H1.41113Z" fill="#00A2E1"/>
                                                            </svg>
                                                        </span>
                                                        <p class="tm_content">
                                                            <?php echo $tmitem['tm_content']; ?>
                                                        </p>
                                                        <div class="name"><strong> <?php echo $tmitem['tm_name']; ?></strong> <?php echo $tmitem['tm_location']; ?></div>
                                                        <span class="coment-icon-bottom">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path d="M14.6455 2.82349V21.1764L22.5867 13.4117V2.82349H14.6455Z" fill="#2B3335"/>
                                                                <path d="M1.41113 2.82349V21.1764L9.35231 13.4117V2.82349H1.41113Z" fill="#2B3335"/>
                                                            </svg>
                                                        </span>
                                                    </li>
                                                <?php } ?>
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
            <style>
                .clients-review-area{
                    background-image:url(<?php echo wp_get_attachment_url($fields['tm_bg']); ?>);
                    background-repeat: no-repeat;
                    background-position:top center;
                }
            </style>
            <?php
        });
