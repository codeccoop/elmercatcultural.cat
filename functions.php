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
    define('ELMERCATCULTURAL_VERSION', '2.6.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
add_action('after_setup_theme', 'setup');
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

add_action('init', 'emc_initialize_theme');
function emc_initialize_theme()
{
    register_taxonomy_for_object_type('post_tag', 'page');
}

add_action('admin_menu', 'emc_admin_init');
function emc_admin_init()
{
    remove_menu_page('edit.php?post_type=product');
}

add_action('pre_get_posts', 'emc_tags_support_query');
function emc_tags_support_query($wp_query)
{
    if ($wp_query->get('tag')) {
        $wp_query->set('post_type', 'any');
    }
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
add_action('after_setup_theme', 'content_width', 0);
function content_width()
{
    $GLOBALS['content_width'] = apply_filters('content_width', 640);
}

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
add_action('widgets_init', 'widgets_init');
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

/**
 * Enqueue scripts and styles.
 */
add_action('wp_enqueue_scripts', 'scripts');
add_action('admin_enqueue_scripts', 'scripts');
function scripts()
{
    wp_register_script('leaflet-js', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', ['jquery'], '1.9.4');
    wp_register_style('leaflet-css', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', [], '1.9.4');

    if (is_admin()) {
        return;
    }

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
    } elseif (is_page(array('programacio', 'tallers'))) {
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
require get_template_directory() . '/shortcodes/feed.php';

/* Custom Post Types */
require get_template_directory() . '/post_types/destacat.php';
require get_template_directory() . '/post_types/event.php';
require get_template_directory() . '/post_types/workshop.php';

/* AJAX actions */
require get_template_directory() . '/ajax/async-grid.php';

/* Store */
require get_template_directory() . '/inc/store/index.php';

/* ACF */
require get_template_directory() . '/acf/event.php';
require get_template_directory() . '/acf/destacats.php';
require get_template_directory() . '/acf/portada.php';

function emc_is_admin()
{
    $user = wp_get_current_user();
    $roles = (array) $user->roles;
    return in_array('administrator', $roles);
}

add_action('wp_head', 'emc_ga_analytics');
function emc_ga_analytics()
{
    ?>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-HSNR4W1VZ8"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-HSNR4W1VZ8');
    </script>
<?php
}

add_action('admin_menu', function () {
    add_options_page(
        'elMercat',
        'elMercat',
        'manage_options',
        'emc',
        'emc_menu_render'
    );
});

function emc_menu_render()
{
    ?>
    <div class="wrap">
        <h1>elMercat</h1>
        <form action="options.php" method="post">
        <?php
        settings_fields('emc');
    do_settings_sections('emc');
    submit_button();
    ?>
        </form>
    </div>
    <?php
}

add_action('admin_init', function () {
    register_setting(
        'emc',
        'emc-inscriptions',
        [
            'type' => 'string',
            'show_in_rest' => false,
            'defaults' => [
                'waiting-list' => '#'
            ]
        ],
    );

    add_settings_section(
        'emc-inscriptions-section',
        __('Inscripcions', 'emc'),
        function () {
            echo '<p>Configuració general de les inscripcions</p>';
        },
        'emc',
    );

    add_settings_field(
        'waiting-list',
        __('Llista d\'espera', 'emc'),
        function () {
            $inscriptions = get_option('emc-inscriptions', []);
            echo "<input type='text' name='emc-inscriptions[waiting-list]' value='{$inscriptions['waiting-list']}' />";
        },
        'emc',
        'emc-inscriptions-section'
    );
});

function emc_get_post_by_name($name, $post_type = 'post')
{
    $posts = get_posts(['post_type' => $post_type, 'name' => $name]);
    if (count($posts)) {
        return $posts[0];
    }
}

add_action('init', function () {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_GET['action']) || !$_GET['action'] === 'emc-newsletter-signup') {
        return;
    }

    if (!empty($_POST['contact_name'])) {
        $contact_name = $_POST['contact_name'];
        if ($contact_email = filter_var($_POST['contact_email'], FILTER_VALIDATE_EMAIL)) {
            $contact_email = $_POST['contact_email'];
            $lead = [
                'email' => $contact_email,
                'attributes' => ['NOMBRE' => $contact_name],
                'includeListIds' => [2],
                'redirectionUrl' => get_bloginfo('url') . '/gracies',
                'templateId' => 5,
            ];

            $res = wp_remote_request('https://api.brevo.com/v3/contacts/doubleOptinConfirmation', [
                'method' => 'POST',
                'headers' => [
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                    'api-key' => BREVO_API_KEY,
                ],
                'body' => json_encode($lead, JSON_UNESCAPED_UNICODE),
            ]);

            if (!is_wp_error($res) && $res['response']['code'] < 300) {
                wp_send_json(['success' => true]);
            }
        }
    }

    wp_send_json(['success' => false]);
});
