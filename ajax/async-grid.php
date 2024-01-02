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
        $order = $term === 'historic' ? 'DESC' : 'ASC';
        $time_dir = $term === 'historic' ? '<=' : '>=';

        $args = array(
            'post_type' => $type,
            'post_status' => 'publish',
            'posts_per_page' => 9,
            'offset' => ($page - 1) * 9,
            'meta_key' => 'date',
            'orderby' => 'meta_value',
            'order' => $order,
            'meta_query' => [
                'relation' => 'OR', [
                    'key' => 'date',
                    'compare' => $time_dir,
                    'value' => date('Y-m-d'),
                    'type' => 'DATE',
                ]
            ]
        );

        if ($term != 'all' && $term != 'historic') {
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
            $thumbnail = get_the_post_thumbnail_url($ID, 'medium');
            // try {
            $date = get_field('date', $ID);
            $final_date_for_comparison = DateTime::createFromFormat('d/m/Y', get_field('date', $ID));
            $date_sale_from = DateTime::createFromFormat('d/m/Y', get_field('date_sale_from', $ID));
            $date_sale_to = DateTime::createFromFormat('d/m/Y', get_field('date_sale_to', $ID));
            $today = time();
            $checkbox = get_field('checkbox', $ID);
            $isopen = true;
            if ($date_sale_from && $date_sale_to) {
                $isopen = ($date_sale_from->getTimestamp() < $today && $date_sale_to->getTimestamp() > $today) && $final_date_for_comparison->getTimestamp() > $today;
            } else if (!$checkbox) {
                $isopen = $final_date_for_comparison->getTimestamp() > $today;
            }

            echo DateTime::createFromFormat('d/m/Y', date());
            $date_initial = get_field('date_initial', $ID);
            // } catch (Exception $e) {
            //     $date = null;
            // }

            $hour = get_field('hour', $ID);
            if (!$thumbnail) {
                $thumbnail = get_template_directory_uri() . '/assets/images/event--default.png';
            }
            $stock = get_field('available_stock', $ID);

            array_push($data['posts'], array(
                'id' => $ID,
                'title' => get_the_title($ID),
                'category' => get_the_category($ID),
                'excerpt' => get_the_excerpt($ID),
                'url' => get_post_permalink($ID),
                'thumbnail' => $thumbnail,
                'date' => $date,
                'date_initial' => $date_initial,
                'hour' => $hour,
                'available_stock' => $stock,
                'isopen' => $isopen,
                'checkbox' => $checkbox,
                'comparison_date' => $final_date_for_comparison
            ));
        }

        $count = $query->found_posts;
        $pages = ceil($count / 9);
        $data['pages'] = $pages;

        wp_send_json($data, 200);
    }
}

add_action('wp_ajax_get_grid_pages', 'emc_get_grid_pages');
add_action('wp_ajax_nopriv_get_grid_pages', 'emc_get_grid_pages');

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
