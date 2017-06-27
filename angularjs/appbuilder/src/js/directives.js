/**
 *首页头部
 */
appBuilder.directive('rheader', function () {
	return {
		restrict: 'AE',
		replace: true,
		templateUrl: viewSrc + 'partials/header.html',
		link: function ($scope, iElm, iAttrs, controller) {
			var app = angular.fromJson(localStorage.app);
			$scope.isBranch = app.isBranch;
			$scope.isPromotionProduct = app.isPromotionProduct;
			$scope.isCreditProduct = app.isCreditProduct;
		}
	};
});

/**
 *主底部菜单
 */
appBuilder.directive('rfooter', function () {
	return {
		restrict: 'AE',
		replace: true,
		scope: {
			productlink: '@',
			articlelink: '@'
		},
		templateUrl: viewSrc + 'partials/footer.html',
		link: function ($scope, iElm, iAttrs, controller) {
			var app = angular.fromJson(localStorage.app);
			$scope.isForum = app.isForum;
		}
	};
});
appBuilder.directive('rhomefooter', function () {
	return {
		restrict: 'AE',
		replace: true,
		scope: {
			homelink: '@'
		},
		templateUrl: viewSrc + 'partials/home-footer.html',
		link: function ($scope, iElm, iAttrs, controller) {
			var app = angular.fromJson(localStorage.app);
			$scope.isForum = app.isForum;
		}
	};
});

/**
产品促销
**/
appBuilder.directive('product', ['$interval', '$state', function ($interval, $state) {
	// Runs during compile
	return {
		restrict: 'AE', // E = Element, A = Attribute, C = Class, M = Comment
		replace: true,
		scope: {
			start: '@', //距离促销开始时间
			end: '@', //距离促销结束时间
			status: '@', //产品此时的状态  1未开时  2正在进行 3 已结束
			summary: '@' //标题名称
		}, // {} = isolate, true = child, false/undefined = no change
		templateUrl: viewSrc + 'partials/saleProduct.html',
		link: function ($scope, iElm, iAttrs, controller) {
			if ($scope.start > 0) {
				$scope.time = $interval(function () {
					if ($scope.start) {
						$scope.second = parseInt($scope.start % 60);
						$scope.minute = parseInt(parseInt($scope.start / 60) % 60);
						$scope.hour = parseInt(parseInt($scope.start / 3600) % 24);
						$scope.day = parseInt(($scope.start / 3600) / 24);
						if ($scope.hour === 0 && $scope.minute === 0 && $scope.second === 0) {
							$scope.day = $scope.day - 1;
							$scope.hour = 23;
							$scope.minute = 59;
							$scope.second = 59;
						}
						if ($scope.minute === 0 && $scope.second === 0) {
							$scope.hour = $scope.hour - 1;
							$scope.minute = 59;
							$scope.second = 59;
						}
						if ($scope.second === 0) {
							$scope.minute = $scope.minute - 1;
							$scope.second = 59;
						}
						if ($scope.second < 10) {
							$scope.second = "0" + $scope.second;
						}
						if ($scope.minute < 10) {
							$scope.minute = "0" + $scope.minute;
						}

						if ($scope.hour < 10) {
							$scope.hour = "0" + $scope.hour;
						}
					} else {
						$scope.day = 0;
						$scope.hour = 00;
						$scope.minute = 00;
						$scope.second = 00;
					}
					$scope.start = $scope.start - 1;
					if ($scope.start < 0) {
						$interval.cancel($scope.time);
						$state.reload();
					}
				}, 1000);
			} else if ($scope.end > 0) {
				$scope.time = $interval(function () {
					if ($scope.end) {
						$scope.second = parseInt($scope.end % 60);
						$scope.minute = parseInt(parseInt($scope.end / 60) % 60);
						$scope.hour = parseInt(parseInt($scope.end / 3600) % 24);
						$scope.day = parseInt(($scope.end / 3600) / 24);
						if ($scope.hour === 0 && $scope.minute === 0 && $scope.second === 0) {
							$scope.day = $scope.day - 1;
							$scope.hour = 23;
							$scope.minute = 59;
							$scope.second = 59;
						}
						if ($scope.minute === 0 && $scope.second === 0) {
							$scope.hour = $scope.hour - 1;
							$scope.minute = 59;
							$scope.second = 59;
						}
						if ($scope.second === 0) {
							$scope.minute = $scope.minute - 1;
							$scope.second = 59;
						}
						if ($scope.second < 10) {
							$scope.second = "0" + $scope.second;
						}
						if ($scope.minute < 10) {
							$scope.minute = "0" + $scope.minute;
						}

						if ($scope.hour < 10) {
							$scope.hour = "0" + $scope.hour;
						}
					} else {
						$scope.day = 0;
						$scope.hour = 00;
						$scope.minute = 00;
						$scope.second = 00;
					}
					$scope.end = $scope.end - 1;
					if ($scope.end < 0) {
						$interval.cancel($scope.time);
						$state.reload();
					}
				}, 1000);
			}
		}
	};
}]);

/**
 *地图
 */
appBuilder.directive('map', function () {
	// Runs during compile
	return {
		controller: 'MapHeightController',
		restrict: 'AE', // E = Element, A = Attribute, C = Class, M = Comment
		template: '<div id="map"></div>',
		// templateUrl:'',
		replace: true,
		// compile: function(tElement, tAttrs, function transclude(function(scope, cloneLinkingFn){ return function linking(scope, elm, attrs){}})),
		link: function ($scope, iElm, iAttrs, controller) {
			var app = angular.fromJson(localStorage.app);
			$scope.setMapheight();
			// 百度地图API功能
			var map = new BMap.Map("map"); // 创建Map实例
			// 初始化地图,设置中心点坐标和地图级别
			map.centerAndZoom(new BMap.Point($scope.detail.addressLng, $scope.detail.addressLat), 17);
			map.setCurrentCity("北京"); // 设置地图显示的城市 此项是必须设置的
			map.enableScrollWheelZoom(true); //开启鼠标滚轮缩放
			if (!app.iconId) {
				appIcon = viewSrc + '/img/branches_icon_shop_nor.png';
			} else {
				appIcon = '/image/get/' + app.iconId + '';
			}
			var icon = new BMap.Icon(appIcon, new BMap.Size(40, 40));
			var point = new BMap.Point($scope.detail.addressLng, $scope.detail.addressLat); //当前分店坐标
			var marker = new BMap.Marker(point, {
				icon: icon
			});
			map.addOverlay(marker);
			map.panTo(point);

			jQuery('.geo').click(function () {
				//定位
				loader.open();
				var geolocation = new BMap.Geolocation();
				geolocation.getCurrentPosition(function (r) {
					if (this.getStatus() == BMAP_STATUS_SUCCESS) {
						var walking = new BMap.WalkingRoute(map, {
							renderOptions: {
								map: map,
								autoViewport: true
							}
						});
						loader.close();
						walking.search(r.point, point);
					} else {
						txtTips('failed' + this.getStatus());
					}
				}, {
					enableHighAccuracy: true
				});
			});
		}
	};
});

/**
 *分店详情，地图上面的向上按钮
 */
appBuilder.directive('mapupbtn', function () {
	// Runs during compile
	return {
		controller: 'MapHeightController',
		restrict: 'A', // E = Element, A = Attribute, C = Class, M = Comment
		link: function ($scope, iElm, iAttrs, controller) {
			jQuery(iElm).click(function (event) {
				if (jQuery(iElm).hasClass('slidearrow')) {
					jQuery(iElm).removeClass('slidearrow').parents('.up').css('margin-top', 0).siblings('.subshop-detail').removeClass('slideup');
					$scope.setMapheight();
				} else {
					jQuery(iElm).addClass('slidearrow').parents('.up').css('margin-top', '1rem').siblings('.subshop-detail').addClass('slideup');
					$scope.setMapheight();
				}
			});
		}
	};
});

