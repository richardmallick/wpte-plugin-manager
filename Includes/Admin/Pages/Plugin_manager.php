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
        wp_enqueue_media();
        wp_enqueue_style('wpte-plugin-manager-style');
        wp_enqueue_script('wpte-pm-serializejson');
        wp_enqueue_script('wpte-pm-main');
        wp_localize_script('wpte-pm-main', 'wptePlugin', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'wpte_nonce' => wp_create_nonce('wpte-insert-nonce'),
            'error'   => __('Something Went Wrong!', WPTE_PM_TEXT_DOMAIN)
        ]);
        if ( ! isset($_GET['plugin']) && ! isset($_GET['id']) ) {

            $this->Elements_Render();
            
        } else {
            new Single_plugin;
        }
    }

    /**
     * Elements Render
     *
     * @since 1.0.0
     */
    public function Elements_Render() {

        $arg = [
            'number'   => 20,
            'offset'   => 0,
            'orderby' => 'ID',
            'order'    => 'ASC',
        ];

        $Plugins = wpte_pm_get_plugins() ? wpte_pm_get_plugins($arg) : [];
        $Plugins = array_reverse($Plugins);

        // echo "<pre>";
        //     print_r($Plugins);
        // echo "</pre>";

      

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
                        <?php foreach( $Plugins as $Plugin ): ?>
                        <div class="wpte-pm-card">
                           <div class="wpte-pm-card-header">
                                <a href="<?php echo admin_url("admin.php?page=wpte-plugin-manager&id=".$Plugin->id."&plugin=".$Plugin->plugin_slug.""); ?>">
                                    <div class="wpte-pm-plugin-icon-area">
                                    <?php   
                                        if ( $Plugin->logo_id ) {
                                            echo wp_get_attachment_image( $Plugin->logo_id, 'thumbnail' );
                                        } else {
                                            ?>
                                                <img src="<?php echo  WPTE_PM_URL ?>/Images/kd-img.png" alt="" srcset="">
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </a>
                                <div class="wpte-pm-plugin-details-area">
                                    <div class="wpte-pm-plugin-name"> <a href="<?php echo admin_url("admin.php?page=wpte-plugin-manager&id=".$Plugin->id."&plugin=".$Plugin->plugin_slug.""); ?>"><?php echo esc_html__($Plugin->plugin_name, WPTE_PM_TEXT_DOMAIN); ?></a></div>
                                    <div class="wpte-pm-plugin-slug"><?php echo esc_html__($Plugin->plugin_slug, WPTE_PM_TEXT_DOMAIN); ?></div>
                                    <div class="wpte-pm-plugin-version"><strong><?php echo esc_html__('Version:', WPTE_PM_TEXT_DOMAIN); ?></strong> <?php echo esc_html__($Plugin->plugin_version, WPTE_PM_TEXT_DOMAIN); ?></div>
                                </div>
                           </div>
                           <div class="wpte-pm-card-footer"></div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                </div>
            </div>
        </div>

        <div class="wpte-pm-popup-wrapper">
           <div class="wpte-pm-popup-inner">
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
                            <label for='wpte_pm_plugin_slug'>Plugin Slug *</label>
                            <input type="text" id='wpte_pm_plugin_slug' name='wpte_pm_plugin_slug'>
                            <p id="plugin-slug"></p>
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
                    <div class="wpte-pm-popup-footer">
                        <div class="wpte-pm-footer-attachment">
                            <label for=''>Logo</label>
                            <div id="wpte-pm-attachment">
                                    <input type="hidden" class="wpte-pm-logo-id" name="wpte-pm-logo-id" value="">
                                    <input type="hidden" class="wpte-pm-logo-url" name="wpte-pm-logo-url" value="">
                                    <img src="<?php echo WPTE_PM_URL ?>/Images/kd-img.png" alt="">
                            </div>
                        </div>
                        <div class="wpte-footer-buttons">
                            <span id="wpte-add-plugin-loader" class="spinner sa-spinner-open"></span>
                            <button type="button" class="wpte-popup-close-button">Close</button>
                            <input type="submit" class="wpte-popup-save-button" name="wpte_popup_form_submit" id="wpte_popup_form_submit" value="Save">
                        </div>
                    </div>
                </form>
                
            </div>
           </div>
        </div>
        <?php
    }
}