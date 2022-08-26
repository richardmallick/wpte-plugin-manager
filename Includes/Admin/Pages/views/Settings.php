<?php
    $plugin_id = isset($_GET['id']) ? $_GET['id'] : '';

    $plugin = wpte_pm_get_plugin( $plugin_id ) ? wpte_pm_get_plugin( $plugin_id ) : (object)[];

    $image_url = wp_get_attachment_image_url($plugin->logo_id);

?>
<div class="wpte-pm-product-wrapper">
    <div class="wpte-pm-popup-inner">
        <form id="wpte-pm-product-form" action="" method="post">
            <input type="hidden" id="wpte_plugin_id" name="wpte_plugin_id" value="<?php echo intval($plugin_id); ?>">
            <div class="wpte-pm-popup-form-fields wpte-pm-form-fields">
                <div class="wpte-pm-popup-form-field-left">
                    <label for="wpte_pm_plugin_name">Plugin Name *</label>
                    <input type="text" id="wpte_pm_plugin_name" name="wpte_pm_plugin_name" value="<?php echo esc_html($plugin->plugin_name); ?>">
                    <p id="plugins-name"></p>
                </div>
                <div class="wpte-pm-popup-form-field-right">
                    <label for="wpte_pm_plugin_slug">Plugin Slug *</label>
                    <input type="text" id="wpte_pm_plugin_slug" name="wpte_pm_plugin_slug" value="<?php echo esc_html($plugin->plugin_slug); ?>">
                    <p id="plugins-slug"></p>
                </div>
            </div>
            <div class="wpte-pm-popup-form-fields wpte-pm-form-fields">
                <div class="wpte-pm-popup-form-field-left">
                    <label for="wpte_pm_plugin_version">Plugin Version *</label>
                    <input type="text" id="wpte_pm_plugin_version" name="wpte_pm_plugin_version" value="<?php echo esc_html($plugin->plugin_version); ?>">
                    <p id="plugins-version"></p>
                </div>
                <div class="wpte-pm-popup-form-field-right">
                    <label for="wpte_pm_plugin_php_version">PHP Version *</label>
                    <input type="text" id="wpte_pm_plugin_php_version" name="wpte_pm_plugin_php_version" value="<?php echo esc_html($plugin->php_version); ?>">
                    <p id="phps-version"></p>
                </div>
            </div>
            <div class="wpte-pm-popup-form-fields wpte-pm-form-fields">
                <div class="wpte-pm-popup-form-field-left">
                    <label for="wpte_pm_plugin_wordpress_version">WordPress Version *</label>
                    <input type="text" id="wpte_pm_plugin_wordpress_version" name="wpte_pm_plugin_wordpress_version" value="<?php echo esc_html($plugin->wordpress_version); ?>">
                    <p id="wp-version"></p>
                </div>
                <div class="wpte-pm-popup-form-field-right">
                    <label for="wpte_pm_plugin_wordpress_tested_version">Tested up to *</label>
                    <input type="text" id="wpte_pm_plugin_wordpress_tested_version" name="wpte_pm_plugin_wordpress_tested_version" value="<?php echo esc_html($plugin->tested_version); ?>">
                    <p id="plugins-slug"></p>
                </div>
            </div>
            <div class="wpte-pm-popup-form-fields wpte-pm-form-fields">
                <div class="wpte-pm-popup-form-field-left">
                    <label for="wpte_pm_plugin_demo_url">Demo URL *</label>
                    <input type="text" id="wpte_pm_plugin_demo_url" name="wpte_pm_plugin_demo_url" value="<?php echo esc_html($plugin->demo_url); ?>">
                    <p id="testeds-version"></p>
                </div>
                <div class="wpte-pm-popup-form-field-right">
                    <label for="wpte_pm_plugin_description">Description</label>
                    <input type="text" id="wpte_pm_plugin_description" name="wpte_pm_plugin_description" value="<?php echo esc_html($plugin->description); ?>">
                    <p></p>
                </div>
            </div>
            <div class="wpte-pm-popup-form-fields wpte-pm-form-fields">
                <div class="wpte-pm-popup-form-field">
                    <div class="wpte-pm-product-attachment-area wpte-pm-input-fluwidth">
                        <label for="wpte-pm-file-url">File *</label>
                        <input type="hidden" class="wpte-pm-file-id" name="wpte_pm_file_id" value="<?php echo $plugin->file_id; ?>">
                        <input type="text" class="wpte-pm-file-url" name="wpte_pm_file_url" value="<?php echo $plugin->file_url; ?>">
                        <button id="wpte-pm-product-attachment" data-id="0"><span class="dashicons dashicons-media-document"></span></button>
                    </div>
                    <p></p>
                </div>
            </div>
            <div class="wpte-pm-popup-form-fields wpte-pm-form-fields">
                <div class="wpte-pm-popup-form-field">
                    <label for='wpte_pm_plugin_change_log'>Change Log</label>
                    <textarea name="wpte_pm_plugin_change_log" id="wpte_pm_plugin_change_log"><?php echo $plugin->change_log; ?></textarea>
                </div>
            </div>
            <div class="wpte-pm-popup-footer">
                <div class="wpte-pm-footer-attachment">
                    <label for="">Logo</label>
                    <div id="wpte-pm-attachment">
                        <input type="hidden" class="wpte-pm-logo-id" name="wpte-pm-logo-id" value="<?php echo esc_html($plugin->logo_id); ?>">
                        <input type="hidden" class="wpte-pm-logo-url" name="wpte-pm-logo-url" value="<?php echo esc_url($image_url); ?>">
                        <?php if ( $image_url ) {?>
                            <img src="<?php echo esc_url($image_url); ?>" alt="">
                        <?php } else { ?>
                            <img src="<?php echo WPTE_PM_URL ?>/Images/kd-img.png" alt="">
                        <?php } ?>
                    </div>
                </div>
                <div class="wpte-footer-buttons">
                    <span id="wpte-add-plugin-loaders" class="spinner sa-spinner-open"></span>
                    <button type="button" class="wpte-plugin-delete-button">Delete</button>
                    <input type="submit" class="wpte-plugin-update-button" name="wpte_plugin_update" id="wpte_plugin_update" value="Update">
                </div>
            </div>
        </form>
    </div>
</div>