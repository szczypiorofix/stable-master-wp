<?php
/*
 * Plugin Name: Stable Master
 * Plugin URI:        https://wroblewskipiotr.pl/
 * Description:       Plugin for managing stable
 * Version:           0.0.2
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Piotr Wróblewski
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       stable-master
 * Domain Path:       /languages
*/

defined( 'ABSPATH' ) || exit;

require __DIR__ . '/includes/define_constants.php';
define_sm_constants( __DIR__, __FILE__ );

require_once __DIR__ . '/classes/class-sm-loader.php';

try {
    $loader = new SM_Loader();
    $loader->add_directories(
        array(
            __DIR__ . '/classes',
            __DIR__ . '/adminpages'
        )
    );

    $loader->register();
    add_action( 'plugins_loaded', array( 'Stable_Master', 'initialize' ) );
} catch ( Exception $e ) {
    echo "SM_Loader error: " . $e->getMessage();
}

