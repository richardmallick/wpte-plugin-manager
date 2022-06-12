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

/**
 * Method wpte_pm_add_product
 *
 * @param $args $args [explicite description]
 * 
 * Inser Pluting data to wpte_plugin_data data table when create new 
 * 
 * @return int|WP_ERROR
 * 
 */
function wpte_pm_add_product( $args = [] ) {

    global $wpdb;

    $default = [
        'plugin_id'  => '',
    ];

    $data = wp_parse_args( $args, $default );

    $inserted = $wpdb->insert(
        "{$wpdb->prefix}wpte_product_data",
        $data,
        [
            '%d'
        ]
    );

    if ( !$inserted ) {
        return new \WP_Error( 'failed-to-insert', __( 'Failed to insert data', WPTE_PM_TEXT_DOMAIN ) );
    }

    return $wpdb->insert_id;
}

/**
 * Method wpte_get_product
 *
 * @param $id $id [explicite description]
 * Fetch Product Row by Plugin ID
 * @return void
 */
function wpte_get_product( $plugin_id ) {
    global $wpdb;
    return $wpdb->get_row(
        $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpte_product_data WHERE plugin_id = %d", $plugin_id )
    );
}

/**
 * Method wpte_product_update
 *
 * @param $plugin_id $plugin_id [explicite description].
 * @param $product_name $product_name [explicite description].
 * @param $product_slug $product_slug [explicite description].
 * @param $product_file $product_file [explicite description].
 * @param $is_variation $is_variation [explicite description].
 * @param $variation $variation [explicite description].
 * 
 * Update Product
 * 
 * @return void
 */
function wpte_product_update( $plugin_id, $product_name, $product_slug, $is_variation, $variation) {
    global $wpdb;
    $wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}wpte_product_data SET product_name = %s, product_slug = %s, is_variation = %s, product_prices = %s, product_variation = %s WHERE plugin_id = %d", $product_name, $product_slug, $is_variation, $variation, $variation, $plugin_id ) );

}

/**
 * Method wpte_pm_add_product_variation
 *
 * @param $args $args [explicite description]
 * 
 * Inser Product Variation Data to wpte_product_variation data table
 * 
 * @return int|WP_ERROR
 * 
 */
function wpte_pm_add_product_variation( $args = [] ) {


    global $wpdb;

    $default = [
        'plugin_id'  => '',
        'variation_name'  => '',
        'variation_slug'=> '',
        'activation_limit'  => '',
        'variation_price' => '',
        'variation_file' => '',
        'recurring_payment' => '',
        'recurring_period' => '',
        'recurring_times' => '',
        'created_date' => current_time('mysql'),

    ];

    $data = wp_parse_args( $args, $default );

    $inserted = $wpdb->insert(
        "{$wpdb->prefix}wpte_product_variation",
        $data,
        [
            '%d',
            '%s',
            '%s',
            '%d',
            '%d',
            '%d',
            '%d',
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