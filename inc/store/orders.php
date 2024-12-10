<?php

add_action('woocommerce_order_status_changed', function ($order_id, $old_status, $new_staus) {
    $order = wc_get_order($order_id);
    $payload = [
        'id' => $order_id,
        'createdAt' => (string) $order->get_date_created(),
        'updatedAl' => (string) $order->get_date_modified(),
        'status' => $order->get_status(),
        'amount' => (float) $order->get_total(),
        'identifiers' => [
            'email_id' => $order->get_billing_email(),
        ],
        'products' => array_values(array_map(function ($item) {
            $product = $item->get_product();
            return [
                'productId' => $product->get_id(),
                'quantity' => $item->get_quantity(),
                'price' => (float) $product->get_price(),
            ];
        }, $order->get_items())),
    ];

    wp_remote_request('https://api.brevo.com/v3/orders/status', [
        'method' => 'POST',
        'headers' => [
            'accept' => 'application/json',
            'content-type' => 'application/json',
            'api-key' => BREVO_API_KEY,
        ],
        'body' => json_encode($payload, JSON_UNESCAPED_UNICODE),
    ]);
}, 10, 3);
