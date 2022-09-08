<?php
namespace WPTE_PM_MANAGER\Includes\Frontend\Render;

class LicensesRenderer {

    /**
     * Output licenses
     *
     * @return string
     */
    public function show() {
        wp_enqueue_style( 'wpte-pm-my-account' );
        wp_enqueue_script( 'wpte-pm-my-account-js' );

        wp_localize_script('wpte-pm-my-account-js', 'wpteMyAc', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'ajaxNonce' => wp_create_nonce('wpte-myac-nonce'),
            'error'   => __('Something Went Wrong!', WPTE_PM_TEXT_DOMAIN)
        ]);

        // If user not logged in
        if ( ! is_user_logged_in() ) {
            return '<div class="wpte-notice notice-error">You must logged in to get licenses.</div>';
        }

        ob_start();

        do_action( 'before_wpte_myaccount_license_table' );
        ?>
        <div class="wpte-licenses">

            <?php
                $licenses = $this->get_licenses();

                if ( count( $licenses ) > 0 ) :

                    foreach ( $licenses as $license ) {
                        $this->single_license_output( $license );
                    }

                else:
            ?>
                <div class="wpte-notice notice-info">No licenses found.</div>
            <?php endif; ?>

        </div>

        <?php

        do_action( 'after_wpte_myaccount_license_table' );

        return ob_get_clean();
    }

    /**
     * Print activations
     */
    private function print_activations( $license, $activations = [] ) {
        ?>
        <div class="license-key-activations">
            <div class="wpte-license-key">
                <p>
                    <strong>Key</strong>
                    <span class="tooltip">
                        <span class="license-key-code"><?php echo esc_html( $license->license_key ); ?></span>
                        <span class="tooltiptext">Click to Copy</span>
                    </span>
                    <?php if ( !empty($license->file_url) ) : ?>
                    <a class="download-btn" href="<?php echo $license->file_url; ?>">Download</a>
                    <?php endif; ?>
                </p>
            </div>
            <div class="wpte-activations">
                <?php if ( count( $activations ) > 0 ) : ?>
                <h4>Activations</h4>

                <?php foreach ( $activations as $activation ) : ?>
                <div class="wpte-activation-item">
                    <span>
                        <?php echo $activation->site_url; ?>

                        <?php if ( $activation->site_type == 'Local' ) : ?>
                            <small class="badge text-normal" style="margin-left: 5px">Local</small>
                            <!-- <span class="tooltip">
                                <i class="as-icon-info"></i>
                                <small class="tooltiptext text-normal" style="min-width: 260px; margin-left: -130px">Local sites are whitelisted and they do not increase the number of your total activated sites</small>
                            </span> -->
                        <?php endif; ?>
                    </span>
                    <a href="#" data-activationid="<?php echo $activation->id; ?>" data-licenseid="<?php echo $license->id; ?>" class="remove-activation-button">Remove</a>
                </div>
                <?php endforeach; ?>

                <?php else: ?>
                    <p style="margin: 0;">No activations found.</p>
                <?php endif; ?>
            </div>
        </div>

        <?php
    }

    /**
     * Licenses of an user
     */
    public function get_licenses() {

        $user_id = get_current_user_id();
        $licenses = wpte_get_data_for_license_by_user_id( $user_id );
        return $licenses ? $licenses : [];
    }

    /**
     * Print single license
     */
    public function single_license_output( $license ) {

        $plugin_name    = isset( $license->plugin_name ) ? $license->plugin_name : '';
        $variation_name = isset( $license->variation_name ) ? $license->variation_name : '';
        $expired_date   = isset( $license->expired_date ) && intval($license->expired_date) ? date('M d, Y', $license->expired_date) : 'Unlimited';
        $activations    = wpte_get_domain_by_license_id( $license->id ) ? wpte_get_domain_by_license_id( $license->id ) : [];
        $remaining      = $this->activationRemaining( $license, $activations );
        ?>
        <div class="wpte-license" data-showing="0">
            <div class="license-header">
                <div class="license-product-info">
                    <div class="license-product-title">
                        <h2><?php echo esc_html($plugin_name); ?></h2>
                        <p class="h3"><?php echo esc_html($variation_name); ?></p>
                    </div>
                    <div class="license-product-expire">
                        <h4>Expires On</h4>
                        <p class="h3"><?php echo esc_html($expired_date); ?></p>
                    </div>
                    <div class="license-product-activation">
                        <h4>Activations Remaining</h4>
                        <p class="h3"><?php echo intval($remaining); ?></p>
                    </div>
                </div>
                <div class="license-toggle-info">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129"><g><path d="m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z"/></g></svg>
                </div>
            </div>

            <?php $this->print_activations( $license, $activations ); ?>

        </div>

        <?php
    }

    /**
     * Get Activation remaining
     */
    private function activationRemaining( $license, $activations ) {
        if ( ! $license->activation_limit|| 0 >= $license->activation_limit ) {
            return "Unlimited";
        }

        $active_sites = 0;
        foreach ( $activations as $activation ) {
            if ( $activation->status === 'active' ) {
                $active_sites += 1;
            }
        }

        return $license->activation_limit - $active_sites;
    }

}
