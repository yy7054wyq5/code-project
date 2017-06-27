var loader = {
	open: function (argument) {
		$('<img src="/dist/img/loading.gif" class="loading">').appendTo('body');
		$('.loading').css({
			left: layer.position($('.loading'))._left-10,
			top: layer.position($('.loading'))._top
		});
	},
	close: function () {
		$('.loading').remove();
	}
};