// /**
// *首页顶部按钮下划线
// */
// appBuilder.directive('headerline',['$rootScope',function($rootScope){
//     return {
//         restrict: 'AE', // E = Element, A = Attribute, C = Class, M = Comment
//         template: '<i style="margin-left: {{headermove}}rem"></i>',
//         replace: true,
//         link: function($scope, iElm, iAttrs) {
//             $scope.linemove = function (num) {
//                 $rootScope.headermove = num*2;
//             };
//         }
//     };
// }]);

/**
 *返回顶部
 */
appBuilder.directive('gotop', ['$timeout', function ($timeout) {
	return {
		restrict: 'AE', // E = Element, A = Attribute, C = Class, M = Comment
		template: '<div class="go-top">&uarr;</div>',
		replace: true,
		link: function ($scope, iElm, iAttrs) {
			//滚动回顶部
			jQuery(window).scroll(function (event) {
				var deviceHeight = window.innerHeight;
				var scrollHeight = jQuery(window).scrollTop();
				if (scrollHeight > deviceHeight / 2) {
					jQuery('.go-top').fadeIn();
					jQuery('.go-top').click(function (event) {
						jQuery(window).scrollTop(0);
					});
				} else if (scrollHeight < deviceHeight / 2) {
					jQuery('.go-top').fadeOut();
				}
			});
		}
	};
}]);

/**
 *图片轮播
 */
appBuilder.directive('slideimg', ['$state', '$interval', function ($state, $interval) {
	return {
		restrict: 'AE', // E = Element, A = Attribute, C = Class, M = Comment
		templateUrl: viewSrc + 'partials/slideimg.html',
		scope: {
			imgdata: '@'
		},
		replace: true,
		link: function ($scope, iElm, iAttrs) {
			$scope.imgs = angular.fromJson($scope.imgdata);
			$scope.slideindex = 0; //默认圆点高亮
			$scope.index = 0; //传递手动轮播后的 $scope.slideindex值
			auto = false; //用于自动轮播时判断手动轮播是否被调用
			$scope.goright = function () {
				if ($scope.slideindex > 0) {
					$scope.slideindex = $scope.slideindex - 1;
				} else {
					$scope.slideindex = 0;
				}
				$scope.index = $scope.slideindex;
				auto = true;
			};
			$scope.goleft = function () {
				if ($scope.slideindex < $scope.imgs.length - 1) {
					$scope.slideindex = $scope.slideindex + 1;
				} else {
					$scope.slideindex = 0;
				}
				$scope.index = $scope.slideindex;
				auto = true;
			};
			$scope.time = $interval(function () {
				if (auto) {
					$scope.slideindex = $scope.index;
					auto = false;
				}
				if ($scope.slideindex < $scope.imgs.length - 1) {
					$scope.slideindex = $scope.slideindex + 1;
				} else {
					$scope.slideindex = 0;
				}
			}, 3000);

			//广告跳转
			$scope.goDetail = function (type, resourceType, resourceId, url) {
				//内部广告
				if (type == 1) {
					if (resourceType == 1) $state.go('product-detail', {
						id: resourceId
					}); //产品
					else if (resourceType == 2) $state.go('article-detail', {
						id: resourceId
					}); //文章
				}
				//外部广告
				else if (type == 2) {
					if (url.indexOf('http://') > -1 || url.indexOf('https://') > -1) {
						location.href = url;
					} else {
						location.href = 'http://' + url;
					}
				}
			};
		}
	};
}]);

/**
 *横向滚动菜单（促销顶部、文章中心顶部）
 *调用方法：<swipemenu discount="5" diswidth="2"></swipemenu>
 *参数是必须要的。
 */
appBuilder.directive('swipemenu', function () {
	// Runs during compile
	return {
		restrict: 'AE', // E = Element, A = Attribute, C = Class, M = Comment
		templateUrl: viewSrc + 'partials/swipemenu.html',
		replace: true,
		link: function ($scope, iElm, iAttrs, controller) {
			//为父级增加样式
			jQuery('.swipemenu').parent().css({
				'position': 'relative',
				'overflow': 'hidden'
			});


			//margin-left: {{count*diswidth}}rem;top:{{topnum}}rem;

			$scope.countmax = 0; //菜单数量
			$scope.acount = 0; //菜单默认高亮
			$scope.count = 0; //菜单横向滑动初始值为0
			$scope.diswidth = iAttrs.diswidth; //移动的距离值,例子是2，就是2rem
			$scope.discount = iAttrs.discount; //显示个数

			//菜单竖向滚动
			jQuery(window).scroll(function (event) {
				var deviceHeight = window.innerHeight;
				var scrollHeight = jQuery(window).scrollTop();
				if (scrollHeight === 0) jQuery('.swipemenu').removeClass('fixed');
				else jQuery('.swipemenu').addClass('fixed');
			});
			//菜单左滑
			/* $scope.swipeLeft = function () {
			     $scope.countmax = jQuery('.swipemenu>li').length;
			     if(-$scope.count === ($scope.countmax-$scope.discount)) return '不能左滑了';
			     else $scope.count = $scope.count - 1;
			 };
			 //菜单右滑
			 $scope.swipeRight = function () {
			     if($scope.count===0) return '不能右滑了';
			     else $scope.count = $scope.count + 1;
			 };*/
			//菜单左滑
			$scope.sum = 0; //移动的距离
			$scope.swipeLeft = function () {
				$scope.navmax = jQuery('.swipemenu>li').length;
				if ($scope.count === $scope.navmax - 4) {
					return '不能左滑了';
				} else {
					$scope.count = $scope.count + 1;
					$scope.sum = $scope.sum + jQuery("li:nth-child(" + $scope.count + ")").width() / 37.5 + 0.5;
				}
			};

			//菜单右滑
			$scope.swipeRight = function () {
				if ($scope.count === 0) {
					return '不能右滑了';
				} else {
					$scope.sum = $scope.sum - jQuery("li:nth-child(" + $scope.count + ")").width() / 37.5 - 0.5;
					$scope.count = $scope.count - 1;

				}
			};

		}
	};
});

/**
 *同上
 */
appBuilder.directive('swipenavmenu', function () {
	// Runs during compile
	return {
		restrict: 'AE', // E = Element, A = Attribute, C = Class, M = Comment
		templateUrl: viewSrc + 'partials/swipenavmenu.html',
		replace: true,
		link: function ($scope, iElm, iAttrs, controller) {

			//为父级增加样式
			jQuery('.swipenavmenu').parent().css({
				'position': 'relative',
				'overflow': 'hidden'
			});

			//菜单竖向滚动
			jQuery(window).scroll(function (event) {
				var deviceHeight = window.innerHeight;
				var scrollHeight = jQuery(window).scrollTop();
				if (scrollHeight === 0) jQuery('.swipenavmenu').removeClass('fixed');
				else jQuery('.swipenavmenu').addClass('fixed');
			});

			$scope.navmax = 0;
			$scope.navdiswidth = iAttrs.diswidth; //移动的距离值,例子是2，就是2rem
			$scope.navdiscount = iAttrs.discount; //显示个数
			$scope.anavcount = 0; //菜单默认高亮
			$scope.navcount = 0; //菜单横向滑动初始值为0
			// console.log(iAttrs.discount);
			//菜单左滑
			$scope.navsum = 0; //移动的距离
			$scope.swipeNavLeft = function () {
				$scope.navmax = jQuery('.swipenavmenu>li').length;
				if ($scope.navcount === $scope.navmax - 2) {
					return '不能左滑了';
				} else {
					$scope.navcount = $scope.navcount + 1;
					$scope.navsum = $scope.navsum + jQuery("li:nth-child(" + $scope.navcount + ")").width() / 37.5 + 0.5;
				}
			};

			//菜单右滑
			$scope.swipeNavRight = function () {
				if ($scope.navcount === 0) {
					return '不能右滑了';
				} else {
					$scope.navsum = $scope.navsum - jQuery("li:nth-child(" + $scope.navcount + ")").width() / 37.5 - 0.5;
					$scope.navcount = $scope.navcount - 1;

				}
			};
		}
	};
});

