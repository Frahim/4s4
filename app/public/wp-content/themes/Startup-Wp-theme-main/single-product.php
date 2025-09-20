<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Wp-ouie
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

get_header('shop'); ?>



<div class="container">

	<div class="row">
		<div class="col-12 py-4">
			<?php
			/**
			 * woocommerce_before_main_content hook.
			 *
			 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
			 * @hooked woocommerce_breadcrumb - 20
			 */
			do_action('woocommerce_before_main_content');
			?>

			<?php while (have_posts()) : ?>
				<?php the_post(); ?>

				<?php wc_get_template_part('content', 'single-product'); ?>

			<?php endwhile; // end of the loop. 
			?>

			<?php
			/**
			 * woocommerce_after_main_content hook.
			 *
			 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
			 */
			do_action('woocommerce_after_main_content');
			?>

			<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
				<div class="offcanvas-header">
					<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
				</div>
				<div class="offcanvas-body">
					<div class="size-gide-wrap">
						<?php
						global $post;

						// Get the selected size guide ID from the custom field
						$selected_guide_id = carbon_get_post_meta($post->ID, 'size_guide_select');

						if (! empty($selected_guide_id)) {
							// Get the size guide post
							$size_guide_post = get_post($selected_guide_id);

							if ($size_guide_post) {
								// Display the size guide title and content
								echo '<div class="size-guide">';
								echo '<h3>' . esc_html($size_guide_post->post_title) . '</h3>';
								echo wp_kses_post(wpautop($size_guide_post->post_content)); // Output the content of the size guide
								echo '</div>';
							}
						}

						?>
					</div>

				</div>
			</div>
			<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample2" aria-labelledby="offcanvasExampleLabel">
				<div class="offcanvas-header">
					<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
				</div>
				<div class="offcanvas-body">
					<div class="size-gide-wrap">
						

						<h5 class="card-title mb-3">Delevery Information</h5>
						<p class="card-text mb-3">With supporting text below as a natural lead-in to additional content.</p>
						<p class="card-text mb-3">With supporting text below as a natural lead-in to additional content.</p>
						<p class="card-text mb-3">With supporting text below as a natural lead-in to additional content.</p>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<?php
get_footer('shop');
