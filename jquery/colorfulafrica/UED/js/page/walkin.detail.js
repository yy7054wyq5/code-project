/*走进非洲--详情*/
else if($('body>.header>.banner.walkin-detail').hasClass('walkin-detail')){
	$('.header-menu>li>a[walkin]').addClass('active');
	cutRightMargin($('.food-box>div'),4);
	cutRightMargin($('.photo-box>div'),3);
	cutRightMargin($('.partner-box>a'),4);
	$('body').append('<div class="float-tabs" style="display:none;"></div>');
	$('.float-tabs').html($('.line-detail>.tabs').html()).css({
		left: ($('body').width()-1180)/2,
		top: 0,
		width: 1180,
		'position': 'fixed',
		'z-index': 999999
	});
	$(document).scroll(function(event) {
		var scrollTop = $('body').scrollTop();
		if(scrollTop>550){
			$('.float-tabs').show();
			$('.tabs').css('visibility', 'hidden');
		}else{
			$('.tabs').css('visibility', 'visible');
			$('.float-tabs').hide();
		}
	});

	$(document).on('click', '.float-tabs>a,.tabs>a', function(event) {
		if($(this).parent().hasClass('tabs')){
			$(this).addClass('active').siblings().removeClass('active');
			$('.float-tabs>a').removeClass('active');
			$($('.float-tabs>a')[$(this).index()]).addClass('active');
		}
		else{
			$(this).addClass('active').siblings().removeClass('active');
			$('.tabs>a').removeClass('active');
			$($('.tabs>a')[$(this).index()]).addClass('active');
		}
	});

}