viewSrc = ''; //页面地址
//reqHost = 'appbuilder.123dby.com';//本地测试
reqHost = ''; //正式地址

//微信支付需要在正式地址的域名下测试

/**
 *获取设备宽度并设置html的字体大小
 */
function base() {
	var dpr, rem, scale;
	var docEl = document.documentElement;
	var fontEl = document.createElement('style');
	var metaEl = document.querySelector('meta[name="viewport"]');
	dpr = window.devicePixelRatio || 1;
	rem = docEl.clientWidth * dpr / 10;
	scale = 1 / dpr;
	var fontSize = rem / dpr;
	//<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	// 设置viewport，进行缩放，达到高清效果(去除缩放，移动端并没有什么卵用)
	//metaEl.setAttribute('content', 'width=' + dpr * docEl.clientWidth + ',initial-scale=' + scale + ',maximum-scale=' + scale + ', minimum-scale=' + scale + ',user-scalable=no');

	// 设置data-dpr属性，留作的css hack之用
	docEl.setAttribute('data-dpr', dpr);

	// 动态写入样式
	docEl.firstElementChild.appendChild(fontEl);
	if (docEl.clientWidth >= 640) {
		fontSize = 64;
	}
	fontEl.innerHTML = 'html{font-size:' + fontSize + 'px!important;}';

	// 给js调用的，某一dpr下rem和px之间的转换函数
	window.rem2px = function (v) {
		v = parseFloat(v);
		return v * rem;
	};
	window.px2rem = function (v) {
		v = parseFloat(v);
		return v / rem;
	};

	window.dpr = dpr;
	window.rem = rem;
}
base();

window.onresize = function (event) {
	base();
};

//提示窗
function txtTips(txt) {
	var hasTips = $('.txt-tips').hasClass('txt-tips');
	var tipsWidth = $('.txt-tips').width();
	if (!hasTips) $('body').append('<div class="txt-tips"></div>');
	$('.txt-tips').html(txt).css({
		bottom: $(window).height() / 5,
		left: $(window).width() / 2 - $('.txt-tips').width() / 2 - 10
	}).show();
	setTimeout(function () {
		$('.txt-tips').fadeOut('slow');
	}, 1500);
}



window.loading = false;
//loading
var loader = {
	set: function () {
		if (!$('.loading').hasClass('loading')) {
			$('body').append('<div class="loading"><div class="img-parent"><img src="http://appbuilder.loongjoy.com/phoneweb/app/img/Loading_app.gif"></div></div>');
		}
		$('.loading').css({
			width: '10rem',
			height: $(window).height()
		});
		$('.img-parent').css({
			top: $(window).height() / 3,
			left: $(window).width() / 2 - $('.img-parent').width() / 2 - 10
		});
	},
	open: function () {
		window.loading = true;
		$('.loading').show();
	},
	close: function () {
		window.loading = false;
		$('.loading').hide();
	}
};

//转换APPID
function exchangeAppId() {
	//清空APP相关配置信息
	// localStorage.removeItem('appID');
	// localStorage.removeItem('appIDKey');
	// localStorage.removeItem('app');

	//alert('首次进入获取APP_ID'+localStorage.appID);

	var id = 0;
	var _Href = decodeURIComponent(location.href);
	var urlArray = _Href.split('#/');
	id = urlArray[1].substring(0, 6); //获取短连接
	//alert('短连接'+id);

	//获取到了APPID并且短连接是一样的
	if (localStorage.appID && localStorage.appIDKey == id) {
		//alert('返回APP_ID:'+localStorage.appID);
		return localStorage.appID;
		//短连接并不相同
	} else if (localStorage.appIDKey !== id && id !== 'undefi') {
		//alert('清空上一个APP相关配置信息');
		//清空APP相关配置信息
		localStorage.removeItem('appID');
		localStorage.removeItem('appIDKey');
		localStorage.removeItem('app');
		localStorage.removeItem('wxid');
	} else if (id == 'undefi' && localStorage.appID && localStorage.appIDKey) {
		//alert('短连接为undefined，返回APP_ID:'+localStorage.appID);
		return localStorage.appID;
	}

	//存ID
	$.get(reqHost + '/api/app/info/' + id, function (data) {
		localStorage.setItem('appID', data.content.id);
		localStorage.setItem('appIDKey', id);
		localStorage.setItem('wxid', data.content.WxAppId);
		//alert('存入的APP_ID:'+localStorage.appID);
		//alert('存入的appIDKey:'+localStorage.appIDKey);
		//alert('当前的URL'+_Href);
		location.reload();
	});

}



