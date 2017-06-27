$(function() {
//这是JS开始部分
var htmlWidth = $('body').width();//页面宽度
if(htmlWidth>1400) $('body>.header>.content').width(1350);//宽度限制在1400px
if(htmlWidth<1210){
	$('body,html').width(1210);
}
//.content-txt为内容区域
$('img.lazy').lazyload();//懒加载
if(Cookies.get('captcha')){
	Cookies.remove('captcha');
}

//个人中心内容区域最低高度设置
if($('.header.user .user-container').hasClass('user-container')){
	$('.header.user .user-container').css('min-height', getMinHeight($('.header.user .user-container'),[$('.footer.user')]));
}

//在cookie中存HOST
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
//评论回复的字数检测
.on('keyup', '.input-box>textarea ', function(event) {
	var content = $(this).val();
	if(content.length>200){
		$(this).val( content.substring(0,200) );
	}
	$(this).siblings('.txt').find('.txtnum').text(content.length);
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
		title: trsLang('tips'),
		msg: trsLang('sure_to_quit')
	},function (res) {
		if(res){
			api('post','/user/logout',{
				userId: Cookies.get('userId')
			},function (res) {
				if(!res.status){
					Cookies.remove('userId');
					Cookies.remove('mobile');
					location.reload();
				}
			});
		}
	});
})
//发表评论
.on('click', '.comment-btn', function(event) {
	var content = $(this).siblings('textarea').val();
	if(!isLogin()){//需要登录
		layer.modal('login');
		return;
	}else if(!content||/^ +| +$/.test(content)){//不能为空
		layer.msg(trsLang('comment_cannot_empty'));
		return;
	}
	api('post','/user/create-comment',{
		userId: Cookies.get('userId'),
		resourceId: $(this).parents('.send-comment').data('id'),
		resourceType: $(this).data('type'),
		content: content
	},function (res) {
		layer.msg(res.msg);
		if(!res.status){
			location.reload();
		}
	});
})
//回复评论
.on('click', '.sendcomment', function(event) {
	var comment = $(this).parents('li').find('textarea').val();
	if(!isLogin()){//需要登录
		layer.modal('login');
		return;
	}else if(!comment||/^ +| +$/.test(comment)){
		layer.msg( trsLang('comment_cannot_empty') );
		return;
	}
	api('post','/user/create-comment',{
		userId: Cookies.get('userId'),
		quoteId: $(this).siblings('.comment-detail').data('id'),
		resourceId: $('.send-comment').data('id'),
		resourceType: $('.comment-btn').data('type'),
		content: comment
	},function (res) {
		layer.msg(res.msg);
		if(!res.status){
			location.reload();
		}
	});
})
//收藏
.on('click', '.collect', function(event) {
	if(!isLogin()){
		layer.modal('login');
		return;
	}
	var tag = 0;//收藏
	var type = 2;//收藏线路
	var $star = $(this).siblings('i.star');
	if($star.hasClass('active')){
		tag = 1;//取消收藏
	}
	if($('.strategy-detail').hasClass('strategy-detail')){
		type = 1;//收藏游记攻略
	}
	api('post','/user/collection',{
		userId: Cookies.get('userId'),
		resourceId: $(this).data('id'),
		resourceType: type,
		tag: tag
	},function (res) {
		layer.msg(res.msg);
		if(!res.status){
			location.reload();
		}
	});
})
//点赞
.on('click', '.dianzan', function(event) {
	$zan = $(this).siblings('.zan');
	if(!isLogin()){
		layer.modal('login');
		return;
	}
	api('post','/user/thumb',{
		userId: Cookies.get('userId'),
		resourceId: $(this).data('id'),
		tag: $zan.hasClass('active') ? 1 : 0
	},function (res) {
		if(!res.status){
			if($zan.hasClass('active')) $zan.removeClass('active');
			else $zan.addClass('active');
			location.reload();
		}
	});
})
//加入购物车和立即购买
.on('click', '.addcar,.buynow', function(event) {
	var $self = $(this);
	if(!isLogin()){
		layer.modal('login');
		return;
	}
	else if($('.size>a.active').length===0&&$('.size').hasClass('size')){
		layer.msg(trsLang('select_specifications'));
		return;
	}
	api('post','/user/shopping',{
		id: $(this).data('id'),
		spec: $('.size>a.active').text(),
		number: $self.siblings('.addcut').children('input').val()
	},function (res) {
		layer.msg(res.msg);
		if(!res.status&&$self.hasClass('buynow')){
			location.href = Cookies.get('HOST') + '/'+getLang()+'/user/car';
		}
	});
})
//进入购物车
.on('click', 'i.car', function(event) {
	if(!isLogin()){
		layer.modal('login');
		return;
	}
	location.href = Cookies.get('HOST') +'/'+ getLang() +'/user/car';
});

//个人中心选项卡
$(document).on('click', '.user-tab>a', function(event) {
	if($(this).hasClass('active')) return;
	else{
		$('.user-container.strategy').css('min-height', $(window).height()-$('.header.user>.content').height()-$('.top').height()-$('.footer.user').height()-270);
		$(this).addClass('active').siblings('.active').removeClass('active');
		$($('.list')[$(this).index()]).addClass('active').siblings('.list.active').removeClass('active');
	}
});
$('ul.list>li:last-child>div.line').css('min-height', 67);//for ie8

