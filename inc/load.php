<?php

if( !defined('INC_PATH') ){
	define('INC_PATH',dirname(__FILE__).'/');
}

if( !defined( 'PLUGIN_PATH' ) ){
	define( 'PLUGIN_PATH', INC_PATH.'plugins/' );
}

if( !defined('DB_HOST') ){
	die( 'You really should include config.php before including '.__FILE__ );
}

// Use the Actions and Filters API from WordPress
require_once( INC_PATH.'actions.php' );

// Use the EZSQL class
require_once( INC_PATH.'ezsql_core.php' );
require_once( INC_PATH.'ezsql_mysql.php' );
$db = new ezSQL_mysql(DB_USER,DB_PASS,DB_NAME,DB_HOST);

// Our options data structure
require_once( INC_PATH.'options.php' );

// Use the menu class
require_once( INC_PATH.'menu.class.php' );
require_once( INC_PATH.'tidy_menu.class.php' );
require_once( INC_PATH.'menu.php' );

// Include the general utility functions
require_once( INC_PATH.'utils.php' );

// The beginnings of a plugin system for custom code ...
require_once( INC_PATH.'plugins.php' );

// A place for all custom code to hook in ...
if( file_exists( INC_PATH.'custom.php' ) ){
	require_once( INC_PATH.'custom.php' );
}

do_action('load-plugins');
do_action('init');
if( $_POST ){
	do_action('catch-post');
}
do_action('before-output');