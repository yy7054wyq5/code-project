/*评价订单*/
else if($('.user-container.commentorder').hasClass('commentorder')){
	//商品数为0跳转到我的订单列表
	if($('.product-list>li').length===0){
		location.href = Cookies.get('HOST') + '/'+ getLang() + '/user/order';
	}
	//初始化上传插件
	var uploader = $('.send-comment');
	for (var i = 0; i < uploader.length; i++) {
		$('#comment-order-icon'+i)
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
			if($('.number').text()===0){
		    		isSend = false;
		    	}
			return isSend;
		})
		.fileupload({
		    url: '/'+getLang()+'/user/upload-file',
		    dataType: 'json',
		    done: function (e, data) {
		    	var res = data.result;
		    	layer.msg(res.msg);
		    	var imgID = res.data.imageId;
		    	//图片预览
		    	var $imgCon = $(this).parents('.camera-box').siblings('.img-con');
		    	$imgCon.find('.img-list').append('<div class="handle-img"><img data-id="'+imgID+'" src="/image/get/'+imgID+'"><i>x</i></div>');
		    	$imgCon.find('.number').text(10-$imgCon.find('.img-list>.handle-img').length);
		    }
		});
	}

	//删除图片
	$(document).on('click', '.img-list>div>i', function(event) {
		var num = $(this).parents('.img-con').find('.number').text();
		$(this).parents('.img-con').find('.number').text( parseInt(num) + 1);
		$(this).parents('.handle-img').remove();
	});
	
	//评论内容限制
	$('.send-comment').on('keyup', 'textarea', function(event) {
		var content = $(this).val();
		$('.content-num>span').text(content.length);
		if(content.length>500){
			$(this).val(content.substring(0,500));
			return;
		}
	});

	//提交评价
	$('.submit-comment').click(function(event) {
		var $self = $(this);
		var content = $self.parents('.send-comment').find('textarea').val();
		var $imgArray = $self.siblings('.img-con').find('img');
		var resourceId = $self.parents('.send-comment').data('id');
		var imgIDs = ''; 
		$.each($imgArray, function(index, val) {
			imgIDs += $(val).data('id') + ',';
		});
		imgIDs = imgIDs.substring(0,imgIDs.length-1).split(',');
		if($imgArray.length===0){
			imgIDs = [];
		}
		if(!content||/^ +| +$/.test(content)){
			layer.msg( trsLang('comment_cannot_empty') );
			return;
		}
		//console.log(imgIDs);
		api('post','/user/create-comment',{
			userId: Cookies.get('userId'),
			resourceId: resourceId,
			resourceType: 4,
			content: content,
			album: imgIDs,
			orderId: $(this).data('orderid')
		},function (res) {
			layer.msg(res.msg);
			if(!res.status){
				location.reload();
			}
		});
	});
}