<?php

namespace WPTE_PM_MANAGER\Includes;


/**
 * Plugin_updater Handler Class
 * 
 * @since 1.0.0
 */
class Plugin_updater{

    /**
     * Plugin_updater class constructor
     * 
     * @since 1.0.0
     */
    public function __construct(){
      //  $this->run_plugin_hooks();
    }


    /**
     * Set up WordPress filter to hooks to get update.
     *
     * @return void
     */
    public function run_plugin_hooks() {
        add_filter( 'pre_set_site_transient_update_plugins', array( $this, 'check_plugin_update' ) );
        add_filter( 'plugins_api', array( $this, 'plugins_api_filter' ), 10, 3 );
    }

    /**
     * Check for Update for this specific project
     */
    public function check_plugin_update( $transient_data ) {
        global $pagenow;

        if ( ! is_object( $transient_data ) ) {
            $transient_data = new \stdClass;
        }

        if ( 'plugins.php' == $pagenow && is_multisite() ) {
            return $transient_data;
        }

        if ( ! empty( $transient_data->response ) && ! empty( $transient_data->response[ $this->client->basename ] ) ) {
            return $transient_data;
        }

        $version_info = $this->get_version_info();

        if ( false !== $version_info && is_object( $version_info ) && isset( $version_info->new_version ) ) {

            unset( $version_info->sections );

            // If new version available then set to `response`
            if ( version_compare( $this->client->project_version, $version_info->new_version, '<' ) ) {
                $transient_data->response[ $this->client->basename ] = $version_info;
            } else {
                // If new version is not available then set to `no_update`
                $transient_data->no_update[ $this->client->basename ] = $version_info;
            }

            $transient_data->last_checked = time();
            $transient_data->checked[ $this->client->basename ] = $this->client->project_version;
        }

        return $transient_data;
    }

    /**
     * Get version information
     */
    private function get_version_info() {
        $version_info = $this->get_cached_version_info();

        if ( false === $version_info ) {
            $version_info = $this->get_project_latest_version();
            $this->set_cached_version_info( $version_info );
        }

        return $version_info;
    }

    

}