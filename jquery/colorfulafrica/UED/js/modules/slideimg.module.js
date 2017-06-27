/**
*图片轮播
*/
;(function ($,window,document,undefined) {
	$.fn.slideimg = function(options) {
		//默认参数
		var dft = {
			width: 1010,//active图片宽度
			height: 474,//active图片高度
			ratio: 404/474,//比例根据UI设计的图来的
			top: 34,//距离顶部的高度
			containerWidth: $('html').width(),//页面宽度
			autoTime: 5000,//自动轮播时差
			hasleft: 1
		};
		//合并并替换参数
		var ops = $.extend(dft,options);
		var initwidth = ops.width,
			initheight = ops.height,
			initRatio = ops.ratio,
			initTop = ops.top;
			containerWidth = ops.containerWidth;
			autoTime = ops.autoTime;
			initLeft = 0;
		var $imgCon = $(this);
		var $imgDiv =  $imgCon.children('div.item');
		var imgDivLength =  $imgDiv.length;
		var initIndex = Math.round((imgDivLength-1)/2);//取中间值
		if(ops.hasleft){
			initLeft = (containerWidth-initwidth)/2;
		}
		var imgConStyle = [];//图片容器样式
		var imgGo = true;//是否可点击
		var autoGo = true;//是否轮播
		var $thumb = $imgCon.siblings('.thumb');//缩略图
		var thumbLiWidth = 0;
		//初始化样式
		if($thumb.hasClass('thumb')){
			//复制图片到thumb内
			var thumbIMG = '';
			$.each($imgCon.children('div.item'), function(index, val) {
				thumbIMG  += '<li><img src="'+$(val).children('img').attr('src')+'"></li>';
			});
			$thumb.append('<ul>'+thumbIMG+'</ul>');
			$imgCon.parent().height(initheight+$thumb.height());//调整大容器高度
			$($thumb.find('li')[initIndex]).addClass('active');
			thumbLiWidth = $thumb.find('ul>li.active')[0].clientWidth;//缩略图LI宽度
			$thumb.children('ul').width(thumbLiWidth*$thumb.find('li').length);//UL宽度
		}else{
			$(this).parent().height(initheight);
		}

		$imgCon.css({
			width: initwidth,
			height: initheight
		});

		$($('.img-con>div.item')[initIndex]).addClass('active');
		$imgCon.siblings('.img-btn').find('.index').text(initIndex+1);
		$imgCon.siblings('.img-btn').find('.total').text(imgDivLength);

		//按钮样式
		var $imgBtn = $(this).siblings('.img-btn');
		var btnHeight = $imgBtn.children('a').height();
		$imgBtn.css('width',initwidth).children('a').css('bottom', initheight/2-btnHeight/2);
		
		//图片容器定位
		$.each($imgDiv, function(index, val) {
			$(val).attr('index', index);
			//右侧图
			if(initIndex>index){
				var leftIndex = initIndex - index;
				$(val).css({
					'z-index' : initIndex+1-leftIndex,
					width: initwidth*Math.pow(initRatio,leftIndex),
					height: initheight*Math.pow(initRatio,leftIndex),
					left: index === 0 ? -initLeft : -initLeft/Math.pow(2,leftIndex),
					top: initTop*leftIndex
				});
			}
			//中间图
			else if(initIndex==index){
				$(val).css({
					'z-index' : initIndex+1,
					width: initwidth,
					height: initheight,
					left: 0,
					top: 0
				});
			}
			//左侧图
			else{
				var rightIndex = index - initIndex;
				$(val).css({
					'z-index' : initIndex+1-rightIndex,
					width: initwidth*Math.pow(initRatio,rightIndex),
					height: initheight*Math.pow(initRatio,rightIndex),
					right: index == $imgDiv.length-1 ? -initLeft : -initLeft/Math.pow(2,rightIndex),
					top: initTop*rightIndex
				});
			}
			imgConStyle[index] = $(val).attr('style');
		});
		
		//获取active样式
		var activeStyle = imgConStyle[initIndex];
		//绑定左右按钮
		$(document).on('click', '.img-slide-container .left-btn,.img-slide-container .right-btn', function(event) {
			var $newImgDiv = $('.img-con>div.item');
			if($(this).hasClass('left-btn')&&imgGo){
				imgGo = false;
				//将中间的定位改为left
				imgConStyle[initIndex] = activeStyle.replace(/right/,'left');
				$imgCon.prepend($newImgDiv[imgDivLength-1]);//将最后个移动到第一个
				$.each($newImgDiv, function(index, val) {
					$newImgDiv[index].setAttribute('style', imgConStyle[index + 1 > imgDivLength - 1 ? 0 : index + 1]);
				});
				changeNumber($newImgDiv);
			}
			else if($(this).hasClass('right-btn')&&imgGo){
				goRight();
			}
		});

		//点击缩略图
		$(document).on('click', '.img-slide-container .thumb li', function(event) {
			var $thumb_this = $(this);
			var index = $thumb_this.index();
			//$thumb_this.addClass('active').siblings().removeClass('active');
			//$('.img-con>div.item[index="'+index+'"]').addClass('active').siblings('.active').removeClass('active');
			//这里的操作需要重新给ITEM加以样式
		});

		//自动轮播
		var imgAutoGo = setInterval(function () {
			if(autoTime){
				if(autoGo) goRight();
			}
		},autoTime);
		setTimeout(function () {
			if($imgCon.children().length<2){
				window.clearInterval(imgAutoGo);
			}
		},1000);
		$(document).on('mouseenter', $(this), function(event) {
			autoGo = false;
		});
		$(document).on('mouseleave', $(this), function(event) {
			autoGo = true;
		});

		//向右
		function goRight() {
			imgGo = false;
			var $newImgDiv = $('.img-con>div.item');
			//将中间的定位改为right
			imgConStyle[initIndex] = activeStyle.replace(/left/,'right');
			$.each($newImgDiv, function(index, val) {
				$newImgDiv[index].setAttribute('style', imgConStyle[index - 1 < 0 ? imgDivLength - 1 : index - 1]);
				if(index==imgDivLength-2){
					//隔200ms把第一个添加到末尾
					setTimeout(function () {
						$imgCon.append($newImgDiv[0]);
						changeNumber($newImgDiv);
					},200);
				}
			});
		}

		//改数字加active样式
		function changeNumber($newImgDiv) {
			$newImgDiv.removeClass('active');
			$($('.img-con>div.item')[initIndex]).addClass('active');
			var activeIndex = $imgCon.children('div.active').attr('index');
			$('.img-btn>.number>span.index').text(parseInt(activeIndex)+1);
			if($thumb.hasClass('thumb')){
				$($thumb.find('li')[activeIndex]).addClass('active').siblings().removeClass('active');
				//滚动thumb
				if(activeIndex>11){
					$thumb.children('ul').css('margin-left',-(imgDivLength-12)*thumbLiWidth);
				}
				else if(parseInt(activeIndex)===0){
					$thumb.children('ul').css('margin-left',0);
				}
			}
			imgGo = true;
		}
	};
})(jQuery,window,document);