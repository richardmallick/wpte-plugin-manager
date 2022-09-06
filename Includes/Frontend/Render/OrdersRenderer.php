<?php
namespace WPTE_PM_MANAGER\Includes\Frontend\Render;

class OrdersRenderer {

    /**
     * Show orders of user
     */
    public function show() {
        wp_enqueue_style( 'wpte-pm-my-account' );

        // If user not logged in
        if ( ! is_user_logged_in() ) {
            return '<div class="wpte-notice notice-error">You must logged in to get orders.</div>';
        }

        ob_start();

        do_action( 'before_wpte_myaccount_order_table' );
        ?>
        <div class="wpte-orders">
            <?php
                $orders = $this->get_orders();
                if ( count( $orders ) > 0 ) :
            ?>
            <table class="wpte-order-table">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ( $orders as $order ) {
                            $this->single_order_output( $order );
                        }
                    ?>
                </tbody>
            </table>
            <?php else: ?>
                <div class="wpte-notice notice-info">No orders found.</div>
            <?php endif; ?>
        </div>
        <?php

        do_action( 'after_wpte_myaccount_order_table' );

        return ob_get_clean();
    }

    /**
     * Single order row
     */
    private function single_order_output( $order ) {
        ?>
        <tr>
            <td>#<?php echo $order['id']; ?></td>
            <td><?php echo $order['ordered_at']; ?></td>
            <td><?php echo $order['status']; ?></td>
            <td><?php
                echo isset( $order['currency'] ) ? $order['currency'] : '';
                echo $order['total'];
            ?></td>
            <td><a href="<?php echo $order['invoice_url']; ?>">View Invoice</a></td>
        </tr>
        <?php
    }

    /**
     * Get orders from wpte API
     */
    private function get_orders() {
        $user_id = get_current_user_id();
        $route   = 'public/users/' . $user_id . '/orders';

        // Send request to wpte server
        $response = wpte_helper_remote_get( $route );

        if ( wp_remote_retrieve_response_code( $response ) != 200 ) {
            return [];
        }

        $body = json_decode( wp_remote_retrieve_body( $response ), true );

        return isset( $body['data'] ) ? $body['data'] : [];
    }
}
