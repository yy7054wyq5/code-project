$(document).ready(function() {

    var isUpload = $('#upload_btn').parent().hasClass('upload_btn_box');//判断页面是否有上传的按钮

    /**
   * 标题字数限制
   */
    $(document).on('keyup', '.input-box.title>input', function(event) {
       var titleVa =  $(this).val();
       $('span.now-w').text(titleVa.length);
    });

     /**
    * 积分提示
    */
    $(document).on('keyup', '.input-box.point>input', function(event) {
       var pointVa =  $(this).val();
       if(parseInt(pointVa)<0){
          $(this).val('0');
       }
       else if(pointVa>100){
          $(this).val('100');
       }
       pointVa =  $(this).val();
       $(this).siblings('span').text(pointVa);
    });

     /**
    * 点击展开车型下拉框
    */
    $('.car-type>i,.car-type>.input-result').click(function(event) {
        if($('.car-type').hasClass('active')){
            $('.car-type').removeClass('active');
            $('.car-type-box').hide();
        }else{
            $('.car-type-box').show();
            $('.car-type').addClass('active');
        }
    });

     /**
    * 获取车型
    */
    $('.dropdown-menu.brand').on('click', 'li>a', function(event) {
        $.get('/innovate/getMaterialModelsInterface/'+$(this).attr('data-id'), function(data) {
              var checkedLI ='';
              var checkedBtn = '<li class="check-btn"><a id="lock" role="button">确定</a><a id="all" role="button">全选</a></li>';
              $.each(data.content, function(index, val) {
                    checkedLI += '<li><input type=\"checkbox\" value=\"'+this.name+'\" id=\"'+this.id+'\">'+this.name+'</li>';
              });
              $('.car-type-box').html(checkedLI+checkedBtn);
        });
    });

     /**
    * 车型确定和全选功能
    */
    $('.car-type-box').on('click', '#all', function(event) {//全选
        var $inputList = $(".car-type-box input");
        var $inputCheckdlist = $(".car-type-box input:checked");
        if($inputList.length==$inputCheckdlist.length){
            $inputList.prop("checked", false);
        }
        else{
            $inputList.prop("checked", true);
        }
    })
    .on('click', '#lock', function(event) {//确定
        $(this).parents('.car-type-box').hide();
        $('div.car-type').removeClass('active');
        var cTypes = $('.car-type-box input:checked');
        var choseTypes = '';
        var choseIds = '';
        var $choseResult = $('.car-type .input-result');
        for (i = 0; i < cTypes.length; i++) {
            //choseTypes = cTypes[i].value;
            choseTypes = choseTypes + "," + cTypes[i].value;
            choseIds = choseIds + "," + cTypes[i].id;
        }
        if ($choseResult.text() === '') {
            $choseResult.text(choseTypes.slice(1));
            $('#carType').val(choseIds.slice(1));
            //console.log($('#carType').val());
        }
        else{
            $choseResult.text(choseTypes.slice(1));
            $('#carType').val(choseIds.slice(1));
            //console.log($('#carType').val());
        }
    });

     /**
    * 上传素材的获取子分类
    */
    $(document).on('click', '.add-clip .dropdown-menu.fenlei>li>a', function(event) {
        var classicID = $(this).attr('data-id');
        var li;
        var $subUI = $('.add-clip .sub-fenlei');
        $.get('/innovate/getMaterialSubCatergoryInterface/'+classicID, function(data) {
            var subClassic = data.content;
            $subUI.children().remove();
            $subUI.siblings().children('.input-result').text('请选择');
            if(data.content.length==0){
                $('.sub-fenlei-box').hide();
            }
            else{
                $('.sub-fenlei-box').show();
                for (var i = 0; i < subClassic.length; i++) {
                  $subUI.append('<li><a data-id=\"'+subClassic[i].id+'\">'+subClassic[i].name+'</a></li>');
                }
            }
        });
    });

     
    if(isUpload){
     /**
    * 上传图片
    */
        $("#upload_btn").uploadify({
            'height'        : 32,
            'width'         : 122,
            'buttonText'    : '选择图片',
            'swf'           : '/uploadify/uploadify.swf',
            'uploader'      : '/image/upload',
            'auto'          : true,
            'multi'         : true,
            'removeCompleted':true,
            'cancelImg'     : '/uploadify/uploadify-cancel.png',
            'fileTypeExts'  : '*.jpg;*.jpge;*.gif;*.png',
            'fileSizeLimit' : '1MB',
            'onUploadSuccess':function(file,res,response){
                //图片预览删除
               var data =  JSON.parse(res);
               var imgId = data.content.imageId;
               var page;
               if($('.add-clip').hasClass('add-clip')){//判断页面为上传素材
                    page = 'clip';
               }
               else if($('.add-example').hasClass('add-example')){//判断页面为上传案例（编辑案例）
                    page = 'example';
               }
               else{
                  littleTips('需要指定page的值');
               }
               imgPre('/image/get/'+imgId,page,imgId);//此方法在loongjoy.js的imgPre()中
            },
            //加上此句会重写onSelectError方法【需要重写的事件】
            'overrideEvents': ['onSelectError', 'onDialogClose'],
            //返回一个错误，选择文件的时候触发
            'onSelectError':function(file, errorCode, errorMsg){
                switch(errorCode) {
                    case -110:
                        littleTips("文件 ["+file.name+"] 大小超出系统限制的" + jQuery('#upload_btn').uploadify('settings', 'fileSizeLimit') + "大小！");
                        break;
                    case -120:
                        littleTips("文件 ["+file.name+"] 大小异常！");
                        break;
                    case -130:
                        littleTips("文件 ["+file.name+"] 类型不正确！");
                        break;
                }
            }
        });

         /**
        * 上传附件
        */
        $("#upload_file_btn").uploadify({
            'height'        : 32,
            'width'         : 122,
            'buttonText'    : '选择文件',
            'swf'           : '/uploadify/uploadify.swf',
            'uploader'      : '/files/upload?qiniu=1',
            'auto'          : true,
            'multi'         : false,
            'removeCompleted':true,
            'cancelImg'     : '/uploadify/uploadify-cancel.png',
            'fileTypeExts'  : '*.rar;*.zip;*.pdf;*.doc;*.docx;*.xls;*.xlsx;*.ppt;*.pptx;',
            'fileSizeLimit' : '1024MB',
            'onUploadSuccess':function(file,res,response){
                //console.log(file);//文件属性
                var data = JSON.parse(res);
                if(data.status=='alert'){
                    data.tips = '上传失败：'+data.msg;
                }
                else{
                    $('#fileID').val(data.content.fileId);
                }
                $('.upload_btn_box.file .filename').html(file.name+'<span class=\"red-font\">'+data.tips+'</span>');
            },
            //加上此句会重写onSelectError方法【需要重写的事件】
            'overrideEvents': ['onSelectError', 'onDialogClose'],
            //返回一个错误，选择文件的时候触发
            'onSelectError':function(file, errorCode, errorMsg){
                switch(errorCode) {
                    case -110:
                        littleTips("文件 ["+file.name+"] 大小超出系统限制的" + jQuery('#upload_file_btn').uploadify('settings', 'fileSizeLimit') + "大小！");
                        break;
                    case -120:
                        littleTips("文件 ["+file.name+"] 大小异常！");
                        break;
                    case -130:
                        littleTips("文件 ["+file.name+"] 类型不正确！");
                        break;
                }
            }
        });
    
    }

    /**
    * 为上传准备参数
    */
   //品牌ID
    $('.dropdown-menu.brand').on('click', 'li>a', function(event) {
        $('#brandID').val($(this).attr('data-id'));
    });
    //一级分类ID
    $('.dropdown-menu.fenlei').on('click', 'li>a', function(event) {
        $('#sortID').val($(this).attr('data-id'));
    });
    //二级分类ID
    $(document).on('click','.dropdown-menu.sub-fenlei>li>a', function(event) {
        var a = $('#sortID').val();
        $('#subsortID').val(a);
        $('#sortID').val(a+','+$(this).attr('data-id'));
    });
    //交易求购状态
    $('#status').on('click', '.dropdown-menu>li', function(event) {
        $('#statusID').val($(this).attr('data-id'));
    });
    //成色
    $('#quality').on('click', '.dropdown-menu>li', function(event) {
        $('#qualityID').val($(this).attr('data-id'));
    });

    //获取图片ID
    function getImgID(){
        var img='';
        //生成缩略图在loongjoy.js的imgPre()中.
        $.each($('.upload_btn_box.img .successBox'), function(index, val) {
            var imgID = $(val).attr('data-id');
            var imgTxt =  $(val).children('textarea').val();
            var imgCover = $(val).children().children('img').attr('cover');
            if(imgCover==0){
                img += '\{"imgObj\":{\"imgID\":'+imgID+',\"imgTxt\":\"'+imgTxt+'\",\"cover\":0}}'+',';
            }
            else if(imgCover==1||imgCover===undefined){
                img += '\{"imgObj\":{\"imgID\":'+imgID+',\"imgTxt\":\"'+imgTxt+'\"}}'+',';
            }
            //console.log(img);
        });
        var sendImg = img.substring(0,img.length-1);
        $('#imgID').val('['+sendImg+']');//json字符串
        //console.log($('#imgID').val());
    }

    //获取富文本内容
    function  getContent () {
        var ue = UE.getEditor('editTxt');
        ue.ready(function() {
            var editorContent = ue.getContent();
            $('#editorContent').val(editorContent);
        });
    }

    //获取上传通行证
    function getPass () {
        if($('#materialName').val()===''){
            littleTips('素材名称不能为空');
            return false;
        }
        else if($('#examplename').val()===''){
            littleTips('案例名称不能为空');
            return false;
        }
        else if($('#dealTitle').val()===''){
            littleTips('标题不能为空');
            return false;
        }
        else if($('#brandID').val()===''){
            littleTips('品牌不能为空');
            return false;
        }
        else if($('#carType').val()===''){
            littleTips('车型不能为空');
            return false;
        }
        else if($('#proID').val()===''){
            littleTips('请选择省');
            return false;
        }
        else if($('#cityID').val()===''){
            littleTips('请选择市');
            return false;
        }
        else if($('#add').val()===''){
            littleTips('请填写详细地址');
            return false;
        }
        else if($('#mobile').val()===''){
            littleTips('请填写手机号');
            return false;
        }
        else if($('#price').val()===''){
            littleTips('请填写单价');
            return false;
        }
        else if($('#count').val()===''){
            littleTips('请填写数量');
            return false;
        }
        else if($('#qualityID').val()===''){
            littleTips('请选择成色');
            return false;
        }
        else if($('#userName').val()===''){
            littleTips('联系人不能为空');
            return false; 
        }
        else if($('#sortID').val()===''){
            littleTips('分类不能为空');
            return false;
        }
        else if($('.sub-fenlei-box').css('display')=='block'&&$('#subsortID').val()===''){
            littleTips('子分类不能为空');
            return false;
        }
        else if($('#point').val()===''){
            littleTips('积分不能为空');
            return false;
        }
        else if($('#imgID').val()=='[]'){
            littleTips('请至少上传一张图片');
            return false;
        }
        else if($('.add-example').hasClass('add-example')&&$('.add-example .successBox img').attr('cover')===undefined){
            //上传案例的设置封面检查
            littleTips('请设置封面');
            return false;
        }
        else if($('#fileID').val()===''&&$('.add-clip').hasClass('add-clip')){
            //上传素材附限制
            littleTips('请上传附件');
            return false;
        }
        else if($('#editorContent').val()===''){
            littleTips('请填写详情');
            return false;
        }
        else if($('#factorytime').val()===''){
            littleTips('请选择生产日期');
            return false;
        }
        else{
            //发布交易
            if($('.business-main.deal').hasClass('deal')){
                if($('#mobile').val().length==11 && /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/.test($('#mobile').val())){//验证手机号是否正确
                    if(parseFloat($('#price').val())>0){
                        $('#pass').val(1);
                    }
                    else{
                        littleTips('请输入正常的价格');
                        return false;  
                    }
                }
                else{
                    littleTips('请输入正确的手机号');
                    return false;
                }
            }
            //上传素材和上传案例只有判空
            else{
                $('#pass').val(1);
            }
        }
    }

    /**
    * 上传素材
    */
    $('.add-clip').on('click', '.btn.publish', function(event) {
        if(Cookies.get('lAmE_simple_auth')===undefined){
            alertTips('请登录后再操作','/login','登录');
            return false;
        }
        getImgID();
        getContent();
        getPass();
        var materialId = 0;
        if($('#materialId').val()){
            materialId = $('#materialId').val();
        }
      if($('#pass').val()==1){
          //ajax
          load($.post('/innovate/postSubmitMaterialInterface', 
            {
                materialId:materialId, // 素材ID
                materialName: $('#materialName').val(),      //名称
                brandId:        $('#brandID').val(),                    //品牌
                carmodelId:  $('#carType').val(),                    //车型
                categoryId:   $('#sortID').val(),                         //分类
                integral:        $('#point').val(),                         //积分
                imageId:       $('#imgID').val(),                        //图片
                from:   $('input[name="from"]').val(),
                enclosure:     $('#fileID').val(),                         //附件
                describle:     $('#editorContent').val()             //富文本
            }))
          .done(function  (res) {
                littleTips(res.tips);
                if(res.status==1){
                    if ($('input[name="from"]').val() == 2) {
                        location.href = '/mine/material';
                    } else {
                        location.href = '/innovate/clip';
                    }

                }
                else{

                }
          });
      }
      else{
          return false;
      }
    });

    /**
    * 上传案例
    */
    $('.add-example').on('click', '.btn.publish', function(event) {
        if(Cookies.get('lAmE_simple_auth')===undefined){
            alertTips('请登录后再操作','/login','登录');
            return false;
        }
        getImgID();
        getContent();
        getPass();
        if($('#pass').val()==1){
            //ajax
            load($.post('/innovate/postSubmitCaseInterface', 
              {
                  caseName:   $('#examplename').val(),      //名称
                  caseTypeId:   $('#sortID').val(),                       //分类
                  imageId:       $('#imgID').val(),                        //图片
                  enclosure:   $('#fileID').val(),                         //附件
                  from:   $('input[name="from"]').val(),                   //跳转页面判断
                  describle:     $('#editorContent').val(),   //富文本
                  caseProductId: $('#caseProductId') ? $('#caseProductId').val() : 0        //id
              }))
            .done(function  (res) {
                  littleTips(res.tips);
                  if(res.status==1){
                      if ($('input[name="from"]').val() == 2) {
                          location.href = '/mine/case';
                      } else {
                          location.href = '/innovate/example';
                      }
                  }
                  else{

                  }
            });
        }
        else{
            return false;
        }
    });

    /**
    * 交易求购
    */
    //console.log($.cookie('deal_page'));
    $('.business-main.deal').on('click', '.btn.publish', function(event) {
        if(Cookies.get('lAmE_simple_auth')===undefined){
            alertTips('请登录后再操作','/login','登录');
            return false;
        }
        getContent();
        getPass();
        if($('#pass').val()==1){
            //ajax
            load($.post('/deal/api/release', 
              {
                    type: Cookies.get('deal_page'),     //类型
                    title: $('#dealTitle').val(),      //标题
                    brand:$('#brandID').val(),         //品牌
                    car: $('.car-type>.input-result').text(),      //车型$('#carType').val()是车型的ID
                    province: $('#proID').val(),              //省
                    city: $('#cityID').val(),             //市
                    address: $('#add').val(),                 //地址
                    mobile: $('#mobile').val(),           //手机号
                    status: $('#statusID').val(),        //状态
                    price: $('#price').val(),            //单价
                    num: $('#count').val(),         //数量
                    quality: $('#qualityID').val(),        //成色
                    content: $('#editorContent').val(),//富文本编辑器
                    linkname: $('#userName').val(), //联系人名字
                    factorytime: $('#factorytime').val(),
                    tradingId: $('#tradingId') ? $('#tradingId').val() : 0
              }))
            .done(function  (res) {
                  littleTips(res.tips);
                  if(res.status==1){

                  }
                  else if(res.status==0){
                      location.href = '/deal';
                  }
                  else{
                      
                  }
            });
        }
        else{
            return false;
        }
    });
//JS结束
});
