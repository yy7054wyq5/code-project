var appBuilderCtr = angular.module('appBuilderCtr', [
	'ngCookies',
	'ngFileUpload',
	'me-lazyload'
]);

/**
 *基础
 */
appBuilderCtr.controller('BaseController', ['$filter', '$scope', '$rootScope', '$interval', 'api', '$state', '$stateParams', 'APP_ID',
	function ($filter, $scope, $rootScope, $interval, api, $state, $stateParams, APP_ID) {
		$rootScope.headermove = '0'; //将首页顶部菜单的滑动值放入rootScope，供全局调用
		//发送验证码
		$scope.getcodeword = $filter('translate')('GetverificationCode');
		$scope.code = function (mobile, tag) {
			if ($scope.getcodeword !== $filter('translate')('GetverificationCode')) return false;
			api.get('/api/account/captcha', {
				mobile: mobile,
				appId: APP_ID,
				tag: tag || 1
			}, function (data) {
				txtTips(data.msg);
				if (data.success) {
					var time = 60;
					var stop = $interval(function () {
						time = time - 1;
						$scope.getcodeword = $filter('translate')('overplus') + time + $filter('translate')('second');
						if (time < 0) {
							$interval.cancel(stop);
							$scope.getcodeword = $filter('translate')('GetverificationCode');
						}
					}, 1000);
				}
			});
		};
		//设置隐藏层高度
		$scope.set = function (num) {
			if (num === undefined) $scope.flag = !$scope.flag;
			else if (num == 1) $scope.flagPart = !$scope.flagPart;
			$scope.style = {
				'height': window.innerHeight
			};
		};
		//进入购物车
		$scope.goCar = function () {
			var reurl = encodeURIComponent(location.href);
			if (sessionStorage.getItem('userinfo') === null) {
				$state.go('login', {
					reurl: reurl
				});
				return;
			}
			$state.go('car', {
				reurl: reurl
			});
		};
	}
]);

/**
 *首页
 */
appBuilderCtr.controller('IndexController', ['$scope', '$state', 'appCache', function ($scope, $state, appCache) {
	appCache.remove('indexFindCache'); //清除缓存
	if (localStorage.appID) {
		$state.go('index.find');
	}
}]);

/**
 *首页--发现
 */
appBuilderCtr.controller('FindController', ['$scope', '$rootScope', 'resData', '$state', 'appCache', 'KillZero',
	function ($scope, $rootScope, resData, $state, appCache, KillZero) {
		//接收数据
		if (resData.data.success) {
			//console.log(resData);
			var indexdata = resData.data.content;
			$scope.topimgs = indexdata.locationAds[0].ads;
			$scope.centerimgs = indexdata.locationAds[1].ads;

			$scope.indexdata = {};
			//去除价格末尾的0
			$scope.indexdata.newProducts = KillZero(indexdata.newProducts);
			$scope.indexdata.hotProducts = KillZero(indexdata.hotProducts);
			$scope.indexdata.locationAds = indexdata.locationAds;

			resData.data.content = $scope.indexdata;
			appCache.put('indexFindCache', resData);

		}
	}
]);

/**
 *首页--促销
 */
appBuilderCtr.controller('SaleController', ['$scope', '$rootScope', 'api', 'APP_ID', 'appCache', '$interval', 'KillZero',
	function ($scope, $rootScope, api, APP_ID, appCache, $interval, KillZero) {

		$scope.index = 0; //菜单高亮值
		$scope.menudata = []; //滑动菜单数据

		//进入页面的默认数据缓存
		api.get('/api/product/promotion/' + APP_ID, {
			page: 1
		}, function (data) {
			if (data.success) {
				$scope.topMenu = KillZero(data.content);
			}
		});

		//选中菜单的数据
		$scope.menuActive = function (num, id) {
			jQuery(document).scrollTop(0);
			//重置
			$rootScope.currentPage = 1;
			$rootScope.totalPage = 2;
			$scope.acount = num; //菜单高亮
			$scope.index = num; //显示容器
			if (!$rootScope.saleMenuData) {
				$rootScope.saleMenuData = [];
			}
			if (appCache.get('saleMenuCache' + num)) {
				$rootScope.saleMenuData[num] = appCache.get('saleMenuCache' + num);
			} else {
				api.get('/api/product/promotionproduct/' + id, {
					page: 1,
					pageCount: 10
				}, function (data) {
					if (data.success) {
						$rootScope.saleMenuData[num] = data.content.products;
						var ajaxData = data.content.products;
						ajaxData.totalPage = data.content.pager.totalPage;
						ajaxData.currentPage = data.content.pager.currentPage;
						appCache.put('saleMenuCache' + num, ajaxData);
					}
				});
			}
		};

	}
]);

/**
 *首页--分店
 */
appBuilderCtr.controller('SubShopController', ['$scope', '$rootScope', 'api', 'APP_ID', 'appCache',
	function ($scope, $rootScope, api, APP_ID, appCache) {

		if (appCache.get('indexSubCache')) {
			$rootScope.subshopList = appCache.get('indexSubCache');
		} else {
			api.get('/api/branch/list?appId=' + APP_ID, {
				page: 1
			}, function (data) {
				if (data.success) {
					$rootScope.subshopList = data.content.branches;
					appCache.put('indexSubCache', data.content.branches);
				}
			});
		}

	}
]);

/**
 *首页--分店详情
 */
appBuilderCtr.controller('SubShopDetailController', ['$scope', '$rootScope', 'resData', 'appCache', '$stateParams',
	function ($scope, $rootScope, resData, appCache, $stateParams) {

		if (resData.data.success) {
			$scope.detail = resData.data.content;
			appCache.put('subshopDetail' + $stateParams.id, resData);
		} else {
			txtTips(resData.data.msg);
		}

	}
]);

/**
 *首页--积分商城
 */
appBuilderCtr.controller('PointMallController', ['$scope', '$rootScope', 'api', 'APP_ID', 'appCache', '$state',
	function ($scope, $rootScope, api, APP_ID, appCache, $state) {

		//未登录状态
		/*if(!sessionStorage.userinfo) {
			txtTips('请登录');
			$state.go('login',{reurl: location.href});
			return;
		}*/

		$scope.userinfo = angular.fromJson(sessionStorage.userinfo);
		if (appCache.get('creditProductsList')) {
			$rootScope.creditProductsList = appCache.get('creditProductsList');
		} else {
			api.get('/api/product/credit', {
				appId: APP_ID,
				page: 1,
				pageCount: 10
			}, function (data) {
				if (data.success) {
					$rootScope.creditProductsList = data.content.creditProducts;
					var ajaxData = data.content.creditProducts;
					ajaxData.totalPage = data.content.pager.totalPage;
					ajaxData.currentPage = data.content.pager.currentPage;
					appCache.put('creditProductsList', ajaxData);
				}
			});
		}

		//可兑换
		$scope.exchange = function () {
			if ($scope.active) {
				$scope.active = false;
				$rootScope.creditProductsList = appCache.get('creditProductsList');
			} else if (!$scope.active) {
				$scope.active = true;
				api.get('/api/product/credit', {
					appId: APP_ID,
					page: 1,
					pageCount: 10,
					userId: $scope.userinfo.userId
				}, function (data) {
					if (data.success) {
						$rootScope.creditProductsList = data.content.creditProducts;
					}
				});
			}
		};

	}
]);


/**
 *首页--搜索
 */
appBuilderCtr.controller('SearchController', ['$scope', 'api', 'resData', 'APP_ID', '$rootScope', 'KillZero',
	function ($scope, api, resData, APP_ID, $rootScope, KillZero) {

		$scope.tag2 = $scope.tag3 = $scope.tag4 = 0; //点击初始值
		$scope.classnum2 = $scope.classnum3 = $scope.classnum4 = 1; //初始样式值
		$rootScope.searchtag = 0; //记录最新的tag值
		$scope.movevalue = 0; //高亮
		$rootScope.searchtype = 1;
		$scope.distype = '产品';
		if (resData.data.success) {
			$rootScope.searchList = KillZero(resData.data.content.products);
		}

		//点击弹出产品列表
		$scope.classnum0 = 1; //产品列表的箭头向上
		$scope.ml = false; //隐藏下拉列表和遮罩层

		//下拉列表展现不同的数据
		$scope.classic = function (type) {
			$scope.ml = false;
			$rootScope.searchtype = type;
			if (type == 1) {
				$scope.distype = '产品';
			} else if (type == 3) {
				$scope.distype = '积分';
			} else if (type == 2) {
				$scope.distype = '促销';
			}
			jQuery(document).scrollTop(0);
			//清空当前页tag，清空当前有的数据
			$rootScope.currentPage = 1;
			$rootScope.searchtag = 0; //记录最新的tag值
			getList($rootScope.searchtag);
		};

		//获取数据
		// orderType: 0为降序，1为升序
		function getList(tag, order) {
			api.get('/api/product/list', {
				appId: APP_ID,
				order: order,
				type: $rootScope.searchtype,
				orderType: tag,
				pageCount: 10,
				keyword: $scope.keyword,
				page: 1,
			}, function (data) {
				if (data.success) {
					$rootScope.searchList = KillZero(data.content.products);
					console.log(data.content.products);
				} else {
					txtTips('请重试');
				}
			});
		}

		//搜索
		$scope.searchKey = function () {
			jQuery(document).scrollTop(0);
			var order = null;
			//获得当前选中的是哪个
			if ($scope.movevalue == 2) {
				order = 'updateTime';
			} else if ($scope.movevalue == 4) {
				order = 'saleCount';
			} else if ($scope.movevalue == 6) {
				order = 'price';
			}
			getList($rootScope.searchtag, order);
		};


		//orderType为0 为升序，为1为降序
		$scope.menuActive = function (num) {
			jQuery(document).scrollTop(0);
			//清空当前页tag，清空当前有的数据
			$rootScope.currentPage = 1;
			var tag = 0; //记录最新的tag值
			//分类
			if (num === 0) {
				$scope.ml = !$scope.ml;
				$scope.movevalue = 0;
			}
			//时间排序
			else if (num == 2) {
				$scope.ml = false;
				$scope.movevalue = num;
				//每次点击对应的数值+1，得出奇偶值
				$scope.tag2 = $scope.tag2 + 1;
				$rootScope.searchtag = tag = $scope.classnum2 = $scope.tag2 % 2;
				$scope.classnum4 = $scope.classnum3 = 1;
				$scope.tag4 = $scope.tag3 = 0;
				getList($rootScope.searchtag, 'updateTime');
			}
			//销量
			else if (num == 4) {
				$scope.ml = false;
				$scope.movevalue = num;
				$scope.tag3 = $scope.tag3 + 1;
				$rootScope.searchtag = tag = $scope.classnum3 = $scope.tag3 % 2;
				$scope.classnum4 = $scope.classnum2 = 1;
				$scope.tag4 = $scope.tag2 = 0;
				getList($rootScope.searchtag, 'saleCount');
			}
			//价格
			else if (num == 6) {
				$scope.ml = false;
				$scope.movevalue = num;
				$scope.tag4 = $scope.tag4 + 1;
				$rootScope.searchtag = tag = $scope.classnum4 = $scope.tag4 % 2;
				$scope.classnum3 = $scope.classnum2 = 1;
				$scope.tag3 = $scope.tag3 = 0;
				getList($rootScope.searchtag, 'price');
			}
		};

	}
]);

/**
 *用户登录
 */
