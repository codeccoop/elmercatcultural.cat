<?php

add_shortcode('emc_feed', 'emc_feed');
function emc_feed($atts)
{
    $post_type = isset($atts['post_type']) ? $atts['post_type'] : 'post';
    $posts = isset($atts['posts']) ? $atts['posts'] : 3;

    $query = new WP_Query([
        'post_type' => $post_type,
        'posts_per_page' => $posts,
    ]);

    ob_start(); ?>
    <div class="emc-feed">
    <?php while ($query->have_posts()) : $post = $query->the_post(); ?>
        <article class="emc-feed-entry">
            <a href="<?= get_the_permalink($post) ?>">
                <figure class="emc-feed-thumbnail">
                    <picture>
                        <img src="<?= get_the_post_thumbnail_url($post, 'full') ?>">
                    </picture>
                    <figcaption class="small"><?= get_the_title($post) ?></figcaption>
                </figure>
            </a>
        </article> 
        <?php endwhile; ?>
        </div>
    <?php
    return ob_get_clean();
}
