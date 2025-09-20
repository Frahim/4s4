<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;


Block::make('Product Carousel')
    ->add_fields(array(
        Field::make('text', 'product_category_sec_title', __('Sec Title ')),
        Field::make('select', 'product_category', 'Select Product Category')
            ->set_options(function () {
                $categories = get_terms('product_cat', array('hide_empty' => false));
                $options = [];
                if (!empty($categories) && !is_wp_error($categories)) {
                    foreach ($categories as $category) {
                        $options[$category->term_id] = $category->name;
                    }
                }
                return $options;
            })
    ))
    ->set_render_callback(function ($fields, $attributes, $inner_blocks) {

        ?>
    <section class="product-caro-sec section-padding">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-12">
                    <?php 
                    if(!empty($fields['product_category_sec_title'])):
                    ?>
                    <h2 class="sectitle"><?php echo $fields['product_category_sec_title']; ?> </h2>
                    <?php endif; ?>
                    <div id="product_caru" class="splide product_caru" role="group" aria-label="Splide Basic HTML Example">
                        <div class="splide__arrows">
                          
                            <button class="splide__arrow splide__arrow--next">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6.17667 20L5 18.8233L13.2342 10.5892C13.3904 10.4329 13.4782 10.221 13.4782 9.99999C13.4782 9.77902 13.3904 9.5671 13.2342 9.41083L5.01417 1.19249L6.1925 0.0141602L14.4108 8.23249C14.8795 8.70131 15.1428 9.33708 15.1428 9.99999C15.1428 10.6629 14.8795 11.2987 14.4108 11.7675L6.17667 20Z"
                                        fill="white" />
                                </svg>

                            </button>
                        </div>
                        <?php
                            $selected_category = $fields['product_category'];

                            if ($selected_category) {
                                $args = array(
                                    'post_type' => 'product',
                                    'posts_per_page' => -1,
                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => 'product_cat',
                                            'field' => 'term_id',
                                            'terms' => $selected_category,
                                            'operator' => 'IN',
                                        ),
                                    ),
                                );

                                $query = new WP_Query($args);

                                if ($query->have_posts()): ?>

                                <div class="splide__track">
                                    <ul class="splide__list">
                                        <?php while ($query->have_posts()):
                                                $query->the_post(); ?>
                                            <?php $product = wc_get_product(get_the_ID()); // Define the $product variable 
                                                                ?>
                                            <li <?php wc_product_class('splide__slide', $product); ?>>
                                                <?php
                                                    /**
                                                     * Hook: woocommerce_before_shop_loop_item.
                                                     *
                                                     * @hooked woocommerce_template_loop_product_link_open - 10
                                                     */
                                                    do_action('woocommerce_before_shop_loop_item');

                                                    /**
                                                     * Hook: woocommerce_before_shop_loop_item_title.
                                                     *
                                                     * @hooked woocommerce_show_product_loop_sale_flash - 10
                                                     * @hooked woocommerce_template_loop_product_thumbnail - 10
                                                     */
                                                    do_action('woocommerce_before_shop_loop_item_title');
                                                    ?>
                                                <div class="product-content">
                                                    <?php
                                                        /**
                                                         * Hook: woocommerce_shop_loop_item_title.
                                                         *
                                                         * @hooked woocommerce_template_loop_product_title - 10
                                                         */
                                                        do_action('woocommerce_shop_loop_item_title');

                                                        /**
                                                         * Hook: woocommerce_after_shop_loop_item_title.
                                                         *
                                                         * @hooked woocommerce_template_loop_rating - 5
                                                         * @hooked woocommerce_template_loop_price - 10
                                                         */
                                                        do_action('woocommerce_after_shop_loop_item_title');

                                                        /**
                                                         * Hook: woocommerce_after_shop_loop_item.
                                                         *
                                                         * @hooked woocommerce_template_loop_product_link_close - 5
                                                         * @hooked woocommerce_template_loop_add_to_cart - 10
                                                         */
                                                        do_action('woocommerce_after_shop_loop_item');
                                                        ?>
                                                </div>
                                            </li>
                                        <?php endwhile; ?>
                                    </ul>
                                </div>

                            <?php else: ?>
                                <p>No products found in this category.</p>
                            <?php endif; ?>

                            <?php
                                wp_reset_postdata();
                            } else {
                                echo '<p>No category selected.</p>';
                            }
                            ?>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <?php
    });
