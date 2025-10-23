<?php

add_action( 'wp_ajax_get_grid_items', 'emc_get_grid_items' );
add_action( 'wp_ajax_nopriv_get_grid_items', 'emc_get_grid_items' );

if ( ! function_exists( 'emc_get_grid_items' ) ) {
	function emc_get_grid_items() {
		check_ajax_referer( 'async_grid' );
		$term     = sanitize_text_field( wp_unslash( $_POST['term'] ?? 'all' ) );
		$page     = intval( wp_unslash( $_POST['page'] ?? '1' ) );
		$type     = sanitize_text_field( wp_unslash( $_POST['type'] ?? '' ) );
		$order    = 'historic' === $term ? 'DESC' : 'ASC';
		$time_dir = 'historic' === $term ? '<=' : '>=';

		$args = array(
			'post_type'      => $type,
			'post_status'    => 'publish',
			'posts_per_page' => 9,
			'offset'         => ( $page - 1 ) * 9,
			'meta_key'       => 'date',
			'orderby'        => 'meta_value',
			'order'          => $order,
			'meta_query'     => array(
				array(
					'key'     => 'date',
					'compare' => $time_dir,
					'value'   => date( 'Y-m-d' ),
					'type'    => 'DATE',
				),
			),
		);

		if ( 'all' !== $term && 'historic' !== $term ) {
			$args['category_name'] = $term;
		}

		$query = new WP_Query( $args );

		$data = array(
			'posts' => array(),
			'pages' => 0,
		);

		while ( $query->have_posts() ) {
			$query->the_post();
			$post_id   = get_the_ID();
			$thumbnail = get_the_post_thumbnail_url( $post_id, 'full' );
			if ( ! $thumbnail ) {
				$thumbnail = get_template_directory_uri() . '/assets/images/event--default.png';
			}

			$now = current_time( 'U', false );
			try {
				$event_date      = emc_get_date_field( 'date', $post_id )->getTimestamp();
				$has_inscription = get_field( 'checkbox', $post_id );
				$date_sale_from  = $has_inscription
					? emc_get_date_field( 'date_sale_from', $post_id )->getTimestamp()
					: null;
				$date_sale_to    = $has_inscription
					? emc_get_date_field( 'date_sale_to', $post_id )->getTimestamp()
					: null;
			} catch ( Error ) {
				$date_sale_from = emc_get_date_field( 'date', $post_id )->getTimestamp() ?? null;
				$date_sale_to   = emc_get_date_field( 'date', $post_id )->getTimestamp() ?? null;
			}

			$isopen = true;
			if ( $date_sale_from && $date_sale_to ) {
				$isopen = $date_sale_from < $now && $date_sale_to > $now && $event_date > $now;
			} elseif ( ! get_field( 'checkbox', $post_id ) ) {
				$isopen = $event_date > $now;
			}

			$data['posts'][] = array(
				'id'              => $post_id,
				'title'           => get_the_title( $post_id ),
				'category'        => get_the_category( $post_id ),
				'excerpt'         => get_the_excerpt( $post_id ),
				'url'             => get_post_permalink( $post_id ),
				'thumbnail'       => $thumbnail,
				'hour'            => get_field( 'hour', $post_id ),
				'available_stock' => get_field( 'available_stock', $post_id ),
				'isopen'          => $isopen,
				'checkbox'        => get_field( 'checkbox', $post_id ),
			);
		}

		$count         = $query->found_posts;
		$pages         = ceil( $count / 9 );
		$data['pages'] = $pages;

		wp_send_json( $data, 200 );
	}
}
