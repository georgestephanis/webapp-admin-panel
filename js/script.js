jQuery(document).ready(function($){
	
	$('nav > ul ul').hide();
	$('nav li').hover(function(){
		$(this).children('ul').fadeIn(300);
	},function(){
		$(this).children('ul').hide();
	});
	
});