<?php
//adding our own portfolio item
function emc_post_type_workshop()
{
    $labels = array(
        'name'               => _x('Tallers', 'post type general name'),
        'singular_name'      => _x('Taller', 'post type singular name'),
        'menu_name'          => 'Tallers'
    );
    $args = array(
        'labels'        => $labels,
        'description'   => 'Aquest post serveix per crear les entrades de la secció serveis',
        'public'        => true,
        'menu_position' => 4,
        'supports'      => array('title', 'thumbnail', 'page-attributes'),
        'show_in_rest'  => true,
        'has_archive'   => false,
        'taxonomies' => array('category'),
    );
    register_post_type('workshop', $args);
}

add_action('init', 'emc_post_type_workshop');
