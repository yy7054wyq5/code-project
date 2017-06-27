/*主页*/
if($('body>.content>div.container').hasClass('index')){
	if(htmlWidth<1180){
		htmlWidth = 1180;
	}
	if($('.header .content').width()<1220){
		$('.header-btn').css('margin-right', -10);
		//$('.banner.index .input-con').css('left', 350);
	}else{
		$('.header-btn').css('margin-right', 45);
	}
	//轮播图
	$('.img-con').slideimg({
		width: 1010,
		height: 474,
		ratio: 406/474,
		top: 34,
		containerWidth: htmlWidth < 1400 ? htmlWidth : 1400,
		autoTime: 4000
	});

	//换一换
	var straCurrentPage = 1;//当前页
	var straTotalPage;//总页数
	var straData = [];//攻略数据
	$('.exchange').click(function(event) {
		var straTotalPage = $(this).data('page');//总页数
		var $icon = $(this).siblings('i.icon');
		$icon.addClass('animation');
		straCurrentPage = straCurrentPage + 1;
		if(straCurrentPage>straTotalPage){
			straCurrentPage = 1;
		}
		//该页有数据不请求数据直接返回
		if(straData[straCurrentPage-1]){
			//layer.msg( trsLang('no_data') );
			setTimeout(function () {
				$('.floor.strategy').html(straData[straCurrentPage-1]);
				cutRightMargin($('.floor.strategy>div'),4);
				$icon.removeClass('animation');
			},1000);
			return;
		}
		api('post','/index/strategy',{
			pageIndex: straCurrentPage
		},function (res) {
			$icon.removeClass('animation');
			var html = '';
			if(!res.status){
				straCurrentPage = res.data.pageInfo.pageIndex;
				straTotalPage = res.data.pageInfo.page;
				$.each(res.data.content, function(index, val) {
					html += createHTML(val);
				});
				straData[straCurrentPage-1] = html;
				$('.floor.strategy').html(html);
				cutRightMargin($('.floor.strategy>div'),4);
			}
		});
	});
	//玩转非洲
	$('.play-item').mouseover(function(event) {
		$(this).addClass('active').siblings().removeClass('active');
	});
	//多彩商城tab
	$(document).on('click', '.store-btn>li',function(event) {
		var index = $(this).index();
		var $this = $(this);
		if($($('.floor.store')[index]).html()!==''){
			$this.addClass('active').siblings('li.active').removeClass('active');
			$($('.floor.store')[index]).addClass('active').siblings('.active.floor.store').removeClass('active');
			return;
		}	
		api('post','/index/get-goods',{
			pageIndex: parseInt(index)+1 
		},function (res) {
			var html = '';
			if(!res.status){
				$.each(res.data.content, function(index, val) {
					html += 
					'<a class="store-item" href="/'+getLang()+'/store/detail/'+val.id+'">'+
						'<img src="/image/get/'+val.picKey+'">'+
						'<h3>'+val.name+'</h3>'+
						'<span>&yen;'+val.price+'</span>'+
					'</a>';
				});
				$($('.floor.store')[index]).html(html);
				cutRightMargin($('.floor.store>a'),3);
				$this.addClass('active').siblings('li.active').removeClass('active');
				$($('.floor.store')[index]).addClass('active').siblings('.active.floor.store').removeClass('active');
			}
		});
		
	});
	//去除右侧item的margin值
	cutRightMargin($('.floor.store>a'),3);
	cutRightMargin($('.floor.strategy>div'),4);
	cutRightMargin($('.floor.play>div.play-item'),4);
	//搜索
	$('.index-search').click(function(event) {
		indexSearch();
	});

	$('.input-con>input').focus(function(event) {
		Mousetrap.bind('enter', indexSearch, 'keydown');
	});
	$('.input-con>input').blur(function(event) {
		Mousetrap.unbind('enter');
	});
}