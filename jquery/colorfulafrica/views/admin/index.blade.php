@extends('admin.adminbase')

@section('title', '首页')
@section('content')
    <div class="result_wrap" style="padding-top: 50px;" >
        <div class="result_title" style="text-align: center"  >
            <h3>欢迎来到<?= Config::get('app.appCnName')?>管理系统</h3>
        </div>
        <table class="table" style="margin-top: 50px;" >
            <thead>
            <tr>
                <td>操作系统</td>
                <td>{{PHP_OS}}</td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>运行环境</td>
                <td>{{$_SERVER['SERVER_SOFTWARE']}}</td>
            </tr>
            <tr>
                <td>版本</td>
                <td>v-1.0</td>
            </tr>
            <tr>
                <td>上传附件限制</td>
                <td><?php echo get_cfg_var ("upload_max_filesize")?get_cfg_var ("upload_max_filesize"):"不允许上传附件"; ?></td>
            </tr>
            <tr>
                <td>北京时间</td>
                <td><?php echo date('Y年m月d日 H时i分s秒')?></td>
            </tr>
            <tr>
                <td>服务器域名/IP</td>
                <td>{{$_SERVER['SERVER_NAME']}} [ {{$_SERVER['SERVER_ADDR']}} ]</td>
            </tr>
            <tr>
                <td>Host</td>
                <td>{{$_SERVER['SERVER_ADDR']}}</td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection