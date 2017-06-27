 /*!
 * loongjoy.js
 *一些说明：
 * 1.function()为全站调用方法.
 * 2.FUNCTION 为涉及到的页面效果和交互.
 * 3.尝试使用if...else if...判断页面调用相应的方法和效果.
 * 4.DOM.ready内开始调用页面所需的方法和效果.
 * 5.方法效果在DOM.ready外.
 * 6.页面顶部和底部需另加JS的话,结构请看模版.
 * author: loongjoy
 */

  /**
  *不让console.log报错
  */
  var console=console||{log:function(){return;}}
  /**
  *hack
  */
  if($(window).width()<1130) $('.header-bottom,.footer,body,html').width(1130);

  /**
  *全局变量
  */
  var homeUrl = location.href;
  if(homeUrl.indexOf('http://lanmeng.doboyu.com/')>-1){
      homeUrl = 'http://lanmeng.doboyu.com/';
  }
  else if(homeUrl.indexOf('http://www.lemauto.cn/')>-1){
      homeUrl = 'http://www.lemauto.cn/';
  }
  else{
      homeUrl = 'http://lanwang2.test.com/';
  }


  var isDeal = $('.deal-main').hasClass('deal-main');
  var brandData = [];

  //载入热门品牌
  $.get('/innovate/getTypebydataInterface/0', function(data) {
      // console.log(data.content.letter[0].ucfirst);//首字母
      // console.log(data.content.brands[1].brandId);//品牌ID
      // console.log(data.content.brands[1].brandName);//品牌名字
      // console.log(data.content.brands[1].ucfirst);//该品牌首字母
      if(data.status==1){
          brandData = data.content.brands;
          loadBrand(data,0);
          //载入其他品牌
          $.get('/innovate/getTypebydataInterface/1', function(data) {
              if(data.status==1){
                  brandData = brandData.concat(data.content.brands);
                  chosedStatus();
                  loadBrand(data,1);
              } 
          });
      }
      
  });

//载入品牌数据的公共方法
function  loadBrand(data,type) {
      var $hotTab = $('li.re.hot .brand-tab');
      var $hotCon = $('li.re.hot .brand-content');
      var $otherTab = $('li.re.other .brand-tab');
      var $otherCon = $('li.re.other .brand-content');
      var letter = data.content.letter;
      var brands = data.content.brands;
      var tabLi = '';
      var conLi = '';
      $.each(letter, function(index, val) {
         tabLi += '<li><a index=\"'+this.ucfirst+'\">'+this.ucfirst+'</a></li>';
      });
      $.each(brands, function(index, val) {
         conLi += '<a class=\"brand'+this.ucfirst+'\" data-id=\"'+this.brandId+'\">'+this.brandName+'</a>';
      });
      if(type==0){//热门
          $hotTab.html('<li class="active"><a>所有</a></li>'+tabLi);
          $hotCon.html(conLi);
      }
      else if(type==1){//其他
          $otherTab.html('<li class="active"><a>所有</a></li>'+tabLi);
          $otherCon.html(conLi);
      }
  }

  /**
  *客服
  */
  function contactUs (openVa,closeVa) {
    $('.open-btn').click(function(event) {
        $('.contact-us').animate({
            right: openVa
          }, 500);
        $('.contact-left').addClass('close-con');
        $('.contact-right').css('visibility','visible');
        $('.open-btn').hide();
        $('.close-btn').show();
    });
    $('.close-btn').click(function(event) {
        $('.contact-us').animate({
            right: closeVa
          }, 500 );
        $('.contact-left').removeClass('close-con');

        setTimeout(function  () {
          $('.contact-right').css('visibility','hidden');
        },500);

        $('.open-btn').show();
        $('.close-btn').hide();
    });
  }

  /**
  *带按钮弹窗效果
  *tips:弹窗需要显示的文字
  *url:确定按钮需要跳转的链接；当url为特殊字符时，
  */
  function alertTips(tips,url,btn,param){
      var clientWidth = document.body.clientWidth;
      var tipsTop = 25+'%';
      var isReady = $('.down-tips').hasClass('down-tips');
      var tipsBody = '<div class="down-tips">'+
      '<div class="tips">提示</div>'+
      '<div class="closeBtn"></div>'+
      '<table>'+
      '<tr>'+
      '<td class="tips-con">'+tips+'</td>'+
      '</tr>'+
      '</table>'+
      '<a class="detail-btn" id="sure">'+btn+'</a><a class="detail-btn" id="cancel">取消</a>'+
      '</div>';

      //是否存在提示框                            
      if(!isReady) $('body').append(tipsBody);
      else if(isReady){
          $('.tips-con').html(tips);
          $('#sure').text(btn);
      }

      //按钮
      if(btn==undefined) btn = '确定';
      else if(btn=='接受') $('#cancel').html('拒绝');

      //是否有路径
      if(url==undefined) $('#sure').removeAttr('href').removeAttr('target');
      else{
          if(url=='creativeOrderOK'||url=='applyBind'||url=='inviteBind') ;
          else $('#sure').attr({'href':url,'target':'_self'});
      }

      //提示框定位并显示
      $('.down-tips').css({'left': clientWidth / 2 - 200,'top': tipsTop}).show();

      $('.down-tips').on('click', '.closeBtn,#cancel,#sure', function(event) {
          $('.down-tips').hide();
          //确定按钮
          if($(this).attr('id')=='sure'){
              //登出操作
              if(url=='/loginout') Cookies.remove('isauth');
              //创意设计，确认完稿操作
              else if(url=='creativeOrderOK'){
                  load($.post('/user/confirmcomplete', {status:3,id:$('input[name="orderID"]').val()}))
                  .done(function (res) {
                      if(res.status==0){
                          littleTips('确认成功');
                          window.location.reload();
                      }

                  })
                  .fail(function () {
                      littleTips('服务器繁忙，请重试或者联系客服');
                  });
              }
              //集团申请和接受邀请
              else if(url=='applyBind'||url=='inviteBind'){
                  if(url=='inviteBind'){
                      console.log('接受');
                      load($.post('/mine/api/accept-admin-request', {uid:param}))
                      .done(function (res) {
                          littleTips(res.tips);
                          if(res.status==1) location.reload();
                      })
                      .fail(function () {
                          littleTips('接受失败，请重试');
                      });
                  }
                  else{
                      console.log('申请');
                      load($.post('/mine/api/bond-group-api', {uid:param}))
                      .done(function (res) {
                          littleTips(res.tips);
                          if(res.status==1) location.reload();
                      })
                      .fail(function () {
                          littleTips('申请失败，请重试');
                      });
                  }      
              }

          }
          //取消按钮
          else if($(this).attr('id')=='cancel'){
              console.log('拒绝');
              if(url=='inviteBind') {
                  load($.post('/mine/api/refuse-admin-request'))
                  .done(function (res) {
                      littleTips(res.tips);
                      if(res.status==1) location.reload();
                  })
                  .fail(function () {
                      littleTips('拒绝失败，请重试');
                  });
              }
          }
          //解除绑定，避免重复调用JS
          $('.down-tips').off('click', '.closeBtn,#cancel,#sure');
      });
  }

  /**
  *不带按钮弹窗效果
  */
  function littleTips(text) {
      var clientWidth = document.body.clientWidth;
      var tipsTop = 25+'%';
      var tipsBody = '<div class=\"little-tips\">'+text+'</div>';
      if($('.little-tips').hasClass('little-tips')){
          $('.little-tips').html(text).show();
      }
      else{
          $('body').append(tipsBody);
      }
      $('.little-tips').css({'left': clientWidth / 2-$('.little-tips').width()/2-50,'top': tipsTop}).show();//提示框定位;

      setTimeout(function () {
          $('.little-tips').fadeOut();
      },2000);
  }

  /**
  *多文字省略号处理
  */
  function ellipsis (txt,obj) {
    //txt 显示的最大字数
    //obj jQuery对象
    var $ellipsisWord = obj;
    if(obj==undefined){
      //IE8 bug
    }
    else{
      for (i = 0; i < $ellipsisWord.length; i++){
            var text = $ellipsisWord[i];
            str = text.innerHTML;
            var textLeng = txt;
            if (str.length > textLeng) {
                text.innerHTML = str.substring(0, textLeng) + "...";
            }
      }
    }
  }

/**
*倒计时转换时间
*endStamp为截止时间的时间戳
*obj为DOM对象,针对聚惠的倒计时
*/
function timeStamp(endStamp,obj) {
  var timestamp = $('input[name="current"]').val();//当前服务器时间戳
  var $Dspan =  $(obj).siblings('ul.time').children('.day').children('.shade');//天数容器
  var $Hspan =  $(obj).siblings('ul.time').children('.hour').children('.shade');//小时容器
  var $Mspan =  $(obj).siblings('ul.time').children('.minute').children('.shade');//分钟容器
  var $Sspan =  $(obj).siblings('ul.time').children('.second').children('.shade');//秒数容器
  //var timestamp = new Date().getTime();//当前时间戳

  if(endStamp.length==10) endStamp = endStamp*1000;
  if(timestamp.length==10)  timestamp = timestamp*1000;

  if(timestamp>=parseInt(endStamp)){
      $(obj).siblings('ul.time').remove();
      $('.gather-ready-detail .detail-btn.buy').addClass('disabled').text('已结束');
      return false;
  }
  var countDown = parseInt(endStamp) - timestamp;//两者之差
  var h;
  //console.log(timestamp);
  d = countDown/3600/1000/24;//获取当前相差的天数带小数点~~~
  var stringD = d.toString();
  var indexD = stringD.indexOf('.');
  var day = stringD.substring(0,indexD);
  if(parseInt(day)==0){
      day = 0;
  }
  else if(parseInt(day)<=-1){
    $('.gather-detail ul.time').hide();//聚惠详情页
    $('.detail-btn.buy ').addClass('disabled').text('已结束');
    $(obj).parents('.gather-main .item').remove();//聚惠列表页
  }
  $Dspan.html(day);
  var sd = stringD.substring(indexD,stringD.length-1);//小数点后面
  h = sd*24;

  var stringH = h.toString();//转换为string类型
  var indexH = stringH.indexOf('.');
  var hour = stringH.substring(0,indexH);//小时数
  $Hspan.html(hour);//传到页面
  //console.log(parseInt(hour));

  var m = stringH.substring(indexH,stringH.length-1);//小数点后面
  var a = m*60;//分钟
  var stringM = a.toString();
  var indexM = stringM.indexOf('.');
  var minute = stringM.substring(0,indexM);//分钟数
  $Mspan.html(minute);//传到页面
  //console.log(parseInt(minute));

  var b = stringM.substr(indexM,stringM.length-1);
  var c = b*60;
  var second = parseInt(c);
  $Sspan.html(second);//传到页面
  //console.log(second);

  var timeS = $Sspan.text();
  var timeM = $Mspan.text();
  var timeH = $Hspan.text();
  var timeD = $Dspan.text();
  var timeBox = '';

  //倒计时显示
  $.each($(obj).siblings('ul.time'), function(index, val) {
       $secondDis = $(val).find('.second>span');
       $secondRun = $(val).find('.second>.shade');
       $minuteDis = $(val).find('.minute>span');
       $minuteRun = $(val).find('.minute>.shade');
       $hourDis = $(val).find('.hour>span');
       $hourRun = $(val).find('.hour>.shade');
       $dayDis = $(val).find('.day>span');
       $dayRun = $(val).find('.day>.shade');
       goTime($secondDis,$secondRun,$minuteDis,$minuteRun,$hourDis,$hourRun,$dayDis,$dayRun);

  });

  //运行倒计时
  function goTime($secondDis,$secondRun,$minuteDis,$minuteRun,$hourDis,$hourRun,$dayDis,$dayRun){

      $secondDis.text($secondRun.text()-1);
      if($secondRun.text()==0){
          $secondDis.text(59);
      }

      $minuteDis.text($minuteRun.text()-1);
      if($minuteRun.text()==0){
          $minuteDis.text(59);
      }

      $hourDis.text($hourRun.text()-1);
      if($hourRun.text()==0){
          $hourDis.text(23);
      }

      $dayDis.text($dayRun.text()-1);
      if($dayRun.text()==0){
          $dayDis.text(0);
      }

      setInterval(function () {
          $secondRun.animate({top: 30,opacity:0},'slow','swing',function () {
              var second = $secondRun.text();
              //秒归0
              if(second==0){
                  //时间全部为0，移除该元素
                  if($dayRun.text()==0&&$hourRun.text()==0&&$minuteRun.text()==0) {
                    $dayDis.parents('.item').remove();
                    $dayDis.parents('.time').remove();
                    $('.gather-ready-detail .detail-btn.buy').addClass('disabled').text('已结束');
                    location.reload();
                  }
                  $(this).css({'top':0,'opacity':1.0}).text(59);
                  $secondDis.text(58);
                  $minuteRun.animate({top: 30,opacity:0}, 'slow','swing',function (){
                      $minuteRun.css({'top':0,'opacity':1.0}).text($minuteDis.text());
                      $minuteDis.text($minuteDis.text()-1);
                  });
                  //分归0
                  if($minuteRun.text()==0){
                      $minuteRun.css({'top':0,'opacity':1.0}).text(0);
                      $minuteDis.text(59);
                      $hourRun.animate({top: 30,opacity:0}, 'slow','swing',function (){
                          $hourRun.css('top',0).text($hourDis.text());
                          $hourDis.text($hourDis.text()-1);
                      });
                  }
                  //小时归0
                  if($hourRun.text()==0){
                      $hourRun.css({'top':0,'opacity':1.0}).text(0);
                      $hourDis.text(23);
                      $dayRun.animate({top: 30,opacity:0}, 'slow','swing',function (){
                          $dayRun.css('top',0).text($dayDis.text());
                          if($dayRun.text()!==0) $dayDis.text($dayDis.text()-1);
                      });
                  }
              }
              else if(second==1){
                  $(this).css({'top':0,'opacity':1.0}).text(0);
                  $secondDis.text(59);
              }
              else{
                   $(this).css({'top':0,'opacity':1.0}).text(second-1);
                   $secondDis.text(second-2);
              }
          });
      },1000);
  }

}
 // timeStamp(1452816000000);//2016-1-13 0点

