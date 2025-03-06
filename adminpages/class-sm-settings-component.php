<?php

class SM_Settings_Component {
    private string $option_group;
    private string $option_name;
    private array $fields;

    public function __construct( string $option_group, string $option_name, array $fields =array() ) {
        $this->option_group = $option_group;
        $this->option_name = $option_name;
        $this->fields = $fields;
    }

    public function register_settings( string $sectionTitle ): void {
        register_setting(
            $this->option_group,
            $this->option_name,
            array( 'sanitize_callback' => array( $this, 'sanitize_input' ) )
        );

        add_settings_section(
            $this->option_group . '_section',
            $sectionTitle,
            null,
            $this->option_group
        );

        foreach ($this->fields as $field) {
            add_settings_field(
                $field['id'],
                $field['label'],
                array( $this, 'render_field' ),
                $this->option_group,
                $this->option_group . '_section',
                array( 'field' => $field )
            );
        }
    }

    public function render_field( array $args ): void {
        $field = $args['field'];
        $options = get_option( $this->option_name );
        $value = isset( $options[ $field['id'] ] ) ? $options[ $field['id'] ] : '';

        switch ( $field['type'] ) {
            case 'text':
                printf(
                    '<input type="text" name="%s[%s]" value="%s" />',
                    esc_attr( $this->option_name ),
                    esc_attr( $field['id'] ),
                    esc_attr( $value )
                );
                break;
            case 'checkbox':
                printf(
                    '<input type="checkbox" name="%s[%s]" value="1" %s />',
                    esc_attr( $this->option_name ),
                    esc_attr( $field['id'] ),
                    checked( 1, $value, false )
                );
                break;
            // TODO: Add other input types
        }
    }

    public function sanitize_input( array $input ): array {
        $sanitized_input = array();
        foreach ($this->fields as $field) {
            if ( isset( $input[ $field ['id'] ] ) ) {
                switch ( $field['type'] ) {
                    case 'text':
                        $sanitized_input[ $field['id'] ] = sanitize_text_field( $input[ $field['id'] ] );
                        break;
                    case 'checkbox':
                        $sanitized_input[ $field['id'] ] = absint( $input[ $field['id'] ] );
                        break;
                }
            }
        }
        return $sanitized_input;
    }
}
