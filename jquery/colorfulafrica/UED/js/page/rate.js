// 汇率页面转外链，弃用此JS
// else if($('.container.rate').hasClass('rate')){
// 	$('.container.rate').height( $(window).height()-$('.car-header').height()-$('.footer.user').height() );
// 	$('body').css('background', '#fff');
	
// 	$('.exchange').on('click', function(event) {
// 		var rmb = $('input[name="rmb"]').val();
// 		var $country = $('select[name="country"]>option:selected');
// 		if(!rmb){
// 			layer.msg(trsLang('input_number'));
// 			return;
// 		}
// 		api('post','/index/get-rate',{
// 			number: $('input[name="rmb"]').val(),
// 			target: $('select[name="country"]>option:selected').val()
// 		},function (res) {
// 			if(!res.status){
// 				$('.dis').text(rmb+ trsLang('cny') +'='+res.data.number+$country.text());
// 			}
// 		});
// 	});
// }