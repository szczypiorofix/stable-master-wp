<?php

class SM_Field_Builder {

    private function __construct() {}
    private function __clone() {}

    public static function getField(
        string $type,
        array $field,
        array $style = array(
            'width' => 'full', /** full, half, quarter */
            'display' => 'block', /** block, flex */
            'direction' => 'row', /** row, column */
        )
    ): void {
        $inputClasses = SM_Field_Builder::getFieldClass($style);

        echo '<label for="' . esc_attr( $field['id'] ) . '">' . esc_html( $field['label'] ) . '</label><br>';
        switch ( $type ) {
            case SM_Field_Type::CHECKBOX:
                ?>
                    <input
                        type="checkbox"
                        id="<?= esc_attr( $field['id'] ) ?>"
                        name="<?= esc_attr( $field['id'] ) ?>"
                        class="<?= $inputClasses ?>"
                        <?= checked( $field['value'] === 'on', 1, false ) ?>
                    />
                <?php
                return;
            case SM_Field_Type::NUMBER:
                // echo '<input type="number" id="' . esc_attr( $field['id'] ) . '" name="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $field['value'] ) . '" style="width: 100%;" />';
                ?>
                    <input
                        type="number"
                        id="<?= esc_attr( $field['id'] ) ?>"
                        name="<?= esc_attr( $field['id'] ) ?>"
                        value="<?= esc_attr( $field['value'] ) ?>"
                        class="<?= $inputClasses ?>"
                    />
                <?php
                return;
            default:
                // text
                echo '<input type="text" id="' . esc_attr( $field['id'] ) . '" name="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $field['value'] ) . '" style="width: 100%;" />';
        }
    }

    private static function getFieldClass( array $style ): string {
        return "admin field" 
            . ' sm_width_' . ( isset( $style['width'] ) ? $style["width"] : '' )
            . ' sm_display_' . ( isset( $style['display'] ) ? $style["display"] : '' )
            . ' sm_direction_' . ( isset( $style['direction'] ) ? $style["direction"] : '' );
    }
}
