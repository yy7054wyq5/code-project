/*我的订单*/
else if($('.user-container').hasClass('order')){
	$('.menu>a.order').addClass('active');
	
	//异步加载数据
	$('.user-tab>a,.loading-more').click(function(event) {
		var $self = $(this);
		var $activeA = $('.user-tab>a.active');
		var tag = $self.data('tag');
		var $list = $('.list[data-tag="'+tag+'"]');
		var currentPage = $self.data('currentpage') || $activeA.data('currentpage');
		var totalPage = $activeA.data('totalpage') || null;

		$('.no-product').hide();
		$('.loading-more').show();
		
		if($list.html()&&!$self.hasClass('loading-more')){
			return;
		}else if($self.hasClass('loading-more')){
			tag = $activeA.data('tag');
			$list = $('.list[data-tag="'+tag+'"]');
			currentPage = parseInt(currentPage) + 1;
			totalPage = $activeA.data('totalpage');
			if(currentPage>totalPage&&totalPage){
				layer.msg( trsLang('no_data') );
				return false;
			}
		}else if($self.find('span').text()===0){
			//console.log('没有的不能点击');
			return;
		}
		//console.log('类型：'+tag);
		//console.log('当前页'+currentPage);
		getOrderList(tag,currentPage);
	
	});

	//去支付
	$(document).on('click', '.go-pay', function(event) {
		var orderId = $(this).parents('li[data-orderid]').data('orderid');
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
	})
	//确认收货
	.on('click', '.receive-good', function(event) {
		api('post','/user/operate-order',{
			orderId: $(this).parents('li[data-orderid]').data('orderid'),
			tag: 1
		},function (res) {
			layer.msg(res.msg);
			if(!res.status){
				location.reload();
			}
		});
	});
}