var addressInfo;//存放编辑地址的json
//编辑地址
$('.address-box').on('click', '.item .edit', function(event) {
	addressInfo = $(this).parents('.item').data('object');
	$('.handle-address .address-btn').data('id', addressInfo.id);
	$('.lz-modal').find('.address-btn').data('id', addressInfo.id);
	var $editBox = $('.handle-address') || $('.lz-modal');
	$editBox.find('input[name="name"]').val(addressInfo.name);
	$editBox.find('.pro').children('option[value="'+addressInfo.provinceId+'"]').prop('selected', true);
	$editBox.find('.city').children('option:selected').text(addressInfo.cityName);
	$editBox.find('.area').children('option:selected').text(addressInfo.districtName);
	$editBox.find('input[name="detail-address"]').val(addressInfo.detail);
	$editBox.find('input[name="postcode"]').val(addressInfo.postcode);
	$editBox.find('input[name="mobile"]').val(addressInfo.mobile);
	$('.city').children().remove();
	$('.area').children().remove();
})
//设为默认地址，删除地址，包含了确认订单页的地址操作。
.on('click', '.default, .delete', function(event) {
	var $self = $(this);
	var tag = 0;//设为默认
	var id = $(this).parents('.item').data('id');
	if($(this).hasClass('delete')){
		tag = 1;//删除
		layer.modal({
			tag: 'tips',
			title: trsLang('tips'),
			msg: trsLang('is_delete')
		},function (res) {
			if(res){
				api('post','/user/operate-address',{
					tag: tag,
					id: id
				},function (res) {
					layer.msg(res.msg);
					$self.parents('.item').remove();
					cutRightMargin($('.address-box>.item'),3,true);
				});
			}
		});
	}
	else{
		api('post','/user/operate-address',{
			tag: tag,
			id: id
		},function (res) {
			layer.msg(res.msg);
			$self.text( trsLang('defualt_address') ).parents('.item').addClass('active');
			$self.parents('.item').siblings('.active').removeClass('active').children('.default').text( trsLang('set_defualt') );
		});
	}	
});


//新增,编辑地址
$('.handle-address').on('click', '.address-btn', function(event) {
	var name = $('input[name="name"]').val();
	var provinceId = $('select.pro').find('option:selected').val();
	var provinceName = $('select.pro').find('option:selected').text();
	var cityId = $('select.city').find('option:selected').val();
	var cityName = $('select.city').find('option:selected').text();
	var districtId = $('select.area').find('option:selected').val();
	var districtName = $('select.area').find('option:selected').text();
	var detail = $('input[name="detail-address"]').val();
	var mobile = $('input[name="mobile"]').val();
	var postcode = $('input[name="postcode"]').val();
	if(name===''){
		layer.msg(trsLang('please_enter_consignee_name'));
		return;
	}else if(cityId==trsLang('first_chose_pro')){
		layer.msg(trsLang('chose_pro'));
		return;
	}else if(districtId==trsLang('first_chose_city')||districtId===''){
		layer.msg(trsLang('chose_city'));
		return;
	}else if(detail===''){
		layer.msg(trsLang('enter_detail_address'));
		return;
	}else if(mobile===''){
		layer.msg(trsLang('enter_consignee_phonenumber'));
		return;
	}else if(mobile.length!==11){
		layer.msg(trsLang('wrong_number'));
		return;
	}else if(isNaN(parseInt(mobile))){
		layer.msg(trsLang('wrong_number'));
		return;
	}
	api('post','/user/address',{
		id: $(this).data('id') || 0,
		name: name,
		provinceId: provinceId,
		provinceName: provinceName,
		cityId: cityId,
		cityName: cityName,
		districtId: districtId,
		districtName: districtName,
		detail: detail,
		mobile: mobile,
		postcode: postcode
	},function (res) {
		if(!res.status){
			location.reload();
		}
	});
});

//上传头像
$('#fileupload')
.bind('fileuploadsend', function (e, data) {
	var isSend = true;
	$.each(data.files, function(index, val) {
		//不能超过2M
		if(val.size>2000000){
			data.files.splice(index);
			layer.msg(trsLang('file')+' ['+val.name+'] '+trsLang('toobig')+'2M');
			isSend = false;
		}
		//只能是图片
		else if( !(/\.jpg$|\.jpeg$|\.gif$|\.png$/i.test(val.name)) ){
			layer.msg(trsLang('file')+' ['+val.name+'] '+trsLang('typenotcorrect'));
			isSend = false;
		} 
	});
	return isSend;
})
.fileupload({
    url: '/'+getLang()+'/user/upload-file',
    dataType: 'json',
    done: function (e, data) {
    	var res = data.result;
    	$('.progress-bar').width(0);
    	var imgID = res.data.imageId;
    	api('post','/user/updateuserinfo',{
		userId: Cookies.get('userId'),
		picKey: imgID,
	},function (res) {
		layer.msg(res.msg);
		$('.info>img').attr('src','/image/get/'+imgID);
	});
    }
});

