/*新闻时讯*/
else if($('body>.content>div.container').hasClass('news')){
	$('.header-menu>li>a[news]').addClass('active');

	//轮播图
	$('.img-con').slideimg({
		width: 1180,
		height: 520,
		ratio: 0.5,
		top: 0,
		containerWidth: htmlWidth,
		autoTime: 5000,
		hasleft: 0
	});

	//tab
	$(document).on('click', 'ul.tab>li', function(event) {
		var $activeLi = $(this);
		var id = $activeLi.data('id');
		var $tabCon = $($('.tab-con')[$activeLi.index()]);
		if(!$(this).hasClass('input')){
			$('.input>input').val('');
			$activeLi.addClass('active').siblings('.active').removeClass('active');
			$tabCon.addClass('active').siblings('.tab-con.active').removeClass('active');
			if($tabCon.html()!==''){
				return;
			}
			getNews({
				countryId: id,
				clickObj:  $activeLi,
				pageSize: 6,
				url: '/news/get-news'
			});
		}
	});

	//加载更多
	$('.loading-more').click(function(event) {
		var $activeLi = $('ul.tab>li.active');
		//将页码和总页数放到按钮上，请求后更新
		var currentpage = $activeLi.data('currentpage') || 1;
		var totalPage = $activeLi.data('totalpage') || 2;
		getNews({
			countryId: $activeLi.data('id'),
			clickObj: $activeLi,
			currentPage: currentpage,
			totalPage: totalPage,
			pageSize: 6,
			url: '/news/get-news'
		});
	});

	//搜索
	$('.tab .input>a').click(function(event) {
		_news_Search();
	});
	//回车搜索
	$('.input>input').focus(function(event) {
		Mousetrap.bind('enter', _news_Search,'keydown');
	});
	$('.input>input').blur(function(event) {
		Mousetrap.unbind('enter');
	});
	
	//class="mousetrap"
	
	//去除右侧item的margin值
	cutRightMargin($('ul.recommend>li'),4);
}