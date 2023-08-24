<?php
add_filter('wp_insert_post_data', 'elmercatcultural_on_event_insert', 99, 2);
function elmercatcultural_on_event_insert($data, $postarr)  // , $unsanitized_postarr = null, $update = false)
{
	if (($postarr['post_type'] === 'event' || $postarr['post_type'] === 'workshop') && $postarr['ID'] != 0 && $data['post_status'] != 'trash') {
		$slug = sanitize_title(wp_unique_post_slug($postarr['post_title'], $postarr['ID'], $postarr['post_status'], $postarr['post_type'], null));
		$product = elmercatcultural_find_product_by_slug($slug);

		$custom_keys = array(
			'data_esdeveniment' => 0,
			'hora_esdeveniment' => 1,
			'fitxa_artistica' => 2,
			'descipcio_esdeveniment' => 3,
			'carroussel' => 4,
			'video' => 5,
			'preu_esdeveniment' => 6,
			'checkbox' => 7,
			'available_stock' => 8,
			'data_inici' => 9,
			'data_fi' => 10,
			'genere' => 11
			// 'checkbox_discount' => 11
		);

		$post_thumbnail_id = get_post_thumbnail_id($postarr['ID']);

		$ACF_keys = array_keys($postarr['acf']);
		$has_bound_product = $postarr['acf'][$ACF_keys[$custom_keys['checkbox']]];
		if ($product == null && $has_bound_product == true) {
			$product = new WC_Product_Simple();
			$product->set_slug($slug . '-product');
			$product->set_name($postarr['post_title']);
			$product->save();
		};
		if ($has_bound_product == true) {
			$product_price = $postarr['acf'][$ACF_keys[$custom_keys['preu_esdeveniment']]];
			$product->set_regular_price($product_price); // in current shop currency
			$product_desc = $postarr['acf'][$ACF_keys[$custom_keys['descipcio_esdeveniment']]];
			$product->set_description($product_desc);
			$product->set_manage_stock(true);
			$product_stock = $postarr['acf'][$ACF_keys[$custom_keys['available_stock']]];
			$product->set_stock_quantity($product_stock);
			$product->set_sold_individually(true);
			$product->set_image_id($post_thumbnail_id);
			$product_date_from = $postarr['acf'][$ACF_keys[$custom_keys['data_inici']]];
			$product_date_from = str_replace('/', '-', $product_date_from);
			$product_date_from = date("c", strtotime($product_date_from));
			$product->set_date_on_sale_from($product_date_from);
			$product_date_to = $postarr['acf'][$ACF_keys[$custom_keys['data_fi']]];
			$product_date_to = str_replace('/', '-', $product_date_to);
			$product_date_to = date("c", strtotime($product_date_to));
			$product->set_date_on_sale_to($product_date_to);
			$product_gender = $postarr['acf'][$ACF_keys[$custom_keys['genere']]];
			$product->update_meta_data('genere', $product_gender);
			$product->save();
		}
	}

	return $data;
}

add_filter('acf/load_value/name=available_stock', 'elmercatcultural_update_stock', 10, 3);
function elmercatcultural_update_stock($value, $post_id, $field)
{
	$post = get_post($post_id);
	$slug = $post->post_name;
	$product = elmercatcultural_find_product_by_slug($slug);
	if ($product === null) {
		return;
	}
	$stock_quantity = $product->get_stock_quantity();
	if ($stock_quantity === null) {
		return;
	} else {
		$value = $stock_quantity;
	}
	return $value;
}

function elmercatcultural_find_product_by_slug($slug)
{
	$posts = get_posts(array(
		'name' => $slug . '-product',
		'post_type' => 'product'
	));
	if (count($posts) == 0) {
		return null;
	}
	$post = $posts[0];
	return wc_get_product($post);
}

add_action('acf/save_post', 'elmercatcultural_slug_sync');
function elmercatcultural_slug_sync($post_id)
{
	$post_type = get_post_type($post_id);
	if ($post_type == 'workshop' || $post_type == 'event') {
		$post = get_post($post_id);
		$title = $post->post_title;
		$clean_title = sanitize_title($title);
		$slug = $post->post_name;
		if ($slug != $clean_title) {
			$clean_post = array('ID' => $post_id, 'post_name' => $clean_title);
			wp_update_post($clean_post);
		}
	}
}

add_action('wp_trash_post', 'elmercatcultural_on_delete_event', 10);
function elmercatcultural_on_delete_event($ID)
{
	if (get_post_type($ID) === 'event' || get_post_type($ID) === 'workshop') {
		$slug = get_post_field('post_name', $ID);
		$product = elmercatcultural_find_product_by_slug($slug);
		if ($product == null) return;
		$product->delete();
	}
}
