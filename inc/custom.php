<?php

# if( defined('DEBUG') && DEBUG ) add_action('sidebar','dummy_sidebar_data');
function dummy_sidebar_data(){
	?>
			<h5>Things:</h5>
			<ul>
				<li>Unordered 1</li>
				<li>Unordered 2</li>
				<li>Unordered 3</li>
			</ul>
			<ol>
				<li>Ordered 1</li>
				<li>Ordered 2</li>
				<li>Ordered 3</li>
			</ol>
	<?php 
}



add_action('footer','attribution_link');
function attribution_link(){
	?>
	<small><a href="http://stephanis.info" rel="author">&copy; 2011 George Stephanis</a></small>
	<?php
}



# add_action('content','home_content');
function home_content(){
	?>
	<article>
		<header><h5>Header header header</h5></header>
		<p>Content content content &hellip;</p>
		<footer><small>Footer footer footer</small></footer>
	</article>
	<?php
}