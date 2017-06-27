/*确认订单*/
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
