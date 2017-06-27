/**
 *带loading效果的Ajax请求
 * @param  
 	 method: 使用post或者get
 	 url: 接口地址
 	 data: 接口参数，是个对象
 	 callback: 请求返回后的回调函数
 * @return 
 	返回接口数据，在回调函数中可以直接用
 */
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