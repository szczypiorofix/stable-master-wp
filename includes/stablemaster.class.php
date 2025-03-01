<?php

defined( 'ABSPATH' ) || exit;

class StableMaster {

    public function __construct() {
        register_activation_hook( __FILE__, array( $this, 'activate' ) );
        register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

        $cptHorse = new Sm_Cpt_Horse('sm_horse');
        $smMenus = new SM_Menus();

        $smAdmin = new Admin_Loader();
    }

    public static function initialize(): void {
        new self();
    }

    public function activate(): void {

    }

    public function deactivate(): void {

    }

}
