//验证
$('.invest-detail #QAQform').validate({
    success: function(label) {//验证成功的提示
       //console.log($(label));
       $(label).html("&nbsp;").addClass("checked").show();
    },
    onsubmit:false,//关闭submit
    errorClass:'error',
    validClass:'checked',
    errorElement:'label',
    errorPlacement: function(error, element) {//验证失败的提示
      $(error).removeClass('checked');
    },
    rules:{
        // dealer:{
        //   required:true,
        //   stringCheck:true
        // },
        // marketAnalyst:{
        //   required:true,
        //   stringCheck:true
        // },
        // personPost:{
        //   required:true,
        //    stringCheck:true
        // },
        mobile:{
          required:true,
          isMobile:true
        }
    },
    messages:{
       // dealer:{
       //   required:'不能为空',
       //   stringCheck:'输入有误'
       // },
       //  marketAnalyst:{
       //    required:'不能为空',
       //    stringCheck:'输入有误'
       //  },
       //  personPost:{
       //    required:'不能为空',
       //     stringCheck:'输入有误'
       //  },
        mobile:{
          required:'不能为空',
          isMobile:'请输入手机号'
        }
    }
});

$('#QAQform table input').focusin(function(event) {
   $(this).parents('td').find('label').hide();
});

$('#postForm').click(function(event) {
    var active = $('.QA-box').find('li.active').length;
    var QAbox = $('.QA-box').length;
    if(active>=QAbox){
        if($("#QAQform").valid()){
              load($.post('/innovate/submitauwor', $('#QAQform').serialize() )).done(function (data, textStatus, xhr) {
                littleTips(data.tips);
              });
        }
    }
    else{
        littleTips('请完成调查问卷再提交');
    }

});