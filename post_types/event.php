<?php

//adding our own portfolio item
function emc_post_type_event()
{
    $labels = array(
        'name'               => _x('Programació', 'post type general name'),
        'singular_name'      => _x('Esdeveniment', 'post type singular name'),
        'menu_name'          => 'Programació'
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
    register_post_type('event', $args);
}

add_action('init', 'emc_post_type_event');

function emc_get_event_by_name($name)
{
    return emc_get_post_by_name($name, 'event');
}
