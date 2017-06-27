var api =  function (method,url,data,callback) {
	var isOut = false;
	var href = location.href;
	var country = getLang();
	loader.open();
	if(method=='get'){
		$.get('/'+country+url,data, function(res) {
			isOut = true;
			loader.close();
			callback(jQuery.parseJSON(res));
			//if(!res.status) console.log(res);
			//else layer.msg(res.msg);
		});
	}else{
		$.post('/'+country+url,data, function(res) {
			isOut = true;
			loader.close();
			callback(jQuery.parseJSON(res));
			//if(!res.status) console.log(res);
			//else layer.msg(res.msg);
		});
	}
	setTimeout(function (argument) {
		if(!isOut){
			layer.msg(trsLang('time_out'));
		}
		loader.close();
	},10000);
};

/**
 *发送验证码
 * @param  
 	 obj: 发送验证码的按钮
 	 mobile: 手机号
 	 tag: 0代表注册，1代表重置密码
 * @return 
 	暂时是把返回的验证码放到cookie内
 */
function getCaptcha(obj,mobile,tag) {
	if(obj.hasClass('wait')){
		layer.msg(trsLang('please_wait'));
		return;
	}
	api('post','/user/captcha',{
		mobile: mobile,
		tag: tag
	},function (res) {
		layer.msg(res.msg);
		if(!res.status){
			//Cookies.set('captcha',res.data.captcha);
			obj.text(trsLang('wait')+'60s').addClass('wait');
			var time = 60;
			var timeInt = setInterval(function () {
			    time = time -1;
			    obj.text(trsLang('wait')+time+'s');
			},1000);
			setTimeout(function  () {
			    window.clearInterval(timeInt);
			    obj.text(trsLang('resend')).removeClass('wait');
			},60000);
		}
	});
}

/**
 *去除item的右边距
 * @param  
 	 obj: 需要去除右边距的jquery对象集合
 	 num: 每行元素个数
 	 tag: 为1或者true，去除右边框。 	
 */
function cutRightMargin(obj,num,tag) {
	var hasborder = '';
	if(tag){
		hasborder = 0;
	}
	if(obj.length<num){
		return;
	}
	$.each(obj, function(index, val) {
		var cutRight = (index+1)%num;
		if(!cutRight) $(val).css({
			'margin-right': 0,
			'border-right': hasborder
		});
	});
}

/**
 *获取省市区
 * @param  
 	 tag: 0代表省，1代表市，2代表区
 	 id: 省ID，市ID
 	 obj: 数据装载的容器，目前默认都是select 
 */
var proData = 0;//省数据
function getcities(tag,id,obj) {
	if(proData&&tag===0){
		obj.html(proData);
		return;
	}
	api('post','/user/get-province-city',{
		tag: tag || 0,
		province: id || null
	},function (res) {
		if(!res.status){
			var temp = '';
			$.each(res.data, function(index, val) {
				temp += '<option id="'+val.id+'" value="'+val.id+'">'+val.name+'</option>';
			});
			obj.html('<option>'+trsLang('please_select')+'</option>'+temp);
			if(tag===0){
				proData = temp;
			}
		}
	});
}

 /**
  * 是否登录
  * @param 
  * @return boolean
  */
function isLogin() {
	var hasLogin = false;
	if(Cookies.get('islogin')){
		hasLogin = true;
	}
	return hasLogin;
}

 /**
  * 首页游记模块--换一换
  * @param ajax response
  * @return HTML
  */
function createHTML(data) {
	var tmp = '';
	if(data.resourcesType==1) tmp = '<i class="contact"></i><span>'+trsLang('partner')+'</span>';//合作伙伴	
	else if(data.resourcesType==2) tmp = '<i class="travel-notes"></i><span>'+trsLang('travel')+'</span>';//游记
	else if(data.resourcesType==3) tmp = '<i class="food"></i><span>'+trsLang('food')+'</span>';//美食
	var straHTML = 
		'<div class="strategy-item" data-id="'+data.resourcesId+'">'+
			'<a href="'+data.url+data.resourcesId+'"><img src="/image/get/'+data.picKey+'"></a>'+
			'<div class="icon">'+tmp+'</div>'+
			'<div class="info">'+
				'<h3><a href="'+data.url+data.resourcesId+'">'+data.name+'</a></h3>'+
				'<span class="classic">'+data.cate+'</span>'+
				'<span class="looks">'+data.looks+trsLang('person_view')+'</span>'+
			'</div>'+
		'</div>';	
	return straHTML;
}

/**
 * 页面ajax
 * @param {option} , function callback()
 * @return 
 */
function pageAjax(option,callback) {
	var countryId = option.countryId;
	var cateId = option.cateId;
	var currentPage = option.currentPage;
	var totalPage = option.totalPage;
	var pageSize = option.pageSize;
	var keyword = option.keyword;
	var url = option.url;
	//点击加载更多的时候才传当前页
	currentPage = currentPage + 1;
	//其余请求中currentPage未undefined，所以会成NaN值

	//页码超出不做请求
	if(currentPage>totalPage&&!keyword){
		layer.msg( trsLang('no_data') );
		return;
	}

	api('post',url,{
		pageIndex: currentPage || 1,//点击tab和搜索不传当前页
		pageSize: pageSize,
		countryId: countryId,
		keyword: keyword,
		categoryId: cateId
	},function (res) {
		callback(res);
	});
}

 /**
  * 新闻首页ajax
  * @param {option} 
  * @return 
  */
function getNews(option) {
	pageAjax(option,function (res) {
		var clickObj = option.clickObj;
		var index = clickObj.index();
		var $tabCon = $($('.tab-con')[index]);
		var keyword = option.keyword;
		var rhtml = '';
		var nhtml = '';
		if(!res.status){
			//点选项卡和翻页都会重新给按钮上的页码和总页数重新赋值
			clickObj.data('currentpage', res.data.pageInfo.pageIndex);
			clickObj.data('totalpage', res.data.pageInfo.page);
			if(res.data.news.length===0){
				if(keyword!==undefined){
					layer.msg(trsLang('no_search_content'));
					$tabCon.html('');
					return;
				}
				layer.msg( trsLang('no_data') );
				return;
			}
			if(keyword!==undefined){
				$tabCon.html('');
			}
			$.each(res.data.recommend, function(index, val) {
				rhtml += '<li>'+
							'<img src="/image/get/'+val.picKey+'">'+
							'<h3><a href="/'+getLang()+'/news/detail/'+val.id+'">'+val.name+'</a></h3>'+
							'<span>'+val.createTime+'</span>'+
						   '</li>';
			});
			$.each(res.data.news, function(index, val) {
				nhtml += '<li>'+
							'<img src="/image/get/'+val.picKey+'">'+
							'<div>'+
								'<h4>'+
									'<span class="title"><a href="/'+getLang()+'/news/detail/'+val.id+'">'+val.name+'</a></span>'+
									'<span class="date">'+val.createTime+'</span>'+
								'</h4>'+
								'<p>'+val.summary+'</p>'+
							'</div>'+
						'</li>';
			});
			if($tabCon.find('.recommend').hasClass('recommend')){
				$tabCon.children('.common').append(nhtml);
			}
			else{
				$tabCon.append('<ul class="recommend">'+rhtml+'</ul><div class="clear"></div><ul class="common">'+nhtml+'</ul>');
			}
			cutRightMargin($tabCon.children('ul.recommend').children('li'),4);
		}	
	});
}


/**
* 游记首页ajax
* @param {option} 
* @return 
*/
function getStrategy(option) {
	var href = location.href;
	pageAjax(option,function (res) {
		var clickObj = option.clickObj;
		var index = clickObj.data('id');
		var $tabCon = $('.tab-con[data-id="'+index+'"]');
		var keyword = option.keyword;
		var id = option.countryId;
		var html = '';
		if(!res.status){
			//点选项卡和翻页都会重新给按钮上的页码和总页数重新赋值
			clickObj.data('currentpage', res.data.pageInfo.pageIndex);
			clickObj.data('totalpage', res.data.pageInfo.page);
			if(res.data.strategy.length===0){
				if(keyword!==undefined){
					layer.msg(trsLang('no_search_content'));
					$tabCon.html('');
					return;
				}
				layer.msg( trsLang('no_data') );
				return;
			}
			if(keyword!==undefined){
				$tabCon.html('');
			}
			$.each(res.data.strategy, function(index, val) {
				html += 
				'<li>'+
					'<a class="img-link" href="/'+getLang()+'/strategy/detail/'+val.id+'"><img src="/image/get/'+val.picKey+'"></a>'+
					'<ul>'+
						'<li class="strategy-info">'+
							'<img class="user-img" src="/image/get/'+val.userIcon+'">'+
							'<span class="user-name">'+val.nickname+'</span>'+
							'<span class="user-place">'+trsLang('on')+'<span>'+$('.tab>a[data-id="'+id+'"]').text()+'</span>'+trsLang('submited_strategy')+'</span>'+
							'<span class="user-comment"><strong>'+val.commentNum+'</strong>'+trsLang('person_comment')+'</span>'+
							'<i class="comment"></i>'+
							'<span class="user-collect"><strong>'+val.favoriteNum+'</strong>'+trsLang('person_collected')+'</span>'+
							'<i class="love"></i>'+
						'</li>'+
						'<li class="strategy-title" ><a href="/'+getLang()+'/strategy/detail/'+val.id+'">'+val.name+'</a></li>'+
						'<li class="strategy-con">'+val.summary+'</li>'+
					'</ul>'+
				'</li>';
			});
			$tabCon.append(html);
			cutRightMargin($tabCon.children('ul.recommend').children('li'),4);
		}	
	});
}

