<?php

function __alert( $msg ){
	global $alerts;
	if( !isset( $alerts ) || !is_array( $alerts ) ) $alerts = array();
	$alerts[] = $msg;
}
function __display_alerts(){
	global $alerts;
	if( !empty( $alerts ) && is_array( $alerts ) ){
		foreach( $alerts as $alert ){
			?>
			<article class="alert">
				<?php echo $alert; ?>
			</article>
			<?php
		}
	}
}
add_action('before-content','__display_alerts',1);

# if( defined('DEBUG') && DEBUG ) __alert( 'This is a test alert!' );