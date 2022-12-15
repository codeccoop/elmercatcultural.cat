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
                # $coordinates = [41.5028, 1.81346];
                $lat = $coordinates[0];
                $lng = $coordinates[1];
                echo do_shortcode('[embedded_map lng="' . $lng . '" lat="' . $lat . '" class="contact__map"]');
                ?>
            </div>
        </div>
        <div class="footer__column">
            <div class="footer__row">
                <p class="footer__title small">Dona't d'alta al nostre butlletí</p>
                <div class="footer__subscription">
                    <form id="mcSubscriptionForm" action=https://elmercatcultural.us11.list-manage.com/subscribe/post?u=6cddc765d60db6bb166e55534&amp;id=77f622e665&amp;f_id=002990e0f0 method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                        <div class="footer__subscription-field">
                            <input placeholder="elteucorreu@correu.cat"="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" required>
                            <i tabindex="0"="button"></i>
                        </div>
                    </form>
                </div>
                <script type='text/javascript'>
                    document.addEventListener('DOMContentLoaded', function() {
                        const form = document.getElementById('mcSubscriptionForm');
                        const submitBtn = form.querySelector('i');
                        const emailInput = form.querySelector('input');

                        function validateEmail(email) {
                            return email.match(
                                /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/);
                        }

                        emailInput.addEventListener('keydown', (ev) => {
                            if (ev.keyCode !== 13) {
                                emailInput.classList.remove('invalid');
                                return;
                            }
                            ev.preventDefault();
                            ev.stopPropagation()
                            if (validateEmail(emailInput.value)) {
                                form.submit();
                            } else {
                                emailInput.classList.add('invalid');
                            }
                        });

                        submitBtn.addEventListener('click', (ev) => {
                            if (validateEmail(emailInput.value)) {
                                form.submit();
                            } else {
                                emailInput.classList.add('invalid');
                            }
                        });
                    });
                </script>
            </div>
        </div>
        <div class="footer__column">
            <div class="footer__row">
                <p class="footer__title small">Troba-ns a</p>
                <ul class="footer__social">
                    <li><a href="<?=get_theme_mod('instagram');?>" target="_blank"><img src="<?= get_bloginfo('template_url') . '/assets/images/instagram.png'; ?>" /></a></li>
                    <li><a href="<?=get_theme_mod('twitter');?>" target="_blank"><img src="<?= get_bloginfo('template_url') . '/assets/images/twitter.png'; ?>" /></a></li>
                    <li><a href="<?=get_theme_mod('whatsapp');?>" target="_blank"><img src="<?= get_bloginfo('template_url') . '/assets/images/whatsapp.png'; ?>" /></a></li>
                    <li><a href="<?=get_theme_mod('telegram');?>" target="_blank"><img src="<?= get_bloginfo('template_url') . '/assets/images/telegram.png'; ?>" /></a></li>
                </ul>
            </div>
        </div>
        <div class="footer__column">
            <div class="footer__row">
                <p class="footer__text small"><a href="/avis-legal">Avís legal</a></p>
                <p class="footer__text small"><a href="/politica-de-privacitat">Política de privacitat</a></p>
                <p class="footer__text small"><a href="/politica-de-cookies">Política de cookies</a></p>
                <p class="footer__text small">© El Mercat Cultural</a></p>
            </div>
            <div class="footer__row">
                <p class="footer__text small">El mercat forma part de:</p>
                <img src="<?= get_bloginfo('template_url') . '/assets/images/xec.png'; ?>" />
            </div>
        </div>
    </div>
    <div class="site-info">
        <p class="small">
            Web creada i dissenyada per <a class="underline" href="https://www.codeccoop.org" target="_blank">Còdec</a>
            (programació) i <a class="underline" href="http://mariacollsague.com/projects/" target="_blank">Maria Coll</a> (disseny)
        </p>
    </div>
</footer>
</div>

<?php wp_footer(); ?>

</body>

</html>
