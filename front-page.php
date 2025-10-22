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
<?php echo do_shortcode('[superblockslider id="6813"]'); ?>
 <section id="feed" class="front-page__section">
        <div class="front-page__section-content">
            <div class="front-page__feed">
                <?= do_shortcode('[emc_feed post_type="event"]') ?>
                <p><a class="underline small" href="/programacio">Programació cultural</a></p>
            </div> 
            <hr> 
            <div class="front-page__feed">
                <?= do_shortcode('[emc_feed post_type="workshop"]') ?>
                <p><a class="underline small" href="/tallers">Tallers i bocins</a></p>
            </div>
        </div>
    </section>
    <section id="barris" class="front-page__section">
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
