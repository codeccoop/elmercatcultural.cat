<?php

/**
 * Template Name: Graella Tallers
 *
 * @package elmercatcultural.cat
 */
get_header();
?>
<main id="workshop-archive" class="site-main archive">
    <header class="page-header">
        <h2 class="page-title"><?= get_the_title() ?></h2>
        <p class="page-description">
            <?= get_the_excerpt() ?>
        </p>
    </header><!-- .page-header -->
    <nav class="workshop-archive__filters archive__filters">
        Filtra per categoria d'espectacle:
        <a data-term="all" class="workshop-archive__filter archive__filter async-filter">Tots</a>
        <a data-term="comunitari" class="workshop-archive__filter archive__filter async-filter">Comunitari</a>
        <a data-term="cultura" class="workshop-archive__filter archive__filter async-filter">Cultura</a>
        <a data-term="ecosocial" class="workshop-archive__filter archive__filter async-filter">Ecosocial</a>
    </nav>
    <div class="workshop-archive__grid async-grid">
    </div>
    <nav class="workshop-archive__pagination">
        <ul class="workshop-archive__pages async-pager"></ul>
    </nav>
    <?php
    /* Start the Loop */
    ?>
</main><!-- #main -->
<?php
get_footer();
