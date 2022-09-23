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
        <div class="footer__column"></div>
        <div class="footer__column"></div>
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
