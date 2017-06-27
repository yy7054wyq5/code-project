//发布游记页面
else if($('.strategy-edit-con').hasClass('strategy-edit-con')){
	
	$('body').css('background', '#fff');

	var coverID = $('.add-cover').data('id') || 0;
	if($('.strategy-edit-con').data('id')){
		$('.add-cover').height(500);
		$('.img-box').show();
	}
	$('.strategy-input.title>span>span').text($('input[name=strategy-title]').val().length);
	$('.strategy-input.des>span>span').text($('input[name=strategy-des]').val().length);
	$('.country').siblings('.con').children('a[id="'+$('.selected.country').data('id')+'"]').addClass('active');
	$('.category').siblings('.con').children('a[id="'+$('.selected.category').data('id')+'"]').addClass('active');
	//展开国家版块
	$('.chose-con').on('click', 'i', function(event) {
		if($(this).hasClass('up')){
			$(this).removeClass('up').addClass('down');
			$(this).siblings('.con').hide();
		}
		else{
			$(this).removeClass('down').addClass('up');
			$(this).siblings('.con').show();
		}
	})
	.on('click', '.con>a', function(event) {
		$(this).addClass('active').siblings('a.active').removeClass('active');
		$(this).parents('.con').siblings('a.selected').text($(this).text()).attr('data-id',$(this).attr('id'));
	});
	//标题限制
	$('input[name=strategy-title]').keyup(function(event) {
		var trs = $(this).val();
		if(trs.length>30){
			$(this).val(trs.substring(0,30));
			return;
		}
		$('.strategy-input.title>span>span').text(trs.length);
	});
	
	//描述限制
	$('input[name=strategy-des]').keyup(function(event) {
		var trs = $(this).val();
		if(trs.length>50){
			$(this).val(trs.substring(0,50));
			return;
		}
		$('.strategy-input.des>span>span').text(trs.length);
	});

	var href = location.href;

	//上传封面
	$('#upcover')
	.bind('fileuploadsend', function (e, data) {
		var isSend = true;
		$.each(data.files, function(index, val) {
			//不能超过2M
			if(val.size>2000000){
				data.files.splice(index);
				layer.msg(trsLang('file')+' ['+val.name+'] '+trsLang('toobig')+'2M');
				isSend = false;
			}
			//只能是图片
			else if( !(/\.jpg$|\.jpeg$|\.gif$|\.png$/i.test(val.name)) ){
				layer.msg(trsLang('file')+' ['+val.name+'] '+trsLang('typenotcorrect'));
				isSend = false;
			} 
		});
		return isSend;
	})
	.fileupload({
	    url: '/'+getLang()+'/user/upload-file',
	    dataType: 'json',
	    done: function (e, data) {
	    	var res = data.result;
	    	layer.msg(res.msg);
	    	var imgID = res.data.imageId;
	    	$('.img-box').parents('.add-cover').height(500);
	    	$('.img-box').show().children('img').attr('src', '/image/get/'+imgID);
	    	coverID = imgID;
	    }
	});

	//发布游记和保存草稿
	$('.header-btn>a').click(function(event) {
		var strategyTitle = $('input[name=strategy-title]').val();
		var strategyCountryId = $('.country').attr('data-id');
		var strategyCategoryId = $('.category').attr('data-id');
		var strategyDes = $('input[name=strategy-des]').val();
		var strategyDetail = ue.getContent();
		var strategyTag = $('input[name=strategy-tag]').val();
		if(strategyTitle===''){
			layer.msg( trsLang('title_not_empty') );
			return;
		}
		else if(strategyCountryId===''){
			layer.msg( trsLang('select_country') );
			return;
		}
		else if(strategyCategoryId===''){
			layer.msg( trsLang('select_category') );
			return;
		}
		else if(strategyDes===''){
			layer.msg( trsLang('description_not_empty') );
			return;
		}
		else if(strategyTag===''){
			layer.msg( trsLang('add_tag') );
			return;
		}
		else if(!coverID){
			layer.msg( trsLang('add_cover') );
			return;
		}
		else if(strategyDetail===''){
			layer.msg( trsLang('content_not_empty') );
			return;
		}
		api('post','/user/create-strategy',{
			id: $('.strategy-edit-con').data('id') || 0,
			type: $(this).data('type'),
			name: strategyTitle,
			countryId: strategyCountryId,
			categoryId: strategyCategoryId,
			summary: strategyDes,
			detail: strategyDetail,
			tagIds: strategyTag,
			picKey: coverID
		},function (res) {
			layer.msg(res.msg);
			if(!res.status){
				location.href = Cookies.get('HOST')+'/'+getLang()+'/strategy/detail/'+res.data.id;
			}
		});

	});
}