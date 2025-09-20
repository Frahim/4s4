<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Wp-ouie
 */
get_header();
?>
<div class="custom-category-header py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-12">
                <h1 class="text-center"><?php the_title(); ?></h1>                
            </div>

        </div>
    </div>
</div>
<div class="page-content-wrwpper">

    <?php
    the_content();
    ?>

</div>
<?php
get_footer();
