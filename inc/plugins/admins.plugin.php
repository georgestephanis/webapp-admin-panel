<?php

class admins_plugin {

	function go(){
		session_start();
		add_action('init',						array(__CLASS__,'init')						);
		add_action('init',						array(__CLASS__,'menu'),				80	);
		add_action('catch-post', 				array(__CLASS__,'catch_post') 				);
		add_action('before-output', 			array(__CLASS__,'before_output') 			);
		add_action('content-admins',			array(__CLASS__,'page')						);
		add_action('install-admins.plugin.php',	array(__CLASS__,'install_options_table')	);
	}
	
	function init(){
		if( isset( $_GET['page'], $_GET['action'] ) 
				&& ( 'admins' == $_GET['page'] ) 
				&& ( 'logout' == $_GET['action'] ) ){
			self::logout();
		}
	}
	
	function menu(){
		add_menu_item('Admins','?page=admins');
	}
	
	function catch_post(){
		if( isset( $_GET['page'], $_GET['action'] ) 
				&& ( 'admins' == $_GET['page'] ) 
				&& ( 'login' == $_GET['action'] ) ){
			$login = $_REQUEST['admin_login'];
			$pass = $_REQUEST['admin_pass'];
			self::login( $login, $pass );
		}
	}
	
	function before_output(){
		if( !empty( $_SESSION['admin'] ) ){
			add_menu_item('Logout','?page=admins&amp;action=logout');
		}else{
			add_action('main-header',array(__CLASS__,'login_form'));
		}
	}
	
	function login_form(){
		$rand = rand(1000,9999);
		?>
		<form class="login-form" method="post" action="?page=admins&amp;action=login">
			<table class="form-table">
				<tr><th scope="row"><label for="frm_admin_login-<?php echo $rand; ?>">U:</label></th>
					<td><input type="text" name="admin_login" id="frm_admin_login-<?php echo $rand; ?>" /></td>
					<td><input type="submit" class="button blue" value="&rarr;" /></td></tr>
				<tr><th scope="row"><label for="frm_admin_pass-<?php echo $rand; ?>">P:</label></th>
					<td><input type="password" name="admin_pass" id="frm_admin_pass-<?php echo $rand; ?>" /></td>
					<td></td></tr>
			</table>
		</form>
		<?php
	}
	
	function page(){
		?>
		<article>
			<header><h5>Admins</h5></header>
			<?php
				$action = isset( $_GET['action'] )?$_GET['action']:null;
				switch( $action ){
					case 'add':
					case 'edit':
						self::form( _val( $_GET, 'id' ) );
						break;
					default:
						self::table();
						break;
				}
			?>
		</article>
		<?php
	}
	
	function form( $id = null ){
		
	}
	
	function table(){
		$admins = self::get_all();
		if( $admins ): ?>
		
			<table class="listing-table">
				<thead>
					<tr>
						<th scope="col"><input type="checkbox" class="col-chk" /></th>
						<th scope="col">ID</th>
						<th style="text-align:center;" scope="col">Img</th>
						<th scope="col">Login</th>
						<th scope="col">Email</th>
						<th scope="col">First Name</th>
						<th scope="col">Last Name</th>
						<th scope="col">Actions</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th scope="col"><input type="checkbox" class="col-chk" /></th>
						<th scope="col">ID</th>
						<th style="text-align:center;" scope="col">Img</th>
						<th scope="col">Login</th>
						<th scope="col">Email</th>
						<th scope="col">First Name</th>
						<th scope="col">Last Name</th>
						<th scope="col">Actions</th>
					</tr>
				</tfoot>
				<tbody>
					<?php foreach( $admins as $admin ): ?>
					<tr>
						<th scope="row"><input type="checkbox" name="admin[]" value="<?php echo $admin['id']; ?>" /></th>
						<td><?php echo $admin['id']; ?></td>
						<td style="text-align:center;"><img src="http://www.gravatar.com/avatar/<?php echo md5(strtolower($admin['email'])) ?>?d=mm&amp;s=20" alt="Gravatar" height="20" width="20" /></td>
						<td><?php echo $admin['login']; ?></td>
						<td><?php echo $admin['email']; ?></td>
						<td><?php echo $admin['first_name']; ?></td>
						<td><?php echo $admin['last_name']; ?></td>
						<td></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		
		<?php else: ?>
			<p>There are no admins in the database.</p>	
		<?php endif;
	}
	
	function get_all(){
		global $db;
		return $db->get_results( "SELECT * FROM `admins`", ARRAY_A );
	}
	
	function get( $id ){
		global $db;
		$id = (int) $id;
		return $db->get_row( "SELECT * FROM `admins` WHERE `id` = '$id'", ARRAY_A );
	}
	
	function get_by_login( $login ){
		global $db;
		$login = addslashes( $login );
		return $db->get_row( "SELECT * FROM `admins` WHERE `login` = '$login'", ARRAY_A );
	}
	
	// auth simply validates credentials, it doesn't login.
	function auth( $login, $pass ){
		global $db;
		$login = addslashes( $login );
		$pass = md5( $pass );
		$admin = $db->get_row( "SELECT * FROM `admins` WHERE `login` = '$login' AND `password` = '$pass'", ARRAY_A );
		if( empty( $admin ) ){
			do_action( 'admin-failed-auth', $login );
			return false;
		}
		return apply_filters( 'admin-auth', $admin );
	}
	
	function login( $login, $pass ){
		if( $admin = self::auth( $login, $pass ) ){
			do_action( 'admin-logged-in', $admin );
			add_action('before-output',array(__CLASS__,'go_home'));
			return $_SESSION['admin'] = $admin;
		}
		return false;
	}
	
	function logout(){
		if( isset( $_SESSION['admin'] ) ){
			$admin = $_SESSION['admin'];
			unset( $_SESSION['admin'] );
			do_action( 'admin-logged-out', $admin );
			add_action('before-output',array(__CLASS__,'go_home'));
		}
	}
	
	function register(){
	
	}
	
	function go_home(){
		header('Location: ?');
		exit;
	}
	
	function install_options_table(){
		global $db;
		$sql = file_get_contents( INC_PATH.'sql/admins.plugin.sql' );
		$db->query( $sql );
	}

}
admins_plugin::go();