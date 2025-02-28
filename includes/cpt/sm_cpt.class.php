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

    abstract function getCustomMetaBox(): void;

    abstract function savePostCallback(int $post_id): void;

    protected function initializeActions(): void {
        add_action('init', array($this, 'registerPostTypeCallback'));
        add_action('add_meta_boxes', array($this, 'getCustomMetaBox'));
        add_action('save_post', array($this, 'savePostCallback'));
    }

    public function addField(string $id, Sm_Cpt_Field $field): void {
        $this->fields[$id] = $field;
    }

    public function getFields(): array {
        return $this->fields;
    }
    
    public function getField(string $id): Sm_Cpt_Field | null {
        if (isset($this->fields[$id])) {
            return $this->fields[$id];
        } else {
            if (defined('WP_DEBUG') && true === WP_DEBUG) {
                wp_die("Nie znaleziono pola id = " . $id, "Błąd pola postu!");
             }
             return null;
        }
    }
}
