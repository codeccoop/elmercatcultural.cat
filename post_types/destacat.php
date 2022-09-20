<?php
//adding our own portfolio item
function emc_post_type_destacat()
{
    $labels = array(
        'name'               => _x('Destacats', 'post type general name'),
        'singular_name'      => _x('Destacat', 'post type singular name'),
        'menu_name'          => 'Destacats'
    );
    $args = array(
        'labels'        => $labels,
        'description'   => 'Aquest post es mostrarà al slider de la portada',
        'public'        => true,
        'menu_position' => 3,
        'supports'      => array('title', 'thumbnail', 'excerpt'),
        'show_in_rest'  => true,
        'has_archive'   => false,
        # 'taxonomies' => array('category', 'post_tag'),
    );
    register_post_type('destacat', $args);
}

add_action('init', 'emc_post_type_destacat');
