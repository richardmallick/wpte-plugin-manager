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
    }

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
            'created_date' => current_time('mysql'),

        ] );

        wp_send_json_success( [
            'success' =>  __( 'Your plugin has beed added', WPTE_PM_TEXT_DOMAIN ),
        ] );

        if ( is_wp_error( $insert_id ) ) {
            wp_send_json_error( [
                'message' => __( 'Data Insert Failed Please retry again!', WPTE_PM_TEXT_DOMAIN ),
            ] );
        }
 
    }



   
}