/**
 *产品规格
 *该指令涉及到DOM的操作，所以数据通过父级传入
 */
appBuilder.directive('size', ['$rootScope', 'api', '$cookies', '$state', '$stateParams', 'appCache', 'KillZero',
	function ($rootScope, api, $cookies, $state, $stateParams, appCache, KillZero) {
		// Runs during compile
		return {
			//priority: 999,
			restrict: 'AE', // E = Element, A = Attribute, C = Class, M = Comment
			templateUrl: viewSrc + 'partials/size.html',
			replace: true,
			scope: {
				maxcount: '@', //普通产品的最大数量
				limitnum: '@', //促销产品的最大数量
				promotionprice: '@', //促销价格
				specinfo: '@', //具体的规格数据
				specmaps: '@', //可选规格
				price: '@', //当前规格价格
				imagepath: '@', //当前规格图片
				specvalues: '@', //当前规格值
				needcredit: '@' //所需积分
			},
			link: function ($scope, iElm, iAttrs, controller) {
				//规格数据
				$scope.specInfo = angular.fromJson($scope.specinfo);
				$scope.specValues = angular.fromJson('[' + $scope.specvalues + ']');
				$scope.newprice = $scope.promotionprice || $scope.price;
				var specMaps = angular.fromJson($scope.specmaps);
				var chosedSize = '';
				var j_countbox = jQuery('.count-box');
				$rootScope.maxcount = $scope.maxcount; //全局使用最大库存
				//显示规格
				jQuery('.bar').click(function (event) {
					jQuery('.size').css('left', 0);
					jQuery('body').css({
						'height': window.innerHeight,
						'overflow': 'hidden'
					});
					chosedSize = '';
					$cookies.put('rightStr', getStr());
					//存入默认的产品ID
					//$cookies.put('productID',$stateParams.id);
					j_countbox.attr('data-id', $stateParams.id);
				});

				//隐藏规格
				jQuery('.size-top>i').click(function (event) {
					var inputCount = jQuery('.addcut>input');
					jQuery('.size').css('left', '-10rem');
					jQuery('body').css({
						'height': '100%',
						'overflow': ''
					});
					//拼接已选规格
					jQuery.each(jQuery('.size-container>.size-box'), function (index, val) {
						chosedSize = chosedSize + ',' + jQuery(val).children('a.active').text();
					});
					if (chosedSize.length > 10) {
						chosedSize = chosedSize.substring(1, 10) + '...';
					} else {
						chosedSize = chosedSize.substring(1, chosedSize.length); //去除首位的,
					}
					//$cookies.put('productNum',jQuery('.count-box').find('input').val());
					//有规格的产品跳转存入cookie的产品
					if (jQuery('.size-container>.size-box').hasClass('size-box')) {
						//$cookies.put('chosedSize','<span>已选</span><span class="chosed">'+chosedSize+','+inputCount.val()+'件'+'</span><i></i>');
						jQuery('.bar').html('<span>已选</span><span class="chosed">' + chosedSize + ',' + inputCount.val() + '件' + '</span><i></i>');
						$state.go('product-detail', {
							id: j_countbox.data('id')
						});
					} else {
						//$cookies.put('chosedSize','<span>已选</span><span class="chosed">'+inputCount.val()+'件'+'</span><i></i>');
						jQuery('.bar').html('<span>已选</span><span class="chosed">' + inputCount.val() + '件' + '</span><i></i>');
					}
				});

				//选中规格
				jQuery('.size-container').on('click', '.size-box>a', function (event) {
					//specMaps;//规格表
					//console.log(specMaps);
					//  var j_self = $(this);
					//  var id = j_self.attr('value-id');//已选中ID
					//  var array = [];//第一次点击所匹配数组
					//  var j_size_box = jQuery('.size-box');
					//  var self_index = j_self.parents('.size-box').index();//已选中规格所对应的size-box的index值
					//  var num = 0;
					//  var sizeLength = j_size_box.length;
					//  var activeA = jQuery('a.active');

					//  if(activeA.length<sizeLength){
					//      j_self.addClass('active');
					//  }else{
					//      j_size_box.find('.active').removeClass('active');
					//      j_self.addClass('active');
					//  }

					//  jQuery.each(specMaps, function(key, val) {
					//      var trsArray = val.split(',');
					//      if(trsArray[self_index]==id){
					//          array[num] = trsArray;
					//      }
					//      num += 1;
					//  });

					//  console.log(array);
					// jQuery.each(array, function(indexa, vala) {
					//      jQuery.each(vala, function(indexb, valb) {
					//          if(id==valb&&id.index){

					//          }
					//      });
					// });


					var specMapsLength = 0; //用来记录可选规格的长度
					var lockNum = 0; //对比次数
					var lockStr = ''; //选中的字符串
					var j_activeA = jQuery('.size-container a.active');
					var j_size_box = jQuery('.size-box');
					jQuery(this).addClass('active').siblings('.active').removeClass('active');
					jQuery.each(specMaps, function (index, val) {
						specMapsLength = specMapsLength + 1;
					});

					if (j_activeA.length < j_size_box.length) {
						return;
					}

					lockStr = getStr();

					//与specMaps的规格值进行比对，得出对应的产品ID
					jQuery.each(specMaps, function (index, val) {
						//console.log(lockStr);
						if (lockStr == val) {
							window.hasSize = true;
							$cookies.put('rightStr', lockStr);
							activeSize(lockStr);
							api.get('/api/product/detail/' + index, function (data) {
								disData(data.content);
								//存入此时选中的规格ID
								j_countbox.data('id', data.content.id);
								//$cookies.put('productID',data.content.id);
							});
						} else {
							lockNum = lockNum + 1;
						}
					});
					if (lockNum == specMapsLength) {

						// if(j_size_box.length==3){
						//     j_size_box.children('a.active').removeClass('active');
						//     jQuery(this).addClass('active');
						//     return;
						// }
						//jQuery(this).removeClass('active');
						//activeSize($cookies.get('rightStr'));
						window.hasSize = false;
						txtTips('没有该规格的产品');
					}
				});
				//获取已选中的字符串
				function getStr() {
					var str = '';
					jQuery.each(jQuery('.size-box>a.active'), function (index, val) {
						str = str + jQuery(val).attr('value-id') + ',';
					});
					return str.substring(0, str.length - 1); //得到选中的规格字符串
				}
				//高亮已选规格
				function activeSize(str) {
					jQuery.each(str.split(','), function (index, val) {
						jQuery.each(jQuery('.size-box'), function (indexsize, valsize) {
							if (index == indexsize) {
								jQuery(valsize).find('a[value-id="' + val + '"]').addClass('active').siblings().removeClass('active');
							}
						});
					});
				}
				//展示数据
				function disData(data) {
					$scope.newprice = KillZero(data.promotionPrice) || KillZero(data.price);
					$scope.imagepath = data.imagePath;
					$scope.maxcount = data.promotionLimitInventory || data.inventory;
					$scope.limitnum = data.promotionLimitNum;
					$scope.productID = data.id;
					$rootScope.maxcount = $scope.maxcount; //全局使用最大库存
				}
			}
		};
	}
]);

/**
 *加减
 *该指令存在于规格指令中和购物车中
 */
