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
