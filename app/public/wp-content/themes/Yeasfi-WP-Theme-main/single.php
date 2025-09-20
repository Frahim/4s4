<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Yeasfi_WP_Theme
 */

get_header();
?>

<div class="<?php echo carbon_get_theme_option( 'ywt_container_select' ); ?>">
    <div class="row">
        <div class="col-9">
            <main id="primary" class="site-main">

                <?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

            </main><!-- #main -->
        </div>
        <div class="col-3">
		<?php 
		get_sidebar();
		?>
          
        </div>
    </div>
</div>

<?php
get_sidebar();
get_footer();
