<?php

namespace WPTE_PM_MANAGER\Includes\Frontend;

/**
 * My Account Class
 * 
 * @since 1.0.0
 */
class Shortcodes{

    /**
     * My Account class constructor
     * 
     * @since 1.0.0
     */
    function __construct(){
        add_shortcode('wpte_licenses', [$this, 'wpte_licenses']);
        add_shortcode('wpte_orders', [$this, 'wpte_orders']);
        add_shortcode('wpte_downloads', [$this, 'wpte_downloads']);
        add_shortcode('wpte_my_account', [$this, 'wpte_my_account']);
    }

    public function wpte_licenses() {
        $renderer = new Render\LicensesRenderer();
        return $renderer->show();
    } 

    public function wpte_orders() {
        $renderer = new Render\OrdersRenderer();
        return $renderer->show();
    } 

    public function wpte_downloads() {
        $renderer = new Render\DownloadsRenderer();
        return $renderer->show();
    } 

    public function wpte_my_account() {

        $renderer = new Render\MyAccount();
        return $renderer->show();

    } 
}