/**
*图片缩略图和删除
*/
function imgPre (url,page,imgID) {
    var imgBox = $('.upload_btn_box.img');
    var succsessBox = '';
    if(page=='clip'){//上传素材
        succsessBox = '<div class="successBox" data-id="'+imgID+'">'+
                                    '<i></i>'+
                                    '<div class="imgCon"><img src="'+url+'" data-id="'+imgID+'"></div>'+
                                    '<textarea class=\"describe\">描述（20字以内）</textarea>'+
                                    '</div>';
    }
    else if(page=='example'){//上传案例
        succsessBox = '<div class="successBox" data-id="'+imgID+'">'+
                                    '<i></i>'+
                                    '<div class="imgCon"><img src="'+url+'" data-id="'+imgID+'"></div>'+
                                    '<a role=\"button\" class=\"setting\">设为封面</a>'+
                                    '<textarea class=\"describe\">描述（20字以内）</textarea>'+
                                    '</div>';
    }
    else{
        littleTips('请为上传图片指定页面');
    }
    imgBox.append(succsessBox);
}

//上传图片后的相关操作
(function () {
    var imgBox = $('.upload_btn_box.img');
    //删除图片
    $(document).on('click', '.successBox i', function(event) {
        $(this).parents('.successBox').remove();
    });
    //设为封面
    $(document).on('click', '.successBox .setting', function(event) {
        imgBox.find('img').attr('cover', '1');
        imgBox.find('a.setting').text('设为封面');
        $(this).text('封面').siblings('.imgCon').children('img').attr('cover','0');
    });
    //描述不超过20个字符
    $(document).on('keyup', '.successBox .describe', function(event) {
       var describe = $(this).val();
       if(describe.length>20){
            $(this).val(describe.substring(0,20));
       }
    });
})();

/**
*发送验证码
*/
function captcha(mobileNum) {
    var $send = $('.send');
    var txt;
    var signC = '4FFFA1170A96911BAA388449A889DBB4';
    var dateB = new Date();
    var b = parseInt(dateB.getMonth())+1;
    var signB = dateB.getFullYear()+'-'+b+'-'+dateB.getDate()+' '+dateB.getHours()+':'+dateB.getMinutes()+':'+dateB.getSeconds();
    var signA = mobileNum;
    var sign = hex_md5(signA+signB+signC);
    // console.log(signA+signB+signC);
    // console.log(sign);
    if($send.hasClass('wait')){
    }
    else{      
            $.get('/user/api/validatecode', {mobile:mobileNum,time:decodeURI(signB),sign:sign},function(data) {//接口为真
            if(data.status!==0){
                littleTips('验证码发送失败');
                $('#code-error').text('验证码发送失败，请稍后再试').next().hide();
                //重新获取图片验证码
                $('.code-img').attr('src', '/api/user/vailcode/'+parseInt(Math.random()*10000000000000)+'');
            }
            else{
                littleTips(data.tips);
                $send.addClass('wait').text('还有60s');
                $('#code-error').text('短信发送成功').next().hide();
                var time = 60;
                var timeInt = setInterval(function () {
                    time = time -1;
                    $send.text('还有'+time+'s');
                    //注册页面倒计时存入cookie
                    if(time==1){
                        Cookies.remove('regCode');
                    }
                    else{
                        Cookies.set('regCode',time);
                    }
                    //console.log(time);
                },1000);

                setTimeout(function  () {
                    window.clearInterval(timeInt);
                    $send.removeClass('wait').text('重新发送');
                    $('#code-error').text('');
                },60000);

            }

        });
    }
}

/**
*装载分页公用方法
*参数说明：
*1.需要currentPage（当前页）,totalPage（总页数）；
*2.DOM中必须有.page-action.white的框子；
*3.头尾为固定存在的；
*4.中间显示5个页码,再加头尾2个页码总为7；
*5.页面必须要有<input type="hidden" id="totalPage">。
*/
function loadPageAction (currentPage,totalPage) {
    //alert(1);
    var upClass = '';
    var downClass = '';
    var pagesNum = '';
    var firstPage = '';
    var lastPage = '';
    var firstClass;
    var lastClass;
    var headAction = '<span>...</span>';
    var footAction = '<span>...</span>';
    //输入框翻页必要条件
    $('#totalPage').val(totalPage);

    //资讯列表
    var index = $('.infor-list-main .tab-pane.active').attr('index');
    $('input[name="totalPage'+index+'"]').val(totalPage);

    function pageCount(start,end) {
        for (var i = start; i < end; i++) {
          if(i==currentPage){
              pagesNum += '<a role=\"button\" index=\"'+i+'\" class=\"active\">'+i+'</a>';
          }
          else{
              pagesNum += '<a role=\"button\" index=\"'+i+'\">'+i+'</a>';
          }
        }
    }
    //前五页
    if(currentPage<7){
        if(totalPage<7){
            //console.log('前5，总页小于7');
            pageCount(2,totalPage);
        }
        else{
            //console.log('前5，总页大于等于7');
            pageCount(2,7);
        }
    }
    //中间页
    else if(currentPage<totalPage-5&&currentPage>=7){
        //console.log('中');
        pageCount(parseInt(currentPage)-2,parseInt(currentPage)+3);
    }
    //后五页
    else if(currentPage>=totalPage-5){
        //console.log('后5');
        pageCount(parseInt(totalPage)-5,totalPage);
    }

    //控制头尾的显示
    if(currentPage==1){
        upClass = 'nopage';
        firstClass = 'active';
        lastClass = '';
        headAction = '';
        if(totalPage<=7){
            footAction = '';
        }
    }
    else if(currentPage==totalPage){
        downClass = 'nopage';
        firstClass = '';
        lastClass = 'active';
        footAction = '';
        if(totalPage<=7){
            headAction = '';
        }
    }
    else{
        firstClass = '';
        lastClass = '';
        if(currentPage<7){
          headAction = '';
          if(totalPage<=7){
            footAction = '';
          }
        }
        else if(currentPage<totalPage&&currentPage>=totalPage-5){
          footAction = '';
        }
    }

    firstPage = '<a role=\"button\" index=\"1\" class="'+firstClass+'">1</a>'+headAction+'';
    lastPage = ''+footAction+'<a role=\"button\" index=\"'+totalPage+'\" class="'+lastClass+'">'+totalPage+'</a>';
    //只有1页的特殊处理
    if(currentPage==1&&totalPage==1){
        lastPage = '';
        downClass = 'nopage';
    }
    //组装分页
    pageAction = '<a class=\"page-up ' +upClass+'\" role=\"button\">&lt;&nbsp;上一页</a>'+firstPage+pagesNum+lastPage+''+
                            '<a class=\"page-down '+downClass+'\" role=\"button\">下一页&nbsp;&gt;</a>'+
                            '<span style=\"margin-left:50px;\">共'+totalPage+'页</span>'+
                            '<span>到第</span>'+
                            '<input type=\"text\">'+
                            '<span>页</span>'+
                            '<a role=\"button\" class=\"btn\">确定</a>';
    //资讯列表页
    if($('.infor-list-main').hasClass('infor-list-main')){
        $('.list-tab .tab-pane.active>.page-action.white').html(pageAction);
    }
    else{
        $('div>.page-action.white').html(pageAction);
    }
    //以下是创库首页顶部的翻页
    $('li>.page-action .current').text(currentPage);
    $('li>.page-action .total').text(totalPage);
}

/**
*创意设计、共享素材首页，聚惠列表的请求过渡效果
*/
function loadingCC () {
    $('#pinterest').height(0);
    $('#pinterest').children().remove();
    $('.loading').html('<img src=\"/img/loading.gif\">').show();
    $('.noContent').hide();
}

/**
*聚惠团购列表请求的方法
*/
function gatherList () {
    var grid = '';
    loadingCC();
    var param = handleURL.getParam();
    //  {
    //     page: $('#pageID').val(),//默认为1，第一页
    //     brandId: $('#brandID').val(),//默认为0， 全部
    //     categoryId: $('#typeID').val(),//默认为0 ，全部
    //     state: $('#statusID').val()//默认为-1 代表全部,0代表即将开始,1代表正在进行,2代表已结束
    // },
    $.get('/ju/api/lists',param,function(data, textStatus, xhr) {
          if(data.status==0){
              //获取成功
              var res = data.content.commodities;
              var currentPage = data.content.pager.current;
              var totalPage = data.content.pager.count;
              $('.loading').hide();

              //装载翻页
              loadPageAction(currentPage,totalPage);
              if(res.length==0){
                  $('.noContent').show();
                  loadPageAction(1,1);
                  $('#totalPage').val(1);//输入框翻页必要条件
                  return false;
              }

              $('.noContent').hide();
              $.each(res, function(index, val) {
                  var delayHour        = val.delayHour;//距离结束的小时数
                  var state            = val.state;//状态
                  //console.log(state);
                  var statusFont;
                  var statusClass;
                  var disDay;

                  if(state==0){
                      statusFont = '即将开始';
                      statusClass = 'start';
                      disDay = '距离开始';
                  }
                  else if(state==1){
                      statusFont = "立即抢购";
                      statusClass = 'ready';
                      disDay = '距离结束';
                  }
                  else if(state==2){
                      statusFont = "已结束";
                      statusClass = "end";
                      disDay = '结束天数';
                  }
                  else if(val.delayDay==0&&val.delayHour>0){
                      val.delayDay = 1;
                  }

                  if(parseInt(val.delayDay)<0){
                      var a = val.delayDay;
                      var b = a.toString();
                      val.delayDay = b.substring(1,a.length);
                  }

                  //装载瀑布流
                  grid += '<div class="grid '+statusClass+'">'+
                                '<div class="tag">'+statusFont+'</div>'+
                                '<div class="zan"></div>'+
                                '<div class="imgholder">'+
                                '<a href="/commodity/detail/'+val.commodityId+'" title="'+val.name+'" target="_self"><img src="/img/temp-img.png" data-original="'+val.imageId+'" class="lazy"></a>'+
                                '</div>'+
                                '<div class="txtk1">'+
                                '<a href="/commodity/detail/'+val.commodityId+'" target="_self" title="'+val.name+'">'+val.name+'</a>'+
                                '<p class="price">￥'+val.showPrice+'</p>'+
                                '<p class="old-price">￥'+val.sourcePrice+'</p>'+
                                '</div>'+
                                '<div class="txtk2">'+
                                 '<span class="icon1"><span>'+val.follow+'人</span>关注度</span>'+
                                 '<span class="icon2"><span>'+val.saleNumber+'</span>已售出</span>'+
                                 '<span class="icon3"><span>'+val.delayDay+'天</span>'+disDay+'</span>'+
                                '<div class="clear-box"></div>'+
                                '</div>'+
                                '</div>';
              });
              $('.gather-list-main #pinterest').html(grid);
              PINTEREST();
          }
          else{
              $('.loading').hide();
              $('.noContent').html('请求超时，请刷新页面').show().css('padding-left',20);
          }
      });

      //接口出错的设置
      $(document).ajaxError(function(event, xhr, settings, thrownError) {
            if(settings.url.indexOf('/ju/api/lists') >-1) {
                $('.loading').hide();
                $('.noContent').html('请求出错，请联系客服').show().css({'color':'red','padding-left':20});
            }
      });
}

