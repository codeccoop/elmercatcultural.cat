<?php

add_action(
	'init',
	function () {
		register_post_meta(
			'product',
			'event_id',
			array(
				'type'              => 'integer',
				'label'             => 'Event ID',
				'description'       => 'Relació amb l\'esdeveniment (Programació o Taller)',
				'single'            => true,
				'sanitize_callback' => 'absint',
				'show_in_rest'      => true,
			),
		);
	},
);

add_filter(
	'posts_bridge_remote_data',
	function ( $data, $rcpt ) {
		if ( 'product' !== $rcpt->post_type ) {
			return $data;
		}

		$response = $rcpt->bridge
			->backend
			->get( '/wp-json/wc/v3/products/' . $rcpt->foreign_id );

		if ( is_wp_error( $response ) ) {
			return $data;
		}

		// $data['meta_input']['type']                  = $response['data']['type'];
		// $data['meta_input']['featured']              = $response['data']['featured'];
		// $data['meta_input']['catalog_visibility']    = $response['data']['catalog_visibility'];
		// $data['meta_input']['description']           = $response['data']['description'];
		// $data['meta_input']['short_description']     = $response['data']['short_description'];
		// $data['meta_input']['sku']                   = $response['data']['sku'];
		$data['meta_input']['_price']                 = $response['data']['price'] ?? '';
		$data['meta_input']['_regular_price']         = $response['data']['regular_price'] ?? '';
		$data['meta_input']['_sale_price_dates_from'] = $response['data']['date_on_sale_from'] ?? '';
		$data['meta_input']['_sale_price_dates_to']   = $response['data']['date_on_sale_to'] ?? '';
		$data['meta_input']['total_sales']            = $response['data']['total_sales'] ?? '';
		$data['meta_input']['_virtual']               = $response['data']['virtual'] ?? '';
		$data['meta_input']['_downloadable']          = $response['data']['downloadable'] ?? '';
		$data['meta_input']['_download_limit']        = $response['data']['download_limit'] ?? '';
		$data['meta_input']['_download_expiry']       = $response['data']['download_expiry'] ?? '';
		$data['meta_input']['_tax_status']            = $response['data']['tax_status'] ?? '';
		$data['meta_input']['_tax_class']             = $response['data']['tax_class'] ?? '';
		$data['meta_input']['_manage_stock']          = $response['data']['manage_stock'] ?? '';
		$data['meta_input']['_stock']                 = $response['data']['stock_quantity'] ?? '';
		$data['meta_input']['_stock_status']          = $response['data']['stock_status'] ?? '';
		$data['meta_input']['_backorders']            = $response['data']['backorders'] ?? '';
		$data['meta_input']['_sold_individually']     = $response['data']['sold_individually'] ?? '';
		// $data['meta_input']['sale_price']            = $response['data']['sale_price'];
		// $data['meta_input']['date_on_sale_from_gmt'] = $response['data']['date_on_sale_from_gmt'];
		// $data['meta_input']['date_on_sale_to_gmt']   = $response['data']['date_on_sale_to_gmt'];
		// $data['meta_input']['on_sale']               = $response['data']['on_sale'];
		// $data['meta_input']['purchasable']           = $response['data']['purchasable'];
		// $data['meta_input']['downloads']             = $response['data']['downloads'];
		// $data['meta_input']['external_url']          = $response['data']['external_url'];
		// $data['meta_input']['button_text']           = $response['data']['button_text'];
		// $data['meta_input']['low_stock_amount']      = $response['data']['low_stock_amount'];
		// $data['meta_input']['shipping_required']     = $response['data']['shipping_required'];
		// $data['meta_input']['shipping_taxable']      = $response['data']['shipping_taxable'];
		// $data['meta_input']['shipping_class']        = $response['data']['shipping_class'];
		// $data['meta_input']['shipping_class_id']     = $response['data']['shipping_class_id'];

		return $data;
	},
	10,
	2
);

