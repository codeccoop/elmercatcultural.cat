<?php
add_action('wp_ajax_get_grid_events', 'emc_get_grid_events');

if (!function_exists('emc_get_grid_events')) {
    function emc_get_grid_events()
    {
        check_ajax_referer('async_grid');
        $term = $_POST['term'];
        $page = $_POST['page'];
        $args = array(
            'post_type' => 'event',
            'post_status' => 'publish',
            'posts_per_page' => 9,
            'offset' => ($page - 1) * 9
        );
        if ($term != 'all') {
            $args['category_name'] = $term;
        }

        $query = new WP_Query($args);

        $data = array(
            'posts' => array(),
            'pages' => 0
        );
        while ($query->have_posts()) {
            $query->the_post();
            $ID = get_the_ID();
            array_push($data['posts'], array(
                'id' => $ID,
                'title' => get_the_title($ID),
                'category' => get_the_category($ID),
                'excerpt' => get_the_excerpt($ID),
                'thumbnail' => get_the_post_thumbnail_url($ID)
            ));
        }

        if ($term != 'all') {
            $cat = get_term_by('slug', $term, 'category');
            // $cat = get_category($catID);
            $count = $cat->count;
        } else {
            $count = wp_count_posts('event');
            if ($count) {
                $count = $count->publish;
            } else {
                $count = 0;
            }
        }

        $pages = ceil($count / 9);
        $data['pages'] = $pages;

        wp_send_json($data, 200);
    }
}

add_action('wp_ajax_get_grid_pages', 'emc_get_grid_pages');

if (!function_exists('emc_get_grid_pages')) {
    function emc_get_grid_pages()
    {

        check_ajax_referer('async_grid');

        $term = $_POST['term'];


        $data = array();

        for ($i = 0; $i < $pages; $i++) {
            array_push($data, $i);
        }

        wp_send_json($data);
    }
}
