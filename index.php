<?php
require_once( dirname(__FILE__).'/config.php' );
require_once( dirname(__FILE__).'/inc/load.php' );
?><!DOCTYPE html>
<html>
<head>
	<?php do_action('admin-head-top'); ?>
	<title><?php echo apply_filters('html-title','Admin Panel'); ?></title>
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Convergence" />
	<link rel="stylesheet" href="css/html5-reset.css" />
	<link rel="stylesheet" href="css/style.css" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script src="js/script.js"></script>
	<?php do_action('admin-head'); ?>
</head>
<body class="<?php echo apply_filters('body-class','fixed-footer'); ?>">
	<header id="main-header">
		<h1><a href="<?php echo apply_filters('page-title-link',$_SERVER['REQUEST_URI']); ?>">
			<?php echo apply_filters('page-title','Admin Panel'); ?></a></h1>
		<?php do_action('main-header'); ?>
	</header>
	<?php if( has_action('navbar') ): ?>
		<nav id="main-nav">
			<?php do_action('navbar'); ?>
		</nav>
	<?php endif; ?>
	<section id="content" class="<?php echo has_action('sidebar')?'has-aside':''; ?>">
		<?php if( has_action('sidebar') ): ?>
			<aside>
				<?php do_action('sidebar'); ?>
			</aside>
		<?php endif; ?>
		<?php do_action('before-content'); ?>
		<?php do_action('content'); ?>
		<?php if( isset( $_GET['page'] ) ) do_action('content-'.addslashes($_GET['page'])); ?>
	</section>
	<footer id="main-footer">
		<?php do_action('footer'); ?>
	</footer>
	<?php do_action('admin-foot'); ?>
</body>
</html>