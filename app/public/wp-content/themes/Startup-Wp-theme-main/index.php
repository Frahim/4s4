<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Wp-ouie
 */
get_header();
$blogbg = carbon_get_theme_option('bp_image_bg');
?>
<section class="inner-page_banner section-padding" style="background-image: url( <?php echo wp_get_attachment_url($blogbg); ?>)">
    <div class="container">
        <div class="row align-items-center text-center justify-content-center">
            <div class="col-lg-7 col-12 ">
                <div class="banner-heading">
                    <h2 class="">
                        <?php echo carbon_get_theme_option('bp_descreption'); ?>                               
                    </h2>
                </div>
                <!-- Dark section heading -->
                <div class="content-banner">
                    <?php echo carbon_get_theme_option('bp_btn_text'); ?> 
                </div>
            </div>
        </div>
    </div>
</section>
<section class="blog-section latest-blog-area section-padding">
    <div class="container">
        <div class="row">
            <?php
            if (have_posts()) :
                /* Start the Loop */
                $count = 0;
                while (have_posts()) :
                    the_post();
                    $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                    $categories = get_the_category();
?>
                        <div class="col-lg-4 col-12 blog-item mb-4">
                            <div class="single-latest-blog">
                                <div class="featured-image">
                                    <img src="<?php echo $featured_img_url; ?>" alt="Featured image"
                                         class="img-fluid">
                                </div>
                                <div class="single-latest-blog-content radius-8">
                                    <!-- Date & Category -->
                                    <div class="date-category">
                                        <a href="/category/<?php
                                        if (!empty($categories)) {
                                            echo esc_html($categories[0]->slug);
                                        }
                                        ?>"
                                           class="post-category-name fs-14 <?php
                                           if (!empty($categories)) {
                                               echo esc_html($categories[0]->slug);
                                           }
                                           ?>  text-uppercase fw-bold text-white text-decoration-none bg-success-main">
                                               <?php
                                               if (!empty($categories)) {
                                                   echo esc_html($categories[0]->name);
                                               }
                                               ?> 
                                        </a>
                                        <span class="post-date fs-14 fw-bold dark-2">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M10.4499 11.2168L11.1999 10.4668L8.54992 7.80016V4.45016H7.54992V8.20016L10.4499 11.2168ZM7.99992 14.6668C7.08881 14.6668 6.2277 14.4918 5.41658 14.1418C4.60547 13.7918 3.89714 13.3141 3.29159 12.7085C2.68603 12.1029 2.20825 11.3946 1.85825 10.5835C1.50825 9.77238 1.33325 8.91127 1.33325 8.00016C1.33325 7.08905 1.50825 6.22794 1.85825 5.41683C2.20825 4.60572 2.68603 3.89738 3.29159 3.29183C3.89714 2.68627 4.60547 2.2085 5.41658 1.8585C6.2277 1.5085 7.08881 1.3335 7.99992 1.3335C8.91103 1.3335 9.77214 1.5085 10.5833 1.8585C11.3944 2.2085 12.1027 2.68627 12.7083 3.29183C13.3138 3.89738 13.7916 4.60572 14.1416 5.41683C14.4916 6.22794 14.6666 7.08905 14.6666 8.00016C14.6666 8.91127 14.4916 9.77238 14.1416 10.5835C13.7916 11.3946 13.3138 12.1029 12.7083 12.7085C12.1027 13.3141 11.3944 13.7918 10.5833 14.1418C9.77214 14.4918 8.91103 14.6668 7.99992 14.6668ZM7.99992 13.6668C9.55547 13.6668 10.8888 13.1113 11.9999 12.0002C13.111 10.8891 13.6666 9.55572 13.6666 8.00016C13.6666 6.44461 13.111 5.11127 11.9999 4.00016C10.8888 2.88905 9.55547 2.3335 7.99992 2.3335C6.44436 2.3335 5.11103 2.88905 3.99992 4.00016C2.88881 5.11127 2.33325 6.44461 2.33325 8.00016C2.33325 9.55572 2.88881 10.8891 3.99992 12.0002C5.11103 13.1113 6.44436 13.6668 7.99992 13.6668Z"
                                                    fill="#4C4C4C" />
                                            </svg>
                                            <?php echo get_the_date('j F Y', get_the_ID()) ?>

                                        </span>
                                    </div>
                                    <!-- Date & Category -->
                                    <h4 class="post-title dark-1 fw-bold">
                                        <?php echo get_the_title(); ?>


                                    </h4>
                                    <p class="post-excerpt fs-20 dark-2">
                                        <?php echo wp_trim_words(get_the_content(), 50, '...'); ?>
                                    </p>
                                </div>
                                <!-- Read More btn -->
                                <a href="<?php echo get_permalink() ?>"
                                   class="blog-read-more-btn dark-1 fs-16 fw-bold text-uppercase text-decoration-none">
                                    Read More
                                    <span class="read-more-btn-icon bg-primary-main">
                                        <svg width="52" height="52" viewBox="0 0 52 52" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M37.7307 22.9363L28.4292 13.6348L25.3656 16.6984L32.5004 23.8333H10.8337V28.1666H32.5004L25.3656 35.3014L28.4292 38.3651L37.7307 29.0636C38.5431 28.251 38.9995 27.149 38.9995 25.9999C38.9995 24.8509 38.5431 23.7489 37.7307 22.9363Z"
                                                fill="white" />
                                        </svg>
                                    </span>
                                </a>
                                <!-- Read More btn -->
                            </div>
                        </div>
                        <?php            
                    $count++;
                endwhile;
                //the_posts_navigation();
                ?>

                <?php wpbeginner_numeric_posts_nav(); ?>
                <!--                <div class="custom-pagination">
                                    <ul class="blog-pagination list-unstyled d-flex flex-wrap align-items-center justify-content-center">
                
                <?php
                echo '<li>';
                previous_posts_link('<a href="#" class="common-btn prev-btn">
                        <svg width="38" height="37" viewBox="0 0 38 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21.2496 23.6199L17.4463 19.8165C16.9971 19.3674 16.9971 18.6324 17.4463 18.1832L21.2496 14.3799" stroke="#4C4C4C" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        <rect x="1" y="0.5" width="36" height="36" rx="7.5" stroke="#B5B5B5"/>
                        </svg>
                    </a>');
                echo '</li>';
                global $wp_query;
                $total_pages = $wp_query->max_num_pages;
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo '<li>';
                    echo '<a href="' . esc_url(get_pagenum_link($i)) . '" class="common-btn text-decoration-none">' . $i . '</a>';
                    echo '</li>';
                }
                echo '<li>';
                next_posts_link('<a href="#" class="common-btn next-btn">
                        <svg width="38" height="37" viewBox="0 0 38 37" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M16.7504 23.6199L20.5537 19.8165C21.0029 19.3674 21.0029 18.6324 20.5537 18.1832L16.7504 14.3799" stroke="#4C4C4C" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
<rect x="-0.5" y="0.5" width="36" height="36" rx="7.5" transform="matrix(-1 0 0 1 36.5 0)" stroke="#B5B5B5"/>
</svg> </a>', $wp_query->max_num_pages);
                echo '</li>';
                ?>
                                    </ul>
                                </div>-->
                <?php
            endif;
            ?>
        </div>
    </div>
</section>


<?php
get_footer();
