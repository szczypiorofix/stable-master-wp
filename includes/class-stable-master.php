<?php

defined( 'ABSPATH' ) || exit;

class Stable_Master {
    public function __construct() {
        register_activation_hook( __FILE__, array( $this, 'activate' ) );
        register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

        $cptHorse = new Sm_Cpt_Horse(SM_CPT_HORSE);
        $smMenus = new SM_Menus();

        $smAdmin = new Admin_Loader();
        $shortCodes = new SM_ShortCodes();
    }

    public static function initialize(): void {
        new self();
    }

    public function activate(): void {

    }

    public function deactivate(): void {

    }
}