appBuilderCtr.controller('LoginController', ['$scope', 'APP_ID', 'api', '$cookies', '$state', '$stateParams', 'handleURL', '$rootScope', 'appCache',
	function ($scope, APP_ID, api, $cookies, $state, $stateParams, handleURL, $rootScope, appCache) {

		if (sessionStorage.userinfo) {
			sessionStorage.removeItem('reurl');
			$state.go('index.find');
			return;
		}

		$cookies.remove('username');
		$cookies.remove('password');
		appCache.removeAll();
		$rootScope.startDate = null;
		$rootScope.endDate = null;


		//登录验证
		$scope.loginValidate = function () {
			if (!$scope.loginMobile) txtTips($filter('translate')('phoneNumber'));
			else if (!$scope.loginPassword) txtTips($filter('translate')('password'));
			else return true;
		};

		$scope.login = function () {
			if ($scope.loginValidate()) {
				api.get('/api/account/login', {
					mobile: $scope.loginMobile,
					appId: APP_ID,
					password: $scope.loginPassword,
					code: handleURL.markValue('code')
				}, function (data) {
					txtTips(data.msg);
					if (data.success) {
						//存用户信息
						sessionStorage.setItem('userinfo', angular.toJson(data.content));
						var expireDate = new Date();
						expireDate.setDate(expireDate.getDate() + 7);
						//存用户帐号密码
						$cookies.put('username', $scope.loginMobile, {
							'expires': expireDate
						});
						$cookies.put('password', $scope.loginPassword, {
							'expires': expireDate
						});
						if (!data.content.guideId && data.content.roleTag == 'AppUser') {
							$state.go('choseguide');
							return;
						}
						if ($stateParams.reurl) {
							var reurl = decodeURIComponent(decodeURIComponent($stateParams.reurl));
							if (reurl.indexOf('http') > -1) location.href = reurl;
							else $state.go(reurl);
						} else if (sessionStorage.reurl) {
							//在微信内
							if (typeof WeixinJSBridge !== 'undefined') {
								$state.go('index.find');
								sessionStorage.removeItem('reurl');
								return;
							}
							location.href = sessionStorage.reurl;
							sessionStorage.removeItem('reurl');
						} else {
							//if(sessionStorage.userinfo||$state.is('login')) $state.go('index.find');
							//else
							history.go(-1);
						}
					}
				});
			}
		};



	}
]);

/**
 *注册
 */
appBuilderCtr.controller('RegController', ['$scope', 'APP_ID', 'api', '$state', '$stateParams',
	function ($scope, APP_ID, api, $state, $stateParams) {

		//获取验证码
		$scope.getCode = function () {
			if ($scope.regValidate()) $scope.code($scope.regMobile);
		};

		//验证手机号
		$scope.checkPhone = function () {
			if ($scope.regMobile) {
				api.get('/api/account/unregisteredmobile?mobile=' + $scope.regMobile, function (data) {
					if (data.success !== 1) {
						txtTips(data.msg);
						$scope.regMobile = '';
					}
				});
			}
		};

		//注册
		$scope.reg = function () {
			if ($scope.regValidate() && $scope.regCode) {
				api.get('/api/account/unregisteredmobile?mobile=' + $scope.regMobile, function (data) {
					if (data.success) {
						api.post('/api/account/register', {
							mobile: $scope.regMobile,
							appId: APP_ID,
							nickname: $scope.regNick,
							password: $scope.regPass,
							captcha: $scope.regCode
						}, function (data) {
							txtTips(data.msg);
							if (data.success) {
								if ($stateParams.reurl) $state.go('login', {
									reurl: $stateParams.reurl
								});
								else $state.go('login');
							}
						});
					} else {
						txtTips(data.msg);
						$scope.regMobile = '';
					}
				});
			}
		};

		//注册验证
		$scope.regValidate = function () {
			if (!$scope.regMobile) txtTips('请输入11位手机号码');
			else if (!$scope.regNick) txtTips('请输入2-10位昵称');
			else if (!$scope.regPass) txtTips('请输入6-12位密码');
			else return true;
		};

	}
]);

/**
 *忘记密码
 */
appBuilderCtr.controller('ForgetController', ['$scope', 'api', '$state',
	function ($scope, api, $state) {
		//验证手机号
		$scope.checkPhone = function () {
			if ($scope.forgetMobile) {
				api.get('/api/account/unregisteredmobile?mobile=' + $scope.forgetMobile, function (data) {
					if (data.success) {
						txtTips('手机号未注册');
						$scope.forgetMobile = '';
					}
				});
			}
		};
		//获取验证码
		$scope.getCode = function () {
			if ($scope.forgetValidate()) $scope.code($scope.forgetMobile, 2);
		};

		//确定
		$scope.forget = function () {
			if ($scope.forgetValidate() && $scope.forgetCode) {
				api.post('/api/account/backpwd', {
					mobile: $scope.forgetMobile,
					password: $scope.forgetPass,
					captcha: $scope.forgetCode
				}, function (data) {
					txtTips(data.msg);
					if (data.success) $state.go('login');
				});
			}
		};

		//验证
		$scope.forgetValidate = function () {
			if (!$scope.forgetMobile) txtTips('请输入11位手机号');
			else if (!$scope.forgetPass) txtTips('请输入6-12位密码');
			else return true;
		};

	}
]);

/**
 *产品首页
 *缓存以ID为索引
 */
appBuilderCtr.controller('ProductController', ['$scope', '$state', 'appCache', 'api', 'APP_ID', 'KillZero', '$rootScope',
	function ($scope, $state, appCache, api, APP_ID, KillZero, $rootScope) {

		jQuery('.list-right').height(jQuery('.dl-body').height()); //品类左导航的高度
		jQuery('.list-left').css('height', window.innerHeight - window.rem / window.dpr);
		//获取品类级数
		var app = angular.fromJson(localStorage.app);
		$scope.productLevel = app.productLevel;
		//没有分类跳转列表页
		if (app.productLevel === 0) {
			$state.go('product-list');
			return;
		}

		//获取一级分类
		if (appCache.get('categoryTop')) {
			$scope.categoryTop = appCache.get('categoryTop');
			if ($scope.productLevel == 1) {
				$scope.hackStyle = {
					'height': 1.1 + 'rem'
				};
				$scope.topMenu = appCache.get('categoryTop');
				$rootScope.productList = appCache.get('productIndexList' + appCache.get('categoryTop')[0].id);
			}
		} else {
			api.get('/api/product/category', {
				appId: APP_ID
			}, function (data) { //获取1级分类
				if (data.success) {
					$scope.categoryTop = data.content;
					appCache.put('categoryTop', data.content);
					appCache.put('categoryChildren0', data.content[0].children);
					if ($scope.productLevel == 1) {
						$scope.hackStyle = {
							'height': 1.1 + 'rem'
						};
						$scope.topMenu = data.content;
						data.content[0].products = KillZero(data.content[0].products);
						$rootScope.productList = data.content[0].products;
						appCache.put('productIndexList' + data.content[0].id, data.content[0].products);
					}
				}
			});
		}

		//获取子分类以及高亮一级分类
		$scope.index = 0;
		$scope.categorychildren = [];
		$scope.menuActive = function (num, id) {
			//层级为1的分类
			if ($scope.productLevel == 1) {
				$scope.acount = num;
				if (appCache.get('productIndexList' + id)) {
					$rootScope.productList = appCache.get('productIndexList' + id);
					$rootScope.currentPage = appCache.get('productIndexList' + id).currentPage;
					$rootScope.totalPage = appCache.get('productIndexList' + id).totalPage;
				} else {
					$rootScope.currentPage = 1;
					$rootScope.totalPage = 2;
					api.get('/api/product/list', {
						appId: APP_ID,
						categoryId: id,
						page: 1,
						pageCount: 10
					}, function (data) {
						if (data.success) {
							data.content.products = KillZero(data.content.products);
							$rootScope.productList = data.content.products;
							appCache.put('productIndexList' + id, data.content.products);
						}
					});
				}
			} else {
				$scope.index = num;
				if (appCache.get('categoryChildren' + num) === undefined) {
					api.get('/api/product/childcategory?appId=' + APP_ID + '&categoryId=' + id + '', function (data) {
						if (data.success) {
							$scope.categorychildren[num] = KillZero(data.content);
							appCache.put('categoryChildren' + num, $scope.categorychildren[num]);
						}
					});
				} else {
					$scope.categorychildren[num] = appCache.get('categoryChildren' + num);
				}
			}
		};

	}
]);

/**
 *产品列表页
 */
appBuilderCtr.controller('ProductListController', ['$scope', 'appCache', '$stateParams', 'api', 'APP_ID', '$cookies', '$rootScope',
	function ($scope, appCache, $stateParams, api, APP_ID, $cookies, $rootScope) {

		//获取数据
		if (appCache.get('productListCache' + $stateParams.id)) {
			$rootScope.productList = appCache.get('productListCache' + $stateParams.id);
		} else {
			//没有产品分类又产品主页直接进入列表页
			if ($stateParams.id === undefined) {
				api.get('/api/product/list?appId=' + APP_ID, {
					page: 1,
					pageCount: 10
				}, function (data) {
					if (data.success) {
						$rootScope.productList = data.content.products;
						appCache.put('productListCache', data.content.products);
					}
				});
			} else {
				api.get('/api/product/list?appId=' + APP_ID + '&categoryId=' + $stateParams.id, {
					page: 1,
					pageCount: 10
				}, function (data) {
					if (data.success) {
						$scope.listName = $stateParams.name;
						$rootScope.productList = data.content.products;
						appCache.put('productListCache' + $stateParams.id, data.content.products);
					}
				});
			}
		}

	}
]);

/**
 *产品详情
 */
appBuilderCtr.controller('ProductDetailController', ['$rootScope', '$scope', '$stateParams', 'api', '$sce', 'resData', '$cookies', '$state', 'APP_ID', 'appCache', 'KillZero',
	function ($rootScope, $scope, $stateParams, api, $sce, resData, $cookies, $state, APP_ID, appCache, KillZero) {
		jQuery(window).scrollTop(0);
		var specInfo = resData.data.content.specInfo; //规格表
		var specs = resData.data.content.specs.split(','); //规格所属ID
		var specValues = resData.data.content.specValues.split(','); //规格所属ID对应的value
		var productSpecs = '1件';
		window.hasSize = true;
		if (specInfo) {
			productSpecs = ' ';
			//在规格表内查出对应的文字
			for (var j = 0; j < specInfo.length; j++) {
				currentSpec = specs[j];
				currentSpecValue = specValues[j];
				if (currentSpec == specInfo[j].specId) {
					for (var k = 0; k < specInfo[j].specValues.length; k++) {
						if (currentSpecValue == specInfo[j].specValues[k].specValueId) {
							productSpecs += specInfo[j].specValues[k].specValueName + ',';
						}
					}
				}
			}
			productSpecs = productSpecs.substring(0, productSpecs.length - 1);
			if (productSpecs.length > 10) {
				productSpecs = productSpecs.substring(0, 9) + '...,1件';
			} else {
				productSpecs = productSpecs + ',1件';
			}
		}
		//已选中规格
		// if($cookies.get('chosedSize')&&$cookies.get('productID')==$stateParams.id){
		// 	$scope.chosedSize = $sce.trustAsHtml($cookies.get('chosedSize'));
		// }else{
		// 	$scope.chosedSize = $sce.trustAsHtml('<span>默认规格</span><span class="chosed">'+productSpecs+'</span><i></i>');
		// }
		//默认规格
		$scope.chosedSize = $sce.trustAsHtml('<span>默认规格</span><span class="chosed">' + productSpecs + '</span><i></i>');
		$rootScope.productSpecs = productSpecs.substr(productSpecs.length - 2, 1); //获取产品数量
		//获取数据
		if (resData.data.success) {
			//去0
			if (resData.data.content.price) {
				resData.data.content.price = KillZero(resData.data.content.price);
			}
			if (resData.data.content.promotionPrice) {
				resData.data.content.promotionPrice = KillZero(resData.data.content.promotionPrice);
			}

			$scope.detail = resData.data.content;
			console.log($scope.detail);

			//产品图文详情
			$scope.allDetail = $sce.trustAsHtml($scope.detail.detail);
		}

		//加入购物车
		$scope.addCar = function () {
			if (!sessionStorage.userinfo) {
				txtTips('请登录');
				$state.go('login', {
					reurl: location.href
				});
				return;
			}
			var userinfo = angular.fromJson(sessionStorage.userinfo);
			if (userinfo.roleTag !== 'AppUser') {
				txtTips('仅限普通用户操作');
				return;
			}
			var j_countBox = jQuery('.count-box');
			jQuery('body').removeAttr('style');
			acar(j_countBox.data('id') || $stateParams.id, j_countBox.data('num'));
		};

		//立即购买
		$scope.buyNow = function () {
			// console.log($rootScope.maxcount);
			// console.log($rootScope.count);
			// console.log($rootScope.chosedSize);
			// console.log($rootScope.productSpecs);
			//产品是否能购买
			if ($rootScope.maxcount < $rootScope.count || $rootScope.maxcount < $rootScope.chosedSize || $rootScope.maxcount < $rootScope.productSpecs) {
				$state.reload('product-detail', {
					reurl: 'product-detail?id=' + $stateParams.id
				});
				txtTips('库存不足');
				return;
			}
			if (!window.hasSize) {
				txtTips('没有该规格的产品');
				return;
			}
			jQuery('body').removeAttr('style');
			var j_countBox = jQuery('.count-box');
			var userinfo = angular.fromJson(sessionStorage.userinfo);
			if (!sessionStorage.userinfo) {
				txtTips('请登录');
				$state.go('login', {
					reurl: location.href
				});
			} else if (userinfo.roleTag !== 'AppUser') {
				txtTips('仅限普通用户操作');
				return;
			} else if (userinfo.guideId === '') {
				txtTips('请先绑定导购');
				$state.go('choseguide', {
					reurl: 'product-detail?id=' + $stateParams.id
				});
			} else {
				//当前产品已选规格
				$state.go('confirm', {
					tag: 2,
					productId: j_countBox.data('id') || $stateParams.id,
					number: j_countBox.data('num') || 1
				});
			}

		};
		var userinfo = angular.fromJson(sessionStorage.userinfo);
		//加入购物车
		function acar(productId, number) {
			//未登录状态
			if (!sessionStorage.userinfo) {
				txtTips('请登录');
				$state.go('login', {
					reurl: encodeURIComponent(location.href)
				});
			} else if (parseInt(number) === 0) {
				txtTips('数量不能为0');
				return;
			} else if (!window.hasSize) {
				//该值是用来判断是否可以购买的
				txtTips('没有该规格的产品');
				return;
			}
			var userinfo = angular.fromJson(sessionStorage.userinfo);
			api.post('/api/cart/set', {
				userId: userinfo.userId,
				appId: APP_ID,
				productId: parseInt(productId),
				number: parseInt(number) || 1,
				tag: 1
			}, function (data) {
				txtTips(data.msg);
				if (data.success) {
					txtTips('加入购物车成功');
				}
			});
		}

		//妈蛋，在指令内操作不了，没的法的
		$scope.hidesendproduct = function () {
			//隐藏浮层
			jQuery('body').removeAttr('style');
			jQuery('.show-send-product').css({
				left: '-10rem'
			});
		};

		//重新获取一次APP信息
		api.get('/api/app/info/' + APP_ID, function (data) {
			if (data.success) {
				localStorage.setItem('app', angular.toJson(data.content));
			}
		});
	}
]);

