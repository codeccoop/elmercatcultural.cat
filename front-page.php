<?php

/**
 * Fornt-page elmercatcultural.cat
 *
 * This is the template for the front-page for the elmercatcultural project
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package elmercatcultural.cat
 */
get_header();
?>
<main class="front-page">
    <section id="cover" class="front-page__section">
        <?php
        $args = array(
            'post_type' => 'destacat',
            'post_status' => 'publish',
            'posts_per_page' => 4,
            'orderby' => 'date',
            'order' => 'DESC'
        );
        $loop = new WP_Query($args);
        ?>
        <div class="front-page__jumbotron">
            <h1>El Mercat</h1> 
            <?php if ($loop->post_count == 0) : ?>
                <img class="front-page__jumbotron-static" src="<?= get_template_directory_uri() . '/assets/images/jumbotron--default.png'; ?>" />
        <?php else : while ($loop->have_posts()) : $loop->the_post(); ?>
            <img class="front-page__jumbotron-slider" src="<?= get_the_post_thumbnail_url(get_the_ID()); ?>" />
            <?php endwhile; endif; ?>
        </div>
    </section>
    <section id=" destacats" class="front-page__section">
                <h1>DESTACATS</h1>
    </section>
    <section id="participa" class="front-page__section">
        <h1>PARTICIPA</h1>
    </section>
</main>
<?php
get_footer();
