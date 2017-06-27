else if($('.container').hasClass('search')){
	$('.header.user').css('background', '#fafafa');
	$('.header.user .header-btn>a').css('color', '#333333');
	$('.header.user .header-btn>i.car').addClass('black').css('margin', 0);

	$('.trs>a').css('color', '#333333');

	$('.search-tab>a').click(function(event) {
		var tag = $(this).data('tag');
		$(this).addClass('active').siblings('.active').removeClass('active');
		if(tag=='all'){
			$('.con').show();
			return;
		}
		$('.con.'+tag+'').show().siblings('.con').hide();
	});

	$('.search-btn').click(function(event) {
		searchPage();
	});

	$('.search-con>input').focus(function(event) {
		Mousetrap.bind('enter', searchPage, 'keydown');
	});
	$('.search-con>input').blur(function(event) {
		Mousetrap.unbind('enter');
	});
}