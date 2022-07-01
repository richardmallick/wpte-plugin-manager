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
 * Method wpte_get_product
 *
 * @param $id $id [explicite description]
 * Fetch Product Row by Plugin ID
 * @return void
 */
function wpte_pm_get_plugin( $plugin_id ) {
    global $wpdb;
    return $wpdb->get_row(
        $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpte_plugin_data WHERE id = %d", $plugin_id )
    );
}

/**
 * Method wpte_plugin_data
 *
 * @param $plugin_id $plugin_id [explicite description].
 * @param $plugin_name $plugin_name [explicite description].
 * @param $plgin_slug $plgin_slug [explicite description].
 * @param $plugin_version $plugin_version [explicite description].
 * @param $wordpress_version $wordpress_version [explicite description].
 * @param $tested_version $tested_version [explicite description].
 * @param $demo_url $demo_url [explicite description].
 * @param $description $description [explicite description].
 * @param $logo_id $logo_id [explicite description].
 * 
 * Update Product
 * 
 * @return void
 */
function wpte_plugin_updater( $plugin_id, $plugin_name, $plugin_slug, $plugin_version, $php_version, $wordpress_version, $tested_version, $demo_url, $description, $logo_id ) {
    global $wpdb;

    // echo $plugin_id;
    // echo $plugin_name;
    // echo $plugin_slug;
    // echo $plugin_version;
    // echo $wordpress_version;
   $wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}wpte_plugin_data SET plugin_name = %s, plugin_slug = %s, plugin_version = %s, php_version = %s, wordpress_version = %s, tested_version = %s, demo_url = %s, description = %s, logo_id = %d WHERE id = %d", $plugin_name, $plugin_slug, $plugin_version, $php_version, $wordpress_version, $tested_version, $demo_url, $description, $logo_id, $plugin_id ) );
}

/**
 * Method wpte_plugin_delete
 *
 * @param $id $id [explicite description]
 * Delete Plugin
 * 
 */
function wpte_plugin_delete( $id ) {
    global $wpdb;
    return $wpdb->delete(
        $wpdb->prefix . 'wpte_plugin_data',
        ['id' => $id]
    );
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
function wpte_product_update( $plugin_id, $product_name, $product_slug, $is_variation) {
    global $wpdb;
    $wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}wpte_product_data SET product_name = %s, product_slug = %s, is_variation = %s WHERE plugin_id = %d", $product_name, $product_slug, $is_variation, $plugin_id ) );
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
        'plugin_id'         => '',
        'variation_name'    => '',
        'variation_slug'    => '',
        'activation_limit'  => '',
        'variation_price'   => '',
        'files_name'        => '',
        'variation_file'    => '',
        'recurring_payment' => '',
        'recurring_period'  => '',
        'recurring_times'   => '',
        'created_date'      => current_time('mysql'),

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
            '%s',
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

/**
 * Method wpte_get_product
 *
 * @param $id $id [explicite description]
 * Fetch Product Row by Plugin ID
 * @return void
 */
function wpte_get_product_variations( $plugin_id ) {
    global $wpdb;
    return $wpdb->get_results(
        $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpte_product_variation WHERE plugin_id = %d", $plugin_id )
    );
}

/**
 * Method wpte_product_variation_update
 * 
 * Update Variations
 * 
 * @return void
 */
function wpte_product_variation_update( $product_variation_id, $variation_name, $variation_slug, $activation_limit, $variation_price, $variation_file, $recurring_payment, $recurring_period, $recurring_times ) {
    global $wpdb;
    $wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}wpte_product_variation SET variation_name = %s, variation_slug = %s, activation_limit = %d, variation_price = %d, variation_file = %d, recurring_payment = %d, recurring_period = %s, recurring_times = %d WHERE id = %d", $variation_name, $variation_slug, $activation_limit, $variation_price, $variation_file, $recurring_payment, $recurring_period, $recurring_times, $product_variation_id) );

}

/**
 * Method wpte_product_variation_delete
 *
 * @param $id $id [explicite description]
 * Delete Product Variation
 * 
 */
function wpte_product_variation_delete( $id ) {
    global $wpdb;
    return $wpdb->delete(
        $wpdb->prefix . 'wpte_product_variation',
        ['id' => $id]
    );
}

/**
 * Method wpte_get_product_variation
 *
 * @param $id $id [explicite description]
 * Fetch Product Row by Plugin ID
 * @return void
 */
