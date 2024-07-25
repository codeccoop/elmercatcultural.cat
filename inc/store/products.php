<?php

$EVENT_FIELDS_KEYMAP = [
    'date' => 0,
    'date_initial' => 1,
    'hour' => 2,
    'artists' => 3,
    'description_event' => 4,
    'carroussel_event' => 5,
    'video' => 6,
    'price' => 7,
    'checkbox' => 8,
    'available_stock' => 9,
    'date_sale_from' => 10,
    'date_sale_to' => 11,
    // 'external_inscription' => 11,
    'genere' => 12
];

function emc_get_bound_product($post_id)
{
    $args = [
        'posts_per_page' => 1,
        'post_type' => 'product',
        'meta_key' => 'event_id',
        'meta_value' => (string) $post_id,
    ];

    $product = null;
    $query = new WP_Query($args);
    while ($query->have_posts()) {
        $query->the_post();
        global $product;
        break;
    }

    return $product;
}

function emc_create_bound_product($post_id, $post_title, $post_type)
{
    $product = new WC_Product_Simple();
    $product->set_name($post_title);
    $product->save();
    update_post_meta($product->id, 'event_id', (string) $post_id);
    update_post_meta($product->id, 'event_type', (string) $post_type);
    return $product;
}

function emc_sync_bound_product($product, $postarr)
{
    global $EVENT_FIELDS_KEYMAP;
    $acf_keys = array_keys($postarr['acf']);

    $product->set_name($postarr['post_title']);
    $product->set_image_id($postarr['_thumbnail_id']);
    if (get_post_meta($product->id, 'event_type', true) === 'workshop') {
        $product->set_sold_individually(true);
    }
    $product->set_manage_stock(true);

    $product_price = $postarr['acf'][$acf_keys[$EVENT_FIELDS_KEYMAP['price']]];
    $product->set_regular_price($product_price); // in current shop currency

    $product_desc = $postarr['acf'][$acf_keys[$EVENT_FIELDS_KEYMAP['description_event']]];
    $product->set_description($product_desc);

    $product_stock = $postarr['acf'][$acf_keys[$EVENT_FIELDS_KEYMAP['available_stock']]];
    $product->set_stock_quantity($product_stock);

    $product_date_from = $postarr['acf'][$acf_keys[$EVENT_FIELDS_KEYMAP['date_sale_from']]];
    $product_date_from = str_replace('/', '-', $product_date_from);
    $product_date_from = date("c", strtotime($product_date_from));
    $product->set_date_on_sale_from($product_date_from);

    $product_date_to = $postarr['acf'][$acf_keys[$EVENT_FIELDS_KEYMAP['date_sale_to']]];
    $product_date_to = str_replace('/', '-', $product_date_to);
    $product_date_to = date("c", strtotime($product_date_to));
    $product->set_date_on_sale_to($product_date_to);

    $product_gender = $postarr['acf'][$acf_keys[$EVENT_FIELDS_KEYMAP['genere']]];
    $product->update_meta_data('genere', $product_gender);

    $product->save();
}

add_filter('wp_insert_post_data', 'elmercatcultural_on_event_insert', 99, 2);
function elmercatcultural_on_event_insert($data, $postarr)  // , $unsanitized_postarr = null, $update = false)
{
    $is_cpt = $postarr['post_type'] === 'event' || $postarr['post_type'] === 'workshop';
    $is_auto_draft = isset($postarr['auto_draft']) && $postarr['auto_draft'] || $postarr['ID'] == 0;
    if (!$is_cpt || $is_auto_draft) {
        return $data;
    }

    $product = emc_get_bound_product($postarr['ID']);

    // In case the post is restored from trash
    if (!isset($postarr['acf'])) {
        return $data;
    }

    if ($postarr['post_status'] !== 'trash') {
        global $EVENT_FIELDS_KEYMAP;
        $acf_keys = array_keys($postarr['acf']);
        $has_bound_product = $postarr['acf'][$acf_keys[$EVENT_FIELDS_KEYMAP['checkbox']]];

        if ($product == null && $has_bound_product) {
            $product = emc_create_bound_product($postarr['ID'], $postarr['post_title'], $postarr['post_type']);
        } elseif ($product && !$has_bound_product) {
            $product->delete(true);
        };

        if ($has_bound_product) {
            emc_sync_bound_product($product, $postarr);
        }
    }

    return $data;
}

add_filter('acf/load_value/name=price', 'emc_update_price', 10, 3);
function emc_update_price($value, $post_id, $field)
{
    $product = emc_get_bound_product($post_id);
    if ($product === null) {
        return $value;
    }
    return $product->get_price();
}

add_filter('acf/load_value/name=available_stock', 'emc_update_stock', 10, 3);
function emc_update_stock($value, $post_id, $field)
{
    $product = emc_get_bound_product($post_id);
    if ($product === null) {
        return $value;
    }
    return $product->get_stock_quantity();
}

add_action('wp_trash_post', 'elmercatcultural_on_delete_event', 10);
function elmercatcultural_on_delete_event($ID)
{
    if (get_post_type($ID) === 'event' || get_post_type($ID) === 'workshop') {
        $product = emc_get_bound_product($ID);
        if ($product == null) {
            return;
        }
        $product->delete(true);
    }
}

add_action('mtphr_post_duplicator_created', 'emc_on_post_duplicated', 99, 2);
function emc_on_post_duplicated($original_id, $duplicate_id)
{
    $post = get_post($duplicate_id);
    $post_title = get_the_title($duplicate_id);
    $product = emc_create_bound_product($duplicate_id, $post_title, $post->post_type);
    $postarr = $post->to_array();
    $postarr['_thumbnail_id'] = get_post_thumbnail_id($original_id);
    $custom_fields = get_fields($original_id, false);

    $acf_array = [];
    global $EVENT_FIELDS_KEYMAP;
    foreach ($EVENT_FIELDS_KEYMAP as $name => $index) {
        if (!isset($custom_fields[$name])) {
            continue;
        }
        $value = $custom_fields[$name];
        $acf_array['field-' . $index] = $value;
    }
    $postarr['acf'] = $acf_array;

    emc_sync_bound_product($product, $postarr);
}
