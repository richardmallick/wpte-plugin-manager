<?php
/**
 * Plugin Name:       Wpte Plugin Manager
 * Plugin URI:        https://wptoffee.com
 * Description:       This is Plugin Manager Plugin for Fast Spring. You can create license and sell your wordpress plugin using this plugin.
 * Version:           1.0.0
 * Author:            WPTOFFEE
 * Author URI:        https://wptoffee.com
 * Text Domain:       wpte-plugin-manager
 * License:           GPLv2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

if ( ! defined( 'ABSPATH' ) ) {
    wp_die( esc_html__( 'You can\'t access this page', 'wpte-plugin-manager' ) );
}

/**
 * Included Autoload File
 */
require_once __DIR__ . '/vendor/autoload.php';

/** If class `Product_Layouts` doesn't exists yet. */
if ( ! class_exists( 'wpte_plugin_manager' ) ) {

    /**
     * Sets up and initializes the plugin.
     * Main initiation class
     *
     * @since 1.0.0
     */
    final class wpte_plugin_manager {

        /**
         * Plugin Version
         */
        const VERSION = '1.0.0';

        /**
         * Php Version
         */
        const MIN_PHP_VERSION = '5.6.20';

        /**
         * WordPress Version
         */
        const MIN_WP_VERSION = '4.0';

        /**
         * Class Constractor
         */
        private function __construct() {

            $this->define_constance();
            register_activation_hook( __FILE__, [$this, 'activate'] );
            add_action( "plugins_loaded", [$this, 'init_plugin'] );
            add_action( 'init', [$this, 'i18n'] );
            add_action( 'admin_init', [$this, 'activation_redirect'] );
            add_filter( 'plugin_action_links_' . plugin_basename( WPTE_PM_FILE ), [__CLASS__, 'WPTE_pm_action_links'] );
        }

        /**
         * Initilize a singleton instance
         *
         * @return /Product_Layouts
         */
        public static function init() {

            static $instance = false;

            if ( ! $instance ) {

                $instance = new self();
            }

            return $instance;
        }

        /**
         * Plugin Constance
         *
         * @return void
         */
        public function define_constance() {

            define( 'WPTE_PM_VERSION', self::VERSION );
            define( 'WPTE_PM_FILE', __FILE__ );
            define( 'WPTE_PM_PATH', plugin_dir_path( __FILE__ ) );
            define( 'WPTE_PM_URL', plugins_url( '', WPTE_PM_FILE ) );
            define( 'WPTE_PM_ASSETS', WPTE_PM_URL . '/assets/' );
            define( 'WPTE_PM_TEXT_DOMAIN', 'wpte-plugin-manager' );
            define( 'WPTE_PM_MINIMUM_PHP_VERSION', self::MIN_PHP_VERSION );
            define( 'WPTE_PM_MINIMUM_WP_VERSION', self::MIN_WP_VERSION );
        }

        /**
         * Load Textdomain
         *
         * Load plugin localization files.
         *
         * Fired by `init` action hook.
         *
         * @since 1.0.0
         *
         * @access public
         */
        public function i18n() {
            load_plugin_textdomain( WPTE_PM_TEXT_DOMAIN );
        }

        /**
         * After Activate Plugin
         *
         * Fired by `register_activation_hook` hook.
         *
         * @return void
         *
         * @since 1.0.0
         *
         * @access public
         */
        public function activate() {

            new WPTE_PM_MANAGER\Includes\Installation();

        }

        /**
         * Plugins Loaded
         *
         * @return void
         */
        public function init_plugin() {
            if ( is_admin() ) {
                new WPTE_PM_MANAGER\Includes\Admin();
                new WPTE_PM_MANAGER\Includes\Assets();
            }
            new WPTE_PM_MANAGER\Includes\Api();
            new WPTE_PM_MANAGER\Includes\Frontend();
        }

        /**
         *
         * Redirect to settings page after activation the plugin
         */
        public function activation_redirect() {

            if ( get_option( 'WPTE_pm_activation_redirect', false ) ) {

                delete_option( 'WPTE_pm_activation_redirect' );

                wp_safe_redirect( admin_url( 'admin.php?page=wpte-plugin-manager' ) );
                exit();
            }
        }

        /**
         *
         * Plugin Page Settings menu
         * 
         * @param $links
         */
        public static function WPTE_pm_action_links( $links ) {

            if ( !current_user_can( 'manage_options' ) ) {
                return $links;
            }

            $links = array_merge(
                [
                    sprintf(
                        '<a href="%s">%s</a>',
                        admin_url( 'admin.php?page=wpte-plugin-manager' ),
                        esc_html__( 'Settings', WPTE_PM_TEXT_DOMAIN )
                    ),
                ], $links );

            return $links;
        }

    }

}

/**
 * Initilize the main plugin
 *
 * @return /WPTE_license_manager
 */
function WPTE_plugin_manager() {

    if ( class_exists( 'wpte_plugin_manager' ) ) {
        return wpte_plugin_manager::init();
    }

    return;
}

/**
 * Kick-off the plugin
 */
WPTE_plugin_manager();
