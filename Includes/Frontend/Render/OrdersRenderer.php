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
        $order_at = $order->created_date ? date('M d, Y', strtotime($order->created_date)) : '';
        ?>
        <tr>
            <td>#<?php echo intval($order->id); ?></td>
            <td><?php echo esc_html($order_at); ?></td>
            <td><?php echo esc_html($order->status); ?></td>
            <td><?php
                echo '$';
                echo '99';
            ?></td>
            <td><a href="#">View Invoice</a></td>
        </tr>
        <?php
    }

    /**
     * Get orders from wpte API
     */
    private function get_orders() {
        $user_id = get_current_user_id();
        $licenses = wpte_get_data_for_order_list_by_user_id( $user_id );
        return $licenses ? $licenses : [];
    }
}
