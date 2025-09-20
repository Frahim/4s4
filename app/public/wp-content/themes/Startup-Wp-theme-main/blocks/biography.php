<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('Biography'))
        ->add_fields(array(
            Field::make('text', 'biography_heading', __('Heading')),
            Field::make('textarea', 'biography_content', __('Content')),
            Field::make('image', 'biography_icon', __('Image')),
            Field::make('text', 'biography_client', __('Client Number')),
            Field::make('image', 'biography_image_bg', __('Image BG')),
        ))
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
            ?>

            <section class="about-us-area section-padding" style="background-image: url( <?php echo wp_get_attachment_url($fields['biography_image_bg']) ?>)">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6 wow fadeInLeft animated">
                            <div class="about-section-content-wrap">
                                <!-- Dark section heading -->
                                <h2 class="dark-1 fw-bold titlevalue">
                                    <?php echo $fields['biography_heading']; ?>                                
                                </h2>

                                <!-- Dark section heading -->
                                <div class="content-wrapper">
                                    <?php echo $fields['biography_content']; ?>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-5 offset-lg-1 wow fadeInRight animated">
                            <div class="about-section-img-wrap">
                                <div class="client-wrap">
                                    <div class="clientaa">
                                        <span class="normal-tx">Client</span>
                                        <span><svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_35_19282)">
                                                    <path d="M16.3064 2.88849C9.05456 2.88849 3.17578 8.76727 3.17578 16.0191C3.17578 23.271 9.05456 29.1497 16.3064 29.1497C23.5583 29.1497 29.437 23.271 29.437 16.0191C29.437 8.76727 23.5583 2.88849 16.3064 2.88849ZM16.3064 27.5084C9.96103 27.5084 4.81711 22.3645 4.81711 16.0191C4.81711 9.67374 9.96103 4.52982 16.3064 4.52982C22.6518 4.52982 27.7957 9.67374 27.7957 16.0191C27.7957 22.3645 22.6518 27.5084 16.3064 27.5084Z" fill="#FF8F00"/>
                                                    <path d="M12.2029 13.5571C13.1093 13.5571 13.8442 12.8223 13.8442 11.9158C13.8442 11.0093 13.1093 10.2745 12.2029 10.2745C11.2964 10.2745 10.5615 11.0093 10.5615 11.9158C10.5615 12.8223 11.2964 13.5571 12.2029 13.5571Z" fill="#FF8F00"/>
                                                    <path d="M20.4094 13.5571C21.3159 13.5571 22.0507 12.8223 22.0507 11.9158C22.0507 11.0093 21.3159 10.2745 20.4094 10.2745C19.5029 10.2745 18.7681 11.0093 18.7681 11.9158C18.7681 12.8223 19.5029 13.5571 20.4094 13.5571Z" fill="#FF8F00"/>
                                                    <path d="M22.051 16.0191C22.051 19.1918 19.4791 21.7638 16.3064 21.7638C13.1337 21.7638 10.5617 19.1918 10.5617 16.0191H8.92041C8.92041 20.0983 12.2272 23.4051 16.3064 23.4051C20.3856 23.4051 23.6924 20.0983 23.6924 16.0191H22.051Z" fill="#FF8F00"/>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_35_19282">
                                                        <rect width="26.2613" height="26.2613" fill="white" transform="translate(3.17529 2.8885)"/>
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                        </span>
                                         </div>
                                        <div class="clent_number"><?php echo $fields['biography_client']; ?></div>
                                        <span class="normal-tx">Happy Client</span>
                                   
                                </div>
                                <img src="<?php echo wp_get_attachment_url($fields['biography_icon']); ?>" alt="Image" class="img-fluid">                                    
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php
        });
