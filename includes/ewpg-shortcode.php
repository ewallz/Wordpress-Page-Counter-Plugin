<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Shortcode for displaying statistics
function ewpg_wp_simple_page_count_display_page_views_stats($atts) {
    global $wpdb;

    $page_id = get_the_ID();
    $table_name = $wpdb->prefix . 'ewpg_pgview';

    // Retrieve statistics for the current page
    $statistics = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE page_id = %d", $page_id));

    // Set default values if $statistics is null
    if ($statistics === null) {
        $statistics = (object) array(
            'total_views' => 1,
            'today' => 1,
            'weekly' => 1,
            'monthly' => 1,
        );
    }

    // Check if any parameters are provided
    $has_parameters = !empty($atts);

    // If no parameters are provided, assume the user wants to display all counters with credit using style 1
    if (!$has_parameters) {
        $atts = array(
            'total' => 'yes',
            'today' => 'yes',
            'weekly' => 'yes',
            'monthly' => 'yes',
            'style' => 1,
        );
    }

    // Initialize variables for shortcode parameters
    $include_total = isset($atts['total']) && strtolower($atts['total']) === 'yes';
    $include_today = isset($atts['today']) && strtolower($atts['today']) === 'yes';
    $include_weekly = isset($atts['weekly']) && strtolower($atts['weekly']) === 'yes';
    $include_monthly = isset($atts['monthly']) && strtolower($atts['monthly']) === 'yes';
    $start_no = isset($atts['startno']) ? (int) $atts['startno'] : 0;
    $style = isset($atts['style']) ? (int) $atts['style'] : 1;
    $credit = isset($atts['credit']) && strtolower($atts['credit']) === 'no' ? false : true;

    // Check if a valid style is provided
    $style = in_array($style, range(1, 5)) ? $style : 1;

    // Translatable labels with "//" prefix
    $today_label = __('// Today Hits', 'ewpg-wp-simple-page-count');
    $weekly_label = __('// Weekly Hits', 'ewpg-wp-simple-page-count');
    $monthly_label = __('// Monthly Hits', 'ewpg-wp-simple-page-count');
    $total_label = __('// Total Hits', 'ewpg-wp-simple-page-count');

    // Calculate the total count based on parameters
    $total_count = $include_total ? $statistics->total_views + $start_no : 0;

    // Calculate other counts based on parameters
    $today_count = $include_today ? $statistics->today : 0;
    $weekly_count = $include_weekly ? $statistics->weekly : 0;
    $monthly_count = $include_monthly ? $statistics->monthly : 0;

    // Enqueue the CSS file
    wp_enqueue_style('ewpg-widget-styles', plugin_dir_url(__FILE__) . '../public/css/ewpg-css.css');

    // Apply CSS styles based on the chosen style
    $widget_style_class = 'ewpg_widget ewpg_widget_style_' . $style;

    // Implement logic to display statistics as needed
    $output = '<div class="' . $widget_style_class . '">';

    if ($include_today) {
        $output .= '<div class="ewpg_label_box">' . $today_label . ': <span class="ewpg_count">' . $today_count . '</span></div>';
    }

    if ($include_weekly) {
        $output .= '<div class="ewpg_label_box">' . $weekly_label . ': <span class="ewpg_count">' . $weekly_count . '</span></div>';
    }

    if ($include_monthly) {
        $output .= '<div class="ewpg_label_box">' . $monthly_label . ': <span class="ewpg_count">' . $monthly_count . '</span></div>';
    }

    if ($include_total) {
        $output .= '<div class="ewpg_label_box">' . $total_label . ': <span class="ewpg_count">' . $total_count . '</span></div>';
    }

    // Add credit link if enabled
    if ($credit) {
        $credit_link = '<a class="ewpg_credit_link" href="https://www.ewallzsolutions.com/wordpress-simple-pageview-sitecounter-plugin/" target="_blank" rel="nofollow">wp sitecounter</a>';
        $output .= $credit_link;
    }

    $output .= '</div>';

    return $output;

}

// Register shortcode
add_shortcode('ewpg_page_views', 'ewpg_wp_simple_page_count_display_page_views_stats');



