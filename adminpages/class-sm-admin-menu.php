<?php

class SM_Admin_Menu {
    public function init() {
        add_action( 'admin_menu', array( $this, 'register_admin_menu' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
    }

    public function register_admin_menu(): void {
        add_menu_page(
            'Stable Master',
            'Stable Master',
            'manage_options',
            'my-settings',
            array( $this, 'render_main_page' ),
            'dashicons-admin-generic',
            14
        );

        add_submenu_page(
            'my-settings',
            'Ustawienia Ogólne',
            'Ustawienia Ogólne',
            'manage_options',
            'my-settings',
            array( $this, 'render_main_page' )
        );

        add_submenu_page(
            'my-settings',
            'Ustawienia Dodatkowe',
            'Ustawienia Dodatkowe',
            'manage_options',
            'my-settings-extra',
            array( $this, 'render_extra_page' )
        );
    }

    public function register_settings(): void {
        $general_fields = array(
            array(
                'id' => 'site_title',
                'label' => 'Tytuł strony',
                'type' => 'text'
            ),
            array(
                'id' => 'enable_feature',
                'label' => 'Włącz funkcję',
                'type' => 'checkbox'
            ),
        );
        $general_settings = new SM_Settings_Component(
            'my_settings_group',
            'my_settings_options',
            $general_fields
        );
        $general_settings->register_settings( 'Sekcja główna' );

        $extra_fields = array(
            array(
                'id' => 'extra_field',
                'label' => 'Pole dodatkowe',
                'type' => 'text'
            ),
        );
        $extra_settings = new SM_Settings_Component(
            'my_settings_extra_group',
            'my_settings_extra_options',
            $extra_fields
        );
        $extra_settings->register_settings( 'Sekcja dodatkowa' );
    }

    public function render_main_page(): void {
        ?>
        <div class="wrap">
            <h1>Stable Master</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields( 'my_settings_group' );
                do_settings_sections( 'my_settings_group' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function render_extra_page() {
        ?>
        <div class="wrap">
            <h1>Ustawienia Dodatkowe</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('my_settings_extra_group');
                do_settings_sections('my_settings_extra_group');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }
}
