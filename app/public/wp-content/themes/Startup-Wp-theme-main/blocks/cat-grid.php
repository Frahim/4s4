<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('New coming through'))
    ->add_tab(__('Content Part'), array(
        Field::make('text', 'nct_items_sec_title', __('SEC Title')),      

        Field::make('complex', 'nct_items', __('Items'))
            ->set_layout('tabbed-vertical')
            ->add_fields(array(
                Field::make('text', 'nct_items_title', __('Title')),
                Field::make('image', 'nct_items_photo', __('Photo')),
                Field::make('text', 'nct_items_url', __('URL')),

            )),

        Field::make('complex', 'nct_botom_items', __('Items'))
            ->set_layout('tabbed-vertical')
            ->add_fields(array(
                Field::make('text', 'nct_botom_items_title', __('Title')),
                Field::make('image', 'nct_botom_items_photo', __('Photo')),
                Field::make('text', 'nct_botom_items_url', __('URL')),

            )),
            Field::make('image', 'nct_items_sec_tag', __('SEC tag')),
            Field::make('text', 'nct_items_sec_url', __('SEC URL')),
    ))

    ->set_render_callback(function ($fields, $attributes) {


?>
    <div class="container-fluid py-5">
        <div class="row">
            <div class="col-12">
                <h2 class="sectitle"><?php echo $fields['nct_items_sec_title'] ?></h2>
            </div>
            <?php foreach ($fields['nct_items'] as  $item) { ?>
                <div class="col-lg-2 col-sm-4 mb-3 mb-lg-0 col-12">
                    <div class="inner-wrap">
                        <a href="<?php echo $item['nct_items_url'] ?>">
                            <img src="<?php echo wp_get_attachment_url($item['nct_items_photo']); ?>" />
                            <h2><?php echo $item['nct_items_title'] ?></h2>
                            <div class="ovlay"></div>
                        </a>
                    </div>
                </div>
            <?php } ?>
            <div class="bobtom-items col-12 py-5">
                <div class="row row-no-gutters">
                    <?php
                    foreach ($fields['nct_botom_items'] as $item) {
                                      ?>
                        <div class="col-lg-4 col-12">
                            <div class="inner-wrap">
                               
                                    <img src="<?php echo wp_get_attachment_url($item['nct_botom_items_photo']); ?>" />
                                    <h2><?php echo $item['nct_botom_items_title'] ?></h2>
                                    <div class="ovlay"></div>
                                <a href="<?php echo $item['nct_botom_items_url'] ?>"> Discover <span></span> </a>
                            </div>
                        </div>
                    <?php
                    }

                    ?>
                </div>

            </div>
            <div class="bobtom-items col-12 py-5">
                <div class="row row-no-gutters">
                        <div class="col-lg-12 col-12">
                            <div class="inner-wrap">
                                <a href="<?php echo$fields['nct_items_sec_url'] ?>">
                                    <img src="<?php echo wp_get_attachment_url($fields['nct_items_sec_tag']); ?>" />
                                   
                                </a>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>

<?php
    });