appBuilder.directive('addcut', ['$rootScope', function ($rootScope) {
	// Runs during compile
	return {
		//priority: 998,
		scope: {
			maxcount: '@',
			limitnum: '@',
			count: '@'
		},
		restrict: 'AE', // E = Element, A = Attribute, C = Class, M = Comment
		templateUrl: viewSrc + 'partials/addcut.html',
		replace: true,
		link: function ($scope, iElm, iAttrs, controller) {
			$scope.max = 0;
			$scope.max = $scope.limitnum || $scope.maxcount;
			$scope.cost = iElm.parents('.price').find('.cost').text();
			//减
			$scope.cutNum = function () {
				if ($scope.count === undefined) return false;
				else if ($scope.count == 1) return false;
				//在购物车内有连续加减的操作，防止用户的快速点击产生过多的异步请求
				//故加入一个全局变量进行限制
				//当该值为1或者undefined时可进行操作，为0将不能执行操作
				//加法亦如此
				if ($rootScope.updateNumTag || $rootScope.updateNumTag === undefined) {
					$scope.count = parseInt($scope.count) - 1;
					$scope.costTotal($scope.cost, $scope.count);
					jQuery(iElm).parents('.count-box').attr('data-num', $scope.count);
				}
			};
			//加
			$scope.addNum = function () {
				if ($scope.count === undefined) return false;
				else if ($scope.count == $scope.max) {
					txtTips('数量已到最大值');
					return false;
				} else {
					if ($rootScope.updateNumTag || $rootScope.updateNumTag === undefined) {
						$scope.count = parseInt($scope.count) + 1;
						$scope.costTotal($scope.cost, $scope.count);
						jQuery(iElm).parents('.count-box').attr('data-num', $scope.count);
					}
				}
			};
			//输
			$scope.inputNum = function () {
				if (parseInt($scope.count) > parseInt($scope.max)) {
					$scope.count = $scope.max;
					$scope.costTotal($scope.cost, $scope.count);
					jQuery(iElm).parents('.count-box').attr('data-num', $scope.count);
				} else if (isNaN($scope.count)) {
					//数量值为NaN，赋值为0
					$scope.count = 0;
					$scope.costTotal($scope.cost, 0);
					jQuery(iElm).parents('.count-box').attr('data-num', $scope.count);
				} else {
					//去除首位的0
					if (parseInt($scope.count.substring(0, 1)) === 0) {
						$scope.count = $scope.count.substring(1, $scope.count.length);
					}
					$scope.costTotal($scope.cost, $scope.count);
					jQuery(iElm).parents('.count-box').attr('data-num', $scope.count);
				}
			};
			//单个总价
			$scope.costTotal = function (cost, count) {
				$scope.total = cost * count;
			};
			//进入购物车计算单个产品的总价
			$scope.costTotal($scope.cost, $scope.count);
		}
	};
}]);

/**
 *购物车
 *购物车内单个产品的计算以及数量加减在addcut指令内，见上
 */
appBuilder.directive('car', ['$http', 'APP_ID', 'api', '$state', '$rootScope', '$stateParams',
	function ($http, APP_ID, api, $state, $rootScope, $stateParams) {
		return {
			restrict: 'A', // E = Element, A = Attribute, C = Class, M = Comment
			link: function ($scope, iElm, iAttrs, controller) {
				var userInfo = angular.fromJson(sessionStorage.userinfo);
				var userId = userInfo.userId;
				//单选产品
				jQuery('.car-main').on('click', '.list i', function (event) {
					var active = jQuery(this).parents('li').hasClass('active');
					if (active) jQuery(this).parents('li').removeClass('active');
					else jQuery(this).parents('li').addClass('active');
					if (jQuery('.list>li').length == jQuery('.list>li.active').length) jQuery('.car-bottom>i').addClass('active');
					else jQuery('.car-bottom>i').removeClass('active');
					car.total(car.activeCost(), car.activeCount());
				});

				//产品数量加减按钮
				jQuery('.list').on('click', 'li .addcut>.add,li .addcut>.cut', function (event) {
					if (jQuery(this).parents('li').hasClass('active')) {
						car.total(car.activeCost(), car.activeCount());
					}
					updateNum(jQuery(this).parents('li').attr('data-id'), jQuery(this).siblings('input').val()); //更新数量
				});

				//产品数量输入框
				jQuery('.list').on('keyup', 'li .addcut>input', function (event) {
					if (jQuery(this).parents('li').hasClass('active')) {
						car.total(car.activeCost(), car.activeCount());
					}
					updateNum(jQuery(this).parents('li').attr('data-id'), jQuery(this).val()); //更新数量
				});

				//点击合计
				jQuery('.car-bottom>i').click(function (event) {
					if (jQuery(this).hasClass('active')) {
						jQuery(this).removeClass('active');
						jQuery('.list>li').removeClass('active');
						car.total(0, 0);
					} else {
						jQuery(this).addClass('active');
						jQuery('.list>li').addClass('active');
						car.total(car.activeCost(), car.activeCount());
					}
				});

				//编辑
				jQuery('a.edit').click(function (event) {
					var j_careditBottom = jQuery('.car-bottom.edit');
					var j_carBottom = jQuery('.car-bottom');
					var activeLength = jQuery('.list>li').length == jQuery('.list>li.active').length;
					var active = j_careditBottom.hasClass('active');
					if (active) {
						jQuery(this).text('编辑');
						j_careditBottom.removeClass('active');
					} else if (!active) {
						jQuery(this).text('完成');
						j_careditBottom.addClass('active');
					}
					if (activeLength) {
						j_careditBottom.children('i').addClass('active');
						j_carBottom.children('i').addClass('active');
					} else if (!activeLength) {
						j_careditBottom.children('i').removeClass('active');
						j_carBottom.children('i').removeClass('active');
					}
				});

				//删除
				jQuery('.car-bottom.edit').on('click', '.deleteItem', function (event) {
					var deleteItem = '';
					var activeLength = jQuery('.list>li.active').length;
					var itemLength = jQuery('.list>li').length;
					if (itemLength && activeLength === 0) {
						txtTips('请选择要删除的产品');
						return;
					}
					jQuery.each(jQuery('.list>li.active'), function (index, val) {
						deleteItem = deleteItem + jQuery(val).attr('car-id') + ',';
					});
					deleteItem = deleteItem.substring(0, deleteItem.length - 1);
					api.post('/api/cart/delete', {
						userId: userId,
						appId: APP_ID,
						cartIds: deleteItem
					}, function (data) {
						if (data.success) {
							location.reload();
						}
					});
				});

				//选择购物车分类
				jQuery('.header>span>i,.header>span>span').click(function (event) {
					jQuery('.car-top').show();
					jQuery('.header>a.edit').hide();
				});
				jQuery('.car-top').on('click', 'li', function (event) {
					jQuery(this).addClass('active').siblings().removeClass('active');
					jQuery('.header>span>span').text(jQuery(this).text());
					jQuery('.car-top').hide();
					jQuery('.header>a.edit').show();
					$state.go('car', {
						type: jQuery(this).data('id')
					});
				});

				//购物车公用方法
				var car = {
					//显示总价
					total: function (price, count) {
						var carPrice = '';
						var carCount = '';
						var j_carPrice = jQuery('.car-bottom').find('.carPrice');
						var j_carCount = jQuery('.car-bottom').find('.carCount');
						if (price === 0) {
							j_carPrice.html('');
							j_carCount.html('');
						} else {
							price = parseFloat(price).toFixed(2);
							if ($stateParams.type == 1) carPrice = '&yen;' + price;
							else carPrice = price + '积分';
							carCount = '(' + count + ')';
							j_carPrice.html(carPrice);
							j_carCount.html(carCount);
						}
					},
					//获取已勾选产品总价
					activeCost: function () {
						var activeCost = 0; //已选中产品总金额
						jQuery.each(jQuery('.list>li.active'), function (index, val) {
							//在指令内已对单个产品的总价进行了计算
							activeCost = activeCost + parseFloat(jQuery(val).find('.addcut').attr('total'));
						});
						return activeCost;
					},
					//获取已勾选产品种数
					activeCount: function () {
						return jQuery('.list>li.active').length;
					}
				};

				//更新数量
				$rootScope.updateNumTag = 1; //阻止用户过快的点击数量加减,在 加减 指令中，引入了该限制条件
				function updateNum(productId, number) {
					if (parseInt(number) === 0) {
						txtTips('数量不能为0');
						return;
					}

					if ($rootScope.updateNumTag) {
						$rootScope.updateNumTag = 0;
						api.post('/api/cart/set', {
							userId: userId,
							appId: APP_ID,
							productId: parseInt(productId),
							number: parseInt(number),
							tag: 2
						}, function (data) {
							if (data.success) $rootScope.updateNumTag = 1;
						});
					}
				}

				//确认订单
				$scope.confirm = function () {
					var cartIds = '';
					var userinfo = angular.fromJson(sessionStorage.userinfo);
					if (jQuery('.list>li.active').length > 0) {
						jQuery.each(jQuery('.list>li.active'), function (key, value) {
							cartIds = cartIds + ',' + jQuery(this).attr('car-id');
						});
						$state.go('confirm', {
							tag: 1,
							cartIds: cartIds.substring(1, cartIds.length),
							cartType: $stateParams.type
						});
					} else if (userinfo.guideId === '') {
						txtTips('请先绑定导购');
						$state.go('choseguide');
						return;
					} else txtTips('请勾选产品');
				};
			}
		};
	}
]);

