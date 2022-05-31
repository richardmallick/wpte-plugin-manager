<?php

namespace WPTE_PM_MANAGER\Includes\Admin;


/**
 * Ajax Handaler Class
 * 
 * @since 1.0.0
 */
class Ajax{

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
        

        $insert_id = wpte_pm_add_plugin( $args );

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