<?php

defined('ABSPATH') || exit;

// Plugin version
if (!defined('SM_PLUGIN_VERSION'))  {
    define('SM_PLUGIN_VERSION', "1.0.1");
}

// Plugin directory path
if (!defined('SM_PLUGIN_DIR_PATH'))  {
    define('SM_PLUGIN_DIR_PATH', __DIR__);
}

// Plugin domain name
if (!defined('SM_DOMAIN'))  {
    define('SM_DOMAIN', 'stable-master');
}

// Plugin base name
if (!defined('SM_PLUGIN_NAME'))  {
    define('SM_PLUGIN_NAME', plugin_basename(__FILE__));
}

// Custom Post Types Names
if (!defined('SM_CPT_HORSE'))  {
    define('SM_CPT_HORSE', 'sm_horse');
}
