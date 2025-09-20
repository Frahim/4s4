<section class="latest-blog-area section-padding" style="background: <?php echo carbon_get_theme_option('spp_background'); ?>">
    <!-- section heading -->
    <div class="section-heading text-center mb-64">

        <h2 class="dark-1 fw-bold">
            <?php echo carbon_get_theme_option('spp_title'); ?> 
        </h2>                  

        <p class="dark-2">
            <?php echo carbon_get_theme_option('spp_text'); ?> 
        </p>

    </div>
    <!-- section heading -->

    <div class="container">
        <div class="splide" role="group" id="latest_blog_post_slider" aria-label="Splide Basic HTML Example">
            <div class="splide__track">
                <ul class="splide__list">
                    <?php
                    $args = array(
                        'posts_per_page' => -1,
                        'post_type' => 'post',
                    );
                    $the_query = new WP_Query($args);
                    while ($the_query->have_posts()) {
                        $the_query->the_post();
                        $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                        $a = get_the_category();
                        ?>
                        <li class="splide__slide">
                            <div class="single-latest-blog">
                                <div class="featured-image">
                                    <img src="<?php echo $featured_img_url; ?>" alt="Featured image"
                                         class="img-fluid">
                                </div>
                                <div class="single-latest-blog-content radius-8">

                                    <div class="date-category">
                                        <a href="/category/<?php echo $a[0]->slug; ?>"
                                           class="post-category-name <?php echo $a[0]->slug; ?> fs-14 text-uppercase fw-bold text-white text-decoration-none bg-success-main">
                                               <?php
                                               echo $category_name = $a[0]->name;
                                               ?>  
                                        </a>
                                        <span class="post-date fs-14 fw-bold dark-2">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M10.4499 11.2168L11.1999 10.4668L8.54992 7.80016V4.45016H7.54992V8.20016L10.4499 11.2168ZM7.99992 14.6668C7.08881 14.6668 6.2277 14.4918 5.41658 14.1418C4.60547 13.7918 3.89714 13.3141 3.29159 12.7085C2.68603 12.1029 2.20825 11.3946 1.85825 10.5835C1.50825 9.77238 1.33325 8.91127 1.33325 8.00016C1.33325 7.08905 1.50825 6.22794 1.85825 5.41683C2.20825 4.60572 2.68603 3.89738 3.29159 3.29183C3.89714 2.68627 4.60547 2.2085 5.41658 1.8585C6.2277 1.5085 7.08881 1.3335 7.99992 1.3335C8.91103 1.3335 9.77214 1.5085 10.5833 1.8585C11.3944 2.2085 12.1027 2.68627 12.7083 3.29183C13.3138 3.89738 13.7916 4.60572 14.1416 5.41683C14.4916 6.22794 14.6666 7.08905 14.6666 8.00016C14.6666 8.91127 14.4916 9.77238 14.1416 10.5835C13.7916 11.3946 13.3138 12.1029 12.7083 12.7085C12.1027 13.3141 11.3944 13.7918 10.5833 14.1418C9.77214 14.4918 8.91103 14.6668 7.99992 14.6668ZM7.99992 13.6668C9.55547 13.6668 10.8888 13.1113 11.9999 12.0002C13.111 10.8891 13.6666 9.55572 13.6666 8.00016C13.6666 6.44461 13.111 5.11127 11.9999 4.00016C10.8888 2.88905 9.55547 2.3335 7.99992 2.3335C6.44436 2.3335 5.11103 2.88905 3.99992 4.00016C2.88881 5.11127 2.33325 6.44461 2.33325 8.00016C2.33325 9.55572 2.88881 10.8891 3.99992 12.0002C5.11103 13.1113 6.44436 13.6668 7.99992 13.6668Z"
                                                    fill="#4C4C4C" />
                                            </svg>
                                            <?php echo get_the_date('j F Y') ?>

                                        </span>
                                    </div>                                  
                                    <h4 class="post-title dark-1 fw-bold">
                                        <?php echo get_the_title(); ?>


                                    </h4>
                                    <p class="post-excerpt fs-20 dark-2">
                                        <?php echo wp_trim_words(get_the_content(), 20, '...'); ?>
                                    </p>
                                </div>                           
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

                            </div>
                        </li>
                        <?php
                    };
                    wp_reset_postdata();
                    ?>
                </ul>
            </div>
        </div>
    </div>
</section>