/**
 *选择地区
 */
appBuilder.directive('chosepart', ['api', 'appCache', function (api, appCache) {
	// Runs during compile
	return {
		//scope: {prodata:'@'}, // {} = isolate, true = child, false/undefined = no change
		// require: 'ngModel', // Array = multiple requires, ? = optional, ^ = check parent elements
		restrict: 'AE', // E = Element, A = Attribute, C = Class, M = Comment
		templateUrl: viewSrc + 'partials/chosepart.html',
		replace: true,
		link: function ($scope, iElm, iAttrs, controller) {
			//选择省
			$scope.chosePro = function (name, id, num) {
				$scope.proName = name;
				$scope.proID = id;
				//重置市
				$scope.cityName = '';
				$scope.cityID = '';
				$scope.cityindex = -1;
				//重置区
				$scope.areadata = [];
				$scope.areaName = '';
				$scope.areaID = '';
				$scope.areaindex = -1;
				$scope.proindex = num;
				if (appCache.get('cityData' + id)) {
					$scope.citydata = appCache.get('cityData' + id);
				} else {
					api.get('/api/public/provincecityareaitems?parentId=' + id, function (data) {
						if (data.success) {
							$scope.citydata = data.content;
							appCache.put('cityData' + id, data.content);
						}
					});
				}
			};
			//选择市
			$scope.choseCity = function (name, id, num) {
				$scope.cityName = name;
				$scope.cityID = id;
				$scope.cityindex = num;
				//重置区
				$scope.areaName = '';
				$scope.areaID = '';
				$scope.areaindex = -1;
				if (appCache.get('areaData' + id)) {
					$scope.areadata = appCache.get('areaData' + id);
				} else {
					api.get('/api/public/provincecityareaitems?parentId=' + id, function (data) {
						if (data.success) {
							$scope.areadata = data.content;
							appCache.put('areaData' + id, data.content);
						}
					});
				}
			};
			//选择区
			$scope.choseArea = function (name, id, num) {
				$scope.areaName = name;
				$scope.areaID = id;
				$scope.areaindex = num;
			};
			//点击确定
			$scope.sure = function () {
				$scope.flagPart = false;
			};
		}
	};
}]);

/**
 *导购
 */
appBuilder.directive('selectguide', ['api', 'APP_ID', 'appCache', '$state', '$stateParams',
	function (api, APP_ID, appCache, $state, $stateParams) {
		// Runs during compile
		return {
			restrict: 'AE', // E = Element, A = Attribute, C = Class, M = Comment
			templateUrl: viewSrc + 'partials/selectguide.html',
			replace: true,
			link: function ($scope, iElm, iAttrs, controller) {
				var userinfo = angular.fromJson(sessionStorage.userinfo);

				//获取导购列表
				$scope.set = function (num) {
					var conWidth = 6.48 * (window.rem / window.dpr);
					console.log(num);
					if (num === undefined) return;
					/*if(appCache.get('branchGuide'+num)){
					    $scope.guide = appCache.get('branchGuide'+num);
					    jQuery('.guide-con').width($scope.guide.length*conWidth);
					}else{*/
					api.get('/api/branch/guide/' + num, function (data) {
						if (data.success) {
							$scope.flag = !$scope.flag;
							$scope.guide = data.content;
							console.log($scope.flag);
							if (!$scope.guide) {
								$scope.flag = !$scope.flag;
								txtTips('该店面暂时没有导购');
								return;
							}
							$scope.style = {
								'height': window.innerHeight
							};
							appCache.put('branchGuide' + num, data.content);
							jQuery('.guide-con').width($scope.guide.length * conWidth);
						}
					});
					//}
				};
				//返回上一层
				$scope.back = function () {
					$scope.flag = !$scope.flag;
					//if($state.is('myguide')) $state.reload();
				};
				//设置导购
				$scope.setGuide = function (id) {
					if (id == userinfo.guideId) {
						$state.go('myguide');
						return;
					}
					api.post('/api/branch/setguide', {
						appId: APP_ID,
						userId: userinfo.userId,
						guideId: id
					}, function (data) {
						txtTips(data.msg);
						if (data.success) {
							//更新用户本地信息
							userinfo.guideId = data.content.guideId;
							sessionStorage.setItem('userinfo', angular.toJson(userinfo));
							appCache.remove('guideinfo');
							if ($stateParams.reurl) $state.go('myguide', {
								reurl: $stateParams.reurl
							});
							else {
								if ($state.is('myguide')) $state.reload();
								else $state.go('myguide');
							}
						}
					});
				};
				//左滑
				$scope.move = 0;
				$scope.swipeLeft = function () {
					// 6.48rem为单个容器的宽度
					if ($scope.move == -6.48 * ($scope.guide.length - 1)) return;
					$scope.move = $scope.move - 6.48;
					$scope.guideStyle = {
						'margin-left': $scope.move + 'rem'
					};
				};
				//右滑
				$scope.swipeRight = function () {
					if ($scope.move === 0) return;
					$scope.move = $scope.move + 6.48;
					$scope.guideStyle = {
						'margin-left': $scope.move + 'rem'
					};
				};
			}
		};
	}
]);

/**
 *数字动画效果
 * data-number="1111"
 */
// appBuilder.directive('animatenumber', function(){
//     // Runs during compile
//     return {
//         link: function($scope, iElm, iAttrs, controller) {
//             jQuery(iElm).animateNumber({ number: iAttrs.number });
//         }
//     };
// });

/**
 *手机号打*号
 * data-phone="138883457052"
 */
appBuilder.directive('phonenumber', function () {
	// Runs during compile
	return {
		restrict: 'A',
		link: function ($scope, iElm, iAttrs, controller) {
			var trs = iAttrs.phone.toString().substr(-8, 4);
			jQuery(iElm).text(iAttrs.phone.toString().replace(trs, '****'));
		}
	};
});

/**
 *上滑加载（翻页）
 * 页面接受数据需要$rootScope
 */
