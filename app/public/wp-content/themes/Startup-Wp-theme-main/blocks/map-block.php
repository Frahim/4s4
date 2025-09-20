<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('Map Block'))
        ->add_tab(__('Content Area'), array(
            Field::make('textarea', 'map_src', __('Iframe')),
            Field::make('image', 'map_image', __('Store Image')),
            Field::make('image', 'map_loc_image', __('Location Icon')),
        ))
        ->add_tab(__('Style Area'), array(
            Field::make('color', 'abu_background', 'Background')
            ->set_palette(array('#FF0000', '#00FF00', '#0000FF')),
            Field::make('image', 'abu_bg', __('Background Image')),
        ))
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
             $loc = carbon_get_theme_option('crb_address');
            ?>

            <!-- Location Map Start  -->
            <section class="map-wrapper">
                <div class="map-iframe-wrap">
                    <iframe class="map-iframe-inner" width="100%" frameborder="0" scrolling="no" marginheight="0"
                            marginwidth="0" style="border: 0; margin-top: -150px"
                            src="<?php echo $fields['map_src']; ?>">                                    
                    </iframe>
                </div>
                <div class="map-address-card">
                    <div>
                        <img class="img-fluid" src="<?php echo wp_get_attachment_url($fields['map_image']); ?>" alt="image">
                    </div>
                    <div class="address-info">
                        <div>
                            <?php if (!empty($fields['map_loc_image'])) { ?>
                                <img src="<?php echo wp_get_attachment_url($fields['map_image']); ?>" alt="icon" class="img-fluid">
                                <?php } else {
                                    ?>
                                    <svg width="56" height="56" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect y="-0.00012207" width="56" height="56" rx="28" fill="#FDF6DC"/>
                                        <path d="M37.2097 21.9899C36.7036 20.8191 35.9739 19.759 35.0618 18.8695C34.1467 17.972 33.068 17.2596 31.8844 16.7713C30.6532 16.2589 29.3468 16 28 16C26.6532 16 25.3468 16.2589 24.1156 16.7686C22.9247 17.2622 21.8575 17.9688 20.9382 18.8668C20.0267 19.7568 19.2971 20.8168 18.7903 21.9872C18.2661 23.2008 18 24.4899 18 25.8168C18 27.7209 18.4543 29.6168 19.3468 31.4453C20.0645 32.9152 21.0672 34.3472 22.3306 35.7092C24.4892 38.0339 26.7527 39.4552 27.3952 39.8355C27.5775 39.9435 27.7855 40.0004 27.9973 40C28.207 40 28.414 39.9461 28.5995 39.8355C29.2419 39.4552 31.5054 38.0339 33.664 35.7092C34.9274 34.3499 35.9301 32.9152 36.6478 31.4453C37.5457 29.6195 38 27.7263 38 25.8195C38 24.4926 37.7339 23.2035 37.2097 21.9899ZM28 37.9314C26.2285 36.8014 19.9355 32.3272 19.9355 25.8195C19.9355 23.7186 20.7715 21.7445 22.2903 20.2558C23.8145 18.7644 25.8414 17.9418 28 17.9418C30.1586 17.9418 32.1855 18.7644 33.7097 20.2585C35.2285 21.7445 36.0645 23.7186 36.0645 25.8195C36.0645 32.3272 29.7715 36.8014 28 37.9314ZM28 21.286C25.3871 21.286 23.2688 23.4112 23.2688 26.0326C23.2688 28.654 25.3871 30.7792 28 30.7792C30.6129 30.7792 32.7312 28.654 32.7312 26.0326C32.7312 23.4112 30.6129 21.286 28 21.286ZM30.129 28.1686C29.8498 28.4495 29.5179 28.6723 29.1525 28.8241C28.7872 28.9759 28.3955 29.0538 28 29.0532C27.1962 29.0532 26.4409 28.7376 25.871 28.1686C25.5909 27.8884 25.3689 27.5555 25.2175 27.1889C25.0662 26.8223 24.9886 26.4294 24.9892 26.0326C24.9892 25.2262 25.3038 24.4684 25.871 23.8966C26.4409 23.3249 27.1962 23.012 28 23.012C28.8038 23.012 29.5591 23.3249 30.129 23.8966C30.6989 24.4684 31.0107 25.2262 31.0107 26.0326C31.0107 26.839 30.6989 27.5968 30.129 28.1686Z" fill="#EDCD5A"/>
                                    </svg>
                                    <?php
                                }
                                ?>
                        </div>
                        <p class=" text-clr-primary-blue fw-medium fs-18"><?php echo $loc; ?></p>
                    </div>
                </div>
            </section>
            <!-- Location Map end  -->
            <?php
        });