/**
 *产品详情的全部评论
 */
appBuilderCtr.controller('AllCommentController', ['$scope', 'api', 'appCache', 'APP_ID', '$stateParams', '$rootScope',
	function ($scope, api, appCache, APP_ID, $stateParams, $rootScope) {
		if (appCache.get('AllProductComment' + $stateParams.id)) {
			$rootScope.AllProductComment = appCache.get('AllProductComment' + $stateParams.id);
		} else {
			api.get('/api/product/comment', {
				appId: APP_ID,
				productId: $stateParams.id,
				page: 1,
				pageCount: 10
			}, function (data) {
				if (data.success) {
					$rootScope.AllProductComment = data.content.comments;
					var ajaxData = data.content.comments;
					ajaxData.totalPage = data.content.pager.totalPage;
					ajaxData.currentPage = data.content.pager.currentPage;
					ajaxData.cnt = data.content.cnt;
					appCache.put('AllProductComment' + $stateParams.id, ajaxData);
				}
			});
		}
	}
]);

/**
 *论坛
 */
appBuilderCtr.controller('CommunityController', ['$scope', '$state', 'api', 'APP_ID', 'appCache', '$rootScope',
	function ($scope, $state, api, APP_ID, appCache, $rootScope) {

		var userinfo = angular.fromJson(sessionStorage.userinfo);
		var userId = typeof userinfo == 'undefined' ? 0 : userinfo.userId;

		if (appCache.get('communityIndexCache')) {
			$rootScope.communityList = appCache.get('communityIndexCache');
		} else {
			api.get('/api/forum/list?appId=' + APP_ID + '&userId=' + userId, {
				page: 1,
				pageCount: 10
			}, function (data) {
				if (data.success) {
					$rootScope.communityList = data.content.forums;
					var ajaxData = data.content.forums;
					ajaxData.totalPage = data.content.pager.totalPage;
					ajaxData.currentPage = data.content.pager.currentPage;
					appCache.put('communityIndexCache', ajaxData);
				}
			});
		}

	}
]);

/**
 *论坛次级列表
 */
appBuilderCtr.controller('CommunitySubController', ['$state', '$scope', '$cookies', 'appCache', '$stateParams', '$rootScope', 'api', 'APP_ID',
	function ($state, $scope, $cookies, appCache, $stateParams, $rootScope, api, APP_ID) {

		if (appCache.get('communityListCache' + $stateParams.id)) {
			$rootScope.topicsList = appCache.get('communityListCache' + $stateParams.id);
			console.log($rootScope.topicsList);
			console.log("$rootScope.topicsList");
			$scope.forumInfo = appCache.get('communityListInfo' + $stateParams.id);
		} else {
			api.get('/api/forum/topics?appId=' + APP_ID + '&forumId=' + $stateParams.id, {
				page: 1,
				pageCount: 10,
				tag: 1
			}, function (data) {
				if (data.success) {
					$rootScope.topicsList = data.content.topics;
					$rootScope.totalPage = data.content.pager.totalPage;
					console.log($rootScope.topicsList);
					console.log("$rootScope.topicsList");
					$scope.forumInfo = data.content.forumInfo;
					console.log($scope.forumInfo);
					$cookies.put('forumID', $scope.forumInfo.id);
					appCache.put('communityListCache' + $stateParams.id, data.content.topics);
					appCache.put('communityListInfo' + $stateParams.id, data.content.forumInfo);
				}
			});
		}
		//发帖时用户是否已登录
		$scope.sendMessage = function () {
			if (!sessionStorage.userinfo) {
				$state.go('login');
			} else {
				$state.go('community-edit');
			}
		};
	}
]);

/**
 *帖子详情
 */
appBuilderCtr.controller('CommunityDetailController', ['$scope', 'resData', '$cookies', 'appCache', '$stateParams', '$sce', '$http', 'APP_ID', 'api', '$state', 'handleUserInfo',
	function ($scope, resData, $cookies, appCache, $stateParams, $sce, $http, APP_ID, api, $state, handleUserInfo) {
		$scope.userinfo = angular.fromJson(sessionStorage.userinfo);
		var forumId;
		if (resData.data.success) {
			$scope.detail = resData.data.content;
			console.log($scope.detail);
			console.log("$scope.detail");
			/*console.log($scope.detail);
			//console.log(nickname);
			if($scope.detail.nickname.length>7){
				$scope.detail.nickname=$scope.detail.nickname.substring(0,7)+'...';
			}*/
			//console.log($scope.detail);
			$scope.thumbs = '';
			//显示点赞人(人数少于20)
			angular.forEach(resData.data.content.thumbs, function (val, index) {
				if (val.nickname !== null) {
					if (index < 20) {
						$scope.thumbs += val.nickname + ',';
					}
				}
			});
			//显示点赞人(人数少于20)，多的打省略号
			if (resData.data.content.thumbs.length > 20) {
				$scope.thumbs = $scope.thumbs.substring(0, $scope.thumbs.length - 1) + '...';
			} else {
				$scope.thumbs = $scope.thumbs.substring(0, $scope.thumbs.length - 1);
			}
			$scope.word = $sce.trustAsHtml($scope.detail.detail);
			appCache.put('communityDetail' + $stateParams.id, resData);
			forumId = resData.data.content.forumId;
			// $scope.zan = true;
		}

		//获取评论
		$scope.discomment = 0;
		api.get('/api/comment/list', {
			appId: APP_ID,
			resourceType: 2,
			resourceId: $scope.detail.id
		}, function (data) {
			if (data.success) {
				$scope.discomment = 1;
				$scope.detail.commentCount = data.content.comments.length;
				$scope.comments = data.content.comments;
			}
		});

		//发表评论
		$scope.sendConment = function (id) {
			console.log(jQuery(".txa").val());
			$scope.communityConment = jQuery(".txa").val();
			var userinfo = angular.fromJson(sessionStorage.userinfo);
			//未登录状态
			if (!sessionStorage.userinfo) {
				txtTips('请登录');
				$state.go('login', {
					reurl: location.href
				});
				return;
			} else if (userinfo.roleTag !== 'AppUser') {
				txtTips('仅限普通用户操作');
				return;
			} else if (!$scope.communityConment) {
				txtTips('请输入评论');
				return;
			}
			api.post('/api/comment/publish', {
				appId: APP_ID,
				resourceType: 2,
				resourceId: id,
				content: $scope.communityConment,
				userId: userinfo.userId
			}, function (data) {
				//txtTips.tips(data.msg);
				if (data.success) {
					//更新本地用户信息
					handleUserInfo.update();
					appCache.remove('myCommunityComment');
					appCache.remove('communityDetail' + $stateParams.id);
					appCache.remove('communityListCache' + forumId);
					appCache.remove('communityListInfo' + forumId);
					$state.reload('community-detail', {
						id: $stateParams.id
					});
				}
			});
		};

		//点赞
		$scope.clickZan = function (id) {
			var userinfo = angular.fromJson(sessionStorage.userinfo);
			//未登录状态
			if (!sessionStorage.userinfo) {
				txtTips('请登录');
				$state.go('login', {
					reurl: location.href
				});
				return;
			} else if (userinfo.roleTag !== 'AppUser') {
				txtTips('仅限普通用户操作');
				return;
			}
			api.post('/api/forum/thumbtopic', {
				topicId: id,
				userId: userinfo.userId,
				appId: APP_ID
			}, function (data) {
				if (data.success) {
					//移除详情缓存
					appCache.remove('communityDetail' + $stateParams.id);
					appCache.remove('communityListCache' + forumId);
					appCache.remove('communityListInfo' + forumId);
					$state.reload('community-detail', {
						id: $stateParams.id
					});
				}
			});
		};

	}
]);

/**
 *发布帖子
 */
appBuilderCtr.controller('CommunityEditController', ['$scope', 'Upload', '$cookies', '$state', 'api', 'APP_ID', 'appCache', 'handleUserInfo',
	function ($scope, Upload, $cookies, $state, api, APP_ID, appCache, handleUserInfo) {

		//未登录状态
		if (!sessionStorage.userinfo) {
			txtTips('请登录');
			$state.go('login');
			return;
		}

		//上传图片
		$scope.thumb = [];
		$scope.uploadFiles = function (files, errFiles) {
			$scope.files = files;
			if (errFiles[0]) {
				//txtTips(errFiles[0].name+'的大小超过了'+errFiles[0].$errorParam);
				txtTips('图片大小超过了' + errFiles[0].$errorParam);
			}
			angular.forEach(files, function (file) {
				file.upload = Upload.upload({
					url: '/image/upload?type=5',
					data: {
						file: file
					}
				});
				loader.open();
				file.upload.then(function (resp) {
					if (resp.data.status == 'success') {
						loader.close();
						$scope.hidespan = true;
						$scope.thumb.push({
							"imagePath": resp.data.path,
							"imgName": resp.config.data.file.name,
							"id": resp.data.picKey
						});
					}
				}, function (resp) {
					console.log('Error status: ' + resp.status);
				}, function (evt) {
					$scope.progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
				});
			});
		};

		//删除已上传图片
		$scope.removeItem = function (id) {
			if ($scope.thumb.length > 0) {
				angular.forEach($scope.thumb, function (value, key) {
					if (parseInt(id) == value.id) {
						$scope.thumb.splice(key, 1); //删除数据
					}
					if ($scope.thumb.length === 0) {
						$scope.hidespan = false;
					}
				});
			}
		};

		//发布
		$scope.sub = function () {
			if (!$scope.title) {
				txtTips('标题不能为空');
				return;
			} else if (!$scope.des) {
				txtTips('内容不能为空');
				return;
			} else if ($scope.thumb.length > 9) {
				txtTips('图片最多上传9张');
				return;
			}
			var img = '';
			angular.forEach($scope.thumb, function (value, key) {
				img = img + ',' + value.id;
			});
			var userinfo = angular.fromJson(sessionStorage.userinfo);
			api.post('/api/forum/create', {
				appId: APP_ID,
				name: $scope.title,
				forumId: $cookies.get('forumID'), //进入论坛列表的时候获取ID
				userId: userinfo.userId,
				detail: $scope.des,
				albumImages: img.substring(1, img.length)
			}, function (data) {
				if (data.success) {
					txtTips('发布成功');
					//更新本地用户信息
					handleUserInfo.update();
					//删除帖子列表缓存
					appCache.remove('communityListCache' + $cookies.get('forumID'));
					appCache.remove('communityListInfo' + $cookies.get('forumID'));
					appCache.remove('myCommunity');
					$state.go('community-sublist', {
						id: $cookies.get('forumID')
					});
				}
			});
		};

	}
]);

