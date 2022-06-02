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

        $installed = get_option('WPTE_pm_installed');

        if ( ! $installed ) {

            update_option('WPTE_pm_installed', time());
        }

        update_option('WPTE_pm_version', WPTE_LM_VERSION);

        add_option('WPTE_pm_activation_redirect', true);
    }

    /**
     * After Activate Plugin
     *
     * @return /Installation
     */
    public function Product_layout_db() {

        global $wpdb;
        $table_name = $wpdb->prefix . 'wpte_plugin_data';
        $charset_collate = $wpdb->get_charset_collate();

        $wpte_sql = "CREATE TABLE $table_name (
            id mediumint(5) NOT NULL AUTO_INCREMENT,
            plugin_name varchar(50) NOT NULL,
            plugin_slug varchar(50) NOT NULL,
            plugin_version varchar(20) NOT NULL,
            php_version varchar(20) NOT NULL,
            wordpress_version varchar(20) NOT NULL,
            tested_version varchar(20) NOT NULL,
            demo_url varchar(50),
            description longtext,
            created_date timestamp,
            logo_id mediumint(10),
            PRIMARY KEY  (id)
        ) $charset_collate";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta($wpte_sql);

        }
    
}