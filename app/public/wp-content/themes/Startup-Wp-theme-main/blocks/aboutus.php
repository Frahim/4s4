<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('About Us'))
        ->add_tab(__('Content Area'), array(
            Field::make('text', 'abu_heading', __('Heading')),
            Field::make('textarea', 'abu_content', __('Content')),
            Field::make('image', 'abu_icon', __('Image')),
            Field::make('text', 'abu_link', __('URL')),
            Field::make('text', 'link_text', __('BTN Text')),
        ))
        ->add_tab(__('Gallery'), array(
            Field::make('media_gallery', 'abu_media_gallery', __('Media Gallery'))
        ))
        ->add_tab(__('Style Area'), array(
            Field::make('color', 'abu_background', 'Background')
            ->set_palette(array('#FF0000', '#00FF00', '#0000FF')),
            Field::make('image', 'abu_bg', __('Background Image')),
        ))
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
            ?>
            <section class="about-us-area py-120 d-none d-lg-block" style="background-image: url( <?php echo wp_get_attachment_url($fields['abu_bg']) ?>)">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 wow fadeInRight  animated">
                            <div class="about-section-img-wrap">
                                <img src="<?php echo wp_get_attachment_url($fields['abu_icon']); ?>" alt="Image" class="img-fluid">                                   
                            </div>
                        </div>

                        <div class="col-lg-9 wow fadeInLeft animated mb-80">
                            <div class="about-section-content-wrap">
                                <!-- Dark section heading -->
                                <div class="dark-section-heading">
                                    <h2 class="">
                                        <?php echo $fields['abu_heading']; ?>                                
                                    </h2>
                                </div>
                                <!-- Dark section heading -->
                                <div class="content-wrapper">
                                    <?php echo $fields['abu_content']; ?>
                                </div>

                                <!-- Primary Button -->
                                <div class="mt-40">
                                    <a href="<?php echo $fields['abu_link']; ?>" class="blue-cta-btn text-decoration-none">
                                        <?php echo $fields['link_text']; ?>                                      
                                    </a>
                                </div>
                                <!-- Primary Button -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12  gallery-wrap  wow fadeInUp animated">
                            <div class="gallery-wrap-inner">
                                <?php
                                $gallery = $fields['abu_media_gallery'];
                                foreach ($gallery as $i => $image) {
                                    echo '<img src="' . wp_get_attachment_url($image) . '" class="d-block w-100">';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="about-us-area py-120 d-block d-lg-none">
                <div class="container">
                    <div class="row">
                        <div class="title-wrap-abt wow fadeInRight  animated">
                            <div class="about-section-img-wrap">
                                <img src="<?php echo wp_get_attachment_url($fields['abu_icon']); ?>" alt="Image" class="img-fluid">                                   
                            </div>
                            <div class="dark-section-heading">
                                <h2 class="">
                                    <?php echo $fields['abu_heading']; ?>                                
                                </h2>
                            </div>
                        </div>

                        <div class="col-lg-12 wow fadeInLeft animated mb-80">
                            <div class="about-section-content-wrap">                              
                                <div class="content-wrapper">
                                    <?php echo $fields['abu_content']; ?>
                                </div>
                                <!-- Primary Button -->
                                <div class="mt-40">
                                    <a href="<?php echo $fields['abu_link']; ?>" class="blue-cta-btn text-decoration-none">
                                        <?php echo $fields['link_text']; ?>                                      
                                    </a>
                                </div>
                                <!-- Primary Button -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12  gallery-wrap  wow fadeInUp animated">
                            <div id="aboutgallery"  class="splide" role="group" aria-label="Splide Basic HTML Example">
                                <div class="splide__track">
                                    <ul class="splide__list">
                                        <?php
                                        $gallery = $fields['abu_media_gallery'];
                                        foreach ($gallery as $i => $image) {
                                            //echo '<img src="' . wp_get_attachment_url($image) . '" class="d-block w-100">';
                                            ?>
                                            <li class="splide__slide"><img src="<?php echo wp_get_attachment_url($image); ?>" class="d-block w-100"></li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php
        });
