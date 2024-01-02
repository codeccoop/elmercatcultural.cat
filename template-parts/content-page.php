<?php

/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package elmercatcultural.cat
 */

?>

<article id="page-<?php the_ID(); ?>" <?php post_class(is_cart() || is_checkout() ? 'type-wc-cart' : ''); ?>>
    <header class="page-header">
        <?php $tags = wp_get_post_tags(get_the_ID()); ?>
        <div class="page-breadcrumbs">
            <?php if (sizeof($tags) > 0) : ?>
                <p class="page-breadcrumb small"><?= $tags[0]->name; ?></p>
            <?php else : ?>
                <p class="page-breadcrumb small">EL MERCAT</p>
            <?php endif; ?>
            <?php if (is_cart() || is_checkout() && empty(is_wc_endpoint_url('order-received'))) : ?>
                <?php
                $site_url = get_site_url();
                $breadcrumb_url = wp_get_referer();
                if ($breadcrumb_url !== $site_url) : ?>
                    <a onclick="history.back()">
                        <p class="post-breadcrumb underline small">
                            < &nbspTORNAR</p>
                    </a>
                <?php else : ?>
                    <a href="<?= $site_url ?>">
                        <p class="post-breadcrumb underline small">
                            < &nbspTORNAR</p>
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php the_title('<h1 class="page-title">', '</h1>'); ?>
    </header><!-- .entry-header -->

    <div class="page-content">
        <?php
        the_content();
        ?>
    </div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->