/**
*聚惠预购列表请求的方法
*/
function gatherReadyList () {
    var grid = '';
    //请求的过渡效果
    loadingCC();
    var param = handleURL.getParam();
    //  {
    //     page: $('#pageID').val(),//默认为1，第一页
    //     brandId: $('#brandID').val(),//默认为0， 全部
    //     categoryId: $('#typeID').val(),//默认为0 ，全部
    //     state: $('#statusID').val()//默认为-1 代表全部,0代表即将开始,1代表正在进行,2代表已结束
    // },
    $.get('/ju/ajaxreadylist',param,function(data, textStatus, xhr) {
          if(data.status==0){
              //获取成功
              var res = data.content.commodities;
              var currentPage = data.content.pager.current;
              var totalPage = data.content.pager.total;
              $('.loading').hide();

              //装载翻页
              loadPageAction(currentPage,totalPage);

              if(res.length==0){
                  $('.noContent').show();
                  loadPageAction(1,1);
                  $('#totalPage').val(1);//输入框翻页必要条件
                  return false;
              }

              $('.noContent').hide();
              $.each(res, function(index, val) {
                  var rate             = val.rate;//完成率（返回的是1-100的数字）
                  var delayDay         = val.delayDay;//距离结束的天数
                  var delayHour        = val.delayHour;//距离结束的小时数
                  var state            = val.state;//状态
                  //console.log(state);
                  var statusFont;
                  var statusClass;
                  var orderWidth  = 235*rate/100;
                  var disDay;

                  if(state==0){
                      statusFont = '即将开始';
                      statusClass = 'start';
                      disDay = '距离开始';
                  }
                  else if(state==1){
                      statusFont = "立即抢购";
                      statusClass = 'ready';
                      disDay = '距离结束';
                  }
                  else if(state==2){
                      statusFont = "已结束";
                      statusClass = "end";
                      disDay = '结束天数';
                  }
                  else if(delayDay==0&&delayHour>0){
                        delayDay = 1;
                  }

                  if(parseInt(val.delayDay)<0){
                      var a = val.delayDay;
                      var b = a.toString();
                      val.delayDay = b.substring(1,a.length);
                  }

                  if(val.path==undefined){
                      val.path = '/image/get/' + val.imageId;
                  }

                  //console.log(val);
                  //装载瀑布流
                  grid += '<div class=\"grid '+statusClass+'\">'+
                                '<div class=\"tag\">'+statusFont+'</div>'+
                                '<div class=\"zan\"></div>'+
                                '<div class=\"imgholder\">'+
                                '<a href=\"/commodity/detail/'+val.id+'\" title=\"'+val.name+'\" target=\"_self\"><img src=\"/img/temp-img.png\" data-original=\"'+val.path+'\" class=\"lazy\"></a>'+
                                '</div>'+
                                '<div class=\"txtk1\">'+
                                '<a href=\"/commodity/detail/'+val.id+'\" target=\"_self\" title=\"'+val.name+'\">'+val.name+'</a>'+
                                '<p class=\"price\">￥'+val.showPrice+'</p>'+
                                '<p class=\"old-price\">￥'+val.sourcePrice+'</p>'+
                                '</div>'+
                                '<div class=\"progress-box\">'+
                                '<div class=\"progress-bg\"></div>'+
                                '<div class=\"proing\">'+
                                '<div class=\"going\" style=\"width:'+orderWidth+'px;\"></div><i></i>'+
                                '</div>'+
                                '</div>'+
                                '<div class=\"txtk2\">'+
                                '<span class=\"icon1\"><span>'+rate+'%</span>达成率</span>'+
                                '<span class=\"icon2\"><span>'+val.saleNumber+'</span>已售出</span>'+
                                '<span class=\"icon3\"><span>'+val.delayDay+'</span>'+disDay+'</span>'+
                                '<div class=\"clear-box\"></div>'+
                                '</div>'+
                                '</div>';
              });
              $('.gather-list-main #pinterest').html(grid);
              PINTEREST();
          }
          else{
              $('.loading').hide();
              $('.noContent').html('请求超时，请刷新页面').show().css('padding-left',20);
          }
      });

      //接口出错的设置
      $(document).ajaxError(function(event, xhr, settings, thrownError) {
            if(settings.url.indexOf('/ju/ajaxreadylist') >-1) {
                $('.loading').hide();
                $('.noContent').html('请求出错，请联系客服').show().css({'color':'red','padding-left':20});
            }
      });
}

/**
*创意设计、共享素材数据请求
*/
function innovateList () {
    var grid = '';
    var ajaxUrl;
    var param;//传参

    var productId;//商品ID
    var name;//商品名字
    var imgPath;//商品主图
    var point;//所需积分
    var followCount;//关注人数
    var commentCount;//评论数
    var downloadCount;//下载次数
    var productUrl;

    var isCreative = $('.innovate-main').hasClass('creative');
    var isClip = $('.innovate-main').hasClass('clip');

    loadingCC();

    //判断页面
    if(isCreative){
        ajaxUrl  = '/innovate/creativeSearch';
        //URL传参
    }
    else if(isClip){
        ajaxUrl  = '/innovate/clipSearch';
      //   param = {
      //     page: $('#pageID').val(),//页码默认为1
      //     brandId: $('#brandID').val(),//品牌默认为空
      //     subjectId: $('#themeID').val(),//主题默认为空
      //     integral: $('#pointID').val(),//积分默认为1       1 ： 0-500   2 ：500-1000 3 ：1000-2000   4: 200以上
      //     data: $('#timeID').val(),//时间默认为4              一周内 1；一个月内 2；一年内3；不限 4
      //     sort: $('#rankID').val(),//排序默认为4                关注量 1；评论量 2；  浏览量3；  不限 4
      //     keyword: $('#searchCon').val(),//搜索框
      //     categoryId:$('#sortID').val(),//分类
      //     modelsId:$('#car-typeID').val()//车型
      // };            
    }
    param = handleURL.getParam();

    $.get(ajaxUrl,param,function(data, textStatus, xhr) {
          var res = data.content.lists;
          var totalPage = data.content.totalPage;
          var currentPage =  data.content.currentPage;
          loadPageAction (currentPage,totalPage);
          $('.loading').hide();
          //console.log(data);
          if(data.status==1){
              //获取成功
              $('#totalPage').val(totalPage);

              if(res.length==0){
                  loadPageAction (1,1);
                  $('.noContent').show();
                  $('#totalPage').val(1);
                  return false;
              }

              $('.noContent').hide();
              $.each(res, function(index, val) {
                  //console.log(val);
                  if(isCreative){
                       productId = val.id;//商品ID
                       name            = val.name;//商品名字
                       imgPath            = val.path;//商品主图
                       point        = val.price;//所需积分
                       followCount = val.followCount;//关注人数
                       commentCount = val.commentCount ;//评论数
                       downloadCount = val.uploadCount;//下载次数
                       productUrl = '/commodity/detail/'+productId;
                  }
                  else if(isClip){
                       productId = val.materialId;//商品ID
                       name            = val.materialName;//商品名字
                       imgPath            = val.path;//商品主图
                       point        = val.integral;//所需积分
                       followCount = val.point;//关注人数
                       commentCount = val.commentCount ;//评论数
                       downloadCount = val.uploadCount;//下载次数
                       productUrl = '/innovate/clip-detail/'+productId;
                  }
                  
                  if(val.uploadCount==undefined){
                      downloadCount = 0;
                  }
                  //装载瀑布流
                  grid +=  '<div class=\"grid\">'+
                                  '<div class="imgholder">'+
                                  '<a href="'+productUrl+'" title="'+name+'" target="_self"><img src="/img/temp-img.png" data-original="'+imgPath+'" class="lazy"></a>'+
                                  '</div>'+
                                  '<div class="txtk1">'+
                                  '<a href="'+productUrl+'" target="_self" title="'+name+'">'+name+'</a>'+
                                  '</div>'+
                                  '<div class="txtk2">'+
                                  '<span class="point">'+point+'积分</span>'+
                                  '<span class="icon1">'+followCount+'</span>'+
                                  '<span class="icon2">'+commentCount+'</span>'+
                                  '<span class="icon3">'+downloadCount+'</span>'+
                                  '</div>'+
                                  '</div>';
              });
              $('.innovate-main #pinterest').html(grid);
              PINTEREST();
          }
          else{
              $('.noContent').html('请求超时，请重新操作').show().css('padding-left',20);
          }
      });

      //接口出错的设置
      $(document).ajaxError(function(event, xhr, settings, thrownError) {
            //创意设计请求接口出错设置
            if(settings.url.indexOf('/innovate/creativeSearch') >-1) {
                $('.loading').hide();
                $('.noContent').html('请求出错，请联系客服').show().css({'color':'red','padding-left':20});
            }
            //共享素材请求接口出错设置
            else if(settings.url.indexOf('/innovate/clipSearch') >-1) {
                $('.loading').hide();
                $('.noContent').html('请求出错，请联系客服').show().css({'color':'red','padding-left':20});
            }
      });

}

/**
*案例ajax
*ajaxType为0，最新和热门案例
*ajaxType为1，分类案例
*exType为各接口参数，因为两个接口的参数都是1-9的数字，故这样操作
*/
function  loadExample(ajaxType,exType) {
      var exampleBox = '';

      //最新和热门案例·
      if(ajaxType==0){
          $('#top-ex'+exType).html('<div class=\"loading show\"><img src=\"/img/loading.gif\"></div>');
          $.get('/innovate/getNewExampleAPI', {type:exType},function(data) {
              if(data.status==1){
                    var res = data.content;
                    //console.log(data)
                    if(res.length==0){
                        //alert($('#ex'+exType));
                        $('#top-ex'+exType).html('<div class=\"noContent show\">没有找到相关的资源</div>');
                        return false;
                    }
                    $.each(res, function(index, val) {
                    //console.log(val);
                    if(val.recommendCount==undefined){
                        val.recommendCount = 0;
                    }
                    exampleBox += '<div class=\"example-box\">'+
                                                    '<a href=\"/innovate/example-detail/'+val.caseProductId+'\" title=\"'+val.caseName+'\" target=\"_self\"><img src=\"/img/temp-img.png\" data-original=\"'+val.path+'\"  class=\"lazy\"></a>'+
                                                    '<span class=\"writer\">'+val.realname+'</span>'+
                                                    '<h2><a href=\"/innovate/example-detail/'+val.caseProductId+'\" title=\"'+val.caseName+'\" target=\"_self\">'+val.caseName+'</a></h2>'+
                                                    '<p>人气 <span class=\"red-font\">'+val.point+'</span>评论<span class=\"red-font\">'+val.commentCount+'</span>推荐<span class="red-font">'+val.recommendCount+'</span></p>'+
                                                    '</div>';
                    });
                    $('#top-ex'+exType).html(exampleBox+'<div class="myclear"></div>');
                    $("img.lazy").lazyload();
              }
              else{
                $('#top-ex'+exType).html('<div class=\"noContent show\">请求超时，请重新操作</div>');
              }
          });
      }

      //分类的案例
      else if(ajaxType==1){
          var keyword;
          $('#ex'+exType).html('<div class=\"loading show\"><img src=\"/img/loading.gif\"></div>');
          keyword = $('.example-list-main input.form-control').val();
          $.get('/innovate/getExampleTypeSerchApi', {type:exType,keyword:keyword},function(data) {
              if(data.status==1){
                    var res = data.content.lists;
                    // console.log(data.content);
                    var currentPage = data.content.currentPage;
                    var totalPage = data.content.totalPage;
                    loadPageAction(currentPage,totalPage);
                    //console.log(res.length);
                    if(res.length==0){
                        //alert($('#ex'+exType));
                        loadPageAction(1,1);
                        $('#ex'+exType).html('<div class=\"noContent show\">没有找到相关的资源</div>');
                        return false;
                    }
                    $.each(res, function(index, val) {
                    if ($('.innovate-main.example').hasClass('innovate-main example')&&index==6) {
                        return false;
                    }
                    if(val.recommendCount==undefined){
                        val.recommendCount = 0;
                    }
                    exampleBox += '<div class=\"example-box\">'+
                    '<a href=\"/innovate/example-detail/'+val.caseProductId+'\" title=\"'+val.caseName+'\" target=\"_self\"><img src=\"/img/temp-img.png\" data-original=\"'+val.path+'\"  class=\"lazy\"></a>'+
                    '<span class=\"writer\">'+val.realname+'</span>'+
                    '<h2><a href=\"/innovate/example-detail/'+val.caseProductId+'\" title=\"'+val.caseName+'\" target=\"_self\">'+val.caseName+'</a></h2>'+
                    '<p>人气 <span class=\"red-font\">'+val.point+'</span>评论<span class=\"red-font\">'+val.commentCount+'</span>推荐<span class="red-font">'+val.recommendCount+'</span></p>'+
                    '</div>';
                  });
                  $('#ex'+exType).html(exampleBox+'<div class="myclear"></div>');
                  $("img.lazy").lazyload();
              }
              else{
                  $('#ex'+exType).html('<div class=\"noContent show\">请求超时，请重新操作</div>');
              }
          });
      }
  }

/**
*交易首页ajax
*/
function loadDealList () {
    $('#linkBody').html('');
    $('.loading').html('<img src=\"/img/loading.gif\">').show();
    $('.noContent').hide();
    var item = '';
    var dealType;
    var param = handleURL.getParam();
    // {
        // page: $('#pageID').val(),//页码
        // type: $('#typeID').val(),//交易类型
        // car: $('#car-typeID').val(),//车型
        // brandId: $('#brandID').val(),//品牌
        // province: $('#proID').val(),//省
        // city: $('#cityID').val(),//市
        // status: $('#statusID').val(),//交易是否结束
        // sort: $('#rankID').val(),//排序
        // keyword: $('.deal-search input').val(),//关键字
        // time: $('#timeID').val(),//发布时间
        // sub: $('#subtypeID').val()//以成色还是时间进行排序
    //}
    $.ajax({
      url: '/deal/api/lists',
      type: 'get',
      data: param
    })
    .done(function(data) {
      if(data.status==0){
            $('.loading').hide();
            var res = data.content.commodities;
            var totalPage = data.content.pager.count;
            var currentPage = data.content.pager.current;
            loadPageAction(currentPage,totalPage);
            //console.log(res);
            if(res.length==0){
                loadPageAction(1,1);
                $('.noContent').show();
                return false;
            }
            $.each(res, function(index, val) {
                if(val.type==0){
                    dealType = '求购';
                }
                else if(val.type==1){
                    dealType = '出售';
                }
                item += '<div class=\"link-con clear\">'+
                                '<span class=\"start-date\">发布时间：'+val.create+'</span>'+
                                '<a href=\"/deal/detail/'+val.id+'\" target=\"_self\" class=\"deal-link\" role=\"button\">'+
                                    '<span class=\"deal-info\"><table><tr><td valign=\"middle\">'+val.title+'</td></tr></table></span>'+
                                    '<span>￥'+val.price+'</span>'+
                                    '<span>'+val.num+'</span>'+
                                    '<span>'+val.brand+'</span>'+
                                    '<span>'+dealType+'</span>'+
                                    '<span>'+val.company+'</span>'+
                                    '<span>'+val.city+'</span>'+
                                    '<span>'+val.quality+'</span>'+
                                    '<span class=\"com-date\">'+val.last+'</span>'+
                                '</a>'+
                                '<div class=\"myclear\"></div>'+
                              '</div>';
            });
            $('#linkBody').html(item);
      }
      else{
          $('.loading').hide();
          $('.noContent').html('请求超时，请重新操作或者刷新页面').show().css('padding-left',20);
      }
    })
    .fail(function(data) {
        $('.loading').hide();
        $('.noContent').html('请求出错，请联系客服').show().css({'color':'red','padding-left':20});
    });

}

