<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('Splide Slider'))
    ->add_tab(__('Slides'), array(
        Field::make('complex', 'splide_slides', __('Slides'))
            ->add_fields(array(
                Field::make('text', 'slide_tag', __('Tag Line')),
                Field::make('text', 'slide_heading', __('Slide Title')),
                Field::make('text', 'slide_sub_heading', __('Slide Sub Title')),
                Field::make('rich_text', 'slide_content', __('Slide Content')),
                Field::make('image', 'slide_bg_image', __('Slide Image')),
                Field::make('text', 'slide_btn_url', __('Button URL')),
                Field::make('text', 'slide_cta_txt', __('Button Text')),
            ))
    ))
    ->add_tab(__('Slider Options'), array(
        Field::make('text', 'splide_class', __('CSS Class')),
        Field::make('checkbox', 'splide_arrows', __('Show Arrows')),
        Field::make('checkbox', 'splide_pagination', __('Show Pagination')),
        Field::make('text', 'splide_perpage', __('Slides per Page'))
            ->set_attribute('type', 'number')
            ->set_default_value(1),
        Field::make('text', 'splide_gap', __('Gap between Slides'))
            ->set_default_value('1rem'),
        Field::make('select', 'splide_type', __('Slider Type'))
            ->add_options(array(
                'slide'  => __('Slide'),
                'loop'   => __('Loop'),
                'fade'   => __('Fade'),
            ))
            ->set_default_value('loop'),
    ))
    ->set_render_callback(function ($fields, $attributes) {
    // Enqueue Splide assets (adjust paths if needed)
       // Prepare Splide options
    $splide_options = [
        'type'         => $fields['splide_type'],
        'perPage'      => (int)$fields['splide_perpage'],
        'gap'          => $fields['splide_gap'],
        'arrows'       => (bool)$fields['splide_arrows'],
        'pagination'   => (bool)$fields['splide_pagination'],
    ];

    // Convert options to a JSON string
    $options_json = json_encode($splide_options);
$slider_id = 'splide-' . uniqid();
    ?>

    <section id="<?php echo esc_attr($slider_id); ?>" class="splide <?php echo esc_attr($fields['splide_class']); ?>" aria-label="Splide Slider">
        <div class="splide__track">
            <ul class="splide__list">
                <?php foreach ($fields['splide_slides'] as $slide) { ?>
                    <li class="splide__slide">
                        <!-- <div class="slide-content-wrapper">
                            <?php if (!empty($slide['slide_tag'])) { ?>
                                <p class="tag-line"><?php echo esc_html($slide['slide_tag']); ?></p>
                            <?php } ?>

                            <?php if (!empty($slide['slide_heading'])) { ?>
                                <h2 class="slide-title"><?php echo esc_html($slide['slide_heading']); ?></h2>
                            <?php } ?>

                            <?php if (!empty($slide['slide_sub_heading'])) { ?>
                                <h3 class="slide-sub-title"><?php echo esc_html($slide['slide_sub_heading']); ?></h3>
                            <?php } ?>

                            <?php if (!empty($slide['slide_content'])) {
                                echo apply_filters('the_content', $slide['slide_content']);
                            } ?>
                            
                            <?php if (!empty($slide['slide_btn_url']) && !empty($slide['slide_cta_txt'])) { ?>
                                <a href="<?php echo esc_url($slide['slide_btn_url']); ?>" class="slide-button">
                                    <?php echo esc_html($slide['slide_cta_txt']); ?>
                                </a>
                            <?php } ?>
                        </div> -->
                        
                        <?php if (!empty($slide['slide_bg_image'])) { ?>
                            <div class="slide-image">
                                <img src="<?php echo esc_url(wp_get_attachment_url($slide['slide_bg_image'])); ?>" alt="<?php echo esc_attr($slide['slide_heading']); ?>" />
                            </div>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </section>

    <script>
       document.addEventListener('DOMContentLoaded', function () {
            // Target the specific slider using its unique ID
            const slider = document.getElementById('<?php echo esc_js($slider_id); ?>');
            
            if (slider) {
                const splideInstance = new Splide(slider, <?php echo $options_json; ?>).mount();

                // Listen for 'mounted' and 'moved' events to trigger the animation
                splideInstance.on('mounted moved', function () {
                    const activeSlide = splideInstance.Components.Slides.get(splideInstance.index);
                    const allSlides = splideInstance.Components.Slides.get();
                    
                    // First, reset all slides
                    allSlides.forEach(slide => {
                        slide.slide.querySelector('.slide-content-wrapper').classList.remove('active');
                    });
                    
                    // Then, add the active class to the current slide
                    if (activeSlide) {
                        activeSlide.slide.querySelector('.slide-content-wrapper').classList.add('active');
                    }
                });
            }
        });
    </script>
    <?php
});