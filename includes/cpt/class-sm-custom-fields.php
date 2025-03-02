<?php
class SM_Custom_Fields {
    protected string$post_type;
    protected array $fields;

    public function __construct($post_type, $fields = []) {
        $this->post_type = $post_type;
        $this->fields = $fields;
        add_action('add_meta_boxes', array($this, 'register_meta_boxes'));
        add_action('save_post', array($this, 'save_meta_fields'));
    }

    public function register_meta_boxes(): void {
        add_meta_box(
            $this->post_type . '_custom_fields',
            'Dodatkowe pola',
            [$this, 'render_meta_box'],
            $this->post_type,
            'normal',
            'high'
        );
    }

    public function render_meta_box($post): void {
        wp_nonce_field(basename(__FILE__), $this->post_type . '_nonce');
        foreach ($this->fields as $field) {
            $value = get_post_meta($post->ID, $field['id'], true);
            echo '<p>';
            echo '<label for="' . esc_attr($field['id']) . '">' . esc_html($field['label']) . '</label><br>';
            switch ($field['type']) {
                case 'text':
                    echo '<input type="text" id="' . esc_attr($field['id']) . '" name="' . esc_attr($field['id']) . '" value="' . esc_attr($value) . '" style="width: 100%;" />';
                    break;
                case 'checkbox':
                    echo '<input type="checkbox" id="' . esc_attr($field['id']) . '" name="' . esc_attr($field['id']) . '" ' . checked($value === 'on', 1, false) . ' />';
                    break;
                // TODO: Add other types
            }
            echo '</p>';
        }
    }

    public function save_meta_fields($post_id): void {
        if (!isset($_POST[$this->post_type . '_nonce']) || !wp_verify_nonce($_POST[$this->post_type . '_nonce'], basename(__FILE__))) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (get_post_type($post_id) !== $this->post_type) {
            return;
        }

        foreach ($this->fields as $field) {
            if (isset($_POST[$field['id']])) {
                $value = sanitize_text_field($_POST[$field['id']]);
                update_post_meta($post_id, $field['id'], $value);
            } else {
                update_post_meta($post_id, $field['id'], $field['type'] === 'checkbox' ? 0 : 1);
            }
        }
    }
}
