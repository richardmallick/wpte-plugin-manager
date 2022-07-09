<?php

namespace WPTE_PM_MANAGER\Includes\Admin\Pages;

/**
 * Plugin Manager
 *
 * @since 1.0.0
 */
class Single_plugin{
    /**
     * Plugin Manager class constructor
     *
     * @since 1.0.0
     */
    public function __construct() {
        $this->wpte_single_plugin();
    }

    /**
     * Wpte Single Plugin
     *
     * @since 1.0.0
     */
    public function wpte_single_plugin() {
		$plugin_id = isset($_GET['id']) ? intval($_GET['id']) : '';
		$plugin_data = wpte_pm_get_plugin( $plugin_id ) ? wpte_pm_get_plugin( $plugin_id ) : (object)[];
        ?>
        <div class="wpte-pm-single-plugin-tabs">
			<aside class="wpte-pm-single-plugin-sidebar">
				<div class="wpte-pm-sidebar-header">
					<div class="wpte-pm-sidebar-logo">
						<?php   
							if ( $plugin_data->logo_id ) {
								echo wp_get_attachment_image( $plugin_data->logo_id, 'thumbnail' );
							} else {
								?>
									<img src="<?php echo  WPTE_PM_URL ?>/images/kd-img.png" alt="" srcset="">
								<?php
							}
						?>
					</div>
					<div class="wpte-pm-sidebar-plugin-title">
						<h2><?php echo esc_html($plugin_data->plugin_name); ?></h2>
						<p>Plugin</p>
					</div>
				</div>
				<ul class="wpte-pm-single-plugin-tab-button">
					<li class="btn active"><a href="#analytics"><i class="wpte-pm-side-menu-icon"><svg viewBox="64 64 896 896" data-icon="dashboard" width="1em" height="1em" fill="currentColor" aria-hidden="true" focusable="false" class=""><path d="M924.8 385.6a446.7 446.7 0 0 0-96-142.4 446.7 446.7 0 0 0-142.4-96C631.1 123.8 572.5 112 512 112s-119.1 11.8-174.4 35.2a446.7 446.7 0 0 0-142.4 96 446.7 446.7 0 0 0-96 142.4C75.8 440.9 64 499.5 64 560c0 132.7 58.3 257.7 159.9 343.1l1.7 1.4c5.8 4.8 13.1 7.5 20.6 7.5h531.7c7.5 0 14.8-2.7 20.6-7.5l1.7-1.4C901.7 817.7 960 692.7 960 560c0-60.5-11.9-119.1-35.2-174.4zM761.4 836H262.6A371.12 371.12 0 0 1 140 560c0-99.4 38.7-192.8 109-263 70.3-70.3 163.7-109 263-109 99.4 0 192.8 38.7 263 109 70.3 70.3 109 163.7 109 263 0 105.6-44.5 205.5-122.6 276zM623.5 421.5a8.03 8.03 0 0 0-11.3 0L527.7 506c-18.7-5-39.4-.2-54.1 14.5a55.95 55.95 0 0 0 0 79.2 55.95 55.95 0 0 0 79.2 0 55.87 55.87 0 0 0 14.5-54.1l84.5-84.5c3.1-3.1 3.1-8.2 0-11.3l-28.3-28.3zM490 320h44c4.4 0 8-3.6 8-8v-80c0-4.4-3.6-8-8-8h-44c-4.4 0-8 3.6-8 8v80c0 4.4 3.6 8 8 8zm260 218v44c0 4.4 3.6 8 8 8h80c4.4 0 8-3.6 8-8v-44c0-4.4-3.6-8-8-8h-80c-4.4 0-8 3.6-8 8zm12.7-197.2l-31.1-31.1a8.03 8.03 0 0 0-11.3 0l-56.6 56.6a8.03 8.03 0 0 0 0 11.3l31.1 31.1c3.1 3.1 8.2 3.1 11.3 0l56.6-56.6c3.1-3.1 3.1-8.2 0-11.3zm-458.6-31.1a8.03 8.03 0 0 0-11.3 0l-31.1 31.1a8.03 8.03 0 0 0 0 11.3l56.6 56.6c3.1 3.1 8.2 3.1 11.3 0l31.1-31.1c3.1-3.1 3.1-8.2 0-11.3l-56.6-56.6zM262 530h-80c-4.4 0-8 3.6-8 8v44c0 4.4 3.6 8 8 8h80c4.4 0 8-3.6 8-8v-44c0-4.4-3.6-8-8-8z"></path></svg></i><?php echo  esc_html__('Analytics', WPTE_PM_TEXT_DOMAIN); ?></a></li>
					<li class="btn"><a href="#product"><span class="dashicons dashicons-admin-plugins"></span> <?php echo  esc_html__('Product', WPTE_PM_TEXT_DOMAIN); ?></a></li>
					<li class="btn"><a href="#license"><span class="dashicons dashicons-unlock"></span> <?php echo  esc_html__('License', WPTE_PM_TEXT_DOMAIN); ?></a></li>
					<li class="btn"><a href="#setting"><i class="wpte-pm-side-menu-icon"><svg viewBox="64 64 896 896" data-icon="setting" width="1em" height="1em" fill="currentColor" aria-hidden="true" focusable="false" class=""><path d="M924.8 625.7l-65.5-56c3.1-19 4.7-38.4 4.7-57.8s-1.6-38.8-4.7-57.8l65.5-56a32.03 32.03 0 0 0 9.3-35.2l-.9-2.6a443.74 443.74 0 0 0-79.7-137.9l-1.8-2.1a32.12 32.12 0 0 0-35.1-9.5l-81.3 28.9c-30-24.6-63.5-44-99.7-57.6l-15.7-85a32.05 32.05 0 0 0-25.8-25.7l-2.7-.5c-52.1-9.4-106.9-9.4-159 0l-2.7.5a32.05 32.05 0 0 0-25.8 25.7l-15.8 85.4a351.86 351.86 0 0 0-99 57.4l-81.9-29.1a32 32 0 0 0-35.1 9.5l-1.8 2.1a446.02 446.02 0 0 0-79.7 137.9l-.9 2.6c-4.5 12.5-.8 26.5 9.3 35.2l66.3 56.6c-3.1 18.8-4.6 38-4.6 57.1 0 19.2 1.5 38.4 4.6 57.1L99 625.5a32.03 32.03 0 0 0-9.3 35.2l.9 2.6c18.1 50.4 44.9 96.9 79.7 137.9l1.8 2.1a32.12 32.12 0 0 0 35.1 9.5l81.9-29.1c29.8 24.5 63.1 43.9 99 57.4l15.8 85.4a32.05 32.05 0 0 0 25.8 25.7l2.7.5a449.4 449.4 0 0 0 159 0l2.7-.5a32.05 32.05 0 0 0 25.8-25.7l15.7-85a350 350 0 0 0 99.7-57.6l81.3 28.9a32 32 0 0 0 35.1-9.5l1.8-2.1c34.8-41.1 61.6-87.5 79.7-137.9l.9-2.6c4.5-12.3.8-26.3-9.3-35zM788.3 465.9c2.5 15.1 3.8 30.6 3.8 46.1s-1.3 31-3.8 46.1l-6.6 40.1 74.7 63.9a370.03 370.03 0 0 1-42.6 73.6L721 702.8l-31.4 25.8c-23.9 19.6-50.5 35-79.3 45.8l-38.1 14.3-17.9 97a377.5 377.5 0 0 1-85 0l-17.9-97.2-37.8-14.5c-28.5-10.8-55-26.2-78.7-45.7l-31.4-25.9-93.4 33.2c-17-22.9-31.2-47.6-42.6-73.6l75.5-64.5-6.5-40c-2.4-14.9-3.7-30.3-3.7-45.5 0-15.3 1.2-30.6 3.7-45.5l6.5-40-75.5-64.5c11.3-26.1 25.6-50.7 42.6-73.6l93.4 33.2 31.4-25.9c23.7-19.5 50.2-34.9 78.7-45.7l37.9-14.3 17.9-97.2c28.1-3.2 56.8-3.2 85 0l17.9 97 38.1 14.3c28.7 10.8 55.4 26.2 79.3 45.8l31.4 25.8 92.8-32.9c17 22.9 31.2 47.6 42.6 73.6L781.8 426l6.5 39.9zM512 326c-97.2 0-176 78.8-176 176s78.8 176 176 176 176-78.8 176-176-78.8-176-176-176zm79.2 255.2A111.6 111.6 0 0 1 512 614c-29.9 0-58-11.7-79.2-32.8A111.6 111.6 0 0 1 400 502c0-29.9 11.7-58 32.8-79.2C454 401.6 482.1 390 512 390c29.9 0 58 11.6 79.2 32.8A111.6 111.6 0 0 1 624 502c0 29.9-11.7 58-32.8 79.2z"></path></svg></i><?php echo  esc_html__('Settings', WPTE_PM_TEXT_DOMAIN); ?></a></li>
					<li class="btn"><a href="#usesguide"><i class="wpte-pm-side-menu-icon"><svg viewBox="64 64 896 896" data-icon="safety-certificate" width="1em" height="1em" fill="currentColor" aria-hidden="true" focusable="false" class=""><path d="M866.9 169.9L527.1 54.1C523 52.7 517.5 52 512 52s-11 .7-15.1 2.1L157.1 169.9c-8.3 2.8-15.1 12.4-15.1 21.2v482.4c0 8.8 5.7 20.4 12.6 25.9L499.3 968c3.5 2.7 8 4.1 12.6 4.1s9.2-1.4 12.6-4.1l344.7-268.6c6.9-5.4 12.6-17 12.6-25.9V191.1c.2-8.8-6.6-18.3-14.9-21.2zM810 654.3L512 886.5 214 654.3V226.7l298-101.6 298 101.6v427.6zm-405.8-201c-3-4.1-7.8-6.6-13-6.6H336c-6.5 0-10.3 7.4-6.5 12.7l126.4 174a16.1 16.1 0 0 0 26 0l212.6-292.7c3.8-5.3 0-12.7-6.5-12.7h-55.2c-5.1 0-10 2.5-13 6.6L468.9 542.4l-64.7-89.1z"></path></svg></i><?php echo  esc_html__('Usage Guide', WPTE_PM_TEXT_DOMAIN); ?></a></li>
				</ul>
			</aside>
			<div class="wpte-pm-single-plugin-tab-content">
				<div id="analytics" class="tab-item active">
					<h1><?php echo  esc_html__('Analytics', WPTE_PM_TEXT_DOMAIN); ?></h1>
					<div class="wpte-tab-item-card wpte-pm-tab-content">
						<?php
							echo "General";
						?>
					</div>
				</div>
				<div id="product" class="tab-item">
						<h1><?php echo  esc_html__('Product', WPTE_PM_TEXT_DOMAIN); ?></h1>
						<div class="wpte-tab-item-card wpte-pm-tab-content">
							<?php
								if (file_exists(__DIR__ . "/views/Product.php")) {

									include __DIR__ . "/views/Product.php";

								}
							?>
						</div>
				</div>
				<div id="license" class="tab-item">
						
							<?php
								if ( isset($_GET['license_id'])) {
									if (file_exists(__DIR__ . "/views/Single-license.php")) {

										include __DIR__ . "/views/Single-license.php";
	
									}
									?>
									<?php
								} else {
									?>
									<div class="wpte-pm-add-new-area">
										<h1><?php echo  esc_html__('License', WPTE_PM_TEXT_DOMAIN); ?></h1>
										<div class="wpte-pm-add-new-linense">
											<button>+ Add License</button>
										</div>
									</div>
									
									
									<?php
									if (file_exists(__DIR__ . "/views/License.php")) {

										include __DIR__ . "/views/License.php";
	
									}
								}	
							?>
						
				</div>
			
				<div id="setting" class="tab-item">
					<h1><?php echo esc_html__('Setting', WPTE_PM_TEXT_DOMAIN); ?></h1>
					<div class="wpte-tab-item-card wpte-pm-tab-content">
						<?php
							if (file_exists(__DIR__ . "/views/Settings.php")) {

								include __DIR__ . "/views/Settings.php";

							}
						?>
					</div>
				</div>
				<div id="usesguide" class="tab-item">
					<h1><?php echo esc_html__('Uses Guide', WPTE_PM_TEXT_DOMAIN); ?></h1>
					<div class="wpte-tab-item-card wpte-pm-tab-content">
						<?php
							if (file_exists(__DIR__ . "/views/Doc.php")) {

								include __DIR__ . "/views/Doc.php";

							}
						?>
					</div>
				</div>
				
			</div>
		</div>

        <?php
    }

}