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
        <?php $tags = wp_get_post_tags(get_the_ID());
        if (sizeof($tags) > 0) : ?>
            <p class="page-breadcrumb small"><?= $tags[0]->name; ?></p>
        <?php endif; ?>
        <?php the_title('<h2 class="post-title is-2">', '</h2>'); ?>
    </header><!-- .entry-header -->

    <div class="post-content">
        <?php $post_id = get_the_ID(); ?>
        <div class="post-content__inscription">
            <a class="small-title">INSCRIU-TE</a>
            <p class="event-bold small">DATES</p>
            <?php if (get_field('date', $post_id)) : ?>
                <p class="small"><?php the_field('date', $post_id); ?></p>
            <?php else : ?>
                
            <?php endif ?>
            <p class="event-bold small">SESSIONS</p>
            <p class="event-bold small">HORA</p>
            <p class="event-bold small">PREU</p>
            <p class="event-bold small">CATEGORIA</p>
            <p class="event-bold small">FITXA TÈCNICA</p>

        </div>
        <div class="post-content__description">
            <p><?php echo get_the_excerpt($post_id); ?></p>
            <?php the_post_thumbnail(); ?>
        </div>

       
    </div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
