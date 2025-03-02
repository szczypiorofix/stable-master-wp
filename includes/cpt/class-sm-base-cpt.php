<?php

abstract class SM_Base_CPT {
    protected $post_type;
    protected $labels;
    protected $args;

    public function __construct() {
        $this->set_defaults();
        add_action('init', array($this, 'register_post_type'));
    }

    abstract protected function set_defaults();

    public function register_post_type() {
        register_post_type($this->post_type, $this->args);
    }

    protected function set_common_args($singular_name, $plural_name) {
        $this->labels = [
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
        ];

        $this->args = [
            'labels'             => $this->labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => ['slug' => strtolower($plural_name)],
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 20,
            'supports'           => ['title', 'editor', 'thumbnail'],
        ];
    }
}
