<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('Container'))
    ->add_fields(array(
        Field::make('html', 'crb_container')
            ->set_html('<h2>Bostrap container</p>')
    ))
    ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
?>

    <div class="container">
        <?php echo  $inner_blocks; ?>
    </div><!-- /.block -->

<?php
    });
