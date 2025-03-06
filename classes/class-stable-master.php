<?php

defined( 'ABSPATH' ) || exit;

class Stable_Master {
    public function __construct() {
        register_activation_hook( __FILE__, array( $this, 'activate' ) );
        register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

        $cpt_horse = new Sm_Cpt_Horse(SM_CPT_HORSE);

        $sm_admin = new Admin_Loader();
        $short_codes = new SM_ShortCodes();

        $admin_menu = new SM_Admin_Menu();
        $admin_menu->init();
    }

    public static function initialize(): void {
        new self();
    }

    public function activate(): void {

    }

    public function deactivate(): void {

    }
}
