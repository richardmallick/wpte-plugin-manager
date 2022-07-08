<?php 
$license_id  = isset($_GET['license_id']) ? $_GET['license_id'] : '';
$license      = wpte_get_product_license_row( $license_id ) ? wpte_get_product_license_row( $license_id ) : (object)[];
$license_key = $license->license_key ? $license->license_key : '';
if ( $license->expired_date !== 'lifetime' ) {
    $_expired_date = $license->expired_date ? $license->expired_date : ''; 
    $expired_date = $license->expired_date ? date("M d, Y", $_expired_date) : '';
} else {
    $expired_date = 'Lifetime';
}
$active = isset($license->active) ? $license->active : '';
$activation_limit = isset($license->activation_limit) ? $license->activation_limit : '';
?>
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
            <div class="wpte-single-license-status">
                <label for="">Status</label>
                <p><?php echo esc_html($active); ?></p>
            </div>
        </div>
        <div class="wpte-single-license-row">
            <div class="wpte-single-license-activation">
                <label for="">Activation Limit</label>
                <p><?php echo esc_html($activation_limit); ?></p>
            </div>
            <div class="wpte-single-license-active">
                <label for="">Active Site</label>
                <p>24</p>
            </div>
            <div class="wpte-single-license-source">
                <label for="">Source</label>
                <p>-</p>
            </div>
        </div>
        <div class="wpte-single-license-row">
            <div class="wpte-single-license-order-id">
                <label for="">Order ID</label>
                <p>#3424</p>
            </div>
            <div class="wpte-single-license-variations">
                <label for="">Variations</label>
                <p>Product Layouts Pro Lifetime</p>
            </div>
            <div class="wpte-single-license-source">
                <label for="">Customer</label>
                <p>Richard Mallick</p>
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
        <div class="wpte-single-license-row wpte-single-license-site">
            <div class="site site-url">wptoffee.com</div>
            <div class="site site-name">wptoffee</div>
            <div class="site site-type-live"><span>Live</span></div>
            <div class="site site-status-active"><span>Active</span></div>
            <div class="site site-action">...</div>
        </div>
    </div>
</div>