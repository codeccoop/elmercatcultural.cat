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
$page_ID = get_option('page_on_front');
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
            $links = get_field('links', $page_ID);
            ?>
            <div class="front-page__highlight-link">
                <a href="<?= $links['link-1']['url']; ?>">
                    <?= $links['link-1']['text']; ?>
                </a>
            </div>
            <div class="front-page__highlight-link">
                <a href="<?= $links['link-2']['url']; ?>">
                    <?= $links['link-2']['text']; ?>
                </a>
            </div>
            <div class="front-page__highlight-link">
                <a href="<?= $links['link-3']['url']; ?>">
                    <?= $links['link-3']['text']; ?>
                </a>
            </div>
        </div>
        <div class="front-page__section-content">
            <?php $section = get_field('section-1', $page_ID); ?>
            <h2><?= $section['title']; ?></h2>
            <p><?= $section['text']; ?></p>
            <a href="<?= $section['link']['url']; ?>" class="button"><?= $section['link']['text'] ?></a>
        </div>
    </section>
    <section id="participa" class="front-page__section">
        <div class="front-page__section-content">
            <?php $section = get_field('section-2', $page_ID); ?>
            <h2><?= $section['title']; ?></h2>
            <p><?= $section['text']; ?></p>
            <a href="<?= $section['link']['url']; ?>" class="button"><?= $section['link']['text'] ?></a>
        </div>
    </section>
</main>
<?php
get_footer();
