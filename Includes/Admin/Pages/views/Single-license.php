<?php 
$license_id     = isset($_GET['license_id']) ? $_GET['license_id'] : '';
$plugin_id      = isset($_GET['id']) ? intval($_GET['id']) : '';
$plugin         = isset($_GET['plugin']) ? esc_html($_GET['plugin']) : '';
$license        = wpte_get_product_license_row( $license_id ) ? wpte_get_product_license_row( $license_id ) : (object)[];
$license_key    = $license->license_key ? $license->license_key : '';

if ( $license->expired_date !== 'lifetime' ) {
    $_expired_date  = $license->expired_date ? $license->expired_date : ''; 
    $expired_date   = $license->expired_date ? date("M d, Y", $_expired_date) : '';
} else {
    $expired_date = 'Lifetime';
}

$status             = isset($license->status) ? $license->status : '';
$inactive = $status !== 'active' ? 'wpte-single-license-status-inactive' : '';
$activation_limit   = isset($license->activation_limit) ? $license->activation_limit : '';
$variation_status   = wpte_get_domain_status_by_license_id( $license_id );
$active_site        = $variation_status ? $variation_status : [];

$customer_id    = isset($license->customer_id) ? $license->customer_id : '';
$customer       = get_user_by('id', $customer_id);
$customer_name  = $customer->first_name . ' ' . $customer->last_name;
$product_id     = $license->product_id ? $license->product_id : '';
$product        = wpte_get_product_variation_by_id( $product_id ) ? wpte_get_product_variation_by_id( $product_id ) : (object)[];
?>
<div class="wpte-pm-add-new-area">
    <div class="wpte-pm-add-new-title">
        <h1><?php echo  esc_html__('License Details', WPTE_PM_TEXT_DOMAIN); ?></h1>
        <a href='<?php echo admin_url( "admin.php?page=wpte-plugin-manager&id=$plugin_id&plugin=$plugin" ); ?>'>Back</a>
    </div>
    <div class="wpte-pm-edit-button-area">
        <div class="wpte-pm-edit-button">
            <button><span class="dashicons dashicons-edit"></span> Edit</button>
        </div>
        <div class="wpte-pm-action-button">
            <button>Action <span class="dashicons dashicons-arrow-down-alt2"></span></button>
            <ul class="wpte-pm-action-list">
                <li id="wpte-license-deactivate" dataid="<?php echo esc_attr($license_id); ?>">Deactivate</li>
                <li id="wpte-license-active" dataid="<?php echo esc_attr($license_id); ?>">Active</li>
                <li id="wpte-license-customer-id" dataid="<?php echo esc_attr($customer_id); ?>">Resend Email</li>
                <li id="wpte-license-delete" pluginid="<?php echo esc_attr($plugin_id); ?>" dataid="<?php echo esc_attr($license_id); ?>">Delete</li>
            </ul>
        </div>
    </div>
</div>
<div class="wpte-tab-item-card wpte-pm-tab-content wpte-pm-tab-license-content">
    <div class="wpte-single-license-row-area">
        <div class="wpte-single-license-row">
            <div class="wpte-single-license-key">
                <label for="">License Key</label>
                <p><?php echo esc_html($license_key); ?></p>
            </div>
            <div class="wpte-single-license-expiry">
                <label for="">Expiry Date</label>
                <p><?php echo esc_html($expired_date);?></p>
            </div>
            <div class="wpte-single-license-status <?php echo esc_attr($inactive);?>">
                <label for="">Status</label>
                <p><?php echo esc_html(ucfirst($status)); ?></p>
            </div>
        </div>
        <div class="wpte-single-license-row">
            <div class="wpte-single-license-activation">
                <label for="">Activation Limit</label>
                <p><?php echo esc_html($activation_limit); ?></p>
            </div>
            <div class="wpte-single-license-active">
                <label for="">Active Site</label>
                <p><?php echo intval(count($active_site)); ?></p>
            </div>
            <div class="wpte-single-license-source">
                <label for="">Source</label>
                <p>-</p>
            </div>
        </div>
        <div class="wpte-single-license-row">
            <div class="wpte-single-license-order-id">
                <label for="">Order ID</label>
                <p>#<?php echo intval($license_id); ?></p>
            </div>
            <div class="wpte-single-license-variations">
                <label for="">Variations</label>
                <p><?php echo esc_html($product->variation_name); ?></p>
            </div>
            <div class="wpte-single-license-source">
                <label for="">Customer</label>
                <p><?php echo esc_html($customer_name); ?></p>
            </div>
        </div>
    </div>
