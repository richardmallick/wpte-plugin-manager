<?php

namespace WPTE_PM_MANAGER\Includes\Admin;

/**
 * Ajax Handaler Class
 * 
 * @since 1.0.0
 */
class Ajax{

    use Email\Invoice;

    public $errors = [];

    /**
     * Ajax class constructor
     * 
     * @since 1.0.0
     */
    function __construct(){
        add_action( 'wp_ajax_wpte_add_new_plugin', [$this, 'wpte_add_new_plugin'] );
        add_action( 'wp_ajax_wpte_add_product', [$this, 'wpte_add_product'] );
        add_action( 'wp_ajax_wpte_add_license', [$this, 'wpte_add_license'] );
        add_action( 'wp_ajax_wpte_update_license', [$this, 'wpte_update_license'] );
        add_action( 'wp_ajax_wpte_license_delete', [$this, 'wpte_license_delete'] );
        add_action( 'wp_ajax_wpte_plugin_update', [$this, 'wpte_plugin_update'] );
        add_action( 'wp_ajax_wpte_plugin_delete', [$this, 'wpte_plugin_delete'] );
    }

    /**
     * Add New Plugin
     * 
     * @since 1.0.0
     */
    function wpte_add_new_plugin() {

        if ( !current_user_can( 'manage_options' ) ) {
            return;
        }

        if ( ! wp_verify_nonce( wp_unslash($_REQUEST['_nonce']), 'wpte-insert-nonce' ) ) {
            return esc_html__( 'Nonce Varification Failed!', WPTE_PM_TEXT_DOMAIN );
        }

        $args = isset($_POST['data']) ? $_POST['data'] : [];

        $plugin_name = $args['plugin_name'] ? sanitize_text_field($args['plugin_name']) : '';
        $plugin_slug = $args['plugin_slug'] ? sanitize_text_field($args['plugin_slug']) : '';
        $plugin_version = $args['plugin_version'] ? sanitize_text_field($args['plugin_version']) : '';
        $php_version = $args['php_version'] ? sanitize_text_field($args['php_version']) : '';
        $wordpress_version = $args['wordpress_version'] ? sanitize_text_field($args['wordpress_version']) : '';
        $tested_version = $args['tested_version'] ? sanitize_text_field($args['tested_version']) : '';
        $demo_url = $args['demo_url'] ? sanitize_url($args['demo_url']) : '';
        $description = $args['description'] ? sanitize_text_field($args['description']) : '';
        $logo_id = $args['logo_id'] ? sanitize_text_field($args['logo_id']) : '';

        if ( empty( $plugin_name ) ) {
            $this->errors['plugin_name'] = __("Plugin Name field is required!", WPTE_PM_TEXT_DOMAIN);
        }

        if ( empty( $plugin_slug ) ) {
            $this->errors['plugin_slug'] = __("Plugin Slug field is required!", WPTE_PM_TEXT_DOMAIN);
        }

        if ( empty( $plugin_slug ) ) {
            $this->errors['plugin_slug'] = __("Plugin Slug field is required!", WPTE_PM_TEXT_DOMAIN);
        }

        if ( empty( $plugin_version ) ) {
            $this->errors['plugin_version'] = __("Plugin Version field is required!", WPTE_PM_TEXT_DOMAIN);
        }

        if ( empty( $php_version ) ) {
            $this->errors['php_version'] = __("PHP Version field is required!", WPTE_PM_TEXT_DOMAIN);
        }

        if ( empty( $wordpress_version ) ) {
            $this->errors['wordpress_version'] = __("WordPress Version field is required!", WPTE_PM_TEXT_DOMAIN);
        }

        if ( empty( $tested_version ) ) {
            $this->errors['tested_version'] = __("Tested Version field is required!", WPTE_PM_TEXT_DOMAIN);
        }

        if ( $this->errors ) {
            wp_send_json_success( [
                'errors' =>  $this->errors,
            ] );
            return false;
        }
        

        $insert_id = wpte_pm_add_plugin( [
            'plugin_name'  => $plugin_name,
            'plugin_slug'  => $plugin_slug,
            'plugin_version'=> $plugin_version,
            'php_version'  => $php_version,
            'wordpress_version' => $wordpress_version,
            'tested_version' => $tested_version,
            'demo_url' => $demo_url,
            'description' => $description,
            'logo_id' => $logo_id,
            'created_date' => current_time('mysql'),

        ] );

        wpte_pm_add_product( [
            'plugin_id' => $insert_id
        ] );

        wp_send_json_success( [
            'added' =>  __( 'Your plugin has beed added', WPTE_PM_TEXT_DOMAIN ),
        ] );

        if ( is_wp_error( $insert_id ) ) {
            wp_send_json_error( [
                'message' => __( 'Data Insert Failed Please retry again!', WPTE_PM_TEXT_DOMAIN ),
            ] );
        }
 
    }

