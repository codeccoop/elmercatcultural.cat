<?php

/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package elmercatcultural.cat
 */

?>


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="post-header">
        <?php $tags = wp_get_post_tags(get_the_ID());
        if (sizeof($tags) > 0) : ?>
            <p class="page-breadcrumb small"><?= $tags[0]->name; ?></p>
        <?php endif; ?>
        <?php the_title('<h2 class="post-title is-2">', '</h2>'); ?>
    </header><!-- .entry-header -->

    <div class="post-content">
        <?php $post_id = get_the_ID(); ?>
        <div class="post-content__inscription">
            <a class="small-title">INSCRIU-TE</a>
            <p class="event-bold small">DATES</p>
            <?php if (get_field('date', $post_id)) : ?>
                <p class="small"><?php the_field('date', $post_id); ?></p>
            <?php else : ?>
                
            <?php endif ?>
            <p class="event-bold small">SESSIONS</p>
            <p class="event-bold small">HORA</p>
            <p class="event-bold small">PREU</p>
            <p class="event-bold small">CATEGORIA</p>
            <p class="event-bold small">FITXA TÈCNICA</p>

        </div>
        <div class="post-content__description">
            <div class="description-text">
            <?php the_field('description_event', $post_id);?>
            </div>
            <?php
            $carroussel_event = get_field('carroussel_event', $post_id);
            $has_images=false;
            foreach ($carroussel_event as $item => $val){
                if($val!=null){
                    $has_images=true;
                }
            }
            if($has_images){?>
                    <div class="carroussel-container">
                        <div class="carroussel-content">
                        <?php 
                            if ($carroussel_event['image_carroussel_1']){
                                $image_carroussel_1 = $carroussel_event['image_carroussel_1'];
                                $carroussel_data_1 = wp_get_attachment_image_src($image_carroussel_1, 'full', false);?>
                                <div><img class="carroussel-image" src="<?php echo $carroussel_data_1[0]; ?>" alt="Imatge del carroussel"></div>
                            <?php }
                            if ($carroussel_event['image_carroussel_2']){
                                $image_carroussel_2 = $carroussel_event['image_carroussel_2'];
                                $carroussel_data_2 = wp_get_attachment_image_src($image_carroussel_2, 'full', false);?>
                                <div><img class="carroussel-image" src="<?php echo $carroussel_data_2[0]; ?>" alt="Imatge del carroussel"></div>
                            <?php }
                            if ($carroussel_event['image_carroussel_3']){
                                $image_carroussel_3 = $carroussel_event['image_carroussel_3'];
                                $carroussel_data_3 = wp_get_attachment_image_src($image_carroussel_3, 'full', false);?>
                                <div><img class="carroussel-image" src="<?php echo $carroussel_data_3[0]; ?>" alt="Imatge del carroussel"></div>
                            <?php }?>
                        </div>
                        <div class="slides-numbers">
                            <span class="active">1</span> / <span class="total"></span>
                        </div> 
                    </div>
                
                <?php }
            else {?>
                <div class="thumbnail-container">
                    <?php the_post_thumbnail(); ?>
                </div>
            <?php } ?>
        </div>

       
    </div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
