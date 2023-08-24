<?php
add_filter('woocommerce_thankyou_order_received_text', 'elmercatcultural_thankyou_text');
function elmercatcultural_thankyou_text($text, $order = null)
{
	return 'Benvolgudes, gràcies per realitzar la inscripció a elMercat';
}

/* add_filter('woocommerce_order_button_text', 'elmercatcultural_order_button_text'); */
/* function elmercatcultural_order_button_text($text) */
/* { */
/* 	return $text; */
/* } */