$EVENT_FIELDS_KEYMAP = array(
	'date'              => 0,
	'date_initial'      => 1,
	'hour'              => 2,
	'artists'           => 3,
	'description_event' => 4,
	'carroussel_event'  => 5,
	'video'             => 6,
	'price'             => 7,
	'checkbox'          => 8,
	'available_stock'   => 9,
	'date_sale_from'    => 10,
	'date_sale_to'      => 11,
	'genere'            => 12,
	'menu'              => 13,
	'has_waiting_list'  => 14,
	'waiting_list_url'  => 15,
);

function emc_get_bound_product( $post_id ) {
	$args = array(
		'posts_per_page' => 1,
		'post_type'      => 'product',
		'meta_key'       => 'event_id',
		'meta_value'     => (string) $post_id,
	);

	$product = null;
	$query   = new WP_Query( $args );
	while ( $query->have_posts() ) {
		$query->the_post();
		global $product;
		break;
	}

	return $product;
}

function emc_create_bound_product( $post_id, $post_title, $post_type ) {
	$product = new WC_Product_Simple();
	$product->set_name( $post_title );
	$product->save();
	update_post_meta( $product->id, 'event_id', (string) $post_id );
	update_post_meta( $product->id, 'event_type', (string) $post_type );
	return $product;
}

function emc_sync_bound_product( $product, $postarr ) {
	$acf_groups = acf_get_field_groups();
	foreach ( $acf_groups as $group ) {
		if ( 'Esdeveniment' === $group['title'] ) {
			$acf_group = $group;
			break;
		}
	}

	if ( ! isset( $acf_group ) ) {
		return;
	}

	$acf_fields = acf_get_fields( $acf_group['key'] );

	$fields_map = array();
	foreach ( $acf_fields as $field ) {
		$fields_map[ $field['name'] ] = $field;
	}

	// global $EVENT_FIELDS_KEYMAP;
	// $acf_keys = array_keys( $postarr['acf'] );

	$product->set_name( $postarr['post_title'] );
	$product->set_image_id( $postarr['_thumbnail_id'] );
	if ( get_post_meta( $product->id, 'event_type', true ) === 'workshop' ) {
		$product->set_sold_individually( true );
	}
	$product->set_manage_stock( true );

	$product_price = $postarr['acf'][ $fields_map['price']['key'] ];
	$product->set_regular_price( $product_price ); // in current shop currency

	$product_desc = $postarr['acf'][ $fields_map['description_event']['key'] ];
	$product->set_description( $product_desc );

	$product_stock = $postarr['acf'][ $fields_map['available_stock']['key'] ];
	$product->set_stock_quantity( $product_stock );

	$product_date_from = $postarr['acf'][ $fields_map['date_sale_from']['key'] ];
	$product_date_from = str_replace( '/', '-', $product_date_from );
	$product_date_from = date( 'c', strtotime( $product_date_from ) );
	$product->set_date_on_sale_from( $product_date_from );

	$product_date_to = $postarr['acf'][ $fields_map['date_sale_to']['key'] ];
	$product_date_to = str_replace( '/', '-', $product_date_to );
	$product_date_to = date( 'c', strtotime( $product_date_to ) );
	$product->set_date_on_sale_to( $product_date_to );

	$product_gender = $postarr['acf'][ $fields_map['genere']['key'] ];
	$product->update_meta_data( 'genere', $product_gender );

	$product_menu = $postarr['acf'][ $fields_map['menu']['key'] ];
	$product->update_meta_data( 'menu', $product_menu );

	$end_date   = $postarr['acf'][ $fields_map['date']['key'] ];
	$start_date = $postarr['acf'][ $fields_map['date_initial']['key'] ] ?? null;
	$product->update_meta_data( 'event_end_date', $end_date );
	if ( ! $start_date ) {
		$product->update_meta_data( 'event_start_date', $end_date );
	} else {
		$product->update_meta_data( 'event_start_date', $start_date );
	}

	$has_waiting_list = (bool) $postarr['acf'][ $fields_map['has_waiting_list']['key'] ] ?? false;
	$product->update_meta_data( 'event_has_waiting_list', $has_waiting_list );

	$product->save();
}

