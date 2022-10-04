<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package elmercatcultural.cat
 */

?>

<footer id="colophon" class="site-footer" style="background-color: white;">
    <div class="footer__content">
        <div class="footer__column">
            <img class="footer__logo" src="<?= get_bloginfo('template_url') . '/assets/images/logo--medium.png'; ?>">
        </div>
        <div class="footer__column">
            <div class="footer__column__adress">
                <p class="footer__title small">
                    Contacte
                </p>
                <p class="footer__text small">
                    Carrer de x, 30 </br>
                    08018 Barcelona </br>
                    elmercat@elmercatcultural.cat </br>
                    93 200 24 34
                </p>
            </div>
            <div class="footer__column__timetable">
                <p class="footer__title small">
                    Horari
                </p>
                <p class="footer__text small">
                    de 10 a 14h </br>
                    i de 17 a 21h </br>
                </p>
            </div>
            
        </div>
        <div class="footer__column"></div>
            <div class="footer__column_map">
                <?php
                $coordinates = array_map('trim', explode(' ', get_theme_mod('map_coordinates')));
                $lat = $coordinates[0];
                $lng = $coordinates[1];
                echo do_shortcode('[embedded_map lng="' . $lng . '" lat="' . $lat . '" class="contact__map"]');
                ?>
            </div>
        <div class="footer__column"></div>
        <div class="footer__column"></div>
        <div class="footer__column"></div>
    </div>
    <div class="site-info">
        Pàgina web feta amb <a href="<?php echo esc_url(__('https://wordpress.org/', 'elmercatcultural.cat')); ?>">WordPress</a>
        <span class="sep"> | </span>
        <?php
        /* translators: 1: Theme name, 2: Theme author. */
        printf(esc_html__('Tema: %1$s by %2$s.', 'elmercatcultural.cat'), 'elmercatcultural.cat', '<a href="https://www.codeccoop.com/">Còdec</a>');
        ?>
    </div><!-- .site-info -->
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>
