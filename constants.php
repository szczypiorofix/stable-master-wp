<?php

defined('ABSPATH') || exit;

if (!defined('SM_PLUGIN_VERSION'))  {
    define('SM_PLUGIN_VERSION' , "1.0.1");
}

if (!defined('SM_PLUGIN_DIR_PATH'))  {
    define('SM_PLUGIN_DIR_PATH' , __DIR__);
}

if (!defined('SM_DOMAIN'))  {
    define('SM_DOMAIN' , 'stable-master');
}

if (!defined('SM_PLUGIN_NAME'))  {
    define('SM_PLUGIN_NAME' , plugin_basename(__FILE__));
}