/**
*资讯列表请求
*/
function loadMessage() {
    $('.list-tab .tab-pane.active>.meg').remove();
    $('.list-tab .tab-pane.active>.page-action').children().remove();
    $('.loading').html('<img src="/img/loading.gif">').show();
    var index = $('.list-tab .tab-pane.active').attr('index');
    var message = '';
    var page;
    var currentPage;
    var keyword;
    var typeId = $('#typeID').val();
    var url = location.href;
    var b = url.indexOf('keyword');
    page = $('input[name="pageID'+index+'"]').val();
    //console.log('page:'+page);
    //搜索
    if(b>-1){
        keyword = url.substring(b+8,url.length);
        var goKeyword = decodeURI(keyword);
        $('.infor-list-main .breadcrumb .current').text('搜索：'+goKeyword);
        $('.infor-list-main .nav.nav-tabs').html('<li style="padding-left:10px;font-size:16px;">搜索结果：</li>');
        $('.list-tab .tab-content>.tab-pane[index="4"]').addClass('active');
        typeId = '';
    }
    $.ajax({
      url: '/infolistapi',
      type: 'POST',
      dataType: 'json',
      data:
      {
          typeId: typeId,
          page: page,
          pageCount: 10,
          keyword: keyword
      },
    })
    .done(function(res) {
        $('.loading').hide();
        var newIndex = $('.list-tab .tab-pane.active').attr('index');
        //console.log('newIndex:'+newIndex);
        //console.log('pageID:'+$('input[name="pageID'+newIndex+'"]').val());
        loadPageAction($('input[name="pageID'+newIndex+'"]').val(),res.url.totalPage);

        if(res.url.lists.length==0){
            $('.noContent').show();
            $('.list-tab .tab-content>.tab-pane>.page-action').hide();
        }

        $.each(res.url.lists, function(index, val) {
            message += '<div class="meg">'+
                        '<a class="meg-img" href="/infor/detail/'+val.infoId+'"><img src="'+val.image+'"></a>'+
                        '<h1><a href="/infor/detail/'+val.infoId+'" target="_self">'+val.infoTitle+'</a></h1>'+
                        '<p><a href="/infor/detail/'+val.infoId+'" target="_self">'+val.summary+'</a></p>'+
                        '<span class="date">'+val.updated+'</span>'+
                        '</div>';
        });
        //资讯列表的分页暂时注释掉
        $('.list-tab .tab-content>.tab-pane.active>.page-action').hide().before(message);
        if(b>-1&&res.url.lists.length!==0){
            $('.list-tab .tab-content>.tab-pane[index="4"]').children('.page-action').show();
        }
        ellipsis(170,$('.infor-list-main .list-tab .tab-content .meg>p>a'));
    })
    .fail(function() {
        $('.loading').hide();
        $('.noContent').html('请求出错，请联系客服').show().css({'color':'red','padding-left':20});
    });

}

/**
*URL传参、取参以及跳转
*例子:http://xxoo.com?name=dada&age=120&height=200
*set('color','red')：为URL添加参数,返回http://xxoo.com?name=dada&age=120&height=200&color=red的字符串
*jump('color','red','href')：返回http://xxoo.com?name=dada&age=120&height=200&color=red直接跳转,href可以为空
*getParam()：获取URL内参数,返回name=dada&age=120&height=200的字符串,便于异步请求数据
*markValue('color')：返回red,如果没有该key,返回undefined
*/
var handleURL = {
    set:function (key,value,href) {
        var URL;
        if(href==undefined){
            href = location.href;
        }
        var index = href.indexOf('?');
        if(index<0){//url没有参数
            URL = href + '?'+key+'='+value;
        }
        else{//url已有参数
            var keyIndex = href.indexOf(key);
            if(keyIndex<0){//url没有该参数
                URL = href +'&'+key+'='+value;
            }
            else if(keyIndex>0){//url有该参数
                var a = href.substring(0,keyIndex);
                var b = href.substring(keyIndex,href.length);
                if(b.indexOf('&')<0){//该参数在最后
                    b = b.substring(0,b.indexOf('=')+1) + value;
                    URL = a + b;
                }
                else{//该参数不在最后
                    var c = b.substring(b.indexOf('&'),b.length);
                    b = b.substring(0,b.indexOf('=')+1) + value;
                    URL = a + b + c;
                }
            }
        }
        return URL;
    },
    getParam:function () {
        var aHref = location.href;
        var param ='';
        var index = aHref.indexOf('?');
        if(index<0){
            param = null;
        }
        else{
          param = aHref.substr(index+1,aHref.length);
        }
        return param;
    },
    markValue:function (key) {
        var aHref = location.href;
        var index = aHref.indexOf(key);
        if(index<0){
            return undefined;
        }
        else{
            var a = aHref.substring(index,aHref.length);
            var aindex = a.indexOf('&');
            if(aindex<0){
                var b = a.substring(key.length+1,a.length);
            }
            else{
                var b = a.substring(key.length+1,aindex);
            }
        }
        return b;
    },
    jump:function (key,value,href) {
        var newURL;
        if(href==undefined){
            href = location.href;
        }
        if(key=='page'){
            newURL = handleURL.set(key,value,href);
        }
        else{
            var url = handleURL.set('page',1,href);
            newURL = handleURL.set(key,value,url);
        }
        location.href  = newURL;
    }
};

/**
*获取URL参数，返回对应文字并装填进样式~~~
*/
function chosedStatus() {
  var param = handleURL.getParam();
  var brandVal = handleURL.markValue('brandId');
  var subjectVal = handleURL.markValue('subjectId');
  var pointVal = handleURL.markValue('integral');
  var sortVal = handleURL.markValue('sort');
  var dateVal = handleURL.markValue('data');
  var carVal = handleURL.markValue('modelsId')||handleURL.markValue('car');
  var typeVal = handleURL.markValue('type');
  var statusVal = handleURL.markValue('status');
  var cityVal = handleURL.markValue('city');
  var fenleiVal = handleURL.markValue('categoryId');
  if(param==null){
    return false;
  }
  else{
    if(brandVal!==undefined&&brandVal!==''){
      var brandName;
      $.each(brandData, function(index, val) {
          if(val.brandId == brandVal){
              brandName = val.brandName;
              return false;
          }
      });
      chosedVal('brand',brandName);
    }
    if(subjectVal!==undefined&&subjectVal!==''){
      $.get('/innovate/getSubjectKeyWordApi/'+subjectVal, function(data) {
          data.content.parent ==null ? chosedVal('theme',data.content.child.name) : chosedVal('theme',data.content.parent.name+'>'+data.content.child.name);
      });
    }
    if(fenleiVal!==undefined&&fenleiVal!==''){
      $.get('/innovate/getMaterialCategoryKeywordApi/'+fenleiVal, function(data) {
          data.content.parent ==null ? chosedVal('fenlei',data.content.child.name) : chosedVal('fenlei',data.content.parent.name+'>'+data.content.child.name);
      });
    }
    if(pointVal!==undefined&&pointVal!==''){
        if(pointVal==1){
          chosedVal('point','0 - 500');
        }
        else if(pointVal==2){
          chosedVal('point','500 - 1000');
        }
        else if(pointVal==3){
          chosedVal('point','1000 - 2000');
        }
        else if(pointVal==4){
          chosedVal('point','2000 以上');
        }
    }
    if(sortVal!==undefined&&sortVal!==''){
        if(sortVal==1){
          chosedVal('rank','浏览量');
        }
        else if(sortVal==2){
          chosedVal('rank','评论量');
        }
        else if(sortVal==3){
          chosedVal('rank','卖出量');
        }
        else if(sortVal==4){
          chosedVal('rank','不限');
        }
    }
    if(dateVal!==undefined&&dateVal!==''){
        if(dateVal==1){
          chosedVal('time','一周内');
        }
        else if(dateVal==2){
          chosedVal('time','一个月内');
        }
        else if(dateVal==3){
          chosedVal('time','一年内');
        }
        else if(dateVal==4){
          chosedVal('time','不限');
        }
    }
    if(carVal!==undefined&&carVal!==''){
        var car = window.car;
        if(isDeal){
          chosedVal('car-type',decodeURI(carVal));
        }
        else{
          chosedVal('car-type',car[carVal].name);
        }
    }
    if(typeVal!==undefined&&typeVal!==''){
        if(typeVal==-1){
          chosedVal('type','不限');
        }
        else if(typeVal==1){
          chosedVal('type','出售');
        }
        else if(typeVal==0){
          chosedVal('type','求购');
        }
    }
    if(statusVal!==undefined&&statusVal!==''){
        if(statusVal==-1){
          chosedVal('status','不限');
        }
        else if(statusVal==0){
          chosedVal('status','进行中');
        }
        else if(statusVal==1){
          chosedVal('status','已结束');
        }
    }
    if(cityVal!==undefined&&cityVal!==''){
        var pro = $('.chosed-box.deal span.part').text();
        $.each(window.city, function(index, val) {
            if(val.id == cityVal){
                chosedVal('part',pro+val.name);
            }
        });
    }
  }
}
//显示已选效果
function chosedVal(key,value) {
    $('.chosed-box').show();
    $('.chosed-box>li>span.'+key+'').text(value).addClass('spanTag').parent('li').css('visibility','visible');
}

//******************页面效果JS********************
/**
*头部2级菜单
*/
HEADERMENUSECOND = function () {
  var disDrop = $('.home-body #homedrop .dropdown-menu').css('display');
  if(disDrop=='block'){//主页
   $('#homedrop').on('mouseleave',function () {
      $(this).children('.dropdown-menu').css('display', 'block');
      $(this).children('#dLabel').addClass('active');
      });
  }
  else{//非主页

     $('#homedrop').on('mouseover',function () {
       $(this).children('.dropdown-menu').show();
       $(this).children('#dLabel').addClass('active');
     });

     $('#homedrop').on('mouseleave',function () {
       $(this).children('.dropdown-menu').hide();
       $(this).children('#dLabel').removeClass('active');
     });
     
  }
};

/**
*头部3级菜单
*/
HEADERMENUTHIRD = function () {
  var menuKey = '';
  var subA;
  var subURL;
  var $dropA = $('.header-bottom .dropdown-menu>li>a');//下拉菜单按钮
  var $subUI = $('.header-bottom .sub-menu>.sub-menu-line');//接收热点关键字容器
  $('.sub-menu .loading').show();

  $.get('/api/menukey', function(data) {
      $('.sub-menu .loading').remove();
      menuKey = data.content;
      for (var i = 0; i < menuKey.length; i++) {//遍历分类
        for (var j = 0; j < menuKey[i].subKey.length; j++) {//遍历子项
          subA = menuKey[i].subKey[j].name;
          //console.log(subA);
          subURL = menuKey[i].subKey[j].url;
          $($subUI[i]).append('<a href= \" '+ subURL  +' \">'+ subA +'</a>');//数据装填
        }
      }
    });

  //添加鼠标经过效果
  $dropA.on('mouseover', function() {
      $subUI.parent().hide();
      $dropA.removeClass('active');
      $(this).addClass('active').siblings('.sub-menu').show();
  });
  //添加鼠标离开效果
  $('.header-bottom .dropdown').on('mouseleave',function() {
      $subUI.parent().hide();
      $dropA.removeClass('active');
  });
};

/**
*下拉框效果
*/
DROPINPUT = function () {
  //下拉框
  var $dropDown = $('.lem-drop>.dropdown');
  var $dropMenuA = $('.lem-drop .dropdown-menu>li>a');
  var isCheckbox = $('.car-type-box').hasClass('car-type-box');
  if(isCheckbox){
      //发布交易有多选框取消鼠标经过效果
  }
  else{
      $dropDown.on('mouseover',function (e) {
          $(this).children('a').addClass('active');
      });
      $dropDown.on('mouseleave',function (e) {
          $(this).children('a').removeClass('active');
      });
  }

  //增加单击事件
  $dropDown.on('click',function (e) {
    var $dropA = $(this).children('a');
    if($dropA.hasClass('active')){
        $(this).children('.dropdown-menu').hide();
        $(this).children('a').removeClass('active');
        }
    else{
        $(this).children('.dropdown-menu').show();
        $(this).children('a').addClass('active');
    }
  });

  //二级菜单选中效果
  $(document).on('click', '.lem-drop .dropdown-menu>li>a', function () {
    if($(this).hasClass('sub-dropdown')){
      return false;
    }else{
      var dropTxt = $(this).text();
      if($(this).parent().hasClass('check-btn')){//多选框

      }
      else{
          $(this).parents('.lem-drop-input').children().children().children('.input-result').text(dropTxt);
      }
    }
  });
};

