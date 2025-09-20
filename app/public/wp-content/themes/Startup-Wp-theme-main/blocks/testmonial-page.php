<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('Testmonial page Block'))
        ->add_tab(__('Content Area'), array(
            Field::make('text', 'tpb_title', __('Block Title')),
            Field::make('rich_text', 'tpb_sub_title', __('Block Sub Title')),
            Field::make('association', 'tpb_association', __('Association'))
            ->set_types(array(
                array(
                    'type' => 'post',
                    'post_type' => 'testmonial',
                    'posts_per_page' => -1
                )
            ))
        ))
        ->add_tab(__('Style Area'), array(
            Field::make('color', 'tpb_background', 'Background')
            ->set_palette(array('#FF0000', '#00FF00', '#0000FF')),
            Field::make('image', 'tpb_bg', __('Background Image')),
        ))
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
            ?>

            <section class="testmonial-section py-120">
                <div class="container">
                    <div class="row align-items-center text-center justify-content-center">
                        <div class="col-12 col-lg-8 mb-60">                           
                            <h2 class="fadeInUp animated tmheading">
                                <?php echo $fields['tpb_title']; ?>                                
                            </h2>                        
                            <div class="content-tm fadeInDown animated">
                                <?php echo $fields['tpb_sub_title']; ?>       
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center justify-content-center">
                        <?php
                        $i = 0;
                        foreach ($fields['tpb_association'] as $tmitem) {   
                           // var_dump($tmitem);
                             $post_id = $tmitem['id'];
                            $location = carbon_get_post_meta($post_id, 'cst_title');
                            ?>
                    
                        <?php 
                       // $keyvalues = get_post_meta( $tmitem['id'], 'cst_title' );
                       // var_dump($keyvalues);
                        ?>
                            <?php
                            // $featured_img_url = get_the_post_thumbnail_url($tmitem['id'], 'full');
                            ?>
                            <div class="col-lg-4 col-12 tm_item">
                                <div class="inner_wrwp_tm">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none">
                                            <path d="M29.6693 15L34.6588 17.5003C33.9729 18.8832 33.4308 20.3325 33.0436 21.8371C32.6564 23.3528 32.4683 25.1119 32.4683 27.1254V33H24.0934V27.059C24.0934 25.6982 24.3589 24.2711 24.8899 22.7664C25.421 21.2618 26.1069 19.8347 26.9477 18.4739C27.7885 17.1131 28.6957 15.9514 29.6693 15ZM18.9157 15L23.9053 17.5003C23.2194 18.8832 22.6773 20.3325 22.2901 21.8371C21.9028 23.3528 21.7148 25.1119 21.7148 27.1254V33H13.3398V27.059C13.3398 25.6982 13.6054 24.2711 14.1364 22.7664C14.6674 21.2618 15.3534 19.8347 16.1942 18.4739C17.035 17.1131 17.9422 15.9514 18.9157 15Z" fill="#00A2E1"/>
                                        </svg>
                                    </span>                                    
                                    <div class="content_part_tm"> 
                                        <?php echo get_post_field('post_content', $tmitem['id']); ?> 
                                    </div>
                                    <h2><?php echo get_the_title($tmitem['id']); ?>, <span><?php echo esc_html($location); ?></span></h2>
                                </div>

                            </div>
                            <?php
                        };
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
            </div>
            </section>
            <?php
        });
 