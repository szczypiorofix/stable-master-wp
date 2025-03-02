<?php

defined( 'ABSPATH' ) || exit;

class Sm_Cpt_Horse extends SM_Base_CPT {
    protected function set_defaults() {
        $this->post_type = 'sm_horse';
        $this->set_common_args('Koń', 'Konie');

        $this->args['menu_icon'] = 'dashicons-buddicons-activity';
    }

    public function __construct() {
        parent::__construct();

        $fields = [
            [
                'id'    => 'product_price',
                'label' => 'Cena produktu',
                'type'  => 'text',
            ],
            [
                'id'    => 'product_available',
                'label' => 'Dostępny',
                'type'  => 'checkbox',
            ],
        ];

        new SM_Custom_Fields($this->post_type, $fields);
    }
}
