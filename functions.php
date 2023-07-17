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
    define('ELMERCATCULTURAL_VERSION', '2.5.1');
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
    }
}
add_action('wp_enqueue_scripts', 'scripts');
add_action('admin_enqueue_scripts', 'scripts');

/**
 * DNI Validator
 */
require get_template_directory() . '/inc/validate-id.php';

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


/* 
***************************************************************************************************
----------------------------------------------------------------------------------------------------
                                                WOOCOMMERCE 
---------------------------------------------------------------------------------------------------
***************************************************************************************************
*/

/* 
++++++++++++++++
CREATE PRODUCTS AUTOMATICALLY 
++++++++++++++++
*/

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
            'available_stock' => 8,
            'data_inici' => 9,
            'data_fi' => 10,
            'genere' => 11
            // 'checkbox_discount' => 11
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
            $product_stock = $postarr['acf'][$ACF_keys[$custom_keys['available_stock']]];
            $product->set_stock_quantity($product_stock);
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
            $product_gender = $postarr['acf'][$ACF_keys[$custom_keys['genere']]];
            $product->update_meta_data('genere', $product_gender);
            $product->save();
        }
    }

    return $data;
}

add_filter('acf/load_value/name=available_stock', 'elmercatcultural_update_stock', 10, 3);
function elmercatcultural_update_stock($value, $post_id, $field)
{
    $post = get_post($post_id);
    $slug = $post->post_name;
    $product = elmercatcultural_find_product_by_slug($slug);
    if ($product === null) {
        return;
    }
    $stock_quantity = $product->get_stock_quantity();
    if ($stock_quantity === null) {
        return;
    } else {
        $value = $stock_quantity;
    }
    return $value;
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

/* 
++++++++++++++++
CART SECTION 
++++++++++++++++
*/


/* EXCLUDE PRODUCTS FROM COUPON DISCOUNT*/
add_filter('woocommerce_coupon_is_valid_for_product', 'elmercatcultural_exclude_product_coupons', 9999, 4);
function elmercatcultural_exclude_product_coupons($valid, $product, $coupon, $values)
{

    if ($product->get_meta('checkbox_discount') === '0') {
        $valid = false;
    }
    return $valid;
}
/* FORCE TO APPLY ALL COUPONS*/

function available_coupon_codes()
{
    global $wpdb;

    // Get an array of all existing coupon codes
    $coupon_codes = $wpdb->get_col("SELECT post_title FROM $wpdb->posts WHERE post_type = 'shop_coupon' AND post_status = 'publish' ORDER BY post_name ASC");

    // Display available coupon codes
    return $coupon_codes; // always use return in a shortcode
}

/** COUPONS LOGIC */
function elmercatcultural_coupon_include_product($coupon_product_ids, $cart_product_ids)
{

    $doesInclude = false;
    foreach ($coupon_product_ids as $coupon_product_id) {
        foreach ($cart_product_ids as $cart_product_id) {
            $doesInclude = $doesInclude || $coupon_product_id == $cart_product_id;
        }
    }
    return $doesInclude;
}
function auto_apply_coupon_for_regular_customers($coupon_code)
{

    if ($coupon_code != 'master-coupon') {
        return;
    }
    $coupon_codes = available_coupon_codes();
    $cart_product_ids = [];
    foreach (WC()->cart->get_cart() as $item => $cart_product) {
        $cart_product_ids[] = $cart_product['product_id'];
    }
    $has_available_coupons = false;
    foreach ($coupon_codes as $code) {
        $coupon = get_page_by_title($code, OBJECT, 'shop_coupon');
        $coupon_id = $coupon->ID;
        $coupon_product_ids = explode(',', get_post_meta($coupon_id, 'product_ids', true));

        if (!WC()->cart->has_discount($code) && elmercatcultural_coupon_include_product($coupon_product_ids, $cart_product_ids)) {

            WC()->cart->apply_coupon($code);
            $has_available_coupons = true;
        }
    }
}

add_action('woocommerce_applied_coupon', 'auto_apply_coupon_for_regular_customers', 10, 1);


add_action('woocommerce_removed_coupon', 'auto_remove_coupon_for_regular_customers', 10, 1);
function auto_remove_coupon_for_regular_customers($coupon_code)
{
    WC()->cart->remove_coupons();
}

//REMOVE COUPON CART MESSAGE WHEN APPLIED
add_filter('woocommerce_coupon_message', 'remove_msg_filter', 10, 2);
function remove_msg_filter($msg, $msg_code)
{
    if ($msg_code === WC_Coupon::WC_COUPON_SUCCESS) {
        return null;
    } else {
        return $msg;
    }
}
//REMOVE CART MESSAGE WHEN PRODUCT REMOVED
add_filter('woocommerce_cart_item_removed_notice_type', '__return_null');

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

/* 
++++++++++++++++
CHECKOUT SECTION
++++++++++++++++
*/
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
    $fields['billing']['billing_city']['required'] = false;
    $fields['billing']['billing_city']['class'] = array('field-remove');
    $fields['billing']['billing_country']['required'] = false;
    $fields['billing']['billing_country']['class'] = array('field-remove');
    $fields['billing']['billing_state']['required'] = false;
    $fields['billing']['billing_state']['class'] = array('field-remove');
    $fields['billing']['billing_address_1']['required'] = false;
    $fields['billing']['billing_address_1']['class'] = array('field-remove');
    $fields['billing']['billing_address_2']['required'] = false;
    $fields['billing']['billing_address_2']['class'] = array('field-remove');

    $fields['shipping']['shipping_city']['required'] = false;
    $fields['shipping']['shipping_city']['class'] = array('field-remove');
    $fields['shipping']['shipping_country']['required'] = false;
    $fields['shipping']['shipping_country']['class'] = array('field-remove');
    $fields['shipping']['shipping_state']['required'] = false;
    $fields['shipping']['shipping_state']['class'] = array('field-remove');
    $fields['shipping']['shipping_address_1']['required'] = false;
    $fields['shipping']['shipping_address_1']['class'] = array('field-remove');
    $fields['shipping']['shipping_address_2']['required'] = false;
    $fields['shipping']['shipping_address_2']['class'] = array('field-remove');

    return $fields;
}

