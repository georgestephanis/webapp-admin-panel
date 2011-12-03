<?php
function install_options_table(){
	global $db;
	$sql = file_get_contents( dirname(__FILE__).'/sql/options.sql' );
	$db->query( $sql );
}
add_action('install','install_options_table');

function load_all_options(){
	global $db, $all_options;
	$all_options = array();
	$options = $db->get_results( "SELECT * FROM `options`" );
	if( $options ){
		foreach( $options as $row ){
			$all_options[$row->option_name] = unserialize( stripslashes( $row->option_value ) );
		}
	}
}

function get_option( $option, $default = false ) {
	global $all_options;
	if( !isset( $all_options ) || !is_array( $all_options ) ){
		load_all_options();
	}
	if( isset( $all_options[$option] ) ){
		return $all_options[$option];
	}else{
		return $default;
	}
}

function set_option( $option, $newvalue ){
	global $db, $all_options;
	$all_options[$option] = $newvalue;
	if( $db->get_var( "SELECT COUNT( * ) FROM `options` WHERE `option_name` = '$option' " ) ){
		return $db->query( "UPDATE `options` SET `option_value` = '".addslashes( serialize( $newvalue ) )."' WHERE `option_name` = '$option' LIMIT 1" );
	}else{
		return $db->query( "INSERT INTO `options` SET `option_value` = '".addslashes( serialize( $newvalue ) )."', `option_name` = '$option' " );
	}
}

function delete_option( $option ) {
	global $db, $all_options;
	unset( $all_options[$option] );
	return $db->query( "DELETE FROM `options` WHERE `option_name` = '$option' LIMIT 1" );
}
