<?php

function add_menu_item( $title, $link, $parent = null, $menu = 'default' ){
	global $menus;
	if( !isset( $menus ) ) $menus = array();
	if( empty( $parent ) ){
		if( isset( $menus[$menu] ) ){
			return $menus[$menu]->add($title,$link);
		}else{
			return $menus[$menu] = menu::factory()->add($title,$link);
		}
	}elseif( is_scalar( $parent ) ){
		if( isset( $menus[$menu] ) ){
			foreach( $menus[$menu]->items as &$item ){
				if( in_array( $parent, $item ) ){
					if( empty( $item['children'] ) ){
						$item['children'] = menu::factory()->add($title,$link);
					}else{
						$item['children']->add($title,$link);
					}
				}
			}
		}else{
			die('Error at '.__FILE__.':'.__LINE__);
		}
	}else{
		die('Error at '.__FILE__.':'.__LINE__);
	}
	return null;
}

function render_menu( $menu = 'default', $attrs = array() ){
	global $menus;
	if( empty( $menu ) ){
		$menu = 'default';
	}
#	var_dump( $menus );
	if( isset( $menus[$menu] ) ){
		if( $attrs ){
			$menus[$menu]->attrs = $attrs;
		}
		# $menus[$menu]->render();
		echo new tidy_menu( $menus[$menu] );
	}
}

add_action('navbar','render_menu');

function default_menu_items(){
	add_menu_item('Home','?');
}
add_action('init','default_menu_items',1);
