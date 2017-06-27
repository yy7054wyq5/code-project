/*用户信息*/
else if($('.user-container').hasClass('userinfo')){

	//用户默认信息
	var userinfo = [ 
		$('input[name="nickName"]').val(),
		$('input[name="realName"]').val(),
		$('select[name="ageRange"]').val(),
		$('.sex.active').data('id')
	];
	$('.menu>a.set').addClass('active');

	//菜单切换
	$('.userinfo-menu>li').click(function(event) {

		$(this).addClass('active').siblings('li').removeClass('active');
		$($('.user-container.userinfo>.con')[$(this).index()]).show().siblings('.con').hide();
		cutRightMargin($('.address-box>.item'),3,true);
		//获取省的数据
		if($(this).index()==1){
			getcities(0,null,$('.chosepart>.pro'));
		}
	});

	$('.sex').click(function(event) {
		$(this).addClass('active').siblings('.active').removeClass('active');
	});

	//保存用户信息
	$('.updateinfo-btn').click(function(event) {
		var checkInfo = 0;
		var _newName = $('input[name="nickName"]').val();
		var newUserInfo = [
			$('input[name="nickName"]').val(),
			$('input[name="realName"]').val(),
			$('select[name="ageRange"]').val(),
			$('.sex.active').data('id')
		];
		//对比数据
		for (var i = 0; i < userinfo.length; i++) {
			if(userinfo[i] == newUserInfo[i]){
				checkInfo += 1;
			}
		}
		if(checkInfo==4){
			layer.msg(trsLang('change_info'));
			return;
		}else if(_newName===''){
			layer.msg(trsLang('username_cannot_empty'));
			return;
		}else if(_newName.toString().length>11){
			layer.msg(trsLang('username_cannot_long'));
			return;
		}
		api('post','/user/updateuserinfo',{
			userId: Cookies.get('userId'),
			picKey: 0,
			nickname: $('input[name="nickName"]').val(),
			realName: $('input[name="realName"]').val(),
			ageRange: $('select[name="ageRange"]').val(),
			sex: $('.sex.active').data('id')
		},function (res) {
			layer.msg(res.msg);
			if(!res.status){
				location.reload();
			}
		});
	});
	
	//选择省市区
	$('.chosepart>select').on('change',function(event) {
		var $select = $(this);
		var id = $select.children('option:selected').val();
		var classname = $select[0].className;
		switch(classname){
			case 'pro':
				getcities(1,id,$('.chosepart>select.city'));
				$('.chosepart>select.area').html('');
				break;
			case 'city':
				getcities(2,id,$('.chosepart>select.area'));
				break;
			case 'area':
				break;
			default:
				//console.log('你在逗我？');
		}
	});

	//密码检测
	$('input[name="newpass"]').blur(function(event) {
		testPass($(this));
	});
	
	//修改密码
	$('.changepass-btn').click(function(event) {
		var oldpass = $('input[name="oldpass"]').val();
		var newpass =  $('input[name="newpass"]').val();
		var repass = $('input[name="confirmpass"]').val();
		if(oldpass===''){
			layer.msg(trsLang('enter_old_password'));
			return;
		}else if(newpass===''){
			layer.msg(trsLang('enter_new_password'));
			return;
		}else if(!testPass($('input[name="newpass"]'))){
			return;
		}else if(repass===''){
			layer.msg(trsLang('enter_duplicate_password'));
			return;
		}else if(newpass!==repass){
			layer.msg(trsLang('new_isdifferent_duplicate'));
			return;
		}else if(!$('input[name="newpass"]')){
			layer.msg( trsLang('input_password') );
			return;
		}
		api('post','/user/modify-password',{
			oldPassword: oldpass,
			newPassword: newpass,
			rePassword: repass
		},function (res) {
			layer.msg(res.msg);
			if(!res.status){
				$.post('/'+getLang()+'/user/logout', {
					userId: Cookies.get('userId')
				}, function(data, textStatus, xhr) {
					if(!data.status){
						Cookies.remove('userId');
						Cookies.remove('mobile');
						location.reload();
					}
				});
			}
		});
	});

	//加载更多问卷
	$('.invest.con').on('click', '.loading-more', function(event) {
		var $self = $(this);
		var currentPage = $self.data('pageindex') + 1;
		var totalPage = $self.data('pagecount');
		if(currentPage>totalPage){
			layer.msg( trsLang('no_data') );
			return;
		}
		api('post','/user/invest',{
			pageIndex: currentPage,
			pageCount: totalPage
		},function (res) {
			if(res.data.invest.length===0){
				layer.msg(trsLang('no_data'));
				$self.data('pageindex',res.data.pager.pageIndex);
				$self.data('pagecount',res.data.pager.page);
				return;
			}
			layer.msg(res.msg);
			if(!res.status){
				var html = '';
				$self.data('pageindex',res.data.pager.pageIndex);
				$self.data('pagecount',res.data.pager.page);
				$.each(res.data.invest, function(index, val) {
					html +=
					 '<li>'+
					 	'<a href="/user/invest/'+val.id+'" title="'+val.title+'">'+val.title+'</a>'+
					 	'<span>'+val.createTime+'</span>'+
					 '</li>';
				});
				$self.siblings('.QAQ').append(html);
			}
		});
	});

}