appBuilder.directive('scroll', ['api', 'appCache', '$state', 'APP_ID', '$rootScope', '$stateParams',
	function (api, appCache, $state, APP_ID, $rootScope, $stateParams) {
		// Runs during compile
		return {
			restrict: 'A', // E = Element, A = Attribute, C = Class, M = Comment
			// compile: function(tElement, tAttrs, function transclude(function(scope, cloneLinkingFn){ return function linking(scope, elm, attrs){}})),
			link: function ($scope, iElm, iAttrs, controller) {

				//绑定滚动事件
				jQuery(window).scroll(function (e) {
					var clientHeight = jQuery(window).height(); //设备高度
					var offsetHeight = jQuery('html').height(); //内容高度
					var scrollTop = $(this).scrollTop(); //滚动高度
					//var userinfo = angular.fromJson( sessionStorage.userinfo );
					//console.log('已经到底了');
					if (scrollTop == offsetHeight - clientHeight) {
						/*
						 *不同页面的不同数据接口请求
						 */
						//首页（发现）
						if ($state.is('index.find')) {
							console.log('没有翻页');
							// if(getCacheTag(appCache.get('indexFindCache'))){
							//     getscrollData('/api/index/hotproducts',function (data) {
							//         //数据格式含有多层结构单独处理
							//         var indexData = appCache.get('indexFindCache');
							//         var a = indexData.data.content.hotProducts;
							//         indexData.data.content.hotProducts = a.concat(data.content.hotProducts);
							//         indexData.totalPage = $rootScope.totalPage;//当前页面翻页tag
							//         indexData.currentPage = $rootScope.currentPage;
							//         appCache.put('indexFindCache',indexData); //更新缓存
							//         $rootScope.indexdata = indexData;
							//     });
							// }
						}
						//首页（促销）
						else if ($state.is('index.sale')) {
							var index = jQuery('.swipemenu>li.active').attr('data-index');
							if (getCacheTag(appCache.get('saleMenuCache' + index))) {
								getscrollData('/api/product/promotionproduct/' + jQuery('.swipemenu>li.active').attr('data-id'), function (data) {
									//选项卡数据
									if (!$rootScope.saleMenuData) {
										$rootScope.saleMenuData = [];
									}
									var index = jQuery('.swipemenu>li.active').attr('data-index');
									var saleIndexData = appCache.get('saleMenuCache' + index);
									$rootScope.saleMenuData[index] = updateCache({
										oldData: saleIndexData,
										scrollData: data.content.products,
										cacheName: 'saleMenuCache' + index
									});
								});
							}
						}
						//首页（分店）
						else if ($state.is('index.subshop')) {
							if (getCacheTag(appCache.get('indexSubCache'))) {
								getscrollData('api/branch/list?appId=' + APP_ID, function (data) {
									$rootScope.subshopList = updateCache({
										oldData: appCache.get('indexSubCache'),
										scrollData: data.content.branches,
										cacheName: 'indexSubCache'
									});
								});
							}
						}
						//首页（积分商城）
						else if ($state.is('index.pointmall')) {
							//可兑换积分产品
							if (jQuery('h2.bar>button').hasClass('active')) {
								getscrollData('/api/product/credit', function (data) {
									var f = $rootScope.creditProductsList;
									$rootScope.creditProductsList = f.concat(data.content.creditProducts);
								});
							}
							//全部积分产品
							else {
								if (getCacheTag(appCache.get('creditProductsList'))) {
									getscrollData('/api/product/credit', function (data) {
										$rootScope.creditProductsList = updateCache({
											oldData: appCache.get('creditProductsList'),
											scrollData: data.content.creditProducts,
											cacheName: 'creditProductsList'
										});
									});
								}
							}
						}
						//搜索
						else if ($state.is('search')) {
							getscrollData('/api/product/list', {
								order: jQuery('.menu>li.active').attr('data-id') || null, //当前搜索分类
								orderType: $rootScope.searchtag || 0,
								type: $rootScope.searchtype || 1
							}, function (data) {
								var d = $rootScope.searchList;
								$rootScope.searchList = d.concat(data.content.products);
							});
						}
						//产品首页
						else if ($state.is('product')) {
							var id = $('.swipemenu>li.active').data('id');
							if (getCacheTag(appCache.get('productIndexList' + id))) {
								getscrollData('/api/product/list?&categoryId=' + id, function (data) {
									$rootScope.productList = updateCache({
										oldData: appCache.get('productIndexList' + id),
										scrollData: data.content.products,
										cacheName: 'productIndexList' + id
									});
								});
							}
						}
						//产品列表页
						else if ($state.is('product-list')) {
							if (getCacheTag(appCache.get('productListCache' + $stateParams.id))) {
								getscrollData('/api/product/list?&categoryId=' + $stateParams.id, function (data) {
									$rootScope.productList = updateCache({
										oldData: appCache.get('productListCache' + $stateParams.id),
										scrollData: data.content.products,
										cacheName: 'productListCache' + $stateParams.id
									});
								});
							}
						}
						//产品全部评价页
						else if ($state.is('allComment')) {
							if (getCacheTag(appCache.get('AllProductComment' + $stateParams.id))) {
								getscrollData('/api/product/comment', {
									productId: $stateParams.id
								}, function (data) {
									$rootScope.AllProductComment = updateCache({
										oldData: appCache.get('AllProductComment' + $stateParams.id),
										scrollData: data.content.comments,
										cacheName: 'AllProductComment' + $stateParams.id
									});
								});
							}
						}
						//论坛首页
						else if ($state.is('community')) {
							if (getCacheTag(appCache.get('communityIndexCache'))) {
								getscrollData('/api/forum/list', function (data) {
									$rootScope.communityList = updateCache({
										oldData: appCache.get('communityIndexCache'),
										scrollData: data.content.forums,
										cacheName: 'communityIndexCache'
									});
								});
							}
						}
						//论坛次级列表页   
						else if ($state.is('community-sublist')) {
							if (getCacheTag(appCache.get('communityListCache' + $stateParams.id))) {
								getscrollData('/api/forum/topics?forumId=' + $stateParams.id, function (data) {
									$rootScope.topicsList = updateCache({
										oldData: appCache.get('communityListCache' + $stateParams.id),
										scrollData: data.content.topics,
										cacheName: 'communityListCache' + $stateParams.id
									});
								});
							}
						}
						//成长值
						else if ($state.is('growth')) {
							getscrollData('/api/account/creditrecord', function (data) {
								var e = $rootScope.creditRecordList;
								$rootScope.creditRecordList = e.concat(data.content.records);
							});
						}
						//我的发帖
						else if ($state.is('myCommunity')) {
							//发布的帖子
							if (jQuery('.nav>.community').hasClass('active')) {
								if (getCacheTag(appCache.get('myCommunity'))) {
									getscrollData('/api/forum/topics', function (data) {
										$rootScope.myCommunity = updateCache({
											oldData: appCache.get('myCommunity'),
											scrollData: data.content.topics,
											cacheName: 'myCommunity'
										});
									});
								}
							}
							//发布的帖子评论
							else {
								if (getCacheTag(appCache.get('myCommunityComment'))) {
									getscrollData('/api/comment/mine', {
										tag: 2
									}, function (data) {
										$rootScope.myCommunity = updateCache({
											oldData: appCache.get('myCommunityComment'),
											scrollData: data.content.comments,
											cacheName: 'myCommunityComment'
										});
									});
								}
							}
						}
						//我的评论
						else if ($state.is('myComment')) {
							//产品
							if (jQuery('.nav>.product').hasClass('active')) {
								if (getCacheTag(appCache.get('myProductComment'))) {
									getscrollData('/api/comment/mine', {
										tag: 3
									}, function (data) {
										$rootScope.myProductComment = updateCache({
											oldData: appCache.get('myProductComment'),
											scrollData: data.content.comments,
											cacheName: 'myProductComment'
										});
									});
								}
							}
							//文章
							else {
								if (getCacheTag(appCache.get('myArticleComment'))) {
									getscrollData('/api/comment/mine', {
										tag: 1
									}, function (data) {
										$rootScope.myCommunity = updateCache({
											oldData: appCache.get('myArticleComment'),
											scrollData: data.content.comments,
											cacheName: 'myArticleComment'
										});
									});
								}
							}
						}
						//我的订单
						else if ($state.is('myOrder')) {
							if (getCacheTag(appCache.get('myOrder' + jQuery('.swipemenu>li.active').data('id')))) {
								getscrollData('/api/order/list', {
									tag: 1, //tag为1为普通产品，tag为2为积分商品
									payState: jQuery('.swipemenu>li.active').data('id')
								}, function (data) {
									var myOrderId = jQuery('.swipemenu>li.active').data('id');
									$rootScope.myOrder = updateCache({
										oldData: appCache.get('myOrder' + myOrderId),
										scrollData: data.content.orders,
										cacheName: 'myOrder' + myOrderId
									});
								});
							}
						}
						//我的会员
						else if ($state.is('mymember')) {
							if (getCacheTag(appCache.get('mymembers'))) {
								getscrollData('/api/account/users', function (data) {
									$rootScope.members = updateCache({
										oldData: appCache.get('mymembers'),
										scrollData: data.content.users,
										cacheName: 'mymembers'
									});
								});
							}
						}
						//我的积分记录
						else if ($state.is('mypoint')) {
							if (getCacheTag(appCache.get('myPointRecords'))) {
								getscrollData('/api/account/creditrecord', {
									type: 0
								}, function (data) {
									$rootScope.pointRecords = updateCache({
										oldData: appCache.get('myPointRecords'),
										scrollData: data.content.records,
										cacheName: 'myPointRecords'
									});
								});
							}
						}
						//提成记录   
						else if ($state.is('mine')) {
							var ajaxUrl;
							var params = {};
							var userInfo = angular.fromJson(sessionStorage.userinfo);
							// console.log($scope.records.updateTime);
							//门店管理员
							if (userInfo.roleTag == 'BranchAdmin') {
								ajaxUrl = '/api/order/list';
								params = {
									tag: 1,
									type: 2,
									payState: $rootScope.payState || -1,
									timeEnd: $rootScope.timeEnd,
									timeStart: $rootScope.timeStart
								};
							}
							//非门店管理员
							else if (userInfo.roleTag !== 'AppUser') {
								ajaxUrl = '/api/account/deduct';
								params = {
									timeEnd: $rootScope.timeEnd,
									timeStart: $rootScope.timeStart
								};
							}
							if (getCacheTag(appCache.get('roleRecords'))) {
								getscrollData(ajaxUrl, params, function (data) {
									$rootScope.records = updateCache({
										oldData: appCache.get('roleRecords'),
										scrollData: data.content.orders || data.content.records,
										cacheName: 'roleRecords'
									});
								});
							}
						}
					} else if (scrollTop === 0) {
						//console.log('已经到顶了');
						// var refresh = '<div class="refresh"><img src=viewSrc+"/img/loading.gif"></div>';
					}
				});

				/*
				 *读取缓存内页码
				 */
				function getCacheTag(tag) {
					if (tag === undefined) return true;
					else if (tag.totalPage === undefined) return true;
					else if (tag.totalPage && tag.currentPage) {
						//数据加载完了不再加载
						if (tag.currentPage >= tag.totalPage) {
							txtTips('已经到底了');
							console.log('缓存提示：已经到底了');
							return false;
						} else {
							$rootScope.currentPage = tag.currentPage;
							$rootScope.totalPage = tag.totalPage;
							return true;
						}
					}
				}

				/*
				 *从后台取数据
				 */
				//全局唯一变量
				$rootScope.currentPage = 1;
				$rootScope.totalPage = 2;

				function getscrollData(ajax, params, foo) {
					var userinfo = angular.fromJson(sessionStorage.userinfo);
					if (angular.isFunction(params)) {
						foo = params;
						params = {};
					}
					//没有缓存数据时的提示
					if ($rootScope.currentPage >= $rootScope.totalPage) {
						txtTips('已经到底了');
						console.log('当前页提示：已经到底了');
						return;
					}
					$rootScope.currentPage += 1;
					params.appId = APP_ID;
					params.page = $rootScope.currentPage;
					params.pageCount = 10;
					params.userId = userinfo ? userinfo.userId : null;
					api.get(ajax, params, function (data) {
						$rootScope.totalPage = data.content.pager.totalPage;
						if (data.success) {
							txtTips(data.msg);
							foo(data);
						}
					});
				}

				//更新缓存
				function updateCache(object) {
					var trs = object.oldData; //已有的数据
					//console.log('已有的数据：'+trs);
					object.scrollData = angular.fromJson(object.scrollData); //翻页获得的数据
					if (object.scrollData.length !== 0) {
						object.oldData = trs.concat(object.scrollData); //合并数据到已有数据中
					}
					var newData = object.oldData;
					newData.totalPage = $rootScope.totalPage; //当前页面翻页tag
					newData.currentPage = $rootScope.currentPage; //当前页面翻页tag
					appCache.put(object.cacheName, newData); //存入缓存
					return newData;
				}
			}
		};
	}
]);

