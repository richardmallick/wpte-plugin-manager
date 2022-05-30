<?php

namespace WPTE_PM_MANAGER\Includes;

/**
 * Plugin Installation Class
 * 
 * @since 1.0.0
 */
class Installation{

    /**
     * Installation class constructor
     * 
     * Database
     * 
     * @since 1.0.0
     */
    public function __construct(){
 
        $this->Activate();
        $this->Product_layout_db();

    }


    /**
     * After Activate Plugin
     *
     * @return /Installation
     */
    public function Activate() {

        $installed = get_option('WPTE_lm_installed');

        if ( ! $installed ) {

            update_option('WPTE_lm_installed', time());
        }

        update_option('WPTE_lm_version', WPTE_LM_VERSION);

        add_option('WPTE_lm_activation_redirect', true);
    }

    /**
     * After Activate Plugin
     *
     * @return /Installation
     */
    public function Product_layout_db() {

        global $wpdb;
        $table_name = $wpdb->prefix . 'wpte_license_manager_product';
        $charset_collate = $wpdb->get_charset_collate();

        $wpte_sql = "CREATE TABLE $table_name (
		        id mediumint(5) NOT NULL AUTO_INCREMENT,
                title varchar(50) NOT NULL,
                product_file varchar(180) NOT NULL,
                product_path varchar(40) NOT NULL,
                product_id mediumint(5) NOT NULL,
                created_date timestamp,
                PRIMARY KEY  (id)
        ) $charset_collate";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta($wpte_sql);

        }
    
}