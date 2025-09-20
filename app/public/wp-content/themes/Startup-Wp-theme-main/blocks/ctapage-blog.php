<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('Contact Page'))
        ->add_fields(array(
            Field::make('text', 'cpb_form_title', __('Form Heading')),
            Field::make('text', 'cpb_form_shortcode', __('Form Short Code')),
            Field::make('text', 'cpb_work_hour', __('Working Hours')),
            Field::make('text', 'cpb_work_hour_note', __('Working Hours Note')),
            Field::make('text', 'cpb_phone_title', __('Phone Sec Title')),
            Field::make('text', 'cpb_email_title', __('Email Sec Title')),
            Field::make('text', 'cpb_location_title', __('Location Sec Title'))
        ))
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
            ?>
            <section class="contact-form section-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-md-7">
                            <div class="formpart cta-item">
                                <h3 class="form-title"><?php echo $fields['cpb_form_title']; ?></h3>
                                <div class="form-wrwp">
                                    <?php echo do_shortcode($fields['cpb_form_shortcode']); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-5 contact-info">
                            <div class="working-wrwp cta-item">
                                <span>Working Hours</span>
                                <h3><?php echo $fields['cpb_work_hour'] ?></h3>
                                <p><?php echo $fields['cpb_work_hour_note'] ?></p>
                            </div>                            

                            <div class="phone-wrwp cta-item">
                                <span class="iconwrwp">
                                    <?php echo carbon_get_theme_option('crb_phone_svg') ?>
                                </span>
                                <span class="phonitem">
                                    <h3><?php echo $fields['cpb_phone_title'] ?></h3>
                                    <a href="tel:<?php echo carbon_get_theme_option('crb_phone_number'); ?>"><?php echo carbon_get_theme_option('crb_phone_number'); ?></a>
                                </span>
                            </div>
                            <div class="phone-wrwp cta-item">
                                <span class="iconwrwp">
                                    <?php echo carbon_get_theme_option('crb_email_svg') ?>
                                </span>
                                <span class="phonitem">
                                    <h3><?php echo $fields['cpb_email_title'] ?></h3>
                                    <a href="mailto:<?php echo carbon_get_theme_option('crb_email'); ?>"><?php echo carbon_get_theme_option('crb_email'); ?></a>
                                </span>
                            </div>

                            <div class="phone-wrwp cta-item">
                                <span class="iconwrwp">
                                    <?php echo carbon_get_theme_option('crb_address_svg') ?>
                                </span>
                                <span class="phonitem">
                                    <h3><?php echo $fields['cpb_location_title'] ?></h3>
                                    <a target="_blank" href="<?php echo carbon_get_theme_option('crb_map_link'); ?>"><?php echo carbon_get_theme_option('crb_address'); ?></a>
                                </span>
                            </div>
                            <div class="phone-wrwp cta-item cta-item-smf d-none d-md-block">
                                <!-- Footer social media -->
                                <ul class="followus-wrap">
                                    <li>Follow Us:</li>
                                    <?php
                                    $socialmedia = carbon_get_theme_option('quicklink');
                                    foreach ($socialmedia as $item) {
                                        ?>                            
                                        <li>
                                            <a href=" <?php echo $item['btn_url']; ?>"></a>
                                            <?php echo $item['btnsvg']; ?>

                                        </li>
                                    <?php } ?>

                                </ul>
                                <!-- Footer social media -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php
        });
