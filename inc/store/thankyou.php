<?php
add_filter('woocommerce_thankyou_order_received_text', 'elmercatcultural_thankyou_text');
function elmercatcultural_thankyou_text()
{

	return 'Benvolgudes, gràcies per realitzar la inscripció a elMercat';
}

/* add_filter('woocommerce_order_button_text', 'elmercatcultural_order_button_text'); */
/* function elmercatcultural_order_button_text($text) */
/* { */
/* 	return $text; */
/* } */

/**
 * Auto Complete Pagament en Efectiu WooCommerce orders.
 */
// add_action('woocommerce_thankyou', 'custom_woocommerce_auto_complete_order');
// function custom_woocommerce_auto_complete_order($order_id)
// {
// 	if (!$order_id) {
// 		return;
// 	}

// 	$order = wc_get_order($order_id);
// 	$order->update_status('completed');
// }


add_action('woocommerce_before_thankyou', 'cod_order_payment_processing_order_status');

function cod_order_payment_processing_order_status($order_id)
{
	if (!$order_id) return;

	$order = new WC_Order($order_id);

	if ($order->get_payment_method() == 'cod' || empty($order->get_payment_method()) && $order->get_total() === '0.00') {
		$order->update_status('completed');
	}
}