/**
* 获取当前语言
* @param 
* @return string
*/
function getLang() {
	var lang = location.href.split('/')[3];
	if(lang===''||!lang||lang=='zh'){
		lang = 'cn';
	}
	return lang.toLowerCase();
}

/**
* 存本地词典
* @param 
* @return string
*/
function storageLang(lang,callback) {
	if(localStorage[lang]){
		// console.log(lang+'语言包已下载');
		return;
	}
	$.post('/'+lang+'/index/get-language', function(data, textStatus, xhr) {
		data = $.parseJSON(data);
		if(!data.status) {
			localStorage[lang] = JSON.stringify(data.data);
			if(callback){
				callback();
			}
		}
	});
}

/**
* 转换词语
* @param string
* @return string
*/
function trsLang(key) {
	var words = {};
	if(!localStorage[getLang()]){
		$.post('/'+getLang()+'/index/get-language', function(data, textStatus, xhr) {
			data = $.parseJSON(data);
			if(!data.status) localStorage[getLang()] = JSON.stringify(data.data);
		});
	}else{
		words = $.parseJSON(localStorage[getLang()]);
	}
	return words[key] || false;
}

/**
* 生成合作伙伴DOM
* @param data
* @return html
*/
function creatPartner(data) {
	var html = '';
	$.each(data, function(index, val) {
		if(getLang()=='cn'){
			name = val.name;
		}else{
			name = val.nameEn;
		}
		if(index%2===0){
			html += 
				'<li>'+
					'<img src="/image/get/'+val.picKey+'" class="pull-left">'+
					'<div class="info pull-left">'+
						'<h2>'+name+'</h2>'+
						'<a href="/'+getLang()+'/partner/detail/'+val.id+'">查看详情</a>'+
					'</div>'+
				'</li>';
		}else{
			html += 
				'<li>'+
					'<div class="info pull-left">'+
						'<h2>'+name+'</h2>'+
						'<a href="/'+getLang()+'/partner/detail/'+val.id+'">查看详情</a>'+
					'</div>'+
					'<img src="/image/get/'+val.picKey+'" class="pull-left">'+
				'</li>';
		}
	});
	return html;
}

/**
* 判断是否全是数字
* @param number
* @return boolean
*/
function isNumber(num) {
	var bool = true;
	if(!/^\d+$/.test(num)){
		bool = false;
	}else if(isNaN(parseInt(num))){
		bool = false;
	}
	return bool;
}

/**
* 注册密码判断
* @param jquery object
* @return boolean
*/
function testPass(obj) {
	var val = obj.val();
	var bool = true;
	if(val.length>16||val.length<8){
		layer.msg(trsLang('enter_password'));
		obj.val(val.substring(0,16));
		bool = false;
	}else if(/^[A-Za-z]+$/.test(val)){//没有数字
		layer.msg(trsLang('add_number_in_passwords'));
		obj.val('');
		bool = false;
	}else if(!isNaN( parseInt(val) )){//没有汉字
		layer.msg(trsLang('add_letters_in_passwords'));
		obj.val('');
		bool = false;
	}
	return bool;
}

/**
* 新闻搜索
* @param 
* @return 
*/
function _news_Search() {
	var $activeLi = $('ul.tab>li.active');
	var keyword = $('.input>input').val();
	if(!keyword){
		layer.msg( trsLang('no_keywords') );
		return;
	}
	getNews({
		countryId: $activeLi.data('id'),
		clickObj: $activeLi,
		pageSize: 6,
		keyword: keyword,
		url: '/news/get-news'
	});
}

/**
* 游记搜索
* @param 
* @return 
*/
function _strategy_Search() {
	var $activeA = $('.tab>a.active');
	var keyword = $('.input>input').val();
	if(!keyword){
		layer.msg( trsLang('no_keywords') );
		return;
	}
	getStrategy({
		countryId: $activeA.data('id'),
		clickObj: $activeA,
		pageSize: 6,
		cateId: $('.cateName').data('id'),
		keyword: keyword,
		url: '/strategy/get-strategy'
	});
}

