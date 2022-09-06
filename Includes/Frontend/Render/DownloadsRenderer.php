<?php
namespace WPTE_PM_MANAGER\Includes\Frontend\Render;

class DownloadsRenderer {

    /**
     * Show orders of user
     */
    public function show() {
        wp_enqueue_style( 'wpte-pm-my-account' );
        
        // If user not logged in
        if ( ! is_user_logged_in() ) {
            return '<div class="wpte-notice notice-error">You must logged in to get downloads.</div>';
        }

        ob_start();

        do_action( 'before_wpte_myaccount_download_table' );
        ?>
        <div class="wpte-downloads">
            <?php
                $downloads = $this->get_downloads();
                if ( count( $downloads ) > 0 ) :
            ?>
            <table class="wpte-order-table wpte-downloads-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Version</th>
                        <th>Version Date</th>
                        <th>Download</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ( $downloads as $download ) {
                            $this->single_download_output( $download );
                        }
                    ?>
                </tbody>
            </table>
            <?php else: ?>
                <div class="wpte-notice notice-info">No downloads found.</div>
            <?php endif; ?>
        </div>
        <?php

        do_action( 'after_wpte_myaccount_download_table' );

        return ob_get_clean();
    }

    /**
     * Get user downloads
     */
    private function get_downloads() {

        $user_id = get_current_user_id();

        $licenses = wpte_get_data_by_user_id( $user_id );
        
        return $licenses ? $licenses : [];
    }

    /**
     * Single download row
     */
    private function single_download_output( $download ) {
        ?>
        <tr>
            <td>
                <?php echo $download->plugin_name; ?>
                <?php echo '<br/><small>' . $download->variation_name . '</small>';  ?>
            </td>
            <td><?php echo $download->plugin_version; ?></td>
            <td><?php echo date('M d, Y', strtotime($download->last_update)); ?></td>
            <td><a href="<?php echo $download->file_url; ?>">Download</a></td>
        </tr>
        <?php
    }

}
