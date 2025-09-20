<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('Container Block'))
        ->add_fields(array(
            Field::make('html', 'crb_container')
            ->set_html('<h2>Container</h2>')
        ))
        ->set_inner_blocks(true)
        ->set_inner_blocks_position('below')
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
            ?>   
            <section class="section-padding custom-content-block">
                <div class="container ">
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-12 ">
                            <?php echo $inner_blocks; ?>
                        </div>
                    </div>
                </div>
            </section>
            <?php
        });
