<?php

/* Change woocommerce product literals for Activitat*/

add_filter('gettext', 'change_some_woocommerce_strings', 10, 3);
add_filter('ngettext', 'change_some_woocommerce_strings', 10, 3);
function change_some_woocommerce_strings($translate_text, $original_text, $domain)
{
    if ($domain != "woocommerce") {
        return $translate_text;
    } elseif (stripos($original_text, 'Product') !== false || stripos($original_text, 'Categories') !== false) {
        $translate_text = str_ireplace(
            array('Product categories', 'Products', 'Product'),
            array('Activitats', 'Activitats', 'Activitat'),
            $original_text
        );
    }

    return $translate_text;
}

/* EXCLUDE PRODUCTS FROM COUPON DISCOUNT*/
add_filter('woocommerce_coupon_is_valid_for_product', 'emc_exclude_product_coupons', 9999, 4);
function emc_exclude_product_coupons($valid, $product, $coupon, $values)
{
    return $product->get_meta('checkbox_discount') !== '0';
}

/* FORCE TO APPLY ALL COUPONS*/
function available_coupon_codes()
{
    global $wpdb;

    // Get an array of all existing coupon codes
    $coupon_codes = $wpdb->get_col("SELECT post_title FROM $wpdb->posts WHERE post_type = 'shop_coupon' AND post_status = 'publish' ORDER BY post_name ASC");

    // Display available coupon codes
    return $coupon_codes; // always use return in a shortcode
}

/** COUPONS LOGIC */
function emc_cart_has_available_coupons()
{
    $coupon_codes = available_coupon_codes();
    foreach ($coupon_codes as $code) {
        $coupon = get_page_by_title($code, OBJECT, 'shop_coupon');
        if (emc_cart_can_use_coupon($coupon->ID)) {
            return true;
        }
    }

    return false;
}

function emc_cart_available_coupons()
{
    $coupon_codes = available_coupon_codes();
    return array_filter(array_map(function ($code) {
        return get_page_by_title($code, OBJECT, 'shop_coupon');
    }, $coupon_codes), function ($coupon) {
        return emc_cart_can_use_coupon($coupon->ID);
    });
}

function emc_cart_can_use_coupon($coupon_id)
{
    $cart_ids = array_map(function ($cart_product) {
        return (int) $cart_product['product_id'];
    }, array_values(WC()->cart->get_cart()));

    $coupon_ids = emc_coupon_product_ids($coupon_id);
    $intersection = array_intersect($cart_ids, $coupon_ids);
    return count($intersection) > 0;
}

function emc_coupon_product_ids($coupon_id)
{
    return array_map(function ($product_id) {
        return (int) $product_id;
    }, explode(',', get_post_meta($coupon_id, 'product_ids', true)));
}

add_action('woocommerce_applied_coupon', 'auto_apply_coupon_for_regular_customers', 10, 1);
function auto_apply_coupon_for_regular_customers($coupon_code)
{
    if ($coupon_code != 'master-coupon') {
        return;
    }
    $coupon_codes = available_coupon_codes();
    foreach ($coupon_codes as $code) {
        $coupon = get_page_by_title($code, OBJECT, 'shop_coupon');

        if (!WC()->cart->has_discount($code) && emc_cart_can_use_coupon($coupon->ID)) {
            WC()->cart->apply_coupon($code);
        }
    }
}

add_action('woocommerce_removed_coupon', 'emc_auto_remove_coupon_for_regular_customers', 10, 1);
function emc_auto_remove_coupon_for_regular_customers($coupon_code)
{
    WC()->cart->remove_coupons();
}

add_action('emc_list_cart_coupons', function ($coupons) {
    $concepts = array_filter(array_unique(array_map(function ($coupon) {
        return esc_html($coupon->post_excerpt);
    }, $coupons)));
    foreach ($concepts as $concept) {
        ?>
        <li><p class="small"><?= $concept ?></p></li>
        <?php
    }
}, 10, 1);

// REMOVE COUPON CART MESSAGE WHEN APPLIED
add_filter('woocommerce_coupon_message', 'emc_hide_coupon_messages', 10, 2);
function emc_hide_coupon_messages($msg, $msg_code)
{
    if ($msg_code === WC_Coupon::WC_COUPON_SUCCESS) {
        return null;
    } else {
        return $msg;
    }
}

//CHANGE PROCEED TO CHECKOUT BUTTON TEXT
add_action('woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20);
function woocommerce_button_proceed_to_checkout()
{

    ?>
	<a href="/finalitza-la-inscripcio" class="checkout-button button alt wc-forward"> Finalitza la inscripció </a>
<?php
}

// REMOVE CART MESSAGE WHEN PRODUCT REMOVED
add_filter('woocommerce_cart_item_removed_notice_type', '__return_null');

add_filter('woocommerce_cart_totals_coupon_html', 'emc_remove_coupon_html');
function emc_remove_coupon_html($html, $coupon = null, $discount = null)
{
    return preg_replace('/\<a href/', '<a aria-hidden="true" href', $html);
}

add_action('woocommerce_review_order_after_cart_contents', 'emc_cart_content_summary');
function emc_cart_content_summary()
{
    $title = WC()->cart->get_coupons() ? 'Total Cistella amb descompte' : 'Total Cistella';

    echo '<tr class="cart-item"><td class="product-name">' . esc_html($title, 'woocommerce') . '</td>';
    echo '<td class="product-name">' . apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_cart_total()) . '</td></tr>';
}

// SHOW CASH ON DELIVERY PAYMENT METHOD WHEN ADMIN ONLY
add_filter('woocommerce_available_payment_gateways', 'filter_woocommerce_available_payment_gateways', 10, 1);
function filter_woocommerce_available_payment_gateways($available_gateways)
{
    foreach ($available_gateways as $key => $gateway) {
        if ($gateway->title === "Pagament en efectiu i presencial" && !current_user_can('manage_options')) {
            unset($available_gateways[$key]);
            break;
        }
    }

    return $available_gateways;
};

add_action('emc_cart_script', function () {
    ?>
        <script>
        document.addEventListener("DOMContentLoaded", function () {
            function debounce(fn, ms) {
                let timeout;
                return function (...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(fn.apply(this, args), ms);
                }
            }

            function listenInputs() {
                const form = document.querySelector(".woocommerce-cart-form");
                if (!form) return;

                for (let input of form.querySelectorAll("input[type=number]")) {
                    input.addEventListener("input", debounce(function (e) {
                        if (!e.target.value) return;
                        const ev = jQuery.Event("keypress");
                        ev.keyCode = 13;
                        ev.key = "Enter";
                        jQuery(input).trigger(ev);
                    }, 300));
                }
            }

            jQuery(document.body).on("updated_wc_div", listenInputs);
            listenInputs();
        });
        </script>
    <?php
});
