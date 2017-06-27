/*多彩商城--线下门店*/
else if($('body>.header>.banner.offline').hasClass('offline')){
	$('.header-menu>li a[store]').addClass('active');
	$('a[store]').siblings('ul').find('li:last-child').children('a').css({
		'background': '#f3eded'
	});

	/*地图事件*/
	$(document).on('click', '.store-address', function(event) {
		//获取动画过渡时间，清空信息窗并隐藏
		var duringTime = $('.dis-address').hide().html('').css('transition-duration');
		duringTime = duringTime.substring(0,duringTime.length-1)*1000;
		//回到点击处
		$('.dis-address').css({
			width: 49,
			height: 55,
			right: $(this).css('right'),
			top: $(this).css('top')
		});
		//信息窗内容
		var $info = $(this).children('.info').children('div');
		var content = '登陆首都北京,在北京厚重的文化底蕴中,同样展现的是线上销售和线下体验的完美模式。不仅开辟了网购的新时代,而且还为北京消费者带来全新的购置体验。';
		var html =  '<h2>'+$info.text()+'</h2>'+
			'<img src="'+$info.data('imgsrc')+'">'+
			'<p>'+content+'</p>'+
			'<span class="address"><i></i><span>'+$info.data('address')+'</span></span>'+
			'<span class="phone"><i></i><span>'+$info.data('phone')+'</span></span>'+
			'<a href="'+$info.data('link')+'">'+trsLang('view_details')+'</a>';
		//显示信息窗之后改变大小以及定位
		$('.dis-address').show(100,function () {
			$('.dis-address').css({
				width: 489,
				height: 551,
				right: 500,
				top: 0
			});	
		});
		//动画过渡时间过后装载内容
		setTimeout(function () {
			$('.dis-address').html(html);
		},duringTime);
		
	});
}