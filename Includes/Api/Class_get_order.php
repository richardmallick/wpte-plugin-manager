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

        $data = $request->get_body();

        write_log(json_decode($data));
        
    }

}