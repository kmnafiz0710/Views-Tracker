<?php
/*
Plugin Name: Views Tracker
Description: Tracks and displays each post's views, today's viewers, and total website viewers using shortcodes.
Version: 1.1
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