add_filter('woocommerce_checkout_fields', 'unrequire_checkout_fields');

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
add_action('radio_input_veina', 'elmercatcultural_new_radio_field');

function elmercatcultural_new_radio_field($checkout)
{
    woocommerce_form_field('billing_neighbour', array(
        'type' => 'radio',
        'class' => array('veina-radio-input', 'form-row-wide', 'update_totals_on_change'),
        'options' => array('1' => 'Si', '2' => 'No',),
        'label'  => __("VEÏNA DELS BARRIS DE MUNTANYA?"),
        'required' => true,
    ), $checkout->get_value('billing_neighbour'));
}


/** add gender custom field and display conditonally depending on post meta*/

function elmercatcultural_filter_checkout_fields($fields)
{
    $fields['extra_fields'] = array(
        'billing_gender_mixta' => array(
            'type' => 'select',
            'class' => array('form-row-wide'),
            'options' => array('a' => __('Home Cis'), 'b' => __('Home Trans'), 'c' => __('Dona Cis'), 'd' => __('Dona Trans'), 'e' => __('Persona No Binaria'), 'f' => __('Altres/Prefereixo no respondre')),
            'label'  => __("GÈNERE"),
            'required' => true
        ),
        'billing_gender_no_mixta' => array(
            'type' => 'select',
            'class' => array('form-row-wide'),
            'options' => array('a' => ('Home Trans'), 'b' => __('Dona Cis'), 'c' => __('Dona Trans'), 'd' => __('Persona No Binaria'), 'e' => __('Altres/Prefereixo no respondre')),
            'label'  => __("GÈNERE"),
            'required' => true,
        )
    );

    return $fields;
}
add_filter('woocommerce_checkout_fields', 'elmercatcultural_filter_checkout_fields');



