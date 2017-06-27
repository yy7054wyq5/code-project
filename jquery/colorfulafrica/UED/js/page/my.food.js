/*我的美食*/
else if($('.user-container').hasClass('food')){
	$('.menu>a.food').addClass('active');

	//默认请求的数据
	getFoodList(0,1);

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
		getFoodList(tag,currentPage);
	});

	//取消点赞
	$('.user-container.food')
	.on('click', '.list>li .list-btn>a', function(event) {
		api('post','/user/thumb',{
			userId: Cookies.get('userId'),
			resourceId: $(this).data('id'),
			tag: 1
		},function (res) {
			layer.msg(res.msg);
			if(!res.status){
				location.reload();
			}
		});
	});
}