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
        $plugin_data = $wpdb->prefix . 'wpte_plugin_data';
        $product_data = $wpdb->prefix . 'wpte_product_data';
        $product_variation = $wpdb->prefix . 'wpte_product_variation';
        $charset_collate = $wpdb->get_charset_collate();

        $wpte_sql = "CREATE TABLE $plugin_data (
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

        $sql_two = "CREATE TABLE $product_data (
            id mediumint(5) NOT NULL AUTO_INCREMENT,
            plugin_id mediumint(5) NOT NULL,
            product_name varchar(50) NOT NULL,
            product_slug varchar(50) NOT NULL,
            is_variation varchar(10),
            product_prices longtext,
            product_variation longtext,
            created_date timestamp,
            PRIMARY KEY  (id)
        ) $charset_collate";

        $sql_three = "CREATE TABLE $product_variation (
            id mediumint(5) NOT NULL AUTO_INCREMENT,
            plugin_id mediumint(5) NOT NULL,
            variation_name varchar(50) NOT NULL,
            variation_slug varchar(50) NOT NULL,
            activation_limit mediumint(5) NOT NULL,
            variation_price mediumint(5) NOT NULL,
            variation_file mediumint(10) NOT NULL,
            recurring_payment mediumint(5) NOT NULL,
            recurring_period varchar(15) NOT NULL,
            recurring_times mediumint(5) NOT NULL,
            created_date timestamp,
            PRIMARY KEY  (id)
        ) $charset_collate";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta($wpte_sql);
        dbDelta($sql_two);
        dbDelta($sql_three);

    }
    
}