/**
*bootstrap自定义JS
*/
LOONGJOYBOOTSTRAP = function  () {
  //鼠标经过tab
  $('.mouse-over-tab>li>a').on('mouseover',function (e) {
      if($(this).hasClass('notab')){
        return false;
      }
      else{
         e.preventDefault();
        $(this).tab('show');
        if($("img.lazy").hasClass('lazy')){
          $("img.lazy").lazyload();
        }
      }
  });
  //全站dropdown鼠标经过效果
  var isCheckbox = $('.car-type-box').hasClass('car-type-box');
  if(isCheckbox){
      //关闭交易求购页面的鼠标效果
  }
  else{
      if($(this).attr('id')!=='dLabel'){
          $('.dropdown').on('mouseover', function () {
              $(this).children('.dropdown-menu').slideDown(150);
          });
          $('.dropdown').on('mouseleave', function () {
              $(this).children('.dropdown-menu').slideUp(150);
          });
      }
  }

  //全站carousel加鼠标经过效果
  $('.carousel .carousel-indicators>li').on('mouseover',function () {
      $(this).addClass('active').siblings().removeClass('active');
      var carouselndex = $(this).attr('data-slide-to');
      var $carouseImg = $(this).parent().siblings('.carousel-inner').children('.item');
      $carouseImg.removeClass('active');
      $($carouseImg[carouselndex]).addClass('active');
  });
};

/**
*筛选列表效果
*/
LISTPAGE = function () {
  var tdHeight = $('.chose-con').height();//获取td初始高度
  //更多按钮
  $(document).on('click', '.list-chose td>a.more', function(event) {
    var boxHeight = $(this).siblings('.chose-con').height();
    if(boxHeight===null){
      boxHeight = 36;
    }
    if(boxHeight==tdHeight){
        $(this).addClass('active').siblings('.chose-con').css('height', 'auto');
        $(this).children('span').text('收起');
    }
    else{
        $(this).removeClass('active').siblings('.chose-con').height(tdHeight);
        $(this).children('span').text('更多');
    }
  });

  //默认显示全部品牌
  if($('#brandAll').hasClass('active')){
    $('.chose-con.brand > a').show();
  }

  //选项卡
  $(document).on('mouseover','.list-chose ul.brand-tab>li>a',function (event) {
    $('.brand-tab>li>a').removeClass('active');
    $(this).addClass('active');
    var a = $(this).attr('id');
    if($(this).attr('id')=='brandAll'){
        $('.chose-con.brand > a').show();
    }
    else{
        $('.chose-con.brand > a').hide();
        $('.chose-con.brand > a.'+a).show();
    }
  });

    function reloadPage(){
        //商城列表页
        if($('.store-list-main').hasClass('store-list-main')){
            var page = arguments[0] ? arguments[0] : 1;
            var brandId = $('.chosed.brand span').data('sourceid');
            brandId = brandId ? brandId : 0;
            var categoryId = $('.chosed.kind span').data('sourceid');
            categoryId = categoryId ? categoryId : $('input[name="categoryId"]').val();
            var priceId = $('.chosed.price span').data('sourceid');
            priceId = priceId ? priceId : 0;
            var sort = $('.navbar .nav.nav-pills .active.first').data('value');
            var keyword = $('input[name="ckeyword"]').val();
            location.href = '/store/list?brandId=' + brandId + '&categoryId=' + categoryId + '&priceId=' + priceId + '&sort=' + sort + '&keyword=' + keyword + '&page=' + page;
        }
        else if($('.gather-readylist-main').hasClass('gather-readylist-main')){//预购列表页

        }
        else if($('.gather-list-main').hasClass('gather-list-main')){//团购列表页

        }

    }

  //添加筛选结果
  $(document).on('click','.list-chose table tr td.black-font .chose-con>a',function (event) {
    var chosedTxt = $(this).text();
    var chosedA = '';
      if($(this).parents('.chose-con').hasClass('brand')){
           chosedA = '<a><span data-sourceId="'+$(this).data('brandid')+'">'+chosedTxt+'</span><i></i></a>';
      }
      else if($(this).parents('.chose-con').hasClass('kind')){
           chosedA = '<a><span data-sourceId="'+$(this).data('categoryid')+'">'+chosedTxt+'</span><i></i></a>';
      }
      else if($(this).parents('.chose-con').hasClass('price')){
          chosedA = '<a><span data-sourceId="'+$(this).data('priceid')+'">'+chosedTxt+'</span><i></i></a>';
      }
    //var chosedA = '<a><span>'+chosedTxt+'</span><i></i></a>';
    var $chosedBrandUI = $('ol.breadcrumb>li.chosed.brand');
    var $chosedKindUI = $('ol.breadcrumb>li.chosed.kind');
    var $chosedPriceUI = $('ol.breadcrumb>li.chosed.price');
    function chosestore(txt,UI){
      var $myUI  = UI;
      var myTxt = txt;
      if(myTxt=='不限'){
        $myUI.children().remove();
      }
      else{
        $myUI.children().remove();
        $myUI.append(chosedA);
      }
    }

    if($(this).parents('.chose-con').hasClass('brand')){
      chosestore($(this).text(),$chosedBrandUI);
    }
    if($(this).parents('.chose-con').hasClass('kind')){
      chosestore($(this).text(),$chosedKindUI);
    }
    if($(this).parents('.chose-con').hasClass('price')){
      chosestore($(this).text(),$chosedPriceUI);
    }
    $(this).siblings('.active').removeClass('active');
    $(this).addClass('active');
      reloadPage();
  });

    $(document).on('click', '.navbar .nav.nav-pills li[role="presentation"]', function(){
        $('.navbar .nav.nav-pills li[role="presentation"]').removeClass('active first');
        $(this).addClass('active first');
        reloadPage();

    });

    $(document).on('click', '.redirect.btn', function(){
        var page = $('input[name="pageNum"]').val();
        reloadPage(page);
    });

    $(document).on('click', '.navbar .nav.nav-pills li[role="presentation"]', function(){
        $('.navbar .nav.nav-pills li[role="presentation"]').removeClass('active first');
        $(this).addClass('active first');
        reloadPage();

    });

    $(document).on('click', '.btn.search', function(){
        reloadPage();
    });

//删除筛选结果
  $(document).on('click', 'ol.breadcrumb>li.chosed>a>i', function(event) {
    var $chosedBrandCon = $('.chose-con.brand');
    var $chosedKindCon = $('.chose-con.kind');
    var $chosedPriceCon = $('.chose-con.price');
    function removeChosed (Con) {
      var $chosedCon = Con;
      $chosedCon.children().removeClass('active');
      $chosedCon.children('a.auto').addClass('active');
    }
    if($(this).parents('li.chosed').hasClass('brand')){
      removeChosed($chosedBrandCon);
    }
    if($(this).parents('li.chosed').hasClass('kind')){
      removeChosed($chosedKindCon);
    }
    if($(this).parents('li.chosed').hasClass('price')){
      removeChosed($chosedPriceCon);
    }
    $(this).parent().remove();
    reloadPage();
  });
};

/**
*瀑布流效果
*/
PINTEREST = function(){
  $("img.lazy").lazyload({//图片懒加载
    load:function(){
      $('#pinterest').BlocksIt({
        numOfCol:4, //每行显示图片个数
        offsetX: 8,
        offsetY: 8
      });
      $('#pinterest-clip').BlocksIt({
        numOfCol:4, //每行显示图片个数
        offsetX: 8,
        offsetY: 8
      });
    }
  });
  //使用方法，在页面调用如下JS。
  // @section('header-scripts')
  // <script type="text/javascript" src="/js/jquery.lazyload.min.js"></script>
  // <script type="text/javascript" src="/js/blocksit.min.js"></script>
  // @endsection

  // 然后在指定页面启动效果,示例如下
  // if($('.innovate-main').hasClass('innovate-main')){
  //   PINTEREST();
  // });
};

/**
*品牌车型效果，此效果在loongjoy.select.js内
*/

/**
*关注按钮效果
*'0' => '商城商品关注',
*'1' => '聚惠商品关注',
*'2' => '车友商品关注',
*'3' => '创意设计关注',
*'4' => '共享素材关注',
*'5' => '执行案例关注'
* id为商品id，status为操作类型，0为关注，1为取消关注
*/
ATTENTION = function () {
  $('.att').click(function(event) {
    if(Cookies.get('lAmE_simple_auth')==undefined){
        alertTips('请登录后再操作','/login?reurl='+homeUrl,'登录');
        return false;
    }
    var type;
    if($('body>.store-detail').hasClass('store-detail')){
        type = 0;
    }
    else if($('body>.gather-detail').hasClass('gather-detail')){
        type = 1;
    }
    else if($('body>.riders-detail').hasClass('riders-detail')){
        type = 2;
    }
    else if($('body>.innovate-creative-detail').hasClass('innovate-creative-detail')){
        type = 3;
    }
    else if($('body>.innovate-clip-detail').hasClass('innovate-clip-detail')){
        type = 4;
    }
    else if($('body>.innovate-example-detail').hasClass('innovate-example-detail')){
        type = 5;
    }
    else if($('body>.gather-ready-detail').hasClass('gather-ready-detail')){
        type = 6;
    }
    //console.log(type);
    var cid = $('input[name="cid"]').val();
    if($(this).hasClass('active')){
       follow(type,cid,1);
      $(this).removeClass('active');
    }
    else{
       follow(type,cid,0);
       $(this).addClass('active');
    }
  });
};

/**
*评论
*/
USERCOMMENT = function () {
  //没有评论时进行隐藏
  if($('.comment-box .all-conmment>li').length==0){
      $('.comment-box .all-conmment').hide();
      $('.comment-box h4').hide();
      $('.page-action').hide();
      $('.comment-box').append('<div class="noContent show">暂无评论</div>');
  }

  //隐藏最后一条评论的虚线
  $('.comment-box ul.all-conmment li:last-child').css('border-bottom', '1px #fff solid');

  var auto = '亲，内容是否喜欢？快说点什么吧！';
  $(document).on('focus', '#conmment', function(event) {
      if($('#conmment').val()==auto){
        $('#conmment').text('');
      }
  });

  $(document).on('click', '.comment-box a.btn', function(event) {
    var conmmentText = $('#conmment').val();
    var type = $('input[name="commentType"]').val();
    var cid = $('input[name="cid"]').val();
    if(Cookies.get('lAmE_simple_auth')==undefined){
        alertTips('请登录后再操作','/login?reurl='+homeUrl,'登录');
        return false;
    }
    else if(conmmentText==''||conmmentText==auto){
        littleTips('评论不能为空');
        return false;
    }
    else{
        if(type==undefined||type==''){
            if($('body>.infor-detail').hasClass('infor-detail')){
                type = 0;
            }
            else if($('body>.store-detail').hasClass('store-detail')){
                type = 1;
            }
            else if($('body>.gather-detail').hasClass('gather-detail')){
                type = 2;
            }
            else if($('body>.riders-detail').hasClass('riders-detail')){
                type = 3;
            }
            else if($('body>.innovate-creative-detail').hasClass('innovate-creative-detail')){
                type = 4;
            }
            else if($('body>.innovate-clip-detail').hasClass('innovate-clip-detail')){
                type = 5;
            }
            else if($('body>.innovate-example-detail').hasClass('innovate-example-detail')){
                type = 6;
            }
            else if($('body>.deal-detail').hasClass('deal-detail')){
                type = 7;
            }
            else if($('body>.gather-ready-detail').hasClass('gather-ready-detail')){
                type = 8;
            }
        }
        //console.log(type);
        $.post('/store/sendcomment', {'comment':conmmentText, 'cid':cid,'type':type},function(data) {//接口为真
            if (data.status == 0){
                $('#conmment').val(auto);
                $('#conmment').blur();
                $('#conmment').focus(function(event) {
                    $('#conmment').val('');
                });
                littleTips(data.tips);
            }
        });
    }
  });

  $(document).on('click', '.redirect.btn-info', function(){
      var pagenum = $('input[name="pagenum"]').val(), type= $('input[name="commentType"]').val();
      if (pagenum && pagenum>=1){
          $.get('/store/comment', {'page': pagenum,'type':type, 'commodityId': $('input[name="cid"]').val()}, function (data) {//接口为真
              if (data.status == 0) {
                  $('#conmment-box .page-action').html(data.content.page);
                  if (data.content.comments) {
                      var imageUrl = content.comments[i]["userInfo"]["cover"] && content.comments[i]["userInfo"]["cover"] && content.comments[i]["userInfo"]["cover"] !== null ? '/image/get/' + content.comments[i]["userInfo"]["cover"] : '/img/auto-portrait-one.jpg';
                      var html = '';
                      for(var i=0; i<data.content.comments.length; i++){
                          html += '<li>'+
                          '<div class="img-round"></div>'+
                          '<img src="'+imageUrl+'" alt="">'+
                          '<a>大大</a>'+
                          '<span>发表时间：'+ data.content.comments[i]['createStr']+'</span>'+
                          '<p>'+ data.content.comments[i]['comment']+'</p>'+
                          '</li>';
                      }
                      $('#conmment-box .all-conmment').html(html);
                  } else {
                      littleTips(data.tips);
                  }

              }
          });

      }

  });
};

