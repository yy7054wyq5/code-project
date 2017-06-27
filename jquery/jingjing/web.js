$(document).ready(function() {
    //brower
    var browser = navigator.appName;
    var version = navigator.userAgent.split(";");
    var trimVersion = version[1].replace(/[ ]/g,"");
    if(browser=="Microsoft Internet Explorer" && trimVersion=="MSIE7.0"){//IE7
        // alert(777);
    } 
    else if(browser=="Microsoft Internet Explorer" && trimVersion=="MSIE8.0"){//IE8
         // alert(888);
    }
    else if(browser=="Microsoft Internet Explorer" && trimVersion=="MSIE9.0"){//IE9
         // alert(999);
    }
    else if(browser=="Microsoft Internet Explorer" && trimVersion=="MSIE10.0"){//IE10
         // alert(1010);
    }
    else if("ActiveXObject" in window){//IE11
        // alert(1111);
    }
    else{
        var cc = version[2];
        if(cc==undefined){//chrome  safari opera
        
        }
        else{
            if(cc.indexOf('Firefox')>-1){//firefox
                $('body.user .user-banner img').css('left','70px');
            }
        }
    }
    //监测浏览器大小变化
    WINRES = function () {
      if($('body').width()<1150){
        $('body.user .user-banner .banner').css('background','url(/img/web/my_bg_new.png) no-repeat center');
        $('body.user .user-banner .banner').width('1150');
      }else{   
        $('body.user .user-banner .banner').css('background','url(/img/web/my_bg.png) no-repeat center');
        $('body.user .user-banner .banner').width('100%');
      }
    }
    $(window).resize(function(){
        WINRES();
     });
    WINRES();
    //tab
    $('.tab>li>span').click(function(event) {
        $('.tab>li>span').removeClass('active');
        $('.tab-con>div').removeClass('active');
        var tabIndex = $(this).attr('index');
        $(this).addClass('active');
        $($('.tab-con>div')[tabIndex-1]).addClass('active');
    });

    //reg
    (function () {
        $nickname = $('body.register #nickname');
        $password = $('body.register #password');
        $rePassword = $('body.register #rePassword');
        $mobile = $('body.register #mobile');
        $captcha = $('body.register #captcha');
        //为注册、发送验证码绑定点击事件
        $(document).on('click','body.register .jjbtn,body.register .send',function () {
            var checkRight = $('body.register table.reg label.error.right');//按要求填写的钩子
            if($nickname.val()==''){
                regTips($nickname,'用户名不能为空');
            }
            if($password.val()==''){
                regTips($password,'密码不能为空');
            }
            if($rePassword.val()==''){
                regTips($rePassword,'确认密码不能为空');
            }
            if($mobile.val()==''){
                regTips($mobile,'手机号不能为空');
            }
            if($captcha.val()==''){   
               if($(this).hasClass('send')){//点击发送验证码
                    if($(this).hasClass('wait')){//如果已经发送
                        regTips($captcha,'请耐心等待再次发送');
                        return false;
                    }
                    else{//第一次发送
                        if(checkRight.length==4){//其余信息是否完备
                            $captcha.siblings('img.loading').show();
                            captcha(1,$('#mobile').val());
                        }
                        else{//否则
                            alert('发送验证码失败，请按要求填写信息');
                        }
                    }
                }
                else{
                    regTips($captcha,'验证码不能为空');
                }
            }
            else{//都不为空
                if($(this).hasClass('jjbtn')){//注册
                    //console.log(checkRight.length);
                    if(checkRight.length>3&&$captcha.val()!==''){
                        $.post('/web/register',
                        {
                            mobile: $mobile.val(),
                            nickname: $nickname.val(),
                            password: $password.val(),
                            rePassword: $rePassword.val(),
                            captcha: $captcha.val()
                        },
                        function(data, textStatus, xhr) {
                            if(data.status=='success'){
                                location.href='/web/login';
                            }
                            else{
                                alert(data.msg);
                            }
                        });
                    }
                    else{
                        alert('注册不成功，请按要求填写注册信息');
                    } 
                }
              
            }
        });
        //为所有验证提示添加隐藏事件
        $('body.register table.reg input').focusin(function(event) {
            if($(this).parent().find('label').hasClass('right')){//只显示填写成功的提示
                $(this).parent().find('label').show();
            }
            else{
                $(this).parent().find('label').hide();
            }
        });
        //验证用户名
        $nickname.focusout(function(event) {
            $.get('/web/nickname-verify',{nickname:$(this).val()}, function(data) {
                if(data.msg=='可以使用'){
                    regTips($nickname,data.msg,1);
                }
                else{
                    regTips($nickname,data.msg);
                }
            });
        });
        //验证密码       
        $(document).on('focusout','#password,#rePassword',function () {//判断是否为空
            var passVa = $(this).val();
            var passlength = $(this).val().length;
            if(passlength==0){
                 regTips($(this),'密码不能为空');
            }
        });
        $(document).on('keyup','#password,#rePassword',function () {//判断长度
            var passVa = $(this).val();
            var passlength = $(this).val().length;
            if(passlength<6){
                regTips($(this),'请输入6-12位密码');
            }
            else{
                if(passlength>12){
                    var newPass = passVa.substr(0,12);
                    $(this).val(newPass);
                    hideTips($(this));
                }
                else{
                    hideTips($(this));
                }
            }
        });
        $rePassword.focusout(function (event) {//比较密码
            if($rePassword.val()!==$password.val()){
                regTips($rePassword,'两次输入的密码不一致');
            }
            else{
                regTips($(this),'密码一致',1);
                regTips($password,'密码一致',1);
            }
        });
        
        //验证手机号
        $mobile.keyup(function(event) {
            var mostr = $mobile.val();
            if(mostr.substr(0,1)!=1){
                regTips($mobile,'请输入正确的手机号码');
            } 
            else{
                if($mobile.val().length>11){
                    var newmostr = mostr.substr(0,11);
                    $mobile.val(newmostr);
                }
                if($mobile.val().length<11){
                    regTips($mobile,'请输入11位手机号码');
                }
                else{//11位号，开头为1
                    $.get('/web/mobile-verify',{mobile:mostr}, function(data) {
                        if(data.status!=='success'){
                            regTips($mobile,data.msg);
                        }
                        else{
                            regTips($mobile,data.msg,1);
                        }
                    });
                }
            }      
        });


    })();

    //login
    $('body.login .jjbtn').click(function(event) {
        var loginName = $('#loginName').val();
        var loginPass = $('#loginPass').val();
        if($('#loginName').val()==''){
            alert('用户名不能为空！');
        }else{
            $.get('/web/ajax-login',{nickname:loginName,password:loginPass},function(data) {
                if(data.status=='success'){
                     location.href = '/web/user';   
                }else{
                    alert(data.msg);
                    return false;
                }
            });
        }
    });

    //user
    ;(function () {
        var $interestTips = $('td.interest label');//兴趣提示框
        var $partsTips = $('td.parts label');//地区提示框
        //下拉框展示
        $('.dropdown').mouseover(function(event) {
            $(this).addClass('open');
            $(this).siblings('label').hide();//关闭提示
        });
        $('.dropdown').mouseleave(function(event) {
            $(this).removeClass('open');
        });
        $('.dropdown').click(function(event) {//关闭点击事件
        });

        //下拉框选中功能
        $(document).on('click','.dropdown>.dropdown-menu>li>a',function(event) {//下拉框绑定点击事件
            if($(this).siblings('ul').hasClass('sub-menu')){
                //有次级菜单点击失效
                return false;
            }
            else{
                $(this).parents('.dropdown-menu').siblings('a.btn').text($(this).text());
            }
        });
        $(document).on('click','.dropdown>.dropdown-menu>li>ul.sub-menu>li>a',function(event) {//次级菜单点击
            $(this).parents('.dropdown-menu').siblings('a.btn').text($(this).text());
        });
        $(document).on('mouseover','.dropdown>.dropdown-menu>li>a',function(event) {//鼠标经过显示次级菜单
            if($(this).siblings('ul').hasClass('sub-menu')){
                 $(this).siblings('ul.sub-menu').show();
            }
        });
        $(document).on('mouseleave','ul.sub-menu',function(event) {//鼠标离开隐藏次级菜单   
            $(this).hide(); 
        });
        //关闭提示
        $('#publishActivity input').focusin(function(event) {
            $(this).siblings('label').hide();
        });
        $('#publishActivity textarea').focusin(function(event) {
            $(this).siblings('label').hide();
        });
        //退款
        $('#refundjj').mouseover(function () {
            $(this).parents('.dropdown.refund').siblings('span.droptips').html('*如需申请退款请于开始前24小时外申请。取消参加后，费用自动退回。');
        });
        $('#norefund').mouseover(function () {
            $(this).parents('.dropdown.refund').siblings('span.droptips').html('本活动票卷一旦售出，恕不退还。无法参加活动，请将票卷转让给其他人。');
        });
        $('.dropdown.refund>.dropdown-menu').mouseleave(function () {
            $(this).parents('.dropdown.refund').siblings('span.droptips').html('');
        });
        $('#refundjj').click(function(event) {
            $('#refund').val('1');
        });
        $('#norefund').click(function(event) {
            $('#refund').val('2');
        });
        //兴趣 
        var $subUI = $('.interest-list');
        $('.interest-menu>li>a').on('click',function(event) {
            var inParenId = $(this).attr('id');
            $('.interest-menu').siblings('img.loading').show();
            $.get('/web/interest-children', {parentId:inParenId},function(res) {
                if(res.status!=='success'){//连接失败
                    setTimeout(function() {//等待5秒
                        $('.interest-menu').siblings('img.loading').hide();
                        $('.interest label').text('连接超时，请重新选择');
                        $('.interest label').show();
                    }, 5000);
                }else{//连接成功
                    $subUI.children().remove();
                    for(i=0;i<res.data.length;i++){
                       var subid = res.data[i].id;
                       var subname = res.data[i].name;
                       $subUI.append('<li><a role=\"button\" id=\"'+subid+'\" >'+subname+'</a></li>');
                    }
                    $subUI.parent('.dropdown').addClass('open');
                    $('.interest-menu').siblings('img.loading').hide();
                    $('.sub-interest').show();
                    $('.sub-interest').children('a.btn').text(res.data[0].name);
                    $('.interest-list>li>a').on('click',function () {
                        var subID = $(this).attr('id');
                        var inInput = '<span id="'+subID+'">'+$(this).text()+'<i></i></span>';
                        $interestTips.hide(); 
                        if($('div.interest-input').text()=='请先选择兴趣分类'||$('div.interest-input').text()==''){//未选兴趣
                            $('div.interest-input').text('');
                            $('div.interest-input').append(inInput);
                        }
                        else{//选了兴趣
                            if($('div.interest-input span').length==1){//选了1个兴趣
                                if($(this).text()==$($('div.interest-input span')[0]).text()){ 
                                    $interestTips.show();    
                                    $interestTips.text('两个兴趣不能相同');
                                    return false;
                                }
                            $('div.interest-input').append(inInput);
                            }
                            else if($('div.interest-input span').length==2){//选了2个兴趣
                                $interestTips.show(); 
                                $interestTips.text('兴趣不能超过2个');
                            }
                        }
                        $('div.interest-input>span>i').on('click',function () {//删除子兴趣
                            $(this).parent().remove();
                            $interestTips.hide();
                        });
                    });
                }
            },'json');
        }); 

    //省市区联动
    $('#pro>li>a').click(function(event) {//选择省
        var proID = $(this).attr('id');
        var $cityUI = $('#city');
        var $areaUI = $('#area');

        $('#provinceId').val(proID);
        //console.log($('#provinceId').val());
        //切换效果
        $('#pro').siblings('img').css({left: '140%'});
        $('#pro').siblings('img').show();
        $.get('/web/cities',{provinceId:proID}, function(res) {
            if(res.status!=='success'){//连接失败
                setTimeout(function() {//等待5秒
                    $('#pro').siblings('img').hide();
                    $partsTips.text('连接超时，请重新选择');
                    $partsTips.show();
                }, 5000);
            }else{//连接成功
                //切换效果
                $cityUI.children().remove();
                $cityUI.parents('.dropdown').show();
                $cityUI.parents('.dropdown').addClass('open');
                $cityUI.siblings('a.btn').text(res.cities[0].value);
                $('#pro').siblings('img').hide();
                
                //载入城市
                for (var j = 0; j < res.cities.length; j++) {
                    var cityid = res.cities[j].id;
                    var cityname = res.cities[j].value;
                    $cityUI.append('<li><a role=\"button\" id=\"'+cityid+'\"  title="'+cityname+'">'+cityname+'</a></li>');
                };
                //设置默认县
                var autoCity = res.cities[0].id;
                $.get('/web/areas',{cityId:autoCity}, function(res) {
                    if(res.areas.length==0){
                        $areaUI.hide();
                        $('#pro').siblings('img').hide();
                        $('td.parts label.error').text('没有相关的县或街道');
                        $('td.parts label.error').show();
                    }
                    else{
                        $areaUI.siblings('a.btn').text(res.areas[0].value);
                    }
                    
                })

                $('#city>li>a').on('click',function () {//选择市
                    var cityID = $(this).attr('id');
                    $('#cityId').val(cityID);
                    //console.log($('#cityId').val());
                    //$('#nowPart').val(cityID);//城市ID传入nowPart
                    $('#pro').siblings('img').css({left: '250%'});
                    $('#pro').siblings('img').show();
                    $('td.parts label.error').hide();
                    $.get('/web/areas',{cityId:cityID}, function(res) {
                        if(res.status!=='success'){//连接失败
                            setTimeout(function() {//等待5秒
                                $partsTips.text('连接超时，请重新选择');
                                $partsTips.show();
                                $('#pro').siblings('img').hide();
                            }, 5000);
                        }else{//连接成功
                            $areaUI.children().remove();
                            $('#lockMap').show();
                            $('#partsMap').show();
                            $('#add').show();
                            $('.abc').show();
                            if(res.areas.length=='0'){//没有县
                                $('#pro').siblings('img').hide();
                                $('td.parts label.error').text('没有相关的县或街道');
                                $('td.parts label.error').show();
                                $areaUI.parents('.dropdown').hide();
                                $areaUI.siblings('a.btn').text('');      
                            }
                            else{//有县
                                //切换效果
                                $('#pro').siblings('img').hide();
                                $areaUI.siblings('a.btn').text(res.areas[0].value);
                                $areaUI.parents('.dropdown').show();
                                $areaUI.parents('.dropdown').addClass('open');
                                $('td.parts label.error').hide();
                                $('#add').show();
                                $('.abc').show();
                                for (var k = 0; k < res.areas.length; k++) {//载入县
                                    var areaid = res.areas[k].id;
                                    var areaname = res.areas[k].value;
                                    $areaUI.append('<li><a role=\"button\" id=\"'+areaid+'\"  title="'+areaname+'">'+areaname+'</a></li>');
                                }
                                //选择区赋值给input
                                $('#publishActivity #area>li>a').on('click',function () {
                                    $('#areaId').val($(this).attr('id'));
                                    //$('#nowPart').val($(this).attr('id'));//县名传入nowPart
                                    //console.log($('#areaId').val());
                                });  

                            }
                        }
                    },'json'); 
                }); 
            }
        },'json');
    });

    
    if($('body').hasClass('user')){//进入个人中心的时候加载此JS
        //地图
        var marker,map = new AMap.Map("partsMap", {
            resizeEnable: true,
            center: [116.397342,39.908983],
            zoom: 18
        });

        //设置城市
        AMap.event.addDomListener(document.getElementById('lockMap'), 'click', function() {//返回用户所选区或县
            $('#add').removeAttr('disabled');
            if($('#area').parents('.dropdown').css('display')=='none'){//没县
                var b = $('#city').siblings('a.btn').text();
                 q(b);
            }else{//有县
                var c = $('#area').siblings('a.btn').text();
                 q(c);
            }
            function q(a) {
                var cityName = a;
                if (!cityName) {
                    cityName = '北京市';
                }
                else if(cityName==='其它区'||cityName==='澳门半岛'||cityName==='海外'){
                    $('input#add').val('地图上检索不到当前区县');
                }
                else{
                    $('input#add').val('标记下方地图获取详细地址');
                }
                map.setCity(cityName);
            }
        });

        //为地图注册click事件,获取鼠标点击的经纬度坐标
        var clickEventListener = map.on('click', function(e) {
            $('.amap-marker').removeClass('active');
            hideTips($partsTips);
            if (marker) {//删除上一个标记
                marker.setMap(null);
                marker = null;
            }
            $('#coordinate').val(e.lnglat.getLng() + ',' + e.lnglat.getLat()); //当前坐标传入#coordinate
            var lnglatXY = new Array;
            lnglatXY = $('#coordinate').val();
            //console.log(lnglatXY);
            if($('body').hasClass('user')){
                //个人中心的逆地理编码
                var geocoder = new AMap.Geocoder({
                    radius: 1000,
                    extensions: "all"
                });    
                geocoder.getAddress(lnglatXY, function(status, result) {
                    if (status === 'complete' && result.info === 'OK') {
                        geocoder_CallBack(result);
                    }
                }); 
                var XYindex = lnglatXY.indexOf(',');//拆分坐标传入标记addMarker()
                var a = lnglatXY.substr(0,XYindex);
                var b = lnglatXY.substr(XYindex+1,lnglatXY.length-1);
                addMarker(a,b);
            }
            // 实例化点标记
            function addMarker(mapX,mapY) {                
                if (marker) {
                    return;
                }
                marker = new AMap.Marker({
                    icon: "/img/web/map-icon.png",
                    position: [mapX,mapY],
                    zIndex:200,
                    clickable:false
                });
                marker.setMap(map);
            }  
            function geocoder_CallBack(data) {
                var address = data.regeocode.formattedAddress; //返回地址描述
                document.getElementById("add").value = address;
                checkParts (); 
            }
        }); 
        
        //输入提示
        $(document).on('focusin', '#add', function(event) {
            checkParts ();
            AMap.plugin(['AMap.Autocomplete','AMap.PlaceSearch'],function(){
                 var autoOptions = {
                      city: '', //城市，默认全国
                      input: "add"//使用联想输入的input的id
                 };
                 autocomplete = new AMap.Autocomplete(autoOptions);//搜索提示
                 var placeSearch = new AMap.PlaceSearch({
                        map:map
                 });
                  // 设置搜索提示框的位置
                 $('.amap-sug-result')[0].style.position= 'absolute';
                 $('.amap-sug-result')[0].style.zIndex= '99';

                 AMap.event.addListener(autocomplete, "select", function(e){
                       hideTips($partsTips);
                       var proVa = $('#pro').siblings('a.btn').text();
                       var cityVa = $('#city').siblings('a.btn').text();
                       placeSearch.search(proVa+cityVa+e.poi.name,function(status, result){
                            //TODO : 按照自己需求处理查询结果
                            var resultArray = result.poiList.pois;
                            //console.log(resultArray);
                            if(resultArray[0]==null){//搜索没有结果
                                regTips($partsTips,'请用另外的关键字进行搜索');
                            }
                            else{
                                //因为点标记的数量与搜索出来的坐标点数量一致
                                $(document).on('click', '.amap-marker', function(event) {
                                    hideTips($partsTips);
                                    var proVa = $('#pro').siblings('a.btn').text();
                                    var cityVa = $('#city').siblings('a.btn').text();
                                    var areaVa = $('#area').siblings('a.btn').text();
                                    if($(this).children().hasClass('amap-icon')){
                                        return false;
                                    }
                                    $('.amap-icon').parent().hide();
                                    $('.amap-marker').removeClass('active');

                                    var pindex = $(this).children().children('.amap_lib_placeSearch_poi').text();
                                    $(this).addClass('active');
                                    $('#coordinate').val(resultArray[pindex-1].location.lng + ',' + resultArray[pindex-1].location.lat);//坐标传入

                                    if(resultArray[pindex-1].name.indexOf(proVa+cityVa+areaVa)>-1){//选中的地址含有联动的城市结构
                                        $('#add').val(resultArray[pindex-1].name);
                                    }
                                    else{//选中的名称不重复
                                        $('#add').val(proVa+cityVa+areaVa+resultArray[pindex-1].name);
                                    }
                                    //console.log($('#coordinate').val());
                                });
                            }
                        })
                 });
             }); 
        });



        //禁止用户删除与联动结果相同的字符
        $(document).on('keyup', '#add', function(event) {
            checkParts ()
        });

        //监控输入框与联动结果是否匹配
        function  checkParts () {
            var addPlace = $('#add').val();//地址栏
            var proVa = $('#pro').siblings('a.btn').text();
            var cityVa = $('#city').siblings('a.btn').text();
            if(cityVa.indexOf(proVa)>-1){//重庆、北京、上海、天津等直辖市
                var selectPlace = $('#city').siblings('a.btn').text()+$('#area').siblings('a.btn').text();
            }
            else{
                var selectPlace = $('#pro').siblings('a.btn').text()+$('#city').siblings('a.btn').text()+$('#area').siblings('a.btn').text();//省市区联动结果
            }
            if(addPlace.indexOf(selectPlace)>-1){
                //console.log('地址栏地名与联动结果相匹配');
                return true;
            }
            else{
                regTips($partsTips,'请在当前地区进行搜索');
                $('#add').val(selectPlace);
                return false;
            }
        }

        //上传图片

        // 初始化Web Uploader
        var  $list = $('#fileList'),
        // 缩略图大小
        thumbnailWidth = 300,
        thumbnailHeight = 300,
         // Web Uploader实例
        uploader;
        var uploader = WebUploader.create({
            // 选完文件后，是否自动上传。
            auto: true,
            // swf文件路径
            swf:  '/js/webuploader/Uploader.swf',
            // 文件接收服务端。
            server: '/image/upload',
            method: 'post',
            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: '#filePicker',
            // 只允许选择图片文件。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            }
        });
        // 当有文件添加进来的时候
        uploader.on( 'fileQueued', function( file ) {
         if(file.size>2000000){
             $('#uploader-demo').siblings('label').show();
             $('#uploader-demo').siblings('label').text('图片不能超过2M');
         }
         else{
             var $li = $(
                     '<div id="' + file.id + '" class="file-item thumbnail">' +
                         '<img>' +
                         '<div class="info">' + file.name + '</div>' +
                         '<div class="file-panel">'+
                              '<span class="cancel">删除</span>'+
                              '<span class="preview" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">预览</span>'+
                          '</div>'+
                     '</div>'
                     ),
             $img = $li.find('img');
             // $list为容器jQuery实例
             $list.append( $li );
             // 创建缩略图
             // 如果为非图片文件，可以不用调用此方法。
             // thumbnailWidth x thumbnailHeight 为 100 x 100
             uploader.makeThumb( file, function( error, src ) {
                 if ( error ) {
                     $img.replaceWith('<span>不能预览</span>');
                     return;
                 }
                 $img.attr( 'src', src );
             }, thumbnailWidth, thumbnailHeight );
             //删除缩略图
             $(document).on('click', '.file-panel .cancel', function(event) {
                 $(this).parents('.file-item').remove();
             });
         }
        });
        // 文件上传过程中创建进度条实时显示。
        uploader.on( 'uploadProgress', function( file, percentage ) {
            var $li = $( '#'+file.id ),
                $percent = $li.find('.progress span');
            // 避免重复创建
            if ( !$percent.length ) {
                $percent = $('<p class="progress"><span></span></p>')
                        .appendTo( $li )
                        .find('span');
            }
            $percent.css( 'width', percentage * 100 + '%' );
        });
        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader.on( 'uploadSuccess', function( file,data ) {
         if(data.picKey==undefined){
             //console.log('图片不对');
         }
         else{
             $( '#'+file.id ).addClass('upload-state-done');
             $( '#'+file.id ).children('.file-panel').children('.preview')[0].id = data.picKey;//标记图片ID
             //console.log(data);
             //console.log(file);
             $(document).on('click', '.file-panel .preview', function(event) {//图片预览功能
             //console.log($(this));
                var picKey = $(this).attr('id');
                var picUrl = '/image/get/'+picKey;
                $('.modal .modal-content').children().remove();
                $('.modal .modal-content').append('<img src="'+picUrl+'"/>');
             });
         }

        });
        // 文件上传失败，显示上传出错。
        uploader.on( 'uploadError', function( file ) {
            var $li = $( '#'+file.id ),
                $error = $li.find('div.error');
            // 避免重复创建
            if ( !$error.length ) {
                $error = $('<div class="error"></div>').appendTo( $li );
            }
            $error.text('上传失败');
        });
        // 完成上传完了，成功或者失败，先删除进度条。
        uploader.on( 'uploadComplete', function( file ) {
            $( '#'+file.id ).find('.progress').remove();
        });

        //获取当前用户圈子
        setTimeout(function () {
            $.get('/web/user-groups', function(res) {
                if(res.status!=='success'){//连接失败
                    setTimeout(function() {//等待5秒
                    //alert('获取圈子失败');
                    }, 5000);
                }
                else{//连接成功
                    if(res.groups.length==0){//没有圈子
                    }
                    else{//有圈子
                        $('.dropdown.group .dropdown-menu').append('<li class=\"relative Zindex9\"><a role=\"button\" id=\"group1\">圈子</a><ul class=\"sub-menu group\"></ul></li>');
                        var $groupUI = $('ul.sub-menu.group');
                        for (var k = 0; k < res.groups.length; k++) {
                          var groupName = res.groups[k].name;
                          var groupId =  res.groups[k].id;
                          $groupUI.append('<li><a role=\"button\" id=\"'+res.groups[k].id+'\">'+res.groups[k].name+'</a></li>');
                        }; 
                   }
                }
               //console.log(res);
            });
        }
        ,2000);
    }

    //选择发布名义
    $(document).on('click','.dropdown.group>.dropdown-menu>li>a#group2',function () {//个人
        $('#type').val('2');
        $('#typeId').val('');
    });
    $(document).on('click','.dropdown.group>.dropdown-menu>li>.sub-menu.group>li>a',function () {//圈子
        $('#type').val('1');
        $('#typeId').val($(this).attr('id'));
    });
   $(document).on('click', '#filePicker', function(event) {//点击增加图片隐藏提示
        $('#uploader-demo').siblings('label').hide();
    });

    $(document).on('focusin', '#timeStart,#timeEnd', function(event) {//鼠标经过时间框隐藏提示
        $(this).siblings('label').hide();
    });

    //点击发布的验证
    $(document).on('click', '#publishActivity a.subform.jjbtn,#publishActivity a.send', function(event) {
        var $captcha = $('#captcha');
        var interestSpan = $('div.input-result.interest-input>span').length;//兴趣验证
        var timeStart = $('#timeStart').val();//活动开始时间
        var timeEnd = $('#timeEnd').val();//活动结束时间
        var coordinate = $('#coordinate').val();//坐标
        var desVa = $('#description').val();
        var acName = $('#name').val();//活动名称
        var acMaxJoiners = $('#maxJoiners').val();//参与人数
        var acCaptcha = $('#captcha').val();
        //console.log(acMaxJoiners);
        var acFee = $('#fee').val(); //费用
        var fileList = $('#fileList>div.thumbnail').length;//图片
        var addressVa = $('#add').val();

        if(interestSpan==0||$('div.input-result.interest-input')=='请先选择兴趣分类'){
            $(window).scrollTop(0);
            $('.interest label').text('请至少选择一个兴趣');
            $('.interest label').show();
            return false;
        }
        if(acName==''){
            $(window).scrollTop(50);
            $('#name').siblings('label').text('活动名称不能为空');
            $('#name').siblings('label').show();
            return false;
        }
        else if(acName!==''){
            if(acName.length>30){
                $(window).scrollTop(50);
                $('#name').siblings('label').text('活动名称不可超过30个字符');
                $('#name').siblings('label').show();
                var newacName = acName.substr(0,30);
                $('#name').val(newacName);
                return false;
            }
            if(acName.length<2){
                $(window).scrollTop(50);
                $('#name').siblings('label').text('活动名称至少2个字符');
                $('#name').siblings('label').show();
                return false;
            }else{
                $('#name').siblings('label').hide();
            }
        }
        if(desVa==''){
            $(window).scrollTop(100);
            $('#description').siblings('label').show();
            $('#description').siblings('label').text('活动介绍不能为空');
            return false;
        }
        else if(desVa!==''){
            if(desVa.length>300){
                $(window).scrollTop(100);
                $('#description').siblings('label').show();
                $('#description').siblings('label').text('活动介绍不超过300个字');
                var newdesVa = desVa.substr(0,300);
                $('#description').val(newdesVa);
                return false;
            }
            else{
                $('#description').siblings('label').hide();
            }
        }
        if(timeStart==''){
            $(window).scrollTop(400);
            $('#timeStart').siblings('label.error').text('开始时间不能为空');
            $('#timeStart').siblings('label.error').show();     
            return false;
        }
        if(timeEnd==''){
            $(window).scrollTop(400);
            $('#timeEnd').siblings('label.error').text('结束时间不能为空');
            $('#timeEnd').siblings('label.error').show();
            return false;
        }
        if(coordinate==''){
            $(window).scrollTop(500);
            $('#coordinate').siblings('label.error').text('请点击地图，以标记活动地点');
            $('#coordinate').siblings('label.error').show();
            return false;
        }
        if(addressVa==''){
            $(window).scrollTop(500);
            $('#coordinate').siblings('label.error').text('请输入活动地址');
            $('#coordinate').siblings('label.error').show();
            return false;
        }
        if(acMaxJoiners==''){
            $(window).scrollTop(550);
            $('#maxJoiners').siblings('label').text('参与人数上限为最多为11人');
            $('#maxJoiners').siblings('label').show();
            return false;
        }
        if(acMaxJoiners>11){
            $(window).scrollTop(550);
            $('#maxJoiners').siblings('label').text('人数不能超过11人');
            $('#maxJoiners').siblings('label').show();
            $('#maxJoiners').val('11');
            return false;
        }
        if(acFee==''){
            $(window).scrollTop(550);
            $('#fee').siblings('label').text('活动费用不能为空');
            $('#fee').siblings('label').show();
            return false;
        }
        if($('.dropdown.group>a.btn').text()=='请选择'){
            $(window).scrollTop(1300);
            $('.dropdown.group').siblings('label.error').text('名义不能为空');
            $('.dropdown.group').siblings('label.error').show();
            return false;
        }
        if($('.dropdown.refund>a.btn').text()=='请选择'){
            //e.preventDefault();//阻止提交表单
            $(window).scrollTop(1300);
            $('.dropdown.refund').siblings('label.error').text('退款设置不能为空');
            $('.dropdown.refund').siblings('label.error').show();
            return false;
        }
        else if(acCaptcha==''){ 
            if($(this).hasClass('send')){
                if($(this).hasClass('wait')){//如果已经发送
                    regTips($captcha,'请耐心等待再次发送');
                    return false;
                }
                else{//第一次发送
                    $captcha.siblings('img.loading').show();
                    captcha(2,$('#mobileNum').val());
                }
            }
            else{
                $('#captcha').siblings('label.error').text('验证码不能为空');
                $('#captcha').siblings('label.error').show();
                return false;
            }
        }
        // if(fileList==0){
        //     $(window).scrollTop(1200); 
        //     $('#uploader-demo').siblings('label.error').text('请至少上传一张图片');
        //     $('#uploader-demo').siblings('label.error').show();
        // }
        else if(acCaptcha!==$('#getCaptcha').val()){
            regTips($captcha,'请输入正确的验证码');
            return false;
        }
        else{//提交表单
            // var acName = $('#name').val();//活动名称
            var acType = $('#type').val();//名义类型
            var acTypeId = $('#typeId').val();//圈子类型
            var acProId = $('#provinceId').val();//省ID
            var acCityId = $('#cityId').val();//市ID
            var acAreaId = $('#areaId').val();//区ID
            //var acFee = $('#fee').val(); //费用
            //var acMaxJoiners = parseInt($('#maxJoiners').val());//参与人数
            var acAddress = $('#add').val();//活动地址

            var trapeze = $('#coordinate').val();//经纬度
            var trapezeindex = trapeze.indexOf(',');
            var acAddressLng = trapeze.substr(0,trapezeindex);//经度
            var acAddressLat = trapeze.substr(trapezeindex+1,trapeze.length-1);//纬度

            var acDescription = $('#description').val();//活动描述
            var acRefundType = $('#refund').val();//是否接受退款

            if($('.interest-input>span').length==1){//所选兴趣
                $('#interestids').val($('.interest-input>span')[0].id);
            }
            else if($('.interest-input>span').length==2){
                $('#interestids').val($('.interest-input>span')[0].id+','+$('.interest-input>span')[1].id)
            }
            var acinterestIds = $('#interestids').val();

            var strStart = timeStart.replace(/-/g,'/');//开始结束时间戳
            var strEnd = timeEnd.replace(/-/g,'/');
            var dateStart = new Date(strStart);
            var dateEnd =  new Date(strEnd);
            var actimeStart =  dateStart.getTime();
            var actimeEnd =  dateEnd.getTime();
            // console.log(actimeStart);
            // console.log(actimeEnd);

            var $pics = $('#fileList .file-item .file-panel .preview');//上传的图片
            //console.log($pics);
            var  PicKey='';
            if($pics.length==0){
                $('#upPicKey').val('');
            }
            else if($pics.length==1){
                PicKey = $pics[0].id;
                $('#upPicKey').val(PicKey);
            }
            else{
                for (var n = 0; n < $pics.length; n++) {
                    PicKey =   $pics[n].id + ',' + PicKey;
                    var okPicKey =  PicKey.substr(0,PicKey.length-1);
                    $('#upPicKey').val(okPicKey);
                }  
            }
            var acpicKeys = $('#upPicKey').val();

            $.post('/web/create-activity', 
                    {name: acName,
                    type: acType,
                    typeId: acTypeId,
                    provinceId: acProId,
                    cityId: acCityId,
                    areaId: acAreaId,
                    timeStart: actimeStart/1000,
                    timeEnd: actimeEnd/1000,
                    fee: acFee,
                    maxJoiners: acMaxJoiners,
                    address: acAddress,
                    addressLng: acAddressLng,
                    addressLat: acAddressLat,
                    description: acDescription,
                    refundType: acRefundType,
                    interestIds: acinterestIds,
                    picKeys: acpicKeys,
                    captcha: acCaptcha
                }, 
                function(data, textStatus, xhr) {
                    // console.log(textStatus);
                    // console.log(xhr);
                    if(data.status=='success'){
                        location.href='/web/user';
                        alert(data.msg);
                    }
                    else{
                        alert(data.msg);
                    }
                });
        }
    });
    
    //user end 
    })(); 

    //公用提示
    function regTips(ob,text,ok){//ok随意用数字赋值只是来区别有或者无这个参数的
        if(ok==undefined){
            ob.parent().find('label').text(text);
            ob.parent().find('label').show();
            ob.parent().find('label').removeClass('right');
        }
        else{
            ob.parent().find('label').text(text);
            ob.parent().find('label').show();
            ob.parent().find('label').addClass('right');
        }
    }

    function hideTips(obb){
         obb.parent().find('label').hide();   
    }

    //发送验证码
    function captcha(tagTXT,mobileNum) {
        var $send = $('.send');
        var $captcha = $('#captcha');
        hideTips($captcha);
        $.get('/web/captcha', {mobile:mobileNum,tag:tagTXT},function(data) {
            if(data.status!=='success'){
                regTips($captcha,data.msg);
                $captcha.siblings('img.loading').hide();
            }
            else{
                $('#getCaptcha').val(data.captcha);
                $captcha.siblings('img.loading').hide();
                regTips($captcha,data.msg,1);
                $send.addClass('wait');
                $send.text('还有60s');

                var time = 60;
                var timeInt = setInterval(function () {
                    time = time -1;
                    $send.text('还有'+time+'s');
                    //console.log(time);
                },1000);

                setTimeout(function  () {
                    window.clearInterval(timeInt);
                    $send.removeClass('wait');
                    $send.text('重新发送');
                    hideTips($captcha);
                },60000);
            } 
        });
        setTimeout(function  () {//ajaxj请求不成功的情况
            if($captcha.siblings('img.loading').css('display')=='block'){
                $captcha.siblings('img.loading').hide();
                regTips($captcha,'发送请求超时，请重新点击获取验证码');
            }
        },5000);
    }
    //JS结束
});

