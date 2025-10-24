<?php

/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package elmercatcultural.cat
 */

defined( 'ABSPATH' ) || exit;
?>


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php do_action( 'woocommerce_before_cart' ); ?>
	<header class="post-header">
		<div class="post-breadcrumbs">
			<p class="post-breadcrumb small">TALLERS I BOCINS</p>
			<?php
			$parent_page    = get_page_by_path( 'tallers', OBJECT, 'page' );
			$breadcrumb_url = get_page_link( $parent_page );
			?>
			<a href="<?php echo $breadcrumb_url; ?>">
				<p class="post-breadcrumb underline small">
					< &nbspTORNAR</p>
			</a>
		</div>
		<?php the_title( '<h1 class="post-title is-2">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="post-content">
		<?php
		$post_id = get_the_ID();
		global $post;
		$product              = emc_get_bound_product( $post_id );
		$has_inscription      = false;
		$external_inscription = null;

		if ( $product ) {
			$has_inscription = get_field( 'checkbox', $post_id );

			$now = current_time( 'U', false );

			try {
				$end_date = strtotime( $product->get_date_on_sale_to() );
				if ( ! $end_date ) {
					$end_date = emc_get_date_field( 'date', $post_id )->getTimestamp();
				}

				$start_date = strtotime( $product->get_date_on_sale_from() );
				if ( ! $start_date ) {
					$start_date = $now;
				}
			} catch ( Error ) {
				$end_date   = emc_get_date_field( 'date', $post_id )->getTimestamp();
				$start_date = emc_get_date_field( 'date', $post_id )->getTimestamp();
			}

			$stock = $product->get_stock_quantity();
		} else {
			$external_inscription = get_field( 'external_inscription', $post_id );
		}
		?>
	<div class="post-content__inscription">
	<?php
	if ( $has_inscription ) {
		if ( $end_date >= $now && $start_date <= $now ) {
			if ( $stock > 0 ) {
				?>
					<form class="cart" action="/cistella" method="post" enctype="multipart/form-data">
						<button type="submit" name="add-to-cart" value="<?php echo $product->get_id(); ?>" class="single_add_to_cart_button button alt wp-element-button inscription">Inscriu-t'hi</button>
					</form>
					<?php
			} elseif ( get_field( 'has_waiting_list', $post_id ) ) {
				$inscriptions = get_field( 'waiting_list_url', $post_id );
				?>
					<p class="event-bold event-title">INSCRIPCIÓ</p>
					<p class="small">Places esgotades, apunta't a <a href="<?php echo $inscriptions; ?>" target="_blank" style="text-decoration:underline;">la llista d'espera</a></p>
					<?php
			} else {
				?>
					<p class="event-bold event-title">INSCRIPCIÓ</p>
					<p class="small">Inscripció tancada</p>
					<?php
			}
		} else {
			?>
				<p class="event-bold event-title">INSCRIPCIÓ</p>
				<p class="small">Inscripció tancada</p>
				<?php
		}
	} elseif ( $external_inscription ) {
		?>
			<div class="cart">
				<a class="button" target="_blank" href="<?php echo $external_inscription; ?>">Inscripció</a>
			</div>
			<?php
	}

	?>
		<p class="event-bold event-title">DATA I HORARI</p>
		<?php if ( get_field( 'hour', $post_id ) ) { ?>
			<p class="small"><?php the_field( 'hour', $post_id ); ?></p>
		<?php } ?>
		<p class="event-bold event-title">PREU</p>
		<?php if ( get_field( 'price', $post_id ) ) : ?>
			<p class="small"><?php the_field( 'price', $post_id ); ?></p>
		<?php else : ?>
			<p class="small">Gratuït</p>
		<?php endif; ?>
		<p class="event-bold event-title">CATEGORIA</p>
		<?php
		$categories = get_the_category( $post_id );
		foreach ( $categories as $category ) {
			?>
			<p class="small"><?php echo $category->name; ?></p>
			<?php } ?>
		<p class="event-bold event-title">FITXA TÈCNICA</p>
		<span class="artistic-description"><?php the_field( 'artists', $post_id ); ?></p>
	</div>
		<div class="post-content__description">
			<div class="description-text">
				<?php the_field( 'description_event', $post_id ); ?>
			</div>
			<?php if ( get_field( 'video', $post_id ) ) { ?>
				<div class="video-container">
					<?php the_field( 'video', $post_id ); ?>
				</div>
			<?php } ?>
			<?php
			$has_images = false;
			if ( get_field( 'carroussel_event', $post_id ) ) {
				$carroussel_event = get_field( 'carroussel_event', $post_id );
				foreach ( $carroussel_event as $item => $val ) {
					if ( $val != null ) {
						$has_images = true;
					}
				}
			}

			if ( $has_images ) {
				?>
				<div class="carroussel-container">
					<div class="carroussel-content">
						<?php
						if ( $carroussel_event['image_carroussel_1'] ) {
							$image_carroussel_1 = $carroussel_event['image_carroussel_1'];
							$carroussel_data_1  = wp_get_attachment_image_src( $image_carroussel_1, 'full', false );
							?>
							<div><img class="carroussel-image" src="<?php echo $carroussel_data_1[0]; ?>" alt="Imatge del carroussel"></div>
									<?php
						}
						if ( $carroussel_event['image_carroussel_2'] ) {
							$image_carroussel_2 = $carroussel_event['image_carroussel_2'];
							$carroussel_data_2  = wp_get_attachment_image_src( $image_carroussel_2, 'full', false );
							?>
							<div><img class="carroussel-image" src="<?php echo $carroussel_data_2[0]; ?>" alt="Imatge del carroussel"></div>
									<?php
						}
						if ( $carroussel_event['image_carroussel_3'] ) {
							$image_carroussel_3 = $carroussel_event['image_carroussel_3'];
							$carroussel_data_3  = wp_get_attachment_image_src( $image_carroussel_3, 'full', false );
							?>
							<div><img class="carroussel-image" src="<?php echo $carroussel_data_3[0]; ?>" alt="Imatge del carroussel"></div>
									<?php } ?>
					</div>
					<div class="slides-numbers">
						<span class="active">1</span> / <span class="total"></span>
					</div>
				</div>

				<?php
			} elseif ( has_post_thumbnail() ) {
				?>
					<div class="thumbnail-container">
						<?php the_post_thumbnail(); ?>
					</div>

			<?php } ?>
		</div>
	</div><!-- .entry-content -->
</article>
<!-- #post-<?php the_ID(); ?> -->
