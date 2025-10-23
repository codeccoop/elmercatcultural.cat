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
 * @version 10.1.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_cart'); ?>

<form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
    <?php do_action('woocommerce_before_cart_table'); ?>

    <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
        <thead>
            <tr>
                <th class="product-cover">
                    <h3 class="sans-serif"><?php esc_html_e('Product', 'woocommerce'); ?></h3>
                </th>
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
                $post_id = get_post_meta($product_id, 'event_id', true);
                $post = get_post($post_id) ?: emc_get_event_by_name($slug) ?? emc_get_workshop_by_name($slug);

                /**
				 * Filter the product name.
				 *
				 * @since 2.1.0
				 * @param string $product_name Name of the product in the cart.
				 * @param array $cart_item The product in the cart.
				 * @param string $cart_item_key Key for the product in the cart.
				 */
				$product_name = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );

                if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                    $post_permalink = get_post_permalink($post);
            ?>
                    <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">

                        <td class="product-cover" data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
                          <div class="product-thumbnail">
                          <?php
                          /**
                          * Filter the product thumbnail displayed in the WooCommerce cart.
                          *
                          * This filter allows developers to customize the HTML output of the product
                          * thumbnail. It passes the product image along with cart item data
                          * for potential modifications before being displayed in the cart.
                          *
                          * @param string $thumbnail     The HTML for the product image.
                          * @param array  $cart_item     The cart item data.
                          * @param string $cart_item_key Unique key for the cart item.
                          *
                          * @since 2.1.0
                          */
                          $thumbnail_url = get_the_post_thumbnail_url($product_id);
                          if ( ! $thumbnail_url ) {
                              $thumbnail_url = get_template_directory_uri() . '/assets/images/event--default.png';
                          }

                          $thumbnail = '<img  height="250" width="250" src="' . $thumbnail_url . '">';
                          $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $thumbnail, $cart_item, $cart_item_key );

                          if ( ! $post || ! $post_permalink ) {
                            echo $thumbnail; // PHPCS: XSS ok.
                          } else {
                            printf( '<a href="%s">%s</a>', esc_url( $post_permalink ), $thumbnail ); // PHPCS: XSS ok.
                          }
                          ?>
                          </div>

                          <div class="product-name title is-3">
                          <?php
                          if ( ! $post || ! $post_permalink ) {
                            echo wp_kses_post( $product_name . '&nbsp;' );
                          } else {
                            /**
                            * This filter is documented above.
                            *
                            * @since 2.1.0
                            */
                            echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $post_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
                          }

                          do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

                          // Meta data.
                          echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

                          // Backorder notification.
                          if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                            echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
                          }
                          ?>
                          </div>
                        </td>

                        <td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
                          <?php
                            echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
                          ?>
                        </td>

                        <td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
                        <?php
                        $min_quantity = 0;
                        $max_quantity = $_product->get_max_purchase_quantity();

                        $product_quantity = woocommerce_quantity_input(
                          array(
                            'input_name'   => "cart[{$cart_item_key}][qty]",
                            'input_value'  => $cart_item['quantity'],
                            'max_value'    => $max_quantity,
                            'min_value'    => $min_quantity,
                            'product_name' => $product_name,
                          ),
                          $_product,
                          false
                        );

                        echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
                        ?>
                        </td>

                        <td class="product-remove">
                          <?php
                            echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                              'woocommerce_cart_item_remove_link',
                              sprintf(
                                '<a role="button" href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                                esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                /* translators: %s is the product name */
                                esc_attr( sprintf( __( 'Remove %s from cart', 'woocommerce' ), wp_strip_all_tags( $product_name ) ) ),
                                esc_attr( $product_id ),
                                esc_attr( $_product->get_sku() )
                              ),
                              $cart_item_key
                            );
                          ?>
                        </td>

                      </tr><?php
                }
            }
            ?>

            <?php do_action('woocommerce_cart_contents'); ?>

            <tr>
                <td colspan="6" class="actions" aria-hidden="true">

                    <?php if (wc_coupons_enabled()) { ?>
                        <div class="coupon">
                            <label for="coupon_code" class="screen-reader-text"><?php esc_html_e('Coupon:', 'woocommerce'); ?></label>
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
    if (wc_coupons_enabled() && emc_cart_has_available_coupons()) : ?>
        <div class="coupon">
            <h3 class="sans-serif">Descomptes</h3>
            <p>Pots beneficiar-te d'algun dels descomptes disponibles?</p>
            <?php $has_coupons = sizeof(WC()->cart->get_coupons()) > 0; ?>
            <ul class="emc-cart-discount-concepts">
            <?= do_action('emc_list_cart_coupons', emc_cart_available_coupons()) ?>
            </ul>
            <div class="checkbox-input-wrapper">
                <input type="checkbox" name="coupon_checkbox" class="input-checkbox bool-selector" id="coupon_checkbox" />
                <div class="checkbox-input__labels">
                    <label class="checkbox-input__label-btn small" data-value="true">Sí</label>
                    <label class="checkbox-input__label-btn small" data-value="false">No</label>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let onLoop = false;

                function applyCoupons() {
                    document.getElementById("coupon_code").value = "master-coupon";
                    document.getElementsByName("apply_coupon")[0].click();
                    onLoop = true;
                }

                function removeCoupons(reload) {
                    fetch('/cistella?remove_coupon=master-coupon')
                        .then(_ => {
                            window.location = window.location;
                        });
                }
                jQuery(document.body).on("wc_cart_emptied", removeCoupons);
                jQuery(document.body).on("updated_cart_totals", () => {
                    radioBtns.forEach(btn => {

                        const value = btn.dataset.value === 'true';
                        btn.classList.remove('clicked');
                        if (checkbox.checked === value) {
                            btn.classList.add('clicked');
                        }
                    });

                    if (checkbox.checked) {
                        if (!onLoop) applyCoupons();
                        else onLoop = false;
                    }
                });
                const checkbox = document.getElementById("coupon_checkbox");
                const radioBtns = document.querySelectorAll(".checkbox-input__label-btn");
                const label = checkbox.nextSibling;
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
                });
                checkbox.addEventListener("change", function() {
                    if (checkbox.checked) applyCoupons();
                    else if (activeCoupons.length) removeCoupons(true);
                });
            });
        </script>
    <?php endif;

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
<?php do_action('emc_cart_script'); ?>
