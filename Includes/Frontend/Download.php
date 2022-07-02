<?php

namespace WPTE_PM_MANAGER\Includes\Frontend;

/**
 * Download Class
 * 
 * @since 1.0.0
 */
class Download{

    public function __construct() {
        $this->wpte_file_download();
    }

    public function wpte_file_download() {
        $license_key = isset( $_GET['key'] ) ? $_GET['key'] : '';
        $license = wpte_get_product_license_row_key( $license_key ) ? wpte_get_product_license_row_key( $license_key ) : (object)[];
        $product_file = isset($license->product_file) ? wp_get_attachment_url($license->product_file) : '#';
        $filename = isset($license->product_file) ? basename( get_attached_file( $license->product_file ) ): '';
        if ( $license_key ) :
        ?>
        <p></p>
        <a id='download' href='<?php echo esc_url($product_file) ?>' download='<?php echo esc_html($filename); ?>'>Download</a>
        <script>
           var  a = document.createElement('a');
                a.href = "<?php echo esc_url($product_file); ?>";
                a.download = '<?php echo esc_html($filename); ?>';
                a.click();
        </script>
        <?php
        endif;
    }
}