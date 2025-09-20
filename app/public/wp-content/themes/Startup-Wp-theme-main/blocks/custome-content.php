<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('Custome Content Block'))
        ->add_fields(array(
            Field::make('text', 'ccb_title', __('Content'))
        ))
        ->set_inner_blocks(true)
        ->set_inner_blocks_position('below')
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
            ?>
            <section class="custome-content py-120">
                <div class="container">
                    <?php if (!empty($fields['ccb_title'])): ?>
                        <h2 class="custom-cont-title"><?php echo $fields['ccb_title']; ?></h2>
                    <?php endif; ?>
                    <div><?php echo $inner_blocks; ?></div>
                </div>
            </section>
            <?php
        });
