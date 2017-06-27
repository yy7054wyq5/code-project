/*非洲攻略--合作伙伴*/
else if($('body>.header>.banner.partner').hasClass('partner')){
	$('.header-menu>li a[strategy]').addClass('active');
	$('a[strategy]').siblings('ul').find('li:nth-child(3)').children('a').css({
		'background': '#f3eded'
	});

	//tab
	var partnerData = [];
	$(document).on('click', '.tab-partner>a', function(event) {
		$(this).addClass('active').siblings().removeClass('active');
		var index = $(this).index();
		var $list = $($('.list')[index]);
		$list.addClass('active').siblings('.active').removeClass('active');
		if(partnerData[index]){
			$list.html(creatPartner(partnerData[index]));
			return;
		}
		api('post','/partner/get-partner',{
			categoryId: $(this).data('id'),
			pageIndex: 1,
			pageSize: 100
		},function (res) {
			var html = '';
			if(!res.status){
				var data = res.data.partners;
				if(!data.length){
					layer.msg( trsLang('no_data') );
				}else{
					var name;
					partnerData[index] = data;
					$list.html(creatPartner(partnerData[index]));
				}
			}
		});
	});
}
