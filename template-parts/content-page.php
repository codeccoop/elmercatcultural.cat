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
        <?php $tags = wp_get_post_tags(get_the_ID());
        if (sizeof($tags) > 0) : ?>
            <a href="/">
                <p class="underline page-breadcrumb small"><?= $tags[0]->name; ?></p>
            </a>
        <?php endif; ?>
        <?php the_title('<h2 class="page-title">', '</h2>'); ?>
    </header><!-- .entry-header -->

    <div class="page-content">
        <?php
        the_content();
        ?>
    </div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
