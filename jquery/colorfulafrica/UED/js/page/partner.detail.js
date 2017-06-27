/*非洲攻略--合作伙伴--详情*/
else if($('body>.header>.banner.partner-detail').hasClass('partner-detail')){
	$('.header-menu>li a[strategy]').addClass('active');
	$('.img-con').slideimg({
		width: 1180,
		height: 420,
		ratio: 0.5,
		top: 0,
		containerWidth: 1180,
		autoTime: 5000
	});
}
