<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('FAQs Block'))
        ->add_fields(array(
            Field::make('text', 'faq_heading', __('FAQ Section Heading')),
            Field::make('image', 'faq_bg', __('FAQ Section BG')),
            Field::make( 'color', 'faq_background', __( 'Background Color' ) ),
            Field::make('complex', 'faqs_items', __('FAQs items'))
            ->set_layout('tabbed-vertical')
            ->add_fields(array(
                Field::make('text', 'faq_question', __('Question')),
                Field::make('textarea', 'faq_answer', __('Answer Text')),                
            ))
        ))
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
            ?>

            <section class="faq-section section-padding faq" style="background-image: url( <?php echo wp_get_attachment_url($fields['faq_bg']) ?>); background-color:<?php echo $fields['faq_background'] ?>">
                <div class="container">
                    <div class="row align-items-start justify-content-center">
                        <div class="col-lg-7 col-12">
                            <div class="faq-section-title text-center">
                                <h2 class="darkblue-title wow fadeInUp animated">
                                    <?php echo $fields['faq_heading']; ?>                           
                                </h2>
                            </div>
                        </div>
                        <div class="col-lg-10 col-12 faw-wrwp">
                            <div class="faq-accordion-sec-wrap">
                                <div class="accordion " id="accordionFlushExample">
                                    <div>
                                        <?php    
                                        $i=1;
                                        foreach ($fields['faqs_items'] as  $item) {
                                            ?>
                                            <div class="accordion-item wow fadeInUp animated" data-wow-delay="0.<?php echo $i; ?>s">
                                                <div class="accordion-header">
                                                    <button
                                                        class="accordion-button collapsed"
                                                        type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#flush-collapse<?php echo $i; ?>"
                                                        aria-expanded="false" aria-controls="flush-collapse<?php echo $i; ?>">
                                                        <span><?php echo $i; ?>.</span>  <?php echo $item['faq_question']; ?>
                                                    </button>
                                                </div>
                                                <div id="flush-collapse<?php echo $i; ?>" class="accordion-collapse collapse"
                                                     data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body ff-sg-book-20">
                                                        <?php if (!empty($item['faq_answer'])) { ?>
                                                            <?php echo $item['faq_answer']; ?>
                                                        <?php } ?>                                                      
                                                    </div>
                                                </div>
                                            </div>
                                        <?php 
                                        $i++;
                                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

               
            </section>
            <?php
        });
