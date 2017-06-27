@extends('layouts.main')

@section('header-scripts')
    <script type="text/javascript" src="/js/jquery.lazyload.min.js"></script>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">添加平台管理员</h3>
        </div>
        <form name="form1" enctype="multipart/form-data" method="post" action="<?=url('/image/upload')?>">
            <input class="custom-file-input"  type="file" name="file2" id="foo"/>
            <input class="custom-file-input" type="submit" name="Submit" value="添加" />
        </form>
    </div>
    {{phpinfo()}}
@endsection





