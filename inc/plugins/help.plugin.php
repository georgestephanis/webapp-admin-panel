<?php

function help_register_menu(){
	add_menu_item('Help','?page=help');
}
add_action('init','help_register_menu',99);

function help_page(){
	?>
	<article>
		<header><h5>HELP!</h5></header>
		<p>Don&rsquo;t Panic!</p>
	</article>
	<?php
}
add_action('content-help','help_page');