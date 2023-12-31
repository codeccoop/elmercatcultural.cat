<?php
add_action('wp_ajax_get_grid_items', 'emc_get_grid_items');
add_action('wp_ajax_nopriv_get_grid_items', 'emc_get_grid_items');

if (!function_exists('emc_get_grid_items')) {
    function emc_get_grid_items()
    {
        check_ajax_referer('async_grid');
        $term = $_POST['term'];
        $page = $_POST['page'];
        $type = $_POST['type'];
        $time_dir = $term === 'historic' ? '<=' : '>=';

        $args = [
            'post_type' => $type,
            'post_status' => 'publish',
            'posts_per_page' => 9,
            'offset' => ($page - 1) * 9,
            'meta_key' => 'date',
            'orderby' => 'meta_value',
            'order' => 'ASC',
            'meta_query' => [
                [
                    'key' => 'date',
                    'compare' => $time_dir,
                    'value' => date('Y-m-d'),
                    'type' => 'DATE',
                ]
            ]
        ];

        if ($term != 'all' && $term != 'historic') {
            $args['category_name'] = $term;
        }

        $query = new WP_Query($args);

        $data = [
            'posts' => [],
            'pages' => 0
        ];

        while ($query->have_posts()) {
            $query->the_post();
            $ID = get_the_ID();
            $thumbnail = get_the_post_thumbnail_url($ID, 'medium');
            if (!$thumbnail) $thumbnail = get_template_directory_uri() . '/assets/images/event--default.png';

            $event_date = DateTime::createFromFormat('d/m/Y', get_field('date', $ID));
            $date_sale_from = DateTime::createFromFormat('d/m/Y g:i a', get_field('date_sale_from', $ID));
            $date_sale_to = DateTime::createFromFormat('d/m/Y g:i a', get_field('date_sale_to', $ID));
            $today = time();

            $isopen = true;
            if ($date_sale_from && $date_sale_to) {
                $isopen = ($date_sale_from->getTimestamp() < $today && $date_sale_to->getTimestamp() > $today) && $event_date->getTimestamp() > $today;
            } else if (!get_field('checkbox', $ID)) {
                $isopen = $event_date->getTimestamp() > $today;
            }

            $data['posts'][] = [
                'id' => $ID,
                'title' => get_the_title($ID),
                'category' => get_the_category($ID),
                'excerpt' => get_the_excerpt($ID),
                'url' => get_post_permalink($ID),
                'thumbnail' => $thumbnail,
                'date' => get_field('date', $ID),
                'date_initial' => get_field('date_initial', $ID),
                'hour' => get_field('hour', $ID),
                'available_stock' => get_field('available_stock', $ID),
                'isopen' => $isopen,
                'checkbox' => get_field('checkbox', $ID),
            ];
        }

        $count = $query->found_posts;
        $pages = ceil($count / 9);
        $data['pages'] = $pages;

        wp_send_json($data, 200);
    }
}
