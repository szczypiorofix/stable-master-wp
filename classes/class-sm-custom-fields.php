<?php

defined( 'ABSPATH' ) || exit;

class SM_Custom_Fields {
    protected string $post_type;
    protected array $fields;

    public function __construct( string $post_type, array $fields = array() ) {
        $this->post_type = $post_type;
        $this->fields = $fields;
        add_action( 'add_meta_boxes', array( $this, 'register_meta_boxes' ) );
        add_action( 'save_post', array( $this, 'save_meta_fields' ) );
    }

    public function register_meta_boxes(): void {
        add_meta_box(
            $this->post_type . '_custom_fields',
            'Cechy konia',
            array( $this, 'render_meta_box' ),
            $this->post_type,
            'advanced',
            'default'
        );
    }

    public function render_meta_box( \WP_Post $post ): void {
        wp_nonce_field( basename( __FILE__ ), $this->post_type . '_nonce' );
        foreach ( $this->fields as $field ) {
            $value = get_post_meta( $post->ID, $field['id'], true );
            echo '<p class="field-group">';
            switch ( $field['type'] ) {
                case 'text':
                    SM_Field_Builder::getField(SM_Field_Type::TEXT, array(
                        'value' => $value,
                        'label' => $field['label'],
                        'id' => $field['id']
                    ));
                    break;
                case 'checkbox':
                    SM_Field_Builder::getField(SM_Field_Type::CHECKBOX, array(
                        'value' => $value,
                        'label' => $field['label'],
                        'id' => $field['id']
                    ));
                    break;
                case 'number':
                    SM_Field_Builder::getField(SM_Field_Type::NUMBER, array(
                        'value' => $value,
                        'label' => $field['label'],
                        'id' => $field['id']
                    ));
                    break;
                // TODO: Add other types
            }
            echo '</p>';
        }
    }

    public function save_meta_fields( int $post_id ): void {
        if ( ! isset( $_POST[ $this->post_type . '_nonce' ] ) || ! wp_verify_nonce( $_POST[ $this->post_type . '_nonce' ], basename( __FILE__ ) ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( get_post_type( $post_id ) !== $this->post_type ) {
            return;
        }

        foreach ( $this->fields as $field ) {
            if ( isset( $_POST[ $field['id'] ] ) ) {
                $value = sanitize_text_field( $_POST[ $field['id'] ] );
                update_post_meta( $post_id, $field['id'], $value );
            } else {
                update_post_meta( $post_id, $field['id'], $field['type'] === 'checkbox' ? 0 : 1 );
            }
        }
    }
}
