<?php

defined( 'ABSPATH' ) || exit;

class SM_Menus {
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'initialize_admin_menu' ) );
    }

    public function initialize_admin_menu(): void {
        add_menu_page(
            'StableMaster',
            'Stable Master',
            'manage_options',
            'sm_settings',
            array( $this, 'stablemaster_settings_view' ),
            'dashicons-admin-generic',
            26
        );
    }

    public function stablemaster_settings_view(): void {
        require_once SM_PLUGIN_DIR_PATH . '/admin/settings-view.php';
    }
}
