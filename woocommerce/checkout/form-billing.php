<?php

/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined('ABSPATH') || exit;
?>
<div class="woocommerce-billing-fields">

    <?php do_action('woocommerce_before_checkout_billing_form', $checkout); ?>

    <div class="woocommerce-billing-fields__field-wrapper">
        <?php $fields = $checkout->get_checkout_fields('billing'); ?>
        <div class="required-fields__message">
            <p> <?= __('Els camps marcats amb un <span class="required-simbol">*</span> són obligatoris', 'elmercatcultural.cat') ?></p>
        </div>
        
        <div class="elmercat-form-field-customer-details">
            <?php woocommerce_form_field('billing_first_name', $fields['billing_first_name'], $checkout->get_value('billing_first_name')); ?>
            <?php woocommerce_form_field('billing_last_name', $fields['billing_last_name'], $checkout->get_value('billing_last_name')); ?>
            <?php woocommerce_form_field('billing_DNI', $fields['billing_DNI'], $checkout->get_value('billing_DNI')); ?>
        </div>
        <div class="elmercat-form-field-contact-details">
            <?php woocommerce_form_field('billing_email', $fields['billing_email'], $checkout->get_value('billing_email')); ?>
            <div class="phone-input-wrapper">
                <?php woocommerce_form_field('billing_phone', $fields['billing_phone'], $checkout->get_value('billing_phone')); ?>
                <div class="more-info">
                    <div class="popup-wrapper">
                        <p>Des d'elMercat Cultural, no es venen les vostres dades privades en cap format. Les dades que us demanem són per a poder-nos posar en contacte, per valorar les activitats i informar de canvis en cas de ser necessari. Et demanem confiança, nosaltres treballem en la responsabilitat.</p>
                    </div>
                </div>
            </div>
            <?php woocommerce_form_field('billing_birthday', $fields['billing_birthday'], $checkout->get_value('billing_company')); ?>
        </div>
        <div class="elmercat-form-field-adress-details">
            <?php woocommerce_form_field('billing_postcode', $fields['billing_postcode'], $checkout->get_value('billing_postcode')); ?>
        </div>
        <div class="elmercat-form-field-is-neighbour">
            <?php do_action("radio_input_veina", $checkout); ?>
            <p class="form-row-placeholder" aria-hidden="true" style="visibility: hidden;"></p>
            <script>
                const buttonSi = document.getElementById('billing_neighbour_1');
                const buttonNo = document.getElementById('billing_neighbour_2');

                buttonSi.addEventListener('click', function() {
                    buttonSi.labels[1].classList.add('clicked');
                    buttonNo.labels[0].classList.remove('clicked');
                });
                buttonNo.addEventListener('click', function() {
                    buttonNo.labels[0].classList.add('clicked');
                    buttonSi.labels[1].classList.remove('clicked');
                });
            </script>
        </div>
        <div class="elmercat-form-field-newsletter-opt-in">
            <?php if (isset($fields['ws_opt_in'])) {
                $fields['ws_opt_in']['label'] = __('Vols subscriure\'t al nostre butlletí?', 'elmercatcultural.cat');
                woocommerce_form_field('ws_opt_in', $fields['ws_opt_in'], $checkout->get_value('ws_opt_in'));
            } ?>
        </div>
        <div class="elmercat-form-field-adress-details">
            <?php woocommerce_form_field('billing_address_1', $fields['billing_address_1'], $checkout->get_value('billing_address_1'));
