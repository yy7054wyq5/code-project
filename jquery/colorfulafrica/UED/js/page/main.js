/*公用设置*/
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