/**
 *文章
 *该页缓存索引是ID值，因为涉及的层级为3层且结构大不相同
 */
appBuilderCtr.controller('ArticleController', ['$scope', 'api', 'APP_ID', 'appCache', '$state',
	function ($scope, api, APP_ID, appCache, $state) {

		jQuery('.article-main').css('min-height', window.innerHeight);
		var app = angular.fromJson(localStorage.app);

		$scope.articleLevel = app.articleLevel;
		$scope.navindex = 0; //顶部菜单高亮

		//顶部滑动菜单数据
		if (appCache.get('articleCategory')) {
			$scope.navMenu = appCache.get('articleNavCategory');
		} else {
			//文章层级为0
			if ($scope.articleLevel === 0) {
				//顶部菜单
				$scope.navMenu = [];
				$scope.listStyle = {
					'margin-top': 1.2 + 'rem'
				};
				if (appCache.get('articleIndexListData')) {
					$scope.MenuArticleList = appCache.get('articleIndexListData');
				} else {
					loadArticleList();
				}
				return;
			}
			api.get('/api/article/category?appId=' + APP_ID, function (data) {
				if (data.success) {
					//顶部菜单
					$scope.navMenu = data.content;
					console.log($scope.navMenu);
					appCache.put('articleNavCategory', $scope.navMenu);
					//文章层级为1
					if ($scope.articleLevel == 1) {
						$scope.listStyle = {
							'margin-top': 1.5 + 'rem'
						};
						$scope.MenuArticleList = data.content[0].articles;
						appCache.put('articleIndexListData' + data.content[0].id, data.content[0].articles);
					}
					//文章层级为2
					else if ($scope.articleLevel == 2) {
						$scope.listStyle = {
							'margin-top': 2.5 + 'rem'
						};
						$scope.topMenu = data.content[0].children; //二级菜单
						appCache.put('articleMenuData' + $scope.navMenu[0].id, $scope.navMenu[0].children); //第一个二级菜单数据
						//加载文章列表
						api.get('/api/article/list?categoryId=' + $scope.navMenu[0].children[0].id + '&appId=' + APP_ID, {
							page: 1,
							pageCount: 10
						}, function (data) {
							if (data.success) {
								putDataPager('articleIndexListData', data, $scope.navMenu[0].children[0].id);
								$scope.MenuArticleList = data.content.articles;
							}
						});
					}
					//文章层级为3
					else if ($scope.articleLevel == 3) {
						appCache.put('articleMenuData' + $scope.navMenu[0].id, $scope.navMenu[0].children); //三级菜单第一个菜单的内容
					}
				}
			});
		}
		//
		//一级菜单的操作
		//
		$scope.navActive = function (num, id) {
			$scope.anavcount = num;
			if ($scope.articleLevel == 1) {
				if (appCache.get('articleIndexListData' + id)) {
					//文章列表数据
					$scope.MenuArticleList = appCache.get('articleIndexListData' + id);
				} else {
					api.get('/api/article/list', {
						appId: APP_ID,
						categoryId: id,
						page: 1,
						pageCount: 10
					}, function (data) {
						if (data.success) {
							$scope.MenuArticleList = data.content.articles;
							putDataPager('articleIndexListData', data, id);
						}
					});
				}
			}
			//二级菜单
			else if ($scope.articleLevel == 2) {
				$scope.acount = 0;
				if (appCache.get('articleMenuData' + id)) {
					//二级横向菜单数据
					$scope.topMenu = appCache.get('articleMenuData' + id);
					//加载二级菜单中第一个选项的文章列表数据
					loadArticleList($scope.topMenu[0].id);
				} else {
					api.get('/api/article/childcategory?categoryId=' + id + '&appId=' + APP_ID, function (data) {
						if (data.success) {
							$scope.topMenu = data.content;
							if (!$scope.topMenu) {
								txtTips('没有相应的二级分类');
								$scope.MenuArticleList = [];
								return;
							}
							//加载二级菜单中第一个选项的文章列表数据
							loadArticleList($scope.topMenu[0].id);
							appCache.put('articleMenuData' + id, data.content);
							//当文章层级为2级和3级的时候，这里并没有返回具体的文章列表
						}
					});
				}
			}
			//三级菜单
			else if ($scope.articleLevel == 3) {
				if (appCache.get('articleMenuData' + id)) {
					//三级菜单数据
					$scope.navdata = appCache.get('articleMenuData' + id);
				} else {
					api.get('/api/article/childcategory?categoryId=' + id + '&appId=' + APP_ID, function (data) {
						if (data.success) {
							$scope.navdata = [];
							if (data.content) {
								$scope.navdata = data.content;
								appCache.put('articleMenuData' + id, data.content);
							}
						}
					});
				}
			}
		};

		//
		//二级菜单的操作
		//
		$scope.menuActive = function (num, id) {
			$scope.acount = num;
			loadArticleList(id);
		};

		//根据层级判断是去什么页面
		$scope.goArticle = function (id) {
			console.log('文章ID：' + id);
			if ($scope.articleLevel == 2) {
				$state.go('article-detail', {
					id: id
				});
			} else {
				$state.go('article-list', {
					id: id
				});
			}
		};

		//加载文章列表
		function loadArticleList(id) {
			//0级分类无分类ID
			if (!id) {
				id = '';
			}
			if (appCache.get('articleIndexListData' + id)) {
				$scope.MenuArticleList = appCache.get('articleIndexListData' + id);
			} else {
				api.get('/api/article/list?categoryId=' + id + '&appId=' + APP_ID, function (data) {
					if (data.success) {
						putDataPager('articleIndexListData', data, id);
						$scope.MenuArticleList = data.content.articles;
					}
				});
			}
		}

		//将页码和数据合成对象并存入缓存
		function putDataPager(cacheName, data, id) {
			var trs = {};
			trs = data.content.articles;
			trs.totalPage = data.content.pager.totalPage;
			trs.currentPage = data.content.pager.currentPage;
			appCache.put(cacheName + id, trs);
		}

	}
]);

/**
 *文章列表
 */
appBuilderCtr.controller('ArticleListController', ['$scope', 'api', 'APP_ID', 'appCache', 'resData', '$stateParams',
	function ($scope, api, APP_ID, appCache, resData, $stateParams) {

		if (resData.data.success) {
			$scope.listData = resData.data.content.articles;
			$scope.listName = $stateParams.name;
			appCache.put('articleList' + $stateParams.id, resData);
		}

	}
]);

/**
 *文章详情
 */
appBuilderCtr.controller('ArticleDetailController', ['$scope', 'api', 'APP_ID', 'appCache', '$stateParams', 'resData', '$sce', '$state', '$http',
	function ($scope, api, APP_ID, appCache, $stateParams, resData, $sce, $state, $http) {
		var userinfo;

		if (resData.data.success) {
			$scope.detail = resData.data.content;
			$scope.word = $sce.trustAsHtml($scope.detail.detail);
		}

		//获取评论
		$scope.discomment = 0;
		api.get('/api/comment/list', {
			appId: APP_ID,
			resourceType: 1,
			resourceId: $scope.detail.id
		}, function (data) {
			if (data.success) {
				$scope.discomment = 1;
				$scope.detail.commentCount = data.content.comments.length;
				$scope.comments = data.content.comments;
			}
		});

		//登录提示
		$scope.tips = function () {
			//未登录状态
			if (sessionStorage.getItem('userinfo') === null) {
				txtTips('评论需要登录');
				$state.go('login', {
					reurl: location.href
				});
				return;
			}
		};

		//发表评论
		$scope.sendConment = function (id) {
			var userinfo = angular.fromJson(sessionStorage.userinfo);
			if (!$scope.articleConment) {
				txtTips('请输入评论');
				return;
			} else if (userinfo.roleTag !== 'AppUser') {
				txtTips('仅限普通用户操作');
				return;
			}
			api.post('/api/comment/publish', {
				appId: APP_ID,
				resourceType: 1,
				resourceId: id,
				content: $scope.articleConment,
				userId: userinfo.userId
			}, function (data) {
				if (data.success) {
					appCache.remove('myArticleComment');
					$state.reload('article-detail', {
						id: $stateParams.id
					});
				}
			});
		};

	}
]);
/**
消息推送汇总
**/
appBuilderCtr.controller('MessageController', ['$state', '$scope', 'api', 'APP_ID', 'resData', 'appCache', '$stateParams',
	function ($state, $scope, api, APP_ID, resData, appCache, $stateParams) {
		$scope.userinfo = angular.fromJson(sessionStorage.userinfo);
		jQuery('.message-total').css('height', window.innerHeight);
		//获取消息汇总表
		if (resData.data.success) {
			$scope.messageTotal = resData.data.content;
			$scope.leftWidth = 0;
		}
		//获取时间格式为年月日
		angular.forEach($scope.messageTotal, function (val) {
			if (val.updateTime) {
				val.updateTime = val.updateTime.substring(0, 10);
			}
		});
		//左右滑动
		$scope.scrollleft = function (data) {
			console.log(data);
			if (data == 1) {
				$scope.leftWidth1 = -1.7;
			} else if (data == 2) {
				$scope.leftWidth2 = -1.7;
			} else if (data == 3) {
				$scope.leftWidth3 = -1.7;
			}

		};
		$scope.scrollright = function (data) {
			if (data == 1) {
				$scope.leftWidth1 = 0;
			} else if (data == 2) {
				$scope.leftWidth2 = 0;
			} else if (data == 3) {
				$scope.leftWidth3 = 0;
			}
		};
		//删除消息
		$scope.deleteMessage = function (resourceType) {
			api.get('/api/account/deletemessage', {
				resourceType: resourceType,
				appId: APP_ID,
				userId: $scope.userinfo.userId
			}, function (data) {
				if (data.success) {
					$state.reload('message');

				}

			});
		};
	}
]);

/**
消息列表
**/
appBuilderCtr.controller('MessageListController', ['$state', '$scope', 'api', 'APP_ID', 'appCache', '$stateParams',
	function ($state, $scope, api, APP_ID, appCache, $stateParams) {
		var userinfo = angular.fromJson(sessionStorage.userinfo);
		$scope.resourceType = $stateParams.resourceType;
		jQuery('.List').css('height', window.innerHeight);
		api.get('/api/account/messages', {
			appId: APP_ID,
			userId: userinfo.userId,
			resourceType: $stateParams.resourceType //$stateParams.xxx接受路由传的参数
		}, function (data) {
			$scope.messageList = data.content.messages;
			angular.forEach($scope.messageList, function (val) {
				if (val.updateTime) {
					val.updateTime = val.updateTime.substring(0, 10);
				}
			});
		});

	}
]);
/**
 *个人中心主页
 */
