$(document).ready(function() {

  /**
  *刷验证码
  */
  $(document).on('click', '.code-img', function(event) {
      $('.code-img').attr('src', '/api/user/vailcode/'+parseInt(Math.random()*10000000000000)+''); 
      $('input[name="frontCode"]').val('');
  });

  /**
  *验证注册信息
  */
  $("#regForm").validate({
      debug:true,//关闭插件的默认提交
      onsubmit:false,//关闭submit
      success: function(label) {
          $(label).html('').addClass("checked");
      },
      onkeyup: false,
      //验证规则
      rules:{
        username:{
           required:true,
           submitHandler: function() {
                 $.post('/user/api/username', {username: $('#username').val()}, function(data, textStatus, xhr) {
                    //console.log(data);
                    if(data.status==0){
                        $('#username-error').text('').addClass('checked').hide();
                    }
                    else{
                        $('#username-error').text(data.tips).removeClass('checked').show();
                    }
                 });
          }
        },
        password:{
           required:true,
           rangelength:[6,16]
        },
        rePassword:{
           required:true,
           rangelength:[6,16],
           equalTo:"#password"
        },
        mobile:{
           required:true,
           submitHandler: function() {
                 $.post('/user/api/mobile', {mobile: $('#mobile').val()}, function(data, textStatus, xhr) {
                    //console.log(data);
                    if(data.status==0){
                        $('#mobile-error').text('').addClass('checked');
                    }
                    else{
                        $('#mobile-error').text(data.tips).removeClass('checked').show();
                    }
                 });
            }
        },
        frontCode:{
            required:true,
            submitHandler: function() {
                  $.get('/api/user/checkvailcode', {code: $('#frontCode').val()}, function(data, textStatus, xhr) {
                     //console.log(data);
                     if(data.status==0){
                         $('#frontCode-error').text('').addClass('checked');
                     }
                     else{
                         $('#frontCode-error').text(data.tips).removeClass('checked').show();
                     }
                  });
             }
        },
        code:{
           required:true,
           submitHandler: function() {
                 $.post('/user/api/expircode', {code: function(){  return $('#code').val();},phone: function(){  return $('#mobile').val();}}, function(data, textStatus, xhr) {
                    //console.log(data);
                    if(data.status==0){
                        $('#code-error').text('').addClass('checked');
                    }
                    else{
                        $('#code-error').text(data.tips).removeClass('checked').show();
                    }
                 });
            }
        },
        protocol:{
          required:true
        }
      },
      //验证的提示信息
      messages:{
         username:{
           required:'用户名不能为空'
         },
         password:{
           required:'密码不能为空',
           rangelength:'只能在6-16个字符内'
         },
         rePassword:{
           required:'确认密码不能为空',
           rangelength:'只能在6-16个字符内',
           equalTo:'密码需要一致'
         },
         mobile:{
           required:'手机号码不能为空'
         },
         frontCode:{
           required:'验证码输入错误'
         },
         code:{
            required:'短信验证码未发送或已过期'
         },
         protocol:{
            required:'注册必须勾选'
         }
      }
   });

    /*
    *发送验证码
     */
    $('.mobileCode.send').click(function(event) {
        var mobile = $('#mobile').val();
        if($('#username').val()===''){
            $('#username-error').text('请输入用户名').removeClass('checked').show();
        }
        else if($('#password').val()===''){
            $('#password-error').text('请输入密码').removeClass('checked').show();
        }
        else if($('#rePassword').val()===''){
            $('#rePassword-error').text('请输入确认密码').removeClass('checked').show();
        }
        else if(mobile===''){
            $('#mobile-error').text('请输入手机号').removeClass('checked').show();
        }
        else if($('#frontCode').val()==''){
            $('#frontCode-error').text('请输入正确的计算结果').removeClass('checked').show();
        }
        else{
            //验证图片验证码
            $.get('/api/user/checkvailcode', {code: $('#frontCode').val()}, function(data, textStatus, xhr) {
               //console.log(data);
               if(data.status==0){
                   $('#frontCode-error').text('').addClass('checked');
                   //验证手机号
                   $.post('/user/api/mobile', {mobile: $('#mobile').val()}, function(data, textStatus, xhr) {
                      //console.log(data);
                      if(data.status==0){
                          $('#mobile-error').text('').addClass('checked');
                          //发送验证码
                          $('#code-error').text(captcha($('#mobile').val())).show();//方法在loongjoy.js
                          if($('.loadingGif').hasClass('loadingGif')){
                              if($(this).hasClass('wait')){
                                  $('#code-error').text('请稍候');
                              }
                              else{
                                  $('#code-error').text('').removeClass('checked').show().next().show();
                              }      
                          }
                          else{
                              $('#code-error').text('').removeClass('checked').show().after('<img src="/img/little-loading.gif" height="30" class="loadingGif">');
                          }
                      }
                      else{
                          $('#mobile-error').text(data.tips).removeClass('checked').show();
                          return false;
                      }
                   });
               }
               else{
                   $('#frontCode-error').text(data.tips).removeClass('checked').show();
                   return false;
               }
            });
        }
    });

    /*
    *注册
     */
    $('.reg-main .detail-btn').click(function(){
      // $.get('/user/api/click-register-count-api', function(data, textStatus, xhr) {
      //   /*optional stuff to do after success */
      // });
      if($("#regForm").valid()){//验证通过
            if($('label.checked').length==7){
                //console.log($('#code-error').text());
                $.post('/user/api/expircode', {code: function(){  return $('#code').val();},phone: function(){  return $('#mobile').val();}}, function(data, textStatus, xhr) {
                   //console.log(data);
                   if(data.status==0){
                       load($.post('/user/index/reg', 
                         {
                           username: $('#username').val(),
                           password: $('#password').val(),
                           repassword: $('#rePassword').val(),
                           mobile:$('#mobile').val(),
                           recommend: $('#recommend').val(),
                         }))
                       .done(function  (res) {
                             if (res.status === 0) {
                               littleTips('注册成功');
                               location.href = '/';
                             } 
                             else {
                               //console.log(res);
                             }
                       });
                   }
                   else{
                       $('#code-error').text(data.tips).removeClass('checked').show();
                   }
                });
            }
      }
      else{//验证未通过
          //alert('请按要求完成注册信息 ');
      }
    });
});