</div>

<h1 style="margin-top: 50px;">Activations of this license</h1>
<div class="wpte-tab-item-card wpte-pm-tab-content wpte-pm-tab-license-content">
    <div class="wpte-single-license-row-area">
        <div class="wpte-single-license-row wpte-single-license-site">
            <h2>Site URL</h2>
            <h2>Site Name</h2>
            <h2>Site Type</h2>
            <h2>Status</h2>
            <h2>-</h2>
        </div>
        <?php
            $sites = wpte_get_domain_rows( $license_id ) ? wpte_get_domain_rows( $license_id ) : [];
            foreach( $sites as $site ) : 
                $site_url = parse_url($site->site_url, PHP_URL_HOST);
                $site_name = isset($site->site_name) && $site->site_name ? $site->site_name : '';
                $site_type = isset($site->site_type) && $site->site_type ? $site->site_type : '';
                $site_type_class = $site_type === 'Local' ? 'site-type-local' : 'site-type-live';
                $site_status = isset($site->status) && $site->status ? $site->status : '';

                if ( $site_status === 'active' ) {
                    $site_status_class = 'site-status-active';
                } elseif ( $site_status === 'inactive' ) {
                    $site_status_class =  'site-status-inactive';
                } else {
                    $site_status_class =  'site-status-blocked';
                }
                
        ?>
            <div class="wpte-single-license-row wpte-single-license-site">
                <div class="site site-url"><?php echo esc_html($site_url); ?></div>
                <div class="site site-name"><?php echo esc_html($site_name); ?></div>
                <div class="site <?php echo esc_attr($site_type_class); ?>"><span><?php echo esc_html( ucfirst($site_type) );?></span></div>
                <div class="site <?php echo esc_attr($site_status_class); ?>"><span><?php echo esc_html( ucfirst($site_status) ); ?></span></div>
                <div class="site wpte-site-action">
                    <span class="dashicons dashicons-ellipsis"></span>
                    <ul class="wpte-site-actions">
                        <li class="wpte-site-block" licenseid="<?php echo intval($site->license_id); ?>" dataid="<?php echo intval($site->id); ?>">Block</li>
                        <li class="wpte-site-inactive" licenseid="<?php echo intval($site->license_id); ?>" dataid="<?php echo intval($site->id); ?>">Inactive</li>
                        <li class="wpte-site-delete" licenseid="<?php echo intval($site->license_id); ?>" dataid="<?php echo intval($site->id); ?>">Delete</li>
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>



<div class="wpte-pm-popup-wrapper">
    <div class="wpte-pm-popup-inner">
        <div class="wpte-pm-popup-box">
            <div class="wpte-pm-popup-header">
                <h1>Edit License</h1>
                <div class="wpte-pm-popup-close">╳</div>
            </div>
            <form action="" method="post">
                <input type="hidden" id="wpte_pm_single_license_id" name="wpte_pm_single_license_id" value="<?php echo esc_attr($license_id); ?>">
                
                <div class="wpte-pm-popup-form-fields">
                    <div class="wpte-pm-popup-form-field-left">
                        <label for='wpte_pm_single_license_activation_limit'>Activation Limit</label>
                        <input type="number" id="wpte_pm_single_license_activation_limit" name="wpte_pm_single_license_activation_limit" value="<?php echo esc_attr($activation_limit); ?>">
                    </div>
                </div>
                <div class="wpte-pm-popup-footer">

                    <div class="wpte-pm-product-attachment-area">
                    </div>
                    <div class="wpte-footer-buttons">
                        <span id="wpte-add-singe-license-loader" class="spinner sa-spinner-open"></span>
                        <button type="button" class="wpte-popup-close-button">Close</button>
                        <input type="submit" class="wpte-popup-license-save-button" name="wpte_single_license_update" id="wpte_single_license_update" value="Update">
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</div>