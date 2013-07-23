<div id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

    <?php if (current_theme_supports('get-the-image')) get_the_image(array('size' => 'download-large', 'image_scan' => true)); ?>

    <?php the_title('<h2 class="entry-title"><a href="' . get_permalink() . '">', '</a></h2>'); ?>

    <div class="entry-summary">
        <?php the_excerpt(); ?>
    </div>
    <!-- .entry-summary -->

</div><!-- .hentry -->