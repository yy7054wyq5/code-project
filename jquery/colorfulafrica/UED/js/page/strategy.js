/*非洲攻略--主页*/
else if($('body>.header>.banner.strategy').hasClass('strategy')){
	$('.header-menu>li a[strategy]').addClass('active');
	$('a[strategy]').siblings('ul').find('li:first-child').children('a').css({
		'background': '#f3eded'
	});

	//轮播图
	$('.img-con-center').width(400*$('.img-con-center>.item').length);//设置宽度

	//图片左右滑动
	$(document).on('click', '.left-btn,.right-btn', function(event) {
		var $imgItem = $('.img-con-center>div.item');
		if($(this).hasClass('left-btn')) $('.img-con-center').append($imgItem[0]);
		else $('.img-con-center').prepend($imgItem[$imgItem.length-1]);
	})

	//切换板块
	.on('click', '.img-con-center>.item', function(event) {
		$('.cateName').text($(this).children('span').text()).data('id', $(this).data('id'));
		var $activeA = $('.tab>a.active');
		var $tabCon = $('.tab-con[data-id="'+$activeA.data('id')+'"]');
		$tabCon.html('').show().siblings('.active').hide();
		getStrategy({
			countryId: $activeA.data('id'),
			cateId: $('.cateName').data('id'),
			clickObj: $activeA,
			pageSize: 6,
			url: '/strategy/get-strategy'
		});
	});

	//tab
	$(document).on('click', '.tab>a', function(event) {
		var $activeA = $(this);
		var id = $activeA.data('id');
		var $tabCon = $('.tab-con[data-id="'+id+'"]');
		$('.input>input').val('');
		$activeA.addClass('active').siblings('.active').removeClass('active');
		$tabCon.addClass('active').siblings('.tab-con.active').removeClass('active');
		if($tabCon.html()!==''){
			return;
		}
		getStrategy({
			countryId: id,
			clickObj:  $activeA,
			pageSize: 6,
			cateId: $('.cateName').data('id'),
			url: '/strategy/get-strategy'
		});
	});
	
	//加载更多
	$('.loading-more').click(function(event) {
		var $activeA = $('.tab>a.active');
		//将页码和总页数放到按钮上，请求后更新
		var currentpage = $activeA.data('currentpage') || 1;
		var totalPage = $activeA.data('totalpage') || 2;
		getStrategy({
			countryId: $activeA.data('id'),
			clickObj: $activeA,
			currentPage: currentpage,
			totalPage: totalPage,
			pageSize: 6,
			cateId: $('.cateName').data('id'),
			url: '/strategy/get-strategy'
		});
	});

	//搜索
	$('.tab .input>a').click(function(event) {
		_strategy_Search();
	});
	//回车搜索
	$('.input>input').focus(function(event) {
		Mousetrap.bind('enter', _strategy_Search,'keydown');
	});
	$('.input>input').blur(function(event) {
		Mousetrap.unbind('enter');
	});
	
}