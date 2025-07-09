<?php
/*
Plugin Name: Like Dislike Buttons
Description: Add Like Dislike Buttons to posts.
Version: 1.0
Author: Illia Rudakov
*/

define('LDB_PATH', plugin_dir_path(__FILE__));

require_once LDB_PATH . 'includes/install.php';
require_once LDB_PATH . 'includes/functions.php';
require_once LDB_PATH . 'includes/hooks.php';
require_once LDB_PATH . 'includes/ajax.php';

register_activation_hook(__FILE__, 'ldb_activate');