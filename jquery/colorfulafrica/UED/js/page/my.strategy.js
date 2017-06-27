/*我的游记*/
else if($('.user-container').hasClass('strategy')){
	$('.menu>a.strategy').addClass('active');

	//tab请求
	$('.user-tab>a,.loading-more').click(function(event) {
		var $self = $(this);
		var $activeA = $('.user-tab>a.active');
		var tag = $self.data('tag');
		var $list = $('.list[data-tag="'+tag+'"]');
		var currentPage = $self.data('currentpage') || $activeA.data('currentpage');
		var totalPage = $self.data('totalpage') || null;

		$('.no-product').hide();
		$('.loading-more').show();
		
		if($list.html()&&!$self.hasClass('loading-more')){
			return;
		}else if($self.hasClass('loading-more')){
			tag = $activeA.data('tag');
			$list = $('.list[data-tag="'+tag+'"]');
			currentPage = parseInt(currentPage) + 1;
			totalPage = $activeA.data('totalpage');
			if(currentPage>totalPage&&totalPage){
				layer.msg( trsLang('no_data') );
				return false;
			}
		}else if($self.find('span').text()===0){
			//console.log('没有的不能点击');
			return;
		}
		//console.log('类型：'+tag);
		//console.log('当前页'+currentPage);
		getStrategyList(tag,currentPage);
	});

	//取消收藏
	$('.user-container.strategy')
	.on('click', '.list-btn>a', function(event) {
		if($('a[data-tag=2]').hasClass('active')){
			api('post','/user/collection',{
				userId: Cookies.get('userId'),
				resourceId: $(this).data('id'),
				resourceType: 1,
				tag: 1
			},function (res) {
				layer.msg(res.msg);
				if(!res.status){
					location.reload();
				}
			});
		}
	})
	//删除我发布的游记
	.on('click', '.deleteBtn', function(event) {
		api('post','/user/del-strategy',{
			id: $(this).data('id')
		},function (res) {
			layer.msg(res.msg);
			if(!res.status){
				location.reload();
			}
		});
	});
}	
