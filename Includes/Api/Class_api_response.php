<?php

namespace WPTE_PM_MANAGER\Includes\Api;

/**
 * Api Response Class
 * 
 * @since 1.0.0
 */
class Class_api_response{

    /**
     * Api Response class constructor
     * 
     * @since 1.0.0
     */
    public function __construct() {
        add_action('rest_api_init', [$this, 'wpte_register_routes']);
    }

    /**
     * Register Routes
     * 
     * @since 1.0.0
     */
    public function wpte_register_routes() {

        register_rest_route(
            'wpte/v1', 
            '/order', 
            [
                'methods' => 'POST',
                'callback' => [$this, 'wpte_get_order_response'],
                'permission_callback' => '__return_true'
            ]
        );

        register_rest_route(
            'wpte/v1', 
            '/active-license', 
            [
                'methods' => 'POST',
                'callback' => [$this, 'wpte_get_active_license_response'],
                'permission_callback' => '__return_true'
            ]
        );

        register_rest_route(
            'wpte/v1', 
            '/deactive-license', 
            [
                'methods' => 'POST',
                'callback' => [$this, 'wpte_get_deactive_license_response'],
                'permission_callback' => '__return_true'
            ]
        );
    }

    /**
     * Get Order Response
     *
     * @since 1.0.0
     */
    public function wpte_get_order_response($request) {

        $data = json_decode($request->get_body());

        $product_path   = $data->events[0]->data->items[0]->product; //path  // Product 
        $customer_email = $data->events[0]->data->customer->email; //email
        $customer_frist_name  = $data->events[0]->data->customer->first; //First Name
        $customer_last_name  = $data->events[0]->data->customer->last; //Last Name
        $customer_phone  = $data->events[0]->data->customer->phone; //phone

        $product = wpte_get_product_variation( $product_path ) ? wpte_get_product_variation( $product_path ) : (object)[];
 
        // This code for create License
        $token = openssl_random_pseudo_bytes(16);
        $token = bin2hex($token);

        if ( isset($product->recurring_payment) && $product->recurring_payment ) {
            $recurring_period = $product->recurring_period;
            $recurring_times = $product->recurring_times;
            $timestamp = strtotime(current_time('mysql'));
            $expired_date = strtotime("+$recurring_times $recurring_period", $timestamp); 
            //$expired_date = date("Y-m-d h:i:s", $timestamp);
        } else {
            $expired_date = 'lifetime';
        }

        $args = [
            'plugin_id'         => $product->plugin_id,
            'license_key'       => $token,
            'customer_name'     => $customer_frist_name .' '. $customer_last_name,
            'customer_email'    => $customer_email,
            'product_name'      => $product->variation_name,
            'product_slug'      => $product->variation_slug,
            'activation_limit'  => $product->activation_limit,
            'product_price'     => $product->variation_price,
            'files_name'        => $product->files_name,
            'product_file'      => $product->variation_file,
            'recurring_payment' => $product->recurring_payment,
            'recurring_period'  => $product->recurring_period,
            'recurring_times'   => $product->recurring_times,
            'is_active'         => 'active',
            'activated'         => 0,
            'domain'            => '',
            'created_date'      => current_time('mysql'),
            'expired_date'      => $expired_date,
    
        ];

        $insert_id = wpte_pm_create_license( $args );

        if ( is_wp_error( $insert_id ) ) {
            wp_send_json_error( [
                'message' => __( 'Data Insert Failed Please retry again!', WPTE_PM_TEXT_DOMAIN ),
            ] );
        }
    }

    /**
     * Get Active License Response
     * 
     * @since 1.0.0
     */
    public function wpte_get_active_license_response($request) {

        $header = $request->get_headers();

        //write_log($header['host'][0]);

        $data = json_decode($request->get_body(), true);

        $get_license = wpte_get_product_license_row_key( $data['license'] ) ? wpte_get_product_license_row_key( $data['license'] ) : (object)[];
        
        $id = $get_license->id ? $get_license->id : (object)[];
        
        $activated_license  = $get_license->activated ? $get_license->activated : 0;
        $addition           = $activated_license + 1;
        $activation_limit   = $get_license->activation_limit ? $get_license->activation_limit : 0;

        $license_key = $get_license->license_key ? $get_license->license_key : (object)[];
        $is_active   = $get_license->is_active ? $get_license->is_active : (object)[];
        $files_name   = $get_license->files_name ? $get_license->files_name : (object)[];
        $domain   = $get_license->domain ? json_decode($get_license->domain, true) : [];

        if ( 
            $data['license']    === $license_key && 
            $data['files_name'] === $files_name && 
            $is_active          === 'active' && 
            $activated_license  < $activation_limit &&
            ! in_array( $_domain = $data['domain'], $domain)
            ) {
            array_push($domain, $_domain);
            wpte_product_license_activate_update( $id, $addition, wp_json_encode($domain, JSON_UNESCAPED_SLASHES) );
            return true;
        }

        return false;
        
    }

    /**
     * Get Deactive License Response
     * 
     * @since 1.0.0
     */
    public function wpte_get_deactive_license_response($request) {

        $header = $request->get_headers();

        $data = json_decode($request->get_body(), true);

        $get_license = wpte_get_product_license_row_key( $data['license'] ) ? wpte_get_product_license_row_key( $data['license'] ) : (object)[];
        
        $id = $get_license->id ? $get_license->id : (object)[];
        
        $activated_license = $get_license->activated ? $get_license->activated : 0;

        $subtraction = $activated_license > 0 ? $activated_license - 1 : 0;

        $license_key = $get_license->license_key ? $get_license->license_key : (object)[];
        $files_name   = $get_license->files_name ? $get_license->files_name : (object)[];
        $domain   = $get_license->domain ? json_decode($get_license->domain, true) : [];

        if ( $data['license'] === $license_key && 
            $data['files_name'] === $files_name && 
            in_array( $_domain = $data['domain'], $domain) ) {

            $domain = array_diff($domain, array($_domain));
            wpte_product_license_activate_update( $id, $subtraction, wp_json_encode($domain) );
            return true;
        }

        return false;
    }

}