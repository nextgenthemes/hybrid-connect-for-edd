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