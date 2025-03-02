<?php

defined( 'ABSPATH' ) || exit;

class Admin_Loader {
    private $pluginVersion;
    private $adminDirPluginUrl;

    public function __construct() {
        $this->pluginVersion = SM_PLUGIN_VERSION;
        $this->adminDirPluginUrl = plugin_dir_url(__FILE__);
        add_action( 'admin_enqueue_scripts', array( $this, 'includeAdminScriptsAndStyles' ) ); 
    }

    public function includeAdminScriptsAndStyles() {
        $adminCssFileUri = $this->adminDirPluginUrl .'static/css/sm_admin.css';        
        $adminJsFileUri = $this->adminDirPluginUrl .'static/js/sm_admin.js';        
        
        wp_enqueue_script( 'admin_stablemaster_script', $adminJsFileUri, array(), $this->pluginVersion, true );
        wp_enqueue_style( 'admin_stablemaster_style', $adminCssFileUri, array(), $this->pluginVersion, 'all');
    }
}
