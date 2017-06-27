@extends('web.main')

@section('body')
<body class="index-body">
    <div class="wrap">
        <div class="index-top">
            <a class="logo" href=""><img src="/img/web/home_icon.png"></a>
            <a class="login" href="/web/login" target="_self">登录</a>
            <a class="reg reg-btn" href="/web/reg" target="_self"  id="index-reg">注册</a>
        </div>
        <div class="index-center">
            <div class="down">
                <a class="ios-down" href="{{config('app.iosDownloadUrl')}}" target="_blank">IOS</a>
                <a class="android-down" href="/apk/androidjj.apk" target="_self">Android</a>
                <img src="/img/web/123.png" />
            </div>
        </div>
        <div class="index-bottom">
            <p>|{{-- <a href="/web/about-us" target="_blank"> --}}<span class="about-us">关于我们</span>{{-- </a> --}}|<span class="records">沪ICP备15054571号-1</span><span class="comp">上海竹动网络科技有限公司</span></p>
            <p>地址：上海市浦东新区商城路800号<span>电话：021-60486486</span><span>邮箱：business@jjing.org</span></p>
        </div>
    </div>
</body>
@endsection
