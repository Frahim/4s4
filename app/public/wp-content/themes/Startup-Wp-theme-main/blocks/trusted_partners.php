<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('Partners'))
        ->add_tab(__('Choisir Items'), array(
            Field::make('text', 'otgp_heading', __('Block Title')),
            Field::make('textarea', 'otgp_content', __('Block Content')),
            Field::make('media_gallery', 'otgp_link', __('Partner Images')),
        ))
        ->add_tab(__('Style'), array(
            Field::make('color', 'otgp_background', 'Background')
            ->set_palette(array('#FF0000', '#00FF00', '#0000FF')),
            Field::make('image', 'otgp_bg_photo', __('Background Photo')),
        ))
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
            ?>

<section class="partners-carousel-area section-padding" style="background-image:url(<?php echo wp_get_attachment_url($fields['otgp_bg_photo']); ?>); ">
                <div class="container">
                    <!-- Section heading -->
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="text-center">
                                <h2 class="section-heading text-clr-neviBlue ff-sg-semibold-25 common-title-animation wow fadeInUp  animated">
                                    <?php echo $fields['otgp_heading']; ?>  
                                </h2>
                                <p class="wow fadeInUp  animated"><?php echo $fields['otgp_content']; ?> </p>
                            </div>
                        </div>
                    </div>
                    <!-- Section heading -->
                </div>
                <div class="partners-carousel-wrapper">
                    <div class="container">
                        <div class="splide" id="partnersCarousel" role="group" aria-label="Splide Basic HTML Example">
                            <div class="splide__track">
                                <ul class="splide__list">
                                    <?php
                                    $gallery = $fields['otgp_link'];
                                    foreach ($gallery as $i => $image) {
                                        ?>
                                        <li class="splide__slide wow fadeInUp  animated">
                                            <div class="d-flex flex-column justify-content-evenly h-100">
                                                <div
                                                    class="partners-carousel-item d-flex align-items-center justify-content-center h-100 carousel-border-right carousel-border">
                                                    <img src="<?php echo wp_get_attachment_url($image); ?>" alt="Partners Logo"
                                                         class="img-fluid">
                                                </div>

                                            </div>
                                        </li>
                                    <?php }
                                    ?>
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <?php
        });
