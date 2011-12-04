<?php

define( 'ADMIN-PANEL-VERSION', 'ALPHA' );

// You can manually include a different config file before loading ~
if( !defined('DB_HOST') ){
	if( file_exists( dirname(__FILE__).'/../config.php' ) ){
		require_once( dirname(__FILE__).'/../config.php' );
	}else{
		die( 'You really should include a config.php before including '.__FILE__ );
	}
}

if( defined('DEBUG') && DEBUG ){
	error_reporting(E_ALL);
	ini_set('display_errors',1);
}

if( !defined('INC_PATH') ){
	define('INC_PATH',dirname(__FILE__).'/');
}

if( !defined( 'PLUGIN_PATH' ) ){
	define( 'PLUGIN_PATH', INC_PATH.'plugins/' );
}

// Include some basic compatability functions for older servers …
require_once( INC_PATH.'compat.php' );

// Use the Actions and Filters API from WordPress …
require_once( INC_PATH.'actions.php' );

// Use the EZSQL class …
require_once( INC_PATH.'ezsql_core.php' );
require_once( INC_PATH.'ezsql_mysql.php' );
$db = new ezSQL_mysql(DB_USER,DB_PASS,DB_NAME,DB_HOST);

// Our options data structure …
require_once( INC_PATH.'options.php' );

// Use the menu class … with our own wrapper function …
require_once( INC_PATH.'menu.class.php' );
require_once( INC_PATH.'tidy_menu.class.php' );
require_once( INC_PATH.'menu.php' );

// Use our own custom form-generating functions …
require_once( INC_PATH.'forms.php' );

// Include the general utility functions …
require_once( INC_PATH.'utils.php' );

// The beginnings of a plugin system for custom code …
require_once( INC_PATH.'plugins.php' );

// A place for all custom code to hook in … 
if( file_exists( INC_PATH.'custom.php' ) ){
	require_once( INC_PATH.'custom.php' );
}

do_action('load-plugins');
do_action('init');
if( $_POST ){
	do_action('catch-post');
}
do_action('before-output');