<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Wp-ouie
 */
$flogo = carbon_get_theme_option('footer_image');
$footerbg = carbon_get_theme_option('footer_bg');

$socialmedia = carbon_get_theme_option('quicklink');
$ctabg = carbon_get_theme_option('cta_image_bg');

$form = carbon_get_theme_option('footer_signup_form');
?>

<footer class="footer-area" style="background-image: url(<?php echo wp_get_attachment_url($footerbg); ?>)">
    <!-- Footer top -->
    <div class="footer-top">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-12 sign-up-wraper section-padding text-center">
                    <!-- <a href="<?php echo get_home_url(); ?>">
                        <img src="<?php echo wp_get_attachment_url($flogo); ?>" alt="Footer Logo" class="img-fluid">
                    </a> -->
                    <h2 class="signyp-form"><?php echo carbon_get_theme_option('footer_signup'); ?></h2>
                    <p class="signyp-form-desc"><?php echo carbon_get_theme_option('footer_signup_desc'); ?></p>
                    <div class="signup-form-wraap"><?php echo do_shortcode($form);  ?></div>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="footer-widget">
                                <h4 class="footer-widget-title dark-5 fw-bold">
                                    <?php echo carbon_get_theme_option('footer_cta1'); ?>
                                </h4>
                                <div class="footer-menu-wrapper">
                                    <div class="menu-item">
                                        <?php
                                        wp_nav_menu(array(
                                            'theme_location' => 'menu-2',
                                            'container' => 'ul',
                                            'container_class' => '',
                                            'menu_class' => 'footer-navigation-menu',
                                            'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>', // Customizing the output format for better filter handling                                   
                                        ));
                                        ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="footer-widget">
                                <h4 class="footer-widget-title dark-5 fw-bold">
                                    <?php echo carbon_get_theme_option('footer_cta2'); ?>
                                </h4>
                                <div class="menu-item menu-item-2nd">
                                    <?php
                                    wp_nav_menu(array(
                                        'theme_location' => 'menu-3',
                                        'container' => 'ul',
                                        'container_class' => '',
                                        'menu_class' => 'footer-navigation-menu',
                                        'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>', // Customizing the output format for better filter handling                                   
                                    ));
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                        <div class="footer-widget">
                                <h4 class="footer-widget-title dark-5 fw-bold">
                                    <?php echo carbon_get_theme_option('footer_cta3'); ?>
                                </h4>
                                <div class="menu-item menu-item-2nd">
                                    <?php
                                    wp_nav_menu(array(
                                        'theme_location' => 'menu-4',
                                        'container' => 'ul',
                                        'container_class' => '',
                                        'menu_class' => 'footer-navigation-menu',
                                        'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>', // Customizing the output format for better filter handling                                   
                                    ));
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="footer-widget">
                                <h4 class="social-widget-title">
                                    <?php echo carbon_get_theme_option('footer_nav'); ?>
                                </h4>
                                <!-- Footer social media -->
                                <ul class="footer-social-media-link">
                                    <?php
                                    foreach ($socialmedia as $item) {
                                       // var_dump($item);
                                    ?>
                                        <li>
                                            <a href=" <?php echo $item['btn_url']; ?>">
                                                <!-- <span><?php echo $item['btnsvg']; ?></span> <span><?php echo $item['btn_title']; ?></span> -->
                                                 <i class="<?php echo $item['btn_icon']['class']?>"></i>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                                <!-- Footer social media -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer top -->
    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="copyright-text">

<div class="payment-img">
<?php
                                    $gallery = carbon_get_theme_option('footer_payment_image');
                                    foreach ($gallery as $i => $image) {
                                        ?>
                                        <span class="wow fadeInUp  animated">
                                            <div class="payment-icon-wrap">
                                                <div
                                                    class="payment-icon">
                                                    <img src="<?php echo wp_get_attachment_url($image); ?>" alt="Partners Logo"
                                                         class="img-fluid">
                                                </div>

                                            </div>
                                    </span>
                                    <?php } ?>
</div>

                        <?php echo carbon_get_theme_option('footer_copyright'); ?>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Footer Bottom -->
</footer>



<?php wp_footer(); ?>

</body>

</html>