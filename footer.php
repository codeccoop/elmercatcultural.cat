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
            <div class="footer__row">
                <p class="footer__title small">
                    Contacte
                </p>
                <p class="footer__text small">
                    <?= preg_replace('/\n/', '<br>', get_theme_mod('contact')) ?>
                </p>
            </div>
            <div class="footer__row">
                <p class="footer__title small">
                    Horari
                </p>
                <p class="footer__text small">
                    <?= preg_replace('/\n/', '<br>', get_theme_mod('open_hours')); ?>
                </p>
            </div>

        </div>
        <div class="footer__column">
            <div class="footer__row">
                <p class="footer__title small">Dona't d'alta al nostre butlletí</p>
            </div>
        </div>
        <div class="footer__column">
            <div class="footer__row">
                <p class="footer__title small">Com arribar</p>
            </div>
            <div class="footer__row">
                <?php
                $coordinates = array_map('trim', explode(' ', get_theme_mod('coordinates')));
                # $coordinates = [41.5028, 1.81346];
                $lat = $coordinates[0];
                $lng = $coordinates[1];
                echo do_shortcode('[embedded_map lng="' . $lng . '" lat="' . $lat . '" class="contact__map"]');
                ?>
            </div>
        </div>
        <div class="footer__column">
            <div class="footer__row">
                <p class="footer__title small">Troba-ns a</p>
                <ul class="footer__social">
                    <li><a></a></li>
                    <li><a></a></li>
                    <li><a></a></li>
                    <li><a></a></li>
                </ul>
            </div>
        </div>
        <div class="footer__column">
            <div class="footer__row">
                <p class="footer__text small"><a>Avís legal</a></p>
                <p class="footer__text small"><a>Política de privacitat</a></p>
            </div>
            <div class="footer__row">
                <p class="footer__text small">Amb el suport de</p>
                <img src="<?= get_bloginfo('template_url') . '/assets/images/logo-ajuntament.png'; ?>" />
            </div>
        </div>
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
