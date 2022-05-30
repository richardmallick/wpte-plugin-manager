<?php

namespace WPTE_PM_MANAGER\Includes\Admin\Pages;

/**
 * Admin Menu Class
 * 
 * @since 1.0.0
 */
trait AdminTopMenu{

    /**
     * Product Layout Admin Top Menu
     *
     * @since 1.0.0
     */
    public function wpte_admin_menu() {

        wp_enqueue_style('wpte-pm-top-menu');

        $_active = isset($_GET['page']) ? $_GET['page'] : '';
        $manager_active = $license_active = $settings_active = '';
        if ( $_active === 'wpte-plugin-manager' ) {
            $manager_active = 'active';
        } elseif ( $_active === 'wpte-plugin-manager-license' ) {
            $license_active = 'active';
        } elseif ( $_active === 'wpte-plugin-manager-settings') {
            $settings_active = 'active';
        }


        $adminLogo = WPTE_PM_URL . '/Images/wpl-logo.svg';

        printf( '<div class="wpte-pm-wrapper">
                <div class="wpte-pm-admin-top-menu">
                    <div class="wpte-pm-admin-top-logo">
                        <a href="%1$s" class="header-logo">
                            <img src="%2$s"/>
                        </a>
                    </div>
                    <nav class="wpte-pm-admin-top-nav">
                        <ul class="wpte-pm-admin-menu">
                            <li class="%10$s"><a href="%3$s">%4$s</a></li>
                            <li class="%11$s"><a href="%5$s">%6$s</a></li>
                        </ul>
                        <ul class="wpte-pm-admin-menu2">
                        <li class="wpte-pm-doc"><a target="_black" href="#">%7$s</a></li>
                        <li class="wpte-pm-doc"><a target="_black" href="#">%8$s</a></li>
                        <li class="wpte-pm-set %12$s"><a href="%9$s"><span class="dashicons dashicons-admin-generic"></span></a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        ',
        esc_url(admin_url('admin.php?page=wpte-plugin-manager')),
        $adminLogo,
        esc_url(admin_url('admin.php?page=wpte-plugin-manager')),
        esc_html__('Plugins', WPTE_PM_TEXT_DOMAIN),
        esc_url(admin_url('admin.php?page=wpte-plugin-manager-license')),
        esc_html__('License', WPTE_PM_TEXT_DOMAIN),
        esc_html__('Docs', WPTE_PM_TEXT_DOMAIN),
        esc_html__('Support', WPTE_PM_TEXT_DOMAIN),
        esc_url(admin_url('admin.php?page=wpte-plugin-manager-settings')),
        esc_attr($manager_active),
        esc_attr($license_active),
        esc_attr($settings_active),
        );
    }
}