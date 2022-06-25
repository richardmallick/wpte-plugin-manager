<?php

namespace WPTE_PM_MANAGER\Includes\Api;

class Class_get_order{

    public function __construct() {
        add_action('rest_api_init', [$this, 'wpte_register_webhook']);
    }

    public function wpte_register_webhook() {
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
            '/license', 
            [
                'methods' => 'POST',
                'callback' => [$this, 'wpte_get_license_response'],
                'permission_callback' => '__return_true'
            ]
        );
    }

    public function wpte_get_order_response($request) {

        $data = json_decode($request->get_body());

        $product_path = $data->events[0]->data->items[0]->product; //path  // Product 
        $customer_email = $data->events[0]->data->customer->email; //path  // Product 

        $product = wpte_get_product_variation( $product_path ) ? wpte_get_product_variation( $product_path ) : (object)[];
 
        // This code for create License
        $token = openssl_random_pseudo_bytes(16);
        $token = bin2hex($token);

        $args = [
            'plugin_id'         => $product->plugin_id,
            'license_key'       => $token,
            'customer_email'    => $customer_email,
            'product_name'      => $product->variation_name,
            'product_slug'      => $product->variation_slug,
            'activation_limit'  => $product->activation_limit,
            'product_price'     => $product->variation_price,
            'product_file'      => $product->variation_file,
            'recurring_payment' => $product->recurring_payment,
            'recurring_period'  => $product->recurring_period,
            'recurring_times'   => $product->recurring_times,
            'activated'         => 0,
            'created_date'      => current_time('mysql'),
    
        ];

        $insert_id = wpte_pm_create_license( $args );

        if ( is_wp_error( $insert_id ) ) {
            wp_send_json_error( [
                'message' => __( 'Data Insert Failed Please retry again!', WPTE_PM_TEXT_DOMAIN ),
            ] );
        }
    }

    public function wpte_get_license_response($request) {

        $header = $request->get_headers();

        $data = json_decode($request->get_body(), true);

        $get_license = wpte_get_product_license_row_key( $data['license'] ) ? wpte_get_product_license_row_key( $data['license'] ) : (object)[];
        
        $id = $get_license->id ? $get_license->id : (object)[];
        
        $activated_license = $get_license->activated ? $get_license->activated : 0;

        $add_active        = $activated_license + 1;


        $license_key = $get_license->license_key ? $get_license->license_key : (object)[];
       // write_log($get_license->license_key);

        if ( $data['license'] === $license_key ) {
           wpte_product_license_activate_update( $id, $add_active );
            return true;
        }

        return false;
        
    }

}