function elmercatcultural_extra_checkout_fields()
{
    foreach (WC()->cart->get_cart() as $cart_item) {
        // Get the WC_Product object (instance)
        $product = $cart_item['data'];
        $meta = get_post_meta($product->get_id());
    }

    // because of this foreach, everything added to the array in the previous function will display automagically
    if (!isset($meta['genere'])) {
        return;
    }
    if ($meta['genere'][0] == 'Activitat per a homes cis') : ?>
        <div class="extra-fields">
            <?php woocommerce_form_field('billing_gender_mixta', array(
                'type' => 'select',
                'class' => array('form-row-wide'),
                'options' => array('Home Cis' => 'Home Cis', 'Home Trans' => 'Home Trans', 'Dona Cis' => 'Dona Cis', 'Dona Trans' => 'Dona Trans', 'Persona No Binaria' => 'Persona No Binaria', 'Altres/Prefereixo no respondre' => 'Altres/Prefereixo no respondre'),
                'label'  => __("GÈNERE"),
                'required' => true,
            )); ?>
        </div>
    <?php elseif ($meta['genere'][0] == 'Activitat no mixta') : ?>
        <div class="extra-fields">
            <?php woocommerce_form_field('billing_gender_no_mixta', array(
                'type' => 'select',
                'class' => array('form-row-wide'),
                'options' => array('Home Trans' => 'Home Trans', 'Dona Cis' => 'Dona Cis', 'Dona Trans' => 'Dona Trans', 'Persona No Binaria' => 'Persona No Binaria', 'Altres/Prefereixo no respondre' => 'Altres/Prefereixo no respondre'),
                'label'  => __("GÈNERE"),
                'required' => true,
            )); ?>
        </div>
    <?php endif;
}
add_action('woocommerce_checkout_after_customer_details', 'elmercatcultural_extra_checkout_fields');

/** Save the extra data */

function elmercatcultural_save_extra_checkout_fields($order, $data)
{

    // don't forget appropriate sanitization if you are using a different field type
    if (isset($data['billing_gender_mixta'])) {
        $note = sanitize_text_field($data['billing_gender_mixta']);
        $order->update_meta_data('billing_gender_mixta', $note);
        // $order->add_order_note( $note );
        // $order->save();
    }
    if (isset($data['billing_gender_no_mixta'])) {
        $note = sanitize_text_field($data['billing_gender_no_mixta']);
        $order->update_meta_data('billing_gender_no_mixta', $note);
        // $order->add_order_note( $note );
        // $order->save();
    }
}
add_action('woocommerce_checkout_create_order', 'elmercatcultural_save_extra_checkout_fields', 10, 2);



/** Display extra data in admin */

function elmercatcultural_display_order_data_in_admin($order)
{
    if ($order->get_meta('billing_gender_mixta')) : ?>
        <h4><?php _e('Informació sobre el gènere de la persona inscrita', 'woocommerce'); ?></h4>

    <?php
        echo '<p><strong>' . __('Gènere') . ':</strong>' . $order->get_meta('billing_gender_mixta') . '</p>';
    elseif ($order->get_meta('billing_gender_no_mixta')) : ?>
        <h4><?php _e('Informació sobre el gènere de la persona inscrita', 'woocommerce'); ?></h4>
<?php echo '<p><strong>' . __('Gènere') . ':</strong>' . $order->get_meta('billing_gender_no_mixta') . '</p>';
    endif;
}
add_action('woocommerce_admin_order_data_after_order_details', 'elmercatcultural_display_order_data_in_admin');

/**
 * ADD CHECKBOX FIELD AND WARNING FOR PRIVACY POLICY
 */
add_action('woocommerce_review_order_before_submit', 'elmercatcultural_add_checkout_checkbox', 10);
/**
 * Add WooCommerce additional Checkbox checkout field
 */
