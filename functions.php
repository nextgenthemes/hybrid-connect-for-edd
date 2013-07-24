<?php

/**
 * Display the portfolio menu.
 *
 * @since  0.1.0
 */
function hcf_edd_download_menu()
{
    if (!locate_template('menu-download.php', true, false)) {

        // if no template found output the default one
        require(HCF_EDD_TEMPLATES_DIR . 'menu-download.php');
    }
}

/**
 * Checks if exists a loop-meta to be displayed.
 *
 * @since  0.1.0
 */
function hcf_edd_has_loop_meta()
{
    return is_post_type_archive('download') || is_tax('download_category') || is_tax('download_tag');
}

/**
 * Display loop-meta.
 *
 * @since  0.1.0
 */
function hcf_edd_loop_meta($wrap = false)
{
    if (!locate_template('loop-meta-downloads.php', true, false)) {

        // if no template found output the default one
        require(HCF_EDD_TEMPLATES_DIR . 'loop-meta-downloads.php');
    }
}

/**
 * Display wrapped loop-meta.
 *
 * @since  0.1.0
 */
function hcf_edd_wrapped_loop_meta()
{

    hcf_edd_loop_meta(true);
}

/**
 * Display some downloads.
 *
 * @since  0.1.0
 */
function hcf_edd_downloads()
{
    $loop = new WP_Query(
        array(
            'post_type' => 'download',
            'posts_per_page' => apply_filters('hcf_edd_downloads_per_page', 0),
        )
    );

    if ($loop->have_posts()) {
        while ($loop->have_posts()) {
            $loop->the_post();

            if (!locate_template('content-download.php', true, false)) {

                // if no template found output the most simple template as possible
                require(HCF_EDD_TEMPLATES_DIR . 'content-download.php');
            }
        }
    }
    ?>

<?php
}