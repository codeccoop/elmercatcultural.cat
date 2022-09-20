<?php

/**
 * Template Name: Graella Programació
 *
 * @package elmercatcultural.cat
 */
wp_enqueue_script('async-grid');
get_header();
?>
<main id="event-archive" class="site-main">
    <header class="page-header">
        <?php
        the_archive_title('<h1 class="page-title">', '</h1>');
        the_archive_description('<div class="archive-description">', '</div>');
        ?>
    </header><!-- .page-header -->
    <nav class="event-archive__filters">
        <button data-term="all" class="event-archive__filter async-filter">Tots</button>
        <button data-term="espectacles-i-concerts" class="event-archive__filter async-filter">Espectacles i concerts</button>
        <button data-term="xerrades-cineforums" class="event-archive__filter async-filter">Xerrades - Cinefòrums</button>
        <button data-term="cicles" class="event-archive__filter async-filter">Cícles</button>
    </nav>
    <div class="event-archive__grid events-grid">
    </div>
    <nav class="event-archive__pagination">
        <ul class="event-archive__pages async-pager"></ul>
    </nav>
    <?php
    /* Start the Loop */
    ?>
</main><!-- #main -->
<?php
get_sidebar();
get_footer();
