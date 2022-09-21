<?php

/**
 * Template Name: Graella Programació
 *
 * @package elmercatcultural.cat
 */
wp_enqueue_script('async-grid');
get_header();
?>
<main id="event-archive" class="site-main archive">
    <header class="page-header">
        <h1 class="page-title"><?= get_the_title() ?></h1>
        <p class="page-subtitle subtitle">
            <?= get_the_excerpt() ?>
        </p>
    </header><!-- .page-header -->
    <nav class="event-archive__filters archive__filters">
        Filtra per categoria d'espectacle:
        <a data-term="all" class="event-archive__filter archive__filter async-filter">Tots</a>
        <a data-term="espectacles-i-concerts" class="event-archive__filter archive__filter async-filter">Espectacles i concerts</a>
        <a data-term="xerrades-cineforums" class="event-archive__filter archive__filter async-filter">Xerrades - Cinefòrums</a>
        <a data-term="cicles" class="event-archive__filter archive__filter async-filter">Cícles</a>
    </nav>
    <div class="event-archive__grid async-grid">
    </div>
    <nav class="event-archive__pagination">
        <ul class="event-archive__pages async-pager"></ul>
    </nav>
    <?php
    /* Start the Loop */
    ?>
</main><!-- #main -->
<?php
get_footer();
