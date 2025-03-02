<?php

defined( 'ABSPATH' ) || exit;

class Admin_Loader {
    private $plugin_version;
    private $admin_dir_plugin_url;

    public function __construct() {
        $this->plugin_version = SM_PLUGIN_VERSION;
        $this->admin_dir_plugin_url = plugin_dir_url(__FILE__);
        add_action( 'admin_enqueue_scripts', array( $this, 'include_admin_scripts_and_styles' ) ); 
    }

    public function include_admin_scripts_and_styles() {
        $adminCssFileUri = $this->admin_dir_plugin_url .'static/css/sm_admin.css';        
        $adminJsFileUri = $this->admin_dir_plugin_url .'static/js/sm_admin.js';        
        
        wp_enqueue_script( 'admin_stablemaster_script', $adminJsFileUri, array(), $this->plugin_version, true );
        wp_enqueue_style( 'admin_stablemaster_style', $adminCssFileUri, array(), $this->plugin_version, 'all');
    }
}
