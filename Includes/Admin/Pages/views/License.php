<?php 
$plugin_id = isset( $_GET['id'] ) ? intval($_GET['id']) : '';
$licenses = wpte_get_product_license( $plugin_id ) ? wpte_get_product_license( $plugin_id ) : [];
$variations = wpte_get_product_variations( $plugin_id ) ? wpte_get_product_variations( $plugin_id ) : [];

?>
<div class="wpte-pm-license-wrapper">
    <div class="wpte-pm-license-header">
        <div class="wpte-pm-license-row">
            <div class="wpte-pm-license-header-content">License Key</div>
            <div class="wpte-pm-license-header-content">Limit</div>
            <div class="wpte-pm-license-header-content">Active</div>
            <div class="wpte-pm-license-header-content">Customer</div>
            <div class="wpte-pm-license-header-content">Status</div>
            <div class="wpte-pm-license-header-content">Expier Date</div>
            <div class="wpte-pm-license-header-content">View</div>
        </div>
    </div>
    <div class="wpte-pm-license-body">
        <?php foreach ( $licenses as $license ) : 
        $license_key = isset($license->license_key) ? $license->license_key : '';
        $activation_limit = isset($license->activation_limit) ? $license->activation_limit : '';
        $active = isset($license->active) ? $license->active : '';
        $_created_date = isset($license->created_date) ? strtotime($license->created_date) : ''; 
        $created_date = isset($license->created_date) ? date("M d, Y", $_created_date) : '';
        $plugin_id = isset($_GET['id']) ? $_GET['id'] : '';
        $plugin = isset($_GET['plugin']) ? $_GET['plugin'] : '';
        $license_id = isset($license->id) ? $license->id : '';
        $customer_id = isset($license->customer_id) ? $license->customer_id : '';
        
        if ( $license->expired_date !== 'lifetime' ) {
            $_expired_date = $license->expired_date ? $license->expired_date : ''; 
            $expired_date = $license->expired_date ? date("M d, Y", $_expired_date) : '';
        } else {
            $expired_date = 'Life Time';
        }

        $customer = get_user_by('id', $customer_id);
        $customer_name = $customer->first_name . ' ' . $customer->last_name;
        ?>
        <div class="wpte-pm-license-row">
            <div class="wpte-pm-license-row-content"><span class="license-key"><?php echo esc_html($license_key); ?></span></div>
            <div class="wpte-pm-license-row-content"><span><?php echo intval($activation_limit); ?></span></div>
            <div class="wpte-pm-license-row-content"><?php echo intval($active); ?></div>
            <div class="wpte-pm-license-row-content">
                <a href="#"><?php echo esc_html($customer_name); ?></a>
                <span><?php echo esc_html($customer->user_email); ?></span>
            </div>
            <div class="wpte-pm-license-row-content">
                <?php if ( $license->status === 'active' ) {
                    echo '<span class="site-type-live">'.esc_html('Active', WPTE_PM_TEXT_DOMAIN).'</span>'; 
                } else {
                    echo '<span class="site-type-inactive">'.esc_html('Inactive', WPTE_PM_TEXT_DOMAIN).'</span>'; 
                }; ?>
            </div>
            <div class="wpte-pm-license-row-content"><?php echo esc_html($expired_date); ?></div>
            <div class="wpte-pm-license-row-content" ><a href="<?php echo admin_url( "admin.php?page=wpte-plugin-manager&id=$plugin_id&plugin=$plugin&license_id=$license_id" ); ?>"><span class="dashicons dashicons-edit"></span></a></div>
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
                        <label for='wpte_pm_license_first_name'>First Name *</label>
                        <input type="text" id='wpte_pm_license_first_name' name='wpte_pm_license_first_name' value="" required>
                        <p></p>
                    </div>
                    <div class="wpte-pm-popup-form-field-middle">
                        <label for='wpte_pm_license_last_name'>Last Name *</label>
                        <input type="text" id='wpte_pm_license_last_name' name='wpte_pm_license_last_name' value="" required>
                        <p></p>
                    </div>
                    <div class="wpte-pm-popup-form-field-right">
                        <label for='wpte_pm_license_email'>Email Address *</label>
                        <input type="email" id='wpte_pm_license_email' name='wpte_pm_license_email' value="" required>
                        <p></p>
                    </div>
                </div>
                <div class="wpte-pm-popup-form-fields">
                    <div class="wpte-pm-popup-form-field-left">
                        <label for='wpte_pm_license_product'>Product</label>
                        <select name="wpte_pm_license_product" id="wpte_pm_license_product">
                            <option value="active">--Select--</option>
                            <?php foreach( $variations as $variation ) { ?>
                                <option value="<?php echo intval($variation->id); ?>" ><?php echo esc_html($variation->variation_name); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="wpte-pm-popup-form-field-right">
                        <label for='wpte_pm_license_is_active'>Is Active</label>
                        <select name="wpte_pm_license_is_active" id="wpte_pm_license_is_active">
                            <option value="active">Active</option>
                            <option value="deactive">Deactive</option>
                        </select>
                    </div>
                </div>
                <div class="wpte-pm-popup-footer">

                    <div class="wpte-pm-product-attachment-area">
                    </div>
                    <div class="wpte-footer-buttons">
                        <span id="wpte-add-plugin-loader" class="spinner sa-spinner-open"></span>
                        <button type="button" class="wpte-popup-delete-button">Delete</button>
                        <input type="submit" class="wpte-popup-license-save-button" name="wpte_popup_licnese_submit" id="wpte_popup_licnese_submit" value="Save">
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</div>