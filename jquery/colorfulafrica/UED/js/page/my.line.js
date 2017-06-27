/*我的线路*/
else if($('.user-container').hasClass('line')){
	$('.menu>a.line').addClass('active');
	//取消收藏
	$('.user-container.line')
	.on('click', '.list-btn>a', function(event) {
		api('post','/user/collection',{
			userId: Cookies.get('userId'),
			resourceId: $(this).parents('li[data-id]').data('id'),
			resourceType: 2,
			tag: 1
		},function (res) {
			layer.msg(res.msg);
			if(!res.status){
				location.reload();
			}
		});
	});
	
	//加载更多
	$('.loading-more').on('click',function(event) {
		var $self = $(this);
		var pageIndex = $self.data('currentPage') || 1;
		var totalPage = $self.data('totalPage') || 2;
		pageIndex = parseInt(pageIndex) + 1;
		if(pageIndex>totalPage){
			layer.msg( trsLang('no_data') );
			return;
		}
		api('post',getLang()+'/user/line',{
			userId: Cookies.get('userId'),
			pageIndex: pageIndex + 1
		},function (res) {
			if(!res.status){
				$self.data('currentPage', res.data.pageInfo.pageIndex);
				$self.data('totalPage', res.data.pageInfo.page);
				if(res.data.line.length===0){
					layer.msg( trsLang('no_data') );
					return;
				}
				var html = '';
				$.each(res.data.line, function(index, val) {
					html += 
					'<li data-id="'+val.resourceId+'">'+
						'<i class="circle"></i>'+
						'<div class="date">'+trsLang('I_at')+val.createTime+trsLang('collected_this_strategy')+'</div>'+
						'<div class="line">'+
							'<div class="list-btn" style="top:40px;">'+
								'<i class="star"></i>'+
								'<a>'+trsLang('cancel_collect')+'</a>'+
							'</div>'+
							'<div class="content">'+
								'<img src="/image/get/'+val.picKey+'" style="width:84px;">'+
								'<div class="txt nobg" style="width:845px;">'+val.name+'</div>'+
							'</div>'+
							'<hr>'+
						'</div>'+
					'</li>';
				});
				$('.list').append(html);
			}
		});
	});
}