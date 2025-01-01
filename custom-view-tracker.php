<?php
/*
Plugin Name: Custom View Tracker
Description: Tracks and displays each post's views, today's viewers, and total website viewers using shortcodes.
Version: 1.0
Author: Khaled Masud
Author URI: https://khaledmasud.com
*/

// Security check
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Include necessary files
require_once plugin_dir_path(__FILE__) . 'includes/tracker-functions.php';
require_once plugin_dir_path(__FILE__) . 'includes/shortcode-functions.php';
require_once plugin_dir_path(__FILE__) . 'includes/admin-functions.php';
include_once plugin_dir_path(__FILE__) . 'includes/functions.php';
include_once plugin_dir_path(__FILE__) . 'includes/widgets.php';
include_once plugin_dir_path(__FILE__) . 'includes/blocks.php';
include_once plugin_dir_path(__FILE__) . 'includes/elementor-widget.php';

// Enqueue styles and scripts for Gutenberg and Elementor blocks
function enqueue_plugin_scripts() {
    wp_enqueue_script('view-tracker-block', plugins_url('js/view-tracker-block.js', __FILE__), ['wp-blocks', 'wp-element', 'wp-editor'], filemtime(plugin_dir_path(__FILE__) . 'js/view-tracker-block.js'));
}
add_action('enqueue_block_editor_assets', 'enqueue_plugin_scripts');