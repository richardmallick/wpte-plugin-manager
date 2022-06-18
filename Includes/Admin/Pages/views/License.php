<?php 
$plugin_id = isset( $_GET['id'] ) ? intval($_GET['id']) : '';
$licenses = wpte_get_product_license( $plugin_id ) ? wpte_get_product_license( $plugin_id ) : [];

// echo "<pre>";
//     print_r($licenses);
// echo "</pre>";
?>
<div class="wpte-pm-license-wrapper">
    <div class="wpte-pm-license-header">
        <div class="wpte-pm-license-row">
            <div class="wpte-pm-license-header-content">License Key</div>
            <div class="wpte-pm-license-header-content">Activation Limit</div>
            <div class="wpte-pm-license-header-content">Created Date</div>
            <div class="wpte-pm-license-header-content">Action</div>
            <div class="wpte-pm-license-header-content">Edit</div>
        </div>
    </div>
    <div class="wpte-pm-license-body">
        <?php foreach ( $licenses as $license ) :  ?>
        <div class="wpte-pm-license-row">
            <div class="wpte-pm-license-row-content"><?php echo esc_html($license->license_key); ?></div>
            <div class="wpte-pm-license-row-content"><?php echo esc_html($license->activation_limit); ?></div>
            <div class="wpte-pm-license-row-content"><?php echo esc_html($license->created_date); ?></div>
            <div class="wpte-pm-license-row-content">Active <span><?php //echo esc_html($license['activated']); ?>/<?php echo esc_html($license->activation_limit); ?></span></div>
            <div class="wpte-pm-license-row-content wpte-pm-license-edit" id="wpte-pm-license-edit-<?php echo esc_html($license->id); ?>" data_id="<?php echo esc_html($license->id); ?>"><span class="dashicons dashicons-edit"></span></div>
        </div>
        <?php endforeach;  ?>
    </div>
</div>


<div class="wpte-pm-popup-wrapper">
           <div class="wpte-pm-popup-inner">
                <div class="wpte-pm-popup-loader">
                    <img src="<?php echo WPTE_PM_URL . '/Images/loader.webp' ?>" alt="">
                </div>
                <div class="wpte-pm-popup-box">
                    <div class="wpte-pm-popup-header">
                        <h1>Edit License</h1>
                        <div class="wpte-pm-popup-close">╳</div>
                    </div>
                    <form action="" method="post">
                        <input type="hidden" name="wpte_pm_license_plugin_id" value="<?php echo intval($plugin_id); ?>">
                        <div class="wpte-pm-popup-form-fields">
                            <div class="wpte-pm-popup-form-field-left">
                                <label for='wpte_pm_license_email'>Customer Email</label>
                                <input type="email" id='wpte_pm_license_email' name='wpte_pm_license_email' value="">
                                <p></p>
                            </div>
                            <div class="wpte-pm-popup-form-field-right">
                                <label for='wpte_pm_license_product_name'>Product Name</label>
                                <input type="text" id='wpte_pm_license_product_name' name='wpte_pm_license_product_name'>
                                <p></p>
                            </div>
                        </div>
                        <div class="wpte-pm-popup-form-fields">
                            <div class="wpte-pm-popup-form-field-left">
                                <label for='wpte_pm_license_product_slug'>Product Slug</label>
                                <input type="text" id='wpte_pm_license_product_slug' name='wpte_pm_license_product_slug'>
                                <p></p>
                            </div>
                            <div class="wpte-pm-popup-form-field-right">
                                <label for='wpte_pm_license_activation_limit'>Activation Limit</label>
                                <input type="number" id='wpte_pm_license_activation_limit' name='wpte_pm_license_activation_limit'>
                                <p></p>
                            </div>
                        </div>
                        <div class="wpte-pm-popup-form-fields">
                            <div class="wpte-pm-popup-form-field-left">
                                <label for='wpte_pm_license_product_price'>Price</label>
                                <input type="text" id='wpte_pm_license_product_price' name='wpte_pm_license_product_price'>
                                <p></p>
                            </div>
                            <div class="wpte-pm-popup-form-field-right wpte-pm-popup-form-field-checkbox">
                                <label for='wpte_pm_license_recurring_payment'>Recurring Payment <input type="checkbox" id='wpte_pm_license_recurring_payment' name='wpte_pm_license_recurring_payment'></label>
                                <p></p>
                            </div>
                        </div>
                        <div class="wpte-pm-popup-form-fields">
                            <div class="wpte-pm-popup-form-field-left">
                                <label for='wpte_pm_license_recurring_period'>Recurring Period</label>
                                <input type="text" id='wpte_pm_license_recurring_period' name='wpte_pm_license_recurring_period'>
                            </div>
                            <div class="wpte-pm-popup-form-field-right">
                                <label for='wpte_pm_license_recurring_times'>Recurring Times</label>
                                <input type="number" id='wpte_pm_license_recurring_times' name='wpte_pm_license_recurring_times'>
                            </div>
                        </div>
                        <div class="wpte-pm-popup-footer">
                            <div class="wpte-pm-footer-attachment">
                                <label for=''>File</label>
                                <div id="wpte-pm-product-attachment-area">
                                    <input type="hidden" id="wpte-pm-file-id" class="wpte-pm-file-id" name="wpte_pm_file_id[]" value="">
                                    <input type="text" id="wpte-pm-file-url" class="wpte-pm-file-url" name="wpte_pm_file_url[]" value="">
                                    <button id="wpte-pm-product-attachment" data-id="0">Choose File</button>
                                </div>
                            </div>
                            <div class="wpte-footer-buttons">
                                <span id="wpte-add-plugin-loader" class="spinner sa-spinner-open"></span>
                                <button type="button" class="wpte-popup-close-button">Delete</button>
                                <input type="submit" class="wpte-popup-save-button" name="wpte_popup_form_submit" id="wpte_popup_form_submit" value="Update">
                            </div>
                        </div>
                    </form>
                    
                </div>
           </div>
        </div>