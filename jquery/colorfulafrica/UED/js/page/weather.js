else if($('.container.weather').hasClass('weather')){
	var $li = $('.user-chose>ul>li');
	var $div = $('.user-chose>.active');
	var cityData = [];//存放获取到的数据

	$('.user-chose')
	//选项卡
	.on('click', 'ul>li', function(event) {
		var index = $(this).index();
		var countryId = $(this).data('id');
		$(this).addClass('active').siblings('.active').removeClass('active');

		if(cityData[index]){
			$div.html(cityData[index]);
			return;
		}

		api('post','/index/country-city',{
			countryId: countryId
		},function (res) {
			layer.msg(res.msg);
			if(!res.status){
				var html = '';
				$.each(res.data, function(index, val) {
					html += '<a href="/'+getLang()+'/index/weather/'+countryId+'/'+val.id+'">'+val.name+'</a>';
				});
				cityData[index] = html;
				$div.html(html);
			}
		});

	});
}