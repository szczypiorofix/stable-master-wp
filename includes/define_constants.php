<?php

defined( 'ABSPATH' ) || exit;

function define_sm_constants( string $dir, string $file ) {
    // Plugin version
    define( 'SM_PLUGIN_VERSION', "1.0.1" );

    // Plugin directory path
    define( 'SM_PLUGIN_DIR_PATH', $dir );

    // Plugin directory path
    define( 'SM_PLUGIN_DIR_PATH_URL', plugin_dir_url( $file ) );

    // Plugin domain name
    define( 'SM_DOMAIN', 'stable-master' );

    // Plugin base name
    define( 'SM_PLUGIN_NAME', plugin_basename( $file ) );

    // Custom Post Types Names
    define( 'SM_CPT_HORSE', 'sm_horse' );
}
