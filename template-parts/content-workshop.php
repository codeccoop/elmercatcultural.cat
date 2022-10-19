<?php

/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package elmercatcultural.cat
 */

?>


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="post-header">
        <?php $parent_page = get_page(28); ?>
        <a href="<?= get_page_link($parent_page); ?>">
            <p class="page-breadcrumb small">TALLERS I BOCINS</p>
        </a>
        <?php the_title('<h2 class="post-title is-2">', '</h2>'); ?>
    </header><!-- .entry-header -->

    <div class="post-content">
        <?php $post_id = get_the_ID(); ?>
        <div class="post-content__inscription">
            <p class="event-bold event-title">INSCRIPCIÓ</p>
            <p class="small"> Presencial </p>
            <p class="event-bold event-title">DATES</p>
            <?php if (get_field('date', $post_id)) { ?>
                <p class="small"><?php the_field('date', $post_id); ?></p>
            <?php } ?>

            <p class="event-bold event-title">HORARI</p>
            <?php if (get_field('hour', $post_id)) { ?>
                <p class="small"><?php the_field('hour', $post_id); ?></p>
            <?php } ?>
            <p class="event-bold event-title">PREU</p>
            <?php if (get_field('price', $post_id)) { ?>
                <p class="small"><?php the_field('price', $post_id); ?></p>
            <?php } ?>
            <p class="event-bold event-title">CATEGORIA</p>
            <?php $categories = get_the_category($post_id);
            foreach ($categories as $category) { ?>
                <p class="small"><?php echo $category->name; ?></p>
            <?php } ?>
            <p class="event-bold event-title">FITXA TÈCNICA</p>
            <span class="artistic-description"><?php the_field('artists', $post_id); ?></p>
        </div>
        <div class="post-content__description">
            <div class="description-text">
                <?php the_field('description_event', $post_id); ?>
            </div>
            <?php
            $has_images = false;
            if (get_field('carroussel_event', $post_id)) {
                $carroussel_event = get_field('carroussel_event', $post_id);
                foreach ($carroussel_event as $item => $val) {
                    if ($val != null) {
                        $has_images = true;
                    }
                }
            }
            if ($has_images) { ?>
                <div class="carroussel-container">
                    <div class="carroussel-content">
                        <?php
                        if ($carroussel_event['image_carroussel_1']) {
                            $image_carroussel_1 = $carroussel_event['image_carroussel_1'];
                            $carroussel_data_1 = wp_get_attachment_image_src($image_carroussel_1, 'full', false); ?>
                            <div><img class="carroussel-image" src="<?php echo $carroussel_data_1[0]; ?>" alt="Imatge del carroussel"></div>
                        <?php }
                        if ($carroussel_event['image_carroussel_2']) {
                            $image_carroussel_2 = $carroussel_event['image_carroussel_2'];
                            $carroussel_data_2 = wp_get_attachment_image_src($image_carroussel_2, 'full', false); ?>
                            <div><img class="carroussel-image" src="<?php echo $carroussel_data_2[0]; ?>" alt="Imatge del carroussel"></div>
                        <?php }
                        if ($carroussel_event['image_carroussel_3']) {
                            $image_carroussel_3 = $carroussel_event['image_carroussel_3'];
                            $carroussel_data_3 = wp_get_attachment_image_src($image_carroussel_3, 'full', false); ?>
                            <div><img class="carroussel-image" src="<?php echo $carroussel_data_3[0]; ?>" alt="Imatge del carroussel"></div>
                        <?php } ?>
                    </div>
                    <div class="slides-numbers">
                        <span class="active">1</span> / <span class="total"></span>
                    </div>
                </div>

                <?php } else {
                if (has_post_thumbnail()) { ?>
                    <div class="thumbnail-container">
                        <?php the_post_thumbnail(); ?>
                    </div>

            <?php }
            } ?>
            <?php if (get_field('video', $post_id)) { ?>
                <div class="video-container">
                    <?php the_field('video', $post_id); ?>
                </div>
            <?php } ?>

        </div>


    </div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
