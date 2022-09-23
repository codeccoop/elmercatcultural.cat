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
// wp_enqueue_script('front-page');
get_header();
?>
<main class="front-page">
    <section id="highlights" class="front-page__section">
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
        <div class="front-page__jumbotron <?= $loop->post_count == 0 ? 'static' : 'slider'; ?>">
            <?php if ($loop->post_count == 0) : ?>
                <figure class="front-page__jumbotron-item">
                    <img src="<?= get_template_directory_uri() . '/assets/images/jumbotron--default.png'; ?>" />
                    <figcaption class="title">El Mercat Cultural</figcaption>
                </figure>
                <?php else : while ($loop->have_posts()) : $loop->the_post(); ?>
                    <figure class="front-page__jumbotron-item">
                        <img src="<?= get_the_post_thumbnail_url(get_the_ID()); ?>" />
                        <figcaption class="title is-3"><?= get_the_excerpt(get_the_ID()) ?></figcaption>
                    </figure>
            <?php endwhile;
            endif; ?>
        </div>
    </section>
    <?php /*
    <section id="highlight-links" class="front-page__section">
        <div class="front-page__highlight-links">
            <?php
            $programacio = get_page_by_title('programacio');
            $tallers = get_page_by_title('tallers');
            ?>
            <div class="front-page__highlight-link">
                <a href="<?= get_page_link($programacio); ?>">
                    Programació Cultural
                </a>
            </div>
            <div class="front-page__highlight-link">
                <a href="<?= get_page_link($tallers); ?>">
                    Tallers i cursos
                </a>
            </div>
        </div>
        </section> */ ?>
    <section id="barris" class="front-page__section">
        <div class="front-page__highlight-links">
            <?php
            $programacio = get_page_by_title('programacio');
            $tallers = get_page_by_title('tallers');
            ?>
            <div class="front-page__highlight-link">
                <a href="#">
                    Entitats del Mercat
                </a>
            </div>
            <div class="front-page__highlight-link">
                <a href="<?= get_page_link($programacio); ?>">
                    Programació Cultural
                </a>
            </div>
            <div class="front-page__highlight-link">
                <a href="<?= get_page_link($tallers); ?>">
                    Tallers i cursos
                </a>
            </div>
        </div>
        <div class="front-page__section-content">
            <h2>Barris de Muntanya</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eu fringilla metus. Phasellus in egestas eros, in efficitur ligula. Proin neque dolor, scelerisque ac mi vel, malesuada varius metus. Pellentesque lobortis maximus orci, at hendrerit tortor finibus non. Vivamus ac nulla vestibulum nisi auctor posuere a sit amet lectus. Nulla posuere nunc quam, et scelerisque nibh lobortis vel.</p>
            <?php $elmercat = get_page_by_title('pagina-exemple'); ?>
            <a href="/pagina-exemple/" class="button">Coneix-ne més</a>
        </div>
    </section>
    <section id="participa" class="front-page__section">
        <div class="front-page__section-content">
            <h2>Participa</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eu fringilla metus. Phasellus in egestas eros, in efficitur ligula. Proin neque dolor, scelerisque ac mi vel, malesuada varius metus. Pellentesque lobortis maximus orci, at hendrerit tortor finibus non. Vivamus ac nulla vestibulum nisi auctor posuere a sit amet lectus. Nulla posuere nunc quam, et scelerisque nibh lobortis vel.</p>
            <?php $participa = get_page_by_title('Pàgina d’exemple'); ?>
            <a href="/pagina-exemple/" class="button">Participa</a>
        </div>
    </section>
</main>
<?php
get_footer();