    /**
     * Update Plugin
     * 
     * @since 1.0.0
     */
    public function wpte_plugin_update() {
        
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        if ( ! wp_verify_nonce( wp_unslash($_REQUEST['_nonce']), 'wpte-insert-nonce' ) ) {
            return esc_html__( 'Nonce Varification Failed!', WPTE_PM_TEXT_DOMAIN );
        }

        $args = isset($_POST['data']) ? $_POST['data'] : [];

        $plugin_id = $args['plugin_id'] ? sanitize_text_field($args['plugin_id']) : '';
        $plugin_name = $args['plugin_name'] ? sanitize_text_field($args['plugin_name']) : '';
        $plugin_slug = $args['plugin_slug'] ? sanitize_text_field($args['plugin_slug']) : '';
        $plugin_version = $args['plugin_version'] ? sanitize_text_field($args['plugin_version']) : '';
        $php_version = $args['php_version'] ? sanitize_text_field($args['php_version']) : '';
        $wordpress_version = $args['wordpress_version'] ? sanitize_text_field($args['wordpress_version']) : '';
        $tested_version = $args['tested_version'] ? sanitize_text_field($args['tested_version']) : '';
        $demo_url = $args['demo_url'] ? sanitize_url($args['demo_url']) : '';
        $description = $args['description'] ? sanitize_text_field($args['description']) : '';
        $logo_id = $args['logo_id'] ? sanitize_text_field($args['logo_id']) : '';

        if ( empty( $plugin_name ) ) {
            $this->errors['plugin_name'] = __("Plugin Name field is required!", WPTE_PM_TEXT_DOMAIN);
        }

        if ( empty( $plugin_slug ) ) {
            $this->errors['plugin_slug'] = __("Plugin Slug field is required!", WPTE_PM_TEXT_DOMAIN);
        }

        if ( empty( $plugin_slug ) ) {
            $this->errors['plugin_slug'] = __("Plugin Slug field is required!", WPTE_PM_TEXT_DOMAIN);
        }

        if ( empty( $plugin_version ) ) {
            $this->errors['plugin_version'] = __("Plugin Version field is required!", WPTE_PM_TEXT_DOMAIN);
        }

        if ( empty( $php_version ) ) {
            $this->errors['php_version'] = __("PHP Version field is required!", WPTE_PM_TEXT_DOMAIN);
        }

        if ( empty( $wordpress_version ) ) {
            $this->errors['wordpress_version'] = __("WordPress Version field is required!", WPTE_PM_TEXT_DOMAIN);
        }

        if ( empty( $tested_version ) ) {
            $this->errors['tested_version'] = __("Tested Version field is required!", WPTE_PM_TEXT_DOMAIN);
        }

        if ( $this->errors ) {
            wp_send_json_success( [
                'update_errors' =>  $this->errors,
            ] );
            return false;
        }
        
        wpte_plugin_updater( $plugin_id, $plugin_name, $plugin_slug, $plugin_version, $php_version, $wordpress_version, $tested_version, $demo_url, $description, $logo_id );

        wp_send_json_success( [
            'update' =>  __( 'Update', WPTE_PM_TEXT_DOMAIN ),
            'updated' =>  __( 'Updated', WPTE_PM_TEXT_DOMAIN ),
        ] );

    }

     /**
     * Get Variation Payment checkbox value
     * 
     * Get Checked value and Uncked Value
     * 
     * @since 1.0.0
     */
    function get_variation_recurring_payment($chk_name) {

        $found = [];

        foreach($chk_name as $key => $val) {

            if($val == '1') { 
                $found[] = $key;
            }
        }

        foreach($found as $kev_f => $val_f) {
            unset($chk_name[$val_f-1]);
        }   

        $final_arr = [];
        return $final_arr = array_values($chk_name);
    }