/**
 *返回上一页
 */
appBuilder.directive('backpage', ['$state', '$stateParams', 'HOST',
	function ($state, $stateParams, HOST) {
		// Runs during compile
		return {
			restrict: 'A', // E = Element, A = Attribute, C = Class, M = Comment
			link: function ($scope, iElm, iAttrs, controller) {
				var reurl = $stateParams.reurl || sessionStorage.reurl;
				var localHost = localStorage._host;
				jQuery('body').removeAttr('style');
				//点击返回
				jQuery(iElm).on('click', function (event) {
					console.log('reurl：' + reurl);
					if (reurl) {
						reurl = decodeURIComponent(decodeURIComponent(reurl));
						//HOST+reurl是针对“满送”被赠送的产品跳转链接
						//ui-sref="product-detail({id: detail.relateId,reurl: 'product-detail?id='+detail.id+''})"

						if (reurl.indexOf('http') < 0) {
							location.href = HOST + reurl;
						} else {
							if (location.href == reurl || reurl.indexOf('#') == -1) {
								sessionStorage.removeItem('reurl');
								$state.go('index.find');
								return;
							}
							location.href = reurl;
							sessionStorage.removeItem('reurl');
						}
					} else {
						if ($state.is('address')) $state.go('mine');
						else if ($state.is('confirm') || $state.is('car') || $state.is('choseguide')) {
							$state.go('index.find');
						} else history.go(-1);
					}
				});
			}
		};
	}
]);

/**
 *打5星
 */
appBuilder.directive('star', function () {
	// Runs during compile
	return {
		scope: {
			totalstar: '@'
		}, // {} = isolate, true = child, false/undefined = no change
		restrict: 'AE', // E = Element, A = Attribute, C = Class, M = Comment
		templateUrl: viewSrc + 'partials/star.html',
		replace: true,
		link: function ($scope, iElm, iAttrs, controller) {
			$scope.star = function (index) {
				$scope.totalstar = index;
				jQuery(iElm).parents('li').attr('data-userscore', index);
			};
		}
	};
});

/**
 *立即评价
 */
appBuilder.directive('usercomment', ['ResetMyOrderData', '$rootScope', '$stateParams', 'api', '$state', 'appCache', 'handleUserInfo',
	function (ResetMyOrderData, $rootScope, $stateParams, api, $state, appCache, handleUserInfo) {
		// Runs during compile
		return {
			restrict: 'AE', // E = Element, A = Attribute, C = Class, M = Comment
			link: function ($scope, iElm, iAttrs, controller) {
				var commentsList = [];
				var userinfo = angular.fromJson(sessionStorage.userinfo);
				jQuery(iElm).click(function (event) {
					jQuery.each(jQuery('.list>li'), function (index, val) {
						if (jQuery(val).find('textarea').val() === '') {
							txtTips('评价不能为空');
							return;
						}
						var obj = {};
						obj.productId = jQuery(val).data('productid');
						obj.score = jQuery(val).data('userscore');
						obj.content = jQuery(val).find('textarea').val();
						commentsList[index] = obj;
					});
					//跳出循环，数组长度必定不等
					if (jQuery('.list>li').length == commentsList.length) {
						api.post('/api/order/comment', {
							userId: userinfo.userId,
							orderId: $stateParams.orderId,
							data: angular.toJson(commentsList)
						}, function (data) {
							if (data.success) {
								ResetMyOrderData._delete();
								$state.go('myOrder');
								appCache.remove('myOrder7');
								appCache.remove('myProductComment');
								//更新本地用户信息
								handleUserInfo.update();
							}
						});
					}

				});
			}
		};
	}
]);

/**
 *日历
 */
