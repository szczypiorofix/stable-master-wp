<?php
/*
 * Plugin Name: Stable Master
 * Plugin URI:        https://wroblewskipiotr.pl/
 * Description:       Plugin for managing stable
 * Version:           0.0.1
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

defined('ABSPATH') || exit;

require __DIR__ . '/constants.php';
require_once __DIR__.'/class_sm_loader.php';

try {
    $loader = new SM_Loader();

    $loader->add_directory(__DIR__ . '/includes');
    $loader->add_directory(__DIR__ . '/includes/classes');
    $loader->add_directory(__DIR__ . '/includes/cpt');
    $loader->add_directory(__DIR__ . '/admin');

    $loader->register();
    add_action( 'plugins_loaded', array( 'Stable_Master', 'initialize' ) );
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

