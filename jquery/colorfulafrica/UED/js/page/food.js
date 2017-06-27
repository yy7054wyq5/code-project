/*非洲攻略--美食*/
else if($('body>.content>div.container').hasClass('food')){
	$('.header-menu>li a[strategy]').addClass('active');
	$('a[strategy]').siblings('ul').find('li:nth-child(2)').children('a').css({
		'background': '#f3eded'
	});
	$('.img-con').slideimg({
		width: 1180,
		height: 520,
		ratio: 1,
		top: 0,
		containerWidth: htmlWidth,
		autoTime: 5000
	});
	//去除右侧item的margin值
	cutRightMargin($('ul.list>li'),3);


	//异步
	var currentPage = 1;
	$('.container.food').on('click', '.tab>a,.input>a,.loading-more', function(event) {
		if($(this)[0].nodeName=='A'){
			$(this).addClass('active').siblings('.active').removeClass('active');
			currentPage = 1;
			// $('.input>input').val('');
			$('.list').html('');
		}
		else if($(this).hasClass('loading-more')){
			currentPage += 1;
		}
		api('post','/food/get-food',{
			pageIndex: currentPage,
			pageSize: 6,
			countryId: $('.tab.country>a.active').data('id'),
			keyword: $('.input>input').val(),
			categoryId: $('.tab.category>a.active').data('id')
		},function (res) {
			var html = '';
			if(!res.status){
				if(res.data.food.length===0){
					layer.msg( trsLang('no_data') );
					return;
				}
				$.each(res.data.food, function(index, val) {
					 html +=
					 '<li>'+
					 	'<div class="detail">'+
					 		'<h3><a href="/'+getLang()+'/food/detail/'+val.id+'">'+val.name+'</a></h3>'+
					 		'<p>'+val.summary+'</p>'+
					 	'</div>'+
					 	'<img src="/image/get/'+val.picKey+'">'+
					 	'<div class="info">'+
					 		'<i class="zan"></i>'+
					 		'<span class="zan-person">'+val.thumbNum+'</span>'+
					 		'<span class="comment-person">'+val.commentNum+'</span>'+
					 		'<i class="comment"></i>'+
					 	'</div>'+
					 '</li>';
				});
			}
			$('.list').append(html);
			cutRightMargin($('ul.list>li'),3);
		});
	});
	//回车搜索
	$('.input>input').focus(function(event) {
		Mousetrap.bind('enter', _food_Search,'keydown');
	});
	$('.input>input').blur(function(event) {
		Mousetrap.unbind('enter');
	});
}