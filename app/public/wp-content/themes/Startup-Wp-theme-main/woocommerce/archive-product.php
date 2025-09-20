<?php
defined('ABSPATH') || exit;

get_header(); // Load the WooCommerce header
?>
<div class="custom-category-header py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-12">
                <header class="woocommerce-products-header">
                    <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
                    <h1 class="woocommerce-products-header__title page-title">
                        <?php woocommerce_page_title(); ?>
                    </h1>
                    <?php endif; ?>

                    <?php do_action('woocommerce_archive_description'); ?>
                </header>
            </div>

        </div>
    </div>
</div>
<div class="container py-5">
    <div class="row">
        <!-- Sidebar for Filters -->
        <aside class="col-md-3">
            <?php if (is_active_sidebar('shop-sidebar')) : ?>
            <div class="shop-sidebar">
                <?php dynamic_sidebar('shop-sidebar'); ?>
            </div>
            <?php endif; ?>
        </aside>

        <!-- Products Section -->
        <div class="col-md-9">
            <?php if (woocommerce_product_loop()) : ?>

            <?php
                // Add sorting dropdown
                do_action('woocommerce_before_shop_loop');
                ?>
            <div class="col-12 shop-loop">
                <div class="row">
                    <?php while (have_posts()) : ?>
                    <?php the_post(); ?>
                    <div class="col-md-4 mb-4">
                        <div class="product-card h-100">
                            <?php
                                /**
                                 * Hook: woocommerce_shop_loop.
                                 */
                                do_action('woocommerce_shop_loop');
                                wc_get_template_part('content', 'product');
                                ?>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
            <?php
                // Pagination
                do_action('woocommerce_after_shop_loop');
                ?>

            <?php else : ?>

            <?php do_action('woocommerce_no_products_found'); ?>

            <?php endif; ?>

        </div>
    </div>
</div>

<?php get_footer(); ?>