appBuilderCtr.controller('MineController', ['$scope', '$state', 'api', 'APP_ID', '$cookies', 'appCache', '$rootScope',
	function ($scope, $state, api, APP_ID, $cookies, appCache, $rootScope) {
		$(window).scrollTop(0);

		//未登录状态
		if (!sessionStorage.userinfo) {
			$state.go('login');
			return;
		}

		//消息推送图片是否显示

		$scope.userinfo = angular.fromJson(sessionStorage.userinfo);
		var app = angular.fromJson(localStorage.app);
		$scope.isPush = app.isPush;
		// console.log(app);
		/*api.get('/api/account/messagegather',{
			appId: APP_ID,
			userId: $scope.userinfo.userId
		},function(data){
			if(data.success){
				jQuery("div.btn i:last-child").addClass('msg');
			}else{
				jQuery("div.btn i:last-child").removeClass('msg');
			}	
	
		});*/

		$scope.dismine = 1; //显示布局
		jQuery('.mine-main').css('min-height', jQuery(window).height() - jQuery('footer').height());
		//获取最新用户信息
		api.get('/api/account/userinfo', {
			appId: APP_ID,
			userId: $scope.userinfo.userId
		}, function (data) {
			if (data.success) {
				$scope.userinfo = data.content;
				sessionStorage.userinfo = angular.toJson(data.content);
			}
		});
		$scope.app = angular.fromJson(localStorage.app);
		getRoleMoney();

		//显示最近更新时间
		function updateTimeRole() {
			var updateTime = new Date();
			var hours = updateTime.getHours();
			var minutes = updateTime.getMinutes();
			//首位加0
			if (hours < 10) hours = '0' + hours.toString();
			else if (minutes < 10) minutes = '0' + minutes.toString();
			return hours + ':' + minutes;
		}

		function getRoleMoney(payState) {
			//门店管理员明细
			if ($scope.userinfo.roleTag == 'BranchAdmin') {
				if (appCache.get('roleRecords')) {
					$rootScope.records = appCache.get('roleRecords');
					$rootScope.sum = appCache.get('roleRecords').sum;
					$scope.roleUpdateTime = updateTimeRole();
					$scope.tag = $rootScope.tag;
				} else {
					api.get('/api/order/list', {
						type: 2,
						userId: $scope.userinfo.userId,
						appId: APP_ID,
						tag: 1,
						payState: payState || -1,
						page: 1,
						pageCount: 10,
						timeEnd: $rootScope.timeEnd,
						timeStart: $rootScope.timeStart
					}, function (data) {
						if (data.success) {
							$rootScope.records = data.content.orders;
							$rootScope.sum = data.content.sum;
							var ajaxData = data.content.orders;
							ajaxData.sum = data.content.sum;
							ajaxData.currentPage = data.content.currentPage;
							ajaxData.totalPage = data.content.totalPage;
							appCache.put('roleRecords', ajaxData);
							$scope.roleUpdateTime = updateTimeRole();
							$scope.tag = 1;
						}
					});
				}
			}
			//店长、导购、收银员的明细
			else if ($scope.userinfo.group !== 'CommonUser') {
				if (appCache.get('roleRecords')) {
					$rootScope.records = appCache.get('roleRecords');
					$rootScope.sum = appCache.get('roleRecords').sum;
					$scope.roleUpdateTime = updateTimeRole();
				} else {
					api.get('/api/account/deduct', {
						userId: $scope.userinfo.userId,
						appId: APP_ID,
						page: 1,
						pageCount: 10,
						timeEnd: $rootScope.timeEnd,
						timeStart: $rootScope.timeStart
					}, function (data) {
						if (data.success) {
							$rootScope.records = data.content.records;
							$rootScope.sum = data.content.sum;
							var ajaxData = data.content.records;
							ajaxData.sum = data.content.sum;
							ajaxData.currentPage = data.content.pager.currentPage;
							ajaxData.totalPage = data.content.pager.totalPage;
							appCache.put('roleRecords', ajaxData);
							$scope.roleUpdateTime = updateTimeRole();
							$scope.tag = 1;
						}
					});
				}
			}
		}

		//我的导购
		$scope.goGuide = function () {
			if ($scope.userinfo.guideId) {
				$state.go('myguide');
			} else {
				$state.go('choseguide');
			}
		};

		//退出
		$scope.out = function () {
			if (confirm('确定退出吗？')) {
				sessionStorage.clear();
				$cookies.remove('username');
				$cookies.remove('password');
				appCache.removeAll();
				$rootScope.startDate = null;
				$rootScope.endDate = null;
				$state.go('index.find');
				console.log('退出成功');
			}
		};

		//清除筛选时间
		$scope.clearTime = function () {
			$rootScope.startDate = 0;
			$rootScope.endDate = 0;
			$rootScope.timeStart = null;
			$rootScope.timeEnd = null;
			$rootScope.sum = null;
			appCache.remove('roleRecords');
			getRoleMoney($rootScope.payState);
		};


	}
]);

/**
 *我的订单
 */
appBuilderCtr.controller('MyOrderController', ['$scope', '$state', 'api', 'APP_ID', 'appCache', '$rootScope', 'ResetMyOrderData', 'KillZero',
	function ($scope, $state, api, APP_ID, appCache, $rootScope, ResetMyOrderData, KillZero) {

		//未登录状态
		if (!sessionStorage.userinfo) {
			txtTips('请登录');
			$state.go('login');
		}

		$scope.userinfo = angular.fromJson(sessionStorage.getItem('userinfo'));

		//获取“全部”的订单
		if (appCache.get('myOrder-1')) {
			$rootScope.myOrder = appCache.get('myOrder-1');
		} else {
			api.get('/api/order/list', {
				userId: $scope.userinfo.userId,
				appId: APP_ID,
				payState: -1,
				page: 1,
				pageCount: 10
			}, function (data) {
				if (data.success) {
					var ajaxData = data.content.orders;
					ajaxData.totalPage = data.content.pager.totalPage;
					ajaxData.currentPage = data.content.pager.currentPage;
					//将请求到的页码放入缓存以备翻页时使用
					appCache.put('myOrder-1', ajaxData);
					$rootScope.myOrder = data.content.orders;
					console.log($rootScope.myOrder);
				}
			});
		}

		$scope.topnum = 1;
		$scope.topMenu = [{
				"name": "全部",
				"id": -1
			},
			{
				"name": "未支付",
				"id": 0
			},
			{
				"name": "已支付",
				"id": 1
			},
			{
				"name": "支付失败",
				"id": 2
			},
			{
				"name": "已发货",
				"id": 3
			},
			{
				"name": "货到付款",
				"id": 4
			},
			{
				"name": "已取消",
				"id": 5
			},
			{
				"name": "已完成",
				"id": 6
			}
		];

		//查看订单列表
		$scope.menuActive = function (index, id) {
			// $rootScope.comment=false;
			jQuery(document).scrollTop(0);
			$scope.acount = index;
			$rootScope.myOrder = []; //因为选项卡共用一个DOM结构所以需要重置数据为空
			if (appCache.get('myOrder' + id)) {
				$rootScope.myOrder = appCache.get('myOrder' + id);
			} else {
				api.get('/api/order/list', {
					userId: $scope.userinfo.userId,
					appId: APP_ID,
					payState: id,
					page: 1,
					pageCount: 10
				}, function (data) {
					if (data.success) {
						var ajaxData = data.content.orders;
						ajaxData.totalPage = data.content.pager.totalPage;
						ajaxData.currentPage = data.content.pager.currentPage;
						appCache.put('myOrder' + id, ajaxData);
						$rootScope.myOrder = data.content.orders;
					}
				});
			}
		};

		function onBridgeReady(appId, timeStamp, nonceStr, package, paySign, orderId) {
			WeixinJSBridge.invoke(
				'getBrandWCPayRequest', {
					"appId": appId, //公众号名称，由商户传入     
					"timeStamp": timeStamp, //时间戳，自1970年以来的秒数     
					"nonceStr": nonceStr, //随机串     
					"package": package,
					"signType": "MD5", //微信签名方式：     
					"paySign": paySign //微信签名 
				},
				function (res) {
					txtTips(res);
					api.post('/api/public/error', {
						appId: APP_ID,
						message: res
					});
					if (res.err_msg == "get_brand_wcpay_request:ok") {
						// 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回    ok，但并不保证它绝对可靠。
						ResetMyOrderData._delete();
						$state.go('order-detail', {
							id: orderId
						});
					}
				}
			);
		}
		//确认收货
		$scope.orderComfirm = false;
		$scope.takeGoods = function (orderId) {
			$scope.orderComfirm = !$scope.orderComfirm;
			console.log($scope.orderComfirm);

			api.post('/api/order/updatestate', {
				orderId: orderId,
				toState: 6,
				userId: $scope.userinfo.userId
			}, function (data) {
				if (data.success) {
					ResetMyOrderData._delete();
					$state.reload('myOrder');
				}
			});
		};
		//删除订单
		$scope.deleteGoods = function (orderId) {
			api.post('/api/order/delete', {
				orderId: orderId,
				toState: 5,
				userId: $scope.userinfo.userId
			}, function (data) {
				if (data.success) {
					ResetMyOrderData._delete();
					$state.reload('myOrder');
				}
			});
		};

		//取消订单
		$scope.cancelOrder = function (orderId) {
			api.post('/api/order/updatestate', {
				orderId: orderId,
				toState: 5,
				userId: $scope.userinfo.userId
			}, function (data) {
				txtTips(data.msg);
				if (data.success == 1) {
					ResetMyOrderData._delete();
					$state.reload('myOrder');
				}
			});
		};

		//去支付
		$scope.goConfirm = function (index) {
			var order = $scope.myOrder[index];
			console.log(order);
			api.post('/api/order/pay', {
				orderId: order.id,
				payType: order.payType,
				fromType: order.fromType
			}, function (data) {
				txtTips(data.msg);

				if (order.payType == 2) {
					if (typeof WeixinJSBridge == "undefined") {
						if (document.addEventListener) {
							document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
						} else if (document.attachEvent) {
							document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
							document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
						}
					} else {
						var appId = data.content.data.appId;
						var timeStamp = data.content.data.timeStamp;
						var nonceStr = data.content.data.nonceStr;
						var package = data.content.data.package;
						var paySign = data.content.data.paySign;
						onBridgeReady(appId, timeStamp, nonceStr, package, paySign);
					}
				} else if (order.payType == 5) {
					$state.go('qrcode', {
						src: data.content.data.billQRCodePath,
						id: order.id
					});
					return;
				} else {
					ResetMyOrderData._delete();
					//$state.go('myOrder');
					$state.go('order-detail', {
						id: order.id
					});
				}
			});
		};

		//跳转立即评价
		$scope.takeComments = function (id) {
			// $rootScope.comment=true;
			$state.go('takecomments', {
				orderId: id
			});
		};

	}
]);

/**
 *订单详情
 */
appBuilderCtr.controller('OrderDetailController', ['$rootScope', '$scope', 'appCache', 'resData', '$stateParams', 'api', '$state', 'ResetMyOrderData', 'KillZero', '$interval',
	function ($rootScope, $scope, appCache, resData, $stateParams, api, $state, ResetMyOrderData, KillZero, $interval) {
		var userinfo = angular.fromJson(sessionStorage.userinfo);

		if (resData.data.success) {
			//appCache.put('orderDetail'+$stateParams.id,resData);
			resData.data.content.details = KillZero(resData.data.content.details);
			resData.data.content.info = KillZero(resData.data.content.info);
			$scope.order = resData.data.content;
			$scope.number = $scope.order.details[0].number;
			$scope.haveComment = $scope.order.details[0].haveComment;
		}
		console.log(resData.data.content);
		console.log("resData.data.content");

		if ($scope.order.info.remark === null || $scope.order.info.remark === "null") {
			$scope.order.info.remark = "无备注";
		}
		if ($scope.order.info.shippingCode === null || $scope.order.info.shippingCode === "null") {
			$scope.order.info.shippingCode = "";
		}
		console.log($scope.order.info);
		console.log("$scope.order.info");

		function onBridgeReady(appId, timeStamp, nonceStr, package, paySign, orderId) {
			WeixinJSBridge.invoke(
				'getBrandWCPayRequest', {
					"appId": appId, //公众号名称，由商户传入     
					"timeStamp": timeStamp, //时间戳，自1970年以来的秒数     
					"nonceStr": nonceStr, //随机串     
					"package": package,
					"signType": "MD5", //微信签名方式：     
					"paySign": paySign //微信签名 
				},
				function (res) {
					txtTips(res);
					api.post('/api/public/error', {
						appId: APP_ID,
						message: res
					});
					if (res.err_msg == "get_brand_wcpay_request:ok") {
						// 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回    ok，但并不保证它绝对可靠。
						ResetMyOrderData._delete();
						$state.reload('order-detail', {
							id: orderId
						});
					}
				}
			);
		}

		//重新支付
		$scope.repay = function (orderId, payType) {
			api.post('/api/order/pay', {
				orderId: orderId,
				payType: payType,
				fromType: 2
			}, function (data) {
				txtTips(data.msg);
				//微信支付
				if (payType == 2) {
					if (typeof WeixinJSBridge == "undefined") {
						if (document.addEventListener) {
							document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
						} else if (document.attachEvent) {
							document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
							document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
						}
					} else {
						var appId = data.content.data.appId;
						var timeStamp = data.content.data.timeStamp;
						var nonceStr = data.content.data.nonceStr;
						var package = data.content.data.package;
						var paySign = data.content.data.paySign;
						onBridgeReady(appId, timeStamp, nonceStr, package, paySign, orderId);
					}
				} else if (payType == 5) {
					$state.go('qrcode', {
						src: data.content.data.billQRCodePath,
						id: orderId
					});
					return;
				} else {
					ResetMyOrderData._delete();
					$state.reload('order-detail', {
						id: orderId
					});
				}

			});
		};

		//取消订单
		$scope.cancelOrder = function (orderId) {
			api.post('/api/order/updatestate', {
				orderId: orderId,
				toState: 5,
				userId: userinfo.userId
			}, function (data) {
				txtTips(data.msg);
				if (data.success) {
					ResetMyOrderData._delete();
					appCache.remove('orderDetail' + $stateParams.id);
					$state.reload('order-detail', {
						id: $stateParams.id
					});
				}
			});
		};

		//确认收货
		$scope.orderComfirm = false;
		$scope.takeGoods = function (orderId) {
			$scope.orderComfirm = !$scope.orderComfirm;
			api.post('/api/order/updatestate', {
				orderId: orderId,
				toState: 6,
				userId: userinfo.userId
			}, function (data) {
				if (data.success) {
					ResetMyOrderData._delete();
					appCache.remove('orderDetail' + $stateParams.id);
					$state.reload('order-detail', {
						id: $stateParams.id
					});
				}
			});
		};

		//删除订单
		$scope.deleteGoods = function (orderId) {
			api.post('/api/order/delete', {
				orderId: orderId,
				toState: 5,
				userId: userinfo.userId
			}, function (data) {
				if (data.success) {
					ResetMyOrderData._delete();
					$state.go('myOrder');
				}

			});
		};
		//跳转立即评价
		$scope.takeComments = function (orderId) {
			$rootScope.comment = true;
			$state.go('takecomments', {
				orderId: orderId
			});
			console.log("123456");
			console.log($rootScope.comment);
		};
	}
]);