     /**
     *  Add Product in Plugin
     * 
     * @since 1.0.0
     */
    function wpte_add_product() {
        if ( !current_user_can( 'manage_options' ) ) {
            return;
        }

        if ( ! wp_verify_nonce( wp_unslash($_REQUEST['_nonce']), 'wpte-insert-nonce' ) ) {
            return esc_html__( 'Nonce Varification Failed!', WPTE_PM_TEXT_DOMAIN );
        }

        $data = isset($_POST['data']) ? $_POST['data'] : [];


        $plugin_id      = isset($data['wpte_plugin_id']) ? sanitize_text_field($data['wpte_plugin_id']) : '';
        $product_name   = isset($data['wpte_product_name']) ? sanitize_text_field($data['wpte_product_name']) : '';
        $product_slug   = isset($data['wpte_product_slug']) ? sanitize_text_field($data['wpte_product_slug']) : '';
        $is_variation   = isset($data['wpte_pm_is_variation']) ? sanitize_text_field($data['wpte_pm_is_variation']) : '';
        
        wpte_product_update( $plugin_id, $product_name, $product_slug, $is_variation);

        // Variation Products
        $variation_name     = isset($data['wpte_pm_variation_name']) ? $data['wpte_pm_variation_name'] : '';
        $variation_slug     = isset($data['wpte_pm_variation_path']) ? $data['wpte_pm_variation_path'] : '';
        $activation_limit   = isset($data['wpte_pm_variation_activation_limit']) ? $data['wpte_pm_variation_activation_limit'] : '';
        $variation_price    = isset($data['wpte_pm_variation_price']) ? $data['wpte_pm_variation_price'] : '';
        $files_name         = isset($data['wpte_pm_files_name']) ? $data['wpte_pm_files_name'] : '';
        $variation_file     = isset($data['wpte_pm_file_id']) ? $data['wpte_pm_file_id'] : '';
        $recurring_payment  = $this->get_variation_recurring_payment($data['wpte_pm_variation_recurring_payment']);
        $recurring_period   = isset($data['wpte_pm_variation_recurring_period']) ? $data['wpte_pm_variation_recurring_period'] : '';
        $recurring_times    = isset($data['wpte_pm_variation_recurring_times']) ? $data['wpte_pm_variation_recurring_times'] : '';
        $product_variation_id    = isset($data['product_variation_id']) ? $data['product_variation_id'] : '';
        $product_variation_id_remove    = isset($data['product_variation_id_remove']) ? $data['product_variation_id_remove'] : '';

        $variation_count = count($variation_name);
        for( $i = 0; $i < $variation_count; $i++ ) {
            $variation = [
                'plugin_id'         => $plugin_id,
                'variation_name'    => $variation_name[$i],
                'variation_slug'    => $variation_slug[$i],
                'activation_limit'  => $activation_limit[$i],
                'variation_price'   => $variation_price[$i],
                'files_name'        => $files_name[$i],
                'variation_file'    => $variation_file[$i],
                'recurring_payment' => $recurring_payment[$i],
                'recurring_period'  => strtolower($recurring_period[$i]),
                'recurring_times'   => $recurring_times[$i],
            ];

            if ( $product_variation_id_remove[$i] ) {
                wpte_product_variation_delete($product_variation_id[$i]);
            } elseif ( ! $product_variation_id[$i] ) {
                wpte_pm_add_product_variation($variation);
            } else {
                wpte_product_variation_update( $product_variation_id[$i], $variation_name[$i], $variation_slug[$i], $activation_limit[$i], $variation_price[$i], $files_name[$i], $variation_file[$i], $recurring_payment[$i], strtolower($recurring_period[$i]), $recurring_times[$i] );
            }
            
        }
        
        wp_send_json_success( [
            'added' =>  __( 'Your Product has beed added', WPTE_PM_TEXT_DOMAIN ),
        ] );

        // if ( is_wp_error( $insert_id ) ) {
        //     wp_send_json_error( [
        //         'message' => __( 'Data Insert Failed Please retry again!', WPTE_PM_TEXT_DOMAIN ),
        //     ] );
        // }
    }

    /**
     * Add New License
     */
    public function wpte_add_license(){

        if ( !current_user_can( 'manage_options' ) ) {
            return;
        }

        if ( ! wp_verify_nonce( wp_unslash($_REQUEST['_nonce']), 'wpte-insert-nonce' ) ) {
            return esc_html__( 'Nonce Varification Failed!', WPTE_PM_TEXT_DOMAIN );
        }

        $data = isset($_POST['data']) ? $_POST['data'] : '';

        // This code for create License
        $token = openssl_random_pseudo_bytes(16);
        $token = bin2hex($token);

        $produt_id = isset($data['wpte_pm_license_product']) && $data['wpte_pm_license_product'] ? sanitize_text_field($data['wpte_pm_license_product']) : '';
        $product = wpte_get_product_variation_by_id( $produt_id ) ? wpte_get_product_variation_by_id( $produt_id ) : (object)[];

        if ( isset($product->recurring_payment) && $product->recurring_payment ) {
            $recurring_period = $product->recurring_period;
            $recurring_times = $product->recurring_times;
            $timestamp = strtotime(current_time('mysql'));
            $expired_date = strtotime("+$recurring_times $recurring_period", $timestamp); 
            //$expired_date = date("Y-m-d h:i:s", $timestamp);
        } else {
            $expired_date = 'lifetime';
        }

        $email      = isset($data['wpte_pm_license_email']) && $data['wpte_pm_license_email'] ? sanitize_email($data['wpte_pm_license_email']) : '';
        $first_name = isset($data['wpte_pm_license_first_name']) && $data['wpte_pm_license_first_name'] ? sanitize_text_field($data['wpte_pm_license_first_name']) : '';
        $last_name  = isset($data['wpte_pm_license_last_name']) && $data['wpte_pm_license_last_name'] ? sanitize_text_field($data['wpte_pm_license_last_name']) : '';
        $password   = wpte_generate_password(16);

        $user_id = wpte_add_new_user($email, $password, $first_name, $last_name);

        $args = [
            'plugin_id'         => $data['wpte_pm_license_plugin_id'],
            'license_key'       => $token,
            'activation_limit'  => $product->activation_limit,
            'active'            => 0,
            'customer_id'       => $user_id,
            'status'            => $data['wpte_pm_license_is_active'],
            'product_id'        => $produt_id,
            'recurring_payment' => $product->recurring_payment,
            'recurring_period'  => $product->recurring_period,
            'recurring_times'   => $product->recurring_times,
            'active_site'       => 0,
            'created_date'      => current_time('mysql'),
            'expired_date'      => $expired_date,
        ];

        // Create License
        $insert_id = wpte_pm_create_license( $args );

        // Send Invoice to customer
        if ( $insert_id ) {

            $to = [
                $data['wpte_pm_license_email']
            ];
            $headers        = 'From: WPTOFFEE < order@wptoffee.com > ' . "\r\n";
            $subject        = "Your order of ".$data['wpte_pm_license_product_name']." is completed";
            $emailtemplate  = $this->wpte_invoice( $insert_id );
            $message = <<<EOT
                    {$emailtemplate}
EOT;
            add_filter(
                'wp_mail_content_type',
                function ( $content_type ) {
                    return 'text/html';
                }
            );
            $email_sent = wp_mail( $to, $subject, $message, $headers );
        }

        wp_send_json_success( [
            'added' =>  __( 'Your License has beed added', WPTE_PM_TEXT_DOMAIN ),
        ] );

        if ( is_wp_error( $insert_id ) ) {
            wp_send_json_error( [
                'message' => __( 'Data Insert Failed Please retry again!', WPTE_PM_TEXT_DOMAIN ),
            ] );
        }
    }

