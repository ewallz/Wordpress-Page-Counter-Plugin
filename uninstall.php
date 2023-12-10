<?php
// If uninstall is not called from WordPress, exit
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Include necessary files
require_once plugin_dir_path(__FILE__) . 'includes/ewpg-functions.php';

// Call the uninstall function
ewpg_wp_simple_page_count_uninstall();
