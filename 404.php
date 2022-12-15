<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package elmercatcultural.cat
 */

get_header();
?>

<main id="primary" class="site-main">

    <section class="error-404 not-found">
        <header class="page-header">
            <h1 class="page-title">Alguna cosa ha anat malament :(</h1>
        </header><!-- .page-header -->

        <div class="page-content">
            <p>No trobem cap contingut associat a aquesta ruta. Si has introduit manualment l'enllaç, comproba que no hi hagi cap error. Si creus que és un error de la pàgina, pots possar-te en contacte amb nosaltres a través del nostre correu <a href="mailto:info@elmercatcultural.cat" class="underline">info@elmercatcultural.cat</a></p>
            <p class="return-to-shop">
                <a class="button wc-backward<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>" href="/">
                    Tornar a l'inici
                </a>
            </p>
        </div><!-- .page-content -->
    </section><!-- .error-404 -->

</main><!-- #main -->

<?php
get_footer();
