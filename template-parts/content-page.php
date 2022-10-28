<?php

/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package elmercatcultural.cat
 */

?>

<article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="page-header">
        <?php $tags = wp_get_post_tags(get_the_ID()); ?>
        <div class="page-breadcrumbs">
            <?php if (sizeof($tags) > 0) : ?>
                <p class="page-breadcrumb small">EL MERCAT</p>
            <?php else : ?>
                <p class="page-breadcrumb small">EL MERCAT</p>
            <?php endif; ?>
            <a href="/">
                <p class="page-breadcrumb underline small">
                    < &nbspTORNAR</p>
            </a>
        </div>
        <?php the_title('<h2 class="page-title">', '</h2>'); ?>
    </header><!-- .entry-header -->

    <div class="page-content">
        <?php
        the_content();
        ?>
    </div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
