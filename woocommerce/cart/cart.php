<?php

/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_cart'); ?>

<form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
    <?php do_action('woocommerce_before_cart_table'); ?>

    <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
        <thead>
            <tr>
                <th class="product-cover"<h3 class="sans-serif"><?php esc_html_e('Product', 'woocommerce'); ?></h3></th>
                <th class="product-price"><?php esc_html_e('Price', 'woocommerce'); ?></th>
                <th class="product-quantity"><?php esc_html_e('Quantity', 'woocommerce'); ?></th>
                <th class="product-remove small"><span class="screen-reader-text"></th>
            </tr>
        </thead>
        <tbody>
            <?php do_action('woocommerce_before_cart_contents'); ?>

            <?php
            foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
                $slug = preg_replace('/-product$/', '', $cart_item['data']->get_slug());
                $post_type = 'event';
                $post = get_page_by_path($slug, OBJECT, $post_type);
                if (!$post) {
                    $post_type = 'workshop';
                    $post = get_page_by_path($slug, OBJECT, $post_type);
                }

                if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                    $product_permalink = get_post_permalink($post);
            ?>
                    <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">

                        <td class="product-cover" data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
                            <div class="product-thumbnail">
                                <?php
                                $thumbnail_url = get_the_post_thumbnail_url($post);
                                if (!$thumbnail_url) {
                                    $thumbnail_url = get_template_directory_uri() . '/assets/images/event--default.png';
                                }

                                $thumbnail = '<img  height="250" width="250" src="' . $thumbnail_url . '">';
                                if (!$product_permalink) {
                                    echo $thumbnail; // PHPCS: XSS ok.
                                } else {
                                    printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail); // PHPCS: XSS ok.
                                }
                                ?>
                            </div>
                            <div class="product-name title is-3">
                                <?php
                                if (!$product_permalink) {
                                    echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;');
                                } else {
                                    echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
                                }

                                do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);

                                // Meta data.
                                echo wc_get_formatted_cart_item_data($cart_item); // PHPCS: XSS ok.

                                // Backorder notification.
                                if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                                    echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
                                }
                                ?>
                            </div>
                        </td>

                        <td class="product-price" data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
                            <?php
                            echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                            ?>
                        </td>

                        <td class="product-quantity" data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
                            <?php
                            if ($_product->is_sold_individually()) {
                                $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
                            } else {
                                $product_quantity = woocommerce_quantity_input(
                                    array(
                                        'input_name'   => "cart[{$cart_item_key}][qty]",
                                        'input_value'  => $cart_item['quantity'],
                                        'max_value'    => $_product->get_max_purchase_quantity(),
                                        'min_value'    => '0',
                                        'product_name' => $_product->get_name(),
                                    ),
                                    $_product,
                                    false
                                );
                            }

                            echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // PHPCS: XSS ok.
                            ?>
                        </td>
                        <td class="product-remove">
                            <?php
                            echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                'woocommerce_cart_item_remove_link',
                                sprintf(
                                    '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                                    esc_url(wc_get_cart_remove_url($cart_item_key)),
                                    esc_html__('Remove this item', 'woocommerce'),
                                    esc_attr($product_id),
                                    esc_attr($_product->get_sku())
                                ),
                                $cart_item_key
                            );
                            ?>
                        </td>

                    </tr>
            <?php
                }
            }
            ?>

            <?php do_action('woocommerce_cart_contents'); ?>

            <tr>
                <td colspan="6" class="actions" aria-hidden="true">

                    <?php if (wc_coupons_enabled()) { ?>
                        <div class="coupon">
                            <label for="coupon_code"><?php esc_html_e('Coupon:', 'woocommerce'); ?></label>
                            <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" />
                            <button type="submit" class="button<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>"><?php esc_attr_e('Apply coupon', 'woocommerce'); ?></button>
                            <?php do_action('woocommerce_cart_coupon'); ?>
                        </div>
                    <?php } ?>

                    <button type="submit" class="button<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>" name="update_cart" value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>"><?php esc_html_e('Update cart', 'woocommerce'); ?></button>

                    <?php do_action('woocommerce_cart_actions'); ?>

                    <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
                </td>
            </tr>

            <?php do_action('woocommerce_after_cart_contents'); ?>
        </tbody>
    </table>
    <?php do_action('woocommerce_after_cart_table'); ?>
</form>

<?php do_action('woocommerce_before_cart_collaterals'); ?>

<div class="cart-collaterals">
    <?php
    if (wc_coupons_enabled()) : ?>
        <div class="coupon">
            <h3 class="sans-serif">Descomptes</h3>
                <?php $has_coupons = sizeof(WC()->cart->get_coupons()) > 0; ?>
            <p class="small">ETS MENOR DE 35 ANYS, JUBILAT O ESTÂS A L'ATUR?</p>
            <div class="checkbox-input-wrapper">
                <input <?= $has_coupons ? 'checked="true"' : '' ?> type="checkbox" name="coupon_checkbox" class="input-checkbox bool-selector" id="coupon_checkbox" />
                <div class="checkbox-input__labels">
                    <label class="checkbox-input__label-btn small" data-value="true">Sí</label>
                    <label class="checkbox-input__label-btn small" data-value="false">No</label>
                </div>
            </div>
        </div>
        <script>
        document.addEventListener("DOMContentLoaded", function () {
            const checkbox = document.getElementById("coupon_checkbox");
            const radioBtns = document.querySelectorAll(".checkbox-input__label-btn");
            const label = checkbox.nextSibling;
            const couponCode = document.getElementById("coupon_code");
            const submitBtn = document.getElementsByName("apply_coupon")[0];
            const activeCoupons = document.getElementsByClassName("woocommerce-remove-coupon");
            radioBtns.forEach(btn => {
                const value = btn.dataset.value === 'true';
                btn.addEventListener('click', () => {
                    if (value !== checkbox.checked) {
                        checkbox.checked = !checkbox.checked;
                        checkbox.dispatchEvent(new Event('change'));
                    }
                    radioBtns.forEach(btn => btn.classList.remove('clicked'));
                    btn.classList.add('clicked');
                });

                if (checkbox.checked === value) btn.classList.add('clicked');
            });
            checkbox.addEventListener("change", function () {
                if (checkbox.checked) {
                    couponCode.value = "master-coupon";
                    submitBtn.click();
                } else if (activeCoupons.length) {
                    Promise.all(Array.from(activeCoupons).map(link => {
                        const href = link.href;
                        return fetch(href);
                    })).then(_ => window.location.reload());
                }
            });
        });
        </script>
    <? endif;

    /**
     * Cart collaterals hook.
     *
     * @hooked woocommerce_cross_sell_display
     * @hooked woocommerce_cart_totals - 10
     */
    do_action('woocommerce_cart_collaterals');
    ?>
</div>

<?php do_action('woocommerce_after_cart'); ?>