/**
 *立即评价页面控制器
 */
appBuilderCtr.controller('TakeCommentsController', ['$scope', 'api', '$stateParams', 'appCache', 'resData',
	function ($scope, api, $stateParams, appCache, resData) {
		$scope.list = resData.data.content.details;
		console.log($scope.list);
	}
]);

/**
 *我的导购和选择导购公用控制器
 */
appBuilderCtr.controller('GuideController', ['$scope', 'api', 'APP_ID', 'resData', 'appCache', '$stateParams',
	function ($scope, api, APP_ID, resData, appCache, $stateParams) {

		//未登录状态
		if (sessionStorage.getItem('userinfo') === null) {
			txtTips('请登录');
			$state.go('login');
		}

		$scope.userinfo = angular.fromJson(sessionStorage.userinfo);

		if (resData.data.success) {
			if (resData.data.content.branches) { //分店
				$scope.branchList = resData.data.content.branches;
				appCache.put('branchList', resData);
			} else if (resData.data.content.guideId) {
				$scope.guideInfo = resData.data.content;
			}
		}

		//获取常见问题
		if (appCache.get('problemsData')) {
			$scope.problemsData = appCache.get('problemsData');
		} else {
			api.get('/api/public/problems', {
				appId: APP_ID
			}, function (data) {
				if (data.success) {
					$scope.problemsData = data.content.problems;
					appCache.put('problemsData', data.content.problems);
				}
			});
		}

	}
]);

/**
 *常见问题详情
 */
appBuilderCtr.controller('ProblemDetailController', ['appCache', '$scope', '$stateParams', '$sce',
	function (appCache, $scope, $stateParams, $sce) {
		//var data = angular.fromJson( sessionStorage.problemsData);
		var data = appCache.get('problemsData');
		console.log("data");
		console.log(data);
		console.log("data11");
		angular.forEach(data, function (val, key) {
			if (val.id == $stateParams.id) {
				$scope.detail = $sce.trustAsHtml(val.detail);
			}
			//	console.log($scope.detail);

		});

	}
]);

/**
 *我的发帖
 */
appBuilderCtr.controller('MyCommunityController', ['$scope', 'api', 'APP_ID', 'appCache', '$rootScope',
	function ($scope, api, APP_ID, appCache, $rootScope) {

		//未登录状态
		if (sessionStorage.getItem('userinfo') === null) {
			txtTips('请登录');
			$state.go('login');
		}

		$scope.userinfo = angular.fromJson(sessionStorage.getItem('userinfo'));
		$scope.discuzactive = true;
		console.log($scope.userinfo);

		//切换
		$scope.exchange = function () {
			$rootScope.currentPage = 1;
			$rootScope.totalPage = 2;
			//评论的帖子
			if ($scope.discuzactive) {
				$scope.discuzactive = false;
				if (appCache.get('myCommunityComment')) {
					$rootScope.myCommunity = appCache.get('myCommunityComment');
				} else {
					api.get('/api/comment/mine', {
						appId: APP_ID,
						userId: $scope.userinfo.userId,
						tag: 2,
						page: 1,
						pageCount: 10
					}, function (data) {
						if (data.success) {
							$rootScope.myCommunity = data.content.comments;
							var ajaxData = data.content.comments;
							ajaxData.totalPage = data.content.pager.totalPage;
							ajaxData.currentPage = data.content.pager.currentPage;
							appCache.put('myCommunityComment', ajaxData);
						}
					});
				}
			}
			//发布的帖子
			else {
				$scope.discuzactive = true;
				$rootScope.myCommunity = appCache.get('myCommunity');
			}
		};

		//默认载入我的发帖
		if (appCache.get('myCommunity')) {
			$rootScope.myCommunity = appCache.get('myCommunity');
		} else {
			api.get('/api/forum/topics', {
				page: 1,
				tag: 2,
				pageCount: 10,
				appId: APP_ID,
				userId: $scope.userinfo.userId
			}, function (data) {
				var ajaxData = data.content.topics;
				ajaxData.totalPage = data.content.pager.totalPage;
				ajaxData.currentPage = data.content.pager.currentPage;
				appCache.put('myCommunity', ajaxData);
				$rootScope.myCommunity = data.content.topics;
			});
		}

	}
]);

/**
 *我的评论
 */
appBuilderCtr.controller('MyCommentController', ['$scope', 'api', 'APP_ID', 'appCache', '$rootScope',
	function ($scope, api, APP_ID, appCache, $rootScope) {

		//未登录状态
		if (sessionStorage.getItem('userinfo') === null) {
			txtTips('请登录');
			$state.go('login');
		}

		$scope.userinfo = angular.fromJson(sessionStorage.userinfo);
		$scope.commentactive = true;

		$scope.exchange = function () {
			//文章的评论
			if ($scope.commentactive) {
				$scope.commentactive = false;
				if (appCache.get('myArticleComment')) {
					$rootScope.myArticleComment = appCache.get('myArticleComment');
				} else {
					api.get('/api/comment/mine', {
						page: 1,
						pageCount: 10,
						appId: APP_ID,
						tag: 1,
						userId: $scope.userinfo.userId
					}, function (data) {
						var ajaxData = data.content.comments;
						ajaxData.totalPage = data.content.pager.totalPage;
						ajaxData.currentPage = data.content.pager.currentPage;
						appCache.put('myArticleComment', ajaxData);
						$rootScope.myArticleComment = data.content.comments;
					});
				}
			}
			//产品的评论
			else {
				$scope.commentactive = true;
				$rootScope.myProductComment = appCache.get('myProductComment');
			}
		};

		//默认载入我的产品评论
		if (appCache.get('myProductComment')) {
			$rootScope.myProductComment = appCache.get('myProductComment');
		} else {
			api.get('/api/comment/mine', {
				page: 1,
				pageCount: 10,
				appId: APP_ID,
				tag: 3,
				userId: $scope.userinfo.userId
			}, function (data) {
				var ajaxData = data.content.comments;
				ajaxData.totalPage = data.content.pager.totalPage;
				ajaxData.currentPage = data.content.pager.currentPage;
				appCache.put('myProductComment', ajaxData);
				$rootScope.myProductComment = data.content.comments;
			});
		}

	}
]);

/**
 *个人中心设置
 */
appBuilderCtr.controller('MineSetController', ['$scope', 'api', 'APP_ID', '$state', 'Upload', '$cookies', 'appCache', '$rootScope',
	function ($scope, api, APP_ID, $state, Upload, $cookies, appCache, $rootScope) {

		$scope.userinfo = angular.fromJson(sessionStorage.userinfo);

		//获取等级信息
		api.get('/api/account/ranks?appId=' + APP_ID + '&userId=' + $scope.userinfo.userId + '',
			function (data) {
				if (data.success) {
					$scope.ranks = data.content.ranks;
				}
			});

		//退出community-detail
		$scope.out = function () {
			if (confirm('确定退出吗？')) {
				$cookies.remove('username');
				$cookies.remove('password');
				sessionStorage.clear();
				appCache.removeAll();
				$rootScope.startDate = null;
				$rootScope.endDate = null;
				$state.go('index.find');
				console.log('退出成功');
			}
		};

		//未登录状态
		if (sessionStorage.getItem('userinfo') === null) {
			txtTips('请登录');
			$state.go('login');
		}

		$scope.userinfo = angular.fromJson(sessionStorage.userinfo);

		//上传头像图片
		$scope.uploadFiles = function (files, errFiles) {
			if (errFiles[0]) {
				txtTips(errFiles[0].name + '的大小超过了' + errFiles[0].$errorParam);
			}
			angular.forEach(files, function (file) {
				file.upload = Upload.upload({
					url: '/image/upload?type=1',
					data: {
						file: file
					}
				});
				loader.open();
				file.upload.then(function (resp) {
					if (resp.data.status == 'success') {
						loader.close();
						//更新当前头像
						$scope.userinfo.imagePath = resp.data.path;
						//更新服务器头像
						api.post('/api/account/update', {
							userId: $scope.userinfo.userId,
							appId: APP_ID,
							coverId: resp.data.picKey
						}, function (data) {
							if (data.success) {
								txtTips('头像修改成功');
								$scope.userinfo.coverId = resp.data.picKey;
								sessionStorage.setItem('userinfo', angular.toJson($scope.userinfo));
							}
						});
					}
				}, function (resp) {
					console.log('Error status: ' + resp.status);
				}, function (evt) {
					$scope.progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
				});
			});
		};

		//显示昵称输入框
		$scope.showInput = function () {
			$scope.nickInput = 1;
			//$scope.auto = 'autofocus';
		};

		//隐藏昵称输入框并修改昵称
		$scope.hideInput = function () {
			// if($scope.newNick===undefined||$scope.newNick===''){
			// 	txtTips('昵称不能为空');
			// 	return;
			// }
			$scope.nickInput = 0;
			$scope.userinfo.nickname = $scope.newNick;
			api.post('/api/account/update', {
				userId: $scope.userinfo.userId,
				appId: APP_ID,
				nickname: $scope.newNick
			}, function (data) {
				if (data.success) {
					sessionStorage.setItem('userinfo', angular.toJson($scope.userinfo));
					txtTips('昵称修改成功');
				}
			});
		};



	}
]);

/**
 *我的会员
 */
appBuilderCtr.controller('MyMemberController', ['$scope', 'appCache', '$state', 'api', '$rootScope',
	function ($scope, appCache, $state, api, $rootScope) {

		var userinfo = angular.fromJson(sessionStorage.userinfo);

		if (appCache.get('mymembers')) {
			$rootScope.members = appCache.get('mymembers');
			$scope.totalMembers = $rootScope.members.cnt;
		} else {
			api.get('/api/account/users', {
				userId: userinfo.userId,
				page: 1,
				pageCount: 10
			}, function (data) {
				if (data.success) {
					$rootScope.members = data.content.users;
					$scope.totalMembers = data.content.cnt;
					var ajaxData = data.content.users;
					ajaxData.totalPage = data.content.pager.totalPage;
					ajaxData.currentPage = data.content.pager.currentPage;
					ajaxData.cnt = data.content.cnt;
					appCache.put('mymembers', ajaxData);
				}
			});
		}

	}
]);

/**
 *app设置
 */
