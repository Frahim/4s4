<?php
get_header();

$category = get_queried_object(); // Get current category object
?>

<div class="custom-category-header py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-12">
                <h1 class="text-center"><?php echo $category->name; ?></h1>
                <div class="text-center category-description"><?php echo $category->description; ?></div>
            </div>
            <div class="col-md-12 col-12">
                <aside id="catCarousel" class="product-filters splide" role="group" aria-label="Splide Basic HTML Example">
                    <div class="filter-group splide__track">
                        <?php
                        // echo do_shortcode('[yith_wcan_filters slug="default-preset"]'); // Example for YITH Plugin 
                        // Get the current category object
                        $current_category = get_queried_object();

                        if ($current_category) {
                            // Fetch child categories of the current category
                            $child_categories = get_terms([
                                'taxonomy' => 'product_cat',
                                'parent' => $current_category->term_id,
                                'hide_empty' => false,
                            ]);

                            if (!empty($child_categories)) {
                                // Display child categories
                                // echo '<h2>Child Categories</h2>';
                                echo '<ul class="splide__list">';
                                foreach ($child_categories as $child) {
                                    echo '<li class="splide__slide"><a href="' . get_term_link($child) . '">' . esc_html($child->name) . '</a></li>';
                                }
                                echo '</ul>';
                            } else {
                                // If no child categories, display related categories (siblings)
                                $related_categories = get_terms([
                                    'taxonomy' => 'product_cat',
                                    'parent' => $current_category->parent,
                                    'exclude' => [$current_category->term_id],
                                    'hide_empty' => false,
                                ]);

                                if (!empty($related_categories)) {
                                    //  echo '<h2>Related Categories</h2>';
                                    echo '<ul class="splide__list">';
                                    foreach ($related_categories as $related) {
                                        echo '<li class="splide__slide"><a href="' . get_term_link($related) . '">' . esc_html($related->name) . '</a></li>';
                                    }
                                    echo '</ul>';
                                } else {
                                    echo '<p>No related categories found.</p>';
                                }
                            }
                        } else {
                            echo '<p>No category found.</p>';
                        }
                        ?>

                    </div>

                </aside>
            </div>
        </div>
    </div>
</div>

<div class="container custom-category-layout py-100">
    <div class="filter-group">
<?php echo do_shortcode('[yith_wcan_filters slug="default-preset"]'); // Example for Price Filter 
?>
    </div>
    <div class="row">
        <!-- Products Section -->
        <ul class="products-wrap">

<?php
// Custom product query
$args = array(
    'post_type' => 'product',
    'posts_per_page' => -1,
    'tax_query' => array(
        array(
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => $category->slug,
        ),
    ),
);

$products = new WP_Query($args);
if ($products->have_posts()) :
    while ($products->have_posts()) :
        $products->the_post();
        wc_get_template_part('content', 'product'); // Default WooCommerce product template
    endwhile;
    wp_reset_postdata();
else :
    echo '<p>No products found.</p>';
endif;
?>

        </ul>
    </div>
</div>

<?php get_footer(); ?>