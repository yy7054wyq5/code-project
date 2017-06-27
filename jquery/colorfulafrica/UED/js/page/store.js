/*多彩商城--首页*/
else if($('body>.content>div.container').hasClass('store')){
	$('.header-menu>li a[store]').addClass('active');
	$('a[store]').siblings('ul').find('li:first-child').children('a').css({
		'background': '#f3eded'
	});
	//去除右侧item的margin值
	cutRightMargin($('ul.normal>li'),3);
	//异步
	$('.container.store').on('click', '.input>a,.loading-more', function(event) {
		var $a = $('.search-btn');
		if($(this).hasClass('loading-more')){
			$a.data('pageindex', parseInt($a.data('pageindex')) + 1);
		}else if($('.input>input').val()===''){
			layer.msg( trsLang('no_keywords') );
			return;
		}
		_store_Search();
	});

	//回车搜索
	$('.input>input').focus(function(event) {
		Mousetrap.bind('enter', _store_Search,'keydown');
	});
	$('.input>input').blur(function(event) {
		Mousetrap.unbind('enter');
	});
}
