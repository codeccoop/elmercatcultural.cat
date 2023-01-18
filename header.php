<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package elmercatcultural.cat
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&family=Montserrat:ital,wght@0,400;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <div id="page" class="site">
        <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'elmercatcultural.cat'); ?></a>

        <header id="masthead" class="site-header">
            <div class="site-branding">
                <?php
                the_custom_logo();
                ?>
            </div><!-- .site-branding -->

            <nav id="site-navigation" class="main-navigation">
                <div class="main-navigation-container">
                    <?php
                    $cart = WC()->cart->get_cart();
                    $cart_items = sizeof($cart);
                    if ($cart_items > 0 && !(is_cart() || is_checkout())) : ?>
                        <div class="cart-item-container">
                            <div class="cart-item" data-items="<?= $cart_items; ?>">
                                <a href="<?= wc_get_cart_url(); ?>"></a>
                            </div>
                        </div>
                    <? endif; ?>
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'menu-1',
                            'menu_id'        => 'primary-menu',
                        )
                    );
                    ?>
                </div>
                <a id="menu-close"></a>
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <span class="burger"></span>
                </button>
            </nav><!-- #site-navigation -->
        </header><!-- #masthead -->
        <div class="veil">
        </div>
