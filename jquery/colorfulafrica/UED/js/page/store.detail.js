/*商城详情*/
else if($('body>.header>.banner.store-detail').hasClass('store-detail')){
	var $input = $('.addcut>input');
	$('.header-menu>li a[store]').addClass('active');
	//相册
	$('#thumblist').on('click', '>li', function(event) {
		$(this).siblings('li').removeClass('active');
		$('.show-img').find('img').attr('src', $(this).addClass('active').find('img').attr('src'));
	});
	//tab
	$('.abb>a').click(function(event) {
		$(this).siblings('a').removeClass('active');
		$('.'+$(this).addClass('active').attr('tab')+'').show().siblings('div.tab-con').hide();
	});
	//选规格
	$(document).on('click', '.size>a', function(event) {
		$(this).addClass('active').siblings('a.active').removeClass('active');
	})
	//加
	.on('click', '.addcut>.add', function(event) {
		var val = $input.val();
		if(isNumber(val)){
			$input.val(parseInt(val)+1);
		}
	})
	//减
	.on('click', '.addcut>.cut', function(event) {
		var val = $input.val();
		if(isNumber(val)&&val>1){
			$input.val(parseInt(val)-1);
		}
	})
	//输
	.on('keyup', $input, function(event) {
		var val = $input.val();
		//console.log(isNumber(val));
		if(!isNumber(val)){
			$input.val(1);
		}
	});
}