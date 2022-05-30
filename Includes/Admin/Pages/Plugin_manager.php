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
                    <div class="wpte-pm-popup-close">x</div>
                </div>
                <form action="" method="post">
                    <table>
                        <tr>
                            <td>Plugin Name</td>
                            <td><input type="text" name="wpte_pm_plugin_name"></td>
                        </tr>
                        <tr>
                            <td>Plugin Slug</td>
                            <td><input type="text" name="wpte_pm_plugin_slug"></td>
                        </tr>
                        <tr>
                            <td>Plugin Version</td>
                            <td><input type="text" name="wpte_pm_plugin_version"></td>
                        </tr>
                        <tr>
                            <td>PHP Version</td>
                            <td><input type="text" name="wpte_pm_plugin_php_version"></td>
                        </tr>
                        <tr>
                            <td>WordPress Version</td>
                            <td><input type="text" name="wpte_pm_plugin_wordpress_version"></td>
                        </tr>
                        <tr>
                            <td>Tested up to</td>
                            <td><input type="text" name="wpte_pm_plugin_wordpress_tested_version"></td>
                        </tr>
                        <tr>
                            <td>Demo URL</td>
                            <td><input type="text" name="wpte_pm_plugin_demo_url"></td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td><input type="text" name="wpte_pm_plugin_description"></td>
                        </tr>
                    </table>
                </form>
                <div class="wpte-pm-popup-footer">
                    <span id="create-loader" class="spinner sa-spinner-open"></span>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-success" name="addonsdatasubmit" id="addonsdatasubmit" value="Save">
                </div>
            </div>
        </div>
        <?php
    }
}