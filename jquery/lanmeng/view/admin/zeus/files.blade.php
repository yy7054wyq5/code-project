@extends('admin.base')
@section('content')
<div class="box border primary">
    <div class="box-title">
        <h4><i class="fa fa-bars"></i>文件管理</h4>
        <div class="tools hidden-xs">
            <a href="javascript:;" class="collapse">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="box-body big">
        <form class="form-horizontal" id="form" onsubmit="return false;">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class="form-group">
                <div>
                	@foreach($files as $value)
                	<div style="width: 200px;height: 200px;float: left;">
                		<img src="/img/files.png" />
                		<div>真实文件名：{{ $value['realname'] ? $value['realname'] : '暂无' }}</div>&nbsp;&nbsp;
                		<!-- <div>系统文件名：{{ $value['filename'] }}</div>&nbsp;&nbsp; -->
                		<div>
                			<a href="/files/downloadfiletemp/{{$value['id']}}">下载</a>
                			<a href="/superman/zeus/setcreative/{{$value['id']}}">设置</a>
                		</div>
                	</div>
                	@endforeach
                </div>
            </div>
        </form>
    </div>
</div>
@stop