$(document).ready(function($) {
	function setHeaderwidth() {
		var htmlWidth = $('html').width();
		//顶部区域的宽度限制
		if(htmlWidth*0.9>1400) {
			$('.header>.content').width(1400);
			$('.content.car').width(1400);//购物车
		}else {
			if(htmlWidth<1210){
				$('.header>.content').width(1180);
				$('.content.car').width(1180);
			}else{
				$('.header>.content').width(htmlWidth*0.9);
				$('.content.car').width(htmlWidth*0.9);
			}
		}
	}
	setHeaderwidth();

	//切换语言
	$('.header-btn>a.country-txt,.top-btn>span.country-txt').click(function(event) {
		var href = $(this).data('url');
		//当前是中文
		if($(this).siblings('.country-icon').hasClass('en')){
			if(!localStorage.en){
				storageLang('en',function () {
					$(this).html('CN').siblings('.country-icon').removeClass('en').addClass('cn');
					location.href =  href;
				});
				return;
			}
			$(this).html('CN').siblings('.country-icon').removeClass('en').addClass('cn');
			location.href = href;
		}else{//当前是英文
			if(!localStorage.cn){
				storageLang('cn',function () {
					$(this).html('EN').siblings('.country-icon').removeClass('cn').addClass('en');
					location.href =  href;
				});
				return;
			}
			$(this).html('EN').siblings('.country-icon').removeClass('cn').addClass('en');
			location.href = href;
		}
	});
	//二级菜单
	$('.index-menu>li.has-sub,.header-menu>li>.trs').on('mouseenter', function(e) {
		$(this).children('ul').addClass('active');
	})
	.on('mouseleave', function(event) {
		$(this).children('ul').removeClass('active');
	});

	$('.header-btn').on('mouseenter', '.trs', function(event) {
		$(this).children('ul').addClass('active');
	})
	.on('mouseleave', '.trs', function(event) {
		$(this).children('ul').removeClass('active');
	});


	$('a[offline]').click(function(event) {
		layer.msg( trsLang('on_the_way') );
	});
});