appBuilderCtr.controller('AppSetController', ['$scope', 'appCache', '$state',
	function ($scope, appCache, $state) {

		$scope.appCacheSize = appCache.info();
		$scope.appInfo = angular.fromJson(localStorage.app);
		$scope.removeAppCache = function () {
			if (confirm('确定清除缓存吗？')) {
				appCache.removeAll();
				$state.reload('appset');
			}
		};

	}
]);

/**
 *成长值
 */
appBuilderCtr.controller('GrowthController', ['$scope', 'api', 'APP_ID', '$rootScope', '$state',
	function ($scope, api, APP_ID, $rootScope, $state) {

		//未登录状态
		if (sessionStorage.getItem('userinfo') === null) {
			txtTips('请登录');
			$state.go('login');
		}

		$scope.userinfo = angular.fromJson(sessionStorage.userinfo);

		//获取等级信息
		api.get('/api/account/ranks?appId=' + APP_ID + '&userId=' + $scope.userinfo.userId + '', function (data) {
			if (data.success) {
				$scope.growth = data.content.ranks;
				$scope.nextRankNeedScore = data.content.nextRankNeedScore;
				$scope.userGrowth = $scope.userinfo.growthScore; //用户当前成长值
				var times = 0; //用户当前等级
				$scope.onewidth = parseFloat(9.2 / $scope.growth.length).toFixed(1);
				//利用循环的次数得出当前等级
				angular.forEach($scope.growth, function (val, key) {
					console.log(val);
					if ($scope.userGrowth >= val.startCredit) {
						times += 1;
					}
				});
				$scope.growthIndex = times; //当前用户等级
				$scope.userLevel = times;
				$scope.previousLevelGrowth = $scope.growth[$scope.growthIndex - 1].startCredit; //上一个等级所对应的成长值
				// $scope.previousLevelGrowth = $scope.growth[$scope.growthIndex].startCredit;
				if ($scope.growth.length <= times) {
					$scope.growthLength = 9.2; //总长为9.2rem
					$scope.nextLevelGrowth = $scope.previousLevelGrowth;
					$scope.userLevel = $scope.userLevel - 1;
					console.log($scope.userLevel);
				} else {
					$scope.nextLevelGrowth = $scope.growth[$scope.growthIndex].startCredit; //下一个等级所对应的成长值
					//$scope.nextLevelGrowth = $scope.growth[$scope.growthIndex+1].startCredit;
					$scope.growthLength = (($scope.userGrowth - $scope.previousLevelGrowth) / ($scope.nextLevelGrowth - $scope.previousLevelGrowth) + $scope.growthIndex) * $scope.onewidth;

				}
			}
		});

		//获取成长值的记录
		api.get('/api/account/creditrecord', {
			appId: APP_ID,
			userId: $scope.userinfo.userId,
			page: 1,
			pageCount: 10,
			type: 1
		}, function (data) {
			if (data.success) {
				$rootScope.creditRecordList = data.content.records;
			}
		});

	}
]);

/**
 *我的积分记录
 */
appBuilderCtr.controller('MyPointController', ['appCache', '$scope', 'APP_ID', 'api', '$rootScope',
	function (appCache, $scope, APP_ID, api, $rootScope) {

		//未登录状态
		if (sessionStorage.getItem('userinfo') === null) {
			txtTips('请登录');
			$state.go('login');
		}

		$scope.userinfo = angular.fromJson(sessionStorage.userinfo);
		if (appCache.get('myPointRecords')) {
			$rootScope.pointRecords = appCache.get('myPointRecords');
		} else {
			api.get('/api/account/creditrecord', {
				userId: $scope.userinfo.userId,
				appId: APP_ID,
				type: 0,
				page: 1,
				pageCount: 10
			}, function (data) {
				if (data.success) {
					var ajaxData = data.content.records;
					ajaxData.totalPage = data.content.pager.totalPage;
					ajaxData.currentPage = data.content.pager.currentPage;
					appCache.put('myPointRecords', ajaxData);
					$rootScope.pointRecords = ajaxData;
				}
			});
		}
	}
]);

/**
 *收货地址
 */
appBuilderCtr.controller('AddressController', ['$scope', 'api', 'APP_ID', '$stateParams', '$state',
	function ($scope, api, APP_ID, $stateParams, $state) {

		//未登录状态
		if (sessionStorage.getItem('userinfo') === null) {
			txtTips('请登录');
			$state.go('login');
		}

		$scope.userinfo = angular.fromJson(sessionStorage.userinfo);
		jQuery(".list").css("height", window.innerHeight - window.rem / window.dpr * 3);
		if (sessionStorage.useraddress) {
			$scope.address = angular.fromJson(sessionStorage.useraddress);
		} else if (sessionStorage.useraddress === undefined) {
			//获取收货地址
			api.get('/api/account/address/' + $scope.userinfo.userId, function (data) {
				if (data.success) {
					if (data.content === undefined) {
						return;
					} else if (data.content.length === 0) {
						txtTips('点击新增地址');
					}
					$scope.address = data.content;
					//将获取的地址存入
					sessionStorage.setItem('useraddress', angular.toJson(data.content));
				}
			});
		}
		//删除收货地址
		$scope.scrollleft = function (index) {
			jQuery("ul li:nth-child(" + (index + 1) + ")").css("margin-left", "-1.87rem");
		};
		$scope.scrollright = function (index) {
			jQuery("ul li:nth-child(" + (index + 1) + ")").css("margin-left", 0);
		};
		$scope.deleteAdd = function (id) {
			api.get('/api/account/deleteaddress', {
				userId: $scope.userinfo.userId,
				addressId: id
			}, function (data) {
				sessionStorage.removeItem('useraddress');
				$state.reload('address');
			});
		};



		//在地址页面对地址的操作
		$scope.handleAddress = function (index, id) {
			//tag==1,选择该地址
			//console.log()
			if ($stateParams.tag == 1) {
				//返回订单页
				sessionStorage.setItem('consignee', angular.toJson($scope.address[index]));
				location.href = decodeURIComponent(decodeURIComponent($stateParams.reurl));
				console.log(!$stateParams.tag);
			}
			//tag==2,修改收货地址
			else if ($stateParams.tag == 2 || !$stateParams.tag) {
				$state.go('plus-address', {
					id: id
				});
			} else if (sessionStorage.reurl) {
				sessionStorage.setItem('consignee', angular.toJson($scope.address[index]));
				location.href = angular.fromJson(sessionStorage.reurl);
			}
			/*else if(!$stateParams.tag===false){
						$state.go('plus-address',{id: id});
					}*/
		};

		//跳转新增地址页
		$scope.plusadd = function () {
			// if($stateParams.reurl){
			// 	//保存订单页url
			// 	sessionStorage.setItem('reurl',decodeURIComponent(decodeURIComponent( $stateParams.reurl )));
			// }
			$state.go('plus-address', {
				reurl: $stateParams.reurl
			});
		};

	}
]);

/**
 *新增收货地址
 */
appBuilderCtr.controller('PlusAddressController', ['$scope', 'api', 'APP_ID', 'appCache', '$state', '$stateParams',
	function ($scope, api, APP_ID, appCache, $state, $stateParams) {

		//未登录状态
		if (sessionStorage.getItem('userinfo') === null) {
			txtTips('请登录');
			$state.go('login');
		}

		$scope.userinfo = angular.fromJson(sessionStorage.userinfo);

		//获取省
		if (appCache.get('proData')) {
			$scope.prodata = appCache.get('proData');
		} else {
			api.get('/api/public/provincecityareaitems?parentId=0', function (data) {
				if (data.success) {
					$scope.prodata = data.content;
					appCache.put('proData', data.content);
				}
			});
		}

		//修改页面名字
		if ($stateParams.id) {
			$scope.title = "修改收货地址";
			var useraddress = angular.fromJson(sessionStorage.useraddress);
			angular.forEach(useraddress, function (val, key) {
				if ($stateParams.id == val.id) {
					$scope.name = val.consignee;
					$scope.mobile = val.mobile;
					$scope.proName = val.province;
					$scope.cityName = val.city;
					$scope.areaName = val.area;
					$scope.proID = val.provinceId;
					$scope.cityID = val.cityId;
					$scope.areaId = val.areaId;
					$scope.detailPart = val.detail;
					$scope.postCode = val.postcode;
				}
			});
		}

		//设置隐藏层高度
		$scope.set = function (num) {
			if (num === undefined) $scope.flag = !$scope.flag;
			else if (num == 1) $scope.flagPart = !$scope.flagPart;
			$scope.style = {
				'height': window.innerHeight
			};
		};

		//保存或更新收货地址
		$scope.saveAdd = function () {
			if ($scope.mobile.length !== 11) {
				txtTips('请输入11位手机号码');
			} else {
				api.post('/api/account/addaddress', {
					userId: $scope.userinfo.userId,
					consignee: $scope.name,
					provinceId: $scope.proID,
					cityId: $scope.cityID,
					areaId: $scope.areaID,
					detail: $scope.detailPart,
					mobile: $scope.mobile,
					postcode: $scope.postCode,
					addressId: $stateParams.id
				}, function (data) {
					txtTips(data.msg);
					if (data.success) {
						if ($stateParams.id || !$stateParams.reurl) $state.go('address', {
							tag: 2
						}); //从个人中心进来的
						else $state.go('address', {
							reurl: $stateParams.reurl,
							tag: 1
						}); //从确认订单进来的
						//删除本地保存的收货地址
						sessionStorage.removeItem('useraddress');
					}
				});
			}
		};

	}
]);

/**
 *关于我们
 */
appBuilderCtr.controller('AboutUsController', ['$scope', 'resData', 'APP_ID', '$state', 'appCache', '$sce',
	function ($scope, resData, APP_ID, $state, appCache, $sce) {

		if (resData.data.success) {
			$scope.us = $sce.trustAsHtml(resData.data.content);
			appCache.put('aboutus', resData);
		}

	}
]);

/**
 *重设密码
 */
appBuilderCtr.controller('ResetController', ['$scope', 'api', '$cookieStore', '$state', 'appCache', '$rootScope', '$cookies',
	function ($scope, api, $cookieStore, $state, appCache, $rootScope, $cookies) {

		//未登录状态
		if (!sessionStorage.userinfo) {
			txtTips('请登录');
			$state.go('login');
		}

		$scope.reset = function () {
			if ($scope.resetValidate()) {
				api.post('/api/account/modifypwd', {
					userId: angular.fromJson(sessionStorage.userinfo).userId,
					passwordNew: $scope.resetPassword,
					passwordOld: $scope.resetOldpassword
				}, function (data) {
					txtTips(data.msg);
					if (data.success) {
						$state.go('mineset');
					}
				});
			}
		};

		//验证
		$scope.resetValidate = function () {
			if (!$scope.resetOldpassword) txtTips('请输入6-12位旧密码');
			else if (!$scope.resetPassword) txtTips('请输入6-12位新密码');
			else return true;
		};

	}
]);

/**
 *设置地图显示高度
 */
appBuilderCtr.controller('MapHeightController', ['$scope', function ($scope) {

	$scope.setMapheight = function () {
		var otherHeight = 0;
		jQuery.each(jQuery('#map').siblings(), function (index, val) {
			otherHeight = otherHeight + parseInt(jQuery(val).height());
		});
		jQuery('#map').css({
			height: window.innerHeight - otherHeight - 10,
			width: '10rem'
		});
	};

}]);

/**
 *投诉建议
 */
appBuilderCtr.controller('SuggestController', ['$scope', 'resData', 'APP_ID', '$state', 'api',
	function ($scope, resData, APP_ID, $state, api) {
		if (resData.data.success && resData.data.content) $scope.msg = resData.data.content;

		//未登录状态
		if (sessionStorage.getItem('userinfo') === null) {
			txtTips('请登录');
			$state.go('login');
		}

		$scope.userinfo = angular.fromJson(sessionStorage.userinfo);

		//发布反馈
		$scope.suggest = function () {
			if ($scope.content === undefined || $scope.content === "") {
				txtTips('请输入内容');
				return;
			}
			api.post('/api/account/createadvice', {
				userId: $scope.userinfo.userId,
				appId: APP_ID,
				content: $scope.content
			}, function (data) {
				txtTips(data.msg);
				if (data.success) {
					$state.reload('suggest');
				}
			});
		};

	}
]);

/**
 *购物车（计算及操作在指令中）
 */
