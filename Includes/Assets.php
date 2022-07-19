<?php

namespace WPTE_PM_MANAGER\Includes;

/**
 * Assets Handler Class
 * 
 * @since 1.0.0
 */
class Assets{

    /**
     * Assets class constructor
     * 
     * @since 1.0.0
     */
    public function __construct() {
        add_action( 'admin_enqueue_scripts', [ $this, 'AdminEnqueueAssets' ] );
    }

    /**
     * Admin Css List
     * 
     * @since 1.0.0
     */
    public function AdminAssetsCss() {
        return [
            [
                'handler' => 'wpte-pm-top-menu',
                'src'     => 'css/top-menu.css',
                'deps'    => null,
            ],
            [
                'handler' => 'wpte-plugin-manager-style',
                'src'     => 'css/plugin-manager.css',
                'deps'    => null,
            ],
            [
                'handler' => 'wpte-plugin-sweetalert2',
                'src'     => 'css/sweetalert2.min.css',
                'deps'    => null,
            ],
        ];
    }

    /**
     * Admin JS List
     * 
     * @since 1.0.0
     */
    public function AdminAssetsJS() {
        return [
            [
                'handler'   => 'wpte-pm-serializejson',
                'src'       => 'js/jquery.serializejson.min.js',
                'deps'      => ['jquery'],
                'in_footer' => true
            ],
            [
                'handler'   => 'wpte-pm-main',
                'src'       => 'js/main.js',
                'deps'      => ['jquery'],
                'in_footer' => true
            ],
            [
                'handler'   => 'wpte-pm-sweetalert2',
                'src'       => 'js/sweetalert2.min.js',
                'deps'      => ['jquery'],
                'in_footer' => true
            ],
        ];
    }

    /**
     * Admin Assets Loader
     * 
     * @since 1.0.0
     */
    public function AdminEnqueueAssets() {

        $assetCss = $this->AdminAssetsCss();
        $assetJS  = $this->AdminAssetsJS();
        
        // Register Admin CSS
        foreach( $assetCss as $cssList ) {

            wp_register_style($cssList['handler'], WPTE_PM_ASSETS. $cssList['src'],  $cssList['deps'], filemtime(WPTE_PM_PATH."assets/".$cssList['src']));
        
        }
        
        // Enqueue Admin Js
        foreach( $assetJS as $jsList ) {
            wp_register_script($jsList['handler'], WPTE_PM_ASSETS. $jsList['src'], $jsList['deps'], filemtime(WPTE_PM_PATH."assets/".$jsList['src']), $jsList['in_footer']);
        }
    }

}