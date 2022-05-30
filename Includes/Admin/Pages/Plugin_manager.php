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
                        <div class="wpte-pm-cart">
                            <div class="wpte-pm-plugin-icon-area"><img src="https://ps.w.org/wc-thank-you-page/assets/icon-256x256.jpg?rev=2444508"></div>
                            <div class="wpte-pm-plugin-details-area">
                                <div class="wpte-pm-plugin-name">WC Thank You Page</div>
                                <div class="wpte-pm-plugin-slug">wc-thank-you-page</div>
                                <div class="wpte-pm-plugin-version">Version: 1.0.3</div>
                            </div>
                        </div>
                        <div class="wpte-pm-cart">
                            <div class="wpte-pm-plugin-icon-area"><img src="https://ps.w.org/wc-thank-you-page/assets/icon-256x256.jpg?rev=2444508"></div>
                            <div class="wpte-pm-plugin-details-area">
                                <div class="wpte-pm-plugin-name">WC Thank You Page</div>
                                <div class="wpte-pm-plugin-slug">wc-thank-you-page</div>
                                <div class="wpte-pm-plugin-version">Version: 1.0.3</div>
                            </div>
                        </div>
                        <div class="wpte-pm-cart">
                            <div class="wpte-pm-plugin-icon-area"><img src="https://ps.w.org/wc-thank-you-page/assets/icon-256x256.jpg?rev=2444508"></div>
                            <div class="wpte-pm-plugin-details-area">
                                <div class="wpte-pm-plugin-name">WC Thank You Page</div>
                                <div class="wpte-pm-plugin-slug">wc-thank-you-page</div>
                                <div class="wpte-pm-plugin-version">Version: 1.0.3</div>
                            </div>
                        </div>
                        <div class="wpte-pm-cart">
                            <div class="wpte-pm-plugin-icon-area"><img src="https://ps.w.org/wc-thank-you-page/assets/icon-256x256.jpg?rev=2444508"></div>
                            <div class="wpte-pm-plugin-details-area">
                                <div class="wpte-pm-plugin-name">WC Thank You Page</div>
                                <div class="wpte-pm-plugin-slug">wc-thank-you-page</div>
                                <div class="wpte-pm-plugin-version">Version: 1.0.3</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php
    }
}