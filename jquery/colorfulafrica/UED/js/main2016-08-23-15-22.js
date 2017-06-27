/*前台页面*/
/*前台页面*/
/*前台页面*/
$(document).ready(function($) {
	/*公用设置*/
	var htmlWidth = $('body').width();//页面宽度
	if(htmlWidth>1400) $('body>.content,body>.header,body>.footer').width(1400);//宽度限制在1400px
	$('img.lazy').lazyload();//懒加载

	//记录HOST
	var getHost = function (href) {
		if(href.indexOf('http://')>-1){
			href = href.substring(7,href.length);
			Cookies.set('HOST','http://'+href.split('/',1).toString());
		}
		else if(href.indexOf('https://')>-1){
			href = href.substring(8,href.length);
			Cookies.set('HOST','https://'+href.split('/',1).toString());
		}
	};
	getHost(location.href);

	$.each($('.ljoy-hover'), function(index, val) {//hover效果设定宽度
		$(val).width($(val).parent().width());
	});
	//评论点回复两个字
	$(document).on('click', '.comment>.list>li>.rebtn', function(event) {
		$(this).hide().siblings('.input-box').show().siblings('.sendcomment').show();
	})
	//点击登录
	.on('click', '.user-login', function(event) {
		layer.modal('login');
	})
	//点击注册
	.on('click', '.user-reg', function(event) {
		layer.modal('reg');
	})
	//退出
	.on('click', '.out', function(event) {
		layer.modal({
			tag: 'tips',
			title: '提示',
			msg: '确定退出吗？'
		},function (res) {
			if(res){
				api('post','/user/logout',{
					userId: Cookies.get('userId')
				},function (res) {
					if(res.status===0){
						Cookies.remove('userId');
						Cookies.remove('mobile');
						location.reload();
					}
				});
			}
		});
	});




	/*主页*/
	if($('body>.content>div.container').hasClass('index')){
		//轮播图
		$('.img-con').slideimg({
			width: 1010,
			height: 474,
			ratio: 406/474,
			top: 34,
			containerWidth: htmlWidth,
			autoTime: 5000
		});
		//换一换
		$('.exchange').click(function(event) {
			$(this).siblings('i.icon').addClass('animation');
			setTimeout(function () {
				$('i.icon').removeClass('animation');
			},700);
		});
		//玩转非洲
		$('.play-item').mouseover(function(event) {
			$(this).addClass('active').siblings().removeClass('active');
		});
		//多彩商城tab
		$(document).on('click', '.store-btn>li',function(event) {
			$(this).addClass('active').siblings().removeClass('active');
			$($('.floor.store')[$(this).index('.store-btn>li')]).addClass('active').siblings().removeClass('active');
		});
		//去除右侧item的margin值
		cutRightMargin($('.floor.store>a'),3);
		cutRightMargin($('.floor.strategy>div'),4);
		cutRightMargin($('.floor.play>div.play-item'),4);
	}









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
		$(document).on('click', '.tab>li', function(event) {
			if(!$(this).hasClass('input')){
				$(this).addClass('active').siblings().removeClass('active');
				$($('.tab-con')[$(this).index('.tab>li')]).addClass('active').siblings('.tab-con').removeClass('active');
			}
		});
		//去除右侧item的margin值
		cutRightMargin($('ul.recommend>li'),4);
	}










	/* 新闻时讯详情 */
	else if($('body>.header>.banner.news-detail').hasClass('news-detail')){
		$('.header-menu>li>a[news]').addClass('active');
	}











	/*非洲攻略--主页*/
	else if($('body>.header>.banner.strategy').hasClass('strategy')){
		$('.header-menu>li>a[strategy]').addClass('active');
		//轮播图
		var imgConCenterW = 0;
		$.each($('.img-con-center>.item'), function(index, val) {
			imgConCenterW += $(val).width();
		});
		$('.img-con-center').width(imgConCenterW);//设置宽度
		$(document).on('click', '.img-btn>.left-btn,.img-btn>.right-btn', function(event) {
			var $imgItem = $('.img-con-center>div.item');
			if($(this).hasClass('left-btn')) $('.img-con-center').append($imgItem[0]);
			else $('.img-con-center').prepend($imgItem[$imgItem.length-1]);
		})		
		//tab
		.on('click', '.tab>a', function(event) {
			$(this).addClass('active').siblings().removeClass('active');
			$($('.tab-con')[$(this).index('.tab>a')]).addClass('active').siblings('.tab-con').removeClass('active');
		});
		//写游记按钮的限制
		if(Cookies.get('userId')){
			$('.banner.strategy .write').attr('href', '/strategy/create-strategy');
		}
		else{
			$('.banner.strategy').on('click', '.write',function () {
				layer.modal('login');
			});
		}
	}












	/*非洲攻略--游记--详情*/
	else if($('body>.header>.banner.strategy-detail').hasClass('strategy-detail')){
		$('.header-menu>li>a[strategy]').addClass('active');
	}










	/*非洲攻略--美食*/
	else if($('body>.content>div.container').hasClass('food')){
		$('.header-menu>li>a[strategy]').addClass('active');
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
	}









	/*非洲攻略--美食--详情*/
	else if($('body>.header>.banner.food-detail').hasClass('food-detail')){
		$('.header-menu>li>a[strategy]').addClass('active');
	}













	/*非洲攻略--合作伙伴*/
	else if($('body>.header>.banner.partner').hasClass('partner')){
		$('.header-menu>li>a[strategy]').addClass('active');
		//tab
		$(document).on('click', '.tab-partner>a', function(event) {
			$(this).addClass('active').siblings().removeClass('active');
			$($('.list')[$(this).index('.tab-partner>a')]).addClass('active').siblings('.list').removeClass('active');
		});
	}










	/*非洲攻略--合作伙伴--详情*/
	else if($('body>.header>.banner.partner-detail').hasClass('partner-detail')){
		$('.header-menu>li>a[strategy]').addClass('active');
		$('.img-con').slideimg({
			width: 1180,
			height: 420,
			ratio: 0.5,
			top: 0,
			containerWidth: 1180,
			autoTime: 5000
		});
	}









	/*走进非洲*/
	else if($('body>.content>div.container').hasClass('walkin')){
		$('.header-menu>li>a[walkin]').addClass('active');
		$(document).on('click', '.tab.level1>a', function(event) {
			$(this).addClass('active').siblings().removeClass('active');
		});
		$(document).on('click', '.tab.level2>a', function(event) {
			$(this).addClass('active').siblings().removeClass('active');
		});
	}








	/*走进非洲--详情*/
	else if($('body>.header>.banner.walkin-detail').hasClass('walkin-detail')){
		$('.header-menu>li>a[walkin]').addClass('active');
		cutRightMargin($('.food-box>div'),4);
		cutRightMargin($('.photo-box>div'),3);
		cutRightMargin($('.partner-box>a'),4);
		$('body').append('<div class="float-tabs" style="display:none;"></div>');
		$('.float-tabs').html($('.line-detail>.tabs').html()).css({
			left: ($('body').width()-1180)/2,
			top: 0,
			width: 1180,
			'position': 'fixed',
			'z-index': 999999
		});
		$(document).scroll(function(event) {
			var scrollTop = $('body').scrollTop();
			if(scrollTop>550){
				$('.float-tabs').show();
				$('.tabs').css('visibility', 'hidden');
			}else{
				$('.tabs').css('visibility', 'visible');
				$('.float-tabs').hide();
			}
		});

		$(document).on('click', '.float-tabs>a,.tabs>a', function(event) {
			if($(this).parent().hasClass('tabs')){
				$(this).addClass('active').siblings().removeClass('active');
				$('.float-tabs>a').removeClass('active');
				$($('.float-tabs>a')[$(this).index()]).addClass('active');
			}
			else{
				$(this).addClass('active').siblings().removeClass('active');
				$('.tabs>a').removeClass('active');
				$($('.tabs>a')[$(this).index()]).addClass('active');
			}
		});
	}










	/*多彩商城--首页*/
	else if($('body>.content>div.container').hasClass('store')){
		$('.header-menu>li>a[store]').addClass('active');
		//去除右侧item的margin值
		cutRightMargin($('ul.normal>li'),3);
	}













	/*商城详情*/
	else if($('body>.header>.banner.store-detail').hasClass('store-detail')){
		$('.header-menu>li>a[store]').addClass('active');
		//相册
		$('#thumblist').on('click', '>li', function(event) {
			$(this).siblings('li').removeClass('active');
			$('.show-img').find('img').attr('src', $(this).addClass('active').find('img').attr('src'));
		});
		//tab
		$('.abb>a').click(function(event) {
			$(this).siblings('a').removeClass('active');
			$('.'+$(this).addClass('active').attr('tab')+'').show().siblings('div.tab-con').hide();
		});
	}













	/*多彩商城--线下门店*/
	else if($('body>.header>.banner.offline').hasClass('offline')){
		$('.header-menu>li>a[store]').addClass('active');
		/*地图事件*/
		$(document).on('click', '.store-address', function(event) {
			//获取动画过渡时间，清空信息窗并隐藏
			var duringTime = $('.dis-address').hide().html('').css('transition-duration');
			duringTime = duringTime.substring(0,duringTime.length-1)*1000;
			//回到点击处
			$('.dis-address').css({
				width: 49,
				height: 55,
				right: $(this).css('right'),
				top: $(this).css('top')
			});
			//信息窗内容
			var $info = $(this).children('.info').children('div');
			var content = '登陆首都北京,在北京厚重的文化底蕴中,同样展现的是线上销售和线下体验的完美模式。不仅开辟了网购的新时代,而且还为北京消费者带来全新的购置体验。';
			var html =  '<h2>'+$info.text()+'</h2>'+
				'<img src="'+$info.data('imgsrc')+'">'+
				'<p>'+content+'</p>'+
				'<span class="address"><i></i><span>'+$info.data('address')+'</span></span>'+
				'<span class="phone"><i></i><span>'+$info.data('phone')+'</span></span>'+
				'<a href="'+$info.data('link')+'">查看详情</a>';
			//显示信息窗之后改变大小以及定位
			$('.dis-address').show(100,function () {
				$('.dis-address').css({
					width: 489,
					height: 551,
					right: 500,
					top: 0
				});	
			});
			//动画过渡时间过后装载内容
			setTimeout(function () {
				$('.dis-address').html(html);
			},duringTime);
			
		});
	}
	











	/*门店详情*/
	else if($('body>.header>.banner.offline-detail').hasClass('offline-detail')){
		$('.header-menu>li>a[store]').addClass('active');
	}








	/*关于我们*/
	else if($('body>.content>div.container').hasClass('aboutus')){
		$('.header-menu>li>a[aboutus]').addClass('active');
		$('.pager1111').pager({
			currentPage: 1,
			totalPage: 10
		});
		// layer.modal('finish');
	}

	/*用户中心*/
	/*用户中心*/
	/*用户中心*/
	//个人中心选项卡
	$(document).on('click', '.user-tab>a', function(event) {
		if($(this).hasClass('active')) return;
		else{
			$(this).addClass('active').siblings('a.active').removeClass('active');
			$($('.list')[$(this).index()]).addClass('active').siblings('.list.active').removeClass('active');
		}
	});
	$('ul.list>li:last-child>div.line').css('min-height', 67);//for ie8










	/*我的游记*/
	else if($('.user-container').hasClass('strategy')){
		$('.menu>a.strategy').addClass('active');
		//tab请求
		$('.user-tab>a').click(function(event) {
			api('post','/user/receive-strategy',{
				userId: Cookies.get('userId'),
				type: $(this).data('tag'),
				pageIndex: 1,
				pageCont: 10
			},function (res) {
				if(res.status===0){
					console.log(1);
				}
			});
		});
		//取消收藏
		$('.user-container.strategy')
		.on('click', '.list-btn>a', function(event) {
			if($('a[data-tag=2]').hasClass('active')){
				api('post','/user/collection',{
					userId: Cookies.get('userId'),
					resourceId: $(this).parents('li').data('id'),
					resourceType: 1,
					tag: 1
				},function (res) {
					layer.msg(res.msg);
					if(res.status===0){
						location.reload();
					}
				});
			}
		})
		//删除我发布的游记
		.on('click', '.selector', function(event) {
			event.preventDefault();
			/* Act on the event */
		});
	}	












	/*我的美食*/
	else if($('.user-container').hasClass('food')){
		$('.menu>a.food').addClass('active');
		//取消点赞
		$('.user-container.food')
		.on('click', '.list>li .list-btn>a', function(event) {
			api('post','/user/thumb',{
				userId: Cookies.get('userId'),
				resourceId: $(this).parents('li').data('id'),
				tag: 1
			},function (res) {
				layer.msg(res.msg);
				if(res.status===0){
					location.reload();
				}
			});
		});
	}















	/*我的线路*/
	else if($('.user-container').hasClass('line')){
		$('.menu>a.line').addClass('active');
		//取消收藏
		$('.user-container.line')
		.on('click', '.list-btn>a', function(event) {
			api('post','/user/collection',{
				userId: Cookies.get('userId'),
				resourceId: $(this).parents('li').data('id'),
				resourceType: 2,
				tag: 1
			},function (res) {
				layer.msg(res.msg);
				if(res.status===0){
					location.reload();
				}
			});
		});
		
	}








	/*订单详情*/
	else if($('.user-container').hasClass('orderdetail')){
		$('.menu>a.order').addClass('active');
		$('.shipping>.title>a').click(function(event) {
			if($(this).hasClass('active')){
				$(this).removeClass('active');
				$('.shipping>.detail').show();
			}
			else{
				$(this).addClass('active');
				$('.shipping>.detail').hide();
			}
		});
	}








	/*我的订单*/
	else if($('.user-container').hasClass('order')){
		$('.menu>a.order').addClass('active');
	}














	/*用户信息*/
	else if($('.user-container').hasClass('userinfo')){
		//用户默认信息
		var userinfo = [ 
			$('input[name="nickName"]').val(),
			$('input[name="realName"]').val(),
			$('select[name="ageRange"]').val(),
			$('.sex.active').data('id')
		];
		$('.menu>a.set').addClass('active');
		//菜单切换
		$('.userinfo-menu>li').click(function(event) {
			$(this).addClass('active').siblings('li').removeClass('active');
			$($('.user-container.userinfo>.con')[$(this).index()]).show().siblings('.con').hide();
			cutRightMargin($('.address-box>.item'),3,true);
			//获取省的数据
			if($(this).index()==1){
				getcities(0,null,$('.chosepart>.pro'));
			}
		});
		$('.sex').click(function(event) {
			$(this).addClass('active').siblings('.active').removeClass('active');
		});
		//保存用户信息
		$('.info-btn').click(function(event) {
			var checkInfo = 0;
			var newUserInfo = [
				$('input[name="nickName"]').val(),
				$('input[name="realName"]').val(),
				$('select[name="ageRange"]').val(),
				$('.sex.active').data('id')
			];
			//对比数据
			for (var i = 0; i < userinfo.length; i++) {
				if(userinfo[i] == newUserInfo[i]){
					checkInfo += 1;
				}
			}
			if(checkInfo==4){
				layer.msg('请对用户信息作出修改再保存');
				return;
			}
			if($('input[name="nickName"]').val()===''){
				layer.msg('昵称不能为空');
				return;
			}
			api('post','/user/updateuserinfo',{
				userId: Cookies.get('userId'),
				picKey: 0,
				nickname: $('input[name="nickName"]').val(),
				realName: $('input[name="realName"]').val(),
				ageRange: $('select[name="ageRange"]').val(),
				sex: $('.sex.active').data('id')
			},function (res) {
				if(res.status===0){
					location.reload();
				}
			});
		});
		//选择省市区
		$('.chosepart>select').on('change',function(event) {
			var $select = $(this);
			var id = $select.children('option:selected').attr('id');
			var classname = $select[0].className;
			switch(classname){
				case 'pro':
					getcities(1,id,$('.chosepart>select.city'));
					$('.chosepart>select.area').html('');
					break;
				case 'city':
					getcities(2,id,$('.chosepart>select.area'));
					break;
				case 'area':
					break;
				default:
					console.log('你在逗我？');
			}
		});
	}


















	//发布游记页面
	else if($('.strategy-edit-con').hasClass('strategy-edit-con')){
		$('.country').siblings('.con').children('a[id="'+$('.selected.country').data('id')+'"]').addClass('active');
		$('.category').siblings('.con').children('a[id="'+$('.selected.category').data('id')+'"]').addClass('active');
		$('.chose-con').on('click', 'i', function(event) {
			if($(this).hasClass('up')){
				$(this).removeClass('up').addClass('down');
				$(this).siblings('.con').hide();
			}
			else{
				$(this).removeClass('down').addClass('up');
				$(this).siblings('.con').show();
			}
		})
		.on('click', '.con>a', function(event) {
			$(this).addClass('active').siblings('a.active').removeClass('active');
			$(this).parents('.con').siblings('a.selected').text($(this).text()).attr('data-id',$(this).attr('id'));
		});
		//标题限制
		$('input[name=strategy-title]').keyup(function(event) {
			var trs = $(this).val();
			if(trs.length>30){
				$(this).val(trs.substring(0,30));
				return;
			}
			$('.strategy-input.title>span>span').text(trs.length);
		});
		//描述限制
		$('input[name=strategy-des]').keyup(function(event) {
			var trs = $(this).val();
			if(trs.length>50){
				$(this).val(trs.substring(0,50));
				return;
			}
			$('.strategy-input.des>span>span').text(trs.length);
		});

		//发布游记
		$('.header-btn>a').click(function(event) {
			var strategyTitle = $('input[name=strategy-title]').val();
			var strategyCountryId = $('.country').attr('data-id');
			var strategyCategoryId = $('.category').attr('data-id');
			var strategyDes = $('input[name=strategy-des]').val();
			var strategyDetail = ue.getContent();
			var strategyTag = $('input[name=strategy-tag]').val();
			if(strategyTitle===''){
				layer.msg('标题不能为空');
				return;
			}
			else if(strategyCountryId===''){
				layer.msg('请选择国家');
				return;
			}
			else if(strategyCategoryId===''){
				layer.msg('请选择分类');
				return;
			}
			else if(strategyDes===''){
				layer.msg('描述不能为空');
				return;
			}
			else if(strategyTag===''){
				layer.msg('请添加标签');
				return;
			}
			else if(strategyDetail===''){
				layer.msg('内容不能为空');
				return;
			}
			api('post','/user/create-strategy',{
				id: $('.strategy-edit-con').data('id') || 0,
				type: $(this).data('type'),
				name: strategyTitle,
				countryId: strategyCountryId,
				categoryId: strategyCategoryId,
				summary: strategyDes,
				detail: strategyDetail,
				tagIds: strategyTag,
				picKey: 0
			},function (res) {
				layer.msg(res.msg);
				if(res.status===0){
					//location.href = Cookies.get('HOST')+'/user/strategy';
				}
			});

		});
	}
});



