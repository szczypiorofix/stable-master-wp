<?php

defined( 'ABSPATH' ) || exit;

class Sm_Cpt_Field {
    public string $name;
    public string $title;
    public string $nonce;
    public string $metaBoxId;

    public function __construct( string $name, string $title, string $nonce, string $metaBoxId) {
        $this->name = $name;
        $this->title = $title;
        $this->nonce = $nonce;
        $this->metaBoxId = $metaBoxId;
    }
}
