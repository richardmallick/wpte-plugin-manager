<?php

namespace WPTE_PM_MANAGER\Includes\Admin\Pages;

/**
 * Plugin Manager
 *
 * @since 1.0.0
 */
class Plugin_manager{
    /**
     * Plugin Manager class constructor
     *
     * @since 1.0.0
     */
    public function __construct() {

        $this->Render_Plugins();
    }

    /**
     * All Element Render in Admin page
     *
     * @since 1.0.0
     */
    public function Render_Plugins() {
        wp_enqueue_style('wpte-plugin-manager-style');
        wp_enqueue_script('wpte-pm-main');
        wp_localize_script('wpte-pm-main', 'wptePlugin', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'wpte_nonce' => wp_create_nonce('wpte-insert-nonce'),
            'error'   => __('Something Went Wrong!', WPTE_WPL_TEXT_DOMAIN)
        ]);
        $this->Elements_Render();
    }

    /**
     * Elements List
     *
     * @since 1.0.0
     */
    public function Plugins() {
        return [
            'general' => [
                'name'    => 'general-layouts',
                'status'  => 'New', //Popular, Updated, Premium
                'icon'    => WPTE_PM_URL . '/Image/general.svg',
                'src'     => '',
                'version' => 1.0,
            ],
            'calltoaction'  => [
                'name'    => 'call-to-action-layouts',
                'status'  => 'Coming...',
                'icon'    => WPTE_PM_URL . '/Image/call-to-action.svg',
                'src'     => '',
                'version' => 1.0,
            ]
        ];
    }

    /**
     * Elements Render
     *
     * @since 1.0.0
     */
    public function Elements_Render() {

        $Plugins = $this->Plugins();

        ?>
        <div class="wpte-pm-row">
            <div class="wpte-pm-wrapper">
                <div class="wpte-pm-row">
                    <div class="wpte-pm-add-new-area">
                        <h2><?php echo __('Plugin', WPTE_PM_TEXT_DOMAIN); ?></h2>
                        <div class="wpte-pm-add-new-button">
                            <button><?php echo '<span class="dashicons dashicons-admin-plugins"></span> '. __('Add Plugin', WPTE_PM_TEXT_DOMAIN); ?></button>
                        </div>
                    </div>
                    <div class="wpte-pm-card-wrapper">
                        <div class="wpte-pm-card">
                           <div class="wpte-pm-card-header">
                            <div class="wpte-pm-plugin-icon-area"><img src="https://ps.w.org/wc-thank-you-page/assets/icon-256x256.jpg?rev=2444508"></div>
                                <div class="wpte-pm-plugin-details-area">
                                    <div class="wpte-pm-plugin-name">WC Thank You Page</div>
                                    <div class="wpte-pm-plugin-slug">wc-thank-you-page</div>
                                    <div class="wpte-pm-plugin-version"><strong>Version:</strong> 1.0.3</div>
                                </div>
                           </div>
                           <div class="wpte-pm-card-footer"></div>
                        </div>
                        <div class="wpte-pm-card">
                           <div class="wpte-pm-card-header">
                            <div class="wpte-pm-plugin-icon-area"><img src="https://ps.w.org/wc-thank-you-page/assets/icon-256x256.jpg?rev=2444508"></div>
                                <div class="wpte-pm-plugin-details-area">
                                    <div class="wpte-pm-plugin-name">WC Thank You Page</div>
                                    <div class="wpte-pm-plugin-slug">wc-thank-you-page</div>
                                    <div class="wpte-pm-plugin-version"><strong>Version:</strong> 1.0.3</div>
                                </div>
                           </div>
                           <div class="wpte-pm-card-footer"></div>
                        </div>
                        <div class="wpte-pm-card">
                           <div class="wpte-pm-card-header">
                            <div class="wpte-pm-plugin-icon-area"><img src="https://ps.w.org/wc-thank-you-page/assets/icon-256x256.jpg?rev=2444508"></div>
                                <div class="wpte-pm-plugin-details-area">
                                    <div class="wpte-pm-plugin-name">WC Thank You Page</div>
                                    <div class="wpte-pm-plugin-slug">wc-thank-you-page</div>
                                    <div class="wpte-pm-plugin-version"><strong>Version:</strong> 1.0.3</div>
                                </div>
                           </div>
                           <div class="wpte-pm-card-footer"></div>
                        </div>
                        <div class="wpte-pm-card">
                           <div class="wpte-pm-card-header">
                            <div class="wpte-pm-plugin-icon-area"><img src="https://ps.w.org/wc-thank-you-page/assets/icon-256x256.jpg?rev=2444508"></div>
                                <div class="wpte-pm-plugin-details-area">
                                    <div class="wpte-pm-plugin-name">WC Thank You Page</div>
                                    <div class="wpte-pm-plugin-slug">wc-thank-you-page</div>
                                    <div class="wpte-pm-plugin-version"><strong>Version:</strong> 1.0.3</div>
                                </div>
                           </div>
                           <div class="wpte-pm-card-footer"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="wpte-pm-popup-wrapper">
            <div class="wpte-pm-popup-box">
                <div class="wpte-pm-popup-header">
                    <h1>Add New Plugin</h1>
                    <div class="wpte-pm-popup-close">╳</div>
                </div>
                <form action="" method="post">
                    <div class="wpte-pm-popup-form-fields">
                        <div class="wpte-pm-popup-form-field-left">
                            <label for='wpte_pm_plugin_name'>Plugin Name *</label>
                            <input type="text" id='wpte_pm_plugin_name' name='wpte_pm_plugin_name'>
                            <p id="plugin-name"></p>
                        </div>
                        <div class="wpte-pm-popup-form-field-right">
                            <label for='wpte_pm_plugin_slug'>Plugin Slug</label>
                            <input type="text" id='wpte_pm_plugin_slug' name='wpte_pm_plugin_slug'>
                        </div>
                    </div>
                    <div class="wpte-pm-popup-form-fields">
                        <div class="wpte-pm-popup-form-field-left">
                            <label for='wpte_pm_plugin_version'>Plugin Version *</label>
                            <input type="text" id='wpte_pm_plugin_version' name='wpte_pm_plugin_version'>
                            <p id="plugin-version"></p>
                        </div>
                        <div class="wpte-pm-popup-form-field-right">
                            <label for='wpte_pm_plugin_php_version'>PHP Version *</label>
                            <input type="text" id='wpte_pm_plugin_php_version' name='wpte_pm_plugin_php_version'>
                            <p id="php-version"></p>
                        </div>
                    </div>
                    <div class="wpte-pm-popup-form-fields">
                        <div class="wpte-pm-popup-form-field-left">
                            <label for='wpte_pm_plugin_wordpress_version'>WordPress Version *</label>
                            <input type="text" id='wpte_pm_plugin_wordpress_version' name='wpte_pm_plugin_wordpress_version'>
                            <p id="wp-version"></p>
                        </div>
                        <div class="wpte-pm-popup-form-field-right">
                            <label for='wpte_pm_plugin_wordpress_tested_version'>Tested up to *</label>
                            <input type="text" id='wpte_pm_plugin_wordpress_tested_version' name='wpte_pm_plugin_wordpress_tested_version'>
                            <p id="tested-version"></p>
                        </div>
                    </div>
                    <div class="wpte-pm-popup-form-fields">
                        <div class="wpte-pm-popup-form-field-left">
                            <label for='wpte_pm_plugin_demo_url'>Demo URL</label>
                            <input type="text" id='wpte_pm_plugin_demo_url' name='wpte_pm_plugin_demo_url'>
                        </div>
                        <div class="wpte-pm-popup-form-field-right">
                            <label for='wpte_pm_plugin_description'>Description</label>
                            <input type="text" id='wpte_pm_plugin_description' name='wpte_pm_plugin_description'>
                        </div>
                    </div>
                </form>
                <div class="wpte-pm-popup-footer">
                    <span id="wpte-add-plugin-loader" class="spinner sa-spinner-open"></span>
                    <button type="button" class="wpte-popup-close-button">Close</button>
                    <input type="submit" class="wpte-popup-save-button" name="wpte_popup_form_submit" id="wpte_popup_form_submit" value="Save">
                </div>
            </div>
        </div>
        <?php
    }
}