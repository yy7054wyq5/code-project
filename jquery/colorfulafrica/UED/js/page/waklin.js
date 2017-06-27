/*走进非洲*/
else if($('body>.content>div.container').hasClass('walkin')){
	$('.header-menu>li>a[walkin]').addClass('active');
	//异步
	var wcurrentPage = 1;
	$('.container.walkin').on('click', '.tab>a,.input>a,.loading-more', function(event) {
		var $partner = $('.partner-item');
		$partner.hide();
		if($(this)[0].nodeName=='A'){
			$(this).addClass('active').siblings('.active').removeClass('active');
			wcurrentPage = 1;
			//tab点击时清空搜索框
			if(!$(this).parent().hasClass('input')){
				$('.input>input').val('');
			}
			$('.list').html('');
		}
		else if($(this).hasClass('loading-more')){
			wcurrentPage += 1;
		}
		api('post','/walkin/get-line',{
			pageIndex: wcurrentPage,
			pageSize: 6,
			countryId: $('.tab.country>a.active').data('id'),
			keyword: $('.input>input').val(),
			categoryId: $('.tab.category>a.active').data('id')
		},function (res) {
			var html = '';
			if(!res.status){
				if(res.data.partner!==''){
					var partnerData = res.data.partner;
					$partner.children().remove();
					$partner.append('<h2>'+trsLang('releatived_partner')+'</h2>'+
						'<img src="/image/get/'+partnerData.picKey+'" style="width:450px;height:300px" alt="450x300">'+
					'<ul>'+
						'<li class="title">'+partnerData.name+'</li>'+
						'<li>'+partnerData.summary+'</li>'+
						'<li>'+trsLang('phone')+'：'+partnerData.telephone+'</li>'+
						'<li>'+trsLang('mobile')+'：'+partnerData.mobile+'</li>'+
						'<li>'+trsLang('tax')+'：'+partnerData.tax+'</li>'+
						'<li>'+trsLang('email')+'：'+partnerData.email+'</li>'+
						'<li>'+trsLang('address')+'：'+partnerData.address+'</li>'+
						'<li></li>'+
					'</ul>').show();
				}
				if(res.data.line.length===0){
					layer.msg( trsLang('no_data') );
					return;
				}
				$.each(res.data.line, function(index, val) {
					html +=
					'<li>'+
					'<a href="/'+getLang()+'/walkin/detail/'+val.id+'">'+
						'<img src="/image/get/'+val.picKey+'" style="width:320px;height:230px" alt="320x230">'+
						'<ul>'+
							'<li class="title">'+val.name+'</li>'+
							'<li class="content">'+val.summary+''+
							'</li>'+
							'<li class="info">'+
								'<i class="love"></i>'+
								'<span class="love-person">'+val.favoriteNum+'</span>'+
								'<i class="comment"></i>'+
								'<span class="comment-person">'+val.commentNum+'</span>'+
								'<span class="price">'+trsLang('consult_price')+'<span>'+val.feeStart+'-'+val.feeEnd+'</span>'+trsLang('percost')+'</span>'+
							'</li>'+
						'</ul>'+
					'</a>'+
					'</li>';
				});
			}
			$('.list').append(html);
		});
	});
	
	//class="mousetrap"

	//回车搜索
	$('.input>input').focus(function(event) {
		Mousetrap.bind('enter', _line_Search,'keydown');
	});
	$('.input>input').blur(function(event) {
		Mousetrap.unbind('enter');
	});
}