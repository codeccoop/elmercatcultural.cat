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
        <form id="newsletter-form" method="post" class="newsletter-form footer__subscription" action="<?= get_bloginfo('url') ?>?action=emc-newsletter-signup">
            <p class="message success-message" style="display:none" arai-hidden="true"><?= __('Gràcies per subscriure\'t al buttletí. Per acabar de confirmar la teva alta, t\'hem enviat un correu de confirmació', 'elmercatcultural.cat') ?></p>
            <p class="message error-message" style="display:none" aria-hidden="true"><?= __('Sembla que hi ha algun problema amb la teva subscripció. Revisa el formulari i torna a intentar-ho', 'elmercatcultural.cat') ?></p>
            <p>Nom i cognoms<input type="text" name="contact_name" required="required"></p>
            <p>Adreça de correu electrònic<input type="email" name="contact_email" required="required"></p>
            <p><input type="submit" value="<?= __('Dona\'m d\'alta', 'elmercatcultural.cat') ?>"></p>
        </form>
        <script>
        const form = document.getElementById("newsletter-form");
        form.addEventListener("submit", (ev) => {
            ev.preventDefault();
            for (let message of form.querySelectorAll(".message")) {
                message.style.display = "none";
                message.setAttribute("aria-hidden", "true");
            }
            fetch(window.location.pathname.replace(/\/+$/, "") + '/?action=emc-newsletter-signup', {
                method: "POST",
                body: new FormData(form)
            })
                .then(res => res.json())
                .then(({ success }) => {
                    if (!success) throw new Error();
                    return form.querySelector(".success-message");
                }).catch((err) => {
                    console.log(err);
                    return form.querySelector(".error-message");
                }).then((message) => {
                    message.style.display = "block";
                    message.removeAttribute("aria-hidden");
                });
        });
        </script>
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
