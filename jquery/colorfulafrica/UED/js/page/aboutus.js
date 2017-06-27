/*关于我们*/
else if($('body>.content>div.container').hasClass('aboutus')){
	$('.header-menu>li>a[aboutus]').addClass('active');
	
	$('body>.content').css('padding-bottom', '120px');
}