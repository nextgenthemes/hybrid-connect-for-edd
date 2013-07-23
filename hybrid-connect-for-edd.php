<?php
/**
 * Plugin Name: Hybrid Connect For Easy Digital Downloads
 * Plugin URI: https://github.com/trsenna/hybrid-connect-for-edd
 * Description: Helps adding Easy Digital Downloads support on themes based in the hybrid-core framework.
 * Version: 0.1.0
 * Author: Thiago Senna
 * Author URI: http://thremes.com.br
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License as published by the Free Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @package HybridConnectForEDD
 * @version 0.1.0
 * @author Thiago Senna <thiago@thremes.com.br>
 * @copyright Copyright (c) 2012 - 2013, Thiago Senna
 * @link https://github.com/trsenna/hybrid-connect-for-edd
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Setup class to help with the Easy Digital Downloads support.
 *
 * @since  0.1.0
 */
class Hybrid_Connect_For_EDD
{
    private $excerpt_length = 20;
    private $downloads_per_page = 6;
    private $image_width = 640, $image_height = 490, $image_crop = true;

    /**
     * The Constructor
     *
     * @since  0.1.0
     */
    function __construct()
    {
        if ($this->is_edd_activated()) {

            add_action('after_setup_theme', array(&$this, 'setup'));
        }
    }

    /**
     * Do the setup on the 'after_setup_theme' hook.
     *
     * @since  0.1.0
     */
    function setup()
    {
        // checks if the activated theme has the hybrid-core framework built-in
        if (!function_exists('hybrid_get_prefix')) {

            return;
        }

        // Set constant path to the Hybrid Connect For EDD plugin directory
        define('HCF_EDD_DIR', trailingslashit(plugin_dir_path(__FILE__)));

        // Set constant path to the Hybrid Connect For EDD template directory
        define('HCF_EDD_TEMPLATES_DIR', trailingslashit(HCF_EDD_DIR . 'templates'));

        // add image sizes and register the download menu
        add_action('init', array(&$this, 'init'));

        // Choose the one column layout
        add_action('template_redirect', array(&$this, 'one_column'));

        // filters the get-the-image args for displaying larger images
        add_filter('get_the_image_args', array(&$this, 'get_the_image_args'));

        // change the default excerpt length
        add_filter('excerpt_length', array(&$this, 'excerpt_length'));

        // hooks for guys who does not like calling classes or static methods
        add_action('hcf_edd_display_download_menu', array('Hybrid_Connect_For_EDD', 'display_download_menu'));
        add_filter('hcf_edd_has_loop_meta', array('Hybrid_Connect_For_EDD', 'has_loop_meta'));
        add_action('hcf_edd_display_loop_meta', array('Hybrid_Connect_For_EDD', 'display_loop_meta'));
        add_action('hcf_edd_display_wrapped_loop_meta', array('Hybrid_Connect_For_EDD', 'display_wrapped_loop_meta'));
        add_action('hcf_edd_display_downloads', array('Hybrid_Connect_For_EDD', 'display_downloads'));

        // the after setup hook to give an opportunity to override things
        do_action('hcf_ccp_after_setup', &$this);
    }

    /**
     * Init image sizes and the download menu.
     *
     * @since  0.1.0
     */
    function init()
    {
        // init the download menu
        register_nav_menu('downloads', esc_html__('Downloads', 'hybrid-connect-for-edd'));

        // add image sizes
        add_image_size('download-large', $this->image_width, $this->image_height, $this->image_crop);
    }

    /**
     * Function for deciding which pages should have a one-column layout.
     *
     * @since 0.1.0
     */
    function one_column()
    {
        if ($this->is_archive()) {

            add_filter('get_theme_layout', array(&$this, 'theme_layout_one_column'));
        }
    }

    /**
     * Filters 'get_theme_layout' by returning 'layout-1c'.
     *
     * @since 0.1.0
     */
    function theme_layout_one_column($layout)
    {
        return 'layout-1c';
    }

    /**
     * Filters the get-the-image args to show larger images.
     *
     * @since  0.1.0
     */
    function get_the_image_args($args)
    {
        if ($this->is_archive()) {

            $args = array('size' => 'download-large', 'image_scan' => true);
        }

        return $args;
    }

    /**
     * Change the default excerpt length.
     *
     * @since  0.1.0
     */
    function excerpt_length($length)
    {
        if ($this->is_archive() || is_page_template('pages/page-downloads.php')) {

            return $this->excerpt_length;
        }

        return $length;
    }

