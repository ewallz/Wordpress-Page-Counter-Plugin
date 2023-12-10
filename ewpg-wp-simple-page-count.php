<?php
/**
 * Plugin Name: EWPG Simple Pageviews Counter
 * Description: A simple WordPress plugin to track page views for each page. Shortcode: [ewpg_page_views]
 * Version: 1.0
 * Author: eWallz Solutions
 * Author URI: https://www.ewallzsolutions.com
 * License: GPL-2.0+
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Load plugin includes
require_once plugin_dir_path(__FILE__) . 'includes/ewpg-functions.php';
require_once plugin_dir_path(__FILE__) . 'includes/ewpg-shortcode.php';

// Load plugin translations
add_action('plugins_loaded', 'ewpg_load_textdomain');
function ewpg_load_textdomain() {
    load_plugin_textdomain('ewpg-wp-simple-page-count', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}

// Activation and Deactivation hooks
register_activation_hook(__FILE__, 'ewpg_wp_simple_page_count_activate');
register_deactivation_hook(__FILE__, 'ewpg_wp_simple_page_count_deactivate');

// Log page views
add_action('wp_head', 'ewpg_wp_simple_page_count_log_page_view');

// Reset counters daily
if (!wp_next_scheduled('ewpg_wp_simple_page_count_reset_counters_event')) {
    wp_schedule_event(time(), 'daily', 'ewpg_wp_simple_page_count_reset_counters_event');
}
add_action('ewpg_wp_simple_page_count_reset_counters_event', 'ewpg_wp_simple_page_count_reset_counters');

// Shortcode for displaying statistics
add_shortcode('ewpg_page_views', 'ewpg_wp_simple_page_count_display_page_views_stats');
