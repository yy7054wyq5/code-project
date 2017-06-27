@extends('layouts.main')

@section('banner')
@endsection

@section('content')
<style>
  .mcoupon{height:648px;padding-top:358px;text-align:center;background:url(/img/eyhq_bg_ui.png) no-repeat center;font-family:'微软雅黑'}.mcoupon .title{color:#fff;font-size:28px;text-align:left;text-indent:430px;height:80px;overflow:hidden;font-weight:bold}.mcoupon p{font-size:18px;color:#7c0c0c;font-weight:bold}.mcoupon .backBtn,.mcoupon .closeBtn{display:inline-block;width:158px;height:44px;text-indent:100%;white-space:nowrap;overflow:hidden;background:url(/img/eyhq_btn_ui2.png) no-repeat center;margin:20px 15px 0}.mcoupon .backBtn{background-image:url(/img/.png)}

   .code
      {
    background: #61709E;
        color: #fff;
        border: 0;
        width: 80px;
        height: 30px;
        letter-spacing: 3px;
        font-size: 16px;
        padding-left: 2px;
        text-align: center;
      }
      .unchanged
      {
        background: #61709E;
        border: 0;
        width: 80px;
        height: 30px;
        padding-left: 2px;
        text-align: center;
      }
      #input-res{
        height: 30px;
        border-bottom: 1px solid #000;
        width: 30px;
        font-size: 16px;
        text-align: center;
        margin-left: 7px;
        background: #ff6a47;
      }
      .btn{
        background: #ffa191;
        padding: 5px;
        color: #c71414;
        margin-left: 10px;
        border-radius: 3px;
        font-size: 14px;
        cursor: pointer;
        font-weight: 900;
      }
      .back{
        border-radius: 3px;
        padding: 10px 20px;
        background: #999999;
        font-size: 16px;
        color: #c71515;
        font-weight: 900;
        letter-spacing: 1px;
        box-shadow: -2px -2px 1px #faff73;
      }
      .back:hover{
        color: #fff;
      }
</style>
<div class="container">
  <div class="mcoupon">
    <div class="title">{{ $title }}</div>
    <p class="get-coupons">请填写正确的结果：<input type="text" onclick="createCode()" readonly="readonly" id="checkCode" class="unchanged"/><input type="text" id="input-res" /><a class='btn'>立即领取</a></p>
    <input type="hidden" id="couponsid" value="{{ $id }}" />
    <div style="height: 20px;"></div>
    <a role="button" href="/" class="back">返回官网首页</a>
  </div>
</div>
@endsection

@section('footer-scripts')
@parent
<script>
      var code; //在全局 定义验证码
      var code2; //在全局 定义验证码
      function createCode() {
        code = "";
        var checkCode = document.getElementById("checkCode");
        var inputRes = document.getElementById("input-res");
        inputRes.value = "";
        function RndNum(n) {
          var rnd = "";
          for (var i = 0; i < n; i++)
            rnd += Math.floor(Math.random() * 20);
          return rnd;
        }
      
        var num = RndNum(1);
        var num2 = RndNum(1);
      
        code = num + "+" + num2 + "=";
        code2 = parseInt(num) + parseInt(num2)
      
        if (checkCode) {
          checkCode.className = "code";
          checkCode.value = code;
        }
      
      }

     $(document).ready(function () {
      createCode();
       $(".btn").click(function () {
         var inputCode = document.getElementById("input-res").value;
         if (inputCode.length <= 0) {
           littleTips("请输入验证码！");
         }
         else if (inputCode != code2) {
           littleTips("验证码输入错误！");
           createCode(); //刷新验证码
         }
         else {
            load($.ajax({
              url: '/coupons/getcouponsapi',
              type: 'GET',
              data: {sum: inputCode,id:$('#couponsid').val()}
            }))
            .done(function(res) {
                $('.title').text(res.tips);
                if(res.status==1){
                    $('.get-coupons').remove();
                }
                else if(res.status==0){
                    window.location.href = '/mine/coupon';
                }
            })
            .fail(function() {
              console.log("error");
            });
         }
       });

     })
</script>
@endsection

