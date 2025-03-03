<?php

defined( 'ABSPATH' ) || exit;

abstract class SM_Base_CPT {
    protected string $post_type;
    protected array $labels;
    protected array $args;

    public function __construct() {
        $this->set_defaults();
        add_action( 'init', array( $this, 'register_post_type' ) );
    }

    abstract protected function set_defaults(): void;

    public function register_post_type(): void {
        register_post_type( $this->post_type, $this->args );
    }

    protected function set_common_args( string $singular_name, string $plural_name ): void {
        $this->labels = array(
            'name'               => $plural_name,
            'singular_name'      => $singular_name,
            'menu_name'          => $plural_name,
            'name_admin_bar'     => $singular_name,
            'add_new'            => "Dodaj nowy",
            'add_new_item'       => "Dodaj nowy $singular_name",
            'new_item'           => "Nowy $singular_name",
            'edit_item'          => "Edytuj $singular_name",
            'view_item'          => "Zobacz $singular_name",
            'all_items'          => "Wszystkie $plural_name",
            'search_items'       => "Szukaj $plural_name",
            'not_found'          => "Nie znaleziono $plural_name",
        );

        $this->args = array(
            'labels'             => $this->labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => strtolower( $plural_name ) ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 20,
            'supports'           => array( 'title', 'editor', 'thumbnail' ),
        );
    }
}
