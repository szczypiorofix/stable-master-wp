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

    protected function setupField(string $fieldId, string $fieldName): Sm_Cpt_Field {
        if (isset($this->fields[$fieldId])) {
            if (defined('WP_DEBUG') && true === WP_DEBUG) {
                wp_die("Pole $fieldId jest już zidentyfikowane !");
             }
        }
        $field = new Sm_Cpt_Field(
            $fieldId . "_fieldName",
            $fieldName,
            $fieldId . '_nonce',
            $fieldId . '_metaBoxId'
        );

        $this->fields[$fieldId] = $field;
        return $field;
    }
    
    protected function addMetaBox(Sm_Cpt_Field $field, callable $callback, string $context = 'normal', $priotify = 'default'): void {
        add_meta_box( 
            $field->metaBoxId,
            __($field->title, SM_DOMAIN),
            $callback,
            $this->postTypeSlug,
            $context,
            $priotify
        );
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
