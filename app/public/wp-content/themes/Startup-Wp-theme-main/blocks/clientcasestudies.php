<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('Client Case Studies'))
        ->add_fields(array(
            Field::make('text', 'ccs_heading', __('Heading')),
            Field::make('textarea', 'ccs_content', __('Content')),
            Field::make('complex', 'ccs_items', __('Case Studies items'))
            ->set_layout('tabbed-vertical')
            ->add_fields(array(
                Field::make('file', 'ccs_item_video', __('Video URL')),
                Field::make('image', 'ccs_item_poster', __('Video Poster')),
            ))
        ))
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
            ?>
            <section class="case-studies-area section-padding">
                <div class="container">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-12">
                            <!-- section heading -->
                            <div class="section-heading text-center">
                                <h2 class="fw-bold text-white  wow animated fadeInUp">
                                    <?php echo $fields['ccs_heading']; ?>     
                                </h2>
                                <p class="text-white fw-normal  wow animated fadeInUp">
                                    <?php echo $fields['ccs_content']; ?>  
                                </p>
                            </div>
                            <!-- section heading -->
                        </div>
                        <div class="col-lg-8 p-60  wow animated fadeInUp">
                            <!-- clients review -->

                            <div class="splide">
                                <div class="splide__track">
                                    <ul class="splide__list">
                                        <?php
                                        foreach ($fields['ccs_items'] as $item) {
                                            $video_url = wp_get_attachment_url($item['ccs_item_video']);
                                            ?>
                                            <li class="splide__slide" data-splide-html-video="<?php echo $video_url; ?>">
                                                <img src="<?php echo wp_get_attachment_url($item['ccs_item_poster']); ?>">                                                    
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
            </section>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    const splide = new Splide('.splide', {
                        heightRatio: 0.6,
                        cover: true,
                        arrows: false,
                        video: {
                            loop: true
                        }
                    });
                    splide.mount(window.splide.Extensions); // Corrected line
                });
            </script>
            <?php
        });