/**
* 美食搜索
* @param 
* @return 
*/
function _food_Search() {
	var keyword = $('.input>input').val();
	$('.list').html('');
	if(!keyword){
		layer.msg( trsLang('no_keywords') );
		return;
	}
	api('post','/food/get-food',{
		pageIndex: 1,
		pageSize: 6,
		countryId: $('.tab.country>a.active').data('id'),
		keyword: keyword,
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
}

/**
* 线路搜索
* @param 
* @return 
*/
function _line_Search() {
	var keyword = $('.input>input').val();
	if(!keyword){
		layer.msg( trsLang('no_keywords') );
		return;
	}
	api('post','/walkin/get-line',{
		pageIndex: 1,
		pageSize: 6,
		countryId: $('.tab.country>a.active').data('id'),
		keyword: keyword,
		categoryId: $('.tab.category>a.active').data('id')
	},function (res) {
		var html = '';
		if(!res.status){
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
}

/**
* 商品搜索
* @param 
* @return 
*/
function _store_Search() {
	var $a = $('a.search-btn');
	if($a.data('pageindex')==1){
		$('.normal').html('');
		$('.recommend').html('');
	}
	api('post','/store/get-goods',{
		pageIndex: $a.data('pageindex'),
		pageSize: 6,
		keyword: $('.input>input').val()
	},function (res) {
		var rhtml = '';
		var nhtml = '';
		if(!res.status){
			if(res.data.goods.length===0){
				layer.msg( trsLang('no_data') );
				return;
			}
			$.each(res.data.recommend, function(index, val) {
				var trs = '';
				//奇数
				if(index%2){
					trs = 
						'<li>'+
							'<ul class="pull-left">'+
								'<li class="title"><a href="/'+getLang()+'/store/detail/'+val.id+'">'+val.name+'</a></li>'+
								'<li class="content">'+val.summary+'</li>'+
								'<li class="price">&yen;<span>'+val.price+'</span></li>'+
								'<li><a data-id="'+val.id+'" class="addcar">'+trsLang('add_to_shoppingcar')+'</a></li>'+
							'</ul>'+
							'<a class="img-link pull-right" href="/'+getLang()+'/store/detail/'+val.id+'"><img src="/image/get/'+val.picKey+'"></a>'+
						'</li>';
				}
				else{
					trs = 
						'<li>'+
							'<a class="img-link pull-left" href="/'+getLang()+'/store/detail/'+val.id+'"><img src="/image/get/'+val.picKey+'"></a>'+
							'<ul class="pull-right">'+
								'<li class="title"><a href="/'+getLang()+'/store/detail/'+val.id+'">'+val.name+'</a></li>'+
								'<li class="content">'+val.summary+'</li>'+
								'<li class="price">&yen;<span>'+val.price+'</span></li>'+
								'<li><a data-id="'+val.id+'" class="addcar">'+trsLang('add_to_shoppingcar')+'</a></li>'+
							'</ul>'+
						'</li>';
				}
				rhtml += trs;
					
			});
			$.each(res.data.goods, function(index, val) {
				nhtml +=
					'<li>'+
						'<div class="price">'+
							'<div>&yen;</div>'+
							'<div class="num">'+val.price+'</div>'+
						'</div>'+
						'<a class="img-link" href="/'+getLang()+'/store/detail/'+val.id+'"><img src="/image/get/'+val.picKey+'"></a>'+
						'<div class="info">'+
							'<span><a href="/'+getLang()+'/store/detail/'+val.id+'">'+val.name+'</a></span>'+
							'<a data-id="'+val.id+'" class="addcar">'+trsLang('add_to_shoppingcar')+'</a>'+
						'</div>'+
					'</li>';
			});
		}
		$('.recommend').html(rhtml);
		$('.normal').append(nhtml);
		cutRightMargin($('ul.normal>li'),3);
	});
}

/**
* 我的游记
* @param tag 游记类型  currentpage 当前页
* @return 
*/
function getStrategyList(tag,currentpage) {
	var $activeA = $('.user-tab>a[data-tag="'+tag+'"]');
	var $list = $('.list[data-tag="'+tag+'"]');
	
	$('.no-product').hide();
	$('.loading-more').show();

	api('post','/user/receive-strategy',{
		userId: Cookies.get('userId'),
		type: tag,
		pageIndex: currentpage,
		pageCont: 6
	},function (res) {
		if(!res.status){
			var strategyHTML = '';

			//将页码放到A标签上
			$activeA.data('currentpage',res.data.pageInfo.pageIndex);
			$activeA.data('totalpage',res.data.pageInfo.page);

			if(res.data.result.length===0&&!$list.html()){
				layer.msg( trsLang('no_data') );
				$('.no-product').show();
				$('.loading-more').hide();
				return;
			}else if(res.data.result.length===0&&$list.html()){
				layer.msg( trsLang('no_data') );
				return;
			}

			if(tag===0){//我发布的游记
				$.each(res.data.result, function(index, val) {
					strategyHTML += 
					'<li>'+
						'<i class="circle"></i>'+
						'<div class="date">'+trsLang('published_in')+val.createTime+'</div>'+
						'<div class="line">'+
							'<div class="list-btn">'+
								'<i class="write"></i>'+
								'<a href="/'+getLang()+'/strategy/create-strategy/'+val.id+'">	</a>'+
								'<i class="delete"></i>'+
								'<a data-id="'+val.id+'" class="deleteBtn">'+trsLang('delete')+'</a>'+
							'</div>'+
							'<a href="/'+getLang()+'/strategy/detail/'+val.id+'" title="">'+val.name+'</a>'+
							'<hr>'+
						'</div>'+
					'</li>';
				});
			}else if(tag==1){//我评论的游记
				$.each(res.data.result, function(index, val) {
					strategyHTML += 
					'<li>'+
						'<i class="circle"></i>'+
						'<div class="date">'+trsLang('I_at')+val.createTime+trsLang('commented_strategy')+'<a href="/'+getLang()+'/strategy/detail/'+val.id+'">'+val.name+'</a></div>'+
						'<div class="line">'+
							'<a href="/'+getLang()+'/strategy/detail/'+val.id+'">'+val.content+'</a>'+
							'<hr>'+
						'</div>'+
					'</li>';
				});
			}else if(tag==2){//我收藏的游记
				$.each(res.data.result, function(index, val) {
					strategyHTML += 
					'<li>'+
						'<i class="circle"></i>'+
						'<div class="date">'+trsLang('I_at')+val.createTime+trsLang('collected_this_strategy')+'</div>'+
						'<div class="line">'+
							'<div class="list-btn">'+
								'<i class="star"></i>'+
								'<a data-id="'+val.id+'">'+trsLang('cancel_collect')+'</a>'+
							'</div>'+
							'<a href="/'+getLang()+'/strategy/detail/'+val.id+'">'+val.name+'</a>'+
							'<hr>'+
						'</div>'+
					'</li>';
				});
			}else if(tag==3){//草稿箱
				$.each(res.data.result, function(index, val) {
					strategyHTML += 
					'<li>'+
						'<i class="circle"></i>'+
						'<div class="date">'+trsLang('save_time')+val.createTime+'</div>'+
						'<div class="line">'+
							'<div class="list-btn">'+
								'<i class="delete"></i>'+
								'<a data-id="'+val.id+'" class="deleteBtn">'+trsLang('delete')+'</a>'+
							'</div>'+
							'<a href="/'+getLang()+'/strategy/create-strategy/'+val.id+'">'+val.name+'</a>'+
							'<hr>'+
						'</div>'+
					'</li>';
				});
			}
			if($list.html()){
				$list.append(strategyHTML);
			}else{
				$list.html(strategyHTML);
			}
		}
	});
}

/**
* 我的美食
* @param tag 美食类型  currentpage 当前页
* @return 
*/
function getFoodList(tag,currentpage) {
	var $activeA = $('.user-tab>a[data-tag="'+tag+'"]');
	var $list = $('.list[data-tag="'+tag+'"]');
	
	$('.no-product').hide();
	$('.loading-more').show();

	api('post','/user/food',{
		userId: Cookies.get('userId'),
		type: tag,
		pageIndex: currentpage,
		pageCont: 6
	},function (res) {
		//layer.msg(res.msg);
		if(!res.status){

			//将页码放到A标签上
			$activeA.data('currentpage',res.data.pageInfo.pageIndex);
			$activeA.data('totalpage',res.data.pageInfo.page);

			if(res.data.food.length===0&&!$list.html()){
				layer.msg( trsLang('no_data') );
				$('.no-product').show();
				$('.loading-more').hide();
				return;
			}else if(res.data.food.length===0&&$list.html()){
				layer.msg( trsLang('no_data') );
				return;
			}

			var foodHTML = '';
			if(tag===0){
				$.each(res.data.food, function(index, val) {
					foodHTML += 
					'<li>'+
						'<i class="circle"></i>'+
						'<div class="date">'+trsLang('i_comment_food')+'<a href="/'+getLang()+'/food/detail/'+val.id+'">'+val.name+'</a><span>'+val.createTime+'</span></div>'+
						'<div class="line">'+
							'<div class="content">'+
								'<img src="/image/get/'+val.picKey+'">'+
								'<div class="txt">'+val.content+'</div>'+
							'</div>'+
							'<hr>'+
						'</div>'+
					'</li>';
				});
			}
			else if(tag==1){
				$.each(res.data.food, function(index, val) {
					foodHTML += 
					'<li>'+
						'<i class="circle"></i>'+
						'<div class="date">'+trsLang('i_favorite_food')+'<span>'+val.createTime+'</span></div>'+
						'<div class="line">'+
							'<div class="list-btn" style="top:30px;">'+
								'<i class="zan"></i>'+
								'<a data-id="'+val.id+'">'+trsLang('cancel_favorite')+'</a>'+
							'</div>'+
							'<div class="content">'+
								'<img src="/image/get/'+val.picKey+'">'+
								'<div class="txt nobg">'+
									'<a href="/'+getLang()+'/foo/detail/'+val.id+'">'+val.name+'</a>'+
								'</div>'+
							'</div>'+
							'<hr>'+
						'</div>'+
					'</li>';
				});
			}
			if($list.html()){
				$list.append(foodHTML);
			}else{
				$list.html(foodHTML);
			}
		}
	});
}

/**
* 我的订单
* @param tag 订单类型  currentpage 当前页
* @return 
*/
function getOrderList(tag,currentpage) {
	var $activeA = $('.user-tab>a[data-tag="'+tag+'"]');
	var $list = $('.list[data-tag="'+tag+'"]');

	api('post','/user/orderlist',{
		type: tag,
		pageIndex: currentpage,
		pageCount: 6
	},function (res) {
		
		if(!res.status){
			var nopay = res.data.num.noPay;
			var payerd = res.data.num.payed;
			var shiped = res.data.num.shiped;

			$('.user-tab>a[data-id="1"]').find('span').text(nopay);
			$('.user-tab>a[data-id="2"]').find('span').text(payerd);
			$('.user-tab>a[data-id="3"]').find('span').text(shiped);

			var html = '';
			var payStatus = '';
			var payBtn = '';

			// console.log('当前页：'+res.data.pageInfo.pageIndex);
			// console.log('总页数：'+res.data.pageInfo.page);
			//将页码放到A标签上
			$activeA.data('currentpage',res.data.pageInfo.pageIndex);
			$activeA.data('totalpage',res.data.pageInfo.page);

			if(res.data.order.length===0&&!$list.html()){
				layer.msg( trsLang('no_data') );
				$('.no-product').show();
				$('.loading-more').hide();
				return;
			}else if(res.data.order.length===0&&$list.html()){
				layer.msg( trsLang('no_data') );
				return;
			}

			$.each(res.data.order, function(index, val) {
				if(val.payState==1){//未支付
					payStatus = '<a class="pay" href="/'+getLang()+'/user/orderdetail/'+val.id+'">'+trsLang('no_pay')+'</a>';
					payBtn = '<li><a class="go-pay">'+trsLang('go_pay')+'</a></li>';
				}else if(val.payState==2){//已支付
					payStatus = '<a class="pay">'+trsLang('payed')+'</a>';
					payBtn = '<li></li>';
				}else if(val.payState==3){//已发货
					payStatus = '<a class="pay">'+trsLang('shipped')+'</a>';
					payBtn = '<li><a class="receive-good">'+trsLang('confirm_receive_good')+'</a></li>';
				}else if(val.payState==4){//已完成
					payStatus = '<a class="pay">'+trsLang('finished')+'</a>';
					payBtn = '<li><a class="go-comment" href="/'+getLang()+'/user/commentorder/'+val.id+'">'+trsLang('go_comment')+'</a></li>';
				}
				if(!val.orderdetail.spec){
					val.orderdetail.spec = '';
				}
				html += '<li data-orderid="'+val.id+'">'+
							'<div class="info">'+
								'<span>'+val.createTime+'</span>'+
								'<span class="order-number"><a href="/'+getLang()+'/user/orderdetail/'+val.id+'">'+trsLang('orderNo')+'：'+val.orderNo+'</a></span>'+
								payStatus+
							'</div>'+
							'<div class="order-content">'+
								'<a href="/'+getLang()+'/user/orderdetail/'+val.id+'" class="img-link"><img src="/image/get/'+val.orderdetail.picKey+'"></a>'+
								'<ul>'+
									'<li class="title">'+val.orderdetail.name+'</li>'+
									'<li>'+val.orderdetail.spec+'</li>'+
									'<li>x'+val.orderdetail.number+'</li>'+
								'</ul>'+
								'<ul class="price-btn">'+ payBtn +
									'<li>&yen;<span>'+val.price+'</span></span>'+
								'</ul>'+
							'</div>'+
						'</li>';
			});
			if($list.html()){
				$list.append(html);
			}else{
				$list.html(html);
			}
			$list.addClass('active').siblings('.active').removeClass('active');
		}
		
	});
}

/**
* 首页搜索
* @param
* @return 
*/
function indexSearch() {
	var keyword = $('.input-con>input').val();
	if(keyword===''){
		layer.msg( trsLang('no_keywords') );
		return;
	}
	location.href = Cookies.get('HOST')+ '/' + getLang() + '/index/search/'+ keyword;
}

/**
* 订单处理后
* @param
* @return 
*/
function _removeLocal() {
	localStorage.removeItem('orderId');
	localStorage.removeItem('payDetail');
	localStorage.removeItem('picId');
	Cookies.remove('times');
}

/**
* 搜索页
* @param
* @return 
*/
function searchPage() {
	location.href = Cookies.get('HOST')+ '/' + getLang() + '/index/search/'+ $('.search-con>input').val()+'/tag/'+$('.search-tab>a.active').data('id');
}

/**
* 获取最小高度
* @param 需要获取高度的jquery对象，不在同级的另外的元素
* @return number
*/
function getMinHeight($obj,$parentSib) {
	var _window_Height = $(window).height();
	var _other_Height = 0;
	$.each($obj.siblings(), function(index, val) {
		var _item_Height = toNumber($(val).height()) + toNumber($(val).css('margin-top')) + toNumber($(val).css('padding-top')) + toNumber($(val).css('padding-bottom'));
		 _other_Height +=  _item_Height;
	});
	$.each($parentSib, function(index, val) {
		_other_Height += toNumber($(val).height()) + toNumber($(val).css('margin-top')) + toNumber($(val).css('padding-top')) + toNumber($(val).css('padding-bottom'));
	});
	return _window_Height - _other_Height - toNumber($obj.parent().css('padding-top'));
}

/**
* 获取CSS样式的数值
* @param 100px
* @return 100
*/
function toNumber(cssVal) {
	var tmp = cssVal.toString();
	if(tmp.indexOf('px')>0){
		tmp = tmp.substring(0,tmp.length-2);
	}
	return parseInt(tmp);
}
$(function() {
	//删除
	function deleteProduct(obj,id) {
		layer.modal({
			tag: 'tips',
			title: trsLang('tips'),
			msg: trsLang('is_delete')
		},function (res) {
			if(res){
				api('post','/user/remove-car',{
					goodIds: id
				},function (res) {
					if(!res.status){
						if(obj.length>1){
							$.each(obj, function(index, val) {
								$(val).remove();
							});
						}
						obj.remove();
						carTotal();
					}
				});
			}
		});
	}
	//算产品总价
	function getProductTotal($li) {
		var product_price = parseFloat($li.find('.product-perprice>span').text()).toFixed(2);
		var product_num = $li.find('input[name="num"]').val();
		var product_total = parseFloat(product_price*product_num);
		$li.find('.product-total>span').text(product_total.toFixed(2));
	}
	//合计
	function carTotal() {
		var $activeLi = $('ul.car-list>li.active');
		var $Li = $('ul.car-list>li');
		var carPrice = 0;
		var noproduct = '<div class="noproduct">'+trsLang('car_empty')+'<a href="/store">'+trsLang('go_shopping')+'</a></div>';
		$('.car-num').text($activeLi.length);
		$.each($activeLi, function(index, val) {
			var product_price = parseFloat($(val).find('.product-perprice>span').text()).toFixed(2);
			var product_num = $(val).find('input[name="num"]').val();
			var product_total = parseFloat(product_price*product_num);
			$(this).find('.product-total>span').text(product_total.toFixed(2));
			carPrice += product_total;
		});
		$('.car-price>span').text(carPrice.toFixed(2));
		if($activeLi.length!==$Li.length||$Li.length===0) {
			$('.chose-all').prop('checked', false);
			if($Li.length===0){
				if($('.noproduct').hasClass('noproduct')){
					return;
				}
				$('.car-list').after(noproduct);
				$('.noproduct').show();
			}
			return;
		}
		$('.chose-all').prop('checked', true);
	}
	if($('.container').hasClass('car')){
		$('body').css('background', '#fff');
		var thisNum = 0;//记录单个产品的数量
		var thisID = 0;//当前产品ID
		var minHeight = $(window).height()-$('.car-header').height()-$('.footer.user').height();
		var userId = Cookies.get('userId');
		if($('.container.car').height()<minHeight){
			$('.container.car').height(minHeight);
		}
		//选中一条
		$('.container.car')
		.on('click', 'td.product', function(event) {
			$(this).parents('li').toggleClass('active');	
			carTotal();
		})
		//加
		.on('click', 'span.add', function(event) {
			var $input = $(this).siblings('input');
			$input.val(parseInt($input.val())+1);
			getProductTotal($(this).parents('li'));
			carTotal();
		})
		//减
		.on('click', 'span.cut', function(event) {
			var $input = $(this).siblings('input');
			if($input.val()<2){
				layer.msg(trsLang('not_less')+'1');
				return;
			}
			$input.val(parseInt($input.val())-1);
			getProductTotal($(this).parents('li'));
			carTotal();
		})
		//输入框
		.on('keyup', 'input[name="num"]', function(event) {
			var val = $(this).val();
			if(isNaN(parseInt(val))){
				$(this).val(1);
				return;
			}
			$(this).val(parseInt(val));
			getProductTotal($(this).parents('li'));
			carTotal();
		})
		//删除一条
		.on('click', 'li i.delete', function(event) {
			deleteProduct($(this).parents('li'),$(this).data('id'));
			carTotal();
		})
		//全选
		.on('click', '.chose-all', function(event) {
			$('ul.car-list>li').toggleClass('active');
			carTotal();
		})
		//底部删除
		.on('click', '.bottom-btn .delete', function(event) {
			$activeLi = $('ul.car-list>li.active');
			var goodIds = '';
			$.each($activeLi, function(index, val) {	
				goodIds += $(val).find('i.delete').data('id') + ',';
			});
			if($activeLi.length>0){
				deleteProduct($('ul.car-list>li.active'),goodIds);
			}
		})
		.on('mouseenter', '.car-list>li', function(event) {
			thisNum = $(this).find('input').val();
			thisID = $(this).data('id');
		})
		//更新数量
		.on('mouseleave', '.car-list>li', function(event) {
			var num = $(this).find('input').val();
			var id = $(this).data('id');
			if(num!==thisNum&&id==thisID){
				thisNum = 0;
				api('post','/user/car-number',{
					id: id,
					number: num
				},function (res) {
					if(res.status){
						layer.msg(res.msg);
					}
				});
			}
		})
		//跳转确认订单页
		.on('click', '.confirm', function(event) {
			if($('.loading').hasClass('loading')) return;
			var cartId = '';
			var $activeLi = $('.car-list>li.active');
			if(!$activeLi.length){
				layer.msg(trsLang('please_select_good'));
				return;
			}
			$.each($activeLi,function(index, el) {
				cartId += $(el).data('id')+',';
			});
			location.href = Cookies.get('HOST') +'/'+ getLang() +'/user/confirm-order/'+cartId.substring(0,cartId.length-1);
		});
	}
});

$(function() {
	//隐藏多余的收货地址
	function hideMoreAddress() {
		var  $address = $('.address-box>.item');
		if($address.length>7){
			$.each($address, function(index, val) {
				if(2<index&&index<$address.length-1){
					$(val).hide();
				}
			});
			return;
		}
		$('.slideup').children().hide();
	}
	if($('.container').hasClass('confirm')){
		$('body').css('background', '#fff');
		cutRightMargin($('.address-box>.item'),3);
		hideMoreAddress();
		//绑定事件
		$('.container.confirm')
		//展开收起地址列表
		.on('click', '.slideup>a', function(event) {
			var  $address = $('.address-box>.item');
			if($(this).hasClass('active')){
				$(this).toggleClass('active').children('span').text(trsLang('hold_up'));
				$address.show();
			}
			else{
				$(this).toggleClass('active').children('span').text(trsLang('open'));
				hideMoreAddress();
			}
		})
		//新增地址
		.on('click', '.add-address', function(event) {
			layer.modal({
				tag: 'address',
				title: trsLang('add_address')
			});
		})
		//编辑地址
		.on('click', '.address-box>.item .edit', function(event) {
			layer.modal({
				tag: 'address',
				title: trsLang('edit_address'),
				data: $(this).parents('.item').data('object')
			});
		})
		//选中地址
		.on('click', '.address-box>.item', function(event) {
			$(this).addClass('active').siblings('.active').removeClass('active');
		})
		//选中支付方式
		.on('click', '.pay-way>a', function(event) {
			$(this).addClass('active').siblings('.active').removeClass('active');
		})
		//提交订单
		.on('click', '.confirm-order-btn', function(event) {
			var href = location.href;
			var trs = href.split('/');
			var cartId = '';
			$.each($('.list>li[data-id]'),function(index, el) {
				cartId += $(el).data('id')+',';
			});
			var address_id = $('.address-box>.item.active').data('id');
			if(!address_id){
				layer.msg(trsLang('select_address'));
				return;
			}else if(cartId===''){
				layer.msg(trsLang('order_submitted'));
				return;
			}
			//console.log(cartId.substring(0,cartId.length-1));
			api('post','/user/create-order',{
				userId: Cookies.get('userId'),
				payment: $('.pay-way>a.active').data('id'),
				addressId: $('.address-box>.item.active').data('id'),
				notice: $('textarea[name="notice"]').val(),
				orderInfo: cartId.substring(0,cartId.length-1)
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
		//设为默认地址在main.js中已有

		//新增地址和编辑地址
		$(document).on('click', '.address-btn', function(event) {
			var name = $('.lz-modal').find('input[name="name"]').val();
			var provinceId = $('.lz-modal select.pro').find('option:selected').val();
			var cityId = $('.lz-modal select.city').find('option:selected').val();
			var districtId = $('.lz-modal select.area').find('option:selected').val();
			var detail = $('.lz-modal').find('input[name="address"]').val();
			var mobile = $('.lz-modal').find('input[name="mobile"]').val();
			var postCode = $('.lz-modal').find('input[name="postcode"]').val();
			if(name==trsLang('enter_consignee_name')){
				layer.msg(trsLang('please_enter_consignee_name'));
				return;
			}
			else if(cityId==trsLang('first_chose_pro')||cityId===''){
				layer.msg(trsLang('chose_pro'));
				return;
			}
			else if(districtId==trsLang('first_chose_city')||districtId===''){
				layer.msg(trsLang('chose_city'));
				return;
			}else if(detail===''){
				layer.msg(trsLang('enter_detail_address'));
				return;
			}else if(mobile==trsLang('enter_consignee_phonenumber')||mobile===''){
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
				provinceName: $('.lz-modal select.pro').find('option[value="'+provinceId+'"]').text(),
				cityId: cityId,
				cityName: $('.lz-modal select.city').find('option[value="'+cityId+'"]').text(),
				districtId: districtId,
				districtName: $('.lz-modal select.area').find('option[value="'+districtId+'"]').text(),
				detail: detail,
				mobile: mobile,
				postcode: postCode
			},function (res) {
				layer.msg(res.msg);
				if(!res.status){
					location.reload();
				}
			});
		})
		//编辑地址，点击省
		.on('click', 'select.pro', function(event) {
			if($(this).parents('table').data('id')&&$(this).children().length==1){
				getcities(0,null,$('select.pro'));//获取省
			}
		});
	}
});

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
var resetPassUserId = null;
var layer = {
	/**
	 * 模态框定位
	 * @method 
	 	例子：
	 	layer.position($('.wo')).left
	 	layer.position($('.wo')).top
	 * @for layer
	 * @param 
	 	obj: 需定位jquery对象
	 	width: 模态框宽度
	 * @return 
	 	返回一个对象，带有left值和top值
	 */
	position: function (obj,width) {
		var _objWidth = width || obj.width();//模态框宽度是否有调整
		var _layerPosition = {
			_left: ($(window).width()-_objWidth)/2,
			_top: ($(window).height()-obj.height())/2
		};
		return _layerPosition;
	},
	/**
	 * 消息提示框
	 * @method 
	 	layer.msg('达到姐啊回答');
	 * @for layer
	 * @param 
		txt: 提示文字
	 */
	msg: function (txt) {
		if($('.lz-msg').hasClass('lz-msg')){
			return;
		}
		var tipsBody = '<div class=\"lz-msg\">'+txt+'</div>';
		$('body').append(tipsBody);
		$('.lz-msg').css({
			'left': layer.position($('.lz-msg'))._left-20,
			'top': layer.position($('.lz-msg'))._top
		})
		.show();//提示框定位;
		setTimeout(function () {
		    $('.lz-msg').remove();
		},2000);
	},
	/**
	 * 模态框内容
	 * @method 
	 	例子：
	 	layer.modal('login') //登录框
	 * @for layer
	 * @param 
	 	tag: 
	 		login 登录框
	 		reg 注册框
	 		finish 完善信息框
	 		address 新增地址框
	 		testmobile 验证手机号框(ps:与重置密码配合用的，暂无单独功能)
	 		reset 重置密码框
	 		tips tips确认框
	 	callback: 配合确认框使用
	 * @return 	
	 	只有tips框有返回，当用户点击确认仅返回一个true
	 */
	modal: function (tag,callback) {
		//字典没有的提示
		if(!localStorage[getLang()]){
			if(getLang()=='en'){
				layer.msg('Please hold on');
				trsLang('index');
			}
			else{
			 	layer.msg('请稍等');
			 	trsLang('index');
			}
			return;
		}
		var title = '';//模态框标题
		var msg = '';//模态框提示信息
		var web_captcha = '';//网页验证码
		var modal_boolean = false;//confirm窗，默认值
		var imgID = 0;//头像ID
		var data ='';
		//编辑地址相关变量
		var address_id;
		var address_user_name;
		var address_proname;
		var address_cityname;
		var address_areaname;
		var address_part_detail;
		var address_postcode;
		var address_mobile;
		var address_proId;
		var address_cityId;
		var address_areaId;
		//编辑地址相关变量
		if(typeof tag =='object'){
			var obj = tag;
			tag = obj.tag;
			title = obj.title;
			msg = obj.msg || '';
			data  = obj.data || null;
		}
		//console.log(data);
		if(data!==null){
			address_id = data.id;
			address_user_name = data.name;
			address_proname = data.provinceName;
			address_cityname = data.cityName || trsLang('first_chose_pro');
			address_areaname = data.districtName || trsLang('chose_area');
			address_postcode = data.postcode;
			address_mobile = data.mobile;
			address_proId = data.provinceId;
			address_cityId = data.cityId;
			address_areaId = data.districtId;
			address_part_detail = data.detail;
		}else{
			address_id = '';
			address_user_name = trsLang('enter_consignee_name');
			address_proname = trsLang('first_chose_pro');
			address_cityname = trsLang('first_chose_city');
			address_areaname = trsLang('chose_area');
			address_postcode = trsLang('enter_consignee_postcode');
			address_mobile = trsLang('enter_consignee_phonenumber');
			address_part_detail = trsLang('enter_detail_address');
		}
		
		var ConfirmHTML = 
			'<div class="lz-tips">'+
				'<p>'+msg+'</p>'+
				'<a class="sure">'+trsLang('confirm')+'</a><a class="cancel">'+trsLang('cancel')+'</a>'+
			'</div>';
		var AddressHTML = 
			'<table data-id="'+address_id+'">'+
				'<tbody>'+
					'<tr>'+
						'<td>'+trsLang('name')+'：</td>'+
						'<td><input type="text" name="name" value="'+address_user_name+'"></td>'+
					'</tr>'+
					'<tr>'+
						'<td>'+trsLang('address')+'</td>'+
						'<td class="part">'+
							'<select class="pro" name="part" style="width:175px;">'+
								'<option value="'+address_proId+'">'+address_proname+'</option>'+
							'</select>'+
							'<select class="city" name="part">'+
								'<option value="'+address_cityId+'">'+address_cityname+'</option>'+
							'</select>'+
							'<select class="area" name="part">'+
								'<option value="'+address_areaId+'">'+address_areaname+'</option>'+
							'</select>'+
							'<input type="text" name="address" value="'+address_part_detail+'">'+
						'</td>'+
					'</tr>'+
					'<tr>'+
						'<td>'+trsLang('postcode')+'：</td>'+
						'<td><input type="text" name="postcode" value="'+address_postcode+'"></td>'+
					'</tr>'+
					'<tr>'+
						'<td>'+trsLang('mobile')+'：</td>'+
						'<td><input type="text" name="mobile" value="'+address_mobile+'"></td>'+
					'</tr>'+
					'<tr>'+
						'<td></td>'+
						'<td><a class="address-btn" data-id="'+address_id+'">'+trsLang('save')+'</a></td>'+
					'</tr>'+
				'</tbody>'+
			'</table>';
		var LoginAndRegHTML = 
			'<div class="modal-tab">'+
				'<a class="login">'+trsLang('login')+'</a>'+
				'<a class="reg">'+trsLang('register')+'</a>'+
			'</div>'+
			'<div class="con login" style="display:block;">'+
			//div.con是默认隐藏的元素，无法获取高度，所以必须这样处理
				'<div class="modal-input">'+
					'<input type="text" id="loginmobile" class="mousetrap">'+
					'<span class="filter">'+trsLang('phone_number')+'</span>'+
				'</div>'+
				'<div class="modal-input">'+
					'<input type="password" id="loginpass" class="mousetrap">'+
					'<span class="filter">'+trsLang('pass_word')+'</span>'+
				'</div>'+
				'<a class="forgetpass">'+trsLang('forgot_password')+'</a>'+
				'<div style="height: 10px;"></div>'+
				'<div class="login-btn">'+
					'<div class="modal-input">'+
						'<input type="text" id="logincode" class="mousetrap">'+
						'<span>'+trsLang('verification_code')+'</span>'+
					'</div>'+
					'<div class="web-captcha">2131</div>'+
					'<a class="modal-btn">'+trsLang('login')+'</a>'+
				'</div>'+
				'<div class="tips">'+trsLang('use_social_account_login')+'</div>'+
				'<a class="thirdparty-btn qq" href="http://www.colourfulafrica.com/auth/qq"><i></i><span>QQ</span></a>'+
				'<a class="thirdparty-btn wechat" href="http://www.colourfulafrica.com/auth/wechat"><i></i><span>'+trsLang('we_chat')+'</span></a>'+
				'<div class="clear"></div>'+
			'</div>'+
			'<div class="con reg">'+
				'<div class="modal-input"><input type="text" id="regmobile" class="mousetrap"><span>'+trsLang('enter_login_mobile')+'</span></div>'+
				'<div class="modal-input" style="width:240px;float:left;"><input type="text" id="regcode" class="mousetrap"><span>'+trsLang('enter_SMS_code')+'</span></div>'+
				'<a class="modal-btn sentcode" style="float: right; margin-top:20px;">'+trsLang('send_code')+'</a>'+
				'<div class="clear"></div>'+
				'<div class="modal-input"><input type="password" id="regpass" class="mousetrap"><span>'+trsLang('enter_password')+'</span></div>'+
				'<div class="modal-input"><input type="password" id="repeatregpass" class="mousetrap"><span>'+trsLang('repeat_password')+'</span></div>'+
				'<a class="modal-btn reg-btn" style="width:100%;margin-top:30px;">'+trsLang('register_now')+'</a>'+
			'</div>';
		var FinishInfoHTML = 
			'<div class="con finish-info" style="display:block;">'+
				'<div class="user-photo">'+
					'<img src="/dist/img/ins_s_ic_autohead.png">'+
					'<input id="headupload" type="file" name="files">'+
					'<span id="photo">'+trsLang('upload_avatar')+'</span>'+
					'<input type="hidden" id="photoID" class="mousetrap">'+
				'</div>'+
				'<div class="modal-input"><input type="text" id="nickname" class="mousetrap" placeholder="'+trsLang('enter_nickname')+'"><span>'+trsLang('enter_nickname')+'</span></div>'+
				'<div class="modal-input"><input type="text" id="realname" class="mousetrap" placeholder="'+trsLang('real_name')+'"><span>'+trsLang('real_name')+'</span></div>'+
				'<div class="modal-input part">'+
					'<span>'+trsLang('province')+'</span><select class="pro" name="part"></select><i></i>'+
				'</div>'+
				'<div class="modal-input part">'+
					'<span>'+trsLang('first_chose_pro')+'</span><select class="city" name="part"></select><i></i>'+
				'</div>'+
				'<div class="modal-input part" style="margin-right:0;">'+
					'<span>'+trsLang('first_chose_city')+'</span><select class="area" name="part"></select><i></i>'+
				'</div>'+
				'<div class="clear"></div>'+
				'<div class="modal-input"><input type="text" id="address" class="mousetrap"><span>'+trsLang('address_detail')+'</span></div>'+
				'<div class="modal-input">'+
					'<select class="ageRange mousetrap" >'+	
						'<option>'+trsLang('select_age')+'</option>'+
						'<option value="1">5'+trsLang('to')+'10'+trsLang('years')+'</option>'+
						'<option value="2">11'+trsLang('to')+'15'+trsLang('years')+'</option>'+
						'<option value="3">16'+trsLang('to')+'20'+trsLang('years')+'</option>'+
						'<option value="4">21'+trsLang('to')+'25'+trsLang('years')+'</option>'+
						'<option value="5">26'+trsLang('to')+'30'+trsLang('years')+'</option>'+
						'<option value="6">31'+trsLang('to')+'35'+trsLang('years')+'</option>'+
						'<option value="7">36'+trsLang('to')+'40'+trsLang('years')+'</option>'+
						'<option value="8">41'+trsLang('to')+'45'+trsLang('years')+'</option>'+
						'<option value="9">46'+trsLang('to')+'50'+trsLang('years')+'</option>'+
						'<option value="10">51'+trsLang('to')+'55'+trsLang('years')+'</option>'+
						'<option value="11">56'+trsLang('to')+'60'+trsLang('years')+'</option>'+
						'<option value="12">61'+trsLang('to')+'65'+trsLang('years')+'</option>'+
						'<option value="13">66'+trsLang('to')+'70'+trsLang('years')+'</option>'+
						'<option value="14">71'+trsLang('to')+'75'+trsLang('years')+'</option>'+
						'<option value="15">76'+trsLang('to')+'80'+trsLang('years')+'</option>'+
						'<option value="16">'+trsLang('more_than')+'80</option>'+
					'</select></div>'+
				'<a class="sex man" data-id="1"><i></i><span>'+trsLang('male')+'</span></a><a class="sex woman" data-id="0"><i></i><span>'+trsLang('female')+'</span></a>'+
				'<input type="hidden" id="sex" mousetrap>'+
				'<div class="clear"></div>'+
				'<a class="modal-btn">'+trsLang('confirm')+'</a>'+
			'</div>';
		var backpassHTML = 
			'<div class="modal-tab">'+
				'<a class="testmobile">'+trsLang('verify_phone')+'</a>'+
				'<a class="reset">'+trsLang('reset_password')+'</a>'+
			'</div>'+
			'<div class="con testmobile" style="display: block">'+
				'<div class="modal-input"><input type="text" id="testmobile" class="mousetrap"><span>'+trsLang('enter_login_number')+'</span></div>'+
				'<div class="modal-input" style="width:240px;float:left;"><input type="text" id="testmobilecode" class="mousetrap"><span>'+trsLang('enter_SMS_code')+'</span></div>'+
				'<a class="modal-btn sentcode" style="float: right; margin-top:30px;">'+trsLang('send_code')+'</a>'+
				'<div class="clear"></div>'+
				'<a class="modal-btn testmobile-btn" style="width:100%;margin-top:30px;">'+trsLang('next')+'</a>'+
			'</div>'+
			'<div class="con reset">'+
				'<div class="modal-input"><input type="password" id="newpass" class="mousetrap"><span>'+trsLang('new_password')+'</span></div>'+
				'<div class="modal-input"><input type="password" id="repeatpass" class="mousetrap"><span>'+trsLang('repeat_new_password')+'</span></div>'+
				'<a class="modal-btn reset-btn" style="width:100%;margin-top:30px;">'+trsLang('confirm')+'</a>'+
			'</div>';
		var _disHTML =
			 '<div class="lz-tips">'+
			 	'<img src>'+
			 	'<a class="sure">'+trsLang('confirm')+'</a><a class="cancel">'+trsLang('cancel')+'</a>'+
			 '</div>';
		switch (tag){
			case 'dis':
				showModal(_disHTML);
				break;
			case 'reg':
				showModal(LoginAndRegHTML);
				Mousetrap.bind('enter', _reg, 'keyup');
				break;
			case 'login':
				showModal(LoginAndRegHTML);
				outCaptcha();
				Mousetrap.bind('enter', _login, 'keyup');
				break;
			case 'finish':
				showModal(FinishInfoHTML, trsLang('improve_the_data'));
				getcities(0,null,$('.part>.pro'));//获取省
				Mousetrap.bind('enter', _finishInfo, 'keyup');
				$('.part>.pro').siblings('span').hide();
				//上传头像
				$('#headupload')
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
						$('.user-photo>img').attr('src','/image/get/'+imgID);
						$('#photoID').val(imgID);
					});
				    }
				});



				break;
			case 'testmobile':
				showModal(backpassHTML);
				Mousetrap.bind('enter', _next, 'keyup');
				break;
			case 'reset':
				showModal(backpassHTML);
				Mousetrap.bind('enter', _reset, 'keyup');
				break;
			case 'tips':
				showModal(ConfirmHTML,title,330);
				break;
			case 'address':
				showModal(AddressHTML,title,882);
				//console.log(!address_proname);
				if(!data){
					getcities(0,null,$('select.pro'));//获取省
				}
				break;
			default:
				//console.log('tag传错了:'+tag);
		}
		//定位
		function setModal(width) {
			$('.lz-modal').css({
				'transform': 'translateY('+layer.position($('.lz-modal'))._top+'px)',
				'margin-left': layer.position($('.lz-modal'),width)._left < 0 ? 0 : layer.position($('.lz-modal'),width)._left,
				'width': width || 530
			});
		}
		//跟随窗口调整位置
		$(window).resize(function(event) {
			setModal($('.lz-modal').width());
		});
		//显示并初始化模态框
		function showModal(html,title,width) {
			if(title===undefined) title = '';
			if($('.modal-wrap').hasClass('modal-wrap')) $('.modal-wrap').remove();
			var modal = 
			'<div class="modal-wrap">'+
				'<div class="lz-modal">'+
					'<span class="title">'+title+'</span>'+
					'<i class="modal-x"></i>'+
					'<div class="clear"></div>'+
				html+'</div>'+
			'</div>';
			$('body').append(modal);
			$('.modal-wrap').height($('body').height());
			//针对模态框有选项卡时显示对应的模态框
			$('.modal-tab>a.'+tag+'').addClass('active').siblings('a').removeClass('active');
			$('.con.'+tag+'').show().siblings('.con').hide();
			if(width) {
				setModal(width);
				return;
			}
			setModal();
		}
		//生成前端验证码
		function outCaptcha() {
			var captcha = '';
			for (var i = 0; i < 4; i++) {
				captcha += parseInt((Math.random()*10)).toString();
			}
			web_captcha = captcha;
			$('.web-captcha').text(web_captcha);
		}
		//登录
		function _login() {
			var loginmobile = $('#loginmobile').val();
			var loginpass = $('#loginpass').val();
			var logincode = $('#logincode').val();
			if(loginmobile&&loginpass&&logincode){
				if(logincode==web_captcha){
					api('post','/user/login',{
						mobile: $('#loginmobile').val(),
						password: $('#loginpass').val()
					},function (res) {
						layer.msg(res.msg);
						if(!res.status){
							Cookies.set('userId',res.data.id);
							Cookies.set('mobile',loginmobile);
							if(res.data.firstLogin===0){
								layer.modal('finish');
								return;
							}
							location.reload();
						}
					});
				}
				else layer.msg(trsLang('enter_right_code'));
			}
			else layer.msg(trsLang('complete_login_information'));
		}
		//注册
		function _reg() {
			var regmobile = $('#regmobile').val();
			var regpass = $('#regpass').val();
			var confirmpass = $('#repeatregpass').val();
			var regcode = $('#regcode').val();
			if(regmobile&&regpass&&confirmpass&&regcode){
				if(regpass!==confirmpass){
					layer.msg(trsLang('two_password_inconsistent'));
					return;
				}else if(!testPass($('#regpass'))){
					layer.msg( trsLang('input_password') );
					return;
				}
				api('post','/user/register',{
					mobile: regmobile,
					password: regpass,
					confirmpasswd: confirmpass,
					captcha: regcode
				},function (res) {
					layer.msg(res.msg);
					if(!res.status){
						layer.modal('login');
					}
				});
				return;
			}
			layer.msg(trsLang('improve_registration_information'));
		}
		//完善资料
		function _finishInfo() {
			var _newName = $('#nickname').val();
			if(!$('#realname').val()){
				layer.msg(trsLang('username_cannot_empty'));
				return;
			}else if(_newName.toString().length>11){
				layer.msg(trsLang('username_cannot_long'));
				return;
			}
			api('post','/user/updateuserinfo',{
				userId: Cookies.get('userId'),
				nickname: _newName,
				picKey: imgID || null,
				realName: $('#realname').val(),
				ageRange: $('.ageRange').val(),
				provinceId: $('.pro').val(),
				cityId: $('.city').val(),
				districtId: $('.area').val(),
				address: $('#address').val(),
				sex: $('#sex').val(),
				mobile: Cookies.get('mobile')
			},function (res) {
				if(!res.status){
					location.reload();
				}
			});
			
		}
		//下一步
		function _next() {
			api('post','/user/resetpwd',{
				mobile: $('#testmobile').val(),
				captcha: $('#testmobilecode').val(),
				tag: 0
			},function (res) {
				if(!res.status){
					Cookies.set('mobile',$('#testmobile').val());
					resetPassUserId = res.data.userId;
					if(resetPassUserId){
						$('#newpass,#repeatpass').attr('disabled', false);
					}
					layer.modal('reset');
				}else{
					layer.msg(trsLang('enter_right_code'));
				}
			});
		}
		//重置密码
		function _reset() {
			var newpass = $('#newpass').val();
			var confirmpass = $('#repeatpass').val();
			if(newpass===''){
				layer.msg( trsLang('input_password') );
				return;
			}else if(newpass!==confirmpass){
				layer.msg(trsLang('two_password_inconsistent'));
				return;
			}else if(!resetPassUserId){
				$('.testmobile').addClass('active').siblings('.active').removeClass('active');
				$('.con.testmobile').show().siblings('.con').hide();
				return;
			}else if(!testPass($('#newpass'))){
				layer.msg( trsLang('input_password') );
				return;
			}

			api('post','/user/resetpwd',{
				mobile: Cookies.get('mobile'),
				password: newpass,
				userId: resetPassUserId
			},function (res) {
				resetPassUserId = null;
				layer.msg(res.msg);
				if(!res.status){
					Cookies.remove('mobile');
					layer.modal('login');
				}
			});
		}
		//选项卡
		$('.lz-modal').on('click', '.modal-tab>a', function(event) {
			$(this).addClass('active').siblings('.active').removeClass('active');
			$($('.lz-modal>.con')[$(this).index()]).show().siblings('.con').hide();
			if(tag=='login') outCaptcha();
			if(!resetPassUserId){
				$('#newpass,#repeatpass').attr('disabled', true);
			}
		})
		//提示框的确定按钮
		.on('click', '.lz-tips>a.sure', function(event) {
			modal_boolean = true;
			$('.modal-wrap').remove();
			callback(modal_boolean);
		})
		//性别
		.on('click', 'a.sex', function(event) {
			$(this).toggleClass('active').siblings('a').removeClass('active');
			$('#sex').val($(this).data('id'));
		})
		//输入框的默认文字
		.on('click', '.modal-input', function(event) {
			$(this).children('span').hide();
			$(this).children('input').focus();
		})
		.on('focus', '.modal-input', function(event) {
			$(this).children('span').hide();
		})
		//去除模态框
		.on('click', 'i.modal-x,a.cancel', function(event) {
			$('.modal-wrap').remove();
			if($(this).parents('.lz-modal').find('.finish-info').hasClass('finish-info')){
				location.reload();
			}
			Mousetrap.unbind('enter');
		})
		//前端验证码
		.on('click', '.web-captcha', function(event) {
		  	web_captcha = outCaptcha();  	
		  	$(this).text(web_captcha);
		})
		// //第三方
		// .on('click', '.thirdparty-btn', function(event) {
		// 	layer.msg('暂未开通');
		// })
		//发送验证码
		.on('click', '.sentcode', function(event) {
			var mobile = $('#regmobile').val() || $('#testmobile').val();
			if(mobile&&mobile.length==11){
				if($('#regmobile').val()) getCaptcha($(this),mobile,0);
				else if($('#testmobile').val()) getCaptcha($(this),mobile,1);
			}
			else layer.msg(trsLang('enter_right_number'));
		})
		//忘记密码按钮
		.on('click', '.forgetpass', function(event) {
			layer.modal('testmobile');
		})
		//验证手机号---下一步
		.on('click', '.testmobile-btn', function(event) {
			if($('#testmobile').val()&&$('#testmobilecode').val()){
				_next();
			}
		})
		//重置密码前验证密码
		.on('blur', '#newpass', function(event) {
			testPass($(this));
		})
		//重置密码
		.on('click', '.reset-btn', function(event) {
			_reset();
		})
		//登录
		.on('click', '.login-btn>.modal-btn', function(event) {
			_login();
		})
		//限制注册手机号
		.on('blur', '#regmobile', function(event) {
			var val = $(this).val();
			if( isNaN( parseInt(val) ) ){
				$(this).val('');
			}
			else if(val.length>14||val.length<11){
				layer.msg(trsLang('enter_right_number'));
				$(this).val(val.substring(0,14));
			}
		})
		//限制注册密码
		.on('blur', '#regpass,#repeatregpass', function(event) {
			testPass($(this));
		})
		//注册
		.on('click', '.con.reg .reg-btn', function(event) {
			_reg();
		})
		//选择省市区
		.on('change', 'select[name="part"]', function(event) {
			var $select = $(this);
			var id = $select.children('option:selected').attr('id');
			var classname = $select[0].className;
			switch(classname){
				case 'pro':
					getcities(1,id,$('.part>select.city'));
					$('.part>select.city').siblings('span').hide();
					$('.part>select.area').html('');
					break;
				case 'city':
					getcities(2,id,$('.part>select.area'));
					$('.part>select.area').siblings('span').hide();
					break;
				case 'area':
					break;
				default:
					//console.log('你在逗我？');
			}
		})
		//完善信息
		.on('click', '.finish-info .modal-btn', function(event) {
			_finishInfo();
		});
	}
};
var loader = {
	open: function (argument) {
		$('<img src="/dist/img/loading.gif" class="loading">').appendTo('body');
		$('.loading').css({
			left: layer.position($('.loading'))._left-10,
			top: layer.position($('.loading'))._top
		});
	},
	close: function () {
		$('.loading').remove();
	}
};
;(function ($,window,document,undefined) {
    $.fn.pager = function (options) {
        var upClass = '';
        var downClass = '';
        var pagesNum = '';
        var firstPage = '';
        var lastPage = '';
        var firstClass;
        var lastClass;
        var headAction = '<span>...</span>';
        var footAction = '<span>...</span>';
        var theme;

        var currentPage = options.currentPage;
        var totalPage = options.totalPage;

        //生成除收尾的页码
        function pageCount (start,end) {
            for (var i = start; i < end; i++) {
              if(i==currentPage) pagesNum += '<a role=\"button\" index=\"'+i+'\" class=\"active\">'+i+'</a>';
              else pagesNum += '<a role=\"button\" index=\"'+i+'\">'+i+'</a>';
            }
        }

        /*前五页*/
        if(currentPage<7){
            if(totalPage<7) pageCount(2,totalPage);//console.log('前5，总页小于7');
            else pageCount(2,7);//console.log('前5，总页大于等于7');
        }
        /*中间页*/
        else if(currentPage<totalPage-5&&currentPage>=7){
            pageCount(parseInt(currentPage) - 2,parseInt(currentPage)+3);//console.log('中');   
        }
        /*后五页*/
        else if(currentPage>=totalPage-5){ 
            pageCount(parseInt(totalPage)-5,totalPage);//console.log('后5');
        }

        //控制头尾的显示
        if(currentPage==1){
            upClass = 'nopage';
            firstClass = 'active';
            lastClass = '';
            headAction = '';
            if(totalPage<=7){
                footAction = '';
            }
        }
        else if(currentPage==totalPage){
            downClass = 'nopage';
            firstClass = '';
            lastClass = 'active';
            footAction = '';
            if(totalPage<=7){
                headAction = '';
            }
        }
        else{
            firstClass = '';
            lastClass = '';
            if(currentPage<7){
              headAction = '';
              if(totalPage<=7){
                footAction = '';
              }
            }
            else if(currentPage<totalPage&&currentPage>=totalPage-5){
              footAction = '';
            }
        }
        //首页尾页的处理
        firstPage = '<a role=\"button\" index=\"1\" class="'+firstClass+'">1</a>'+headAction+'';
        lastPage = ''+footAction+'<a role=\"button\" index=\"'+totalPage+'\" class="'+lastClass+'">'+totalPage+'</a>';
        //只有1页的特殊处理
        if(currentPage==1&&totalPage==1){
            lastPage = '';
            downClass = 'nopage';
        }
        //组装分页
        // pageAction = '<a class=\"page-up ' +upClass+'\" role=\"button\">&lt;&nbsp;上一页</a>'+firstPage+pagesNum+lastPage+''+
        //                         '<a class=\"page-down '+downClass+'\" role=\"button\">下一页&nbsp;&gt;</a>'+
        //                         '<span style=\"margin-left:50px;\">共'+totalPage+'页</span>'+
        //                         '<span>到第</span>'+
        //                         '<input type=\"text\">'+
        //                         '<span>页</span>'+
        //                         '<a role=\"button\" class=\"btn\">确定</a>';
        pageAction = '<a class=\"page-up ' +upClass+'\" role=\"button\">&lt;&nbsp;'+trsLang('previous_page')+'</a>'+firstPage+pagesNum+lastPage+''+
                                '<a class=\"page-down '+downClass+'\" role=\"button\">'+trsLang('next_page')+'&nbsp;&gt;</a>';
        $(this).html('<div class="pager white">'+pageAction+'</div>');
    };
})(jQuery,window,document);

;(function ($,window,document,undefined) {
	$.fn.slideimg = function(options) {
		//默认参数
		var dft = {
			width: 1010,//active图片宽度
			height: 474,//active图片高度
			ratio: 404/474,//比例根据UI设计的图来的
			top: 34,//距离顶部的高度
			containerWidth: $('html').width(),//页面宽度
			autoTime: 5000,//自动轮播时差
			hasleft: 1
		};
		//合并并替换参数
		var ops = $.extend(dft,options);
		var initwidth = ops.width,
			initheight = ops.height,
			initRatio = ops.ratio,
			initTop = ops.top;
			containerWidth = ops.containerWidth;
			autoTime = ops.autoTime;
			initLeft = 0;
		var $imgCon = $(this);
		var $imgDiv =  $imgCon.children('div.item');
		var imgDivLength =  $imgDiv.length;
		var initIndex = Math.round((imgDivLength-1)/2);//取中间值
		if(ops.hasleft){
			initLeft = (containerWidth-initwidth)/2;
		}
		var imgConStyle = [];//图片容器样式
		var imgGo = true;//是否可点击
		var autoGo = true;//是否轮播
		var $thumb = $imgCon.siblings('.thumb');//缩略图
		var thumbLiWidth = 0;
		//初始化样式
		if($thumb.hasClass('thumb')){
			//复制图片到thumb内
			var thumbIMG = '';
			$.each($imgCon.children('div.item'), function(index, val) {
				thumbIMG  += '<li><img src="'+$(val).children('img').attr('src')+'"></li>';
			});
			$thumb.append('<ul>'+thumbIMG+'</ul>');
			$imgCon.parent().height(initheight+$thumb.height());//调整大容器高度
			$($thumb.find('li')[initIndex]).addClass('active');
			thumbLiWidth = $thumb.find('ul>li.active')[0].clientWidth;//缩略图LI宽度
			$thumb.children('ul').width(thumbLiWidth*$thumb.find('li').length);//UL宽度
		}else{
			$(this).parent().height(initheight);
		}

		$imgCon.css({
			width: initwidth,
			height: initheight
		});

		$($('.img-con>div.item')[initIndex]).addClass('active');
		$imgCon.siblings('.img-btn').find('.index').text(initIndex+1);
		$imgCon.siblings('.img-btn').find('.total').text(imgDivLength);

		//按钮样式
		var $imgBtn = $(this).siblings('.img-btn');
		var btnHeight = $imgBtn.children('a').height();
		$imgBtn.css('width',initwidth).children('a').css('bottom', initheight/2-btnHeight/2);
		
		//图片容器定位
		$.each($imgDiv, function(index, val) {
			$(val).attr('index', index);
			//右侧图
			if(initIndex>index){
				var leftIndex = initIndex - index;
				$(val).css({
					'z-index' : initIndex+1-leftIndex,
					width: initwidth*Math.pow(initRatio,leftIndex),
					height: initheight*Math.pow(initRatio,leftIndex),
					left: index === 0 ? -initLeft : -initLeft/Math.pow(2,leftIndex),
					top: initTop*leftIndex
				});
			}
			//中间图
			else if(initIndex==index){
				$(val).css({
					'z-index' : initIndex+1,
					width: initwidth,
					height: initheight,
					left: 0,
					top: 0
				});
			}
			//左侧图
			else{
				var rightIndex = index - initIndex;
				$(val).css({
					'z-index' : initIndex+1-rightIndex,
					width: initwidth*Math.pow(initRatio,rightIndex),
					height: initheight*Math.pow(initRatio,rightIndex),
					right: index == $imgDiv.length-1 ? -initLeft : -initLeft/Math.pow(2,rightIndex),
					top: initTop*rightIndex
				});
			}
			imgConStyle[index] = $(val).attr('style');
		});
		
		//获取active样式
		var activeStyle = imgConStyle[initIndex];
		//绑定左右按钮
		$(document).on('click', '.img-slide-container .left-btn,.img-slide-container .right-btn', function(event) {
			var $newImgDiv = $('.img-con>div.item');
			if($(this).hasClass('left-btn')&&imgGo){
				imgGo = false;
				//将中间的定位改为left
				imgConStyle[initIndex] = activeStyle.replace(/right/,'left');
				$imgCon.prepend($newImgDiv[imgDivLength-1]);//将最后个移动到第一个
				$.each($newImgDiv, function(index, val) {
					$newImgDiv[index].setAttribute('style', imgConStyle[index + 1 > imgDivLength - 1 ? 0 : index + 1]);
				});
				changeNumber($newImgDiv);
			}
			else if($(this).hasClass('right-btn')&&imgGo){
				goRight();
			}
		});

		//点击缩略图
		$(document).on('click', '.img-slide-container .thumb li', function(event) {
			var $thumb_this = $(this);
			var index = $thumb_this.index();
			//$thumb_this.addClass('active').siblings().removeClass('active');
			//$('.img-con>div.item[index="'+index+'"]').addClass('active').siblings('.active').removeClass('active');
			//这里的操作需要重新给ITEM加以样式
		});

		//自动轮播
		var imgAutoGo = setInterval(function () {
			if(autoTime){
				if(autoGo) goRight();
			}
		},autoTime);
		setTimeout(function () {
			if($imgCon.children().length<2){
				window.clearInterval(imgAutoGo);
			}
		},1000);
		$(document).on('mouseenter', $(this), function(event) {
			autoGo = false;
		});
		$(document).on('mouseleave', $(this), function(event) {
			autoGo = true;
		});

		//向右
		function goRight() {
			imgGo = false;
			var $newImgDiv = $('.img-con>div.item');
			//将中间的定位改为right
			imgConStyle[initIndex] = activeStyle.replace(/left/,'right');
			$.each($newImgDiv, function(index, val) {
				$newImgDiv[index].setAttribute('style', imgConStyle[index - 1 < 0 ? imgDivLength - 1 : index - 1]);
				if(index==imgDivLength-2){
					//隔200ms把第一个添加到末尾
					setTimeout(function () {
						$imgCon.append($newImgDiv[0]);
						changeNumber($newImgDiv);
					},200);
				}
			});
		}

		//改数字加active样式
		function changeNumber($newImgDiv) {
			$newImgDiv.removeClass('active');
			$($('.img-con>div.item')[initIndex]).addClass('active');
			var activeIndex = $imgCon.children('div.active').attr('index');
			$('.img-btn>.number>span.index').text(parseInt(activeIndex)+1);
			if($thumb.hasClass('thumb')){
				$($thumb.find('li')[activeIndex]).addClass('active').siblings().removeClass('active');
				//滚动thumb
				if(activeIndex>11){
					$thumb.children('ul').css('margin-left',-(imgDivLength-12)*thumbLiWidth);
				}
				else if(parseInt(activeIndex)===0){
					$thumb.children('ul').css('margin-left',0);
				}
			}
			imgGo = true;
		}
	};
})(jQuery,window,document);