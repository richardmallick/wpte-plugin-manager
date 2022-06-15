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
                //'permission_callback' => [$this, 'wpte_get_order_permission']
            ]
        );
    }

    
    public function wpte_get_order_response($request) {

        $data = json_decode($request->get_body());

        $product_path = $data->events[0]->data->order->items[0]->product; //path  // Product Path from fastspring

        // This code for create License
        $token = openssl_random_pseudo_bytes(16);
        //Convert the binary data into hexadecimal representation.
        $token = bin2hex($token);
        //Print it out for example purposes.
        //echo $token;
        
    }

}