/**
 *定义路由
 */
var appBuilder = angular.module('appBuilder', [
	'ui.router',
	'ngCookies',
	'ngTouch',
	'ngAnimate',
	'appBuilderCtr',
	'appBuilderService',
	'appBuilderFactory',
	'phonecatFilters',
	'pascalprecht.translate'
]);

appBuilder
	.constant('APP_ID', exchangeAppId())
	.constant('HOST', viewSrc + '/phoneweb/app/index.html#')
	.constant('API_SALT', 'ab3e87601534d2ad785eb2d241d59f14');

appBuilder.config(['$stateProvider', '$urlRouterProvider', '$logProvider', '$translateProvider',
	function ($stateProvider, $urlRouterProvider, $logProvider, $translateProvider) {

		var lang = window.navigator.language.substring(0, 2);
		$translateProvider.translations('en', {
			aboutUs: 'About us',
			enterSearchContent: 'Enter search content',
			articleDetails: 'Article details',
			noComment: 'No comment',
			allComments: 'All comments',
			merchantReply: 'Merchant reply:',
			sendOut: 'Send out',
			commentArticle: 'How to write the article, comment on it',
			articleCenter: 'Article center',
			noContent: 'No content',
			articleList: 'Article list',
			shoppingCart: 'Shopping Cart',
			edit: 'edit',
			product: 'product',
			integralMall: 'Integral mall',
			discount: 'discount',
			subtract: 'subtract',
			give: 'give',
			Total: 'Total:',
			notFreight: '(Does not include freight)',
			accounts: 'To settle accounts',
			checkAll: 'check all',
			delete: 'delete',
			placeOrder: 'place order',
			sendAddress: 'Address is not added, where to send it',
			paymentMethod: 'Payment method',
			shippingMethod: 'Shipping Method',
			optionalInformation: 'Optional,Input memo information',
			messageRemarks: 'Message remarks:',
			available: 'available',
			integralDeductible: 'integral Deductible',
			inAll: 'in all',
			pieceProduct: 'piece product',
			freight: 'freight',
			selectPaymentMethod: 'Select payment method',
			weChatPayment: 'WeChat payment',
			noteDetail: 'Post Detail',
			pushUp: 'push up',
			postDeleted: 'This post has been deleted',
			commentOnIt: 'Comment on it',
			PUBLISHPOST: 'PUBLISH POST',
			issue: 'issue',
			editorPostTitle: 'Editor post title',
			enterPostContent: 'Enter post content...',
			addToPicture: 'Add up to 9 pictures, one of the largest single picture 2M',
			forum: 'forum',
			personParticipate: 'person participate in',
			dailyLifeNaggings: 'Daily life naggings',
			post: 'post:',
			Replies: 'Replies:',
			forgetPassword: 'Forget',
			phoneNumber: 'Please enter a 11 digit phone number',
			newPassword: 'Please enter a new password for 6-12',
			verificationCode: 'Please enter the verification code',
			Determine: 'Determine',
			GetverificationCode: 'Get verification code',
			overplus: 'overplus',
			second: 'second',
			Login: ' Login',
			password: 'Please enter a 6-12 bit password',
			register: 'register',
			nickname: 'Please enter a 2-10 nickname',
			newProducts: 'New products on the new',
			Rush: 'Rush at once',
			grab: 'About to open to grab',
			grabAtOnce: 'Grab at once',
			robbed: 'Have robbed the light',
			Sold: 'Sold',
			piece: 'piece',
			currentIntegration: 'Current integration:',
			convertible: 'convertible',
			Deficiency: 'Deficiency of integral',
			noConvertibleProducts: 'No convertible products',
			sale: 'discount',
			openGrab: 'Open grab',
			alreadyOpenGrab: 'Already open grab',
			convenienceSupermarket: 'Convenience supermarket',
			havebeenRobbed: 'Have been robbed',
			path: 'path',
			shippingAddress: 'Shipping address',
			addAddress: 'Add address',
			setUp: 'Set up',
			aboutStore: 'About store',
			wipeCache: 'wipe cache',
			currentVersion: 'current version',
			quicklyDownload: 'Share to friends, sweep code quickly download',
			filter: ' filter',
			whole: 'whole',
			notPaid: 'Not paid',
			alreadyPaid: 'Already paid',
			paymentFailure: 'Payment failure',
			alreadyAhipped: 'Already shipped',
			cashOnDelivery: 'Cash on Delivery',
			canceled: 'canceled',
			completed: 'completed',
			IntegrationOrder: 'Integration order',
			ProductOrder: 'Product order',
			Sun: 'Sun.',
			Mon: 'Mon.',
			Tues: 'Tues.',
			Wed: 'Wed.',
			Thurs: 'Thurs',
			Fri: 'Fri.',
			Sat: 'Sat.',
			year: 'year',
			month: 'month',
			start: 'start',
			end: 'end',
			selectShoppingGuide: 'Select shopping guide',
			currentLevel: 'Current level',
			nextLevel: 'Distance to the next level',
			growthValue: 'Growth value',
			growthValueDetailed: 'growth Value Detailed',
			information: 'Personal information',
			myInformation: 'My information',
			portrait: 'Head portrait',
			name: 'Full name',
			CellphoneNumber: 'Cell-phone number',
			exitAccount: 'Exit account',
			comment: 'comment',
			integral: 'integral',
			MyOrder: 'My order',
			MyGuide: 'My shopping guide',
			MyPost: 'My post',
			complaintsAndAuggestions: 'Complaints and suggestions',
			accumulatedIncome: 'Accumulated income(￥)',
			earningsPeriod: 'Earnings period(￥)',
			TotalOrder: 'Total order(￥)',
			RecentUpdate: 'Recent update:',
			to: 'to',
			ClearFilterDate: 'Clear filter date',
			MyMember: 'My member',
			orderDetails: 'order details',
			IncomeDetails: 'Income Details',
			NoRecord: 'No record',
			OrderAmount: 'Order amount:',
			OrderIntegration: 'Credit Order:',
			news: 'news',
			back: 'back',
		});
		$translateProvider.translations('zh', {
			back: '返回',
			news: '消息',
			OrderIntegration: '订单积分:',
			OrderAmount: '订单金额:',
			NoRecord: '暂无记录',
			IncomeDetails: '收益明细',
			orderDetails: '订单明细',
			MyMember: '我的会员',
			ClearFilterDate: '清除筛选日期',
			to: '至',
			RecentUpdate: '最近更新：',
			TotalOrder: '订单总额（元）',
			earningsPeriod: '期间收益（元）',
			accumulatedIncome: '累计收益（元）',
			complaintsAndAuggestions: '投诉建议',
			MyPost: '我的帖子',
			MyGuide: '我的导购',
			MyOrder: '我的订单',
			integral: '积分',
			comment: '评论',
			exitAccount: '退出帐号',
			CellphoneNumber: '手机号',
			name: '姓名',
			portrait: '头像',
			myInformation: '我的资料',
			information: '个人信息',
			growthValueDetailed: '成长值明细',
			growthValue: '成长值',
			nextLevel: '距离下一等级还需',
			currentLevel: '当前等级',
			selectShoppingGuide: '选择导购',
			end: '结束',
			start: '开始',
			month: '月',
			year: '年',
			Sat: '六',
			Fri: '五',
			Thurs: '四',
			Wed: '三',
			Tues: '二',
			Mon: '一',
			Sun: '日',
			ProductOrder: '产品订单',
			IntegrationOrder: '积分订单',
			canceled: '已取消',
			completed: '已完成',
			cashOnDelivery: '货到付款',
			alreadyAhipped: '已发货',
			paymentFailure: '支付失败',
			alreadyPaid: '已支付',
			notPaid: '未支付',
			whole: '全部',
			filter: '筛选',
			quicklyDownload: '分享给朋友，扫码快速下载',
			currentVersion: '当前版本',
			wipeCache: '清空缓存',
			aboutStore: '关于门店',
			setUp: '设置',
			addAddress: '新增地址',
			shippingAddress: '收货地址',
			path: '路径',
			convenienceSupermarket: '便民超市',
			havebeenRobbed: '已抢',
			alreadyOpenGrab: '已开抢',
			openGrab: '未开抢',
			sale: '折扣',
			noConvertibleProducts: '暂无可兑换产品',
			Deficiency: '积分不足',
			convertible: '可兑换',
			currentIntegration: '当前积分:',
			piece: '件',
			Sold: '已售',
			robbed: '已抢光',
			grabAtOnce: '马上抢',
			grab: '即将开抢',
			Rush: '立即抢',
			newProducts: '新品上新',
			nickname: '请输入2-10位昵称',
			register: '注册',
			password: '请输入6-12位密码',
			Login: '登录',
			second: '秒',
			overplus: '还有',
			GetverificationCode: '获取验证码',
			Determine: '确定',
			verificationCode: '请输入验证码',
			newPassword: '请输入6-12位新密码',
			phoneNumber: '请输入11位手机号',
			forgetPassword: '忘记密码',
			Replies: '回帖:',
			post: '帖子:',
			dailyLifeNaggings: '生活日常碎碎念',
			personParticipate: '人参与',
			forum: '论坛',
			addToPicture: '最多添加9张图片，单张图片最大2M',
			enterPostContent: '输入帖子内容...',
			editorPostTitle: '编辑帖子标题',
			issue: '发布',
			PUBLISHPOST: '发布帖子',
			commentOnIt: '点评一下吧',
			postDeleted: '该贴已删除',
			pushUp: '顶',
			noteDetail: '帖子详情',
			weChatPayment: '微信支付',
			selectPaymentMethod: '选择支付方式',
			freight: '含运费',
			pieceProduct: '件商品',
			inAll: '共',
			integralDeductible: '积分抵',
			available: '可用',
			messageRemarks: '留言备注：',
			optionalInformation: '选填，可输入备注信息',
			shippingMethod: '配送方式',
			paymentMethod: '支付方式',
			sendAddress: '地址都没有添加，要寄去哪里呢',
			placeOrder: '提交订单',
			delete: '删除',
			checkAll: '全选',
			accounts: '去结算',
			notFreight: '(不含运费)',
			Total: '合计：',
			give: '送',
			subtract: '减',
			discount: '折',
			integralMall: '积分商城',
			product: '产品',
			edit: '编辑',
			shoppingCart: '购物车',
			articleList: '文章列表',
			noContent: '没有内容了',
			articleCenter: '文章中心',
			commentArticle: '文章写得怎么样，点评一下吧',
			sendOut: '发送',
			merchantReply: '商户回复:',
			allComments: '全部评论',
			noComment: '暂无评论',
			articleDetails: '文章详情',
			aboutUs: '关于门店',
			enterSearchContent: '输入搜索内容',
		});
		$translateProvider.preferredLanguage(lang);
		$translateProvider.useSanitizeValueStrategy('escapeParameters');

		var appInfo = angular.fromJson(localStorage.app);
		var shortUrl = '/' + localStorage.appIDKey;
		$urlRouterProvider.otherwise(shortUrl + "/index");

		//进入登录页时记录url
		function recordReurl(web_HOST) {
			if (!sessionStorage.reurl) {
				//是登录页
				if (location.href.indexOf('login') > -1) {
					sessionStorage.reurl = localStorage._host + web_HOST + '/' + localStorage.appIDKey + '/index';
					return;
				} else {
					sessionStorage.reurl = location.href;
				}
			}
		}

		$stateProvider
			//主页
			.state('index', {
				url: shortUrl + "/index",
				templateUrl: viewSrc + "home.html",
				controller: 'IndexController'
			})
			//登录
			.state('login', {
				url: shortUrl + "/login?reurl",
				templateUrl: viewSrc + "enter/login.html",
				controller: 'LoginController',
				controllerAs: 'vm',
				onEnter: function (handleURL, HOST) {
					//当没有微信返回的code时
					if (!handleURL.markValue('code') && typeof WeixinJSBridge !== 'undefined') {
						if (localStorage.wxid) {
							location.href =
								'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' + localStorage.wxid +
								'&redirect_uri=' + encodeURIComponent(localStorage._host + HOST + '/' + localStorage.appIDKey + '/login') +
								'&response_type=code&scope=snsapi_userinfo&state=STATE&' +
								'#wechat_redirect';
						} else {
							recordReurl(HOST);
						}
					} else {
						recordReurl(HOST);
					}

				}
			})
			//注册
			.state('reg', {
				url: shortUrl + "/reg?reurl",
				templateUrl: viewSrc + "enter/reg.html",
				controller: 'RegController',
				controllerAs: 'vm'
			})
			//忘记密码
			.state('forget', {
				url: shortUrl + "/forget?reurl",
				templateUrl: viewSrc + "enter/forget.html",
				controller: 'ForgetController',
				controllerAs: 'vm'
			})
			//发现
			.state('index.find', {
				url: "/find?code",
				controller: 'FindController',
				controllerAs: 'vm',
				templateUrl: viewSrc + "index/find.html",
				onEnter: function ($rootScope) {
					$rootScope.currentPage = 1;
					$rootScope.totalPage = 2;
				},
				resolve: {
					resData: function (api, APP_ID, appCache) {
						return appCache.get('indexFindCache') || api.get('/api/index/index', {
							appId: APP_ID,
							page: 1
						});
					}
				}
			})
			//促销
			.state('index.sale', {
				url: "/sale",
				controller: 'SaleController',
				controllerAs: 'vm',
				templateUrl: viewSrc + "index/sale.html",
				onEnter: function ($rootScope) {
					$rootScope.currentPage = 1;
					$rootScope.totalPage = 2;
				}
			})
			//分店
			.state('index.subshop', {
				url: "/subshop",
				controller: 'SubShopController',
				controllerAs: 'vm',
				templateUrl: viewSrc + "index/subshop.html",
				onEnter: function ($rootScope) {
					$rootScope.currentPage = 1;
					$rootScope.totalPage = 2;
				}
			})
			//分店详情
			.state('subshop-detail', {
				url: shortUrl + "/subshop-detail/:id",
				controller: 'SubShopDetailController',
				controllerAs: 'vm',
				templateUrl: viewSrc + "index/subshop-detail.html",
				resolve: {
					resData: function (api, $stateParams, appCache) {
						return appCache.get('subshopDetail' + $stateParams.id) || api.get('/api/branch/detail/' + $stateParams.id);
					}
				}
			})
			//积分商城
			.state('index.pointmall', {
				url: '/pointmall',
				controller: 'PointMallController',
				controllerAs: 'vm',
				templateUrl: viewSrc + "index/pointmall.html",
				onEnter: function ($rootScope) {
					$rootScope.currentPage = 1;
					$rootScope.totalPage = 2;
				}
			})
			//搜索
			.state('search', {
				url: shortUrl + "/search",
				controller: 'SearchController',
				controllerAs: 'vm',
				templateUrl: viewSrc + "search.html",
				onEnter: function ($rootScope) {
					$rootScope.currentPage = 1;
					$rootScope.totalPage = 2;
					$rootScope.searchtype = 1;
					$rootScope.searchtag = 0;
				},
				resolve: {
					resData: function (api, APP_ID) {
						return api.get('/api/product/list', {
							appId: APP_ID,
							pageCount: 10,
							page: 1,
							type: 1
						});
					}
				}
			})
			//购物车
			.state('car', {
				url: shortUrl + "/car?type&reurl",
				templateUrl: viewSrc + "buy/car.html",
				controller: 'CarController',
				controllerAs: 'vm',
				resolve: {
					resData: function (api, APP_ID, $stateParams) {
						if ($stateParams.type === undefined) {
							$stateParams.type = 1;
						}
						var userinfo = angular.fromJson(sessionStorage.userinfo);
						return api.get('/api/cart/list', {
							userId: userinfo.userId,
							appId: APP_ID,
							type: $stateParams.type,
							pageCount: 10,
							page: 10
						});
					}
				}
			})
			//确认订单
			.state('confirm', {
				url: shortUrl + "/confirm?tag&cartIds&cartType&productId&number&reurl",
				templateUrl: viewSrc + "buy/confirm.html",
				controller: 'ConfirmController',
				controllerAs: 'vm',
				resolve: {
					resData: function (api, $stateParams, APP_ID) {
						var userinfo = angular.fromJson(sessionStorage.userinfo);
						return api.get('/api/order/confirm', {
							userId: userinfo.userId,
							appId: APP_ID,
							tag: $stateParams.tag,
							cartIds: $stateParams.cartIds,
							cartType: $stateParams.cartType,
							productId: $stateParams.productId,
							number: $stateParams.number
						});
					}
				},
				onEnter: function ($state) {
					if (!sessionStorage.userinfo) {
						$state.go('login');
					}
					var trs = sessionStorage.reurl;
					console.log('sessionStorage.reurl：' + trs);
					if (trs && trs.indexOf('product-detail') < 0) {
						sessionStorage.reurl = location.href;
					} else {
						sessionStorage.reurl = location.href;
					}
				}
			})
			//支付二维码
			.state('qrcode', {
				url: shortUrl + "/qrcode?src&id",
				templateUrl: viewSrc + "buy/QRcode.html",
				controller: 'QrCodeController',
				controllerAs: 'vm',
				onExit: function ($rootScope, $interval) {
					$interval.cancel($rootScope.stop); //关闭定时器
				}
			})
			//重设密码
			.state('reset', {
				url: shortUrl + "/reset?reurl",
				templateUrl: viewSrc + "mine/reset.html",
				controller: 'ResetController',
				controllerAs: 'vm'
			})
			//论坛首页
			.state('community', {
				url: shortUrl + "/community",
				templateUrl: viewSrc + "community/index.html",
				controller: 'CommunityController',
				controllerAs: 'vm',
				onEnter: function ($rootScope) {
					$rootScope.currentPage = 1;
					$rootScope.totalPage = 2;
				}
			})
			//论坛子列表
			.state('community-sublist', {
				url: shortUrl + "/community-sublist?id",
				templateUrl: viewSrc + "community/sublist.html",
				controller: 'CommunitySubController',
				controllerAs: 'vm',
				onEnter: function ($rootScope) {
					$rootScope.currentPage = 1;
					$rootScope.totalPage = 2;
				}
			})
			//帖子详情
			.state('community-detail', {
				url: shortUrl + "/community-detail?id",
				templateUrl: viewSrc + "community/detail.html",
				controller: 'CommunityDetailController',
				controllerAs: 'vm',
				resolve: {
					resData: function (api, APP_ID, $stateParams, appCache) {
						return appCache.get('communityDetail' + $stateParams.id) || api.get('/api/forum/topicdetail/' + $stateParams.id);
					}
				},
				onEnter: function ($state) {
					//记录列表页URL
					if ($state.is('community-sublist')) {
						sessionStorage.reurl = location.href;
					}
				}
			})
			//发布帖子
			.state('community-edit', {
				url: shortUrl + "/community-edit",
				templateUrl: viewSrc + "community/edit.html",
				controller: 'CommunityEditController',
				controllerAs: 'vm',
				onEnter: function ($state) {
					if (!sessionStorage.userinfo) {
						$state.go('login');
					}
					var userinfo = angular.fromJson(sessionStorage.userinfo);
					if (userinfo.roleTag !== 'AppUser') {
						txtTips('仅限普通用户操作');
						$state.reload();
					}
				}
			})
			//产品主页
			.state('product', {
				url: shortUrl + "/product",
				templateUrl: viewSrc + "product/index.html",
				controller: 'ProductController',
				controllerAs: 'vm'
			})
			//产品列表
			.state('product-list', {
				url: shortUrl + "/product-list?id?name",
				templateUrl: viewSrc + "product/list.html",
				controller: 'ProductListController',
				controllerAs: 'vm',
				onEnter: function ($rootScope) {
					$rootScope.currentPage = 1;
					$rootScope.totalPage = 2;
				}
			})
			//产品详情
			.state('product-detail', {
				url: shortUrl + "/product-detail?id&reurl",
				templateUrl: viewSrc + "product/detail.html",
				controller: 'ProductDetailController',
				controllerAs: 'vm',
				resolve: {
					resData: function ($stateParams, api) {
						return api.get('/api/product/detail/' + $stateParams.id);
					}
				},
				onEnter: function ($state, $stateParams, handleURL) {
					//记录列表页URL
					if (!sessionStorage.reurl) {
						sessionStorage.reurl = location.href;
					} else {
						if (sessionStorage.reurl.indexOf('product') < 0) { //非产品URL
							sessionStorage.reurl = location.href;
						} else if (handleURL.markValue('id', sessionStorage.reurl) !== $stateParams.id) { //从不同产品列表进入
							sessionStorage.reurl = location.href;
						}
					}
				}
			})
			//全部评论
			.state('allComment', {
				url: shortUrl + "/allComment?id",
				templateUrl: viewSrc + "product/allcomment.html",
				controller: 'AllCommentController',
				controllerAs: 'vm'
			})
			//文章首页
			.state('article', {
				url: shortUrl + "/article",
				templateUrl: viewSrc + "article/index.html",
				controller: 'ArticleController',
				controllerAs: 'vm'
			})
			//文章列表
			.state('article-list', {
				url: shortUrl + "/article-list?id&name",
				templateUrl: viewSrc + "article/list.html",
				controller: 'ArticleListController',
				controllerAs: 'vm',
				resolve: {
					resData: function ($stateParams, api, appCache, APP_ID) {
						return appCache.get('articleList' + $stateParams.id) || api.get('/api/article/list', {
							appId: APP_ID,
							categoryId: $stateParams.id
						});
					}
				}
			})
			//文章详情
			.state('article-detail', {
				url: shortUrl + "/article-detail?id",
				templateUrl: viewSrc + "article/detail.html",
				controller: 'ArticleDetailController',
				controllerAs: 'vm',
				resolve: {
					resData: function ($stateParams, api, appCache) {
						return appCache.get('articleDetail' + $stateParams.id) || api.get('/api/article/detail/' + $stateParams.id);
					}
				},
				onEnter: function ($state) {
					//记录列表页URL
					if ($state.is('article-list')) {
						sessionStorage.reurl = location.href;
					}
				}
			})
			//个人中心
			.state('mine', {
				url: shortUrl + "/mine",
				templateUrl: viewSrc + "mine/index.html",
				controller: 'MineController',
				controllerAs: 'vm',
				onEnter: function ($rootScope) {
					$rootScope.currentPage = 1;
					$rootScope.totalPage = 2;
				}
			})
			//我的导购
			.state('myguide', {
				url: shortUrl + "/myguide?reurl",
				templateUrl: viewSrc + "mine/myguide.html",
				controller: 'GuideController',
				controllerAs: 'vm',
				resolve: {
					resData: function (api, appCache, APP_ID) {
						var data = {};
						var userinfo = angular.fromJson(sessionStorage.userinfo);
						if (userinfo.guideId && appCache.get('guideinfo')) {
							data = appCache.get('guideinfo');
						} else if (userinfo.guideId) {
							data = api.get('/api/branch/guideinfo', {
								appId: APP_ID,
								userId: userinfo.userId
							});
							appCache.put('guideinfo', data);
						} else {
							data = null;
						}
						return data;
					}
				}
			})

			//消息推送
			.state('message', {
				url: shortUrl + "/message",
				templateUrl: viewSrc + "mine/message.html",
				controller: 'MessageController',
				controllerAs: 'vm',
				resolve: {
					resData: function (api, appCache, APP_ID) {
						var userinfo = angular.fromJson(sessionStorage.userinfo);
						return api.get('/api/account/messagegather', {
							appId: APP_ID,
							userId: userinfo.userId
						});
					}
				}
			})
			.state('messageList', {
				url: shortUrl + "/messageList?resourceType", //用&连接多个参数
				templateUrl: viewSrc + "mine/messageList.html",
				controller: 'MessageListController',
				controllerAs: 'vm',
			})
			//选择导购
			.state('choseguide', {
				url: shortUrl + "/choseguide?reurl",
				templateUrl: viewSrc + "mine/choseguide.html",
				controller: 'GuideController',
				controllerAs: 'vm',
				resolve: {
					resData: function (api, appCache, APP_ID) {
						return appCache.get('branchList') || api.get('/api/branch/list', {
							appId: APP_ID
						});
					}
				}
			})

			//常见问题详情
			.state('problemdetail', {
				url: shortUrl + "/problemdetail?id",
				templateUrl: viewSrc + "mine/problemdetail.html",
				controller: 'ProblemDetailController',
				controllerAs: 'vm'
			})
			//个人设置
			.state('mineset', {
				url: shortUrl + "/mineset?reurl",
				templateUrl: viewSrc + "mine/mineset.html",
				controller: 'MineSetController',
				controllerAs: 'vm'
			})
			//app设置
			.state('appset', {
				url: shortUrl + "/appset",
				templateUrl: viewSrc + "mine/appset.html",
				controller: 'AppSetController',
				controllerAs: 'vm'
			})
			//收货地址
			//tag:1确认订单的选择地址
			//tag:2个人中心查看地址
			//reurl上一个页面URL路径
			.state('address', {
				url: shortUrl + "/address?tag&reurl",
				templateUrl: viewSrc + "mine/address.html",
				controller: 'AddressController',
				controllerAs: 'vm'
			})
			//新增收货地址/修改收货地址
			.state('plus-address', {
				url: shortUrl + "/plus-address?id&reurl",
				templateUrl: viewSrc + "mine/plusaddress.html",
				controller: 'PlusAddressController',
				controllerAs: 'vm'
			})
			//建议
			.state('suggest', {
				url: shortUrl + "/suggest",
				templateUrl: viewSrc + "mine/suggest.html",
				controller: 'SuggestController',
				controllerAs: 'vm',
				resolve: {
					resData: function (api, APP_ID) {
						var userinfo = angular.fromJson(sessionStorage.userinfo);
						return api.get('/api/account/advise', {
							userId: userinfo.userId,
							appId: APP_ID
						});
					}
				}
			})
			//成长值
			.state('growth', {
				url: shortUrl + "/growth",
				templateUrl: viewSrc + "mine/growth.html",
				controller: 'GrowthController',
				controllerAs: 'vm',
				onEnter: function ($rootScope) {
					$rootScope.currentPage = 1;
					$rootScope.totalPage = 2;
				}
			})
			//我的订单
			.state('myOrder', {
				url: shortUrl + "/myOrder",
				templateUrl: viewSrc + "mine/myorder.html",
				controller: 'MyOrderController',
				controllerAs: 'vm',
				onEnter: function ($rootScope) {
					$rootScope.currentPage = 1;
					$rootScope.totalPage = 2;
				}
			})
			//订单详情
			.state('order-detail', {
				url: shortUrl + "/order-detail?id",
				//url:"/order-detail",
				templateUrl: viewSrc + "mine/orderdetail.html",
				controller: 'OrderDetailController',
				controllerAs: 'vm',
				resolve: {
					resData: function (api, appCache, $stateParams) {
						return appCache.get('orderDetail' + $stateParams.id) || api.get('/api/order/detail/' + $stateParams.id);
					}
				}
			})
			//我的发帖
			.state('myCommunity', {
				url: shortUrl + "/myCommunity",
				templateUrl: viewSrc + "mine/mycommunity.html",
				controller: 'MyCommunityController',
				controllerAs: 'vm',
				onEnter: function ($rootScope) {
					$rootScope.currentPage = 1;
					$rootScope.totalPage = 2;
				}
			})
			//我的评论
			.state('myComment', {
				url: shortUrl + "/myComment",
				templateUrl: viewSrc + "mine/mycomment.html",
				controller: 'MyCommentController',
				controllerAs: 'vm',
				onEnter: function ($rootScope) {
					$rootScope.currentPage = 1;
					$rootScope.totalPage = 2;
				}
			})
			//关于我们
			.state('aboutus', {
				url: shortUrl + "/aboutus",
				templateUrl: viewSrc + "aboutus.html",
				controller: 'AboutUsController',
				resolve: {
					resData: function (api, APP_ID, appCache) {
						return appCache.get('aboutus') || api.get('/api/public/about/' + APP_ID);
					}
				}
			})
			//我的积分
			.state('mypoint', {
				url: shortUrl + "/mypoint",
				templateUrl: viewSrc + "mine/mypoint.html",
				controller: 'MyPointController',
				onEnter: function ($rootScope) {
					$rootScope.currentPage = 1;
					$rootScope.totalPage = 2;
				}
			})
			//导购角色信息
			.state('guideinformation', {
				url: shortUrl + "/guideinformation",
				templateUrl: viewSrc + "mine/guideinformation.html",
				controller: 'MineSetController'
			})
			//我的会员
			.state('mymember', {
				url: shortUrl + "/mymember",
				templateUrl: viewSrc + "mine/mymember.html",
				controller: 'MyMemberController',
				onEnter: function ($rootScope) {
					$rootScope.currentPage = 1;
					$rootScope.totalPage = 2;
				}
			})
			//立即评价
			.state('takecomments', {
				url: shortUrl + "/takecomments?orderId",
				templateUrl: viewSrc + "mine/takecomments.html",
				controller: 'TakeCommentsController',
				resolve: {
					resData: function (api, appCache, $stateParams) {
						return appCache.get('orderDetail' + $stateParams.orderId) || api.get('/api/order/detail/' + $stateParams.orderId);
					}
				}
			})
			.state('calendar', {
				url: shortUrl + "/calendar",
				templateUrl: viewSrc + "mine/calendar.html",
				controller: 'CalendarController'
			})
			.state('test', {
				url: shortUrl + "/test",
				templateUrl: viewSrc + "test.html"
			});

	}
]);

