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
        wp_enqueue_script( 'wpte-pm-my-account' );

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
    private function print_activations( $license, $activations ) {
        ?>
        <div class="license-key-activations">
            <div class="wpte-license-key">
                <p>
                    <strong>Key</strong>
                    <span class="tooltip">
                        <span class="license-key-code"><?php echo esc_html( $license['key'] ); ?></span>
                        <span class="tooltiptext">Click to Copy</span>
                    </span>
                    <?php if ( !empty($license['download_url']) ) : ?>
                    <a class="download-btn" href="<?php echo $license['download_url']; ?>">Download</a>
                    <?php endif; ?>
                </p>
            </div>
            <div class="wpte-activations">
                <?php if ( count( $activations ) > 0 ) : ?>
                <h4>Activations</h4>

                <?php foreach ( $activations as $activation ) : ?>
                <div class="wpte-activation-item">
                    <span>
                        <?php echo $activation['site_url']; ?>
                        <?php if ( $activation['is_local'] ) : ?>
                            <small class="badge text-normal" style="margin-left: 5px">Local</small>
                            <span class="tooltip">
                                <i class="as-icon-info"></i>
                                <small class="tooltiptext text-normal" style="min-width: 260px; margin-left: -130px">Local sites are whitelisted and they do not increase the number of your total activated sites</small>
                            </span>
                        <?php endif; ?>
                    </span>
                    <a href="#" data-activationid="<?php echo $activation['id']; ?>" class="remove-activation-button">Remove</a>
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
     * Prpare activation and expires
     */
    private function get_activations_and_expires( $license ) {
        if ( empty( $license['expire_date'] ) ) {
            $expires_on = 'Unlimited';
        } else {
            $date_time = \DateTime::createFromFormat( 'Y-m-d H:i:s', $license['expire_date'] );
            $expires_on = $date_time->format( 'M jS, Y' );
        }

        if ( is_array( $license['activations'] ) ) {
            $activations = $license['activations'];
        } else {
            $activations = json_decode( $license['activations'], true );
            $activations = ( ! is_array( $activations ) ) ? [] : $activations;
        }

        $activations = array_filter( $activations, function( $item ) {
            return 1 == $item['is_active'];
        } );

        return [ $expires_on, $activations ];
    }

    /**
     * Print single license
     */
    public function single_license_output( $license ) {

        $plugin_name = isset( $license->plugin_name ) ? $license->plugin_name : '';
        $variation_name = isset( $license->variation_name ) ? $license->variation_name : '';

        ?>
        <div class="wpte-license" data-showing="0"
            data-sourceid="<?php echo $license['source_id']; ?>"
            data-productid="<?php echo $license['product_id']; ?>"
        >
            <div class="license-header">
                <div class="license-product-info">
                    <div class="license-product-title">
                        <h2><?php echo esc_html($plugin_name); ?></h2>
                        <p class="h3"><?php echo esc_html($variation_name); ?></p>
                    </div>
                    <div class="license-product-expire">
                        <h4>Expires On</h4>
                        <p class="h3"><?php echo $expires_on; ?></p>
                    </div>
                    <div class="license-product-activation">
                        <h4>Activations Remaining</h4>
                        <p class="h3"><?php echo $this->activationRemaining( $license, $activations ); ?></p>
                    </div>
                </div>
                <div class="license-toggle-info">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129"><g><path d="m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z"/></g></svg>
                </div>
            </div>

            <?php $this->print_activations( $license, $activations = [] ); ?>

        </div>

        <?php
    }

    /**
     * Find variation name of product
     */
    private function get_variation_name( $product, $license ) {
        // FastSpring
        if ( 'fastspring' == $license['store_type'] ) {
            return $product->variation_name ? $product->variation_name : '-';
        }

        // For EDD
        if ( is_a( $product, 'EDD_Download' ) ) {
            $payment = edd_get_payment( $license['order_id'] );
            $variation_id = $this->get_edd_cart_variation_id( $payment->cart_details, $product->ID );

            if ( $variation_id ) {
                $prices = $product->get_prices();

                return $prices[ $variation_id ]['name'];
            }
        }

        // For Woo
        if ( is_a( $product, 'WC_Product_Variable' ) ) {
            $order = wc_get_order( $license['order_id'] );

            if ( ! $order ) {
                return '-';
            }

            return $this->get_woo_cart_variation_name( $order->get_items( 'line_item' ), $product );
        }

        return '-';
    }

    /**
     * Get cart of this product
     */
    private function get_edd_cart_variation_id( $carts, $product_id ) {
        $cart = false;
        $variation_id = false;

        foreach ( $carts as $cart_item ) {
            if ( $cart_item['id'] == $product_id ) {
                $cart = $cart_item;
                break;
            }
        }

        if ( false === $cart ) {
            return false;
        }

        // Find variation ID
        if ( isset( $cart['item_number']['options']['price_id'] ) && $cart['item_number']['options']['price_id'] ) {
            $variation_id = $cart['item_number']['options']['price_id'];
        }

        return $variation_id;
    }

    /**
     * Find varaition id of woo item
     */
    private function get_woo_cart_variation_name( $carts, $product ) {
        $cart = false;

        foreach ( $carts as $cart_item ) {
            if ( $cart_item->get_product_id() == $product->get_id() ) {
                $cart = $cart_item;
                break;
            }
        }

        if ( false === $cart ) {
            return '-';
        }

        if ( $variation_id = $cart->get_variation_id() ) {
            $variation = $product->get_available_variation( $variation_id );
            return implode( ' - ', $variation['attributes'] );
        }

        return '-';
    }

    /**
     * Get Activation remaining
     */
    private function activationRemaining( $license, $activations ) {
        if ( ! $license['activation_limit'] || 0 >= $license['activation_limit'] ) {
            return "Unlimited";
        }

        if( isset( $license['active_sites'] ) ) {
            return $license['activation_limit'] - $license['active_sites'];
        }

        return $license['activation_limit'] - count( $activations );
    }

}