woocommerce_form_field('billing_address_2', $fields['billing_address_2'], $checkout->get_value('billing_address_2'));
woocommerce_form_field('billing_city', $fields['billing_city'], $checkout->get_value('billing_city'));
woocommerce_form_field('billing_state', $fields['billing_state'], $checkout->get_value('billing_state'));
woocommerce_form_field('billing_country', $fields['billing_country'], $checkout->get_value('billing_country'));
?></div>

        <!-- <form id="mcSubscriptionForm" action="https://elmercatcultural.us11.list-manage.com/subscribe/post?u=6cddc765d60db6bb166e55534&id=77f622e665&f_id=002990e0f0" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate> -->
        <!-- <div class="footer__subscription-field">
            <input placeholder="elteucorreu@correu.cat" type="email" value="" name="EMAIL" class="email" id="mce-EMAIL">
            <i tabindex="0" role="button"></i>
        </div> -->
        <!-- </form> -->

        <script type='text/javascript'>
            // document.addEventListener('DOMContentLoaded', function() {
            //     const emailInput = document.getElementById('mce-EMAIL');
            //     const checkoutEmail = document.getElementById("billing_email");
            //     const newsletterCheckbox = document.getElementById("newsletter_checkbox");
            //     //const formCheckout = document.getElementsByName("checkout")[0];

            //     function syncEmailValues() {
            //         console.log("fired");
            //         if (newsletterCheckbox.checked) {
            //             emailInput.value = checkoutEmail.value;
            //         } else {
            //             emailInput.value = "";
            //         }
            //     }
            //     syncEmailValues();
            //     newsletterCheckbox.addEventListener("change", syncEmailValues);
            //     checkoutEmail.addEventListener("input", syncEmailValues);


            // formCheckout.addEventListener("submit", (ev) => {
            //     ev.stopPropagation();
            //     debugger;
            //     const data = Array.from(formCheckout.querySelectorAll('input')).reduce((data, input) => {
            //         return data + '&' + input.name + '=' + encodeURIComponent(input.value)
            //     }, '').slice(1);
            //     jQuery.ajax({
            //         url: 'https://elmercatcultural.cat/?wc-ajax=checkout',
            //         method: 'POST',
            //         data: data,
            //         success: function(response) {
            //             debugger;
            //             if (response.result === "success") {
            //                 if (newsletterCheckbox.checked) {
            //                     jQuery.ajax({
            //                         url: 'https://elmercatcultural.us11.list-manage.com/subscribe/post?u=6cddc765d60db6bb166e55534&amp;id=77f622e665&amp;f_id=002990e0f0',
            //                         method: 'POST',
            //                         data: 'EMAIL=' + checkoutEmail.value,
            //                         complete: function() {
            //                             window.location = response.redirect;
            //                         }
            //                     });
            //                 } else {
            //                     window.location = response.redirect;
            //                 }
            //             } else {
            //                 // gestio d'errors
            //             }

            //         },
            //         error: function(jqXHR, textStatus, errorThrown) {
            //             console.error(arguments);
            //         }
            //     })


            // });
            //});
        </script>

    </div>

    <?php do_action('woocommerce_after_checkout_billing_form', $checkout); ?>
</div>

<?php if (!is_user_logged_in() && $checkout->is_registration_enabled()) : ?>
    <div class="woocommerce-account-fields">
        <?php if (!$checkout->is_registration_required()) : ?>

            <p class="form-row form-row-wide create-account">
                <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                    <input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="createaccount" <?php checked((true === $checkout->get_value('createaccount') || (true === apply_filters('woocommerce_create_account_default_checked', false))), true); ?> type="checkbox" name="createaccount" value="1" /> <span><?php esc_html_e('Create an account?', 'woocommerce'); ?></span>
                </label>
            </p>

        <?php endif; ?>

        <?php do_action('woocommerce_before_checkout_registration_form', $checkout); ?>

        <?php if ($checkout->get_checkout_fields('account')) : ?>

            <div class="create-account">
                <?php foreach ($checkout->get_checkout_fields('account') as $key => $field) : ?>
                    <?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
                <?php endforeach; ?>
                <div class="clear"></div>
            </div>

        <?php endif; ?>

        <?php do_action('woocommerce_after_checkout_registration_form', $checkout); ?>
    </div>
<?php endif; ?>