$('.container.blank').css('min-height', $(window).height()-$('.header.user').height()-$('.footer.user').height());
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
else if($('body>.content>div.container').hasClass('aboutus')){
	$('.header-menu>li>a[aboutus]').addClass('active');
	
	$('body>.content').css('padding-bottom', '120px');
}
else if($('.user-container.commentorder').hasClass('commentorder')){
	//商品数为0跳转到我的订单列表
	if($('.product-list>li').length===0){
		location.href = Cookies.get('HOST') + '/'+ getLang() + '/user/order';
	}
	//初始化上传插件
	var uploader = $('.send-comment');
	for (var i = 0; i < uploader.length; i++) {
		$('#comment-order-icon'+i)
		.bind('fileuploadsend', function (e, data) {
			var isSend = true;
			$.each(data.files, function(index, val) {
				//不能超过2M
				if(val.size>2000000){
					data.files.splice(index);
					layer.msg(trsLang('file')+' ['+val.name+'] '+trsLang('toobig')+'2M');
					isSend = false;
				}
				//只能是图片
				else if( !(/\.jpg$|\.jpeg$|\.gif$|\.png$/i.test(val.name)) ){
					layer.msg(trsLang('file')+' ['+val.name+'] '+trsLang('typenotcorrect'));
					isSend = false;
				} 
			});
			if($('.number').text()===0){
		    		isSend = false;
		    	}
			return isSend;
		})
		.fileupload({
		    url: '/'+getLang()+'/user/upload-file',
		    dataType: 'json',
		    done: function (e, data) {
		    	var res = data.result;
		    	layer.msg(res.msg);
		    	var imgID = res.data.imageId;
		    	//图片预览
		    	var $imgCon = $(this).parents('.camera-box').siblings('.img-con');
		    	$imgCon.find('.img-list').append('<div class="handle-img"><img data-id="'+imgID+'" src="/image/get/'+imgID+'"><i>x</i></div>');
		    	$imgCon.find('.number').text(10-$imgCon.find('.img-list>.handle-img').length);
		    }
		});
	}

	//删除图片
	$(document).on('click', '.img-list>div>i', function(event) {
		var num = $(this).parents('.img-con').find('.number').text();
		$(this).parents('.img-con').find('.number').text( parseInt(num) + 1);
		$(this).parents('.handle-img').remove();
	});
	
	//评论内容限制
	$('.send-comment').on('keyup', 'textarea', function(event) {
		var content = $(this).val();
		$('.content-num>span').text(content.length);
		if(content.length>500){
			$(this).val(content.substring(0,500));
			return;
		}
	});

	//提交评价
	$('.submit-comment').click(function(event) {
		var $self = $(this);
		var content = $self.parents('.send-comment').find('textarea').val();
		var $imgArray = $self.siblings('.img-con').find('img');
		var resourceId = $self.parents('.send-comment').data('id');
		var imgIDs = ''; 
		$.each($imgArray, function(index, val) {
			imgIDs += $(val).data('id') + ',';
		});
		imgIDs = imgIDs.substring(0,imgIDs.length-1).split(',');
		if($imgArray.length===0){
			imgIDs = [];
		}
		if(!content||/^ +| +$/.test(content)){
			layer.msg( trsLang('comment_cannot_empty') );
			return;
		}
		//console.log(imgIDs);
		api('post','/user/create-comment',{
			userId: Cookies.get('userId'),
			resourceId: resourceId,
			resourceType: 4,
			content: content,
			album: imgIDs,
			orderId: $(this).data('orderid')
		},function (res) {
			layer.msg(res.msg);
			if(!res.status){
				location.reload();
			}
		});
	});
}
else if($('body>.header>.banner.food-detail').hasClass('food-detail')){
	$('.header-menu>li a[strategy]').addClass('active');

	
}
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
else if($('.user-container').hasClass('food')){
	$('.menu>a.food').addClass('active');

	//默认请求的数据
	getFoodList(0,1);

	//tab请求
	$('.user-tab>a,.loading-more').click(function(event) {
		var $self = $(this);
		var $activeA = $('.user-tab>a.active');
		var tag = $self.data('tag');
		var $list = $('.list[data-tag="'+tag+'"]');
		var currentPage = $self.data('currentpage') || $activeA.data('currentpage');
		var totalPage = $self.data('totalpage') || null;

		$('.no-product').hide();
		$('.loading-more').show();
		
		if($list.html()&&!$self.hasClass('loading-more')){
			return;
		}else if($self.hasClass('loading-more')){
			tag = $activeA.data('tag');
			$list = $('.list[data-tag="'+tag+'"]');
			currentPage = parseInt(currentPage) + 1;
			totalPage = $activeA.data('totalpage');
			if(currentPage>totalPage&&totalPage){
				layer.msg( trsLang('no_data') );
				return false;
			}
		}else if($self.find('span').text()===0){
			//console.log('没有的不能点击');
			return;
		}
		//console.log('类型：'+tag);
		//console.log('当前页'+currentPage);
		getFoodList(tag,currentPage);
	});

	//取消点赞
	$('.user-container.food')
	.on('click', '.list>li .list-btn>a', function(event) {
		api('post','/user/thumb',{
			userId: Cookies.get('userId'),
			resourceId: $(this).data('id'),
			tag: 1
		},function (res) {
			layer.msg(res.msg);
			if(!res.status){
				location.reload();
			}
		});
	});
}
else if($('.user-container').hasClass('line')){
	$('.menu>a.line').addClass('active');
	//取消收藏
	$('.user-container.line')
	.on('click', '.list-btn>a', function(event) {
		api('post','/user/collection',{
			userId: Cookies.get('userId'),
			resourceId: $(this).parents('li[data-id]').data('id'),
			resourceType: 2,
			tag: 1
		},function (res) {
			layer.msg(res.msg);
			if(!res.status){
				location.reload();
			}
		});
	});
	
	//加载更多
	$('.loading-more').on('click',function(event) {
		var $self = $(this);
		var pageIndex = $self.data('currentPage') || 1;
		var totalPage = $self.data('totalPage') || 2;
		pageIndex = parseInt(pageIndex) + 1;
		if(pageIndex>totalPage){
			layer.msg( trsLang('no_data') );
			return;
		}
		api('post',getLang()+'/user/line',{
			userId: Cookies.get('userId'),
			pageIndex: pageIndex + 1
		},function (res) {
			if(!res.status){
				$self.data('currentPage', res.data.pageInfo.pageIndex);
				$self.data('totalPage', res.data.pageInfo.page);
				if(res.data.line.length===0){
					layer.msg( trsLang('no_data') );
					return;
				}
				var html = '';
				$.each(res.data.line, function(index, val) {
					html += 
					'<li data-id="'+val.resourceId+'">'+
						'<i class="circle"></i>'+
						'<div class="date">'+trsLang('I_at')+val.createTime+trsLang('collected_this_strategy')+'</div>'+
						'<div class="line">'+
							'<div class="list-btn" style="top:40px;">'+
								'<i class="star"></i>'+
								'<a>'+trsLang('cancel_collect')+'</a>'+
							'</div>'+
							'<div class="content">'+
								'<img src="/image/get/'+val.picKey+'" style="width:84px;">'+
								'<div class="txt nobg" style="width:845px;">'+val.name+'</div>'+
							'</div>'+
							'<hr>'+
						'</div>'+
					'</li>';
				});
				$('.list').append(html);
			}
		});
	});
}
else if($('.user-container').hasClass('order')){
	$('.menu>a.order').addClass('active');
	
	//异步加载数据
	$('.user-tab>a,.loading-more').click(function(event) {
		var $self = $(this);
		var $activeA = $('.user-tab>a.active');
		var tag = $self.data('tag');
		var $list = $('.list[data-tag="'+tag+'"]');
		var currentPage = $self.data('currentpage') || $activeA.data('currentpage');
		var totalPage = $activeA.data('totalpage') || null;

		$('.no-product').hide();
		$('.loading-more').show();
		
		if($list.html()&&!$self.hasClass('loading-more')){
			return;
		}else if($self.hasClass('loading-more')){
			tag = $activeA.data('tag');
			$list = $('.list[data-tag="'+tag+'"]');
			currentPage = parseInt(currentPage) + 1;
			totalPage = $activeA.data('totalpage');
			if(currentPage>totalPage&&totalPage){
				layer.msg( trsLang('no_data') );
				return false;
			}
		}else if($self.find('span').text()===0){
			//console.log('没有的不能点击');
			return;
		}
		//console.log('类型：'+tag);
		//console.log('当前页'+currentPage);
		getOrderList(tag,currentPage);
	
	});

	//去支付
	$(document).on('click', '.go-pay', function(event) {
		var orderId = $(this).parents('li[data-orderid]').data('orderid');
		api('post','/user/create-order',{
			orderId: orderId,
			userId: Cookies.get('userId')
		},function (res) {
			layer.msg(res.msg);
			if(!res.status){
				localStorage.orderId = res.data.orderNo;
				if(isNumber(res.data.id)){
					localStorage.removeItem('payDetail');
					localStorage.picId = res.data.id;
					//$('.user-container.orderdetail').html('<div class="zhifu"><img src="/image/get/'+res.data.id+'"><p>请用微信扫描二维码进行支付。</p></div>');
				}else{
					localStorage.removeItem('picId');
					localStorage.payDetail = res.data;
					//$('.user-container.orderdetail').html('<div class="zhifu">'+res.data+'</div>');
				}
				location.href  = Cookies.get('HOST') + '/' + getLang() + '/user/pay';
			}
		});
	})
	//确认收货
	.on('click', '.receive-good', function(event) {
		api('post','/user/operate-order',{
			orderId: $(this).parents('li[data-orderid]').data('orderid'),
			tag: 1
		},function (res) {
			layer.msg(res.msg);
			if(!res.status){
				location.reload();
			}
		});
	});
}
else if($('.user-container').hasClass('strategy')){
	$('.menu>a.strategy').addClass('active');

	//tab请求
	$('.user-tab>a,.loading-more').click(function(event) {
		var $self = $(this);
		var $activeA = $('.user-tab>a.active');
		var tag = $self.data('tag');
		var $list = $('.list[data-tag="'+tag+'"]');
		var currentPage = $self.data('currentpage') || $activeA.data('currentpage');
		var totalPage = $self.data('totalpage') || null;

		$('.no-product').hide();
		$('.loading-more').show();
		
		if($list.html()&&!$self.hasClass('loading-more')){
			return;
		}else if($self.hasClass('loading-more')){
			tag = $activeA.data('tag');
			$list = $('.list[data-tag="'+tag+'"]');
			currentPage = parseInt(currentPage) + 1;
			totalPage = $activeA.data('totalpage');
			if(currentPage>totalPage&&totalPage){
				layer.msg( trsLang('no_data') );
				return false;
			}
		}else if($self.find('span').text()===0){
			//console.log('没有的不能点击');
			return;
		}
		//console.log('类型：'+tag);
		//console.log('当前页'+currentPage);
		getStrategyList(tag,currentPage);
	});

	//取消收藏
	$('.user-container.strategy')
	.on('click', '.list-btn>a', function(event) {
		if($('a[data-tag=2]').hasClass('active')){
			api('post','/user/collection',{
				userId: Cookies.get('userId'),
				resourceId: $(this).data('id'),
				resourceType: 1,
				tag: 1
			},function (res) {
				layer.msg(res.msg);
				if(!res.status){
					location.reload();
				}
			});
		}
	})
	//删除我发布的游记
	.on('click', '.deleteBtn', function(event) {
		api('post','/user/del-strategy',{
			id: $(this).data('id')
		},function (res) {
			layer.msg(res.msg);
			if(!res.status){
				location.reload();
			}
		});
	});
}	

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
	$('.updateinfo-btn').click(function(event) {
		var checkInfo = 0;
		var _newName = $('input[name="nickName"]').val();
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
			layer.msg(trsLang('change_info'));
			return;
		}else if(_newName===''){
			layer.msg(trsLang('username_cannot_empty'));
			return;
		}else if(_newName.toString().length>11){
			layer.msg(trsLang('username_cannot_long'));
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
			layer.msg(res.msg);
			if(!res.status){
				location.reload();
			}
		});
	});
	
	//选择省市区
	$('.chosepart>select').on('change',function(event) {
		var $select = $(this);
		var id = $select.children('option:selected').val();
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
				//console.log('你在逗我？');
		}
	});

	//密码检测
	$('input[name="newpass"]').blur(function(event) {
		testPass($(this));
	});
	
	//修改密码
	$('.changepass-btn').click(function(event) {
		var oldpass = $('input[name="oldpass"]').val();
		var newpass =  $('input[name="newpass"]').val();
		var repass = $('input[name="confirmpass"]').val();
		if(oldpass===''){
			layer.msg(trsLang('enter_old_password'));
			return;
		}else if(newpass===''){
			layer.msg(trsLang('enter_new_password'));
			return;
		}else if(!testPass($('input[name="newpass"]'))){
			return;
		}else if(repass===''){
			layer.msg(trsLang('enter_duplicate_password'));
			return;
		}else if(newpass!==repass){
			layer.msg(trsLang('new_isdifferent_duplicate'));
			return;
		}else if(!$('input[name="newpass"]')){
			layer.msg( trsLang('input_password') );
			return;
		}
		api('post','/user/modify-password',{
			oldPassword: oldpass,
			newPassword: newpass,
			rePassword: repass
		},function (res) {
			layer.msg(res.msg);
			if(!res.status){
				$.post('/'+getLang()+'/user/logout', {
					userId: Cookies.get('userId')
				}, function(data, textStatus, xhr) {
					if(!data.status){
						Cookies.remove('userId');
						Cookies.remove('mobile');
						location.reload();
					}
				});
			}
		});
	});

	//加载更多问卷
	$('.invest.con').on('click', '.loading-more', function(event) {
		var $self = $(this);
		var currentPage = $self.data('pageindex') + 1;
		var totalPage = $self.data('pagecount');
		if(currentPage>totalPage){
			layer.msg( trsLang('no_data') );
			return;
		}
		api('post','/user/invest',{
			pageIndex: currentPage,
			pageCount: totalPage
		},function (res) {
			if(res.data.invest.length===0){
				layer.msg(trsLang('no_data'));
				$self.data('pageindex',res.data.pager.pageIndex);
				$self.data('pagecount',res.data.pager.page);
				return;
			}
			layer.msg(res.msg);
			if(!res.status){
				var html = '';
				$self.data('pageindex',res.data.pager.pageIndex);
				$self.data('pagecount',res.data.pager.page);
				$.each(res.data.invest, function(index, val) {
					html +=
					 '<li>'+
					 	'<a href="/user/invest/'+val.id+'" title="'+val.title+'">'+val.title+'</a>'+
					 	'<span>'+val.createTime+'</span>'+
					 '</li>';
				});
				$self.siblings('.QAQ').append(html);
			}
		});
	});

}
else if($('body>.header>.banner.news-detail').hasClass('news-detail')){
	$('.header-menu>li>a[news]').addClass('active');
}

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
else if($('body>.header>.banner.offline-detail').hasClass('offline-detail')){
	$('.header-menu>li a[store]').addClass('active');
}
else if($('body>.header>.banner.offline').hasClass('offline')){
	$('.header-menu>li a[store]').addClass('active');
	$('a[store]').siblings('ul').find('li:last-child').children('a').css({
		'background': '#f3eded'
	});

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
			'<a href="'+$info.data('link')+'">'+trsLang('view_details')+'</a>';
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

	//去支付
	$(document).on('click', '.go-pay', function(event) {
		var orderId = $(this).data('id');
		api('post','/user/create-order',{
			orderId: orderId,
			userId: Cookies.get('userId')
		},function (res) {
			layer.msg(res.msg);
			if(!res.status){
				localStorage.orderId = res.data.orderNo;
				if(isNumber(res.data.id)){
					localStorage.removeItem('payDetail');
					localStorage.picId = res.data.id;
					//$('.user-container.orderdetail').html('<div class="zhifu"><img src="/image/get/'+res.data.id+'"><p>请用微信扫描二维码进行支付。</p></div>');
				}else{
					localStorage.removeItem('picId');
					localStorage.payDetail = res.data;
					//$('.user-container.orderdetail').html('<div class="zhifu">'+res.data+'</div>');
				}
				location.href  = Cookies.get('HOST') + '/' + getLang() + '/user/pay';
			}
		});
	});

}
else if($('body>.header>.banner.partner-detail').hasClass('partner-detail')){
	$('.header-menu>li a[strategy]').addClass('active');
	$('.img-con').slideimg({
		width: 1180,
		height: 420,
		ratio: 0.5,
		top: 0,
		containerWidth: 1180,
		autoTime: 5000
	});
}

