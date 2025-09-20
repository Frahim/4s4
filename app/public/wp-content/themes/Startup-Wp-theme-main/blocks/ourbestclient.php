<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('Our Best Client'))
        ->add_tab(__('Content'), array(
            Field::make('text', 'obc_heading', __('Heading')),
            Field::make('textarea', 'obc_content', __('Content')),
            //Field::make('text', 'obc_link', __('URL')),
            //Field::make('text', 'obc_link_text', __('BTN Text')),
            Field::make('file', 'obc_file', __('Video')),
            Field::make('image', 'obc_poster', __('Video Poster')),
            Field::make('text', 'obc_poster_text', __('Video Poster Text')),
        ))
        ->add_tab(__('Slider'), array(
            Field::make('text', 'obc_slider_heading', __('Heading')),
            Field::make('textarea', 'obc_slider_content', __('Content')),
            // Field::make('text', 'obc_slider_link', __('URL')),
            // Field::make('text', 'obc_slider_link_text', __('BTN Text')),
            Field::make('image', 'obc_slider_bg', __('Background')),
            Field::make('complex', 'obc_slider_items', __('Slider Items'))
            ->set_layout('tabbed-vertical')
            ->add_fields(array(
                Field::make('text', 'obc_slider_titlt', __('Title')),
                Field::make('textarea', 'obc_slider_content', __('Content')),
                Field::make('file', 'obc_slider_file', __('Video')),
                Field::make('image', 'obc_slider_poster', __('Video Poster')),
                Field::make('text', 'obc_slider_poster_text', __('Video Poster Text')),
            ))
        ))
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
            ?>
            <section class="best-client-section">
                <div class="container">
                    <div class="bset-client-wrapper"> 
                        <div class="bcw-titlewrwp">
                            <div class="bcw-tag wow fadeInUp animated">
                                <p>Our Best Client</p>
                            </div>
                            <div class="bew-contentwrwp">
                                <h2 class="bcw-title wow fadeInLeft animated">
                                    <?php echo $fields['obc_heading']; ?>
                                </h2>
                                <p class="bew-content wow fadeInLeft animated">
                                    <?php echo $fields['obc_content']; ?>
                                </p>
                                <!-- Primary Button -->
                                <div class="mt-40 wow fadeInDown animated" data-wow-delay="1.0s">
                                    <a href="<?php echo carbon_get_theme_option('cta_url'); ?>" class="primary-main-btn text-uppercase fs-16 fw-bold text-decoration-none">
                                        <?php echo carbon_get_theme_option('cta_btn_text'); ?>                                 
                                    </a>
                                </div>
                                <!-- Primary Button -->  
                            </div>   
                        </div>
                        <div class="video-wrap wow fadeInDown animated">
                            <span id="duration">
                                <?php
                                $video_url = wp_get_attachment_url($fields['obc_file']);
                                $video_meta = wp_get_attachment_metadata($fields['obc_file']);
                                //var_dump($video_meta);
                                ?>
                            </span>
                            <img src="<?php echo wp_get_attachment_url($fields['obc_poster']); ?>" alt="Item Image"/>   
                            <div class="postertext">
                                <div class="posttxt">
                                    <div class="headerwrwp">
                                        <?php echo $fields['obc_poster_text']; ?>
                                        <div class="duration"> <?php echo $video_meta['length_formatted']; ?> Min</div>
                                    </div>

                                    <button type="button" class="btn btn-primary video-btn" data-bs-toggle="modal" data-src=" <?php echo $video_url; ?>" data-bs-target="#myModal"> 
                                        <svg width="120" height="121" viewBox="0 0 120 121" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M60 8.10107C31.0078 8.10107 7.5 31.6089 7.5 60.6011C7.5 89.5933 31.0078 113.101 60 113.101C88.9922 113.101 112.5 89.5933 112.5 60.6011C112.5 31.6089 88.9922 8.10107 60 8.10107ZM76.8867 61.4097L51.293 80.0308C51.1527 80.1316 50.9873 80.1918 50.815 80.2047C50.6427 80.2177 50.4701 80.1829 50.3163 80.1042C50.1625 80.0254 50.0334 79.9059 49.9431 79.7585C49.8529 79.6112 49.805 79.4418 49.8047 79.269V42.0503C49.8041 41.8772 49.8515 41.7073 49.9416 41.5594C50.0317 41.4116 50.1609 41.2915 50.3151 41.2127C50.4692 41.1338 50.6421 41.0991 50.8147 41.1125C50.9873 41.1259 51.1529 41.1869 51.293 41.2886L76.8867 59.8979C77.0076 59.9835 77.1063 60.0967 77.1743 60.2283C77.2424 60.3598 77.2779 60.5057 77.2779 60.6538C77.2779 60.8019 77.2424 60.9478 77.1743 61.0794C77.1063 61.2109 77.0076 61.3242 76.8867 61.4097Z" fill="#F9FBFF"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
            <section class="best-client-slider-section" style="background-image: url( <?php echo wp_get_attachment_url($fields['obc_slider_bg']); ?>)">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-6 col-12">
                            <h2 class="slider-sec-title wow fadeInLeft animated">
                                <?php echo $fields['obc_slider_heading']; ?>
                            </h2>
                            <p class="slider-sec-cont wow fadeInLeft animated"><?php echo $fields['obc_slider_content']; ?></p>
                            <!-- Primary Button -->
                            <div class="mt-40 wow fadeInLeft animated">
                                <a href="<?php echo carbon_get_theme_option('cta_url'); ?>" class="primary-main-btn text-uppercase fs-16 fw-bold text-decoration-none">
                                    <?php echo carbon_get_theme_option('cta_btn_text'); ?>                                     
                                </a>
                            </div>
                            <!-- Primary Button -->  
                        </div>
                        <div class="col-md-6 col-12 wow fadeInUp animated">
                            <div class="splide" id="ourbestclientslider">
                                <div class="splide__track">
                                    <ul class="splide__list">
                                        <?php
                                        foreach ($fields['obc_slider_items'] as $item) {
                                            $sl_video_meta = wp_get_attachment_metadata($item['obc_slider_file']);
                                            ?>
                                            <li class="splide__slide">
                                                <img src="<?php echo wp_get_attachment_url($item['obc_slider_poster']); ?>" alt="Item Image"/>   
                                                <div class="postertext">
                                                    <div class="posttxt">
                                                        <div class="headerwrwp-sm"> 
                                                            <?php echo $item['obc_slider_poster_text']; ?>  
                                                            <div class="duration"> <?php echo $sl_video_meta['length_formatted']; ?> Min</div>
                                                        </div>
                                                        <button type="button" class="btn btn-primary video-btn" data-bs-toggle="modal" data-src=" <?php echo wp_get_attachment_url($item['obc_slider_file']); ?>" data-bs-target="#myModal"> 
                                                            <svg width="74" height="74" viewBox="0 0 120 121" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M60 8.10107C31.0078 8.10107 7.5 31.6089 7.5 60.6011C7.5 89.5933 31.0078 113.101 60 113.101C88.9922 113.101 112.5 89.5933 112.5 60.6011C112.5 31.6089 88.9922 8.10107 60 8.10107ZM76.8867 61.4097L51.293 80.0308C51.1527 80.1316 50.9873 80.1918 50.815 80.2047C50.6427 80.2177 50.4701 80.1829 50.3163 80.1042C50.1625 80.0254 50.0334 79.9059 49.9431 79.7585C49.8529 79.6112 49.805 79.4418 49.8047 79.269V42.0503C49.8041 41.8772 49.8515 41.7073 49.9416 41.5594C50.0317 41.4116 50.1609 41.2915 50.3151 41.2127C50.4692 41.1338 50.6421 41.0991 50.8147 41.1125C50.9873 41.1259 51.1529 41.1869 51.293 41.2886L76.8867 59.8979C77.0076 59.9835 77.1063 60.0967 77.1743 60.2283C77.2424 60.3598 77.2779 60.5057 77.2779 60.6538C77.2779 60.8019 77.2424 60.9478 77.1743 61.0794C77.1063 61.2109 77.0076 61.3242 76.8867 61.4097Z" fill="#F9FBFF"/>
                                                            </svg>

                                                        </button>
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
                </div>
            </section>
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></span>
                            </button>        
                            <!-- 16:9 aspect ratio -->
                            <div class="ratio ratio-16x9">
            <!--                                <iframe class="embed-responsive-item" src="" id="video"  allowscriptaccess="always" allow="autoplay"></iframe>-->
                                <video id="video"  controls>
                                    <source src="" type="video/mp4"> 
                                        Your browser does not support HTML5 video.
                                </video>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                // Declare a variable to store the video source
                let videoSrc;

                // Add click event listener to all elements with class "video-btn"
                document.querySelectorAll('.video-btn').forEach(button => {
                    button.addEventListener('click', () => {
                        // Get the video source from the data-src attribute
                        videoSrc = button.dataset.src;
                        console.log(videoSrc);
                    });
                });

                // Add event listener for when the modal is opened
                document.getElementById('myModal').addEventListener('shown.bs.modal', () => {
                    // Update the video source with autoplay and other options
                    document.getElementById('video').src = videoSrc + "?autoplay";
                });

                // Add event listener for when the modal is closed
                //                document.getElementById('myModal').addEventListener('hide.bs.modal', () => {
                //                    // Stop the video by resetting the source
                //                    document.getElementById('video').src = videoSrc;
                //                });
                document.getElementById('myModal').addEventListener('hide.bs.modal', () => {
                    // Debugging statement to check if the event listener is triggered
                    console.log("Modal is hiding");

                    // Pause the video explicitly
                    const video = document.getElementById('video');
                    if (video) {
                        console.log("Video element found, pausing video");
                        video.pause();
                    } else {
                        console.error("Video element not found");
                    }
                });



            </script>

            <?php
        });
