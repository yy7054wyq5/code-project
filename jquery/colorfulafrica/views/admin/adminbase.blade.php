<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>{{Config::get('app.appCnName')}}  后台管理系统 -@yield('title')</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/AdminLTE.min.css">
    <link rel="stylesheet" href="/css/_all-skins.min.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="/datepicker/css/bootstrap-datepicker3.min.css">
    <link rel="stylesheet" href="/Jcrop/css/jquery.Jcrop.min.css">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/bootstrap.file-input.css">
    <link rel="stylesheet" href="/uploadify/uploadify.css" >

    <link href="/dialog/css/dialog.css" rel="stylesheet"/>
    <link href="/dialog/css/dialog-theme.css" rel="stylesheet" type="text/css">

    <!-- script -->
    <script src="/js/jquery-1.11.2.min.js"></script>
    <script src="/js/jquery.form.js"></script>
    {{--<script src="/js/bootstrap.file-input.js"></script>--}}
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/app.min.js"></script>

    <script src="/My97DatePicker/WdatePicker.js"></script>

    <script src="/ueditor/ueditor.config.js"></script>
    <script src="/ueditor/ueditor.all.min.js"></script>
    <script src="/ueditor/lang/zh-cn/zh-cn.js"></script>
  <!--  <script src="/uploader/SimpleAjaxUploader.min.js"></script>  -->
    <script src="/js/common.js"></script>
    <script src="/uploadify/jquery.uploadify.min.js"></script>

    <script src="/formvalidator/formValidator-4.1.3.min.js" type="text/javascript" charset="UTF-8"></script>
    <script src="/formvalidator/formValidatorRegex.js" type="text/javascript" charset="UTF-8"></script>

    <script src="/dialog/js/dialog.js" type="text/javascript" charset="UTF-8"></script>

    @section('head')
    @show

</head>
<body class="skin-blue">

<div class="wrapper">

    <!-- header -->
    <div class="main-header">
        <!-- logo -->
        <a href="/backstage/index/index" class="logo"><b>{{Config::get('app.appCnName')}}</b> Admin</a>
        <!-- navbar -->
        <nav class="navbar">
            <!-- sidebar toggle btn -->
            <a href="javascript:;" class="sidebar-toggle" data-toggle="offcanvas"></a>
            <!-- right menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- messages menu -->
                    {{--<li class="dropdown messages-menu">--}}
                        {{--<a href="#" class="dropdown-toggle">--}}
                            {{--<i class="fa fa-envelope-o"></i>--}}
                            {{--<span class="label label-success"></span>--}}
                        {{--</a>--}}
                        {{--<ul class="dropdown-menu">--}}
                            {{--<li class="header">您有0条消息</li>--}}
                            {{--<li>--}}
                                {{--<ul class="menu" style="height: 200px;overflow: hidden;">--}}
                                    {{--<li><a href="#">--}}
                                            {{--<h4 class="no-margin">type <small><i class="fa fa-clock-o"></i>5 mins</small></h4>--}}
                                            {{--<p class="no-margin">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis dolorem nulla commodi libero, enim tempore iure exercitationem, deleniti est id repellendus, in doloremque. Inventore eveniet nostrum cumque omnis aliquam ducimus.</p>--}}
                                        {{--</a></li>--}}
                                    {{--<li><a href="#">--}}
                                            {{--<h4 class="no-margin">type <small><i class="fa fa-clock-o"></i>5 mins</small></h4>--}}
                                            {{--<p class="no-margin">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis dolorem nulla commodi libero, enim tempore iure exercitationem, deleniti est id repellendus, in doloremque. Inventore eveniet nostrum cumque omnis aliquam ducimus.</p>--}}
                                        {{--</a></li>--}}
                                    {{--<li><a href="#">--}}
                                            {{--<h4 class="no-margin">type <small><i class="fa fa-clock-o"></i>5 mins</small></h4>--}}
                                            {{--<p class="no-margin">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis dolorem nulla commodi libero, enim tempore iure exercitationem, deleniti est id repellendus, in doloremque. Inventore eveniet nostrum cumque omnis aliquam ducimus.</p>--}}
                                        {{--</a></li>--}}
                                {{--</ul>--}}
                            {{--</li>--}}
                            {{--<li class="footer"><a href="#">查看所有</a></li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                    <!-- usermenu -->
                    <!-- <li style="color: #fff;padding: 15px;">plat<small>(平台管理员)</small></li>
                    <li><a href="#"><i class="fa fa-circle text-danger"></i> 退出</a></li> -->
                    @if(in_array(\Illuminate\Support\Facades\Config::get('app.userlist.resetpwd.id'),$jurisdiction))
                    <li class="dorpdown user user-menu">
                        <a href="/backstage/account/reset-pwd"><i class="fa fa-user"></i>修改密码</a>
                    </li>
                    @endif
                    <li><a href="<?=url('/backstage/index/logout')?>"><i class="fa fa-power-off"></i></a></li>
                </ul>
            </div>
        </nav>
    </div>

    <!-- sidebar -->
    <aside class="main-sidebar">
        <section class="sidebar">
            <!-- sidebar menu -->
            <ul class="sidebar-menu">
            <?php
/*   $menus = Config('app.adminMenu');
$html = '<ul class="sidebar-menu">';
foreach ($menus as $menu) {//1级菜单
$active = Config('app.currentMenu') == $menu['nameEn'] ? 'active' : '';
$li = '';
if (empty($menu['children'])) {
$li .= '<li class="treeview ' . $active . '"><a href="' . url('/admin/index/' . $menu['nameEn']) . '">' . $menu['name'] . '</a></li>';
} else {
$li .= '<li class="treeview ' . $active . '">';
$li .= '<a href="#">' . $menu['name'] . '<i class="fa fa-angle-left pull-right"></i></a>';
$li .= '<ul class="treeview-menu">';
foreach ($menu['children'] as $secondMenu) {//2级菜单
$li .= '<li><a href="' . url($secondMenu['url']) . '">' . $secondMenu['name'] . '</a></li>';
}
$li .= '</ul>';
$li .= '</li>';
}
$html .= $li;
}
echo $html;*/
echo $menus;
?>
            </ul>
        </section>
    </aside>

    <div class="content-wrapper">
        @yield('content')
        <section class="content">
        </section>
    </div>
    <!-- footer -->
    <footer class="main-footer">
        <div class="pull-right"><span class="hidden-xs"></span></div>
        <div><span class="hidden-xs">{{Config::get('app.appCnName')}} 系统管理</span> Powered by 2014 loongJoy Inc.</div>
    </footer>

    <div id="j_confirmDelete" class="modal fade in" data-toggle="modal">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">确认提示</div>
                <div class="modal-body">是否确认删除该条数据</div>
                <div class="modal-footer">
                    <button class="btn btn-default apply">确定</button>
                    <button class="btn btn-primary" data-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
@yield('footer')
<script type="text/javascript" >
    var ue = UE.getEditor('container');
</script>