add_filter( 'wp_insert_post_data', 'elmercatcultural_on_event_insert', 99, 2 );
function elmercatcultural_on_event_insert( $data, $postarr ) {
	// , $unsanitized_postarr = null, $update = false)
	$is_cpt        = $postarr['post_type'] === 'event' || $postarr['post_type'] === 'workshop';
	$is_auto_draft = isset( $postarr['auto_draft'] ) && $postarr['auto_draft'] || $postarr['ID'] == 0;
	if ( ! $is_cpt || $is_auto_draft ) {
		return $data;
	}

	$product = emc_get_bound_product( $postarr['ID'] );

	// In case the post is restored from trash
	if ( ! isset( $postarr['acf'] ) ) {
		return $data;
	}

	if ( $postarr['post_status'] !== 'trash' ) {
		global $EVENT_FIELDS_KEYMAP;
		$acf_keys          = array_keys( $postarr['acf'] );
		$has_bound_product = $postarr['acf'][ $acf_keys[ $EVENT_FIELDS_KEYMAP['checkbox'] ] ];

		if ( $product == null && $has_bound_product ) {
			$product = emc_create_bound_product( $postarr['ID'], $postarr['post_title'], $postarr['post_type'] );
		} elseif ( $product && ! $has_bound_product ) {
			$product->delete( true );
		}

		if ( $has_bound_product ) {
			emc_sync_bound_product( $product, $postarr );
		}
	}

	return $data;
}

add_filter( 'acf/load_value/name=price', 'emc_update_price', 10, 3 );
function emc_update_price( $value, $post_id, $field ) {
	$product = emc_get_bound_product( $post_id );
	if ( null === $product ) {
		return $value;
	}
	return $product->get_price();
}

add_filter( 'acf/load_value/name=available_stock', 'emc_update_stock', 10, 3 );
function emc_update_stock( $value, $post_id, $field ) {
	$product = emc_get_bound_product( $post_id );
	if ( null === $product ) {
		return $value;
	}
	return $product->get_stock_quantity();
}

add_action( 'wp_trash_post', 'elmercatcultural_on_delete_event', 10 );
function elmercatcultural_on_delete_event( $ID ) {
	if ( get_post_type( $ID ) === 'event' || get_post_type( $ID ) === 'workshop' ) {
		$product = emc_get_bound_product( $ID );
		if ( $product == null ) {
			return;
		}
		$product->delete( true );
	}
}

add_action( 'mtphr_post_duplicator_created', 'emc_on_post_duplicated', 99, 2 );
function emc_on_post_duplicated( $original_id, $duplicate_id ) {
	$post = get_post( $duplicate_id );

	if ( 'event' !== $post->post_type && 'workshop' !== $post->post_type ) {
		return;
	}

	$post_title               = get_the_title( $duplicate_id );
	$product                  = emc_create_bound_product( $duplicate_id, $post_title, $post->post_type );
	$postarr                  = $post->to_array();
	$postarr['_thumbnail_id'] = get_post_thumbnail_id( $original_id );
	$custom_fields            = get_fields( $original_id, false );

	$acf_array = array();
	global $EVENT_FIELDS_KEYMAP;
	foreach ( $EVENT_FIELDS_KEYMAP as $name => $index ) {
		if ( ! isset( $custom_fields[ $name ] ) ) {
			continue;
		}

		$acf_array[ 'field-' . $index ] = $custom_fields[ $name ];
	}

	$postarr['acf'] = $acf_array;

	emc_sync_bound_product( $product, $postarr );
}
