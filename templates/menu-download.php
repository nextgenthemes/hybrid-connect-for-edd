<?php if (has_nav_menu('download')) { ?>

    <?php wp_nav_menu(
        array(
            'theme_location' => 'download',
            'container' => 'div',
            'container_id' => 'menu-download',
            'container_class' => '',
            'menu_id' => 'menu-download-items',
            'menu_class' => 'menu-items',
            'depth' => 1,
            'fallback_cb' => ''
        )
    ); ?>

<?php } else { ?>

    <div id="menu-download">
        <ul id="menu-download-items" class="menu-items">
            <?php $type = get_post_type_object('download'); ?>

            <li <?php echo is_post_type_archive('download') ? 'class="current-cat"' : ''; ?>>
                <a href="<?php echo get_post_type_archive_link('download'); ?>">
                    <?php echo(isset($type->labels->archive_title) ? $type->labels->archive_title : $type->labels->name); ?>
                </a>
            </li>

            <?php wp_list_categories(
                array(
                    'taxonomy' => is_tax('download_tag') ? 'download_tag' : 'download_category',
                    'depth' => 1,
                    'hierarchical' => false,
                    'show_option_none' => false,
                    'title_li' => false
                )
            ); ?>
        </ul>
    </div>

<?php } ?>