    /**
     * Change the default downloads per page.
     *
     * @since  0.1.0
     */
    function downloads_per_page($per_page)
    {
        return $this->downloads_per_page = $per_page;
    }

    /**
     * Get the content download template.
     *
     * @since  0.1.0
     */
    function get_template_content_download()
    {
        if (!locate_template('content-download.php', true, false)) {

            // if no template found output the most simple template as possible
            require(HCF_EDD_TEMPLATES_DIR . 'content-download.php');
        }
    }

    // =====================================================
    // STATIC METHODS
    // =====================================================

    /**
     * Display the portfolio menu.
     *
     * @since  0.1.0
     */
    static function display_download_menu()
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
    static function has_loop_meta()
    {
        return is_post_type_archive('download') || is_tax('download_category') || is_tax('download_tag');
    }

    /**
     * Display loop-meta.
     *
     * @since  0.1.0
     */
    static function display_loop_meta($wrap = false)
    {
        if (!Hybrid_Connect_For_EDD::has_loop_meta()) {

            return;
        }

        echo '<div class="loop-meta">';
        if ($wrap) echo apply_filters('hcf_edd_open_loop_meta_wrap', '<div class="wrap">');

        if (is_tax('download_category') || is_tax('download_tag')) {
            ?>

            <h1 class="loop-title"><?php single_term_title(); ?></h1>

            <div class="loop-description">
                <?php echo term_description('', get_query_var('taxonomy')); ?>
                <?php Hybrid_Connect_For_EDD::display_download_menu(); ?>
            </div><!-- .loop-description -->

        <?php
        } elseif (is_post_type_archive('download')) {
            ?>

            <?php $post_type = get_post_type_object(get_query_var('post_type')); ?>

            <h1 class="loop-title"><?php post_type_archive_title(); ?></h1>

            <div class="loop-description">
                <?php if (!empty($post_type->description)) echo wpautop($post_type->description); ?>
                <?php Hybrid_Connect_For_EDD::display_download_menu(); ?>
            </div><!-- .loop-description -->

        <?php
        }

        if ($wrap) echo apply_filters('hcf_edd_close_loop_meta_wrap', '</div><!-- .wrap -->');
        echo '</div><!-- .loop-meta -->';
    }

    /**
     * Display wrapped loop-meta.
     *
     * @since  0.1.0
     */
    static function display_wrapped_loop_meta()
    {

        Hybrid_Connect_For_EDD::display_loop_meta(true);
    }

    /**
     * Display some downloads.
     *
     * @since  0.1.0
     */
    static function display_downloads()
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

                do_action('hcf_edd_get_content_download');
            }
        }
        ?>

    <?php
    }

    // =====================================================
    // UTIL PRIVATE METHODS
    // =====================================================

    /**
     * Checks if the plugin is activated.
     *
     * @since  0.1.0
     */
    private function is_edd_activated()
    {
        return class_exists('Easy_Digital_Downloads');
    }

    /**
     * Checks if is a plugin related archive page.
     *
     * @since  0.1.0
     */
    private function is_archive()
    {
        return is_post_type_archive('download') || is_tax('download_category') || is_tax('download_tag');
    }

    // =====================================================
    // GETTERS & SETTERS
    // =====================================================

    /**
     * Sets the image crop.
     *
     * @param boolean $image_crop
     * @since  0.1.0
     */
    public function set_image_crop($image_crop)
    {
        $this->image_crop = $image_crop;
    }

    /**
     * Sets the image height.
     *
     * @param int $image_height
     * @since  0.1.0
     */
    public function set_image_height($image_height)
    {
        $this->image_height = $image_height;
    }

    /**
     * Sets the image width.
     *
     * @param int $image_width
     * @since  0.1.0
     */
    public function set_image_width($image_width)
    {
        $this->image_width = $image_width;
    }

    /**
     * Sets the excerpt lenght.
     *
     * @param int $excerpt_length
     * @since  0.1.0
     */
    public function set_excerpt_length($excerpt_length)
    {
        $this->excerpt_length = $excerpt_length;
    }

    /**
     * Sets the downloads per page.
     *
     * @param int $downloads_per_page
     * @since  0.1.0
     */
    public function set_downloads_per_page($downloads_per_page)
    {
        $this->downloads_per_page = $downloads_per_page;
    }
}

new Hybrid_Connect_For_EDD();