function elmercatcultural_add_checkout_checkbox()
{

    woocommerce_form_field('privacy_checkbox', array( // CSS ID
        'type'          => 'checkbox',
        'class'         => array('emc_privacy_checkbox'), // CSS Class
        'label_class'   => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox'),
        'input_class'   => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
        'required'      => true, // Mandatory or Optional
        'label'         => "Accepto la <a href='/politica-de-privacitat' target='_blank' rel='noopener'>Política de Privacitat</a>. Les dades personals s'utilitzaran per processar la comanda, millorar l'experiència d'usuari en aquest lloc web.", // Label and Link
    ));
    woocommerce_form_field('newsletter_checkbox', array( // CSS ID
        'type'          => 'checkbox',
        'class'         => array('emc_newsletter_checkbox'), // CSS Class
        'label_class'   => array('woocommerce-form__label woocommerce-form__label-for-checkbox newsletter'),
        'input_class'   => array('woocommerce-form__input woocommerce-form__input-checkbox newsletter-checkbox'),
        'required'      => false, // Mandatory or Optional
        'label'         => "Vull rebre els correus de elMercat i subscriure'm a la newsletter", // Label and Link
    ));
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
    $isvalid = true;
    // Check if set, if its not set add an error.
    if (!$_POST['billing_first_name']) {
        $isvalid = false;
        wc_add_notice(__('És obligatori introduir el NOM'), 'error');
    }
    if (!$_POST['billing_last_name']) {
        $isvalid = false;
        wc_add_notice(__('És obligatori introduir els COGNOMS'), 'error');
    }

    if (!$_POST['billing_email']) {
        $isvalid = false;
        wc_add_notice(__('És obligatori introduir un CORREU ELECTRÒNIC vàlid'), 'error');
    }
    if (!$_POST['billing_neighbour']) {
        $isvalid = false;
        wc_add_notice(__('És obligatori marcar una opció a la pregunta VEÏNA DELS BARRIS DE MUNTANYA?'), 'error');
    }
    if (!$_POST['billing_DNI']) {
        $isvalid = false;
        wc_add_notice(__('És obligatori introduir el DNI'), 'error');
    } else {
        $validation = elmercatcultural_validate_id($_POST['billing_DNI']);
        if (!$validation['valid']) {
            $isvalid = false;
            wc_add_notice(__('El valor del camp DNI és invàlid'), 'error');
        }
    }
    if (!$_POST['billing_birthday']) {
        $isvalid = false;
        wc_add_notice(__('És obligatori introduir la DATA DE NAIXEMENT'), 'error');
    } else {
        $dateFormat = '/^\d{2}\/[0-1]{1}[1-9]{1}\/\d{4}$/';
        if (!preg_match($dateFormat, $_POST['billing_birthday'])) {
            $isvalid = false;
            wc_add_notice(__('El valor del camp DATA DE NAIXEMENT és invàlid'), 'error');
        }
    }
    if (!isset($_POST['privacy_checkbox'])) {
        $isvalid = false;
        wc_add_notice(__("Heu d'acceptar la política de privadesa"), 'error');
    }
    if ($isvalid && isset($_POST['newsletter_checkbox'])) {
        try {
            elmercatcultural_submit_email_to_newsletter();
        } catch (Exception $e) {
            wc_add_notice(__("No us heu pogut subscriure a la Newsletter: " . $e->getMessage()), 'notice');
        }
    }
}

add_action('woocommerce_checkout_update_order_meta', 'elmercatcultural_update_order_meta');
function elmercatcultural_update_order_meta($order_id)
{
    if (!empty($_POST['billing_birthday'])) {
        update_post_meta($order_id, 'DATA NAIXEMENT', sanitize_text_field($_POST['customised_field_name']));
    }
}

function elmercatcultural_submit_email_to_newsletter()
{
    $WP_Http = new WP_Http();
    $response = $WP_Http->request(
        "https://elmercatcultural.us11.list-manage.com/subscribe/post?u=6cddc765d60db6bb166e55534&id=77f622e665&f_id=002990e0f0",
        //"/wp-json/myplugin/v1/newsletter/post",
        array(
            'method' => 'POST',
            'body' => 'EMAIL=' . $_POST['billing_email'],
            'httpversion' => '1.0',
            'user-agent' => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:109.0) Gecko/20100101 Firefox/111.0',
            'headers' => array(
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Origin' => 'https://elmercatcultural.cat',
                'Host' => 'elmercatcultural.us11.list-manage.com',
                'Referer' => 'https://elmercatcultural.cat/',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',

                'Accept-Language' => 'en-US,en;q=0.5',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Cache-Control' => 'no-cache',
                'Connection' => 'keep-alive'
            )
        )
    );
    if ($response['response']['code'] != 200) {
        throw new Exception("Subscription error " . $response['response']['code']);
    }
}

//SHOW CASH ON DELIVERY PAYMENT METHOD WHEN ADMIN ONLY//
// define the woocommerce_available_payment_gateways callback 
function filter_woocommerce_available_payment_gateways($available_gateways)
{
    $delete = false;
    foreach ($available_gateways as $key => $gateway) {
        if ($gateway->title === "Pagament contra reemborsament" && !current_user_can('manage_options')) {
            unset($available_gateways[$key]);
            break;
        }
    }
    return $available_gateways;
};

