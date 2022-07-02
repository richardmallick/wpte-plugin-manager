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
            <div class="wpte-pm-license-header-content">ID</div>
            <div class="wpte-pm-license-header-content">License Key</div>
            <div class="wpte-pm-license-header-content">Activation</div>
            <div class="wpte-pm-license-header-content">Created Date</div>
            <div class="wpte-pm-license-header-content">Expired Date</div>
            <div class="wpte-pm-license-header-content">Status</div>
            <div class="wpte-pm-license-header-content">Edit</div>
        </div>
    </div>
    <div class="wpte-pm-license-body">
        <?php foreach ( $licenses as $license ) : 
        $_created_date = $license->created_date ? strtotime($license->created_date) : ''; 
        $created_date = $license->created_date ? date("M d, Y", $_created_date) : '';    
        
        if ( $license->expired_date !== 'lifetime' ) {
            $_expired_date = $license->expired_date ? $license->expired_date : ''; 
            $expired_date = $license->expired_date ? date("M d, Y", $_expired_date) : '';
        } else {
            $expired_date = 'Life Time';
        }
           
        ?>
        <div class="wpte-pm-license-row">
            <div class="wpte-pm-license-row-content"><?php echo "#". intval($license->id); ?></div>
            <div class="wpte-pm-license-row-content"><code><?php echo esc_html($license->license_key); ?></code></div>
            <div class="wpte-pm-license-row-content"><span><?php echo ($license->activated ? esc_html($license->activated) : 0); ?>/<?php echo esc_html($license->activation_limit); ?></span></div>
            <div class="wpte-pm-license-row-content"><?php echo esc_html($created_date); ?></div>
            <div class="wpte-pm-license-row-content"><?php echo esc_html($expired_date); ?></div>
            <div class="wpte-pm-license-row-content">
                <?php if ( $license->is_active === 'active' ) {
                    echo '<span style="color:green">'.esc_html('Active', WPTE_PM_TEXT_DOMAIN).'</span>'; 
                } else {
                    echo '<span style="color:orange">'.esc_html('Deactive', WPTE_PM_TEXT_DOMAIN).'</span>'; 
                }; ?>
            </div>
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
        <div class="wpte-pm-popup-box popup-box-width">
            <div class="wpte-pm-popup-header">
                <h1>Add License</h1>
                <div class="wpte-pm-popup-close">╳</div>
            </div>
            <form action="" method="post">
                <input type="hidden" name="wpte_pm_license_plugin_id" value="<?php echo intval($plugin_id); ?>">
                <input type="hidden" id="wpte_pm_license_id" name="wpte_pm_license_id" value="">
                <div class="wpte-pm-popup-form-fields">
                    <div class="wpte-pm-popup-form-field-left">
                        <label for='wpte_pm_license_customer_name'>Customer Name *</label>
                        <input type="email" id='wpte_pm_license_customer_name' name='wpte_pm_license_customer_name' value="" required>
                        <p></p>
                    </div>
                    <div class="wpte-pm-popup-form-field-middle">
                        <label for='wpte_pm_license_email'>Customer Email *</label>
                        <input type="email" id='wpte_pm_license_email' name='wpte_pm_license_email' value="" required>
                        <p></p>
                    </div>
                    <div class="wpte-pm-popup-form-field-right">
                        <label for='wpte_pm_license_product_name'>Product Name *</label>
                        <input type="text" id='wpte_pm_license_product_name' name='wpte_pm_license_product_name' required>
                        <p></p>
                    </div>
                </div>
                <div class="wpte-pm-popup-form-fields">
                    <div class="wpte-pm-popup-form-field-left">
                        <label for='wpte_pm_license_product_slug'>Product Slug *</label>
                        <input type="text" id='wpte_pm_license_product_slug' name='wpte_pm_license_product_slug' required>
                        <p></p>
                    </div>
                    <div class="wpte-pm-popup-form-field-middle">
                        <label for='wpte_pm_license_activation_limit'>Activation Limit</label>
                        <input type="number" id='wpte_pm_license_activation_limit' name='wpte_pm_license_activation_limit'>
                        <p></p>
                    </div>
                    <div class="wpte-pm-popup-form-field-right">
                        <label for='wpte_pm_license_product_price'>Price *</label>
                        <input type="number" id='wpte_pm_license_product_price' name='wpte_pm_license_product_price' required>
                        <p></p>
                    </div>
                </div>
                <div class="wpte-pm-popup-form-fields">
                    <div class="wpte-pm-popup-form-field-left wpte-pm-popup-form-field-checkbox">
                        <label for='wpte_pm_license_recurring_payment'>Recurring Payment <input type="checkbox" id='wpte_pm_license_recurring_payment' name='wpte_pm_license_recurring_payment' value="1"></label>
                        <p></p>
                    </div>
                    <div class="wpte-pm-popup-form-field-middle">
                        <label for='wpte_pm_license_recurring_period'>Recurring Period</label>
                        <select name="wpte_pm_license_recurring_period" id="wpte_pm_license_recurring_period">
                            <option value="days">Days</option>
                            <option value="months">Months</option>
                            <option value="years">Years</option>
                        </select>
                        <p></p>
                    </div>
                    <div class="wpte-pm-popup-form-field-right">
                        <label for='wpte_pm_license_recurring_times'>Recurring Times</label>
                        <input type="number" id='wpte_pm_license_recurring_times' name='wpte_pm_license_recurring_times'>
                        <p></p>
                    </div>
                </div>
                <div class="wpte-pm-popup-form-fields">
                    <div class="wpte-pm-popup-form-field-left">
                        <label for='wpte_pm_license_is_active'>Is Active</label>
                        <select name="wpte_pm_license_is_active" id="wpte_pm_license_is_active">
                            <option value="active">Active</option>
                            <option value="deactive">Deactive</option>
                        </select>
                    </div>
                    <div class="wpte-pm-popup-form-field-right">
                        <label for='wpte_pm_license_file_name'>File Name *</label>
                        
                        <input type="text" id='wpte_pm_license_file_name' name='wpte_pm_license_file_name' required>
                    </div>
                </div>
                <div class="wpte-pm-popup-footer">

                    <div class="wpte-pm-product-attachment-area">
                        <label for="wpte-pm-file-url">File * :</label>
                        <input type="hidden" class="wpte-pm-file-id" name="wpte_pm_file_id[]" value="0">
                        <input type="text" class="wpte-pm-file-url" name="wpte_pm_file_url[]" value="">
                        <button id="wpte-pm-product-attachment" data-id="0"><span class="dashicons dashicons-media-document"></span></button>
                    </div>
                    <div class="wpte-footer-buttons">
                        <span id="wpte-add-plugin-loader" class="spinner sa-spinner-open"></span>
                        <button type="button" class="wpte-popup-delete-button">Delete</button>
                        <input type="submit" class="wpte-popup-save-button" name="wpte_popup_form_submit" id="wpte_popup_form_submit" value="Update">
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</div>