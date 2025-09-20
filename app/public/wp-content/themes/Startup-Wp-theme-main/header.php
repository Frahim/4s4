<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Wp-ouie
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Google font -->
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <header class="sticky">
        <div class="container">
            <div class="row align-items-center py-md-4 py-2">
                <div class="col-lg-3 col-4">
                    <div class="logo">
                        <?php
                        if (has_custom_logo()) :
                            the_custom_logo();
                        endif;
                        ?>
                    </div>
                </div>
                <div class="col-lg-6 col-4 searchbar text-center">
                    <div class="search-wrap">
                        <?php if (is_active_sidebar('header_search')) { ?>
                            <div id="header_search">
                                <?php dynamic_sidebar('header_search'); ?>
                            </div>
                        <?php } ?>
                       
                    </div>
                </div>
                <div class="col-lg-3 col-4 store-finder logon-wrap">
                    <div class="signbtn"><a href="/my-account/">Sign In</a></div>
                    <div class="regbtn"><a href="/my-account/">Free Registreation</a></div>
 <!-- <div class="carticon">
                            <div class="cart-icon">
                                <a href="<?php echo wc_get_cart_url(); ?>" class="cart-contents">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path d="M12 4C9.8 4 8 5.8 8 8h8C16 5.8 14.2 4 12 4zM6 8c0-3.3 2.7-6 6-6s6 2.7 6 6h3c0.6 0 1 0.4 1 1v12c0 0.6-0.4 1-1 1H3c-0.6 0-1-0.4-1-1V9c0-0.6 0.4-1 1-1H6zM4 10v10h16V10H4z"></path>
                                    </svg>
                                    <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                                </a>
                            </div>
                        </div> -->
                </div>
            </div>
        </div>
        <div class="container-fluid bg-dark2">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-3 ">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'menu-1',
                        'container' => 'ul',
                        'container_class' => '',                       
                         //'walker' => new Custom_Walker_Nav_Menu() // Custom walker to add classes
                    ));
                    ?>

                    <div class="ofc d-lg-none d-block">
                        <!-- Offcanvas Menu Trigger Button -->
                        <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0 0 16 16">
                                <path d="M0 7H16V9H0zM0 2H16V4H0zM0 12H16V14H0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

               
            </div>
        </div>

      

    </header>