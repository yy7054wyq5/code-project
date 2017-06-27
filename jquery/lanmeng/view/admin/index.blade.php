@extends('admin.base')
@section('content')
<style type="text/css">
th,td{text-align: center;}
.name{width: 30%;}
</style>
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-table"></i>管理员信息</h4>
        <div class="tools hidden-xs">
            <a href="javascript:;" class="collapse">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="box-body">
        <div id="datatable1_wrapper" class="dataTables_wrapper form-inline" role="grid">
            <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                    <tr>
                        <td>您的IP</td>
                        <td>{{ $userinfo['ip'] }}</td>
                        <td>操作系统</td>
                        <td>{{ $userinfo['sysver'] }}</td>
                    </tr>
                    <tr>
                        <td>浏览器</td>
                        <td>{{ $userinfo['brover'] }}</td>
                        <td>最后登录IP</td>
                        <td>{{ $userinfo['last_ip'] }}</td>
                    </tr>
                    <tr>
                        <td>最后登录时间</td>
                        <td>{{ $userinfo['last_time'] }}</td>
                        <td>登录次数</td>
                        <td>{{ $userinfo['login_num'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-table"></i>服务器信息</h4>
        <div class="tools hidden-xs">
            <a href="javascript:;" class="collapse">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="box-body">
        <div id="datatable1_wrapper" class="dataTables_wrapper form-inline" role="grid">
            <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover dataTable" aria-describedby="datatable1_info">
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                    <tr>
                        <td>服务器地址</td>
                        <td>{{ $sysinfo['sysname'] }}({{ $sysinfo['sysip'] }}) 端口：{{ $sysinfo['port'] }}</td>
                        <td>服务器时间</td>
                        <td>{{ $sysinfo['systime'] }}</td>
                    </tr>
                    <tr>
                        <td>操作系统</td>
                        <td>{{ $sysinfo['sysver'] }}</td>
                        <td>服务器名</td>
                        <td>{{ $sysinfo['sys_name'] }}</td>
                    </tr>
                    <tr>
                        <td>系统文件夹</td>
                        <td>{{ $sysinfo['root'] }}</td>
                        <td>开机运行时长</td>
                        <td>{{ $sysinfo['sys_time'] }}</td>
                    </tr>
                    <tr>
                        <td>Apache版本</td>
                        <td>{{ $sysinfo['software'] }}</td>
                        <td>PHP版本</td>
                        <td>{{ $sysinfo['phpver'] }}</td>
                    </tr>
                    <tr>
                        <td>当前用户</td>
                        <td>{{ $sysinfo['now_user'] }}</td>
                        <td>物理路径</td>
                        <td>{{ $sysinfo['document'] }}</td>
                    </tr>
                    <tr>
                        <td>相对路径</td>
                        <td>{{ $sysinfo['now_doc'] }}</td>
                        <td>CPU数量</td>
                        <td>{{ $sysinfo['cpunum'] }}</td>
                    </tr>
                    <tr>
                        <td>CPU详情</td>
                        <td>{{ $sysinfo['cpuinfo'] }}</td>
                        <td>本页执行时间</td>
                        <td>{{ $sysinfo['consume'] }}毫秒</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop