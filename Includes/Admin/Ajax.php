<?php

namespace WPTE_PM_MANAGER\Includes\Admin;


/**
 * Ajax Handaler Class
 * 
 * @since 1.0.0
 */
class Ajax{

    public $errors = [];

    /**
     * Ajax class constructor
     * 
     * @since 1.0.0
     */
    function __construct(){
        add_action( 'wp_ajax_wpte_add_new_plugin', [$this, 'wpte_add_new_plugin'] );
        add_action( 'wp_ajax_wpte_add_product', [$this, 'wpte_add_product'] );
        add_action( 'wp_ajax_wpte_get_license_data', [$this, 'wpte_get_license_data'] );
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
                wpte_product_variation_update( $product_variation_id[$i], $variation_name[$i], $variation_slug[$i], $activation_limit[$i], $variation_price[$i], $variation_file[$i], $recurring_payment[$i], strtolower($recurring_period[$i]), $recurring_times[$i] );
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

    public function wpte_get_license_data() {
        if ( !current_user_can( 'manage_options' ) ) {
            return;
        }

        $id = isset($_POST['id']) ? $_POST['id'] : '';

        $license = wpte_get_product_license_row( $id );

        $file = wp_get_attachment_url($license->product_file);

        wp_send_json_success( [
            'customer_email'    =>  $license->customer_email,
            'product_name'      =>  $license->product_name,
            'product_slug'      =>  $license->product_slug,
            'activation_limit'  =>  $license->activation_limit,
            'product_price'     =>  $license->product_price,
            'recurring_payment' =>  $license->recurring_payment,
            'recurring_period'  =>  $license->recurring_period,
            'recurring_times'   =>  $license->recurring_times,
            'product_file_url'      =>  $file,
            'product_file_id'      =>  $license->product_file,
        ] );

    }
   
}