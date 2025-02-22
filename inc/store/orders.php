<?php

add_action('woocommerce_order_status_changed', function ($order_id, $old_status, $new_staus) {
    $order = wc_get_order($order_id);
    $payload = [
        'id' => (string) $order_id,
        'createdAt' => (string) $order->get_date_created()->date('Y-m-d\Th:i:s.u\Z'),
        'updatedAt' => (string) $order->get_date_modified()->date('Y-m-d\Th:i:s.u\Z'),
        'status' => $order->get_status(),
        'amount' => (float) $order->get_total(),
        'identifiers' => [
            'email_id' => $order->get_billing_email(),
        ],
        'products' => array_values(array_map(function ($item) {
            $product = $item->get_product();
            return [
                'productId' => (string) $product->get_id(),
                'quantity' => (int) $item->get_quantity(),
                'price' => (float) $product->get_price(),
            ];
        }, $order->get_items())),
    ];

    $brevo_api = apply_filters('forms_bridge_backend', null, 'Brevo API');
    if (!$brevo_api) {
        return;
    }

    $api_key = $brevo_api->headers['api-key'] ?? null;
    if (!$api_key) {
        return;
    }

    $res = wp_remote_request('https://api.brevo.com/v3/orders/status', [
        'method' => 'POST',
        'headers' => [
            'accept' => 'application/json',
            'content-type' => 'application/json',
            'api-key' => $api_key,
        ],
        'body' => json_encode($payload, JSON_UNESCAPED_UNICODE),
    ]);
}, 10, 3);
