/**
 * 模态框
 */
var resetPassUserId = null;
var layer = {
	/**
	 * 模态框定位
	 * @method 
	 	例子：
	 	layer.position($('.wo')).left
	 	layer.position($('.wo')).top
	 * @for layer
	 * @param 
	 	obj: 需定位jquery对象
	 	width: 模态框宽度
	 * @return 
	 	返回一个对象，带有left值和top值
	 */
	position: function (obj,width) {
		var _objWidth = width || obj.width();//模态框宽度是否有调整
		var _layerPosition = {
			_left: ($(window).width()-_objWidth)/2,
			_top: ($(window).height()-obj.height())/2
		};
		return _layerPosition;
	},
	/**
	 * 消息提示框
	 * @method 
	 	layer.msg('达到姐啊回答');
	 * @for layer
	 * @param 
		txt: 提示文字
	 */
	msg: function (txt) {
		if($('.lz-msg').hasClass('lz-msg')){
			return;
		}
		var tipsBody = '<div class=\"lz-msg\">'+txt+'</div>';
		$('body').append(tipsBody);
		$('.lz-msg').css({
			'left': layer.position($('.lz-msg'))._left-20,
			'top': layer.position($('.lz-msg'))._top
		})
		.show();//提示框定位;
		setTimeout(function () {
		    $('.lz-msg').remove();
		},2000);
	},
	/**
	 * 模态框内容
	 * @method 
	 	例子：
	 	layer.modal('login') //登录框
	 * @for layer
	 * @param 
	 	tag: 
	 		login 登录框
	 		reg 注册框
	 		finish 完善信息框
	 		address 新增地址框
	 		testmobile 验证手机号框(ps:与重置密码配合用的，暂无单独功能)
	 		reset 重置密码框
	 		tips tips确认框
	 	callback: 配合确认框使用
	 * @return 	
	 	只有tips框有返回，当用户点击确认仅返回一个true
	 */
	modal: function (tag,callback) {
		//字典没有的提示
		if(!localStorage[getLang()]){
			if(getLang()=='en'){
				layer.msg('Please hold on');
				trsLang('index');
			}
			else{
			 	layer.msg('请稍等');
			 	trsLang('index');
			}
			return;
		}
		var title = '';//模态框标题
		var msg = '';//模态框提示信息
		var web_captcha = '';//网页验证码
		var modal_boolean = false;//confirm窗，默认值
		var imgID = 0;//头像ID
		var data ='';
		//编辑地址相关变量
		var address_id;
		var address_user_name;
		var address_proname;
		var address_cityname;
		var address_areaname;
		var address_part_detail;
		var address_postcode;
		var address_mobile;
		var address_proId;
		var address_cityId;
		var address_areaId;
		//编辑地址相关变量
		if(typeof tag =='object'){
			var obj = tag;
			tag = obj.tag;
			title = obj.title;
			msg = obj.msg || '';
			data  = obj.data || null;
		}
		//console.log(data);
		if(data!==null){
			address_id = data.id;
			address_user_name = data.name;
			address_proname = data.provinceName;
			address_cityname = data.cityName || trsLang('first_chose_pro');
			address_areaname = data.districtName || trsLang('chose_area');
			address_postcode = data.postcode;
			address_mobile = data.mobile;
			address_proId = data.provinceId;
			address_cityId = data.cityId;
			address_areaId = data.districtId;
			address_part_detail = data.detail;
		}else{
			address_id = '';
			address_user_name = trsLang('enter_consignee_name');
			address_proname = trsLang('first_chose_pro');
			address_cityname = trsLang('first_chose_city');
			address_areaname = trsLang('chose_area');
			address_postcode = trsLang('enter_consignee_postcode');
			address_mobile = trsLang('enter_consignee_phonenumber');
			address_part_detail = trsLang('enter_detail_address');
		}
		
		var ConfirmHTML = 
			'<div class="lz-tips">'+
				'<p>'+msg+'</p>'+
				'<a class="sure">'+trsLang('confirm')+'</a><a class="cancel">'+trsLang('cancel')+'</a>'+
			'</div>';
		var AddressHTML = 
			'<table data-id="'+address_id+'">'+
				'<tbody>'+
					'<tr>'+
						'<td>'+trsLang('name')+'：</td>'+
						'<td><input type="text" name="name" value="'+address_user_name+'"></td>'+
					'</tr>'+
					'<tr>'+
						'<td>'+trsLang('address')+'</td>'+
						'<td class="part">'+
							'<select class="pro" name="part" style="width:175px;">'+
								'<option value="'+address_proId+'">'+address_proname+'</option>'+
							'</select>'+
							'<select class="city" name="part">'+
								'<option value="'+address_cityId+'">'+address_cityname+'</option>'+
							'</select>'+
							'<select class="area" name="part">'+
								'<option value="'+address_areaId+'">'+address_areaname+'</option>'+
							'</select>'+
							'<input type="text" name="address" value="'+address_part_detail+'">'+
						'</td>'+
					'</tr>'+
					'<tr>'+
						'<td>'+trsLang('postcode')+'：</td>'+
						'<td><input type="text" name="postcode" value="'+address_postcode+'"></td>'+
					'</tr>'+
					'<tr>'+
						'<td>'+trsLang('mobile')+'：</td>'+
						'<td><input type="text" name="mobile" value="'+address_mobile+'"></td>'+
					'</tr>'+
					'<tr>'+
						'<td></td>'+
						'<td><a class="address-btn" data-id="'+address_id+'">'+trsLang('save')+'</a></td>'+
					'</tr>'+
				'</tbody>'+
			'</table>';
		var LoginAndRegHTML = 
			'<div class="modal-tab">'+
				'<a class="login">'+trsLang('login')+'</a>'+
				'<a class="reg">'+trsLang('register')+'</a>'+
			'</div>'+
			'<div class="con login" style="display:block;">'+
			//div.con是默认隐藏的元素，无法获取高度，所以必须这样处理
				'<div class="modal-input">'+
					'<input type="text" id="loginmobile" class="mousetrap">'+
					'<span class="filter">'+trsLang('phone_number')+'</span>'+
				'</div>'+
				'<div class="modal-input">'+
					'<input type="password" id="loginpass" class="mousetrap">'+
					'<span class="filter">'+trsLang('pass_word')+'</span>'+
				'</div>'+
				'<a class="forgetpass">'+trsLang('forgot_password')+'</a>'+
				'<div style="height: 10px;"></div>'+
				'<div class="login-btn">'+
					'<div class="modal-input">'+
						'<input type="text" id="logincode" class="mousetrap">'+
						'<span>'+trsLang('verification_code')+'</span>'+
					'</div>'+
					'<div class="web-captcha">2131</div>'+
					'<a class="modal-btn">'+trsLang('login')+'</a>'+
				'</div>'+
				'<div class="tips">'+trsLang('use_social_account_login')+'</div>'+
				'<a class="thirdparty-btn qq" href="http://www.colourfulafrica.com/auth/qq"><i></i><span>QQ</span></a>'+
				'<a class="thirdparty-btn wechat" href="http://www.colourfulafrica.com/auth/wechat"><i></i><span>'+trsLang('we_chat')+'</span></a>'+
				'<div class="clear"></div>'+
			'</div>'+
			'<div class="con reg">'+
				'<div class="modal-input"><input type="text" id="regmobile" class="mousetrap"><span>'+trsLang('enter_login_mobile')+'</span></div>'+
				'<div class="modal-input" style="width:240px;float:left;"><input type="text" id="regcode" class="mousetrap"><span>'+trsLang('enter_SMS_code')+'</span></div>'+
				'<a class="modal-btn sentcode" style="float: right; margin-top:20px;">'+trsLang('send_code')+'</a>'+
				'<div class="clear"></div>'+
				'<div class="modal-input"><input type="password" id="regpass" class="mousetrap"><span>'+trsLang('enter_password')+'</span></div>'+
				'<div class="modal-input"><input type="password" id="repeatregpass" class="mousetrap"><span>'+trsLang('repeat_password')+'</span></div>'+
				'<a class="modal-btn reg-btn" style="width:100%;margin-top:30px;">'+trsLang('register_now')+'</a>'+
			'</div>';
		var FinishInfoHTML = 
			'<div class="con finish-info" style="display:block;">'+
				'<div class="user-photo">'+
					'<img src="/dist/img/ins_s_ic_autohead.png">'+
					'<input id="headupload" type="file" name="files">'+
					'<span id="photo">'+trsLang('upload_avatar')+'</span>'+
					'<input type="hidden" id="photoID" class="mousetrap">'+
				'</div>'+
				'<div class="modal-input"><input type="text" id="nickname" class="mousetrap" placeholder="'+trsLang('enter_nickname')+'"><span>'+trsLang('enter_nickname')+'</span></div>'+
				'<div class="modal-input"><input type="text" id="realname" class="mousetrap" placeholder="'+trsLang('real_name')+'"><span>'+trsLang('real_name')+'</span></div>'+
				'<div class="modal-input part">'+
					'<span>'+trsLang('province')+'</span><select class="pro" name="part"></select><i></i>'+
				'</div>'+
				'<div class="modal-input part">'+
					'<span>'+trsLang('first_chose_pro')+'</span><select class="city" name="part"></select><i></i>'+
				'</div>'+
				'<div class="modal-input part" style="margin-right:0;">'+
					'<span>'+trsLang('first_chose_city')+'</span><select class="area" name="part"></select><i></i>'+
				'</div>'+
				'<div class="clear"></div>'+
				'<div class="modal-input"><input type="text" id="address" class="mousetrap"><span>'+trsLang('address_detail')+'</span></div>'+
				'<div class="modal-input">'+
					'<select class="ageRange mousetrap" >'+	
						'<option>'+trsLang('select_age')+'</option>'+
						'<option value="1">5'+trsLang('to')+'10'+trsLang('years')+'</option>'+
						'<option value="2">11'+trsLang('to')+'15'+trsLang('years')+'</option>'+
						'<option value="3">16'+trsLang('to')+'20'+trsLang('years')+'</option>'+
						'<option value="4">21'+trsLang('to')+'25'+trsLang('years')+'</option>'+
						'<option value="5">26'+trsLang('to')+'30'+trsLang('years')+'</option>'+
						'<option value="6">31'+trsLang('to')+'35'+trsLang('years')+'</option>'+
						'<option value="7">36'+trsLang('to')+'40'+trsLang('years')+'</option>'+
						'<option value="8">41'+trsLang('to')+'45'+trsLang('years')+'</option>'+
						'<option value="9">46'+trsLang('to')+'50'+trsLang('years')+'</option>'+
						'<option value="10">51'+trsLang('to')+'55'+trsLang('years')+'</option>'+
						'<option value="11">56'+trsLang('to')+'60'+trsLang('years')+'</option>'+
						'<option value="12">61'+trsLang('to')+'65'+trsLang('years')+'</option>'+
						'<option value="13">66'+trsLang('to')+'70'+trsLang('years')+'</option>'+
						'<option value="14">71'+trsLang('to')+'75'+trsLang('years')+'</option>'+
						'<option value="15">76'+trsLang('to')+'80'+trsLang('years')+'</option>'+
						'<option value="16">'+trsLang('more_than')+'80</option>'+
					'</select></div>'+
				'<a class="sex man" data-id="1"><i></i><span>'+trsLang('male')+'</span></a><a class="sex woman" data-id="0"><i></i><span>'+trsLang('female')+'</span></a>'+
				'<input type="hidden" id="sex" mousetrap>'+
				'<div class="clear"></div>'+
				'<a class="modal-btn">'+trsLang('confirm')+'</a>'+
			'</div>';
		var backpassHTML = 
			'<div class="modal-tab">'+
				'<a class="testmobile">'+trsLang('verify_phone')+'</a>'+
				'<a class="reset">'+trsLang('reset_password')+'</a>'+
			'</div>'+
			'<div class="con testmobile" style="display: block">'+
				'<div class="modal-input"><input type="text" id="testmobile" class="mousetrap"><span>'+trsLang('enter_login_number')+'</span></div>'+
				'<div class="modal-input" style="width:240px;float:left;"><input type="text" id="testmobilecode" class="mousetrap"><span>'+trsLang('enter_SMS_code')+'</span></div>'+
				'<a class="modal-btn sentcode" style="float: right; margin-top:30px;">'+trsLang('send_code')+'</a>'+
				'<div class="clear"></div>'+
				'<a class="modal-btn testmobile-btn" style="width:100%;margin-top:30px;">'+trsLang('next')+'</a>'+
			'</div>'+
			'<div class="con reset">'+
				'<div class="modal-input"><input type="password" id="newpass" class="mousetrap"><span>'+trsLang('new_password')+'</span></div>'+
				'<div class="modal-input"><input type="password" id="repeatpass" class="mousetrap"><span>'+trsLang('repeat_new_password')+'</span></div>'+
				'<a class="modal-btn reset-btn" style="width:100%;margin-top:30px;">'+trsLang('confirm')+'</a>'+
			'</div>';
		var _disHTML =
			 '<div class="lz-tips">'+
			 	'<img src>'+
			 	'<a class="sure">'+trsLang('confirm')+'</a><a class="cancel">'+trsLang('cancel')+'</a>'+
			 '</div>';
		switch (tag){
			case 'dis':
				showModal(_disHTML);
				break;
			case 'reg':
				showModal(LoginAndRegHTML);
				Mousetrap.bind('enter', _reg, 'keyup');
				break;
			case 'login':
				showModal(LoginAndRegHTML);
				outCaptcha();
				Mousetrap.bind('enter', _login, 'keyup');
				break;
			case 'finish':
				showModal(FinishInfoHTML, trsLang('improve_the_data'));
				getcities(0,null,$('.part>.pro'));//获取省
				Mousetrap.bind('enter', _finishInfo, 'keyup');
				$('.part>.pro').siblings('span').hide();
				//上传头像
				$('#headupload')
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
				    	$('.progress-bar').width(0);
				    	var imgID = res.data.imageId;
				    	api('post','/user/updateuserinfo',{
						userId: Cookies.get('userId'),
						picKey: imgID,
					},function (res) {
						layer.msg(res.msg);
						$('.user-photo>img').attr('src','/image/get/'+imgID);
						$('#photoID').val(imgID);
					});
				    }
				});



				break;
			case 'testmobile':
				showModal(backpassHTML);
				Mousetrap.bind('enter', _next, 'keyup');
				break;
			case 'reset':
				showModal(backpassHTML);
				Mousetrap.bind('enter', _reset, 'keyup');
				break;
			case 'tips':
				showModal(ConfirmHTML,title,330);
				break;
			case 'address':
				showModal(AddressHTML,title,882);
				//console.log(!address_proname);
				if(!data){
					getcities(0,null,$('select.pro'));//获取省
				}
				break;
			default:
				//console.log('tag传错了:'+tag);
		}
		//定位
		function setModal(width) {
			$('.lz-modal').css({
				'transform': 'translateY('+layer.position($('.lz-modal'))._top+'px)',
				'margin-left': layer.position($('.lz-modal'),width)._left < 0 ? 0 : layer.position($('.lz-modal'),width)._left,
				'width': width || 530
			});
		}
		//跟随窗口调整位置
		$(window).resize(function(event) {
			setModal($('.lz-modal').width());
		});
		//显示并初始化模态框
		function showModal(html,title,width) {
			if(title===undefined) title = '';
			if($('.modal-wrap').hasClass('modal-wrap')) $('.modal-wrap').remove();
			var modal = 
			'<div class="modal-wrap">'+
				'<div class="lz-modal">'+
					'<span class="title">'+title+'</span>'+
					'<i class="modal-x"></i>'+
					'<div class="clear"></div>'+
				html+'</div>'+
			'</div>';
			$('body').append(modal);
			$('.modal-wrap').height($('body').height());
			//针对模态框有选项卡时显示对应的模态框
			$('.modal-tab>a.'+tag+'').addClass('active').siblings('a').removeClass('active');
			$('.con.'+tag+'').show().siblings('.con').hide();
			if(width) {
				setModal(width);
				return;
			}
			setModal();
		}
		//生成前端验证码
		function outCaptcha() {
			var captcha = '';
			for (var i = 0; i < 4; i++) {
				captcha += parseInt((Math.random()*10)).toString();
			}
			web_captcha = captcha;
			$('.web-captcha').text(web_captcha);
		}
		//登录
		function _login() {
			var loginmobile = $('#loginmobile').val();
			var loginpass = $('#loginpass').val();
			var logincode = $('#logincode').val();
			if(loginmobile&&loginpass&&logincode){
				if(logincode==web_captcha){
					api('post','/user/login',{
						mobile: $('#loginmobile').val(),
						password: $('#loginpass').val()
					},function (res) {
						layer.msg(res.msg);
						if(!res.status){
							Cookies.set('userId',res.data.id);
							Cookies.set('mobile',loginmobile);
							if(res.data.firstLogin===0){
								layer.modal('finish');
								return;
							}
							location.reload();
						}
					});
				}
				else layer.msg(trsLang('enter_right_code'));
			}
			else layer.msg(trsLang('complete_login_information'));
		}
		//注册
		function _reg() {
			var regmobile = $('#regmobile').val();
			var regpass = $('#regpass').val();
			var confirmpass = $('#repeatregpass').val();
			var regcode = $('#regcode').val();
			if(regmobile&&regpass&&confirmpass&&regcode){
				if(regpass!==confirmpass){
					layer.msg(trsLang('two_password_inconsistent'));
					return;
				}else if(!testPass($('#regpass'))){
					layer.msg( trsLang('input_password') );
					return;
				}
				api('post','/user/register',{
					mobile: regmobile,
					password: regpass,
					confirmpasswd: confirmpass,
					captcha: regcode
				},function (res) {
					layer.msg(res.msg);
					if(!res.status){
						layer.modal('login');
					}
				});
				return;
			}
			layer.msg(trsLang('improve_registration_information'));
		}
		//完善资料
		function _finishInfo() {
			var _newName = $('#nickname').val();
			if(!$('#realname').val()){
				layer.msg(trsLang('username_cannot_empty'));
				return;
			}else if(_newName.toString().length>11){
				layer.msg(trsLang('username_cannot_long'));
				return;
			}
			api('post','/user/updateuserinfo',{
				userId: Cookies.get('userId'),
				nickname: _newName,
				picKey: imgID || null,
				realName: $('#realname').val(),
				ageRange: $('.ageRange').val(),
				provinceId: $('.pro').val(),
				cityId: $('.city').val(),
				districtId: $('.area').val(),
				address: $('#address').val(),
				sex: $('#sex').val(),
				mobile: Cookies.get('mobile')
			},function (res) {
				if(!res.status){
					location.reload();
				}
			});
			
		}
		//下一步
		function _next() {
			api('post','/user/resetpwd',{
				mobile: $('#testmobile').val(),
				captcha: $('#testmobilecode').val(),
				tag: 0
			},function (res) {
				if(!res.status){
					Cookies.set('mobile',$('#testmobile').val());
					resetPassUserId = res.data.userId;
					if(resetPassUserId){
						$('#newpass,#repeatpass').attr('disabled', false);
					}
					layer.modal('reset');
				}else{
					layer.msg(trsLang('enter_right_code'));
				}
			});
		}
		//重置密码
		function _reset() {
			var newpass = $('#newpass').val();
			var confirmpass = $('#repeatpass').val();
			if(newpass===''){
				layer.msg( trsLang('input_password') );
				return;
			}else if(newpass!==confirmpass){
				layer.msg(trsLang('two_password_inconsistent'));
				return;
			}else if(!resetPassUserId){
				$('.testmobile').addClass('active').siblings('.active').removeClass('active');
				$('.con.testmobile').show().siblings('.con').hide();
				return;
			}else if(!testPass($('#newpass'))){
				layer.msg( trsLang('input_password') );
				return;
			}

			api('post','/user/resetpwd',{
				mobile: Cookies.get('mobile'),
				password: newpass,
				userId: resetPassUserId
			},function (res) {
				resetPassUserId = null;
				layer.msg(res.msg);
				if(!res.status){
					Cookies.remove('mobile');
					layer.modal('login');
				}
			});
		}
		//选项卡
		$('.lz-modal').on('click', '.modal-tab>a', function(event) {
			$(this).addClass('active').siblings('.active').removeClass('active');
			$($('.lz-modal>.con')[$(this).index()]).show().siblings('.con').hide();
			if(tag=='login') outCaptcha();
			if(!resetPassUserId){
				$('#newpass,#repeatpass').attr('disabled', true);
			}
		})
		//提示框的确定按钮
		.on('click', '.lz-tips>a.sure', function(event) {
			modal_boolean = true;
			$('.modal-wrap').remove();
			callback(modal_boolean);
		})
		//性别
		.on('click', 'a.sex', function(event) {
			$(this).toggleClass('active').siblings('a').removeClass('active');
			$('#sex').val($(this).data('id'));
		})
		//输入框的默认文字
		.on('click', '.modal-input', function(event) {
			$(this).children('span').hide();
			$(this).children('input').focus();
		})
		.on('focus', '.modal-input', function(event) {
			$(this).children('span').hide();
		})
		//去除模态框
		.on('click', 'i.modal-x,a.cancel', function(event) {
			$('.modal-wrap').remove();
			if($(this).parents('.lz-modal').find('.finish-info').hasClass('finish-info')){
				location.reload();
			}
			Mousetrap.unbind('enter');
		})
		//前端验证码
		.on('click', '.web-captcha', function(event) {
		  	web_captcha = outCaptcha();  	
		  	$(this).text(web_captcha);
		})
		// //第三方
		// .on('click', '.thirdparty-btn', function(event) {
		// 	layer.msg('暂未开通');
		// })
		//发送验证码
		.on('click', '.sentcode', function(event) {
			var mobile = $('#regmobile').val() || $('#testmobile').val();
			if(mobile&&mobile.length==11){
				if($('#regmobile').val()) getCaptcha($(this),mobile,0);
				else if($('#testmobile').val()) getCaptcha($(this),mobile,1);
			}
			else layer.msg(trsLang('enter_right_number'));
		})
		//忘记密码按钮
		.on('click', '.forgetpass', function(event) {
			layer.modal('testmobile');
		})
		//验证手机号---下一步
		.on('click', '.testmobile-btn', function(event) {
			if($('#testmobile').val()&&$('#testmobilecode').val()){
				_next();
			}
		})
		//重置密码前验证密码
		.on('blur', '#newpass', function(event) {
			testPass($(this));
		})
		//重置密码
		.on('click', '.reset-btn', function(event) {
			_reset();
		})
		//登录
		.on('click', '.login-btn>.modal-btn', function(event) {
			_login();
		})
		//限制注册手机号
		.on('blur', '#regmobile', function(event) {
			var val = $(this).val();
			if( isNaN( parseInt(val) ) ){
				$(this).val('');
			}
			else if(val.length>14||val.length<11){
				layer.msg(trsLang('enter_right_number'));
				$(this).val(val.substring(0,14));
			}
		})
		//限制注册密码
		.on('blur', '#regpass,#repeatregpass', function(event) {
			testPass($(this));
		})
		//注册
		.on('click', '.con.reg .reg-btn', function(event) {
			_reg();
		})
		//选择省市区
		.on('change', 'select[name="part"]', function(event) {
			var $select = $(this);
			var id = $select.children('option:selected').attr('id');
			var classname = $select[0].className;
			switch(classname){
				case 'pro':
					getcities(1,id,$('.part>select.city'));
					$('.part>select.city').siblings('span').hide();
					$('.part>select.area').html('');
					break;
				case 'city':
					getcities(2,id,$('.part>select.area'));
					$('.part>select.area').siblings('span').hide();
					break;
				case 'area':
					break;
				default:
					//console.log('你在逗我？');
			}
		})
		//完善信息
		.on('click', '.finish-info .modal-btn', function(event) {
			_finishInfo();
		});
	}
};