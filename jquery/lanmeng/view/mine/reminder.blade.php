<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<div class="row">
    <div class="col-md-12">
        <div class="box border primary">
            <div class="box-body">
                <div class="form-group">
                    <p class="text-muted small form-control-static">订单编号:<font color="red">{{$ordersn}}</font></p>
                </div>
                <div class="form-group">
                    <p class="text-muted small form-control-static">下单时间:<font color="red">{{date('Y-m-d H:i',$created)}}  </font></p>
                </div>
                <div class="form-group">
                    <p class="text-muted small form-control-static">手机号:<font color="red">@if(isset($mobile) && !empty($mobile)){{$mobile}} @endif</font></p>
                </div>
                <div class="form-group">
                    <p class="text-muted small form-control-static">用户名:<font color="red">@if(isset($username) && !empty($username)){{$username}}@endif</font></p>
                </div>
                <div class="form-group">
                    <p class="text-muted small form-control-static">真实姓名:<font color="red">@if(isset($realname) && !empty($realname)){{$realname}}@endif</font></p>
                </div>
                <div class="form-group">
                    <!--   <p class="text-muted small form-control-static">QQ:<font color="red">@if(isset($qqinfo) && !empty($qqinfo)){{--trim($qqinfo)--}} @endif </font></p> -->
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>