appBuilder.directive('calendar', ['$rootScope', '$state', 'appCache', 'APP_ID', 'api',
	function ($rootScope, $state, appCache, APP_ID, api) {
		return {
			restrict: 'A', // E = Element, A = Attribute, C = Class, M = Comment
			link: function ($scope, iElm, iAttrs, controller) {
				var userinfo = angular.fromJson(sessionStorage.userinfo);
				var endMonth;
				var endDay;
				var date = new Date();
				var year = date.getFullYear();
				var startDate;
				var endDate;
				$rootScope.payState = -1;
				$scope.year = year;
				//对非门店管理员角色隐藏
				if (userinfo.roleTag !== "BranchAdmin") {
					jQuery('.status-name').remove();
					jQuery('.classic-name').remove();
					jQuery('.line').remove();
					jQuery('.week').css('border', 0);
					jQuery('.calendar').css('margin-top', '2rem');
				}
				//获取数据
				function getCord() {
					appCache.remove('roleRecords');
					var startMonth = jQuery('.start').data('month');
					var startDay = jQuery('.start').data('day');
					var endMonth = jQuery('.end').data('month');
					var endDay = jQuery('.end').data('day');


					if (!startMonth && !endMonth) {
						return;
					}

					startDate = new Date(year + ',' + startMonth + ',' + startDay);
					var timeStart = startDate.getTime() / 1000;
					endDate = new Date(year + ',' + endMonth + ',' + endDay);
					var timeEnd = endDate.getTime() / 1000;

					$rootScope.timeStart = timeStart; //时间戳
					$rootScope.timeEnd = timeEnd; //时间戳

					$rootScope.startDate = year + '-' + startMonth + '-' + startDay;
					$rootScope.endDate = year + '-' + endMonth + '-' + endDay;
					console.log($rootScope.startDate);
					console.log($rootScope.endDate);

					if (userinfo.roleTag == 'BranchAdmin') {
						api.get('/api/order/list', {
							type: 2,
							userId: userinfo.userId,
							appId: APP_ID,
							tag: $rootScope.tag || 1,
							payState: $rootScope.payState || -1,
							page: 1,
							pageCount: 10,
							timeStart: timeStart,
							timeEnd: timeEnd
						}, function (data) {
							updateCache(data);
						});
					} else {
						api.get('/api/account/deduct', {
							userId: userinfo.userId,
							appId: APP_ID,
							page: 1,
							pageCount: 10,
							timeStart: timeStart,
							timeEnd: timeEnd
						}, function (data) {
							if (data.success) {
								updateCache(data);
							}
						});
					}
				}

				//更新缓存
				function updateCache(data) {
					if (data.content.orders && !data.content.orders.length) {
						txtTips('没有此时间段的订单');
						return;
					} else if (data.content.records && !data.content.records.length) {
						txtTips('没有此时间段的订单');
						return;
					}
					var ajaxData = data.content.records || data.content.orders;
					ajaxData.totalPage = data.content.pager.totalPage;
					ajaxData.currentPage = data.content.pager.currentPage;
					ajaxData.sum = data.content.sum;
					appCache.put('roleRecords', ajaxData);
					$state.go('mine');
				}

				//显示菜单
				jQuery('.menu').on('click', '.status-name,.classic-name', function (event) {
					var bgHeight = window.innerHeight - jQuery('.header').height() - jQuery('.menu').height() - 10;
					var j_this = jQuery(this);
					jQuery('.chose-con').show(100, function () {
						if (j_this[0].className.indexOf('status') === 0) {
							jQuery('.classic').hide();
							jQuery('.status').show();
						} else if (j_this[0].className.indexOf('status') == -1) {
							jQuery('.status').hide();
							jQuery('.classic').show();
						}
						jQuery(this).find('.bg').css('height', bgHeight);
					});
				});
				//选中菜单
				jQuery('.chose-con').on('click', 'ul>li', function (event) {
					jQuery(this).addClass('active').siblings('li').removeClass('active');
					if (jQuery(this).parent('ul').hasClass('status')) {
						jQuery('.status-name>span').text(jQuery(this).text());
						$rootScope.payState = jQuery(this).data('status');
						getCord();
						console.log('订单状态：' + $rootScope.payState);
					} else {
						jQuery('.classic-name>span').text(jQuery(this).text()).parent('li').addClass('active');
						$rootScope.tag = jQuery(this).data('classic');
						getCord();
						console.log('订单类别：' + $rootScope.tag);
					}
					jQuery('.chose-con').hide();
					// if(jQuery('.chose-con').find('li.active').length==2){
					//     jQuery('.calendar,.week').css('visibility', 'visible');
					// }
				});
				//绑定操作
				jQuery('.calendar').on('click', '.list>div', function (event) {
					var hasStart = jQuery('.start').hasClass('start'); //已有开始
					var hasEnd = jQuery('.end').hasClass('end'); //已有结束
					var startMonth = jQuery('.start').data('month');
					var startDay = jQuery('.start').data('day');

					//选开始时间
					if (!hasStart && !hasEnd || hasStart && hasEnd) {
						if (hasStart && hasEnd) {
							jQuery('.start').removeClass('start').children('.tag').text(' ');
							jQuery('.end').removeClass('end').children('.tag').text(' ');
							jQuery(this).addClass('start').children('.tag').text('开始');
						} else {
							jQuery(this).addClass('start').children('.tag').text('开始');
						}
					}
					//选结束时间
					else if (hasStart && !hasEnd) {
						endMonth = jQuery(this).data('month');
						endDay = jQuery(this).data('day');
						if (endMonth > startMonth) {
							jQuery(this).addClass('end').children('.tag').text('结束');
							getCord();
						} else if (endMonth == startMonth && endDay > startDay) {
							jQuery(this).addClass('end').children('.tag').text('结束');
							getCord();
						} else {
							txtTips('结束时间不能早于开始时间');
						}
					}

				});
			}
		};
	}
]);


/*
 *显示赠送产品
 */
appBuilder.directive('showsendproduct', ['$rootScope', function ($rootScope) {
	// Runs during compile
	return {
		link: function ($scope, iElm, iAttrs, controller) {
			var dHeight = window.innerHeight;
			//显示浮层
			jQuery(iElm).on('click', function (event) {
				jQuery('body').css({
					height: dHeight,
					'overflow': 'hidden'
				});
				jQuery('.show-send-product').css({
					height: dHeight,
					left: 0
				});
			});

		}
	};
}]);

/*
 * 没有数据
 * 当路由没有传递数据时，此指令接受不到值！！！！！
 */
appBuilder.directive('nodata', ['$rootScope', function ($rootScope) {
	// Runs during compile
	return {
		restrict: 'AE', // E = Element, A = Attribute, C = Class, M = Comment
		templateUrl: viewSrc + 'partials/nodata.html',
		scope: {
			dis: '@'
		},
		replace: true,
		link: function ($scope, iElm, iAttrs, controller) {
			var data_length = $scope.dis;
			var w_height = jQuery(window).height();
			var div_height = jQuery(iElm).find('div').height();
			var j_nodata = jQuery(iElm);
			j_nodata.height(w_height);
			j_nodata.find('div').css({
				'margin-top': (w_height - div_height) / 2
			});
			console.log(data_length);
			if (data_length > 0) {
				j_nodata.hide();
			} else {
				j_nodata.show();
			}
		}
	};
}]);

/*
 * 查看图片
 */
appBuilder.component('lookphoto', {
	templateUrl: viewSrc + 'partials/community.photo.html',
	bindings: {
		data: '='
	},
	controller: function () {
		var _win_height = jQuery(window).height();
		var _win_width = jQuery(window).width();

		this.isShow = 'none';
		this.max = this.data.length;
		this.imgMaxHeight = _win_height * 0.9;
		this._move_val = 0;
		this._photo_height = _win_height;
		this._photo_width = _win_width * this.max;

		this.showPhoto = function (index) {
			this._move_val = -index * 10;
			this.isShow = 'block';
		};

		this.hidePhoto = function () {
			this.isShow = 'none';
		};

		this.runright = function () {
			if (this._move_val === 0) {
				return;
			}
			this._move_val = this._move_val + 10;
		};

		this.runleft = function () {
			if (this._move_val == -10 * (this.max - 1)) {
				return;
			}
			this._move_val = this._move_val - 10;
		};
	}
});