appBuilderCtr.controller('CarController', ['$scope', 'resData', 'APP_ID', '$state', '$rootScope', '$stateParams', 'KillZero',
	function ($scope, resData, APP_ID, $state, $rootScope, $stateParams, KillZero) {
		$scope.type = $stateParams.type;
		if ($scope.type == 1) {
			$scope.carclassic = '产品';
		} else if ($scope.type == 2) {
			$scope.carclassic = '积分商城';
		}

		$scope.userinfo = angular.fromJson(sessionStorage.userinfo);
		//$scope.AppUser="AppUser";
		console.log($scope.userinfo.roleTag == $scope.AppUser);
		console.log($scope.userinfo);
		//载入购物车数据
		$rootScope.cartProducts = KillZero(resData.data.content.cartProducts);
	}
]);

/**
 *确认订单
 */
appBuilderCtr.controller('ConfirmController', ['$filter', '$stateParams', 'api', 'APP_ID', 'resData', '$scope', '$state', 'appCache', 'KillZero', 'handleURL', '$rootScope', '$interval',
	function ($filter, $stateParams, api, APP_ID, resData, $scope, $state, appCache, KillZero, handleURL, $rootScope, $interval) {

		if (resData.data.success === 0) {
			txtTips(resData.data.msg);
			history.go(-1);
			return;
		}

		//未登录状态
		if (!sessionStorage.getItem('userinfo')) {
			txtTips('请登录');
			$state.go('login');
		}
		var userinfo = angular.fromJson(sessionStorage.userinfo);
		var appinfo = angular.fromJson(localStorage.app);
		// 注释去0操作
		// resData.data.content.products = KillZero(resData.data.content.products);
		// resData.data.content.gift = KillZero(resData.data.content.gift);
		$scope.order = resData.data.content;
		$scope.totalPrice = $filter('number')($scope.order.totalPrice, 2);
		console.log($scope.totalPrice);

		//用户可用积分
		$scope.spendCredits = 0;
		angular.forEach(resData.data.content.products, function (val, key) {
			$scope.spendCredits += val.spendCredits * val.number;
		});
		if ($scope.spendCredits > userinfo.credits) {
			$scope.spendCredits = userinfo.credits;
		}
		console.log('产品可用积分：' + $scope.spendCredits);
		$scope.toMoney = $scope.spendCredits / appinfo.creditRate;
		if ($scope.toMoney > $scope.order.totalPrice) {
			$scope.toMoney = $scope.order.totalPrice;
			$scope.spendCredits = $scope.toMoney * appinfo.creditRate;
		}
		console.log('可抵扣的现金：' + $scope.toMoney);

		//判断是否有已选地址
		if (sessionStorage.consignee) {
			$scope.consignee = angular.fromJson(sessionStorage.consignee);
			getFreight();
		} else {
			api.get('/api/account/address/' + userinfo.userId, function (data) {
				if (data.success) {
					if (!data.content) {
						txtTips('请先添加一个收货地址');
						return;
					}
					sessionStorage.consignee = angular.toJson(data.content[0]);
					$scope.consignee = data.content[0];
					getFreight();
				}
			});
		}

		//获取运费
		function getFreight() {
			if ($scope.order.currency !== 'RMB') {
				$scope.shippingfee = 0;
				return;
			}
			api.get('/api/public/shippingfee', {
				appId: APP_ID,
				provinceId: $scope.consignee.provinceId
			}, function (data) {
				if (data.success) {
					//累加运费
					$scope.productsTotalNum = 0;
					var shipping_fee = data.content;
					angular.forEach($scope.order.products, function (val, index) {
						$scope.productsTotalNum += val.number;
					});
					console.log('产品总数量：' + $scope.productsTotalNum);
					//$scope.spendCredits=$scope.spendCredits*productsTotalNum;
					$scope.shippingfee = parseFloat(shipping_fee.price) + ($scope.productsTotalNum - 1) * parseFloat(shipping_fee.addPrice);
					console.log('总运费：' + $scope.shippingfee);
					$scope.totalPrice = $filter('number')(parseFloat($scope.shippingfee + $scope.order.totalPrice), 2);
					console.log('订单总金额：' + $scope.totalPrice);
					$scope.sendway = '快递';
				} else {
					txtTips(data.msg);
					$scope.consignee = null;
					sessionStorage.removeItem('consignee');
				}
			});
		}

		//跳转到收货地址页
		$scope.goAddress = function () {
			$state.go('address', {
				tag: 1,
				reurl: encodeURIComponent(location.href)
			});
		};

		//抵扣现金
		$scope.toCash = function () {
			$scope.tomoneyflag = !$scope.tomoneyflag;
			if ($scope.tomoneyflag) {
				var cutMoney = $scope.order.totalPrice - $scope.toMoney;
				if (cutMoney < 0) {
					$scope.totalPrice = $scope.shippingfee;
					return;
				}
				$scope.totalPrice = $filter('number')(parseFloat($scope.order.totalPrice - $scope.toMoney + $scope.shippingfee), 2);
			} else {
				$scope.totalPrice = $filter('number')(parseFloat($scope.order.totalPrice + $scope.shippingfee), 2);
			}

		};

		// 支付方式的显示
		var hasYueDan = angular.fromJson(localStorage.app).yuedanPay;
		if (hasYueDan === 0) { //没有悦单支付
			if (handleURL.markValue('code')) { //有微信code
				$scope.wx = true;
			} else {
				$scope.wx = false;
			}
		} else if (hasYueDan == 1) {
			$scope.wx = true;
		}

		// 默认的支付方式，微信支付
		if (localStorage.payWay) { //用户已选支付方式
			$scope.paytype = localStorage.payWay;
			$scope.payWay = localStorage.payWayWord;
		} else if (typeof WeixinJSBridge == "undefined" && hasYueDan === 0) {
			$scope.payWay = $filter('translate')('cashOnDelivery');
			$scope.paytype = 3;
		} else {
			$scope.payWay = $filter('translate')('weChatPayment');
			$scope.paytype = 2; //默认的支付方式，微信支付
		}

		// 请选择支付方式
		$scope.pay = function (num) {
			localStorage.payWay = num;
			$scope.paytype = num;
			if (num == 2) $scope.payWay = '微信支付';
			else if (num == 3) $scope.payWay = '货到付款';
			localStorage.payWayWord = $scope.payWay;
		};

		//提交订单
		$scope.sendOrder = function (productsTotalNum) {
			var cartType;
			if (!$scope.consignee) {
				txtTips('请选择收货地址');
				return;
			} else if ($scope.paytype === undefined) {
				txtTips('请选择支付方式');
				return;
			}
			var creattime = Date.parse(new Date());
			console.log($stateParams.tag);
			api.post('/api/order/create?creattime=' + creattime, {
				userId: userinfo.userId,
				appId: APP_ID,
				tag: $stateParams.tag,
				payType: $scope.paytype,
				shippingAddress: $scope.consignee.id,
				cartIds: $stateParams.cartIds,
				cartType: $stateParams.cartType,
				remark: $scope.remark,
				productId: $stateParams.productId,
				number: $stateParams.number,
				fromType: 2,
				spendCredit: $scope.tomoneyflag ? $scope.spendCredits : 0,
				openId: userinfo.openId || null
			}, function (data) {
				function onBridgeReady(appId, timeStamp, nonceStr, package, paySign) {
					WeixinJSBridge.invoke(
						'getBrandWCPayRequest', {
							"appId": appId, //公众号名称，由商户传入     
							"timeStamp": timeStamp, //时间戳，自1970年以来的秒数     
							"nonceStr": nonceStr, //随机串     
							"package": package,
							"signType": "MD5", //微信签名方式：     
							"paySign": paySign //微信签名 
						},
						function (res) {
							txtTips(res);
							api.post('/api/public/error', {
								appId: APP_ID,
								message: res
							});
							if (res.err_msg == "get_brand_wcpay_request:ok") {
								// 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回    ok，但并不保证它绝对可靠。
								$state.go('myOrder');
							}
						}
					);
				}

				txtTips(data.msg);
				if (data.success) {
					appCache.removeAll();
					if ($scope.paytype == 2) { //微信支付和悦单支付
						if (typeof WeixinJSBridge == "undefined") { //非微信环境
							// location.href = data.content.data.billQRCode;
							if (data.content.data.billQRCodePath) {
								$state.go('qrcode', {
									src: data.content.data.billQRCodePath,
									id: data.content.orderId
								});
								return;
							}
							if (document.addEventListener) {
								document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
							} else if (document.attachEvent) {
								document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
								document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
							}
						} else if (!localStorage.wxid && WeixinJSBridge) { //微信环境有悦单无微信支付
							var yuedanPayUrl = data.content.data.billQRCode;
							location.href = yuedanPayUrl;
							return;
						} else {
							var appId = data.content.data.appId;
							var timeStamp = data.content.data.timeStamp;
							var nonceStr = data.content.data.nonceStr;
							var package = data.content.data.package;
							var paySign = data.content.data.paySign;
							onBridgeReady(appId, timeStamp, nonceStr, package, paySign);
						}
					} else {
						$state.go('order-detail', {
							id: data.content.orderId
						});
					}
					sessionStorage.removeItem('consignee');
				}
			});
		};

	}
]);

/**
 * 支付二维码
 */
(function () {
	'use strict';

	appBuilderCtr
		.controller('QrCodeController', QrCodeController);

	QrCodeController.inject = ['$scope', '$stateParams', '$interval', 'api', '$rootScope', '$state', 'appCache'];

	function QrCodeController($scope, $stateParams, $interval, api, $rootScope, $state, appCache) {
		$scope.src = $stateParams.src;
		var orderId = $stateParams.id;
		$rootScope.stop = $interval(function () {
			api.get('/api/order/detail/' + orderId, {
				norealParam: 1
			}, function (res) {
				if (res.success) {
					var payState = res.content.info.payState;
					if (payState == 1 || payState == 2) {
						$state.go('order-detail', {
							id: orderId
						});
						$interval.cancel($rootScope.stop);
						appCache.removeAll(); //清空缓存
					}
				}
			}, 'noloader');
		}, 2000);
	}
})();

/**
 *生成日历
 */
appBuilderCtr.controller('CalendarController', ['$scope', 'appCache', '$rootScope',
	function ($scope, appCache, $rootScope) {
		//显示已选日期
		function showDateTime() {
			if ($rootScope.startDate && $rootScope.endDate) {
				$scope._startMonth = $rootScope.startDate.split('-')[1];
				$scope._startDay = $rootScope.startDate.split('-')[2];
				$scope._endMonth = $rootScope.endDate.split('-')[1];
				$scope._endDay = $rootScope.endDate.split('-')[2];
			}
		}
		//将数值转换为数字数组
		//比如是3，转换为[0,1,2]
		function setdays(days) {
			var daysArray = [];
			for (var i = 0; i < days; i++) {
				daysArray[i] = i + 1;
			}
			return daysArray;
		}
		if (appCache.get('calendar')) {
			$scope.month = appCache.get('calendar');
			showDateTime();
			return;
		}
		var date = new Date();
		var year = date.getFullYear();
		var monthday = [31, 0, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31]; //每月的天数
		var weekday = [];
		var _weekday = [];
		//是否为闰年
		if (year % 400 === 0 || year % 4 === 0 && year % 100 !== 0) monthday[1] = 29;
		else monthday[1] = 28;
		//获取每月1号是星期几
		//注意：这里j的值在实例化时会自动+1，毋须手动+1
		for (var j = 0; j < 12; j++) {
			var _date = new Date(year, j, 1);
			weekday[j] = _date.getDay();
		}
		//将monthday、weekday内的元素转换为数组以便ng-repeat
		for (var i = 0; i < 12; i++) {
			monthday[i] = setdays(monthday[i]);
			weekday[i] = setdays(weekday[i]);
		}
		//将每月1号的星期数转换为数组并将元素替换为空
		for (var k = 0; k < 12; k++) {
			var trs = weekday[k];
			var _trs = [];
			for (var m = 0; m < weekday[k].length; m++) {
				_trs[m] = trs[m].toString().replace(/\d/g, ' ');
			}
			_weekday[k] = _trs;
		}
		//合并每月天数和1号星期数
		for (var n = 0; n < 12; n++) {
			monthday[n] = _weekday[n].concat(monthday[n]);
		}
		$scope.month = monthday;
		showDateTime();
		appCache.put('calendar', monthday);
	}
]);