function wpte_get_product_variation( $product_slug ) {
    global $wpdb;
    return $wpdb->get_row(
        $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpte_product_variation WHERE variation_slug = %s", $product_slug )
    );
}

/**
 * Method wpte_pm_create_license
 *
 * @param $args $args [explicite description]
 * 
 * Inser Product Variation Data to wpte_product_variation data table
 * 
 * @return int|WP_ERROR
 * 
 */
function wpte_pm_create_license( $args = [] ) {


    global $wpdb;

    $default = [
        'plugin_id'         => '',
        'license_key'       => '',
        'customer_name'     => '',
        'customer_email'    => '',
        'product_name'      => '',
        'product_slug'      => '',
        'activation_limit'  => '',
        'product_price'     => '',
        'files_name'        => '',
        'product_file'      => '',
        'recurring_payment' => '',
        'recurring_period'  => '',
        'recurring_times'   => '',
        'is_active'         => '',
        'activated'         => '',
        'domain'            => '',
        'created_date'      => current_time('mysql'),

    ];

    $data = wp_parse_args( $args, $default );

    $inserted = $wpdb->insert(
        "{$wpdb->prefix}wpte_product_license",
        $data,
        [
            '%d',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%d',
            '%d',
            '%s',
            '%d',
            '%d',
            '%s',
            '%d',
            '%s',
            '%d',
            '%s',
            '%d',
        ]
    );

    if ( !$inserted ) {
        return new \WP_Error( 'failed-to-insert', __( 'Failed to insert data', WPTE_PM_TEXT_DOMAIN ) );
    }

    return $wpdb->insert_id;
}

/**
 * Method wpte_get_product_license
 *
 * @param $id $id [explicite description]
 * Fetch License Rows by Plugin ID
 * @return void
 */
function wpte_get_product_license( $plugin_id ) {
    global $wpdb;
    return $wpdb->get_results(
        $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpte_product_license WHERE plugin_id = %d", $plugin_id )
    );
}

/**
 * Method wpte_get_product_license_row
 *
 * @param $id $id [explicite description]
 * Fetch Product Row by Plugin ID
 * @return void
 */
function wpte_get_product_license_row( $license_id ) {
    global $wpdb;
    return $wpdb->get_row(
        $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpte_product_license WHERE id = %d", $license_id )
    );
}

/**
 * Method wpte_get_product_license_row
 *
 * @param $id $id [explicite description]
 * Fetch Product Row by Plugin ID
 * @return void
 */
function wpte_get_product_license_row_key( $license_key ) {
    global $wpdb;
    return $wpdb->get_row(
        $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpte_product_license WHERE license_key = %s", $license_key )
    );
}

/**
 * Method wpte_product_license_delete
 *
 * @param $id $id [explicite description]
 * Delete Product License
 * 
 */
function wpte_product_license_delete( $id ) {
    global $wpdb;
    return $wpdb->delete(
        $wpdb->prefix . 'wpte_product_license',
        ['id' => $id]
    );
}

/**
 * Method wpte_product_license_update
 * 
 * Update License
 * 
 * @return void
 */
function wpte_product_license_update( $license_id, $customer_name, $customer_email, $product_name, $product_slug, $activation_limit, $product_price, $files_name, $product_file, $recurring_payment, $recurring_period, $recurring_times, $is_active ) {
    global $wpdb;
    $wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}wpte_product_license SET customer_name = %s, customer_email = %s, product_name = %s, product_slug = %s, activation_limit = %d, product_price = %d, files_name = %s, product_file = %d, recurring_payment = %d, recurring_period = %s, recurring_times = %d, is_active = %s WHERE id = %d", $customer_name, $customer_email, $product_name, $product_slug, $activation_limit, $product_price, $files_name, $product_file, $recurring_payment, $recurring_period, $recurring_times, $is_active, $license_id ) );
}

/**
 * Method wpte_product_get_license_activate
 * 
 * Get Activate license count
 * 
 * @return void
 */
function wpte_product_license_activate_update( $license_id, $activated, $domain = '' ) {
    global $wpdb;
    $wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}wpte_product_license SET activated = %d, domain = %s WHERE id = %d", $activated, $domain, $license_id ) );
}


function mailtrap($phpmailer) {
    $phpmailer->isSMTP();
    $phpmailer->Host = 'smtp.mailtrap.io';
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = 2525;
    $phpmailer->Username = '27daf8b7afe6aa';
    $phpmailer->Password = '52d71b680269e3';
}
  
add_action('phpmailer_init', 'mailtrap');
