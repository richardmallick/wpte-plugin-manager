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
            '/plugin/license/check', 
            [
                'methods' => 'POST',
                'callback' => [$this, 'wpte_license_check'],
                'permission_callback' => '__return_true'
            ]
        );

        register_rest_route(
            'wpte/v1', 
            '/plugin/license/activate', 
            [
                'methods' => 'POST',
                'callback' => [$this, 'wpte_license_activate'],
                'permission_callback' => '__return_true'
            ]
        );

        register_rest_route(
            'wpte/v1', 
            '/plugin/license/deactivate', 
            [
                'methods' => 'POST',
                'callback' => [$this, 'wpte_license_deactivate'],
                'permission_callback' => '__return_true'
            ]
        );

        register_rest_route(
            'wpte/v1', 
            '/update/werewr/check', 
            [
                'methods' => 'POST',
                'callback' => [$this, 'wpte_plugin_update_response'],
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
     * Get License Response
     * 
     * @since 1.0.0
     */
    public function wpte_license_activate($request) {
        // TODO: Make header secure
        $header = $request->get_headers();

        $data = $request->get_params();

        if ( ! $data['license_key'] || ! $data['url'] ) {
            return false;
        }

        $get_license        = wpte_get_product_license_row_and_plugin_slug( $data['license_key'] ) ? wpte_get_product_license_row_and_plugin_slug( $data['license_key'] ) : (object)[];
        $variation_status   = wpte_get_domain_status_by_license_id( $get_license->id ) ? wpte_get_domain_status_by_license_id( $get_license->id ) : [];
        $active_sites       = count($variation_status);
        
        if ( $get_license->license_key !== $data['license_key'] || $data['slug'] !== $get_license->plugin_slug ) {
            $send_data = [
                'error'     => 'Invalid License Key',
                'success'   => false
            ];
        } elseif ( ! ( $get_license->activation_limit > $active_sites ) ) {
            $send_data = [
                'error'     => 'Out of Activation Limit',
                'success'   => false
            ];
        } elseif ( $get_license->expired_date < time() && $get_license->expired_date !== 'lifetime' ) {
            $send_data = [
                'error'     => 'License Key has been expired',
                'success'   => false
            ];
        } elseif ( $get_license->status == 'inactive' ) {
            $send_data = [
                'error'     => 'Inactive License Key',
                'success'   => false
            ];
        } else {
            
            if ( $data['is_local'] ) {
                $site_type = 'Local';
            } else {
                $site_type = 'Live';
            }

            $url = explode('.', parse_url($data['url'], PHP_URL_HOST));

            $args = [
                'license_id'    => $get_license->id,
                'site_url'      => $data['url'],
                'site_name'     => $url[0],
                'site_type'     => $site_type,
                'status'        => 'active',
            ];

            $is_url_exist = wpte_is_license_url_exitst( $data['url'], $get_license->id ) ? wpte_is_license_url_exitst( $data['url'], $get_license->id  ) : (object)[];

            if ( !empty(get_object_vars($is_url_exist)) ) {
                if ( isset($is_url_exist->status) && $is_url_exist->status === 'blocked' ) {
                    $send_data = [
                        'error'     => 'This URL has been Blocked',
                        'success'   => false
                    ];
                    header( 'Content-Type: application/json' );
                    wp_send_json($send_data);
                    return false;
                }
                $active_sites = wpte_get_domain_status_by_license_id( $get_license->id ) ? wpte_get_domain_status_by_license_id( $get_license->id ) : [];
                $active = count($active_sites) + 1;
                wpte_product_license_activate_update( $get_license->id, $active );
                wpte_product_license_url_update( $get_license->id , $data['url'], 'active');
            } else {
                $addSite = wpte_pm_add_new_site( $args );
                if ( $addSite ) {
                    $active_sites = wpte_get_domain_status_by_license_id( $get_license->id ) ? wpte_get_domain_status_by_license_id( $get_license->id ) : [];
                    $active = count($active_sites) + 1;
                    wpte_product_license_activate_update( $get_license->id, $active );
                    wpte_product_license_url_update( $get_license->id , $data['url'], 'active');
                } 
            }

            $variation_status   = wpte_get_domain_status_by_license_id( $get_license->id ) ? wpte_get_domain_status_by_license_id( $get_license->id ) : [];
            $active_sites = count($variation_status);
            $send_data = [
                'success'          => true,
                'remaining'        => $active_sites,
                'activation_limit' => $get_license->activation_limit,
                'expiry_days'      => $get_license->expired_date,
                'recurring'        => $get_license->recurring_payment,
            ];
  
        }
        
        header( 'Content-Type: application/json' );
        wp_send_json($send_data);
        
    }

    /**
     * Get License Response
     * 
     * @since 1.0.0
     */
    public function wpte_license_check($request) {
        // TODO: Make header secure
        $header = $request->get_headers();

        $data = $request->get_params();

        if ( ! $data['license_key'] || ! $data['url'] ) {
            return false;
        }

        $get_license        = wpte_get_product_license_row_and_plugin_slug( $data['license_key'] ) ? wpte_get_product_license_row_key( $data['license_key'] ) : (object)[];
        $variation_status   = wpte_get_domain_status_by_license_id( $get_license->id ) ? wpte_get_domain_status_by_license_id( $get_license->id ) : [];
        $active_sites       = count($variation_status);

        if ( $get_license->license_key !== $data['license_key'] || $data['slug'] !== $get_license->plugin_slug ) {
            $send_data = [
                'error'     => 'Invalid License Key',
                'success'   => false
            ];
        }elseif ( $get_license->expired_date < time() ) {
            $send_data = [
                'error'     => 'License Key has been expired',
                'success'   => false
            ];
        } elseif ( $get_license->status === 'inactive' ) {
            $send_data = [
                'error'     => 'Inactive License Key',
                'success'   => false
            ];
        } else {

            $send_data = [
                'success'          => true,
                'remaining'        => $active_sites,
                'activation_limit' => $get_license->activation_limit,
                'expiry_days'      => $get_license->expired_date,
                'recurring'        => $get_license->recurring_payment,
            ];
  
        }
        
        header( 'Content-Type: application/json' );
        wp_send_json($send_data);
        
    }

    /**
     * License Deactivate
     * 
     * @since 1.0.0
     */
    public function wpte_license_deactivate( $request ) {
        // TODO: Make header secure
        $header = $request->get_headers();

        $data   = $request->get_params();

        if ( ! $data['license_key'] ) {
            return false;
        }

        $get_license  = wpte_get_product_license_row_key( $data['license_key'] ) ? wpte_get_product_license_row_key( $data['license_key'] ) : (object)[];
        
        $is_url_exist = wpte_is_license_url_exitst( $data['url'], $get_license->id ) ? wpte_is_license_url_exitst( $data['url'], $get_license->id  ) : (object)[];
        
        if ( $get_license->license_key !== $data['license_key'] ) {
            $send_data = [
                'error'     => 'Invalid License Key',
                'success'   => false
            ];
        } else {
            $send_data = [
                'success' => true,
            ];
            
            $active_sites = wpte_get_domain_status_by_license_id( $get_license->id ) ? wpte_get_domain_status_by_license_id( $get_license->id ) : [];
            $active = count($active_sites) ? count($active_sites) - 1 : 0;
            wpte_product_license_activate_update( $get_license->id, $active );

            if ( !empty(get_object_vars($is_url_exist)) && $is_url_exist->status !== 'blocked' && $is_url_exist->status !== 'inactive' ) {
                wpte_product_license_url_update( $get_license->id , $data['url'], 'inactive');
            }
            
        }

        header( 'Content-Type: application/json' );
        wp_send_json($send_data);
    }

    /**
     * Plugin Update Response
     * 
     * @since 1.0.0
     */
    public function wpte_plugin_update_response( $request ) {

        $header = $request->get_headers();

        $data = $request->get_params();

        $id          = isset($data['id']) && $data['id'] ? esc_html($data['id']) : '';
        // $version     = isset($data['version']) && $data['version'] ? esc_html($data['version']) : '';
        // $name        = isset($data['name']) && $data['name'] ? esc_html($data['name']) : '';
        // $slug        = isset($data['slug']) && $data['slug'] ? esc_html($data['slug']) : '';
        // $basename    = isset($data['basename']) && $data['basename'] ? esc_html($data['basename']) : '';
        $license_key = isset($data['license_key']) && $data['license_key'] ? esc_html($data['license_key']) : '';

        $plugin_data    = wpte_pm_get_data_for_plugin_update( $id );
        $get_license_db = wpte_get_product_license_row_key( $license_key ) ? wpte_get_product_license_row_key( $license_key ) : (object)[];

        $update = array(
            "id"   => $plugin_data->plugin_key,
            "name" => $plugin_data->plugin_name,
            "slug" => $plugin_data->plugin_slug,
            "plugin" => $plugin_data->plugin_slug."/".$plugin_data->plugin_slug."php",
            "url" => "",
            "icons" => [
                '1x' => '',
                '2x' => '',
            ],
            "banners"  => [
                "low"  => "",
                "high"  => ""
            ],
            "tested"  => $plugin_data->tested_version,
            "requires_php"  => $plugin_data->php_version,
            "requires"  => $plugin_data->wordpress_version,
            "sections"  => [
                "description"  => $plugin_data->description,
                "installation"  => "Click the activate button and that's it.",
                "changelog"  => $plugin_data->change_log
            ],
            'new_version' => $plugin_data->plugin_version,
            "last_updated"  => $plugin_data->last_update,
            
        );
        if ( $license_key === $get_license_db->license_key ) {
            $update["package"] = 'http://myplugin.test/wp-content/uploads/2022/07/product-layouts-pro.zip';
            $update["download_link"] = 'http://myplugin.test/wp-content/uploads/2022/07/product-layouts-pro.zip';
        }
       
        header( 'Content-Type: application/json' );
        wp_send_json($update);
    }

}