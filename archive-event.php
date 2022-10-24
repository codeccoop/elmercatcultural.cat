<?php

/**
 * Template Name: Graella Programació
 *
 * @package elmercatcultural.cat
 */
get_header();
?>
<main id="event-archive" class="site-main archive">
    <header class="page-header">
        <h2 class="page-title"><?= get_the_title() ?></h2>
        <p class="page-description">
            <?= get_the_content() ?>
        </p>
    </header><!-- .page-header -->
    <div class="page-content">
        <nav class="event-archive__filters archive__filters">
            <span>Filtra per categoria d'espectacle:</span>
            <a data-term="all" class="small underline event-archive__filter archive__filter async-filter">Tots</a>
            <a data-term="espectacles-i-concerts" class="small underline event-archive__filter archive__filter async-filter">Espectacles i <br> concerts</a>
            <a data-term="xerrades-cineforums" class="small underline event-archive__filter archive__filter async-filter">Xerrades i <br> Cinefòrums</a>
            <a data-term="cicles" class="small underline event-archive__filter archive__filter async-filter">Cícles</a>
        </nav>
        <div class="event-archive__grid archive__grid async-grid">
        </div>
        <nav class="event-archive__pagination">
            <ul class="event-archive__pages async-pager"></ul>
        </nav>
    </div>
    <?php
    /* Start the Loop */
    ?>
</main><!-- #main -->
<?php
get_footer();
