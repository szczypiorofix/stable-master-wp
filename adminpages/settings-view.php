<?php

defined( 'ABSPATH' ) || exit;

add_settings_section(
	'eg_setting_section',
	__( 'Zarządzanie', SM_DOMAIN ),
	'setting_section_callback_function',
	'sm_settings'
);

function setting_section_callback_function($args) {
    ?>
    <div class="sm_admin main">
        <img class="logo" src="<?= plugins_url( 'images/horse-icon.jpg',__FILE__ ) ?>" alt="Stable Master logo" />
        <div>
            <pre><?= print_r($args) ?></pre>
        </div>
    </div>
    <?php
}

?>

<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <form action="options.php" method="post">
    <?php
    
    settings_fields( 'sm_settings' );
    
    do_settings_sections( 'sm_settings' );
    
    submit_button( __( 'Zapisz', SM_DOMAIN ) );
    ?>
    </form>
</div>
