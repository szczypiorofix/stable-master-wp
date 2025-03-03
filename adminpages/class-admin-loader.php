<?php

defined( 'ABSPATH' ) || exit;

class Admin_Loader {
    public function __construct() {
        add_action( 'admin_enqueue_scripts', array( $this, 'include_admin_scripts_and_styles' ) ); 
    }

    public function include_admin_scripts_and_styles() {
        $adminCssFileUri = plugins_url('css/sm_admin.css',__FILE__);
        $adminJsFileUri = plugins_url('js/sm_admin.js', __FILE__);
        
        wp_enqueue_script( 'admin_stablemaster_script', $adminJsFileUri, array(), SM_PLUGIN_VERSION, true );
        wp_enqueue_style( 'admin_stablemaster_style', $adminCssFileUri, array(), SM_PLUGIN_VERSION, 'all');
    }
}
