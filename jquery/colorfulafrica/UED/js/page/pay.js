/*评价订单*/
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