    /**
     * Update License
     */
    public function wpte_update_license(){
        
        if ( !current_user_can( 'manage_options' ) ) {
            return;
        }

        if ( ! wp_verify_nonce( wp_unslash($_REQUEST['_nonce']), 'wpte-insert-nonce' ) ) {
            return esc_html__( 'Nonce Varification Failed!', WPTE_PM_TEXT_DOMAIN );
        }

        $data = isset($_POST['data']) ? $_POST['data'] : '';

        $license_id         = isset($data['wpte_pm_license_id']) ? intval($data['wpte_pm_license_id']) : '';
        $customer_name      = isset($data['wpte_pm_license_customer_name']) ? $data['wpte_pm_license_customer_name'] : '';
        $customer_email     = isset($data['wpte_pm_license_email']) ? $data['wpte_pm_license_email'] : '';
        $product_name       = isset($data['wpte_pm_license_product_name']) ? esc_html($data['wpte_pm_license_product_name']) : '';
        $product_slug       = isset($data['wpte_pm_license_product_slug']) ? esc_html($data['wpte_pm_license_product_slug']) : '';
        $activation_limit   = isset($data['wpte_pm_license_activation_limit']) ? intval($data['wpte_pm_license_activation_limit']) : '';
        $product_price      = isset($data['wpte_pm_license_product_price']) ? esc_html($data['wpte_pm_license_product_price']) : '';
        $files_name         = isset($data['wpte_pm_license_file_name']) ? esc_html($data['wpte_pm_license_file_name']) : '';
        $product_file       = isset($data['wpte_pm_file_id'][0]) ? intval($data['wpte_pm_file_id'][0]) : '';
        $recurring_payment  = isset($data['wpte_pm_license_recurring_payment']) ? esc_html($data['wpte_pm_license_recurring_payment']) : 0;
        $recurring_period   = isset($data['wpte_pm_license_recurring_period']) ? esc_html($data['wpte_pm_license_recurring_period']) : '';
        $recurring_times    = isset($data['wpte_pm_license_recurring_times']) ? intval($data['wpte_pm_license_recurring_times']) : '';
        $is_active          = isset($data['wpte_pm_license_is_active']) ? esc_html($data['wpte_pm_license_is_active']) : '';

        wpte_product_license_update( $license_id, $customer_name, $customer_email, $product_name, $product_slug, $activation_limit, $product_price, $files_name, $product_file, $recurring_payment, $recurring_period, $recurring_times, $is_active );

        $get_license = wpte_get_product_license_row( $license_id ) ?  wpte_get_product_license_row( $license_id ) : (object)[];
        if ( $is_active === 'deactive' ){
            $domains     = $get_license->domain ? json_decode($get_license->domain, true) : [];
            $activated = $get_license->activated;
            $domain_arg = [];
            foreach( $domains as $domain ) {
                $url = $domain.'/wp-json/wpte/v1/deactivate';
                $args = array(
                    'headers' => array(
                        'Content-Type'  => 'application/json; charset=utf-8', 
                        'authorization' =>  'sdafdsafdsafdf' 
                    ),
                    'body' => json_encode([
                        'is_active' => 'deactive'
                    ]),
                    'data_format' => 'body',
                );
                $request = wp_remote_post($url, $args);

                if ( $request ) {
                    $activated = - 1;
                    $domain_arg = $domain;
                }
            }
            wpte_product_license_deactive( $license_id,  $activated, json_encode($domain_arg) );
            
        }
        wp_send_json_success( [
            'added' =>  __( 'Your License has beed Updated', WPTE_PM_TEXT_DOMAIN ),
        ] );

    }

    /**
     * Delete License
     */
    public function wpte_license_delete() {
        if ( !current_user_can( 'manage_options' ) ) {
            return;
        }

        if ( ! wp_verify_nonce( wp_unslash( $_REQUEST['_nonce'] ), 'wpte-insert-nonce' ) ) {
            return esc_html__( 'Nonce Varification Failed!', WPTE_PM_TEXT_DOMAIN );
        }

        $id = isset( $_POST['id'] ) ? $_POST['id'] : '';

        wpte_product_license_delete( $id );

        wp_send_json_success( [
            'deleted' =>  __( 'Your License has beed Deleted', WPTE_PM_TEXT_DOMAIN ),
        ] );
    }

    public function wpte_plugin_delete() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        if ( ! wp_verify_nonce( wp_unslash( $_REQUEST['_nonce'] ), 'wpte-insert-nonce' ) ) {
            return esc_html__( 'Nonce Varification Failed!', WPTE_PM_TEXT_DOMAIN );
        }

        $id = isset( $_POST['id'] ) ? $_POST['id'] : '';

        wpte_plugin_delete( $id );

        wp_send_json_success( [
            'plugin_url' =>  admin_url( 'admin.php?page=wpte-plugin-manager' ),
        ] );
    }
   
}