/**
*产品经理推荐
*/
PMRECONMMENT =function  () {

  if($('.PM-speak').height()<130){
      $('.PM-speak').height(130);
      $('.PM-recon .btn').hide();
      return false;
  }
  else{
      $('.PM-recon .PM-speak').css({'overflow':'hidden','height':'130'});
  }

  $('.PM-recon .btn').click(function(event) {
    if($(this).hasClass('active')){
        $('.PM-recon .PM-speak').css({'overflow':'hidden','height':'130'});
        $(this).removeClass('active');
    }
    else{
        $('.PM-recon .PM-speak').css({'overflow':'visible','height':'auto'});
        $(this).addClass('active');
    }

  });
};

/**
*聚惠团购、预购列表的传值操作
*/
GATHERPUSHVAL = function  () {
     $('.gather-list-main').on('click','#brandBox a[data-brandId],#statusBox>li>a,#typeBox a[data-categoryId],.page-action a',function(event) {
    //品牌
    if($(this).parents('#brandBox').attr('id')=='brandBox'){
        handleURL.jump('brandId',$(this).attr('data-brandId'));
    }
    //种类
    else if($(this).parents('#typeBox').attr('id')=='typeBox'){
        handleURL.jump('categoryId',$(this).attr('data-categoryid'));
    }
    //状态
    else if($(this).parents('#statusBox').attr('id')=='statusBox'){
        handleURL.jump('state',$(this).attr('status-id'));
        //$(this).addClass('active').parent().siblings().children().removeClass('active');
    }
    //翻页
    else if($(this).parents('.page-action').hasClass('page-action')){
      var page = $('.page-action').find('a.active').text();
      var totalPage = $('#totalPage').val();
      //上一页
      if($(this).hasClass('page-up')){
          if(page==1){
              return false;
          }
          else{
              page = parseInt(page) - 1;
          }
      }
      //下一页
      else if($(this).hasClass('page-down')){
            if(page==totalPage){
                  return false;
            }
            else{
                  page = parseInt(page) + 1;
            }
      }
      //翻页的确定按钮
      else if($(this).hasClass('btn')){
          if($(this).siblings('input').val()==''){
                //输入框为空，不给page重新给值
          }
          else{
                page = $(this).siblings('input').val();
          }
      }
      else{
          page = $(this).attr('index');
      }
      handleURL.jump('page',page);
      //console.log(page);
    }
});
};

/**
*全局通用大型loading图
*/
function load(promise) {
    if (!load.$load) load.$load = $('<div class="uc-load">').appendTo('body');
    var $load = load.$load;
    var defer = $.Deferred();
    $load.addClass('show');
    promise
      .done(function (res) {
        defer.resolve(res);
      })
      .fail(function (res) {
        defer.reject(res);
      })
      .always(function () {
        $load.removeClass('show');
      });
    return defer.promise();
  }

/**
*登出清空
*/
function loginOut() {
    alertTips('确定退出吗？','/loginout','确定');
}

/**
*获取reurl
*/
function getReurl() {
    var ahref = location.href;
    var aindex = ahref.indexOf('reurl');
    var reurl = '';
    if(aindex>-1){
      reurl = ahref.substring(aindex+6,ahref.length);
    }else{
      reurl = false;
    }
    return reurl;
}

/**
*用户登录
*/
function loginIn() {
    if($('.login-username').val()==''){
      $('.login-username').next().text('用户名不能为空').css('visibility','visible');
      return false;
    }
    else if($('.login-password').val()==''){
      $('.login-password').next().text('密码不能为空').css('visibility','visible');
      return false;
    }
    else{
        load($.post('/user/login', {username:$('.login-username').val(),password:$('.login-password').val()}))
        .done(function  (res) {
              if (res.status == 0) {
                  //判断用户是否勾选自动登录
                  if($('.autoLogin').prop('checked')==true){
                        Cookies.set('userName',$('.login-username').val(),{ expires: 30 });
                        $.get('/user/api/simplecookie',{type:'ENCODE',value:$('.login-password').val()}, function(data) {
                              Cookies.set('passWord',data.tips,{ expires: 30 });
                        });
                        //认证cookie
                        if(Cookies.get('lAmE_simple_auth')){
                            $.get('/user/api/isauth', function(data) {
                                Cookies.set('isauth',data.status);
                                //console.log(data.status);
                            });
                        }
                  }
                  else if($('.autoLogin').prop('checked')==false){
                        Cookies.remove('userName');
                        Cookies.remove('passWord');
                        $.get('/user/api/isauth', function(data) {
                            Cookies.set('isauth',data.status);
                        });
                  }
                  $('body').html(res.content).hide();
                  //回到上一页
                  if(handleURL.markValue('reurl')==homeUrl){
                      location.href = document.referrer;
                  }
                  //进入主页
                  else if(!getReurl('reurl')){
                      location.href = homeUrl;
                  }
                  //回到url上记录的页面
                  else{
                      location.href = getReurl('reurl');
                  }
              }
              else {
                  $('#ajaxTips').text(res.tips).css('visibility', 'visible');
              }
        })
        .fail(function () {
            littleTips('登录失败，请稍候再试');
        });

    }
}

