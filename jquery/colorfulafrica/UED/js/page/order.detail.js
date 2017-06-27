/*订单详情*/
else if($('.user-container').hasClass('orderdetail')){
	$('.menu>a.order').addClass('active');
	$('.shipping>.title>a').click(function(event) {
		if($(this).hasClass('active')){
			$(this).removeClass('active');
			$('.shipping>.detail').show();
		}
		else{
			$(this).addClass('active');
			$('.shipping>.detail').hide();
		}
	});

	//去支付
	$(document).on('click', '.go-pay', function(event) {
		var orderId = $(this).data('id');
		api('post','/user/create-order',{
			orderId: orderId,
			userId: Cookies.get('userId')
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

}