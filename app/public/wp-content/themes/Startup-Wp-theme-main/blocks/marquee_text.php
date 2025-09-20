<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('marquee'))
    ->add_tab(__('Content Part'), array(
        Field::make('text', 'marquee_text', __('Marquee Text')),
        // Field::make('complex', 'marquee_items', __('Marquee items'))
        //     ->set_layout('tabbed-vertical')
        //     ->add_fields(array(
        //         Field::make('text', 'marquee_text', __('Marquee Text')),
        //     ))

    ))
    ->add_tab(__('Style'), array(
        Field::make('color', 'marquee_background', 'Background')

    ))
    ->set_render_callback(function ($fields, $attributes) {
?>


    <div class="mqheader">
        <div class="marquee">
            <h1> <?php echo $fields['marquee_text']; ?></h1>
        </div>
    </div>
    <script>
        // script.js
        function Marquee(selector, speed, gap) {
            const parentSelector = document.querySelector(selector);
            const clone = parentSelector.innerHTML;
            const firstElement = parentSelector.children[0];
            let i = 0;
            let marqueeInterval;

            parentSelector.insertAdjacentHTML('beforeend', clone);
            parentSelector.insertAdjacentHTML('beforeend', clone);

            // Apply gap to the child elements of the parent container
            const childElements = parentSelector.children;
            for (let element of childElements) {
                element.style.marginRight = `${gap}px`; // Set the gap between the items
            }

            function startMarquee() {
                marqueeInterval = setInterval(function() {
                    firstElement.style.marginLeft = `-${i}px`;
                    if (i > firstElement.clientWidth) {
                        i = 0;
                    }
                    i = i + speed;
                }, 0);
            }

            function stopMarquee() {
                clearInterval(marqueeInterval);
            }

            parentSelector.addEventListener('mouseenter', stopMarquee);
            parentSelector.addEventListener('mouseleave', startMarquee);

            startMarquee();
        }

        window.addEventListener('load', () => Marquee('.marquee', 0.1, 200)); // Example gap of 20px
    </script>
<?php
    });