//*******************************************
//******************公用JS********************
//*******************************************
$(document).ready(function() {
  /**
  *联系我们的兼容性代码
  */
  (function () {
      var browser = navigator.appName;  //判断IE浏览器版本
      var version = navigator.userAgent.split(";");
      //xp中的chrome
      if(version[1]==undefined){
          contactUs ('0px','-153px');
          return false;
      }
      var trimVersion = version[1].replace(/[ ]/g,"");
      var ie = browser=="Microsoft Internet Explorer";
      var ie7 = trimVersion=="MSIE7.0";//IE7下返回true
      var ie8 = trimVersion=="MSIE8.0";//IE8下返回true
      var ie9 = trimVersion=="MSIE9.0";//IE9下返回true
      var ie10 = trimVersion=="MSIE10.0";//IE10下返回true
      var ie11 = "ActiveXObject" in window;//IE11返回true
      if(ie && ie7){//IE7
          //alert(777);
          contactUs ('0px','-153px');
          //交易平台底部下拉框的二级菜单底部那根线~~~~
          $('.deal-main .lem-drop.lem-drop-input .dropdown-menu li:last-child').css('border-bottom','1px solid #dddddd');
      }
      else if(ie && ie8){//IE8
          contactUs ('0px','-153px');
          //alert(888);
      }
      else if(ie && ie9){//IE9
          $('.riders-detail .ready-btn.fixed').css('left','903px');
          contactUs ('0px','-153px');
          //alert(999);
          //
      }
      else if(ie && ie10){//IE10
          $('.contact-us').css('right','-136px');
          contactUs ('17px','-136px');
          //alert(000);
      }
      else if(ie11){//IE11
          $('.contact-us').css('right','-136px');
          contactUs ('17px','-136px');
          $('.riders-detail .ready-btn.fixed').css('left','916px');
      }
      else{//chrome firefox safari opera
          contactUs ('0px','-153px');
          var cc = version[2];
          if(cc==undefined){//chrome  safari opera

          }
          else{
              if(cc.indexOf('Firefox')>-1){//firefox

              }
          }
      }

  })();
  
  /**
  *网站自动登入
  */
  if(Cookies.get('userName')&&Cookies.get('passWord')&&Cookies.get('lAmE_simple_auth')){
      var isLogin = $('.username').hasClass('username');//已登录
      var isMine = $('.minename').hasClass('minename');//个人中心
      //console.log(isLogin);
      if(!isLogin&&!isMine){
          var cookiepass = Cookies.get('passWord');
          var username = Cookies.get('userName');
          $('.front-out').hide();
          $('.front-in').show();
          $('.cookiename>a').text(username);
          //登录密码解密
          $.get('/user/api/simplecookie',{type:'DECODE',value:cookiepass}, function(data) {
              var password = data.tips;
              $.post('/user/login', {username:username,password:password},function (res) {
                  $('body').html(res.content).hide();
                  console.log('重新登录');
                  window.location.reload();
              })
          });
      }
      setTimeout(function() {
        $.get('/user/api/isauth', function(data) {
            Cookies.set('isauth',data.status);
            // console.log('验证认证');
        });
      }, 1000);
  }
  //验证登录，因某些特殊浏览器登录时不保存密码的cookie，故做这样的判断
  else if(Cookies.get('userName')&&Cookies.get('lAmE_simple_auth')){
      setTimeout(function() {
        $.get('/user/api/isauth', function(data) {
            Cookies.set('isauth',data.status);
            //console.log('验证认证');
        });
      }, 1000);
  }

  /**
  *权限限制
  */
  //创库：素材的查看，上传素材，上传案例，案例的查看，案例的管理
  $('.innovate-main').on('click', '.grid,.up-example,.example-box,.manage-example', function(event) {
      if($('.innovate-main').hasClass('creative')){}
      else{
          if(Cookies.get('lAmE_simple_auth')==undefined){
              alertTips('请登录后再操作','/login?reurl='+homeUrl,'登录');
              return false;
          }
      }
  });
  $(document).on('click', '.up-clip', function(event) {
      if(Cookies.get('lAmE_simple_auth')==undefined){
          alertTips('请登录后再操作','/login?reurl='+homeUrl,'登录');
          return false;
      }
      if(Cookies.get('isauth')==1||Cookies.get('isauth')==undefined){
          alertTips('该操作仅限认证用户','/mine/auth','去认证');
          return false;
      }
  });

  //交易平台：发布需求，查看交易
  $('.deal-main').on('click', '.deal-btn,.link-con', function(event) {
      //未登录
      if(Cookies.get('lAmE_simple_auth')==undefined){
          alertTips('请登录后再操作','/login?reurl='+homeUrl,'登录');
          return false;
      }
      //未认证
      if(Cookies.get('isauth')==1||Cookies.get('isauth')==undefined){
          alertTips('该操作仅限认证用户','/mine/auth','去认证');
          return false;
      }
  });

  //顶部我的购物车按钮
  $('a[href="/cart"]').on('click', function(event) {
      if(Cookies.get('lAmE_simple_auth')==undefined){
         window.open('/login?reurl='+homeUrl);
          return false;
      }
  });

  //互动调研登录限制：创库执行案例首页
  $('.survey-box>li').click(function(event) {
      if(Cookies.get('lAmE_simple_auth')==undefined){
          alertTips('请登录后再操作','/login?reurl='+homeUrl,'登录');
          return false;
      }
  });
  //互动调研登录限制：主页
  $('#inspect>a').click(function(event) {
      if(Cookies.get('lAmE_simple_auth')==undefined){
          alertTips('请登录后再操作','/login?reurl='+homeUrl,'登录');
          return false;
      }
  });
  //互动调研登录限制：互动调研列表页
  $('.invest-list-main').on('click', '.list>li>a,.co-box>li>a', function(event) {
      if(Cookies.get('lAmE_simple_auth')==undefined){
          alertTips('请登录后再操作','/login?reurl='+homeUrl,'登录');
          return false;
      }
  });

  /**
  *搜索
  */

  //回车搜索
  (function () {
      var $search = $('.header-search .tab-pane.active');
      $search.find('.form-control').focusin(function() {
          var searchID = $(this).parents('.tab-pane').attr('id');
          document.onkeydown=function(event){
              var e = event || window.event || arguments.callee.caller.arguments[0];
              var val = $('.header-search .tab-pane.active').find('.form-control').val();
               if(e && e.keyCode==13){// enter 键
                    if(searchID=='good'&&val!==''){
                        location.href = '/store/list/?brandId=0&categoryId=0&priceId=0&sort=&page=1&keyword='+val;
                    }
                    else if(searchID=='case'&&val!==''){
                        location.href = '/innovate/example-list?keyword=' + val;
                    }
                    else if(searchID=='message'&&val!==''){
                        location.href = '/infor/list?keyword='+val;
                    }
                    else if(searchID=='community'&&val!==''){
                        window.open("http://www.lemauto.cn/bbs/search.php?mod=forum&searchsubmit=yes&srchtxt=" + val);
                    }
              }
          }; 
      });
  })();

  //点击搜索
  $('.header-search').on('click', '.tab-pane .btn', function(event) {
      var val = $(this).parent().siblings('input').val();
      if($(this).parents('.tab-pane').attr('id')=='good'){
          location.href = '/store/list/?keyword='+val;
      }
      else if($(this).parents('.tab-pane').attr('id')=='case'){
          location.href = '/innovate/example-list?keyword=' + val;
      }
      else if($(this).parents('.tab-pane').attr('id')=='message'){
          location.href = '/infor/list?keyword='+val;
      }
  });

//*******************页面通用JS*********************
HEADERMENUSECOND();//二级菜单
HEADERMENUTHIRD();//三级菜单
LOONGJOYBOOTSTRAP();//龙照自定义bootstrap
DROPINPUT();//下拉框效果
ellipsis(35,$('.side-font'));//侧栏图片下面的描述文字

//******************模块单独JS********************

//点击收藏
$('.collect a').click(function(event) {
    littleTips('请使用ctrl+D键收藏本站');
});

//关闭a标签的虚线框
$('body a').focus(function() {
      this.blur();
});

//限制翻页输入框
$(document).on('keyup', '.page-action.white input', function(event) {
    var maxPage;
    if($('.infor-list-main').hasClass('infor-list-main')){
        var index = $(this).parents('.tab-pane.active').attr('index');
        maxPage = parseInt($('input[name="totalPage'+index+'"]').val());
    }
    else{
        maxPage = parseInt($('#totalPage').val());
    }
    var inputVa = $(this).val();
    if(isNaN(inputVa)){
        //console.log(isNaN(inputVa));
        $(this).val(maxPage);
    }
    else if(inputVa>maxPage){
        $(this).val(maxPage);
    }
    else if(inputVa==0){
        $(this).val('');
    }
});

//聚惠禁止购买
$(document).on('click', '.gather-detail a.detail-btn.buy.disabled', function(event) {
    return false;
});

//******************各页面单独JS********************
if($('body>.login-main').hasClass('login-main')){//登录页

  //当有用户的登录cookie时，自动输入用户名和密码
  if(Cookies.get('userName')&&Cookies.get('passWord')){
      var username = Cookies.get('userName');
      var password = Cookies.get('passWord');
      $('.login-username').val(username);
      //登录密码解密
      $.get('/user/api/simplecookie',{type:'DECODE',value:password}, function(data) {
          $('.login-password').val(data.tips);
      });
  }
  //点击登录
  $('.login-box .detail-btn').click(function(event) {
      loginIn();
  });
  //回车登录
  document.onkeydown=function(event){
      var e = event || window.event || arguments.callee.caller.arguments[0];
      if(e && e.keyCode==13){// enter 键
          loginIn();
      }
  }
  //点击输入框
  $(document).on('click', '.login-username,.login-password', function(event) {
  	$(this).next().css('visibility','hidden');
  });
}

//注册验证在reg.js

else if($('body>.home-main').hasClass('home-main')){//主页
    $('.home-main .carousel .carousel-caption h3 a').addClass('txt');//首页左侧幻灯片文字加限定字数样式
    ellipsis(28,$('#carousel-main-fl4 .carousel-caption h3 a'));
    $('#menu1').parent().addClass('active');
    $('#homedrop').children('a#dLabel').addClass('active');
    $('#homedrop').children('ul.dropdown-menu').show();
    // $('.index-main').parents('body').css('background','#f5f5f5').addClass('home-body');//原样式

    $('.index-main').parents('body').addClass('home-bg');

    $('.dropdown').on('mouseleave', function () {
        $(this).children('.dropdown-menu').show();
        $('#homedrop').children('a#dLabel').addClass('active');
    });

    $('#dLabel').click(function(event) {
        if($(this).hasClass('active')){
            return false;
        }
    });

    $("img.lazy").lazyload();
    $('.fl3-box').next().next().addClass('mtop6');
}

//商城首页
else if($('body>.store-main').hasClass('store-main')){
  $('#menu2').parent().addClass('active');
  ellipsis(27,$('.store-main .store-left .small-adv h5 a'));//小广告的文字描述
  $("img.lazy").lazyload();
}

//商城列表首页
else if($('.store-list-main').hasClass('store-list-main')){
  $('#menu2').parent().addClass('active');
  ellipsis(28,$('.store-list-right .dis-result .small-adv h5 a'));
  LISTPAGE();//列表筛选效果
  $("img.lazy").lazyload();
  //没有数据
  if($('.store-list-main .dis-result>.small-adv').length==0){
      $('.noContent').addClass('show');
  }

  //回车搜索
  $('.navbar-form .form-control').focusin(function() {
      document.onkeydown=function(event){
           var e = event || window.event || arguments.callee.caller.arguments[0];
           if(e && e.keyCode==13){// enter 键
                var brandId = $('.chosed.brand span').data('sourceid');
                brandId = brandId ? brandId : 0;
                var categoryId = $('.chosed.kind span').data('sourceid');
                categoryId = categoryId ? categoryId : $('input[name="categoryId"]').val();
                var priceId = $('.chosed.price span').data('sourceid');
                priceId = priceId ? priceId : 0;
                var sort = $('.navbar .nav.nav-pills .active.first').data('value');
                var keyword = $('input[name="ckeyword"]').val();
                location.href = '/store/list?brandId=' + brandId + '&categoryId=' + categoryId + '&priceId=' + priceId + '&sort=' + sort + '&keyword=' + keyword + '&page=1';
           }
      };
  });

}

//商城详情页
else if($('body>.store-detail').hasClass('store-detail')){
  ellipsis(75,$('.detail-box h1'));
  $('#menu2').parent().addClass('active');
  ATTENTION();//关注效果
  USERCOMMENT();//评论
  //DETAILBOX();//详情交互（规格是否选取、点击购买、点击加入购物车）
  $(".jqzoom").jqueryzoom({//放大镜效果
      xzoom: 363, //放大图的宽度(默认是 200)
      yzoom: 363, //放大图的高度(默认是 200)
      offset: 0, //离原图的距离(默认是 10)
      position: "right"//放大图的定位(默认是 "right")
  });
}

//创意设计首页
else if($('body>.innovate-main').hasClass('creative')){
  //搜索框显示搜索关键字
  handleURL.markValue('keyword')==undefined ? $('#searchCon').val('') : $('#searchCon').val(decodeURI(handleURL.markValue('keyword')));
  //清空顶部搜索框文字，不知道怎么来的，去掉再说
  $('.header-search input').val('');
  ellipsis(30,$('.grid .txtk1 a'));
  ellipsis(14,$('.side-bar-innovate ul li.first span'));
  $('#menu3').parent().addClass('active');
  PINTEREST();
  $("img.lazy").lazyload();
  innovateList ();

  //绑定请求，传值在loongjoy.select.js中
  $(document).on('click', '.dropSelect .dropdown-menu>li>a,.dropSelect .dropdown-menu>li>.sub-box>.brand-content>a,.input-group>.go,.chosed-box>li>i', function(event) {
      if($(this).hasClass('go')){
          handleURL.jump('keyword',$('#searchCon').val());
      }
      //innovateList ();
  });

  //翻页请求
  // $(document).on('click', '.page-action a', function(event) {
  //     if($(this).hasClass('btn')){
  //         if($(this).siblings('input').val()==''){
  //             return false;
  //         }
  //     }
  //     else if($(this).hasClass('active')){
  //         return false;
  //     }
  //     //innovateList ();
  // });

  //回车搜索
  $('#searchCon').focusin(function(event) {
      document.onkeydown=function(event){
           var e = event || window.event || arguments.callee.caller.arguments[0];
           if(e && e.keyCode==13){// enter 键
                handleURL.jump('keyword',$('#searchCon').val());
                //innovateList ();
           }
      };
  });

}

//共享素材首页
else if($('body>.innovate-main').hasClass('clip')){
  //搜索框显示搜索关键字
  handleURL.markValue('keyword')==undefined ? $('#searchCon').val('') : $('#searchCon').val(decodeURI(handleURL.markValue('keyword')));
  //清空顶部搜索框文字，不知道怎么来的，去掉再说
  $('.header-search input').val('');

  ellipsis(30,$('.grid .txtk1 a'));
  ellipsis(14,$('.side-bar-innovate ul li.first span'));
  $('#menu3').parent().addClass('active');
  PINTEREST();
  $("img.lazy").lazyload();
  innovateList ();

  //绑定请求，传值在loongjoy.select.js中
  $(document).on('click', '.dropSelect .dropdown-menu>li>a,.dropSelect .dropdown-menu>li>.sub-box>li>a,.dropSelect .dropdown-menu>li>.sub-box>.brand-content>a,.input-group>.go,.chosed-box>li>i', function(event) {
      // $('#pageID').val(1);
      // innovateList ();
      if($(this).hasClass('go')){
          handleURL.jump('keyword',$('#searchCon').val());
      }
  });

  //翻页请求
  $(document).on('click', '.page-action a', function(event) {
      if($(this).hasClass('btn')){
          if($(this).siblings('input').val()==''){
              return false;
          }
      }
      else if($(this).hasClass('active')){
          return false;
      }
      //innovateList ();
  });

  //回车搜索
  $('#searchCon').focusin(function(event) {
      document.onkeydown=function(event){
           var e = event || window.event || arguments.callee.caller.arguments[0];
           if(e && e.keyCode==13){// enter 键
                //innovateList ();
                handleURL.jump('keyword',$('#searchCon').val());
           }
      };
  });

}

//执行案例首页
else if($('body>.innovate-main').hasClass('example')){
  ellipsis(30,$('.grid .txtk1 a'));
  ellipsis(14,$('.side-bar-innovate ul li.first span'));
  $('#menu3').parent().addClass('active');
  $("img.lazy").lazyload();
  loadExample(0,1);
  loadExample(1,1);
  //绑定请求
  $('.nav-tabs.example>li>a').mouseover(function(event) {
      loadExample(0,$(this).attr('data-id'));
  });
  //绑定请求
  $('.nav-tabs.more-example>li>a').mouseover(function(event) {
      loadExample(1,$(this).attr('data-id'));
  });
  //互动调研最后一个去掉底线
  $('.survey-box li:last-child').css('border-bottom', '0');

  //点击搜索
  $('.innovate-main.example').on('click', '.input-group-btn .btn', function(event) {
        var val = $(this).parent().siblings('input').val();
        location.href = '/innovate/example-list?keyword='+val;
  });
  //回车搜索
  $('.page-left .form-control').focusin(function(event) {
      document.onkeydown=function(event){
           var e = event || window.event || arguments.callee.caller.arguments[0];
           if(e && e.keyCode==13){// enter 键
                location.href = '/innovate/example-list?keyword='+$('.page-left .form-control').val();
           }
      };
  });

}

//创意设计详情页
else if ($('body>.innovate-creative-detail').hasClass('innovate-creative-detail')) {
  $('#menu3').parent().addClass('active');
  ellipsis(75,$('.detail-box h1'));
  ATTENTION();//关注效果
  USERCOMMENT();//评论
  //DETAILBOX();//详情交互（规格是否选取、点击购买、点击加入购物车）
  $(".jqzoom").jqueryzoom({//放大镜效果
      xzoom: 363, //放大图的宽度(默认是 200)
      yzoom: 363, //放大图的高度(默认是 200)
      offset: 0, //离原图的距离(默认是 10)
      position: "right"//放大图的定位(默认是 "right")
  });
}

//共享素材详情页
else if ($('body>.innovate-clip-detail').hasClass('innovate-clip-detail')) {
  $('#menu3').parent().addClass('active');
  ellipsis(75,$('.detail-box h1'));
  ellipsis(14,$('.side-bar-innovate ul li.first span'));
  ATTENTION();//关注效果
  USERCOMMENT();//评论
}

//上传素材
else if ($('body>.add-clip').hasClass('add-clip')) {
    $('#menu3').parent().addClass('active');
    //此功能在loongjoy.upload.js
}

//执行案例列表页
else if ($('body>.example-list-main').hasClass('example-list-main')) {
  $('#menu3').parent().addClass('active');
  $("img.lazy").lazyload();
  loadExample(1,1);
    //绑定请求
  $('.nav-tabs.more-example>li>a').mouseover(function(event) {
      $('#pageID').val(1);
      loadExample(1,$(this).attr('data-id'));
  });
  $('.nav-tabs.more-example .input-group div.btn').click(function(event) {
      $('#pageID').val(1);
      loadExample(1,$('.nav-tabs.more-example').find('li.active').children().attr('data-id'));
  });

  //翻页请求
  $(document).on('click', '.page-action a', function(event) {
      if($(this).hasClass('btn')){
          if($(this).siblings('input').val()==''){
              return false;
          }
      }
      else if($(this).hasClass('active')){
          return false;
      }
      loadExample(1,$('.nav-tabs.more-example').find('li.active').children().attr('data-id'));
  });

  //回车搜索
  $('.example-list-main .form-control').focusin(function(event) {
      document.onkeydown=function(event){
           var e = event || window.event || arguments.callee.caller.arguments[0];
           if(e && e.keyCode==13){// enter 键
                loadExample(1,$('.nav-tabs.more-example').find('li.active').children().attr('data-id'));
           }
      };
  });

}

//上传案例
else if ($('body>.add-example').hasClass('add-example')) {
  $('#menu3').parent().addClass('active');
      //此功能在loongjoy.upload.js
}

//执行案例详情页
else if ($('body>.innovate-example-detail').hasClass('innovate-example-detail')) {
  $('#menu3').parent().addClass('active');
  ellipsis(75,$('.detail-box h1'));
  USERCOMMENT();//评论
}

//互动调研列表页
else if ($('body>.invest-list-main').hasClass('invest-list-main')) {
  $('#menu3').parent().addClass('active');
}

//互动调研详情页
else if ($('body>.invest-detail').hasClass('invest-detail')) {
  $('#menu3').parent().addClass('active');
  //单选
  $(document).on('click', '.QA-box.radio-box li', function(event) {
    $(this).addClass('active').children('input').prop("checked", true);
    $(this).siblings('li').removeClass('active').children('input').removeAttr("checked");
  });
  //多选
  $(document).on('click', '.QA-box.mt li', function(event) {
    if($(this).hasClass('active')){
      $(this).removeClass('active').children('input').removeAttr("checked");
    }
    else{
      $(this).addClass('active').children('input').prop("checked", true);
    }
  });

}

//车友汇首页
else if($('body>.riders-main').hasClass('riders-main')){
  $('#menu4').parent().addClass('active');
  ellipsis(34,$('.riders-main .big-adv .word-bg h3>a'));//大广告
  ellipsis(40,$('.riders-main .small-adv h5 a'));//小广告
  $("img.lazy").lazyload();
}

//车友汇列表页
else if($('body>.riders-list-main').hasClass('riders-list-main')){
  $('#menu4').parent().addClass('active');
  ellipsis(40,$('.riders-list-main ul.riders-list-con dl dt'));//标题
}

//车友汇详情页
else if($('body>.riders-detail').hasClass('riders-detail')){
  //延展套餐是否存在
  var isExbox = $('.extension-box ul>li').length!==0;
  var goHeight;
  if(!isExbox){
      goHeight = 790;
  }
  else if(isExbox){
      goHeight = 1062;
  }

  $('#menu4').parent().addClass('active');
  ellipsis(70,$('.detail-box h1'));
  USERCOMMENT();//评论
  ATTENTION();//关注效果
  PMRECONMMENT();//产品经理推荐
  $(".jqzoom").jqueryzoom({//放大镜效果
      xzoom: 492, //放大图的宽度(默认是 200)
      yzoom: 363, //放大图的高度(默认是 200)
      offset: 0, //离原图的距离(默认是 10)
      position: "right"//放大图的定位(默认是 "right")
  });

  $('.page-right .nav-tabs').on('click', 'li[role="presentation"]', function(event) {
      if(isExbox){
          $(window).scrollTop(1050);
      }
      else{
          $(window).scrollTop(780);
      }
  });

  $(window).scroll(function(event) {//滚动tab
    var DOMtop = $(this).scrollTop();
    if(DOMtop>goHeight){
        $('.riders-detail .ready-btn,.riders-detail .ab').addClass('fixed');
        var browser = navigator.appName;  //判断IE浏览器版本
        var version = navigator.userAgent.split(";");
        //xp中的chrome
        if(version[1]==undefined){
            return false;
        }
        var trimVersion = version[1].replace(/[ ]/g,"");
        var ie = browser=="Microsoft Internet Explorer";
        var ie7 = trimVersion=="MSIE7.0";//IE7下返回true
        var ie8 = trimVersion=="MSIE8.0";//IE8下返回true
        var ie9 = trimVersion=="MSIE9.0";//IE9下返回true
        var ie10 = trimVersion=="MSIE10.0";//IE10下返回true
        var ie11 = "ActiveXObject" in window;//IE11返回true
        if(ie && ie7){//IE7
            $('.riders-detail .ab.fixed').css('left', '174px');
            $('.riders-detail .detail-main .page-right .ready-btn.fixed').css('left', '968px');
        }
        else if(ie && ie8){//IE8
            $('.riders-detail .detail-main .page-right .ready-btn.fixed').css('left', '881px');
        }
        else if(ie && ie9){//IE9
            $('.riders-detail .ready-btn.fixed').css('left','903px');
        }
        else if(ie && ie10){//IE10
            $('.riders-detail .ready-btn.fixed').css('left','920px');
        }
        else if(ie11){//IE11
            $('.riders-detail .ready-btn.fixed').css('left','915px');
        }
    }
    else{
        $('.riders-detail .ab,.riders-detail .ready-btn').removeClass('fixed');
    }
  });
}

//资讯首页
else if($('body>.infor-main').hasClass('infor-main')){
  $('#menu6').parent().addClass('active');
}

//资讯列表页
else if($('body>.infor-list-main').hasClass('infor-list-main')){
  $('#menu6').parent().addClass('active');
  ellipsis(170,$('.infor-list-main .list-tab .tab-content .meg>p>a'));
  var a = location.href;
  var b = a.indexOf('/list/');
  var index = a.substring(b+6,b+7);
  $('#typeID').val(index);
  $('.breadcrumb .current').text($('.list-tab .nav-tabs>li[index="'+index+'"]').addClass('active').text());
  $('.list-tab .tab-content>.tab-pane[index="'+index+'"]').addClass('active');
  loadMessage();

  //翻页传值
  $(document).on('click', '.page-action>a', function(event) {
        var index = $(this).parents('.tab-pane.active').attr('index');
      //翻页
        var page = $('input[name="pageID'+index+'"]').val();
        var totalPage = $('input[name="totalPage'+index+'"]').val();
        //上一页
        if($(this).hasClass('page-up')){
            if(page==1){//li中的上一页
                return false;
            }
            else{
                page = parseInt(page) - 1;
            }
        }
        //下一页
        else if($(this).hasClass('page-down')){
              if(page==totalPage){//li中的下一页
                    return false;
              }
              else{
                    page = parseInt(page) + 1;
              }
        }
        //翻页的确定按钮
        else if($(this).hasClass('btn')){
            if($(this).siblings('input').val()==''){
                  //输入框为空，不给page重新给值
            }
            else{
                  page = $(this).siblings('input').val();
            }
        }
        else{
            page = $(this).attr('index');
        }
        $('input[name="pageID'+index+'"]').val(page);
        //console.log(page);
  });

  //选项卡绑定请求
  $('.list-tab .nav-tabs>li>a').click(function(event) {
      if($(this).parent().hasClass('active')) return false;
      $('.breadcrumb .current').text($(this).text());
      $('#typeID').val($(this).parent().attr('index'));
      for (var i = 1; i < 5; i++) {
          $('input[name="pageID'+i+'"]').val(1);
      }
      loadMessage();
  });

    //翻页绑定请求
  $(document).on('click', '.page-action>a', function(event) {
      loadMessage();
  });
}

//资讯详情页
else if($('body>.infor-detail-main').hasClass('infor-detail-main')){
  $('#menu6').parent().addClass('active');
  USERCOMMENT();//评论
}

//交易首页
else if($('body>.deal-main').hasClass('deal-main')){
  //搜索框显示搜索关键字
  handleURL.markValue('keyword')==undefined ? $('#keyword').val('') : $('#keyword').val(decodeURI(handleURL.markValue('keyword')));
  //清空顶部搜索框文字，不知道怎么来的，去掉再说
  $('.header-search input').val('');

  //下面3个下拉框的选项
  if(handleURL.markValue('sub')!==undefined){
      $('ul[classic="subtype"]').siblings('a').children('.input-result').text($('ul[classic="subtype"]').find('a[data-id="'+handleURL.markValue('sub')+'"]').text());
  }
  if(handleURL.markValue('sort')!==undefined){
      $('ul[classic="rank"]').siblings('a').children('.input-result').text($('ul[classic="rank"]').find('a[data-id="'+handleURL.markValue('sort')+'"]').text());
  }
  if(handleURL.markValue('time')!==undefined){
      $('ul[classic="time"]').siblings('a').children('.input-result').text($('ul[classic="time"]').find('a[data-id="'+handleURL.markValue('time')+'"]').text());
  }
  
  $('#menu7').parent().addClass('active');
  ellipsis(30,$('.deal-info td'));

  //交易求购按钮
  $('.deal-btn.sell,.deal-btn.buy').on('click', function(event) {
      if($(this).hasClass('sell')){
          Cookies.set('deal_page', 1);//出售
      }
      else{
          Cookies.set('deal_page', 0);//求购
      }
  });

  loadDealList();

  //绑定请求
  $(document).on('click', '.dropSelect  #deal .dropdown-menu li>a,.chosed-box>li>i,.deal-search i,.dropSelect .dropdown-menu>li>.sub-box>.brand-content>a,.citySelector-list>li>a,.go-btn', function(event) {
        //$('#pageID').val(1);
        //loadDealList();
  });

  $('.deal-search i').click(function(event) {
      handleURL.jump('keyword',$('#keyword').val());
  });

  //翻页请求
  $(document).on('click', '.page-action a', function(event) {
      if($(this).hasClass('btn')){
          if($(this).siblings('input').val()==''){
              return false;
          }
      }
      else if($(this).hasClass('active')){
          return false;
      }
      //loadDealList();
  });

  //热门车型绑定请求
  $(document).on('click', '.hot-cartype>a', function(event) {
        $('.chosed-box').show().find('.brand').removeClass('spanTag').text('').parent().removeAttr('style');
        $('.chosed-box .car-type').text($(this).text()).addClass('spanTag').parent().css('visibility', 'visible');
        handleURL.jump('brandId','',handleURL.set('car',$(this).text()));
  });

  //热门地区绑定请求
  $(document).on('click', '.hot-parts>a', function(event) {
        $('.chosed-box').show();
        $('.chosed-box .part').text($(this).text()).addClass('spanTag').parent().css('visibility', 'visible');
        handleURL.jump('province',0,handleURL.set('city',$(this).attr('data-id')));
  });

  //回车搜索
  $('#keyword').focusin(function(event) {
      document.onkeydown=function(event){
           var e = event || window.event || arguments.callee.caller.arguments[0];
           if(e && e.keyCode==13){// enter 键
                //loadDealList();
                handleURL.jump('keyword',$('#keyword').val());
           }
      };
  });
}

//交易详情
else if($('body>.deal-detail-main').hasClass('deal-detail-main')){
  $('#menu7').parent().addClass('active');
  ellipsis(75,$('.detail-box h1'));
  ATTENTION();//关注效果
  USERCOMMENT();//评论
}

//交易求购
else if($('body>.business-main').hasClass('business-main')){
    $('#menu7').parent().addClass('active');

    //点击品牌展开车型
    $('.dropdown-menu.brand>li').click(function(event) {
        $('.car-type').addClass('active');
        $('.car-type-box').show();
    });

    var pageType = Cookies.get('deal_page');
    if(pageType==0){
        $('.business-main h1').text('求购');
    }
    else{
        $('.business-main h1').text('出售');
    }
    //此功能在loongjoy.upload.js
}

//聚惠首页
else if($('body>.gather-main').hasClass('gather-main')){
  $('#menu5').parent().addClass('active');
  var timeList = $('.item .endTime');
  for (var i = 0; i < timeList.length; i++) {
     var endTime = timeList[i].value;
     //console.log(endTime);
     timeStamp(endTime,timeList[i]);//倒计时算时间的方法
  }
  $("img.lazy").lazyload();
}

//聚惠详情页
else if($('body>.gather-detail').hasClass('gather-detail')){
  $('#menu5').parent().addClass('active');
  var dtimeList = $('.endTime');
  var dendTime = $('.endTime').val();
  timeStamp(dendTime,dtimeList[0]);//倒计时算时间的方法
  ATTENTION();//关注效果
  USERCOMMENT();//评论
  // DETAILBOX();//详情交互
  $(".jqzoom").jqueryzoom({//放大镜效果
      xzoom: 363, //放大图的宽度(默认是 200)
      yzoom: 363, //放大图的高度(默认是 200)
      offset: 0, //离原图的距离(默认是 10)
      position: "right"//放大图的定位(默认是 "right")
  });
}

//聚惠预购详情页
else if($('body>.gather-ready-detail').hasClass('gather-ready-detail')){
  $('#menu5').parent().addClass('active');
  var rtimeList = $('.endTime');
  var rendTime = $('.endTime').val();
  timeStamp(rendTime,rtimeList[0]);//倒计时算时间的方法
  ATTENTION();//关注效果
  USERCOMMENT();//评论
  // DETAILBOX();//详情交互
  $(".jqzoom").jqueryzoom({//放大镜效果
      xzoom: 363, //放大图的宽度(默认是 200)
      yzoom: 363, //放大图的高度(默认是 200)
      offset: 0, //离原图的距离(默认是 10)
      position: "right"//放大图的定位(默认是 "right")
  });
}

//聚惠团购列表
else if($('body>.gather-list-main').hasClass('gather-list-main')){
  $('#menu5').parent().addClass('active');
  LISTPAGE();//列表筛选效果
  $("img.lazy").lazyload();
  PINTEREST();
  gatherList ();//团购列表的ajax
  GATHERPUSHVAL();//为ajax传值
  //绑定请求
  $('.gather-list-main').on('click','#brandBox a[data-brandId],#statusBox>li>a,#typeBox a[data-categoryId],.page-action a',function(event) {
      var isPageAction = $(this).parents('.page-action').hasClass('page-action');
      if(!isPageAction){
          //$('#pageID').val(1);
      }
      else{
          if($(this).hasClass('active')){
              return false;
          }
      }
      // gatherList ();
  });
}

//聚惠预购列表
else if($('body>.gather-readylist-main').hasClass('gather-readylist-main')){
  $('#menu5').parent().addClass('active');
  LISTPAGE();//列表筛选效果
  $("img.lazy").lazyload();
  PINTEREST();
  gatherReadyList ();//预购列表的ajax
  GATHERPUSHVAL();//为ajax传值
  //绑定请求
  $('.gather-list-main').on('click','#brandBox a[data-brandId],#statusBox>li>a,#typeBox a[data-categoryId],.page-action a',function(event) {
      var isPageAction = $(this).parents('.page-action').hasClass('page-action');
      if(!isPageAction){
          $('#pageID').val(1);
      }
      else{
          if($(this).hasClass('active')){
              return false;
          }
      }
      //gatherReadyList ();
  });
}

//DOM ready结束
});



