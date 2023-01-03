<?php

/**
 * elmercatcultural.cat functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package elmercatcultural.cat
 */

if (!defined('ELMERCATCULTURAL_VERSION')) {
    // Replace the version number of the theme on each release.
    define('ELMERCATCULTURAL_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function setup()
{
    /*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on elmercatcultural.cat, use a find and replace
		* to change 'elmercatcultural.cat' to the name of your theme in all the template files.
		*/
    load_theme_textdomain('elmercatcultural.cat', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
    add_theme_support('title-tag');

    /*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
    add_theme_support('post-thumbnails');

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus(
        array(
            'menu-1' => esc_html__('Primary', 'elmercatcultural.cat'),
        )
    );

    /*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    // Set up the WordPress core custom background feature.
    add_theme_support(
        'custom-background',
        apply_filters(
            'custom_background_args',
            array(
                'default-color' => 'ffffff',
                'default-image' => '',
            )
        )
    );

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Add support for core custom logo.
     *
     * @link https://codex.wordpress.org/Theme_Logo
     */
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        )
    );

    add_theme_support('editor-styles');
    add_editor_style('style.css');
}
add_action('after_setup_theme', 'setup');

function emc_initialize_theme()
{
    register_taxonomy_for_object_type('post_tag', 'page');
}
add_action('init', 'emc_initialize_theme');

function emc_tags_support_query($wp_query)
{
    if ($wp_query->get('tag')) $wp_query->set('post_type', 'any');
}
add_action('pre_get_posts', 'emc_tags_support_query');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function content_width()
{
    $GLOBALS['content_width'] = apply_filters('content_width', 640);
}
add_action('after_setup_theme', 'content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function widgets_init()
{
    register_sidebar(
        array(
            'name'          => esc_html__('Sidebar', 'elmercatcultural.cat'),
            'id'            => 'sidebar-1',
            'description'   => esc_html__('Add widgets here.', 'elmercatcultural.cat'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
}
add_action('widgets_init', 'widgets_init');

/**
 * Enqueue scripts and styles.
 */
function scripts()
{
    wp_register_style('mapbox-gl-css', 'https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.css', false);
    // wp_enqueue_style('mapbox-gl-css');
    wp_register_script('mapbox-gl-js', 'https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.js', false);
    // wp_enqueue_script('mapbox-gl-js');
    // wp_enqueue_style('montserrat_font',
    # '<link rel="preconnect" href="https://fonts.googleapis.com">
    # <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    # <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,700;0,800;1,400&display=swap" rel="stylesheet">';
    // wp_enqueue_style('
    // wp_enqueue_style('montserrat_font', 'https://fonts.googleapis.com/css2?family=family=Montserrat:ital,wght@0,400;0,700;0,800;1,400&display=swap', array(), ELMERCATCULTURAL_VERSION, null, 'all');
    // wp_enqueue_style('krona_font', 'https://fonts.googleapis.com/css2?family=Krona+One&display=swap', array(), ELMERCATCULTURAL_VERSION, null, 'all');

    if (is_admin()) return;

    wp_enqueue_style('elmercatcultural-style', get_stylesheet_uri(), array(), ELMERCATCULTURAL_VERSION);
    wp_style_add_data('elmercatcultural-style', 'rtl', 'replace');

    wp_enqueue_script('elmercatcultural-navigation', get_template_directory_uri() . '/js/navigation.js', array(), ELMERCATCULTURAL_VERSION, true);
    wp_enqueue_script('elmercatcultural-viewport', get_template_directory_uri() . '/js/viewport.js', array(), ELMERCATCULTURAL_VERSION, true);
    wp_enqueue_script('elmercatcultural-device', get_template_directory_uri() . '/js/device-detect.js', array(), ELMERCATCULTURAL_VERSION, true);

    if (is_single()) {
        wp_enqueue_style('slick-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', array(), true);
        wp_enqueue_script('slick-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), ELMERCATCULTURAL_VERSION, true);
        wp_enqueue_script('front-page', get_template_directory_uri() . '/js/event.js', array('jquery', 'slick-js'), ELMERCATCULTURAL_VERSION, true);
    }
    if (is_front_page()) {
        wp_enqueue_style('slick-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', array(), true);
        wp_enqueue_script('slick-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), ELMERCATCULTURAL_VERSION, true);
        wp_enqueue_script('front-page', get_template_directory_uri() . '/js/front-page.js', array('jquery', 'slick-js'), ELMERCATCULTURAL_VERSION, true);
    } else if (is_page(array('programacio', 'tallers'))) {
        wp_enqueue_script('async-grid', get_template_directory_uri() . '/js/async-grid.js', array(), ELMERCATCULTURAL_VERSION, true);
        wp_localize_script(
            'async-grid',
            'ajax_data',
            array(
                'nonce' => wp_create_nonce('async_grid'),
                'ajax_url' => admin_url('admin-ajax.php'),
            )
        );
    } else if (is_checkout()) {
        wp_enqueue_script('elmercatcultural-validateID', get_template_directory_uri() . '/js/validateID.js', array(), ELMERCATCULTURAL_VERSION, true);
        wp_enqueue_script('elmercatcultural-checkout', get_template_directory_uri() . '/js/checkout-fields-validator.js', array(), ELMERCATCULTURAL_VERSION, true);
    }

    /* if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    } */
}
add_action('wp_enqueue_scripts', 'scripts');
add_action('admin_enqueue_scripts', 'scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if (class_exists('WooCommerce')) {
    require get_template_directory() . '/inc/woocommerce.php';
}

function wip_redirection()
{
    if (!is_user_logged_in()) {
        wp_redirect('/wip.html');
    }
}
// add_action('template_redirect', 'wip_redirection');
/**
 * Load shortcodes
 */
require get_template_directory() . '/shortcodes/embedded-map.php';

/* Custom Post Types */
require get_template_directory() . '/post_types/destacat.php';
require get_template_directory() . '/post_types/event.php';
require get_template_directory() . '/post_types/workshop.php';

/* AJAX actions */
require get_template_directory() . '/ajax/async-grid.php';


/*WOOCOMMERCE*/

/*This file enables you to add custom code to your site*/

function elmercatcultural_add_woocommerce_support()
{
    add_theme_support('woocommerce');
}

add_filter('woocommerce_cart_totals_coupon_html', 'elmercatcultural_remove_coupon_html');
function elmercatcultural_remove_coupon_html($html, $coupon = null, $discount = null)
{
    return preg_replace('/\<a href/', '<a aria-hidden="true" href', $html);
}

add_filter('woocommerce_thankyou_order_received_text', 'elmercatcultural_thankyou_text');
function elmercatcultural_thankyou_text($text, $order = null)
{
    return 'Benvolgudes, gràcies per realitzar la preinscripció al mercat';
}

add_action('after_setup_theme', 'elmercatcultural_add_woocommerce_support');

/***
 Remove billing fields
 **/
function elmercatcultural_remove_checkout_fields($fields)
{

    // Billing fields

    unset($fields['billing']['billing_state']);
    unset($fields['billing']['billing_country']);
    unset($fields['billing']['billing_address_1']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_city']);


    // Shipping fields
    unset($fields['shipping']['shipping_state']);
    unset($fields['shipping']['shipping_country']);
    unset($fields['shipping']['shipping_address_1']);
    unset($fields['shipping']['shipping_address_2']);
    unset($fields['shipping']['shipping_city']);
    // Order fields

    return $fields;
}
add_filter('woocommerce_checkout_fields', 'elmercatcultural_remove_checkout_fields');
/***
 Unrequire billing fields
 **/

function unrequire_checkout_fields($fields)
{
    $fields['billing']['billing_city']['required']      = false;
    $fields['billing']['billing_city']['class']      = array('field-remove');
    $fields['billing']['billing_country']['required']   = false;
    $fields['billing']['billing_country']['class']      = array('field-remove');
    $fields['billing']['billing_state']['required']     = false;
    $fields['billing']['billing_state']['class']      = array('field-remove');
    $fields['billing']['billing_address_1']['required'] = false;
    $fields['billing']['billing_address_1']['class']      = array('field-remove');
    $fields['billing']['billing_address_2']['required'] = false;
    $fields['billing']['billing_address_2']['class']      = array('field-remove');


    $fields['shipping']['shipping_city']['required']      = false;
    $fields['shipping']['shipping_city']['class']      = array('field-remove');
    $fields['shipping']['shipping_country']['required']   = false;
    $fields['shipping']['shipping_country']['class']      = array('field-remove');
    $fields['shipping']['shipping_state']['required']     = false;
    $fields['shipping']['shipping_state']['class']      = array('field-remove');
    $fields['shipping']['shipping_address_1']['required'] = false;
    $fields['shipping']['shipping_address_1']['class']      = array('field-remove');
    $fields['shipping']['shipping_address_2']['required'] = false;
    $fields['shipping']['shipping_address_2']['class']      = array('field-remove');

    return $fields;
}

add_filter('woocommerce_checkout_fields', 'unrequire_checkout_fields');






// remove_action( 'woocommerce_after_checkout_billing_form', 'woocommerce_checkout_shipping' );
// add_filter( 'woocommerce_ship_to_different_address_checked', '__return_false' );
//remove_action( 'woocommerce_after_checkout_billing_form', 'woocommerce_checkout_shipping' );

/***
 Add custom billing fields
 **/

// Hook in
add_filter('woocommerce_checkout_fields', 'elmercatcultural_override_checkout_fields');

// Our hooked in function – $fields is passed via the filter!
function elmercatcultural_override_checkout_fields($fields)
{
    $fields['billing']['billing_DNI'] = array(
        'placeholder'   => _x('DNI', 'placeholder', 'woocommerce'),
        'required'  => true,
        'class'     => array('form-row-wide'),
        'clear'     => true,
        'priority' => 9
    );
    $fields['billing']['billing_birthday'] = array(
        'placeholder'   => _x('DATA NAIXEMENT (dd/mm/aaaa)', 'placeholder', 'woocommerce'),
        'required'  => true,
        'class'     => array('form-row-wide'),
        'clear'     => true,
        'maxlength' => 10
    );
    //add placeholder to native fields

    $fields['billing']['billing_first_name'] = array(
        'placeholder'   => _x('NOM', 'placeholder', 'woocommerce'),
        'required'  => true
    );
    $fields['billing']['billing_last_name'] = array(
        'placeholder'   => _x('COGNOMS', 'placeholder', 'woocommerce'),
        'required'  => true
    );
    $fields['billing']['billing_email'] = array(
        'placeholder'   => _x('CORREU ELECTRÒNIC', 'placeholder', 'woocommerce'),
        'required'  => true
    );
    $fields['billing']['billing_phone'] = array(
        'placeholder'   => _x('TELÈFON', 'placeholder', 'woocommerce'),
        'required'  => true
    );
    $fields['billing']['billing_postcode'] = array(
        'placeholder'   => _x('CODI POSTAL', 'placeholder', 'woocommerce'),
        'class'     => array('form-row-wide'),
        'required'  => false
    );

    return $fields;
}
//Create radio button
add_action('radio_input_veina', 'new_radio_field');

function new_radio_field($checkout)
{
    woocommerce_form_field('billing_neighbour', array(
        'type' => 'radio',
        'class' => array('veina-radio-input', 'form-row-wide', 'update_totals_on_change'),
        'options' => array('1' => 'Si', '2' => 'No',),
        'label'  => __("VEÏNA DELS BARRIS DE MUNTANYA?"),
        'required' => true,
    ), $checkout->get_value('billing_neighbour'));
}

/**
 * DISPLAY CUSTOM MESSAGES WHEN FIELDS ARE EMPTY
 */
add_action('woocommerce_after_checkout_validation', 'quadlayers', 9999, 2);
function quadlayers($fields, $errors)
{
    // in case any validation errors
    if (!empty($errors->get_error_codes())) {

        // omit all existing error messages
        foreach ($errors->get_error_codes() as $code) {
            $errors->remove($code);
        }
        // display custom single error message
        $errors->add('validation', '');
    }
}


add_action('woocommerce_checkout_process', 'elmercatcultural_checkout_field_process');

function elmercatcultural_checkout_field_process()
{
    // Check if set, if its not set add an error.
    if (!$_POST['billing_first_name']) {
        wc_add_notice(__('És obligatori introduir el NOM'), 'error');
    }
    if (!$_POST['billing_last_name']) {
        wc_add_notice(__('És obligatori introduir els COGNOMS'), 'error');
    }

    if (!$_POST['billing_email']) {
        wc_add_notice(__('És obligatori introduir els CORREU ELECTRÒNIC vàlid'), 'error');
    }
    if (!$_POST['billing_neighbour']) {
        wc_add_notice(__('És obligatori marcar una opció a la pregunta VEÏNA DELS BARRIS DE MUNTANYA?'), 'error');
    }
}

add_action('woocommerce_checkout_update_order_meta', 'elmercatcultural_update_order_meta');
function elmercatcultural_update_order_meta($order_id)
{
    if (!empty($_POST['billing_birthday'])) {
        update_post_meta($order_id, 'DATA NAIXEMENT', sanitize_text_field($_POST['customised_field_name']));
    }
}

/* EVENT POST TYPE LIFE CYCLE */

add_filter('wp_insert_post_data', 'elmercatcultural_on_event_insert', 99, 2);
function elmercatcultural_on_event_insert($data, $postarr)  // , $unsanitized_postarr = null, $update = false)
{
    if (($postarr['post_type'] === 'event' || $postarr['post_type'] === 'workshop') && $postarr['ID'] != 0 && $data['post_status'] != 'trash') {
        $slug = sanitize_title(wp_unique_post_slug($postarr['post_title'], $postarr['ID'], $postarr['post_status'], $postarr['post_type'], null));
        $product = elmercatcultural_find_product_by_slug($slug);

        $custom_keys = array(
            'data_esdeveniment' => 0,
            'hora_esdeveniment' => 1,
            'fitxa_artistica' => 2,
            'descipcio_esdeveniment' => 3,
            'carroussel' => 4,
            'video' => 5,
            'preu_esdeveniment' => 6,
            'checkbox' => 7,
            'stock' => 8,
            'data_inici' => 9,
            'data_fi' => 10,
        );

        $post_thumbnail_id = get_post_thumbnail_id($postarr['ID']);
        $ACF_keys = array_keys($postarr['acf']);
        $has_bound_product = $postarr['acf'][$ACF_keys[$custom_keys['checkbox']]];
        if ($product == null && $has_bound_product == true) {
            $product = new WC_Product_Simple();
            $product->set_slug($slug . '-product');
            $product->set_name($postarr['post_title']);
            $product->save();
        };
        if ($has_bound_product == true) {
            $product_price = $postarr['acf'][$ACF_keys[$custom_keys['preu_esdeveniment']]];
            $product->set_regular_price($product_price); // in current shop currency
            $product_desc = $postarr['acf'][$ACF_keys[$custom_keys['descipcio_esdeveniment']]];
            $product->set_description($product_desc);
            $product->set_manage_stock(true);
            $product_stock = $postarr['acf'][$ACF_keys[$custom_keys['stock']]];
            if ($product->get_stock_quantity() === null) {
                $product->set_stock_quantity($product_stock);
            }
            $product->set_sold_individually(true);
            $product->set_image_id($post_thumbnail_id);
            $product_date_from = $postarr['acf'][$ACF_keys[$custom_keys['data_inici']]];
            $product_date_from = str_replace('/', '-', $product_date_from);
            $product_date_from = date("c", strtotime($product_date_from));
            $product->set_date_on_sale_from($product_date_from);
            $product_date_to = $postarr['acf'][$ACF_keys[$custom_keys['data_fi']]];
            $product_date_to = str_replace('/', '-', $product_date_to);
            $product_date_to = date("c", strtotime($product_date_to));
            $product->set_date_on_sale_to($product_date_to);

            $product->save();
        }
    }

    return $data;
}

add_action('wp_trash_post', 'elmercatcultural_on_delete_event', 10);
function elmercatcultural_on_delete_event($ID)
{
    if (get_post_type($ID) === 'event' || get_post_type($ID) === 'workshop') {
        $slug = get_post_field('post_name', $ID);
        $product = elmercatcultural_find_product_by_slug($slug);
        if ($product == null) return;
        $product->delete();
    }
}



function elmercatcultural_find_product_by_slug($slug)
{
    $posts = get_posts(array(
        'name' => $slug . '-product',
        'post_type' => 'product'
    ));
    if (count($posts) == 0) {
        return null;
    }
    $post = $posts[0];
    return wc_get_product($post);
}

add_action('acf/save_post', 'elmercatcultural_slug_sync');
function elmercatcultural_slug_sync($post_id)
{
    $post_type = get_post_type($post_id);
    if ($post_type == 'workshop' || $post_type == 'event') {
        $post = get_post($post_id);
        $title = $post->post_title;
        $clean_title = sanitize_title($title);
        $slug = $post->post_name;
        if ($slug != $clean_title) {
            $clean_post = array('ID' => $post_id, 'post_name' => $clean_title);
            wp_update_post($clean_post);
        }
    }
}
