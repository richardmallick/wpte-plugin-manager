<?php 

namespace WPTE_PM_MANAGER\Includes\Frontend\Render;

class MyAccount {

    /**
     * Show orders of user
     */
    public function show() {
        wp_enqueue_style( 'wpte-pm-my-account' );
        wp_enqueue_script( 'wpte-pm-my-account-js' );

        // If user not logged in
        if ( ! is_user_logged_in() ) {
            $this->show_login_form();
            return ob_get_clean();
        }

        $tab = empty( $_GET['tab'] ) ? 'dashboard' : $_GET['tab'];

        ob_start();
        ?>
        <div class="wpte-my-account">
            <ul class="wpte-my-account-sidebar">

                <?php do_action( 'before_wpte_myaccount_sidebar', $tab); ?>

                <li><a href="?tab=dashboard" class="<?php echo $tab == 'dashboard' ? 'ama-active-tab' : ''; ?>">Dashboard</a></li>
                <li><a href="?tab=orders" class="<?php echo $tab == 'orders' ? 'ama-active-tab' : ''; ?>">Orders</a></li>
                <li><a href="?tab=licenses" class="<?php echo $tab == 'licenses' ? 'ama-active-tab' : ''; ?>">My Licenses</a></li>
                <li><a href="?tab=downloads" class="<?php echo $tab == 'downloads' ? 'ama-active-tab' : ''; ?>">Downloads</a></li>

                <?php do_action( 'after_wpte_myaccount_sidebar', $tab); ?>

            </ul>
            <div class="wpte-my-account-content">

                <?php do_action( 'before_wpte_myaccount_contents', $tab); ?>

                <?php $this->show_tab_content( $tab ); ?>

                <?php do_action( 'after_wpte_myaccount_contents', $tab); ?>

            </div>
        </div>
        <?php

        return ob_get_clean();
    }

    /**
     * Show login form
     */
    private function show_login_form() {
        echo '<div class="wpte-login-form">';

        wp_login_form( [
            'redirect' => get_permalink( get_the_ID() ),
        ] );

        echo '</div>';
    }

    /**
     * Show specific tab conetnt
     */
    private function show_tab_content( $tab ) {
        switch ( $tab ) {
            case 'orders':
                echo do_shortcode('[wpte_orders]');
                break;

            case 'licenses':
                echo do_shortcode('[wpte_licenses]');
                break;

            case 'downloads':
                echo do_shortcode('[wpte_downloads]');
                break;

            case 'dashboard':
                $this->show_dashboard_content();
                break;

            default:
                do_action( 'wpte_myaccount_custom_tab', $tab );
                break;
        }
    }

    /**
     * Show dashboard tab content
     */
    private function show_dashboard_content() {
        $user = wp_get_current_user();
        ?>
        <p>Hello <strong><?php echo $user->display_name; ?></strong>, (not <strong><?php echo $user->display_name; ?></strong>? <a href="<?php echo wp_logout_url( get_permalink( get_the_ID() ) ); ?>">Sign out</a>)</p>
        <p>From your account dashboard you can view your Orders, Licenses and Downloads</p>
        <?php
    }

}
