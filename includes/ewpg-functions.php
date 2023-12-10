<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Function to create the database table during activation
function ewpg_wp_simple_page_count_activate() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'ewpg_pgview';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        page_id bigint(20) NOT NULL,
        total_views bigint(20) DEFAULT 1, -- Initialize total_views with 1
        weekly bigint(20) DEFAULT 1,      -- Initialize weekly with 1
        monthly bigint(20) DEFAULT 1,     -- Initialize monthly with 1
        today bigint(20) DEFAULT 1,       -- Initialize today with 1
        last_updated datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        PRIMARY KEY  (id),
        UNIQUE KEY page_id (page_id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}


// Function to delete the database table during plugin deletion
function ewpg_wp_simple_page_count_deactivate() {
    // Do nothing on deactivation for now
}

// Function to uninstall the plugin
function ewpg_wp_simple_page_count_uninstall() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'ewpg_pgview';

    $wpdb->query("DROP TABLE IF EXISTS $table_name");
}

// Function to log page views and update counters
function ewpg_wp_simple_page_count_log_page_view() {
    global $wpdb;

    // Default page ID to use when none is available
    $default_page_id = 1;

    // Use the provided page ID or default to the specified default_page_id
    $page_id = get_the_ID() ?: $default_page_id;
    $table_name = $wpdb->prefix . 'ewpg_pgview';

    // Get the current date and time
    $current_timestamp = current_time('mysql');

    // Check if a record exists for the current page
    $existing_record = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE page_id = %d", $page_id));

    if ($existing_record) {
        // Update existing record
        $wpdb->update(
            $table_name,
            array(
                'total_views' => $existing_record->total_views + 1,
                'weekly'      => $existing_record->weekly + 1,
                'monthly'     => $existing_record->monthly + 1,
                'today'       => $existing_record->today + 1,
                'last_updated' => $current_timestamp,
            ),
            array('page_id' => $page_id)
        );
    } else {
        // Insert new record
        $wpdb->insert(
            $table_name,
            array(
                'page_id'      => $page_id,
                'total_views'  => 1,
                'weekly'       => 1,
                'monthly'      => 1,
                'today'        => 1,
                'last_updated' => $current_timestamp,
            )
        );
    }
}



// Function to reset counters at specified intervals
function ewpg_wp_simple_page_count_reset_counters() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'ewpg_pgview';

    // Reset weekly counters every Sunday
    $wpdb->update(
        $table_name,
        array('weekly' => 0),
        array("DAYOFWEEK(last_updated)" => 1)
    );

    // Reset monthly counters at the end of the month
    $wpdb->update(
        $table_name,
        array('monthly' => 0),
        array("DAY(last_updated)" => date('t'))
    );

    // Reset daily counters every 24 hours
    $wpdb->update(
        $table_name,
        array('today' => 0),
        array("HOUR(last_updated)" => date('H'))
    );
}
