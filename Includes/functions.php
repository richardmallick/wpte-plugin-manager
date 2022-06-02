<?php

/**
 * Method wpte_pm_add_plugin
 *
 * @param $args $args [explicite description]
 * 
 * Inser Pluting data to wpte_plugin_data data table when create new 
 * 
 * @return int|WP_ERROR
 * 
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
        'logo_id' => '',
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
            '%d',
        ]
    );

    if ( !$inserted ) {
        return new \WP_Error( 'failed-to-insert', __( 'Failed to insert data', WPTE_PM_TEXT_DOMAIN ) );
    }

    return $wpdb->insert_id;
}

/**
 * Method wpte_get_products_layout
 *
 * @param $arg
 *
 * Fetch all product layouts from database
 *
 * @return dbdata
 */
function wpte_pm_get_plugins( $arg = [] ) {

    global $wpdb;

    $default = [
        'number'   => 20,
        'offset'   => 0,
        'orderby' => 'ID',
        'order'    => 'DESC',
    ];

    $args = wp_parse_args( $arg, $default );

    $items = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}wpte_plugin_data
            ORDER BY %s %s
            LIMIT %d, %d",
            $args['orderby'], $args['order'], $args['offset'], $args['number']
        )
   );

    return $items;
}