else if($('body>.header>.banner.partner').hasClass('partner')){
	$('.header-menu>li a[strategy]').addClass('active');
	$('a[strategy]').siblings('ul').find('li:nth-child(3)').children('a').css({
		'background': '#f3eded'
	});

	//tab
	var partnerData = [];
	$(document).on('click', '.tab-partner>a', function(event) {
		$(this).addClass('active').siblings().removeClass('active');
		var index = $(this).index();
		var $list = $($('.list')[index]);
		$list.addClass('active').siblings('.active').removeClass('active');
		if(partnerData[index]){
			$list.html(creatPartner(partnerData[index]));
			return;
		}
		api('post','/partner/get-partner',{
			categoryId: $(this).data('id'),
			pageIndex: 1,
			pageSize: 100
		},function (res) {
			var html = '';
			if(!res.status){
				var data = res.data.partners;
				if(!data.length){
					layer.msg( trsLang('no_data') );
				}else{
					var name;
					partnerData[index] = data;
					$list.html(creatPartner(partnerData[index]));
				}
			}
		});
	});
}

else if($('.user-container.pay').hasClass('pay')){
	$('.user-container.pay').css('min-height', $(window).height()-$('.header.user').height()-$('.footer.user').height());
	if(localStorage.orderId&&localStorage.picId){
		$('.user-container.pay').append('<div class="wechat-pay"><h2>微信扫码支付</h2><img src="/image/get/'+localStorage.picId+'"><p class="tips"><span></span>后此二维码过期</p></div>');
	}else{
		$('.user-container.pay').append('<div class="zhifu">'+localStorage.payDetail+'</div>');
		if($('form[name="SendOrderForm"]')){
			$('form[name="SendOrderForm"]').submit();
		}
	}

	if($('.wechat-pay').hasClass('wechat-pay')){

		var times = Cookies.get('times') ||60;
		var orderNo = localStorage.orderId;
		//检测订单是否支付
		var testOrder = setInterval(function () {
			$.post('/'+getLang()+'/user/order-state',{
				orderNo: orderNo
			},function (res) {
				res = $.parseJSON(res);
				if(!res.status){
					//console.log(res);
					layer.msg(res.msg);
					_removeLocal();
					location.href = Cookies.get('HOST') + '/' + getLang() +'/user/orderdetail/'+res.data.id+'';
				}
			});
		},5000);

		var timeLeft = setInterval(function () {
			times -= 1;
			Cookies.set('times',times);
			if(times==1){
				_removeLocal();
				location.href = Cookies.get('HOST') + '/' + getLang() +'/user/order';
			}
			$('.tips>span').text(times+'s');
		},1000);

		setTimeout(function () {
			$.post('/'+getLang()+'/user/order-state',{
				orderNo: orderNo
			},function (res) {
				res = $.parseJSON(res);
				if(!res.status){
					layer.msg(res.msg);
					_removeLocal();
					location.href = Cookies.get('HOST') + '/' + getLang() +'/user/order';
				}
			});
			_removeLocal();
			window.clearInterval('testOrder');
			window.clearInterval('timeLeft');
			Cookies.remove('times');
			location.href = Cookies.get('HOST') + '/' + getLang() +'/user/orderdetail/'+res.data.id+'';
		},60000);
	}
	
}
// 汇率页面转外链，弃用此JS
// else if($('.container.rate').hasClass('rate')){
// 	$('.container.rate').height( $(window).height()-$('.car-header').height()-$('.footer.user').height() );
// 	$('body').css('background', '#fff');
	
