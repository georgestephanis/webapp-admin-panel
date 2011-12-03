<?php

if( !defined('DB_HOST') ){
	die( 'You really should include config.php before including '.__FILE__ );
}

// Use the Actions and Filters API from WordPress
require_once( dirname(__FILE__).'/actions.php' );

// Use the EZSQL class
require_once( dirname(__FILE__).'/ezsql_core.php' );
require_once( dirname(__FILE__).'/ezsql_mysql.php' );
$db = new ezSQL_mysql(DB_USER,DB_PASS,DB_NAME,DB_HOST);

// Our options data structure
require_once( dirname(__FILE__).'/options.php' );

// Use the menu class
require_once( dirname(__FILE__).'/menu.class.php' );
require_once( dirname(__FILE__).'/tidy_menu.class.php' );
require_once( dirname(__FILE__).'/menu.php' );

// Include the general utility functions
require_once( dirname(__FILE__).'/utils.php' );

// The beginnings of a plugin system for custom code ...
require_once( dirname(__FILE__).'/plugins.php' );

// A place for all custom code to hook in ...
require_once( dirname(__FILE__).'/custom.php' );

do_action('load-plugins');

do_action('init');

if( $_POST ){
	do_action('catch-post');
}

do_action('before-output');