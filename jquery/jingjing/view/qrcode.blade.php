@extends('web.main')

@section('scripts')
<script type="text/javascript">
    // 获取终端的相关信息
    var Terminal = {
        // 辨别移动终端类型
        platform : function(){
            var u = navigator.userAgent, app = navigator.appVersion;
            return {
                // android终端或者uc浏览器
                android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1,
                // 是否为iPhone或者QQHD浏览器
                iPhone: u.indexOf('iPhone') > -1 ,
                // 是否iPad
                iPad: u.indexOf('iPad') > -1
            };
        }(),
        // 辨别移动终端的语言：zh-cn、en-us、ko-kr、ja-jp...
        //language : (navigator.browserLanguage || navigator.language).toLowerCase()
    }

    // 根据不同的终端，跳转到不同的地址
    var theUrl = 'http://www.jingjing.org';
    if(Terminal.platform.android){
        theUrl = '/apk/androidjj.apk';
    }else if(Terminal.platform.iPhone){
        theUrl = 'http://www.pgyer.com/WKfD';
     }
     //else if(Terminal.platform.iPad){
    //     // 还可以通过language，区分开多国语言版
    //     switch(Terminal.language){
    //         case 'en-us':
    //             theUrl = '你的iPad APP（英文版）对应下载地址：APP Store地址';
    //             break;
    //         case 'ko-kr':
    //             theUrl = '你的iPad APP（韩语版）对应下载地址：APP Store地址';
    //             break;
    //         case 'ja-jp':
    //             theUrl = '你的iPad APP（日文版）对应下载地址：APP Store地址';
    //             break;
    //         default:
    //             theUrl = '你的iPad APP（中文版-默认）对应下载地址：APP Store地址';
    //     }
    // }
    location.href = theUrl;
</script>
@endsection