// add the filter 
add_filter('woocommerce_available_payment_gateways', 'filter_woocommerce_available_payment_gateways', 10, 1);


/********************************************************************************************************* */
//TEST HTTP REQUEST//

// add_action('rest_api_init', function () {
//     register_rest_route('myplugin/v1', '/newsletter/post', array(
//         'methods' => 'GET',
//         'callback' => 'my_awesome_func',
//         'permission_callback' => '__return_true'
//     ));
// });
// function my_awesome_func($request)
// {
//     $WP_Http = new WP_Http();
//     $response = $WP_Http->request(
//         "https://elmercatcultural.us11.list-manage.com/subscribe/post?u=6cddc765d60db6bb166e55534&id=77f622e665&f_id=002990e0f0",
//         //"/wp-json/myplugin/v1/newsletter/post",
//         array(
//             'method' => 'POST',
//             'body' => 'EMAIL=',
//             'httpversion' => '1.0',
//             'user-agent' => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:109.0) Gecko/20100101 Firefox/111.0',
//             'headers' => array(
//                 'Content-Type' => 'application/x-www-form-urlencoded',
//                 'Origin' => 'https://elmercatcultural.cat',
//                 'Host' => 'elmercatcultural.us11.list-manage.com',
//                 'Referer' => 'https://elmercatcultural.cat/',
//                 'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
//                 'Accept-Language' => 'en-US,en;q=0.5',
//                 'Accept-Encoding' => 'gzip, deflate, br',
//                 'Cache-Control' => 'no-cache',
//                 'Connection' => 'keep-alive'
//             )
//         )
//     );
//     //return print_r($response[request]);
//     return print_r($response);
//     //     $posts = get_posts(array(
//     //         'author' => $request['id'],
//     //     ));

//     //     if (empty($posts)) {
//     //         return null;
//     //     }

//     //     return $posts[0]->post_title;
// }
// add_action('http_api_debug', 'retrive_api_request', 10, 5);

// function retrive_api_request($respose, $context, $class, $parsed_args, $url)
// {
//     echo print_r($parsed_args);
// }

/*test */

add_action('woocommerce_review_order_after_cart_contents', 'elmercatcultural_test');

function elmercatcultural_test()
{
    if (WC()->cart->get_coupons()) {
        echo '<tr class="cart-item"><td class="product-name">' . esc_html('Total Cistella amb descompte', 'woocommerce') . '</td>';
        echo '<td class="product-name">' . apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_cart_total()) . '</td></tr>';
    } else {
        echo '<tr class="cart-item"><td class="product-name">' . esc_html('Total Cistella', 'woocommerce') . '</td>';
        echo '<td class="product-name">' . apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_cart_total()) . '</td></tr>';
    }
}


// add_action('woocommerce_order_status_changed', 'elmercatcultural_submit_email_to_newsletter');
// function elmercatcultural_submit_email_to_newsletter()
// {
//     if (isset($_POST['newsletter_checkbox'])) {
//         // throw new Exception('Això és un error');
//         // $url = 'URL';
//         // $data = array('EMAIL' => $_POST['billing_email']);
//         // $options = array(
//         //     'http' => array(
//         //         'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
//         //         'method'  => 'POST',
//         //         'content' => http_build_query($data),
//         //     )
//         // );

//         // $context  = stream_context_create($options);
//         // $result = file_get_contents($url, false, $context);
//         // var_dump($result);
//     }
// }


// add_action('woocommerce_after_checkout_validation', 'elmercatcultural_submit_email_to_newsletter', 9999, 2);
// function elmercatcultural_submit_email_to_newsletter($fields, $errors)
// {
//     if (empty($errors->get_error_codes()) && isset($_POST['newsletter_checkbox'])) {
//         wc_add_notice(__('Error'), 'error');
//     }
// }

/* 
++++++++++++++++
THANK YOU SECTION 
++++++++++++++++
*/

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
    return 'Benvolgudes, gràcies per realitzar la inscripció a elMercat';
}

add_action('after_setup_theme', 'elmercatcultural_add_woocommerce_support');

add_filter('woocommerce_order_button_text', 'elmercatcultural_order_button_text');
function elmercatcultural_order_button_text($text)
{
    return $text;
}
