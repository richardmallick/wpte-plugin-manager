<?php

namespace WPTE_PM_MANAGER\Includes;


/**
 * Admin Handler Class
 * 
 * @since 1.0.0
 */
class Admin{

    /**
     * Admin class constructor
     * 
     * @since 1.0.0
     */
    public function __construct(){
        new Admin\Class_menu();
        new Admin\Ajax();
    }

}