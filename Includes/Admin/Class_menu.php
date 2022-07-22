<?php

namespace WPTE_PM_MANAGER\Includes\Admin;


/**
 * Admin Menu Class
 * 
 * @since 1.0.0
 */
class Class_menu{

    use Pages\AdminTopMenu;

    /**
     * Menu class constructor
     * 
     * @since 1.0.0
     */
    function __construct(){
        add_action("admin_menu", [ $this, 'adminMenu'] );
        $this->admin_menu();
    }

    /**
     * Admin Menu Method
     * 
     * @since 1.0.0
     */
    public function admin_menu() {
        add_filter('wpte_plugin_manager_admin_menu', [ $this, 'wpte_admin_menu']);
    }

    /**
     * Register Admin Menue
     *
     * @return void
     */
    public function adminMenu(){
        $user = 'manage_options';
        add_menu_page(__('Plugin Manager', WPTE_PM_TEXT_DOMAIN), __('Plugin Manager', WPTE_PM_TEXT_DOMAIN), $user, 'wpte-plugin-manager', [ $this, 'wpte_plugins_page'], 'dashicons-layout', 57);
        add_submenu_page('wpte-plugin-manager', __('Plugins', WPTE_PM_TEXT_DOMAIN), __('Plugins', WPTE_PM_TEXT_DOMAIN), $user, 'wpte-plugin-manager', [$this, 'wpte_plugins_page']);
        add_submenu_page('wpte-plugin-manager',  __('License', WPTE_PM_TEXT_DOMAIN),  __('License', WPTE_PM_TEXT_DOMAIN), $user, 'wpte-plugin-manager-license', [$this, 'Plugins_license']);
        add_submenu_page('wpte-plugin-manager', __('Settings', WPTE_PM_TEXT_DOMAIN), __('Settings', WPTE_PM_TEXT_DOMAIN), $user, 'wpte-plugin-manager-settings', [$this, 'Plugins_Settings']);
        wp_enqueue_style('wpte-plugin-sweetalert2');
        wp_enqueue_script('wpte-pm-sweetalert2');
    }

    /**
     * Plugin Admin Menu
     *
     * @return void
     */
    public function wpte_plugins_page(){
        apply_filters('wpte_plugin_manager_admin_menu', true);
        new Pages\Plugin_manager;
    }
    /**
     * Plugins License
     *
     * @return void
     */
    public function Plugins_license(){
        apply_filters('wpte_plugin_manager_admin_menu', true);
        
    }
    /**
     * Plugin Settings
     *
     * @return void
     */
    public function Plugins_Settings(){
        apply_filters('wpte_plugin_manager_admin_menu', true);
        
    }

   
}