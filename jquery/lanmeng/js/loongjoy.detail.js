$(document).ready(function() {
   /**
  *点击规格展现相应图片的属性准备
  */
  ;(function(){

      //为规格和相册增加index
      $.each($('.size-box>ul>li'), function(index, val) {
          $(this).attr('index', index);
      });
      $.each($('.thumb>ul>li'), function(index, val) {
          $(this).attr('index', index);
      });
      $.each($('.pic>ul>li'), function(index, val) {
          $(this).attr('index', index);
      });
      //为车友汇的规格增加index
      $.each($('.riders-detail .size-box ul.dropdown-menu>li'), function(index, val) {
          $(this).attr('index', index);
      });

  })();

  /**
  *产品没有规格参数时进行隐藏
  */
  if($('.size-box>ul').find('li').length==0){
      if($('.riders-detail').hasClass('riders-detail'));
      else{
          $('.size-box').hide();
      }   
  }

  /**
  *抵用现金，通过后台给的最大可用积分/50进行显示
  */
  function toMoney (cost,maxScore) {
    var re = /([0-9]+\.[0-9]{2})[0-9]*/;
    var dd = maxScore/50;
    var ooxx = dd.toString();
    var bNew = ooxx.replace(re,"$1");

    $('.toMoney').text(bNew+'元');//可抵多少RMB

  }  

/**
*详情页面的计算
*/
(function () {
    var c = $('#cost').text();//当前产品单价字符串
    var isMoney = c.substring(0,1)=='￥';//判断是积分产品还是RMB产品
    var isRiders = $('.riders-detail').hasClass('riders-detail');//车友汇
    var dataScore = $('.giftPoint').attr('data-score');
    var alreadyDown = $('.detail-btn.buy').hasClass('disabled');

    //获取产品库存
    var maxCount = $('.size-box>ul>li:first-child>a').attr('sizecount');
    var maxScore;
    if(isRiders){
        maxScore = $('.size-box ul.dropdown-menu>li:first-child>a').attr('max-score');
    }
    else if(!isRiders){
        maxScore = $('.size-box>ul>li:first-child>a').attr('max-score');
    }
    
    $('#maxCount').text(maxCount);//显示库存

    //获取产品单价
    if(!isMoney){//积分产品
        var cost =  c.substr(-c.length,c.length-2);
        //console.log(c);
        $('#defaultCost').val(cost);
        $('.RMBprice').text('￥'+cost/50);//等价于RMB的价值
    }
    else if(isMoney){//RMB产品
        var costM = c.substr(1,c.length-1);
        $('#defaultCost').val(costM);
        if(dataScore===''){
            $('.giftPoint').text(parseInt(costM));
        }
        else{
            $('.giftPoint').text(parseInt(costM)+parseInt(dataScore));
        }
        toMoney (costM,maxScore);//抵用现金
    }

    //库存为0，禁用按钮
    if(maxCount==0){
        $('.addNum').addClass('stop');
        $('.cutNum').addClass('stop');
        $('#maxCount').text(0);
        $('.detail-btn.buy').addClass('disabled');
        $('.detail-btn.addshop').addClass('disabled');
    }

    //团购详情未开始，禁用按钮
    if($('.gather-detail .buy-box .time>li:first-child').attr('state')==0){
        $('.detail-btn.buy').addClass('disabled');
    }
    
    //计算价格的方法，涉及延展套餐
    function  computerTotal(cost,count) {
        var cc = cost*count;
        var disabled = $('.detail-btn.buy').hasClass('disabled');
        if(count===undefined){
            cc = cost;
        }
        var xxoo =  cc.toString();
        var re = /([0-9]+\.[0-9]{2})[0-9]*/;
        var cNew = xxoo.replace(re,"$1");
        if(disabled){
            cNew = 0;
        }
        //console.log(aNew);
        if(!isMoney){
          if($('#boxPoint').val()===''){//套餐总积分
              $('#totalPoint').text(cNew);
          }
          else{
              $('#totalPoint').text(parseInt(cNew)+parseInt($('#boxPoint').val()));
          }
        }
        else{
          if($('#boxPrice').val()===''){//套餐总价格
              $('#totalPrice').text(cNew);
          }
          else{
              $('#totalPrice').text(parseFloat(cNew)+parseFloat($('#boxPrice').val()));
          }
        }
    }

    //规格选中效果
    $('.detail-box').on('click','a[sizecost]',function(event) {
        if(alreadyDown){
            $('a.detail-btn.buy,a.detail-btn.addshop').addClass('disabled');
        }
        if(!isRiders){
            $('.detail-box .size-box ul li').removeClass('active');
            $(this).parent().addClass('active');
        }

        var cost = $(this).attr('sizecost');//不同规格的不同单价
        var count = parseInt($('#count').val());//用户所选数量
        var oldCost = $(this).attr('oldcost');//不同规格的不同原价
        var sizeCount = parseInt($(this).attr('sizecount'));//不同规格的不同库存
        var maxScore = parseInt($(this).attr('max-score'));//不同规格的不同抵用积分最大值
        //var date = $(this).attr('rider-date');//车友汇不同规格的出发日期
        //console.log(cost);

        //传入当前规格的单价和数量
        $('#defaultCost').val(cost);
        $('#maxCount').text(sizeCount);

        //图片的联动
        var imgIndex = $(this).parent().attr('index');
        $('.thumb>ul>li').removeClass('current');
        $('.thumb>ul>li[index=\"'+imgIndex+'\"]').addClass('current');
        $('#slide-box .pic>ul>li').hide();
        $('#slide-box .pic>ul>li[index=\"'+imgIndex+'\"]').show();

        //展示数据
        //$('.go-date').text(date);
        if(!isMoney){
            $('#cost').text(cost+'积分');//当前积分
            $('.delete-font').text(oldCost+'积分');//原积分
            $('.RMBprice').text('￥'+cost/50);//等价于RMB的价值
        }
        else if(isMoney){
            $('#cost').text('￥'+cost);//当前价格
            $('.delete-font').text('￥'+oldCost);//原价
            // console.log('价值:'+cost);
            // console.log('最大可使用积分:'+maxScore);
            toMoney(cost,maxScore);
            if(dataScore===''){
                $('.giftPoint').text(parseInt(cost));
            }
            else{
                $('.giftPoint').text(parseInt(cost)+parseInt(dataScore));
            }
        }

        //数量的核算
        if(count<sizeCount){//数量未超出库存
            //$('#maxCount').text(sizeCount-count);
            $('.addNum').removeClass('stop');
        }
        else if(count>=sizeCount){//数量超出或者等于库存
            //$('#maxCount').text(0);
            $('.addNum').addClass('stop');
            $('#count').val(sizeCount);
            count = sizeCount;
        }
        if(count==0) $('.cutNum').addClass('stop');
        if(isNaN(count)){//是否为数字结果
            if(isRiders) count = undefined;
            else count = 0;    
        }

        //库存为0，按钮变灰
        if(sizeCount>0){
            //聚惠详情团购时间过期
            if($('ul.time').css('display')=='none');
            else if($('ul.time').css('display')=='block') $('.detail-btn.buy,.detail-btn.addshop').removeClass('disabled');
            $('#maxCount').text(sizeCount);
            $('#count').val(1);
            $('.addNum').removeClass('stop');
            $('.cutNum').removeClass('stop');
            count = 1;
        }
        else if(sizeCount==0){
            $('.detail-btn.buy,.detail-btn.addshop').addClass('disabled');
        }

        //团购未开始
        if($('.gather-detail .buy-box .time>li:first-child').attr('state')==0){
            $('.detail-btn.buy').addClass('disabled');
        }
        computerTotal(cost,count);

    });

    //增加数量
    $('.addNum').click(function(event) {
      var cost = $('#defaultCost').val();
      var count = $('#count').val();
      var maxCount = $('#maxCount').text();//显示的库存量
      //预购无上限
      if($('.gather-ready-detail').hasClass('gather-ready-detail')) {
          $('.cutNum').removeClass('stop');
          count = parseInt(count)+1;
          $('#count').val(count);
          computerTotal(cost,count);
          return false;
      }
      if(count==maxCount){
          $('.addNum').addClass('stop');
          return false;
      }
      else{
          $('.cutNum').removeClass('stop');
          count = parseInt(count)+1;
          $('#count').val(count);
          computerTotal(cost,count);
      }
  });

  //减少数量
  $('.cutNum').click(function(event) {
      var cost =  $('#defaultCost').val();//1个的价值
      var count = $('#count').val();
      if(count==1){
        $('#count').val('1');
        $('.cutNum').addClass('stop');
        return false;
      }
      else{
        $('.addNum').removeClass('stop');
        count = count-1;
        $('#count').val(count);
        computerTotal(cost,count);
      }
  });

  //输入效果
  $('#count').keyup(function(event) {
    var count = $(this).val();
    var cost =  $('#defaultCost').val();//1个的价值
    var maxCount = $('#maxCount').text();
    if(count<0||count===''){
        $(this).val(1);
    }
    //预购无上限
    if($('.gather-ready-detail').hasClass('gather-ready-detail')) {
        computerTotal(cost,count);
        return false;
    }
    else if(parseInt(count)>=parseInt(maxCount)){
        $(this).val(maxCount);
    }
    count = $(this).val();
    computerTotal(cost,count);
  });

})();



/**
*延展套餐效果
*#cost，当前产品所需积分或者金额
*/
;(function () {
    //没有延展套餐时隐藏
    if($('.extension-box ul>li').length==0){
        $('.extension-box').hide();
        return false;
    }
    var c = $('#cost').text();
    var n = $('#count').val();
    var isMoney = c.substring(0,1)=='￥';
    //console.log($('#cost').text());
    if(!isMoney){//当前产品所需为积分
        $('.jf').show();//显示“积分”
        var p = c.substr(-c.length,c.length-2);
        if(n===undefined){//没有数量加减的时候
            $('#totalPoint').text(p);
        }
        else{
            $('#totalPoint').text(parseInt(p)*n);
        }
        
    }
    else{//当前产品所需为钱
        $('.money').show();//显示“￥”
        $('#totalPrice').text(c.substr(1,c.length-1));
    }

    //延展套餐复选框效果
    $(document).on('click','.extension-box div.check',function(){
        var a = $(this).siblings('span.num').text();
        // alert(a);
        var isPoint = a[a.length-1]=='\u5206';//代表获取的是积分
        var isMoney = a.substring(0,1)=='￥';//代表获取的是金额
        //取消选中套餐产品效果
        if($(this).hasClass('active')){
          $(this).removeClass('active');
          if(!isMoney){//取消的为积分产品
              var point = a.substr(-a.length,a.length-2);
              //console.log(point);
              $('#totalPoint').text(parseInt($('#totalPoint').text())-parseInt(point));
              $('#boxPoint').val(parseInt($('#boxPoint').val())-parseInt(point));
              //console.log($('#boxPoint').val());
          }
          else{//取消的为RMB产品
             var price = a.substr(1,a.length-1);
             // console.log(price);
             var totalPrice = parseFloat($('#totalPrice').text())-parseFloat(price);
             var boxPrice = parseFloat($('#boxPrice').val())-parseFloat(price);
             $('#totalPrice').text(parseFloat(totalPrice).toFixed(2));
             $('#boxPrice').val(parseFloat(boxPrice).toFixed(2));
             //console.log($('#boxPrice').val());    
          }
        }
        //选中套餐产品效果
        else{
          $(this).addClass('active');
          //选中积分产品
          if(!isMoney){
              $('.jf').show();
              var pointCost = a.substr(-a.length,a.length-2);
              //alert(pointCost);
              if($('#totalPrice').text()!==''){
                  $('.plus').show();
              }
              if($('#totalPoint').text()===''){//总积分为0
                  $('#totalPoint').text(pointCost);
                  $('#boxPoint').val(pointCost);
                  //console.log($('#boxPoint').val());
              }
              else{
                  $('#totalPoint').text(parseInt($('#totalPoint').text())+parseInt(pointCost));
                  //console.log($('#boxPoint').val());
                  if($('#boxPoint').val()===''){//第一次选中
                      $('#boxPoint').val(pointCost);
                      //console.log($('#boxPoint').val());
                  }
                  else{//第二次选中以及之后
                      $('#boxPoint').val(parseInt($('#boxPoint').val())+parseInt(pointCost));
                      //console.log($('#boxPoint').val());
                  }
              }
          }
          //选中RMB产品
          else{
             $('.money').show();
             var priceR = a.substr(1,a.length-1);
             var newPrice = 0;
             //console.log(priceR);
             if($('#totalPoint').text()!==''){
                  $('.plus').show();
              }
             if($('#totalPrice').text()===''){//总金额为0
                $('#totalPrice').text(priceR);
                $('#boxPrice').val(priceR);
                 //console.log($('#boxPrice').val());
             }
             else{
                newPrice = parseFloat($('#totalPrice').text())+parseFloat(priceR);
                $('#totalPrice').text(newPrice.toFixed(2));//四舍五入
                if($('#boxPrice').val()===''){//第一次选中
                    $('#boxPrice').val(priceR);
                    //console.log($('#boxPrice').val());
                }
                else{//第二次选中以及之后
                    $('#boxPrice').val(parseFloat($('#boxPrice').val())+parseFloat(priceR));
                    console.log($('#boxPrice').val());
                }
             }
          }
        }
    });

  /**
  *图片滚动效果
  */
  var $li = $('.extension-box .pic ul>li');
  if($li.length<5){
      $('.extension-box .prev,.extension-box .next').hide();
      return false;
  }
  var $imgBox = $('.extension-box .pic ul').width($li.width()*$li.length);//设置图片容器的宽度
  //在LI尾部插入当前第一个LI
  $(document).on('click', '.extension-box .next', function(event) {
    var $li = $('.extension-box .pic ul>li');
    $imgBox.animate({left: -$li.width()},function(){
        $imgBox.append($li[0]);
        $imgBox.css('left', 0);
    });
  });
  //在LI头部插入当前最后一个LI
  $(document).on('click', '.extension-box .prev', function(event) {
    var $li = $('.extension-box .pic ul>li');
    $imgBox.animate({right: -$li.width()},function(){
        $imgBox.prepend($li[$li.length-1]);
        $imgBox.css('right', 0);
    });
  });

//套餐JS结束
})();

// 创库立即支付
$('#buy_immediately').click(function(){
     $.post('/innovate/buyImmediately', {id: $(this).attr('data-id')}).success(function (res) {
     if (res.status !== 0) {
        littleTips(res.tips);
     } else {
     }
     });
});

/**
*结束
*/
});

/**
* 点相册缩略图效果
*/
window.onload = function () {
    var $thumbLi = $('.thumb>ul>li');
    var $picLi = $('.pic>ul>li');
    var $prev = $('.prev');
    var $next = $('.next');

    $thumbLi.click(function(event) {
        var index = $(this).attr('index');
        $(this).addClass('current').siblings().removeClass('current');
        $($picLi[index]).show().siblings().hide();
    });

    //移除UEditor的无序列表样式，避免引起页面的错乱。
    setTimeout(function () {
        $('#list').remove();
    },1);
    
    var disabled = $('.detail-btn.buy').hasClass('disabled');
    if(disabled){
        $('#totalPrice').text(0);
    }
    
};


