<?php

defined( 'ABSPATH' ) || exit;

/**
 * Custom Post Type - Horse
 * For Stable Master plugin
 * 
 * @since 0.0.2
 * 
 * @see SM_Base_CPT
 */
class Sm_Cpt_Horse extends SM_Base_CPT {
    public function __construct() {
        parent::__construct();

        $fields = array(
            array(
                'id'    => 'product_price',
                'label' => 'Cena produktu',
                'type'  => 'text',
            ),
            array(
                'id'    => 'product_available',
                'label' => 'Dostępny',
                'type'  => 'checkbox',
            ),
        );

        new SM_Custom_Fields( $this->post_type, $fields );
    }

    protected function set_defaults(): void {
        $this->post_type = 'sm_horse';
        $this->set_common_args( 'Koń', 'Konie' );

        $this->args['menu_icon'] = 'dashicons-buddicons-activity';
    }
}
