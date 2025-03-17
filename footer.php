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

<section id="newsletter" class="newsletter__section">
    <div class="newsletter__section-border">
        <div class="newsletter__section-content">
	    <h2>Dona't d'alta al nostre butlletí</h2>
        <?php echo do_shortcode('[contact-form-7 id="1b92982" title="Subscriu-te al butlletí"]'); ?>
    </div>
</section>
<hr>
<footer id="colophon" class="site-footer" style="background-color: white;">
    <div class="footer__content">
        <div class="footer__column">
            <div class="footer__logo"></div>
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
                    Horari d'obertura
                </p>
                <p class="footer__text small">
                    <?= preg_replace('/\n/', '<br>', get_theme_mod('open_hours')); ?>
                </p>
            </div>
        </div>
        <div class="footer__column">
            <div class="footer__row">
                <p class="footer__title small">Com arribar</p>
                <p class="footer__text small">
                    <?= preg_replace('/\n/', '<br>', get_theme_mod('howtoarrive')); ?>
                </p>
            </div>
            <div class="footer__row">
                <?php
                $coordinates = array_map('trim', explode(' ', get_theme_mod('coordinates')));
$lat = $coordinates[0];
$lng = $coordinates[1];
echo do_shortcode('[embedded_map lng="' . $lng . '" lat="' . $lat . '" class="contact__map"]');
?>
            </div>
        </div>
        <div class="footer__column">
            <div class="footer__row">
                <p class="footer__title small">Troba'ns a</p>
                <ul class="footer__social">
                    <li><a href="<?= get_theme_mod('instagram'); ?>" target="_blank"><img src="<?= get_bloginfo('template_url') . '/assets/images/instagram.png'; ?>" /></a></li>
                    <li><a href="<?= get_theme_mod('twitter'); ?>" target="_blank"><img src="<?= get_bloginfo('template_url') . '/assets/images/twitter.png'; ?>" /></a></li>
                    <li><a href="<?= get_theme_mod('whatsapp'); ?>" target="_blank"><img src="<?= get_bloginfo('template_url') . '/assets/images/whatsapp.png'; ?>" /></a></li>
                    <li><a href="<?= get_theme_mod('telegram'); ?>" target="_blank"><img src="<?= get_bloginfo('template_url') . '/assets/images/telegram.png'; ?>" /></a></li>
                </ul>
            </div>
        </div>
        <div class="footer__column">
            <div class="footer__row">
                <p class="footer__text small">elMercat forma part de:</p>
                <img src="<?= get_bloginfo('template_url') . '/assets/images/xec.png'; ?>" />
                <p class="footer__text small">Amb el suport de:</p>
                <img src="<?= get_bloginfo('template_url') . '/assets/images/logo-ajuntament.png'; ?>" />
            </div>
        </div>
    </div>
    <div class="site-info">
        <div class="legal_info">
            <p class="footer__text small">
                <span><a href="/avis-legal"><u>Avís legal</u></a></span>
                <span><a href="/politica-de-privacitat"><u>Política de privacitat</u></a></span>
                <span>© elMercat</span>
            </p>
        </div>
        <p class="small">
            Web creada i dissenyada per <u><a href="https://www.codeccoop.org" target="_blank">Còdec</a></u>
            (programació) i <u><a href="http://mariacollsague.com/projects/" target="_blank">Maria Coll</a></u> (disseny)
        </p>
    </div>
</footer>
</div>

<?php wp_footer(); ?>

</body>

</html>
