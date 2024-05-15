<?php

add_shortcode('emc_feed', 'emc_feed');
function emc_feed($atts)
{
    $post_type = isset($atts['post_type']) ? $atts['post_type'] : 'post';
    $posts = isset($atts['posts']) ? $atts['posts'] : 3;

    $query = new WP_Query([
        'post_type' => $post_type,
        'posts_per_page' => $posts,
        'meta_query' => [
            [
                'key' => 'date',
                'type' => 'DATE',
                'value' => date('Y-m-d H:m:s'),
                'compare' => '>='
            ]
        ],
        'orderby' => 'meta_value',
        'order' => 'ASC',
    ]);

    if ($query->found_posts < 3) {
        if ($post_type === 'event') {
            return '<h2>No et perdis cap esdeveniment</h2>';
        } else {
            return '<h2>Descobreix tot el que fem a elMercat</h2>';
        }
    }

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
