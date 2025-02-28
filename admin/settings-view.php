<?php

defined('ABSPATH') || exit;



?>


<?php

add_settings_section(
	'eg_setting_section',
	__('Settings section', 'stable-master'),
	'setting_section_callback_function',
	'sm_settings'
);

function setting_section_callback_function($args) {
    ?>
    <img style="max-width: 200px; height: auto;" src="<?php echo plugins_url('static/images/horse-icon.jpg', __FILE__ ) ?>" alt="" width="" height="" />
    <div>
        <pre><?= print_r($args) ?></pre>
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
    
    submit_button( __( 'Zapisz', 'stable-master' ) );
    ?>
    </form>
</div>

