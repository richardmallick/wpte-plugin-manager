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
        'plugin_name'       => '',
        'plugin_slug'       => '',
        'plugin_version'    => '',
        'php_version'       => '',
        'wordpress_version' => '',
        'tested_version'    => '',
        'demo_url'          => '',
        'description'       => '',
        'created_date'      => current_time('mysql'),
        'logo_id'           => '',
        'plugin_key'        => '',
        'last_update'       => current_time('mysql'),
        'change_log'        => '',
        'file_id'           => '',
        'file_url'          => ''

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
            '%s',
            '%d',
            '%s',
            '%s',
            '%s',
            '%d',
            '%s',
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
function wpte_plugin_updater( $plugin_id, $plugin_name, $plugin_slug, $plugin_version, $php_version, $wordpress_version, $tested_version, $demo_url, $description, $logo_id, $last_update, $change_log, $file_id, $file_url ) {
    global $wpdb;
   $wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}wpte_plugin_data SET plugin_name = %s, plugin_slug = %s, plugin_version = %s, php_version = %s, wordpress_version = %s, tested_version = %s, demo_url = %s, description = %s, logo_id = %d, last_update = %s, change_log = %s, file_id = %d, file_url = %s WHERE id = %d", $plugin_name, $plugin_slug, $plugin_version, $php_version, $wordpress_version, $tested_version, $demo_url, $description, $logo_id, $last_update, $change_log, $file_id, $file_url, $plugin_id ) );
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
function wpte_product_update( $plugin_id, $is_variation) {
    global $wpdb;
    $wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}wpte_product_data SET is_variation = %s WHERE plugin_id = %d", $is_variation, $plugin_id ) );
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
            '%d',
            '%s',
            '%d',
            '%s',
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
function wpte_get_product_variation_by_id( $id ) {
    global $wpdb;
    return $wpdb->get_row(
        $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpte_product_variation WHERE id = %d", $id )
    );
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
function wpte_product_variation_update( $product_variation_id, $variation_name, $variation_slug, $activation_limit, $variation_price, $recurring_payment, $recurring_period, $recurring_times ) {
    global $wpdb;
    $wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}wpte_product_variation SET variation_name = %s, variation_slug = %s, activation_limit = %d, variation_price = %d, recurring_payment = %d, recurring_period = %s, recurring_times = %d WHERE id = %d", $variation_name, $variation_slug, $activation_limit, $variation_price, $recurring_payment, $recurring_period, $recurring_times, $product_variation_id) );

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
        'activation_limit'  => '',
        'active'            => '',
        'customer_id'       => '',
        'status'            => '',
        'product_id'        => '',
        'recurring_payment' => '',
        'recurring_period'  => '',
        'recurring_times'   => '',
        'created_date'      => '',
        'expired_date'      => '',

    ];

    $data = wp_parse_args( $args, $default );

    $inserted = $wpdb->insert(
        "{$wpdb->prefix}wpte_product_license",
        $data,
        [
            '%d',
            '%s',
            '%d',
            '%d',
            '%d',
            '%s',
            '%d',
            '%d',
            '%s',
            '%d',
            '%s',
            '%s',
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
 * Method wpte_product_get_license_activate
 * 
 * Get Activate license count
 * 
 * @return void
 */
function wpte_product_license_activate_update( $license_id, $active ) {
    global $wpdb;
    $wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}wpte_product_license SET active = %d WHERE id = %d", $active, $license_id ) );
}

/**
 * Method wpte_product_get_license_activate
 * 
 * Get Activate license count
 * 
 * @return void
 */
function wpte_product_license_activation_limit_update( $license_id, $activation_limit ) {
    global $wpdb;
    $wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}wpte_product_license SET activation_limit = %d WHERE id = %d", $activation_limit, $license_id ) );
}

/**
 * Method wpte_product_get_license_activate
 * 
 * Get Activate license count
 * 
 * @return void
 */
function wpte_product_license_status_update( $license_id, $status ) {
    global $wpdb;
    $wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}wpte_product_license SET status = %s WHERE id = %d", $status, $license_id ) );
}

/**
 * Method wpte_generate_password
 * 
 * Password Generator to Create New User
 * 
 * @return void
 */
function wpte_generate_password($length = 20){
    $chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.
              '0123456789`-=~!@#$%^&*()_+,/<>?;[]{}\|';
  
    $str = '';
    $max = strlen($chars) - 1;
  
    for ($i=0; $i < $length; $i++)
      $str .= $chars[mt_rand(0, $max)];
  
    return $str;
  }

/**
 * Method wpte_add_new_user
 * 
 * Create New User
 * 
 * @return void
 */
