<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('My Clients Say'))
        ->add_fields(array(
            Field::make('text', 'mcs_heading', __('Heading')),
            Field::make('complex', 'mcs_video_items', __('Vodei items'))
            ->set_layout('tabbed-vertical')
            ->add_fields(array(
                Field::make('file', 'mcs_video_file', __('Video')),
                Field::make('image', 'mcs_video_poster', __('Video Poster')),
            ))
        ))
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
            ?>
            <section class="section-padding myclientsay-sec">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col12 wow fadeInDown animated">
                            <h2 class="darkblue-title"><?php echo $fields['mcs_heading']; ?></h2>
                        </div>
                        <div class="vedio-secwrap col-12">
                            <div class="row">
                            <?php
                            $i=1;
                            foreach ($fields['mcs_video_items'] as $i => $item) {
                                ?>
                                <div class="col-12 col-md-4 single-video wow fadeInUp animated" data-wow-delay="0.<?php echo $i; ?>s">
                                    <div class="ratio ratio-16x9">            
                                        <video id="video-grid"  controls poster="<?php echo wp_get_attachment_url($item['mcs_video_poster']); ?>">
                                            <source src="<?php echo wp_get_attachment_url($item['mcs_video_file']); ?>" type="video/mp4"> 
                                            Your browser does not support HTML5 video.
                                        </video>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                                <a href="#" id="loadMore">View More...</a>
                            </div>
                        </div>
                    </div>        
                </div>
            </section>

            <?php
        });
