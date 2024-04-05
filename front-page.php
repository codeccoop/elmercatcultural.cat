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
            'order' => 'ASC'
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
                    <?php
                    $ID = get_the_ID();
                    $imageURL = get_the_post_thumbnail_url(get_the_ID());
                    $text = get_field('text', $ID);
                    $URL = get_field('url', $ID);
                    ?>
                    <figure class="front-page__jumbotron-item">
                        <? if ($URL) : ?>
                            <a href="<?= $URL; ?>">
                                <img src="<?= $imageURL; ?>" />
                                <figcaption class="title is-3"><?= $text; ?></figcaption>
                            </a>
                        <? else : ?>
                            <img src="<?= $imageURL; ?>" /></a>
                            <figcaption class="title is-3"><?= $text; ?></figcaption>
                        <? endif; ?>
                    </figure>
            <?php endwhile;
            endif; ?>
        </div>
    </section>
    <section id="barris" class="front-page__section">
        <div class="front-page__highlight-links">
            <?php
            $links = get_field('links', $page_ID);
            ?>
            <div class="front-page__highlight-link">
                <a href="<?= $links['link-1']['url']; ?>">
                    <span class="underline"><?= $links['link-1']['text']; ?></span>
                </a>
            </div>
            <div class="front-page__highlight-link">
                <a href="<?= $links['link-2']['url']; ?>">
                    <span class="underline"><?= $links['link-2']['text']; ?></span>
                </a>
            </div>
            <div class="front-page__highlight-link">
                <a href="<?= $links['link-3']['url']; ?>">
                    <span class="underline"><?= $links['link-3']['text']; ?></span>
                </a>
            </div>
        </div>
        <div class="front-page__section-content">
            <?php $section = get_field('section-1', $page_ID); ?>
            <h2><?= $section['title']; ?></h2>
            <p><?= $section['text']; ?></p>
            <a href="<?= $section['link']['url']; ?>" class="underline small"><?= $section['link']['text'] ?></a>
        </div>
    </section>
    <section id="participa" class="front-page__section">
        <div class="front-page__section-content">
            <?php $section = get_field('section-2', $page_ID); ?>
            <h2><?= $section['title']; ?></h2>
            <p><?= $section['text']; ?></p>
            <a href="<?= $section['link']['url']; ?>" class="underline small"><?= $section['link']['text'] ?></a>
        </div>
    </section>
</main>
<?php
get_footer();
