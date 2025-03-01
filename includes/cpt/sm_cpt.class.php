<?php

defined( 'ABSPATH' ) || exit;

abstract class Sm_Cpt {
    protected string $postTypeSlug;
    private array $fields;

    protected function __construct(string $postTypeSlug) {
        $this->postTypeSlug = $postTypeSlug;
        $this->fields = array();

        $this->initializeActions();
    }

    abstract function registerPostTypeCallback(): void;

    abstract function addCustomMetaBoxCallback(): void;

    abstract function savePostCallback(int $post_id): void;

    protected function initializeActions(): void {
        add_action('init', array($this, 'registerPostTypeCallback'));
        add_action('add_meta_boxes', array($this, 'addCustomMetaBoxCallback'));
        add_action('save_post', array($this, 'savePostCallback'));
    }

    protected function addField(string $id, Sm_Cpt_Field $field): void {
        if (isset($this->fields[$id])) {
            if (defined('WP_DEBUG') && true === WP_DEBUG) {
                wp_die("Pole $id jest już zidentyfikowane !");
             }
        }
        $this->fields[$id] = $field;
    }
    
    protected function getField(string $id): Sm_Cpt_Field | null {
        if (isset($this->fields[$id])) {
            return $this->fields[$id];
        } else {
            if (defined('WP_DEBUG') && true === WP_DEBUG) {
                wp_die("Nie znaleziono pola id = $id Błąd pola postu!");
             }
             return null;
        }
    }
}
