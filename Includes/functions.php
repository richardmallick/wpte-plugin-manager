<?php

/**
 * Method wpte_layout_insert
 *
 * @param $args $args [explicite description]
 * Inser Layout to wpte_product_layout_style data table when create new 
 * @return int|WP_ERROR
 */
function wpte_pm_add_plugin( $args = [] ) {

    global $wpdb;

    $default = [
        'plugin_name'  => '',
        'plugin_slug'  => '',
        'plugin_version'=> '',
        'php_version'  => '',
        'wordpress_version' => '',
        'tested_version' => '',
        'demo_url' => '',
        'description' => '',
        'created_date' => current_time('mysql'),

    ];


    $data = wp_parse_args( $args, $default );

    $inserted = $wpdb->insert(
        "{$wpdb->prefix}wpte_plugin_data",
        $data,
        [
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%d',
        ]
    );

    if ( !$inserted ) {
        return new \WP_Error( 'failed-to-insert', __( 'Failed to insert data', WPTE_WPL_TEXT_DOMAIN ) );
    }

    return $wpdb->insert_id;
}