var appBuilderService = angular.module('appBuilderService',[]);
var appBuilderFactory = angular.module('appBuilderFactory',[]);

/*
*重新封装ajax请求，加个loading
*params格式：{key1:value1,key2:value2}
*/
appBuilderFactory.factory('api', ['$http','API_SALT','KillZero','$state', 
function($http,API_SALT,KillZero,$state){
	//生成sign
	function createSign(params) {
		// console.log(params);
		var params_array = [];
		//转成数组
		angular.forEach(params,function (val,key) {
			//中文转unicode字符串
			if(angular.isObject(val)){
				var trs = val;
				val = '';//清空该对象的value值
				angular.forEach(trs,function (value,index) {
					var _value;
					//判断是否含有中文
					if(/.*[\u4e00-\u9fa5]+.*$/.test(value)){
						_value = escape(value).toLocaleLowerCase().replace(/%u/gi, '\\u');
					}else{
						_value = value;
					}
					//判断是否是数字
					if(angular.isNumber(value)){
						val += '"'+index+'":'+_value+',';
					}else{
						val += '"'+index+'":"'+_value+'",';
					}
				});
				val = '{'+val.substring(0,val.length-1)+'}';
				val = val.replace(/,/g,';');
			}else if(key=='sign'){
				//不让返回的sign进入加密队列
				return;
			}
			params_array.push(key+'='+val); 
		});
		//按字母排序后转成字符串
		var str = params_array.sort().toString();
		// console.log(str);
		var result = str.replace(/,/g,'&');
		if(result.indexOf('content')>-1){
			result = result.replace(/;/g,',');
		}
		//console.log(result.replace(/\//g,'\\\/'));
		//console.log('{"userId":121,"nickname":"qwe123","email":"","mobile":"18580035120","group":"CommonUser","roleId":"4","appId":10,"name":"","coverId":"","sex":0,"signature":"\u8fd9\u5bb6\u4f19\u5f88\u806a\u660e\uff0c\u6492\u90fd\u6728\u6709\u5199","currentAppId":10,"branchId":13,"guideId":120,"userRankId":17,"growthScore":50,"credits":50,"userRankName":"\u82f1\u52c7\u9ec4\u94dc","userRankIcon":687,"startCredit":20,"roleName":"APP\u7528\u6237","roleTag":"AppUser","imagePath":"http:\/\/appbuilder\/img\/web\/userDefault.png","userRankIconPath":"http:\/\/appbuilder\/uploads\/img\/product\/2016-08\/400057b67fb6f434f5ee4959324043d1.png","commentNum":0}');
		console.log(hex_md5(result.replace(/\//g,'\\\/')+API_SALT));
		return hex_md5(result.replace(/\//g,'\\\/')+API_SALT);
	}

	return {
		get: function (url,params,foo,isloader) {
			url =  reqHost + url;
			if(!isloader){
				loader.open();
			}
			if(angular.isFunction(params)) foo = params;
			//console.log(createSign(params));
			if(!params){
				params = {};
			}
			//超时
			params.timeout = 5000;
			//加密参数
			params.sign = createSign(params);
			
			return $http.get(url,{params: params}).
				success(function(data, status, headers, config) {
					loader.close();
					//if(!data.success) txtTips(data.msg);

					if(data.content){
						//回调前去0，若没有回调，需要单独对请求的数据做去0操作
						if(data.content.products){
							data.content.products = KillZero(data.content.products,url);
						}else if(data.content.hotProducts){
							data.content.hotProducts = KillZero(data.content.hotProducts,url);
						}else if(data.content.newProducts){
							data.content.newProducts = KillZero(data.content.newProducts,url);
						}else if(data.content.orders){
							data.content.orders = KillZero(data.content.orders,url);
						}
					}
					
					if(angular.isFunction(foo)) foo(data,status,headers,config);
				}).
				error(function(data, status, headers, config) {
					loader.close();
					txtTips('请求失败，请稍后再试');
				});

		},
		post: function (url,params,foo) {
			url =  reqHost + url;
			loader.open();
			if(angular.isFunction(params)) foo = params;
			if(!params){
				params = {};
			}
			//超时
			params.timeout = 5000;
			//加密参数
			params.sign = createSign(params);
			
			return $http.post(url,params).
			 	success(function(data, status, headers, config) {
			 		loader.close();
			 		if(!data.success) txtTips(data.msg);

			 		if(data.content){
			 			//回调前去0，若没有回调，需要单独对请求的数据做去0操作
			 			if(data.content.products){
			 				data.content.products = KillZero(data.content.products);
			 			}else if(data.content.hotProducts){
			 				data.content.hotProducts = KillZero(data.content.hotProducts);
			 			}else if(data.content.newProducts){
			 				data.content.newProducts = KillZero(data.content.newProducts);
			 			}else if(data.content.orders){
			 				data.content.orders = KillZero(data.content.orders);
			 			}
			 		}
			 		
			  		if(angular.isFunction(foo)) foo(data,status,headers,config);
			  	}).
			 	error(function(data, status, headers, config) {
			 		loader.close();
			 		txtTips('请求失败，请稍后再试');
			 	});
		}
	};
}]);

//APP缓存
appBuilderFactory.factory('appCache', ['$cacheFactory', function($cacheFactory) {
    return $cacheFactory('app_cache');
}]);

/**
*URL取参
*例子:http://xxoo.com?name=dada&age=120&height=200
*set('color','red')：为URL添加参数,返回http://xxoo.com?name=dada&age=120&height=200&color=red的字符串
*getParam()：获取URL内参数,返回name=dada&age=120&height=200的字符串,便于异步请求数据
*markValue('color')：返回red,如果没有该key,返回undefined
*/
appBuilderFactory.factory('handleURL', function(){
	return {
	    set: function (key,value,href) {
			var URL;
			if(href===undefined){
				href = location.href;
			}
			var index = href.indexOf('?');
			if(index<0){//url没有参数
				URL = href + '?'+key+'='+value;
			}
			else{//url已有参数
				var keyIndex = href.indexOf(key);
				if(keyIndex<0){//url没有该参数
					URL = href +'&'+key+'='+value;
				}
				else if(keyIndex>0){//url有该参数
					var a = href.substring(0,keyIndex);
					var b = href.substring(keyIndex,href.length);
					if(b.indexOf('&')<0){//该参数在最后
						b = b.substring(0,b.indexOf('=')+1) + value;
						URL = a + b;
					}
					else{//该参数不在最后
						var c = b.substring(b.indexOf('&'),b.length);
						b = b.substring(0,b.indexOf('=')+1) + value;
						URL = a + b + c;
					}
				}
			}
			return URL;
	    },
	    getParam: function (Href) {
			if(Href===undefined){
				Href = location.href;
			}
			var param ='';
			var index = Href.indexOf('?');
			if(index<0){
				param = null;
			}
			else{
				param = Href.substr(index+1,Href.length);
			}
			return param;
	    },
	    markValue: function (key,href) {
	    	var Href;
	    	if(!href){
	    		Href = location.href;
	    	}else{
	    		Href = href;
	    	}
	    	var index = Href.indexOf(key);
	    	if(index<0){
	    	    return undefined;
	    	}
	    	else{
	    	    var a = Href.substring(index,Href.length);
	    	    var b;
	    	    var aindex = a.indexOf('&');
	    	    if(aindex<0){
	    	        b = a.substring(key.length+1,a.length);
	    	    }
	    	    else{
	    	        b = a.substring(key.length+1,aindex);
	    	    }
	    	    return b;
	    	}
	    }
	};
});

/**
*更新用户积分
*/
appBuilderFactory.factory('handleUserInfo', ['api','APP_ID',
function(api,APP_ID){
	return {
		update: function (key,value) {
			var userinfo = angular.fromJson(sessionStorage.userinfo);
			//获取用户最新信息
			api.post('/api/account/update',{
				userId: userinfo.userId,
				appId: APP_ID
			},function (data) {
				if(data.success==1){
					sessionStorage.setItem('userinfo',angular.toJson(data.content));
				}
			});		
		}
	};
}]);

/**
*重置我的订单的数据
*/
appBuilderFactory.factory('ResetMyOrderData', ['api','APP_ID','appCache',
function(api,APP_ID,appCache){
	return {
		_delete: function () {
			for (var i = -1; i < 7; i++) {
				appCache.remove('myOrder'+i);
			}
		}
	};
}]);

/**
*去掉价格后面多余的0
* 参数：数组，对象或字符串
* 返回：相对应的数据
*/
appBuilderFactory.factory('KillZero', ['$state', function($state){
	return function (data,url) {
		// console.log('开始处理数据--KillZero');
		var _new_data;

		function getLastString (val) {
			val = val.toString();
			if(val.length==1){
				val = val;
			}else{
				val = val.substring(val.length-1,val.length);
			}
			return val;
		}

		if(!data){
			console.log('当你看到这个log时，或许是你传的值不对或未定义----------来自于KillZero的日志');
			return;
		}

		if(url){
			// console.log('数据来源（'+url+'）--KillZero');
		}

		if(angular.isArray(data)){//数组
			// console.log('数据是数组--KillZero');
			_new_data = [];
			angular.forEach(data,function (val,key) {
				var _new_obj = '';
				angular.forEach(val,function (value,keyword) {
					if(keyword.indexOf('price')>-1||keyword.indexOf('Price')>-1){
						//当价格为数字0时抛出
						if(value.toString().indexOf('.')>-1){
							if(getLastString(value)=='0'){
								value = value.substring(0,value.length-1);
								if(getLastString(value)=='0'){
									value = value.substring(0,value.length-2);
								}
							}
						}
					}
					if(angular.isArray(value)){
						// console.log('数据有嵌套--KillZero');
						var _new_array_A = '';
						//遍历数组
						angular.forEach(value,function (vval,kkey) {
							/////////////////////////////////////////
							var _new_array_a = '';
							//遍历json对象
							angular.forEach(vval,function (_val,_key) {
								/////////////////////////////////////////
								if(_key.indexOf('price')>-1||_key.indexOf('Price')>-1){
									//当价格为数字0时抛出
									if(_val.toString().indexOf('.')>-1){
										if(getLastString(_val)=='0'){
											_val = _val.substring(0,_val.length-1);
											if(getLastString(_val)=='0'){
												_val = _val.substring(0,_val.length-2);
											}
										}
									}
								}
								_new_array_a += '"'+ _key + '":"' + _val + '",';
								/////////////////////////////////////////
							});
							_new_array_A += '{' + _new_array_a.substring(0,_new_array_a.length-1) +'},' ;
							/////////////////////////////////////////							
						});
						//console.log(_new_array_A);
						value = '';
						value = '['+ _new_array_A.substring(0,_new_array_A.length-1) +']';
					}else if(!angular.isArray(value)){
						value = '"'+ value +'"';
						//console.log(keyword+':'+value);
						//在确认订单页有产品详情的HTML结构，影响字符串合并，这里直接重新赋值
						if(value.indexOf('<p>')>-1&&keyword=='detail'){
							value = '"这原本是HTML结构字符串，在JS内经过KillZero方法重新赋值了!!!!!!"';
						}
					}
					_new_obj += '"'+ keyword + '":' + value + ',';//在json中，数组字符串不要打双引号

				});
				_new_obj  = angular.fromJson('{'+_new_obj.substring(0,_new_obj.length-1)+'}');
				_new_data.push(_new_obj);
			});
		}else if(angular.isObject(data)){//数据为对象
			// console.log('数据是对象--KillZero');
			var _new_array_a = '';
			//遍历json对象
			angular.forEach(data,function (_val,_key) {
				if(_key.indexOf('price')>-1||_key.indexOf('Price')>-1){
					//当价格为数字0时抛出
					if(_val.toString().indexOf('.')>-1){
						if(getLastString(_val)=='0'){
							_val = _val.substring(0,_val.length-1);
							if(getLastString(_val)=='0'){
								_val = _val.substring(0,_val.length-2);
							}
						}
					}
				}
				_new_array_a += '"'+ _key + '":"' + _val + '",';
			});
			return angular.fromJson('{'+_new_array_a.substring(0,_new_array_a.length-1)+'}');
		}
		else{//非数组
			// console.log('数据是字符串--KillZero');
			//当价格为数字0时抛出
			if(data.toString().indexOf('.')>-1){
				if(getLastString(data)=='0'){
					data = data.substring(0,data.length-1);
					if(getLastString(data)=='0'){
						data = data.substring(0,data.length-2);
					}
				}
			}
			_new_data = data;
		}
		return _new_data;

	};
}]);