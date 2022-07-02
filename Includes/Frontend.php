<?php

namespace WPTE_PM_MANAGER\Includes;


/**
 * Frontend Handler Class
 * 
 * @since 1.0.0
 */
class Frontend{

    /**
     * Frontend class constructor
     * 
     * @since 1.0.0
     */
    public function __construct(){
        add_filter('generate_rewrite_rules', [$this, 'wpte_rewrite_rules'] );
        add_filter('query_vars', [$this, 'wpte_query_vars'] );
        add_action('template_redirect', [$this, 'wpte_template_redirect'] );
    }

    public function wpte_rewrite_rules( $wp_rewrite ) {
        global $wp_rewrite;
        $wp_rewrite->rules = array_merge(
            ['download/?$' => 'index.php?download=1'],
            $wp_rewrite->rules
        );
    }

    function wpte_query_vars( $query_vars ){
        $query_vars[] = 'download';
        return $query_vars;
    }

    function wpte_template_redirect(){
        $custom = intval( get_query_var( 'download' ) );
        if ( $custom ) {
            new Frontend\Download();
            die;
        }
    }

}