function wpte_add_new_user($email, $password, $first_name, $last_name) {

    $_username = $first_name.$last_name;

    if ( username_exists( $_username ) ) {
        $digits = 3;
        $username = $_username.rand(pow(10, $digits-1), pow(10, $digits)-1);
    } else {
        $username = $_username;
    }

    $user_id      = username_exists( $username );
    $email_exists = email_exists( $email );

    if ( $email_exists == false ) {
        $user_id = wp_create_user( $username, $password, $email );
        if( ! is_wp_error($user_id) ) {
            $user = get_user_by( 'id', $user_id );
            $user->set_role( 'subscriber' );

            $metas = array( 
                'nickname'   => $first_name,
                'first_name' => $first_name, 
                'last_name'  => $last_name,
            );
            
            foreach($metas as $key => $value) {
                update_user_meta( $user_id, $key, $value );
            }

            return $user_id;
        }
    } else {
        $user = get_user_by( 'email', $email );
        return $user->ID;
    }
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
function wpte_pm_add_new_site( $args = [] ) {

    global $wpdb;

    $default = [
        'license_id'    => '',
        'site_url'      => '',
        'site_name'     => '',
        'site_type'     => '',
        'status'        => '',
    ];

    $data = wp_parse_args( $args, $default );

    $inserted = $wpdb->insert(
        "{$wpdb->prefix}wpte_domains",
        $data,
        [
            '%d',
            '%s',
            '%s',
            '%s',
            '%s',
        ]
    );

    if ( !$inserted ) {
        return new \WP_Error( 'failed-to-insert', __( 'Failed to insert data', WPTE_PM_TEXT_DOMAIN ) );
    }

    return $wpdb->insert_id;
}

/**
 * Method wpte_get_product_license_row
 *
 * @param $id $id [explicite description]
 * Fetch Product Row by Plugin ID
 * @return void
 */
function wpte_get_domain_rows( $license_id ) {
    global $wpdb;
    return $wpdb->get_results(
        $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpte_domains WHERE license_id = %d", $license_id )
    );
}

/**
 * Method wpte_get_product_license_row
 *
 * @param $id $id [explicite description]
 * Fetch Product Row by Plugin ID
 * @return void
 */
function wpte_is_license_url_exitst( $site_url, $license_id ) {
    global $wpdb;
    return $wpdb->get_row(
        $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpte_domains WHERE license_id = %d AND site_url = %s", $license_id, $site_url )
    );
}

/**
 * Method wpte_product_get_license_activate
 * 
 * Get Activate license count
 * 
 * @return void
 */
function wpte_product_license_url_update( $license_id , $site_url, $status) {
    global $wpdb;
    $wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}wpte_domains SET status = %s WHERE license_id = %d AND site_url = %s ", $status, $license_id, $site_url ) );
}
/**
 * Method wpte_product_get_license_activate
 * 
 * Get Activate license count
 * 
 * @return void
 */
function wpte_pm_license_url_status_updater( $id , $status) {
    global $wpdb;
    $wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}wpte_domains SET status = %s WHERE id = %d", $status, $id) );
}

/**
 * Method wpte_pm_license_url_delete
 *
 * @param $id $id [explicite description]
 * Delete Site
 * 
 */
function wpte_pm_license_url_delete( $id ) {
    global $wpdb;
    return $wpdb->delete(
        $wpdb->prefix . 'wpte_domains',
        ['id' => $id]
    );
}


/**
 * Method wpte_pm_get_data_for_invoice
 *
 * @param $licese_id $licese_id [explicite description]
 * Query for invoice email
 * 
 */
function wpte_pm_get_data_for_invoice( $licese_id ) {
    global $wpdb;
    return $wpdb->get_row(
        $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpte_product_license, {$wpdb->prefix}wpte_product_variation, {$wpdb->prefix}wpte_plugin_data 
        WHERE {$wpdb->prefix}wpte_product_license.id = %d 
        AND {$wpdb->prefix}wpte_product_license.product_id = {$wpdb->prefix}wpte_product_variation.id 
        AND {$wpdb->prefix}wpte_product_license.plugin_id = {$wpdb->prefix}wpte_plugin_data.id", 
        $licese_id)
    );
}

/**
 * Method wpte_pm_get_data_for_invoice
 *
 * @param $licese_id $licese_id [explicite description]
 * Query for invoice email
 * 
 */

function wpte_pm_get_data_for_plugin_update( $license_key ) {
    global $wpdb;
    return $wpdb->get_row(
        $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpte_plugin_data WHERE plugin_key = %s", $license_key )
    );
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
