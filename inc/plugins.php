<?php

if( !defined( 'PLUGIN_PATH' ) ){
	define( 'PLUGIN_PATH', dirname(__FILE__).'/plugins/' );
}

class plugin_system{

	function go(){
		add_action('init',				array(__CLASS__,'init')						);
		add_action('init',				array(__CLASS__,'menu'),				80	);
		add_action('content-plugins',	array(__CLASS__,'page')						);
		add_action('load-plugins',		array(__CLASS__,'load_active_plugins')		);
		
		if( isset( $_GET['activate-plugin'] ) ) self::activate_plugin( $_GET['activate-plugin'] );
		if( isset( $_GET['deactivate-plugin'] ) ) self::deactivate_plugin( $_GET['deactivate-plugin'] );
	}
	
	function init(){
		
	}
	
	function menu(){
		add_menu_item('Plugins','?page=plugins');
	}
	
	function page(){
		$available_plugins = self::get_available_plugins();
		?>
		<article>
			<header><h5>Plugins</h5></header>
			<?php if( $available_plugins ): ?>
			<table class="listing-table">
				<thead>
					<tr>
						<th scope="col"><input type="checkbox" class="col-chk" /></th>
						<th scope="col">Plugin</th>
						<th scope="col">File</th>
						<th scope="col">Active</th>
						<th scope="col">Action</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th scope="col"><input type="checkbox" class="col-chk" /></th>
						<th scope="col">Plugin</th>
						<th scope="col">File</th>
						<th scope="col">Active</th>
						<th scope="col">Action</th>
					</tr>
				</tfoot>
				<tbody>
					<?php foreach( $available_plugins as $file ): ?>
					<tr>
						<th scope="row"><input type="checkbox" name="plugin[]" value="<?php echo $file; ?>" /></th>
						<td><?php echo $file; ?></td>
						<td><?php echo $file; ?></td>
						<td><?php echo self::is_plugin_active( $file )?'Yes':'No'; ?></td>
						<td><?php if( self::is_plugin_active( $file ) ): ?>
								<a class="button red" href="?page=plugins&amp;deactivate-plugin=<?php echo $file; ?>">Deactivate</a>
							<?php else: ?>
								<a class="button blue" href="?page=plugins&amp;activate-plugin=<?php echo $file; ?>">Activate</a>
							<?php endif; ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php else: ?>
				<p><strong>No plugins found!</strong></p>
				<p>Please place any plugin files in the <code><?php echo PLUGIN_PATH; ?></code> directory, and be sure that they end with <code>.plugin.php</code> !</p>
			<?php endif; ?>

		</article>
		<?php
	}
	
	function get_available_plugins(){
		$plugins_raw = scandir( PLUGIN_PATH );
		$plugins_available = array();

		if( $plugins_raw ){
			foreach( $plugins_raw as $potential ){
				if( false !== strpos( strtolower( $potential ), '.plugin.php' ) ){
					$plugins_available[] = $potential;
				}
			}
		}
		
		return $plugins_available;
	}
	
	function get_active_plugins(){
		$active_plugins = get_option( 'active_plugins', array() );
		return $active_plugins;
	}
	
	function is_plugin_active( $file ){
		$active_plugins = self::get_active_plugins();
		if( in_array( $file, $active_plugins ) ){
			return true;
		}
		return false;
	}
	
	function activate_plugin( $file ){
		if( strpos( $file, '/' ) ) return; # We don't want to leave any chance of someone hacking into server files.
		$active_plugins = self::get_active_plugins();
		if( ! in_array( $file, $active_plugins ) ){
			set_option( 'active_plugins', array_merge( $active_plugins, array($file) ) );
		}
		self::load_plugin( $file );
		do_action("install-$file");
	}
	
	function deactivate_plugin( $file ){
		$active_plugins = self::get_active_plugins();
		if( in_array( $file, $active_plugins ) ){
			$key = array_search( $file, $active_plugins );
			unset( $active_plugins[$key] );
			set_option( 'active_plugins', $active_plugins );
		}
	}
	
	function load_active_plugins(){
		$active_plugins = self::get_active_plugins();
		foreach( $active_plugins as $file ){
			if( ! self::load_plugin( $file ) ){
				self::deactivate_plugin( $file );
				__alert( "The plugin `$file` cannot be found and has been deactivated." );
			}
		}
	}
	
	function load_plugin( $file = null ){
		if( strpos( $file, '/' ) ) return;
		if( empty( $file ) ) return null;
		if( file_exists( PLUGIN_PATH.$file ) ){
			require_once( PLUGIN_PATH.$file );
			return true;
		}
		return false;
	}

}
# pikachu::go();
plugin_system::go();