/*
 *RUN
 */
appBuilder.run(['APP_ID', 'api', '$cookies', '$state', '$rootScope', 'appCache',
	function (APP_ID, api, $cookies, $state, $rootScope, appCache) {
		loader.set(); //浮动loading图定位设置
		appCache.removeAll(); //清除缓存
		 // console.log('appid:' + APP_ID);
		localStorage._host = location.protocol + '//' + location.host;
		//用户登录
		if ($cookies.get('username') && $cookies.get('password')) {
			if (!sessionStorage.userinfo) {
				api.get('/api/account/login', {
					mobile: $cookies.get('username'),
					appId: APP_ID,
					password: $cookies.get('password')
				}, function (data) {
					$state.go('index.find');
					//存用户信息
					if (data.success) sessionStorage.setItem('userinfo', angular.toJson(data.content));
				});
			}
		} else {
			//cookie内无用户登录信息删除sessionStorage.userinfo
			sessionStorage.removeItem('userinfo');
		}
		//载入配置
		var app = angular.fromJson(localStorage.app);
		if (app === undefined || APP_ID !== app.id) {
			api.get('/api/app/info/' + APP_ID, function (data) {
				localStorage.setItem('app', angular.toJson(data.content));
				localStorage.setItem('wxid', data.content.WxAppId);
				$rootScope.apptitle = data.content.name;
			});
		} else {
			$rootScope.apptitle = app.name;
		}
		//读取用户信息
		// 	console.log(angular.fromJson(sessionStorage.userinfo));
	 //	console.log(angular.fromJson(localStorage.app));

	}
]);