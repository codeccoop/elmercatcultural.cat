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
        <h1 class="page-title"><?= get_the_title() ?></h1>
        <p class="page-description">
            <?= get_the_content() ?>
        </p>
    </header><!-- .page-header -->
    <nav class="workshop-archive__filters archive__filters">
        <span>Filtra per categoria d'espectacle:</span>
        <a data-term="all" class="small underline workshop-archive__filter archive__filter async-filter">Tots</a>
        <a data-term="comunitari" class="small underline workshop-archive__filter archive__filter async-filter">Comunitari</a>
        <a data-term="cultura" class="small underline workshop-archive__filter archive__filter async-filter">Cultura</a>
        <a data-term="ecosocial" class="small underline workshop-archive__filter archive__filter async-filter">Ecosocial</a>
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
