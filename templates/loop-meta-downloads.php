<div class="loop-meta">

    <?php if ($wrap) echo apply_filters('hcf_edd_open_loop_meta_wrap', '<div class="wrap">'); ?>

    <?php if (is_tax('download_category') || is_tax('download_tag')) { ?>

        <h1 class="loop-title"><?php single_term_title(); ?></h1>

        <div class="loop-description">
            <?php echo term_description('', get_query_var('taxonomy')); ?>
            <?php if (function_exists('hcf_edd_downloads_menu')) hcf_edd_downloads_menu(); ?>
        </div><!-- .loop-description -->

    <?php } elseif (is_post_type_archive('download')) { ?>

        <?php $post_type = get_post_type_object(get_query_var('post_type')); ?>

        <h1 class="loop-title"><?php post_type_archive_title(); ?></h1>

        <div class="loop-description">
            <?php if (!empty($post_type->description)) echo wpautop($post_type->description); ?>
            <?php if (function_exists('hcf_edd_downloads_menu')) hcf_edd_downloads_menu(); ?>
        </div><!-- .loop-description -->

    <?php } ?>

    <?php if ($wrap) echo apply_filters('hcf_edd_close_loop_meta_wrap', '</div><!-- .wrap -->'); ?>

</div><!-- .loop-meta -->