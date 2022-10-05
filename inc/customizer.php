<?php

/**
 * elmercatcultural.cat Theme Customizer
 *
 * @package elmercatcultural.cat
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function customize_register($wp_customize)
{
    $wp_customize->get_setting('blogname')->transport         = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial(
            'blogname',
            array(
                'selector'        => '.site-title a',
                'render_callback' => 'customize_partial_blogname',
            )
        );
        $wp_customize->selective_refresh->add_partial(
            'blogdescription',
            array(
                'selector'        => '.site-description',
                'render_callback' => 'customize_partial_blogdescription',
            )
        );
    }

    /* Footer Customizer */
    $wp_customize->add_section('footer', array(
        'title' => 'Peu de pàgina',
        # 'description' => 'Informació de contacte i altres',
        'priority' => 60
    ));

    $wp_customize->add_setting('contact', array(
        'type' => 'theme_mod',
        'sanitize_callback' => 'sanitize_textarea_field',
        'default' => 'Carrer d\'Elisa Moragues i Badia, 3\n08017 Barcelona'
    ));
    $wp_customize->add_setting('open_hours', array(
        'type' => 'theme_mod',
        'sanitize_callback' => 'sanitize_textarea_field',
        'default' => 'De 10 a 14h i de 17 a 21h'
    ));
    $wp_customize->add_setting('coordinates', array(
        'type' => 'theme_mod',
        'sanitize_callback' => 'sanitize_text_field',
        'default' => '41.399647 2.149845'
    ));

    $wp_customize->add_control('contact', array(
        'type' => 'textarea',
        'priority' => 5,
        'label' => 'Contacte',
        'description' => 'Adreça, correu electrònic i telèfon',
        'section' => 'footer'
    ));
    $wp_customize->add_control('open_hours', array(
        'type' => 'textarea',
        'priority' => 5,
        'label' => 'Horari',
        'description' => 'Hores d\'obertura i tancament',
        'section' => 'footer'
    ));
    $wp_customize->add_control('coordinates', array(
        'type' => 'text',
        'priority' => 5,
        'label' => 'Coordenades de l\'edifici',
        'description' => 'Hores d\'obertura i tancament',
        'section' => 'footer'
    ));
}
add_action('customize_register', 'customize_register');

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function customize_partial_blogname()
{
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function customize_partial_blogdescription()
{
    bloginfo('description');
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function customize_preview_js()
{
    wp_enqueue_script('elmercatcultural.cat-customizer', get_template_directory_uri() . '/js/customizer.js', array('customize-preview'), ELMERCATCULTURAL_VERSION, true);
}
add_action('customize_preview_init', 'customize_preview_js');