// 	$('.exchange').on('click', function(event) {
// 		var rmb = $('input[name="rmb"]').val();
// 		var $country = $('select[name="country"]>option:selected');
// 		if(!rmb){
// 			layer.msg(trsLang('input_number'));
// 			return;
// 		}
// 		api('post','/index/get-rate',{
// 			number: $('input[name="rmb"]').val(),
// 			target: $('select[name="country"]>option:selected').val()
// 		},function (res) {
// 			if(!res.status){
// 				$('.dis').text(rmb+ trsLang('cny') +'='+res.data.number+$country.text());
// 			}
// 		});
// 	});
// }
else if($('.container').hasClass('search')){
	$('.header.user').css('background', '#fafafa');
	$('.header.user .header-btn>a').css('color', '#333333');
	$('.header.user .header-btn>i.car').addClass('black').css('margin', 0);

	$('.trs>a').css('color', '#333333');

	$('.search-tab>a').click(function(event) {
		var tag = $(this).data('tag');
		$(this).addClass('active').siblings('.active').removeClass('active');
		if(tag=='all'){
			$('.con').show();
			return;
		}
		$('.con.'+tag+'').show().siblings('.con').hide();
	});

	$('.search-btn').click(function(event) {
		searchPage();
	});

	$('.search-con>input').focus(function(event) {
		Mousetrap.bind('enter', searchPage, 'keydown');
	});
	$('.search-con>input').blur(function(event) {
		Mousetrap.unbind('enter');
	});
}
else if($('body>.header>.banner.store-detail').hasClass('store-detail')){
	var $input = $('.addcut>input');
	$('.header-menu>li a[store]').addClass('active');
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
	//选规格
	$(document).on('click', '.size>a', function(event) {
		$(this).addClass('active').siblings('a.active').removeClass('active');
	})
	//加
	.on('click', '.addcut>.add', function(event) {
		var val = $input.val();
		if(isNumber(val)){
			$input.val(parseInt(val)+1);
		}
	})
	//减
	.on('click', '.addcut>.cut', function(event) {
		var val = $input.val();
		if(isNumber(val)&&val>1){
			$input.val(parseInt(val)-1);
		}
	})
	//输
	.on('keyup', $input, function(event) {
		var val = $input.val();
		//console.log(isNumber(val));
		if(!isNumber(val)){
			$input.val(1);
		}
	});
}
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

else if($('body>.header>.banner.strategy-detail').hasClass('strategy-detail')){
	$('.header-menu>li a[strategy]').addClass('active');
	
}

//发布游记页面
else if($('.strategy-edit-con').hasClass('strategy-edit-con')){
	
	$('body').css('background', '#fff');

	var coverID = $('.add-cover').data('id') || 0;
	if($('.strategy-edit-con').data('id')){
		$('.add-cover').height(500);
		$('.img-box').show();
	}
	$('.strategy-input.title>span>span').text($('input[name=strategy-title]').val().length);
	$('.strategy-input.des>span>span').text($('input[name=strategy-des]').val().length);
	$('.country').siblings('.con').children('a[id="'+$('.selected.country').data('id')+'"]').addClass('active');
	$('.category').siblings('.con').children('a[id="'+$('.selected.category').data('id')+'"]').addClass('active');
	//展开国家版块
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

	var href = location.href;

	//上传封面
	$('#upcover')
	.bind('fileuploadsend', function (e, data) {
		var isSend = true;
		$.each(data.files, function(index, val) {
			//不能超过2M
			if(val.size>2000000){
				data.files.splice(index);
				layer.msg(trsLang('file')+' ['+val.name+'] '+trsLang('toobig')+'2M');
				isSend = false;
			}
			//只能是图片
			else if( !(/\.jpg$|\.jpeg$|\.gif$|\.png$/i.test(val.name)) ){
				layer.msg(trsLang('file')+' ['+val.name+'] '+trsLang('typenotcorrect'));
				isSend = false;
			} 
		});
		return isSend;
	})
	.fileupload({
	    url: '/'+getLang()+'/user/upload-file',
	    dataType: 'json',
	    done: function (e, data) {
	    	var res = data.result;
	    	layer.msg(res.msg);
	    	var imgID = res.data.imageId;
	    	$('.img-box').parents('.add-cover').height(500);
	    	$('.img-box').show().children('img').attr('src', '/image/get/'+imgID);
	    	coverID = imgID;
	    }
	});

	//发布游记和保存草稿
	$('.header-btn>a').click(function(event) {
		var strategyTitle = $('input[name=strategy-title]').val();
		var strategyCountryId = $('.country').attr('data-id');
		var strategyCategoryId = $('.category').attr('data-id');
		var strategyDes = $('input[name=strategy-des]').val();
		var strategyDetail = ue.getContent();
		var strategyTag = $('input[name=strategy-tag]').val();
		if(strategyTitle===''){
			layer.msg( trsLang('title_not_empty') );
			return;
		}
		else if(strategyCountryId===''){
			layer.msg( trsLang('select_country') );
			return;
		}
		else if(strategyCategoryId===''){
			layer.msg( trsLang('select_category') );
			return;
		}
		else if(strategyDes===''){
			layer.msg( trsLang('description_not_empty') );
			return;
		}
		else if(strategyTag===''){
			layer.msg( trsLang('add_tag') );
			return;
		}
		else if(!coverID){
			layer.msg( trsLang('add_cover') );
			return;
		}
		else if(strategyDetail===''){
			layer.msg( trsLang('content_not_empty') );
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
			picKey: coverID
		},function (res) {
			layer.msg(res.msg);
			if(!res.status){
				location.href = Cookies.get('HOST')+'/'+getLang()+'/strategy/detail/'+res.data.id;
			}
		});

	});
}
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
else if($('body>.content>div.container').hasClass('walkin')){
	$('.header-menu>li>a[walkin]').addClass('active');
	//异步
	var wcurrentPage = 1;
	$('.container.walkin').on('click', '.tab>a,.input>a,.loading-more', function(event) {
		var $partner = $('.partner-item');
		$partner.hide();
		if($(this)[0].nodeName=='A'){
			$(this).addClass('active').siblings('.active').removeClass('active');
			wcurrentPage = 1;
			//tab点击时清空搜索框
			if(!$(this).parent().hasClass('input')){
				$('.input>input').val('');
			}
			$('.list').html('');
		}
		else if($(this).hasClass('loading-more')){
			wcurrentPage += 1;
		}
		api('post','/walkin/get-line',{
			pageIndex: wcurrentPage,
			pageSize: 6,
			countryId: $('.tab.country>a.active').data('id'),
			keyword: $('.input>input').val(),
			categoryId: $('.tab.category>a.active').data('id')
		},function (res) {
			var html = '';
			if(!res.status){
				if(res.data.partner!==''){
					var partnerData = res.data.partner;
					$partner.children().remove();
					$partner.append('<h2>'+trsLang('releatived_partner')+'</h2>'+
						'<img src="/image/get/'+partnerData.picKey+'" style="width:450px;height:300px" alt="450x300">'+
					'<ul>'+
						'<li class="title">'+partnerData.name+'</li>'+
						'<li>'+partnerData.summary+'</li>'+
						'<li>'+trsLang('phone')+'：'+partnerData.telephone+'</li>'+
						'<li>'+trsLang('mobile')+'：'+partnerData.mobile+'</li>'+
						'<li>'+trsLang('tax')+'：'+partnerData.tax+'</li>'+
						'<li>'+trsLang('email')+'：'+partnerData.email+'</li>'+
						'<li>'+trsLang('address')+'：'+partnerData.address+'</li>'+
						'<li></li>'+
					'</ul>').show();
				}
				if(res.data.line.length===0){
					layer.msg( trsLang('no_data') );
					return;
				}
				$.each(res.data.line, function(index, val) {
					html +=
					'<li>'+
					'<a href="/'+getLang()+'/walkin/detail/'+val.id+'">'+
						'<img src="/image/get/'+val.picKey+'" style="width:320px;height:230px" alt="320x230">'+
						'<ul>'+
							'<li class="title">'+val.name+'</li>'+
							'<li class="content">'+val.summary+''+
							'</li>'+
							'<li class="info">'+
								'<i class="love"></i>'+
								'<span class="love-person">'+val.favoriteNum+'</span>'+
								'<i class="comment"></i>'+
								'<span class="comment-person">'+val.commentNum+'</span>'+
								'<span class="price">'+trsLang('consult_price')+'<span>'+val.feeStart+'-'+val.feeEnd+'</span>'+trsLang('percost')+'</span>'+
							'</li>'+
						'</ul>'+
					'</a>'+
					'</li>';
				});
			}
			$('.list').append(html);
		});
	});
	
	//class="mousetrap"

	//回车搜索
	$('.input>input').focus(function(event) {
		Mousetrap.bind('enter', _line_Search,'keydown');
	});
	$('.input>input').blur(function(event) {
		Mousetrap.unbind('enter');
	});
}
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
else if($('.container.weather').hasClass('weather')){
	var $li = $('.user-chose>ul>li');
	var $div = $('.user-chose>.active');
	var cityData = [];//存放获取到的数据

	$('.user-chose')
	//选项卡
	.on('click', 'ul>li', function(event) {
		var index = $(this).index();
		var countryId = $(this).data('id');
		$(this).addClass('active').siblings('.active').removeClass('active');

		if(cityData[index]){
			$div.html(cityData[index]);
			return;
		}

		api('post','/index/country-city',{
			countryId: countryId
		},function (res) {
			layer.msg(res.msg);
			if(!res.status){
				var html = '';
				$.each(res.data, function(index, val) {
					html += '<a href="/'+getLang()+'/index/weather/'+countryId+'/'+val.id+'">'+val.name+'</a>';
				});
				cityData[index] = html;
				$div.html(html);
			}
		});

	});
}
//这是JS收尾部分	
});